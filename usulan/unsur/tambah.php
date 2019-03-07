<?php
  session_start();
  require("../../vendor/autoload.php");
  require("../../pengaturan/helper.php");
  require("../../pengaturan/medoo.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Tambah Data Unsur";
  $unsur = $db->select("tbl_sub_unsur", "*", ["id_posisi" => $_SESSION['id_posisi']]); 
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
          <h3 class="box-title">Tambah Data Unsur Kegiatan</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/usulan/unsur/proses_tambah.php" enctype="multipart/form-data">
            <input type="hidden" name="id_usulan" value="<?=$_GET['id_usulan']?>" />
            <div class="form-group">
              <label class="form-label">Unsur</label>
              <select class="form-control custom-select"  name="id_sub_unsur" required>
                <option selected disabled>-- Pilih Unsur --</option>
                <?php foreach($unsur as $d): ?>
                  <option value="<?=$d['id_sub_unsur']?>"><?=$d['nm_unsur']." - ".$d['kategori_unsur']." - ".$d['jenis_unsur']?></option>
                <?php endforeach; ?>
              </select>
            </div>
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label class="form-label">Tanggal Mulai Kegiatan</label>
                    <input class="form-control"  type="text" name="tgl_mulai_kegiatan" id="tgl_mulai_kegiatan" required />
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                  <label class="form-label">Tanggal Selesai Kegiatan</label>
                  <input class="form-control"  type="text" name="tgl_selesai_kegiatan" id="tgl_selesai_kegiatan" required />
                </div>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Tingkat Kesulitan</label>
                <input class="form-control"  type="text" name="tingkat_kesulitan" required />
              </div>
              <div class="form-group">
                <label class="form-label">Uraian Kegiatan</label>
                <input class="form-control"  type="text" name="butir_kegiatan" required />
              </div>
              <div class="form-group">
                <label class="form-label">Bukti Kegiatan</label>
                <input class="form-control" type="file" name="bukti_kegiatan" required />
              </div>
              <div class="form-group">
                <label class="form-label">Satuan</label>
                <input class="form-control"  type="text" name="satuan" required />
              </div>
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label class="form-label">Angka Kredit Murni</label>
                    <input class="form-control"  type="text" name="angka_kredit_murni" onkeyup="hitungKredit()" required />
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label class="form-label">Angka Kredit Persentase</label>
                    <input class="form-control"  type="text" name="angka_kredit_persentase" onkeyup="hitungKredit()" required />
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Tempat</label>
                <input class="form-control"  type="text" name="tempat" required />
              </div>
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                  <label class="form-label">Jumlah Volume Kegiatan</label>
                  <input class="form-control"  type="text" name="jumlah_volume_kegiatan" onkeyup="hitungKredit()" required />
                </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                  <label class="form-label">Total Kredit</label>
                  <input class="form-control"  type="text" name="angka_kredit" required />
                </div>
                </div>
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
  <script>
    function hitungKredit(){
      var persentase = document.getElementsByName("angka_kredit_persentase")[0].value/100 || 0;
      var murni = document.getElementsByName("angka_kredit_murni")[0].value || 0;
      var volume = document.getElementsByName("jumlah_volume_kegiatan")[0].value || 0;
      document.getElementsByName("angka_kredit")[0].value = volume * (persentase * murni);
    }
    var tgl_mulai_kegiatan = new Pikaday({
      field: document.getElementById('tgl_mulai_kegiatan'),
      format: 'YYYY-MM-DD',
    });
    var tgl_selesai_kegiatan = new Pikaday({
      field: document.getElementById('tgl_selesai_kegiatan'),
      format: 'YYYY-MM-DD',
    });
  </script>
</div>
</body>
</html>
