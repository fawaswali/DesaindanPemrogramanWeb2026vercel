<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/csrf.php';

$sudahLogin = isset($_SESSION['user_id']);
$namaUser   = $_SESSION['nama'] ?? '';

// Prefix relatif ke root proyek
$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? e($page_title) . " - Kost Papa" : "Kost Papa"; ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>
    <header>
        <div class="logo">Kost Papa</div>
        <button type="button" class="nav-toggle-label" id="nav-toggle-btn">&#9776;</button>
        <nav>
            <a href="<?php echo $base; ?>index.php">Beranda</a>
            <a href="<?php echo $base; ?>kamar/list.php">Daftar Kamar</a>
            <?php if ($sudahLogin): ?>
                <a href="<?php echo $base; ?>kamar/tambah.php">Tambah Kamar</a>
                <a href="<?php echo $base; ?>penghuni/list.php">Daftar Penghuni</a>
                <a href="<?php echo $base; ?>penghuni/tambah.php">Tambah Penghuni</a>
            <?php endif; ?>
        </nav>
        <div class="auth-status">
            <?php if ($sudahLogin): ?>
                <span>Halo, <?php echo e($namaUser); ?></span>
                <a href="<?php echo $base; ?>auth/logout.php">Logout</a>
            <?php else: ?>
                <a href="<?php echo $base; ?>auth/login.php">Login Petugas</a>
                <a href="<?php echo $base; ?>auth/register.php">Registrasi</a>
            <?php endif; ?>
        </div>
    </header>
    <main>