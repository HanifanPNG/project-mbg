<?php
$id = $_GET['id'];          
$sppg_id = $_GET['sppg_id'];

require_once "../config.php";

$sql = "DELETE FROM sppg_rating WHERE id='$id'";
$hasil = $db->query($sql);

if ($hasil) {
    echo "<script>
            window.location.href='.?p=detail_sppg&id=$sppg_id';
          </script>";
} else {
    echo "<script>
            window.location.href='.?p=detail_sppg&id=$sppg_id';
          </script>";
}
?>
