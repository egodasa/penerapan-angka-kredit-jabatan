<?php
  session_start();
  require_once("../../vendor/autoload.php");
  require("../../pengaturan/helper.php");
  require_once("../../pengaturan/medoo.php");
  
  $judul_halaman = "Tambah Butir Kegiatan";
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
          <h3 class="box-title">Tambah Butir Kegiatan</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/unsur-kegiatan/butir-kegiatan/proses_tambah.php">
              <input type="hidden" name="id_sub_unsur" value="<?=$_GET['id_sub_unsur']?>" />
              <div class="form-group">
                <label class="form-label">Butir Kegiatan</label>
                <input class="form-control" type="text" name="butir_kegiatan" required />
              </div>
              <div class="form-group">
                <label class="form-label">Satuan</label>
                <input class="form-control" type="text" name="satuan" required />
              </div>
              <div class="form-group">
                <label class="form-label">Angka Kredit</label>
                <input class="form-control" type="text" name="angka_kredit" required />
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
  <?php include "../../template/footer.php"; ?>
  <?php include("../../template/script.php"); ?>
</div>
</body>
</html>
