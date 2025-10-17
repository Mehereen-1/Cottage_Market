<!DOCTYPE html>
<html>
<head>
    <title>Register - Cottage Marketplace</title>
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
        .register-container { 
            background: white; 
            padding: 40px; 
            border-radius: 10px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
            width: 100%; 
            max-width: 400px; 
        }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
        input, select { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #ddd; 
            border-radius: 5px; 
            font-size: 16px; 
            box-sizing: border-box;
        }
        input:focus, select:focus { border-color: #007bff; outline: none; }
        button { 
            width: 100%; 
            background-color: #28a745; 
            color: white; 
            padding: 12px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            font-size: 16px; 
            margin-bottom: 15px;
        }
        button:hover { background-color: #218838; }
        .error { color: red; margin-top: 5px; }
        .success { color: green; margin-top: 5px; }
        .role-info {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .role-info h4 { margin-top: 0; color: #856404; }
        .role-info ul { margin: 10px 0; padding-left: 20px; }
        .role-info li { margin: 5px 0; }
        .links { text-align: center; margin-top: 20px; }
        .links a { color: #007bff; text-decoration: none; margin: 0 10px; }
        .links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="register-container">
        <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Create Account</h2>

            <div class="role-info">
                <h4>Account Information:</h4>
                <p>All new accounts start as <strong>guests</strong> and can browse and purchase products. To become a seller, you can apply after registration through the seller application process.</p>
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

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit">Create Account</button>
        </form>

        <div class="links">
            <a href="{{ route('login') }}">Already have an account?</a>
            <a href="/">Back to Home</a>
        </div>
    </div>
</body>
</html>
