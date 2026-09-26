# Wireframe & User Flow — Kost Papa
Sub-CPMK: Merancang UI/UX aplikasi dan manajemen sesi autentikasi.

Sistem Kost Papa menerapkan pembagian hak akses (role & guard clause) antara Tamu dan Petugas Pengelola Kost:

## Pembagian Aktor
* **Tamu (Publik):** Pengunjung umum yang dapat melihat Beranda dan Katalog Ketersediaan Kamar tanpa perlu login.
* **Petugas:** Pengelola kost yang wajib login untuk mengakses seluruh fitur CRUD kamar, data penghuni, serta pendaftaran sewa.

---

## User Flow — Autentikasi & Pengelolaan Kost
---

## Wireframe: Halaman Login Petugas
```text
+-----------------------------------------------------+
|                      Kost Papa                      |
|-----------------------------------------------------|
|                                                     |
|                 [ Login Petugas ]                   |
|                                                     |
|   Username : [_________________________]           |
|   Password : [_________________________]           |
|                                                     |
|                 [   Masuk ke Sistem   ]             |
|                                                     |
|     Belum punya akun? Registrasi petugas baru       |
+-----------------------------------------------------+

+-----------------------------------------------------------------------------------+
| Kost Papa    Beranda | Kamar | Penghuni                   [👤 Nama Petugas] Logout |
|-----------------------------------------------------------------------------------|
|  [ Total Kamar ]         [ Total Penghuni ]         [ Kamar Terisi ]              |
|                                                                                   |
|  Tabel Ketersediaan Kamar & Penghuni Terdaftar                                    |
|  -------------------------------------------------------------------------------  |
|  No. Kamar | Tipe | Harga / Bulan | Status | Aksi                                 |
+-----------------------------------------------------------------------------------+

### 2. `jobsheet-10/includes/auth.php`
Guard clause pengaman halaman internal[cite: 27]. Menggunakan penanganan sesi `$_SESSION['user_id']` bawaan dan path absolut agar aman diakses dari subfolder mana pun[cite: 27]:

```php
<?php
// Guard clause: di-include di baris paling atas setiap halaman yang
// membutuhkan login sebelum file lain mengeluarkan output apa pun.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => 'Silakan login terlebih dahulu untuk mengakses menu ini.'
    ];
    header('Location: /jobsheet-10/auth/login.php');
    exit;
}