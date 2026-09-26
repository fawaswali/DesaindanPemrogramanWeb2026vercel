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
        <section style="max-width: 460px; margin: 0 auto;">
            <h2>Registrasi Petugas Kost</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
            <?php endif; ?>

            <form method="post" action="proses_register.php">
                <p>
                    <label for="nama">Nama Lengkap</label><br>
                    <input type="text" id="nama" name="nama" placeholder="Contoh: Budi Santoso" required>
                </p>
                <p>
                    <label for="username">Username</label><br>
                    <input type="text" id="username" name="username" placeholder="Masukkan username unik" required>
                </p>
                <p>
                    <label for="password">Password</label><br>
                    <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" required minlength="6">
                </p>
                <p>
                    <button type="submit" style="width: 100%; margin-top: 10px;">Daftar</button>
                </p>
            </form>
            <p style="margin-top: 18px; font-size: 13px; color: #94a3b8; text-align: center;">
                Sudah punya akun? <a href="login.php" style="color: #38bdf8;">Login di sini</a>
            </p>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>