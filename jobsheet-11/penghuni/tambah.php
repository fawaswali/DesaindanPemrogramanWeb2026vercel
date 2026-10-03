<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Tambah Penghuni";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Ambil kamar yang berstatus 'Tersedia'
$kamarList = $pdo->query("SELECT id, nomor_kamar, tipe_kamar FROM kamar_10 ORDER BY nomor_kamar ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
        <section>
            <h2>Tambah Penghuni Kost</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_tambah.php">
                <?php echo csrf_field(); ?>
                <p>
                    <label for="nik">NIK</label><br>
                    <input type="text" id="nik" name="nik" required>
                </p>
                <p>
                    <label for="nama">Nama Lengkap</label><br>
                    <input type="text" id="nama" name="nama" required>
                </p>
                <p>
                    <label for="no_telepon">No. Telepon / WhatsApp</label><br>
                    <input type="text" id="no_telepon" name="no_telepon">
                </p>
                <p>
                    <label for="pekerjaan">Pekerjaan</label><br>
                    <input type="text" id="pekerjaan" name="pekerjaan">
                </p>
                <p>
                    <label for="kamar_id">Pilih Kamar</label><br>
                    <select id="kamar_id" name="kamar_id">
                        <option value="">-- Pilih Kamar --</option>
                        <?php foreach ($kamarList as $kamar): ?>
                            <option value="<?php echo (int) $kamar['id']; ?>">
                                Kamar <?php echo e($kamar['nomor_kamar']); ?> (<?php echo e($kamar['tipe_kamar']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <button type="submit">Simpan Penghuni</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>