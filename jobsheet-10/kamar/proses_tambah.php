<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$nomor_kamar   = trim($_POST['nomor_kamar'] ?? '');
$tipe_kamar    = trim($_POST['tipe_kamar'] ?? '');
$fasilitas     = trim($_POST['fasilitas'] ?? '');
$harga_bulanan = $_POST['harga_bulanan'] ?? '';
$status        = trim($_POST['status'] ?? 'Tersedia');

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
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO kamar_10 (nomor_kamar, tipe_kamar, fasilitas, harga_bulanan, status)
     VALUES (:nomor_kamar, :tipe_kamar, :fasilitas, :harga_bulanan, :status)
     RETURNING id"
);
$stmt->execute([
    'nomor_kamar'   => $nomor_kamar,
    'tipe_kamar'    => $tipe_kamar,
    'fasilitas'     => $fasilitas,
    'harga_bulanan' => (int) $harga_bulanan,
    'status'        => $status,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Kamar berhasil ditambahkan.'];
header('Location: list.php');
exit;