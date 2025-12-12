<?php
$idx=$_GET['id'];

require_once "../config.php";
$sql = "delete from sppg where id=$idx";
$hasil=$db->query($sql);

if($hasil){
    echo "<script>window.location.href='index.php?p=sppg';</script>";
} else {
    echo "<script>alert('data gagal dihapus');
     window.location.href='index.php?p=sppg';</script>";
}
?>