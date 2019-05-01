<section class="content-header">
  <h1>
    <?=$judul_halaman?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=$alamat_web?>/posisi"><i class="fa fa-dashboard"></i> Jabatan <?=$_SESSION['current_posisi']['nm_posisi']?></a></li>
    <li><a href="<?=$alamat_web?>/jabatan">Tingkat <?=$_SESSION['current_jabatan']['nm_jabatan']?></a></li>
    <li><a href="<?=$alamat_web?>/unsur">Unsur <?=$_SESSION['current_unsur']['nm_unsur']?></a></li>
    <li><a href="<?=$alamat_web?>/unsur">Sub Unsur <?=$_SESSION['current_sub_unsur']['nm_sub_unsur']?></a></li>
    <li><a class="active" href="./"><?=$judul_halaman?></a></li>
  </ol>
</section>
