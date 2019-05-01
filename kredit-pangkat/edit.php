<?php
  session_start();
  require("../pengaturan/helper.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit pangkat";
  if(isset($_GET['id_jabatan_pangkat'])){
    require_once("../pengaturan/database.php");
    $query = $db->prepare("SELECT * FROM tbl_jabatan_pangkat WHERE id_jabatan_pangkat = ? LIMIT 1"); 
    $query->bindParam(1, $_GET['id_jabatan_pangkat']);
    $query->execute();
    $detail = $query->fetch();
    
    $query = $db->query("SELECT * FROM tbl_jabatan");
    $query->execute();
    $jabatan = $query->fetchAll(PDO::FETCH_ASSOC);
    
    
    $query = $db->query("SELECT * FROM tbl_pangkat");
    $query->execute();
    $pangkat = $query->fetchAll(PDO::FETCH_ASSOC);
    
    // cek dulu, datanya ketemu atau tidak. Kalau gk ketemu, ya redirect ke halaman awal
    if(empty($detail)){
      header("Location: $alamat_web/kredit-pangkat");
    }
  }else{
    header("Location: $alamat_web/kredit-pangkat");
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
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Nilai Kredit Pangkat</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/kredit-pangkat/proses_edit.php">
            <input type="hidden" value="<?=$detail['id_jabatan_pangkat']?>" name="id_jabatan_pangkat">
              <div class="form-group">
                <label class="form-label">Jabatan</label>
                <select class="form-control custom-select"  name="id_jabatan" disabled>
                  <option selected disabled>-- Pilih Jabatan --</option>
                  <?php foreach($jabatan as $d): ?>
                    <option value="<?=$d['id_jabatan']?>"><?=$d['nm_jabatan']?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Pangkat</label>
                <select class="form-control custom-select"  name="id_pangkat" disabled>
                  <option selected disabled>-- Pilih Pangkat --</option>
                  <?php foreach($pangkat as $d): ?>
                    <option value="<?=$d['id_pangkat']?>"><?=$d['nm_pangkat']?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label" >Besar Nilai Kredit</label>
                <input class="form-control"  type="number" name="nilai_kredit" value="<?=$detail['nilai_kredit']?>" required />
              </div>
              <div class="form-group">
                <label class="form-label" >Peringkat</label>
                <small><br/>*Angka kecil = kedudukan jabatan/pangkat rendah</small>
                <input class="form-control"  type="number" name="peringkat" value="<?=$detail['peringkat']?>" required />
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
  <script>
    document.getElementsByName("id_jabatan")[0].value = "<?=$detail['id_jabatan']?>";
    document.getElementsByName("id_pangkat")[0].value = "<?=$detail['id_pangkat']?>";
  </script>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
