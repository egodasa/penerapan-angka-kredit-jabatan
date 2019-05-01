<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  
  // Posisi yang sedang diakses akan disimpan kedalam session
  if(isset($_GET['id_jabatan']))
  {
    $_SESSION['current_jabatan'] = $db->get("tbl_jabatan", "*", ["id_jabatan" => $_GET['id_jabatan']]);
  }
  $data = $db->query("SELECT a.* FROM tbl_unsur a JOIN tbl_jabatan b ON a.id_jabatan = b.id_jabatan WHERE b.id_jabatan = :id_jabatan", ["id_jabatan" => $_SESSION['current_jabatan']['id_jabatan']])->fetchAll(PDO::FETCH_ASSOC); 
  
  $judul_halaman = "Daftar Kegiatan Unsur <br> Posisi ".$_SESSION['current_posisi']['nm_posisi']." <br> Tingkat ".$_SESSION['current_jabatan']['nm_jabatan'];
?>

<html>
<head>
  <?php
    include("../template/head.php");
  ?>
</head>
<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">
  <?php include "../template/menu-staff.php"; ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><?=$judul_halaman?></h3>
        </div>
        <div class="box-body table-responsive">
            <a href="<?=$alamat_web?>/jabatan" class="btn btn-flat btn-primary">Kembali Ke Daftar Jabatan</a>
            <a href="<?=$alamat_web?>/unsur/tambah.php" class="btn btn-flat btn-success">Tambah Data</a>
            <table class="table table-bordered" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama unsur</th>
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
                  <td><?=$d['nm_unsur']?></td>
                  <td>
                    <a href="<?=$alamat_web?>/unsur/proses_hapus.php?id_unsur=<?=$d['id_unsur']?>" class="btn btn-flat btn-danger">Hapus</a> 
                    <a href="<?=$alamat_web?>/unsur/edit.php?id_unsur=<?=$d['id_unsur']?>" class="btn btn-flat btn-primary">Edit</a></td>
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
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
