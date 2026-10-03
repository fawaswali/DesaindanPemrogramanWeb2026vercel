<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Edit Penghuni";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM penghuni_12 WHERE id = :id");
$stmt->execute(['id' => $id]);
$penghuni = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$penghuni) {
    header('Location: list.php');
    exit;
}
?>
        <section>
            <h2>Edit Penghuni Kost</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_edit.php">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo (int) $penghuni['id']; ?>">
                <p>
                    <label for="nama">Nama Penghuni</label><br>
                    <input type="text" id="nama" name="nama" value="<?php echo e($penghuni['nama']); ?>" required>
                </p>
                <p>
                    <label for="nik">NIK KTP</label><br>
                    <input type="text" id="nik" name="nik" value="<?php echo e($penghuni['nik']); ?>" required>
                </p>
                <p>
                    <label for="alamat">Alamat Asal</label><br>
                    <input type="text" id="alamat" name="alamat" value="<?php echo e($penghuni['alamat']); ?>">
                </p>
                <p>
                    <label for="no_hp">No. HP / WhatsApp</label><br>
                    <input type="text" id="no_hp" name="no_hp" value="<?php echo e($penghuni['no_hp']); ?>">
                </p>
                <p>
                    <button type="submit">Update Data</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>