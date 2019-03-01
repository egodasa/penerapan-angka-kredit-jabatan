<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require("../pengaturan/medoo.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Penilaian Data Usulan";
?>

<html>
<head>
  <?php
    include("../template/head.php");
  ?>
</head>
<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">
  
  <?php include "../template/menu.php"; 
  ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Penilaian Data Usulan</h3>
        </div>
        <div class="box-body table-responsive">
          <form action="proses_edit.php" method="POST">
            <input type="hidden" name="jenis_usulan" value="penilaian" />
            <input type="hidden" name="id_usulan" value="<?=$_GET['id_usulan']?>" />
            <div class="form-group">
              <label class="form-label">Hasil Penilaian</label>
              <select class="form-control custom-select" name="status_proses" required>
                <option selected disabled>-- Pilih Hasil Penilaian --</option>
                <option value="Angka Kredit Diterima">Angka Kredit Diterima</option>
                <option value="Angka Kredit Ditolak">Angka Kredit Ditolak</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Keterangan</label>
              <small><br/>*Keterangan jika angka kredit tidak diterima.</small>
              <textarea name="keterangan" class="form-control"></textarea>
            </div>
            <div class="form-group">
              <label class="form-label">Tanggal Pengesahan</label>
              <input class="form-control"  type="text" name="tgl_pengesahan" id="tgl_pengesahan" readonly required />
            </div>
            <div class="form-group">
              <label class="form-label">Tanggal Penyesuaian</label>
              <input class="form-control"  type="text" name="tgl_penyesuaian" id="tgl_penyesuaian" readonly required />
            </div>
            <button type="submit" class="btn btn-primary">Kirim Sekarang</button>
          </form>
        </div>
      </div>
    </section>
  </div>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
  <script>
    var tgl_pengesahan = new Pikaday({
      field: document.getElementById('tgl_pengesahan'),
      format: 'YYYY-MM-DD',
    });
    var tgl_penyesuaian = new Pikaday({
      field: document.getElementById('tgl_penyesuaian'),
      format: 'YYYY-MM-DD',
    });
  </script>
</div>
</body>
</html>
