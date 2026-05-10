<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Faktur Pembelian - {{ $fakturPembelian->nomor_faktur ?? 'NO-FAKTUR' }}</title>

    <style>
    @page {
        size: A4;
        margin: 15mm;
    }

    body {
        font-family: 'Arial', 'Helvetica', sans-serif;
        font-size: 14px;
        line-height: 1.6;
        color: #333;
        background: #fff;
    }

    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 3px solid #1e3a8a;
    }

    .company-info h1 {
        margin: 0;
        font-size: 26px;
        color: #1e3a8a;
    }

    .company-info p {
        margin: 5px 0 0 0;
        font-size: 13px;
    }

    .invoice-info {
        text-align: right;
    }

    .invoice-title {
        font-size: 32px;
        font-weight: bold;
        color: #1e3a8a;
        margin: 0;
    }

    .invoice-number {
        font-size: 18px;
        color: #555;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 12px 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #1e40af;
    }

    .text-end {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .summary-table {
        width: 380px;
        margin-left: auto;
        margin-top: 30px;
        border: 2px solid #1e3a8a;
    }

    .summary-table td {
        padding: 10px 15px;
    }

    .total-row {
        font-size: 18px;
        font-weight: bold;
        background-color: #f0f9ff;
    }

    .footer {
        margin-top: 60px;
        text-align: center;
        font-size: 13px;
        color: #666;
    }
    </style>
</head>

<body onload="window.print()">

    <div class="invoice-header">
        <div class="company-info">
            <!-- Nama Perusahaan Dinamis -->
            <h1>{{ $fakturPembelian->perusahaan->nama_perusahaan ?? 'Nama Perusahaan Anda' }}</h1>

            <p>
                @if($fakturPembelian->perusahaan)
                {{ $fakturPembelian->perusahaan->alamat ?? 'Alamat Lengkap' }}<br>
                Telp: {{ $fakturPembelian->perusahaan->telepon ?? '(021) 1234567' }}
                | Email: {{ $fakturPembelian->perusahaan->email ?? 'info@perusahaananda.com' }}
                @else
                Alamat Lengkap<br>
                Telp: (021) 1234567 | Email: info@perusahaananda.com
                @endif
            </p>
        </div>

        <div class="invoice-info">
            <div class="invoice-title">FAKTUR PEMBELIAN</div>
            <div class="invoice-number">{{ $fakturPembelian->nomor_faktur ?? '-' }}</div>
            <div>{{ \Carbon\Carbon::parse($fakturPembelian->tanggal ?? now())->format('d F Y') }}</div>
        </div>
    </div>

    <!-- Informasi Pihak -->
    <table>
        <tr>
            <td width="160"><strong>Supplier</strong></td>
            <td>: {{ $fakturPembelian->supplier->nama_supplier ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Ditujukan Kepada</strong></td>
            <td>: {{ $fakturPembelian->perusahaan->nama_perusahaan ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Status</strong></td>
            <td>:
                <strong>
                    @php
                    $status = $fakturPembelian->status ?? 'Belum Lunas';
                    @endphp
                    @if($status == 'Lunas')
                    ✅ LUNAS
                    @elseif($status == 'Belum Lunas')
                    ⏳ BELUM LUNAS
                    @else
                    ❌ DIBATALKAN
                    @endif
                </strong>
            </td>
        </tr>
    </table>

    <!-- Daftar Barang -->
    <table>
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Nama Barang</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Harga Satuan</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fakturPembelian->detail ?? [] as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->barang->nama_barang ?? $item->nama_barang ?? '-' }}</td>
                <td class="text-center">
                    {{ $item->qty ?? 0 }} {{ $item->satuan ?? 'pcs' }}
                </td>
                <td class="text-end">
                    Rp {{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}
                </td>
                <td class="text-end">
                    Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4">Tidak ada data barang</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Ringkasan -->
    <table class="summary-table">
        <tr>
            <td>Subtotal</td>
            <td class="text-end">Rp {{ number_format($fakturPembelian->subtotal ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>PPN {{ $fakturPembelian->ppn_persen ?? 11 }}%</td>
            <td class="text-end">Rp {{ number_format($fakturPembelian->ppn ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr class="total-row">
            <td><strong>TOTAL</strong></td>
            <td class="text-end"><strong>Rp {{ number_format($fakturPembelian->total ?? 0, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <div class="footer">
        Terima kasih atas kerjasamanya.<br>
        Faktur ini sah dan merupakan bukti pembayaran yang resmi.
    </div>

</body>

</html>
