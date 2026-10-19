# 04. CorporateFE API Contract Specifications
## Comprehensive Internal BFF Proxy Endpoints & Backend API Schemas

> **Target Directory:** `d:\DevMuncen\CorporateFE/docs/01_preplan/04_CORPORATEFE_API_CONTRACTS.md`  
> **Backend Engine:** `d:\DevMuncen\BackendCorporateLogistic` (`/api/corporate/*`, `/api/master/*`, `/api/auth/*`)  
> **Security Standards:** S2S Sanctum Token Forwarding with `X-Tenant-Corporate-ID` Header Injection

---

## 1. Authentication & Multi-Tenant S2S Session Setup

### 1.1 Login Endpoint
* **Internal Frontend Route:** `POST /login` (handled by `AuthController.php`)
* **Backend Target:** `POST /api/auth/login`
* **Request Payload:**
  ```json
  {
    "username": "korporasi_merahputih",
    "password": "muncen12",
    "portal_type": "corporate"
  }
  ```
* **Backend Response (`200 OK`):**
  ```json
  {
    "status": "success",
    "message": "Login berhasil.",
    "data": {
      "user": {
        "id": 8,
        "name": "PIC Korporasi Merah Putih",
        "email": "korporasi@logistikmerahputih.com",
        "role": "corporate_admin",
        "portal_access": "corporate",
        "corporate_id": 1
      },
      "access_token": "4|sanctum-token-hash...",
      "token_type": "Bearer"
    }
  }
  ```
* **BFF Handling:** Stores `access_token` in `session('api_token')`, `corporate_id` in `session('tenant_corporate_id')`, and user profile in `session('user_data')`.

### 1.2 Mandatory S2S Forwarding Headers
All internal proxy calls forwarded to `BackendCorporateLogistic` automatically attach:
```http
Authorization: Bearer {session('api_token')}
X-Tenant-Corporate-ID: {session('tenant_corporate_id')}
Accept: application/json
```

---

## 2. Corporate Master Data Contracts

### 2.1 Corporate Product Catalog (`/products`)
| Internal Route (`/api/internal/corporate/...`) | Backend Target (`/api/corporate/...`) | Method | Description |
| :--- | :--- | :---: | :--- |
| `/products` | `/products` | `GET` | List corporate products (paginated, search, category filter) |
| `/products` | `/products` | `POST` | Create new product (requires `code`, `name`, `cargo_type_id`, `default_price`) |
| `/products/{id}` | `/products/{id}` | `GET` | Get single product detail |
| `/products/{id}` | `/products/{id}` | `PUT` | Update product details |
| `/products/{id}` | `/products/{id}` | `DELETE`| Soft delete product |

### 2.2 Corporate Warehouses & Manufacturing Facilities (`/warehouses`)
| Internal Route | Backend Target | Method | Description |
| :--- | :--- | :---: | :--- |
| `/warehouses` | `/warehouses` | `GET` | List corporate facilities (includes `is_pickup_hub` status) |
| `/warehouses` | `/warehouses` | `POST` | Create warehouse (`code`, `name`, `address`, `city_code`, `is_pickup_hub`) |
| `/warehouses/{id}` | `/warehouses/{id}` | `GET` | Detail of warehouse |
| `/warehouses/{id}` | `/warehouses/{id}` | `PUT` | Update warehouse properties |
| `/warehouses/{id}` | `/warehouses/{id}` | `DELETE`| Remove warehouse |

### 2.3 Corporate Customers & Vendors
| Internal Route | Backend Target | Method | Description |
| :--- | :--- | :---: | :--- |
| `/customers` | `/customers` | `GET` / `POST` | List and create corporate B2B customers (`city_code`, `pic_name`) |
| `/customers/{id}` | `/customers/{id}` | `GET` / `PUT` / `DELETE` | View, update, or remove customer |
| `/vendors` | `/vendors` | `GET` / `POST` | Supply vendor directory management |

### 2.4 Reference Data Selectors
| Internal Route | Backend Target | Method | Description |
| :--- | :--- | :---: | :--- |
| `/uoms` | `/uoms` | `GET` | List active UOMs (Pcs, Box, Karton, Kg) |
| `/product-categories`| `/product-categories` | `GET` / `POST` | List and create product categories |
| `/cargo-types` | `/api/cargo-types` | `GET` | Read-only cargo categories and handling fee multipliers |
| `/master/logistic-vendors`| `/api/master/logistic-vendors/options` | `GET` | Read-only transport carrier options for selection |
| `/master/cities` | `/api/master/cities` | `GET` | Kemendagri city/regency dropdown options |

---

## 3. Request Order Engine & Dynamic Pricing Contracts

### 3.1 Route Inquiry (`inquireRoutes`)
* **Internal Route:** `POST /api/internal/corporate/request-orders/inquire-routes`
* **Backend Target:** `POST /api/corporate/request-orders/inquire-routes`
* **Request Payload:**
  ```json
  {
    "origin_city_code": "31.71",
    "destination_city_code": "35.78",
    "fleet_type_id": 1
  }
  ```
* **Response Payload (`200 OK`):**
  ```json
  {
    "status": "success",
    "data": {
      "available_carriers": [
        {
          "logistic_id": 1,
          "logistic_name": "Logistik Merah Putih",
          "contract_id": 1,
          "price_contract_id": 101,
          "linehaul_price": 3500000.00,
          "shunting_price": 450000.00,
          "inner_city_shunting_price": 250000.00,
          "total_estimated": 4200000.00
        }
      ]
    }
  }
  ```

### 3.2 Dynamic Pricing Calculation (`calculatePricing`)
* **Internal Route:** `POST /api/internal/corporate/request-orders/calculate-pricing`
* **Backend Target:** `POST /api/corporate/request-orders/calculate-pricing`
* **Request Payload:**
  ```json
  {
    "logistic_id": 1,
    "origin_city_code": "31.71",
    "destination_city_code": "35.78",
    "fleet_type_id": 1,
    "cargo_type_id": 1,
    "waypoints_count": 2
  }
  ```
* **Response Payload (`200 OK`):**
  ```json
  {
    "status": "success",
    "data": {
      "contract_id": 1,
      "price_contract_id": 101,
      "pricing_tier": "corporate_specific",
      "rates": {
        "linehaul_price": 3500000.00,
        "shunting_price": 450000.00,
        "inner_city_shunting_price": 250000.00,
        "subtotal_base_rate": 4200000.00
      },
      "adjustments": {
        "multi_stop_surcharge": 0.00,
        "cargo_multiplier": 1.00
      },
      "total_estimated_cost": 4200000.00
    }
  }
  ```

### 3.3 Request Orders CRUD (`/request-orders`)
* **Internal Route:** `POST /api/internal/corporate/request-orders`
* **Backend Target:** `POST /api/corporate/request-orders`
* **Request Payload (Multi-Drop with Encapsulated Items):**
  ```json
  {
    "order_date": "2026-10-15",
    "origin_warehouse_id": 1,
    "origin_city_code": "31.71",
    "destination_city_code": "35.78",
    "origin_address": "Jl. Industri Selatan No. 12, Cikarang",
    "sender_name": "Gudang Utama Merah Putih",
    "sender_phone": "08123456789",
    "fleet_type_id": 1,
    "logistic_id": 1,
    "notes": "Pengiriman Multi-Stop Prioritas",
    "delivery_points": [
      {
        "stop_sequence": 1,
        "city_code": "32.73",
        "delivery_type": 2,
        "distributor_warehouse_id": 1,
        "distributor_order_id": 105,
        "po_number": "PO-DIST-2026-009",
        "recipient_name": "Mitra Distributor Bandung",
        "recipient_phone": "081377665511",
        "address": "Jl. Soekarno Hatta No. 100, Bandung",
        "items": [
          {
            "product_id": 1,
            "cargo_type_id": 1,
            "quantity": 20,
            "unit_price": 150000,
            "notes": "Drop 1"
          }
        ]
      },
      {
        "stop_sequence": 2,
        "city_code": "35.78",
        "delivery_type": 2,
        "distributor_warehouse_id": 2,
        "recipient_name": "Mitra Distributor Surabaya",
        "recipient_phone": "081377665544",
        "address": "Jl. Industri Raya No. 45, Surabaya",
        "items": [
          {
            "product_id": 1,
            "cargo_type_id": 1,
            "quantity": 30,
            "unit_price": 150000,
            "notes": "Drop 2"
          }
        ]
      }
    ]
  }
  ```

### 3.4 Distributor Orders Lookup & Autofill
* **Internal Route:** `GET /api/internal/corporate/distributor-orders?city_code={code}`
* **Backend Target:** `GET /api/corporate/distributor-orders?city_code={code}`
* Returns pending distributor purchase orders to auto-populate delivery points and products.

---

## 4. Child Waybills, Live Tracking & Verification

| Internal Route (`/api/internal/corporate/...`) | Backend Target (`/api/corporate/...`) | Method | Description |
| :--- | :--- | :---: | :--- |
| `/waybills` | `/waybills` | `GET` | List child waybills (`AWB-...-S{seq}`) |
| `/waybills/{id}` | `/waybills/{id}` | `GET` | Single waybill details, items, drop point |
| `/waybills/{id}/tracking` | `/waybills/{id}/tracking` | `GET` | Live shipment milestones, GPS telemetry, proof photos |
| `/waybills/{id}/print` | `/waybills/{id}/print` | `GET` | Printable Surat Jalan HTML layout |
| `/waybills/{id}/confirm-pickup` | `/waybills/{id}/confirm-pickup` | `POST` | Physical pickup confirmation + `pickup_proof_photo` |
| `/waybills/{id}/complete-delivery` | `/waybills/{id}/complete-delivery`| `POST` | Delivery drop confirmation + `pod_proof_photo` |

---

## 5. Inventory & Financial Billing Contracts

### 5.1 Corporate Inventory Movements
| Internal Route | Backend Target | Method | Description |
| :--- | :--- | :---: | :--- |
| `/inventory/item-ins` | `/item-ins` | `GET` / `POST` | Goods receipt logging / stock additions |
| `/inventory/item-outs` | `/item-outs` | `GET` / `POST` | Goods issue logging / stock deductions |

### 5.2 Distributor Invoices (`distributor-invoices`)
| Internal Route | Backend Target | Method | Description |
| :--- | :--- | :---: | :--- |
| `/finance/distributor-invoices` | `/finance/distributor-invoices` | `GET` | List distributor invoices, status, totals |
| `/finance/distributor-invoices` | `/finance/distributor-invoices` | `POST` | Generate distributor invoice |
| `/finance/distributor-invoices/form-dependencies` | `/finance/distributor-invoices/form-dependencies` | `GET` | Pending orders and customer lists for invoice creation |
