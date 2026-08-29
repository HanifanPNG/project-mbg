<?php
require_once "../config.php";
require_once "../lib/db_helper.php";

$id = (int)($_GET['id'] ?? 0);
$sppg_id = (int)($_GET['sppg_id'] ?? 0);

$ok = db_exec("DELETE FROM sppg_rating WHERE id=?", "i", $id);

if ($ok) {
    echo "<script>window.location.href='.?p=detail_sppg&id=$sppg_id';</script>";
} else {
    echo "<script>window.location.href='.?p=detail_sppg&id=$sppg_id';</script>";
}
?>