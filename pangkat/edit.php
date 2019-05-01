<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit Pangkat";
  if(isset($_GET['id_pangkat']))
  {
    $detail = $db->get("tbl_pangkat", "*", ["id_pangkat" => $_GET['id_pangkat']]); 
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
            <form method="POST" action="<?=$alamat_web?>/pangkat/proses_edit.php">
              <input class="form-control" type="hidden" name="id_pangkat" value="<?=$detail['id_pangkat']?>" />
              <div class="form-group">
                <label class="form-label" >Nama Pangkat</label>
                <input class="form-control"  type="text" name="nm_pangkat" value="<?=$detail['nm_pangkat']?>" required />
              </div>
              <div class="form-group">
                <label class="form-label">Angka Kredit Minimal</label>
                <input class="form-control"  type="text" name="angka_kredit_minimal" value="<?=$detail['angka_kredit_minimal']?>" required />
              </div>
              <div class="form-group">
                <label class="form-label">Peringkat</label>
                <input class="form-control"  type="text" name="peringkat" value="<?=$detail['peringkat']?>" required />
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
