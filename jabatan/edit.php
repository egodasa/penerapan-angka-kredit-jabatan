<?php
  ini_set('display_errors','off');
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit Tingkat Jabatan";
  $detail = $db->get("tbl_jabatan", "*", ["id_jabatan" => $_GET['id_jabatan']]);
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
    <?php
      include("breadcrumb.php");
    ?>
    <section class="content">
      <div class="box">
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/jabatan/proses_edit.php">
              <input class="form-control"  type="hidden" name="id_jabatan" value="<?=$detail['id_jabatan']?>" />
              <div class="form-group">
                <label class="form-label" >Nama jabatan</label>
                <input class="form-control"  type="text" name="nm_jabatan" value="<?=$detail['nm_jabatan']?>" required />
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-flat btn-primary" >Simpan Perubahan</button>
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
