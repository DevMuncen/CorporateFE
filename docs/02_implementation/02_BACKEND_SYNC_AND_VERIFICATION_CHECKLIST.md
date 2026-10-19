# 02. CorporateFE Backend Synchronization & Endpoint Parity Checklist
## Verification Matrix for BackendCorporateLogistic API Endpoints

> **Target Directory:** `d:\DevMuncen\CorporateFE/docs/02_implementation/02_BACKEND_SYNC_AND_VERIFICATION_CHECKLIST.md`  
> **Backend Engine:** `d:\DevMuncen\BackendCorporateLogistic` (`routes/api.php`)  
> **Verification Standard:** HTTP Status Codes, Response JSON Shapes, Tenant Scoping, and Error Handlers.

---

## 1. Authentication & Tenant Resolution Verification

| Endpoint | Method | Expected Input Payload | Expected Response Shape | Verification Status |
| :--- | :---: | :--- | :--- | :---: |
| `/api/auth/login` | `POST` | `{"username": "korporasi_merahputih", "password": "...", "portal_type": "corporate"}` | `status: "success", access_token: "...", user.corporate_id: 1` | Verified (200 OK) |
| `/api/auth/me` | `GET` | Header: `Authorization: Bearer {token}` | User profile with `portal_access: "corporate"` | Verified (200 OK) |
| `/api/auth/logout` | `POST` | Header: `Authorization: Bearer {token}` | Token invalidated | Verified (200 OK) |

---

## 2. Corporate Master Data Endpoints Parity

| Endpoint | Method | Required Scope / Query | Expected Response Shape | Verification Status |
| :--- | :---: | :--- | :--- | :---: |
| `/api/corporate/products` | `GET` | Scoped to `corporate_id` | Paginated product list with `cargo_type_id`, `uom` | Verified (200 OK) |
| `/api/corporate/products` | `POST` | `code`, `name`, `cargo_type_id`, `default_price` | Created product model | Verified (201 Created) |
| `/api/corporate/products/{id}` | `PUT` | Product updates | Updated product model | Verified (200 OK) |
| `/api/corporate/product-categories`| `GET` / `POST` | Scoped categories | Category collection | Verified (200 OK) |
| `/api/corporate/uoms` | `GET` | Active UOMs | List of UOM models | Verified (200 OK) |
| `/api/corporate/warehouses` | `GET` | Scoped facilities | List of facilities with `is_pickup_hub` | Verified (200 OK) |
| `/api/corporate/warehouses` | `POST` | `code`, `name`, `address`, `city_code`, `is_pickup_hub` | Created warehouse model | Verified (201 Created) |
| `/api/corporate/customers` | `GET` / `POST` | B2B Customers | Customer collection | Verified (200 OK) |
| `/api/corporate/vendors` | `GET` / `POST` | Supply Vendors | Vendor collection | Verified (200 OK) |
| `/api/master/logistic-vendors/options` | `GET` | Approved carriers | Array of `{ id, name, code }` | Verified (200 OK) |
| `/api/cargo-types` | `GET` | Global cargo categories | Array with `handling_fee_multiplier` | Verified (200 OK) |
| `/api/master/cities` | `GET` | Kemendagri city codes | Array of `{ code, name, province_code }` | Verified (200 OK) |

---

## 3. Request Order, Route Inquiry & Dynamic Pricing Verification

| Endpoint | Method | Key Request Parameters | Expected Behavior & Response | Verification Status |
| :--- | :---: | :--- | :--- | :---: |
| `/api/corporate/request-orders/inquire-routes` | `POST` | `origin_city_code`, `destination_city_code`, `fleet_type_id` | Returns `available_carriers[]` with base contract rates | Verified (200 OK) |
| `/api/corporate/request-orders/calculate-pricing`| `POST` | `logistic_id`, `origin_city_code`, `destination_city_code`, `fleet_type_id`, `cargo_type_id`, `waypoints_count` | Returns itemized tariff breakdown (linehaul, shunting, adjustments, total) | Verified (200 OK) |
| `/api/corporate/request-orders` | `GET` | Filter by `status`, `date` | Paginated Request Orders with `delivery_points[]` | Verified (200 OK) |
| `/api/corporate/request-orders` | `POST` | Multi-drop payload with `delivery_points[].items[]` | Creates RO and locks `snapshot_pricing` | Verified (201 Created) |
| `/api/corporate/request-orders/{id}` | `GET` | RO ID | Complete RO detail with frozen pricing | Verified (200 OK) |
| `/api/corporate/distributor-orders` | `GET` | Filter `?city_code={code}` | Pending distributor POs for RO autofill | Verified (200 OK) |

---

## 4. Child Waybills, Tracking & Verification Endpoints Parity

| Endpoint | Method | Key Parameters | Expected Behavior & Response | Verification Status |
| :--- | :---: | :--- | :--- | :---: |
| `/api/corporate/waybills` | `GET` | Filter by status, carrier | Spawned child waybills (`AWB-...-S{seq}`) | Verified (200 OK) |
| `/api/corporate/waybills/{id}` | `GET` | Waybill ID | Waybill detail with items and drop point | Verified (200 OK) |
| `/api/corporate/waybills/{id}/tracking` | `GET` | Waybill ID | Milestone timeline, driver telemetry, proof photos | Verified (200 OK) |
| `/api/corporate/waybills/{id}/print` | `GET` | Waybill ID | Printable HTML Surat Jalan format | Verified (200 OK) |
| `/api/corporate/waybills/{id}/confirm-pickup` | `POST` | Multipart: `pickup_proof_photo` | Updates status to `transit`; auto-triggers `CorporateItemOut` if origin is Corporate WH | Verified (200 OK) |
| `/api/corporate/waybills/{id}/complete-delivery`| `POST` | Multipart: `pod_proof_photo` | Updates status to `delivered`; auto-triggers `CorporateItemIn` if drop is Corporate WH | Verified (200 OK) |

---

## 5. Inventory & Financial Billing Endpoints Parity

| Endpoint | Method | Key Parameters | Expected Response | Verification Status |
| :--- | :---: | :--- | :--- | :---: |
| `/api/corporate/item-ins` | `GET` / `POST` | `warehouse_id`, items array | Goods receipt list & manual creation | Verified (200 OK) |
| `/api/corporate/item-outs` | `GET` / `POST` | `warehouse_id`, items array | Goods dispatch list & manual creation | Verified (200 OK) |
| `/api/corporate/finance/distributor-invoices` | `GET` | Filter by `status` | Distributor invoices ledger | Verified (200 OK) |
| `/api/corporate/finance/distributor-invoices` | `POST` | Bundled `order_ids[]`, terms | Created distributor invoice | Verified (201 Created) |
| `/api/corporate/finance/distributor-invoices/form-dependencies` | `GET` | None | Unbilled orders & distributor options | Verified (200 OK) |
| `/api/corporate/invoices` | `GET` | Carrier freight invoices | Invoices matching against `snapshot_pricing` | Verified (200 OK) |
| `/api/corporate/dashboard/mobile` | `GET` | None | Summary metrics for dashboard KPI cards | Verified (200 OK) |
