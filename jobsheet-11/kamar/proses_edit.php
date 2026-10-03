<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$id           = (int) ($_POST['id'] ?? 0);
$nomorKamar   = trim($_POST['nomor_kamar'] ?? '');
$tipeKamar    = trim($_POST['tipe_kamar'] ?? '');
$fasilitas    = trim($_POST['fasilitas'] ?? '');
$hargaBulanan = $_POST['harga_bulanan'] ?? '';
$status       = trim($_POST['status'] ?? 'Tersedia');

if (!$id) {
    header('Location: list.php');
    exit;
}

$errors = [];
if ($nomorKamar === '') {
    $errors[] = "Nomor kamar wajib diisi.";
}
if ($tipeKamar === '') {
    $errors[] = "Tipe kamar wajib dipilih.";
}
if (!is_numeric($hargaBulanan) || (int)$hargaBulanan <= 0) {
    $errors[] = "Harga bulanan harus berupa angka positif.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . $id);
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE kamar_11 
     SET nomor_kamar = :nomor_kamar, tipe_kamar = :tipe_kamar, 
         fasilitas = :fasilitas, harga_bulanan = :harga_bulanan, status = :status 
     WHERE id = :id"
);
$stmt->execute([
    'nomor_kamar'   => $nomorKamar,
    'tipe_kamar'    => $tipeKamar,
    'fasilitas'     => $fasilitas,
    'harga_bulanan' => (int) $hargaBulanan,
    'status'        => $status,
    'id'            => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data kamar berhasil diperbarui.'];
header('Location: list.php');
exit;