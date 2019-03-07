<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit Unsur Kegiatan";
  if(isset($_GET['id_sub_unsur'])){
    $detail = $db->get("tbl_sub_unsur", "*", ["id_sub_unsur" => $_GET['id_sub_unsur']]); 
    
    $posisi = $db->select("tbl_posisi", "*", ['jenis_posisi' => "Tenaga Kependidikan"]);
    
    $kategori_unsur = $db->select("tbl_unsur", "*");
    // cek dulu, datanya ketemu atau tidak. Kalau gk ketemu, ya redirect ke halaman awal
    if(empty($detail)){
      header("Location: $alamat_web/unsur-kegiatan");
    }
  }else{
    header("Location: $alamat_web/unsur-kegiatan");
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
  <?php include "../template/menu.php"; ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Unsur Kegiatan</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/unsur-kegiatan/proses_edit.php" enctype="multipart/form-data">
              <input class="form-control"  type="hidden" name="id_sub_unsur" value="<?=$detail['id_sub_unsur']?>" />
              <div class="form-group">
                <label class="form-label">Nama Unsur Kegiatan</label>
                <input class="form-control"  type="text" name="nm_unsur" required />
              </div>
              <div class="form-group">
                <label class="form-label">Posisi Unsur Kegiatan</label>
                <select class="form-control custom-select"  name="id_posisi" required>
                  <?php foreach($posisi as $d): ?>
                    <option value="<?=$d['id_posisi']?>"><?=$d['nm_posisi']?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Jenis Unsur Kegiatan</label>
                <select class="form-control custom-select"  name="jenis_unsur" required>
                  <option value="Unsur Utama">Unsur Utama</option>
                  <option value="Unsur Penunjang">Unsur Penunjang</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Kategori Unsur Kegiatan</label>
                <select class="form-control custom-select"  name="kategori_unsur" required>
                  <?php foreach($kategori_unsur as $d): ?>
                    <option value="<?=$d['nm_unsur']?>"><?=$d['nm_unsur']?></option>
                  <?php endforeach; ?>
                </select>
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
    document.getElementsByName("nm_unsur")[0].value = "<?=$detail['nm_unsur']?>";
    document.getElementsByName("id_posisi")[0].value = "<?=$detail['id_posisi']?>";
    document.getElementsByName("jenis_unsur")[0].value = "<?=$detail['jenis_unsur']?>";
    document.getElementsByName("kategori_unsur")[0].value = "<?=$detail['kategori_unsur']?>";
  </script>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
