<?php
  session_start();
  require("../../vendor/autoload.php");
  require("../../pengaturan/helper.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Daftar usulan";
  require("../../pengaturan/medoo.php");
  $data = $db->query("SELECT a.*, b.nm_berkas FROM tbl_berkas_penilaian a JOIN tbl_jenis_berkas b ON a.id_berkas = b.id_berkas WHERE a.id_usulan = :id_usulan", ["id_usulan" => $_GET['id_usulan']])->fetchAll(); 
?>

<html>
<head>
  <?php
    include("../../template/head.php");
  ?>
</head>
<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">
  <?php include "../../template/menu.php"; ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Berkas Usulan <?=$_GET['id_usulan']?></h3>
        </div>
        <div class="box-body table-responsive ">
          <div class="table-responsive" style="overflow-x: visible; overflow-y:visible;">
	        <div style="overflow:auto; min-height:500px; margin:0px 0 0px 0;" >
            <table id="tabel" class="table table-bordered" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Berkas</th>
                  <th>Berkas</th>
                  <?php if($_SESSION['jenis_posisi'] == 'Tenaga Kependidikan'): ?>
                    <th>Aksi</th>
                  <?php endif; ?>
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
                  <td><?=$d['nm_berkas']?></td>
                  <td>
                    <?php if(empty($d['file'])):?>
                      Berkas belum ada.
                    <?php else:?>
                      <a href="<?=$alamat_web?>/assets/img/berkas/<?=$d['file']?>" target="_blank">
                        <img src="<?=$alamat_web?>/assets/img/berkas/<?=$d['file']?>" height="300" width="300">
                      </a>
                    <?php endif; ?>
                  </td>
                  <?php if($_SESSION['jenis_posisi'] == 'Tenaga Kependidikan'): ?>
                    <td>
                      <?php if(empty($d['file'])): ?>
                        <form method="POST" action="tambah-berkas.php" enctype="multipart/form-data">
                          <input type="hidden" name="id_usulan" value="<?=$_GET['id_usulan']?>" />
                          <input type="hidden" name="id_berkas_penilaian" value="<?=$d['id_berkas_penilaian']?>" />
                          <div class="form-group">
                            <label class="form-label">Upload Berkas</label>
                            <input class="form-control" type="file" name="berkas" />
                          </div>  
                          <div class="form-group">
                            <button type="submit" class="btn btn-flat  btn btn-primary" >Upload</button>
                          </div>
                        </form>
                      <?php else: ?>
                        <form method="POST" action="ganti-berkas.php" enctype="multipart/form-data">
                          <input type="hidden" name="id_usulan" value="<?=$_GET['id_usulan']?>" />
                          <input type="hidden" name="id_berkas_penilaian" value="<?=$d['id_berkas_penilaian']?>" />
                          <input type="hidden" name="berkas_lama" value="<?=$d['file']?>" />
                            <div class="form-group">
                              <label class="form-label">Ganti Berkas</label>
                              <input class="form-control" type="file" name="berkas" />
                            </div>  
                            <div class="form-group">
                              <button type="submit" class="btn btn-flat  btn btn-primary" >Upload</button>
                            </div>
                          </form>
                      <?php endif; ?>
                    </td>
                  <?php endif; ?>
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
        </div>
      </div>
    </section>
  </div>
  <?php include "../../template/footer.php"; ?>
  <?php include("../../template/script.php"); ?>
</div>
</body>
</html>
