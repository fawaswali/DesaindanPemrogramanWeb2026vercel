<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Riwayat Sewa Kamar";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$anggotaId = $_GET['anggota_id'] ?? '';
$daftarPenghuni = $pdo->query("SELECT * FROM penghuni_12 ORDER BY nama")->fetchAll(PDO::FETCH_ASSOC);

$riwayat = [];
$penghuniTerpilih = null;

if ($anggotaId !== '') {
    $stmtA = $pdo->prepare("SELECT * FROM penghuni_12 WHERE id = :id");
    $stmtA->execute(['id' => $anggotaId]);
    $penghuniTerpilih = $stmtA->fetch(PDO::FETCH_ASSOC);

    if ($penghuniTerpilih) {
        $stmt = $pdo->prepare(
            "SELECT b.nomor_kamar, b.tipe_kamar, p.tanggal_pinjam, p.tanggal_kembali, p.status
             FROM peminjaman_12 p
             JOIN kamar_12 b ON b.id = p.buku_id
             WHERE p.anggota_id = :id
             ORDER BY p.tanggal_pinjam DESC"
        );
        $stmt->execute(['id' => $anggotaId]);
        $riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
        <section>
            <h2>Riwayat Sewa Kamar Penghuni</h2>

            <form method="get" action="riwayat.php">
                <p>
                    <label for="anggota_id">Pilih Penghuni</label><br>
                    <select id="anggota_id" name="anggota_id">
                        <option value="">-- Pilih Penghuni --</option>
                        <?php foreach ($daftarPenghuni as $penghuni): ?>
                        <option value="<?php echo $penghuni['id']; ?>" <?php echo (string) $anggotaId === (string) $penghuni['id'] ? 'selected' : ''; ?>>
                            <?php echo e($penghuni['nama']); ?> (NIK: <?php echo e($penghuni['nik']); ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <button type="submit">Tampilkan Riwayat</button>
                </p>
            </form>

            <?php if ($penghuniTerpilih): ?>
            <h3>Riwayat Sewa &mdash; <?php echo e($penghuniTerpilih['nama']); ?></h3>
            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No. Kamar (Tipe)</th>
                        <th>Tgl Masuk</th>
                        <th>Tgl Keluar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayat)): ?>
                    <tr>
                        <td colspan="4">Belum ada riwayat transaksi sewa kamar.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($riwayat as $r): ?>
                        <tr>
                            <td><?php echo e($r['nomor_kamar'] . ' (' . $r['tipe_kamar'] . ')'); ?></td>
                            <td><?php echo $r['tanggal_pinjam']; ?></td>
                            <td><?php echo $r['tanggal_kembali'] ?? '-'; ?></td>
                            <td><?php echo $r['status'] === 'dipinjam' ? 'Aktif Disewa' : 'Selesai'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
            <?php endif; ?>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>