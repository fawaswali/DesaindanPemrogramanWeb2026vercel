<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$anggotaId = $_POST['anggota_id'] ?? '';
$bukuId    = $_POST['buku_id'] ?? '';

if ($anggotaId === '' || $bukuId === '') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Penghuni dan Kamar wajib dipilih.'];
    header('Location: tambah.php');
    exit;
}

try {
    $pdo->beginTransaction();

    // Kunci baris kamar (FOR UPDATE) agar stok/status tidak berubah oleh transaksi lain
    // di tengah proses ini — mencegah double booking akibat race condition.
    $cek = $pdo->prepare("SELECT stok FROM kamar_12 WHERE id = :id FOR UPDATE");
    $cek->execute(['id' => $bukuId]);
    $kamar = $cek->fetch(PDO::FETCH_ASSOC);

    if (!$kamar || $kamar['stok'] < 1) {
        throw new Exception('Stok unit kamar tidak tersedia / sudah terisi.');
    }

    $insert = $pdo->prepare(
        "INSERT INTO peminjaman_12 (buku_id, anggota_id, tanggal_pinjam, status)
         VALUES (:buku_id, :anggota_id, CURRENT_DATE, 'dipinjam')"
    );
    $insert->execute(['buku_id' => $bukuId, 'anggota_id' => $anggotaId]);

    // Kurangi stok kamar menjadi 0 dan set status 'Terisi'
    $update = $pdo->prepare("UPDATE kamar_12 SET stok = 0, status = 'Terisi' WHERE id = :id");
    $update->execute(['id' => $bukuId]);

    $pdo->commit();

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Transaksi sewa kamar / check-in berhasil dicatat.'];
    header('Location: ../index.php');
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mencatat sewa kamar: ' . $e->getMessage()];
    header('Location: tambah.php');
    exit;
}