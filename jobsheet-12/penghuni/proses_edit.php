<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$id     = $_POST['id'] ?? null;
$nama   = trim($_POST['nama'] ?? '');
$nik    = trim($_POST['nik'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$noHp   = trim($_POST['no_hp'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($nik === '') {
    $errors[] = "NIK wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE penghuni_12 SET nama = :nama, nik = :nik,
     alamat = :alamat, no_hp = :no_hp WHERE id = :id"
);
$stmt->execute([
    'nama'   => $nama,
    'nik'    => $nik,
    'alamat' => $alamat,
    'no_hp'  => $noHp,
    'id'     => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data penghuni berhasil diperbarui.'];
header('Location: list.php');
exit;