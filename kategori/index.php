<?php
  session_start();
  require("../pengaturan/helper.php");
  cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Daftar Kategori";
  require("../pengaturan/database.php");
  $query = $db->prepare("SELECT * FROM tbl_kategori"); 
  $query->execute();
  $data = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<html>

<head>
  <?php
    include("../template/head.php");
  ?>
</head>

<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
  <div class="wrapper" style="height: auto; min-height: 100%;">
    <?php include "../template/menu-kasir.php"; ?>
    <div class="content-wrapper" style="min-height: 901px;">
      <section class="content">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Daftar Kategori Menu</h3>
          </div>
          <div class="box-body table-responsive ">
            <a href="<?=$alamat_web?>/kategori/tambah.php" class="btn btn-success">Tambah Data</a>
            <table class="table table-bordered" >
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
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
                    <td><?=$no?></td>
                    <td><?=$d['nm_kategori']?></td>
                    <td>
                      <a href="<?=$alamat_web?>/kategori/proses_hapus.php?id_kategori=<?=$d[id_kategori]?>" class="btn btn-danger">Hapus</a> 
                      <a href="<?=$alamat_web?>/kategori/edit.php?id_kategori=<?=$d[id_kategori]?>" class="btn btn-primary">Edit</a></td>
                  </tr>
              <?php 
                $no++;
                }
              }else{
              ?>
                  <tr>
                    <td colspan=3 class="text-center">Tidak ada data yang ditampilkan!</td>
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