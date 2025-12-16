<?php
$id = $_GET['id'];          
$sppg_id = $_GET['sppg_id'];

require_once "../config.php";

$sql = "DELETE FROM menu_sppg WHERE id='$id'";
$hasil = $db->query($sql);

if ($hasil) {
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
