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
<body>
    <div class="no-print" style="margin-bottom: 15px; display: flex; gap: 8px;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #1e3a8a; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
            Cetak Dokumen
        </button>
        <button onclick="window.close()" style="padding: 8px 16px; background: #64748b; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
            Tutup
        </button>
    </div>

    <div class="header">
        <div>
            <div class="company-title" id="wbCorpName">PT MUNCEN KORPORASI MERAH PUTIH</div>
            <div id="wbCorpDiv">Divisi Rantai Pasok &amp; Logistik Nasional</div>
            <div id="wbCorpAddr">Kawasan Industri Jababeka Blok C-12, Cikarang, Bekasi</div>
        </div>
        <div>
            <div class="doc-title">SURAT JALAN PENGIRIMAN</div>
            <div style="font-family: monospace; font-size: 13px; font-weight: bold; color: #1e3a8a;" id="wbNumber">WB-Loading...</div>
            <div style="font-size: 10px; color: #64748b;" id="wbDate">Tanggal: {{ date('d F Y') }}</div>
            <div style="font-size: 10px; font-weight: bold; color: #4338ca;" id="wbRoNumber">Ref RO: -</div>
        </div>
    </div>

    <div class="meta-grid">
        <div class="meta-box">
            <h4>1. Pengirim / Gudang Asal</h4>
            <div id="originText">
                <strong id="originName">Gudang Asal</strong><br>
                <span id="originAddress">-</span><br>
                <span id="originCity">-</span>
            </div>
        </div>
        <div class="meta-box">
            <h4>2. Penerima / Lokasi Bongkar</h4>
            <div id="destText">
                <strong id="destCustomer">Penerima</strong><br>
                <span id="destAddress">-</span><br>
                <span id="destCity">-</span>
            </div>
        </div>
    </div>

    <div class="meta-box" style="margin-bottom: 15px;">
        <h4>Informasi Armada &amp; Pengemudi</h4>
        <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
            <span>Transporter: <strong id="transporterName">Muncen Logistics</strong></span>
            <span>Tipe Armada: <strong id="fleetTypeName">Dedicated Fleet</strong></span>
            <span>No. Polisi: <strong id="plateNumber" style="font-family: monospace;">-</strong></span>
            <span>Pengemudi: <strong id="driverName">Driver Bertugas</strong></span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px; text-align: center;">No</th>
                <th style="width: 100px;">Kode SKU</th>
                <th>Nama Barang / Deskripsi Muatan</th>
                <th style="width: 80px; text-align: center;">Jumlah</th>
                <th style="width: 90px; text-align: right;">Berat (Kg)</th>
                <th>Keterangan / Kondisi</th>
            </tr>
        </thead>
        <tbody id="itemsBody">
            <tr>
                <td colspan="6" style="text-align: center; padding: 12px; color: #64748b;">Memuat data muatan...</td>
            </tr>
        </tbody>
        <tfoot>
            <tr style="background: #f8fafc; font-weight: bold;">
                <td colspan="3" style="text-align: right; text-transform: uppercase;">Total Ringkasan:</td>
                <td id="footKoli" style="text-align: center;">-</td>
                <td id="footWeight" style="text-align: right;">-</td>
                <td>Direct Point-to-Point</td>
            </tr>
        </tfoot>
    </table>

    <div class="signatures">
        <div>
            <div style="margin-bottom: 8px;">Yang Menyerahkan (Gudang Asal)</div>
            <div class="sig-box">( Petugas Pemuatan )</div>
        </div>
        <div>
            <div style="margin-bottom: 8px;">Yang Membawa (Supir/Transporter)</div>
            <div class="sig-box" id="sigDriver">( Pengemudi Armada )</div>
        </div>
        <div>
            <div style="margin-bottom: 8px;">Yang Menerima (Customer/Penerima)</div>
            <div class="sig-box" id="sigCustomer">( Tanda Tangan &amp; Cap Toko )</div>
        </div>
    </div>

    <div style="margin-top: 30px; font-size: 9px; color: #64748b; border-top: 1px solid #e2e8f0; padding-top: 8px;">
        * Lembar 1: Pengirim | Lembar 2: Transporter / Supir | Lembar 3: Penerima / Arsip Toko | Sistem Terintegrasi Korporasi Merah Putih
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const pathParts = window.location.pathname.split('/');
            const id = pathParts[pathParts.length - 2] || pathParts[pathParts.length - 1];

            try {
                const res = await axios.get(`/api/waybills/${id}`);
                const wb = res.data?.data;
                if (!wb) return;

                // Basic meta
                document.getElementById('wbNumber').innerText = wb.waybill_number || ('WB-#' + wb.id);
                if (wb.created_at) {
                    const d = new Date(wb.created_at);
                    document.getElementById('wbDate').innerText = 'Tanggal: ' + d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                }

                // Corporate
                if (wb.corporate?.name) {
                    document.getElementById('wbCorpName').innerText = wb.corporate.name;
                }

                // Reference RO
                const roId = wb.request_order_id || wb.request_order?.id;
                const roNum = wb.request_order?.order_number || wb.request_order?.ro_number || (roId ? 'RO-#' + roId : '-');
                document.getElementById('wbRoNumber').innerText = 'Ref RO: ' + roNum;

                // Shipper
                const originWh = wb.origin_warehouse?.name || wb.request_order?.origin_warehouse?.name || 'Gudang Pusat';
                const originAddr = wb.origin_warehouse?.address || wb.request_order?.sender_address || '-';
                const originCity = wb.origin_city_name || wb.origin_warehouse?.city?.name || wb.request_order?.origin_city?.name || '-';
                document.getElementById('originName').innerText = originWh;
                document.getElementById('originAddress').innerText = originAddr;
                document.getElementById('originCity').innerText = originCity;

                // Consignee
                const custName = wb.customer?.name || wb.request_order?.customer_name || 'Pelanggan Korporasi';
                const destAddr = wb.destination_address || wb.destination_city_name || '-';
                const destCity = wb.destination_city_name || wb.customer?.city?.name || wb.request_order?.destination_city?.name || '-';
                document.getElementById('destCustomer').innerText = custName;
                document.getElementById('destAddress').innerText = destAddr;
                document.getElementById('destCity').innerText = destCity;
                document.getElementById('sigCustomer').innerText = `( ${custName} )`;

                // Transporter & Driver
                const transp = wb.request_order?.logistic?.name || wb.logistic?.name || 'PT Logistik Merah Putih';
                const fleet = wb.request_order?.fleet_type?.name || wb.fleet_type?.name || 'Dedicated Cargo';
                const plate = wb.plate_number || 'Armada Dedicated';
                const driver = wb.driver_name || 'Driver Dedicated';
                document.getElementById('transporterName').innerText = transp;
                document.getElementById('fleetTypeName').innerText = fleet;
                document.getElementById('plateNumber').innerText = plate;
                document.getElementById('driverName').innerText = driver;
                document.getElementById('sigDriver').innerText = `( ${driver} )`;

                // Manifest items
                let rawItems = [];
                if (Array.isArray(wb.manifest_items) && wb.manifest_items.length) {
                    rawItems = wb.manifest_items;
                } else if (Array.isArray(wb.items_payload) && wb.items_payload.length) {
                    rawItems = wb.items_payload;
                } else if (Array.isArray(wb.request_order?.cargo_items) && wb.request_order.cargo_items.length) {
                    rawItems = wb.request_order.cargo_items;
                } else if (Array.isArray(wb.request_order?.items) && wb.request_order.items.length) {
                    rawItems = wb.request_order.items;
                }

                const roItemsList = wb.request_order?.cargo_items || wb.request_order?.items || [];
                const roProductMap = {};
                if (Array.isArray(roItemsList)) {
                    roItemsList.forEach(r => {
                        const pid = r.product_id || r.id;
                        if (pid) roProductMap[pid] = r;
                    });
                }

                const initialTotalWeight = Number(wb.total_weight || wb.request_order?.total_weight_kg || wb.request_order?.total_weight || 0);

                if (!rawItems.length) {
                    const fallbackWeight = initialTotalWeight > 0 ? initialTotalWeight : 50;
                    document.getElementById('itemsBody').innerHTML = `
                        <tr>
                            <td style="text-align: center;">1</td>
                            <td style="font-family: monospace;">-</td>
                            <td>Kargo Muatan FTL (General Cargo Langsung dari Gudang)</td>
                            <td style="text-align: center;">${wb.total_koli || 1} Koli</td>
                            <td style="text-align: right;">${fallbackWeight.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} Kg</td>
                            <td>Kondisi Baik &amp; Tersegel</td>
                        </tr>
                    `;
                    document.getElementById('footKoli').innerText = (wb.total_koli || 1) + ' Koli';
                    document.getElementById('footWeight').innerText = fallbackWeight.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' Kg';
                } else {
                    let koliSum = 0;
                    let weightSum = 0;
                    let itemsWithoutWeightCount = 0;

                    const parsedItems = rawItems.map((it, idx) => {
                        const qty = Number(it.quantity || it.qty || 1);
                        koliSum += qty;

                        const pid = it.product_id || it.id;
                        const roRef = pid && roProductMap[pid] ? roProductMap[pid] : null;

                        let rowWeight = null;
                        if (it.subtotal_weight != null && it.subtotal_weight !== '' && !isNaN(it.subtotal_weight) && Number(it.subtotal_weight) > 0) {
                            rowWeight = Number(it.subtotal_weight);
                        } else if (it.weight_per_unit != null && it.weight_per_unit !== '' && !isNaN(it.weight_per_unit) && Number(it.weight_per_unit) > 0) {
                            rowWeight = Number(it.weight_per_unit) * qty;
                        } else if (it.weight_kg != null && it.weight_kg !== '' && !isNaN(it.weight_kg) && Number(it.weight_kg) > 0) {
                            rowWeight = Number(it.weight_kg);
                        } else if (it.weight != null && it.weight !== '' && !isNaN(it.weight) && Number(it.weight) > 0) {
                            rowWeight = Number(it.weight);
                        } else if (it.product?.weight_kg != null && !isNaN(it.product.weight_kg) && Number(it.product.weight_kg) > 0) {
                            rowWeight = Number(it.product.weight_kg) * qty;
                        } else if (roRef?.subtotal_weight != null && Number(roRef.subtotal_weight) > 0) {
                            rowWeight = Number(roRef.subtotal_weight);
                        } else if (roRef?.weight_per_unit != null && Number(roRef.weight_per_unit) > 0) {
                            rowWeight = Number(roRef.weight_per_unit) * qty;
                        } else if (roRef?.product?.weight_kg != null && Number(roRef.product.weight_kg) > 0) {
                            rowWeight = Number(roRef.product.weight_kg) * qty;
                        } else if (it.tonase != null && !isNaN(it.tonase) && Number(it.tonase) > 0) {
                            rowWeight = Number(it.tonase);
                        }

                        if (rowWeight != null && rowWeight > 0) {
                            weightSum += rowWeight;
                        } else {
                            itemsWithoutWeightCount++;
                        }

                        const sku = it.product_sku || it.sku || it.product?.sku || roRef?.product_sku || roRef?.sku || '-';
                        const desc = it.product_name || it.name || it.product?.name || roRef?.product_name || roRef?.product?.name || it.notes || ('Produk #' + (pid || (idx + 1)));
                        const notes = it.notes || 'Kondisi Baik &amp; Tersegel';

                        return { it, idx, qty, sku, desc, notes, rowWeight };
                    });

                    let finalTotalWeight = initialTotalWeight > 0 ? initialTotalWeight : weightSum;
                    if (itemsWithoutWeightCount > 0 && finalTotalWeight > weightSum && koliSum > 0) {
                        const remainingWeight = finalTotalWeight - weightSum;
                        let unallocatedKoliSum = 0;
                        parsedItems.forEach(item => {
                            if (item.rowWeight == null || item.rowWeight <= 0) unallocatedKoliSum += item.qty;
                        });

                        parsedItems.forEach(item => {
                            if (item.rowWeight == null || item.rowWeight <= 0) {
                                if (unallocatedKoliSum > 0) {
                                    item.rowWeight = (item.qty / unallocatedKoliSum) * remainingWeight;
                                }
                            }
                        });
                        weightSum = finalTotalWeight;
                    } else if (finalTotalWeight <= 0 && weightSum > 0) {
                        finalTotalWeight = weightSum;
                    }

                    document.getElementById('itemsBody').innerHTML = parsedItems.map(item => {
                        let weightText = '-';
                        if (item.rowWeight != null && !isNaN(item.rowWeight) && item.rowWeight > 0) {
                            weightText = `${Number(item.rowWeight).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} Kg`;
                        } else if (finalTotalWeight > 0 && koliSum > 0) {
                            const distributed = (item.qty / koliSum) * finalTotalWeight;
                            weightText = `${Number(distributed).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} Kg`;
                        } else {
                            weightText = '0.00 Kg';
                        }

                        return `
                            <tr>
                                <td style="text-align: center;">${item.idx + 1}</td>
                                <td style="font-family: monospace;">${item.sku}</td>
                                <td>${item.desc}</td>
                                <td style="text-align: center;">${item.qty} Koli</td>
                                <td style="text-align: right;">${weightText}</td>
                                <td>${item.notes}</td>
                            </tr>
                        `;
                    }).join('');

                    const displayKoli = wb.total_koli || koliSum;
                    const displayWeight = finalTotalWeight > 0 ? finalTotalWeight : weightSum;

                    document.getElementById('footKoli').innerText = displayKoli + ' Koli';
                    document.getElementById('footWeight').innerText = `${Number(displayWeight).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} Kg`;
                }
            } catch (err) {
                console.error('Fetch waybill print error:', err);
            }
        });
    </script>
</body>
</html>
