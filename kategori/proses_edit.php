<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_kategori'])){
  try{
    $query = $db->prepare("UPDATE tbl_kategori SET nm_kategori = :nm_kategori WHERE id_kategori = :id_kategori");
    $query->bindParam("id_kategori", $_POST['id_kategori'], PDO::PARAM_INT);
    $query->bindParam("nm_kategori", $_POST['nm_kategori']);
    $query->execute();
  }
  catch(PDOException $e)
  {
    echo $sql . "<br>" . $e->getMessage();
  }
}

// Arahkan user ke halaman kategori kembali
header("Location: $alamat_web/kategori");
?>

