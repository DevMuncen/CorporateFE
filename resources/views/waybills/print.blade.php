<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Jalan Pengiriman | Corporate Logistics</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            margin: 0;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }
        .company-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e3a8a;
        }
        .doc-title {
            font-size: 14px;
            font-weight: bold;
            text-align: right;
            text-transform: uppercase;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        .meta-box {
            border: 1px solid #cbd5e1;
            padding: 10px;
            border-radius: 6px;
        }
        .meta-box h4 {
            margin: 0 0 6px 0;
            font-size: 11px;
            text-transform: uppercase;
            color: #475569;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            text-transform: uppercase;
            font-size: 10px;
        }
        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            text-align: center;
            margin-top: 30px;
            gap: 20px;
        }
        .sig-box {
            border-top: 1px dashed #64748b;
            padding-top: 50px;
            font-weight: bold;
        }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #1e3a8a; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
            Cetak Dokumen
        </button>
    </div>

    <div class="header">
        <div>
            <div class="company-title">PT MUNCEN KORPORASI MERAH PUTIH</div>
            <div>Divisi Rantai Pasok &amp; Logistik Nasional</div>
            <div>Kawasan Industri Jababeka Blok C-12, Cikarang, Bekasi</div>
        </div>
        <div>
            <div class="doc-title">SURAT JALAN PENGIRIMAN</div>
            <div style="font-family: monospace; font-size: 12px; font-weight: bold;" id="wbNumber">WB-{{ date('Ymd') }}-001</div>
            <div style="font-size: 10px; color: #64748b;">Tanggal: {{ date('d F Y') }}</div>
        </div>
    </div>

    <div class="meta-grid">
        <div class="meta-box">
            <h4>Pengirim / Gudang Asal</h4>
            <div id="originText"><strong>Hub Cikarang</strong><br>Kawasan Industri Jababeka, Bekasi<br>PIC: Bpk. Herman (08123456789)</div>
        </div>
        <div class="meta-box">
            <h4>Penerima / Lokasi Bongkar</h4>
            <div id="destText"><strong>Toko Mitra Grosir Jaya</strong><br>Jl. Raya Kopo No. 120, Kota Bandung<br>PIC: Ibu Ratna (08198765432)</div>
        </div>
    </div>

    <div class="meta-box" style="margin-bottom: 15px;">
        <h4>Informasi Armada &amp; Pengemudi</h4>
        <div style="display: flex; justify-content: space-between;">
            <span>Transporter: <strong>Muncen Express Logistics</strong></span>
            <span>No. Polisi: <strong>B 9123 MCN</strong></span>
            <span>Pengemudi: <strong>Agus Supriyanto</strong></span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Kode SKU</th>
                <th>Nama Barang / Deskripsi</th>
                <th style="width: 70px; text-align: center;">Jumlah (Qty)</th>
                <th style="width: 80px; text-align: right;">Berat (Kg)</th>
                <th>Keterangan / Kondisi</th>
            </tr>
        </thead>
        <tbody id="itemsBody">
            <tr>
                <td style="text-align: center;">1</td>
                <td style="font-family: monospace;">SKU-BRG-001</td>
                <td>Beras Premium Cap Muncen 5kg</td>
                <td style="text-align: center;">100 Sak</td>
                <td style="text-align: right;">500 kg</td>
                <td>Kondisi Baik &amp; Segel Utuh</td>
            </tr>
            <tr>
                <td style="text-align: center;">2</td>
                <td style="font-family: monospace;">SKU-MYK-002</td>
                <td>Minyak Goreng Pouch 2L (Karton @6 pouch)</td>
                <td style="text-align: center;">50 Karton</td>
                <td style="text-align: right;">600 kg</td>
                <td>Kondisi Baik &amp; Segel Utuh</td>
            </tr>
        </tbody>
    </table>

    <div class="signatures">
        <div>
            <div style="margin-bottom: 8px;">Yang Menyerahkan (Gudang Asal)</div>
            <div class="sig-box">( Petugas Pemuatan )</div>
        </div>
        <div>
            <div style="margin-bottom: 8px;">Yang Membawa (Supir/Transporter)</div>
            <div class="sig-box">( Pengemudi Armada )</div>
        </div>
        <div>
            <div style="margin-bottom: 8px;">Yang Menerima (Customer/Penerima)</div>
            <div class="sig-box">( Tanda Tangan &amp; Cap Toko )</div>
        </div>
    </div>

    <div style="margin-top: 30px; font-size: 9px; color: #64748b; border-top: 1px solid #e2e8f0; padding-top: 8px;">
        * Lembar 1: Pengirim | Lembar 2: Transporter / Supir | Lembar 3: Penerima / Arsip Toko
    </div>
</body>
</html>
