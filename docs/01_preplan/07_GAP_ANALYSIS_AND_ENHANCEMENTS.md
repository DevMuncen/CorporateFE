# 07. CorporateFE Gap Analysis & Architectural Enhancements
## Comparative Analysis: Legacy CodeIgniter 4 (Corporate-Development) vs. Modern Laravel 12 (CorporateFE + BackendCorporateLogistic)

> **Target Directory:** `d:\DevMuncen\CorporateFE/docs/01_preplan/07_GAP_ANALYSIS_AND_ENHANCEMENTS.md`  
> **Legacy Reference:** `d:\DevMuncen\Corporate-Development` (CodeIgniter 4 Monolith)  
> **Target Production:** `d:\DevMuncen\CorporateFE` (Laravel 12 BFF) + `BackendCorporateLogistic` (Laravel 12 API)

---

## 1. Executive Modernization Audit

The legacy application (`Corporate-Development`) was constructed as a traditional monolithic CodeIgniter 4 application. Over time, it accumulated significant technical debt: 169+ controller files, tightly coupled database queries, duplicated session handling, legacy UI templates with z-index modal trapping, and rigid single-drop logistics workflows.

**`CorporateFE`** represents a complete modernization: a decoupled, high-performance Laravel 12 frontend operating on a secure **Backend-For-Frontend (BFF)** proxy pattern, consuming the modernized multi-tenant REST API of **`BackendCorporateLogistic`**.

```
+--------------------------------------------------------------------------+
|  ARCHITECTURAL TRANSFORMATION MATRIX                                     |
+--------------------------+-----------------------+-----------------------+
| Architectural Dimension  | Legacy CI4 Monolith   | Modern CorporateFE    |
+--------------------------+-----------------------+-----------------------+
| Framework & Language     | CodeIgniter 4 (PHP 7/8)| Laravel 12 (PHP 8.2+) |
| Frontend Technology      | Bootstrap / jQuery    | Tailwind v4 + Preline |
| Build Tool               | Manual Asset Scripts  | Vite 7 Bundler        |
| API Architecture         | Monolithic Views      | Decoupled REST BFF    |
| Authentication & Auth    | Monolithic DB Session | Sanctum S2S Bearer    |
| Tenant Isolation         | Fragile Query Filters | X-Tenant-Corporate-ID |
| Request Order Workflow   | Flat Single-Drop      | Multi-Drop RO Wizard  |
| Item Packaging           | Top-Level Mixed Items | Encapsulated in Drops |
| Distributor PO Sync      | Manual Double-Entry   | 1-Click PO Autofill   |
| Freight Tariff Engine    | Hardcoded Lookups     | Dynamic Snapshotting  |
| Waybill Generation       | Manual Document Issue | Auto-Spawned Waybills |
| Proof & Verification     | Deprecated SiGembok   | Photo Proofs (POD)    |
| Inventory Movement       | Manual Goods Movement | Event-Driven Triggers |
| Modal Stacking           | Trapped Z-Index Bugs  | Strict Layer Tokening |
+--------------------------+-----------------------+-----------------------+
```

---

## 2. Detailed Technical Gap Analysis

### 2.1 Multi-Drop Routing & Delivery Point Item Encapsulation
- **Legacy Defect (`Corporate-Development`):**
  - Orders stored all items in a single top-level table (`tb_detail_ro`).
  - Waypoints lacked structured stop sequences and could not specify which items were to be dropped at which destination.
- **Modern Enhancement (`CorporateFE`):**
  - Structured `delivery_points[]` array sequentially ordered by `stop_sequence` (1, 2, 3...).
  - Products belong strictly inside `delivery_points[i].items[]`.
  - Mutually exclusive destination typing (`delivery_type`: 1 = Corporate WH, 2 = Distributor WH, 3 = Customer).
  - Approving the Request Order automatically generates individual **Child Waybills (`AWB-...-S{seq}`)** matching each drop point.

### 2.2 Dynamic Tariff Calculation & Snapshot Locking
- **Legacy Defect:**
  - Freight calculations were calculated on the fly or hardcoded in legacy controllers (`calculateContractPrice()`), causing price drift when rate contracts changed mid-shipment.
- **Modern Enhancement:**
  - Real-time pre-submission rate inquiry (`POST /api/corporate/request-orders/inquire-routes`).
  - Itemized tariff calculation (`POST /api/corporate/request-orders/calculate-pricing`) combining Linehaul, Outer Shunting, Inner-City Shunting, and Cargo Sensitivity Multipliers.
  - Frozen **`snapshot_pricing`** JSON locked inside the Request Order upon submission, ensuring 100% price parity during carrier freight invoice reconciliation.

### 2.3 Distributor Purchase Order Integration
- **Legacy Defect:**
  - Corporate dispatchers had to manually copy-paste distributor purchase orders into shipping forms, leading to data entry errors and inventory mismatches.
- **Modern Enhancement:**
  - Direct integration via `GET /api/corporate/distributor-orders?city_code={code}`.
  - 1-Click Autofill populating recipient address, contact information, PO number, and product quantities into the active drop point.
  - Linked distributor orders automatically transition to `scheduled_for_delivery`.

### 2.4 Event-Driven Inventory Synchronization
- **Legacy Defect:**
  - Warehouse stock deductions and additions had to be keyed manually by warehouse clerks across separate screens (`ItemIn.php`, `ItemOut.php`), resulting in frequent stock variances.
- **Modern Enhancement:**
  - Automated **`CorporateItemOut`**: Decrements stock from `corporate_product_stocks` upon confirmed carrier pickup (`confirmPickup()`) if the origin is a Corporate Warehouse.
  - Automated **`CorporateItemIn`**: Increments stock at destination warehouse upon delivery completion (`completeDelivery()`) if the destination is a Corporate Warehouse (`delivery_type = 1`).
  - Bypassed cleanly for customer or distributor drop points.

### 2.5 Security, Multi-Tenancy & BFF Architecture
- **Legacy Defect:**
  - Browser-side scripts interacted directly with database models or unauthenticated session cookies.
- **Modern Enhancement:**
  - **No Client-Side Token Storage:** Sanctum tokens and corporate tenant IDs are held exclusively in encrypted server-side Laravel sessions.
  - Internal S2S Proxy (`ProxyController.php`) seamlessly injects `Authorization: Bearer {token}` and `X-Tenant-Corporate-ID: {corporate_id}` on every forwarded call.
  - Backend validation enforced via `ResolveCorporateTenantContext` middleware.

### 2.6 Complete Deprecation of SiGembok Smartlocks
- **Legacy Defect:**
  - Legacy code required physical SiGembok smartlock hardware pairing (`requires_sigembok`), which caused dispatch bottlenecks due to device battery failures and hardware shortage.
- **Modern Enhancement:**
  - Complete elimination of SiGembok dependencies from forms, schemas, and tracking views.
  - Verification standardized on **Bukti Pickup (`pickup_proof_photo`)**, **Proof of Delivery (`pod_proof_photo`)**, and driver GPS telemetry.

---

## 3. Deprecated File & Component Removal Matrix

When establishing `CorporateFE`, the following legacy CodeIgniter 4 controller domains from `Corporate-Development` are officially replaced or consolidated:

| Legacy CI4 Controller (`Corporate-Development`) | Replacement Architecture in CorporateFE |
| :--- | :--- |
| `RequestOrder.php`, `RequestPickup.php`, `RequestResi.php` | Consolidated into `request-orders/create.blade.php` (5-Step RO Wizard) |
| `CorporateWaybill.php`, `WayBill.php` | Consolidated into `waybills/index.blade.php` & `waybills/show.blade.php` |
| `OrderDistributor.php`, `DistributorOrder.php` | Replaced by `distributor-orders/index.blade.php` & RO Autofill |
| `GoodsIn.php`, `ItemIn.php` | Replaced by `inventory/item-ins.blade.php` & Auto-Trigger |
| `GoodsOut.php`, `ItemOut.php` | Replaced by `inventory/item-outs.blade.php` & Auto-Trigger |
| `DistributorInvoice.php` | Modernized in `finance/distributor-invoices/index.blade.php` |
| `Palet.php`, `Assets.php` (SiGembok) | **DEPRECATED & REMOVED** |
| `BengkelController.php`, `Armada.php` | Reassigned exclusively to Carrier Portal (`LogisticFE`) |
| `MenuController.php`, `PrivilegePresetController.php` | Replaced by standard Laravel 12 Blade components & RBAC |
