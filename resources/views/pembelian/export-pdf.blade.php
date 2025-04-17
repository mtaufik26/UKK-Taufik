<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pembelian</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2 class="text-center">Daftar Pembelian</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Penjualan</th>
                <th>Total Harga</th>
                <th>Dibuat Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembelians as $pembelian)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $pembelian->customer_name }}</td>
                <td class="text-center">{{ $pembelian->tanggal }}</td>
                <td class="text-right">Rp {{ number_format($pembelian->grand_total, 0, ',', '.') }}</td>
                <td>{{ $pembelian->user->name ?? 'Stuf' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>