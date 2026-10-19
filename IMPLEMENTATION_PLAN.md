# 🏢 CorporateFE Master Implementation Plan

> **Target Directory:** `d:\DevMuncen\CorporateFE`  
> **Backend Reference:** `d:\DevMuncen\BackendCorporateLogistic`  
> **Target Framework:** Laravel 12 + Tailwind CSS v4 + Preline UI + Vite 7  
> **Default Port:** `http://localhost:8004` (Backend at `http://localhost:8001`)

---

## 1. Project Overview & Strategic Objectives

The goal of this initiative is to build the dedicated **CorporateFE Web Portal** on the newly provisioned blank repository at `d:\DevMuncen\CorporateFE`.

`CorporateFE` modernizes the legacy monolithic operations from `Corporate-Development` into a high-performance, decoupled frontend application adhering to the **Backend-For-Frontend (BFF)** proxy pattern established in `LogisticFE` and `AgregatorFE`.

### Primary Capabilities to Deliver:
1. **Corporate Master Data Foundation:** Full CRUD management for Product Catalog (with Cargo Types & UOMs), Corporate Warehouses/Plants (with Kemendagri city codes & pickup hub flags), Customers, Distributors, and Vendors.
2. **5-Step Interactive Request Order Wizard:**
   - Origin facility selection and carrier route inquiry.
   - Vehicle fleet category selection with live payload capacity validation.
   - Sequential multi-drop delivery point sequencer (`delivery_points[]`).
   - Encapsulated item rosters with 1-click Distributor Purchase Order autofill.
   - Dynamic freight calculation and immutable `snapshot_pricing` lock.
3. **Child Waybill Monitoring & Live Tracking:** Real-time visibility into auto-spawned child waybills (`AWB-...-S{seq}`), driver telemetry, and photo proofs (`pickup_proof_photo`, `pod_proof_photo`).
4. **Event-Driven Conditional Inventory Synchronization:** Automatic goods issue (`CorporateItemOut`) upon carrier pickup and automatic goods receipt (`CorporateItemIn`) upon delivery to a corporate warehouse.
5. **Distributor Billing & Commercial Invoicing:** Automated billing based on delivered distributor purchase orders and carrier invoice reconciliation against frozen tariff snapshots.

---

## 2. Target Application File Structure

```
CorporateFE/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php                   # S2S Corporate Login/Logout
│   │   │   ├── ProxyController.php                  # BFF S2S Header Injector
│   │   │   ├── DashboardController.php              # Corporate KPI Cards
│   │   │   ├── CorporateProductController.php       # Product Catalog CRUD
│   │   │   ├── CorporateWarehouseController.php     # Facility & Hub CRUD
│   │   │   ├── CorporateCustomerController.php      # B2B Customer CRUD
│   │   │   ├── CorporateVendorController.php        # Supply Vendor CRUD
│   │   │   ├── CorporateDistributorController.php   # Distributor Network
│   │   │   ├── RequestOrderController.php           # 5-Step RO Wizard & Inquiries
│   │   │   ├── WaybillController.php                # Child Waybills & Tracking
│   │   │   ├── InventoryController.php              # Stocks, Item In, Item Out
│   │   │   └── DistributorInvoiceController.php     # Distributor Invoices & PDF
│   │   └── Middleware/
├── config/
│   └── services.php                                 # backend.url config
├── docs/                                            # Structured System Docs
│   ├── 00_design/
│   ├── 01_preplan/
│   └── 02_implementation/
├── resources/
│   ├── css/
│   │   └── app.css                                  # Tailwind v4 Corporate Navy Theme
│   ├── js/
│   │   ├── app.js                                   # Preline & Global UI
│   │   └── ro-wizard.js                             # 5-Step Dynamic Pricing Engine
│   └── views/
│       ├── components/
│       │   ├── layout/
│       │   │   ├── app.blade.php                    # Zero trapped z-10 shell
│       │   │   ├── head.blade.php
│       │   │   └── scripts.blade.php
│       │   ├── header.blade.php                     # Enterprise Topbar
│       │   ├── sidebar.blade.php                    # Corporate Navigation
│       │   ├── modal.blade.php                      # z-60 Dialog
│       │   ├── modal-picker.blade.php               # z-80 Relational Picker
│       │   └── toast.blade.php                      # z-100 Feedback Alerts
│       ├── auth/
│       │   └── login.blade.php
│       ├── dashboard.blade.php
│       ├── products/
│       ├── warehouses/
│       ├── customers/
│       ├── vendors/
│       ├── distributors/
│       ├── request-orders/
│       ├── distributor-orders/
│       ├── waybills/
│       ├── inventory/
│       └── finance/
├── routes/
│   └── web.php                                      # UI Routes & Internal BFF Routes
├── package.json                                     # Vite 7 + Tailwind v4 + Preline
├── composer.json                                    # Laravel 12 Skeleton
└── .env                                             # PORT=8004, BACKEND=8001
```

---

## 3. Phased Implementation Roadmap

### Phase 1: Skeleton Initialization & Auth Proxy
- Initialize Laravel 12 application skeleton with PHP 8.2+ and Vite 7.
- Install and configure Tailwind CSS v4 with Corporate Navy theme tokens (`#1E3A8A`, `#102A5C`, `#3155A6`, `#60A5FA`).
- Configure `.env` with `APP_PORT=8004` and `BACKEND_URL=http://localhost:8001`.
- Build `AuthController` and `ProxyController` injecting `X-Tenant-Corporate-ID` and Sanctum bearer tokens.

### Phase 2: Core Components & Layout Shell
- Port layout components from `LogisticFE`/`AgregatorFE` to create `<x-layout.app>`, `<x-header>`, and `<x-sidebar>`.
- Enforce strict unconstrained z-index layering (`!z-[40]` backdrop, `!z-[60]` modal, `!z-[80]` picker, `!z-[100]` toast).
- Implement login screen (`auth/login.blade.php`) and executive dashboard (`dashboard.blade.php`).

### Phase 3: Corporate Master Data CRUD Views
- Implement Corporate Product Catalog with category and cargo type selectors.
- Implement Corporate Warehouses view with Kemendagri city picker and `is_pickup_hub` toggle.
- Implement Customer, Vendor, and Distributor directory management views.

### Phase 4: Request Order Wizard & Dynamic Pricing Engine
- Build the 5-Step interactive Request Order Wizard (`request-orders/create.blade.php`).
- Connect route inquiry (`POST /inquire-routes`) and dynamic tariff calculations (`POST /calculate-pricing`).
- Implement 1-click Distributor PO autofill from `GET /distributor-orders`.
- Verify multi-drop stop sequencing and locked `snapshot_pricing` JSON.

### Phase 5: Child Waybills Roster & Live Tracking
- Build child waybill monitor (`waybills/index.blade.php`) displaying `AWB-...-S{seq}` records.
- Implement visual shipment timeline with GPS telemetry and photo proof displays (`pickup_proof_photo`, `pod_proof_photo`).
- Implement printable Surat Jalan Korporasi layout (`waybills/print.blade.php`).

### Phase 6: Event-Driven Inventory & Stock Ledger
- Build real-time stock ledger view (`inventory/stocks.blade.php`).
- Verify automated `CorporateItemOut` stock deduction on carrier pickup.
- Verify automated `CorporateItemIn` stock crediting on warehouse delivery.
- Implement manual goods in and goods issue logging views.

### Phase 7: Distributor Billing & E2E Verification
- Build distributor invoicing management (`finance/distributor-invoices`).
- Implement commercial invoice PDF generation and payment status tracking.
- Implement carrier freight invoice reconciliation against `snapshot_pricing`.
- Execute automated Puppeteer E2E tests validating the complete user journey.
