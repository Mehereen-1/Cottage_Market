<!DOCTYPE html>
<html>
<head>
    <title>Login - Cottage Marketplace</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            background-color: #f8f9fa; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
        }
        .login-container { 
            background: white; 
            padding: 40px; 
            border-radius: 10px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
            width: 100%; 
            max-width: 400px; 
        }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
        input { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #ddd; 
            border-radius: 5px; 
            font-size: 16px; 
            box-sizing: border-box;
        }
        input:focus { border-color: #007bff; outline: none; }
        button { 
            width: 100%; 
            background-color: #007bff; 
            color: white; 
            padding: 12px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            font-size: 16px; 
            margin-bottom: 15px;
        }
        button:hover { background-color: #0056b3; }
        .error { color: red; margin-top: 5px; }
        .success { color: green; margin-top: 5px; }
        .demo-info {
            background-color: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .demo-info h4 { margin-top: 0; color: #0066cc; }
        .demo-info ul { margin: 10px 0; padding-left: 20px; }
        .demo-info li { margin: 5px 0; }
        .links { text-align: center; margin-top: 20px; }
        .links a { color: #007bff; text-decoration: none; margin: 0 10px; }
        .links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Login to Cottage Marketplace</h2>

        <div class="demo-info">
            <h4>Demo Accounts:</h4>
            <ul>
                <li><strong>Admin:</strong> admin@demo.com (password: password)</li>
                <li><strong>Seller:</strong> seller@demo.com (password: password)</li>
                <li><strong>Buyer:</strong> buyer@demo.com (password: password)</li>
            </ul>
        </div>

        @if ($errors->any())
            <div class="error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="links">
            <a href="{{ route('register') }}">Create Account</a>
            <a href="/">Back to Home</a>
        </div>
    </div>
</body>
</html>
