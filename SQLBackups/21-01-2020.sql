-- MySQL dump 10.13  Distrib 5.7.28, for Linux (x86_64)
--
-- Host: localhost    Database: real_estate
-- ------------------------------------------------------
-- Server version	5.7.28-0ubuntu0.18.04.4

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
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint(20) unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `method` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_log_log_name_index` (`log_name`),
  KEY `subject` (`subject_id`,`subject_type`),
  KEY `causer` (`causer_id`,`causer_type`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log`
--

LOCK TABLES `activity_log` WRITE;
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
INSERT INTO `activity_log` VALUES (1,'Bank Account Updated','Admin updated JS Bank',2,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','update','2020-01-03 08:01:24','2020-01-03 08:01:24'),(2,'Bank Account Deleted','Admin deleted JS Bank',2,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','delete','2020-01-03 08:02:53','2020-01-03 08:02:53'),(3,'User Updated','Admin updated his profile',1,'App\\User',1,'App\\User','users','[]','updateProfile','2020-01-03 08:43:27','2020-01-03 08:43:27'),(4,'Bank Account Added','Admin added new JS Bank',3,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','store','2020-01-03 08:47:18','2020-01-03 08:47:18'),(5,'Role Added','Admin added new sds',14,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 09:27:53','2020-01-03 09:27:53'),(6,'Role Added','Admin added new adsa',15,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 09:29:10','2020-01-03 09:29:10'),(7,'Role Deleted','Admin deleted sds',14,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 09:29:19','2020-01-03 09:29:19'),(8,'Role Deleted','Admin deleted sdd',13,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 09:29:21','2020-01-03 09:29:21'),(9,'User Deleted','Admin deleted Admin',8,'App\\User',1,'App\\User','users','[]','delete','2020-01-03 09:53:00','2020-01-03 09:53:00'),(10,'User Deleted','Admin deleted Admin',7,'App\\User',1,'App\\User','users','[]','delete','2020-01-03 09:53:02','2020-01-03 09:53:02'),(11,'User Deleted','Admin deleted Admin',4,'App\\User',1,'App\\User','users','[]','delete','2020-01-03 09:53:04','2020-01-03 09:53:04'),(12,'Role Added','Admin added new ads',16,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 09:56:15','2020-01-03 09:56:15'),(13,'Role Added','Admin added new sadads',17,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 09:58:20','2020-01-03 09:58:20'),(14,'Role Added','Admin added new asdasdsad',18,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 09:58:41','2020-01-03 09:58:41'),(15,'Role Added','Admin added new asdasd',19,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 10:04:09','2020-01-03 10:04:09'),(16,'Role Deleted','Admin deleted asdasd',19,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:06:03','2020-01-03 10:06:03'),(17,'Role Deleted','Admin deleted asdasdsad',18,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:06:04','2020-01-03 10:06:04'),(18,'Role Deleted','Admin deleted sadads',17,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:06:07','2020-01-03 10:06:07'),(19,'Role Deleted','Admin deleted ads',16,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:06:09','2020-01-03 10:06:09'),(20,'Role Deleted','Admin deleted adsa',15,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:06:16','2020-01-03 10:06:16'),(21,'Role Deleted','Admin deleted Employee',6,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:06:29','2020-01-03 10:06:29'),(22,'Role Added','Admin added new Employee',20,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 10:06:44','2020-01-03 10:06:44'),(23,'Role Deleted','Admin deleted Employee',20,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:07:40','2020-01-03 10:07:40'),(24,'Role Added','Admin added new sd',21,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 10:08:19','2020-01-03 10:08:19'),(25,'Role Added','Admin added new dsa',22,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 10:13:33','2020-01-03 10:13:33'),(26,'Tenant Added','Admin added new sda',2,'App\\Models\\Tenant',1,'App\\User','tenants','[]','store','2020-01-03 10:13:49','2020-01-03 10:13:49'),(27,'Tenant Deleted','Admin deleted sda',2,'App\\Models\\Tenant',1,'App\\User','tenants','[]','delete','2020-01-03 10:13:59','2020-01-03 10:13:59'),(28,'Role Deleted','Admin deleted dsa',22,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:14:05','2020-01-03 10:14:05'),(29,'Role Deleted','Admin deleted sd',21,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:14:06','2020-01-03 10:14:06'),(30,'Tenant Updated','Admin updated uzair khan',1,'App\\Models\\Tenant',1,'App\\User','tenants','[]','update','2020-01-03 10:18:13','2020-01-03 10:18:13'),(31,'Role Updated','Admin updated Admin',1,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-03 11:16:29','2020-01-03 11:16:29'),(32,'Lease Added','Admin added new Lease 2',2,'App\\Models\\Lease',1,'App\\User','leases','[]','store','2020-01-03 11:35:42','2020-01-03 11:35:42'),(33,'Lease Added','Admin added new Lease 2',3,'App\\Models\\Lease',1,'App\\User','leases','[]','store','2020-01-03 11:37:20','2020-01-03 11:37:20'),(34,'Invoice Added','Admin added new uzair khan invoice',7,'App\\Models\\Invoice',1,'App\\User','invoices','[]','store','2020-01-03 11:48:49','2020-01-03 11:48:49'),(35,'Lease Added','Admin added new Lease 3',4,'App\\Models\\Lease',1,'App\\User','leases','[]','store','2020-01-03 11:55:25','2020-01-03 11:55:25'),(36,'Invoice Update','Admin update uzair khan invoice',4,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-03 11:56:33','2020-01-03 11:56:33'),(37,'Role Updated','Admin updated Admin',1,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-06 02:44:51','2020-01-06 02:44:51'),(38,'Role Updated','Admin updated Admin',1,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-06 02:45:05','2020-01-06 02:45:05'),(39,'Role Updated','Admin updated Admin',1,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-06 02:48:26','2020-01-06 02:48:26'),(40,'Role Updated','Admin updated Admin',1,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-06 02:48:35','2020-01-06 02:48:35'),(41,'Role Updated','Admin updated Admin',1,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-06 02:48:46','2020-01-06 02:48:46'),(42,'Lease Updated','Admin updated Lease 2',3,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 03:12:02','2020-01-06 03:12:02'),(43,'Lease Updated','Admin updated Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 03:12:18','2020-01-06 03:12:18'),(44,'Role Added','Admin added new sda',5,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-06 03:22:25','2020-01-06 03:22:25'),(45,'Role Deleted','Admin deleted sda',5,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-06 03:22:33','2020-01-06 03:22:33'),(46,'Invoice Added','Admin added new uzair khan invoice',8,'App\\Models\\Invoice',1,'App\\User','invoices','[]','store','2020-01-06 04:00:08','2020-01-06 04:00:08'),(47,'Property Deleted','Admin deleted Property 2',5,'App\\Models\\Property',1,'App\\User','properties','[]','delete','2020-01-06 04:32:09','2020-01-06 04:32:09'),(48,'Property Updated','Admin updated Property 1',1,'App\\Models\\Property',1,'App\\User','properties','[]','update','2020-01-06 06:33:01','2020-01-06 06:33:01'),(49,'Property Updated','Admin updated Property 1',1,'App\\Models\\Property',1,'App\\User','properties','[]','update','2020-01-06 06:37:26','2020-01-06 06:37:26'),(50,'Property Updated','Admin updated Property 1',1,'App\\Models\\Property',1,'App\\User','properties','[]','update','2020-01-06 06:37:36','2020-01-06 06:37:36'),(51,'Property Updated','Admin updated Property 1',1,'App\\Models\\Property',1,'App\\User','properties','[]','update','2020-01-06 06:37:43','2020-01-06 06:37:43'),(52,'Invoice Update','Admin update M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-06 06:42:36','2020-01-06 06:42:36'),(53,'Lease Updated','Admin updated Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 06:48:26','2020-01-06 06:48:26'),(54,'Lease Updated','Admin updated Lease 2',3,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 06:48:32','2020-01-06 06:48:32'),(55,'Lease Updated','Admin updated Lease 3',4,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 06:48:39','2020-01-06 06:48:39'),(56,'Invoice Deleted','Admin deleted uzair khan invoice',8,'App\\Models\\Invoice',1,'App\\User','invoices','[]','delete','2020-01-06 06:49:41','2020-01-06 06:49:41'),(57,'Invoice Deleted','Admin deleted uzair khan invoice',7,'App\\Models\\Invoice',1,'App\\User','invoices','[]','delete','2020-01-06 06:49:45','2020-01-06 06:49:45'),(58,'Invoice Deleted','Admin deleted uzair khan invoice',4,'App\\Models\\Invoice',1,'App\\User','invoices','[]','delete','2020-01-06 06:49:48','2020-01-06 06:49:48'),(59,'Invoice Deleted','Admin deleted uzair khan invoice',3,'App\\Models\\Invoice',1,'App\\User','invoices','[]','delete','2020-01-06 06:49:51','2020-01-06 06:49:51'),(60,'Invoice Deleted','Admin deleted uzair khan invoice',1,'App\\Models\\Invoice',1,'App\\User','invoices','[]','delete','2020-01-06 06:49:55','2020-01-06 06:49:55'),(61,'Property Updated','Admin updated Property 1',1,'App\\Models\\Property',1,'App\\User','properties','[]','update','2020-01-06 06:50:18','2020-01-06 06:50:18'),(62,'Lease Updated','Admin updated Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 06:55:05','2020-01-06 06:55:05'),(63,'Lease Updated','Admin updated Lease 2',3,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 06:55:17','2020-01-06 06:55:17'),(64,'Lease Updated','Admin updated Lease 3',4,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 06:55:24','2020-01-06 06:55:24'),(65,'Lease Updated','Admin updated Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 07:02:08','2020-01-06 07:02:08'),(66,'Invoice Added','Admin added new uzair khan invoice',9,'App\\Models\\Invoice',1,'App\\User','invoices','[]','store','2020-01-06 07:05:07','2020-01-06 07:05:07'),(67,'Lease Cancelled','Admin cancelled Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','cancelLease','2020-01-06 08:12:48','2020-01-06 08:12:48'),(68,'Lease Ended','Admin ended Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','endLease','2020-01-06 08:13:03','2020-01-06 08:13:03'),(69,'Property Added','Admin added new Property 3',7,'App\\Models\\Property',1,'App\\User','properties','[]','store','2020-01-06 08:17:32','2020-01-06 08:17:32'),(70,'Property Deleted','Admin deleted Property 3',7,'App\\Models\\Property',1,'App\\User','properties','[]','delete','2020-01-06 08:17:43','2020-01-06 08:17:43'),(71,'Lease Cancelled','Admin cancelled Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','cancelLease','2020-01-06 08:35:38','2020-01-06 08:35:38'),(72,'Lease Ended','Admin ended Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','endLease','2020-01-06 08:35:42','2020-01-06 08:35:42'),(73,'Lease Cancelled','Admin cancelled Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','cancelLease','2020-01-06 08:35:47','2020-01-06 08:35:47'),(74,'Lease Cancelled','Admin cancelled Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','cancelLease','2020-01-06 08:36:08','2020-01-06 08:36:08'),(75,'Lease Ended','Admin ended Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','endLease','2020-01-06 08:36:12','2020-01-06 08:36:12'),(76,'Lease Cancelled','Admin cancelled Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','cancelLease','2020-01-06 08:36:33','2020-01-06 08:36:33'),(77,'Invoice Paid','Admin marked as paid M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-06 08:52:30','2020-01-06 08:52:30'),(78,'Invoice Paid','Admin marked as paid M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-06 08:53:00','2020-01-06 08:53:00'),(79,'Invoice Paid','Admin marked as paid uzair khan invoice',9,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-06 08:53:55','2020-01-06 08:53:55'),(80,'Invoice Update','Admin update M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-06 08:54:25','2020-01-06 08:54:25'),(81,'Invoice Update','Admin update uzair khan invoice',9,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-06 08:54:30','2020-01-06 08:54:30'),(82,'Invoice Update','Admin update M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-06 08:56:41','2020-01-06 08:56:41'),(83,'Invoice Update','Admin update M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-06 08:56:48','2020-01-06 08:56:48'),(84,'Invoice Paid','Admin marked as paid M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-06 08:57:06','2020-01-06 08:57:06'),(85,'Invoice Cancelled','Admin cancelled uzair khan invoice',9,'App\\Models\\Invoice',1,'App\\User','invoices','[]','cancelInvoice','2020-01-06 09:01:08','2020-01-06 09:01:09'),(86,'Invoice Cancelled','Admin cancelled M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','cancelInvoice','2020-01-06 09:01:59','2020-01-06 09:01:59'),(87,'Lease Updated','Admin updated Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 09:05:07','2020-01-06 09:05:07'),(88,'Invoice Update','Admin update M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-06 09:22:57','2020-01-06 09:22:57'),(89,'Invoice Paid','Admin marked as paid M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-06 09:32:30','2020-01-06 09:32:30'),(90,'Invoice Update','Admin update M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-06 09:32:40','2020-01-06 09:32:40'),(91,'Invoice Update','Admin update M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-06 09:32:48','2020-01-06 09:32:48'),(92,'Invoice Update','Admin update M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-06 09:32:54','2020-01-06 09:32:54'),(93,'Tenant Deleted','Admin deleted uzair khan',1,'App\\Models\\Tenant',1,'App\\User','tenants','[]','delete','2020-01-06 09:36:13','2020-01-06 09:36:13'),(94,'Role Updated','Admin updated Admin',1,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-06 09:42:01','2020-01-06 09:42:01'),(95,'Property Updated','Admin updated Property 1',1,'App\\Models\\Property',1,'App\\User','properties','[]','update','2020-01-06 10:19:16','2020-01-06 10:19:16'),(96,'Lease Updated','Admin updated Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 11:16:22','2020-01-06 11:16:22'),(97,'Lease Updated','Admin updated Lease 2',3,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 11:16:25','2020-01-06 11:16:25'),(98,'Lease Updated','Admin updated Lease 3',4,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 11:16:28','2020-01-06 11:16:28'),(99,'Lease Ended','Admin ended Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','endLease','2020-01-06 11:19:25','2020-01-06 11:19:25'),(100,'Lease Updated','Admin updated Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 11:22:03','2020-01-06 11:22:03'),(101,'Lease Ended','Admin ended Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','endLease','2020-01-06 11:22:10','2020-01-06 11:22:10'),(102,'Lease Updated','Admin updated Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 11:22:37','2020-01-06 11:22:37'),(103,'Lease Updated','Admin updated Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 11:23:34','2020-01-06 11:23:34'),(104,'Lease Updated','Admin updated Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 11:24:04','2020-01-06 11:24:04'),(105,'Lease Updated','Admin updated Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 11:24:48','2020-01-06 11:24:48'),(106,'Lease Ended','Admin ended Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','endLease','2020-01-06 11:24:51','2020-01-06 11:24:51'),(107,'Lease Ended','Admin ended Lease 2',3,'App\\Models\\Lease',1,'App\\User','leases','[]','endLease','2020-01-06 11:26:18','2020-01-06 11:26:18'),(108,'Lease Updated','Admin updated Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 11:39:02','2020-01-06 11:39:02'),(109,'Invoice Added','Admin added new uzair khan invoice',10,'App\\Models\\Invoice',1,'App\\User','invoices','[]','store','2020-01-06 11:46:39','2020-01-06 11:46:39'),(110,'Tenant Deleted','Admin deleted uzair khan',1,'App\\Models\\Tenant',1,'App\\User','tenants','[]','delete','2020-01-06 11:56:17','2020-01-06 11:56:17'),(111,'Tenant Updated','Admin updated uzair khan',1,'App\\Models\\Tenant',1,'App\\User','tenants','[]','update','2020-01-06 12:11:10','2020-01-06 12:11:10'),(112,'Lease Updated','Admin updated Lease 3',4,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-06 12:11:25','2020-01-06 12:11:25'),(113,'Property Updated','Admin updated Property 3',6,'App\\Models\\Property',1,'App\\User','properties','[]','update','2020-01-06 12:26:06','2020-01-06 12:26:06'),(114,'Property Updated','Admin updated Property 1',1,'App\\Models\\Property',1,'App\\User','properties','[]','update','2020-01-06 12:26:14','2020-01-06 12:26:14'),(115,'Invoice Update','Admin update uzair khan invoice',9,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-06 12:27:04','2020-01-06 12:27:04'),(116,'Invoice Update','Admin update uzair khan invoice',9,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-06 12:27:11','2020-01-06 12:27:11'),(117,'Invoice Update','Admin update M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-06 12:27:16','2020-01-06 12:27:16'),(118,'Invoice Update','Admin update M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-06 12:28:02','2020-01-06 12:28:02'),(119,'Lease Updated','Admin updated Lease 3',4,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-07 02:49:46','2020-01-07 02:49:46'),(120,'Invoice Deleted','Admin deleted uzair khan invoice',10,'App\\Models\\Invoice',1,'App\\User','invoices','[]','delete','2020-01-07 02:49:58','2020-01-07 02:49:58'),(121,'Invoice Deleted','Admin deleted uzair khan invoice',9,'App\\Models\\Invoice',1,'App\\User','invoices','[]','delete','2020-01-07 02:50:01','2020-01-07 02:50:01'),(122,'Invoice Deleted','Admin deleted M uzair invoice',2,'App\\Models\\Invoice',1,'App\\User','invoices','[]','delete','2020-01-07 02:50:03','2020-01-07 02:50:03'),(123,'Lease Deleted','Admin deleted Lease 3',4,'App\\Models\\Lease',1,'App\\User','leases','[]','delete','2020-01-07 02:50:09','2020-01-07 02:50:09'),(124,'Lease Deleted','Admin deleted Lease 2',3,'App\\Models\\Lease',1,'App\\User','leases','[]','delete','2020-01-07 02:50:12','2020-01-07 02:50:12'),(125,'Lease Deleted','Admin deleted Lease 1',1,'App\\Models\\Lease',1,'App\\User','leases','[]','delete','2020-01-07 02:50:15','2020-01-07 02:50:15'),(126,'Lease Added','Admin added new Lease 1',5,'App\\Models\\Lease',1,'App\\User','leases','[]','store','2020-01-07 02:50:43','2020-01-07 02:50:43'),(127,'Property Updated','Admin updated Property 1',1,'App\\Models\\Property',1,'App\\User','properties','[]','update','2020-01-07 02:50:58','2020-01-07 02:50:58'),(128,'Lease Deleted','Admin deleted Lease 1',5,'App\\Models\\Lease',1,'App\\User','leases','[]','delete','2020-01-07 02:55:16','2020-01-07 02:55:16'),(129,'Lease Added','Admin added new Lease 1',6,'App\\Models\\Lease',1,'App\\User','leases','[]','store','2020-01-07 02:55:47','2020-01-07 02:55:47'),(130,'Property Updated','Admin updated Property 1',1,'App\\Models\\Property',1,'App\\User','properties','[]','update','2020-01-07 02:55:55','2020-01-07 02:55:55'),(131,'Property Updated','Admin updated Property 1',1,'App\\Models\\Property',1,'App\\User','properties','[]','update','2020-01-07 02:56:06','2020-01-07 02:56:06'),(132,'Lease Cancelled','Admin cancelled Lease 1',6,'App\\Models\\Lease',1,'App\\User','leases','[]','cancelLease','2020-01-07 02:57:07','2020-01-07 02:57:07'),(133,'Lease Added','Admin added new Lease 2',7,'App\\Models\\Lease',1,'App\\User','leases','[]','store','2020-01-07 02:57:52','2020-01-07 02:57:52'),(134,'Lease Deleted','Admin deleted Lease 2',7,'App\\Models\\Lease',1,'App\\User','leases','[]','delete','2020-01-07 02:58:01','2020-01-07 02:58:01'),(135,'Lease Added','Admin added new Lease 2',8,'App\\Models\\Lease',1,'App\\User','leases','[]','store','2020-01-07 02:58:29','2020-01-07 02:58:29'),(136,'Lease Ended','Admin ended Lease 2',8,'App\\Models\\Lease',1,'App\\User','leases','[]','endLease','2020-01-07 02:58:38','2020-01-07 02:58:38'),(137,'Lease Added','Admin added new Lease 3',9,'App\\Models\\Lease',1,'App\\User','leases','[]','store','2020-01-07 03:03:43','2020-01-07 03:03:43'),(138,'Invoice Added','Admin added new uzair khan invoice',11,'App\\Models\\Invoice',1,'App\\User','invoices','[]','store','2020-01-07 03:05:37','2020-01-07 03:05:37'),(139,'Invoice Added','Admin added new uzair khan invoice',12,'App\\Models\\Invoice',1,'App\\User','invoices','[]','store','2020-01-07 03:06:28','2020-01-07 03:06:28'),(140,'Invoice Paid','Admin marked as paid uzair khan invoice',12,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-07 03:08:41','2020-01-07 03:08:41'),(141,'Invoice Update','Admin update uzair khan invoice',12,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-07 03:09:42','2020-01-07 03:09:42'),(142,'Invoice Update','Admin update uzair khan invoice',11,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-07 03:09:47','2020-01-07 03:09:47'),(143,'Invoice Paid','Admin marked as paid uzair khan invoice',11,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-07 03:43:15','2020-01-07 03:43:15'),(144,'Invoice Deleted','Admin deleted uzair khan invoice',12,'App\\Models\\Invoice',1,'App\\User','invoices','[]','delete','2020-01-07 03:46:27','2020-01-07 03:46:27'),(145,'Invoice Update','Admin update uzair khan invoice',11,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-07 03:47:26','2020-01-07 03:47:26'),(146,'Lease Updated','Admin updated Lease 1',6,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-07 03:52:01','2020-01-07 03:52:01'),(147,'Lease Updated','Admin updated Lease 3',9,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-07 03:52:30','2020-01-07 03:52:30'),(148,'Lease Updated','Admin updated Lease 3',9,'App\\Models\\Lease',1,'App\\User','leases','[]','update','2020-01-07 03:52:59','2020-01-07 03:52:59'),(149,'Invoice Added','Admin added new  invoice',13,'App\\Models\\Invoice',1,'App\\User','invoices','[]','store','2020-01-07 04:09:35','2020-01-07 04:09:35'),(150,'Invoice Update','Admin update  invoice',13,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-07 04:14:11','2020-01-07 04:14:11'),(151,'Invoice Update','Admin update  invoice',13,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-07 04:14:47','2020-01-07 04:14:47'),(152,'Invoice Paid','Admin marked as paid  invoice',13,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-07 04:14:57','2020-01-07 04:14:57'),(153,'Role Updated','Admin updated Admin',1,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-07 04:39:11','2020-01-07 04:39:11'),(154,'User Deleted','Admin deleted Admin',3,'App\\User',1,'App\\User','users','[]','delete','2020-01-07 06:28:15','2020-01-07 06:28:15'),(155,'Property Updated','Admin updated Property 3',6,'App\\Models\\Property',1,'App\\User','properties','[]','update','2020-01-07 06:48:21','2020-01-07 06:48:21'),(156,'Invoice Added','Admin added new  invoice',14,'App\\Models\\Invoice',1,'App\\User','invoices','[]','store','2020-01-07 08:10:48','2020-01-07 08:10:48'),(157,'Invoice Paid','Admin marked as paid  invoice',14,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-07 08:11:05','2020-01-07 08:11:05'),(158,'Invoice Deleted','Admin deleted  invoice',14,'App\\Models\\Invoice',1,'App\\User','invoices','[]','delete','2020-01-07 08:11:13','2020-01-07 08:11:13'),(159,'Tenant Deleted','Admin deleted uzair khan',1,'App\\Models\\Tenant',1,'App\\User','tenants','[]','delete','2020-01-07 09:20:41','2020-01-07 09:20:41'),(160,'Tenant Updated','Admin updated uzair khan',1,'App\\Models\\Tenant',1,'App\\User','tenants','[]','update','2020-01-07 09:23:12','2020-01-07 09:23:12'),(161,'Bank Account Updated','Admin updated JS Bank',3,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','update','2020-01-07 10:11:14','2020-01-07 10:11:14'),(162,'Tenant Deleted','Admin deleted uzair khan',1,'App\\Models\\Tenant',1,'App\\User','tenants','[]','delete','2020-01-07 11:51:19','2020-01-07 11:51:19'),(163,'Tenant Updated','Admin updated uzair khan',1,'App\\Models\\Tenant',1,'App\\User','tenants','[]','update','2020-01-07 11:57:42','2020-01-07 11:57:42'),(164,'Lease Added','Admin added new Lease 10',10,'App\\Models\\Lease',1,'App\\User','leases','[]','store','2020-01-07 11:58:08','2020-01-07 11:58:08'),(165,'Invoice Added','Admin added new  invoice',15,'App\\Models\\Invoice',1,'App\\User','invoices','[]','store','2020-01-07 12:04:20','2020-01-07 12:04:20'),(166,'Role Updated','Admin updated Land Lord',2,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-07 12:17:01','2020-01-07 12:17:01'),(167,'User Added','Admin added new Admin',4,'App\\User',1,'App\\User','users','[]','store','2020-01-07 12:17:23','2020-01-07 12:17:23'),(168,'Property Added','Admin added new Property 4',8,'App\\Models\\Property',1,'App\\User','properties','[]','store','2020-01-07 12:17:44','2020-01-07 12:17:44'),(169,'Invoice Paid','Admin marked as paid  invoice',15,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-13 11:51:19','2020-01-13 11:51:19'),(170,'Invoice Paid','Admin marked as paid  invoice',13,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-13 11:56:30','2020-01-13 11:56:30'),(171,'Invoice Paid','Admin marked as paid  invoice',13,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-13 11:57:42','2020-01-13 11:57:42'),(172,'Invoice Paid','Admin marked as paid  invoice',13,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-13 12:06:32','2020-01-13 12:06:32'),(173,'Invoice Update','Admin update  invoice',15,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-14 04:04:57','2020-01-14 04:04:57'),(174,'Invoice Paid','Admin marked as paid  invoice',15,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-14 04:05:07','2020-01-14 04:05:07'),(175,'Invoice Update','Admin update  invoice',15,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-14 04:06:04','2020-01-14 04:06:04'),(176,'Invoice Paid','Admin marked as paid  invoice',15,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-14 04:06:28','2020-01-14 04:06:28'),(177,'Role Updated','Admin updated Land Lord',2,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-14 04:09:23','2020-01-14 04:09:23'),(178,'Role Updated','Admin updated Land Lord',2,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-14 04:15:38','2020-01-14 04:15:38'),(179,'Property Updated','Land Lord updated Property 1',1,'App\\Models\\Property',2,'App\\User','properties','[]','update','2020-01-14 04:15:49','2020-01-14 04:15:49'),(180,'Bank Account Added','Admin added new JS Bank',4,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','store','2020-01-14 10:27:13','2020-01-14 10:27:13'),(181,'Bank Account Added','Admin added new JS Bank',5,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','store','2020-01-14 10:27:20','2020-01-14 10:27:20'),(182,'Bank Account Added','Admin added new JS Bank',6,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','store','2020-01-14 10:27:24','2020-01-14 10:27:24'),(183,'Bank Account Added','Admin added new adsdsa',7,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','store','2020-01-14 10:27:28','2020-01-14 10:27:28'),(184,'Bank Account Added','Admin added new JS Bank',8,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','store','2020-01-14 10:27:32','2020-01-14 10:27:32'),(185,'Bank Account Added','Admin added new JS Bank',9,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','store','2020-01-14 10:27:38','2020-01-14 10:27:38'),(186,'Bank Account Added','Admin added new JS Bank',10,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','store','2020-01-14 10:27:48','2020-01-14 10:27:48'),(187,'Bank Account Added','Admin added new JS Bank',11,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','store','2020-01-14 10:27:59','2020-01-14 10:27:59'),(188,'Bank Account Added','Admin added new JS Bank',12,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','store','2020-01-14 10:28:10','2020-01-14 10:28:10'),(189,'Bank Account Added','Admin added new silk',13,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','store','2020-01-14 10:28:16','2020-01-14 10:28:16'),(190,'Role Updated','Admin updated Land Lord',2,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-16 03:51:44','2020-01-16 03:51:44'),(191,'Role Updated','Admin updated Land Lord',2,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-16 03:52:03','2020-01-16 03:52:03'),(192,'Role Updated','Admin updated Land Lord',2,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-16 03:52:11','2020-01-16 03:52:11'),(193,'Role Updated','Land Lord updated Land Lord',2,'App\\Models\\Role',2,'App\\User','roles','[]','update','2020-01-16 03:52:30','2020-01-16 03:52:30'),(194,'Role Updated','Land Lord updated Land Lord',2,'App\\Models\\Role',2,'App\\User','roles','[]','update','2020-01-16 03:56:18','2020-01-16 03:56:18'),(195,'Role Updated','Land Lord updated Property Manager',4,'App\\Models\\Role',2,'App\\User','roles','[]','update','2020-01-16 03:56:30','2020-01-16 03:56:30'),(196,'Role Updated','Land Lord updated Land Lord',2,'App\\Models\\Role',2,'App\\User','roles','[]','update','2020-01-16 03:56:47','2020-01-16 03:56:47'),(197,'Role Updated','Land Lord updated Land Lord',2,'App\\Models\\Role',2,'App\\User','roles','[]','update','2020-01-16 03:57:17','2020-01-16 03:57:17'),(198,'Role Updated','Land Lord updated Land Lord',2,'App\\Models\\Role',2,'App\\User','roles','[]','update','2020-01-16 03:57:26','2020-01-16 03:57:26'),(199,'Role Updated','Land Lord updated Land Lord',2,'App\\Models\\Role',2,'App\\User','roles','[]','update','2020-01-16 03:57:32','2020-01-16 03:57:32'),(200,'Role Updated','Land Lord updated Land Lord',2,'App\\Models\\Role',2,'App\\User','roles','[]','update','2020-01-16 03:57:38','2020-01-16 03:57:38'),(201,'Role Updated','Land Lord updated Land Lord',2,'App\\Models\\Role',2,'App\\User','roles','[]','update','2020-01-16 04:07:16','2020-01-16 04:07:16'),(202,'User Updated','Land Lord updated his profile',2,'App\\User',2,'App\\User','users','[]','updateProfile','2020-01-16 04:12:15','2020-01-16 04:12:15'),(203,'User Updated','Land Lord 1 updated his profile',2,'App\\User',2,'App\\User','users','[]','updateProfile','2020-01-16 04:12:20','2020-01-16 04:12:20'),(204,'User Updated','Land Lord updated his profile',2,'App\\User',2,'App\\User','users','[]','updateProfile','2020-01-16 04:13:58','2020-01-16 04:13:58'),(205,'User Updated','Land Lord updated his profile',2,'App\\User',2,'App\\User','users','[]','updateProfile','2020-01-16 04:14:55','2020-01-16 04:14:55'),(206,'Role Updated','Land Lord updated Land Lord',2,'App\\Models\\Role',2,'App\\User','roles','[]','update','2020-01-16 04:16:20','2020-01-16 04:16:20'),(207,'Invoice Paid','Land Lord marked as paid  invoice',16,'App\\Models\\Invoice',2,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-17 09:13:19','2020-01-17 09:13:19'),(208,'User Deleted','Land Lord deleted Land Lord',4,'App\\User',2,'App\\User','users','[]','delete','2020-01-17 12:27:15','2020-01-17 12:27:15'),(209,'User Deleted','Land Lord deleted Land Lord',12,'App\\User',2,'App\\User','users','[]','delete','2020-01-17 12:27:17','2020-01-17 12:27:17'),(210,'Role Added','Land Lord added new Employee',5,'App\\Models\\Role',2,'App\\User','roles','[]','store','2020-01-17 12:47:20','2020-01-17 12:47:20'),(211,'Role Added','Admin added new dasdas',6,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-17 12:47:33','2020-01-17 12:47:33'),(212,'Role Deleted','Admin deleted dasdas',6,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-17 12:47:38','2020-01-17 12:47:38'),(213,'Bank Account Added','Admin added new dasd',14,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','store','2020-01-17 12:47:44','2020-01-17 12:47:44'),(214,'Bank Account Deleted','Admin deleted dasd',14,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','delete','2020-01-17 12:47:50','2020-01-17 12:47:50'),(215,'Bank Account Added','Land Lord added new das',15,'App\\Models\\BankAccount',2,'App\\User','bank_accounts','[]','store','2020-01-17 12:48:05','2020-01-17 12:48:05'),(216,'Bank Account Deleted','Land Lord deleted das',15,'App\\Models\\BankAccount',2,'App\\User','bank_accounts','[]','delete','2020-01-17 12:48:20','2020-01-17 12:48:20'),(217,'User Added','Land Lord added new Land Lord',13,'App\\User',2,'App\\User','users','[]','store','2020-01-17 12:48:27','2020-01-17 12:48:27'),(218,'User Deleted','Land Lord deleted Land Lord',13,'App\\User',2,'App\\User','users','[]','delete','2020-01-17 12:48:30','2020-01-17 12:48:30'),(219,'Tenant Added','Land Lord added new ddsa',2,'App\\Models\\Tenant',2,'App\\User','tenants','[]','store','2020-01-17 12:49:01','2020-01-17 12:49:01'),(220,'Tenant Deleted','Land Lord deleted ddsa',2,'App\\Models\\Tenant',2,'App\\User','tenants','[]','delete','2020-01-17 12:50:12','2020-01-17 12:50:12'),(221,'Tenant Added','Admin added new das',3,'App\\Models\\Tenant',1,'App\\User','tenants','[]','store','2020-01-17 12:52:34','2020-01-17 12:52:34'),(222,'User Added','Land Lord added new Land Lord',15,'App\\User',2,'App\\User','users','[]','store','2020-01-20 06:44:28','2020-01-20 06:44:28'),(223,'User Deleted','Land Lord deleted Land Lord',15,'App\\User',2,'App\\User','users','[]','delete','2020-01-20 06:44:36','2020-01-20 06:44:36'),(224,'Property Updated','Land Lord updated Property 1',1,'App\\Models\\Property',2,'App\\User','properties','[]','update','2020-01-20 07:59:17','2020-01-20 07:59:17'),(225,'Property Updated','Admin updated Property 1',1,'App\\Models\\Property',1,'App\\User','properties','[]','update','2020-01-20 09:10:32','2020-01-20 09:10:32'),(226,'Invoice Paid','Admin marked as paid  invoice',17,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-20 09:30:16','2020-01-20 09:30:16'),(227,'Invoice Paid','Admin marked as paid  invoice',18,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-20 09:30:31','2020-01-20 09:30:31'),(228,'User Updated','Land Lord updated his profile',2,'App\\User',2,'App\\User','users','[]','updateProfile','2020-01-20 11:44:44','2020-01-20 11:44:44'),(229,'User Updated','Land Lord updated his profile',2,'App\\User',2,'App\\User','users','[]','updateProfile','2020-01-20 11:44:59','2020-01-20 11:44:59'),(230,'User Updated','Land Lord updated his profile',2,'App\\User',2,'App\\User','users','[]','updateProfile','2020-01-20 11:45:06','2020-01-20 11:45:06'),(231,'Property Updated','Land Lord updated Property 1',1,'App\\Models\\Property',2,'App\\User','properties','[]','update','2020-01-20 11:52:28','2020-01-20 11:52:28'),(232,'Property Updated','Land Lord updated Property 1',1,'App\\Models\\Property',2,'App\\User','properties','[]','update','2020-01-20 11:54:45','2020-01-20 11:54:45'),(233,'Invoice Added','Land Lord added new  invoice',23,'App\\Models\\Invoice',2,'App\\User','invoices','[]','store','2020-01-20 12:25:28','2020-01-20 12:25:28'),(234,'Property Updated','Land Lord updated Property 1',1,'App\\Models\\Property',2,'App\\User','properties','[]','update','2020-01-20 13:02:23','2020-01-20 13:02:23'),(235,'Property Updated','Land Lord updated Property 3',6,'App\\Models\\Property',2,'App\\User','properties','[]','update','2020-01-20 13:02:48','2020-01-20 13:02:48'),(236,'Lease Updated','Land Lord updated Lease 3',11,'App\\Models\\Lease',2,'App\\User','leases','[]','update','2020-01-20 13:14:13','2020-01-20 13:14:13'),(237,'Tenant Added','Land Lord added new das',4,'App\\Models\\Tenant',2,'App\\User','tenants','[]','store','2020-01-20 13:34:07','2020-01-20 13:34:07'),(238,'Tenant Updated','Land Lord updated uzair khan',1,'App\\Models\\Tenant',2,'App\\User','tenants','[]','update','2020-01-20 13:34:17','2020-01-20 13:34:17'),(239,'Lease Updated','Land Lord updated Lease 10',10,'App\\Models\\Lease',2,'App\\User','leases','[]','update','2020-01-21 05:30:59','2020-01-21 05:30:59'),(240,'User Updated','Admin updated Admin',16,'App\\User',1,'App\\User','users','[]','update','2020-01-21 06:09:29','2020-01-21 06:09:29'),(241,'User Updated','Admin updated Admin',16,'App\\User',1,'App\\User','users','[]','update','2020-01-21 06:09:36','2020-01-21 06:09:36'),(242,'User Updated','Admin updated Admin',16,'App\\User',1,'App\\User','users','[]','update','2020-01-21 06:17:49','2020-01-21 06:17:49'),(243,'User Updated','uzair khan updated his profile',16,'App\\User',16,'App\\User','users','[]','updateProfile','2020-01-21 06:18:08','2020-01-21 06:18:08'),(244,'User Updated','Admin updated Admin',16,'App\\User',1,'App\\User','users','[]','update','2020-01-21 06:18:15','2020-01-21 06:18:15'),(245,'Role Updated','Admin updated Admin',1,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-21 06:39:38','2020-01-21 06:39:38'),(246,'Role Updated','Admin updated Land Lord',2,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-21 06:46:39','2020-01-21 06:46:39'),(247,'Role Deleted','Admin deleted Property Manager',4,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-21 06:46:43','2020-01-21 06:46:43'),(248,'Role Deleted','Admin deleted Employee',5,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-21 06:46:46','2020-01-21 06:46:46'),(249,'Invoice Paid','Admin marked as paid  invoice',13,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-21 06:47:33','2020-01-21 06:47:33'),(250,'Invoice Paid','Admin marked as paid  invoice',15,'App\\Models\\Invoice',1,'App\\User','invoices','[]','markAsPaidInvoice','2020-01-21 06:48:01','2020-01-21 06:48:01');
/*!40000 ALTER TABLE `activity_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_log_tags`
--

DROP TABLE IF EXISTS `activity_log_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_log_tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `wildcards` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log_tags`
--

LOCK TABLES `activity_log_tags` WRITE;
/*!40000 ALTER TABLE `activity_log_tags` DISABLE KEYS */;
INSERT INTO `activity_log_tags` VALUES (1,'property_added','[USER] added new [PROPERTY]','Property Added','[USER],[PROPERTY]',NULL,NULL),(2,'property_updated','[USER] updated [PROPERTY]','Property Updated','[USER],[PROPERTY]',NULL,NULL),(3,'bank_account_added','[USER] added new [BANK_ACCOUNT]','Bank Account Added','[USER],[BANK_ACCOUNT]',NULL,NULL),(4,'bank_account_updated','[USER] updated [BANK_ACCOUNT]','Bank Account Updated','[USER],[BANK_ACCOUNT]',NULL,NULL),(5,'bank_account_deleted','[USER] deleted [BANK_ACCOUNT]','Bank Account Deleted','[USER],[BANK_ACCOUNT]',NULL,NULL),(6,'property_deleted','[USER] deleted [PROPERTY]','Property Deleted','[USER],[PROPERTY]',NULL,NULL),(7,'lease_added','[USER] added new [LEASE]','Lease Added','[USER],[LEASE]',NULL,NULL),(8,'lease_updated','[USER] updated [LEASE]','Lease Updated','[USER],[LEASE]',NULL,NULL),(9,'lease_deleted','[USER] deleted [LEASE]','Lease Deleted','[USER],[LEASE]',NULL,NULL),(10,'invoice_added','[USER] added new [INVOICE] invoice','Invoice Added','[USER],[INVOICE]',NULL,NULL),(11,'invoice_update','[USER] update [INVOICE] invoice','Invoice Update','[USER],[INVOICE]',NULL,NULL),(12,'invoice_deleted','[USER] deleted [INVOICE] invoice','Invoice Deleted','[USER],[INVOICE]',NULL,NULL),(13,'role_added','[USER] added new [ROLE]','Role Added','[USER],[ROLE]',NULL,NULL),(14,'role_updated','[USER] updated [ROLE]','Role Updated','[USER],[ROLE]',NULL,NULL),(15,'role_deleted','[USER] deleted [ROLE]','Role Deleted','[USER],[ROLE]',NULL,NULL),(16,'tenant_added','[USER] added new [TENANT]','Tenant Added','[USER],[TENANT]',NULL,NULL),(17,'tenant_updated','[USER] updated [TENANT]','Tenant Updated','[USER],[TENANT]',NULL,NULL),(18,'tenant_deleted','[USER] deleted [TENANT]','Tenant Deleted','[USER],[TENANT]',NULL,NULL),(19,'user_added','[USER] added new [USER]','User Added','[USER],[USER]',NULL,NULL),(20,'user_updated','[USER] updated [USER]','User Updated','[USER],[USER]',NULL,NULL),(21,'user_deleted','[USER] deleted [USER]','User Deleted','[USER],[USER]',NULL,NULL),(22,'user_profile','[USER] updated his profile','User Updated','[USER]',NULL,NULL),(23,'lease_cancelled','[USER] cancelled [LEASE]','Lease Cancelled','[USER],[LEASE]',NULL,NULL),(24,'lease_ended','[USER] ended [LEASE]','Lease Ended','[USER],[LEASE]',NULL,NULL),(25,'invoice_paid','[USER] marked as paid [INVOICE] invoice','Invoice Paid','[USER],[INVOICE]',NULL,NULL),(26,'invoice_cancelled','[USER] cancelled [INVOICE] invoice','Invoice Cancelled','[USER],[INVOICE]',NULL,NULL);
/*!40000 ALTER TABLE `activity_log_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_accounts`
--

DROP TABLE IF EXISTS `bank_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_title` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_accounts`
--

LOCK TABLES `bank_accounts` WRITE;
/*!40000 ALTER TABLE `bank_accounts` DISABLE KEYS */;
INSERT INTO `bank_accounts` VALUES (3,'JS Bank','Subhan','32432342234432',NULL,'2020-01-03 08:47:18','2020-01-07 10:11:14'),(4,'JS Bank','adsda','32132312132132',2,'2020-01-14 10:27:13','2020-01-14 10:27:13'),(5,'JS Bank','adssda','232323',NULL,'2020-01-14 10:27:20','2020-01-14 10:27:20'),(6,'JS Bank','dadsadsa','23233223',NULL,'2020-01-14 10:27:24','2020-01-14 10:27:24'),(7,'adsdsa','adsadsa','3223123',NULL,'2020-01-14 10:27:28','2020-01-14 10:27:28'),(8,'JS Bank','adsadads','dasdasads',NULL,'2020-01-14 10:27:32','2020-01-14 10:27:32'),(9,'JS Bank','daadssda','dsaadsdas',NULL,'2020-01-14 10:27:38','2020-01-14 10:27:38'),(10,'JS Bank','dasdasads','32132312132',NULL,'2020-01-14 10:27:48','2020-01-14 10:27:48'),(11,'JS Bank','sadasadssda','213132132132',NULL,'2020-01-14 10:27:59','2020-01-14 10:27:59'),(12,'JS Bank','dasasdads','adsadsads',NULL,'2020-01-14 10:28:10','2020-01-14 10:28:10'),(13,'silk','asdasd','asdasd',NULL,'2020-01-14 10:28:16','2020-01-14 10:28:16');
/*!40000 ALTER TABLE `bank_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `invoice_status_id` int(11) DEFAULT NULL,
  `lease_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (13,5,1,87,'2020-01-01','2019-12-31',200,15,9,'das',5,1,'2020-01-07 04:09:35','2020-01-21 06:47:33'),(15,5,1,85,'2020-01-01','2019-08-31',201,15,10,'dsa',5,1,'2020-01-07 12:04:20','2020-01-21 06:48:01'),(16,5,1,85,'2020-01-01','2019-09-28',203,7,10,'dsa',5,1,'2020-01-07 12:04:20','2020-01-17 09:13:19'),(17,5,1,85,'2020-01-01','2019-04-28',208,15,10,'dsa',5,1,'2020-01-07 12:04:20','2020-01-20 09:30:16'),(18,5,1,85,'2020-01-01','2019-10-15',213,15,10,'dsa',5,1,'2020-01-07 12:04:20','2020-01-20 09:30:31'),(19,5,1,85,'2020-01-01','2019-07-28',219,7,10,'dsa',5,1,'2020-01-07 12:04:20','2020-01-14 04:06:28'),(20,5,1,85,'2020-01-01','2019-03-28',220,7,10,'dsa',5,1,'2020-01-07 12:04:20','2020-01-14 04:06:28'),(21,5,1,85,'2020-01-01','2018-11-28',230,7,10,'dsa',5,1,'2020-01-07 12:04:20','2020-01-14 04:06:28'),(22,5,1,85,'2020-01-01','2020-01-11',233,7,10,'dsa',5,1,'2020-01-07 12:04:20','2020-01-14 04:06:28'),(23,6,1,86,'2019-12-01','2020-01-19',100,7,NULL,'dsasd',NULL,1,'2020-01-20 12:25:28','2020-01-20 12:25:28');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_english` int(11) DEFAULT NULL,
  `is_arabic` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,1,0,'2020-01-01 09:08:49','2020-01-01 09:08:49');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leases`
--

DROP TABLE IF EXISTS `leases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lease_name` varchar(255) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `lease_status_id` int(11) DEFAULT NULL,
  `payer_name` varchar(255) DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `amount_payable` double DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `enable_email` int(11) DEFAULT NULL,
  `enable_sms` int(11) DEFAULT NULL,
  `rental` varchar(255) DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leases`
--

LOCK TABLES `leases` WRITE;
/*!40000 ALTER TABLE `leases` DISABLE KEYS */;
INSERT INTO `leases` VALUES (6,'Lease 1',1,4,12,'M Uzair','weekly',1000,3,'2020-01-01','2020-01-31','ads',NULL,1,1,'',1,85,'2020-01-07 02:55:47','2020-01-07 03:52:01'),(8,'Lease 2',1,4,11,'M Uzair','weekly',2000,4,'2020-01-01','2020-03-01','asd',NULL,1,1,'commercial',1,86,'2020-01-07 02:58:29','2020-01-07 02:58:38'),(9,'Lease 3',1,3,3,'M Uzair','weekly',3000,3,'2020-01-01','2020-04-01','ads',NULL,0,1,'commercial',1,87,'2020-01-07 03:03:43','2020-01-07 03:52:59'),(10,'Lease 10',1,4,3,'uzair khan','weekly',1000,3,'2019-11-01','2020-01-31','dsadas',NULL,0,1,'',4,85,'2020-01-07 11:58:08','2020-01-21 05:30:59'),(11,'Lease 3',1,3,3,'M Uzair','weekly',3000,3,'2020-01-01','2020-02-11','ads',NULL,0,1,'commercial',1,87,'2020-01-07 03:03:43','2020-01-20 13:14:13');
/*!40000 ALTER TABLE `leases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2020_01_03_110223_create_activity_log_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(11) unsigned NOT NULL,
  `permissions_enabled` int(11) DEFAULT NULL,
  `permissions_table` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` int(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,'dashboard','Dashboard','home','fa fa-columns',0,NULL,NULL,1,NULL,NULL),(2,'settings','Settings','#','fa fa-cog',0,NULL,NULL,7,NULL,NULL),(3,'users','User Management','users.show','',2,NULL,NULL,NULL,NULL,NULL),(4,'properties','Properties','properties.show','fa fa fa-home',0,NULL,NULL,2,NULL,NULL),(5,'leases','Leases','leases.show','fa fa-file',0,NULL,NULL,3,NULL,NULL),(6,'invoices','Invoices','invoices.show','fa fa-dollar-sign',0,NULL,NULL,4,NULL,NULL),(7,'tenants','Tenants','tenants.show','fa fa-poll-h',0,NULL,NULL,5,NULL,NULL),(8,'roles','Role Management','roles.show','',2,NULL,NULL,NULL,NULL,NULL),(9,'bank_accounts','Bank Account','bank_accounts.show','',2,NULL,NULL,NULL,NULL,NULL),(10,'user_profile','User Profile','profile','',2,NULL,NULL,NULL,NULL,NULL),(11,'activity_logs','Activity Logs','activity_logs.show','',2,NULL,NULL,NULL,NULL,NULL),(12,'languages','Language Settings','languages.language','',2,NULL,NULL,NULL,NULL,NULL),(13,'reports','Reports','reports.show','fa fa-compact-disc',0,NULL,NULL,6,NULL,NULL),(14,'widgets','Widgets Management','widgets.show','',2,NULL,NULL,NULL,NULL,NULL),(15,'user_notification','Notification Settings','notification','',2,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `months`
--

DROP TABLE IF EXISTS `months`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `months` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `month` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `months`
--

LOCK TABLES `months` WRITE;
/*!40000 ALTER TABLE `months` DISABLE KEYS */;
INSERT INTO `months` VALUES (1,'January'),(2,'Febraury'),(3,'March'),(4,'April'),(5,'May'),(6,'June'),(7,'July'),(8,'August'),(9,'September'),(10,'October'),(11,'November'),(12,'December');
/*!40000 ALTER TABLE `months` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_tags`
--

DROP TABLE IF EXISTS `notification_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wildcards` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_tags`
--

LOCK TABLES `notification_tags` WRITE;
/*!40000 ALTER TABLE `notification_tags` DISABLE KEYS */;
INSERT INTO `notification_tags` VALUES (1,'invoice_payment','[USER] marked as paid to [INVOICE] invoice.','[USER],[INVOICE]',NULL,NULL),(2,'land_lord_sign_up','[USER] has signed up to system','[USER]',NULL,NULL);
/*!40000 ALTER TABLE `notification_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_id` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `replacers` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (3,'invoice_payment',15,2,1,'Admin,Property 1',1,'2020-01-14 04:06:28','2020-01-21 06:48:13','invoices'),(4,'invoice_payment',16,2,2,'Land Lord,Property 1',1,'2020-01-17 09:13:19','2020-01-21 06:48:13','invoices'),(5,'invoice_payment',17,2,1,'Admin,Property 1',1,'2020-01-20 09:30:16','2020-01-21 06:48:13','invoices'),(6,'invoice_payment',18,2,1,'Admin,Property 1',1,'2020-01-20 09:30:31','2020-01-21 06:48:13','invoices'),(7,'land_lord_sign_up',16,1,16,'uzair khan',1,'2020-01-21 04:55:55','2020-01-21 06:11:50','users'),(8,'invoice_payment',13,2,1,'Admin,Property 1',1,'2020-01-21 06:47:33','2020-01-21 06:48:13','invoices'),(9,'invoice_payment',15,2,1,'Admin,Property 1',1,'2020-01-21 06:48:01','2020-01-21 06:48:13','invoices');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `module` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES (1,'Online','online','properties'),(2,'Offline','offline','properties'),(3,'Online','online','leases'),(4,'Offline','offline','leases'),(5,'Online','online','invoices'),(6,'Offline','offline','invoices');
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `add` int(11) DEFAULT NULL,
  `edit` int(11) DEFAULT NULL,
  `show` int(11) DEFAULT NULL,
  `delete` int(11) DEFAULT NULL,
  `is_visible` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=479 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (95,'properties','14',0,0,0,0,1,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(96,'leases','14',0,0,0,0,0,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(97,'invoices','14',0,0,0,0,0,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(98,'tenants','14',0,0,0,0,0,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(99,'users','14',0,0,0,0,0,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(100,'roles','14',0,0,0,0,0,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(101,'bank_accounts','14',0,0,0,0,0,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(102,'activity_logs','14',0,0,0,0,0,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(103,'properties','15',0,0,0,0,0,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(104,'leases','15',0,0,0,0,0,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(105,'invoices','15',0,0,0,0,1,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(106,'tenants','15',0,0,0,0,0,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(107,'users','15',0,0,0,0,0,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(108,'roles','15',0,0,0,0,0,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(109,'bank_accounts','15',0,0,0,0,0,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(110,'activity_logs','15',0,0,0,0,0,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(111,'properties','16',0,0,0,0,1,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(112,'leases','16',0,0,0,0,0,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(113,'invoices','16',0,0,0,0,0,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(114,'tenants','16',0,0,0,0,0,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(115,'users','16',0,0,0,0,0,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(116,'roles','16',0,0,0,0,0,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(117,'bank_accounts','16',0,0,0,0,0,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(118,'activity_logs','16',0,0,0,0,0,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(119,'properties','17',0,0,0,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(120,'leases','17',0,0,0,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(121,'invoices','17',0,0,1,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(122,'tenants','17',0,0,0,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(123,'users','17',0,0,0,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(124,'roles','17',0,0,0,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(125,'bank_accounts','17',0,0,0,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(126,'activity_logs','17',0,0,0,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(127,'activity_logs','18',0,0,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(128,'bank_accounts','18',0,0,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(129,'invoices','18',0,1,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(130,'leases','18',0,0,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(131,'properties','18',0,0,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(132,'roles','18',0,0,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(133,'tenants','18',0,0,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(134,'users','18',0,0,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(135,'properties','19',0,0,1,1,1,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(136,'leases','19',0,0,0,0,0,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(137,'invoices','19',0,0,0,0,0,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(138,'tenants','19',0,0,0,0,0,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(139,'users','19',0,0,0,0,0,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(140,'roles','19',0,0,0,0,0,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(141,'bank_accounts','19',0,0,0,0,0,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(142,'activity_logs','19',0,0,0,0,0,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(143,'activity_logs','20',0,0,0,0,0,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(144,'bank_accounts','20',0,0,0,0,0,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(145,'invoices','20',0,0,0,0,0,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(146,'leases','20',0,0,0,0,0,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(147,'properties','20',0,0,0,0,0,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(148,'roles','20',0,0,0,0,0,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(149,'tenants','20',0,0,0,0,0,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(150,'users','20',0,0,0,0,1,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(151,'properties','21',0,0,0,0,1,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(152,'leases','21',0,0,0,0,0,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(153,'invoices','21',0,0,0,0,0,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(154,'tenants','21',0,0,0,0,0,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(155,'users','21',0,0,0,0,0,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(156,'roles','21',0,0,0,0,0,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(157,'bank_accounts','21',0,0,0,0,0,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(158,'activity_logs','21',0,0,0,0,0,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(159,'properties','22',0,0,0,0,1,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(160,'leases','22',0,0,0,0,0,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(161,'invoices','22',0,0,0,0,0,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(162,'tenants','22',0,0,0,0,0,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(163,'users','22',0,0,0,0,0,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(164,'roles','22',0,0,0,0,0,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(165,'bank_accounts','22',0,0,0,0,0,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(166,'activity_logs','22',0,0,0,0,0,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(453,'properties','1',1,1,1,1,1,'2020-01-21 06:39:38','2020-01-21 06:39:38'),(454,'leases','1',1,1,1,1,1,'2020-01-21 06:39:38','2020-01-21 06:39:38'),(455,'invoices','1',1,1,1,1,1,'2020-01-21 06:39:38','2020-01-21 06:39:38'),(456,'tenants','1',1,1,1,1,1,'2020-01-21 06:39:38','2020-01-21 06:39:38'),(457,'reports','1',1,1,1,1,1,'2020-01-21 06:39:38','2020-01-21 06:39:38'),(458,'users','1',1,1,1,1,1,'2020-01-21 06:39:38','2020-01-21 06:39:38'),(459,'roles','1',1,1,1,1,1,'2020-01-21 06:39:38','2020-01-21 06:39:38'),(460,'bank_accounts','1',1,1,1,1,1,'2020-01-21 06:39:38','2020-01-21 06:39:38'),(461,'user_profile','1',0,0,0,0,0,'2020-01-21 06:39:38','2020-01-21 06:39:38'),(462,'activity_logs','1',1,1,1,1,1,'2020-01-21 06:39:38','2020-01-21 06:39:38'),(463,'languages','1',1,1,1,1,1,'2020-01-21 06:39:38','2020-01-21 06:39:38'),(464,'widgets','1',1,1,1,1,1,'2020-01-21 06:39:38','2020-01-21 06:39:38'),(465,'user_notification','1',1,1,1,1,1,'2020-01-21 06:39:38','2020-01-21 06:39:38'),(466,'properties','2',1,1,1,1,1,'2020-01-21 06:46:39','2020-01-21 06:46:39'),(467,'leases','2',1,1,1,1,1,'2020-01-21 06:46:39','2020-01-21 06:46:39'),(468,'invoices','2',1,1,1,1,1,'2020-01-21 06:46:39','2020-01-21 06:46:39'),(469,'tenants','2',1,1,1,1,1,'2020-01-21 06:46:39','2020-01-21 06:46:39'),(470,'reports','2',1,1,1,1,1,'2020-01-21 06:46:39','2020-01-21 06:46:39'),(471,'users','2',1,1,1,1,1,'2020-01-21 06:46:39','2020-01-21 06:46:39'),(472,'roles','2',1,1,1,1,1,'2020-01-21 06:46:39','2020-01-21 06:46:39'),(473,'bank_accounts','2',1,1,1,1,1,'2020-01-21 06:46:39','2020-01-21 06:46:39'),(474,'user_profile','2',1,1,1,1,1,'2020-01-21 06:46:39','2020-01-21 06:46:39'),(475,'activity_logs','2',1,1,1,1,1,'2020-01-21 06:46:39','2020-01-21 06:46:39'),(476,'languages','2',1,1,1,1,1,'2020-01-21 06:46:39','2020-01-21 06:46:39'),(477,'widgets','2',0,0,0,0,0,'2020-01-21 06:46:39','2020-01-21 06:46:39'),(478,'user_notification','2',1,1,1,1,1,'2020-01-21 06:46:39','2020-01-21 06:46:39');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `properties`
--

DROP TABLE IF EXISTS `properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `property_status_id` int(11) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `paci_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `land_lord_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `properties`
--

LOCK TABLES `properties` WRITE;
/*!40000 ALTER TABLE `properties` DISABLE KEYS */;
INSERT INTO `properties` VALUES (1,'Property 1','Karachi',NULL,2,1,'1234567890','sindh',2,1,'Silk Bank',2,'DHA','2020-01-01 03:38:12','2020-01-20 13:02:23'),(6,'Property 3','Islamabad',NULL,1,2,'1234567890','sindh',1,1,'Silk Bank',2,'DHA','2020-01-01 09:08:49','2020-01-20 13:02:48');
/*!40000 ALTER TABLE `properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','admin',NULL,'2020-01-03 02:58:25','2020-01-03 02:58:25'),(2,'Land Lord','land-lord',NULL,'2020-01-03 02:58:25','2020-01-03 02:58:25');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statuses`
--

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;
INSERT INTO `statuses` VALUES (1,'Active','active','properties'),(2,'In Active','in-active','properties'),(3,'Active','active','leases'),(4,'In Active','in-active','leases'),(5,'Active','active','tenants'),(6,'In Active','in-active','tenants'),(7,'Active','active','invoices'),(8,'In Active','in-active','invoices'),(9,'Active','active','users'),(10,'In Active','in-active','users'),(11,'Ended','ended','leases'),(12,'Canceled','cancelled','leases'),(13,'Active','active','units'),(14,'In Active','in-active','units'),(15,'Paid','paid','invoices'),(16,'Canceled','cancelled','invoices'),(17,'Blocked','blocked','tenants'),(18,'Active','active','widgets'),(19,'In Active','in-active','widgets');
/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tenants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `national_id` varchar(255) DEFAULT NULL,
  `tenant_status_id` int(11) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenants`
--

LOCK TABLES `tenants` WRITE;
/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;
INSERT INTO `tenants` VALUES (1,'uzair khan','root@email.com','1234567890','2',6,2,'2020-01-02 05:52:03','2020-01-20 13:34:17',NULL),(2,'ddsa','root1@email.com','1234567890','1',17,2,'2020-01-17 12:49:01','2020-01-17 12:50:12','2020-01-17 12:50:12'),(3,'das','modihost@hms.com','1234567890',NULL,5,1,'2020-01-17 12:52:34','2020-01-17 12:52:34',NULL),(4,'das','root@1email.com','1234567890',NULL,5,2,'2020-01-20 13:34:07','2020-01-20 13:34:07',NULL);
/*!40000 ALTER TABLE `tenants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` VALUES (1,'Lease','lease','properties'),(2,'Installments','installments','properties'),(3,'Rental','rental','leases'),(4,'Installments','installments','leases'),(5,'Lease','lease','invoices'),(6,'Non Lease','non-lease','invoices'),(7,'Unit Vacancy Report','unit_vacancy_report','reports'),(8,'Expiring Lease Report','expiring_lease_report','reports'),(9,'Blocked Tenants Report','blocked_tenants_report','reports'),(10,'Unpaid Tenants Report','unpaid_tenants_reports','reports'),(11,'Counter','counter','widgets'),(12,'Table','single_table','widgets'),(13,'Flot Line Chart','flot_line_chart','widgets'),(14,'Pie Chart','pie_chart','widgets'),(15,'Flot Bar Chart','flot_bar_chart','widgets');
/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `no_of_bedrooms` int(11) DEFAULT NULL,
  `no_of_bathrooms` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unit_status_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (85,1,'1','1','commercial',NULL,NULL,'2020-01-06 06:37:43','2020-01-07 11:58:08',14),(86,1,'2','2','residential',2,2,'2020-01-06 06:37:43','2020-01-07 02:58:38',13),(87,1,'3','3','commercial',NULL,NULL,'2020-01-06 06:37:43','2020-01-07 03:03:43',14),(88,1,'4','4','commercial',NULL,NULL,'2020-01-06 06:37:43','2020-01-20 11:54:45',13);
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_properties`
--

DROP TABLE IF EXISTS `user_properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_properties`
--

LOCK TABLES `user_properties` WRITE;
/*!40000 ALTER TABLE `user_properties` DISABLE KEYS */;
INSERT INTO `user_properties` VALUES (1,3,1,'2020-01-02 11:10:13','2020-01-02 11:10:13'),(2,3,6,'2020-01-02 11:10:13','2020-01-02 11:10:13');
/*!40000 ALTER TABLE `user_properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_status_id` int(11) DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification_enable` int(11) DEFAULT '0',
  `creator_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@realestate.com',NULL,'$2y$10$eMgUi1v3s.a5xXJDYyv7muDG505.xSwFRL/kDL/u0xpcJVo7o9M5q',NULL,1,'DHa','123456789',9,'/files/1578044875profile-avatar.png',1,NULL,'2019-12-31 10:22:21','2020-01-21 06:42:54'),(2,'Land Lord','landlord@realestate.com',NULL,'$2y$10$yQNGD0mwIEHKnBDfNnmeYOpUKF5LYP5NV.y6BQmemH0ESQO.Inc0y',NULL,2,NULL,'03343362255',9,'/files/1578044875profile-avatar.png',0,NULL,'2019-12-31 10:22:21','2020-01-21 06:47:51'),(16,'uzair khan','uzair.khan@cubixlabs.com',NULL,'$2y$10$d4qJqEsCgWHVqBeGDc1rH.9k4.mJz5Uvwh/orB2NdpKtTCbAdVeC2',NULL,2,NULL,NULL,10,NULL,0,NULL,'2020-01-21 04:55:47','2020-01-21 06:18:15');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `widgets`
--

DROP TABLE IF EXISTS `widgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `widgets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_title` varchar(45) DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `query` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `sorting` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `column` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `widgets`
--

LOCK TABLES `widgets` WRITE;
/*!40000 ALTER TABLE `widgets` DISABLE KEYS */;
INSERT INTO `widgets` VALUES (5,'Total Active Properties',NULL,NULL,'select count(id) as value from properties where exists( select  * from statuses where properties.property_status_id = statuses.id and slug = \'active\' and module = \'properties\')',18,'1',NULL,NULL,NULL,11,NULL,'2020-01-07 05:08:27','2020-01-07 11:44:55'),(6,'Total Active Land Lords',NULL,NULL,'select count(id) as value from users where exists( select  * from statuses where users.user_status_id = statuses.id and slug = \'active\' and module = \'users\')  and exists( select  * from roles where users.role_id = roles.id and slug = \'land-lord\')',18,'2',NULL,NULL,NULL,11,NULL,'2020-01-07 06:25:47','2020-01-07 11:44:59'),(7,'Total Active Tenants',NULL,NULL,'select count(id) as value from tenants where exists( select  * from statuses where tenants.tenant_status_id = statuses.id and slug = \'active\' and module = \'tenants\')',18,'3',NULL,NULL,NULL,11,NULL,'2020-01-07 06:29:13','2020-01-07 11:45:04'),(8,'Total Active Properties',NULL,NULL,'select count(id) as value from properties where exists( select  * from statuses where properties.property_status_id = statuses.id and slug = \'active\' and module = \'properties\') and land_lord_id = [USER_ID]',18,'4',NULL,NULL,NULL,11,NULL,'2020-01-07 06:42:21','2020-01-17 13:07:25'),(9,'Total Earning Report',NULL,NULL,NULL,19,'6',NULL,'invoice','makeTotalEarningsDataTable',12,NULL,'2020-01-07 07:30:34','2020-01-07 14:15:09'),(10,'Total Transactions',NULL,NULL,NULL,18,'14',NULL,'invoice','makeTotalTransactionsDataTable',12,'row row-xs col-12','2020-01-07 08:14:30','2020-01-07 13:14:30'),(11,'Total Properties',NULL,NULL,NULL,18,'15',NULL,'property','makeTotalPropertiesDataTable',12,'row row-xs col-12','2020-01-07 09:13:44','2020-01-07 14:13:44'),(12,'Total Tenants',NULL,NULL,NULL,18,'16',NULL,'tenant','makeTotalTenantsDataTable',12,'row row-xs col-12','2020-01-07 09:16:10','2020-01-07 14:16:10'),(13,'Total Land Lords',NULL,NULL,NULL,18,'17',NULL,'user','makeTotalLandLordsDataTable',12,'row row-xs col-12','2020-01-07 09:24:00','2020-01-07 14:24:18'),(14,'Total Units',NULL,NULL,'select count(id) as value from units',18,'7',NULL,NULL,NULL,11,NULL,'2020-01-07 10:13:01','2020-01-07 15:13:35'),(15,'Vacant Units',NULL,NULL,'select count(id) as value from units where exists( select  * from statuses where units.unit_status_id = statuses.id and slug = \'active\' and module = \'units\')',18,'8',NULL,NULL,NULL,11,NULL,'2020-01-07 10:14:07','2020-01-07 15:15:54'),(16,'Total Units',NULL,NULL,'select count(id) as value from units where exists( select  * from properties where units.property_id = properties.id and exists(select  * from users where properties.land_lord_id = [USER_ID]))',19,'9',NULL,NULL,NULL,11,NULL,'2020-01-07 10:17:09','2020-01-17 13:05:25'),(17,'Vacant Units',NULL,NULL,'select count(id) as value from units where exists( select  * from statuses where units.unit_status_id = statuses.id and slug = \'active\' and module = \'units\') and exists( select  * from properties where units.property_id = properties.id and exists(select  * from users where properties.land_lord_id = [USER_ID]))',19,'10',NULL,NULL,NULL,11,NULL,'2020-01-07 10:21:02','2020-01-17 13:04:25'),(18,'Over Due Payments',NULL,NULL,NULL,18,'18',NULL,'invoice','getDataForPlotLineGraph',13,NULL,'2020-01-16 11:31:22','2020-01-17 11:37:12'),(19,'Vacancy Rate',NULL,NULL,NULL,18,'19',NULL,'property','getPropertyDataForPieChart',14,NULL,'2020-01-17 04:52:30','2020-01-17 11:58:59'),(20,'Revenue & Expenses',NULL,NULL,NULL,18,'20',NULL,'invoice','getDataForPlotBarGraph',15,NULL,'2020-01-17 06:36:36','2020-01-17 11:37:35'),(21,'Total Collections',NULL,NULL,'select concat(\'$\',FORMAT(sum(total_amount), 0)) as value from invoices where exists( select  * from statuses where invoices.invoice_status_id = statuses.id and slug = \'paid\' and module = \'invoices\') and exists( select  * from properties where invoices.property_id = properties.id and exists(select  * from users where properties.land_lord_id = [USER_ID]))',18,'11',NULL,NULL,NULL,11,NULL,'2020-01-17 07:56:37','2020-01-17 17:39:47'),(22,'Online Collections',NULL,NULL,'select concat(\'$\',FORMAT(sum(total_amount), 0)) as value from invoices where exists( select  * from statuses where invoices.invoice_status_id = statuses.id and slug = \'paid\' and module = \'invoices\') and exists( select  * from payment_methods where invoices.payment_method_id = payment_methods.id and slug = \'online\' and module = \'invoices\') and exists( select  * from properties where invoices.property_id = properties.id and exists(select  * from users where properties.land_lord_id = [USER_ID]))',18,'12',NULL,NULL,NULL,11,NULL,'2020-01-17 08:04:00','2020-01-17 17:39:34'),(23,'Offline Collections',NULL,NULL,'select concat(\'$\',FORMAT(sum(total_amount), 0)) as value from invoices where exists( select  * from statuses where invoices.invoice_status_id = statuses.id and slug = \'paid\' and module = \'invoices\') and exists( select  * from payment_methods where invoices.payment_method_id = payment_methods.id and slug = \'offline\' and module = \'invoices\') and exists( select  * from properties where invoices.property_id = properties.id and exists(select  * from users where properties.land_lord_id = [USER_ID]))',18,'13',NULL,NULL,NULL,11,NULL,'2020-01-17 08:05:07','2020-01-17 17:39:06'),(24,'Expiring Leases','Leases that are expiring next month',NULL,NULL,18,'21',NULL,'lease','makeExpiringLeasesDataTable',12,'row row-xs col-7 set_card_height','2020-01-17 08:56:02','2020-01-17 13:56:02');
/*!40000 ALTER TABLE `widgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `widgets_roles`
--

DROP TABLE IF EXISTS `widgets_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `widgets_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `widget_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `widgets_roles`
--

LOCK TABLES `widgets_roles` WRITE;
/*!40000 ALTER TABLE `widgets_roles` DISABLE KEYS */;
INSERT INTO `widgets_roles` VALUES (66,5,1,'2020-01-07 06:45:13','2020-01-07 06:45:13'),(67,6,1,'2020-01-07 06:45:17','2020-01-07 06:45:17'),(76,10,1,'2020-01-07 08:14:30','2020-01-07 08:14:30'),(79,11,1,'2020-01-07 09:13:44','2020-01-07 09:13:44'),(80,9,1,'2020-01-07 09:15:09','2020-01-07 09:15:09'),(81,12,1,'2020-01-07 09:16:10','2020-01-07 09:16:10'),(83,13,1,'2020-01-07 09:24:18','2020-01-07 09:24:18'),(85,14,1,'2020-01-07 10:13:35','2020-01-07 10:13:35'),(88,15,1,'2020-01-07 10:15:54','2020-01-07 10:15:54'),(98,18,2,'2020-01-17 06:37:12','2020-01-17 06:37:12'),(99,20,2,'2020-01-17 06:37:35','2020-01-17 06:37:35'),(101,19,2,'2020-01-17 06:58:59','2020-01-17 06:58:59'),(102,7,1,'2020-01-17 07:50:12','2020-01-17 07:50:12'),(105,17,2,'2020-01-17 08:04:25','2020-01-17 08:04:25'),(107,16,2,'2020-01-17 08:05:25','2020-01-17 08:05:25'),(109,8,2,'2020-01-17 08:07:25','2020-01-17 08:07:25'),(113,24,2,'2020-01-17 08:56:02','2020-01-17 08:56:02'),(115,23,2,'2020-01-17 12:39:11','2020-01-17 12:39:11'),(116,22,2,'2020-01-17 12:39:34','2020-01-17 12:39:34'),(117,21,2,'2020-01-17 12:39:47','2020-01-17 12:39:47');
/*!40000 ALTER TABLE `widgets_roles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-21 16:50:10
