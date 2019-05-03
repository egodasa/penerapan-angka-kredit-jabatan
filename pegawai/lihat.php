<?php
  session_start();
  require_once("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require_once("../pengaturan/medoo.php");
  
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Profil Pegawai";
  $detail = $db->query("SELECT a.*,
                           b.id_pangkat,
                           b.nm_pangkat,
                           c.id_jabatan,
                           c.nm_jabatan,
                           e.nm_unit_kerja,
                           d.id_posisi,
                           d.nm_posisi 
                    FROM   tbl_pegawai a
                           LEFT JOIN tbl_pangkat b
                                  ON a.id_pangkat = b.id_pangkat
                           LEFT JOIN tbl_jabatan c
                                  ON b.id_jabatan = c.id_jabatan
                           LEFT JOIN tbl_posisi d
                                  ON c.id_posisi = d.id_posisi 
                    LEFT JOIN tbl_unit_kerja e ON a.id_unit_kerja = e.id_unit_kerja WHERE a.id_pegawai = :id_pegawai", ["id_pegawai" => $_SESSION['id_pegawai']])->fetch(); 
  $jabatan = $db->select("tbl_posisi", "*");
  $unit_kerja = $db->select("tbl_unit_kerja", "*");
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
          <h3 class="box-title">Profil Pegawai</h3>
        </div>
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/pegawai/proses_edit.php" enctype="multipart/form-data">
              <input class="form-control"  type="hidden" name="id_pegawai" value="<?=$detail['id_pegawai']?>" />
              <div class="form-group">
                <label class="form-label">NIP</label>
                <input class="form-control"  type="text" name="nip" required />
              </div>
              <div class="form-group">
                <label class="form-label">Password</label>
                <input class="form-control"  type="password" name="password" required />
              </div>
              <div class="form-group">
                <label class="form-label">No Seri KARPEG</label>
                <input class="form-control"  type="text" name="no_karpeg" required />
              </div>
              <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input class="form-control"  type="text" name="nm_lengkap" required />
              </div>
              <div class="form-group">
                <label class="form-label">Jenis Kelamin</label>
                <select class="form-control custom-select"  name="jk" required>
                  <option selected disabled>-- Pilih Jenis Kelamin --</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Tempat Lahir</label>
                <input class="form-control"  type="text" name="tempat_lahir" required />
              </div>
              <div class="form-group">
                <label class="form-label">Tanggal Lahir</label>
                <input class="form-control"  type="text" name="tgl_lahir" required />
              </div>
              <div class="form-group">
                <label class="form-label">Nomor HP</label>
                <input class="form-control"  type="text" name="nohp" required />
              </div>
              <div class="form-group">
                <label class="form-label">Email</label>
                <input class="form-control"  type="text" name="email" required />
              </div>
              <input type="hidden" name="foto_lama" value="<?=$detail['foto']?>" />
              <div class="form-group">
                <label class="form-label">Foto</label>
                <small>
                  <br/>
                  <?php
                    if(empty($detail['foto']))
                    {
                      echo "Belum ada foto";
                    }
                    else
                    {
                      echo "<img src='".$alamat_web."/assets/img/foto/".$detail['foto']."' width='100' height='200' /> <br/> Silahkan upload foto baru untuk mengganti foto.";
                    }
                  ?>
                </small>
                <input class="form-control"  type="file" name="foto" />
              </div>
              <div class="form-group">
                <label class="form-label">Pendidikan</label>
                <select class="form-control custom-select"  name="pendidikan" required>
                  <option selected disabled>-- Pilih Pendidikan --</option>
                  <option value="Sarjana (S1)/Diploma IV">Sarjana (S1)/Diploma IV</option>
                  <option value="Magister (S2)">Magister (S2)</option>
                  <option value="Doktor (S3)">Doktor (S3)</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Tanggal Lulus Pendidikan Terakhir</label>
                <input class="form-control"  type="text" name="tgl_lulus" required />
              </div>
              <div class="form-group">
              <label class="form-label">Jabatan</label>
              <select class="form-control custom-select"  name="id_posisi" onchange="getTingkat()">
                <option selected disabled>-- Pilih Jabatan --</option>
                <?php foreach($jabatan as $d): ?>
                  <option value="<?=$d['id_posisi']?>"><?=$d['nm_posisi']?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Tingkat Jabatan</label>
              <select class="form-control custom-select" name="id_jabatan" onchange="getPangkat()">
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Pangkat/Golongan</label>
              <select class="form-control custom-select" name="id_pangkat">
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Pegawai Atasan ?</label>
              <select class="form-control custom-select" name="is_atasan" required>
                <option value="0">Tidak</option>
                <option value="1">Ya</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Unit Kerja</label>
              <select class="form-control custom-select" name="id_unit_kerja">
                <option selected disabled>-- Pilih Unit Kerja --</option>
                <?php foreach($unit_kerja as $d): ?>
                  <option value="<?=$d['id_unit_kerja']?>"><?=$d['nm_unit_kerja']?></option>
                <?php endforeach; ?>
              </select>
            </div>
              <div class="form-group">
                <label class="form-label">TMT Jabatan</label>
                <input class="form-control"  type="text" name="tmt_jabatan" required />
              </div>
              <div class="form-group">
                <label class="form-label">Kredit Awal Unsur Utama</label>
                <input class="form-control"  type="text" name="kredit_awal_utama" required />
              </div>
              <div class="form-group">
                <label class="form-label">Kredit Awal Unsur Penunjang</label>
                <input class="form-control"  type="text" name="kredit_awal_penunjang" required />
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
  <script src="<?=$alamat_web?>/assets/js/axios.min.js"></script>
  <script>
    function getPangkat(){
      axios.get('get-pangkat.php?id_jabatan=' + document.getElementsByName("id_jabatan")[0].value)
        .then(function(res){
          document.getElementsByName("id_pangkat")[0].innerHTML = "";
          var data = res.data;
          var pangkat = "";
          for(var x = 0; x < data.length; x++){
            pangkat += "<option value='" + data[x].id_pangkat + "'>" + data[x].nm_pangkat + "</option>";
          }
          document.getElementsByName("id_pangkat")[0].innerHTML = pangkat;
        })
    }
    
    document.getElementsByName("nip")[0].value = "<?=$detail['nip']?>";
    document.getElementsByName("no_karpeg")[0].value = "<?=$detail['no_karpeg']?>";
    document.getElementsByName("nm_lengkap")[0].value = "<?=$detail['nm_lengkap']?>";
    document.getElementsByName("jk")[0].value = "<?=$detail['jk']?>";
    document.getElementsByName("tempat_lahir")[0].value = "<?=$detail['tempat_lahir']?>";
    document.getElementsByName("tgl_lahir")[0].value = "<?=$detail['tgl_lahir']?>";
    document.getElementsByName("nohp")[0].value = "<?=$detail['nohp']?>";
    document.getElementsByName("email")[0].value = "<?=$detail['email']?>";
    document.getElementsByName("pendidikan")[0].value = "<?=$detail['pendidikan']?>";
    document.getElementsByName("id_posisi")[0].value = "<?=$detail['id_posisi']?>";
    document.getElementsByName("is_atasan")[0].value = "<?=$detail['is_atasan']?>";
    document.getElementsByName("id_unit_kerja")[0].value = "<?=$detail['id_unit_kerja']?>";
    document.getElementsByName("kredit_awal_utama")[0].value = "<?=$detail['kredit_awal_utama']?>";
    document.getElementsByName("kredit_awal_penunjang")[0].value = "<?=$detail['kredit_awal_penunjang']?>";
    document.getElementsByName("tmt_jabatan")[0].value = "<?=$detail['tmt_jabatan']?>";
    document.getElementsByName("tgl_lulus")[0].value = "<?=$detail['tgl_lulus']?>";
    
    function getTingkat(){
      axios.get('<?=$alamat_web?>/jabatan/api-get-jabatan.php?id_posisi=' + document.getElementsByName("id_posisi")[0].value)
        .then(function(res){
          document.getElementsByName("id_jabatan")[0].innerHTML = "";
          document.getElementsByName("id_pangkat")[0].innerHTML = "";
          var data = res.data;
          var pangkat = "<option value=''>-- Pilih Tingkat Jabatan--</option>";
          for(var x = 0; x < data.length; x++){
            pangkat += "<option value='" + data[x].id_jabatan + "'>" + data[x].nm_jabatan + "</option>";
          }
          document.getElementsByName("id_jabatan")[0].innerHTML = pangkat;
        })
    }
    function getPangkat(){
      axios.get('<?=$alamat_web?>/pangkat/api-get-pangkat.php?id_jabatan=' + document.getElementsByName("id_jabatan")[0].value)
        .then(function(res){
          document.getElementsByName("id_pangkat")[0].innerHTML = "";
          var data = res.data;
          var pangkat = "<option value=''>-- Pilih Pangkat--</option>";
          for(var x = 0; x < data.length; x++){
            pangkat += "<option value='" + data[x].id_pangkat + "'>" + data[x].nm_pangkat + "</option>";
          }
          document.getElementsByName("id_pangkat")[0].innerHTML = pangkat;
        })
    }
    
    document.getElementsByName("id_jabatan")[0].addEventListener("change", function(){
      getPangkat();
    })
    
  </script>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
  <script>
    var tgl_lulus = new Pikaday({
      field: document.getElementsByName('tgl_lulus')[0],
      format: 'YYYY-MM-DD',
    });
    var tgl_lahir = new Pikaday({
      field: document.getElementsByName('tgl_lahir')[0],
      format: 'YYYY-MM-DD',
      minDate: new Date('1940-01-01')
    });
    var tmt_jabatan = new Pikaday({
      field: document.getElementsByName('tmt_jabatan')[0],
      format: 'YYYY-MM-DD',
    });
    
    
    // Ambil jabatan
    axios.get('<?=$alamat_web?>/jabatan/api-get-jabatan.php?id_posisi=<?=$detail["id_posisi"]?>')
      .then(function(res){
        document.getElementsByName("id_jabatan")[0].innerHTML = "";
        document.getElementsByName("id_pangkat")[0].innerHTML = "";
        var data = res.data;
        var pangkat = "<option value=''>-- Pilih Tingkat Jabatan--</option>";
        for(var x = 0; x < data.length; x++){
          pangkat += "<option value='" + data[x].id_jabatan + "'>" + data[x].nm_jabatan + "</option>";
        }
        document.getElementsByName("id_jabatan")[0].innerHTML = pangkat;
        document.getElementsByName("id_jabatan")[0].value = "<?=$detail['id_jabatan']?>";
        
        // Ambil tingkat jabatan 
        return axios.get('<?=$alamat_web?>/pangkat/api-get-pangkat.php?id_jabatan=<?=$detail["id_jabatan"]?>')
      })
      .then(function(res){
        document.getElementsByName("id_pangkat")[0].innerHTML = "";
        var data = res.data;
        var pangkat = "<option value=''>-- Pilih Pangkat--</option>";
        for(var x = 0; x < data.length; x++){
          pangkat += "<option value='" + data[x].id_pangkat + "'>" + data[x].nm_pangkat + "</option>";
        }
        document.getElementsByName("id_pangkat")[0].innerHTML = pangkat;
        document.getElementsByName("id_pangkat")[0].value = "<?=$detail['id_pangkat']?>";
      })
  </script>
</div>
</body>
</html>
