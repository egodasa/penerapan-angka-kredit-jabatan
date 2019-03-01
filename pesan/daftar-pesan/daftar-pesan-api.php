<?php
  session_start();
  require("../../pengaturan/helper.php");
  require("../../pengaturan/database.php");
  $result = array();
  // Ambil daftar menu
  $sql = "SELECT a.*,b.nm_meja FROM tbl_pesan a JOIN tbl_meja b ON a.id_meja = b.id_meja WHERE DAY(a.tanggal_pesan) = DAY(NOW()) AND a.id_pesan = :id_pesan";
  
  // Eksekusi query daftar menu beserta filternya
  $query = $db->prepare($sql);
  
  $query->bindParam("id_pesan", $_GET['id_pesan']);
  $query->execute();
  $daftar_pesan = $query->fetchAll(PDO::FETCH_ASSOC);

  $result['data'] = $daftar_pesan;
  $result['total'] = count($daftar_pesan);
  echo json_encode($result);
  ?>