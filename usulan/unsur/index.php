<?php
  session_start();
  require("../../vendor/autoload.php");
  require("../../pengaturan/helper.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Daftar Unsur Kegiatan";
  require("../../pengaturan/medoo.php");
  $data = $db->query("SELECT a.*, b.nm_unsur, b.jenis_unsur FROM tbl_usulan_unsur a JOIN tbl_unsur b ON a.id_unsur = b.id_unsur WHERE a.id_usulan = :id_usulan", ["id_usulan" => $_GET['id_usulan']])->fetchAll();
?>

<html>
<head>
  <?php
    include("../../template/head.php");
  ?>
</head>
<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">
  <?php include "../../template/menu.php";  ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Unsur Kegiatan</h3>
        </div>
        <div class="box-body table-responsive ">
          <?php if($_SESSION['jenis_posisi'] == "Tenaga Kependidikan"): ?>
            <a href="<?=$alamat_web?>/usulan/unsur/tambah.php?id_usulan=<?=$_GET['id_usulan']?>" class="btn btn-success">Tambah Data</a>
          <?php endif; ?>
          <div class="table-responsive" style="overflow-x: visible; overflow-y:visible;">
	        <div style="overflow:auto; min-height:500px; margin:0px 0 0px 0;" >
            <table id="tabel" class="table table-bordered" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal Kegiatan</th>
                  <th>Butir Kegiatan</th>
                  <th>Satuan</th>
                  <th>Tempat</th>
                  <th>Bukti</th>
                  <th>Volume Kegiatan</th>
                  <th>Angka Kredit</th>
                  <th>Angka Kredit Baru</th>
                  <th>Jenis Unsur</th>
                  <?php if($_SESSION['jenis_posisi'] == "Tenaga Kependidikan" || $_SESSION['jenis_posisi'] == "Tim Penilai"): ?>
                    <th>Aksi</th>
                  <?php endif; ?>
                  <th>Status</th>
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
                  <td><?=tanggal_indo($d['tgl_mulai_kegiatan'])." - ".tanggal_indo($d['tgl_selesai_kegiatan'])?></td>
                  <td><?=$d['butir_kegiatan']?></td>
                  <td><?=$d['satuan']?></td>
                  <td><?=$d['tempat']?></td>
                  <td><a href="<?=$alamat_web."/assets/img/foto/".$d['bukti_kegiatan']?>"><img src="<?=$alamat_web."/assets/img/foto/".$d['bukti_kegiatan']?>" width="100" height="125" /></a></td>
                  <td><?=$d['jumlah_volume_kegiatan']?></td>
                  <td><?=round($d['angka_kredit'], 4)?></td>
                  <td><?=round($d['angka_kredit_baru'], 4)?></td>
                  <td><?=$d['jenis_unsur']?></td>
                  <?php if($_SESSION['jenis_posisi'] == "Tenaga Kependidikan"): ?>
                    <td>
                    <a href="<?=$alamat_web?>/usulan/unsur/proses_hapus.php?id_usulan_unsur=<?=$d['id_usulan_unsur']?>&id_usulan=<?=$_GET['id_usulan']?>" class="btn btn-danger">Hapus</a> 
                    <a href="<?=$alamat_web?>/usulan/unsur/edit.php?id_usulan_unsur=<?=$d['id_usulan_unsur']?>&id_usulan=<?=$_GET['id_usulan']?>" class="btn btn-primary">Edit</a>
                    </td>
                  <?php elseif($_SESSION['jenis_posisi'] == "Tim Penilai"): ?>
                    <td>
                    <a href="<?=$alamat_web?>/usulan/unsur/edit-kredit.php?id_usulan_unsur=<?=$d['id_usulan_unsur']?>&id_usulan=<?=$_GET['id_usulan']?>" class="btn btn-primary">Edit Angka Kredit</a>
                    </td>
                  <?php endif; ?>
                  <td><?=$d['status']?></td>
                </tr>
            <?php 
              $no++;
              }
            }else{
            ?>
                <tr>
                  <td colspan=13 class="text-center">Tidak ada data yang ditampilkan!</td>
                </tr>
            <?php
            }
            ?>
              </tbody>
            </table>
          </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <?php include "../../template/footer.php"; ?>
  <?php include("../../template/script.php"); ?>
</div>
</body>
</html>
