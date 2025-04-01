<!DOCTYPE html>
 <html lang="vi">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Chi tiết người dùng - MilkTeaShop</title>
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Font Awesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
     <!-- Animate.css -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
     <style>
         body {
             background: linear-gradient(135deg, #6b48ff, #00ddeb);
             min-height: 100vh;
             font-family: 'Poppins', sans-serif;
             padding: 40px 20px;
             overflow-x: hidden;
         }
         .user-container {
             background: rgba(255, 255, 255, 0.95);
             border-radius: 20px;
             box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
             padding: 40px;
             max-width: 800px;
             margin: 0 auto;
             position: relative;
             overflow: hidden;
             animation: fadeInUp 0.8s ease-out;
         }
         .user-container::before {
             content: '';
             position: absolute;
             top: 0;
             left: 0;
             width: 100%;
             height: 5px;
             background: linear-gradient(90deg, #6b48ff, #00ddeb);
         }
         .user-container h1 {
             font-size: 2.2rem;
             color: #2c3e50;
             text-align: center;
             margin-bottom: 40px;
             font-weight: 700;
             position: relative;
             display: inline-block;
         }
         .user-container h1::after {
             content: '';
             position: absolute;
             bottom: -10px;
             left: 50%;
             transform: translateX(-50%);
             width: 60px;
             height: 4px;
             background: linear-gradient(90deg, #6b48ff, #00ddeb);
             border-radius: 2px;
         }
         .user-details {
             background: white;
             border-radius: 15px;
             box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
             padding: 30px;
             animation: fadeIn 0.5s ease-out;
         }
         .user-details h5 {
             font-size: 1.5rem;
             color: #2c3e50;
             margin-bottom: 20px;
             font-weight: 600;
             position: relative;
             display: inline-block;
         }
         .user-details h5::after {
             content: '';
             position: absolute;
             bottom: -5px;
             left: 0;
             width: 40px;
             height: 3px;
             background: linear-gradient(90deg, #6b48ff, #00ddeb);
             border-radius: 2px;
         }
         .user-details p {
             font-size: 1rem;
             color: #34495e;
             margin-bottom: 15px;
             display: flex;
             align-items: center;
         }
         .user-details p strong {
             font-weight: 600;
             color: #2c3e50;
             min-width: 120px;
             display: inline-block;
         }
         .user-details p i {
             margin-right: 10px;
             color: #6b48ff;
             font-size: 1.2rem;
         }
         .btn-back {
             background: linear-gradient(90deg, #6b48ff, #00ddeb);
             border: none;
             border-radius: 50px;
             padding: 12px 30px;
             font-weight: 600;
             color: white;
             transition: all 0.4s ease;
             box-shadow: 0 5px 15px rgba(107, 72, 255, 0.3);
             display: inline-flex;
             align-items: center;
             justify-content: center;
             margin-top: 20px;
         }
         .btn-back:hover {
             background: linear-gradient(90deg, #00ddeb, #6b48ff);
             transform: translateY(-3px);
             box-shadow: 0 8px 20px rgba(107, 72, 255, 0.5);
         }
         .btn-back i {
             margin-right: 8px;
         }
         @keyframes fadeInUp {
             from {
                 opacity: 0;
                 transform: translateY(20px);
             }
             to {
                 opacity: 1;
                 transform: translateY(0);
             }
         }
         @keyframes fadeIn {
             from {
                 opacity: 0;
             }
             to {
                 opacity: 1;
             }
         }
     </style>
 </head>
 <body>
     <div class="user-container">
         <h1>Chi tiết người dùng</h1>
 
         <div class="user-details">
             <h5>Thông tin người dùng</h5>
             <p><i class="fas fa-id-badge"></i><strong>ID:</strong> {{ $user->id }}</p>
             <p><i class="fas fa-user"></i><strong>Name:</strong> {{ $user->name }}</p>
             <p><i class="fas fa-envelope"></i><strong>Email:</strong> {{ $user->email }}</p>
             <p><i class="fas fa-phone"></i><strong>Phone:</strong> {{ $user->phone }}</p>
             <p><i class="fas fa-map-marker-alt"></i><strong>Address:</strong> {{ $user->address }}</p>
             <p><i class="fas fa-user-tag"></i><strong>Role:</strong> {{ $user->role->name ?? 'N/A' }}</p>
             <p>
         <i class="fas fa-lock"></i><strong>Mật khẩu:</strong>
         <span id="password-text" style="display: none;">********</span>
         <span id="password-hidden">[Đã ẩn vì lý do bảo mật]</span>
         <i class="fas fa-eye toggle-password" style="cursor: pointer; margin-left: 10px;" onclick="togglePassword()"></i>
     </p>
         </div>
 
         <div class="text-center">
             <a href="{{ route('users.index', array_merge(request()->query(), ['from' => 'show'])) }}" class="btn btn-back">
                 <i class="fas fa-arrow-left"></i> Quay lại danh sách user
             </a>
         </div>
     </div>
 
     <!-- Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <script>
     function togglePassword() {
         const passwordText = document.getElementById('password-text');
         const passwordHidden = document.getElementById('password-hidden');
         const toggleIcon = document.querySelector('.toggle-password');
 
         if (passwordText.style.display === 'none') {
             // Hiển thị mật khẩu
             passwordText.style.display = 'inline';
             passwordHidden.style.display = 'none';
             toggleIcon.classList.remove('fa-eye');
             toggleIcon.classList.add('fa-eye-slash'); // Đổi thành icon con mắt đóng
         } else {
             // Ẩn mật khẩu
             passwordText.style.display = 'none';
             passwordHidden.style.display = 'inline';
             toggleIcon.classList.remove('fa-eye-slash');
             toggleIcon.classList.add('fa-eye'); // Đổi lại thành icon con mắt mở
         }
     }
 </script>
 </body>
 </html>