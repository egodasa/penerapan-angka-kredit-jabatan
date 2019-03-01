<?php
  session_start();
  require("../../pengaturan/helper.php");
  cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  if(isset($_GET['id_pesan'])){
    require_once("../../pengaturan/database.php");
    // Ambil detail pesan
    $query = $db->prepare("SELECT a.*,b.nm_meja FROM tbl_pesan a JOIN tbl_meja b ON a.id_meja = b.id_meja WHERE a.id_pesan = :id_pesan LIMIT 1");
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
<style>
body{
	font-family: Times New Roman;
  margin: 0 auto;
}
table {
  border-collapse: collapse;
	margin: 0 auto;
  width: 40%;
}

table, td, th {
    border: 1px solid black;
}
.kepala {
	background-color: #f0f0f0;
	padding: 13px 5px;
}
.judul {
	background-color: #fff;
	border-color: #fff;
}
td{
	padding: 15px;
}
h1{
	text-align: center;
}
p{
	text-align: center;
}
.penutup-kepala{
  border-color: #000;
}
</style>
<p style="text-align:left;"></p>
    <table>
      <tr>
        <td class="judul" colspan=5 style="text-align: right;font-size: 20px;"><?=$nama_perusahaan?></td>
      </tr>
      <tr>
        <td class="judul" colspan=5 style="text-align: right;font-size: 17px;"><?=$alamat_perusahaan?></td>
      </tr>
      <tr>
        <td class="judul" colspan=2>No Pesan # </td>
        <td class="judul" colspan=3 style="text-align: left;"><?=$detail_pesan['id_pesan']?></td>
      </tr>
      <tr>
        <td class="judul" colspan=2>Tanggal Pesan</td>
        <td class="judul" colspan=3 style="text-align: left;"><?=tanggal_indo_waktu($detail_pesan['tanggal_pesan'])?></td>
      </tr>
      <tr>
        <td class="judul" colspan=2>Nama Pembeli</td>
        <td class="judul" colspan=3 style="text-align: left;"><?=$detail_pesan['nama_pemesan']?></td>
      </tr>
      <tr>
        <td colspan=5 style="border-left-color: #fff;border-right-color: #fff;"></td>
      </tr>
      <tr class="penutup_kepala">
        <th class="kepala">No</th>
        <th class="kepala">Nama</th>
        <th class="kepala">Harga</th>
        <th class="kepala">Jumlah</th>
        <th class="kepala">Total Harga</th>
      </tr>

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
        <td><?=rupiah($d['harga'])?></td>
        <td><?=$d['jumlah']?></td>
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
        <td colspan=3 class="text-center">Tidak ada data yang ditampilkan!</td>
      </tr>
      <?php
}
?>
      <tr>
        <td colspan="3"> </td>
        <td>Total</td>
        <td>
            <?=rupiah($total_bayar)?>
        </td>
      </tr>
      <tr>

        <td colspan="3"></td>
        <td>Dibayar</td>
        <td>
            <?=rupiah($detail_pesan['dibayar'])?>
        </td>
      </tr>
      <tr>
        <td colspan="3"> </td>
        <td>Kembalian</td>
        <td><?=rupiah($detail_pesan['kembalian'])?></td>
      </tr>

    </table>

  </div>
  <script>
    window.print()
  </script>