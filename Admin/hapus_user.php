<?php
require_once "../config.php";
require_once "../lib/db_helper.php";

$idx = (int)($_GET['id'] ?? 0);
$ok = db_exec("DELETE FROM users WHERE id=?", "i", $idx);

if ($ok) {
    echo "<script>window.location.href='index.php?p=sppg';</script>";
} else {
    echo "<script>alert('data gagal dihapus');
     window.location.href='index.php?p=sppg';</script>";
}
?>