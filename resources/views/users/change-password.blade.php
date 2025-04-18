<!DOCTYPE html>
 <html lang="vi">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Đổi mật khẩu - MilkTeaShop</title>
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Font Awesome cho biểu tượng con mắt -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
     <style>
         body {
             background: linear-gradient(135deg, #74ebd5, #acb6e5);
             min-height: 100vh;
             display: flex;
             justify-content: center;
             align-items: center;
             font-family: 'Arial', sans-serif;
         }
         .translate-middle-y {
     transform: translateY(0) !important;
 }
         .change-password-container {
             background: white;
             padding: 40px;
             border-radius: 15px;
             box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
             width: 100%;
             max-width: 450px;
             transition: transform 0.3s ease, box-shadow 0.3s ease;
         }
         .change-password-container:hover {
             transform: translateY(-5px);
             box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
         }
         .change-password-container h1 {
             font-size: 1.8rem;
             color: #333;
             text-align: center;
             margin-bottom: 20px;
             font-weight: bold;
         }
         .form-label {
             font-weight: 600;
             color: #555;
         }
         .form-control {
             border-radius: 10px;
             border: 1px solid #ddd;
             padding: 12px;
             transition: border-color 0.3s ease, box-shadow 0.3s ease;
         }
         .form-control:focus {
             border-color: #74ebd5;
             box-shadow: 0 0 10px rgba(116, 235, 213, 0.3);
             outline: none;
         }
         .position-relative {
             position: relative;
         }
         .toggle-password {
             cursor: pointer;
             color: #888;
             transition: color 0.3s ease;
         }
         .toggle-password:hover {
             color: #333;
         }
         .btn-primary {
             background: linear-gradient(90deg, #74ebd5, #acb6e5);
             border: none;
             border-radius: 10px;
             padding: 12px;
             font-weight: 600;
             transition: background 0.3s ease, transform 0.3s ease;
         }
         .btn-primary:hover {
             background: linear-gradient(90deg, #acb6e5, #74ebd5);
             transform: scale(1.05);
         }
         .btn-secondary {
             background: linear-gradient(90deg, #d3d3d3, #a9a9a9);
             border: none;
             border-radius: 10px;
             padding: 12px;
             font-weight: 600;
             transition: background 0.3s ease, transform 0.3s ease;
         }
         .btn-secondary:hover {
             background: linear-gradient(90deg, #a9a9a9, #d3d3d3);
             transform: scale(1.05);
         }
         .alert {
             border-radius: 10px;
             margin-bottom: 20px;
         }
         .text-danger {
             font-size: 0.9rem;
             margin-top: 5px;
             display: block;
         }
         #passwordMismatchError {
             display: none;
             color: #dc3545;
             font-size: 0.9rem;
             margin-top: 5px;
         }
     </style>
 </head>
 <body>
     <div class="change-password-container">
         <h1>Đổi mật khẩu cho {{ $user->name }}</h1>
 
         @if(session('success'))
             <div class="alert alert-success">
                 {{ session('success') }}
             </div>
         @endif
 
         @if ($errors->any())
             <div class="alert alert-danger">
                 <ul>
                     @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                     @endforeach
                 </ul>
             </div>
         @endif
 
         <form action="{{ route('users.update-password', $user->id) }}" method="POST" id="changePasswordForm">
             @csrf
             <div class="mb-3 position-relative">
                 <label for="password" class="form-label">Mật khẩu mới</label>
                 <input type="password" name="password" id="password" class="form-control" required>
                 <span class="position-absolute end-0 top-50 translate-middle-y me-3 toggle-password">
                     <i class="fas fa-eye" id="togglePasswordIcon"></i>
                 </span>
                 @error('password')
                     <span class="text-danger">{{ $message }}</span>
                 @enderror
             </div>
             <div class="mb-3 position-relative">
                 <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                 <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                 <span class="position-absolute end-0 top-50 translate-middle-y me-3 toggle-password">
                     <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                 </span>
                 <span id="passwordMismatchError">Mật khẩu xác nhận không khớp!</span>
             </div>
             <div class="d-flex justify-content-between">
                 <button type="submit" class="btn btn-primary w-45">Cập nhật mật khẩu</button>
                 <a href="{{ route('users.index') }}" class="btn btn-secondary w-45">Quay lại</a>
             </div>
         </form>
     </div>
 
     <!-- Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <script>
         // Xử lý hiển thị/ẩn mật khẩu cho trường "Mật khẩu mới"
         document.querySelector('#togglePasswordIcon').addEventListener('click', function () {
             const passwordInput = document.querySelector('#password');
             const icon = this;
             if (passwordInput.type === 'password') {
                 passwordInput.type = 'text';
                 icon.classList.remove('fa-eye');
                 icon.classList.add('fa-eye-slash');
             } else {
                 passwordInput.type = 'password';
                 icon.classList.remove('fa-eye-slash');
                 icon.classList.add('fa-eye');
             }
         });
 
         // Xử lý hiển thị/ẩn mật khẩu cho trường "Xác nhận mật khẩu"
         document.querySelector('#toggleConfirmPasswordIcon').addEventListener('click', function () {
             const confirmPasswordInput = document.querySelector('#password_confirmation');
             const icon = this;
             if (confirmPasswordInput.type === 'password') {
                 confirmPasswordInput.type = 'text';
                 icon.classList.remove('fa-eye');
                 icon.classList.add('fa-eye-slash');
             } else {
                 confirmPasswordInput.type = 'password';
                 icon.classList.remove('fa-eye-slash');
                 icon.classList.add('fa-eye');
             }
         });
 
         // Kiểm tra mật khẩu khớp nhau
         const form = document.querySelector('#changePasswordForm');
         const passwordInput = document.querySelector('#password');
         const confirmPasswordInput = document.querySelector('#password_confirmation');
         const mismatchError = document.querySelector('#passwordMismatchError');
         const submitButton = form.querySelector('button[type="submit"]');
 
         function checkPasswordMatch() {
             if (passwordInput.value !== confirmPasswordInput.value) {
                 mismatchError.style.display = 'block';
                 confirmPasswordInput.classList.add('is-invalid');
                 submitButton.disabled = true;
             } else {
                 mismatchError.style.display = 'none';
                 confirmPasswordInput.classList.remove('is-invalid');
                 submitButton.disabled = false;
             }
         }
 
         passwordInput.addEventListener('input', checkPasswordMatch);
         confirmPasswordInput.addEventListener('input', checkPasswordMatch);
 
         // Kiểm tra khi submit form
         form.addEventListener('submit', function (e) {
             if (passwordInput.value !== confirmPasswordInput.value) {
                 e.preventDefault();
                 mismatchError.style.display = 'block';
                 confirmPasswordInput.classList.add('is-invalid');
             }
         });
     </script>
 </body>
 </html>