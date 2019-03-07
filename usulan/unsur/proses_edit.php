<?php
require("../../pengaturan/database.php");
require("../../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_usulan_unsur'])){
  $nama_file = $_POST['bukti_kegiatan_lama'];
  if($_FILES['bukti_kegiatan']['name'] != '')
  {
    $nama_file = fileUpload($_FILES['bukti_kegiatan'], "../../assets/img/foto/");
  }
  
  $sql = "UPDATE `tbl_usulan_unsur` SET 
            `tgl_mulai_kegiatan` = :tgl_mulai_kegiatan,
             `tgl_selesai_kegiatan` = :tgl_selesai_kegiatan,
             `butir_kegiatan` = :butir_kegiatan,
             `satuan` = :satuan,
             `angka_kredit_murni` = :angka_kredit_murni,
             `angka_kredit_persentase` = :angka_kredit_persentase,
             `angka_kredit` = :angka_kredit,
             `tempat` = :tempat,
             `id_usulan` = :id_usulan,
             `tingkat_kesulitan` = :tingkat_kesulitan,
             `jumlah_volume_kegiatan` = :jumlah_volume_kegiatan,
             `id_sub_unsur` = :id_sub_unsur,
             `bukti_kegiatan` = :bukti_kegiatan WHERE id_usulan_unsur = :id_usulan_unsur";
  $query = $db->prepare($sql);
  $query->bindParam('id_usulan_unsur', $_POST['id_usulan_unsur']);
  $query->bindParam('tgl_mulai_kegiatan', $_POST['tgl_mulai_kegiatan']);
  $query->bindParam('tgl_selesai_kegiatan', $_POST['tgl_selesai_kegiatan']);
  $query->bindParam('butir_kegiatan', $_POST['butir_kegiatan']);
  $query->bindParam('satuan', $_POST['satuan']);
  $query->bindParam('angka_kredit_murni', $_POST['angka_kredit_murni']);
  $query->bindParam('angka_kredit_persentase', $_POST['angka_kredit_persentase']);
  $query->bindParam('angka_kredit', $_POST['angka_kredit']);
  $query->bindParam('tempat', $_POST['tempat']);
  $query->bindParam('id_usulan', $_POST['id_usulan']);
  $query->bindParam('tingkat_kesulitan', $_POST['tingkat_kesulitan']);
  $query->bindParam('jumlah_volume_kegiatan', $_POST['jumlah_volume_kegiatan']);
  $query->bindParam('id_sub_unsur', $_POST['id_sub_unsur']);
  $query->bindParam('bukti_kegiatan', $nama_file);
  $query->execute();
}

// Arahkan user ke halaman jabatan kembali
header("Location: $alamat_web/usulan/unsur/?id_usulan=".$_POST['id_usulan']);
?>

