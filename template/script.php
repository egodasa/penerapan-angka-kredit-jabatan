<script src="<?=$alamat_web?>/assets/js/moment.js"></script>
<script src="<?=$alamat_web?>/assets/js/pikaday.js"></script>
<script src="<?=$alamat_web?>/assets/js/app_adminlte.js"></script>
<script src="<?=$alamat_web?>/assets/js/jquery.dataTables.min.js"></script>
<script src="<?=$alamat_web?>/assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $("#tabel").DataTable();
  function tanggal_indo(tanggal, cetak_hari = false){
	  hari = [
      'Senin',
			'Selasa',
			'Rabu',
			'Kamis',
			'Jumat',
			'Sabtu',
			'Minggu'
    ];
      			
	  bulan = [
      'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
    ];
        
	var bagian 	  = tanggal.split('-');
	tgl_indo = bagian[2] + ' ' + bulan[Number(bagian[1]) - 1] + ' ' + bagian[0];
	
	if(cetak_hari){
		var num = new Date(tanggal).getDay();
		return hari[num-1] + ', ' + tgl_indo;
	}
	return tgl_indo;
  }
  function tanggal_indo_waktu(waktu, hari = false){
    var bagian = waktu.split(" ");
    var tanggal = tanggal_indo(bagian[0], hari);
    return tanggal + " " + bagian[1];
  }
    $(document).ready(function () {
        var url = window.location;
        $('ul.nav a[href="'+ url +'"]').parent().addClass('active');
        $('ul.nav a').filter(function() {
             return this.href == url;
        }).parent().addClass('active');
    });
</script> 
