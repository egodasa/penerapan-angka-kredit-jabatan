<?php
  session_start();
  require("../pengaturan/database.php");
  require("../pengaturan/helper.php");
  cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  
  $waktu = date("Y-m-d");
  if(isset($_GET['waktu'])){
    $waktu = $_GET['waktu'];
  }
  // Ambil laporan
  $query = $db->prepare("select aa.nama, aa.harga, ifnull(bb.jumlah, 0) as jumlah,ifnull(bb.total, 0) as total  from tbl_menu aa left join (select a.tanggal_pesan, b.nama, b.id_menu, b.harga, sum(a.jumlah) as jumlah, sum(b.harga*a.jumlah) as total from (select aa.tanggal_pesan, bb.id_menu, bb.jumlah, aa.status_pesanan from tbl_pesan aa join tbl_detail_pesan bb on aa.id_pesan = bb.id_pesan WHERE aa.status_pesanan <> 'Belum Dibayar' AND month(aa.tanggal_pesan) = month(:waktu) AND year(aa.tanggal_pesan) = year(:waktu) AND DATE(aa.tanggal_pesan) <= DATE(:waktu)) a join tbl_menu b on a.id_menu = b.id_menu group by b.id_menu) bb on aa.id_menu = bb.id_menu ORDER BY bb.jumlah DESC;"); 
  $query->bindParam("waktu", $waktu);
  $query->execute();
  $laporan = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<style>
body{
	font-family: Times New Roman;
}
table {
    border-collapse: collapse;
	margin: 0 auto;
}

table, td, th {
    border: 1px solid black;
}
th {
	background-color: #f0f0f0;
	padding: 13px 5px;
}
td{
	padding: 7px;
}
h1{
	text-align: center;
}
p{
	text-align: center;
}
.ttl{
	width:75%;
}
.ttd{
	width: 25%;
	text-align:center;
	float: right;
}
</style>
<p>
<b><?=$nama_perusahaan?></b>
</p>
<p><?=$alamat_perusahaan?></p>
<hr/>
<p>
Laporan Pemasukan Bulanan <br/> Bulan : <?=namaBulan(date("m", strtotime($waktu)))?>
</p>
<table>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Menu</th>
                  <th>Harga Satuan</th>
                  <th>Terjual</th>
                  <th>Pemasukan</th>
                </tr>
              </thead>
              <tbody>
                <?php
              $no = 1;
              if(count($laporan) > 0){
                $total_bayar = 0;
                foreach($laporan as $d){
                $total_bayar += $d['total'];
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
                  <td>
                    <?=$d['jumlah']?>
                  </td>
                  <td>
                    <?=rupiah($d['total'])?>
                  </td>
                </tr>
                <?php 
                $no++;
                }
              }else{
              ?>
                <tr>
                  <td colspan=5 class="text-center">Belum ada pemasukan saat ini.</td>
                </tr>
                <?php
              }
              ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan=4 style="text-align: right;"><b>Total Pemasukan</b></td>
                  <td>
                    <?=rupiah($total_bayar)?>
                  </td>
                </tr>
                </tr>
              </tfoot>
            </table>
<br/>
<div class="ttd">
<p><?=$kota_perusahaan?>, <?=date("d/m/Y")?></p><br/>
<br/>
<p>Pimpinan
</p>
</div>

<script>
  window.print();
</script>