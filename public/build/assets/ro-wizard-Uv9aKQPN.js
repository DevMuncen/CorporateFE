document.addEventListener("DOMContentLoaded",function(){if(!document.getElementById("ro-wizard-form"))return;let d=1;const c=5,t={order_date:new Date().toISOString().split("T")[0],origin_warehouse_id:"",origin_city_code:"",destination_city_code:"",origin_address:"",sender_name:"Gudang Utama Korporasi",sender_phone:"081234567890",fleet_type_id:1,logistic_id:"",notes:"",delivery_points:[]};window.goToStep=function(e){if(e<1||e>c)return;if(e>d){if(d===1&&(!t.origin_warehouse_id||!t.destination_city_code||!t.logistic_id)){window.showToast("Silakan pilih Gudang Asal, Kota Tujuan, dan Mitra Logistik terlebih dahulu.","error");return}if(d===3&&t.delivery_points.length===0){window.showToast("Minimal harus ada 1 titik drop pengiriman (Delivery Point).","error");return}}for(let s=1;s<=c;s++){const a=document.getElementById(`step-card-${s}`),n=document.getElementById(`step-tab-${s}`);a&&a.classList.add("hidden"),n&&(n.classList.remove("bg-corporate-800","text-white"),n.classList.add("bg-slate-100","text-slate-600"))}const o=document.getElementById(`step-card-${e}`),i=document.getElementById(`step-tab-${e}`);o&&o.classList.remove("hidden"),i&&(i.classList.remove("bg-slate-100","text-slate-600"),i.classList.add("bg-corporate-800","text-white")),d=e,d===5&&m()},window.inquireRoutes=async function(){const e=document.getElementById("origin_warehouse_id"),o=document.getElementById("destination_city_code"),i=document.getElementById("carrier-selection-list");if(!e.value||!o.value)return;t.origin_warehouse_id=e.value;const s=e.options[e.selectedIndex];t.origin_city_code=s.getAttribute("data-city-code")||"31.71",t.origin_address=s.getAttribute("data-address")||"",t.destination_city_code=o.value,i.innerHTML='<div class="py-4 text-center text-slate-500 text-sm">Mencari kontrak tarif logistik aktif...</div>';try{const n=(await axios.post("/api/internal/corporate/request-orders/inquire-routes",{origin_city_code:t.origin_city_code,destination_city_code:t.destination_city_code,fleet_type_id:t.fleet_type_id})).data?.data?.available_carriers||[];if(n.length===0){i.innerHTML='<div class="p-3 bg-amber-50 text-amber-800 rounded-lg text-sm">Tidak ditemukan mitra logistik dengan kontrak aktif untuk rute ini. Silakan hubungi Aggregator.</div>';return}let u="";n.forEach((r,p)=>{const b=p===0?"checked":"";p===0&&(t.logistic_id=r.logistic_id),u+=`
                    <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-slate-50 border-slate-200">
                        <div class="flex items-center space-x-3">
                            <input type="radio" name="selected_carrier" value="${r.logistic_id}" ${b} onchange="window.selectCarrier(${r.logistic_id})" class="text-corporate-800 focus:ring-corporate-700">
                            <div>
                                <div class="font-semibold text-slate-800 text-sm">${r.logistic_name}</div>
                                <div class="text-xs text-slate-500">Estimasi Base: ${window.formatCurrency(r.total_estimated||r.linehaul_price)}</div>
                            </div>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded font-medium">Kontrak Aktif</span>
                    </label>
                `}),i.innerHTML=u}catch{i.innerHTML='<div class="p-3 bg-rose-50 text-rose-800 rounded-lg text-sm">Gagal memuat rute kontrak. Default ke Logistik Merah Putih.</div>',t.logistic_id=1}},window.selectCarrier=function(e){t.logistic_id=e},window.selectFleetType=function(e){t.fleet_type_id=e,document.querySelectorAll(".fleet-card").forEach(i=>{i.classList.remove("border-corporate-800","bg-blue-50/50")});const o=document.getElementById(`fleet-card-${e}`);o&&o.classList.add("border-corporate-800","bg-blue-50/50")},window.addDeliveryPoint=function(){const e=t.delivery_points.length+1;t.delivery_points.push({stop_sequence:e,city_code:t.destination_city_code,delivery_type:2,distributor_warehouse_id:"",distributor_order_id:null,po_number:"",recipient_name:"",recipient_phone:"",address:"",items:[{product_id:1,cargo_type_id:1,quantity:10,unit_price:15e4,notes:""}]}),l()},window.removeDeliveryPoint=function(e){t.delivery_points.splice(e,1),t.delivery_points.forEach((o,i)=>o.stop_sequence=i+1),l()};function l(){const e=document.getElementById("delivery-points-container");if(!e)return;if(t.delivery_points.length===0){e.innerHTML='<div class="p-6 text-center border-2 border-dashed border-slate-200 rounded-xl text-slate-500 text-sm">Belum ada titik drop pengiriman. Klik "+ Tambah Titik Drop" untuk memulai.</div>';return}let o="";t.delivery_points.forEach((i,s)=>{o+=`
                <div class="p-5 border border-slate-200 rounded-xl bg-white shadow-sm mb-4">
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                        <div class="flex items-center space-x-2">
                            <span class="w-7 h-7 rounded-full bg-corporate-800 text-white flex items-center justify-center font-bold text-xs">${i.stop_sequence}</span>
                            <h4 class="font-bold text-slate-800 text-sm">Drop Point #${i.stop_sequence}</h4>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="window.openDistributorPoPicker(${s})" class="px-2.5 py-1 text-xs font-medium text-corporate-800 bg-blue-50 border border-blue-200 rounded hover:bg-blue-100">
                                📥 Import Distributor PO
                            </button>
                            <button type="button" onclick="window.removeDeliveryPoint(${s})" class="text-rose-500 hover:text-rose-700 text-xs font-semibold">
                                Hapus Stop
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Tipe Tujuan (Delivery Type)</label>
                            <select class="w-full text-xs rounded-lg border-slate-200 p-2 border" onchange="window.updateDropField(${s}, 'delivery_type', Number(this.value))">
                                <option value="1" ${i.delivery_type===1?"selected":""}>Gudang Korporasi (Wh-to-Wh)</option>
                                <option value="2" ${i.delivery_type===2?"selected":""}>Gudang Distributor</option>
                                <option value="3" ${i.delivery_type===3?"selected":""}>End Customer B2B</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Nama Penerima</label>
                            <input type="text" value="${i.recipient_name}" class="w-full text-xs rounded-lg border-slate-200 p-2 border" placeholder="Contoh: Distributor Bandung" oninput="window.updateDropField(${s}, 'recipient_name', this.value)">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">No. Telp Penerima</label>
                            <input type="text" value="${i.recipient_phone}" class="w-full text-xs rounded-lg border-slate-200 p-2 border" placeholder="0813..." oninput="window.updateDropField(${s}, 'recipient_phone', this.value)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="block text-xs font-medium text-slate-600 mb-1">Alamat Lengkap Drop</label>
                        <input type="text" value="${i.address}" class="w-full text-xs rounded-lg border-slate-200 p-2 border" placeholder="Jl. Raya Industri..." oninput="window.updateDropField(${s}, 'address', this.value)">
                    </div>

                    <!-- Encapsulated Items -->
                    <div class="mt-4 pt-3 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-700">Daftar Produk untuk Stop #${i.stop_sequence}:</span>
                            <button type="button" onclick="window.addItemToDrop(${s})" class="text-xs text-corporate-800 font-semibold hover:underline">+ Tambah SKU Produk</button>
                        </div>
                        <div class="space-y-2">
                            ${i.items.map((a,n)=>`
                                <div class="flex items-center space-x-2 text-xs">
                                    <span class="text-slate-400 w-5 text-right">${n+1}.</span>
                                    <select class="rounded border-slate-200 p-1 text-xs flex-1 border" onchange="window.updateItemField(${s}, ${n}, 'product_id', Number(this.value))">
                                        <option value="1" ${a.product_id===1?"selected":""}>Produk Karton Merah Putih (PRD-CMP-001)</option>
                                        <option value="2" ${a.product_id===2?"selected":""}>Produk Cold Chain Merah Putih (PRD-CMP-002)</option>
                                    </select>
                                    <input type="number" min="1" value="${a.quantity}" class="w-20 rounded border-slate-200 p-1 text-xs border" placeholder="Qty" oninput="window.updateItemField(${s}, ${n}, 'quantity', Number(this.value))">
                                    <input type="number" value="${a.unit_price}" class="w-28 rounded border-slate-200 p-1 text-xs border" placeholder="Harga Satuan" oninput="window.updateItemField(${s}, ${n}, 'unit_price', Number(this.value))">
                                    <button type="button" onclick="window.removeItemFromDrop(${s}, ${n})" class="text-rose-500 font-bold px-1 hover:text-rose-700">&times;</button>
                                </div>
                            `).join("")}
                        </div>
                    </div>
                </div>
            `}),e.innerHTML=o}window.updateDropField=function(e,o,i){t.delivery_points[e][o]=i},window.updateItemField=function(e,o,i,s){t.delivery_points[e].items[o][i]=s},window.addItemToDrop=function(e){t.delivery_points[e].items.push({product_id:1,cargo_type_id:1,quantity:10,unit_price:15e4,notes:""}),l()},window.removeItemFromDrop=function(e,o){t.delivery_points[e].items.splice(o,1),l()};async function m(){const e=document.getElementById("step-5-tariff-breakdown");e.innerHTML='<div class="py-6 text-center text-slate-500 text-sm">Menghitung kalkulasi tarif dinamis berdasarkan kontrak...</div>';try{const i=(await axios.post("/api/internal/corporate/request-orders/calculate-pricing",{logistic_id:t.logistic_id||1,origin_city_code:t.origin_city_code||"31.71",destination_city_code:t.destination_city_code||"35.78",fleet_type_id:t.fleet_type_id||1,cargo_type_id:1,waypoints_count:t.delivery_points.length})).data?.data||{},s=i.rates||{};e.innerHTML=`
                <div class="space-y-3">
                    <div class="flex justify-between text-sm text-slate-600">
                        <span>Tarif Antar Kota (Linehaul):</span>
                        <span class="font-semibold text-slate-800">${window.formatCurrency(s.linehaul_price||35e5)}</span>
                    </div>
                    <div class="flex justify-between text-sm text-slate-600">
                        <span>Biaya Langsir Luar Kota (Shunting):</span>
                        <span class="font-semibold text-slate-800">${window.formatCurrency(s.shunting_price||45e4)}</span>
                    </div>
                    <div class="flex justify-between text-sm text-slate-600">
                        <span>Langsir Dalam Kota (Inner-City):</span>
                        <span class="font-semibold text-slate-800">${window.formatCurrency(s.inner_city_shunting_price||25e4)}</span>
                    </div>
                    <div class="pt-3 border-t border-slate-200 flex justify-between text-base font-bold text-corporate-800">
                        <span>Total Estimasi Ongkos Kirim:</span>
                        <span>${window.formatCurrency(i.total_estimated_cost||42e5)}</span>
                    </div>
                    <div class="p-3 bg-blue-50 text-blue-800 rounded-lg text-xs mt-2">
                        🔒 Tarif ini akan dibekukan ke dalam <b>snapshot_pricing</b> saat pesanan diajukan.
                    </div>
                </div>
            `}catch{e.innerHTML=`
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between font-bold text-slate-800">
                        <span>Total Estimasi Tarif:</span>
                        <span>Rp 4.200.000</span>
                    </div>
                </div>
            `}}window.submitRequestOrder=async function(){const e=document.getElementById("submit-ro-btn");e&&(e.disabled=!0);try{const o=await axios.post("/api/internal/corporate/request-orders",t);window.showToast("Request Order berhasil diajukan!","success"),setTimeout(()=>{window.location.href="/request-orders"},1e3)}catch(o){e&&(e.disabled=!1),window.showToast(o.response?.data?.message||"Gagal mengajukan Request Order.","error")}}});
