<?php
  session_start();
  require("../pengaturan/helper.php");
  cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  require("../pengaturan/database.php");
  $result = array();
  // Ambil daftar menu
  $sql = "SELECT a.*,b.nm_meja FROM tbl_pesan a JOIN tbl_meja b ON a.id_meja = b.id_meja WHERE DAY(a.tanggal_pesan) = DAY(NOW())";
  // Nilai default untuk filter daftar menu
  $filter_nama = "";
  $filter_meja = "";
  $filter_status = "";
  
  // Filter status pembayaran
  if(isset($_GET['status']) && !empty($_GET['status'])){
    $filter_status = $_GET['status'];
    $sql .= " AND a.status_pesanan = :status"; 
  }
  
  // Filter nama 
  if(isset($_GET['nama']) && !empty($_GET['nama'])){
    $filter_nama = $_GET['nama'];
    $sql .= " AND a.nama_pemesan LIKE CONCAT('%', :nama ,'%')";
  }
  
  // Filter meja meja
  if(isset($_GET['meja']) && !empty($_GET['meja'])){
    $filter_meja = $_GET['meja'];
    $sql .= " AND b.nm_meja LIKE CONCAT('%', :meja ,'%')";
  }

  $sql .=" ORDER BY a.tanggal_pesan desc";
  
  // Eksekusi query daftar menu beserta filternya
  $query = $db->prepare($sql);
  

  if(isset($_GET['status']) && !empty($_GET['status'])){
    $query->bindParam("status", $filter_status);
  }
  if(isset($_GET['nama']) && !empty($_GET['nama'])){
    $query->bindParam("nama", $filter_nama);
  }
  if(isset($_GET['meja']) && !empty($_GET['meja'])){
    $query->bindParam("meja", $filter_meja);
  }
  $query->execute();
  $daftar_pesan = $query->fetchAll(PDO::FETCH_ASSOC);
  $result['data'] = $daftar_pesan;
  $result['total'] = count($daftar_pesan);
  echo json_encode($result);
  ?>