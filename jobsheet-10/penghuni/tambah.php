<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Tambah Penghuni";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Ambil daftar kamar untuk dropdown opsi
$listKamar = $pdo->query("SELECT id, nomor_kamar, tipe_kamar FROM kamar_10 ORDER BY nomor_kamar ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
        <section>
            <h2>Tambah Penghuni Baru</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_tambah.php">
                <p>
                    <label for="nik">NIK (Nomor Induk Kependudukan)</label><br>
                    <input type="text" id="nik" name="nik" placeholder="Contoh: 3507123456780001" required>
                </p>
                <p>
                    <label for="nama">Nama Lengkap</label><br>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama penghuni" required>
                </p>
                <p>
                    <label for="no_telepon">No. Telepon / WhatsApp</label><br>
                    <input type="text" id="no_telepon" name="no_telepon" placeholder="Contoh: 08123456789">
                </p>
                <p>
                    <label for="pekerjaan">Pekerjaan / Instansi</label><br>
                    <input type="text" id="pekerjaan" name="pekerjaan" placeholder="Contoh: Mahasiswa / Karyawan">
                </p>
                <p>
                    <label for="kamar_id">Pilih Kamar</label><br>
                    <select id="kamar_id" name="kamar_id">
                        <option value="">-- Tanpa / Belum Pilih Kamar --</option>
                        <?php foreach ($listKamar as $kamar): ?>
                            <option value="<?php echo $kamar['id']; ?>">
                                Kamar <?php echo htmlspecialchars($kamar['nomor_kamar'] . ' (' . $kamar['tipe_kamar'] . ')'); ?>
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