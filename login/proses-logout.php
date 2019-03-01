<?
  session_start();
  require('../pengaturan/helper.php');
  if(isset($_SESSION['username'])){
    unset($_SESSION['username']);
    unset($_SESSION['level']);
  }
  header("Location: $alamat_web/login");
?>
