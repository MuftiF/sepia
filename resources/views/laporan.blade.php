@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

{{-- PAGE HERO --}}
<section class="page-hero">
  <div class="hero-inner">
    <div class="hero-label fade-up">
      <span class="label-dot"></span>
      01 — Ekstraksi & Strukturisasi
    </div>
    <h1 class="hero-title fade-up">Laporan <em>Terstruktur</em></h1>
    <p class="hero-desc fade-up">
      Input URL berita atau tempel teks dokumen — Llama AI akan mengekstrak kronologi,
      aktor, pasal, dan fakta penting secara otomatis.
    </p>
  </div>
</section>

{{-- PAGE BODY --}}
<div class="page-body">
  <div class="two-col">

    {{-- KIRI: FORM INPUT --}}
    <div class="col-left">

      <div class="panel fade-up">
        <div class="panel-header">
          <div class="panel-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
              <polyline points="14 2 14 8 20 8"/>
            </svg>
          </div>
          <span class="panel-title">Input Sumber</span>
        </div>

        <div class="input-group">
          <label class="input-label" for="laporan-input">URL Berita atau Teks Dokumen</label>
          <textarea
            class="input-field"
            id="laporan-input"
            rows="10"
            placeholder="Tempel URL berita, atau langsung salin isi teks berita / dokumen di sini..."></textarea>
        </div>

        <button class="btn-process" id="laporan-btn" onclick="prosesLaporan()">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
          </svg>
          Proses dengan Llama AI
        </button>

        <div class="alert-danger" id="laporan-error" style="display:none"></div>
      </div>

      {{-- INFO BOX --}}
      <div class="info-box fade-up">
        <p class="info-box-title">Yang akan diekstrak</p>
        <ul class="info-list">
          <li>
            <span class="info-bullet"></span>
            Judul &amp; ringkasan kasus
          </li>
          <li>
            <span class="info-bullet"></span>
            Kronologi kejadian
          </li>
          <li>
            <span class="info-bullet"></span>
            Aktor: tersangka, korban, saksi
          </li>
          <li>
            <span class="info-bullet"></span>
            Lokasi, tanggal, kategori kasus
          </li>
          <li>
            <span class="info-bullet"></span>
            Pasal yang disangkakan
          </li>
          <li>
            <span class="info-bullet"></span>
            Kerugian finansial (jika ada)
          </li>
          <li>
            <span class="info-bullet"></span>
            Status terkini kasus
          </li>
        </ul>
      </div>

    </div>

    {{-- KANAN: HASIL --}}
    <div class="col-right">

      {{-- SPINNER --}}
      <div class="spinner-wrap" id="laporan-spinner" style="display:none">
        <div class="spinner-ring">
          <div></div><div></div><div></div><div></div>
        </div>
        <p class="spinner-text">Llama sedang memproses konten...</p>
      </div>

      {{-- HASIL --}}
      <div class="result-panel" id="laporan-result" style="display:none">
        <div class="result-panel-header">
          <div class="result-panel-title">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="9 11 12 14 22 4"/>
              <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
            </svg>
            Hasil Strukturisasi
          </div>
          <div class="result-status">
            <div class="status-dot"></div>
            <span>Llama 3.3 — Groq</span>
          </div>
        </div>
        <div class="result-panel-body" id="laporan-result-body">
          {{-- Diisi oleh JavaScript --}}
        </div>
      </div>

      {{-- PLACEHOLDER KOSONG --}}
      <div id="laporan-placeholder" class="placeholder-box">
        <div class="placeholder-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10 9 9 9 8 9"/>
          </svg>
        </div>
        <p class="placeholder-title">Hasil akan muncul di sini</p>
        <p class="placeholder-sub">Masukkan URL atau teks berita, lalu tekan proses</p>
      </div>

    </div>
  </div>
</div>

@endsection

@push('styles')
<style>
  /* ─── PAGE HERO ────────────────────────────────────── */
  .page-hero {
    padding: 4rem 0 3rem;
    border-bottom: 1px solid rgba(26, 102, 64, 0.12);
    background: linear-gradient(
      160deg,
      rgba(234, 247, 240, 0.7) 0%,
      rgba(255, 255, 255, 0.4) 60%
    );
  }

  .hero-inner {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 48px;
  }

  .hero-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: 'DM Mono', monospace;
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: #1a6640;
    background: rgba(234, 247, 240, 0.9);
    border: 1px solid rgba(26, 102, 64, 0.2);
    padding: 6px 14px;
    border-radius: 20px;
    margin-bottom: 1.4rem;
  }

  .label-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #2a9d65;
    animation: pulseDot 2.5s ease-in-out infinite;
  }

  @keyframes pulseDot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.35; transform: scale(0.65); }
  }

  .hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4vw, 2.9rem);
    font-weight: 900;
    color: #0a2e1a;
    line-height: 1.1;
    letter-spacing: -0.02em;
    margin-bottom: 1rem;
  }

  .hero-title em {
    font-style: italic;
    color: #1a6640;
    position: relative;
  }

  .hero-title em::after {
    content: '';
    position: absolute;
    bottom: 3px; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #2a9d65, #86d4aa);
    border-radius: 2px;
    opacity: 0.5;
  }

  .hero-desc {
    font-size: 0.97rem;
    font-weight: 300;
    line-height: 1.75;
    color: #2d6647;
    max-width: 560px;
  }

  /* ─── PAGE BODY ────────────────────────────────────── */
  .page-body {
    max-width: 900px;
    margin: 0 auto;
    padding: 3rem 48px 5rem;
  }

  .two-col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    align-items: start;
  }

  /* ─── PANEL ────────────────────────────────────────── */
  .panel {
    background: #ffffff;
    border: 1px solid rgba(26, 102, 64, 0.14);
    border-radius: 16px;
    padding: 1.8rem;
    box-shadow: 0 2px 12px rgba(10, 46, 26, 0.05);
  }

  .panel-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 1.4rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(26, 102, 64, 0.1);
  }

  .panel-icon {
    width: 32px; height: 32px;
    background: rgba(234, 247, 240, 0.9);
    border: 1px solid rgba(26, 102, 64, 0.18);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }

  .panel-icon svg {
    width: 15px; height: 15px;
    stroke: #1f7a4d;
  }

  .panel-title {
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #0a2e1a;
    letter-spacing: 0.01em;
  }

  /* ─── INPUT ────────────────────────────────────────── */
  .input-group { margin-bottom: 1.2rem; }

  .input-label {
    display: block;
    font-family: 'DM Sans', sans-serif;
    font-size: 12px;
    font-weight: 500;
    color: #2d6647;
    letter-spacing: 0.02em;
    margin-bottom: 0.5rem;
  }

  .input-field {
    width: 100%;
    background: #f7faf8;
    border: 1px solid rgba(26, 102, 64, 0.16);
    border-radius: 10px;
    padding: 12px 14px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13.5px;
    font-weight: 300;
    color: #0a2e1a;
    line-height: 1.65;
    resize: vertical;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
  }

  .input-field::placeholder { color: #6aaa88; opacity: 0.7; }

  .input-field:focus {
    border-color: rgba(31, 122, 77, 0.4);
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(42, 157, 101, 0.08);
  }

  /* ─── BUTTON ───────────────────────────────────────── */
  .btn-process {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: linear-gradient(135deg, #1f7a4d 0%, #1a6640 100%);
    color: #ffffff;
    border: none;
    border-radius: 10px;
    padding: 12px 20px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13.5px;
    font-weight: 500;
    letter-spacing: 0.02em;
    cursor: pointer;
    transition: opacity 0.2s, transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 4px 16px rgba(31, 122, 77, 0.25);
  }

  .btn-process:hover {
    opacity: 0.92;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(31, 122, 77, 0.32);
  }

  .btn-process:active { transform: translateY(0); }

  .btn-process:disabled {
    opacity: 0.55;
    cursor: not-allowed;
    transform: none;
  }

  /* ─── ALERT ────────────────────────────────────────── */
  .alert-danger {
    margin-top: 0.8rem;
    background: #fff0f0;
    border: 1px solid rgba(220, 60, 60, 0.2);
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 12.5px;
    color: #c0392b;
    line-height: 1.5;
  }

  /* ─── INFO BOX ─────────────────────────────────────── */
  .info-box {
    margin-top: 16px;
    background: rgba(234, 247, 240, 0.5);
    border: 1px dashed rgba(26, 102, 64, 0.22);
    border-radius: 12px;
    padding: 1.4rem;
  }

  .info-box-title {
    font-family: 'DM Mono', monospace;
    font-size: 10px;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: #6aaa88;
    margin-bottom: 0.9rem;
  }

  .info-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .info-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: #2d6647;
    font-weight: 400;
    line-height: 1.4;
  }

  .info-bullet {
    width: 5px; height: 5px;
    border-radius: 50%;
    background: #2a9d65;
    flex-shrink: 0;
  }

  /* ─── SPINNER ──────────────────────────────────────── */
  .spinner-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 5rem 2rem;
    background: #ffffff;
    border: 1px solid rgba(26, 102, 64, 0.12);
    border-radius: 16px;
    gap: 1.2rem;
  }

  .spinner-ring {
    display: inline-block;
    position: relative;
    width: 40px; height: 40px;
  }

  .spinner-ring div {
    box-sizing: border-box;
    display: block;
    position: absolute;
    width: 32px; height: 32px;
    margin: 4px;
    border: 3px solid transparent;
    border-top-color: #1f7a4d;
    border-radius: 50%;
    animation: spinRing 0.9s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  }

  .spinner-ring div:nth-child(1) { animation-delay: -0.27s; }
  .spinner-ring div:nth-child(2) { animation-delay: -0.18s; }
  .spinner-ring div:nth-child(3) { animation-delay: -0.09s; }

  @keyframes spinRing {
    0%   { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  .spinner-text {
    font-family: 'DM Mono', monospace;
    font-size: 11px;
    letter-spacing: 0.08em;
    color: #6aaa88;
  }

  /* ─── RESULT PANEL ─────────────────────────────────── */
  .result-panel {
    background: #ffffff;
    border: 1px solid rgba(26, 102, 64, 0.14);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(10, 46, 26, 0.05);
  }

  .result-panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    background: linear-gradient(135deg, rgba(234,247,240,0.8), rgba(240,246,242,0.6));
    border-bottom: 1px solid rgba(26, 102, 64, 0.12);
  }

  .result-panel-title {
    display: flex;
    align-items: center;
    gap: 7px;
    font-family: 'DM Sans', sans-serif;
    font-size: 12.5px;
    font-weight: 600;
    color: #0a2e1a;
  }

  .result-panel-title svg { stroke: #1f7a4d; }

  .result-status {
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: 'DM Mono', monospace;
    font-size: 10.5px;
    color: #6aaa88;
    letter-spacing: 0.05em;
  }

  .status-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #2a9d65;
    animation: pulseDot 2.5s ease-in-out infinite;
  }

  .result-panel-body {
    padding: 1.6rem;
    font-size: 13.5px;
    line-height: 1.7;
    color: #0a2e1a;
  }

  /* ─── PLACEHOLDER ──────────────────────────────────── */
  .placeholder-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 5rem 2rem;
    border: 1px dashed rgba(26, 102, 64, 0.2);
    border-radius: 16px;
    background: rgba(247, 250, 248, 0.5);
    text-align: center;
    gap: 12px;
  }

  .placeholder-icon {
    width: 52px; height: 52px;
    background: rgba(234, 247, 240, 0.8);
    border: 1px solid rgba(26, 102, 64, 0.15);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 4px;
  }

  .placeholder-icon svg {
    width: 24px; height: 24px;
    stroke: #86d4aa;
  }

  .placeholder-title {
    font-family: 'DM Mono', monospace;
    font-size: 11px;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: #6aaa88;
  }

  .placeholder-sub {
    font-size: 12px;
    color: #86d4aa;
    font-weight: 300;
  }

  /* ─── FADE-UP ──────────────────────────────────────── */
  .fade-up {
    opacity: 0;
    transform: translateY(16px);
    animation: fadeUp 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
  }

  .fade-up:nth-child(1) { animation-delay: 0.05s; }
  .fade-up:nth-child(2) { animation-delay: 0.12s; }
  .fade-up:nth-child(3) { animation-delay: 0.19s; }

  .col-left .fade-up:nth-child(1) { animation-delay: 0.12s; }
  .col-left .fade-up:nth-child(2) { animation-delay: 0.22s; }

  @keyframes fadeUp {
    to { opacity: 1; transform: translateY(0); }
  }

  /* ─── RESPONSIVE ───────────────────────────────────── */
  @media (max-width: 768px) {
    .hero-inner, .page-body { padding-left: 24px; padding-right: 24px; }
    .two-col { grid-template-columns: 1fr; }
  }
</style>
@endpush

@push('scripts')
<script>
// ============================================================
// PROMPT KHUSUS LAPORAN
// ============================================================
const PROMPT_LAPORAN = `
Kamu adalah SEPIA AI, sistem analisis berita dan dokumen hukum profesional Indonesia.

TUGASMU: Ekstrak dan strukturkan informasi dari teks berita/dokumen yang diberikan.

ATURAN WAJIB:
1. Kembalikan output HANYA berupa JSON valid murni — tanpa penjelasan, tanpa kalimat pembuka, tanpa markdown code block
2. Mulai langsung dengan karakter { dan akhiri dengan }
3. Jangan tambahkan opini atau asumsi
4. Gunakan bahasa Indonesia yang formal dan baku
5. Jika informasi tidak tersedia, isi dengan null
6. Identifikasi SEMUA aktor dengan peran yang jelas

FORMAT JSON YANG HARUS DIKEMBALIKAN:
{
  "judul": "string - judul atau topik utama kasus",
  "ringkasan": "string - ringkasan 2-3 kalimat yang padat",
  "tanggal": "string atau null",
  "lokasi": "string atau null",
  "kategori_kasus": "string - misal: Korupsi, Pembunuhan, Penipuan, Narkoba, dll",
  "kronologi": [
    { "waktu": "string", "kejadian": "string" }
  ],
  "aktor": [
    {
      "nama": "string",
      "peran": "tersangka|korban|saksi|institusi|pengacara|jaksa|hakim",
      "deskripsi": "string"
    }
  ],
  "kerugian": "string atau null",
  "pasal": "string atau null",
  "status_kasus": "string atau null"
}`.trim();

// ============================================================
// HANDLER PROSES LAPORAN
// ============================================================
async function prosesLaporan() {
  const input  = document.getElementById('laporan-input').value.trim();
  const btn    = document.getElementById('laporan-btn');

  if (!input) {
    showError('laporan', 'Harap masukkan URL atau teks berita terlebih dahulu.');
    return;
  }

  hideError('laporan');
  hideResult('laporan');
  document.getElementById('laporan-placeholder').style.display = 'none';
  setLoading('laporan', true);
  btn.disabled = true;

  try {
    const raw  = await callGroq(PROMPT_LAPORAN, 'Strukturkan berita/dokumen berikut:\n\n' + input);
    const data = parseGroqJSON(raw);

    document.getElementById('laporan-result-body').innerHTML = renderHasilLaporan(data);
    showResult('laporan');

  } catch (e) {
    showError('laporan', e.message);
    document.getElementById('laporan-placeholder').style.display = 'flex';
  } finally {
    setLoading('laporan', false);
    btn.disabled = false;
  }
}

// ============================================================
// RENDER HASIL LAPORAN
// ============================================================
function renderHasilLaporan(data) {
  let html = '';

  if (data.judul) {
    html += renderSection('Judul Kasus',
      `<strong style="font-size:1rem;color:#0a2e1a">${data.judul}</strong>`);
  }

  if (data.ringkasan) {
    html += renderSection('Ringkasan', data.ringkasan);
  }

  const metaItems = [
    data.tanggal        ? `<strong>Tanggal:</strong> ${data.tanggal}`         : '',
    data.lokasi         ? `<strong>Lokasi:</strong> ${data.lokasi}`           : '',
    data.kategori_kasus ? `<strong>Kategori:</strong> ${data.kategori_kasus}` : '',
    data.status_kasus   ? `<strong>Status:</strong> ${data.status_kasus}`     : '',
    data.kerugian       ? `<strong>Kerugian:</strong> ${data.kerugian}`       : '',
    data.pasal          ? `<strong>Pasal:</strong> ${data.pasal}`             : '',
  ].filter(Boolean).join('<br>');

  if (metaItems) {
    html += renderSection('Metadata Kasus', metaItems);
  }

  if (data.kronologi?.length) {
    html += renderSection('Kronologi Kejadian', renderTimeline(data.kronologi));
  }

  if (data.aktor?.length) {
    html += renderSection('Aktor yang Terlibat',
      renderActorChips(data.aktor) + '<br><br>' + renderActorList(data.aktor));
  }

  return html || '<p style="color:#6aaa88;font-size:13px">Tidak ada data yang berhasil diekstrak.</p>';
}
</script>
@endpush