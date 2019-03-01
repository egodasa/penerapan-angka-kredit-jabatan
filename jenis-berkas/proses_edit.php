<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_berkas'])){
  try{
    $query = $db->prepare("UPDATE tbl_jenis_berkas SET nm_berkas = :nm_berkas WHERE id_berkas = :id_berkas");
    $query->bindParam("id_berkas", $_POST['id_berkas'], PDO::PARAM_INT);
    $query->bindParam("nm_berkas", $_POST['nm_berkas']);
    $query->execute();
  }
  catch(PDOException $e)
  {
    echo $sql . "<br>" . $e->getMessage();
  }
}

// Arahkan user ke halaman jenis berkas kembali
header("Location: $alamat_web/jenis-berkas");
?>

