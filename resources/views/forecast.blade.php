<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prakiraan Cuaca - RunningTracker</title>
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

        /* Content Wrapper */
        .dashboard-wrapper {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .page-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--slate-900);
            letter-spacing: -0.03em;
        }

        .city-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background-color: var(--primary-light);
            color: var(--primary);
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.95rem;
        }

        /* New Forecast Side-by-Side Layout */
        .forecast-layout {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 2rem;
            align-items: start;
        }

        /* Left Panel: Summary */
        .forecast-summary-panel {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .forecast-summary-card {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            color: white;
            text-align: center;
            box-shadow: 0 20px 25px -5px rgba(30, 58, 138, 0.15), 0 10px 10px -5px rgba(30, 58, 138, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .giant-icon {
            font-size: 5rem;
            display: block;
            margin-bottom: 1rem;
            line-height: 1;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }

        .giant-temp {
            font-size: 3.5rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .summary-cond {
            font-size: 1.25rem;
            font-weight: 700;
            opacity: 0.9;
            margin-bottom: 0.25rem;
        }

        .summary-desc {
            font-size: 0.85rem;
            opacity: 0.7;
            font-weight: 500;
            line-height: 1.4;
        }

        /* Safety Recommendation Alert card */
        .forecast-indicator-card {
            background-color: var(--card-bg);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            border: 1px solid #f1f5f9;
            position: relative;
            overflow: hidden;
        }

        .forecast-indicator-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
        }

        .forecast-indicator-card.safe-alert::before {
            background-color: #10b981;
        }

        .forecast-indicator-card.unsafe-alert::before {
            background-color: #ef4444;
        }

        .indicator-headline {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--slate-900);
            margin-bottom: 0.5rem;
        }

        .indicator-subtext {
            font-size: 0.85rem;
            color: #475569;
            line-height: 1.5;
            font-weight: 500;
        }

        /* Right Panel: Forecast Timeline */
        .forecast-timeline-panel {
            background-color: var(--card-bg);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: var(--shadow);
            border: 1px solid #f1f5f9;
        }

        .timeline-headline {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--slate-900);
            margin-bottom: 2rem;
            border-bottom: 1.5px solid #f1f5f9;
            padding-bottom: 1rem;
        }

        .forecast-timeline-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .timeline-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.1rem 1.5rem;
            background-color: #f8fafc;
            border-radius: 16px;
            border: 1px solid #f1f5f9;
            transition: var(--transition);
        }

        .timeline-row:hover {
            transform: translateX(5px);
            background-color: #fafcff;
            border-color: var(--primary-light);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.05);
        }

        .row-time {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--slate-900);
            width: 80px;
        }

        .row-condition {
            display: flex;
            align-items: center;
            gap: 1rem;
            width: 180px;
        }

        .row-icon {
            font-size: 1.75rem;
        }

        .row-text {
            font-weight: 700;
            font-size: 0.95rem;
            color: #475569;
        }

        .row-status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            text-align: center;
            width: 100px;
        }

        .row-status-badge.badge-green {
            background-color: #ecfdf5;
            color: #059669;
        }

        .row-status-badge.badge-red {
            background-color: #fef2f2;
            color: #dc2626;
        }

        .row-temp {
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--primary);
            width: 60px;
            text-align: right;
        }

        /* Responsive Breakpoints */
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
            .sidebar-menu {
                display: none;
            }
            .sidebar-footer {
                border-top: none;
                padding-top: 0;
                flex-direction: row;
                align-items: center;
            }
            .user-profile {
                display: none;
            }
            .main-content {
                margin-left: 0;
                padding: 1.5rem;
            }
            .header-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            .city-badge {
                width: 100%;
                justify-content: center;
            }
            .forecast-layout {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            .timeline-row {
                padding: 0.8rem 1rem;
                gap: 0.5rem;
            }
            .row-time {
                font-size: 0.95rem;
                width: 60px;
            }
            .row-condition {
                width: auto;
                flex-grow: 1;
                gap: 0.5rem;
            }
            .row-icon {
                font-size: 1.5rem;
            }
            .row-text {
                font-size: 0.85rem;
            }
            .row-status-badge {
                width: 80px;
                font-size: 0.7rem;
                padding: 0.25rem 0.5rem;
            }
            .row-temp {
                font-size: 1.15rem;
                width: auto;
            }
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        
        <!-- Sidebar Navigation (Light Mode) -->
        <aside class="sidebar">
            <div>
                <a href="{{ route('dashboard') }}" class="sidebar-brand">
                    <div class="brand-logo">R</div>
                    <span class="brand-name">RunningTracker</span>
                </a>
                
                <nav class="sidebar-menu">
                    <a href="{{ route('dashboard') }}" class="menu-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('workout-logs.index') }}" class="menu-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H19M19 5V11M19 5L11 13L9 11L5 15"></path>
                        </svg>
                        Log Aktivitas
                    </a>
                    <a href="{{ route('weather.forecast') }}" class="menu-item active">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path>
                        </svg>
                        Prakiraan Cuaca
                    </a>

                    <a href="{{ route('weather.settings') }}" class="menu-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Pengaturan
                    </a>
                </nav>
            </div>
            
            <div class="sidebar-footer">
                <div class="user-profile">
                    <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div class="user-details">
                        <span class="username">{{ Auth::user()->name }}</span>
                        <span class="userrole">Anggota Pelari</span>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
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
            <div class="dashboard-wrapper">
                
                <div class="header-section">
                    <h2 class="page-title">Prakiraan Cuaca per Jam</h2>
                    <div class="city-badge">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        📍 {{ $weather['city'] }}
                    </div>
                </div>

                <div class="forecast-layout">
                    <!-- Left Panel: Summary Info -->
                    <div class="forecast-summary-panel">
                        <div class="forecast-summary-card">
                            <span class="giant-icon">{{ $weather['icon'] }}</span>
                            <h3 class="giant-temp">{{ $weather['temp'] }}°C</h3>
                            <p class="summary-cond">{{ $weather['condition'] }}</p>
                            <p class="summary-desc">{{ $weather['description'] }}</p>
                        </div>

                        <div class="forecast-indicator-card @if($weather['is_safe']) safe-alert @else unsafe-alert @endif">
                            <h4 class="indicator-headline">
                                @if($weather['is_safe'])
                                    🟢 Rekomendasi: Aman untuk Lari
                                @else
                                    🔴 Rekomendasi: Hindari Lari
                                @endif
                            </h4>
                            <p class="indicator-subtext">
                                @if($weather['is_safe'])
                                    Semua parameter cuaca ideal. Gunakan kesempatan ini untuk berlatih di luar ruangan!
                                @else
                                    Cuaca kurang bersahabat. Faktor penghalang: <strong>{{ implode(', ', $weather['reasons']) }}</strong>. Lebih disarankan berlatih secara indoor.
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Right Panel: Chronological Timeline -->
                    <div class="forecast-timeline-panel">
                        <h3 class="timeline-headline">Prakiraan Cuaca Per Jam</h3>
                        <div class="forecast-timeline-list">
                            @foreach($weather['forecast'] as $item)
                                <div class="timeline-row">
                                    <div class="row-time">{{ $item['time'] }}</div>
                                    <div class="row-condition">
                                        <span class="row-icon">{{ $item['icon'] }}</span>
                                        <span class="row-text">{{ $item['condition'] }}</span>
                                    </div>
                                    
                                    <div class="row-status-badge @if($item['condition'] === 'Hujan' || $item['condition'] === 'Badai' || $item['condition'] === 'Gerimis') badge-red @else badge-green @endif">
                                        @if($item['condition'] === 'Hujan' || $item['condition'] === 'Badai' || $item['condition'] === 'Gerimis')
                                            Indoor saja
                                        @else
                                            Bisa lari
                                        @endif
                                    </div>

                                    <div class="row-temp">{{ $item['temp'] }}°C</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </main>

    </div>

</body>
</html>
