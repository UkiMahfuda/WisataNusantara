/*
SQLyog Enterprise v13.1.1 (64 bit)
MySQL - 10.4.27-MariaDB : Database - db_pariwisata
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_pariwisata` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `db_pariwisata`;

/*Table structure for table `paket_wisata` */

DROP TABLE IF EXISTS `paket_wisata`;

CREATE TABLE `paket_wisata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_paket` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,0) NOT NULL,
  `durasi` varchar(50) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `paket_wisata` */

insert  into `paket_wisata`(`id`,`nama_paket`,`deskripsi`,`harga`,`durasi`,`gambar`) values 
(55,'Wisata Gunung Bromo','Gunung Bromo, yang berada di Taman Nasional Bromo Tengger Semeru, Jawa Timur, adalah salah satu gunung berapi paling terkenal di Indonesia. Wisata ini menawarkan pemandangan matahari terbit yang spektakuler dari Puncak Penanjakan, serta pengalaman mendaki kaldera Bromo yang luas.',1500000,'1','66b17e9b8bb36.jpg'),
(56,'Wisata Pulau Komodo','Pulau Komodo, yang terletak di Nusa Tenggara Timur, terkenal sebagai habitat asli hewan purba Komodo. Wisata ini menawarkan petualangan yang unik dengan trekking di alam liar untuk melihat komodo secara langsung. ',2000000,'1','66b17eb73c56a.jpg'),
(57,'Wisata Pulau Bali','Bali, sering disebut sebagai Pulau Dewata, adalah destinasi wisata populer di Indonesia. Pulau ini terkenal dengan pantai-pantai indah seperti Kuta, Seminyak, dan Nusa Dua, serta kekayaan budaya dan seni tradisionalnya. ',1750000,'1','66b17edd5e70a.jpg'),
(58,'Wisata Pulau Pahawang','Pulau Pahawang terletak di Provinsi Lampung dan terkenal dengan keindahan bawah lautnya. Wisata ini menawarkan pengalaman snorkeling dan diving yang memukau dengan terumbu karang yang masih terjaga serta berbagai jenis ikan hias yang berwarna-warni.',750000,'1','66b17ef95f8a1.jpg'),
(59,'Wisata Candi Borobudur','Candi Borobudur adalah salah satu situs warisan dunia UNESCO yang terletak di Magelang, Jawa Tengah. Candi ini merupakan candi Buddha terbesar di dunia dan memiliki arsitektur yang sangat megah dengan relief-relief yang menceritakan kehidupan Buddha. ',1000000,'1','66b17f155f3dd.jpg');

/*Table structure for table `pemesanan` */

DROP TABLE IF EXISTS `pemesanan`;

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `tanggal_pemesanan` varchar(255) NOT NULL,
  `jumlah_orang` char(2) NOT NULL,
  `total_harga` char(255) NOT NULL,
  `jumlah_hari` char(2) DEFAULT NULL,
  `transportasi` tinyint(255) DEFAULT 0,
  `makan` tinyint(255) DEFAULT 0,
  `penginapan` tinyint(255) DEFAULT 0,
  PRIMARY KEY (`id_pemesanan`),
  KEY `id_user` (`id_user`),
  KEY `id_paket` (`id_paket`),
  CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`id_paket`) REFERENCES `paket_wisata` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pemesanan` */

insert  into `pemesanan`(`id_pemesanan`,`id_user`,`id_paket`,`tanggal_pemesanan`,`jumlah_orang`,`total_harga`,`jumlah_hari`,`transportasi`,`makan`,`penginapan`) values 
(32,38,57,'2024-08-10','2','39500000','5',1,0,1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `admin` char(2) DEFAULT '0',
  PRIMARY KEY (`id`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`admin`) values 
(36,'Admin','admin@gmail.com','$2y$10$kpWxYmKMrUMymXEhTV8WyOx5/8CAf9ZhVcyKEeabrIvGaMCo7aCjK','1'),
(38,'User','user@gmail.com','$2y$10$ASwfHdcDNvK9vje6QJwr7.jri4Q6KSoiuClLOGO5dXGO5rn.odyVW','');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
