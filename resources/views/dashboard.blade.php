<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - RunningTracker</title>
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
            --dark-bg: #0f172a;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
            --card-bg: #ffffff;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: var(--text-main);
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            background-color: var(--dark-bg);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .brand-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.1rem;
            color: white;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.3);
        }

        .brand-name {
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            background: linear-gradient(to right, #ffffff, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.95rem;
            color: white;
        }

        .user-role {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        .btn-logout {
            background-color: transparent;
            border: 1.5px solid #ef4444;
            color: #ef4444;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-logout:hover {
            background-color: #ef4444;
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        /* Dashboard Wrapper (Applying zoom here to keep layout full screen but contents compact) */
        .dashboard-wrapper {
            padding: 2.5rem;
            max-width: 1400px;
            margin: 0 auto;
            zoom: 0.8;
        }

        .welcome-header {
            margin-bottom: 2.5rem;
        }

        .welcome-title {
            font-size: 2.25rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            color: var(--slate-900);
            margin-bottom: 0.5rem;
        }

        .welcome-title span {
            color: var(--primary);
        }

        .welcome-desc {
            color: var(--text-muted);
            font-size: 1.05rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            border: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08);
        }

        .stat-icon-wrapper {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-blue {
            background-color: #eff6ff;
            color: #3b82f6;
        }

        .icon-green {
            background-color: #f0fdf4;
            color: #22c55e;
        }

        .icon-purple {
            background-color: #faf5ff;
            color: #a855f7;
        }

        .icon-orange {
            background-color: #fff7ed;
            color: #f97316;
        }

        .stat-info {
            display: flex;
            flex-direction: column;
        }

        .stat-value {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--slate-900);
            line-height: 1.2;
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 0.2rem;
        }

        /* Main Grid (2 Columns: Charts/Actions & Recent Activity) */
        .main-grid {
            display: grid;
            grid-template-columns: 1.8fr 1.2fr;
            gap: 2rem;
        }

        .section-card {
            background-color: var(--card-bg);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid #f1f5f9;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--slate-900);
        }

        .btn-action {
            background: linear-gradient(135deg, var(--primary) 0%, #1d4ed8 100%);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
            font-weight: 700;
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
        }

        /* Chart mock/Visual illustration */
        .chart-placeholder {
            height: 250px;
            background: linear-gradient(180deg, #f8fafc 0%, #eff6ff 100%);
            border-radius: 12px;
            border: 1.5px dashed #cbd5e1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: var(--text-muted);
            gap: 0.75rem;
        }

        .chart-icon {
            color: var(--primary);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.05); opacity: 1; }
            100% { transform: scale(1); opacity: 0.8; }
        }

        /* Runs Table/List */
        .runs-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .run-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background-color: #f8fafc;
            border-radius: 12px;
            border-left: 4px solid var(--primary);
            transition: var(--transition);
        }

        .run-item:hover {
            transform: translateX(4px);
            background-color: #eff6ff;
        }

        .run-details {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .run-date-badge {
            background-color: #e2e8f0;
            color: var(--slate-800);
            padding: 0.4rem 0.6rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            text-align: center;
            min-width: 60px;
        }

        .run-title {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--slate-900);
        }

        .run-meta {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.15rem;
        }

        .run-stats-right {
            text-align: right;
        }

        .run-distance {
            font-weight: 700;
            color: var(--primary);
            font-size: 1rem;
        }

        .run-duration {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.15rem;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .main-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .navbar {
                padding: 1rem;
            }
            .dashboard-wrapper {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header class="navbar">
        <div class="brand-container">
            <div class="brand-logo">R</div>
            <h1 class="brand-name">RunningTracker</h1>
        </div>
        <div class="nav-user">
            <div class="user-info">
                <p class="user-name">{{ Auth::user()->name }}</p>
                <p class="user-role">Runner Member</p>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <!-- SVG Signout Icon -->
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="dashboard-wrapper">
        
        <!-- Welcome Header -->
        <div class="welcome-header">
            <h2 class="welcome-title">Welcome back, <span>{{ explode(' ', Auth::user()->name)[0] }}</span>!</h2>
            <p class="welcome-desc">Here is your activity overview for this week. Keep up the good work!</p>
        </div>

        <!-- Stats Overview Cards -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon-wrapper icon-blue">
                    <!-- SVG Runner Icon -->
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="stat-info">
                    <span class="stat-value">34.2 km</span>
                    <span class="stat-label">Total Distance</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-wrapper icon-green">
                    <!-- SVG Checked Calendar -->
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <div class="stat-info">
                    <span class="stat-value">8</span>
                    <span class="stat-label">Completed Runs</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-wrapper icon-purple">
                    <!-- SVG Clock / Timer -->
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-info">
                    <span class="stat-value">5'24"</span>
                    <span class="stat-label">Average Pace /km</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-wrapper icon-orange">
                    <!-- SVG Fire -->
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div class="stat-info">
                    <span class="stat-value">2,850 kcal</span>
                    <span class="stat-label">Calories Burned</span>
                </div>
            </div>
        </section>

        <!-- Main Dashboard Details Grid -->
        <div class="main-grid">
            
            <!-- Left Panel: Weekly Performance Chart -->
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title">Weekly Activity Analysis</h3>
                    <button class="btn-action">
                        <!-- SVG Plus -->
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Record New Run
                    </button>
                </div>
                
                <div class="chart-placeholder">
                    <!-- Mock chart graphics with CSS SVG -->
                    <svg class="chart-icon" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path>
                    </svg>
                    <p style="font-weight: 600;">Activity chart visualization is ready</p>
                    <p style="font-size: 0.8rem;">Data tracking will update automatically as runs are recorded.</p>
                </div>
            </div>

            <!-- Right Panel: Recent Activity -->
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title">Recent Running History</h3>
                </div>
                
                <div class="runs-list">
                    <div class="run-item">
                        <div class="run-details">
                            <div class="run-date-badge">
                                <p style="font-size: 0.9rem;">08</p>
                                <p style="font-size: 0.6rem; font-weight: 500;">JUL</p>
                            </div>
                            <div>
                                <h4 class="run-title">Morning Interval Run</h4>
                                <p class="run-meta">Pace: 5'15" • Cal: 420 kcal</p>
                            </div>
                        </div>
                        <div class="run-meta-right">
                            <p class="run-distance">5.2 km</p>
                            <p class="run-duration">27m 18s</p>
                        </div>
                    </div>

                    <div class="run-item" style="border-left-color: #10b981;">
                        <div class="run-details">
                            <div class="run-date-badge">
                                <p style="font-size: 0.9rem;">06</p>
                                <p style="font-size: 0.6rem; font-weight: 500;">JUL</p>
                            </div>
                            <div>
                                <h4 class="run-title">Evening Casual Jog</h4>
                                <p class="run-meta">Pace: 5'40" • Cal: 610 kcal</p>
                            </div>
                        </div>
                        <div class="run-meta-right">
                            <p class="run-distance">8.0 km</p>
                            <p class="run-duration">45m 20s</p>
                        </div>
                    </div>

                    <div class="run-item" style="border-left-color: #a855f7;">
                        <div class="run-details">
                            <div class="run-date-badge">
                                <p style="font-size: 0.9rem;">03</p>
                                <p style="font-size: 0.6rem; font-weight: 500;">JUL</p>
                            </div>
                            <div>
                                <h4 class="run-title">Weekend Endurance Run</h4>
                                <p class="run-meta">Pace: 5'32" • Cal: 1,120 kcal</p>
                            </div>
                        </div>
                        <div class="run-meta-right">
                            <p class="run-distance">15.0 km</p>
                            <p class="run-duration">1h 23m</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

</body>
</html>
