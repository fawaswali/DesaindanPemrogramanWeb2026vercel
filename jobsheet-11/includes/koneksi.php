<?php
// Ambil kredensial dari Environment Variables Vercel
$host     = getenv('SUPABASE_HOST') ?: $_ENV['SUPABASE_HOST'] ?? '';
$user     = getenv('SUPABASE_USER') ?: $_ENV['SUPABASE_USER'] ?? '';
$password = getenv('SUPABASE_PASS') ?: $_ENV['SUPABASE_PASS'] ?? '';
$dbname   = getenv('SUPABASE_DB')   ?: $_ENV['SUPABASE_DB']   ?? 'postgres';
$port     = getenv('SUPABASE_PORT') ?: $_ENV['SUPABASE_PORT'] ?? '6543';

// Fallback jika env Vercel tidak terbaca / diuji di lokal
if (empty($host)) {
    // Isikan langsung data Supabase milikmu di sini jika env kosong:
    $host     = 'aws-0-ap-northeast-2.pooler.supabase.com"'; // Ganti dengan Host Supabase kamu
    $user     = 'postgres';
    $password = 'sg95WPSX2YuRgV91'; // Ganti dengan Password Supabase kamu
    $dbname   = 'postgres';
    $port     = '6543';
}

try {
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname};";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}