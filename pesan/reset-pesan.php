<?php  
  session_start();
  if(isset($_SESSION['id_pesan'])){
    require_once("../pengaturan/database.php");
    require_once("../pengaturan/helper.php");
    // Hapus semua data pesan dari tabel pesan_tmp
    $query = $db->prepare("DELETE FROM tbl_detail_pesan_tmp WHERE id_pesan = :id_pesan");
    $query->bindParam("id_pesan", $_SESSION['id_pesan']); 
    $query->execute();
    // Buat id_pesan baru
    $_SESSION['id_pesan'] = generateNumber();
    if(isset($_GET['tinggalkan_meja'])){
      unset($_SESSION['id_pesan_siap']);
      header("Location: $alamat_web/pesan?tinggalkan_meja=true");
    }else{
      header("Location: $alamat_web/pesan");
    }
  }
?>
