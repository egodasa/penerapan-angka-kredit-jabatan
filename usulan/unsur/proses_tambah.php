<?php
require("../../pengaturan/database.php");
require("../../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $nama_file = fileUpload($_FILES['bukti_kegiatan'], "../../assets/img/foto/");
  $sql = "INSERT INTO `tbl_usulan_unsur`
            (`tgl_mulai_kegiatan`,
             `tgl_selesai_kegiatan`,
             `butir_kegiatan`,
             `satuan`,
             `angka_kredit_murni`,
             `angka_kredit_persentase`,
             `angka_kredit`,
             `tempat`,
             `id_usulan`,
             `tingkat_kesulitan`,
             `jumlah_volume_kegiatan`,
             `id_unsur`,
             `bukti_kegiatan`)
            VALUES 
              (:tgl_mulai_kegiatan,
               :tgl_selesai_kegiatan,
               :butir_kegiatan,
               :satuan,
               :angka_kredit_murni,
               :angka_kredit_persentase,
               :angka_kredit,
               :tempat,
               :id_usulan,
               :tingkat_kesulitan,
               :jumlah_volume_kegiatan,
               :id_unsur,
               :bukti_kegiatan)";
  $query = $db->prepare($sql);
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
  $query->bindParam('id_unsur', $_POST['id_unsur']);
  $query->bindParam('bukti_kegiatan', $nama_file);
  $query->execute();
}

// Arahkan user ke halaman jabatan kembali
header("Location: $alamat_web/usulan/unsur?id_usulan=".$_POST['id_usulan']);
?>

