<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\SanPham;
use App\Models\User;
use Illuminate\Http\Request;

class DonHangController extends Controller
{
    /**
     * Hiển thị giao diện quản lý đơn hàng
     */
    public function indexView()
    {
        return view('donhangs.index');
    }

    /**
     * Lấy danh sách đơn hàng (API)
     */
    public function index(Request $request)
    {
        try {
            // Lấy tham số tìm kiếm và phân trang từ request
            $search = $request->query('search', '');
            $perPage = $request->query('per_page', 10);

            // Tạo query để lấy danh sách đơn hàng
            $query = DonHang::with('user.role', 'chiTietDonHangs.sanPham.danhMuc')
                ->orderBy('created_at', 'desc');

            // Nếu có từ khóa tìm kiếm
            if ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })->orWhere('trang_thai', 'like', "%{$search}%");
            }

            // Phân trang
            $donHangs = $query->paginate($perPage);

            return response()->json($donHangs, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi lấy danh sách đơn hàng: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Lưu đơn hàng mới (API)
     */
    public function store(Request $request)
    {
        try {
            // Validate dữ liệu
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'chi_tiet' => 'required|array',
                'chi_tiet.*.san_pham_id' => 'required|exists:san_phams,id',
                'chi_tiet.*.so_luong' => 'required|integer|min:1',
            ]);

            // Tính tổng tiền
            $tongTien = 0;
            foreach ($validated['chi_tiet'] as $item) {
                $sanPham = SanPham::findOrFail($item['san_pham_id']);
                $tongTien += $sanPham->gia * $item['so_luong'];
            }

            // Tạo đơn hàng
            $donHang = DonHang::create([
                'user_id' => $validated['user_id'],
                'tong_tien' => $tongTien,
                'trang_thai' => 'cho_xac_nhan',
            ]);

            // Tạo chi tiết đơn hàng
            foreach ($validated['chi_tiet'] as $item) {
                $sanPham = SanPham::findOrFail($item['san_pham_id']);
                ChiTietDonHang::create([
                    'don_hang_id' => $donHang->id,
                    'san_pham_id' => $item['san_pham_id'],
                    'so_luong' => $item['so_luong'],
                    'gia_ban' => $sanPham->gia,
                ]);
            }

            return response()->json(['message' => 'Tạo đơn hàng thành công'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi tạo đơn hàng: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Cập nhật đơn hàng (API)
     */
    public function update(Request $request, $id)
    {
        try {
            // Tìm đơn hàng
            $donHang = DonHang::findOrFail($id);

            // Validate dữ liệu
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'trang_thai' => 'required|in:cho_xac_nhan,dang_giao,hoan_thanh,da_huy',
                'chi_tiet' => 'required|array',
                'chi_tiet.*.san_pham_id' => 'required|exists:san_phams,id',
                'chi_tiet.*.so_luong' => 'required|integer|min:1',
            ]);

            // Tính tổng tiền
            $tongTien = 0;
            foreach ($validated['chi_tiet'] as $item) {
                $sanPham = SanPham::findOrFail($item['san_pham_id']);
                $tongTien += $sanPham->gia * $item['so_luong'];
            }

            // Cập nhật đơn hàng
            $donHang->update([
                'user_id' => $validated['user_id'],
                'tong_tien' => $tongTien,
                'trang_thai' => $validated['trang_thai'],
            ]);

            // Xóa chi tiết đơn hàng cũ
            ChiTietDonHang::where('don_hang_id', $donHang->id)->delete();

            // Tạo chi tiết đơn hàng mới
            foreach ($validated['chi_tiet'] as $item) {
                $sanPham = SanPham::findOrFail($item['san_pham_id']);
                ChiTietDonHang::create([
                    'don_hang_id' => $donHang->id,
                    'san_pham_id' => $item['san_pham_id'],
                    'so_luong' => $item['so_luong'],
                    'gia_ban' => $sanPham->gia,
                ]);
            }

            return response()->json(['message' => 'Cập nhật đơn hàng thành công'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi cập nhật đơn hàng: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Xóa đơn hàng (API)
     */
    public function destroy($id)
    {
        try {
            $donHang = DonHang::findOrFail($id);
            $donHang->delete(); // Xóa đơn hàng, chi tiết đơn hàng sẽ tự động xóa nhờ onDelete('cascade')

            return response()->json(['message' => 'Xóa đơn hàng thành công'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi xóa đơn hàng: ' . $e->getMessage()], 500);
        }
    }
}