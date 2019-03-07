<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Daftar Unsur";
  require("../pengaturan/medoo.php");
  $data= $db->select("tbl_unsur", "*");
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
            <h3 class="box-title">Daftar Unsur</h3>
          </div>
          <div class="box-body table-responsive ">
            <a href="<?=$alamat_web?>/unsur/tambah.php" class="btn btn-flat  btn btn-success">Tambah Data</a>
            <table id="tabel" class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Unsur</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
<?php
  $no = 1;
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
                    <a href="<?=$alamat_web?>/unsur/sub-unsur?id_unsur=<?=$d['id_unsur']?>" class="btn btn-flat  btn btn-flat btn btn-success">Daftar Sub Unsur</a>
                    <a href="<?=$alamat_web?>/unsur/proses_hapus.php?id_unsur=<?=$d['id_unsur']?>" class="btn btn-flat  btn btn-flat btn btn-danger">Hapus</a>
                    <a href="<?=$alamat_web?>/unsur/edit.php?id_unsur=<?=$d['id_unsur']?>" class="btn btn-flat  btn btn-flat btn btn-primary">Edit</a></td>
                </tr>
<?php 
  $no++;
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
