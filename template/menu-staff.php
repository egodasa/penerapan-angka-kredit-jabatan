<header class="main-header">
    <a href="../../index2.html" class="logo">
      <span class="logo-mini"><b><?=$_SESSION['nip']?></b></span>
      <span class="logo-lg"><b><?=$_SESSION['nip']?></b></span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="logo-lg"><b>SISTEM PENILAIAN ANGKA KREDIT TENAGA KEPENDIDIKAN FUNGSIONAL UNIVERSITAS ANDALAS</b></span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href='<?=$alamat_web?>/login/proses-logout.php'>Logout</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar" style="height: auto;">
      <div class="user-panel">
        <div style="text-align: center;margin: 0 auto;">
          <a><img src="<?=$alamat_web?>/assets/img/foto/<?=$_SESSION['foto']?>" class="img-circle" alt="User Image" width="100" height="125" /></a><br/>
          <a><?=$_SESSION['nm_lengkap']?></a><br/>
        </div>
      </div>
      <ul class="sidebar-menu tree" data-widget="tree">
        <li class="header">MENU</li>
        <?php
          if($_SESSION['is_atasan'] != "1"):
        ?>
          <li>
            <a href="<?=$alamat_web?>/unit-kerja">
              <i class="fa fa-list-alt"></i> <span>Data Unit Kerja</span>
            </a>
          </li>
          <li>
            <a href="<?=$alamat_web?>/posisi">
              <i class="fa fa-list-alt"></i> <span>Data Posisi</span>
            </a>
          </li>
          <li>
            <a href="<?=$alamat_web?>/unsur">
              <i class="fa fa-list-alt"></i> <span>Data Unsur</span>
            </a>
          </li>
          <li>
            <a href="<?=$alamat_web?>/unsur-kegiatan">
              <i class="fa fa-list-alt"></i> <span>Data Sub Unsur</span>
            </a>
          </li>
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
            <a href="<?=$alamat_web?>/jenis-berkas">
              <i class="fa fa-list-ol"></i> <span>Data Jenis Berkas</span>
            </a>
          </li>
          <li>
            <a href="<?=$alamat_web?>/usulan">
              <i class="fa fa-list-ol"></i> <span>Daftar Usulan</span>
            </a>
          </li>
          <li>
            <a href="<?=$alamat_web?>/evaluasi/tabel.php">
              <i class="fa fa-list-ol"></i> <span>Evaluasi (tabel)</span>
            </a>
          </li>
        <?php
          else:
        ?>
          <li>
            <a href="<?=$alamat_web?>/usulan">
              <i class="fa fa-list-ol"></i> <span>Daftar Usulan</span>
            </a>
          </li>
        <?php
          endif;
        ?>
      </ul>
    </section>
  </aside>
