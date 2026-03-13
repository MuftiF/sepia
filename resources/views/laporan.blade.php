@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

<section class="page-hero">
  <p class="page-label">01 — Ekstraksi & Strukturisasi</p>
  <h1>Laporan <em>Terstruktur</em></h1>
  <p>Input URL berita atau tempel teks dokumen — Llama AI akan mengekstrak kronologi, aktor, pasal, dan fakta penting secara otomatis.</p>
</section>

<div class="page-body">
  <div class="two-col">

    {{-- KIRI: FORM INPUT --}}
    <div>
      <div class="panel">
        <div class="panel-title">Input Sumber</div>

        {{-- FORM LARAVEL --}}
<form action="{{ route('laporan.store') }}" method="POST">
@csrf

<div class="input-group">
<label class="input-label">Judul Berita</label>
<input
type="text"
name="title"
class="input-field"
placeholder="Masukkan judul berita..."
required>
</div>

<div class="input-group">
<label class="input-label">URL Berita</label>
<input
type="text"
name="source_url"
class="input-field"
placeholder="https://..."
required>
</div>

<div class="input-group">
<label class="input-label">Isi Berita / Dokumen</label>
<textarea
id="laporan-input"
class="input-field"
name="content"
rows="10"
placeholder="Tempel teks berita di sini..."
required></textarea>
</div>

<br>

<button type="button" class="btn btn-primary" onclick="prosesLaporan()">
Proses dengan Llama AI
</button>

<br><br>

<button type="submit" class="btn btn-secondary">
Simpan Laporan
</button>

</form>

        <div class="alert-danger" id="laporan-error"></div>
      </div>

      {{-- INFO BOX --}}
      <div style="margin-top:1.2rem;padding:1.2rem;border:1px dashed rgba(139,105,20,0.25)">
        <p style="font-family:'DM Mono',monospace;font-size:0.62rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted);margin-bottom:0.5rem">
        Yang akan diekstrak
        </p>

        <ul style="list-style:none;font-size:0.83rem;color:var(--slate);line-height:2">
          <li>→ Judul & ringkasan kasus</li>
          <li>→ Kronologi kejadian</li>
          <li>→ Aktor: tersangka, korban, saksi</li>
          <li>→ Lokasi, tanggal, kategori kasus</li>
          <li>→ Pasal yang disangkakan</li>
          <li>→ Kerugian finansial</li>
          <li>→ Status terkini kasus</li>
        </ul>
      </div>
    </div>

    {{-- KANAN: HASIL LAPORAN --}}
    <div>

      <div class="panel">
        <div class="panel-title">Riwayat Laporan</div>

        @forelse($reports as $report)

        <div style="border:1px solid #eee;padding:1rem;margin-bottom:1rem">

          <strong>{{ $report->title }}</strong>

          <p style="font-size:0.8rem;color:#666">
            {{ $report->source_url }}
          </p>

          <p>
            {{ Str::limit($report->content,150) }}
          </p>

        </div>

        @empty

        <p style="color:var(--muted)">
        Belum ada laporan yang disimpan.
        </p>

        @endforelse

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