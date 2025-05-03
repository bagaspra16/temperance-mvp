<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Temperance') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Library for animations -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <!-- Styles -->
    <style>
        :root {
            --color-primary: #111827;
            --color-secondary: #1f2937;
            --color-dark-100: #374151;
            --color-dark-200: #282c34;
            --color-dark-300: #1e2227; 
            --color-accent: #ec4899;
            --color-accent-light: #f472b6;
            --color-accent-dark: #db2777;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #121212;
            color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before, body::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            opacity: 0.15;
            filter: blur(100px);
            z-index: -1;
        }
        
        body::before {
            background: var(--color-accent);
            top: -50px;
            left: -50px;
        }
        
        body::after {
            background: var(--color-accent-light);
            bottom: -50px;
            right: -50px;
        }
        
        .auth-container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(90deg, var(--color-accent), var(--color-accent-light));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }
        
        .tagline {
            color: rgba(229, 231, 235, 0.7);
            font-size: 1rem;
        }
        
        .auth-card {
            background-color: rgba(31, 41, 55, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: transform 0.3s ease;
        }
        
        .auth-card:hover {
            transform: translateY(-5px);
        }
        
        .auth-card h2 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: white;
            text-align: center;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 500;
            color: rgba(229, 231, 235, 0.9);
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            color: rgba(156, 163, 175, 0.7);
        }
        
        .form-input {
            width: 100%;
            background-color: rgba(17, 24, 39, 0.8);
            color: white;
            border: 1px solid rgba(75, 85, 99, 0.4);
            border-radius: 10px;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            border-color: var(--color-accent);
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
        }
        
        .form-input.error {
            border-color: #ef4444;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .custom-checkbox {
            position: relative;
            width: 18px;
            height: 18px;
            margin-right: 10px;
            cursor: pointer;
        }
        
        .custom-checkbox input {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            width: 18px;
            height: 18px;
            background-color: rgba(17, 24, 39, 0.8);
            border: 1px solid rgba(75, 85, 99, 0.4);
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        
        .custom-checkbox input:checked ~ .checkmark {
            background-color: var(--color-accent);
            border-color: var(--color-accent);
        }
        
        .checkmark:after {
            content: '';
            position: absolute;
            display: none;
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        
        .custom-checkbox input:checked ~ .checkmark:after {
            display: block;
        }
        
        .remember-me label {
            font-size: 0.95rem;
            color: rgba(229, 231, 235, 0.8);
            cursor: pointer;
        }
        
        .btn {
            width: 100%;
            background: linear-gradient(135deg, var(--color-accent), var(--color-accent-dark));
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            box-shadow: 0 4px 10px rgba(236, 72, 153, 0.3);
        }
        
        .btn:hover {
            background: linear-gradient(135deg, var(--color-accent-light), var(--color-accent));
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(236, 72, 153, 0.4);
        }
        
        .btn:active {
            transform: translateY(1px);
        }
        
        .auth-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
        }
        
        .auth-link {
            font-size: 0.875rem;
            color: var(--color-accent-light);
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .auth-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--color-accent-light);
            transition: width 0.3s ease;
        }
        
        .auth-link:hover::after {
            width: 100%;
        }
        
        /* Animation classes */
        .fade-up {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        
        .loaded .fade-up {
            opacity: 1;
            transform: translateY(0);
        }
        
        .decorative-circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.15;
            filter: blur(40px);
            z-index: -1;
            background: linear-gradient(135deg, var(--color-accent), var(--color-accent-light));
        }
        
        .circle-1 {
            width: 150px;
            height: 150px;
            top: 10%;
            left: 10%;
        }
        
        .circle-2 {
            width: 200px;
            height: 200px;
            bottom: 10%;
            right: 10%;
        }
    </style>
</head>
<body>
    <!-- Decorative elements -->
    <div class="decorative-circle circle-1"></div>
    <div class="decorative-circle circle-2"></div>
    
    <div class="auth-container">
        <div class="logo-container fade-up" data-aos="fade-up" data-aos-delay="100">
            <h1 class="logo">Temperance</h1>
            <p class="tagline">Self-Improvement Tracking</p>
        </div>

        <div class="auth-card fade-up" data-aos="fade-up" data-aos-delay="200">
            <h2>Sign In</h2>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <i class="input-icon fas fa-envelope"></i>
                        <input id="email" type="email" class="form-input @error('email') error @enderror" 
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="input-icon fas fa-lock"></i>
                        <input id="password" type="password" class="form-input @error('password') error @enderror" 
                               name="password" required autocomplete="current-password">
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-me">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                    </label>
                    <label for="remember">Remember Me</label>
                </div>

                <button type="submit" class="btn">
                    Sign In
                </button>

                <div class="auth-links">
                    @if (Route::has('password.request'))
                        <a class="auth-link" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif

                    <a class="auth-link" href="{{ route('register') }}">
                        Create Account
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        // Initialize AOS animations
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-out',
                once: true
            });
            
            // Add loaded class to body to trigger animations
            setTimeout(() => {
                document.body.classList.add('loaded');
            }, 100);
            
            // Add focus and active effects for inputs
            const inputs = document.querySelectorAll('.form-input');
            
            inputs.forEach(input => {
                // Change icon color on focus
                input.addEventListener('focus', function() {
                    const icon = this.previousElementSibling;
                    if (icon) icon.style.color = 'var(--color-accent)';
                });
                
                input.addEventListener('blur', function() {
                    const icon = this.previousElementSibling;
                    if (icon) icon.style.color = 'rgba(156, 163, 175, 0.7)';
                });
            });
        });
    </script>
</body>
</html>
