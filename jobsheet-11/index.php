<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Beranda Dashboard";
include __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/koneksi.php';

// Hitung statistik dari tabel terisolasi Jobsheet 11
$totalKamar    = (int) $pdo->query("SELECT COUNT(*) FROM kamar_11")->fetchColumn();
$kamarTerisi   = (int) $pdo->query("SELECT COUNT(*) FROM kamar_11 WHERE status = 'Terisi'")->fetchColumn();
$totalPenghuni = (int) $pdo->query("SELECT COUNT(*) FROM penghuni_11")->fetchColumn();

$sudahLogin = isset($_SESSION['user_id']);
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section>
            <h2>Selamat Datang di Sistem Manajemen Kost Papa</h2>
            <?php if ($flash): ?>
                <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
            <?php endif; ?>
            <p>Platform pengelolaan data kamar, ketersediaan unit, dan pencatatan penghuni kost secara terpusat dan aman.</p>
        </section>

        <section class="stats-grid">
            <article>
                <h3>Total Unit Kamar</h3>
                <p><?php echo $totalKamar; ?></p>
            </article>
            <article>
                <h3>Kamar Terisi</h3>
                <p><?php echo $kamarTerisi; ?></p>
            </article>
            <article>
                <h3>Total Penghuni Aktif</h3>
                <p><?php echo $totalPenghuni; ?></p>
            </article>
        </section>

        <?php if (!$sudahLogin): ?>
            <section>
                <h2>Akses Petugas</h2>
                <p>Silakan <a href="auth/login.php">Login sebagai Petugas</a> untuk melakukan pengelolaan data kamar dan penghuni kost.</p>
            </section>
        <?php endif; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>