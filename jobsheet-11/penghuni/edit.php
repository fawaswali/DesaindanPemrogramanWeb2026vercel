<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Edit Penghuni";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = (int) ($_GET['id'] ?? 0);
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM penghuni_10 WHERE id = :id");
$stmt->execute(['id' => $id]);
$penghuni = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$penghuni) {
    header('Location: list.php');
    exit;
}

$kamarList = $pdo->query("SELECT id, nomor_kamar, tipe_kamar FROM kamar_10 ORDER BY nomor_kamar ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
        <section>
            <h2>Edit Data Penghuni</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
            <?php endif; ?>

            <form id="form-edit" method="post" action="proses_edit.php">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo (int) $penghuni['id']; ?>">
                <p>
                    <label for="nik">NIK</label><br>
                    <input type="text" id="nik" name="nik" value="<?php echo e($penghuni['nik']); ?>" required>
                </p>
                <p>
                    <label for="nama">Nama Lengkap</label><br>
                    <input type="text" id="nama" name="nama" value="<?php echo e($penghuni['nama']); ?>" required>
                </p>
                <p>
                    <label for="no_telepon">No. Telepon / WhatsApp</label><br>
                    <input type="text" id="no_telepon" name="no_telepon" value="<?php echo e($penghuni['no_telepon']); ?>">
                </p>
                <p>
                    <label for="pekerjaan">Pekerjaan</label><br>
                    <input type="text" id="pekerjaan" name="pekerjaan" value="<?php echo e($penghuni['pekerjaan']); ?>">
                </p>
                <p>
                    <label for="kamar_id">Pilih Kamar</label><br>
                    <select id="kamar_id" name="kamar_id">
                        <option value="">-- Tanpa Kamar --</option>
                        <?php foreach ($kamarList as $kamar): ?>
                            <option value="<?php echo (int) $kamar['id']; ?>" <?php echo $penghuni['kamar_id'] == $kamar['id'] ? 'selected' : ''; ?>>
                                Kamar <?php echo e($kamar['nomor_kamar']); ?> (<?php echo e($kamar['tipe_kamar']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <button type="submit">Update Penghuni</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>