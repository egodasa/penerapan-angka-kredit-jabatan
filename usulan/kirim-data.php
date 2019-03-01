<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require("../pengaturan/medoo.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Kirim Data";
  $ak_pendidikan = $db->query("SELECT SUM(a.angka_kredit) AS angka_kredit FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur WHERE b.kategori_unsur = 'Pendidikan' AND a.id_usulan = :id_usulan", ['id_usulan' => $_GET['id_usulan']])->fetch();
  $ak_tugas_pokok = $db->query("SELECT SUM(a.angka_kredit) AS angka_kredit FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur WHERE b.kategori_unsur = 'Tugas Pokok' AND a.id_usulan = :id_usulan", ['id_usulan' => $_GET['id_usulan']])->fetch();
  $ak_pengembangan_profesi = $db->query("SELECT SUM(a.angka_kredit) AS angka_kredit FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur WHERE b.kategori_unsur = 'Pengembangan Profesi' AND a.id_usulan = :id_usulan", ['id_usulan' => $_GET['id_usulan']])->fetch();
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
          Anda akan mengusul PAK tahunan. <br/>
          Total AK pendidikan Anda <?=$ak_pendidikan['angka_kredit']?><br/>
          Total AK tugas pokok Anda <?=$ak_tugas_pokok['angka_kredit']?><br/>
          Total AK kredit pengembangan profesi Anda <?=$ak_pengembangan_profesi['angka_kredit']?><br/>
          Total AK saat ini <?=($ak_pendidikan['angka_kredit']+$ak_tugas_pokok['angka_kredit']+$ak_pengembangan_profesi['angka_kredit'])?><br/>
          Total AK memenuhi pangkat <?=$_SESSION['angka_kredit_selanjutnya']?><br/>
          Total kekurangan AK untuk kenaikan pangkat <?=abs(($ak_pendidikan['angka_kredit']+$ak_tugas_pokok['angka_kredit']+$ak_pengembangan_profesi['angka_kredit'])-$_SESSION['angka_kredit_selanjutnya'])?><br/>
          <form action="proses_edit.php" method="POST">
            <input type="hidden" name="jenis_usulan" value="kirim-data" />
            <input type="hidden" name="id_usulan" value="<?=$_GET['id_usulan']?>" />
            <button type="submit" class="btn btn-primary">Kirim Sekarang</button>
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
