<?php
session_start();
require("../pengaturan/database.php");
require("../pengaturan/helper.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  // Cek kecocokan kode meja dan nama meja dulu
  $query = $db->prepare("SELECT * FROM tbl_meja WHERE id_meja = :id_meja AND kd_meja = :kd_meja");
  $query->bindParam("id_meja", $_POST['id_meja']);
  $query->bindParam("kd_meja", $_POST['kd_meja']);
  $query->execute();
  $hasil_cek = $query->fetchAll(PDO::FETCH_ASSOC);

  // Jika hasil cek atau perhitungan 0, maka tidak cocok dan redirect kehalaman pesan dengan pesan error
  if(count($hasil_cek) == 1){
    $db->beginTransaction();
  $query = $db->prepare("INSERT INTO tbl_pesan (id_pesan, tanggal_pesan, nama_pemesan, id_meja) VALUES (:id_pesan, :tanggal_pesan, :nama_pemesan, :id_meja)");
  $query->bindParam("id_pesan", $_POST['id_pesan']);
  $query->bindParam("tanggal_pesan", date("Y-m-d H:i:s"));
  $query->bindParam("nama_pemesan", $_POST['nama_pemesan']);
  $query->bindParam("id_meja", $_POST['id_meja']);
  $query->execute();
  
  $query = $db->prepare("INSERT INTO tbl_detail_pesan (id_pesan, id_menu, jumlah) SELECT id_pesan, id_menu, jumlah FROM tbl_detail_pesan_tmp WHERE id_pesan = :id_pesan");
  $query->bindParam("id_pesan", $_POST['id_pesan']);
  $query->execute();
  
  // Hapus semua data pesan dari tabel pesan_tmp
  $query = $db->prepare("DELETE FROM tbl_detail_pesan_tmp WHERE id_pesan = :id_pesan");
  $query->bindParam("id_pesan", $_POST['id_pesan']); 
  $query->execute();
  
  $db->commit();
  // Buat id_pesan baru
  $_SESSION['id_pesan_siap'] = $_SESSION['id_pesan'];
  $_SESSION['id_pesan'] = generateNumber();
  // Arahkan menu ke halaman menu kembali
  header("Location: $alamat_web/pesan?simpan=ya");
  }else{
    // Arahkan menu ke halaman menu kembali dengan pesan error
    header("Location: $alamat_web/pesan?cocok=tidak");
  }
}
?>

