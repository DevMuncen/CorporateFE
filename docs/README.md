# 🏢 CorporateFE Documentation Master Index
## Enterprise Shipper Management Portal Architecture & Engineering Documentation

Welcome to the central documentation repository for the **CorporateFE Portal** (`d:\DevMuncen\CorporateFE`), designed and built to interface seamlessly with the multi-tenant REST API of `BackendCorporateLogistic` (`d:\DevMuncen\BackendCorporateLogistic`).

---

## 🗂️ Master System Specifications

- **[`CORPORATEFE_MASTER_SPECIFICATION.md`](CORPORATEFE_MASTER_SPECIFICATION.md)**: **Master Architectural Blueprint**: Comprehensive system blueprint detailing the complete end-to-end shipment journey, prerequisite master data structures, multi-drop stop sequencing, dynamic pricing snapshot engine, child waybills lifecycle, conditional automated inventory synchronization, and UI stacking hierarchy.
- **[`CORPORATEFE_FRONTEND_REQUIREMENTS_SUMMARY.md`](CORPORATEFE_FRONTEND_REQUIREMENTS_SUMMARY.md)**: **Front-End Requirements Summary**: Consolidated reference guide compiling tech stack parameters (Laravel 12, PHP 8.2+, Tailwind CSS v4, Preline UI, Vite 7), functional requirements ordering, and document index.

---

## 🎨 Design & Branding (`docs/00_design`)

- **[`COLOR BRAND GUIDELINE.md`](00_design/COLOR%20BRAND%20GUIDELINE.md)**: Corporate Enterprise Blue brand system, Corporate Navy (`#1E3A8A`), Deep Corporate (`#102A5C`), Enterprise Blue (`#3155A6`), Sky Blue (`#60A5FA`), typography standards, Tailwind CSS tokens, and z-index layering hierarchy.

---

## 📁 Sequential Pre-Plan Document Index (`docs/01_preplan`)

| Index | Document File Name | Focus Area & Technical Scope |
| :---: | :--- | :--- |
| **01** | [`01_CORPORATEFE_PREPLAN.md`](01_preplan/01_CORPORATEFE_PREPLAN.md) | **Architectural Blueprint & BFF Pre-Plan**: Multi-tenant server-to-server (S2S) proxy model, `X-Tenant-Corporate-ID` header injection, encrypted session storage, and unconstrained modal stacking hierarchy. |
| **02** | [`02_CORPORATEFE_MASTER_DATA_SPEC.md`](01_preplan/02_CORPORATEFE_MASTER_DATA_SPEC.md) | **Master Data Foundation & Governance**: Corporate-owned CRUD entities vs. central reference pickers, product catalog with mandatory `cargo_type_id`, corporate warehouses with `is_pickup_hub` flags, and Kemendagri city code standards. |
| **03** | [`03_CORPORATEFE_TEMPLATE_MAPPING.md`](01_preplan/03_CORPORATEFE_TEMPLATE_MAPPING.md) | **Template Slicing & Component Mapping**: Sliced Blade layout components (`<x-layout.app>`, `<x-header>`, `<x-sidebar>`), 5-Step Request Order Wizard architecture, modal pickers, and view route mappings. |
| **04** | [`04_CORPORATEFE_API_CONTRACTS.md`](01_preplan/04_CORPORATEFE_API_CONTRACTS.md) | **Complete API Contract Specifications**: Complete mapping of internal BFF routes (`/api/internal/corporate/*`) to backend endpoints (`/api/corporate/*`, `/api/master/*`, `/api/auth/*`), including request/response payloads. |
| **05** | [`05_CORPORATEFE_REQUEST_ORDER_AND_DISPATCH_SPEC.md`](01_preplan/05_CORPORATEFE_REQUEST_ORDER_AND_DISPATCH_SPEC.md) | **Operational RO & Dispatch Deep-Dive**: Multi-drop stop sequencing (`stop_sequence`), destination type switching, encapsulated items (`delivery_points[].items[]`), 1-click distributor PO autofill, dynamic pricing snapshotting (`snapshot_pricing`), auto-spawned child waybills (`AWB-...-S{seq}`), and photo proof verification. |
| **06** | [`06_CORPORATEFE_INVENTORY_AND_FINANCE_SPEC.md`](01_preplan/06_CORPORATEFE_INVENTORY_AND_FINANCE_SPEC.md) | **Inventory & Financial Billing Specification**: Multi-facility stock ledger, automated `CorporateItemOut` triggers on pickup, automated `CorporateItemIn` triggers on delivery, distributor commercial invoicing, and freight billing audit reconciliation. |
| **07** | [`07_GAP_ANALYSIS_AND_ENHANCEMENTS.md`](01_preplan/07_GAP_ANALYSIS_AND_ENHANCEMENTS.md) | **Comprehensive Gap Analysis**: Systematic audit contrasting legacy CodeIgniter 4 monolith (`Corporate-Development`) with modernized Laravel 12 architecture (`CorporateFE` + `BackendCorporateLogistic`), highlighting smartlock deprecation, item encapsulation, and BFF security. |

---

## 📁 Implementation Checklists (`docs/02_implementation`)

| Index | Document File Name | Focus Area & Scope |
| :---: | :--- | :--- |
| **01** | [`01_CORPORATEFE_IMPLEMENTATION_CHECKLIST.md`](02_implementation/01_CORPORATEFE_IMPLEMENTATION_CHECKLIST.md) | **Master 7-Phase Implementation Tracking Checklist**: Step-by-step progress tracker covering environment initialization, component porting, master data CRUD, RO wizard, child waybills, inventory sync, and distributor billing. |
| **02** | [`02_BACKEND_SYNC_AND_VERIFICATION_CHECKLIST.md`](02_implementation/02_BACKEND_SYNC_AND_VERIFICATION_CHECKLIST.md) | **Backend Endpoint Parity & Verification Checklist**: Detailed verification matrix auditing HTTP methods, parameters, and response shapes across all consumed backend endpoints. |
