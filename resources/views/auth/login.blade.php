<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RunningTracker</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            --accent: #38bdf8;
            --accent-glow: rgba(56, 189, 248, 0.15);
            --dark-bg: #0f172a;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --border-focus: #3b82f6;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            --shadow-btn: 0 4px 14px 0 rgba(37, 99, 235, 0.4);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--dark-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        .split-container {
            display: flex;
            width: 100vw;
            height: 100vh;
            background-color: var(--card-bg);
        }

        /* Left Cover Section */
        .cover-section {
            flex: 1.2;
            position: relative;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.7) 100%), 
                        url('/images/running_hero_bg.png') no-repeat center center;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            color: #ffffff;
            overflow: hidden;
        }

        /* Add overlay glowing effect in left cover */
        .cover-section::after {
            content: '';
            position: absolute;
            top: -20%;
            left: -20%;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.15) 0%, transparent 70%);
            z-index: 1;
            pointer-events: none;
        }

        .brand-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 2;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.4);
            font-weight: 800;
            font-size: 1.25rem;
            color: white;
        }

        .brand-name {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            background: linear-gradient(to right, #ffffff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .cover-content {
            z-index: 2;
            max-width: 500px;
            margin-bottom: 2rem;
        }

        .cover-title {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 1.5rem;
            letter-spacing: -0.03em;
        }

        .cover-title span {
            background: linear-gradient(135deg, #60a5fa, #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .cover-description {
            font-size: 1.125rem;
            color: #94a3b8;
            line-height: 1.6;
        }

        .cover-footer {
            z-index: 2;
            font-size: 0.875rem;
            color: #64748b;
        }

        /* Right Form Section */
        .form-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            background-color: #ffffff;
            position: relative;
        }

        .form-container {
            width: 100%;
            max-width: 420px;
            zoom: 0.8;
        }

        .brand-container, .cover-content, .cover-footer {
            zoom: 0.8;
        }

        .form-header {
            margin-bottom: 2.25rem;
        }

        .form-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .form-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Inputs and Form elements */
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-left: 2.75rem;
            font-size: 0.95rem;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            outline: none;
            transition: var(--transition);
            background-color: #f8fafc;
            color: var(--text-main);
        }

        .form-input:focus {
            border-color: var(--border-focus);
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            width: 18px;
            height: 18px;
            pointer-events: none;
            transition: var(--transition);
        }

        .form-input:focus ~ .input-icon {
            color: var(--primary);
        }

        /* Utilities */
        .form-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
            font-size: 0.875rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        .remember-checkbox {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 1.5px solid var(--border-color);
            cursor: pointer;
            accent-color: var(--primary);
        }

        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .forgot-link:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, var(--primary) 0%, #1d4ed8 100%);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: var(--shadow-btn);
            transition: var(--transition);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px 0 rgba(37, 99, 235, 0.5);
            background: linear-gradient(135deg, #1d4ed8 0%, #172554 100%);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Social Button */
        .social-btn {
            width: 100%;
            padding: 0.75rem;
            border: 1.5px solid var(--border-color);
            background-color: #ffffff;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .social-btn:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.825rem;
            margin-bottom: 1.5rem;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-color);
        }

        .divider:not(:empty)::before {
            margin-right: .75em;
        }

        .divider:not(:empty)::after {
            margin-left: .75em;
        }

        /* Auth Redirect Link */
        .auth-redirect {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .auth-redirect a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            transition: var(--transition);
        }

        .auth-redirect a:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        /* Responsive Breakpoints */
        @media (max-width: 992px) {
            .cover-section {
                flex: 1;
                padding: 2.5rem;
            }
            .cover-title {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .cover-section {
                display: none;
            }
            .form-section {
                flex: 1;
                padding: 2rem;
            }
        }
    </style>
</head>
<body>

    <div class="split-container">
        <!-- Left Side - Aesthetic Branding -->
        <div class="cover-section">
            <div class="brand-container">
                <div class="brand-logo">R</div>
                <div class="brand-name">RunningTracker</div>
            </div>
            
            <div class="cover-content">
                <h1 class="cover-title">Elevate Your <span>Running Journey</span>.</h1>
                <p class="cover-description">Track real-time stats, design customized running plans, and share milestones with a vibrant, active community.</p>
            </div>
            
            <div class="cover-footer">
                &copy; 2026 RunningTracker Inc. All rights reserved.
            </div>
        </div>

        <!-- Right Side - Form Container -->
        <div class="form-section">
            <div class="form-container">
                <div class="form-header">
                    <h2 class="form-title">Welcome back</h2>
                    <p class="form-subtitle">Please enter your details to sign in</p>
                </div>

                <!-- Social Sign In -->
                <button type="button" class="social-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l3.66-2.85z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.85c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Continue with Google
                </button>

                <div class="divider">or sign in with email</div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email address</label>
                        <div class="input-wrapper">
                            <input type="email" id="email" name="email" class="form-input" placeholder="name@domain.com" value="{{ old('email') }}" required autocomplete="email">
                            <!-- SVG Mail Icon -->
                            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        @error('email')
                            <div style="color: #ef4444; font-size: 0.85rem; margin-top: 0.4rem; font-weight: 500;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                            <!-- SVG Lock Icon -->
                            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        @error('password')
                            <div style="color: #ef4444; font-size: 0.85rem; margin-top: 0.4rem; font-weight: 500;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <label class="remember-me">
                            <input type="checkbox" name="remember" class="remember-checkbox">
                            Remember me
                        </label>
                        <a href="#" class="forgot-link">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn-submit">
                        Sign In
                    </button>
                </form>

                <div class="auth-redirect">
                    Don't have an account? <a href="{{ route('register') }}">Sign up for free</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
