# 25. Dual-Track Invoicing System Architecture & Implementation Preplan (CorporateFE & LogisticFE)

> **Document Status**: READY FOR REVIEW  
> **Author**: Antigravity Core Architect  
> **Scope**: Comprehensive architecture, schema mapping, and end-to-end integration preplan for implementing the complete Invoicing System across **`BackendCorporateLogistic`**, **`CorporateFE`**, and **`LogisticFE`**.

---

## 1. Executive Summary & Architectural Overview

The enterprise platform architecture establishes **two parallel, non-overlapping financial billing tracks** connecting Corporate Merchants, Logistics Carriers, and Regional Distributors:

```
                                  ┌────────────────────────────────────────────────────────┐
                                  │             Corporate Enterprise (Owner)               │
                                  └───────────┬────────────────────────────────┬───────────┘
                                              │                                │
                     ┌────────────────────────┴────────┐              ┌────────┴────────────────────────┐
                     │   TRACK A: Carrier Freight      │              │   TRACK B: Distributor Goods    │
                     │   (Logistic Freight Payables)   │              │   (Commercial Sales Receivables)│
                     └────────────────┬────────────────┘              └────────┬────────────────────────┘
                                      │                                        │
                                      ▼                                        ▼
                       ┌──────────────────────────────┐         ┌──────────────────────────────┐
                       │ Logistics Carrier (Vendor)   │         │ Distributor / B2B Customer   │
                       ├──────────────────────────────┤         ├──────────────────────────────┤
                       │ Model: Invoice               │         │ Model: DistributorInvoice    │
                       │ Table: invoices              │         │ Table: distributor_invoices  │
                       │ Item: invoice_details        │         │ Item: distributor_invoice_items
                       │ Pay: invoice_payments        │         │ Pay: distributor_invoice_payments
                       │ Portal: LogisticFE           │         │ Portal: CorporateFE          │
                       └──────────────────────────────┘         └──────────────────────────────┘
```

### 1.1 Track A: Carrier Logistics Freight Invoicing
- **Creditor (Issuer)**: Logistics Carrier (`logistics`).
- **Debtor (Payer)**: Corporate Enterprise (`corporates`).
- **Core Purpose**: Billing for physical freight transportation, linehaul rates, shunting, and multi-drop surcharges.
- **Underlying Documents**: Request Orders (`request_orders`) and Delivery Waybills (`waybills`).
- **Primary Actors**:
  - `LogisticFE`: Carrier generates freight invoices for delivered waybills/ROs, sets due dates and bank accounts, and confirms payment receipts.
  - `CorporateFE`: Corporate inspects freight invoices, audits billed rates against agreed contract/snapshot pricing, and uploads payment proof.

### 1.2 Track B: Distributor Wholesale Product Invoicing
- **Creditor (Issuer)**: Corporate Enterprise (`corporates`).
- **Debtor (Payer)**: Regional Distributor or B2B Customer (`corporate_distributors` / `corporate_customers`).
- **Core Purpose**: Commercial invoicing for delivered wholesale inventory items, calculated per product SKU.
- **Underlying Documents**: Completed Delivery Waybills (`waybills`) and received SKU items (`waybill_items`).
- **Primary Actors**:
  - `CorporateFE`: Corporate auto-generates or drafts product invoices upon waybill delivery confirmation, itemizes SKU quantities and wholesale prices, and tracks distributor payments.

---

## 2. Multi-Domain Technical Comparison & Schema Matrix

| Dimension | **Track A: Carrier Freight Invoicing** | **Track B: Distributor Product Invoicing** |
| :--- | :--- | :--- |
| **Issuer Entity** | Logistics Carrier (`logistic_id`) | Corporate Enterprise (`corporate_id`) |
| **Recipient Entity** | Corporate Enterprise (`corporate_id`) | Regional Distributor (`distributor_id`) |
| **Frontend Portal (Issuer)** | **`LogisticFE`** (`/finance/invoices`) | **`CorporateFE`** (`/finance/distributor-invoices`) |
| **Frontend Portal (Debtor)** | **`CorporateFE`** (`/finance/corporate-invoices`) | `DistributorDevelopment` / B2B Portal |
| **Main Table** | `invoices` | `distributor_invoices` |
| **Item Detail Table** | `invoice_details` | `distributor_invoice_items` |
| **Payment Table** | `invoice_payments` | `distributor_invoice_payments` |
| **Item Granularity** | **Shipment / Waybill Spread** (`waybill_id`, `request_order_id`, freight cost, additional cost, discount) | **Product SKU Item Spread** (`corporate_product_id`, SKU, received qty, unit price, tax, subtotal) |
| **Freight Charge Handling** | **INCLUDED** (Main substance of invoice) | **EXCLUDED** (Product cost only) |
| **Tax Regime** | Transport VAT (Tax Type 1=Exclude, 2=Include) | Commercial Goods VAT (PPN 11% / 1.1%) |
| **Lifecycle Statuses** | `1=Draft`, `2=Sent/Issued`, `3=Paid`, `4=Canceled` | `0=Draft`, `1=Issued`, `2=Paid`, `3=Confirmed`, `4=Canceled`, `5=Rejected` |

---

## 3. End-to-End Data Flow & State Machine

### 3.1 Track A: Carrier Freight Billing Lifecycle

```
[Carrier: LogisticFE]
Waybills Delivered / RO Completed
         │
         ▼
Carrier creates Freight Invoice ──► status: 1 (Draft) or 2 (Sent)
(Picks Corporate, Unbilled Waybills, Bank Details)
         │
         ▼
[Corporate: CorporateFE]
Corporate views Carrier Invoice (`/finance/corporate-invoices`)
Audits Freight Charges vs Snapshot Pricing
         │
         ▼
Corporate executes Bank Transfer & Uploads Payment Proof
(Updates invoice payment proof metadata & inserts `invoice_payments`)
         │
         ▼
[Carrier: LogisticFE]
Carrier verifies transfer on bank account & clicks "Konfirmasi Lunas"
         │
         ▼
Status transitions to: 3 (Paid / Settled)
Waybills marked as fully settled.
```

### 3.2 Track B: Distributor Commercial Product Billing Lifecycle

```
[Corporate: CorporateFE]
Waybill Delivery Completed at Destination Drop
         │
         ▼
Corporate opens `/finance/distributor-invoices`
Calls `form-dependencies` to load unbilled delivered waybills
         │
         ▼
Corporate generates Distributor Invoice (status: 1 Issued)
Copies snapshot product SKUs, received quantities, and unit prices
         │
         ▼
Distributor receives Commercial Invoice PDF & pays corporate
Corporate records payment / validates proof
         │
         ▼
Status transitions to: 2 (Paid) ──► 3 (Confirmed / Settled)
```

---

## 4. Backend API Layer Specifications (`BackendCorporateLogistic`)

### 4.1 Carrier Logistics Finance Endpoints
- **Base Route**: `/api/logistic/finance/invoices` (with alias `/api/logistic/invoices`)
- **Controller**: `App\Http\Controllers\Api\Logistic\Finance\LogisticInvoiceController`

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/logistic/finance/invoices` | List carrier invoices with multi-tenant filtering (`status`, `corporate_id`, `date_from`, `date_to`, `search`). |
| `GET` | `/api/logistic/finance/invoices/{id}` | Detail carrier invoice with `details` and `payments`. |
| `POST` | `/api/logistic/finance/invoices` | Create new carrier invoice with itemized waybills/RO details. |
| `GET` | `/api/logistic/finance/invoices/form-dependencies` | *(To add)* Returns active corporate clients, unbilled delivered waybills/ROs with calculated freight, and auto-suggested invoice number. |
| `POST` | `/api/logistic/finance/invoices/{id}/confirm-payment` | *(To add)* Carrier marks invoice as confirmed/paid upon verifying bank funds. |

### 4.2 Corporate Carrier Invoices Endpoints (Payables)
- **Base Route**: `/api/corporate/invoices`
- **Controller**: `App\Http\Controllers\Api\Corporate\Finance\CorporateInvoiceController`

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/corporate/invoices` | List freight bills from carriers scoped to `corporate_id`. Filter by `type=logistic`, `status=unpaid\|paid`. |
| `GET` | `/api/corporate/invoices/{id}` | Detail of freight bill with linehaul/shunting breakdown. |
| `POST` | `/api/corporate/invoices/{id}/payment-proof` | *(To add)* Upload bank payment receipt, amount, and notes. |

### 4.3 Corporate Distributor Invoices Endpoints (Receivables)
- **Base Route**: `/api/corporate/finance/distributor-invoices`
- **Controller**: `App\Http\Controllers\Api\Corporate\Finance\DistributorInvoiceController`

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/corporate/finance/distributor-invoices` | List distributor commercial invoices. |
| `GET` | `/api/corporate/finance/distributor-invoices/{id}` | Detailed product invoice with SKU lines and payments. |
| `GET` | `/api/corporate/finance/distributor-invoices/form-dependencies` | Returns distributors and unbilled waybills available for invoicing. |
| `POST` | `/api/corporate/finance/distributor-invoices/process-inbound` | Creates distributor invoice directly from delivered waybill items. |

---

## 5. Frontend Implementation Architecture

### 5.1 Portal A: Logistics Carrier Portal (`LogisticFE`)

#### 1. Navigation & Sidebar
Add **Finance & Billing** menu in `resources/views/components/sidebar.blade.php`:
- Item: **Faktur & Tagihan Logistik** (`/finance/invoices`)
- Icon: `solar:bill-list-bold-duotone`
- Badges: Count of pending unpaid invoices.

#### 2. BFF Controller & Web Routes
- File: `app/Http/Controllers/LogisticInvoiceController.php` (extending `ProxyController`).
- Web routes:
  - `GET /finance/invoices`: View invoice management page.
  - `GET /finance/invoices/{id}/print`: Printable commercial invoice layout.
- Proxy routes under `api/internal/finance/invoices`:
  - `GET /api/internal/finance/invoices` $\rightarrow$ forwards to `GET /api/logistic/finance/invoices`
  - `POST /api/internal/finance/invoices` $\rightarrow$ forwards to `POST /api/logistic/finance/invoices`
  - `GET /api/internal/finance/invoices/{id}` $\rightarrow$ forwards to `GET /api/logistic/finance/invoices/{id}`
  - `GET /api/internal/finance/invoices/form-dependencies` $\rightarrow$ forwards to `GET /api/logistic/finance/invoices/form-dependencies`
  - `POST /api/internal/finance/invoices/{id}/confirm-payment` $\rightarrow$ forwards to `POST /api/logistic/finance/invoices/{id}/confirm-payment`

#### 3. Blade Views
- `resources/views/finance/invoices/index.blade.php`:
  - Stat Cards: Total Tagihan, Menunggu Pembayaran, Lunas / Terbayar, Overdue.
  - Filter Bar: Tab Status (`Semua`, `Draft`, `Terkirim`, `Lunas`), Search box, Corporate selector.
  - Invoices Table: No. Invoice, Corporate Partner, Periode & Jatuh Tempo, Total Ekspedisi, PPN & Diskon, Total Tagihan, Status Badge, Aksi (`Detail`, `Cetak`, `Konfirmasi Lunas`).
  - Modal Create Invoice:
    - Select Corporate Partner.
    - Set Periode Pengiriman & Jatuh Tempo (Term of Payment: 14 hari, 30 hari).
    - Table of unbilled delivered waybills / request orders with checkboxes to select items.
    - Automatic calculation of subtotal, additional costs (shunting/multi-stop), discounts, and tax (PPN 11%).
    - Input bank details (Bank Name, No. Rekening, Atas Nama).
    - Save as Draft or Submit/Issue.
  - Modal Detail Invoice:
    - Summary card with QR/barcode, corporate partner, bank transfer instructions.
    - Itemized breakdown table of waybills (No. Resi, Rute Asal-Tujuan, Armada, Biaya Ekspedisi).
    - Payment proof viewer (if uploaded by Corporate).
- `resources/views/finance/invoices/print.blade.php`:
  - Clean, official letterhead print template for PDF/printing.

---

### 5.2 Portal B: Corporate Merchant Portal (`CorporateFE`)

#### 1. Page 1: Tagihan Biaya Logistik / Carrier Payables (`/finance/corporate-invoices`)
- File: `resources/views/finance/corporate-invoices/index.blade.php`
- Purpose: Corporate audits and pays carrier freight bills.
- Capabilities:
  - Metric Stat Cards: Total Tagihan Logistik, Belum Dibayar, Sudah Lunas.
  - Table: No. Invoice Logistik, Vendor / Transporter, Periode, Biaya Ekspedisi, Status Pembayaran, Aksi (`Detail & Bayar`, `Cetak Bukti`).
  - Modal Detail & Bayar:
    - Menampilkan rincian waybill pengiriman yang ditagihkan.
    - Rekening bank tujuan pembayaran vendor.
    - Form Upload Bukti Transfer: input Bank Pengirim, No. Referensi Transaksi, Tanggal Bayar, dan upload file bukti bayar.

#### 2. Page 2: Faktur Penagihan Pelanggan / Distributor Receivables (`/finance/distributor-invoices`)
- File: `resources/views/finance/distributor-invoices/index.blade.php`
- Purpose: Corporate bills regional distributors for goods delivered.
- Capabilities:
  - Metric Stat Cards: Total Piutang Produk, Belum Terbayar, Sudah Lunas.
  - Button **"Buat Faktur Penagihan"**:
    - Modal wizard: pilih Distributor $\rightarrow$ pilih Surat Jalan (Waybill) yang telah diterima $\rightarrow$ periksa kuantitas SKU dan harga satuan $\rightarrow$ simpan dan terbitkan invoice.
  - Table: No. Invoice, Distributor / Pelanggan, Ref Waybill, Jatuh Tempo, Total Nilai Barang, Status Pembayaran, Aksi (`Detail`, `Validasi Bayar`, `Cetak Faktur`).
  - Modal Detail & Validasi: review bukti transfer distributor dan ubah status menjadi `Confirmed/Paid`.
  - Printable Commercial Invoice: format faktur pajak dan faktur komersial standar B2B.

---

## 6. Multi-Tenant Security & Role Authorization Matrix

| Action | `logistik_admin` (`LogisticFE`) | `corporate_admin` (`CorporateFE`) | `aggregator_admin` |
| :--- | :---: | :---: | :---: |
| **Create Freight Invoice** | YES (Scoped to `logistic_id`) | NO | VIEW ONLY |
| **Inspect Freight Invoice** | YES (Own invoices) | YES (Billed to own `corporate_id`) | YES (All) |
| **Upload Freight Payment Proof** | NO | YES (For own payables) | YES |
| **Confirm Freight Payment (Settled)** | YES (Creditor) | NO | AUDIT ONLY |
| **Create Distributor Invoice** | NO | YES (For own goods) | NO |
| **Inspect Distributor Invoice** | NO | YES (Own distributors) | VIEW ONLY |
| **Approve Distributor Payment** | NO | YES (Creditor) | NO |

---

## 7. Delivery Milestones & Readiness

1. **Milestone 1**: Backend API completion (dependencies, unbilled queries, payment actions).
2. **Milestone 2**: `LogisticFE` Carrier Invoicing interface (list, create modal, detail, print).
3. **Milestone 3**: `CorporateFE` Freight Payables & Payment Proof upload interface.
4. **Milestone 4**: `CorporateFE` Distributor Commercial Invoicing interface.
5. **Milestone 5**: Full end-to-end integration simulation and verification.
