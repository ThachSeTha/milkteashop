@extends('layouts.app')

@section('content')
<!-- About Header Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-5 fw-bold mb-3">Về chúng tôi</h1>
                <p class="lead">MilkTeaShop - Nơi mang đến những ly trà sữa thơm ngon, đậm vị!</p>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="About Us" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Our Story" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h2 class="section-title text-start">Câu chuyện của chúng tôi</h2>
                <p class="lead">MilkTeaShop được thành lập vào năm 2020 với tình yêu dành cho trà sữa.</p>
                <p>Chúng tôi bắt đầu với một cửa hàng nhỏ và một ước mơ lớn: mang đến những ly trà sữa thơm ngon, đậm vị với giá cả phải chăng cho mọi người.</p>
                <p>Với sự nỗ lực không ngừng và tình yêu dành cho nghề, MilkTeaShop đã phát triển từ một cửa hàng nhỏ thành một thương hiệu được yêu thích, với nhiều chi nhánh trên khắp thành phố.</p>
                <p>Chúng tôi tự hào về việc sử dụng nguyên liệu tươi sạch, được chọn lọc kỹ càng để tạo ra những ly trà sữa chất lượng, đáp ứng khẩu vị của mọi người.</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Values Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5" data-aos="fade-up">Giá trị cốt lõi</h2>
        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-primary text-white rounded-circle p-3 d-inline-block mb-3">
                            <i class="fas fa-leaf fa-2x"></i>
                        </div>
                        <h4 class="mb-3">Chất lượng</h4>
                        <p class="text-muted">Chúng tôi cam kết sử dụng nguyên liệu tươi sạch, chất lượng cao để tạo ra những ly trà sữa thơm ngon, đậm vị.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-primary text-white rounded-circle p-3 d-inline-block mb-3">
                            <i class="fas fa-heart fa-2x"></i>
                        </div>
                        <h4 class="mb-3">Tận tâm</h4>
                        <p class="text-muted">Chúng tôi luôn đặt sự hài lòng của khách hàng lên hàng đầu, phục vụ với tinh thần nhiệt tình, chuyên nghiệp.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-primary text-white rounded-circle p-3 d-inline-block mb-3">
                            <i class="fas fa-lightbulb fa-2x"></i>
                        </div>
                        <h4 class="mb-3">Sáng tạo</h4>
                        <p class="text-muted">Chúng tôi không ngừng sáng tạo, nghiên cứu để mang đến những hương vị mới, độc đáo cho khách hàng.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Team Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5" data-aos="fade-up">Đội ngũ của chúng tôi</h2>
        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" class="card-img-top" alt="Team Member" style="height: 300px; object-fit: cover;">
                    <div class="card-body p-4 text-center">
                        <h5 class="card-title mb-1">Nguyễn Văn A</h5>
                        <p class="text-muted mb-3">Giám đốc điều hành</p>
                        <p class="card-text">Với hơn 10 năm kinh nghiệm trong ngành F&B, anh A đã dẫn dắt MilkTeaShop phát triển từ một cửa hàng nhỏ thành một thương hiệu được yêu thích.</p>
                        <div class="social-icons mt-3">
                            <a href="#" class="text-dark me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-dark me-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-dark me-2"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" class="card-img-top" alt="Team Member" style="height: 300px; object-fit: cover;">
                    <div class="card-body p-4 text-center">
                        <h5 class="card-title mb-1">Trần Thị B</h5>
                        <p class="text-muted mb-3">Quản lý sản phẩm</p>
                        <p class="card-text">Chị B là người đứng sau những công thức trà sữa độc đáo của MilkTeaShop. Với tình yêu dành cho ẩm thực, chị luôn tìm tòi, sáng tạo để mang đến những hương vị mới.</p>
                        <div class="social-icons mt-3">
                            <a href="#" class="text-dark me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-dark me-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-dark me-2"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100">
                    <img src="https://randomuser.me/api/portraits/men/67.jpg" class="card-img-top" alt="Team Member" style="height: 300px; object-fit: cover;">
                    <div class="card-body p-4 text-center">
                        <h5 class="card-title mb-1">Lê Văn C</h5>
                        <p class="text-muted mb-3">Quản lý kinh doanh</p>
                        <p class="card-text">Anh C là người đứng sau chiến lược kinh doanh của MilkTeaShop. Với tầm nhìn chiến lược, anh đã giúp MilkTeaShop mở rộng thị trường và phát triển bền vững.</p>
                        <div class="social-icons mt-3">
                            <a href="#" class="text-dark me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-dark me-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-dark me-2"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Achievements Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5" data-aos="fade-up">Thành tựu của chúng tôi</h2>
        <div class="row text-center">
            <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="display-4 fw-bold text-primary mb-3">10+</div>
                        <h5>Chi nhánh</h5>
                        <p class="text-muted">Trên khắp thành phố</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="display-4 fw-bold text-primary mb-3">50+</div>
                        <h5>Loại trà sữa</h5>
                        <p class="text-muted">Đa dạng hương vị</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="display-4 fw-bold text-primary mb-3">1000+</div>
                        <h5>Khách hàng</h5>
                        <p class="text-muted">Hài lòng mỗi ngày</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="display-4 fw-bold text-primary mb-3">3</div>
                        <h5>Năm kinh nghiệm</h5>
                        <p class="text-muted">Phát triển bền vững</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <h2 class="mb-4">Bạn đã sẵn sàng thưởng thức trà sữa thơm ngon?</h2>
                <p class="lead mb-4">Hãy đến với MilkTeaShop để trải nghiệm những ly trà sữa đậm vị, được làm từ nguyên liệu tươi ngon nhất!</p>
                <div class="d-flex justify-content-center">
                    <a href="{{ route('sanpham.public') }}" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-shopping-bag me-2"></i>Đặt hàng ngay
                    </a>
                    <a href="#" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-map-marker-alt me-2"></i>Tìm cửa hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 