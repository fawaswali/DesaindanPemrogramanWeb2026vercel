<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Tambah Penghuni";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section>
            <h2>Tambah Penghuni Baru</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_tambah.php">
                <?php echo csrf_field(); ?>
                <p>
                    <label for="nama">Nama Penghuni</label><br>
                    <input type="text" id="nama" name="nama" required placeholder="Contoh: Fawas Wali">
                </p>
                <p>
                    <label for="nik">NIK KTP</label><br>
                    <input type="text" id="nik" name="nik" required placeholder="Contoh: 3573012005060001">
                </p>
                <p>
                    <label for="alamat">Alamat Asal</label><br>
                    <input type="text" id="alamat" name="alamat" placeholder="Alamat lengkap sesuai KTP">
                </p>
                <p>
                    <label for="no_hp">No. HP / WhatsApp</label><br>
                    <input type="text" id="no_hp" name="no_hp" placeholder="081234567890">
                </p>
                <p>
                    <button type="submit">Simpan Penghuni</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>