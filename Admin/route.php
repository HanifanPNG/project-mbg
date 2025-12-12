<?php 

$p=$_GET['p'];

switch ($p) {
    case 'sppg':
        require_once "sppg.php";
        break;  
    case 'detail_sppg':
        require_once "detail_sppg.php";
        break;  
    case 'edit_sppg':
        require_once "edit_sppg.php";
        break;  
    case 'hapus_sppg':
        require_once "hapus_sppg.php";
        break;      
    case 'tambah_sppg' :
        require_once "tambah_sppg.php";
        break; 

    case 'tambah_menu' :
        require_once "tambah_menu.php";
        break;      
    case 'edit_menu' :
        require_once "edit_menu.php";
        break;      
    case 'hapus_menu' :
        require_once "hapus_menu.php";
        break;      
        
    case 'tambah_sekolah' :
        require_once "tambah_sekolah.php";
        break;   
    case 'edit_sekolah' :
        require_once "edit_sekolah.php";
        break;   
    case 'hapus_sekolah' :
        require_once "hapus_sekolah.php";
        break;  

    case 'tambah_ibu_hamil' :
        require_once "tambah_ibu_hamil.php";
        break;   
    case 'edit_ibu_hamil' :
        require_once "edit_ibu_hamil.php";
        break;   
    case 'hapus_ibu_hamil' :
        require_once "hapus_ibu_hamil.php";
        break;   
        
        
    case 'hapus_komentar' :
        require_once "hapus_komentar.php";
        break;      
    case 'gantiPW' :
        require_once "gantiPW.php";
        break;     

    default:
        require_once "dashboard.php";
        break;

    }
?>