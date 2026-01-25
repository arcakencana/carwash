/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.11.9-MariaDB-log : Database - carwash
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `cache` */

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

/*Table structure for table `cache_locks` */

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache_locks` */

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `job_batches` */

DROP TABLE IF EXISTS `job_batches`;

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `job_batches` */

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

/*Table structure for table `master_barang` */

DROP TABLE IF EXISTS `master_barang`;

CREATE TABLE `master_barang` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `harga_modal` int(11) NOT NULL DEFAULT 0,
  `harga_jual` int(11) NOT NULL DEFAULT 0,
  `kategori` enum('primary','secondary') NOT NULL DEFAULT 'primary',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `master_barang` */

insert  into `master_barang`(`id`,`nama`,`harga_modal`,`harga_jual`,`kategori`,`created_at`,`updated_at`) values 
(1,'BODY WASH SMALL',50000,50000,'primary','2026-01-25 16:04:22','2026-01-25 16:04:22'),
(2,'BODY WASH LARGE',60000,60000,'primary','2026-01-25 16:04:22','2026-01-25 16:04:22'),
(3,'BASIC WASH SMALL',70000,70000,'primary','2026-01-25 16:04:22','2026-01-25 16:04:22'),
(4,'BASIC WASH LARGE',80000,80000,'primary','2026-01-25 16:04:22','2026-01-25 16:04:22'),
(5,'PREMIUM WASH SMALL',100000,100000,'primary','2026-01-25 16:04:22','2026-01-25 16:04:22'),
(6,'PREMIUM WASH LARGE',110000,110000,'primary','2026-01-25 16:04:22','2026-01-25 16:04:22'),
(7,'PREMIUM WASH PLUS SMALL',150000,150000,'primary','2026-01-25 16:04:22','2026-01-25 16:04:22'),
(8,'PREMIUM WASH PLUS LARGE',160000,160000,'primary','2026-01-25 16:04:22','2026-01-25 16:04:22'),
(9,'ENGINE CLEANING',150000,150000,'primary','2026-01-25 16:04:22','2026-01-25 16:04:22'),
(10,'CAR FOGGING',50000,50000,'primary','2026-01-25 16:04:22','2026-01-25 16:04:22'),
(11,'MOTOR MATIC & BEBEK',20000,20000,'primary','2026-01-25 16:04:22','2026-01-25 16:04:22'),
(12,'MOTOR SPORT 150 & 200CC',30000,30000,'primary','2026-01-25 16:04:22','2026-01-25 16:04:22'),
(13,'MOTOR 250CC UP',50000,50000,'primary','2026-01-25 16:04:22','2026-01-25 16:04:22');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2025_10_28_131704_create_master_barang_table',1),
(5,'2026_01_25_132733_create_transaksi_table',1),
(6,'2026_01_25_132820_create_transaksi_items_table',1);

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values 
('BysAF6iYGLaYwu9ekRV1aU6qhvjI6uALdp1yn28K',NULL,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiamZ5WHBndXd1bmo4V29vMXpwWnFkQVBvbmtHWGF2cmhWWDNlMDNzMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3QvY2Fyd2FzaC9wdWJsaWMvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjQxOiJodHRwOi8vbG9jYWxob3N0L2Nhcndhc2gvcHVibGljL2Rhc2hib2FyZCI7fX0=',1769335453);

/*Table structure for table `transaksi` */

DROP TABLE IF EXISTS `transaksi`;

CREATE TABLE `transaksi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(255) NOT NULL,
  `no_polisi` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `total_harga` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaksi_kode_transaksi_unique` (`kode_transaksi`),
  KEY `transaksi_user_id_foreign` (`user_id`),
  CONSTRAINT `transaksi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `transaksi` */

insert  into `transaksi`(`id`,`kode_transaksi`,`no_polisi`,`tanggal`,`user_id`,`total_harga`,`created_at`,`updated_at`) values 
(1,'TRX-1769332710','BP1234AA','2026-01-25',1,20000,'2026-01-25 16:18:30','2026-01-25 16:18:30'),
(2,'TRX-1769334479','BP1235AA','2026-01-25',1,80000,'2026-01-25 16:47:59','2026-01-25 16:47:59');

/*Table structure for table `transaksi_items` */

DROP TABLE IF EXISTS `transaksi_items`;

CREATE TABLE `transaksi_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaksi_id` bigint(20) unsigned NOT NULL,
  `master_barang_id` bigint(20) unsigned NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaksi_items_transaksi_id_foreign` (`transaksi_id`),
  KEY `transaksi_items_master_barang_id_foreign` (`master_barang_id`),
  CONSTRAINT `transaksi_items_master_barang_id_foreign` FOREIGN KEY (`master_barang_id`) REFERENCES `master_barang` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaksi_items_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `transaksi_items` */

insert  into `transaksi_items`(`id`,`transaksi_id`,`master_barang_id`,`qty`,`harga`,`subtotal`,`created_at`,`updated_at`) values 
(1,1,11,1,20000,20000,'2026-01-25 16:18:30','2026-01-25 16:18:30'),
(2,2,4,1,80000,80000,'2026-01-25 16:47:59','2026-01-25 16:47:59');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','kasir','admin') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`role`,`remember_token`,`created_at`,`updated_at`) values 
(1,'User','user@example.com',NULL,'$2y$12$WFpWHuCUvZtlRRcOp6a4.OemSzz0NX5PmhFHxzN8W.5YyUNK6P.Gu','user',NULL,'2026-01-25 16:04:21','2026-01-25 16:04:21'),
(2,'Kasir','kasir@example.com',NULL,'$2y$12$5xW8mlez0cbXYG/o//wW7.iIeBffm2FzUogmWouAqM322r40wN0gu','kasir',NULL,'2026-01-25 16:04:22','2026-01-25 16:04:22'),
(3,'Admin','admin@example.com',NULL,'$2y$12$.tN.dRijNzsIm4p3g0Rk5ODSmv3PKuHbrMxMcVcoDvTaz68p3wNMe','admin',NULL,'2026-01-25 16:04:22','2026-01-25 16:04:22');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
