Checklist Keamanan — Jobsheet 12
Audit menyeluruh terhadap kode Jobsheet 12 (Kost Papa - Modul Transaksi & Sewa Kamar), dengan bukti before/after.

#	Kerentanan	Ditemukan di	Sebelum	Sesudah (perbaikan)
1	SQL Injection	Semua query di kamar_12, penghuni_12, users_12, peminjaman_12	Sejak Jobsheet 8 sudah memakai prepared statement PDO (:parameter)	Diaudit ulang, sudah aman — tidak ada satupun query yang menyisipkan $_POST/$_GET langsung ke string SQL. Diuji input ' OR '1'='1 di form login → tidak berhasil bypass.
2	XSS (Cross-Site Scripting)	kamar/list.php, kamar/edit.php, penghuni/list.php, penghuni/edit.php, includes/header.php (nama petugas)	Output nomor_kamar, fasilitas, nama, alamat, no_hp, dan nilai pencarian (q) dicetak langsung tanpa escaping	Dibungkus fungsi e() (includes/helpers.php, htmlspecialchars dengan ENT_QUOTES). Diuji simpan fasilitas <script>alert(1)</script> → tampil sebagai teks biasa, bukan dieksekusi.
3	CSRF (Cross-Site Request Forgery)	Form Tambah/Edit/Hapus Kamar & Penghuni, Login, Register, Transaksi Sewa & Check-out	Form POST tidak memiliki token verifikasi — bisa dipicu dari situs lain	Ditambah includes/csrf.php (csrf_field() + csrf_verify()), token disimpan di $_SESSION['csrf_token'], diverifikasi di setiap proses_*.php dan hapus.php sebelum query dijalankan.
4	Validasi & Sanitasi Input	proses_tambah.php, proses_edit.php (kamar & penghuni)	Sudah ada validasi tipe (is_numeric) dan wajib-isi sejak Jobsheet 7-9	Diaudit ulang, tetap dipertahankan — ditambah cast eksplisit (int) pada id di form Edit untuk mencegah nilai non-numerik masuk sebagai hidden input.
5	Session Fixation	auth/proses_login.php	Session ID tidak diperbarui setelah login	session_regenerate_id(true) dipanggil tepat setelah password_verify() berhasil.
6	Race Condition (Double Booking)	peminjaman/proses_tambah.php & proses_kembali.php	Dua request bersamaan bisa membuat unit kamar disewa dua kali saat stok tersisa 1	Menggunakan Database Transaction (beginTransaction/commit/rollBack) dan penguncian baris `SELECT ... FOR UPDATE` pada tabel kamar_12.

Catatan Implementasi:
Guard includes/auth.php selalu dijalankan sebelum includes/csrf.php di halaman proses — memastikan pengguna yang belum login tidak bisa memicu pengecekan CSRF sama sekali (langsung di-redirect ke login).
Fungsi csrf_verify() mengembalikan HTTP 403 dan menghentikan eksekusi (die()) bila token tidak cocok atau tidak ada.