<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Faktur Pembelian - {{ $fakturPembelian->nomor_faktur ?? 'NO-FAKTUR' }}</title>

    <style>
    @page {
        size: A4 portrait;
        margin: 12mm 15mm;
    }

    body {
        font-family: 'Arial', 'Helvetica', sans-serif;
        font-size: 13.5px;
        line-height: 1.6;
        color: #1f2937;
        background: #fff;
    }

    .invoice-container {
        max-width: 100%;
    }

    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 25px;
        margin-bottom: 35px;
        border-bottom: 4px solid #1e40af;
    }

    .company-info h1 {
        margin: 0;
        font-size: 28px;
        color: #1e40af;
        font-weight: bold;
    }

    .company-info p {
        margin: 8px 0 0 0;
        font-size: 13px;
        color: #374151;
        line-height: 1.5;
    }

    .invoice-info {
        text-align: right;
    }

    .invoice-title {
        font-size: 36px;
        font-weight: 800;
        color: #1e40af;
        letter-spacing: -1px;
        margin: 0 0 6px 0;
    }

    .invoice-number {
        font-size: 17px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 4px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        padding: 13px 10px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    th {
        background-color: #f8fafc;
        font-weight: 700;
        color: #1e40af;
        font-size: 14px;
    }

    .text-end {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .summary-table {
        width: 420px;
        margin-left: auto;
        margin-top: 40px;
        border: 3px solid #1e40af;
        border-radius: 8px;
        overflow: hidden;
    }

    .summary-table td {
        padding: 13px 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .summary-table tr:last-child td {
        border-bottom: none;
    }

    .total-row {
        background-color: #eff6ff;
        font-size: 18px;
        font-weight: bold;
    }

    .footer {
        margin-top: 80px;
        text-align: center;
        font-size: 13px;
        color: #6b7280;
        line-height: 1.6;
    }
    </style>
</head>

<body onload="window.print()">

    <div class="invoice-container">

        <!-- Header -->
        <div class="invoice-header">
            <!-- Company Info -->
            <div class="company-info">
                <h1>{{ $fakturPembelian->perusahaan->nama_perusahaan ?? 'Nama Perusahaan Anda' }}</h1>
                <p>
                    @if($fakturPembelian->perusahaan)
                    {{ $fakturPembelian->perusahaan->alamat ?? '-' }}<br>
                    Telp: {{ $fakturPembelian->perusahaan->telepon ?? '-' }}
                    | Email: {{ $fakturPembelian->perusahaan->email ?? '-' }}
                    @else
                    Alamat Lengkap<br>
                    Telp: (021) 1234567 | Email: info@perusahaananda.com
                    @endif
                </p>
            </div>

            <!-- Invoice Info -->
            <div class="invoice-info">
                <div class="invoice-title">FAKTUR PEMBELIAN</div>
                <div class="invoice-number">No. {{ $fakturPembelian->nomor_faktur ?? '-' }}</div>
                <div>{{ \Carbon\Carbon::parse($fakturPembelian->tanggal ?? now())->format('d F Y') }}</div>
            </div>
        </div>

        <!-- Info Supplier -->
        <table>
            <tr>
                <td width="160"><strong>Supplier</strong></td>
                <td>: <strong>{{ $fakturPembelian->supplier->nama_supplier ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td><strong>Ditujukan Kepada</strong></td>
                <td>: {{ $fakturPembelian->perusahaan->nama_perusahaan ?? '-' }}</td>
            </tr>
        </table>

        <!-- Ringkasan -->
        <table class="summary-table">
            <tr>
                <td>Subtotal</td>
                <td class="text-end">Rp {{ number_format($fakturPembelian->subtotal ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>PPN ({{ $fakturPembelian->ppn_persen ?? 11 }}%)</td>
                <td class="text-end">Rp {{ number_format($fakturPembelian->ppn ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td><strong>TOTAL</strong></td>
                <td class="text-end"><strong>Rp {{ number_format($fakturPembelian->total ?? 0, 0, ',', '.') }}</strong>
                </td>
            </tr>
        </table>

        <div class="footer">
            Terima kasih atas kepercayaan dan kerjasamanya.<br>
            <strong>Faktur ini sah dan merupakan bukti pembelian yang resmi.</strong>
        </div>

    </div>

</body>

</html>
