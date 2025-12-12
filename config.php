<?php
date_default_timezone_set('Asia/Jakarta');
$db = new mysqli("localhost","root","","project-mbg");
if($db){
    //echo "koneksi berhasil";
} else {
    echo "gagal";
}
?>