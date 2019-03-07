<?php
  session_start();
  require("../../vendor/autoload.php");
  require("../../pengaturan/helper.php");
  require("../../pengaturan/medoo.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit Unsur Kegiatan";
  if(isset($_GET['id_usulan_unsur'])){
    $detail = $db->get("tbl_usulan_unsur", "*", ['id_usulan_unsur' => $_GET['id_usulan_unsur']]);
    $unsur = $db->select("tbl_sub_unsur", "*");
    // cek dulu, datanya ketemu atau tidak. Kalau gk ketemu, ya redirect ke halaman awal
    if(empty($detail)){
      header("Location: $alamat_web/usulan/unsur");
    }
  }else{
    header("Location: $alamat_web/usulan/unsur");
  }
?>
<html>
<head>
  <?php
    include("../../template/head.php");
  ?>
  <link rel="stylesheet" type="text/css" href="<?=$alamat_web?>/assets/css/pikaday.css">
</head>
<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">
  <?php include "../../template/menu.php"; ?>
  <div class="content-wrapper" style="min-height: 901px;">
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Status Angka Kredit</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/usulan/unsur/proses_edit_status_penilaian.php">
              <input name="id_usulan" type="hidden" value="<?=$detail['id_usulan']?>" />
              <input name="id_usulan_unsur" type="hidden" value="<?=$detail['id_usulan_unsur']?>" />
              <input name="bukti_kegiatan_lama" type="hidden" value="<?=$detail['bukti_kegiatan']?>" />
              <div class="form-group">
                <label class="form-label">Unsur</label>
                <select class="form-control custom-select" name="id_sub_unsur" readonly >
                  <option selected disabled>-- Pilih Unsur --</option>
                  <?php foreach($unsur as $d): ?>
                    <option value="<?=$d['id_sub_unsur']?>"><?=$d['nm_unsur']?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label class="form-label">Tanggal Mulai Kegiatan</label>
                    <input class="form-control"  type="text" name="tgl_mulai_kegiatan" id="tgl_mulai_kegiatan" readonly />
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                  <label class="form-label">Tanggal Selesai Kegiatan</label>
                  <input class="form-control"  type="text" name="tgl_selesai_kegiatan" id="tgl_selesai_kegiatan" readonly  />
                </div>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Tingkat Kesulitan</label>
                <input class="form-control"  type="text" name="tingkat_kesulitan" readonly  />
              </div>
              <div class="form-group">
                <label class="form-label">Uraian Kegiatan</label>
                <input class="form-control"  type="text" name="butir_kegiatan" readonly />
              </div>
              <div class="form-group">
                <label class="form-label">Bukti Kegiatan</label>
                <small>
                  <br/>
                  <img src="<?=$alamat_web?>/assets/img/foto/<?=$detail['bukti_kegiatan']?>" width="200" height="200" /> <br/>
                  * Upload bukti baru untuk mengganti bukti kegiatan
                </small>
                <input class="form-control" type="file" name="bukti_kegiatan" readonly />
              </div>
              <div class="form-group">
                <label class="form-label">Satuan</label>
                <input class="form-control"  type="text" name="satuan" readonly  />
              </div>
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label class="form-label">Angka Kredit Murni</label>
                    <input class="form-control" name="angka_kredit_murni" onkeyup="hitungKredit()" readonly />
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label class="form-label">Angka Kredit Persentase</label>
                    <input class="form-control"  name="angka_kredit_persentase" onkeyup="hitungKredit()" readonly />
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Tempat</label>
                <input class="form-control"  type="text" name="tempat" readonly />
              </div>
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                  <label class="form-label">Jumlah Volume Kegiatan</label>
                  <input class="form-control"  type="text" name="jumlah_volume_kegiatan" onkeyup="hitungKredit()" readonly />
                </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label class="form-label">Total Kredit</label>
                    <input class="form-control"  type="text" name="angka_kredit" readonly />
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Status Unsur Kegiatan</label>
                <select name="status" class="form-control">
                  <option value="">-- Pilih Status --</option>
                  <option value="Diterima">Diterima</option>
                  <option value="Ditolak">Ditolak</option>
                </select>
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
  <script src="<?=$alamat_web?>/assets/js/moment.js"></script>
  <script src="<?=$alamat_web?>/assets/js/pikaday.js"></script>
  <script>
    function hitungKredit(){
      var persentase = document.getElementsByName("angka_kredit_persentase")[0].value/100 || 0;
      var murni = document.getElementsByName("angka_kredit_murni")[0].value || 0;
      var volume = document.getElementsByName("jumlah_volume_kegiatan")[0].value || 0;
      document.getElementsByName("angka_kredit")[0].value = volume * (persentase * murni);
    }
    document.getElementsByName("id_sub_unsur")[0].value = "<?=$detail['id_sub_unsur']?>";
    document.getElementsByName("tgl_mulai_kegiatan")[0].value = "<?=$detail['tgl_mulai_kegiatan']?>";
    document.getElementsByName("tgl_selesai_kegiatan")[0].value = "<?=$detail['tgl_selesai_kegiatan']?>";
    document.getElementsByName("tingkat_kesulitan")[0].value = "<?=$detail['tingkat_kesulitan']?>";
    document.getElementsByName("butir_kegiatan")[0].value = "<?=$detail['butir_kegiatan']?>";
    document.getElementsByName("satuan")[0].value = "<?=$detail['satuan']?>";
    document.getElementsByName("tempat")[0].value = "<?=$detail['tempat']?>";
    document.getElementsByName("angka_kredit_murni")[0].value = "<?=$detail['angka_kredit_murni_baru']?>";
    document.getElementsByName("angka_kredit_persentase")[0].value = "<?=$detail['angka_kredit_persentase_baru']?>";
    document.getElementsByName("jumlah_volume_kegiatan")[0].value = "<?=$detail['jumlah_volume_kegiatan']?>";
    document.getElementsByName("angka_kredit")[0].value = "<?=$detail['angka_kredit']?>";
    document.getElementsByName("status")[0].value = "<?=$detail['status']?>";
    hitungKredit();
  </script>
  <?php include "../../template/footer.php"; ?>
  <?php include("../../template/script.php"); ?>
</div>
</body>
</html>
