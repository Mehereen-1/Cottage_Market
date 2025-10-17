<!DOCTYPE html>
<html>
<head>
    <title>Apply to Become a Seller</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f8f9fa; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
        input, textarea, select { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 5px; font-size: 16px; box-sizing: border-box; }
        input:focus, textarea:focus, select:focus { border-color: #007bff; outline: none; }
        button { background-color: #28a745; color: white; padding: 12px 24px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #218838; }
        .error { color: red; margin-top: 5px; }
        .success { color: green; margin-top: 5px; }
        .info-box { background-color: #e7f3ff; border: 1px solid #b3d9ff; border-radius: 5px; padding: 15px; margin-bottom: 20px; }
        .info-box h4 { margin-top: 0; color: #0066cc; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Apply to Become a Seller</h1>

        @guest
            <div class="error">
                <p>You must be logged in to apply as a seller. <a href="{{ route('login') }}">Login here</a></p>
            </div>
        @elseif(auth()->user()->role === 'student')
            <div class="success">
                <p>You are already approved as a seller! <a href="{{ route('products.index') }}">Manage your products</a></p>
            </div>
        @else
            <div class="info-box">
                <h4>Seller Application Information</h4>
                <p>As a seller, you can:</p>
                <ul>
                    <li>Create and manage your own products</li>
                    <li>Set your own prices and descriptions</li>
                    <li>Upload product images</li>
                    <li>Track your sales and earnings</li>
                </ul>
                <p><strong>Note:</strong> Your application will be reviewed by our admin team before approval.</p>
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

            <form method="POST" action="{{ route('apply.seller') }}">
                @csrf
                
                <div class="form-group">
                    <label for="message">Why do you want to become a seller?</label>
                    <textarea id="message" name="message" rows="4" placeholder="Tell us about your products, experience, or motivation to sell on our platform..." required>{{ old('message') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="commission_rate">Commission Rate (%)</label>
                    <select id="commission_rate" name="commission_rate" required>
                        <option value="">Select commission rate</option>
                        <option value="5" {{ old('commission_rate') == '5' ? 'selected' : '' }}>5%</option>
                        <option value="10" {{ old('commission_rate') == '10' ? 'selected' : '' }}>10%</option>
                        <option value="15" {{ old('commission_rate') == '15' ? 'selected' : '' }}>15%</option>
                        <option value="20" {{ old('commission_rate') == '20' ? 'selected' : '' }}>20%</option>
                    </select>
                    <small style="color: #666;">This is the percentage of each sale that goes to the platform.</small>
                </div>

                <button type="submit">Submit Application</button>
            </form>
        @endif

        <p style="margin-top: 30px;">
            <a href="/">← Back to Home</a>
        </p>
    </div>
</body>
</html>
