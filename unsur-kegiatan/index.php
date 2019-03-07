<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Daftar Unsur Kegiatan";
  require("../pengaturan/medoo.php");
  $data= $db->query("SELECT a.*, b.nm_posisi FROM tbl_unsur a JOIN tbl_posisi b ON a.id_posisi = b.id_posisi")->fetchAll();
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
            <h3 class="box-title">Daftar Unsur Kegiatan</h3>
          </div>
          <div class="box-body table-responsive ">
            <a href="<?=$alamat_web?>/unsur-kegiatan/tambah.php" class="btn btn-flat btn-success">Tambah Data</a>
            <table id="tabel" class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Unsur Kegiatan</th>
                  <th>Posisi</th>
                  <th>Jenis Unsur Kegiatan</th>
                  <th>Kategori Unsur Kegiatan</th>
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
                    <?=$d['nm_unsur']?>
                  </td>
                  <td>
                    <?=$d['nm_posisi']?>
                  </td>
                  <td>
                    <?=$d['jenis_unsur']?>
                  </td>
                  <td>
                    <?=$d['kategori_unsur']?>
                  </td>
                  <td>
                    <a href="<?=$alamat_web?>/unsur-kegiatan/proses_hapus.php?id_unsur=<?=$d['id_unsur']?>" class="btn btn-flat btn-danger">Hapus</a>
                    <a href="<?=$alamat_web?>/unsur-kegiatan/edit.php?id_unsur=<?=$d['id_unsur']?>" class="btn btn-flat btn-primary">Edit</a></td>
                </tr>
                <?php 
  $no++;
  }
}else{
?>
                <tr>
                  <td colspan=6 class="text-center">Tidak ada data yang ditampilkan!</td>
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
