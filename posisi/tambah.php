<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Tambah Jabatan";
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
            <form method="POST" action="<?=$alamat_web?>/posisi/proses_tambah.php" enctype="multipart/form-data">
              <div class="form-group">
                <label class="form-label">Nama Jabatan</label>
                <input class="form-control"  type="text" name="nm_posisi" required />
              </div>
              <div class="form-group">
                <label class="form-label">Jenis Jabatan</label>
                <select class="form-control custom-select"  name="jenis_posisi" required>
                  <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                  <option value="Staff Pegawai">Staff Pegawai</option>
                  <option value="Tim Penilai">Tim Penilai</option>
                </select>
              </div>
            <div class="form-group">
              <button type="submit" class="btn btn-flat btn-primary" >Simpan</button>
              <button type="reset" class="btn btn-flat btn-danger" >Reset</button>
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
