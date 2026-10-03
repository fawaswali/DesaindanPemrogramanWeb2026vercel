<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$nama   = trim($_POST['nama'] ?? '');
$nik    = trim($_POST['nik'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$noHp   = trim($_POST['no_hp'] ?? '');

$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($nik === '') {
    $errors[] = "NIK wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO penghuni_12 (nama, nik, alamat, no_hp)
     VALUES (:nama, :nik, :alamat, :no_hp)
     RETURNING id"
);
$stmt->execute([
    'nama'   => $nama,
    'nik'    => $nik,
    'alamat' => $alamat,
    'no_hp'  => $noHp,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Penghuni baru berhasil ditambahkan.'];
header('Location: list.php');
exit;