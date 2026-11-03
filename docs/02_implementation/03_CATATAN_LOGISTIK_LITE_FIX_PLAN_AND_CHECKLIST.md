# Rencana Perbaikan & Checklist Implementasi: Catatan Logistik Sedang (Lite)
**Berdasarkan Laporan Pengujian:** `CATATAN LOGISTIK LITE 19102026.pdf` (19 Oktober 2026)  
**Penguji:** Mufidi  
**Developer:** Simon, Nugroho  
**Target Repositori:**
- **Backend (BE):** `d:\DevMuncen\BackendCorporateLogistic` (Laravel 12 / Port 8001)
- **Frontend (FE):** `d:\DevMuncen\CorporateFE` (Laravel 12 + Tailwind v4 + Preline UI / Port 8004)

---

## 1. Ringkasan Eksekutif & Analisis Akar Masalah (Root Cause Analysis)

Berdasarkan pengujian menyeluruh pada platform Corporate (`corporate.logistikmerahputih.com`), ditemukan 16 catatan utama yang menghambat alur operasional. Sebagian besar kegagalan submit (404/405 error) disebabkan oleh **ketidaksinkronan antara rute proxy di Frontend (`routes/web.php`) dengan panggilan API di view Blade (`axios`)**, serta ketidakcocokan nama atribut payload antara FE dan BE.

### Ringkasan Masalah Utama:
1. **Routing Proxy Mismatch (404 & 405 Method Not Supported):**
   - Di `CorporateFE/routes/web.php`, endpoint proxy backend hanya didaftarkan di bawah prefix `api/internal/corporate/*`, sementara seluruh kode JavaScript di Blade memanggil `/api/products`, `/api/product-categories`, `/api/warehouses`, `/api/customers`, `/api/vendors`, `/api/distributors`, `/api/inventory/*`, dan `/api/finance/*`.
   - Di bawah prefix `Route::prefix('api')`, hanya ada 5 route `GET` saja (`/dashboard/summary`, `/request-orders`, `/products`, `/warehouses`, `/waybills`). Panggilan `POST /api/warehouses` menghasilkan `405 The POST method is not supported for route api/warehouses. Supported methods: GET, HEAD.`, dan panggilan `POST /api/product-categories`, `POST /api/customers`, `POST /api/vendors` menghasilkan `404 Not Found`.

2. **Perubahan Terminologi & Domain Konsep (Distributor &rarr; Customer):**
   - Catatan penguji secara eksplisit meminta konsep "Distributor" diubah menjadi "CUSTOMER" (Pelanggan) karena pada model Corporate, penagihan dan distribusi ditangani langsung dalam satu panel Corporate ke Customer. Hal ini berlaku untuk menu Mitra Distributor, Pesanan Distributor, Faktur Penagihan Distributor, dan tombol pada Tagihan Ongkir Logistik.

3. **Sinkronisasi Katalog SKU & Mobile App:**
   - Dropdown kategori kosong karena tidak ada inisialisasi pemanggilan `/api/product-categories` pada modal produk maupun filter kategori.
   - Ketidaksesuaian penamaan field: FE mengirim `sku`, `base_price`, `weight`, sementara BE `CorporateProductController` memvalidasi `code` (wajib), `default_price`, `weight_kg`.
   - Token login auth tidak mengembalikan `corporate_id` eksplisit di `data.user`, sehingga FE fallback ke `tenant_corporate_id = 1` yang bisa berbeda dengan corporate ID yang digunakan saat mobile app menambahkan produk.

4. **Inventori & Modul Multi-Gudang Belum Tersedia (Blank / Tanpa Form):**
   - Endpoint saldo stok gudang (`/api/inventory/stocks`) belum ada di controller maupun router.
   - Halaman Barang Masuk (`item-ins.blade.php`) dan Barang Keluar (`item-outs.blade.php`) hanya berupa tabel pasif tanpa tombol "+ Tambah", tanpa modal form, dan tanpa eksekusi mutasi stok `CorporateProductStock`.

5. **Wizard Request Order (RO) Desinkronisasi:**
   - Terdapat bentrok struktur antara `create.blade.php` dan `ro-wizard.js` (ID elemen HTML berbeda: `ro-wizard-form` vs `step-content-1`, `originWarehouse` vs `origin_warehouse_id`), dan data gudang asal tidak pernah dimuat (`fetch`) ke dropdown `<select id="originWarehouse">`.

6. **Pembersihan Komponen UI:**
   - Menghapus box section biru tua "Integrasi Logistik" di kanan bawah dashboard.
   - Menghapus icon Language, Dark Mode, dan Notifikasi di Top Section Header karena tidak ada fungsionalitasnya.
   - Menghapus tombol "Faktur Penagihan Distributor" di halaman Tagihan Ongkir Logistik.

---

## 2. Matriks Rincian Perbaikan per Item Catatan (16 Item)

| No | Modul / Catatan | Root Cause | Rencana Perbaikan Backend (BE) | Rencana Perbaikan Frontend (FE) |
|---|---|---|---|---|
| **1** | **DASHBOARD**<br>- Data analitik tidak aktual<br>- Hapus box biru tua kanan bawah | - Backend `CorporateMobileDashboardController` hanya hitung 6 metrik (tanpa total produk, total unit stok, dan total invoice).<br>- FE fallback ke nilai statis `12, 3, 5, 8, 1450, 4`.<br>- Terdapat card "Integrasi Logistik" redundan. | - Update `CorporateMobileDashboardController` (atau sediakan endpoint `/api/corporate/dashboard/summary`) agar menghitung data aktual real-time dari database:<br>• `total_products`: `CorporateProduct::where('corporate_id', $cid)->count()`<br>• `total_warehouses`: `CorporateWarehouse::where('corporate_id', $cid)->count()`<br>• `total_request_orders`: `RequestOrder::where('corporate_id', $cid)->count()`<br>• `total_waybills`: `Waybill::where('corporate_id', $cid)->count()`<br>• `total_stock_units`: `CorporateProductStock::where('corporate_id', $cid)->sum('quantity')`<br>• `total_invoices`: `DistributorInvoice::where('corporate_id', $cid)->count()` atau `CorporateCustomer::where('corporate_id', $cid)->count()`. | - Hapus card biru tua kanan bawah (`Integrasi Logistik Muncen` & tombol `Buat Pengiriman Baru`) di `resources/views/dashboard.blade.php`.<br>- Bind data aktual dari respons API ke card statistik tanpa fallback ke mock dummy angka statis.<br>- Muat 5 data Request Order terbaru langsung dari respons real-time. |
| **2** | **KATALOG SKU**<br>- Kategori kosong<br>- Tidak sinkron dengan Mobile App | - Dropdown kategori tidak pernah di-fetch dari API.<br>- Parameter payload berbeda (`sku` vs `code`, `base_price` vs `default_price`, `weight` vs `weight_kg`).<br>- Tenant ID session tidak terisi dari auth user payload. | - Tambahkan alias accessor/mutator pada model `CorporateProduct` (`sku` &rarr; `code`, `price` &rarr; `default_price`, `weight` &rarr; `weight_kg`) dan `appends = ['sku', 'price', 'weight']`.<br>- Di `CorporateProductController@store` dan `@update`, terima baik `code` maupun `sku`, `default_price` maupun `base_price`, serta `weight_kg` maupun `weight`.<br>- Di `AuthController@login`, sertakan `corporate_id` pada objek `user`. | - Di `products/index.blade.php`, tambahkan fungsi `fetchCategories()` saat DOM ready untuk mengisi `<select id="categoryFilter">` dan `<select id="prodCategory">`.<br>- Sesuaikan render tabel dan form submit agar membaca/mengirim atribut dengan fallback yang konsisten (`p.sku \|\| p.code`, `p.base_price \|\| p.default_price`, `p.weight \|\| p.weight_kg`).<br>- Pastikan pagination info dan controls berfungsi. |
| **3** | **KATEGORI PRODUK**<br>- Gagal Submit (`route api/product-categories could not be found`) | - Route `/api/product-categories` tidak didaftarkan di grup `Route::prefix('api')` pada `CorporateFE/routes/web.php`. | - Pastikan `CorporateProductCategoryController` di BE mendukung validasi unik per tenant (`corporate_id`). | - Di `CorporateFE/routes/web.php`, daftarkan rute proxy lengkap untuk `/api/product-categories` (`GET`, `POST`, `PUT`, `DELETE`) yang mengarah ke `CorporateProductController` (`proxyCategories`, `proxyStoreCategory`, dll.). |
| **4** | **HUB & GUDANG**<br>- Gagal Submit (`POST method is not supported for route api/warehouses`) | - Di `CorporateFE/routes/web.php`, `/api/warehouses` hanya didaftarkan method `GET`, sehingga `POST` ditolak (HTTP 405). | - Di `CorporateWarehouseController@store` & `@update`, tambahkan validasi dan pengisian kolom `city`, `city_code`, `phone`, `pic_name`, `postal_code`. | - Di `CorporateFE/routes/web.php`, daftarkan rute `POST`, `PUT`, `DELETE` untuk `/api/warehouses` yang mengarah ke `CorporateWarehouseController@proxyStore`, `@proxyUpdate`, `@proxyDestroy`. |
| **5** | **PELANGGAN B2B**<br>- Gagal Submit (`route api/customers could not be found`) | - Route `/api/customers` tidak didaftarkan di grup `Route::prefix('api')` pada `CorporateFE/routes/web.php`. | - Pastikan `CorporateCustomerController` di BE menerima data PIC, telepon, email, alamat, dan kota. | - Di `CorporateFE/routes/web.php`, daftarkan rute proxy lengkap untuk `/api/customers` (`GET`, `POST`, `PUT`, `DELETE`) yang mengarah ke `CorporateCustomerController`. |
| **6** | **VENDOR LOGISTIK**<br>- Gagal Submit (`route api/vendors could not be found`) | - Route `/api/vendors` tidak didaftarkan di grup `Route::prefix('api')` pada `CorporateFE/routes/web.php`. | - Pastikan `CorporateVendorController` di BE berjalan normal. | - Di `CorporateFE/routes/web.php`, daftarkan rute proxy lengkap untuk `/api/vendors` (`GET`, `POST`, `PUT`, `DELETE`) yang mengarah ke `CorporateVendorController`. |
| **7** | **MITRA DISTRIBUTOR**<br>- Ganti ke CUSTOMER<br>- Gagal simpan (`route api/distributors could not be found`) | - Penguji meminta terminologi diubah ke CUSTOMER.<br>- Route `/api/distributors` tidak terdaftar. | - Di backend, gunakan entitas `CorporateCustomer` sebagai master customer korporasi. Jika ada filter tipe, gunakan flag `customer_type` ('distributor'/'b2b'). | - Ubah label menu sidebar dan halaman dari "Mitra Distributor" menjadi "Customer" / "Data Pelanggan (Customer)".<br>- Di `CorporateFE/routes/web.php`, arahkan `/api/distributors` ke `CorporateCustomerController` atau `CorporateDistributorController` yang mem-proxy ke `/api/corporate/customers`. |
| **8** | **REQUEST ORDER (RO)**<br>- Sinkronisasi dengan Mobile App<br>- Sinkronisasi data Gudang Asal | - Halaman form wizard `create.blade.php` tidak memuat data gudang asal dari backend.<br>- Skrip `ro-wizard.js` memiliki ID selektor yang tidak cocok dengan Blade template. | - Pastikan endpoint `GET /api/corporate/request-orders` mengembalikan data relasi lengkap (`originWarehouse`, `logistic`, `fleetType`, `waybills`).<br>- Pastikan endpoint `POST /api/corporate/request-orders/inquire-routes` dan `calculate-pricing` sinkron dengan kontrak transporter. | - Di `request-orders/create.blade.php`, tambahkan inisialisasi `fetchWarehouses()` saat load untuk mengisi dropdown `<select id="originWarehouse">`.<br>- Selaraskan selektor ID antara `create.blade.php` dan `ro-wizard.js` agar wizard 5-tahap dapat bernavigasi dan menghitung estimasi tarif.<br>- Di daftar RO (`index.blade.php`), tampilkan data RO riil yang dibuat baik dari web maupun dari Mobile App. |
| **9** | **PESANAN DISTRIBUTOR**<br>- Ganti jadi PESANAN CUSTOMER<br>- Memuat order Customer dari Request Order | - Judul halaman masih "Pesanan Distributor".<br>- Controller BE sebelumnya membaca `DistributorInvoice`, bukan pesanan customer dari `RequestOrder`. | - Di `CorporateDistributorOrderController@index`, ubah query agar memuat pesanan customer dari `RequestOrderItem` dan `RequestOrder` (`where('corporate_id', $cid)`), menyertakan data penerima/customer, produk, kuantitas, dan status RO. | - Ubah judul halaman dan navigasi sidebar menjadi "Pesanan Customer" (`/distributor-orders` atau `/customer-orders`).<br>- Tampilkan daftar order customer lengkap dengan nomor pesanan, nama customer/tujuan, tanggal, total barang, nilai pesanan, dan status pengiriman. |
| **10** | **SURAT JALAN**<br>- Pastikan tampil dan sinkron dengan Logistik | - `Waybill::getPaginatedList` tidak melakukan eager load relasi (`requestOrder.logistic`, `customer`, `originWarehouse`), sehingga data armada dan rute di tabel waybill kosong/undefined. | - Di `Waybill::getPaginatedList`, tambahkan eager loading: `with(['requestOrder.logistic', 'customer', 'originWarehouse'])`.<br>- Pastikan waybill yang dibuat oleh logistik/armada terkait `corporate_id` korporasi bersangkutan terambil secara konsisten. | - Perbaiki binding kolom pada `waybills/index.blade.php` agar membaca nomor surat jalan, nama transporter/armada, gudang asal, dan kota tujuan customer secara akurat.<br>- Pastikan tombol "Detail" dan "Cetak Surat Jalan" bekerja dengan membuka view detail/print waybill. |
| **11** | **SALDO STOK GUDANG**<br>- Blank Data, not tested | - Belum ada endpoint backend untuk mengambil rekapitulasi stok per produk per gudang.<br>- Route `/api/inventory/stocks` belum ada di FE dan BE. | - Buat controller `CorporateStockController` atau method di `CorporateItemInController`/`CorporateProductController` dengan route `GET /api/corporate/inventory/stocks`.<br>- Ambil data dari `corporate_product_stocks` dengan relasi `product` dan `warehouse`, atau kalkulasi dari `CorporateProduct` dengan stok di masing-masing gudang. | - Di `CorporateFE/app/Http/Controllers/InventoryController.php`, tambahkan method `proxyStocks()` yang mem-forward ke `/api/corporate/inventory/stocks`.<br>- Di `CorporateFE/routes/web.php`, daftarkan `GET /api/inventory/stocks`.<br>- Di `inventory/stocks.blade.php`, muat dropdown filter gudang dan tampilkan data stok fisik, teralokasi, dan stok tersedia. |
| **12** | **BARANG MASUK (INBOUND)**<br>- Implementasikan CRUD, modal, table, dan fiturnya | - `inventory/item-ins.blade.php` hanya tabel statis tanpa form modal tambah/edit dan tanpa aksi simpan. | - Pastikan `CorporateItemInController@store` memvalidasi input dan otomatis menambah saldo kuantitas di `corporate_product_stocks` melalui `CorporateProductStock::adjustStock(...)`.<br>- Tambahkan relasi `warehouse` dan `vendor` pada model `CorporateItemIn`. | - Buat modal interaktif "+ Catat Penerimaan Barang Masuk (Inbound)" di `item-ins.blade.php`.<br>- Form modal mencakup: Gudang Penerima, Pemasok / Asal Barang, Tanggal Masuk, No. Referensi (Surat Jalan Pabrik), Pilihan Produk SKU, Kuantitas, dan Catatan.<br>- Implementasikan aksi simpan via `POST /api/inventory/item-ins` dan refresh tabel otomatis. |
| **13** | **BARANG KELUAR (OUTBOUND)**<br>- Implementasikan CRUD, modal, table, dan fiturnya | - `inventory/item-outs.blade.php` hanya tabel statis tanpa modal form pengeluaran barang. | - Pastikan `CorporateItemOutController@store` memvalidasi input dan otomatis memotong saldo stok di `corporate_product_stocks` via `CorporateProductStock::adjustStock(...)`.<br>- Tambahkan relasi `warehouse`, `customer`, `waybill` pada model `CorporateItemOut`. | - Buat modal interaktif "+ Catat Pengeluaran Barang (Outbound)" di `item-outs.blade.php`.<br>- Form modal mencakup: Gudang Asal, Tujuan Pengiriman / Customer, Tanggal Keluar, No. Referensi / Surat Jalan, Pilihan Produk SKU, Kuantitas, dan Catatan Petugas.<br>- Implementasikan aksi simpan via `POST /api/inventory/item-outs` dan refresh tabel. |
| **14** | **FAKTUR PENAGIHAN DISTRIBUTOR**<br>- Ganti ke CUSTOMER<br>- Penagihan satu panel oleh Corporate | - Terminologi masih "Distributor".<br>- Route `/api/finance/distributor-invoices` belum di-expose di level `/api/*`. | - Pastikan `DistributorInvoiceController` di backend melayani data penagihan customer (`distributor_id` / `customer_id`) lengkap dengan rincian item waybill dan status bayar. | - Ubah label menu sidebar dan view menjadi "Faktur Penagihan Customer".<br>- Di `CorporateFE/routes/web.php`, daftarkan route `/api/finance/distributor-invoices` (GET, POST, SHOW).<br>- Tampilkan tabel invoice penagihan ke customer dengan status (Unpaid, Paid, Overdue). |
| **15** | **TAGIHAN ONGKIR LOGISTIK**<br>- Hapus button "Faktur Penagihan Distributor"<br>- Pastikan alur berjalan seperti Logistik Corporate | - Terdapat tombol navigasi redundan `Faktur Penagihan Distributor` di header halaman.<br>- Route `/api/finance/corporate-invoices` belum terhubung di level `/api/*`. | - Pastikan `CorporateInvoiceController` mengembalikan daftar tagihan transporter/logistik yang diterbitkan untuk korporasi terkait. | - Hapus tombol link `Faktur Penagihan Distributor` di `resources/views/finance/corporate-invoices/index.blade.php`.<br>- Daftarkan route `/api/finance/corporate-invoices` di `routes/web.php` dan pastikan mem-proxy ke `/api/corporate/invoices`. |
| **16** | **TOP SECTION ICON**<br>- Hapus Language, Dark Mode, Notif Button jika tidak ada fungsi | - Di `components/header.blade.php` terdapat dropdown bahasa (ID/EN), dark mode switch, dan notification bell yang tidak memiliki fungsionalitas backend atau tidak diinginkan tester. | - Tidak ada perubahan di BE. | - Di `CorporateFE/resources/views/components/header.blade.php`: Hapus elemen dropdown bahasa, tombol switch theme dark mode, dan tombol lonceng notifikasi, sehingga topbar bersih dan hanya menyisakan toggle sidebar, quick search, info tenant, dan avatar dropdown profil/logout. |

---

## 3. Checklist Eksekusi Teknis Bertahap

### FASE 1: Backend (`BackendCorporateLogistic`)
- [x] **B1. Update AuthController (`app/Http/Controllers/Api/Auth/AuthController.php`):**
  - Sertakan `corporate_id` pada payload `user` response: `'corporate_id' => $user->corporate_id ?? $user->corporateUser?->corporate_id ?? null`.
- [x] **B2. Update CorporateProduct Model & Controller:**
  - Tambahkan accessor/mutator dan `$appends` untuk kompatibilitas frontend: `sku` &harr; `code`, `price` / `base_price` &harr; `default_price`, `weight` &harr; `weight_kg`.
  - Pada `CorporateProductController@store` dan `@update`, lakukan mapping atribut sebelum validasi (`code = $request->code ?? $request->sku`, `default_price = $request->default_price ?? $request->base_price`, `weight_kg = $request->weight_kg ?? $request->weight`).
- [x] **B3. Update CorporateWarehouse Controller:**
  - Pada `CorporateWarehouseController@store` dan `@update`, terima kolom `city`, `city_code`, `phone`, `pic_name`, `postal_code`, dan `address`.
- [x] **B4. Update Dashboard Controller (`CorporateMobileDashboardController.php`):**
  - Hitung data aktual real-time dari database untuk semua 6 metrik:
    - `total_products` / `jumlah_produk`
    - `total_warehouses` / `jumlah_gudang`
    - `total_request_orders` / `request_order`
    - `total_waybills` / `surat_jalan`
    - `total_stock_units` / `stok_tersedia`
    - `total_invoices` / `jumlah_customer`
- [x] **B5. Implementasi Endpoint Saldo Stok (`/api/corporate/inventory/stocks`):**
  - Buat query rekap stok per produk per gudang dari `corporate_product_stocks` dengan relasi `product` dan `warehouse`.
  - Daftarkan route `GET inventory/stocks` di bawah prefix `corporate`.
- [x] **B6. Update CorporateItemIn & CorporateItemOut Controllers:**
  - Tambahkan relasi `warehouse`, `vendor`/`customer` pada model.
  - Pada saat simpan (`store`), jalankan `CorporateProductStock::adjustStock($cid, $warehouseId, $productId, $qty)` (positif untuk Item In, negatif untuk Item Out).
- [x] **B7. Update Pesanan Customer dari Request Order:**
  - Perbarui `CorporateDistributorOrderController@index` agar mengambil daftar pesanan customer yang dibuat dari `RequestOrder` (`with(['originWarehouse', 'logistic', 'items.product'])`).
- [x] **B8. Update Waybill Listing:**
  - Di `Waybill::getPaginatedList`, tambahkan eager loading: `with(['requestOrder.logistic', 'customer', 'originWarehouse'])`.

---

### FASE 2: Frontend Routing & Proxy BFF (`CorporateFE`)
- [x] **F1. Lengkapi Route Proxy di `routes/web.php`:**
  - Daftarkan seluruh rute `/api/*` agar mencakup:
    - **Dashboard:** `GET /api/dashboard/summary`
    - **Produk:** `GET /api/products`, `POST /api/products`, `GET /api/products/{id}`, `PUT /api/products/{id}`, `DELETE /api/products/{id}`
    - **Kategori Produk:** `GET /api/product-categories`, `POST /api/product-categories`, `GET /api/product-categories/{id}`, `PUT /api/product-categories/{id}`, `DELETE /api/product-categories/{id}`
    - **Gudang:** `GET /api/warehouses`, `POST /api/warehouses`, `GET /api/warehouses/{id}`, `PUT /api/warehouses/{id}`, `DELETE /api/warehouses/{id}`
    - **Customer:** `GET /api/customers`, `POST /api/customers`, `GET /api/customers/{id}`, `PUT /api/customers/{id}`, `DELETE /api/customers/{id}`
    - **Vendor:** `GET /api/vendors`, `POST /api/vendors`, `GET /api/vendors/{id}`, `PUT /api/vendors/{id}`, `DELETE /api/vendors/{id}`
    - **Distributor / Customer Alias:** `GET /api/distributors`, `POST /api/distributors`, `PUT /api/distributors/{id}`, `DELETE /api/distributors/{id}`
    - **Request Order:** `GET /api/request-orders`, `POST /api/request-orders`, `GET /api/request-orders/{id}`, `PUT /api/request-orders/{id}`, `DELETE /api/request-orders/{id}`, `POST /api/request-orders/inquire-routes`, `POST /api/request-orders/calculate-pricing`
    - **Pesanan Customer:** `GET /api/distributor-orders`, `GET /api/customer-orders`
    - **Surat Jalan:** `GET /api/waybills`, `GET /api/waybills/{id}`, `GET /api/waybills/{id}/print`
    - **Inventori:** `GET /api/inventory/stocks`, `GET /api/inventory/item-ins`, `POST /api/inventory/item-ins`, `GET /api/inventory/item-outs`, `POST /api/inventory/item-outs`
    - **Keuangan & Faktur:** `GET /api/finance/distributor-invoices`, `POST /api/finance/distributor-invoices`, `GET /api/finance/corporate-invoices`
- [x] **F2. Update `InventoryController.php` di CorporateFE:**
  - Tambahkan method `proxyStocks(Request $request)` yang mem-forward ke `/api/corporate/inventory/stocks`.
- [x] **F3. Update `DistributorInvoiceController.php` di CorporateFE:**
  - Pastikan method `proxyCorporateInvoices` mem-forward ke `/api/corporate/invoices`.

---

### FASE 3: Frontend View & UI/UX Fixes (`CorporateFE`)
- [x] **F4. Pembersihan Header Topbar (`components/header.blade.php`):**
  - Hapus dropdown bahasa (Language switcher).
  - Hapus tombol dark mode (Moon/Sun).
  - Hapus lonceng notifikasi (Notification bell).
- [x] **F5. Pembersihan & Perbaikan Dashboard (`dashboard.blade.php`):**
  - Hapus card biru tua di kanan bawah (`Integrasi Logistik Muncen`).
  - Update data binding statistik agar menampilkan angka aktual dari API.
- [x] **F6. Perbaikan Katalog SKU (`products/index.blade.php`):**
  - Panggil `fetchCategories()` saat load untuk mengisi dropdown `<select id="prodCategory">` dan `<select id="categoryFilter">`.
  - Pastikan submit form mengirim field yang sesuai (`code`, `name`, `default_price`, `weight_kg`, `category_id`).
- [x] **F7. Perbaikan Wizard Request Order (`request-orders/create.blade.php` & `ro-wizard.js`):**
  - Panggil `GET /api/warehouses` untuk mengisi dropdown `<select id="originWarehouse">`.
  - Selaraskan selektor id form dan tombol antara `create.blade.php` dan `ro-wizard.js`.
- [x] **F8. Refactor Distributor &rarr; Customer di Seluruh View:**
  - Di `sidebar.blade.php`: Ubah menu "Mitra Distributor" &rarr; "Pelanggan (Customer)", "Pesanan Distributor" &rarr; "Pesanan Customer", "Faktur Distributor" &rarr; "Faktur Customer".
  - Di `distributor-orders/index.blade.php`: Ubah judul menjadi "Pesanan Customer" dan render item yang dibuat dari Request Order.
  - Di `finance/distributor-invoices/index.blade.php`: Ubah judul menjadi "Faktur Penagihan Customer".
  - Di `finance/corporate-invoices/index.blade.php`: Hapus tombol `Faktur Penagihan Distributor`.
- [x] **F9. Implementasi CRUD Barang Masuk (`inventory/item-ins.blade.php`):**
  - Tambahkan tombol "+ Catat Barang Masuk (Inbound)".
  - Tambahkan modal form penerimaan barang (Gudang Penerima, Vendor/Pemasok, Tanggal, No. Referensi, Pilihan Produk, Kuantitas, Catatan).
  - Tambahkan submit handler `axios.post('/api/inventory/item-ins', payload)` dan refresh tabel.
- [x] **F10. Implementasi CRUD Barang Keluar (`inventory/item-outs.blade.php`):**
  - Tambahkan tombol "+ Catat Barang Keluar (Outbound)".
  - Tambahkan modal form pengeluaran barang (Gudang Asal, Customer Tujuan, Tanggal, No. Surat Jalan / Waybill, Pilihan Produk, Kuantitas, Catatan).
  - Tambahkan submit handler `axios.post('/api/inventory/item-outs', payload)` dan refresh tabel.
- [x] **F11. Perbaikan Saldo Stok Gudang (`inventory/stocks.blade.php`):**
  - Muat data gudang pada `<select id="warehouseFilter">`.
  - Render data stok aktual per produk per gudang dari respons `/api/inventory/stocks`.

---

## 4. Protokol Pengujian & Verifikasi (Verification Suite)

1. **Uji Otomatis Backend (Pest PHP):**
   - Jalankan `php artisan test --compact --filter=CorporateMasterEntitiesTest` di Backend untuk memvalidasi master entity CRUD.
   - Buat / jalankan feature test untuk mutasi stok `CorporateItemIn` & `CorporateItemOut`.
2. **Uji Respons API Proxy (Curl / Tinker):**
   - Tes endpoint `/api/products` (POST, GET).
   - Tes endpoint `/api/product-categories` (POST, GET).
   - Tes endpoint `/api/warehouses` (POST, GET).
   - Tes endpoint `/api/customers` (POST, GET).
   - Tes endpoint `/api/vendors` (POST, GET).
   - Tes endpoint `/api/inventory/stocks` (GET).
   - Tes endpoint `/api/inventory/item-ins` (POST, GET).
   - Tes endpoint `/api/inventory/item-outs` (POST, GET).
3. **Uji Alur Pengguna di Browser:**
   - Navigasi ke Dashboard: pastikan box biru tua kanan bawah sudah hilang, icon header bersih, angka ringkasan aktual.
   - Navigasi ke Katalog SKU: pastikan dropdown kategori terisi, tambah produk berhasil disimpan.
   - Navigasi ke Hub & Gudang, Customer, Vendor: simpan form baru tidak lagi memunculkan error 404/405.
   - Navigasi ke Buat Request Order: dropdown Gudang Asal terisi, navigasi wizard berjalan.
   - Navigasi ke Pesanan Customer: memuat data pesanan.
   - Navigasi ke Surat Jalan: daftar surat jalan tampil dengan rute dan armada.
   - Navigasi ke Saldo Stok: saldo terisi sesuai mutasi barang masuk & keluar.
   - Navigasi ke Keuangan: tombol "Faktur Penagihan Distributor" pada Tagihan Ongkir sudah dihilangkan.
