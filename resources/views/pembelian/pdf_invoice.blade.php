<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $pembelian->invoice_number }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #2c3e50;
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .info {
            margin-bottom: 30px;
            clear: both;
        }
        .customer-info, .transaction-info {
            width: 45%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #eee;
            border-radius: 5px;
            background: #f8f9fa;
        }
        .customer-info {
            float: left;
        }
        .transaction-info {
            float: right;
        }
        .info-title {
            color: #3498db;
            font-weight: bold;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .info-content {
            font-size: 13px;
            line-height: 1.8;
        }
        .info-content strong {
            display: inline-block;
            width: 100px;
            color: #555;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 13px;
            clear: both;
        }
        .table th {
            background: #3498db;
            color: white;
            padding: 12px;
            text-align: left;
        }
        .table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .table tfoot td {
            font-weight: bold;
            border-top: 2px solid #3498db;
            background: #f8f9fa;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px dashed #ddd;
        }
        .thank-you {
            color: #3498db;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .store-info {
            font-size: 12px;
            color: #666;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>INVOICE #{{ $pembelian->invoice_number }}</h1>
            <p>{{ \Carbon\Carbon::parse($pembelian->created_at)->translatedFormat('d F Y') }} | {{ \Carbon\Carbon::parse($pembelian->created_at)->format('H:i') }} WIB</p>
        </div>

        <div class="info">
            <div class="customer-info">
                <div class="info-title">Informasi Pelanggan</div>
                @if($member)
                    <div class="info-content">
                        <p><strong>Status</strong> Member</p>
                        <p><strong>Nama</strong> {{ $pembelian->customer_name }}</p>
                        <p><strong>No. HP</strong> {{ $member->phone_number }}</p>
                        <p><strong>Poin</strong> {{ $member->points }} Poin</p>
                        <p><strong>Member Sejak</strong> {{ \Carbon\Carbon::parse($member->member_since)->translatedFormat('d F Y') }}</p>
                    </div>
                @else
                    <div class="info-content">
                        <p><strong>Status</strong> Non-Member</p>
                        <p><strong>Nama</strong> {{ $pembelian->customer_name ?? '-' }}</p>
                    </div>
                @endif
            </div>
            
            <div class="transaction-info">
                <div class="info-title">Informasi Transaksi</div>
                <div class="info-content">
                    <p><strong>Kasir</strong> {{ $pembelian->dibuat_oleh }}</p>
                    <p><strong>Tanggal</strong> {{ \Carbon\Carbon::parse($pembelian->created_at)->translatedFormat('d F Y') }}</p>
                    <p><strong>Waktu</strong> {{ \Carbon\Carbon::parse($pembelian->created_at)->format('H:i') }} WIB</p>
                    <p><strong>No. Invoice</strong> #{{ $pembelian->invoice_number }}</p>
                </div>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 40%">Produk</th>
                    <th class="text-center" style="width: 15%">Qty</th>
                    <th class="text-right" style="width: 20%">Harga Satuan</th>
                    <th class="text-right" style="width: 25%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembelian->details as $detail)
                    <tr>
                        <td>{{ $detail->product->nama_produk }}</td>
                        <td class="text-center">{{ $detail->quantity }}</td>
                        <td class="text-right">Rp {{ number_format($detail->product->harga, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($detail->total_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total Pembelian</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($pembelian->grand_total, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            <p class="thank-you">Terima kasih atas pembelian Anda!</p>
            <p>Silahkan berkunjung kembali</p>
            <div class="store-info">
                <p>Toko Taufik | Jl. Raya No. 123, Kota | Telp: (021) 123-4567</p>
            </div>
        </div>
    </div>
</body>
</html>