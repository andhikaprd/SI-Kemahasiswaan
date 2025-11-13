<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ranking Prestasi Mahasiswa (SAW)</title>
  <style>
    body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; color: #111; }
    h1 { font-size: 18px; margin: 0 0 6px; }
    .meta { font-size: 12px; color: #555; margin-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 6px 8px; }
    th { background: #f5f5f5; text-align: left; }
    .right { text-align: right; }
    .center { text-align: center; }
    .muted { color: #777; }
    @media print {
      .no-print { display: none; }
    }
  </style>
  <script>
    function autoPrint(){
      if (!('{{ class_exists("\\\\Barryvdh\\\\DomPDF\\\\Facade\\\\Pdf") ? '1' : '0' }}' === '1')) {
        setTimeout(function(){ window.print && window.print(); }, 300);
      }
    }
  </script>
  </head>
<body onload="autoPrint()">
  <div class="no-print" style="margin-bottom:10px;">
    <em>Catatan:</em> Jika paket PDF tidak terpasang, halaman ini dapat dicetak ke PDF dari browser.
  </div>

  <h1>Ranking Prestasi Mahasiswa (SAW)</h1>
  <div class="meta">
    Periode: <strong>{{ $tahun ? $tahun : 'Semua' }}</strong>
    &nbsp;|&nbsp; Bobot AHP → IPK: {{ number_format($weights['ipk'],4) }}, Tingkat: {{ number_format($weights['tingkat'],4) }}, Juara: {{ number_format($weights['juara'],4) }}, B.Ing: {{ number_format($weights['english'],4) }}
  </div>

  <table>
    <thead>
      <tr>
        <th style="width:60px">Rank</th>
        <th style="width:120px">NIM</th>
        <th>Nama</th>
        <th class="center" style="width:70px">r(IPK)</th>
        <th class="center" style="width:120px">Tingkat Terbaik</th>
        <th class="center" style="width:80px">r(Tingkat)</th>
        <th class="center" style="width:120px">Juara Terbaik</th>
        <th class="center" style="width:80px">r(Juara)</th>
        <th class="center" style="width:80px">r(Inggris)</th>
        <th class="right" style="width:80px">Skor</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $row)
        <tr>
          <td class="center">{{ $row['rank'] }}</td>
          <td>{{ $row['nim'] ?? '-' }}</td>
          <td>{{ $row['nama'] }}</td>
          <td class="center">{{ number_format($row['r_ipk'],3) }}</td>
          <td class="center">{{ $row['best_tingkat_label'] }}</td>
          <td class="center">{{ number_format($row['r_tingkat'],3) }}</td>
          <td class="center">{{ $row['best_juara_label'] }}</td>
          <td class="center">{{ number_format($row['r_juara'],3) }}</td>
          <td class="center">{{ number_format($row['r_eng'],3) }}</td>
          <td class="right">{{ number_format($row['score'],4) }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="10" class="center muted">Tidak ada data.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>

