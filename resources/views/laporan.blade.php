@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

{{-- PAGE HERO --}}
<section class="page-hero">
  <p class="page-label">01 — Ekstraksi & Strukturisasi</p>
  <h1>Laporan <em>Terstruktur</em></h1>
  <p>Input URL berita atau tempel teks dokumen — Llama AI akan mengekstrak kronologi, aktor, pasal, dan fakta penting secara otomatis.</p>
</section>

{{-- PAGE BODY --}}
<div class="page-body">
  <div class="two-col">

    {{-- KIRI: FORM INPUT --}}
    <div>
      <div class="panel">
        <div class="panel-title">Input Sumber</div>

        <div class="input-group">
          <label class="input-label" for="laporan-input">URL Berita atau Teks Dokumen</label>
          <textarea
            class="input-field"
            id="laporan-input"
            rows="10"
            placeholder="Tempel URL berita, atau langsung salin isi teks berita / dokumen di sini..."></textarea>
        </div>

        <button class="btn btn-primary" id="laporan-btn" onclick="prosesLaporan()">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
          Proses dengan Llama AI
        </button>

        <div class="alert-danger" id="laporan-error"></div>
      </div>

      {{-- INFO BOX --}}
      <div style="margin-top:1.2rem;padding:1.2rem;border:1px dashed rgba(139,105,20,0.25)">
        <p style="font-family:'DM Mono',monospace;font-size:0.62rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted);margin-bottom:0.5rem">Yang akan diekstrak</p>
        <ul style="list-style:none;font-size:0.83rem;color:var(--slate);line-height:2">
          <li>→ Judul & ringkasan kasus</li>
          <li>→ Kronologi kejadian</li>
          <li>→ Aktor: tersangka, korban, saksi</li>
          <li>→ Lokasi, tanggal, kategori kasus</li>
          <li>→ Pasal yang disangkakan</li>
          <li>→ Kerugian finansial (jika ada)</li>
          <li>→ Status terkini kasus</li>
        </ul>
      </div>
    </div>

    {{-- KANAN: HASIL --}}
    <div>
      {{-- SPINNER --}}
      <div class="spinner-wrap" id="laporan-spinner">
        <div class="spinner"></div>
        <p class="spinner-text">Llama sedang memproses konten...</p>
      </div>

      {{-- HASIL --}}
      <div class="result-panel" id="laporan-result">
        <div class="result-panel-header">
          <span>Hasil Strukturisasi</span>
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
      <div id="laporan-placeholder" style="padding:4rem 2rem;text-align:center;border:1px dashed rgba(139,105,20,0.2)">
        <p style="font-family:'DM Mono',monospace;font-size:0.68rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted)">
          Hasil akan muncul di sini
        </p>
      </div>
    </div>

  </div>
</div>

@endsection

@push('scripts')
<script>
// ============================================================
// PROMPT KHUSUS LAPORAN
// Dioptimalkan untuk Llama 3.3 (lebih eksplisit soal JSON-only)
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
  const input = document.getElementById('laporan-input').value.trim();

  if (!input) {
    showError('laporan', 'Harap masukkan URL atau teks berita terlebih dahulu.');
    return;
  }

  hideError('laporan');
  hideResult('laporan');
  document.getElementById('laporan-placeholder').style.display = 'none';
  setLoading('laporan', true);

  try {
    // callGroq() dipanggil sama persis seperti callGemini() dulu
    const raw  = await callGroq(PROMPT_LAPORAN, 'Strukturkan berita/dokumen berikut:\n\n' + input);
    const data = parseGroqJSON(raw);

    document.getElementById('laporan-result-body').innerHTML = renderHasilLaporan(data);
    showResult('laporan');

  } catch (e) {
    showError('laporan', e.message);
    document.getElementById('laporan-placeholder').style.display = 'block';
  } finally {
    setLoading('laporan', false);
  }
}

// ============================================================
// RENDER HASIL LAPORAN
// ============================================================
function renderHasilLaporan(data) {
  let html = '';

  if (data.judul) {
    html += renderSection('Judul Kasus',
      `<strong style="font-size:1rem">${data.judul}</strong>`);
  }

  if (data.ringkasan) {
    html += renderSection('Ringkasan', data.ringkasan);
  }

  const metaHtml = [
    data.tanggal        ? `<strong>Tanggal:</strong> ${data.tanggal}`           : '',
    data.lokasi         ? `<strong>Lokasi:</strong> ${data.lokasi}`             : '',
    data.kategori_kasus ? `<strong>Kategori:</strong> ${data.kategori_kasus}`   : '',
    data.status_kasus   ? `<strong>Status:</strong> ${data.status_kasus}`       : '',
    data.kerugian       ? `<strong>Kerugian:</strong> ${data.kerugian}`         : '',
    data.pasal          ? `<strong>Pasal:</strong> ${data.pasal}`               : '',
  ].filter(Boolean).join('<br>');

  if (metaHtml) {
    html += renderSection('Metadata Kasus', metaHtml);
  }

  if (data.kronologi?.length) {
    html += renderSection('Kronologi Kejadian', renderTimeline(data.kronologi));
  }

  if (data.aktor?.length) {
    html += renderSection('Aktor yang Terlibat',
      renderActorChips(data.aktor) + '<br><br>' + renderActorList(data.aktor));
  }

  return html || '<p style="color:var(--muted)">Tidak ada data yang berhasil diekstrak.</p>';
}
</script>
@endpush