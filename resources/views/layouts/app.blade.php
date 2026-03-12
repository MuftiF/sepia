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
    <div class="footer-text">Powered by Gemini · Qwen · Llama &mdash; &copy; {{ date('Y') }}</div>
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
