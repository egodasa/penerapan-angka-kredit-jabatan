<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  
  $judul_halaman = "Edit Unsur Kegiatan";
  if(isset($_GET['id_unsur']))
  {
    $detail = $db->get("tbl_unsur", "*", ['id_unsur' => $_GET['id_unsur']]); 
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
            <form method="POST" action="<?=$alamat_web?>/unsur/proses_edit.php">
              <input class="form-control"  type="hidden" name="id_unsur" value="<?=$detail['id_unsur']?>" />
              <div class="form-group">
                <label class="form-label" >Nama unsur</label>
                <input class="form-control"  type="text" name="nm_unsur" value="<?=$detail['nm_unsur']?>" required />
              </div>
              <div class="form-group">
                <label class="form-label">Kategori</label>
                <select class="form-control" name="kategori">
                  <option value="Unsur Utama">Unsur Utama</option>
                  <option value="Unsur Penunjang">Unsur Penunjang</option>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-flat btn-primary" >Simpan Perubahan</button>
                <button type="reset" class="btn btn-flat btn-danger" >Reset</button>
              </div>
            </form>
            <script>
              document.getElementsByName("kategori")[0].value = "<?=$detail['kategori']?>";
            </script>
        </div>
      </div>
    </section>
  </div>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
