-- MySQL dump 10.14  Distrib 5.5.50-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: pancake
-- ------------------------------------------------------
-- Server version	5.5.50-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `level` tinyint(3) unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` tinyint(3) unsigned DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,0,1,'Children','children',1,'Active','2016-06-03 11:58:30','2016-10-22 12:10:38'),(2,0,1,'Small size','small-size',2,'Active','2016-06-03 12:08:25','2016-10-22 12:10:55'),(3,0,1,'Medium size','medium-size',3,'Active','2016-06-03 12:10:39','2016-10-22 12:13:13'),(4,0,1,'Big size','big-size',4,'Active','2016-07-16 12:09:26','2016-10-22 12:13:38'),(5,0,1,'Double size','double-size',5,'Active','2016-07-16 12:11:11','2016-10-22 12:13:54'),(6,0,1,'Khác','khac',6,'Active','2016-07-16 12:11:49','2016-10-22 12:14:14');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `president` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `capital` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_number` int(11) DEFAULT NULL,
  `description` varchar(2550) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `logo` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` varchar(2550) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_tel` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(50) CHARACTER SET utf8 DEFAULT 'Việt Nam',
  `zip_code` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `prefecture` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `district` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `building` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `favicon` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_mail` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'comp1','Company 1','Company 1',NULL,1,'Company 1\r\n\r\nolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklth\r\nr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkol\r\n','/image/company/1/1_thumbnail.png','/image/company/1/1_logo.png','Company 1\r\n\r\nolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklth\r\nr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkol\r\n','comp1@pancake.vn','testtest','http://comp1.pancake.vn/','0545644648',' ','Việt Nam',' ','東京都','TP. Hồ Chí Minh','Quận 1','Số 138-142 Hai Bà Trưng, Phường Đa Kao','Tầng 15, Tòa nhà Empress','Active','2016-05-02 06:56:09','2016-10-22 11:46:21',NULL),(2,'comp2','Company 2','Company 2',NULL,1,'Company 2\r\n\r\nolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklth\r\nr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkol\r\n','/image/company/3/3_thumbnail.png','/image/company/3/3_logo.png',NULL,'comp2@pancake.vn','12345678','http://comp2.pancake.vn/','54516546846',' ','Việt Nam',' ','0','Hồ Chí Minh','Gò Vấp','1278 Quang Trung, Phường 14',' ','Active','2016-05-02 08:07:59','2016-10-22 11:47:21',NULL),(3,'comp3','Company 3','Company 3',NULL,1,'Company 3\r\n\r\nolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklth\r\nr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkol\r\n','/image/company/5/5_thumbnail.png','/image/company/5/5_logo.png','<p>備考備考備考</p>\r\n\r\n<p>備考</p>\r\n','comp3@pancake.vn','$2y$10$VHmLKvMmAmg5GwmCvrWkru/ejJJzwEiwKddpYsZICumwWAF8lgRse','http://comp3.pancake.vn','545436453',' ','Việt Nam',' ',' ','Hồ Chí Minh','Quận 07','Lô 29B-31B-33B, Đường Tân Thuận, KCX Tân Thuận, Phường Tân Thuận Đông','','Active','2016-05-07 00:51:58','2016-10-22 12:02:39',NULL),(4,'comp4','Company 4','Company 4',NULL,NULL,'Company 4\r\n\r\nolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklth\r\nr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkol\r\n','/image/company/7/7_thumbnail.png','/image/company/7/7_logo.png',NULL,'comp4@pancake.vn','$2y$10$YlSG1FmNnhuPyeOEj1JXk.cs7EJohFfAxznpmy4XH4fA8fx5Hraci','http://comp4.pancake.vn/',NULL,'3454','Việt Nam',NULL,NULL,'Hồ Chí Minh','1','99 Nguyễn Thị Minh Khai',NULL,'Active','2016-10-12 07:28:49','2016-10-22 12:02:57',NULL),(5,'comp5','Company 5','Company 5',NULL,NULL,'Company 5\r\n\r\nolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklth\r\nr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkol\r\n','/image/company/8/8_thumbnail.png','/image/company/8/8_logo.png',NULL,'comp5@pancake.vn','','http://comp5.pancake.vn/',NULL,NULL,'Việt Nam',NULL,NULL,NULL,NULL,NULL,NULL,'Active','2016-10-22 11:49:31','2016-10-22 12:03:13',NULL),(6,'comp6','Company 6','Company 6',NULL,NULL,'Company 6\r\n\r\nolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklth\r\nr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkolr trt rltmklhm oltkol\r\n','/image/company/9/9_thumbnail.png','/image/company/9/9_logo.png',NULL,'comp6@pancake.vn','','http://comp6.pancake.vn/',NULL,NULL,'Việt Nam',NULL,NULL,NULL,NULL,NULL,NULL,'Active','2016-10-22 11:50:06','2016-10-22 12:03:22',NULL);
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` enum('Male','Female') COLLATE utf8_unicode_ci DEFAULT 'Male',
  `birthday` date DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `images` text COLLATE utf8_unicode_ci,
  `short_description` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `zip_code` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `prefecture` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `building` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `members_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'nam@pancake.vn','$2y$10$Nm5qlFp8MBh6B/cpY7lraOSgthe.PMEDvA/6RdOzNaaDQwUZodlxS','Ngoc Nam','Nguyen','0868934520','','2016-01-04',NULL,NULL,NULL,'Short','Full description',NULL,NULL,NULL,NULL,NULL,'Active','3PvCDOjWzYHimUX8LYvMW7pruZbmNnipwZTWdnA041ezR9RnkZvaYCDPkmqZ','2016-06-12 08:40:08','2016-10-22 10:59:17'),(2,'ngocnam.facebook@yahoo.com.vn','','','',NULL,'Male',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Active','F4rEKDQd5L2CkXpOANGzWLCCxNHGSbmYP0raMUCp4QSFjs6uyuDRie15PnyW','2016-07-04 06:02:42','2016-07-06 08:26:41');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2016_05_01_145615_create_products_table',1),('2016_05_01_155852_create_companies_table',2),('2016_05_05_192111_create_members_table',3),('2016_05_06_190932_create_categories_table',4),('2016_05_25_154433_create_videos_table',4),('2016_06_03_174832_create_administrators_table',4),('2016_07_04_124637_create_social_accounts_table',5),('2016_07_04_170525_contact',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) DEFAULT NULL,
  `category_id` int(10) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `market_price` int(20) DEFAULT NULL,
  `price` int(20) DEFAULT NULL,
  `down_percent` enum('Special','25','50','75','80','90') DEFAULT 'Special',
  `quantity` int(11) DEFAULT NULL,
  `max_quantity` int(11) DEFAULT NULL,
  `short_description` mediumtext,
  `description` mediumtext,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `rate` tinyint(1) DEFAULT '0',
  `expired_datetime` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,3,NULL,NULL,'/image/product/1/1_thumbnail.jpg','/image/product/1/1_logo.jpg','Pancake Clipart 1',1000,800,'Special',NULL,NULL,NULL,NULL,'Active',0,NULL,'2016-10-22 12:24:57','2016-10-22 12:25:10'),(2,1,1,NULL,NULL,'/image/product/2/2_thumbnail.jpg','/image/product/2/2_logo.jpg','Pancake Clipart 2',52013,46516,'Special',NULL,NULL,'Pancake Clipart 2',NULL,'Active',0,NULL,'2016-10-22 12:30:33','2016-10-22 12:30:43'),(3,1,1,NULL,NULL,'/image/product/3/3_thumbnail.jpg','/image/product/3/3_logo.jpg','Pancake Clipart 3',60000,55000,'Special',NULL,NULL,NULL,NULL,'Active',0,NULL,'2016-10-22 12:31:23','2016-10-22 12:31:34'),(4,1,1,NULL,NULL,'/image/product/4/4_thumbnail.jpg','/image/product/4/4_logo.jpg','Pancake Clipart 4',700000,600000,'Special',NULL,NULL,'Pancake Clipart 4',NULL,'Active',0,NULL,'2016-10-22 12:31:56','2016-10-22 12:32:05'),(5,1,1,NULL,NULL,'/image/product/5/5_thumbnail.jpg','/image/product/5/5_logo.jpg','Pancake Clipart 5',90000,80000,'Special',NULL,NULL,'Pancake Clipart 5',NULL,'Active',0,NULL,'2016-10-22 12:32:26','2016-10-22 12:32:41'),(6,1,1,NULL,NULL,'/image/product/6/6_thumbnail.jpg','/image/product/6/6_logo.jpg','Pancake Clipart 6',75000,60000,'Special',NULL,NULL,'Pancake Clipart 6',NULL,'Active',0,NULL,'2016-10-22 12:33:08','2016-10-22 12:33:24'),(7,1,1,NULL,NULL,'/image/product/7/7_thumbnail.jpg','/image/product/7/7_logo.jpg','Pancake Clipart 7',60000,54000,'Special',NULL,NULL,'Pancake Clipart 7',NULL,'Active',0,NULL,'2016-10-22 12:34:12','2016-10-22 12:34:35'),(8,1,1,NULL,NULL,'/image/product/8/8_thumbnail.jpg','/image/product/8/8_logo.jpg','Pancake Clipart 8',5000,4000,'Special',NULL,NULL,'Pancake Clipart 8',NULL,'Active',0,NULL,'2016-10-22 12:34:59','2016-10-22 12:35:08'),(9,1,1,NULL,NULL,'/image/product/9/9_thumbnail.jpg','/image/product/9/9_logo.jpg','Pancake Clipart 9',88888,77777,'Special',NULL,NULL,'Pancake Clipart 9','Pancake Clipart 9','Active',0,NULL,'2016-10-22 12:41:00','2016-10-22 12:41:13'),(10,1,1,NULL,NULL,'/image/product/10/10_thumbnail.jpg','/image/product/10/10_logo.jpg','Pancake Clipart 10',90000,85000,'Special',NULL,NULL,'Pancake Clipart 10','Pancake Clipart 10','Active',0,NULL,'2016-10-22 12:41:43','2016-10-22 12:45:44'),(11,1,1,NULL,NULL,'/image/product/11/11_thumbnail.jpg','/image/product/11/11_logo.jpg','Pancake Clipart 11',11100,11000,'Special',NULL,NULL,'Pancake Clipart 11','Pancake Clipart 11','Active',0,NULL,'2016-10-22 12:42:12','2016-10-22 12:42:23'),(12,1,1,NULL,NULL,'/image/product/12/12_thumbnail.jpg','/image/product/12/12_logo.jpg','Pancake Clipart 12',12200,12000,'Special',NULL,NULL,'Pancake Clipart 12','Pancake Clipart 12','Active',0,NULL,'2016-10-22 12:42:47','2016-10-22 12:42:57'),(13,1,1,NULL,NULL,'/image/product/13/13_thumbnail.jpg','/image/product/13/13_logo.jpg','Pancake Clipart 13',500000,200000,'Special',NULL,NULL,'Pancake Clipart 13','Pancake Clipart 13','Active',0,NULL,'2016-10-22 12:43:31','2016-10-22 12:43:40'),(14,1,1,NULL,NULL,'/image/product/14/14_thumbnail.jpg','/image/product/14/14_logo.jpg','Pancake Clipart 14',90000,2000,'Special',NULL,NULL,'Pancake Clipart 14','Pancake Clipart 14','Active',0,NULL,'2016-10-22 12:44:07','2016-10-22 12:44:17'),(15,1,1,NULL,NULL,'/image/product/15/15_thumbnail.jpg','/image/product/15/15_logo.jpg','Pancake Clipart 15',50000,30000,'Special',NULL,NULL,'Pancake Clipart 15','Pancake Clipart 15','Active',0,NULL,'2016-10-22 12:44:52','2016-10-22 12:45:00'),(16,1,1,NULL,NULL,'/image/product/16/16_thumbnail.jpg','/image/product/16/16_logo.jpg','Pancake Clipart 16',60000,30000,'Special',NULL,NULL,'Pancake Clipart 16','Pancake Clipart 16','Active',0,NULL,'2016-10-22 12:45:19','2016-10-22 12:45:26'),(17,1,1,NULL,NULL,NULL,NULL,'Pancake Clipart 17',700000,500000,'Special',NULL,NULL,'Pancake Clipart 17','Pancake Clipart 17','Active',0,NULL,'2016-10-22 12:46:18','2016-10-22 12:46:18'),(18,1,1,NULL,NULL,'/image/product/18/18_thumbnail.jpg','/image/product/18/18_logo.jpg','Pancake Clipart 18',10000,2000,'Special',NULL,NULL,'Pancake Clipart 18','Pancake Clipart 18','Active',0,NULL,'2016-10-22 12:49:04','2016-10-22 12:49:25');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_accounts`
--

DROP TABLE IF EXISTS `social_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_accounts` (
  `user_id` int(11) NOT NULL,
  `provider_user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider` enum('facebook','google') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'facebook',
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `social_accounts_user_id_unique` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_accounts`
--

LOCK TABLES `social_accounts` WRITE;
/*!40000 ALTER TABLE `social_accounts` DISABLE KEYS */;
INSERT INTO `social_accounts` VALUES (2,'1151904738182456','facebook','Active','2016-07-04 06:32:23','2016-07-04 06:32:23');
/*!40000 ALTER TABLE `social_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-23  2:51:09
