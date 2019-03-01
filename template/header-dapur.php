<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="../../index2.html" class="navbar-brand"><b>
                        <?=$nama_perusahaan?></b></a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            </div>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <?php if($_SESSION['jk'] == "Laki-laki"): ?>
                            <img src="<?=$alamat_web?>/assets/img/laki.png" class="user-image" alt="User Image">
                            <?php else: ?>
                            <img src="<?=$alamat_web?>/assets/img/perempuan.png" class="user-image" alt="User Image">
                            <?php endif; ?>
                            <span class="hidden-xs">
                                <?=isset($_SESSION['username']) ? $_SESSION['username'] : "Anda belum login"?></span>
                        </a>
                        <ul class="dropdown-menu">

                            <li class="user-header">
                                <?php if($_SESSION['jk'] == "Laki-laki"): ?>
                                <img src="<?=$alamat_web?>/assets/img/laki.png" class="img-circle" alt="User Image">
                                <?php else: ?>
                                <img src="<?=$alamat_web?>/assets/img/perempuan.png" class="img-circle" alt="User Image">
                                <?php endif; ?>
                                <p>
                                    <?=isset($_SESSION['username']) ? $_SESSION['username'] : "Anda belum login"?>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="<?=$alamat_web?>/login/proses-logout.php" class="btn btn-default btn-flat">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->

                </ul>
            </div>
        </div>
    </nav>
</header>