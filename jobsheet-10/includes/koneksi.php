<?php
$host = getenv('SUPABASE_HOST') ?: "aws-0-ap-northeast-2.pooler.supabase.com";
$port = getenv('SUPABASE_PORT') ?: "6543";
$db   = getenv('SUPABASE_DB')   ?: "postgres";
$user = getenv('SUPABASE_USER') ?: "postgres.mpycrxqzjfmqqafoxpew";
$pass = getenv('SUPABASE_PASS') ?: "sg95WPSX2YuRgV91"; // Ganti 'rahasia' dengan password asli database Supabase kamu

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}