<?php
require_once "../config.php";
require_once "../lib/db_helper.php";

$id = (int)($_GET['id'] ?? 0);
$sppg_id = (int)($_GET['sppg_id'] ?? 0);

$ok = db_exec("DELETE FROM menu_sppg WHERE id=?", "i", $id);

if ($ok) {
    echo "<script>
            alert('Menu berhasil dihapus!');
            window.location.href='.?p=detail_sppg&id=$sppg_id';
          </script>";
} else {
    echo "<script>
            alert('Gagal menghapus menu');
            window.location.href='.?p=detail_sppg&id=$sppg_id';
          </script>";
}
?>