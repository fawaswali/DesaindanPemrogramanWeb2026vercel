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
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM penghuni_10 WHERE nama ILIKE :kw OR nik ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("
        SELECT p.*, k.nomor_kamar 
        FROM penghuni_10 p 
        LEFT JOIN kamar_10 k ON p.kamar_id = k.id 
        WHERE p.nama ILIKE :kw OR p.nik ILIKE :kw 
        ORDER BY p.id DESC LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM penghuni_10")->fetchColumn();
    $stmt = $pdo->prepare("
        SELECT p.*, k.nomor_kamar 
        FROM penghuni_10 p 
        LEFT JOIN kamar_10 k ON p.kamar_id = k.id 
        ORDER BY p.id DESC LIMIT :limit OFFSET :offset
    ");
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
                <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
            <?php endif; ?>

            <div class="search-box">
                <form method="get" action="list.php">
                    <span>
                        <label for="search-input">Cari Penghuni (Nama / NIK)</label><br>
                        <input type="text" id="search-input" name="q" value="<?php echo e($keyword); ?>" placeholder="Ketik nama atau NIK...">
                    </span>
                    <button type="submit">Cari</button>
                </form>
            </div>

            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama Penghuni</th>
                        <th>No. HP</th>
                        <th>Pekerjaan</th>
                        <th>Kamar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarPenghuni)): ?>
                    <tr>
                        <td colspan="6">Tidak ada data penghuni yang cocok.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($daftarPenghuni as $penghuni): ?>
                        <tr>
                            <td><?php echo e($penghuni['nik']); ?></td>
                            <td><?php echo e($penghuni['nama']); ?></td>
                            <td><?php echo e($penghuni['no_telepon']); ?></td>
                            <td><?php echo e($penghuni['pekerjaan']); ?></td>
                            <td><?php echo e($penghuni['nomor_kamar'] ? 'Kamar ' . e($penghuni['nomor_kamar']) : '-'); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo (int) $penghuni['id']; ?>" class="btn-edit">Edit</a>
                                <form class="form-hapus" method="post" action="hapus.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo (int) $penghuni['id']; ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus penghuni ini?');">Hapus</button>
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