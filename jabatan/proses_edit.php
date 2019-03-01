<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_jabatan'])){
  try{
    $query = $db->prepare("UPDATE tbl_jabatan SET nm_jabatan = :nm_jabatan WHERE id_jabatan = :id_jabatan");
    $query->bindParam("id_jabatan", $_POST['id_jabatan'], PDO::PARAM_INT);
    $query->bindParam("nm_jabatan", $_POST['nm_jabatan']);
    $query->execute();
  }
  catch(PDOException $e)
  {
    echo $sql . "<br>" . $e->getMessage();
  }
}

// Arahkan user ke halaman jabatan kembali
header("Location: $alamat_web/jabatan");
?>

