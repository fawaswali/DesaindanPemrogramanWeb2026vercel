<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$totalKamar = 0;
$totalPenghuni = 0;
$kamarTerisi = 0;

try {
    $totalKamar = (int) $pdo->query("SELECT COUNT(*) FROM kamar_10")->fetchColumn();
    $totalPenghuni = (int) $pdo->query("SELECT COUNT(*) FROM penghuni_10")->fetchColumn();
    $kamarTerisi = (int) $pdo->query("SELECT COUNT(*) FROM kamar_10 WHERE status = 'Terisi'")->fetchColumn();
} catch (PDOException $e) {
    // Penanganan jika tabel belum dibuat atau belum ada data
}

$kamarKosong = max(0, $totalKamar - $kamarTerisi);
?>
        <?php if ($flash): ?>
            <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
        <?php endif; ?>

        <section>
            <h2>Selamat Datang di Sistem Manajemen Kost Papa</h2>
            <p style="color: #94a3b8;">Aplikasi pengelolaan hunian, ketersediaan kamar, dan data penghuni kost berbasis web.</p>
        </section>

        <section>
            <h2>Ringkasan Kost</h2>
            <div class="stats-grid">
                <article class="stat-card">
                    <h3>Total Kamar</h3>
                    <p class="stat-number"><?php echo $totalKamar; ?></p>
                    <span class="stat-subtext"><?php echo $kamarKosong; ?> kamar tersedia</span>
                </article>
                <article class="stat-card">
                    <h3>Total Penghuni</h3>
                    <p class="stat-number"><?php echo $totalPenghuni; ?></p>
                    <span class="stat-subtext" style="color: #94a3b8;">Terdaftar aktif</span>
                </article>
                <article class="stat-card">
                    <h3>Kamar Terisi</h3>
                    <p class="stat-number"><?php echo $kamarTerisi; ?></p>
                    <span class="stat-subtext" style="color: #38bdf8;">Tingkat hunian</span>
                </article>
            </div>
        </section>
<?php include __DIR__ . '/includes/footer.php'; ?>