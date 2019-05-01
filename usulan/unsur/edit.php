<?php
  session_start();
  require("../../vendor/autoload.php");
  require("../../pengaturan/helper.php");
  require("../../pengaturan/medoo.php");
  // cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit Unsur Kegiatan";
  $unsur = $db->select("tbl_sub_unsur", "*", ["id_posisi" => $_SESSION['id_posisi']]); 
  if(isset($_GET['id_usulan_unsur'])){
    $detail = $db->get("tbl_usulan_unsur", "*", ['id_usulan_unsur' => $_GET['id_usulan_unsur']]);
    
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
          <h3 class="box-title">Edit Butir Kegiatan</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/usulan/unsur/proses_edit.php" enctype="multipart/form-data">
              <input name="id_usulan" type="hidden" value="<?=$detail['id_usulan']?>" />
              <input name="id_usulan_unsur" type="hidden" value="<?=$detail['id_usulan_unsur']?>" />
              <input name="bukti_kegiatan_lama" type="hidden" value="<?=$detail['bukti_kegiatan']?>" />
               <div class="form-group">
              <label class="form-label">Unsur</label>
              <select class="form-control custom-select" name="id_sub_unsur" onchange="getButirKegiatan()" required>
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
                <label class="form-label">Butir Kegiatan</label>
                <select class="form-control custom-select"  name="butir_kegiatan" onchange="detailButirKegiatan()" required>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Bukti Kegiatan</label>
                <input class="form-control" type="file" name="bukti_kegiatan" required />
              </div>
              <div class="form-group">
                <label class="form-label">Satuan</label>
                <input class="form-control"  type="text" name="satuan" readonly required />
              </div>
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label class="form-label">Angka Kredit Murni</label>
                    <input class="form-control"  type="text" name="angka_kredit_murni" onchange="detailButirKegiatan()" readonly />
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
  <script src="<?=$alamat_web?>/assets/js/moment.js"></script>
  <script src="<?=$alamat_web?>/assets/js/pikaday.js"></script>
  <script src="<?=$alamat_web?>/assets/js/axios.min.js"></script>
  <script>
    var butir_kegiatan = [];
    function hitungKredit(){
      var persentase = document.getElementsByName("angka_kredit_persentase")[0].value/100 || 0;
      var murni = document.getElementsByName("angka_kredit_murni")[0].value || 0;
      var volume = document.getElementsByName("jumlah_volume_kegiatan")[0].value || 0;
      document.getElementsByName("angka_kredit")[0].value = volume * (persentase * murni);
    }
    function getButirKegiatan()
    {
      var id_sub_unsur = document.getElementsByName("id_sub_unsur")[0].value;
      document.getElementsByName("satuan")[0].value = "";
      document.getElementsByName("angka_kredit_murni")[0].value = "";
      document.getElementsByName("butir_kegiatan")[0].innerHTML = "";
      axios.get('api-get-butir-kegiatan.php?id_sub_unsur=' + id_sub_unsur)
        .then(function(res){
          var hasil = res.data;
          if(hasil.length != 0)
          {
            var html_butir_kegiatan = "<option value='' selected disabled>-- Pilih Butir Kegiatan --</option>";
            butir_kegiatan = hasil;
            for(var x = 0; x < hasil.length; x++)
            {
              html_butir_kegiatan += "<option value='" + butir_kegiatan[x].butir_kegiatan + "'>" + butir_kegiatan[x].butir_kegiatan + "</option>"
            }
            document.getElementsByName("butir_kegiatan")[0].innerHTML = html_butir_kegiatan;
          }
        })
    }
    function detailButirKegiatan()
    {
      var index = document.getElementsByName("butir_kegiatan")[0].selectedIndex;
      index--;
      document.getElementsByName("satuan")[0].value = butir_kegiatan[index].satuan;
      document.getElementsByName("angka_kredit_murni")[0].value = butir_kegiatan[index].angka_kredit;
      hitungKredit();
    }
    var tgl_mulai_kegiatan = new Pikaday({
      field: document.getElementById('tgl_mulai_kegiatan'),
      format: 'YYYY-MM-DD',
    });
    var tgl_selesai_kegiatan = new Pikaday({
      field: document.getElementById('tgl_selesai_kegiatan'),
      format: 'YYYY-MM-DD',
    });
    document.getElementsByName("id_sub_unsur")[0].value = "<?=$detail['id_sub_unsur']?>";
    document.getElementsByName("tgl_mulai_kegiatan")[0].value = "<?=$detail['tgl_mulai_kegiatan']?>";
    document.getElementsByName("tgl_selesai_kegiatan")[0].value = "<?=$detail['tgl_selesai_kegiatan']?>";
    document.getElementsByName("tingkat_kesulitan")[0].value = "<?=$detail['tingkat_kesulitan']?>";
    document.getElementsByName("satuan")[0].value = "<?=$detail['satuan']?>";
    document.getElementsByName("tempat")[0].value = "<?=$detail['tempat']?>";
    document.getElementsByName("jumlah_volume_kegiatan")[0].value = "<?=$detail['jumlah_volume_kegiatan']?>";
    document.getElementsByName("angka_kredit_murni")[0].value = "<?=$detail['angka_kredit_murni']?>";
    document.getElementsByName("angka_kredit_persentase")[0].value = "<?=$detail['angka_kredit_persentase']?>";
    
    // Jalankan kode getButirKegiatan diluar agar nilai butir kegiatan bisa diselect sesuai yang sudah ada
    // Karena ini halaman edit, bukan halaman tambah
    var id_sub_unsur = document.getElementsByName("id_sub_unsur")[0].value;
    document.getElementsByName("butir_kegiatan")[0].innerHTML = "";
    axios.get('api-get-butir-kegiatan.php?id_sub_unsur=' + id_sub_unsur)
      .then(function(res){
        var hasil = res.data;
        if(hasil.length != 0)
        {
          var html_butir_kegiatan = "<option value='' selected disabled>-- Pilih Butir Kegiatan --</option>";
          butir_kegiatan = hasil;
          for(var x = 0; x < hasil.length; x++)
          {
            html_butir_kegiatan += "<option value='" + butir_kegiatan[x].butir_kegiatan + "'>" + butir_kegiatan[x].butir_kegiatan + "</option>"
          }
          document.getElementsByName("butir_kegiatan")[0].innerHTML = html_butir_kegiatan;
          
          document.getElementsByName("butir_kegiatan")[0].value = "<?=$detail['butir_kegiatan']?>";
        }
      })
    hitungKredit();
  </script>
  <?php include "../../template/footer.php"; ?>
  <?php include("../../template/script.php"); ?>
</div>
</body>
</html>
