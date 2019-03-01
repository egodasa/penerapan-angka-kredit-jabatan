<?php 
  if($_SESSION['jenis_posisi'] == 'Tenaga Kependidikan'){
    include "menu-kependidikan.php";  
  }else if($_SESSION['jenis_posisi'] == 'Staff Kepegawaian'){
    include "menu-staff.php";
  }else{
    include "menu-penilai.php";
  }
?>
