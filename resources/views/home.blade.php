@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<div class="home-wrapper">

  {{-- HERO --}}
  <div class="home-hero fade-up">
    <p class="home-label">Multi-Agent AI Platform</p>
    <h1>Ubah berita menjadi <em>wawasan</em> yang terstruktur.</h1>
    <p class="home-sub">Platform AI untuk memproses dokumen hukum dan berita secara otomatis.</p>
  </div>

  {{-- CARDS --}}
  <div class="home-grid fade-up">

    <a href="{{ route('laporan.index') }}" class="home-card">
      <div class="hc-icon">
        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      </div>
      <div class="hc-info">
        <h2>Laporan</h2>
        <p>Ekstrak kronologi, aktor, dan fakta penting dari berita atau dokumen.</p>
      </div>
      <span class="hc-arrow">↗</span>
    </a>

    <a href="{{ route('personalisasi.index') }}" class="home-card">
      <div class="hc-icon">
        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      </div>
      <div class="hc-info">
        <h2>Personalisasi</h2>
        <p>Kompilasi keterlibatan seseorang atau entitas dari seluruh laporan.</p>
      </div>
      <span class="hc-arrow">↗</span>
    </a>

    <a href="{{ route('forecasting.index') }}" class="home-card">
      <div class="hc-icon">
        <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
      </div>
      <div class="hc-info">
        <h2>Forecasting</h2>
        <p>Rekomendasi tindakan untuk polisi, jaksa, dan hakim.</p>
      </div>
      <span class="hc-arrow">↗</span>
    </a>

    <div class="home-card disabled">
      <div class="hc-icon">
        <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
      </div>
      <div class="hc-info">
        <h2>Analisis</h2>
        <p>Visualisasi pola kasus, jaringan aktor, dan tren lintas laporan.</p>
      </div>
      <span class="badge-soon">Segera Hadir</span>
    </div>

  </div>

</div>

@endsection

@push('styles')
<style>
  .home-wrapper {
    min-height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 2rem 1.5rem;
    gap: 2rem;
  }

  /* HERO */
  .home-hero {
    text-align: center;
    max-width: 480px;
  }

  .home-label {
    font-size: 0.7rem;
    font-family: 'DM Mono', monospace;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--green);
    margin-bottom: 0.75rem;
  }

  .home-hero h1 {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.25;
    margin-bottom: 0.6rem;
  }

  .home-hero h1 em {
    font-style: normal;
    color: var(--green);
  }

  .home-sub {
    font-size: 0.85rem;
    color: var(--muted);
    line-height: 1.6;
  }

  /* GRID */
  .home-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
    width: 100%;
    max-width: 560px;
  }

  /* CARD */
  .home-card {
    background: #fff;
    border: 1px solid rgba(45,122,80,0.12);
    border-radius: 12px;
    padding: 1.1rem 1.2rem;
    display: flex;
    align-items: flex-start;
    gap: 0.85rem;
    text-decoration: none;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: box-shadow 0.2s, transform 0.2s, background 0.2s;
  }

  .home-card:not(.disabled):hover {
    box-shadow: 0 6px 20px rgba(45,122,80,0.12);
    transform: translateY(-2px);
    background: #f9fefb;
  }

  .home-card.disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  /* Icon */
  .hc-icon {
    flex-shrink: 0;
    width: 32px; height: 32px;
    background: rgba(45,122,80,0.08);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
  }
  .hc-icon svg {
    width: 15px; height: 15px;
    stroke: var(--green);
    fill: none;
    stroke-width: 1.5;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  /* Info */
  .hc-info { flex: 1; min-width: 0; }
  .hc-info h2 {
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 0.25rem;
    line-height: 1.2;
  }
  .hc-info p {
    font-size: 0.75rem;
    color: var(--muted);
    line-height: 1.5;
  }

  /* Arrow */
  .hc-arrow {
    font-size: 0.85rem;
    color: var(--muted);
    flex-shrink: 0;
    transition: all 0.2s;
  }
  .home-card:not(.disabled):hover .hc-arrow {
    transform: translate(2px, -2px);
    color: var(--green);
  }

  /* Badge */
  .badge-soon {
    font-size: 0.55rem;
    font-family: 'DM Mono', monospace;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    background: rgba(45,122,80,0.08);
    color: var(--green);
    padding: 0.2rem 0.45rem;
    border-radius: 4px;
    flex-shrink: 0;
    white-space: nowrap;
  }

  @media (max-width: 500px) {
    .home-grid { grid-template-columns: 1fr; }
  }
</style>
@endpush