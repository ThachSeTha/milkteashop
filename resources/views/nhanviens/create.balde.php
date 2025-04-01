<!DOCTYPE html>
 <html lang="vi">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Thêm nhân viên</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
     <style>
         body {
             font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
             background: linear-gradient(135deg, #6dd5ed, #2193b0);
             display: flex;
             justify-content: center;
             align-items: center;
             min-height: 100vh;
             margin: 0;
             color: #333;
           
         }
 
         .form-container {
             background-color: rgba(255, 255, 255, 0.9);
             padding: 10px;
             border-radius: 8px;
             box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
             width: 90%; /* Chiếm 90% chiều rộng màn hình */
             max-width: 600px; /* Chiều rộng tối đa là 600px */
         }
 
         h1 {
             text-align: center;
             color: #2193b0;
             margin-bottom: 15px;
         }
 
         .form-group {
             margin-bottom: 15px;
         }
 
         label {
             display: block;
             margin-bottom: 5px;
             color: #555;
         }
 
         input, select {
             width: calc(100% - 22px);
             padding: 8px;
             border: 1px solid #ddd;
             border-radius: 4px;
             box-sizing: border-box;
             transition: border-color 0.3s;
         }
 
         input:focus, select:focus {
             border-color: #2193b0;
             outline: none;
         }
 
         button {
             background-color: #2193b0;
             color: white;
             padding: 12px 20px;
             border: none;
             border-radius: 4px;
             cursor: pointer;
             width: 100%;
             transition: background-color 0.3s;
         }
 
         button:hover {
             background-color: #1a7e96;
         }
 
         .error-message {
             color: #d32f2f;
             margin-bottom: 15px;
         }
 
         .error-message ul {
             list-style-type: none;
             padding: 0;
         }
 
         .error-message li {
             margin-bottom: 5px;
         }
 
         .back-link {
             display: block;
             text-align: center;
             margin-top: 20px;
             color: #2193b0;
             text-decoration: none;
         }
 
         .back-link:hover {
             text-decoration: underline;
         }
 
         .icon {
             margin-right: 8px;
         }
 
         /* Thêm responsive design */
         @media (max-width: 600px) {
             .form-container {
                 padding: 20px;
             }
         }
     </style>
 </head>
 <body>
     <div class="form-container">
         <h1><i class="fas fa-user-plus icon"></i> Thêm nhân viên</h1>
 
         @if ($errors->any())
             <div class="error-message">
                 <ul>
                     @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                     @endforeach
                 </ul>
             </div>
         @endif
 
         <form action="{{ route('nhanviens.store') }}" method="POST">
             @csrf
             <div class="form-group">
                 <label for="ho_ten"><i class="fas fa-user icon"></i> Họ tên:</label>
                 <input type="text" id="ho_ten" name="ho_ten" required>
             </div>
             <div class="form-group">
                 <label for="email"><i class="fas fa-envelope icon"></i> Email:</label>
                 <input type="email" id="email" name="email" required>
             </div>
             <div class="form-group">
                 <label for="mat_khau"><i class="fas fa-lock icon"></i> Mật khẩu:</label>
                 <input type="password" id="mat_khau" name="mat_khau" required>
             </div>
             <div class="form-group">
                 <label for="so_dien_thoai"><i class="fas fa-phone icon"></i> Số điện thoại:</label>
                 <input type="text" id="so_dien_thoai" name="so_dien_thoai" required>
             </div>
             <div class="form-group">
                 <label for="chuc_vu"><i class="fas fa-briefcase icon"></i> Chức vụ:</label>
                 <select id="chuc_vu" name="chuc_vu">
                     @foreach ($chucVus as $chucVu)
                         <option value="{{ $chucVu->id }}">{{ $chucVu->ten_chuc_vu }}</option>
                     @endforeach
                 </select>
             </div>
             <div class="form-group">
                 <label for="dia_chi"><i class="fas fa-map-marker-alt icon"></i> Địa chỉ:</label>
                 <input type="text" id="dia_chi" name="dia_chi" required>
             </div>
             <button type="submit"><i class="fas fa-save icon"></i> Thêm</button>
         </form>
         <a href="{{ route('nhanviens.index') }}" class="back-link"><i class="fas fa-arrow-left icon"></i> Quay lại</a>
     </div>
 </body>
 </html>