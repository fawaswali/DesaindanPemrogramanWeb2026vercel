<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Check-in Sewa Baru";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarPenghuni = $pdo->query("SELECT * FROM penghuni_12 ORDER BY nama")->fetchAll(PDO::FETCH_ASSOC);
$daftarKamarTersedia = $pdo->query("SELECT * FROM kamar_12 WHERE stok > 0 ORDER BY nomor_kamar")->fetchAll(PDO::FETCH_ASSOC);
?>
        <section>
            <h2>Check-in Sewa Kamar Baru</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo e($flash['pesan']); ?></p>
            <?php endif; ?>

            <?php if (empty($daftarPenghuni)): ?>
                <p class="flash flash-error">Belum ada data penghuni. Tambahkan penghuni terlebih dahulu.</p>
            <?php elseif (empty($daftarKamarTersedia)): ?>
                <p class="flash flash-error">Tidak ada kamar dengan stok ketersediaan saat ini.</p>
            <?php else: ?>
            <form method="post" action="proses_tambah.php">
                <?php echo csrf_field(); ?>
                <p>
                    <label for="anggota_id">Pilih Penghuni</label><br>
                    <select id="anggota_id" name="anggota_id" required>
                        <option value="">-- Pilih Penghuni --</option>
                        <?php foreach ($daftarPenghuni as $penghuni): ?>
                        <option value="<?php echo $penghuni['id']; ?>">
                            <?php echo e($penghuni['nama']); ?> (NIK: <?php echo e($penghuni['nik']); ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <label for="buku_id">Pilih Kamar (Kamar Tersedia)</label><br>
                    <select id="buku_id" name="buku_id" required>
                        <option value="">-- Pilih Kamar --</option>
                        <?php foreach ($daftarKamarTersedia as $kamar): ?>
                        <option value="<?php echo $kamar['id']; ?>">
                            Kamar <?php echo e($kamar['nomor_kamar']); ?> - <?php echo e($kamar['tipe_kamar']); ?> (Rp <?php echo number_format($kamar['harga_bulanan'], 0, ',', '.'); ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <button type="submit">Proses Check-in</button>
                </p>
            </form>
            <?php endif; ?>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>