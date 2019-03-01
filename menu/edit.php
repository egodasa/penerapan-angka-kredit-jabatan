<?php
  session_start();
  require("../pengaturan/helper.php");
  cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Edit Menu";
  if(isset($_GET['id_menu'])){
    require_once("../pengaturan/database.php");
    // ambil detail menu
    $query1 = $db->prepare("SELECT * FROM tbl_menu WHERE id_menu = ? LIMIT 1"); 
    $query1->bindParam(1, $_GET['id_menu']);
    $query1->execute();
    $detail = $query1->fetch();
    
    // Ambil daftar kategori
    $query2 = $db->prepare("SELECT * FROM tbl_kategori"); 
    $query2->execute();
    $kategori = $query2->fetchAll(PDO::FETCH_ASSOC);
    
    // cek dulu, datanya ketemu atau tidak. Kalau gk ketemu, ya redirect ke halaman awal
    if(empty($detail)){
      header('Location: $alamat_web/menu');
    }
  }else{
    header('Location: $alamat_web/menu');
  }
?>
<html>

<head>
  <?php
    include("../template/head.php");
  ?>
</head>

<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
  <div class="wrapper" style="height: auto; min-height: 100%;">
    <?php include "../template/menu-kasir.php"; ?>
    <div class="content-wrapper" style="min-height: 901px;">
      <section class="content">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Tambah Kategori</h3>
          </div>
          <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/menu/proses_edit.php" enctype="multipart/form-data">
              <input class="form-control" type="hidden" name="id_menu" value="<?=$detail['id_menu']?>" />
              <div class="form-group">
                <label class="form-label">Nama Menu</label>
                <input class="form-control" type="text" name="nama" value="<?=$detail['nama']?>" required />
              </div>
              <div class="form-group">
                <label class="form-label">Kategori</label>
                <select class="form-control custom-select" name="id_kategori" required>
                  <option selected disabled>-- Pilih Kategori Menu --</option>
                  <?php foreach($kategori as $d): ?>
                  <option value="<?=$d['id_kategori']?>" <?=$detail['id_kategori']==$d['id_kategori'] ?
                    ' selected="selected"' : '' ;?>>
                    <?=$d['nm_kategori']?>
                  </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" required><?=$detail['deskripsi']?></textarea>
              </div>
              <div class="form-group">
                <label class="form-label">Harga</label>
                <input class="form-control" type="number" name="harga" value="<?=$detail['harga']?>" required />
              </div>
              <div class="form-group">
                <label class="form-label">Gambar</label>
                <p>
                  <a href="<?=$alamat_web?>/assets/img/produk/<?=$detail['gambar']?>"><img src="<?=$alamat_web?>/assets/img/produk/<?=$detail['gambar']?>" width="200" height="150" /></a>
                </p>
                <p>
                  *Upload gambar baru untuk mengganti gambar. Disarankan untuk mengupload gambar dengan resolusi 4:3
                </p>
                <input class="form-control" type="file" name="gambar" />
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Simpan perubahan</button>
                <button type="reset" class="btn btn-danger">Reset</button>
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>
    <?php include "../template/footer.php"; ?>
    <?php include("../template/script.php"); ?>
  </div>
</body>

</html>