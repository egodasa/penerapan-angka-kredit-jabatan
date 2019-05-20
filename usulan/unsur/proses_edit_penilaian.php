<?php
require("../../pengaturan/database.php");
require("../../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_usulan_unsur'])){  
  $sql = "UPDATE `tbl_usulan_unsur` SET 
             `angka_kredit_murni_baru` = :angka_kredit_murni,
             `angka_kredit_persentase_baru` = :angka_kredit_persentase,
             `status` = :status,
             `angka_kredit_baru` = :angka_kredit WHERE id_usulan_unsur = :id_usulan_unsur";
  $query = $db->prepare($sql);
  $query->bindParam('angka_kredit_murni', $_POST['angka_kredit_murni']);
  $query->bindParam('angka_kredit_persentase', $_POST['angka_kredit_persentase']);
  $query->bindParam('angka_kredit', $_POST['angka_kredit']);
  $query->bindParam('status', $_POST['status']);
  $query->bindParam('id_usulan_unsur', $_POST['id_usulan_unsur']);
  $query->execute();
}

// Arahkan user ke halaman jabatan kembali
header("Location: $alamat_web/usulan/unsur/?id_usulan=".$_POST['id_usulan']);
?>

