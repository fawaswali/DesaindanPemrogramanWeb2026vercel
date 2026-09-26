<?php
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$targetFile = dirname(__DIR__) . $requestUri;

// 1. Jika URL mengarah ke direktori (contoh: /jobsheet-10/), cari file index.php atau index.html
if (is_dir($targetFile)) {
    if (file_exists(rtrim($targetFile, '/') . '/index.php')) {
        $targetFile = rtrim($targetFile, '/') . '/index.php';
    } elseif (file_exists(rtrim($targetFile, '/') . '/index.html')) {
        $targetFile = rtrim($targetFile, '/') . '/index.html';
    }
}

// 2. Jika berkas fisik benar-benar ada
if (file_exists($targetFile) && !is_dir($targetFile)) {
    $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Jika file PHP, eksekusi seperti biasa
    if ($ext === 'php') {
        header('Content-Type: text/html; charset=UTF-8');
        chdir(dirname($targetFile));
        require $targetFile;
        exit;
    }

    // Daftar MIME type untuk file statis
    $mimeTypes = [
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'json' => 'application/json',
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'ico'  => 'image/x-icon',
        'html' => 'text/html; charset=UTF-8',
    ];

    if (isset($mimeTypes[$ext])) {
        header('Content-Type: ' . $mimeTypes[$ext]);
        readfile($targetFile);
        exit;
    }
}

// 3. Fallback jika tidak ditemukan
http_response_code(404);
header('Content-Type: text/html; charset=UTF-8');
echo "Halaman tidak ditemukan.";