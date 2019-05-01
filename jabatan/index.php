<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  
  // Posisi yang sedang diakses akan disimpan kedalam session
  if(isset($_GET['id_posisi']))
  {
    $_SESSION['current_posisi'] = $db->get("tbl_posisi", "*", ["id_posisi" => $_GET['id_posisi']]);
  }
  $data = $db->query("SELECT a.* FROM tbl_jabatan a JOIN tbl_posisi b ON a.id_posisi = b.id_posisi WHERE b.id_posisi = :id_posisi", ["id_posisi" => $_SESSION['current_posisi']['id_posisi']])->fetchAll(PDO::FETCH_ASSOC); 
  
  $judul_halaman = "Daftar Jabatan ".$_SESSION['current_posisi']['nm_posisi'];
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
        <div class="box-body table-responsive ">
            <a href="<?=$alamat_web?>/posisi" class="btn btn-flat btn-primary">Kembali Ke Daftar Posisi</a>
            <a href="<?=$alamat_web?>/jabatan/tambah.php" class="btn btn-flat btn-success">Tambah Data</a>
            <table class="table table-bordered" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Jabatan</th>
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
                  <td><?=$d['nm_jabatan']?></td>
                  <td>
                    <a href="<?=$alamat_web?>/jabatan/proses_hapus.php?id_jabatan=<?=$d['id_jabatan']?>" class="btn btn-flat btn-danger">Hapus</a> 
                    <a href="<?=$alamat_web?>/jabatan/edit.php?id_jabatan=<?=$d['id_jabatan']?>" class="btn btn-flat btn-primary">Edit</a>
                    <a href="<?=$alamat_web?>/unsur/index.php?id_jabatan=<?=$d['id_jabatan']?>" class="btn btn-flat btn-warning">Daftar Kegiatan Unsur</a>
                  </td>
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
