@extends('layouts.app')

@section('content')
<!-- Products Header Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-5 fw-bold mb-3">Sản phẩm của chúng tôi</h1>
                <p class="lead">Khám phá bộ sưu tập trà sữa đa dạng với hương vị độc đáo, được làm từ nguyên liệu tươi ngon nhất.</p>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1558857563-c0c3a62fd0b7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Products" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Products Filter Section -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-body p-4">
                        <form action="{{ route('sanpham.public') }}" method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label for="danh_muc_filter" class="form-label">Danh mục</label>
                                <select class="form-select" id="danh_muc_filter" name="danh_muc_filter">
                                    <option value="">Tất cả danh mục</option>
                                    @foreach($danhMucs as $danhMuc)
                                        <option value="{{ $danhMuc->id }}" {{ request('danh_muc_filter') == $danhMuc->id ? 'selected' : '' }}>
                                            {{ $danhMuc->ten_danh_muc }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="price_filter" class="form-label">Giá</label>
                                <select class="form-select" id="price_filter" name="price_filter">
                                    <option value="">Tất cả giá</option>
                                    <option value="0-30000" {{ request('price_filter') == '0-30000' ? 'selected' : '' }}>Dưới 30,000 VNĐ</option>
                                    <option value="30000-50000" {{ request('price_filter') == '30000-50000' ? 'selected' : '' }}>30,000 - 50,000 VNĐ</option>
                                    <option value="50000-100000" {{ request('price_filter') == '50000-100000' ? 'selected' : '' }}>50,000 - 100,000 VNĐ</option>
                                    <option value="100000+" {{ request('price_filter') == '100000+' ? 'selected' : '' }}>Trên 100,000 VNĐ</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-2"></i>Lọc sản phẩm
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Display Section -->
<section class="py-5">
    <div class="container">
        @if($sanPhams->isEmpty())
            <div class="alert alert-info text-center" data-aos="fade-up">
                <i class="fas fa-info-circle me-2"></i>Không tìm thấy sản phẩm nào phù hợp với tiêu chí của bạn.
            </div>
        @else
            <div class="row">
                @foreach($sanPhams as $index => $sanPham)
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="position-relative">
                                <img src="{{ $sanPham->hinh_anh ?? 'https://via.placeholder.com/300' }}" class="card-img-top" alt="{{ $sanPham->ten_san_pham }}" style="height: 250px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-primary">
                                        <i class="fas fa-fire me-1"></i>Hot
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $sanPham->ten_san_pham }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($sanPham->mo_ta ?? 'Mô tả sản phẩm', 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0 text-primary fw-bold">{{ number_format($sanPham->gia, 0, ',', '.') }} VNĐ</span>
                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal{{ $sanPham->id }}">
                                        <i class="fas fa-shopping-cart me-1"></i>Thêm vào giỏ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Modal -->
                    <div class="modal fade" id="productModal{{ $sanPham->id }}" tabindex="-1" aria-labelledby="productModalLabel{{ $sanPham->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="productModalLabel{{ $sanPham->id }}">{{ $sanPham->ten_san_pham }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <img src="{{ $sanPham->hinh_anh ?? 'https://via.placeholder.com/300' }}" class="img-fluid rounded" alt="{{ $sanPham->ten_san_pham }}">
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="mb-3">{{ $sanPham->ten_san_pham }}</h4>
                                            <p class="text-muted mb-3">{{ $sanPham->mo_ta ?? 'Mô tả sản phẩm' }}</p>
                                            <h5 class="text-primary mb-3">{{ number_format($sanPham->gia, 0, ',', '.') }} VNĐ</h5>
                                            
                                            <form action="{{ route('donhangs.addToCart') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="san_pham_id" value="{{ $sanPham->id }}">
                                                
                                                <div class="mb-3">
                                                    <label for="size{{ $sanPham->id }}" class="form-label">Kích thước</label>
                                                    <select class="form-select" id="size{{ $sanPham->id }}" name="size_id" required>
                                                        @foreach($sizes as $size)
                                                            <option value="{{ $size->id }}">{{ $size->ten_size }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Topping</label>
                                                    <div class="row">
                                                        @foreach($toppings as $topping)
                                                            <div class="col-md-6 mb-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="toppings[]" value="{{ $topping->id }}" id="topping{{ $topping->id }}{{ $sanPham->id }}">
                                                                    <label class="form-check-label" for="topping{{ $topping->id }}{{ $sanPham->id }}">
                                                                        {{ $topping->ten_topping }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="quantity{{ $sanPham->id }}" class="form-label">Số lượng</label>
                                                    <input type="number" class="form-control" id="quantity{{ $sanPham->id }}" name="so_luong" value="1" min="1" required>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="note{{ $sanPham->id }}" class="form-label">Ghi chú</label>
                                                    <textarea class="form-control" id="note{{ $sanPham->id }}" name="ghi_chu" rows="2"></textarea>
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection 