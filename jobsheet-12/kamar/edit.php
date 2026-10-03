<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Edit Kamar";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM kamar_12 WHERE id = :id");
$stmt->execute(['id' => $id]);
$kamar = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$kamar) {
    header('Location: list.php');
    exit;
}
?>
        <section>
            <h2>Edit Data Kamar Kost</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_edit.php">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo (int) $kamar['id']; ?>">
                <p>
                    <label for="nomor_kamar">Nomor Kamar</label><br>
                    <input type="text" id="nomor_kamar" name="nomor_kamar" value="<?php echo e($kamar['nomor_kamar']); ?>" required>
                </p>
                <p>
                    <label for="tipe_kamar">Tipe Kamar</label><br>
                    <select id="tipe_kamar" name="tipe_kamar" required>
                        <?php foreach (['Standard' => 'Standard', 'Deluxe' => 'Deluxe', 'VIP' => 'VIP'] as $value => $label): ?>
                        <option value="<?php echo $value; ?>" <?php echo $kamar['tipe_kamar'] === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <label for="harga_bulanan">Harga Bulanan (Rp)</label><br>
                    <input type="number" id="harga_bulanan" name="harga_bulanan" min="0" value="<?php echo $kamar['harga_bulanan']; ?>" required>
                </p>
                <p>
                    <label for="fasilitas">Fasilitas</label><br>
                    <textarea id="fasilitas" name="fasilitas" rows="3"><?php echo e($kamar['fasilitas']); ?></textarea>
                </p>
                <p>
                    <label for="stok">Stok Unit Tersedia</label><br>
                    <input type="number" id="stok" name="stok" min="0" max="1" value="<?php echo $kamar['stok']; ?>" required>
                </p>
                <p>
                    <button type="submit">Update Data Kamar</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>