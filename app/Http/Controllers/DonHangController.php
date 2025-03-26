<?php
namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\SanPham;
use App\Models\Size;
use App\Models\Topping;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class DonHangController extends Controller
{
    //public function __construct()
    //{
     //   $this->middleware('auth'); // Yêu cầu đăng nhập
   // }

   public function indexView()
{
    $donHangs = DonHang::with('chiTietDonHangs.sanPham', 'user')->paginate(5);
    $sanPhams = \App\Models\SanPham::all();
    $sizes = \App\Models\Size::all();
    $toppings = \App\Models\Topping::all();
    return view('donhangs.index', compact('donHangs', 'sanPhams', 'sizes', 'toppings'));
}

    public function create()
    {
        $sanPham = SanPham::all();
        $sizes = Size::all();
        $toppings = Topping::all();
        return view('donhangs.create', compact('sanPham', 'sizes', 'toppings'));
    }
    public function cancel($id)
{
    $donHang = DonHang::where('user_id', Auth::id())->findOrFail($id);
    if ($donHang->trang_thai !== 'cho_xac_nhan') {
        return redirect()->route('donhangs.index')->with('error', 'Chỉ có thể hủy đơn hàng ở trạng thái "Chờ xác nhận".');
    }

    $donHang->update(['trang_thai' => 'huy']);
    return redirect()->route('donhangs.index')->with('success', 'Đã hủy đơn hàng thành công.');
}

    public function addToCart(Request $request)
    {
        $request->validate([
            'san_pham_id' => 'required|exists:san_phams,id',
            'so_luong' => 'required|integer|min:1',
            'size_id' => 'required|exists:sizes,id',
            'topping_id' => 'nullable|exists:toppings,id',
        ]);

        $sanPham = SanPham::find($request->san_pham_id);
        $size = Size::find($request->size_id);
        $topping = $request->topping_id ? Topping::find($request->topping_id) : null;

        // Tính giá: giá sản phẩm * hệ số kích thước + giá topping
        $price = $sanPham->gia * $size->price_multiplier + ($topping ? $topping->price : 0);
        $totalPrice = $price * $request->so_luong;

        $cart = session()->get('cart', []);
        $cart[] = [
            'san_pham_id' => $request->san_pham_id,
            'san_pham_name' => $sanPham->ten_san_pham, // Sử dụng ten_san_pham
            'so_luong' => $request->so_luong,
            'size_id' => $request->size_id,
            'size_name' => $size->name,
            'topping_id' => $request->topping_id,
            'topping_name' => $topping ? $topping->name : null,
            'price' => $price,
            'total_price' => $totalPrice,
        ];

        session()->put('cart', $cart);

        return redirect()->route('donhangs.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function removeFromCart($index)
    {   
        $cart = session()->get('cart', []);
        if (isset($cart[$index])) {
            unset($cart[$index]);
            session()->put('cart', array_values($cart));
            return redirect()->route('donhangs.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
        }
        return redirect()->route('donhangs.index')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
    }
    

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('donhangs.create')->with('error', 'Giỏ hàng trống. Vui lòng thêm sản phẩm.');
        }

        // Tính tổng tiền
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['total_price'];
        }

        // Tạo đơn hàng
        $donHang = DonHang::create([
            //'user_id' => Auth::id(),
            'tong_tien' => $totalAmount,
            'trang_thai' => 'cho_xac_nhan',
        ]);

        // Tạo chi tiết đơn hàng
        foreach ($cart as $item) {
            ChiTietDonHang::create([
                'don_hang_id' => $donHang->id,
                'san_pham_id' => $item['san_pham_id'],
                'so_luong' => $item['so_luong'],
                'gia_ban' => $item['price'],
                'size_id' => $item['size_id'],
                'topping_id' => $item['topping_id'],
            ]);
        }

        // Xóa giỏ hàng sau khi tạo đơn hàng
        session()->forget('cart');

        // Gửi email thông báo
        //$khachHang = Auth::user();
        //$nhanViens = User::whereHas('role', function ($query) {
            //$query->where('role', 'nhanvien');
        //})->get();
        //Notification::send($khachHang, new OrderCreatedNotification($donHang));
        //Notification::send($nhanViens, new OrderCreatedNotification($donHang));

        return redirect()->route('donhangs.index')->with('success', 'Tạo đơn hàng thành công.');
    }
}