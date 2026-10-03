# Wireframe & User Flow — Kost Papa
Sub-CPMK: Merancang UI/UX dan alur keamanan aplikasi web manajemen kost.

Dokumen ini menjelaskan alur pengguna dan rancangan antarmuka aplikasi **Kost Papa** berbasis peran (*Role-Based Access Control*) antara Tamu/Publik dan Petugas Kost.

---

## 👥 Peran Pengguna (Aktor)
1. **Tamu (Publik):**
   * Tanpa login.
   * Hanya dapat mengakses halaman Beranda dan Daftar Katalog Kamar (`kamar/list.php`) tanpa tombol aksi edit/hapus.
2. **Petugas (Terautentikasi):**
   * Wajib login melalui form kredensial petugas.
   * Memiliki hak akses penuh untuk melakukan operasi CRUD pada data Kamar Kost (`kamar_11`) dan data Penghuni (`penghuni_11`).

---

## 🔄 User Flow — Pengelolaan Kamar Kost
`[Petugas Login]` $\rightarrow$ `[Dashboard]` $\rightarrow$ `[Menu Tambah Kamar]` $\rightarrow$ `[Input Spesifikasi & Harga]` $\rightarrow$ `[Verifikasi Token CSRF]` $\rightarrow$ `[Simpan ke kamar_11]` $\rightarrow$ `[Kembali ke List Kamar]`

## 🔄 User Flow — Check-in Penghuni Baru
`[Petugas Login]` $\rightarrow$ `[Dashboard]` $\rightarrow$ `[Menu Tambah Penghuni]` $\rightarrow$ `[Input NIK & Data Diri]` $\rightarrow$ `[Pilih Kamar 'Tersedia']` $\rightarrow$ `[Verifikasi Token CSRF]` $\rightarrow$ `[Status Kamar Berubah 'Terisi']` $\rightarrow$ `[Kembali ke List Penghuni]`

---

## 🎨 Wireframe Tampilan

### Wireframe: Halaman Login Petugas
```text
+--------------------------------------+
|              Kost Papa               |
|--------------------------------------|
|                                      |
|        [ Login Petugas Kost ]        |
|                                      |
|   Username : [______________]        |
|   Password : [______________]        |
|                                      |
|          [   Masuk   ]               |
|                                      |
|   Belum punya akun? Daftar di sini   |
+--------------------------------------+

+-----------------------------------------------------+
| Kost Papa     Beranda | Kamar | Penghuni | (Petugas) Logout |
|-----------------------------------------------------|
|  [Total Kamar]   [Kamar Terisi]   [Total Penghuni]  |
|                                                     |
|  Aksi Cepat:                                        |
|  [ + Tambah Kamar ]     [ + Tambah Penghuni ]       |
|                                                     |
|  Ringkasan Status Kost                              |
|  -------------------------------------------------- |
|  Nomor Kamar | Tipe Kamar | Harga/Bulan | Status    |
+-----------------------------------------------------+

