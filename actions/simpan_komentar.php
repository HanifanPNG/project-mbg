<?php
session_start();
require "../config.php";

// WAJIB LOGIN
if (!isset($_SESSION['isLogin'])) {
  die("Akses ditolak");
}

// AMBIL DATA
$sppg_id  = $_POST['sppg_id'];
$komentar = htmlspecialchars($_POST['komentar']);
$rating   = (int)$_POST['rating'];

// VALIDASI HAK AKSES


// SIMPAN KOMENTAR
$db->query("
  INSERT INTO sppg_rating (user_id, sppg_id, komentar, rating)
  VALUES (
    '{$_SESSION['user_id']}',
    '$sppg_id',
    '$komentar',
    '$rating'
  )
");

// REDIRECT (ANTI DOUBLE SUBMIT)
header("Location: ../User/detail_sppg.php?id=$sppg_id");
exit;
