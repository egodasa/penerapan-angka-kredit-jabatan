<html>
<head>
  <?php
    require("../pengaturan/helper.php");
    $judul_halaman = "Cara Pemesanan";
    include("../template/head.php");
  ?>
</head>

<body class="skin-blue layout-top-nav">

<body class="skin-blue layout-top-nav" style="height: auto; min-height: 100%;">
  <div class="wrapper" style="height: auto; min-height: 100%;">
    <?php include("../template/header-pelanggan.php"); ?>
    <div class="content-wrapper" style="min-height: 335px;">
      <div class="container">
        <section class="content-header">
        <a href="<?=$alamat_web?>/pesan" class="btn btn-success btn-flat">< Kembali Ke Halaman Menu</a>
        </section>
        <section class="content">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Cara Pemesan</h3>
                </div>
              <div class="box-body table-responsive ">
                <ol>
                  <li>Buka menu "Pemesanan Menu"</li>
                  <li>Masukkan jumlah pesanan yang diinginkan dan tekan tombol "Keranjang" disebelahnya agar pesanan tersimpan.</li>
                  <li>Lakukan langkah ke-2 kembali jika ingin menambah pesanan.</li>
                  <li>Jika sudah selesai, klik tombol "Selesaikan Pesanan"</li>
                  <li>Masukkan nama Anda, nama meja serta kode meja. Kode meja dapat ditanyakan kepada kasir. Kemudian tekan tombol "Selesaikan Pesanan" yang berada dibagian bawah.</li>
                  <li>Pesanan Anda sudah berhasil dibuat. Selanjutnya Anda harus melakukan pembayaran ke bagian kasir.</li>
                  <li>Status pesanan Anda dapat dilihat di menu "Status Pesanan".</li>
                </ol>    
              </div>
          
          </div>
          </section>
        </div>
      </div>
      <?php include("../template/footer.php"); ?>
    </div>
    <?php include("../template/script.php"); ?>
  </body>

</html>
