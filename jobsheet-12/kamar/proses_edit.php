<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$id           = $_POST['id'] ?? null;
$nomorKamar   = trim($_POST['nomor_kamar'] ?? '');
$tipeKamar    = trim($_POST['tipe_kamar'] ?? '');
$hargaBulanan = $_POST['harga_bulanan'] ?? '';
$fasilitas    = trim($_POST['fasilitas'] ?? '');
$stok         = $_POST['stok'] ?? 1;

if (!$id) {
    header('Location: list.php');
    exit;
}

$errors = [];
if ($nomorKamar === '') {
    $errors[] = "Nomor kamar wajib diisi.";
}
if ($tipeKamar === '') {
    $errors[] = "Tipe kamar wajib diisi.";
}
if (!is_numeric($hargaBulanan) || $hargaBulanan < 0) {
    $errors[] = "Harga bulanan tidak valid.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$status = (int) $stok > 0 ? 'Tersedia' : 'Terisi';

$stmt = $pdo->prepare(
    "UPDATE kamar_12 SET nomor_kamar = :nomor_kamar, tipe_kamar = :tipe_kamar,
     harga_bulanan = :harga_bulanan, fasilitas = :fasilitas, stok = :stok, status = :status WHERE id = :id"
);
$stmt->execute([
    'nomor_kamar'   => $nomorKamar,
    'tipe_kamar'    => $tipeKamar,
    'harga_bulanan' => (float) $hargaBulanan,
    'fasilitas'     => $fasilitas,
    'stok'          => (int) $stok,
    'status'        => $status,
    'id'            => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data kamar berhasil diperbarui.'];
header('Location: list.php');
exit;