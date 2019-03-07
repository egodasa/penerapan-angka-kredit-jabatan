<?php
  session_start();
  require("../pengaturan/helper.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Daftar pangkat";
  require("../pengaturan/database.php");
  $query = $db->prepare("SELECT a.*, b.nm_jabatan, c.nm_pangkat FROM tbl_jabatan_pangkat a JOIN tbl_jabatan b ON a.id_jabatan = b.id_jabatan JOIN tbl_pangkat c ON a.id_pangkat = c.id_pangkat ORDER BY a.peringkat DESC"); 
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
  <?php include "../template/menu-staff.php"; ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Nilai Kredit Pangkat</h3>
        </div>
        <div class="box-body table-responsive ">
            <a href="<?=$alamat_web?>/kredit-pangkat/tambah.php" class="btn btn-flat btn-success">Tambah Data</a>
            <table class="table table-bordered" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Jabatan</th>
                  <th>Nilai Kredit</th>
                  <th>Peringkat</th>
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
                  <td><?=$d['nm_jabatan']." ".$d['nm_pangkat']?></td>
                  <td><?=$d['nilai_kredit']?></td>
                  <td><?=$d['peringkat']?></td>
                  <td>
                    <a href="<?=$alamat_web?>/kredit-pangkat/proses_hapus.php?id_jabatan_pangkat=<?=$d['id_jabatan_pangkat']?>" class="btn btn-flat btn-danger">Hapus</a> 
                    <a href="<?=$alamat_web?>/kredit-pangkat/edit.php?id_jabatan_pangkat=<?=$d['id_jabatan_pangkat']?>" class="btn btn-flat btn-primary">Edit</a></td>
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
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
