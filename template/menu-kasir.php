<header class="main-header">
    <a href="../../index2.html" class="logo">
      <span class="logo-mini"><b><?=$nama_perusahaan?></b></span>
      <span class="logo-lg"><b><?=$nama_perusahaan?></b></span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar" style="height: auto;">
      <div class="user-panel">
        <div class="pull-left image">=
          <?php if($_SESSION['jk'] == "Laki-laki"): ?>
            <img src="<?=$alamat_web?>/assets/img/laki.png" class="img-circle" alt="User Image">
          <?php else: ?>
            <img src="<?=$alamat_web?>/assets/img/perempuan.png" class="img-circle" alt="User Image">
          <?php endif; ?>
        </div>
        <div class="pull-left info">
          <p>
          <?=isset($_SESSION['username']) ? $_SESSION['username'] : "Anda belum login"?>
          </p>
          <a href='<?=$alamat_web?>/login/proses-logout.php'>Logout</a>
        </div>
      </div>
      <ul class="sidebar-menu tree" data-widget="tree">
        <li class="header">MENU</li>
        <li>
          <a href="<?=$alamat_web?>/pegawai">
            <i class="fa fa-list-alt"></i> <span>Data Pegawai</span>
          </a>
        </li>
        <li>
          <a href="<?=$alamat_web?>/jabatan">
            <i class="fa fa-list"></i> <span>Data Jabatan</span>
          </a>
        </li>
        <li>
          <a href="<?=$alamat_web?>/pangkat">
            <i class="fa fa-toggle-up"></i> <span>Data Pangkat</span>
          </a>
        </li>
        <li>
          <a href="<?=$alamat_web?>/kredit-pangkat">
            <i class="fa fa-list-ol"></i> <span>Data Kredit Pangkat</span>
          </a>
        </li>
        <li>
          <a href="<?=$alamat_web?>/user">
            <i class="fa fa-users"></i> <span>Daftar User</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-paste"></i> <span>Laporan Pemasukan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=$alamat_web?>/laporan/harian.php"><i class="fa fa-circle-o"></i> Harian</a></li>
            <li><a href="<?=$alamat_web?>/laporan/bulanan.php"><i class="fa fa-circle-o"></i> Bulanan</a></li>
            <li><a href="<?=$alamat_web?>/laporan/tahunan.php"><i class="fa fa-circle-o"></i> Tahunan</a></li>
          </ul>
        </li>
      </ul>
    </section>
  </aside>
