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

$stmt = $pdo->prepare("SELECT * FROM penghuni_10 WHERE id = :id");
$stmt->execute(['id' => $id]);
$penghuni = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$penghuni) {
    header('Location: list.php');
    exit;
}

$listKamar = $pdo->query("SELECT id, nomor_kamar, tipe_kamar FROM kamar_10 ORDER BY nomor_kamar ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
        <section>
            <h2>Edit Data Penghuni</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_edit.php">
                <input type="hidden" name="id" value="<?php echo $penghuni['id']; ?>">
                <p>
                    <label for="nik">NIK</label><br>
                    <input type="text" id="nik" name="nik" value="<?php echo htmlspecialchars($penghuni['nik']); ?>" required>
                </p>
                <p>
                    <label for="nama">Nama</label><br>
                    <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($penghuni['nama']); ?>" required>
                </p>
                <p>
                    <label for="no_telepon">No. Telepon / WhatsApp</label><br>
                    <input type="text" id="no_telepon" name="no_telepon" value="<?php echo htmlspecialchars($penghuni['no_telepon'] ?? ''); ?>">
                </p>
                <p>
                    <label for="pekerjaan">Pekerjaan / Instansi</label><br>
                    <input type="text" id="pekerjaan" name="pekerjaan" value="<?php echo htmlspecialchars($penghuni['pekerjaan'] ?? ''); ?>">
                </p>
                <p>
                    <label for="kamar_id">Pilih Kamar</label><br>
                    <select id="kamar_id" name="kamar_id">
                        <option value="">-- Tanpa / Belum Pilih Kamar --</option>
                        <?php foreach ($listKamar as $kamar): ?>
                            <option value="<?php echo $kamar['id']; ?>" <?php echo $kamar['id'] == $penghuni['kamar_id'] ? 'selected' : ''; ?>>
                                Kamar <?php echo htmlspecialchars($kamar['nomor_kamar'] . ' (' . $kamar['tipe_kamar'] . ')'); ?>
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