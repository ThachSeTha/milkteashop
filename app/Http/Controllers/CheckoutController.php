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
            $sanPham = SanPham::findOrFail($id);

            $defaultSize = Size::first();
            if (!$defaultSize) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy kích thước mặc định!',
                ], 500);
            }

            $sessionId = Session::getId();
            $userId = Auth::id();

            Log::info('CheckoutController@addToCart - Session ID: ' . $sessionId);
            Log::info('CheckoutController@addToCart - User ID: ' . ($userId ?? 'Guest'));

            $cartItem = GioHang::where([
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'san_pham_id' => $id,
                'size_id' => $request->input('size_id', $defaultSize->id),
                'topping_id' => $request->input('topping_id', null),
            ])->first();

            if ($cartItem) {
                $cartItem->so_luong += ($request->so_luong ?? 1);
            } else {
                $cartItem = new GioHang();
                $cartItem->user_id = $userId;
                $cartItem->session_id = $userId ? null : $sessionId;
                $cartItem->san_pham_id = $id;
                $cartItem->size_id = $request->input('size_id', $defaultSize->id);
                $cartItem->topping_id = $request->input('topping_id', null);
                $cartItem->so_luong = $request->so_luong ?? 1;
                $cartItem->ghi_chu = $request->input('ghi_chu', null);
            }

            $size = Size::find($cartItem->size_id);
            $topping = Topping::find($cartItem->topping_id);
            $giaSanPham = $sanPham->gia;
            $giaSize = $size ? $size->price_multiplier : 0;
            $giaTopping = $topping ? $topping->price : 0;
            $cartItem->thanh_tien = ($giaSanPham + $giaSize + $giaTopping) * $cartItem->so_luong;
            $cartItem->save();

            Log::info('CheckoutController@addToCart - Cart Item Saved: ' . $cartItem->toJson());

            $message = 'Sản phẩm đã được thêm vào giỏ hàng!';
            if ($request->has('buy_now') && $request->input('buy_now') == 1) {
                $message = 'Sản phẩm đã được thêm vào giỏ hàng! Vui lòng kiểm tra và đặt hàng.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_item' => [
                    'san_pham_id' => $cartItem->san_pham_id,
                    'name' => $sanPham->ten_san_pham,
                    'price' => $giaSanPham + $giaSize + $giaTopping,
                    'so_luong' => $cartItem->so_luong,
                    'hinh_anh' => $sanPham->hinh_anh
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('CheckoutController@addToCart - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng: ' . $e->getMessage(),
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
    
            // Tạo đơn hàng tạm thời để lấy ID
            $donHang = DonHang::create([
                'user_id' => $userId,
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'hinh_thuc_giao_hang' => $validated['hinh_thuc_giao_hang'], // Lưu hình thức giao hàng
                'payment_method' => 'momo',
                'total' => $total,
                'status' => 'awaiting_payment',
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
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ]);
        }
    }
    public function placeOrder(Request $request)
    {
        try {
            // Validate dữ liệu
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'address' => 'required|string',
                'hinh_thuc_giao_hang' => 'required|string|in:pickup,delivery',
                'payment_method' => 'required|string|in:cod,momo',
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
                    'message' => 'Giỏ hàng của bạn đang trống!'
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

            // Tạo đơn hàng
            $donHang = DonHang::create([
                'user_id' => $userId,
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'hinh_thuc_giao_hang' => $validated['hinh_thuc_giao_hang'],
                'payment_method' => $validated['payment_method'],
                'total' => $total,
                'status' => $validated['payment_method'] === 'cod' ? 'pending' : 'awaiting_payment',
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

            // Xóa giỏ hàng trong cơ sở dữ liệu nếu là COD
            if ($validated['payment_method'] === 'cod') {
                GioHang::where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Đặt hàng thành công! Chúng tôi sẽ liên hệ bạn sớm.',
                    'clearCart' => true // Thêm flag để phía client xóa Local Storage
                ]);
            }

            return response()->json([
                'success' => true,
                'order_id' => $donHang->id,
                'clearCart' => true // Thêm flag để phía client xóa Local Storage
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage(),
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
            $sessionId = Session::getId();
            $userId = Auth::id();

            $gioHang = GioHang::where('id', $id)
                ->where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })
                ->first();

            if (!$gioHang) {
                return response()->json(['success' => false, 'message' => 'Mục giỏ hàng không tồn tại!'], 404);
            }

            $gioHang->delete();

            return response()->json(['success' => true, 'message' => 'Xóa sản phẩm thành công!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi khi xóa sản phẩm: ' . $e->getMessage()], 500);
        }
    }
}