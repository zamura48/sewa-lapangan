/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 8.0.30 : Database - sewa-lapangan
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sewa-lapangan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `sewa-lapangan`;

/*Table structure for table `bookings` */

DROP TABLE IF EXISTS `bookings`;

CREATE TABLE `bookings` (
  `booking_id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_pelanggan` varchar(50) NOT NULL,
  `id_jadwal` varchar(50) NOT NULL,
  `harga` int DEFAULT NULL,
  `subtotal` int DEFAULT NULL,
  PRIMARY KEY (`booking_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb3;

/*Data for the table `bookings` */

insert  into `bookings`(`booking_id`,`id_pelanggan`,`id_jadwal`,`harga`,`subtotal`) values 
(36,'2','27',70000,70000),
(37,'2','28',70000,70000),
(39,'2','30',70000,70000),
(40,'2','32',35000,35000),
(41,'2','33',35000,NULL);

/*Table structure for table `jadwals` */

DROP TABLE IF EXISTS `jadwals`;

CREATE TABLE `jadwals` (
  `jadwal_id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_jam` varchar(50) NOT NULL,
  `id_lapangan` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `harga` int NOT NULL,
  `status_booking` varchar(50) NOT NULL,
  PRIMARY KEY (`jadwal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb3;

/*Data for the table `jadwals` */

insert  into `jadwals`(`jadwal_id`,`id_jam`,`id_lapangan`,`tanggal`,`harga`,`status_booking`) values 
(1,'1','2','2023-02-24',50000,'Selesai'),
(2,'2','2','2023-02-26',150000,'0'),
(4,'4','8','2023-02-15',100000,'Selesai'),
(6,'5','2','2023-02-28',22,'Selesai'),
(20,'25','2','2023-04-12',70000,'Batal'),
(27,'32','2','2023-05-19',70000,'Selesai'),
(28,'33','2','2023-04-12',70000,'Selesai'),
(30,'35','2','2023-04-21',70000,'Selesai'),
(31,'36','3','2023-05-09',35000,'Selesai'),
(32,'37','3','2023-05-10',35000,'Selesai'),
(33,'38','3','2023-05-10',35000,'Batal');

/*Table structure for table `jams` */

DROP TABLE IF EXISTS `jams`;

CREATE TABLE `jams` (
  `jam_id` int unsigned NOT NULL AUTO_INCREMENT,
  `jamMulai` varchar(50) NOT NULL,
  `jamAkhir` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`jam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb3;

/*Data for the table `jams` */

insert  into `jams`(`jam_id`,`jamMulai`,`jamAkhir`) values 
(1,'17:00','19:00'),
(2,'8:00','10:00'),
(4,'12:10','14:10'),
(5,'12:10','14:10'),
(6,'15:45','18:45'),
(7,'15:45','18:45'),
(8,'15:45','18:00'),
(9,'15:45','18:00'),
(10,'15:45','18:00'),
(24,'10:32','12:32'),
(25,'10:32','12:32'),
(32,'08:38','10:38'),
(33,'10:40','12:40'),
(35,'09:55','11:55'),
(36,'12:00','13:00'),
(37,'08:00','09:00'),
(38,'20:00','21:00');

/*Table structure for table `lapangans` */

DROP TABLE IF EXISTS `lapangans`;

CREATE TABLE `lapangans` (
  `lapangan_id` int unsigned NOT NULL AUTO_INCREMENT,
  `nomor` int NOT NULL,
  `harga` int DEFAULT NULL,
  `gambar` varchar(50) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`lapangan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

/*Data for the table `lapangans` */

insert  into `lapangans`(`lapangan_id`,`nomor`,`harga`,`gambar`,`status`) values 
(2,1,35000,'123.png',0),
(3,2,35000,'1648515746635.jpg',0),
(4,3,35000,'1646102519626-c9e33f22-6f60-4a4c-8b4c-46e4323a5c47',0),
(5,4,35000,'123.png',0),
(6,5,35000,'123.png',0),
(7,6,35000,'123.png',0),
(8,7,35000,'123.png',0);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb3;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`version`,`class`,`group`,`namespace`,`time`,`batch`) values 
(36,'2023-02-21-044312','App\\Database\\Migrations\\Pelanggan','default','App',1677134167,1),
(37,'2023-02-21-044319','App\\Database\\Migrations\\Booking','default','App',1677134167,1),
(38,'2023-02-21-044323','App\\Database\\Migrations\\Jadwal','default','App',1677134167,1),
(39,'2023-02-21-044330','App\\Database\\Migrations\\Lapangan','default','App',1677134167,1),
(40,'2023-02-21-044335','App\\Database\\Migrations\\Jam','default','App',1677134167,1),
(41,'2023-02-21-044343','App\\Database\\Migrations\\Pembayaran','default','App',1677134167,1),
(42,'2023-02-21-044553','App\\Database\\Migrations\\User','default','App',1677134167,1);

/*Table structure for table `pelanggans` */

DROP TABLE IF EXISTS `pelanggans`;

CREATE TABLE `pelanggans` (
  `pelanggan_id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `noHp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pelanggan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

/*Data for the table `pelanggans` */

insert  into `pelanggans`(`pelanggan_id`,`id_user`,`nama`,`noHp`,`alamat`,`foto`) values 
(2,'2','pelanggan ni bos','088217643823','jalan jalan','16836826569.jpg'),
(3,'3','Admin','088217643823','aasdasd',NULL),
(4,'4','Owner','088217643823','owner',NULL);

/*Table structure for table `pembayarans` */

DROP TABLE IF EXISTS `pembayarans`;

CREATE TABLE `pembayarans` (
  `pembayaran_id` int unsigned NOT NULL AUTO_INCREMENT,
  `kode_pembayaran` varchar(50) NOT NULL,
  `id_booking` varchar(50) NOT NULL,
  `payment_method` enum('CASH','DP') DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `no_rek` varchar(50) DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`pembayaran_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb3;

/*Data for the table `pembayarans` */

insert  into `pembayarans`(`pembayaran_id`,`kode_pembayaran`,`id_booking`,`payment_method`,`payment_type`,`no_rek`,`status`) values 
(66,'TRX-20230412610','36','CASH',NULL,NULL,'Terbayar'),
(67,'TRX-20230412716','37','CASH',NULL,NULL,'Terbayar'),
(68,'TRX-20230419485','39','CASH',NULL,NULL,'Terbayar'),
(69,'TRX-20230509280','40','CASH',NULL,NULL,'Terbayar');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

/*Data for the table `users` */

insert  into `users`(`user_id`,`role`,`username`,`email`,`password`,`is_aktif`) values 
(2,'Pelanggan','pelanggan','pelanggan@gmail.com','$2y$10$5/B0cR1JOK7IUSGE1CI90eUsaQ8db9NeBHMbJz/hfcHL8vaPrTwne',1),
(3,'Admin','admin','admin@gmail.com','$2y$10$8H4t4ACsekgc/weEU4bT1ectPNGQutcH4DrxgIIsfYg9g0VdjIV7i',1),
(4,'Owner','owner','owner@gmail.com','$2y$10$SkwxSuUlOJraaqhDDo0YZ.7D7R3QJen4g4PSgCBFOkPsAwn.DOP8m',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
