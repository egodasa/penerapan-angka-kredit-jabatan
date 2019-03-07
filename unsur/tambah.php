<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  $judul_halaman = "Tambah Unsur";
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
          <h3 class="box-title">Input Unsur</h3>
        </div>
        <div class="box-body table-responsive ">
          <form method="POST" action="<?=$alamat_web?>/unsur/proses_tambah.php" enctype="multipart/form-data">
            <div class="form-group">
              <label class="form-label">Nama Unsur</label>
              <input class="form-control" type="text" name="nm_unsur" required />
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-flat  btn btn-primary" >Simpan</button>
              <button type="reset" class="btn btn-flat  btn btn-danger" >Reset</button>
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
