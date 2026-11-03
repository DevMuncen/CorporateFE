# 03. Invoicing System Implementation Checklist (Corporate Freight Payables & Distributor Commercial Billing)

> **Document Status**: COMPLETED & VERIFIED  
> **Preplan Reference**: [docs/01_preplan/07_INVOICING_SYSTEM_IMPLEMENTATION_PREPLAN_CORPORATE_AUDIT_AND_DISTRIBUTOR_BILLING.md](file:///d:/DevMuncen/CorporateFE/docs/01_preplan/07_INVOICING_SYSTEM_IMPLEMENTATION_PREPLAN_CORPORATE_AUDIT_AND_DISTRIBUTOR_BILLING.md)  
> **Backend Master Checklist**: [BackendCorporateLogistic/docs/02_implementation/15_INVOICING_SYSTEM_IMPLEMENTATION_CHECKLIST_CORPORATE_AND_LOGISTIC_FE.md](file:///d:/DevMuncen/BackendCorporateLogistic/docs/02_implementation/15_INVOICING_SYSTEM_IMPLEMENTATION_CHECKLIST_CORPORATE_AND_LOGISTIC_FE.md)

---

## 1. Freight Payables Audit & Payment Proof (`finance/corporate-invoices`)
- [x] In [resources/views/finance/corporate-invoices/index.blade.php](file:///d:/DevMuncen/CorporateFE/resources/views/finance/corporate-invoices/index.blade.php):
  - [x] 4 Stat Cards: Total Tagihan Logistik, Belum Dibayar, Menunggu Verifikasi, Lunas / Settled.
  - [x] Status filter pills (Semua, Harus Dibayar, Lunas) & search input.
  - [x] Invoices Table: No. Invoice, Transporter, Surat Jalan count, Jatuh Tempo, Biaya Ekspedisi, Status, Aksi (`Detail & Bayar`).
  - [x] Modal Detail & Audit:
    - Itemized breakdown table of waybills.
    - Vendor bank account info.
    - Status bukti transfer.
    - Upload Bukti Pembayaran form with file attachment, transfer date, bank account, and amount.
- [x] In [app/Http/Controllers/ProxyController.php](file:///d:/DevMuncen/CorporateFE/app/Http/Controllers/ProxyController.php):
  - [x] Added `forwardMultipart()` helper method for handling file uploads.
- [x] In [app/Http/Controllers/DistributorInvoiceController.php](file:///d:/DevMuncen/CorporateFE/app/Http/Controllers/DistributorInvoiceController.php):
  - [x] Added `proxyCorporateInvoiceShow()` and `proxyUploadPaymentProof()`.
- [x] In [routes/web.php](file:///d:/DevMuncen/CorporateFE/routes/web.php):
  - [x] Registered `/api/internal/corporate/finance/corporate-invoices/{id}` and `/payment-proof`.
  - [x] Registered `/api/finance/corporate-invoices/{id}` and `/payment-proof`.

## 2. Distributor Commercial Billing (`finance/distributor-invoices`)
- [x] In [resources/views/finance/distributor-invoices/index.blade.php](file:///d:/DevMuncen/CorporateFE/resources/views/finance/distributor-invoices/index.blade.php):
  - [x] 4 Stat Cards: Total Piutang Produk, Belum Dibayar (Unpaid), Menunggu Validasi, Lunas / Terbayar.
  - [x] Status filter pills & search input.
  - [x] Invoices Table: No. Invoice, Pelanggan / Distributor, Item Produk count, Jatuh Tempo, Total Tagihan, Status, Aksi (`Detail`).
  - [x] Modal Detail Faktur Penagihan Pelanggan:
    - Rincian item produk (SKU, Qty Diterima, Harga Satuan, Diskon, Subtotal).
    - Status pembayaran distributor & payment proof details.
