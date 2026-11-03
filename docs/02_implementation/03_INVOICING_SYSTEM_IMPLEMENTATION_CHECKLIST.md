# 15. Invoicing System Implementation Checklist (CorporateFE & LogisticFE)

> **Document Status**: READY FOR EXECUTION  
> **Preplan Reference**: [01_preplan/25_INVOICING_SYSTEM_IMPLEMENTATION_PREPLAN_CORPORATE_AND_LOGISTIC_FE.md](file:///d:/DevMuncen/BackendCorporateLogistic/docs/01_preplan/25_INVOICING_SYSTEM_IMPLEMENTATION_PREPLAN_CORPORATE_AND_LOGISTIC_FE.md)  
> **Scope**: Step-by-step technical checklist covering Backend API enhancements and full frontend implementations in `LogisticFE` and `CorporateFE`.

---

## Phase 1: Backend API Readiness & Enhancements (`BackendCorporateLogistic`)

### 1.1 Carrier Logistics Invoicing Endpoints
- [ ] **1.1.1** In [app/Http/Controllers/Api/Logistic/Finance/LogisticInvoiceController.php](file:///d:/DevMuncen/BackendCorporateLogistic/app/Http/Controllers/Api/Logistic/Finance/LogisticInvoiceController.php):
  - [ ] Add method `formDependencies(Request $request)`:
    - Query active Corporate Partners linked to this carrier (`LogisticContract` / `RequestOrder`).
    - Query unbilled delivered Waybills and completed Request Orders for the selected `corporate_id`.
    - Provide an auto-generated unique invoice code preview (`INV-LOG/{logistic_id}/{corporate_id}/YYYYMMDD/0001`).
    - Return default carrier bank account credentials from `logistics` record.
  - [ ] Add method `confirmPayment(int $id)`:
    - Verify invoice belongs to the authenticated carrier (`logistic_id`).
    - Update invoice status to `3` (Paid / Settled).
    - Update payment record status to `Confirmed`.
  - [ ] Update `index()` and `show()` to eager load `corporate:id,code,name`, `details`, and `payments`.
- [ ] **1.1.2** In [routes/api.php](file:///d:/DevMuncen/BackendCorporateLogistic/routes/api.php):
  - [ ] Register `GET logistic/finance/invoices/form-dependencies`.
  - [ ] Register `POST logistic/finance/invoices/{id}/confirm-payment`.
  - [ ] Add top-level alias `logistic/invoices` pointing to `LogisticInvoiceController`.

### 1.2 Corporate Invoicing Endpoints (Payables & Proof Upload)
- [ ] **1.2.1** In [app/Http/Controllers/Api/Corporate/Finance/CorporateInvoiceController.php](file:///d:/DevMuncen/BackendCorporateLogistic/app/Http/Controllers/Api/Corporate/Finance/CorporateInvoiceController.php):
  - [ ] Update `index()` to eager load `logistic:id,code,name`, `details`, and `payments`.
  - [ ] Update `show($id)` to include full carrier profile, bank account, and itemized waybill details.
  - [ ] Add method `uploadPaymentProof(Request $request, int $id)`:
    - Validate inputs: `payment_date`, `amount`, `payment_method`, `payment_proof` (image/pdf file), and `notes`.
    - Store uploaded proof in `storage/app/public/payment_proofs/`.
    - Create record in `invoice_payments` with status `Pending`.
    - Update `invoices` with `payment_proof`, `payment_proof_status = 1`, and `status = 'paid' / 2`.
- [ ] **1.2.2** In [routes/api.php](file:///d:/DevMuncen/BackendCorporateLogistic/routes/api.php):
  - [ ] Register `POST corporate/invoices/{id}/payment-proof` in corporate group.

### 1.3 Backend Quality & Linting
- [ ] Run `vendor/bin/pint --dirty --format agent` in `BackendCorporateLogistic`.
- [ ] Verify endpoints with Tinker / local curl or unit tests.

---

## Phase 2: Logistics Carrier Portal Implementation (`LogisticFE`)

### 2.1 Navigation & Layout
- [ ] **2.1.1** In [resources/views/components/sidebar.blade.php](file:///d:/DevMuncen/LogisticFE/resources/views/components/sidebar.blade.php):
  - [ ] Add a new collapsible or direct section: **Finance & Invoicing**.
  - [ ] Add menu item: **Faktur & Tagihan Logistik** (`/finance/invoices`).
  - [ ] Include active state indicator and solar icon `solar:bill-list-bold-duotone`.

### 2.2 BFF Controller & Routing Layer
- [ ] **2.2.1** Create [app/Http/Controllers/LogisticInvoiceController.php](file:///d:/DevMuncen/LogisticFE/app/Http/Controllers/LogisticInvoiceController.php):
  - [ ] `index()`: renders `finance.invoices.index`.
  - [ ] `show($id)`: renders `finance.invoices.show`.
  - [ ] `print($id)`: renders printable view `finance.invoices.print`.
  - [ ] `proxyList(Request $request)`: forwards to `GET /api/logistic/finance/invoices`.
  - [ ] `proxyStore(Request $request)`: forwards to `POST /api/logistic/finance/invoices`.
  - [ ] `proxyShow(Request $request, $id)`: forwards to `GET /api/logistic/finance/invoices/{id}`.
  - [ ] `proxyFormDependencies(Request $request)`: forwards to `GET /api/logistic/finance/invoices/form-dependencies`.
  - [ ] `proxyConfirmPayment(Request $request, $id)`: forwards to `POST /api/logistic/finance/invoices/{id}/confirm-payment`.
- [ ] **2.2.2** In [routes/web.php](file:///d:/DevMuncen/LogisticFE/routes/web.php):
  - [ ] Register web routes: `/finance/invoices`, `/finance/invoices/{id}`, `/finance/invoices/{id}/print`.
  - [ ] Register proxy routes under `api/internal`:
    - `GET /api/internal/finance/invoices`
    - `POST /api/internal/finance/invoices`
    - `GET /api/internal/finance/invoices/{id}`
    - `GET /api/internal/finance/invoices/form-dependencies`
    - `POST /api/internal/finance/invoices/{id}/confirm-payment`

### 2.3 Blade Views & User Interfaces
- [ ] **2.3.1** Create [resources/views/finance/invoices/index.blade.php](file:///d:/DevMuncen/LogisticFE/resources/views/finance/invoices/index.blade.php):
  - [ ] Stat Cards: Total Tagihan, Menunggu Pembayaran, Lunas / Terbayar, Overdue.
  - [ ] Tab Filter: Semua, Draft, Menunggu Pembayaran (Sent), Lunas (Paid), Batal.
  - [ ] Search & Filter Bar: input cari no. invoice/corporate, tombol *Buat Tagihan Baru*, tombol *Refresh Data*.
  - [ ] Invoices Table: No. Invoice, Corporate Partner, Periode & Jatuh Tempo, Total Biaya Ekspedisi, PPN & Diskon, Total Tagihan, Status Badge, Aksi (`Detail`, `Cetak`, `Konfirmasi Lunas`).
- [ ] **2.3.2** Modal Create Invoice in `index.blade.php`:
  - [ ] Step 1: Pilih Corporate Partner (loads unbilled shipments via AJAX).
  - [ ] Step 2: Periode Pengiriman, Jatuh Tempo (Term of Payment 14/30 hari).
  - [ ] Step 3: Interactive Table of unbilled delivered waybills / request orders with checkboxes, route, cargo type, and shipping cost.
  - [ ] Step 4: Financial Summary (Subtotal, Biaya Tambahan/Shunting, Diskon, PPN 11%, Grand Total Tagihan).
  - [ ] Step 5: Rekening Pembayaran (Bank Name, No. Rekening, Atas Nama).
  - [ ] Action buttons: *Simpan Draft* & *Terbitkan & Kirim Tagihan*.
- [ ] **2.3.3** Modal Detail Invoice in `index.blade.php`:
  - [ ] Invoice header, corporate profile, due date, status badge.
  - [ ] Bank transfer instruction details.
  - [ ] Itemized waybill table (No. Waybill / Resi, Tanggal Kirim, Rute, Armada, Biaya Ekspedisi).
  - [ ] Payment status card & bukti transfer viewer (jika sudah diupload Corporate).
  - [ ] Button *Konfirmasi Pembayaran Lunas* (muncul jika status = Terkirim/Paid).
- [ ] **2.3.4** Create [resources/views/finance/invoices/print.blade.php](file:///d:/DevMuncen/LogisticFE/resources/views/finance/invoices/print.blade.php):
  - [ ] Professional invoice letterhead layout for print/PDF export.

---

## Phase 3: Corporate Merchant Portal Implementation (`CorporateFE`)

### 3.1 Sub-Module 1: Tagihan Logistik / Carrier Freight Payables
- [ ] **3.1.1** In [resources/views/finance/corporate-invoices/index.blade.php](file:///d:/DevMuncen/CorporateFE/resources/views/finance/corporate-invoices/index.blade.php):
  - [ ] Stat Cards: Total Tagihan Logistik, Belum Dibayar, Sudah Lunas.
  - [ ] Invoices Table: No. Invoice Logistik, Vendor Transporter, Periode, Ref Waybills, Biaya Ekspedisi, Status Pembayaran, Aksi (`Rincian & Bayar`).
  - [ ] Modal Detail & Rincian Waybill:
    - List of waybill shipments billed in this invoice.
    - Comparison against frozen contract snapshot tariff.
    - Vendor bank account details for transfer.
  - [ ] Modal Upload Bukti Transfer:
    - Form: Bank Pengirim, No. Referensi Transaksi, Tanggal Transfer, Catatan Pembayaran.
    - File upload: Bukti transfer (JPG/PNG/PDF).
    - Submit to `/api/internal/corporate/finance/invoices/{id}/payment-proof`.
- [ ] **3.1.2** In [app/Http/Controllers/DistributorInvoiceController.php](file:///d:/DevMuncen/CorporateFE/app/Http/Controllers/DistributorInvoiceController.php):
  - [ ] Add `proxyUploadFreightPaymentProof(Request $request, $id)` forwarding to `POST /api/corporate/invoices/{id}/payment-proof`.
- [ ] **3.1.3** In [routes/web.php](file:///d:/DevMuncen/CorporateFE/routes/web.php):
  - [ ] Register `POST /api/finance/corporate-invoices/{id}/payment-proof` and internal proxy route.

### 3.2 Sub-Module 2: Faktur Pelanggan / Distributor Commercial Receivables
- [ ] **3.2.1** In [resources/views/finance/distributor-invoices/index.blade.php](file:///d:/DevMuncen/CorporateFE/resources/views/finance/distributor-invoices/index.blade.php):
  - [ ] Stat Cards: Total Piutang Produk, Belum Terbayar, Sudah Lunas.
  - [ ] Add Button: **"Buat Faktur Penagihan Distributor"**.
  - [ ] Modal Generate Faktur Distributor:
    - Pilih Distributor / Customer Mitra.
    - Load delivered waybills (`form-dependencies`).
    - Load received product SKU items, received quantities, and unit wholesale prices.
    - Set Tax (PPN 11% / 1.1% / Non-PPN) and Due Date.
    - Submit to `/api/finance/distributor-invoices/process-inbound` (or standard store).
  - [ ] Modal Detail Faktur Komersial:
    - Rincian item produk per SKU (Kode Barang, Nama Produk, Qty, Harga Satuan, Subtotal).
    - Status pembayaran distributor.
    - Bukti bayar distributor viewer & tombol *Validasi Pembayaran Lunas*.
  - [ ] Printable Commercial Invoice modal / button.

---

## Phase 4: Integration Simulation & Verification Checklist

- [ ] **4.1 Track A (Carrier Freight Billing) Flow Verification**:
  - [ ] 1. Carrier in `LogisticFE` opens `/finance/invoices` $\rightarrow$ clicks *Buat Tagihan Baru*.
  - [ ] 2. Selects Corporate Partner $\rightarrow$ unbilled waybills appear $\rightarrow$ selects waybills $\rightarrow$ submits invoice.
  - [ ] 3. Invoice successfully appears in `LogisticFE` table with status `Terkirim / Sent`.
  - [ ] 4. Corporate logs into `CorporateFE` $\rightarrow$ opens `/finance/corporate-invoices` $\rightarrow$ sees the new invoice.
  - [ ] 5. Corporate inspects waybills $\rightarrow$ clicks *Upload Bukti Bayar* $\rightarrow$ submits payment proof.
  - [ ] 6. Carrier in `LogisticFE` sees payment proof $\rightarrow$ clicks *Konfirmasi Lunas* $\rightarrow$ status updates to `Lunas / Paid`.
- [ ] **4.2 Track B (Distributor Product Billing) Flow Verification**:
  - [ ] 1. Corporate in `CorporateFE` opens `/finance/distributor-invoices` $\rightarrow$ clicks *Buat Faktur Penagihan*.
  - [ ] 2. Selects Distributor $\rightarrow$ selects delivered waybill $\rightarrow$ verifies SKU items $\rightarrow$ generates invoice.
  - [ ] 3. Distributor invoice appears with correct total, VAT, and SKU breakdown.
- [ ] **4.3 UI Polish & Aesthetics Verification**:
  - [ ] Dark mode compatibility across all modals and tables.
  - [ ] Proper currency formatting (`Rp X.XXX.XXX`) and date formatting (`DD MMM YYYY`).
  - [ ] Mobile responsive layout testing on both portals.
