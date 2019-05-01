<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Daftar Jabatan";
  
  $data= $db->select("tbl_posisi", '*');
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
      <?php
        include("breadcrumb.php");
      ?>
      <section class="content">
        <div class="box">
          <div class="box-body table-responsive ">
            <a href="<?=$alamat_web?>/posisi/tambah.php" class="btn btn-flat btn-success">Tambah Data</a>
            <table id="tabel" class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Jabatan</th>
                  <th>Jenis Jabatan</th>
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
                    <?=$d['nm_posisi']?>
                  </td>
                  <td>
                    <?=$d['jenis_posisi']?>
                  </td>
                  <td>
                    <a href="<?=$alamat_web?>/posisi/proses_hapus.php?id_posisi=<?=$d['id_posisi']?>" class="btn btn-flat btn-danger">Hapus</a>
                    <a href="<?=$alamat_web?>/posisi/edit.php?id_posisi=<?=$d['id_posisi']?>" class="btn btn-flat btn-primary">Edit</a>
                    <a href="<?=$alamat_web?>/jabatan/index.php?id_posisi=<?=$d['id_posisi']?>" class="btn btn-flat btn-warning">Daftar Tingkat Jabatan</a>
                  </td>
                </tr>
                <?php 
  $no++;
  }
}else{
?>
                <tr>
                  <td colspan=4 class="text-center">Tidak ada data yang ditampilkan!</td>
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
