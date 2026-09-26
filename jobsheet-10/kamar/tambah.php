<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Tambah Kamar";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section>
            <h2>Tambah Kamar Baru</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_tambah.php">
                <p>
                    <label for="nomor_kamar">Nomor Kamar</label><br>
                    <input type="text" id="nomor_kamar" name="nomor_kamar" placeholder="Contoh: A-01" required>
                </p>
                <p>
                    <label for="tipe_kamar">Tipe Kamar</label><br>
                    <select id="tipe_kamar" name="tipe_kamar" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="Standar">Standar</option>
                        <option value="Superior">Superior</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="VIP">VIP</option>
                    </select>
                </p>
                <p>
                    <label for="fasilitas">Fasilitas</label><br>
                    <input type="text" id="fasilitas" name="fasilitas" placeholder="Contoh: AC, Wi-Fi, Kasur, Lemari">
                </p>
                <p>
                    <label for="harga_bulanan">Harga / Bulan (Rp)</label><br>
                    <input type="number" id="harga_bulanan" name="harga_bulanan" min="0" placeholder="Contoh: 850000" required>
                </p>
                <p>
                    <label for="status">Status Kamar</label><br>
                    <select id="status" name="status">
                        <option value="Tersedia" selected>Tersedia</option>
                        <option value="Terisi">Terisi</option>
                        <option value="Perbaikan">Perbaikan</option>
                    </select>
                </p>
                <p>
                    <button type="submit">Simpan Kamar</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>