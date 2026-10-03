# Laporan Checklist Keamanan — Kost Papa (Jobsheet 11)
Audit menyeluruh terhadap kode Jobsheet 7-10 pada proyek Kost Papa, dilengkapi bukti verifikasi sebelum dan sesudah perbaikan.

| No | Vektor Kerentanan | Ditemukan di | Sebelum Audit | Sesudah Audit (Perbaikan / Proteksi) |
|---|---|---|---|---|
| 1 | **SQL Injection** | Semua kueri di `kamar/`, `penghuni/`, dan `auth/` | Sejak Jobsheet 08 telah menggunakan *Prepared Statements* PDO (`:parameter`). | Diaudit ulang, dikonfirmasi 100% aman — tidak ada variabel `$_POST` / `$_GET` yang disisipkan langsung ke string SQL. Diuji input `' OR '1'='1` pada form login $\rightarrow$ gagal bypass. |
| 2 | **Cross-Site Scripting (XSS)** | `kamar/list.php`, `kamar/edit.php`, `penghuni/list.php`, `penghuni/edit.php`, `includes/header.php` (nama petugas) | Output nomor kamar, fasilitas, nama penghuni, NIK, pekerjaan, dan nilai pencarian (`q`) dicetak langsung tanpa sanitasi. | Seluruh output dibungkus fungsi `e()` (`includes/helpers.php` menggunakan `htmlspecialchars` dengan flag `ENT_QUOTES`). Diuji simpan nama penghuni `<script>alert(1)</script>` $\rightarrow$ tampil sebagai teks biasa tanpa pop-up. |
| 3 | **Cross-Site Request Forgery (CSRF)** | Form Tambah/Edit/Hapus Kamar & Penghuni, Form Login, Form Register | Form bertipe `POST` tidak memiliki token verifikasi sehingga rentan dipicu dari situs asing. | Menambahkan modul `includes/csrf.php` (`csrf_field()` + `csrf_verify()`). Token dikunci di `$_SESSION['csrf_token']` dan diverifikasi di setiap file `proses_*.php` dan `hapus.php` sebelum kueri dieksekusi. |
| 4 | **Validasi & Sanitasi Input** | `proses_tambah.php`, `proses_edit.php` (kamar & penghuni) | Validasi tipe angka (`is_numeric`) dan wajib-isi sudah ada sejak Jobsheet 07–09. | Diaudit ulang dan dipertahankan — ditambahkan *type casting* eksplisit `(int)` pada parameter `id` di form Edit dan Hapus untuk mencegah parameter non-numerik. |
| 5 | **Session Fixation** | `auth/proses_login.php` | ID Sesi (`session_id`) tidak diperbarui setelah proses autentikasi berhasil. | Pemanggilan fungsi `session_regenerate_id(true)` diletakkan tepat setelah verifikasi `password_verify()` dinyatakan valid saat login. |

---

### Catatan Implementasi Keamanan
1. **Urutan Guard Authentication & CSRF:**
   Guard `includes/auth.php` selalu dipanggil **sebelum** `includes/csrf.php` dan `csrf_verify()` pada halaman pemrosesan data. Hal ini memastikan pengguna yang belum login langsung diarahkan ke halaman Login tanpa perlu memproses verifikasi token.
2. **Respon Penolakan CSRF (HTTP 403):**
   Fungsi `csrf_verify()` mengembalikan kode respon `HTTP 403 Forbidden` dan menghentikan eksekusi script (`die()`) jika token CSRF tidak valid atau tidak dikirimkan. Hal ini telah diverifikasi via perintah `curl -X POST` tanpa menyertakan token CSRF.