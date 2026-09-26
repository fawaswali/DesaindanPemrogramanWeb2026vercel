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

$stmt = $pdo->prepare("SELECT * FROM kamar_10 WHERE id = :id");
$stmt->execute(['id' => $id]);
$kamar = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$kamar) {
    header('Location: list.php');
    exit;
}
?>
        <section>
            <h2>Edit Data Kamar</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_edit.php">
                <input type="hidden" name="id" value="<?php echo $kamar['id']; ?>">
                <p>
                    <label for="nomor_kamar">Nomor Kamar</label><br>
                    <input type="text" id="nomor_kamar" name="nomor_kamar" value="<?php echo htmlspecialchars($kamar['nomor_kamar']); ?>" required>
                </p>
                <p>
                    <label for="tipe_kamar">Tipe Kamar</label><br>
                    <select id="tipe_kamar" name="tipe_kamar" required>
                        <?php foreach (['Standar', 'Superior', 'Deluxe', 'VIP'] as $tipe): ?>
                            <option value="<?php echo $tipe; ?>" <?php echo $kamar['tipe_kamar'] === $tipe ? 'selected' : ''; ?>>
                                <?php echo $tipe; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <label for="fasilitas">Fasilitas</label><br>
                    <input type="text" id="fasilitas" name="fasilitas" value="<?php echo htmlspecialchars($kamar['fasilitas'] ?? ''); ?>">
                </p>
                <p>
                    <label for="harga_bulanan">Harga / Bulan (Rp)</label><br>
                    <input type="number" id="harga_bulanan" name="harga_bulanan" min="0" value="<?php echo $kamar['harga_bulanan']; ?>" required>
                </p>
                <p>
                    <label for="status">Status Kamar</label><br>
                    <select id="status" name="status">
                        <?php foreach (['Tersedia', 'Terisi', 'Perbaikan'] as $st): ?>
                            <option value="<?php echo $st; ?>" <?php echo $kamar['status'] === $st ? 'selected' : ''; ?>>
                                <?php echo $st; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <button type="submit">Update Kamar</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>