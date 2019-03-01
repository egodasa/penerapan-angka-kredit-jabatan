-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `tbl_detail_pesan`;
CREATE TABLE `tbl_detail_pesan` (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_pesan` varchar(50) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`id_detail`),
  KEY `id_pesan` (`id_pesan`),
  KEY `id_menu` (`id_menu`),
  CONSTRAINT `tbl_detail_pesan_ibfk_1` FOREIGN KEY (`id_pesan`) REFERENCES `tbl_pesan` (`id_pesan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_detail_pesan_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `tbl_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_detail_pesan` (`id_detail`, `id_pesan`, `id_menu`, `jumlah`) VALUES
(1,	'261218143618416800',	25,	1),
(2,	'030119091426062000',	17,	1),
(3,	'030119094431889500',	17,	1),
(4,	'030119094431889500',	18,	1),
(5,	'030119094431889500',	19,	1),
(6,	'030119214824000000',	2,	1);

DROP TABLE IF EXISTS `tbl_detail_pesan_tmp`;
CREATE TABLE `tbl_detail_pesan_tmp` (
  `id_tmp` int(11) NOT NULL AUTO_INCREMENT,
  `id_pesan` varchar(100) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`id_tmp`),
  KEY `id_pesan` (`id_pesan`),
  KEY `id_menu` (`id_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_detail_pesan_tmp` (`id_tmp`, `id_pesan`, `id_menu`, `jumlah`) VALUES
(7,	'030119094543434600',	17,	1),
(14,	'030119152609660200',	2,	1);

DROP TABLE IF EXISTS `tbl_kategori`;
CREATE TABLE `tbl_kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nm_kategori` varchar(50) NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_kategori` (`id_kategori`, `nm_kategori`) VALUES
(1,	'Minuman'),
(2,	'Makanan');

DROP TABLE IF EXISTS `tbl_meja`;
CREATE TABLE `tbl_meja` (
  `id_meja` int(11) NOT NULL AUTO_INCREMENT,
  `nm_meja` varchar(10) NOT NULL,
  `kd_meja` varchar(10) NOT NULL,
  PRIMARY KEY (`id_meja`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_meja` (`id_meja`, `nm_meja`, `kd_meja`) VALUES
(2,	'Meja 1',	'12345'),
(3,	'Meja 2',	'43214'),
(4,	'Meja 3',	'02881'),
(5,	'Meja 4',	'00001'),
(6,	'Meja 5',	'27171'),
(7,	'Meja 6',	'38274'),
(8,	'Meja 7',	'31890'),
(9,	'Meja 8',	'48991'),
(10,	'Meja 9',	'49911'),
(11,	'Meja 10',	'48992'),
(12,	'Meja 11',	'31412'),
(13,	'Meja 12',	'129431'),
(14,	'Meja 13',	'83012'),
(15,	'Meja 14',	'12392'),
(16,	'Meja 15',	'M10A3'),
(17,	'Meja 16',	'KFC71'),
(18,	'Meja 17',	'F14A3'),
(19,	'Meja 18',	'A10F1'),
(20,	'Meja 19',	'19MJA'),
(21,	'Meja 20',	'MJA20');

DROP TABLE IF EXISTS `tbl_menu`;
CREATE TABLE `tbl_menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` int(11) NOT NULL,
  `gambar` text NOT NULL,
  PRIMARY KEY (`id_menu`),
  KEY `id_kategori` (`id_kategori`),
  CONSTRAINT `tbl_menu_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `tbl_kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_menu` (`id_menu`, `nama`, `id_kategori`, `deskripsi`, `harga`, `gambar`) VALUES
(2,	'Ayam Bakar Paha',	2,	'Ayam Bakar Paha',	12000,	'261218133248164100.jpg'),
(3,	'Ayam Bakar Paha + Nasi',	2,	'Ayam Bakar Paha + Nasi',	18000,	'261218133321640800.jpg'),
(4,	'Ayam Bakar Dada',	2,	'Ayam Bakar Dada',	14000,	'261218133452780400.jpg'),
(5,	'Ayam Bakar Dada + Nasi',	2,	'Ayam Bakar Dada + Nasi',	20000,	'261218133554922700.jpg'),
(6,	'Ayam Penyet Dada',	2,	'Ayam Penyet Dada',	13000,	'261218133719425800.jpg'),
(7,	'Ayam Penyet Dada + Nasi',	2,	'Ayam Penyet Dada + Nasi',	18000,	'261218133810417600.jpg'),
(8,	'Ayam Penyet Paha',	2,	'Ayam Penyet Paha',	12000,	'261218134045165500.jpg'),
(9,	'Ayam Penyet Paha + Nasi',	2,	'Ayam Penyet Paha + Nasi',	18000,	'261218134107521100.jpg'),
(10,	'Ikan Bakar',	2,	'Ikan bakar',	13000,	'261218134927690600.jpg'),
(11,	'Ikan Bakar + Nasi',	2,	'Ikan bakar + nasi',	18000,	'261218134956037400.jpg'),
(12,	'Pecel Lele',	2,	'Pecel lele',	14000,	'261218135014643800.jpg'),
(13,	'Pecel Lele + Nasi',	2,	'Pecel lele + nasi',	20000,	'261218135039819600.jpg'),
(14,	'Cah Kangkung',	2,	'Cah kangkung',	6000,	'261218135108255000.jpg'),
(15,	'Soto',	2,	'Soto',	15000,	'261218135129908800.jpg'),
(16,	'Soto Nasi',	2,	'Soto nasi',	18000,	'261218135148928400.jpg'),
(17,	'Teh Tarik Es',	1,	'Teh Tarik Es',	7000,	'261218140206423200.jpg'),
(18,	'Teh Tarik Panas',	1,	'Teh Tarik Panas',	7000,	'261218140229338000.jpg'),
(19,	'Teh Telur',	1,	'Teh Telur',	10000,	'261218140251429900.jpg'),
(20,	'Jus Pokat',	1,	'Jus pokat',	10000,	'261218140313996200.jpg'),
(21,	'Jus Mangga',	1,	'Jus mangga',	12000,	'261218140335227600.jpg'),
(22,	'Jus Tomat',	1,	'Jus Tomat',	7000,	'261218140401818600.jpg'),
(23,	'Jus Timun',	1,	'Jus Timun',	7000,	'261218140457541300.jpg'),
(24,	'Jus Jeruk',	1,	'Jus Jeruk',	10000,	'261218140523228000.jpg'),
(25,	'Teh Es',	1,	'Teh es',	5000,	'261218140548237500.jpg'),
(26,	'Kopi Es',	1,	'Kopi Es',	6000,	'261218140618621800.jpg'),
(27,	'Kopi Panas',	1,	'Kopi Panas',	5000,	'261218140640904300.jpg'),
(28,	'Kopi Susu',	1,	'Kopi Susu',	6000,	'261218140701948800.jpg'),
(29,	'Kopi Susu Es',	1,	'Kopi Susu Es',	7000,	'261218140731522100.jpg'),
(30,	'Teh Susu',	1,	'Teh Susu',	6000,	'261218142046035900.jpg'),
(31,	'Teh Susu Es',	1,	'Teh Susu Es',	7000,	'261218142134178000.jpg'),
(32,	'Susu Panas',	1,	'Susu Panas',	5000,	'261218142157815600.jpg'),
(33,	'Susu Es',	1,	'Susu Es',	7000,	'261218142221418500.jpg'),
(34,	'Jeruk Panas',	1,	'Jeruk Panas',	10000,	'261218142247016300.jpg'),
(35,	'Cappucino Es',	1,	'Cappucino Es',	7000,	'261218142308960700.jpg'),
(36,	'Cappucino Panas',	1,	'Cappucino Panas',	6000,	'261218142331682000.jpg'),
(37,	'Es Lemon Tea',	1,	'Es Lemon Tea',	7000,	'261218142357524400.jpg'),
(38,	'Susu Extra Joss',	1,	'Susu Extra Joss',	7000,	'261218142416654300.jpg'),
(39,	'Jus Naga',	1,	'Jus Naga',	10000,	'261218142440188200.jpg'),
(40,	'Jus Terong Pirus',	1,	'Jus Terong Pirus',	10000,	'261218142500222500.jpg'),
(41,	'Jeruk Nipis Es',	1,	'Jeruk Nipis Es',	7000,	'261218142517672900.jpg'),
(42,	'Jus Sirsak',	1,	'Jus Sirsak',	10000,	'261218142539952800.jpg'),
(43,	'Jus Melon',	1,	'Jus Melon',	100000,	'261218142600847000.jpg'),
(44,	'Jus Nenas',	1,	'Jus Nenas',	10000,	'261218142622119300.jpg'),
(45,	'Jus Apel',	1,	'Jus Apel',	12000,	'261218142643529100.jpg'),
(46,	'Jus Pepaya',	1,	'Jus Pepaya',	10000,	'261218142702793900.jpg'),
(47,	'Jus Bengkuang',	1,	'Jus Bengkuang',	100000,	'261218142721594700.jpg');

DROP TABLE IF EXISTS `tbl_pesan`;
CREATE TABLE `tbl_pesan` (
  `id_pesan` varchar(50) NOT NULL,
  `tanggal_pesan` datetime NOT NULL,
  `nama_pemesan` varchar(100) NOT NULL,
  `status_pesanan` enum('Belum Dibayar','Sudah Dibayar','Hidangan Sedang Disiapkan','Hidangan Sudah Siap') NOT NULL DEFAULT 'Belum Dibayar',
  `id_meja` int(11) NOT NULL,
  `dibayar` int(11) NOT NULL DEFAULT '0',
  `kembalian` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pesan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_pesan` (`id_pesan`, `tanggal_pesan`, `nama_pemesan`, `status_pesanan`, `id_meja`, `dibayar`, `kembalian`) VALUES
('030119091426062000',	'2019-01-03 16:22:23',	'Mai',	'Sudah Dibayar',	5,	50000,	43000),
('030119094431889500',	'2019-01-03 16:45:43',	'ajo',	'Hidangan Sudah Siap',	2,	120000,	96000),
('030119214824000000',	'2019-01-03 21:50:40',	'Budiman',	'Belum Dibayar',	2,	0,	0),
('261218143618416800',	'2018-12-26 21:42:51',	'Mai',	'',	2,	6000,	1000);

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL,
  `password` text NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `nohp` varchar(15) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `level` enum('Kasir','Dapur') NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_user` (`id_user`, `username`, `password`, `nama`, `jk`, `nohp`, `alamat`, `level`) VALUES
(1,	'kasir',	'c7911af3adbd12a035b289556d96470a',	'Kasir',	'Perempuan',	'65343',	'ALamat rumah',	'Kasir'),
(2,	'dapur',	'de20b1d289dd6005ba8116085122f144',	'Dapur',	'Laki-laki',	'098766',	'Alamat Dapur',	'Dapur'),
(3,	'ajo',	'773f25d9509bc4cffd75d843db03c4f4',	'ajo kudun',	'Laki-laki',	'081373652309',	'padang',	'Kasir');

-- 2019-01-03 16:39:54
