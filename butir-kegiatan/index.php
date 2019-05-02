<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/medoo.php");
  require("../pengaturan/helper.php");
  
  if(isset($_GET['id_sub_unsur']))
  {
    $_SESSION['current_sub_unsur'] = $db->get("tbl_sub_unsur", "*", ["id_sub_unsur" => $_GET['id_sub_unsur']]);
  }
  
  $judul_halaman = "Daftar Butir Kegiatan";
  $data = $db->select("tbl_butir_kegiatan", "*", ["id_sub_unsur" => $_SESSION['current_sub_unsur']['id_sub_unsur']]);
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
            <a href="<?=$alamat_web?>/sub-unsur" class="btn btn-flat btn-primary">Kembali Ke Daftar Sub Unsur</a>
            <a href="<?=$alamat_web?>/butir-kegiatan/tambah.php" class="btn btn-flat btn-success">Tambah Data</a>
            <table id="tabel" class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Butir Kegiatan</th>
                  <th>Satuan</th>
                  <th>Angka Kredit</th>
                  <th>Pelaksana</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
$no = 1;
if(count($data) > 0){
  foreach($data as $d){
?>
                <tr>
                  <td>
                    <?=$no?>
                  </td>
                  <td>
                    <?=$d['butir_kegiatan']?>
                  </td>
                  <td>
                    <?=$d['satuan']?>
                  </td>
                  <td>
                    <?=$d['angka_kredit']?>
                  </td>
                  <td>
                    <?php
                      // Mengambil data pelaksana butir kegiatan
                      $pelaksana = $db->query("SELECT b.nm_pangkat FROM tbl_pelaksana_butir_kegiatan a JOIN tbl_pangkat b ON a.id_pangkat = b.id_pangkat WHERE a.id_butir = :id_butir", ["id_butir" => $d['id_butir']])->fetchAll(PDO::FETCH_ASSOC);
                      echo "<ol>";
                      foreach($pelaksana as $data_pelaksana)
                      {
                        echo "<li>".$data_pelaksana['nm_pangkat']."</li>";
                      }
                      echo "</ol>";
                    ?>
                  </td>
                  <td>
                    <a href="<?=$alamat_web?>/butir-kegiatan/proses_hapus.php?id_butir=<?=$d['id_butir']?>" class="btn btn-flat btn-danger">Hapus</a>
                    <a href="<?=$alamat_web?>/butir-kegiatan/edit.php?id_butir=<?=$d['id_butir']?>" class="btn btn-flat btn-primary">Edit</a>
                  </td>
                </tr>
                <?php 
  $no++;
  }
}
else
{
?>
                <tr>
                  <td colspan=6 class="text-center">Tidak ada data yang ditampilkan!</td>
                </tr>
                <?php
}
?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
    <?php include("../template/footer.php"); ?>
  </div>
  <?php include("../template/script.php"); ?>
</body>
</html>
