<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  
  $judul_halaman = "Edit Sub Unsur Kegiatan";
  if(isset($_GET['id_sub_unsur']))
  {
    $detail = $db->get("tbl_sub_unsur", "*", ['id_sub_unsur' => $_GET['id_sub_unsur']]); 
  }
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
            <form method="POST" action="<?=$alamat_web?>/sub-unsur/proses_edit.php">
              <input class="form-control"  type="hidden" name="id_sub_unsur" value="<?=$detail['id_sub_unsur']?>" />
              <div class="form-group">
                <label class="form-label">Nama Sub Unsur</label>
                <input class="form-control"  type="text" name="nm_sub_unsur" value="<?=$detail['nm_sub_unsur']?>" required />
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
