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
            --sidebar-bg: #ffffff;
            --sidebar-border: #e2e8f0;
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

        /* Dashboard Container Layout */
        .dashboard-container {
            display: flex;
            min-height: 125vh;
            width: 125vw;
            position: relative;
            zoom: 0.8;
        }

        /* Sidebar - Light Mode, Modern */
        .sidebar {
            width: 280px;
            background-color: var(--sidebar-bg);
            border-right: 1.5px solid var(--sidebar-border);
            padding: 2.5rem 1.75rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 50;
            transition: var(--transition);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 3rem;
            text-decoration: none;
        }

        .brand-logo {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.25rem;
            color: white;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
        }

        .brand-name {
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--slate-900);
        }

        /* Menu */
        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex-grow: 1;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.8rem 1.1rem;
            color: #475569;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 12px;
            transition: var(--transition);
        }

        .menu-item svg {
            width: 20px;
            height: 20px;
            color: #64748b;
            transition: var(--transition);
        }

        .menu-item:hover {
            background-color: #f1f5f9;
            color: var(--slate-900);
        }

        .menu-item:hover svg {
            color: var(--slate-900);
        }

        .menu-item.active {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .menu-item.active svg {
            color: var(--primary);
        }

        /* Footer Profile & Logout */
        .sidebar-footer {
            border-top: 1.5px solid var(--sidebar-border);
            padding-top: 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.05rem;
            border: 2px solid #dbeafe;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .username {
            font-weight: 700;
            font-size: 0.925rem;
            color: var(--slate-900);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .userrole {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .btn-logout {
            width: 100%;
            background-color: transparent;
            border: 1.5px solid #f87171;
            color: #ef4444;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            font-weight: 700;
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-logout:hover {
            background-color: #ef4444;
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
            border-color: #ef4444;
        }

        /* Main Content Section */
        .main-content {
            flex-grow: 1;
            margin-left: 280px;
            min-height: 125vh;
            background-color: #f8fafc;
            padding: 2.5rem;
            transition: var(--transition);
        }

        /* Content Wrapper - Zoom: 0.8 */
        .dashboard-wrapper {
            max-width: 1250px;
            margin: 0 auto;
        }

        .welcome-header {
            margin-bottom: 2.5rem;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--slate-900);
            margin-bottom: 0.4rem;
        }

        .welcome-title span {
            color: var(--primary);
        }

        .welcome-desc {
            color: var(--text-muted);
            font-size: 1.1rem;
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
            border-radius: 18px;
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
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--slate-900);
            line-height: 1.2;
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-top: 0.2rem;
        }

        /* Main Grid */
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
            margin-bottom: 1.75rem;
        }

        .section-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--slate-900);
            letter-spacing: -0.02em;
        }

        .btn-action {
            background: linear-gradient(135deg, var(--primary) 0%, #1d4ed8 100%);
            color: white;
            border: none;
            padding: 0.65rem 1.3rem;
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
            height: 270px;
            background: linear-gradient(180deg, #f8fafc 0%, #eff6ff 100%);
            border-radius: 14px;
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

        .run-meta-right {
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

        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
                width: 100%;
                min-height: auto;
                zoom: 1;
            }
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                border-right: none;
                border-bottom: 1.5px solid var(--sidebar-border);
                padding: 1.25rem 1.5rem;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
            .sidebar-brand {
                margin-bottom: 0;
            }
            .sidebar-menu {
                display: none; /* Hide vertical menu on tablet/mobile */
            }
            .sidebar-footer {
                border-top: none;
                padding-top: 0;
                flex-direction: row;
                align-items: center;
                gap: 1rem;
            }
            .user-profile {
                display: none; /* Hide profile summary on small screens footer */
            }
            .btn-logout {
                padding: 0.5rem 1rem;
            }
            .main-content {
                margin-left: 0;
                padding: 1.5rem;
                min-height: auto;
            }
            .dashboard-wrapper {
                zoom: 1; /* Reset zoom on mobile for readable text sizes */
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        
        <!-- Sidebar Navigation (Light Mode) -->
        <aside class="sidebar">
            <div>
                <a href="#" class="sidebar-brand">
                    <div class="brand-logo">R</div>
                    <span class="brand-name">RunningTracker</span>
                </a>
                
                <nav class="sidebar-menu">
                    <a href="{{ route('dashboard') }}" class="menu-item active">
                        <!-- Dashboard Icon -->
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('workout-logs.index') }}" class="menu-item">
                        <!-- Activity Icon -->
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H19M19 5V11M19 5L11 13L9 11L5 15"></path>
                        </svg>
                        Activity Log
                    </a>
                    <a href="#" class="menu-item">
                        <!-- Analytics Icon -->
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path>
                        </svg>
                        Analytics
                    </a>
                    <a href="#" class="menu-item">
                        <!-- Profile/User Icon -->
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </a>
                    <a href="#" class="menu-item">
                        <!-- Settings Icon -->
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Settings
                    </a>
                </nav>
            </div>
            
            <div class="sidebar-footer">
                <div class="user-profile">
                    <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div class="user-details">
                        <span class="username">{{ Auth::user()->name }}</span>
                        <span class="userrole">Runner Member</span>
                    </div>
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
        </aside>
        
        <!-- Main Content Area -->
        <main class="main-content">
            
            <!-- Dashboard Content Wrapper (with zoom: 0.8 for compact size) -->
            <div class="dashboard-wrapper">
                
                <!-- Welcome Header -->
                <div class="welcome-header">
                    <h2 class="welcome-title">Welcome back, <span>{{ explode(' ', Auth::user()->name)[0] }}</span>!</h2>
                    <p class="welcome-desc">Here is your activity overview for this week. Keep up the good work!</p>
                </div>

                <!-- Stats Overview Cards -->
                <section class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon-wrapper icon-blue">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">{{ $totalDistance }} km</span>
                            <span class="stat-label">Total Distance</span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon-wrapper icon-green">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">{{ $completedRuns }}</span>
                            <span class="stat-label">Completed Runs</span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon-wrapper icon-purple">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">{{ $averagePace }}</span>
                            <span class="stat-label">Average Pace /km</span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon-wrapper icon-orange">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">{{ $caloriesBurned }} kcal</span>
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
                            <button class="btn-action" onclick="window.location.href='{{ route('workout-logs.create') }}'">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Record New Run
                            </button>
                        </div>
                        
                        <div class="chart-placeholder">
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
                            @forelse($recentLogs as $log)
                                <div class="run-item" style="border-left-color: 
                                    @if($log->workout_type == 'Lari') #2563eb 
                                    @elseif($log->workout_type == 'Jalan Cepat') #10b981 
                                    @elseif($log->workout_type == 'Bersepeda') #a855f7 
                                    @elseif($log->workout_type == 'Berenang') #38bdf8 
                                    @else #f97316 @endif">
                                    <div class="run-details">
                                        <div class="run-date-badge">
                                            <p style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($log->workout_date)->format('d') }}</p>
                                            <p style="font-size: 0.6rem; font-weight: 500;">{{ strtoupper(\Carbon\Carbon::parse($log->workout_date)->format('M')) }}</p>
                                        </div>
                                        <div>
                                            <h4 class="run-title">{{ $log->workout_type }}</h4>
                                            <p class="run-meta">Durasi: {{ $log->duration }} menit @if($log->notes) • {{ Str::limit($log->notes, 25) }} @endif</p>
                                        </div>
                                    </div>
                                    <div class="run-meta-right">
                                        <p class="run-distance">{{ number_format($log->distance, 1) }} km</p>
                                        <p class="run-duration">{{ \Carbon\Carbon::parse($log->workout_date)->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; color: var(--text-muted); padding: 2rem;">
                                    Belum ada catatan olahraga.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </main>
        
    </div>

</body>
</html>
