<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$id        = $_POST['id'] ?? null;
$nik       = trim($_POST['nik'] ?? '');
$nama      = trim($_POST['nama'] ?? '');
$noTelepon = trim($_POST['no_telepon'] ?? '');
$pekerjaan = trim($_POST['pekerjaan'] ?? '');
$kamarId   = !empty($_POST['kamar_id']) ? (int)$_POST['kamar_id'] : null;

if (!$id) {
    header('Location: list.php');
    exit;
}

$errors = [];
if ($nik === '') {
    $errors[] = "NIK wajib diisi.";
}
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE penghuni_10 SET 
        nik = :nik, 
        nama = :nama, 
        no_telepon = :no_telepon, 
        pekerjaan = :pekerjaan, 
        kamar_id = :kamar_id 
     WHERE id = :id"
);
$stmt->execute([
    'nik'        => $nik,
    'nama'       => $nama,
    'no_telepon' => $noTelepon,
    'pekerjaan'  => $pekerjaan,
    'kamar_id'   => $kamarId,
    'id'         => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data penghuni berhasil diperbarui.'];
header('Location: list.php');
exit;