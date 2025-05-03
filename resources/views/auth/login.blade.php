<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oke Toys - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #D5E0FF;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        
        .login-container {
            width: 100%;
            max-width: 430px;
            margin: 15px;
        }
        
        .login-box {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);
        }
        
        .login-header {
            background-color: #2C3245;
            color: white;
            padding: 15px 20px;
            text-align: center;
        }
        
        .login-body {
            padding: 24px;
            background-color: #E4EBFF;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            color: #4a5568;
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #8EABFF;
            border-radius: 8px;
            display: block;
            color: #4a5568;
        }
        
        .login-button {
            display: block;
            width: auto;
            margin: 24px auto 0;
            background-color: #3B4B7A;
            color: white;
            border: none;
            padding: 0.5rem 3rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.3);
        }
        
        .login-button:hover {
            background-color: #1e293b;
        }
        
        .error-message {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 16px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h2>Login Page</h2>
            </div>
            
            <div class="login-body">
                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="error-message">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" class="login-button">Login</button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>