<?
  session_start();
  require('../pengaturan/helper.php');
  cekIzinAksesHalaman(null, $alamat_web, true);
  $judul_halaman = "Login Pengguna";
?>
<html>
<head>
  <?php
    include("../template/head.php");
  ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?=$alamat_web?>"><?=$nama_perusahaan?></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body table-responsive ">
  <?php if(isset($_GET['status'])): ?>
  <?php if($_GET['status'] == 'gagal'): ?>
  <div>
    <p class="alert alert-danger">NIP atau password salah!</p> 
  </div>
  <?php endif; ?>
<?php endif; ?>
    <p class="login-box-msg">Login untuk menggunakan aplikasi</p>
    <form action="<?=$alamat_web?>/login/proses-login.php" method="POST">
      <div class="form-group">
        <label class="form-label">NIP</label>
        <input class="form-control" type="text" name="nip" />
      </div>
      <div class="form-group">
        <label class="form-label">Password</label>
        <input class="form-control" type="password" name="password" />
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-flat  btn btn-primary btn btn-flat">Login</button>
        <button type="reset" class="btn btn-flat  btn btn-danger btn btn-flat">Reset</button>
      </div>
    </form>
  </div>
  <?php include("../template/script.php"); ?>
</body>
</html>
