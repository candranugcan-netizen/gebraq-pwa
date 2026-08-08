<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - Gebraq</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        h2 { margin-bottom: 2px; text-align: center; color: #4f46e5; }
        p.subtitle { text-align: center; font-size: 10px; color: #666; margin-top: 0; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e5e7eb; padding: 7px; text-align: left; }
        th { background-color: #4f46e5; color: white; text-transform: uppercase; font-size: 9px; }
        .text-right { text-align: right; }
        .pemasukan { color: #059669; font-weight: bold; }
        .pengeluaran { color: #dc2626; font-weight: bold; }
        .summary { margin-top: 20px; float: right; width: 45%; }
        .summary table { border: none; }
        .summary td { border: none; padding: 4px; }
    </style>
</head>
<body>
    <h2>LAPORAN KEUANGAN PROGRAM GEBRAQ</h2>
    <p class="subtitle">Dicetak pada: {{ date('d-m-Y H:i') }} WIB</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 15%;">Tipe</th>
                <th style="width: 20%;">Kategori</th>
                <th>Keterangan</th>
                <th style="width: 20%;" class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($keuangan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->tanggal }}</td>
                <td class="{{ $item->tipe == 'Pemasukan' ? 'pemasukan' : 'pengeluaran' }}">{{ $item->tipe }}</td>
                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $item->keterangan }}</td>
                <td class="text-right">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <table>
            <tr>
                <td>Total Pemasukan</td>
                <td class="text-right pemasukan">Rp {{ number_format($pemasukan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Pengeluaran</td>
                <td class="text-right pengeluaran">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr style="border-top: 1px solid #333;">
                <td><strong>Sisa Saldo</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($saldo, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>
</body>
</html>
