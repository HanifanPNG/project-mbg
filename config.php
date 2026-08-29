<?php
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $env = parse_ini_file($envFile);
} else {
    $env = [];
}
$db_host = $env['DB_HOST'] ?? 'localhost';
$db_user = $env['DB_USER'] ?? 'root';
$db_pass = $env['DB_PASS'] ?? '';
$db_name = $env['DB_NAME'] ?? 'project-mbg';

$db = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($db->connect_errno) {
    error_log("DB connection failed: " . $db->connect_error);
    die("Koneksi database gagal");
}
$db->set_charset("utf8mb4");
?>