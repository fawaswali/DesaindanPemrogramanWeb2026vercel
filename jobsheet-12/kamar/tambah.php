<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Tambah Kamar";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section>
            <h2>Tambah Kamar Kost Baru</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_tambah.php">
                <?php echo csrf_field(); ?>
                <p>
                    <label for="nomor_kamar">Nomor Kamar</label><br>
                    <input type="text" id="nomor_kamar" name="nomor_kamar" required placeholder="Contoh: A-01">
                </p>
                <p>
                    <label for="tipe_kamar">Tipe Kamar</label><br>
                    <select id="tipe_kamar" name="tipe_kamar" required>
                        <option value="Standard">Standard</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="VIP">VIP</option>
                    </select>
                </p>
                <p>
                    <label for="harga_bulanan">Harga Bulanan (Rp)</label><br>
                    <input type="number" id="harga_bulanan" name="harga_bulanan" min="0" required placeholder="Contoh: 850000">
                </p>
                <p>
                    <label for="fasilitas">Fasilitas</label><br>
                    <textarea id="fasilitas" name="fasilitas" rows="3" placeholder="AC, Kamar Mandi Dalam, Kasur, Wi-Fi..."></textarea>
                </p>
                <p>
                    <label for="stok">Stok Ketersediaan</label><br>
                    <input type="number" id="stok" name="stok" min="0" max="1" value="1" required>
                </p>
                <p>
                    <button type="submit">Simpan Kamar</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>