<?php
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_jabatan_pangkat'])){
  try{
    $query = $db->prepare("UPDATE tbl_jabatan_pangkat SET nilai_kredit = :nilai_kredit, peringkat = :peringkat WHERE id_jabatan_pangkat = :id_jabatan_pangkat");
    $query->bindParam("id_jabatan_pangkat", $_POST['id_jabatan_pangkat'], PDO::PARAM_INT);
    $query->bindParam("nilai_kredit", $_POST['nilai_kredit']);
    $query->bindParam("peringkat", $_POST['peringkat']);
    $query->execute();
  }
  catch(PDOException $e)
  {
    echo $sql . "<br>" . $e->getMessage();
  }
}

// Arahkan user ke halaman pangkat kembali
header("Location: $alamat_web/kredit-pangkat");
?>

