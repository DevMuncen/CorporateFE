# 01. CorporateFE Implementation Master Checklist
## Phased Implementation Roadmap & Verification Checklist

> **Target Directory:** `d:\DevMuncen\CorporateFE`  
> **Backend Architecture:** `d:\DevMuncen\BackendCorporateLogistic`  
> **Corporate Identity:** Corporate Navy (`#1E3A8A`) & Enterprise Blue (`#3155A6`)  
> **Tenant Governance:** Corporate-Owned Full CRUD (`corporate_id`) vs. Central Read-Only Pickers

---

## Phase 1: Environment & Foundational Setup
- [x] **1.1. Directory Structure Setup:** Establish `docs/00_design`, `docs/01_preplan`, and `docs/02_implementation` structure in `d:\DevMuncen\CorporateFE`.
- [x] **1.2. Architectural Specifications:** Author comprehensive preplan specifications covering BFF proxying, master data, RO wizard, dynamic pricing, and inventory sync.
- [ ] **1.3. Laravel 12 & Vite Initialization:** Initialize Laravel 12 application skeleton with PHP 8.2+, Vite 7, and Tailwind CSS v4.
- [ ] **1.4. Port & Environment Configuration:** Configure `.env` for `CorporateFE` on port `8004` pointing to `BACKEND_URL=http://localhost:8001`.
- [ ] **1.5. Corporate Branding Setup:** Configure Corporate Navy (`#1E3A8A`), Deep Corporate (`#102A5C`), Enterprise Blue (`#3155A6`), and Sky Blue (`#60A5FA`) in `resources/css/app.css`.
- [ ] **1.6. Multi-Tenant BFF S2S Auth Proxy:** Build `AuthController` pointing to `BackendCorporateLogistic/api/auth/login` (`portal_type: "corporate"`), storing `api_token` and `tenant_corporate_id` in encrypted session.
- [ ] **1.7. ProxyController S2S Header Injection:** Implement `ProxyController.php` intercepting `/api/internal/corporate/*` and injecting `Authorization: Bearer {token}` and `X-Tenant-Corporate-ID: {corporate_id}`.

---

## Phase 2: Core Components & Layout Porting
- [ ] **2.1. Unconstrained Stacking Layout:** Implement `<x-layout.app>` ensuring `.page-wrapper` has zero trapped `z-10` stacking context.
- [ ] **2.2. Enterprise Topbar & Navigation:** Implement `<x-header>` with responsive toggle, tenant indicator badge ("Korporasi Merah Putih"), and profile menu.
- [ ] **2.3. Corporate Sidebar Navigation:** Implement `<x-sidebar>` configured strictly with Corporate modules (Dashboard, Master Data, Orders & Dispatches, Inventory, Finance & Invoicing).
- [ ] **2.4. Modal & Modal Picker Engines:** Implement `<x-modal>` (`!z-[60]`) and `<x-modal-picker>` (`!z-[80]`) for seamless relational item selection without backdrop trapping.
- [ ] **2.5. Toast Notification System:** Implement `<x-toast>` (`!z-[100]`) for real-time calculation and operation feedback.

---

## Phase 3: Corporate Master Data CRUD Views
- [ ] **3.1. Corporate Product Catalog (`/products`) [FULL CRUD]**:
  - Build product data grid with search, category filtering, and status badges.
  - Implement Add/Edit modal with `cargo_type_id` picker (General, Cold Chain, Hazmat) and `uom_id` selector.
  - Implement product soft delete with confirmation dialog.
- [ ] **3.2. Product Categories Management (`/product-categories`) [FULL CRUD]**:
  - Build category list and modal editor.
- [ ] **3.3. Corporate Warehouses & Facilities (`/warehouses`) [FULL CRUD]**:
  - Build facility data grid displaying address, Kemendagri city codes, and `is_pickup_hub` status.
  - Implement Add/Edit warehouse modal with Kemendagri city dropdown and pickup hub toggle.
- [ ] **3.4. Corporate Customers Directory (`/customers`) [FULL CRUD]**:
  - Build B2B customer accounts table with contact details and delivery addresses.
  - Implement Add/Edit customer modal with PIC contact fields.
- [ ] **3.5. Supply Vendors Directory (`/vendors`) [FULL CRUD]**:
  - Build supply vendor directory and modal manager.
- [ ] **3.6. Regional Distributors Network (`/distributors`) [FULL CRUD]**:
  - Build distributor partner table and branch mapping.

---

## Phase 4: Request Order Wizard & Dynamic Pricing Engine
- [ ] **4.1. Request Orders Data Grid (`/request-orders`)**:
  - Build master orders table with filtering by status (`draft`, `confirmed`, `transit`, `completed`, `cancelled`).
  - Implement order detail modal displaying multi-drop `delivery_points[]` and encapsulated item rosters.
- [ ] **4.2. Multi-Step Request Order Wizard (`/request-orders/create`)**:
  - **Step 1: Origin & Route Inquiry:** Select origin warehouse (`is_pickup_hub = true`), destination city, and trigger `POST /inquire-routes`.
  - **Step 2: Fleet Type Selection:** Choose vehicle category (CDE, CDD, Fuso, Wingbox) with live weight/volume capacity limits.
  - **Step 3: Multi-Drop Stop Sequencer:** Add 1..$N$ delivery points with sequential `stop_sequence` and mutually exclusive `delivery_type` switcher.
  - **Step 4: Encapsulated Items & PO Autofill:** Add item rows under each drop point. Connect "Import Distributor PO" picker (`GET /distributor-orders?city_code=...`) to auto-populate destination details and item lines.
  - **Step 5: Dynamic Tariff Breakdown & Review:** Call `POST /calculate-pricing` to render itemized costs (Linehaul + Outer Shunting + Inner Shunting) and submit order, locking `snapshot_pricing`.
- [ ] **4.3. Distributor Purchase Orders Inbox (`/distributor-orders`)**:
  - Build pending distributor PO table with 1-click action to bundle into a new Request Order.

---

## Phase 5: Child Waybills Roster, Live Tracking & Verification
- [ ] **5.1. Child Waybill Monitoring Grid (`/waybills`)**:
  - Build waybill roster displaying spawned `AWB-...-S{seq}` records linked to parent Request Orders.
  - Implement filter by transport carrier, destination city, and milestone status.
- [ ] **5.2. Live Shipment Tracker (`/waybills/{id}`)**:
  - Build visual milestone timeline: Order Placed $\rightarrow$ Carrier Assigned $\rightarrow$ Picked Up $\rightarrow$ In Transit $\rightarrow$ Delivered $\rightarrow$ Completed.
  - Render driver telemetry, vehicle plate number, and assigned carrier details.
  - Render verified photo attachments: **Bukti Pickup (`pickup_proof_photo`)** and **Proof of Delivery (`pod_proof_photo`)**.
- [ ] **5.3. Printable Surat Jalan Korporasi (`/waybills/{id}/print`)**:
  - Implement clean, printable HTML Surat Jalan layout for physical documentation.

---

## Phase 6: Inventory Movements & Conditional Auto-Triggers
- [ ] **6.1. Real-Time Stock Ledger (`/inventory/stocks`)**:
  - Build multi-facility stock table displaying quantity on hand, allocated quantity, and available balance per SKU.
- [ ] **6.2. Goods Receipt Logging (`/inventory/item-ins`)**:
  - Build goods receipt table showing factory inbound shipments.
  - Verify automatic `CorporateItemIn` generation when a carrier delivers to a Corporate Warehouse (`delivery_type = 1`).
- [ ] **6.3. Goods Dispatch Logging (`/inventory/item-outs`)**:
  - Build goods issue table showing outbound dispatches.
  - Verify automatic `CorporateItemOut` stock deduction when a carrier confirms pickup from a Corporate Warehouse.

---

## Phase 7: Distributor Billing, Freight Reconciliation & QA
- [ ] **7.1. Distributor Invoicing Ledger (`/finance/distributor-invoices`)**:
  - Build distributor invoice data grid with status badges (`unpaid`, `partial`, `paid`, `overdue`).
  - Implement "Generate Invoice" modal utilizing `form-dependencies` to bundle delivered distributor orders.
  - Implement printable/downloadable commercial invoice PDF.
- [ ] **7.2. Carrier Freight Invoice Reconciliation (`/finance/corporate-invoices`)**:
  - Build freight invoices table matching billed amounts against `snapshot_pricing.total_estimated_cost`.
  - Provide 1-click approval for matching tariff reconciliations.
- [ ] **7.3. Asset Compilation & Linting:** Execute `npm run build` and `vendor/bin/pint --format agent`.
- [ ] **7.4. End-to-End Operational Testing:** Execute Puppeteer E2E tests validating the complete flow: Login $\rightarrow$ Master Data $\rightarrow$ RO Wizard $\rightarrow$ Tariff Snapshot $\rightarrow$ Carrier Waybill Spawning $\rightarrow$ POD Completion $\rightarrow$ Inventory Sync $\rightarrow$ Invoicing.
