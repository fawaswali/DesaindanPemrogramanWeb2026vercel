<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$nik       = trim($_POST['nik'] ?? '');
$nama      = trim($_POST['nama'] ?? '');
$noTelepon = trim($_POST['no_telepon'] ?? '');
$pekerjaan = trim($_POST['pekerjaan'] ?? '');
$kamarId   = !empty($_POST['kamar_id']) ? (int)$_POST['kamar_id'] : null;

$errors = [];
if ($nik === '') {
    $errors[] = "NIK wajib diisi.";
}
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO penghuni_10 (nik, nama, no_telepon, pekerjaan, kamar_id)
     VALUES (:nik, :nama, :no_telepon, :pekerjaan, :kamar_id)
     RETURNING id"
);
$stmt->execute([
    'nik'        => $nik,
    'nama'       => $nama,
    'no_telepon' => $noTelepon,
    'pekerjaan'  => $pekerjaan,
    'kamar_id'   => $kamarId,
]);

// Jika kamar dipilih, tandai kamar jadi terisi
if ($kamarId) {
    $updateKamar = $pdo->prepare("UPDATE kamar_10 SET status = 'Terisi' WHERE id = :kid");
    $updateKamar->execute(['kid' => $kamarId]);
}

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Penghuni berhasil ditambahkan.'];
header('Location: list.php');
exit;