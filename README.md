# 🏢 CorporateFE — Corporate Shipper Enterprise Portal
## Modern Laravel 12 Frontend Portal for Enterprise Corporate Logistics

[![Laravel 12](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP 8.2+](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![Tailwind CSS v4](https://img.shields.io/badge/Tailwind_CSS-v4.0-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![Vite 7](https://img.shields.io/badge/Vite-7.x-646CFF?style=for-the-badge&logo=vite)](https://vitejs.dev)

`CorporateFE` is the dedicated web operations and management portal for **Corporate Shippers (Prinsipal Korporasi / Manufaktur / National Shippers)**. Built with Laravel 12, Tailwind CSS v4, and Preline UI, it connects seamlessly to the multi-tenant REST API of [`BackendCorporateLogistic`](file:///d:/DevMuncen/BackendCorporateLogistic) using a secure **Backend-For-Frontend (BFF)** proxy pattern.

---

## 🚀 Key Functional Capabilities

1. **Corporate Master Data Management:**
   - Product Catalog with SKU, categories, units of measure, and mandatory **Cargo Type Classifications (`cargo_type_id`)**.
   - Corporate Warehouses & Manufacturing Plants with Kemendagri city codes and **Pickup Hub flags (`is_pickup_hub`)**.
   - B2B Corporate Customers, Regional Distributors, and Supply Vendors.
2. **5-Step Request Order Wizard (`/request-orders/create`):**
   - Origin warehouse selection and live carrier route inquiry (`POST /inquire-routes`).
   - Transport vehicle category selection with real-time payload capacity meters.
   - Sequential multi-drop delivery point sequencer (`delivery_points[]`) with destination type switching.
   - Encapsulated item rosters with 1-click **Distributor Purchase Order Autofill**.
   - Dynamic freight tariff calculation locking into an immutable **`snapshot_pricing`** JSON audit trail.
3. **Child Waybills & Live Tracking (`/waybills`):**
   - Real-time tracking of auto-spawned child waybills (`AWB-...-S{seq}`) spawned upon order acceptance.
   - Live shipment timeline, GPS driver telemetry, and photo proofs: **Bukti Pickup (`pickup_proof_photo`)** and **Proof of Delivery (`pod_proof_photo`)**.
   - Printable Surat Jalan Korporasi layout (`/waybills/{id}/print`).
4. **Conditional Automated Inventory Synchronization:**
   - Automatic goods issue (`CorporateItemOut`) and stock deduction upon carrier pickup from a Corporate Warehouse.
   - Automatic goods receipt (`CorporateItemIn`) and stock addition upon carrier delivery to a Corporate Warehouse.
5. **Distributor Billing & Commercial Invoicing:**
   - Commercial invoice generation for delivered distributor orders with payment status tracking and PDF export.
   - Freight billing audit reconciliation comparing carrier invoices against frozen `snapshot_pricing`.

---

## 🌐 Ecosystem Architecture & Port Conventions

| Portal / Service | Port | Repository | Core Role |
| :--- | :---: | :--- | :--- |
| **`BackendCorporateLogistic`** | **8001** | `d:\DevMuncen\BackendCorporateLogistic` | Multi-Tenant Core REST API Engine |
| **`CorporateFE`** | **8004** | `d:\DevMuncen\CorporateFE` | **Corporate Shipper Enterprise Web Portal** |
| **`LogisticFE`** | **8003** | `d:\DevMuncen\LogisticFE` | Logistics Carrier Web Portal |
| **`AgregatorFE`** | **8002** | `d:\DevMuncen\AgregatorFE` | Central Aggregator Hub Portal |

---

## 🔒 Backend-For-Frontend (BFF) Security Architecture

- **Zero Token Leakage:** Sanctum bearer tokens and corporate tenant IDs are **never** stored in browser `localStorage` or accessible cookies.
- **Encrypted S2S Storage:** Upon login via `POST /api/auth/login` (`portal_type: "corporate"`), the token and `tenant_corporate_id` are encrypted in Laravel session.
- **Automatic Header Injection:** `ProxyController.php` intercepts all `/api/internal/corporate/*` client calls and attaches:
  ```http
  Authorization: Bearer {session('api_token')}
  X-Tenant-Corporate-ID: {session('tenant_corporate_id')}
  Accept: application/json
  ```
- **Unconstrained Modal Stacking:** Zero trapped `z-10` contexts on `.page-wrapper`. Backdrops (`!z-[40]`), Modals (`!z-[60]`), Relational Pickers (`!z-[80]`), Toasts (`!z-[100]`).

---

## 📖 Comprehensive Documentation Suite

All system specifications and implementation checklists are meticulously organized in [`docs/`](docs/README.md):

- **Master System Specifications:**
  - [`CORPORATEFE_MASTER_SPECIFICATION.md`](docs/CORPORATEFE_MASTER_SPECIFICATION.md): Master Architectural Blueprint.
  - [`CORPORATEFE_FRONTEND_REQUIREMENTS_SUMMARY.md`](docs/CORPORATEFE_FRONTEND_REQUIREMENTS_SUMMARY.md): Front-End Requirements Summary.
  - [`IMPLEMENTATION_PLAN.md`](IMPLEMENTATION_PLAN.md): Strategic Implementation Roadmap.
- **Design & Branding (`docs/00_design`):**
  - [`COLOR BRAND GUIDELINE.md`](docs/00_design/COLOR%20BRAND%20GUIDELINE.md): Corporate Navy (`#1E3A8A`) Design Tokens & Hierarchy.
- **Pre-Plan Architectural Specs (`docs/01_preplan`):**
  - [`01_CORPORATEFE_PREPLAN.md`](docs/01_preplan/01_CORPORATEFE_PREPLAN.md): BFF Proxy Model & Security.
  - [`02_CORPORATEFE_MASTER_DATA_SPEC.md`](docs/01_preplan/02_CORPORATEFE_MASTER_DATA_SPEC.md): Master Data & Tenant Governance.
  - [`03_CORPORATEFE_TEMPLATE_MAPPING.md`](docs/01_preplan/03_CORPORATEFE_TEMPLATE_MAPPING.md): Blade Layouts & RO Wizard Architecture.
  - [`04_CORPORATEFE_API_CONTRACTS.md`](docs/01_preplan/04_CORPORATEFE_API_CONTRACTS.md): Internal BFF Proxy API Contracts.
  - [`05_CORPORATEFE_REQUEST_ORDER_AND_DISPATCH_SPEC.md`](docs/01_preplan/05_CORPORATEFE_REQUEST_ORDER_AND_DISPATCH_SPEC.md): Multi-Drop RO & Dynamic Pricing Deep-Dive.
  - [`06_CORPORATEFE_INVENTORY_AND_FINANCE_SPEC.md`](docs/01_preplan/06_CORPORATEFE_INVENTORY_AND_FINANCE_SPEC.md): Inventory Movements & Distributor Invoicing.
  - [`07_GAP_ANALYSIS_AND_ENHANCEMENTS.md`](docs/01_preplan/07_GAP_ANALYSIS_AND_ENHANCEMENTS.md): Legacy CI4 vs. Modern Laravel 12 Gap Analysis.
- **Implementation Checklists (`docs/02_implementation`):**
  - [`01_CORPORATEFE_IMPLEMENTATION_CHECKLIST.md`](docs/02_implementation/01_CORPORATEFE_IMPLEMENTATION_CHECKLIST.md): Master 7-Phase Tracking Checklist.
  - [`02_BACKEND_SYNC_AND_VERIFICATION_CHECKLIST.md`](docs/02_implementation/02_BACKEND_SYNC_AND_VERIFICATION_CHECKLIST.md): Backend Endpoints Parity Matrix.

---

## 🛠️ Local Development Quickstart

```bash
# 1. Clone repository & install dependencies
composer install
npm install

# 2. Setup environment configuration
cp .env.example .env
php artisan key:generate

# 3. Configure backend target in .env
# SERVER_PORT=8004
# BACKEND_URL=http://localhost:8001

# 4. Start concurrent development server
npm run dev
# Launches CorporateFE on http://localhost:8004 with Vite HMR
```
