<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$nomorKamar   = trim($_POST['nomor_kamar'] ?? '');
$tipeKamar    = trim($_POST['tipe_kamar'] ?? '');
$fasilitas    = trim($_POST['fasilitas'] ?? '');
$hargaBulanan = $_POST['harga_bulanan'] ?? '';
$status       = trim($_POST['status'] ?? 'Tersedia');

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
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO kamar_11 (nomor_kamar, tipe_kamar, fasilitas, harga_bulanan, status)
     VALUES (:nomor_kamar, :tipe_kamar, :fasilitas, :harga_bulanan, :status)"
);
$stmt->execute([
    'nomor_kamar'   => $nomorKamar,
    'tipe_kamar'    => $tipeKamar,
    'fasilitas'     => $fasilitas,
    'harga_bulanan' => (int) $hargaBulanan,
    'status'        => $status,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Kamar berhasil ditambahkan.'];
header('Location: list.php');
exit;