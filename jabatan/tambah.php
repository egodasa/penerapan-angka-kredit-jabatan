<?php
  session_start();
  require("../pengaturan/helper.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Tambah jabatan";
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
          <h3 class="box-title">Tambah jabatan</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/jabatan/proses_tambah.php">
              <div class="form-group">
                <label class="form-label">Nama jabatan</label>
                <input class="form-control"  type="text" name="nm_jabatan" required />
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
