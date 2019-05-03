<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require("../pengaturan/medoo.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Kirim Data";
  
  $ak_utama_total = 0;
  $ak_penunjang_total = 0;
  $ak_total = 0;
  
  $ak_utama_sekarang = $_SESSION['kredit_awal_utama'];
  $ak_penunjang_sekarang = $_SESSION['kredit_awal_penunjang'];
  
  // Ambil angka kredit utama dan penunjang dari usulan
  
  $sql_ak_utama = "SELECT 
                      SUM(IFNULL(a.angka_kredit_baru), a.angka_kredit, a.angka_kredit_baru) AS angka_kredit 
                      FROM tbl_usulan_unsur a 
                      JOIN tbl_usulan b ON a.id_usulan = b.id_usulan 
                      JOIN tbl_pegawai c ON b.nip = c.nip 
                      JOIN tbl_butir_kegiatan d ON a.id_butir = b.id_butir 
                      JOIN tbl_sub_unsur e ON d.id_sub_unsur = e.id_sub_unsur 
                      JOIN tbl_unsur f ON e.id_unsur = f.id_unsur 
                     WHERE c.nip = :nip AND f.kategori = 'Unsur Utama' GROUP BY a.id_usulan_unsur";
  $ak_utama_sementara = $db->query($sql_ak_utama, ['nip' => $_SESSION['nip']])->fetch();
  
  $sql_ak_penunjang = "SELECT 
                      SUM(IFNULL(a.angka_kredit_baru), a.angka_kredit, a.angka_kredit_baru) AS angka_kredit 
                      FROM tbl_usulan_unsur a 
                      JOIN tbl_usulan b ON a.id_usulan = b.id_usulan 
                      JOIN tbl_pegawai c ON b.nip = c.nip 
                      JOIN tbl_butir_kegiatan d ON a.id_butir = b.id_butir 
                      JOIN tbl_sub_unsur e ON d.id_sub_unsur = e.id_sub_unsur 
                      JOIN tbl_unsur f ON e.id_unsur = f.id_unsur 
                     WHERE c.nip = :nip AND f.kategori = 'Unsur Penunjang' GROUP BY a.id_usulan_unsur";
  $ak_penunjang_sementara = $db->query($sql_ak_penunjang, ['nip' => $_SESSION['nip']])->fetch();
  
  $ak_utama_total = $ak_utama_sekarang + $ak_utama_sementara['angka_kredit'];
  $ak_penunjang_total = $ak_penunjang_sekarang + $ak_penunjang_sementara['angka_kredit'];
  
  $ak_total = $ak_utama_total + $ak_penunjang_total;
?>

<html>
<head>
  <?php
    include("../template/head.php");
  ?>
</head>
<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">
  
  <?php include "../template/menu.php"; ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Pengiriman Data</h3>
        </div>
        <div class="box-body table-responsive ">
          Golongan Anda saat ini <b><?=$_SESSION['nm_pangkat_sekarang']?></b> akan naik pangkat ke <b><?=$_SESSION['nm_pangkat_selanjutnya']?></b> <br/>
          Total KUM saat ini <?=round($ak_total, 4)?> (Unsur Utama <?=round($ak_utama_total, 4)?>, Unsur Penunjang <?=round($ak_penunjang_total, 4)?>)<br/>
          Total KUM yang harus dicapai untuk naik pangkat : <b><?=$_SESSION['angka_kredit_selanjutnya']?></b><br/>
          Total kekurangan Angka Kredit Anda <b><?=round(abs($ak_total - $_SESSION['angka_kredit_selanjutnya']), 4)?></b><br/>
          Untuk memenuhi kenaikan pangkat <b><?=$_SESSION['nm_pangkat_selanjutnya']?></b><br/>
          <form action="proses_edit.php" method="POST">
            <input type="hidden" name="jenis_usulan" value="kirim-data" />
            <input type="hidden" name="id_usulan" value="<?=$_GET['id_usulan']?>" />
            <button type="submit" class="btn btn-flat btn-primary">Kirim Sekarang</button>
          </form>
        </div>
      </div>
    </section>
  </div>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
