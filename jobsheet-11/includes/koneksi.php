<?php
$host = getenv('SUPABASE_HOST') ?: "aws-0-ap-northeast-2.pooler.supabase.com";
$port = getenv('SUPABASE_PORT') ?: "6543";
$db   = getenv('SUPABASE_DB')   ?: "postgres";
$user = getenv('SUPABASE_USER') ?: "postgres.mpycrxqzjfmqqafoxpew";
$pass = getenv('SUPABASE_PASS') ?: "sg95WPSX2YuRgV91"; 

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}