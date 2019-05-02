<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  
  $judul_halaman = "Tambah Butir Kegiatan";
  $pelaksana = $db->select("tbl_pangkat", "*", ["id_jabatan" => $_SESSION['current_jabatan']['id_jabatan']]);
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
    <?php
      include("breadcrumb.php");
    ?>
    <section class="content">
      <div class="box">
        <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/butir-kegiatan/proses_tambah.php">
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
              <div class="checkbox">
                  <label>
                    <div class="row">
                      <?php
                        if(count($pelaksana) == 0):
                      ?>
                        <div class="col-xs-12">
                          <b>Tidak Ada Pangkat/Golongan Untuk Jabatan <?=$_SESSION['current_posisi']['nm_posisi']?>, Tingkat Jabatan <?=$_SESSION['current_jabatan']['nm_jabatan']?></b>
                        </div>
                      <?
                        else:
                      ?>
                        <div class="col-xs-12">
                          <input type="checkbox" name="semua_pangkat" onclick="centangSemuaPangkat()"> Semua Pangkat/Golongan
                        </div>
                      <?php
                          foreach($pelaksana as $d):
                      ?>
                          <div class="col-xs-12">
                            <input type="checkbox" name="id_pangkat[]" value="<?=$d['id_pangkat']?>" onclick="centangSatuPangkat()"> <?=$d['nm_pangkat']?>
                          </div>
                      <?php
                          endforeach;
                        endif;
                      ?>
                    </div>
                  </label>
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
    function centangSemuaPangkat()
    {
      var id_pangkat = document.getElementsByName("id_pangkat[]");
      var banyak_pangkat = id_pangkat.length;
      var semua_pangkat = document.getElementsByName("semua_pangkat")[0];
      
        for(var x = 0; x < banyak_pangkat; x++)
        {
          if(semua_pangkat.checked)
          {
            id_pangkat[x].checked = true;
            id_pangkat[x].readonly = true;
          }
          else
          {
            id_pangkat[x].readonly = false;
            id_pangkat[x].checked = false;
          }
        }
    }
    function centangSatuPangkat()
    {
      document.getElementsByName("semua_pangkat")[0].checked = false;
    }
  </script>
  <?php include "../template/footer.php"; ?>
  <?php include("../template/script.php"); ?>
</div>
</body>
</html>
