<?php
  session_start();
  require("../vendor/autoload.php");
  require("../pengaturan/helper.php");
  require("../pengaturan/medoo.php");
  //~ cekIzinAksesHalaman(array('Kasir'), $alamat_web);
  $judul_halaman = "Beranda";
  $detail_ak_utama = $db->query("SELECT ifnull(SUM(CASE WHEN a.angka_kredit_baru = 0 THEN a.angka_kredit ELSE a.angka_kredit_baru END), 0) AS angka_kredit, ifnull(SUM(a.angka_kredit_baru), 0) AS angka_kredit_baru FROM tbl_usulan_unsur a JOIN tbl_usulan b on a.id_usulan = b.id_usulan JOIN tbl_sub_unsur c on a.id_sub_unsur = c.id_sub_unsur WHERE b.nip = '$_SESSION[nip]' AND a.status <> 'Ditolak' AND c.jenis_unsur = 'Unsur Utama'")->fetchAll();
  $detail_ak_penunjang = $db->query("SELECT ifnull(SUM(CASE WHEN a.angka_kredit_baru = 0 THEN a.angka_kredit ELSE a.angka_kredit_baru END), 0) AS angka_kredit, ifnull(SUM(a.angka_kredit_baru), 0) AS angka_kredit_baru FROM tbl_usulan_unsur a JOIN tbl_usulan b on a.id_usulan = b.id_usulan JOIN tbl_sub_unsur c on a.id_sub_unsur = c.id_sub_unsur WHERE b.nip = '$_SESSION[nip]' AND a.status <> 'Ditolak' AND c.jenis_unsur = 'Unsur Penunjang'")->fetchAll();

  $ak_sekarang = $detail_ak_utama[0]['angka_kredit']+$detail_ak_penunjang[0]['angka_kredit']+$_SESSION['angka_kredit'];
?>
<html>

<head>
  <?php
    include("../template/head.php");
  ?>
  <script src="<?=$alamat_web?>/assets/js/pdf.js"></script>
  <script src="<?=$alamat_web?>/assets/js/pdf.worker.js"></script>
  <style type="text/css">
    
    #upload-button {
      width: 150px;
      display: block;
      margin: 20px auto;
    }
    
    #file-to-upload {
      display: none;
    }
    
    #pdf-main-container {
      width: 400px;
      margin: 20px auto;
    }
    
    #pdf-loader {
      display: none;
      text-align: center;
      color: #999999;
      font-size: 13px;
      line-height: 100px;
      height: 100px;
    }
    
    #pdf-contents {
      display: none;
    }
    
    #pdf-meta {
      overflow: hidden;
      margin: 0 0 20px 0;
    }
    
    #pdf-buttons {
      float: left;
    }
    
    #page-count-container {
      float: right;
    }
    
    #pdf-current-page {
      display: inline;
    }
    
    #pdf-total-pages {
      display: inline;
    }
    
    #pdf-canvas {
      border: 1px solid rgba(0,0,0,0.2);
      box-sizing: border-box;
    }
    
    #page-loader {
      height: 100px;
      line-height: 100px;
      text-align: center;
      display: none;
      color: #999999;
      font-size: 13px;
    }
    
    </style>
</head>

<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
  <div class="wrapper" style="height: auto; min-height: 100%;">
    <?php include "../template/menu-kependidikan.php"; ?>
    <div class="content-wrapper" style="min-height: 901px;">
      <section class="content">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Selamat Datang</h3>
          </div>
          <div class="box-body table-responsive ">
            Golongan Anda saat ini <b><?=$_SESSION['pangkat']?></b> akan naik pangkat ke <b><?=$_SESSION['pangkat_selanjutnya']?></b> <br/>
            Total KUM saat ini <?=round($ak_sekarang, 4)?> (Unsur Utama <?=round($detail_ak_utama[0]['angka_kredit']+$_SESSION['kredit_awal_utama'], 4)?>, Unsur Penunjang <?=round($detail_ak_penunjang[0]['angka_kredit']+$_SESSION['kredit_awal_penunjang'], 4)?>)<br/>
            Total KUM yang harus dicapai untuk naik pangkat : <b><?=$_SESSION['angka_kredit_selanjutnya']?></b><br/>
            Total kekurangan Angka Kredit Anda <b><?=round(abs($ak_sekarang-$_SESSION['angka_kredit_selanjutnya']), 4)?></b><br/>
            Untuk memenuhi kenaikan pangkat <b><?=$_SESSION['pangkat_selanjutnya']?></b><br/>
          </div>
        </div>
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Persyaratan untuk kenaikan pangkat/jabatan</h3>
          </div>
          <div class="box-body table-responsive ">
            <ol>
              <li>File Scan Karpeg</li>
              <li>File Scan Pangkat Terakhir</li>
              <li>File Scan SK Jabatan Terakhir</li>
              <li>File Scan STTPP Diklat Fungsional</li>
              <li>File Scan PAK Terakhir</li>
              <li>File Scan Ijazah Terakhir</li>
              <li>File Scan Penilaian Prestasi Kerja 2th terakhir</li>
              <li>File Scan Pegawai CPNS & PNS</li>
              <li>File Scan Surat Tugas</li>
              <li>File Scan Bukti Fisik Hasil Kegiatan</li>
              <li>File Scan Surat Pernyataan Melakukan Kegiatan</li>
              <li>File Scan Surat Pengantar dari pejabat pengusul</li>
            </ol>
          </div>
        </div>
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Informasi</h3>
          </div>
          <div class="box-body table-responsive">
            <div id="pdf-main-container">
              <div id="pdf-loader">Memuat Dokumen</div>
              <div id="pdf-contents">
                <div id="pdf-meta">
                  <div id="pdf-buttons">
                    <button id="pdf-prev" class="btn btn-primary btn-flat">Sebelumnya</button>
                    <button id="pdf-next" class="btn btn-primary btn-flat">Selanjutnya</button>
                  </div>
                  <div id="page-count-container">Page <div id="pdf-current-page"></div> dari <div id="pdf-total-pages"></div></div>
                </div>
                <canvas id="pdf-canvas" width="400"></canvas>
                <div id="page-loader">Memuat Dokumen</div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include("../template/footer.php"); ?>
  </div>
  <?php include("../template/script.php"); ?>
  <script>

  var __PDF_DOC,
    __CURRENT_PAGE,
    __TOTAL_PAGES,
    __PAGE_RENDERING_IN_PROGRESS = 0,
    __CANVAS = $('#pdf-canvas').get(0),
    __CANVAS_CTX = __CANVAS.getContext('2d');
  
  function showPDF(pdf_url) {
    $("#pdf-loader").show();
  
    PDFJS.getDocument({ url: pdf_url }).then(function(pdf_doc) {
      __PDF_DOC = pdf_doc;
      __TOTAL_PAGES = __PDF_DOC.numPages;
      
      // Hide the pdf loader and show pdf container in HTML
      $("#pdf-loader").hide();
      $("#pdf-contents").show();
      $("#pdf-total-pages").text(__TOTAL_PAGES);
  
      // Show the first page
      showPage(1);
    }).catch(function(error) {
      // If error re-show the upload button
      $("#pdf-loader").hide();
      $("#upload-button").show();
      
      alert(error.message);
    });;
  }
  
  function showPage(page_no) {
    __PAGE_RENDERING_IN_PROGRESS = 1;
    __CURRENT_PAGE = page_no;
  
    // Disable Prev & Next buttons while page is being loaded
    $("#pdf-next, #pdf-prev").attr('disabled', 'disabled');
  
    // While page is being rendered hide the canvas and show a loading message
    $("#pdf-canvas").hide();
    $("#page-loader").show();
  
    // Update current page in HTML
    $("#pdf-current-page").text(page_no);
    
    // Fetch the page
    __PDF_DOC.getPage(page_no).then(function(page) {
      // As the canvas is of a fixed width we need to set the scale of the viewport accordingly
      var scale_required = __CANVAS.width / page.getViewport(1).width;
  
      // Get viewport of the page at required scale
      var viewport = page.getViewport(scale_required);
  
      // Set canvas height
      __CANVAS.height = viewport.height;
  
      var renderContext = {
        canvasContext: __CANVAS_CTX,
        viewport: viewport
      };
      
      // Render the page contents in the canvas
      page.render(renderContext).then(function() {
        __PAGE_RENDERING_IN_PROGRESS = 0;
  
        // Re-enable Prev & Next buttons
        $("#pdf-next, #pdf-prev").removeAttr('disabled');
  
        // Show the canvas and hide the page loader
        $("#pdf-canvas").show();
        $("#page-loader").hide();
      });
    });
  }
  
  // Upon click this should should trigger click on the #file-to-upload file input element
  // This is better than showing the not-good-looking file input element
  $("#upload-button").on('click', function() {
    $("#file-to-upload").trigger('click');
  });
  
  // When user chooses a PDF file
  $("#file-to-upload").on('change', function() {
    // Validate whether PDF
      if(['application/pdf'].indexOf($("#file-to-upload").get(0).files[0].type) == -1) {
          alert('Error : Not a PDF');
          return;
      }
  
    $("#upload-button").hide();
  
    // Send the object url of the pdf
    showPDF(URL.createObjectURL($("#file-to-upload").get(0).files[0]));
  });
  
  // Previous page of the PDF
  $("#pdf-prev").on('click', function() {
    if(__CURRENT_PAGE != 1)
      showPage(--__CURRENT_PAGE);
  });
  
  // Next page of the PDF
  $("#pdf-next").on('click', function() {
    if(__CURRENT_PAGE != __TOTAL_PAGES)
      showPage(++__CURRENT_PAGE);
  });
  
  <?php
    $file_pdf = "";
    if($_SESSION['nm_posisi'] == "Pranata Laboratorium Pendidikan")
    {
      $file_pdf = "plp.pdf";
    }
    else if($_SESSION['nm_posisi'] == "Pustakawan")
    {
      $file_pdf = "pustakawan.pdf";
    }
    else if($_SESSION['nm_posisi'] == "Arsiparis")
    {
      $file_pdf = "arsiparis.pdf";
    }
  ?>
  showPDF("<?=$alamat_web.'/persyaratan/'.$file_pdf?>");
  
  </script>
</body>
</html>
