<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Daftar Unit Kerja";
  require("../pengaturan/medoo.php");
  $data = $db->query("SELECT a.*, b.nm_posisi, c.nip, c.nm_pegawai FROM tbl_unit_kerja a JOIN tbl_posisi b ON a.id_posisi = b.id_posisi JOIN tbl_pegawai c ON a.nip_atasan = c.nip")->fetchAll();
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
            <h3 class="box-title">Daftar Unit Kerja</h3>
          </div>
          <div class="box-body table-responsive ">
            <a href="<?=$alamat_web?>/unit-kerja/tambah.php" class="btn btn-success">Tambah Data</a>
            <table id="tabel" class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Unit Kerja</th>
                  <th>Yang Dibawahi</th>
                  <th>Atasan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
$no = 1;
if(count($data) > 0){
  foreach($data as $d){
?>
                <tr>
                  <td>
                    <?=$no?>
                  </td>
                  <td>
                    <?=$d['nm_unit_kerja']?>
                  </td>
                  <td>
                    <?=$d['nm_posisi']?>
                  </td>
                  <td>
                    <?=$d['nip']." ".$d['nm_pegawai']?>
                  </td>
                  <td>
                    <a href="<?=$alamat_web?>/unit-kerja/proses_hapus.php?id_unit_kerja=<?=$d['id_unit_kerja']?>" class="btn btn-danger">Hapus</a>
                    <a href="<?=$alamat_web?>/unit-kerja/edit.php?id_unit_kerja=<?=$d['id_unit_kerja']?>" class="btn btn-primary">Edit</a></td>
                </tr>
                <?php 
  $no++;
  }
}else{
?>
                <tr>
                  <td colspan=5 class="text-center">Tidak ada data yang ditampilkan!</td>
                </tr>
                <?php
}
?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
    <?php include("../template/footer.php"); ?>
  </div>
  <?php include("../template/script.php"); ?>
</body>
</html>
