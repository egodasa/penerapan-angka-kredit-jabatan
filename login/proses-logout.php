<?
  session_start();
  require('../pengaturan/helper.php');
  if(isset($_SESSION['username'])){
    session_destroy();
  }
  header("Location: $alamat_web/login");
?>
