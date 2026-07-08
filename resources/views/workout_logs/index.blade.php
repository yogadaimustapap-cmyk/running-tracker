<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivitas Olahraga - RunningTracker</title>
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
            max-width: 1250px;
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

        .btn-add {
            background: linear-gradient(135deg, var(--primary) 0%, #1d4ed8 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 700;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.35);
        }

        /* Alert styling */
        .alert-success {
            background-color: #f0fdf4;
            border: 1.5px solid #bbf7d0;
            color: #15803d;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* CRUD Table Container */
        .table-card {
            background-color: var(--card-bg);
            border-radius: 20px;
            box-shadow: var(--shadow);
            border: 1px solid #f1f5f9;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .logs-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .logs-table th {
            background-color: #f8fafc;
            color: var(--slate-800);
            padding: 1.2rem 1.5rem;
            font-weight: 700;
            font-size: 0.9rem;
            border-bottom: 1.5px solid #e2e8f0;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .logs-table td {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.95rem;
            color: #334155;
        }

        .logs-table tr:last-child td {
            border-bottom: none;
        }

        .logs-table tr:hover td {
            background-color: #fafcff;
        }

        .badge-type {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .badge-lari { background-color: #eff6ff; color: #2563eb; }
        .badge-jalan { background-color: #f0fdf4; color: #16a34a; }
        .badge-sepeda { background-color: #faf5ff; color: #9333ea; }
        .badge-berenang { background-color: #ecfeff; color: #0891b2; }
        .badge-lainnya { background-color: #fff7ed; color: #ea580c; }

        .actions-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-edit {
            background-color: #f1f5f9;
            color: #334155;
            padding: 0.45rem 0.9rem;
            font-size: 0.85rem;
            font-weight: 700;
            border-radius: 8px;
            text-decoration: none;
            transition: var(--transition);
            border: 1px solid #e2e8f0;
        }

        .btn-edit:hover {
            background-color: var(--primary-light);
            color: var(--primary);
            border-color: #bfdbfe;
        }

        .btn-delete {
            background-color: transparent;
            color: #ef4444;
            border: 1px solid #fca5a5;
            padding: 0.45rem 0.9rem;
            font-size: 0.85rem;
            font-weight: 700;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-delete:hover {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        /* Pagination custom wrapper styling */
        .pagination-container {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
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
            .btn-add {
                width: 100%;
                justify-content: center;
            }
            .logs-table th, .logs-table td {
                padding: 0.8rem 1rem;
                font-size: 0.85rem;
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
                    <a href="{{ route('workout-logs.index') }}" class="menu-item active">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H19M19 5V11M19 5L11 13L9 11L5 15"></path>
                        </svg>
                        Activity Log
                    </a>
                    <a href="#" class="menu-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path>
                        </svg>
                        Analytics
                    </a>
                    <a href="#" class="menu-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </a>
                    <a href="#" class="menu-item">
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
                    <h2 class="page-title">Aktivitas Olahraga</h2>
                    <a href="{{ route('workout-logs.create') }}" class="btn-add">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Catat Olahraga Baru
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert-success">
                        <!-- SVG Check Icon -->
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-card">
                    <table class="logs-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis Olahraga</th>
                                <th>Durasi</th>
                                <th>Jarak</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td style="font-weight: 600;">{{ \Carbon\Carbon::parse($log->workout_date)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge-type badge-{{ $log->workout_type == 'Jalan Cepat' ? 'jalan' : ($log->workout_type == 'Lari' ? 'lari' : ($log->workout_type == 'Bersepeda' ? 'sepeda' : ($log->workout_type == 'Berenang' ? 'berenang' : 'lainnya'))) }}">
                                            {{ $log->workout_type }}
                                        </span>
                                    </td>
                                    <td>{{ $log->duration }} menit</td>
                                    <td style="font-weight: 700; color: var(--primary);">{{ number_format($log->distance, 2) }} km</td>
                                    <td>{{ $log->notes ? Str::limit($log->notes, 40) : '-' }}</td>
                                    <td>
                                        <div class="actions-cell">
                                            <a href="{{ route('workout-logs.edit', $log->id) }}" class="btn-edit">Ubah</a>
                                            <form method="POST" action="{{ route('workout-logs.destroy', $log->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 3rem;">
                                        Belum ada aktivitas olahraga yang dicatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-container">
                    {{ $logs->links() }}
                </div>

            </div>
        </main>

    </div>

</body>
</html>
