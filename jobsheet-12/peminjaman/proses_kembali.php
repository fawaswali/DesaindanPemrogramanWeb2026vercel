<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: kembali.php');
    exit;
}

csrf_verify();

$id = $_POST['id'] ?? null;
if (!$id) {
    header('Location: kembali.php');
    exit;
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT buku_id, status FROM peminjaman_12 WHERE id = :id FOR UPDATE");
    $stmt->execute(['id' => $id]);
    $trx = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$trx || $trx['status'] !== 'dipinjam') {
        throw new Exception('Transaksi sewa tidak ditemukan atau sudah selesai/check-out.');
    }

    $updatePeminjaman = $pdo->prepare(
        "UPDATE peminjaman_12 SET status = 'dikembalikan', tanggal_kembali = CURRENT_DATE WHERE id = :id"
    );
    $updatePeminjaman->execute(['id' => $id]);

    // Kembalikan stok kamar menjadi 1 dan status ketersediaannya
    $updateKamar = $pdo->prepare("UPDATE kamar_12 SET stok = 1, status = 'Tersedia' WHERE id = :buku_id");
    $updateKamar->execute(['buku_id' => $trx['buku_id']]);

    $pdo->commit();
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Proses Check-out berhasil dikonfirmasi. Kamar kini kembali Tersedia.'];
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memproses check-out: ' . $e->getMessage()];
}

header('Location: kembali.php');
exit;