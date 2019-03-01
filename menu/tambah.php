<?php
  session_start();
  require("../pengaturan/helper.php");
  cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Tambah Menu";
  require("../pengaturan/database.php");
  // Ambil daftar kategori
  $query = $db->prepare("SELECT * FROM tbl_kategori"); 
  $query->execute();
  $kategori = $query->fetchAll(PDO::FETCH_ASSOC);
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
            <h3 class="box-title">Input Makanan & Minuman</h3>
          </div>
          <div class="box-body table-responsive ">
            <form method="POST" action="<?=$alamat_web?>/menu/proses_tambah.php" enctype="multipart/form-data">
              <div class="form-group">
                <label class="form-label">Nama Menu</label>
                <input class="form-control" type="text" name="nama" required />
              </div>
              <div class="form-group">
                <label class="form-label">Kategori</label>
                <select class="form-control custom-select" name="id_kategori" required>
                  <option selected disabled>-- Pilih Kategori Menu --</option>
                  <?php foreach($kategori as $d): ?>
                  <option value="<?=$d['id_kategori']?>">
                    <?=$d['nm_kategori']?>
                  </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" required></textarea>
              </div>
              <div class="form-group">
                <label class="form-label">Harga</label>
                <input class="form-control" type="number" name="harga" required />
              </div>
              <div class="form-group">
                <label class="form-label">Gambar</label>
                <p>
                  *Disarankan untuk mengupload gambar dengan resolusi 4:3
                </p>
                <input class="form-control" type="file" name="gambar" required />
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Simpan</button>
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