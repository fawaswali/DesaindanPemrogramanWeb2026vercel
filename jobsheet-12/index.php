<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Beranda Dashboard";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';

// Hitung statistik secara dinamis dari database Jobsheet 12
$totalKamar    = (int) $pdo->query("SELECT COUNT(*) FROM kamar_12")->fetchColumn();
$totalPenghuni = (int) $pdo->query("SELECT COUNT(*) FROM penghuni_12")->fetchColumn();
$totalDisewa   = (int) $pdo->query("SELECT COUNT(*) FROM peminjaman_12 WHERE status = 'dipinjam'")->fetchColumn();

$sudahLogin = isset($_SESSION['user_id']);
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section>
            <h2>Selamat Datang di Sistem Manajemen Kost Papa</h2>
            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo e($flash['pesan']); ?></p>
            <?php endif; ?>
            <p>Platform pengelolaan data kamar, ketersediaan unit, pencatatan penghuni, dan transaksi sewa secara terpusat dan aman.</p>
        </section>

        <section>
            <article>
                <h3>Total Unit Kamar</h3>
                <p><?php echo $totalKamar; ?></p>
            </article>
            <article>
                <h3>Total Penghuni Aktif</h3>
                <p><?php echo $totalPenghuni; ?></p>
            </article>
            <article>
                <h3>Kamar Sedang Disewa</h3>
                <p><?php echo $totalDisewa; ?></p>
            </article>
        </section>

        <?php if (!$sudahLogin): ?>
            <section>
                <h2>Akses Petugas</h2>
                <p>Silakan <a href="auth/login.php">Login sebagai Petugas</a> untuk melakukan pengelolaan data kamar, penghuni, dan transaksi sewa kost.</p>
            </section>
        <?php endif; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>