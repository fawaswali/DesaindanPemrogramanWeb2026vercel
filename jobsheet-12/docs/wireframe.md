Wireframe & User Flow — Kost Papa (Jobsheet 12)
Sub-CPMK: Merancang UI/UX aplikasi manajemen kost.

Dokumen ini menjelaskan alur interaksi dan tata letak halaman untuk modul transaksi sewa kamar Kost Papa.

Aktor
Tamu: hanya bisa melihat katalog kamar (Beranda, Daftar Kamar) tanpa login.
Petugas: login untuk mengakses seluruh fitur CRUD kamar/penghuni dan transaksi check-in/check-out.

User Flow — Check-in Sewa Kamar Baru
[Petugas Login] -> [Dashboard] -> [Pilih menu "Check-in Baru"]
        -> [Pilih Penghuni] -> [Pilih Kamar (stok > 0 / Tersedia)]
        -> [Simpan] -> [Status kamar berubah jadi 'Terisi'] -> [Kembali ke Dashboard]

User Flow — Check-out / Pengembalian Kamar
[Dashboard] -> [Menu "Check-out"] -> [Cari transaksi aktif (penghuni/kamar)]
        -> [Konfirmasi "Check-out"] -> [Status kamar kembali 'Tersedia']
        -> [Kembali ke Dashboard]

Wireframe: Halaman Login
+--------------------------------------+
|              Kost Papa               |
|--------------------------------------|
|                                      |
|        [ Login Petugas ]            |
|                                      |
|   Username : [______________]       |
|   Password : [______________]       |
|                                      |
|          [   Masuk   ]              |
|                                      |
|   Belum punya akun? Daftar di sini  |
+--------------------------------------+

Wireframe: Dashboard Petugas
+-----------------------------------------------------+
| Kost Papa        Beranda | Kamar | Penghuni | Sewa  | Halo, Fawas Wali | Logout |
|-------------------------------------------------------|
|  [Total Kamar]   [Total Penghuni]   [Sedang Disewa]   |
|                                                       |
|  Aksi Cepat:                                         |
|  [ + Check-in Baru ]   [ + Check-out ]               |
|                                                       |
|  Transaksi Sewa Terbaru                              |
|  --------------------------------------------------  |
|  Penghuni | No. Kamar | Tgl Masuk | Status           |
+-----------------------------------------------------+

Wireframe: Form Check-in Sewa Baru
+--------------------------------------+
|  Form Check-in Sewa Kamar            |
|--------------------------------------|
|  Penghuni : [ dropdown pilih nama ]  |
|  Kamar    : [ dropdown, unit ready ] |
|  Tgl Masuk: [ auto: hari ini ]       |
|                                      |
|        [  Proses Check-in  ]         |
+--------------------------------------+

Wireframe: Form Check-out
+--------------------------------------+
|  Check-out Sewa Kamar                |
|--------------------------------------|
|  Cari transaksi aktif:               |
|  [ nama penghuni / no. kamar _____ ] |
|                                      |
|  Penghuni | Kamar | Tgl Masuk | [Check-out] |
+--------------------------------------+

Wireframe: Riwayat Sewa per Penghuni
+--------------------------------------+
|  Riwayat Sewa — Fawas Wali           |
|--------------------------------------|
|  No. Kamar       | Masuk    | Keluar  | Status      |
|  Kamar A-01      | 01/09    | 30/09   | Selesai     |
|  Kamar B-02      | 01/10    | -       | Aktif       |
+--------------------------------------+