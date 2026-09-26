<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$sudahLogin = isset($_SESSION['user_id']);

// Penentu base path URL agar aset selalu tepat
$base = '/jobsheet-10/';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kost Papa<?php echo isset($page_title) ? ' | ' . htmlspecialchars($page_title) : ''; ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>
    <header>
        <a href="<?php echo $base; ?>index.php" class="logo">Kost Papa</a>
        <button type="button" id="nav-toggle-btn" class="nav-toggle-label" aria-label="Menu">&#9776;</button>
        <nav>
            <a href="<?php echo $base; ?>index.php">Beranda</a>
            <a href="<?php echo $base; ?>kamar/list.php">Daftar Kamar</a>
            <?php if ($sudahLogin): ?>
                <a href="<?php echo $base; ?>kamar/tambah.php">Tambah Kamar</a>
                <a href="<?php echo $base; ?>penghuni/list.php">Daftar Penghuni</a>
                <a href="<?php echo $base; ?>penghuni/tambah.php">Tambah Penghuni</a>
                <span class="auth-user">
                    👤 <?php echo htmlspecialchars($_SESSION['nama'] ?? 'Petugas'); ?>
                </span>
                <a href="<?php echo $base; ?>auth/logout.php" class="btn-logout">Logout</a>
            <?php else: ?>
                <a href="<?php echo $base; ?>auth/login.php" class="btn-login">Login Petugas</a>
                <a href="<?php echo $base; ?>auth/register.php">Registrasi</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="container">