<?php
  session_start();
  require_once("../../vendor/autoload.php");
  require("../../pengaturan/helper.php");
  require_once("../../pengaturan/medoo.php");
  
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit Butir Kegiatan";
  if(isset($_GET['id_butir']))
  {
    $detail = $db->get("tbl_butir_kegiatan", "*", ["id_butir" => $_GET['id_butir']]); 
    
    // cek dulu, datanya ketemu atau tidak. Kalau gk ketemu, ya redirect ke halaman awal
    if(empty($detail))
    {
      header("Location: $alamat_web/unsur-kegiatan");
    }
  }
  else
  {
    header("Location: $alamat_web/unsur-kegiatan");
  }
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
          <h3 class="box-title">Edit Butir Kegiatan</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/unsur-kegiatan/butir-kegiatan/proses_edit.php" enctype="multipart/form-data">
              <input class="form-control" type="hidden" name="id_sub_unsur" value="<?=$detail['id_sub_unsur']?>" />
              <input class="form-control" type="hidden" name="id_butir" value="<?=$detail['id_butir']?>" />
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
                <button type="submit" class="btn btn-flat btn-primary" >Simpan perubahan</button>
                <button type="reset" class="btn btn-flat btn-danger" >Reset</button>
              </div>
            </form>
        </div>
      </div>
    </section>
  </div>
  <script>
    document.getElementsByName("butir_kegiatan")[0].value = "<?=$detail['butir_kegiatan']?>";
    document.getElementsByName("satuan")[0].value = "<?=$detail['satuan']?>";
    document.getElementsByName("angka_kredit")[0].value = "<?=$detail['angka_kredit']?>";
  </script>
  <?php include "../../template/footer.php"; ?>
  <?php include("../../template/script.php"); ?>
</div>
</body>
</html>
