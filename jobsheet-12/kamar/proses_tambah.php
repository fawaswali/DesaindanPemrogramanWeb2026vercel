<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$nomorKamar   = trim($_POST['nomor_kamar'] ?? '');
$tipeKamar    = trim($_POST['tipe_kamar'] ?? '');
$hargaBulanan = $_POST['harga_bulanan'] ?? '';
$fasilitas    = trim($_POST['fasilitas'] ?? '');
$stok         = $_POST['stok'] ?? 1;

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
    header('Location: tambah.php');
    exit;
}

$status = (int) $stok > 0 ? 'Tersedia' : 'Terisi';

$stmt = $pdo->prepare(
    "INSERT INTO kamar_12 (nomor_kamar, tipe_kamar, harga_bulanan, fasilitas, stok, status)
     VALUES (:nomor_kamar, :tipe_kamar, :harga_bulanan, :fasilitas, :stok, :status)
     RETURNING id"
);
$stmt->execute([
    'nomor_kamar'   => $nomorKamar,
    'tipe_kamar'    => $tipeKamar,
    'harga_bulanan' => (float) $hargaBulanan,
    'fasilitas'     => $fasilitas,
    'stok'          => (int) $stok,
    'status'        => $status,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Kamar baru berhasil ditambahkan.'];
header('Location: list.php');
exit;