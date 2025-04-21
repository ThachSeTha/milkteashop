<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - MilkTeaShop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fab7b7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h1 {
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .message {
            color: #28a745;
            margin-bottom: 1rem;
        }
        .error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }
        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }
        label {
            display: block;
            font-size: 0.875rem;
            color: #555;
            margin-bottom: 0.5rem;
        }
        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }
        button {
            background-color: #007bff;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Xác Nhận OTP</h1>
        @if (session('message'))
            <p class="message">{{ session('message') }}</p>
        @endif
        <form method="POST" action="{{ route('verify.otp') }}">
            @csrf
            <div class="form-group">
                <label for="otp">Nhập mã OTP</label>
                <input id="otp" type="text" name="otp" required autofocus />
                @error('otp')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit">Xác nhận</button>
        </form>
    </div>
</body>
</html>