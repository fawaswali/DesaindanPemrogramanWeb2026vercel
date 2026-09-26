<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Daftar Penghuni";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$perPage = 5;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM penghuni_10 WHERE nama ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare(
        "SELECT p.*, k.nomor_kamar 
         FROM penghuni_10 p 
         LEFT JOIN kamar_10 k ON p.kamar_id = k.id 
         WHERE p.nama ILIKE :kw 
         ORDER BY p.id DESC 
         LIMIT :limit OFFSET :offset"
    );
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM penghuni_10")->fetchColumn();
    $stmt = $pdo->prepare(
        "SELECT p.*, k.nomor_kamar 
         FROM penghuni_10 p 
         LEFT JOIN kamar_10 k ON p.kamar_id = k.id 
         ORDER BY p.id DESC 
         LIMIT :limit OFFSET :offset"
    );
}
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$daftarPenghuni = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>
        <section>
            <h2>Daftar Penghuni Kost</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
            <?php endif; ?>

            <div class="search-box">
                <form method="get" action="list.php">
                    <span>
                        <label for="search-input">Cari Nama Penghuni</label><br>
                        <input type="text" id="search-input" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Ketik nama penghuni...">
                    </span>
                    <button type="submit">Cari</button>
                </form>
            </div>

            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>No. Telp / WA</th>
                        <th>Pekerjaan</th>
                        <th>Kamar</th>
                        <th>Tgl Masuk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarPenghuni)): ?>
                    <tr>
                        <td colspan="7">Tidak ada data penghuni yang cocok.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($daftarPenghuni as $penghuni): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($penghuni['nik']); ?></td>
                            <td><strong><?php echo htmlspecialchars($penghuni['nama']); ?></strong></td>
                            <td><?php echo htmlspecialchars($penghuni['no_telepon'] ?: '-'); ?></td>
                            <td><?php echo htmlspecialchars($penghuni['pekerjaan'] ?: '-'); ?></td>
                            <td><?php echo htmlspecialchars($penghuni['nomor_kamar'] ? 'Kamar ' . $penghuni['nomor_kamar'] : 'Belum Ditentukan'); ?></td>
                            <td><?php echo htmlspecialchars($penghuni['tanggal_masuk']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $penghuni['id']; ?>" class="btn-edit">Edit</a>
                                <form class="form-hapus" method="post" action="hapus.php" onsubmit="return confirm('Yakin ingin menghapus penghuni ini?');">
                                    <input type="hidden" name="id" value="<?php echo $penghuni['id']; ?>">
                                    <button type="submit" class="btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>

            <nav class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>"
                   class="<?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
            </nav>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>