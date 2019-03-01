<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Tambah Posisi";
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
          <h3 class="box-title">Input Posisi</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/posisi/proses_tambah.php" enctype="multipart/form-data">
              <div class="form-group">
                <label class="form-label">Nama Posisi</label>
                <input class="form-control"  type="text" name="nm_posisi" required />
              </div>
              <div class="form-group">
                <label class="form-label">Jenis Posisi</label>
                <select class="form-control custom-select"  name="jenis_posisi" required>
                  <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                  <option value="Staff Pegawai">Staff Pegawai</option>
                  <option value="Tim Penilai">Tim Penilai</option>
                </select>
              </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary" >Simpan</button>
              <button type="reset" class="btn btn-danger" >Reset</button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
