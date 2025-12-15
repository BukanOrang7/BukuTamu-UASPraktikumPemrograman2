<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Buku Tamu' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f3f4f6;
            font-family: 'Inter', sans-serif;
            transition: background .3s, color .3s;
        }
        body.dark { background:#0f172a; color:#e5e7eb; }

        /* HEADER */
        .app-header {
            position: fixed;
            top: 0; left: 0;
            height: 60px; width: 100%;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            padding: 0 20px;
            z-index: 1000;
        }
        body.dark .app-header {
            background: rgba(31,41,55,0.8);
        }

        .hamburger {
            font-size: 26px;
            cursor: pointer;
            margin-right: 20px;
            padding: 4px 10px;
            border-radius: 6px;
            transition: background .2s;
        }
        .hamburger:hover { background: rgba(0,0,0,0.08); }
        body.dark .hamburger:hover { background: rgba(255,255,255,0.08); }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 260px;
            height: 100vh;
            background: rgba(255,255,255,0.6);
            backdrop-filter: blur(18px);
            border-right: 1px solid rgba(0,0,0,0.08);
            transform: translateX(-280px);
            transition: .35s ease;
            padding-top: 75px;
            z-index: 1200;
            box-shadow: 4px 0 18px rgba(0,0,0,0.08);
        }
        body.dark .sidebar {
            background: rgba(30,41,59,0.6);
            border-right: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar.open { transform: translateX(0); }

        .sidebar h5 {
            padding: 0 20px;
            margin-bottom: 10px;
            font-weight: 600;
            opacity: .7;
            font-size: .92rem;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 22px;
            color: #1f2937;
            text-decoration: none;
            border-radius: 10px;
            margin: 4px 12px;
            transition: .25s ease;
        }
        .menu-item i { font-size: 18px; opacity: .85; }

        .menu-item:hover {
            background: rgba(100,120,255,0.12);
            transform: translateX(6px);
            box-shadow: 0 3px 10px rgba(100,120,255,0.15);
        }

        .active-menu {
            background: linear-gradient(135deg,#6b8cff,#60cdff);
            color:white!important;
            box-shadow: 0 4px 12px rgba(90,140,255,0.3);
        }
        .active-menu i { color:white; opacity:1; }

        body.dark .menu-item { color:#e5e7eb; }
        body.dark .menu-item:hover { background: rgba(255,255,255,0.08); }

        /* OVERLAY */
        .overlay {
            position: fixed;
            top:0; left:0;
            width:100%; height:100%;
            background: rgba(0,0,0,0.45);
            display:none;
            z-index:1100;
        }
        .overlay.show { display:block; }

        /* CONTENT */
        .app-content {
            padding: 90px 40px;
        }

        /* Global action button used across pages */
        .action-btn { display:inline-flex; align-items:center; justify-content:center; gap:8px; height:40px; min-width:110px; padding:8px 12px; border-radius:10px; font-weight:700; border:none; cursor:pointer; text-decoration:none; }
        a.action-btn { text-decoration:none !important; }
        .action-btn:focus { outline: none; box-shadow: 0 0 0 3px rgba(59,130,246,0.12); }

        /* make sure small links in tables and pagination don't show underlines */
        .dataTables_wrapper a { text-decoration: none !important; }

        /* DARK MODE TOGGLE */
        .theme-toggle {
            margin-left:auto;
            cursor:pointer;
            font-size:20px;
            padding: 6px 10px;
            border-radius: 6px;
            transition:.2s;
        }
        .theme-toggle:hover { background:rgba(0,0,0,0.1); }
        body.dark .theme-toggle:hover { background:rgba(255,255,255,0.1); }

        @media (max-width: 768px) {
            .app-content { padding: 80px 12px; }
            .app-header { height:56px; padding: 0 12px; }
            .hamburger { margin-right: 8px; }
            .sidebar { width: 220px; }
        }

    </style>
</head>

<body class="{{ session('theme','light') === 'dark' ? 'dark' : '' }}">

<div id="overlay" class="overlay"></div>

<header class="app-header">
    <div id="hamburgerBtn" class="hamburger">
        <i class="bi bi-list"></i>
    </div>

    <h4 class="m-0">{{ $title ?? 'Buku Tamu' }}</h4>

    <div id="themeToggle" class="theme-toggle">
        <i class="bi bi-moon-stars"></i>
    </div>
</header>

<!-- SIDEBAR -->
<aside id="sidebar" class="sidebar">

    <h5>Menu Utama</h5>
    <a href="{{ route('event.index') }}" class="menu-item {{ request()->routeIs('event.index') ? 'active-menu' : '' }}">
        <i class="bi bi-collection"></i> Semua Event
    </a>

    <a href="{{ route('event.create') }}" class="menu-item {{ request()->routeIs('event.create') ? 'active-menu' : '' }}">
        <i class="bi bi-plus-circle"></i> Buat Event
    </a>

    @isset($allEvents)
    <h5 class="mt-3">Event Lainnya</h5>
    @foreach($allEvents as $ev)
        <a href="{{ route('tamu.index', $ev->id) }}"
           class="menu-item {{ isset($event) && $event->id == $ev->id ? 'active-menu' : '' }}">
            <i class="bi bi-calendar-event"></i>{{ $ev->nama_acara }}
        </a>
    @endforeach
    @endisset

    @isset($event)
    <h5 class="mt-3">Tools Event</h5>
    <a href="{{ route('tamu.rekap',$event->id) }}" class="menu-item">
        <i class="bi bi-clipboard-data"></i> Rekap Kehadiran
    </a>
    <a href="{{ route('tamu.export',$event->id) }}" class="menu-item">
        <i class="bi bi-download"></i> Unduh Data Tamu
    </a>
    @endisset

</aside>

<main class="app-content">
    @yield('content')
</main>

<script>
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const hamburger = document.getElementById('hamburgerBtn');
const themeBtn = document.getElementById('themeToggle');

/* OPEN SIDEBAR */
hamburger.onclick = () => {
    sidebar.classList.add('open');
    overlay.classList.add('show');
};

/* CLOSE SIDEBAR */
overlay.onclick = () => {
    sidebar.classList.remove('open');
    overlay.classList.remove('show');
};

/* DARK MODE */
function updateThemeIcon(){
    const i = themeBtn.querySelector('i');
    if(document.body.classList.contains('dark')){
        i.className = 'bi bi-sun-fill';
    } else {
        i.className = 'bi bi-moon-stars';
    }
}

// make icon correct on load
updateThemeIcon();

themeBtn.onclick = () => {
    // optimistic toggle for immediate feedback
    document.body.classList.toggle('dark');
    updateThemeIcon();

    fetch('/toggle-theme', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").content,
            'Accept': 'application/json'
        }
    }).then(resp => {
        if(!resp.ok) throw new Error('Failed to persist theme');
        return resp.json();
    }).then(data => {
        // in case server returned a different state, ensure UI matches
        if(data.theme === 'dark'){
            document.body.classList.add('dark');
        } else {
            document.body.classList.remove('dark');
        }
        updateThemeIcon();
    }).catch(err => {
        // revert optimistic change on error
        document.body.classList.toggle('dark');
        updateThemeIcon();
        console.error('Theme toggle failed', err);
    });
};
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
