<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 900px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 32px;
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 16px;
        }

        .toggle-button-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            gap: 15px;
        }

        .toggle-btn {
            padding: 12px 28px;
            border: 2px solid #ddd;
            background: white;
            color: #333;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-btn:hover {
            border-color: #999;
            background: #f9f9f9;
        }

        .toggle-btn.active {
            border-color: #333;
            background: #333;
            color: white;
        }

        .content-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .form-section {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-section.hidden {
            display: none;
        }

        .form-section h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #666;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }

        .form-group input::placeholder {
            color: #999;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #333;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: #555;
        }

        .submit-btn:active {
            background: #222;
        }

        .error-box {
            background: #fee;
            border: 1px solid #fcc;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 20px;
        }

        .error-box ul {
            list-style: none;
            color: #c33;
            font-size: 14px;
        }

        .error-box li {
            margin-bottom: 5px;
        }

        .error-box li:last-child {
            margin-bottom: 0;
        }

        .success-box {
            background: #efe;
            border: 1px solid #cfc;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 20px;
            color: #3c3;
            font-size: 14px;
            font-weight: 500;
        }

        .divider {
            grid-column: 1 / -1;
            height: 1px;
            background: #eee;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                grid-template-columns: 1fr;
            }

            .divider {
                grid-column: 1;
                height: 1px;
                background: #eee;
            }

            .header h1 {
                font-size: 24px;
            }

            .form-section {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome</h1>
            <p>Manage your fitness goals and track your progress</p>
        </div>

        <div class="toggle-button-container">
            <button class="toggle-btn active" id="loginTabBtn" onclick="showForm('login')">Login</button>
            <button class="toggle-btn" id="registerTabBtn" onclick="showForm('register')">Create Account</button>
        </div>

        <div class="content-wrapper">
            <!-- Login Form -->
            <div class="form-section" id="loginForm">
                <h2>Sign In</h2>
                <form action="{{ route('login') }}" method="post">
                    @csrf

                    @if ($errors->any())
                        <div class="error-box">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                 
                    <div class="form-group">
                        <label for="email_login">Email Address</label>
                        <input type="email" id="email_login" name="email" required value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label for="password_login">Password</label>
                        <input type="password" id="password_login" name="password" required>
                    </div>

                    <button type="submit" class="submit-btn">Sign In</button>
                    @if (session('success'))
                        <div class="success-box">
                            {{ session('success') }}
                        </div>
                    @endif
                </form>
            </div>

            <div class="divider"></div>

            <!-- Registration Form -->
            <div class="form-section hidden" id="registerForm">
                <h2>Create Account</h2>
                <form action="{{ route('users.store') }}" method="post">
                    @csrf

                    

                    @if ($errors->any())
                        <div class="error-box">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="form-group">
                        <label for="idade">Age</label>
                        <input type="number" id="idade" name="idade" required value="{{ old('idade') }}">
                    </div>

                    <div class="form-group">
                        <label for="peso">Weight (kg)</label>
                        <input type="number" id="peso" name="peso" step="0.1" required value="{{ old('peso') }}">
                    </div>

                    <div class="form-group">
                        <label for="altura">Height (cm)</label>
                        <input type="number" id="altura" name="altura" required value="{{ old('altura') }}">
                    </div>

                    <div class="form-group">
                        <label for="sexo">Gender</label>
                        <select id="sexo" name="sexo" required>
                            <option value="">Select Gender</option>
                            <option value="M" {{ old('sexo') === 'M' ? 'selected' : '' }}>Male</option>
                            <option value="F" {{ old('sexo') === 'F' ? 'selected' : '' }}>Female</option>
                            <option value="O" {{ old('sexo') === 'O' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="objetivo_peso">Weight Goal (kg)</label>
                        <input type="number" id="objetivo_peso" name="objetivo_peso" step="0.1" required value="{{ old('objetivo_peso') }}">
                    </div>

                    <div class="form-group">
                        <label for="data_objetivo">Goal Date</label>
                        <input type="date" id="data_objetivo" name="data_objetivo" required value="{{ old('data_objetivo') }}">
                    </div>

                    <button type="submit" class="submit-btn">Create Account</button>
                </form>

                
            </div>

        </div>
    </div>

    <script>
        function showForm(formType) {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const loginTabBtn = document.getElementById('loginTabBtn');
            const registerTabBtn = document.getElementById('registerTabBtn');

            if (formType === 'login') {
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                loginTabBtn.classList.add('active');
                registerTabBtn.classList.remove('active');
            } else {
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                loginTabBtn.classList.remove('active');
                registerTabBtn.classList.add('active');
            }
        }
    </script>
</body>
</html>
</html>