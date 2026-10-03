<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$page_title = "Registrasi Petugas";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section>
            <h2>Registrasi Petugas Kost Papa</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
            <?php endif; ?>

            <form method="post" action="proses_register.php">
                <?php echo csrf_field(); ?>
                <p>
                    <label for="nama">Nama Lengkap</label><br>
                    <input type="text" id="nama" name="nama" required>
                </p>
                <p>
                    <label for="username">Username</label><br>
                    <input type="text" id="username" name="username" required autocomplete="username">
                </p>
                <p>
                    <label for="password">Password (min. 6 karakter)</label><br>
                    <input type="password" id="password" name="password" required autocomplete="new-password">
                </p>
                <p>
                    <button type="submit">Daftar</button>
                </p>
            </form>
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>