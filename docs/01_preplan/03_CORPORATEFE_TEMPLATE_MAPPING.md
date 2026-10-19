# 03. CorporateFE Template & Blade Component Mapping
## Layout Slicing, Multi-Step Request Order Wizard & Z-Index Standardization

> **Target Directory:** `d:\DevMuncen\CorporateFE/docs/01_preplan/03_CORPORATEFE_TEMPLATE_MAPPING.md`  
> **Base Architecture:** Laravel 12 Blade Components + Tailwind CSS v4 + Preline UI + Vanilla JS BFF Engine  
> **Corporate Identity:** Corporate Navy (`#1E3A8A`) & Enterprise Blue (`#3155A6`)  
> **Tenant Governance:** Corporate-Owned Full CRUD vs Shared Reference Pickers

---

## 1. Master Layout Components (`resources/views/components/layout`)

| Component | Target File | Purpose & Customization for CorporateFE |
| :--- | :--- | :--- |
| `<x-layout.app>` | `components/layout/app.blade.php` | Root shell containing sidebar, topbar, and main container. **Zero trapped `z-10` stacking context** on `.page-wrapper`. |
| `<x-layout.head>` | `components/layout/head.blade.php` | Page metadata, Corporate Navy theme tokens, favicon (`assets/images/logos/corporate-logo.png`), Vite CSS bundle import. |
| `<x-layout.scripts>`| `components/layout/scripts.blade.php` | Vite JavaScript entrypoint, Preline UI initializer, and helper script bundles (`?v={{ time() }}`). |

---

## 2. Shared Interactive & Overlay Components (`resources/views/components`)

| Component | File Path | Z-Index Layer | Description & Role |
| :--- | :--- | :---: | :--- |
| **Backdrop** | `.hs-overlay-backdrop` | `!z-[40]` | Semi-transparent darkened backdrop covering viewport. |
| **Header** | `components/header.blade.php` | `!z-[20]` | Top bar with responsive toggle, tenant indicator badge ("Korporasi Merah Putih"), and profile menu. |
| **Sidebar** | `components/sidebar.blade.php` | `!z-[30]` | Responsive left navigation configured with Corporate modules (Master Data, Orders, Inventory, Finance). |
| **Modal** | `components/modal.blade.php` | `!z-[60]` | Primary dialog container for Corporate CRUD operations (Products, Warehouses, Customers). |
| **Modal Picker** | `components/modal-picker.blade.php` | `!z-[80]` | High-layer relational picker for selecting products, carrier contracts, and distributor POs without modal trapping. |
| **Toast** | `components/toast.blade.php` | `!z-[100]` | System alert notifications for success, warning, dynamic tariff recalculation, and error messages. |

---

## 3. Page Templates & Views Architecture (`resources/views`)

### 3.1 Corporate Master Data Views

| Route Path | View File | UI Type | Capabilities & Description |
| :--- | :--- | :---: | :--- |
| `/products` | `products/index.blade.php` | **FULL CRUD** | Table of corporate products, SKU search, category filter; Add/Edit product modal with `cargo_type_id` picker and `uom_id` selector. |
| `/product-categories`| `product-categories/index.blade.php`| **FULL CRUD** | Product category taxonomy management. |
| `/warehouses` | `warehouses/index.blade.php` | **FULL CRUD** | Table of corporate warehouses & plants; Add/Edit modal with Kemendagri city picker and `is_pickup_hub` toggle switch. |
| `/customers` | `customers/index.blade.php` | **FULL CRUD** | Corporate B2B customer accounts, delivery address manager, and receiving PIC details. |
| `/vendors` | `vendors/index.blade.php` | **FULL CRUD** | Raw materials & packaging supply vendors directory. |
| `/distributors` | `distributors/index.blade.php` | **FULL CRUD** | Regional distribution partner roster and affiliated warehouse branches. |

### 3.2 Transaction & Request Order Views (The RO Engine)

| Route Path | View File | UI Type | Key Capabilities & Features |
| :--- | :--- | :---: | :--- |
| `/dashboard` | `dashboard.blade.php` | **KPI DASHBOARD** | Real-time executive cards: Active Request Orders, Dispatches In-Transit, Monthly Freight Spend, and Pending Invoices. |
| `/request-orders` | `request-orders/index.blade.php` | **DATA GRID** | Master Request Orders table; filter by status (`draft`, `confirmed`, `transit`, `completed`, `cancelled`); view order detail modal. |
| `/request-orders/create`| `request-orders/create.blade.php`| **5-STEP WIZARD** | **Interactive Multi-Drop Request Order Wizard** (see Section 4 for complete breakdown). |
| `/distributor-orders`| `distributor-orders/index.blade.php`| **IMPORT LIST** | Pending purchase orders from distributors (`distributor_orders`); quick action to convert/bundle into a Request Order. |
| `/waybills` | `waybills/index.blade.php` | **MONITOR GRID** | Live roster of spawned child waybills (`AWB-...-S{seq}`); filter by carrier, destination city, and milestone. |
| `/waybills/{id}` | `waybills/show.blade.php` | **LIVE TRACKER** | Visual shipment timeline: Order Placed $\rightarrow$ Carrier Assigned $\rightarrow$ Picked Up (Photo) $\rightarrow$ In Transit $\rightarrow$ Delivered (POD Photo). |
| `/waybills/{id}/print`| `waybills/print.blade.php` | **PRINT LAYOUT** | Clean printable HTML format of Surat Jalan Korporasi for physical shipment attachment. |

### 3.3 Inventory Management Views

| Route Path | View File | Key Capabilities & Features |
| :--- | :--- | :--- |
| `/inventory/stocks` | `inventory/stocks.blade.php` | Real-time stock levels across corporate warehouses, min/max thresholds, and reserve quantities. |
| `/inventory/item-ins` | `inventory/item-ins.blade.php` | Warehouse goods receipt logs; automatic item ins triggered by carrier drops to corporate warehouses. |
| `/inventory/item-outs` | `inventory/item-outs.blade.php` | Warehouse dispatch logs; automatic item outs triggered by carrier pickups from corporate warehouses. |

### 3.4 Finance & Invoicing Views

| Route Path | View File | Key Capabilities & Features |
| :--- | :--- | :--- |
| `/finance/distributor-invoices` | `finance/distributor-invoices/index.blade.php` | Distributor billing ledger; Generate invoice modal with order selection; Payment status; PDF export. |
| `/finance/corporate-invoices` | `finance/corporate-invoices/index.blade.php` | Logistics carrier freight invoices reconciliation and payment status. |

---

## 4. Multi-Step Request Order Wizard Architecture (`/request-orders/create`)

```mermaid
graph LR
    S1[Step 1: Origin & Carrier Route Inquiry] --> S2[Step 2: Fleet Type Selection & Constraints]
    S2 --> S3[Step 3: Multi-Drop Stop Sequencer]
    S3 --> S4[Step 4: Encapsulated Items & PO Autofill]
    S4 --> S5[Step 5: Dynamic Tariff Breakdown & Lock]
```

### Step 1: Origin Hub & Route Inquiry
- User selects origin facility from `corporate_warehouses` where `is_pickup_hub = true`.
- User selects destination primary city (Kemendagri city code, e.g. `35.78` Surabaya).
- System triggers `POST /api/internal/corporate/request-orders/inquire-routes` to list eligible logistics carriers (`distribution_vendors`) with active contracts.

### Step 2: Fleet Type & Capacity Validation
- Select transport vehicle type: CDE, CDD, Fuso, or Tronton Wingbox.
- Live capacity meter displaying maximum payload (kg) and volume (CBM).

### Step 3: Multi-Drop Delivery Points Sequencer (`delivery_points[]`)
- Dynamic accordion/card interface allowing users to add 1 to $N$ delivery stops.
- Automatic ordering by `stop_sequence` (1, 2, 3...).
- Mutually exclusive destination type switcher:
  - `Type 1`: Corporate Warehouse drop (`corporate_warehouse_id`).
  - `Type 2`: Distributor Warehouse drop (`distributor_warehouse_id`).
  - `Type 3`: Customer drop (`customer_id`).

### Step 4: Encapsulated Items & Distributor PO Autofill
- For each drop point, add items into `delivery_points[i].items[]`.
- **Autofill Option**: Click "Import Distributor PO" $\rightarrow$ opens `<x-modal-picker>` listing pending orders for that city $\rightarrow$ selecting an order automatically populates recipient information, PO number, and product quantities.

### Step 5: Dynamic Tariff Review & Submission
- Real-time call to `POST /api/internal/corporate/request-orders/calculate-pricing`.
- Displays itemized cost breakdown:
  - Base Linehaul Tariff (`linehaul_price`)
  - Outer Shunting Tariff (`shunting_price`)
  - Inner-City Shunting Tariff (`inner_city_shunting_price`)
  - Cargo Multiplier Adjustments
  - **Total Estimated Freight Cost**
- Submitting locks this calculation into `snapshot_pricing` JSON.
