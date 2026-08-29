<?php
session_start();
require_once "../config.php";
require_once "../lib/db_helper.php";
require_once "../lib/validation.php";
require_once "../lib/csrf.php";

// WAJIB LOGIN
if (!isset($_SESSION['isLogin'])) {
    die("Akses ditolak");
}

if (!csrf_verify()) die("Invalid CSRF");

// AMBIL DATA
$sppg_id  = (int)($_POST['sppg_id'] ?? 0);
$komentar = v_string($_POST['komentar'] ?? '', 2000);
$rating   = v_rating($_POST['rating'] ?? '0');
$user_id  = (int)($_SESSION['user_id'] ?? 0);

// VALIDASI HAK AKSES
$userLevel = $_SESSION['level'] ?? '';
if ($userLevel === 'user') {
    // User biasa: hanya boleh rating SPPG yang dinaungi
    $userSppgId = (int)($_SESSION['sppg_id'] ?? 0);
    if ($userSppgId !== $sppg_id) {
        die("Tidak diizinkan: Anda hanya bisa memberi rating pada SPPG yang Anda terima.");
    }
} elseif ($userLevel !== 'admin' && $userLevel !== 'sppg') {
    // User dengan level tidak dikenal
    die("Akses ditolak");
}

// SIMPAN KOMENTAR
$ok = db_exec(
    "INSERT INTO sppg_rating (user_id, sppg_id, komentar, rating) VALUES (?, ?, ?, ?)",
    "iisi",
    $user_id, $sppg_id, $komentar, $rating
);

// REDIRECT (ANTI DOUBLE SUBMIT)
header("Location: ../User/detail_sppg.php?id=$sppg_id");
exit;