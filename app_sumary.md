jangan buat template lagi. disini saya menggunakan style dari FlyOnUI
kamu bisa pelajari disini https://flyonui.com/docs

Struktur Utama Project

Guards:

web → untuk tenant user (admin, operator)

admin → untuk superadmin (pemilik SaaS)

Tables (sudah ada, dari migrasi kita):

tenants, users, admins, plans, billing, queues, vehicles, dll.

Template Admin: sudah disediakan → tinggal dipasang sesuai guard.

📋 Task List (Revisi Final)

1. Authentication & Authorization

Konfigurasi auth.php → 2 guard (web untuk tenant users, admin untuk superadmin).

Buat login + register tenant (/login, /register).

Buat login superadmin (/admin/login).

Setup reset password untuk dua guard (pakai tabel password_resets yang sama).

Middleware:

auth:web → SPBU admin & operator.

auth:admin → superadmin platform.

2. Superadmin Panel (Global SaaS Management)

Dashboard superadmin: ringkasan tenant, billing, laporan global.

CRUD Plans (paket berlangganan: harga bulanan/tahunan, fitur, limit).

CRUD Tenants (buat SPBU baru, atur aktif/nonaktif).

Billing management: lihat invoice tenant, status pembayaran.

Laporan global: jumlah tiket antrian, konsumsi liter BBM, omzet SaaS.

3. Tenant Panel (SPBU Admin)

Dashboard SPBU: total antrian hari ini, total liter, breakdown per jenis kendaraan.

CRUD Vehicles (atur jenis kendaraan & kuota max liter).

Setting jam operasional & jam maksimal ambil antrian.

CRUD Operator (user role operator).

Manajemen stok BBM (opsional: untuk catat sisa kuota harian).

Monitor antrian harian (queues → filter by tenant_id + queue_date).

4. Operator Panel

Login sebagai operator.

Scan QR / input queue_number → load data antrian.

Validasi liters_requested <= vehicles.max_liters.

Update status antrian (waiting → called → completed).

Catat served_by, checkin_time, checkout_time.

5. Pelanggan (End-User)

Register akun pelanggan (tabel customers).

Ambil nomor antrian (queues → generate queue_number + queue_date).

Pilih jenis kendaraan (vehicle_id) + input liter yang diminta.

Dapat QR Code / kode unik.

Tracking status antrian (lihat urutan & estimasi waktu).

6. Laporan & Analytics

Per tenant → total antrian, total liter, breakdown per kendaraan.

Per operator → jumlah pelanggan yang dilayani.

Global (superadmin) → agregat semua tenant.

7. Fitur Tambahan (Opsional)

Notifikasi WhatsApp/SMS → kirim info nomor antrian.

Subdomain per tenant → spbu-001.saas.com.

Integrasi Payment Gateway → tenant bisa bayar paket langsung online.

Export laporan Excel/PDF.
