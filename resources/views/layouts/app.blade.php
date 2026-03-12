<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SEPIA — @yield('title', 'Multi-Agent AI Platform')</title>

  {{-- Google Fonts --}}
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Mono:wght@300;400;500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />

  {{-- Global CSS --}}
  <link rel="stylesheet" href="{{ asset('css/sepia.css') }}" />

  <style>
    /* ─── CSS VARIABLES ──────────────────────────────── */
    :root {
      --green-900: #0a2e1a;
      --green-800: #0f3d24;
      --green-700: #155232;
      --green-600: #1a6640;
      --green-500: #1f7a4d;
      --green-400: #2a9d65;
      --green-300: #4db882;
      --green-200: #86d4aa;
      --green-100: #c2ecd5;
      --green-50:  #eaf7f0;

      --white:     #ffffff;
      --off-white: #f7faf8;
      --cream:     #f0f6f2;

      --text-primary:   #0a2e1a;
      --text-secondary: #2d6647;
      --text-muted:     #6aaa88;

      --border:    rgba(26, 102, 64, 0.15);
      --border-md: rgba(26, 102, 64, 0.25);

      --shadow-sm: 0 1px 4px rgba(10, 46, 26, 0.06);
      --shadow-md: 0 4px 24px rgba(10, 46, 26, 0.10);
      --shadow-lg: 0 12px 48px rgba(10, 46, 26, 0.14);

      --radius-sm: 6px;
      --radius-md: 12px;
      --radius-lg: 20px;

      --header-h: 64px;
      --transition: 0.22s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ─── RESET ─────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html {
      font-size: 16px;
      -webkit-font-smoothing: antialiased;
      scroll-behavior: smooth;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      font-weight: 400;
      background-color: var(--off-white);
      color: var(--text-primary);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      position: relative;
      overflow-x: hidden;
    }

    /* ─── SUBTLE BACKGROUND PATTERN ─────────────────── */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        radial-gradient(circle at 15% 20%, rgba(42, 157, 101, 0.06) 0%, transparent 50%),
        radial-gradient(circle at 85% 80%, rgba(26, 102, 64, 0.05) 0%, transparent 50%),
        url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%231f7a4d' fill-opacity='0.025'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 0;
    }

    /* ─── NOISE OVERLAY ──────────────────────────────── */
    .noise-overlay {
      position: fixed;
      inset: 0;
      opacity: 0.018;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 1;
    }

    /* ─── HEADER ─────────────────────────────────────── */
    .site-header {
      position: sticky;
      top: 0;
      z-index: 100;
      height: var(--header-h);
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(20px) saturate(180%);
      -webkit-backdrop-filter: blur(20px) saturate(180%);
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      padding: 0 32px;
      gap: 40px;
      box-shadow: var(--shadow-sm);
    }

    /* ─── LOGO ───────────────────────────────────────── */
    .logo {
      font-family: 'Playfair Display', serif;
      font-weight: 900;
      font-size: 22px;
      letter-spacing: 0.12em;
      color: var(--green-900);
      text-decoration: none;
      flex-shrink: 0;
      position: relative;
      transition: color var(--transition);
    }

    .logo span {
      color: var(--green-500);
    }

    .logo::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: linear-gradient(90deg, var(--green-500), var(--green-300));
      border-radius: 2px;
      transition: width var(--transition);
    }

    .logo:hover::after { width: 100%; }

    /* ─── NAV ────────────────────────────────────────── */
    .site-nav {
      display: flex;
      align-items: center;
      gap: 4px;
      flex: 1;
    }

    .nav-link {
      font-family: 'DM Sans', sans-serif;
      font-size: 13.5px;
      font-weight: 500;
      letter-spacing: 0.02em;
      color: var(--text-secondary);
      text-decoration: none;
      padding: 7px 16px;
      border-radius: var(--radius-sm);
      position: relative;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: color var(--transition), background var(--transition);
    }

    .nav-link:hover {
      color: var(--green-700);
      background: var(--green-50);
    }

    .nav-link.active {
      color: var(--green-800);
      background: var(--green-50);
      font-weight: 600;
    }

    .nav-link.active::before {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 16px;
      right: 16px;
      height: 2px;
      background: linear-gradient(90deg, var(--green-500), var(--green-400));
      border-radius: 2px 2px 0 0;
    }

    .nav-link.disabled {
      opacity: 0.5;
      pointer-events: none;
      cursor: not-allowed;
    }

    .badge-soon {
      font-family: 'DM Mono', monospace;
      font-size: 9px;
      font-weight: 500;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: var(--green-600);
      background: var(--green-100);
      border: 1px solid var(--green-200);
      padding: 2px 6px;
      border-radius: 4px;
      line-height: 1;
    }

    /* ─── HEADER TAG ─────────────────────────────────── */
    .header-tag {
      font-family: 'DM Mono', monospace;
      font-size: 11px;
      font-weight: 400;
      letter-spacing: 0.1em;
      color: var(--text-muted);
      background: var(--cream);
      border: 1px solid var(--border);
      padding: 4px 10px;
      border-radius: 20px;
      flex-shrink: 0;
    }

    /* ─── MAIN ───────────────────────────────────────── */
    .site-main {
      flex: 1;
      position: relative;
      z-index: 2;
    }

    /* ─── FOOTER ─────────────────────────────────────── */
    .site-footer {
      position: relative;
      z-index: 2;
      border-top: 1px solid var(--border);
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      padding: 20px 32px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
    }

    .footer-logo {
      font-family: 'Playfair Display', serif;
      font-weight: 900;
      font-size: 15px;
      letter-spacing: 0.14em;
      color: var(--green-800);
    }

    .footer-divider {
      width: 1px;
      height: 14px;
      background: var(--border-md);
    }

    .footer-text {
      font-family: 'DM Mono', monospace;
      font-size: 11.5px;
      font-weight: 400;
      color: var(--text-muted);
      letter-spacing: 0.03em;
    }

    .footer-right {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .footer-dot {
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: var(--green-400);
      animation: pulse-dot 2.5s ease-in-out infinite;
    }

    @keyframes pulse-dot {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.4; transform: scale(0.7); }
    }

    .footer-status {
      font-family: 'DM Mono', monospace;
      font-size: 11px;
      color: var(--green-500);
      letter-spacing: 0.04em;
    }

    /* ─── HEADER ENTRY ANIMATION ─────────────────────── */
    .site-header {
      animation: slideDown 0.4s cubic-bezier(0.4, 0, 0.2, 1) both;
    }

    @keyframes slideDown {
      from { transform: translateY(-8px); opacity: 0; }
      to   { transform: translateY(0);    opacity: 1; }
    }

    /* ─── SCROLLBAR ──────────────────────────────────── */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: var(--cream); }
    ::-webkit-scrollbar-thumb {
      background: var(--green-200);
      border-radius: 8px;
    }
    ::-webkit-scrollbar-thumb:hover { background: var(--green-300); }

    /* ─── RESPONSIVE ─────────────────────────────────── */
    @media (max-width: 768px) {
      .site-header {
        padding: 0 20px;
        gap: 20px;
      }

      .site-nav {
        gap: 2px;
      }

      .nav-link {
        padding: 6px 12px;
        font-size: 13px;
      }

      .header-tag { display: none; }

      .site-footer {
        padding: 16px 20px;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
      }
    }

    @media (max-width: 480px) {
      .logo { font-size: 18px; }
      .site-nav { gap: 0; }
      .nav-link { padding: 6px 10px; font-size: 12.5px; }
    }
  </style>

  {{-- Page specific CSS --}}
  @stack('styles')
</head>
<body>

  {{-- NOISE TEXTURE --}}
  <div class="noise-overlay"></div>

  {{-- HEADER --}}
  <header class="site-header">
    <a href="{{ route('home') }}" class="logo">S<span>E</span>PIA</a>

    <nav class="site-nav">
      <a href="{{ route('laporan.index') }}"
         class="nav-link {{ request()->routeIs('laporan*') ? 'active' : '' }}">
        Laporan
      </a>
      <a href="{{ route('personalisasi.index') }}"
         class="nav-link {{ request()->routeIs('personalisasi*') ? 'active' : '' }}">
        Personalisasi
      </a>
      <a href="{{ route('forecasting.index') }}"
         class="nav-link {{ request()->routeIs('forecasting*') ? 'active' : '' }}">
        Forecasting
      </a>
      <a href="{{ route('analisis.index') }}"
         class="nav-link disabled {{ request()->routeIs('analisis*') ? 'active' : '' }}">
        Analisis
        <span class="badge-soon">Soon</span>
      </a>
    </nav>

    <div class="header-tag">v1.0</div>
  </header>

  {{-- MAIN CONTENT --}}
  <main class="site-main">
    @yield('content')
  </main>

  {{-- FOOTER --}}
  <footer class="site-footer">
    <div class="footer-logo">SEPIA</div>
    <div class="footer-right">
      <div class="footer-dot"></div>
      <span class="footer-status">System Online</span>
    </div>
  </footer>

  {{-- Global JS --}}
  <script>
    window.GROQ_PROXY_URL = '{{ route('groq.chat') }}';
    window.CSRF_TOKEN     = '{{ csrf_token() }}';
  </script>
  <script src="{{ asset('js/sepia.js') }}"></script>

  {{-- Page specific JS --}}
  @stack('scripts')

</body>
</html>