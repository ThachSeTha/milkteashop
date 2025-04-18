<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GioHang;
use App\Models\SanPham;
use App\Models\Size;
use App\Models\Topping;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class CheckoutController extends Controller
{
    public function index()
    {
        $sessionId = Session::getId();
        $userId = Auth::id();
    
        Log::info('CheckoutController@index - Session ID: ' . $sessionId); // Ghi log session_id
    
        $cartItems = GioHang::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })
        ->with('sanPham')
        ->get();
    
        Log::info('CheckoutController@index - Cart Items: ' . $cartItems->toJson()); // Ghi log dữ liệu giỏ hàng
    
        $total = $cartItems->sum('thanh_tien');
    
        $sizes = Size::all();
        $toppings = Topping::all();
    
        return view('checkout', compact('cartItems', 'total', 'sizes', 'toppings'));
    }
    
    public function addToCart(Request $request, $id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn cần đăng nhập để thực hiện thao tác này!'
                ], 401);
            }
    
            // Tìm sản phẩm theo ID
            $sanPham = SanPham::find($id);
            if (!$sanPham) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại!'
                ], 404);
            }
    
            // Thêm sản phẩm vào bảng GioHang
            $cartItem = GioHang::where('user_id', $user->id)
                ->where('san_pham_id', $id)
                ->where('size_id', $request->size_id ?? null)
                ->where('topping_id', $request->topping_id ?? null)
                ->first();
    
            if ($cartItem) {
                // Nếu sản phẩm đã có, tăng số lượng
                $cartItem->so_luong += 1;
                $cartItem->save();
            } else {
                // Nếu sản phẩm chưa có, thêm mới
                $cartItem = GioHang::create([
                    'user_id' => $user->id,
                    'san_pham_id' => $sanPham->id,
                    'so_luong' => 1,
                    'size_id' => $request->size_id ?? null,
                    'topping_id' => $request->topping_id ?? null,
                    'ghi_chu' => ''
                ]);
            }
    
            // Lấy lại giỏ hàng từ database
            $cartItems = GioHang::where('user_id', $user->id)
                ->with(['sanPham', 'size', 'topping'])
                ->get();
    
            // Chuyển đổi dữ liệu thành định dạng phù hợp
            $cart = $cartItems->map(function ($item) {
                return [
                    'san_pham_id' => $item->san_pham_id,
                    'so_luong' => $item->so_luong,
                    'size_id' => $item->size_id,
                    'topping_id' => $item->topping_id,
                    'name' => $item->sanPham ? $item->sanPham->ten_san_pham : 'Sản phẩm không tồn tại',
                    'price' => $item->sanPham ? $item->sanPham->gia : 0,
                    'hinh_anh' => $item->sanPham ? ($item->sanPham->hinh_anh ?? 'https://via.placeholder.com/300') : 'https://via.placeholder.com/300',
                    'ghi_chu' => $item->ghi_chu ?? ''
                ];
            })->toArray();
    
            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được thêm vào giỏ hàng!',
                'cart' => $cart
            ]);
        } catch (\Exception $e) {
            Log::error('CheckoutController@addToCart - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng!',
                'cart' => []
            ], 500);
        }
    }   
        /**
     * Xử lý đặt hàng
     */
    public function store(Request $request)
    {
        try {
            // Validate dữ liệu đầu vào
            $request->validate([
                'ten_khach_hang' => 'required|string|max:255',
                'so_dien_thoai' => 'required|string|max:15',
                'email' => 'required|email',
                'hinh_thuc_giao_hang' => 'required|in:delivery,pickup',
                'dia_chi' => 'required_if:hinh_thuc_giao_hang,delivery|string',
                'tinh_thanh' => 'required_if:hinh_thuc_giao_hang,delivery|string',
                'quan_huyen' => 'required_if:hinh_thuc_giao_hang,delivery|string',
                'phuong_xa' => 'required_if:hinh_thuc_giao_hang,delivery|string',
                'payment_method' => 'required|in:cod,momo',
            ]);

            $sessionId = Session::getId();
            $userId = Auth::id();

            // Lấy giỏ hàng
            $cartItems = GioHang::where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
                ->with(['sanPham', 'size', 'topping'])
                ->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Giỏ hàng của bạn đang trống!'
                ], 400);
            }

            // Tính tổng tiền
            $total = 0;
            foreach ($cartItems as $item) {
                $giaSanPham = $item->sanPham->gia;
                $giaSize = $item->size ? $item->size->price_multiplier : 0;
                $giaTopping = $item->topping ? $item->topping->price : 0;
                $item->thanh_tien = ($giaSanPham + $giaSize + $giaTopping) * $item->so_luong;
                $total += $item->thanh_tien;
            }

            // Tạo đơn hàng
            $order = Order::create([
                'ten_khach_hang' => $request->input('ten_khach_hang'),
                'so_dien_thoai' => $request->input('so_dien_thoai'),
                'email' => $request->input('email'),
                'hinh_thuc_giao_hang' => $request->input('hinh_thuc_giao_hang'),
                'dia_chi' => $request->input('hinh_thuc_giao_hang') === 'delivery' ? $request->input('dia_chi') : null,
                'tinh_thanh' => $request->input('hinh_thuc_giao_hang') === 'delivery' ? $request->input('tinh_thanh') : null,
                'quan_huyen' => $request->input('hinh_thuc_giao_hang') === 'delivery' ? $request->input('quan_huyen') : null,
                'phuong_xa' => $request->input('hinh_thuc_giao_hang') === 'delivery' ? $request->input('phuong_xa') : null,
                'tong_tien' => $total,
                'trang_thai' => 'pending',
                'payment_method' => $request->input('payment_method'),
            ]);

            // Tạo chi tiết đơn hàng
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'san_pham_id' => $item->san_pham_id,
                    'kich_thuoc' => $item->size ? $item->size->name : null,
                    'topping' => $item->topping ? $item->topping->name : null,
                    'so_luong' => $item->so_luong,
                    'thanh_tien' => $item->thanh_tien,
                    'ghi_chu' => $item->ghi_chu,
                ]);
            }

            // Xóa giỏ hàng trong cơ sở dữ liệu
            GioHang::where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đặt hàng thành công! Chúng tôi sẽ liên hệ với bạn sớm.',
                'order_id' => $order->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi đặt hàng: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function updateCartItem(Request $request, $id)
    {
        try {
            $request->validate([
                'size_id' => 'required|exists:sizes,id',
                'topping_id' => 'nullable|exists:toppings,id',
                'so_luong' => 'required|integer|min:1',
                'ghi_chu' => 'nullable|string',
            ]);

            $sessionId = Session::getId();
            $userId = Auth::id();

            $cartItem = GioHang::where('id', $id) // Sửa từ san_pham_id thành id
                ->where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })
                ->firstOrFail();

            $cartItem->update([
                'size_id' => $request->input('size_id'),
                'topping_id' => $request->input('topping_id'),
                'so_luong' => $request->input('so_luong'),
                'ghi_chu' => $request->input('ghi_chu'),
            ]);

            // Tính lại thành tiền
            $sanPham = SanPham::find($cartItem->san_pham_id);
            $size = Size::find($cartItem->size_id);
            $topping = Topping::find($cartItem->topping_id);
            $giaSanPham = $sanPham->gia;
            $giaSize = $size ? $size->price_multiplier : 0;
            $giaTopping = $topping ? $topping->price : 0;
            $cartItem->thanh_tien = ($giaSanPham + $giaSize + $giaTopping) * $cartItem->so_luong;
            $cartItem->save();

            return response()->json([
                'success' => true,
                'message' => 'Giỏ hàng đã được cập nhật!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật giỏ hàng: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function removeFromCart($id)
    {
        try {
            $sessionId = Session::getId();
            $userId = Auth::id();

            $cartItem = GioHang::where('san_pham_id', $id)
                ->where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })
                ->firstOrFail();

            $cartItem->delete();

            return redirect()->route('checkout')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
        } catch (\Exception $e) {
            return redirect()->route('checkout')->with('error', 'Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng!');
        }
    }
    public function syncCart(Request $request)
    {
        $cartItems = $request->input('cart_items', []);
    
        Log::info('CheckoutController@syncCart - Cart Items Received: ' . json_encode($cartItems));
    
        if (empty($cartItems)) {
            Log::warning('CheckoutController@syncCart - No cart items to sync');
            return response()->json(['success' => false, 'message' => 'Giỏ hàng trống']);
        }
    
        $user = Auth::user();
        $sessionId = Session::getId();
    
        try {
            foreach ($cartItems as $item) {
                // Kiểm tra tồn tại sản phẩm
                $sanPham = SanPham::find($item['san_pham_id']);
                if (!$sanPham) {
                    Log::error('CheckoutController@syncCart - Invalid san_pham_id: ' . $item['san_pham_id']);
                    continue;
                }
    
                $gioHang = GioHang::updateOrCreate(
                    [
                        'user_id' => $user ? $user->id : null,
                        'session_id' => $user ? null : $sessionId,
                        'san_pham_id' => $item['san_pham_id'],
                        'size_id' => null, // Không dùng size_id/topping_id trong localStorage hiện tại
                        'topping_id' => null,
                    ],
                    [
                        'so_luong' => $item['so_luong'] ?? 1,
                        'thanh_tien' => ($item['price'] ?? $sanPham->gia) * ($item['so_luong'] ?? 1),
                        'ghi_chu' => '',
                    ]
                );
    
                Log::info('CheckoutController@syncCart - Synced item: ' . $gioHang->toJson());
            }
    
            return response()->json(['success' => true, 'message' => 'Đồng bộ giỏ hàng thành công']);
        } catch (\Exception $e) {
            Log::error('CheckoutController@syncCart - Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Lỗi khi đồng bộ giỏ hàng: ' . $e->getMessage()]);
        }
    }
    /**
     * Tạo đơn hàng MoMo
     */    
    public function createMoMoOrder(Request $request)
    {
        try {
            // Validate dữ liệu
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'address' => 'required|string',
                'hinh_thuc_giao_hang' => 'required|string|in:pickup,delivery',
            ]);

            // Lấy giỏ hàng
            $sessionId = Session::getId();
            $userId = Auth::id();

            $cartItems = GioHang::where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
                ->with(['sanPham', 'size', 'topping'])
                ->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Giỏ hàng của bạn đang trống!',
                ]);
            }

            // Tính tổng tiền
            $total = 0;
            foreach ($cartItems as $item) {
                $giaSanPham = $item->sanPham->gia;
                $giaSize = $item->size ? $item->size->price_multiplier : 0;
                $giaTopping = $item->topping ? $item->topping->price : 0;
                $giaBan = $giaSanPham + $giaSize + $giaTopping;
                $item->thanh_tien = $giaBan * $item->so_luong;
                $total += $item->thanh_tien;
            }

            // Tạo mã đơn hàng duy nhất
            $maDonHang = 'DH-' . date('Ymd') . '-' . str_pad(DonHang::count() + 1, 4, '0', STR_PAD_LEFT);

            // Tạo đơn hàng tạm thời để lấy ID
            $donHang = DonHang::create([
                'ma_don_hang' => $maDonHang,
                'user_id' => $userId,
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'hinh_thuc_giao_hang' => $validated['hinh_thuc_giao_hang'],
                'payment_method' => 'momo',
                'tong_tien' => $total, // Sửa 'total' thành 'tong_tien'
                'trang_thai' => 'awaiting_payment', // Sửa 'status' thành 'trang_thai'
            ]);

            // Tạo chi tiết đơn hàng
            foreach ($cartItems as $item) {
                $giaSanPham = $item->sanPham->gia;
                $giaSize = $item->size ? $item->size->price_multiplier : 0;
                $giaTopping = $item->topping ? $item->topping->price : 0;
                $giaBan = $giaSanPham + $giaSize + $giaTopping;

                ChiTietDonHang::create([
                    'don_hang_id' => $donHang->id,
                    'san_pham_id' => $item->san_pham_id,
                    'size_id' => $item->size_id,
                    'topping_id' => $item->topping_id,
                    'so_luong' => $item->so_luong,
                    'gia_ban' => $giaBan,
                ]);
            }

            // Chuẩn bị dữ liệu cho API MoMo
            $orderId = "DH{$donHang->id}_" . time();
            $requestId = time() . "";
            $orderInfo = "Thanh toán đơn hàng #{$donHang->id}";
            $amount = $total;
            $redirectUrl = config('momo.return_url');
            $ipnUrl = config('momo.notify_url');
            $extraData = base64_encode(json_encode(['order_id' => $donHang->id]));

            $rawHash = "accessKey=" . config('momo.access_key') .
                    "&amount=" . $amount .
                    "&extraData=" . $extraData .
                    "&ipnUrl=" . $ipnUrl .
                    "&orderId=" . $orderId .
                    "&orderInfo=" . $orderInfo .
                    "&partnerCode=" . config('momo.partner_code') .
                    "&redirectUrl=" . $redirectUrl .
                    "&requestId=" . $requestId .
                    "&requestType=captureWallet";

            $signature = hash_hmac('sha256', $rawHash, config('momo.secret_key'));

            $order = [
                'partnerCode' => config('momo.partner_code'),
                'partnerName' => 'MilkTeaShop',
                'storeId' => 'MilkTeaShop',
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => 'captureWallet',
                'signature' => $signature,
            ];

            // Gọi API MoMo
            $client = new \GuzzleHttp\Client();
            $response = $client->post(config('momo.endpoint'), [
                'json' => $order,
            ]);

            $result = json_decode($response->getBody(), true);

            if ($result['resultCode'] !== 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể tạo đơn hàng MoMo: ' . $result['message'],
                ]);
            }

            // Tạo mã QR từ payUrl
            $qrCodeBase64 = QrCode::format('png')
                ->size(300)
                ->margin(1)
                ->generate($result['payUrl']);

            $qrCodeBase64 = base64_encode($qrCodeBase64);

            return response()->json([
                'success' => true,
                'qr_code' => $qrCodeBase64,
                'order_id' => $donHang->id,
                'order' => [
                    'id' => $donHang->id,
                    'ma_don_hang' => $donHang->ma_don_hang,
                    'name' => $donHang->name,
                    'phone' => $donHang->phone,
                    'address' => $donHang->address,
                    'hinh_thuc_giao_hang' => $donHang->hinh_thuc_giao_hang,
                    'payment_method' => $donHang->payment_method,
                    'tong_tien' => $donHang->tong_tien,
                    'trang_thai' => $donHang->trang_thai,
                    'created_at' => $donHang->created_at->format('Y-m-d H:i:s'),
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ]);
        }
    }
    public function paymentCallback(Request $request)
    {
        $data = $request->all();
        $secretKey = config('momo.secret_key');

        // Kiểm tra chữ ký
        $rawHash = "accessKey=" . config('momo.access_key') .
                "&amount=" . $data['amount'] .
                "&extraData=" . $data['extraData'] .
                "&message=" . $data['message'] .
                "&orderId=" . $data['orderId'] .
                "&orderInfo=" . $data['orderInfo'] .
                "&orderType=" . $data['orderType'] .
                "&partnerCode=" . $data['partnerCode'] .
                "&payType=" . $data['payType'] .
                "&requestId=" . $data['requestId'] .
                "&responseTime=" . $data['responseTime'] .
                "&resultCode=" . $data['resultCode'] .
                "&transId=" . $data['transId'];
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        if ($signature !== $data['signature']) {
            return redirect()->route('home')->with('error', 'Chữ ký không hợp lệ!');
        }

        $extraData = json_decode(base64_decode($data['extraData']), true);
        $donHangId = $extraData['order_id'] ?? null;
        $donHang = DonHang::find($donHangId);

        if (!$donHang) {
            return redirect()->route('home')->with('error', 'Đơn hàng không tồn tại!');
        }

        $userId = Auth::id();
        $sessionId = Session::getId();

        if ($data['resultCode'] == 0) {
            // Thanh toán thành công
            $donHang->update([
                'trang_thai' => 'pending',
            ]);

            // Xóa giỏ hàng trong database
            GioHang::where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->delete();

            return redirect()->route('donhangs.index')->with('success', 'Thanh toán thành công! Đơn hàng của bạn đang được xử lý.');
        } else {
            // Thanh toán thất bại
            $donHang->update([
                'trang_thai' => 'failed',
            ]);
            return redirect()->route('donhangs.index')->with('error', 'Thanh toán thất bại: ' . $data['message']);
        }
    }
    public function placeOrder(Request $request)
    {
        try {
            // Validate dữ liệu đầu vào
            $rules = [
                'ho_ten' => 'required|string|max:255',
                'so_dien_thoai' => 'required|string|max:15',
                'hinh_thuc_giao_hang' => 'required|in:pickup,delivery',
                'payment_method' => 'required|in:cod,momo',
                'cartItems' => 'required',
            ];
            if ($request->hinh_thuc_giao_hang === 'delivery') {
                $rules['dia_chi_giao_hang'] = 'required|string|max:255';
            }
            $validated = $request->validate($rules);
            // Decode cartItems từ JSON
            $cartItems = json_decode($request->input('cartItems'), true);
            if (!$cartItems || !is_array($cartItems)) {
                return response()->json(['success' => false, 'message' => 'Dữ liệu giỏ hàng không hợp lệ'], 400);
            }

            // Kiểm tra giỏ hàng
            if (empty($cartItems)) {
                return response()->json(['success' => false, 'message' => 'Giỏ hàng rỗng'], 400);
            }

            // Tạo đơn hàng
            $donHang = new DonHang();
            $donHang->ho_ten = $request->ho_ten;
            $donHang->so_dien_thoai = $request->so_dien_thoai;
            $donHang->hinh_thuc_giao_hang = $request->hinh_thuc_giao_hang;
            $donHang->phuong_thuc_thanh_toan = $request->payment_method;
            $donHang->trang_thai = 'cho_xac_nhan';
            $donHang->tong_tien = 0; // Sẽ tính sau
            // Gán địa chỉ giao hàng dựa trên hình thức giao hàng
            if ($request->hinh_thuc_giao_hang === 'pickup') {
                $donHang->dia_chi_giao_hang = 'Nhận tại cửa hàng';
            } else {
                $donHang->dia_chi_giao_hang = $request->dia_chi_giao_hang; // Địa chỉ từ form
            }
            $donHang->save();

            // Tính tổng tiền và lưu chi tiết đơn hàng
            $tongTien = 0;
            foreach ($cartItems as $item) {
                $sanPham = SanPham::find($item['id']);
                if (!$sanPham) {
                    return response()->json(['success' => false, 'message' => "Sản phẩm với ID {$item['id']} không tồn tại"], 400);
                }

                // Tính giá bán dựa trên size và topping
                $giaBan = $sanPham->gia;
                if (isset($item['size_id']) && $item['size_id']) {
                    $size = Size::find($item['size_id']);
                    if ($size) {
                        $giaBan += $size->price_multiplier;
                    }
                }
                if (isset($item['topping_id']) && $item['topping_id']) {
                    $topping = Topping::find($item['topping_id']);
                    if ($topping) {
                        $giaBan += $topping->price;
                    }
                }

                $thanhTien = $giaBan * $item['so_luong'];

                // Lưu chi tiết đơn hàng
                $chiTiet = new ChiTietDonHang();
                $chiTiet->don_hang_id = $donHang->id;
                $chiTiet->san_pham_id = $item['id'];
                $chiTiet->so_luong = $item['so_luong'];
                $chiTiet->gia_ban = $giaBan; // Sử dụng cột gia_ban thay vì don_gia
                $chiTiet->size_id = isset($item['size_id']) && $item['size_id'] ? $item['size_id'] : null;
                $chiTiet->topping_id = isset($item['topping_id']) && $item['topping_id'] ? $item['topping_id'] : null;
                $chiTiet->ghi_chu = isset($item['ghi_chu']) ? $item['ghi_chu'] : null;
                $chiTiet->save();

                $tongTien += $thanhTien;
            }

            // Cập nhật tổng tiền
            $donHang->tong_tien = $tongTien;
            $donHang->save();

            // Xóa giỏ hàng nếu thành công
            if (Auth::check()) {
                GioHang::where('user_id', Auth::id())->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Đặt hàng thành công',
                'clearCart' => true
            ]);
        } catch (\Exception $e) {
            Log::error('Error in placeOrder: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage()], 500);
        }
    }
    public function checkMoMoStatus($orderId)
    {
        try {
            $donHang = DonHang::findOrFail($orderId);
            return response()->json([
                'success' => true,
                'trang_thai' => $donHang->trang_thai,
                'order' => [
                    'id' => $donHang->id,
                    'ma_don_hang' => $donHang->ma_don_hang,
                    'name' => $donHang->name,
                    'phone' => $donHang->phone,
                    'address' => $donHang->address,
                    'hinh_thuc_giao_hang' => $donHang->hinh_thuc_giao_hang,
                    'payment_method' => $donHang->payment_method,
                    'tong_tien' => $donHang->tong_tien,
                    'trang_thai' => $donHang->trang_thai,
                    'created_at' => $donHang->created_at->format('Y-m-d H:i:s'),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể kiểm tra trạng thái đơn hàng: ' . $e->getMessage(),
            ]);
        }
    }
    public function updateQuantity(Request $request)
    {
        try {
            $cartItemId = $request->input('cart_item_id');
            $quantity = $request->input('quantity');

            if ($quantity < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng phải lớn hơn 0!',
                    'old_quantity' => $quantity,
                ]);
            }

            $sessionId = Session::getId();
            $userId = Auth::id();

            $cartItem = GioHang::where('id', $cartItemId)
                ->where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })
                ->with(['sanPham', 'size', 'topping'])
                ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại trong giỏ hàng!',
                    'old_quantity' => $quantity,
                ]);
            }

            // Cập nhật số lượng
            $cartItem->so_luong = $quantity;
            $cartItem->save();

            // Tính lại thành tiền
            $giaSanPham = $cartItem->sanPham->gia;
            $giaSize = $cartItem->size ? $cartItem->size->price_multiplier : 0;
            $giaTopping = $cartItem->topping ? $cartItem->topping->price : 0;
            $giaBan = $giaSanPham + $giaSize + $giaTopping;
            $thanhTien = $giaBan * $quantity;

            // Tính lại tổng tiền
            $cartItems = GioHang::where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
                ->with(['sanPham', 'size', 'topping'])
                ->get();

            $total = 0;
            foreach ($cartItems as $item) {
                $giaSanPham = $item->sanPham->gia;
                $giaSize = $item->size ? $item->size->price_multiplier : 0;
                $giaTopping = $item->topping ? $item->topping->price : 0;
                $giaBan = $giaSanPham + $giaSize + $giaTopping;
                $total += $giaBan * $item->so_luong;
            }

            return response()->json([
                'success' => true,
                'thanh_tien' => $thanhTien,
                'total' => $total,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật số lượng!',
                'old_quantity' => $request->input('quantity'),
            ]);
        }
    }
    public function getCart(Request $request)
    {
        try {
            $sessionId = Session::getId();
            $userId = Auth::id();

            Log::info('CheckoutController@getCart - Session ID: ' . $sessionId);
            Log::info('CheckoutController@getCart - User ID: ' . ($userId ?? 'Guest'));

            $cartItems = GioHang::where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->with(['sanPham', 'size', 'topping'])
            ->get();

            Log::info('CheckoutController@getCart - Cart: ' . $cartItems->toJson());

            // Kiểm tra xem $cartItems có phải là mảng/collection không
            if (!$cartItems instanceof \Illuminate\Database\Eloquent\Collection) {
                Log::error('CheckoutController@getCart - CartItems is not a collection: ' . json_encode($cartItems));
                return response()->json([]);
            }

            return response()->json($cartItems);
        } catch (\Exception $e) {
            Log::error('CheckoutController@getCart - Error: ' . $e->getMessage());
            return response()->json([]); // Trả về mảng rỗng nếu có lỗi
        }
    }
    public function handleMoMoNotify(Request $request)
    {
        try {
            $data = $request->all();
            $orderId = $data['orderId'] ?? null;
            $resultCode = $data['resultCode'] ?? null;

            if (!$orderId || $resultCode === null) {
                return response()->json(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ'], 400);
            }

            // Lấy order_id từ extraData
            $extraData = json_decode(base64_decode($data['extraData']), true);
            $donHangId = $extraData['order_id'] ?? null;

            if (!$donHangId) {
                return response()->json(['status' => 'error', 'message' => 'Không tìm thấy đơn hàng'], 400);
            }

            $donHang = DonHang::find($donHangId);
            if (!$donHang) {
                return response()->json(['status' => 'error', 'message' => 'Đơn hàng không tồn tại'], 404);
            }

            if ($resultCode == 0) {
                // Thanh toán thành công
                $donHang->status = 'paid';
                $donHang->save();

                // Xóa giỏ hàng
                $userId = $donHang->user_id;
                $sessionId = Session::getId();
                GioHang::where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })->delete();
            } else {
                // Thanh toán thất bại
                $donHang->status = 'failed';
                $donHang->save();
            }

            return response()->json(['status' => 'success', 'message' => 'Xử lý thông báo thành công']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }
    public function updateCart(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Bạn cần đăng nhập để cập nhật giỏ hàng!'], 401);
            }

            $cartItems = $request->input('cartItems', []);

            if (empty($cartItems)) {
                return response()->json(['success' => false, 'message' => 'Không có sản phẩm để cập nhật!'], 400);
            }

            foreach ($cartItems as $item) {
                $gioHang = GioHang::where('id', $item['id'])
                    ->where('user_id', $user->id)
                    ->first();

                if ($gioHang) {
                    $soLuong = $item['so_luong'] ?? 1;
                    if ($soLuong < 1) {
                        $gioHang->delete();
                    } else {
                        $gioHang->so_luong = $soLuong;
                        $gioHang->save();
                    }
                }
            }

            return response()->json(['success' => true, 'message' => 'Cập nhật giỏ hàng thành công!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi khi cập nhật giỏ hàng: ' . $e->getMessage()], 500);
        }
    }
    public function remove($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn cần đăng nhập để thực hiện thao tác này!'
                ], 401);
            }

            $cartItem = GioHang::where('user_id', $user->id)
                ->where('id', $id)
                ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại trong giỏ hàng!'
                ], 404);
            }

            $cartItem->delete();

            // Lấy lại giỏ hàng từ database
            $cartItems = GioHang::where('user_id', $user->id)
                ->with(['sanPham', 'size', 'topping'])
                ->get();

            $cart = $cartItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'san_pham_id' => $item->san_pham_id,
                    'so_luong' => $item->so_luong,
                    'size_id' => $item->size ? $item->size->name : null,
                    'size_price' => $item->size ? $item->size->price_multiplier : 0,
                    'topping_id' => $item->topping ? $item->topping->name : null,
                    'topping_price' => $item->topping ? $item->topping->price : 0,
                    'name' => $item->sanPham ? $item->sanPham->ten_san_pham : 'Sản phẩm không tồn tại',
                    'price' => $item->sanPham ? $item->sanPham->gia : 0,
                    'hinh_anh' => $item->sanPham ? ($item->sanPham->hinh_anh ?? 'https://via.placeholder.com/300') : 'https://via.placeholder.com/300',
                    'ghi_chu' => $item->ghi_chu ?? ''
                ];
            })->toArray();

            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng!',
                'cart' => $cart
            ]);
        } catch (\Exception $e) {
            Log::error('CheckoutController@remove - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage(),
                'cart' => []
            ], 500);
        }
    }
}