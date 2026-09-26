<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$id            = $_POST['id'] ?? null;
$nomor_kamar   = trim($_POST['nomor_kamar'] ?? '');
$tipe_kamar    = trim($_POST['tipe_kamar'] ?? '');
$fasilitas     = trim($_POST['fasilitas'] ?? '');
$harga_bulanan = $_POST['harga_bulanan'] ?? '';
$status        = trim($_POST['status'] ?? 'Tersedia');

if (!$id) {
    header('Location: list.php');
    exit;
}

$errors = [];
if ($nomor_kamar === '') {
    $errors[] = "Nomor kamar wajib diisi.";
}
if ($tipe_kamar === '') {
    $errors[] = "Tipe kamar wajib diisi.";
}
if (!is_numeric($harga_bulanan) || (int)$harga_bulanan <= 0) {
    $errors[] = "Harga bulanan harus angka positif.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE kamar_10 SET nomor_kamar = :nomor_kamar, tipe_kamar = :tipe_kamar,
     fasilitas = :fasilitas, harga_bulanan = :harga_bulanan, status = :status WHERE id = :id"
);
$stmt->execute([
    'nomor_kamar'   => $nomor_kamar,
    'tipe_kamar'    => $tipe_kamar,
    'fasilitas'     => $fasilitas,
    'harga_bulanan' => (int) $harga_bulanan,
    'status'        => $status,
    'id'            => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data kamar berhasil diperbarui.'];
header('Location: list.php');
exit;