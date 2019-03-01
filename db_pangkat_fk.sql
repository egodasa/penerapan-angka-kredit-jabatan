-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `tbl_berkas_penilaian`;
CREATE TABLE `tbl_berkas_penilaian` (
  `id_berkas_penilaian` int(11) NOT NULL AUTO_INCREMENT,
  `id_usulan` int(11) NOT NULL,
  `id_berkas` int(11) NOT NULL,
  `file` text,
  PRIMARY KEY (`id_berkas_penilaian`),
  KEY `id_usulan` (`id_usulan`),
  KEY `id_berkas` (`id_berkas`),
  CONSTRAINT `tbl_berkas_penilaian_ibfk_1` FOREIGN KEY (`id_usulan`) REFERENCES `tbl_usulan` (`id_usulan`) ON DELETE CASCADE,
  CONSTRAINT `tbl_berkas_penilaian_ibfk_2` FOREIGN KEY (`id_berkas`) REFERENCES `tbl_jenis_berkas` (`id_berkas`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_berkas_penilaian` (`id_berkas_penilaian`, `id_usulan`, `id_berkas`, `file`) VALUES
(1,	1,	1,	'270219072737004400.jpeg'),
(2,	1,	2,	'270219072742220500.jpeg'),
(3,	1,	3,	NULL),
(4,	1,	4,	NULL),
(5,	1,	5,	NULL),
(6,	1,	6,	NULL),
(7,	1,	7,	NULL),
(8,	1,	8,	NULL),
(9,	1,	9,	NULL),
(10,	1,	10,	NULL),
(11,	1,	11,	NULL),
(12,	1,	12,	NULL),
(13,	1,	13,	NULL),
(14,	1,	14,	NULL);

DROP TABLE IF EXISTS `tbl_jabatan`;
CREATE TABLE `tbl_jabatan` (
  `id_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `nm_jabatan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_jabatan` (`id_jabatan`, `nm_jabatan`) VALUES
(1,	'Pustakawan Pelaksana'),
(2,	'Pustakawan Pelaksana Lanjutan'),
(3,	'Pustakawan Penyelia'),
(4,	'Staff Kepegawaian'),
(5,	'Tim Penilai');

DROP TABLE IF EXISTS `tbl_jabatan_pangkat`;
CREATE TABLE `tbl_jabatan_pangkat` (
  `id_jabatan_pangkat` int(11) NOT NULL AUTO_INCREMENT,
  `id_jabatan` int(11) NOT NULL,
  `id_pangkat` int(11) NOT NULL,
  `nilai_kredit` float NOT NULL,
  `peringkat` int(11) NOT NULL,
  PRIMARY KEY (`id_jabatan_pangkat`),
  KEY `id_jabatan` (`id_jabatan`),
  KEY `id_pangkat` (`id_pangkat`),
  CONSTRAINT `tbl_jabatan_pangkat_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `tbl_jabatan` (`id_jabatan`) ON DELETE CASCADE,
  CONSTRAINT `tbl_jabatan_pangkat_ibfk_2` FOREIGN KEY (`id_pangkat`) REFERENCES `tbl_pangkat` (`id_pangkat`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_jabatan_pangkat` (`id_jabatan_pangkat`, `id_jabatan`, `id_pangkat`, `nilai_kredit`, `peringkat`) VALUES
(1,	1,	1,	10,	10),
(2,	1,	2,	20,	20),
(3,	1,	3,	30,	30),
(4,	1,	4,	40,	40),
(5,	4,	13,	0,	0),
(6,	5,	14,	0,	0);

DROP TABLE IF EXISTS `tbl_jenis_berkas`;
CREATE TABLE `tbl_jenis_berkas` (
  `id_berkas` int(11) NOT NULL AUTO_INCREMENT,
  `nm_berkas` varchar(255) NOT NULL,
  PRIMARY KEY (`id_berkas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_jenis_berkas` (`id_berkas`, `nm_berkas`) VALUES
(1,	'KARPEG'),
(2,	'Pangkat Terakhir'),
(3,	'SK Jabatan Terakhir'),
(4,	'STTPP Diklat Fungsional'),
(5,	'PAK Terakhir'),
(6,	'Ijazah Terakhir'),
(7,	'Penilaian Prestasi Kerja 2thn terakhir'),
(8,	'SK Pegawai CPNS & PNS'),
(9,	'Surat Tugas'),
(10,	'Bukti Fisik Hasil Kegiatan'),
(11,	'Surat Pernyataan Melakukan Kegiatan'),
(12,	'Surat Pengantar dari Pejabat Pengusul'),
(13,	'DUPAK'),
(14,	'SPMK');

DROP TABLE IF EXISTS `tbl_pangkat`;
CREATE TABLE `tbl_pangkat` (
  `id_pangkat` int(11) NOT NULL AUTO_INCREMENT,
  `nm_pangkat` varchar(100) NOT NULL,
  PRIMARY KEY (`id_pangkat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_pangkat` (`id_pangkat`, `nm_pangkat`) VALUES
(1,	'II/a'),
(2,	'Pengatur Muda Tingkat I (II/b)'),
(3,	'Pengatur (II/c)'),
(4,	'II/d'),
(5,	'Penata Muda III/a'),
(6,	'Penata Muda Tingkat I III/b'),
(7,	'Penata III/c'),
(8,	'Penata Tingkat I III/d'),
(9,	'Pembina IV/a'),
(10,	'Pembina Tingkat I IV/b'),
(11,	'Pembina Utama Muda IV/c'),
(12,	'Pembina Utama Madya IV/d'),
(13,	'Staff Kepegawaian IV/a'),
(14,	'Tim Penilai IV/a'),
(15,	'Pembina Utama IV/e');

DROP TABLE IF EXISTS `tbl_pegawai`;
CREATE TABLE `tbl_pegawai` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `no_karpeg` varchar(50) NOT NULL,
  `nm_lengkap` varchar(100) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `nohp` varchar(15) NOT NULL,
  `pendidikan` varchar(50) NOT NULL,
  `tgl_lulus` date NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `id_jabatan_pangkat` int(11) NOT NULL,
  `id_unit_kerja` int(11) NOT NULL,
  `foto` text,
  `kredit_awal` float NOT NULL DEFAULT '0',
  `tmt_jabatan` date NOT NULL,
  PRIMARY KEY (`id_pegawai`),
  KEY `id_jabatan_pangkat` (`id_jabatan_pangkat`),
  KEY `id_unit_kerja` (`id_unit_kerja`),
  CONSTRAINT `tbl_pegawai_ibfk_1` FOREIGN KEY (`id_jabatan_pangkat`) REFERENCES `tbl_jabatan_pangkat` (`id_jabatan_pangkat`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_pegawai_ibfk_2` FOREIGN KEY (`id_unit_kerja`) REFERENCES `tbl_unit_kerja` (`id_unit_kerja`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_pegawai` (`id_pegawai`, `nip`, `password`, `no_karpeg`, `nm_lengkap`, `tempat_lahir`, `tgl_lahir`, `email`, `nohp`, `pendidikan`, `tgl_lulus`, `jk`, `id_jabatan_pangkat`, `id_unit_kerja`, `foto`, `kredit_awal`, `tmt_jabatan`) VALUES
(4,	'12345',	'827ccb0eea8a706c4c34a16891f84e7b',	'12345',	'Saya',	'Padang',	'2012-10-10',	'email@mail.com',	'08123456789',	'Sarjana (S1)/Diploma IV',	'2019-02-01',	'Laki-laki',	5,	5,	'240219125752884600.png',	0,	'2019-02-25'),
(5,	'11111',	'b0baee9d279d34fa1dfd71aadb908c3f',	'11111',	'11111',	'padang',	'2010-10-10',	'siswa@mail.com',	'12345',	'Sarjana (S1)/Diploma IV',	'2019-02-01',	'Laki-laki',	1,	6,	'240219124048061500.png',	20,	'2019-02-06'),
(6,	'22222',	'3d2172418ce305c7d16d4b05597c6a59',	'22222',	'22222',	'padang',	'2019-10-10',	'duqe@mailinator.com',	'1213212321',	'Sarjana (S1)/Diploma IV',	'2019-02-01',	'Laki-laki',	4,	6,	'240219123955716800.png',	0,	'2019-02-06'),
(7,	'98765',	'c37bf859faf392800d739a41fe5af151',	'N. 98765',	'Tim Penilai',	'Padang',	'2003-04-04',	'tim@pegawai.com',	'089876544321',	'Sarjana (S1)/Diploma IV',	'2019-02-06',	'Laki-laki',	6,	4,	'270219091105546300.jpeg',	0,	'2019-02-04'),
(8,	'77777',	'22a4d9b04fe95c9893b41e2fde83a427',	'N. 77777',	'Atasan Pustakawan',	'padang',	'1995-10-10',	'7777@777.com',	'777777777777',	'Sarjana (S1)/Diploma IV',	'2019-02-01',	'Laki-laki',	1,	1,	'280219011047829700.jpeg',	0,	'2019-02-07');

DROP TABLE IF EXISTS `tbl_posisi`;
CREATE TABLE `tbl_posisi` (
  `id_posisi` int(11) NOT NULL AUTO_INCREMENT,
  `nm_posisi` varchar(255) NOT NULL,
  `jenis_posisi` enum('Tenaga Kependidikan','Staff Kepegawaian','Tim Penilai') NOT NULL,
  PRIMARY KEY (`id_posisi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_posisi` (`id_posisi`, `nm_posisi`, `jenis_posisi`) VALUES
(2,	'Arsiparis',	'Tenaga Kependidikan'),
(3,	'Pranata Laboratorium Pendidikan',	'Tenaga Kependidikan'),
(4,	'Pustakawan',	'Tenaga Kependidikan'),
(5,	'Admin',	'Staff Kepegawaian'),
(6,	'Tim Penilai',	'Tim Penilai');

DROP TABLE IF EXISTS `tbl_unit_kerja`;
CREATE TABLE `tbl_unit_kerja` (
  `id_unit_kerja` int(11) NOT NULL AUTO_INCREMENT,
  `nm_unit_kerja` varchar(100) NOT NULL,
  `nip_atasan` varchar(20) NOT NULL,
  `id_posisi` int(11) NOT NULL,
  PRIMARY KEY (`id_unit_kerja`),
  KEY `id_posisi` (`id_posisi`),
  CONSTRAINT `tbl_unit_kerja_ibfk_1` FOREIGN KEY (`id_posisi`) REFERENCES `tbl_posisi` (`id_posisi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_unit_kerja` (`id_unit_kerja`, `nm_unit_kerja`, `nip_atasan`, `id_posisi`) VALUES
(1,	'UPT Pustakawan',	'12345',	2),
(2,	'Arsiparis',	'12345',	2),
(3,	'UPT PLT',	'12345',	3),
(4,	'UPT Tim Penilai',	'12345',	6),
(5,	'UPT Staff Kepegawaian',	'12345',	5),
(6,	'UPT Pustakawan',	'12345',	4);

DROP TABLE IF EXISTS `tbl_unsur`;
CREATE TABLE `tbl_unsur` (
  `id_unsur` int(11) NOT NULL AUTO_INCREMENT,
  `nm_unsur` varchar(255) NOT NULL,
  `id_posisi` int(11) NOT NULL,
  `jenis_unsur` enum('Unsur Utama','Unsur Penunjang') NOT NULL,
  `kategori_unsur` enum('Pendidikan','Tugas Pokok','Pengembangan Profesi') NOT NULL DEFAULT 'Tugas Pokok',
  PRIMARY KEY (`id_unsur`),
  KEY `id_posisi` (`id_posisi`),
  CONSTRAINT `tbl_unsur_ibfk_1` FOREIGN KEY (`id_posisi`) REFERENCES `tbl_posisi` (`id_posisi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_unsur` (`id_unsur`, `nm_unsur`, `id_posisi`, `jenis_unsur`, `kategori_unsur`) VALUES
(2,	'Pengelolaan Perpustakaan',	4,	'Unsur Utama',	'Tugas Pokok'),
(3,	'Pelayanan Perpustakaan',	4,	'Unsur Utama',	'Tugas Pokok'),
(4,	'Pengembangan Sistem Kepustakawanan',	4,	'Unsur Utama',	'Tugas Pokok'),
(5,	'Pengembangan Profesi',	4,	'Unsur Utama',	'Pengembangan Profesi'),
(6,	'Pengajaran/pelatihan pada diklat fungsional/teknis di bidang kepustakawanan',	4,	'Unsur Penunjang',	'Pengembangan Profesi'),
(8,	'Keanggotaan dalam organisasi profesi',	4,	'Unsur Penunjang',	'Pengembangan Profesi'),
(9,	'Keanggotaan dalam tim penilai',	4,	'Unsur Penunjang',	'Tugas Pokok'),
(10,	'Perolehan penghargaan/tanda jasa dan perolehan gelar kesarjanaan lainnya',	4,	'Unsur Penunjang',	'Pendidikan'),
(11,	'Pendidikan',	4,	'Unsur Utama',	'Pendidikan'),
(12,	'Pendidikan',	2,	'Unsur Utama',	'Pendidikan'),
(13,	'Pengelolaan Arsip',	2,	'Unsur Utama',	'Tugas Pokok'),
(14,	'Pembinaan Kearsipan',	2,	'Unsur Utama',	'Tugas Pokok'),
(15,	'Pengembangan Profesi',	2,	'Unsur Utama',	'Tugas Pokok'),
(16,	'Pengelolaan/pelatihan di bidang kearsipan',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(17,	'Mengikuti bimbingan di bidang kearsipan',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(18,	'Peran serta dalam seminar/lokakarya di bidang kearsipan',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(19,	'Keanggotaan dalam organisasi profesi',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(20,	'Keanggotaan dalam tim penilai',	2,	'Unsur Penunjang',	'Tugas Pokok'),
(21,	'Perolehan gelar kesarjanaan lainnya',	2,	'Unsur Penunjang',	'Tugas Pokok');

DROP TABLE IF EXISTS `tbl_usulan`;
CREATE TABLE `tbl_usulan` (
  `id_usulan` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_usulan` date NOT NULL,
  `status_proses` varchar(30) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `nip` varchar(20) NOT NULL,
  `masa_penilaian_awal` date NOT NULL,
  `masa_penilaian_akhir` date NOT NULL,
  `tgl_penyesuaian` date DEFAULT NULL,
  `tgl_pengesahan` date DEFAULT NULL,
  `id_jabatan_pangkat_selanjutnya` int(11) NOT NULL,
  `id_jabatan_pangkat_sekarang` int(11) NOT NULL,
  `masa_kerja_golongan_lama` varchar(100) NOT NULL,
  `masa_kerja_golongan_baru` varchar(100) NOT NULL,
  PRIMARY KEY (`id_usulan`),
  KEY `id_jabatan_pangkat_selanjutnya` (`id_jabatan_pangkat_selanjutnya`),
  KEY `id_jabatan_pangkat_sekarang` (`id_jabatan_pangkat_sekarang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_usulan` (`id_usulan`, `tgl_usulan`, `status_proses`, `keterangan`, `nip`, `masa_penilaian_awal`, `masa_penilaian_akhir`, `tgl_penyesuaian`, `tgl_pengesahan`, `id_jabatan_pangkat_selanjutnya`, `id_jabatan_pangkat_sekarang`, `masa_kerja_golongan_lama`, `masa_kerja_golongan_baru`) VALUES
(1,	'2019-02-02',	'Angka Kredit Diterima',	'',	'11111',	'2019-03-02',	'2019-07-02',	'2019-02-21',	'2019-02-01',	3,	2,	'1 tahun',	'2 tahun');

DROP TABLE IF EXISTS `tbl_usulan_unsur`;
CREATE TABLE `tbl_usulan_unsur` (
  `id_usulan_unsur` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_mulai_kegiatan` date NOT NULL,
  `tgl_selesai_kegiatan` date NOT NULL,
  `butir_kegiatan` text NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `angka_kredit_murni` float NOT NULL,
  `angka_kredit_murni_baru` float NOT NULL DEFAULT '0',
  `angka_kredit_persentase` float NOT NULL,
  `angka_kredit_persentase_baru` float NOT NULL DEFAULT '0',
  `angka_kredit` float NOT NULL,
  `angka_kredit_baru` float NOT NULL DEFAULT '0',
  `tempat` varchar(30) NOT NULL,
  `id_usulan` int(11) NOT NULL,
  `tingkat_kesulitan` varchar(30) NOT NULL,
  `jumlah_volume_kegiatan` int(11) NOT NULL,
  `id_unsur` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `bukti_kegiatan` text NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_usulan_unsur`),
  KEY `id_unsur` (`id_unsur`),
  KEY `id_usulan` (`id_usulan`),
  CONSTRAINT `tbl_usulan_unsur_ibfk_1` FOREIGN KEY (`id_usulan`) REFERENCES `tbl_usulan` (`id_usulan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_usulan_unsur_ibfk_2` FOREIGN KEY (`id_unsur`) REFERENCES `tbl_unsur` (`id_unsur`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_usulan_unsur` (`id_usulan_unsur`, `tgl_mulai_kegiatan`, `tgl_selesai_kegiatan`, `butir_kegiatan`, `satuan`, `angka_kredit_murni`, `angka_kredit_murni_baru`, `angka_kredit_persentase`, `angka_kredit_persentase_baru`, `angka_kredit`, `angka_kredit_baru`, `tempat`, `id_usulan`, `tingkat_kesulitan`, `jumlah_volume_kegiatan`, `id_unsur`, `status`, `bukti_kegiatan`, `keterangan`) VALUES
(3,	'2018-07-01',	'2019-02-01',	'Mengelola perpustakaan Besar',	'Hari',	0,	1,	0,	20,	10,	26,	'Perpustakaan',	1,	'Susah',	130,	2,	NULL,	'270219020746080800.jpeg',	''),
(4,	'2019-02-02',	'2019-02-04',	'Mengikuti seminar kepustakawan',	'hari',	0,	0.12,	0,	20,	0.5,	0.576,	'Padang Panjang',	1,	'Lumayan',	24,	6,	NULL,	'270219021008729000.jpg',	''),
(5,	'2014-02-01',	'2017-02-01',	'Mengikuti pendidikan S1',	'Hari',	0,	0,	0,	0,	15,	0,	'Surabaya',	1,	'Susah',	768,	10,	NULL,	'270219021121265200.jpeg',	''),
(6,	'2019-02-08',	'2019-02-08',	'dfsdfs',	'sdf',	1,	0,	10,	0,	1.2,	0,	'asdsd',	1,	'eere',	12,	4,	NULL,	'270219154855768000.jpg',	'');

-- 2019-03-01 09:55:26
