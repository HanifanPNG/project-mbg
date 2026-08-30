<?php
session_start();
require_once "../config.php";
require_once "../lib/db_helper.php";

// SPPG ID dari session (AMAN)
if (!isset($_SESSION['isLogin']) || $_SESSION['level'] !== 'sppg') {
    header("Location: ../login.php");
    exit;
}
$sppg_id = (int)$_SESSION['sppg_id'];
$id = (int)($_GET['id'] ?? 0);

// Validasi ownership: menu ini milik SPPG yang login?
$res = db_query("SELECT id FROM menu_sppg WHERE id=? AND sppg_id=?", "ii", $id, $sppg_id);
if (!$res || $res->num_rows === 0) {
    header("Location: index.php?error=notfound");
    exit;
}

$ok = db_exec("DELETE FROM menu_sppg WHERE id=? AND sppg_id=?", "ii", $id, $sppg_id);

if ($ok) {
    echo "<script>
            alert('Menu berhasil dihapus!');
            window.location.href='index.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menghapus menu');
            window.location.href='index.php';
          </script>";
}
?>