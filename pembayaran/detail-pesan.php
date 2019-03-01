<?php
  session_start();
  require("../pengaturan/helper.php");
  cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Detail Pesanan";
  if(isset($_GET['id_pesan'])){
    require_once("../pengaturan/database.php");
    // Ambil detail pesan
    $query = $db->prepare("SELECT a.*,b.nm_meja FROM tbl_pesan a JOIN tbl_meja b ON a.id_meja = b.id_meja WHERE id_pesan = :id_pesan LIMIT 1");
    $query->bindParam("id_pesan", $_GET['id_pesan']); 
    $query->execute();
    $detail_pesan = $query->fetch();
    
    
    // Ambil daftar pesan
    $query = $db->prepare("select `a`.`id_detail` AS `id_detail`,`a`.`id_pesan` AS `id_pesan`,`b`.`nama` AS `nama`,`b`.`harga` AS `harga`,`a`.`jumlah` AS `jumlah`,(`a`.`jumlah` * `b`.`harga`) AS `sub_bayar` from (`tbl_detail_pesan` `a` join `tbl_menu` `b` on((`a`.`id_menu` = `b`.`id_menu`))) WHERE a.id_pesan = :id_pesan");
    $query->bindParam("id_pesan", $_GET['id_pesan']); 
    $query->execute();
    $daftar_pesan = $query->fetchAll(PDO::FETCH_ASSOC);
    
  }else{
    header("Location: $alamat_web/pembayaran");
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
      <section class="content-header">
        <a href="<?=$alamat_web?>/pembayaran" class="btn btn-success btn-flat">
          < Kembali Ke Daftar Pesanan</a> </section> <section class="content">
            <div class="row">
              <div class="col-md-5 col-xs-12">
                <div class="box">
                  <div class="box-header with-border">
                    <h3 class="box-title">Informasi Pemesan</h3>
                  </div>
                  <div class="box-body table-responsive ">
                    <form action="<?=$alamat_web?>/pembayaran/proses-pembayaran.php" id="form_pesanan" method="POST">
                      <div class="row">
                        <div class="col-md-6 col-xs-12">
                          <div class="form-group">
                            <label class="form-label">No Pesan</label>
                            <input class="form-control" type="text" value="<?=$detail_pesan['id_pesan']?>" name="id_pesan"
                              readonly>
                          </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                          <div class="form-group">
                            <label class="form-label">Nama Pemesan</label>
                            <input class="form-control" type="text" value="<?=$detail_pesan['nama_pemesan']?>" readonly>
                          </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                          <div class="form-group">
                            <label class="form-label">Tanggal Pesan</label>
                            <input class="form-control" type="text" value="<?=tanggal_indo_waktu($detail_pesan['tanggal_pesan'])?>"
                              readonly>
                          </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                          <div class="form-group">
                            <label class="form-label">Nomor Meja</label>
                            <input class="form-control" type="text" value="<?=$detail_pesan['nm_meja']?>" readonly>
                          </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                          <div class="form-group">
                            <label class="form-label">Status Pesanan</label>
                            <select class="form-control custom-select" name="status_pesanan">
                              <option value="Belum Dibayar" <?=$detail_pesan['status_pesanan']=='Belum Dibayar'
                                ? ' selected="selected"' : '' ;?>>Belum Dibayar</option>
                              <option value="Sudah Dibayar" <?=$detail_pesan['status_pesanan']=='Sudah Dibayar'
                                ? ' selected="selected"' : '' ;?>>Sudah Dibayar</option>
                              <option value="Hidangan Sedang Disiapkan" <?=$detail_pesan['status_pesanan']=='Hidangan Sedang Disiapkan' ?
                                ' selected="selected"' : '' ;?>>Hidangan Sedang Disiapkan</option>
                              <option value="Hidangan Sudah Siap" <?=$detail_pesan['status_pesanan']=='Hidangan Sudah Siap'
                                ? ' selected="selected"' : '' ;?>>Hidangan Sudah Siap</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                          <div class="form-group">
                            <label class="form-label">Total Bayar</label>
                            <input class="form-control" type="text" id="total_bayar" readonly>
                            <input type="hidden" name="nilai_total_bayar" id="nilai_total_bayar" />
                          </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                          <div class="form-group">
                            <label class="form-label">Dibayar</label>
                            <input class="form-control" type="text" name="dibayar" id="dibayar" value="<?=$detail_pesan['dibayar']?>" />
                            <input type="hidden" name="nilai_dibayar" id="nilai_dibayar" value="<?=$detail_pesan['dibayar']?>" />
                          </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                          <div class="form-group">
                            <label class="form-label">Kembalian</label>
                            <input class="form-control" value="<?=$detail_pesan['kembalian']?>" type="text" name="kembalian" id="kembalian" readonly />
                            <input value="<?=$detail_pesan['kembalian']?>" type="hidden" name="nilai_kembalian" id="nilai_kembalian" />
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Proses Pesanan</button>
                      <a id="btn_invoice" class="btn btn-success" href="<?=$alamat_web?>/pembayaran/cetak/index.php?id_pesan=<?=$detail_pesan['id_pesan']?>">Cetak
                        Invoice</a>
                    </form>
                  </div>
                </div>
              </div>

              <div class="col-md-7 col-xs-12">
                <div class="box">
                  <div class="box-header with-border">
                    <h3 class="box-title" data-widget="collapse">Daftar Menu Yang Dipesan</h3>
                    <!-- /.box-tools -->
                  </div>
                  <div class="box-body table-responsive ">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Harga</th>
                          <th class="text-right">Jumlah</th>
                          <th>Sub Bayar</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                $no = 1;
                if(count($daftar_pesan) > 0){
                  $total_bayar = 0;
                  foreach($daftar_pesan as $d){
                  $total_bayar += $d['sub_bayar'];
                ?>
                        <tr>
                          <td>
                            <?=$no?>
                          </td>
                          <td>
                            <?=$d['nama']?>
                          </td>
                          <td>
                            <?=rupiah($d['harga'])?>
                          </td>
                          <td class="text-right">
                            <?=$d['jumlah']?>
                          </td>
                          <td>
                            <?=rupiah($d['sub_bayar'])?>
                          </td>
                        </tr>
                        <?php 
                  $no++;
                  }
                }else{
                ?>
                        <tr>
                          <td colspan=5 class="text-center">Tidak ada data yang ditampilkan!</td>
                        </tr>
                        <?php
                }
                ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan=4>Total Bayar</td>
                          <td>
                            <?=rupiah($total_bayar)?>
                          </td>
                        </tr>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>


            </div>
      </section>
      <script>
        var pengaturan_rupiah = {
          currencySymbol: "Rp",
          decimalCharacter: ',',
          digitGroupSeparator: '.'
        };
        var dibayar = new AutoNumeric('#dibayar', pengaturan_rupiah);
        var total_bayar = new AutoNumeric('#total_bayar', pengaturan_rupiah);
        var kembalian = new AutoNumeric('#kembalian', pengaturan_rupiah);
        <?php
          if($detail_pesan['status_pesanan'] == 'Belum Dibayar'):
        ?>
          document.getElementById("btn_invoice").className = "btn btn-success disabled";
        <?php
          else:
        ?>
          document.getElementById("btn_invoice").className = "btn btn-success";
        <?php
          endif;
        ?>
        function hitungKembalian() {
          kembalian.set(dibayar.getNumber() - total_bayar.getNumber());
          document.getElementById("nilai_dibayar").value = dibayar.getNumber();
          document.getElementById("nilai_total_bayar").value = total_bayar.getNumber();
          document.getElementById("nilai_kembalian").value = kembalian.getNumber();
        }
        document.getElementById("dibayar").addEventListener("keyup", hitungKembalian);
        total_bayar.set(<?=$total_bayar?>);
        hitungKembalian();
      </script>
    </div>
    <?php include("../template/footer.php"); ?>
  </div>
  <?php include("../template/script.php"); ?>
</body>

</html>
