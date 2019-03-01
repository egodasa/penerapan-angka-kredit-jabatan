<?php session_start();
require("../pengaturan/helper.php");
cekIzinAksesHalaman(array('Kasir'), $alamat_web);
$judul_halaman="Daftar Pesanan";
require("../pengaturan/database.php");

// Ambil daftar menu
$sql="SELECT a.*,b.nm_meja FROM tbl_pesan a JOIN tbl_meja b ON a.id_meja = b.id_meja WHERE DAY(a.tanggal_pesan) = DAY(NOW())";
// Nilai default untuk filter daftar menu
$filter_nama="";
$filter_meja="";
$filter_status="";

// Filter status pembayaran
if(isset($_GET['status']) && !empty($_GET['status'])) {
  $filter_status=$_GET['status'];
  $sql .=" AND a.status_pesanan = :status";
}

// Filter nama 
if(isset($_GET['nama']) && !empty($_GET['nama'])) {
  $filter_nama=$_GET['nama'];
  $sql .=" AND a.nama_pemesan LIKE CONCAT('%', :nama ,'%')";
}

// Filter meja meja
if(isset($_GET['meja']) && !empty($_GET['meja'])) {
  $filter_meja=$_GET['meja'];
  $sql .=" AND b.nm_meja LIKE CONCAT('%', :meja ,'%')";
}

$sql .=" ORDER BY a.tanggal_pesan desc";

// Eksekusi query daftar menu beserta filternya
$query=$db->prepare($sql);


if(isset($_GET['status']) && !empty($_GET['statsu'])) {
  $query->bindParam("status", $filter_status);
}

if(isset($_GET['nama']) && !empty($_GET['nama'])) {
  $query->bindParam("nama", $filter_nama);
}

if(isset($_GET['meja']) && !empty($_GET['meja'])) {
  $query->bindParam("meja", $filter_meja);
}

$query->execute();
$daftar_pesan=$query->fetchAll(PDO::FETCH_ASSOC);

?>
<html>

<head>
  <?php include("../template/head.php");
?>
</head>

<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
  <div class="wrapper" style="height: auto; min-height: 100%;">
    <?php include "../template/menu-kasir.php";
?>
    <div class="content-wrapper" style="min-height: 901px;">
      <section class="content-header"><button type="button" class="btn btn-primary btn-flat" data-toggle="modal"
          data-target="#pencarian">Pencarian Pesanan </button></section>
      <section class="content">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Daftar Pesanan</h3>
          </div>
          <div class="box-body table-responsive ">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Pemesan</th>
                  <th>Waktu Pesan</th>
                  <th>Nomor Meja</th>
                  <th>Status Pesanan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="isi_pesanan">
                <?php $no=1;

if(count($daftar_pesan) > 0) {
  foreach($daftar_pesan as $d) {
    ?>
                <tr>
                  <td>
                    <?=$no?>
                  </td>
                  <td>
                    <?=$d['nama_pemesan']?>
                  </td>
                  <td>
                    <?=tanggal_indo_waktu($d['tanggal_pesan'])?>
                  </td>
                  <td>
                    <?=$d['nm_meja']?>
                  </td>
                  <td>
                    <?=$d['status_pesanan']?>
                  </td>
                  <td><a class="btn btn-info btn-flat" href="<?=$alamat_web?>/pembayaran/detail-pesan.php?id_pesan=<?=$d['id_pesan']?>">Detail
                      Pesanan</a></td>
                </tr>
                <?php $no++;
  }
}

else {
  ?>
                <tr>
                  <td colspan=7 class="text-center">Belum ada pesanan saat ini. Silahkan cek menu <b>Pencarian Pesanan</b> untuk
                    melakukan pencarian data pesanan.</td>
                </tr>
                <?php
}

?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- Modal Pencarian Pesanan -->
          <div class="modal fade" id="pencarian" tabindex="-1" role="dialog" aria-labelledby="pencarian">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                      aria-hidden="true">&times;
                    </span></button>
                  <h4 class="modal-title">Pencarian Pesanan</h4>
                </div>
                <form method="GET">
                  <div class="modal-body table-responsive">
                    <form method="GET">
                      <div class="form-group"><label class="form-label">Nama Pemesan</label><input class="form-control"
                          type="text" name="nama" value="<?=$filter_nama?>" /></div>
                      <div class="form-group"><label class="form-label">Nomor Meja</label><input class="form-control"
                          type="text" name="meja" value="<?=$filter_meja?>" /></div>
                      <div class="form-group"><label class="form-label">Status Pesanan</label><select class="form-control custom-select"
                          name="status">
                          <option value="" <?=$filter_status=='' ? ' selected="selected"' :
                            '' ; ?>>Semua Pesanan</option>
                          <option value="Belum Dibayar" <?=$filter_status=='Belum Dibayar' ? ' selected="selected"' :
                            '' ; ?>>Belum Dibayar</option>
                          <option value="Sudah Dibayar" <?=$filter_status=='Sudah Dibayar' ? ' selected="selected"' :
                            '' ; ?>>Sudah Dibayar</option>
                          <option value="Hidangan Sedang Disiapkan" <?=$filter_status=='Hidangan Sedang Disiapkan' ? ' selected="selected"' :
                            '' ; ?>>Hidangan Sedang Disiapkan</option>
                          <option value="Hidangan Sudah Siap" <?=$filter_status=='Hidangan Sudah Siap' ? ' selected="selected"' :
                            '' ; ?>>Hidangan Sudah Siap</option>
                        </select>
                      </div>
                  </div>
                  <div class="modal-footer"><button type="submit" class="btn btn-primary">Tampilkan</button><a href="<?=$alamat_web?>/pembayaran"
                      class="btn btn-danger">Reset</a><button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button></div>
                </form>
              </div>
            </div>
          </div>
      </section>
    </div>
    <?php include("../template/footer.php");
?>
  </div>
  <script src="<?=$alamat_web?>/assets/js/axios.min.js"></script>
  <script>
    var tbl_pesanan = document.getElementById("tbl_pesanan");
    var current_search = window.location.search;

    function getDaftarPesanan() {
      axios.get("<?=$alamat_web?>/pembayaran/daftar-pesan-api.php" + current_search).then(function (res) {
          var data = res.data;
          total_data = data.total
          // Kosongkan tabel
          document.getElementById("isi_pesanan").innerHTML = "";
          var no = 1;
          var baris_baru = ""

          // Tampilkan data
          if (data.total == 0) {
            baris_baru =
              "<tr><td colspan=7 class='text-center'>Belum ada pesanan saat ini. Silahkan cek menu <b>Pencarian</b> untuk melakukan pencarian data pesanan.</td></tr>";
          } else {
            for (var x = 0; x < data.total;

              x++) {
              baris_baru += "<tr>";
              baris_baru += "<td>" + (x + 1) + "</td>";
              baris_baru += "<td>" + data.data[x]['nama_pemesan'] + "</td>";
              baris_baru += "<td>" + tanggal_indo_waktu(data.data[x]['tanggal_pesan']) + "</td>";
              baris_baru += "<td>" + data.data[x]['nm_meja'] + "</td>";
              baris_baru += "<td>" + data.data[x]['status_pesanan'] + "</td>";
              baris_baru +=
                "<td><a class='btn btn-info btn-flat' href='<?=$alamat_web?>/pembayaran/detail-pesan.php?id_pesan=" +
                data.data[x]['id_pesan'] + "'>Detail Pesanan</a></td>";
              baris_baru += "</tr>";
            }
          }
          document.getElementById("isi_pesanan").innerHTML = baris_baru
        })
    }

    setInterval(getDaftarPesanan, 10000);
  </script>
  <?php include("../template/script.php");
?>
</body>

</html>
