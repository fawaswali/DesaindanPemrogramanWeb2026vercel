<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$page_title = "Login";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section style="max-width: 440px; margin: 0 auto;">
            <h2>Login Petugas Kost</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
            <?php endif; ?>

            <form method="post" action="proses_login.php">
                <p>
                    <label for="username">Username</label><br>
                    <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                </p>
                <p>
                    <label for="password">Password</label><br>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                </p>
                <p>
                    <button type="submit" style="width: 100%; margin-top: 10px;">Masuk</button>
                </p>
            </form>
            <p style="margin-top: 18px; font-size: 13px; color: #94a3b8; text-align: center;">
                Belum punya akun? <a href="register.php" style="color: #38bdf8;">Daftar di sini</a>
            </p>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>