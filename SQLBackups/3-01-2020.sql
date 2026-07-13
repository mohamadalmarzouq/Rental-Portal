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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log`
--

LOCK TABLES `activity_log` WRITE;
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
INSERT INTO `activity_log` VALUES (1,'Bank Account Updated','Admin updated JS Bank',2,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','update','2020-01-03 08:01:24','2020-01-03 08:01:24'),(2,'Bank Account Deleted','Admin deleted JS Bank',2,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','delete','2020-01-03 08:02:53','2020-01-03 08:02:53'),(3,'User Updated','Admin updated his profile',1,'App\\User',1,'App\\User','users','[]','updateProfile','2020-01-03 08:43:27','2020-01-03 08:43:27'),(4,'Bank Account Added','Admin added new JS Bank',3,'App\\Models\\BankAccount',1,'App\\User','bank_accounts','[]','store','2020-01-03 08:47:18','2020-01-03 08:47:18'),(5,'Role Added','Admin added new sds',14,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 09:27:53','2020-01-03 09:27:53'),(6,'Role Added','Admin added new adsa',15,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 09:29:10','2020-01-03 09:29:10'),(7,'Role Deleted','Admin deleted sds',14,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 09:29:19','2020-01-03 09:29:19'),(8,'Role Deleted','Admin deleted sdd',13,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 09:29:21','2020-01-03 09:29:21'),(9,'User Deleted','Admin deleted Admin',8,'App\\User',1,'App\\User','users','[]','delete','2020-01-03 09:53:00','2020-01-03 09:53:00'),(10,'User Deleted','Admin deleted Admin',7,'App\\User',1,'App\\User','users','[]','delete','2020-01-03 09:53:02','2020-01-03 09:53:02'),(11,'User Deleted','Admin deleted Admin',4,'App\\User',1,'App\\User','users','[]','delete','2020-01-03 09:53:04','2020-01-03 09:53:04'),(12,'Role Added','Admin added new ads',16,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 09:56:15','2020-01-03 09:56:15'),(13,'Role Added','Admin added new sadads',17,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 09:58:20','2020-01-03 09:58:20'),(14,'Role Added','Admin added new asdasdsad',18,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 09:58:41','2020-01-03 09:58:41'),(15,'Role Added','Admin added new asdasd',19,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 10:04:09','2020-01-03 10:04:09'),(16,'Role Deleted','Admin deleted asdasd',19,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:06:03','2020-01-03 10:06:03'),(17,'Role Deleted','Admin deleted asdasdsad',18,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:06:04','2020-01-03 10:06:04'),(18,'Role Deleted','Admin deleted sadads',17,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:06:07','2020-01-03 10:06:07'),(19,'Role Deleted','Admin deleted ads',16,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:06:09','2020-01-03 10:06:09'),(20,'Role Deleted','Admin deleted adsa',15,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:06:16','2020-01-03 10:06:16'),(21,'Role Deleted','Admin deleted Employee',6,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:06:29','2020-01-03 10:06:29'),(22,'Role Added','Admin added new Employee',20,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 10:06:44','2020-01-03 10:06:44'),(23,'Role Deleted','Admin deleted Employee',20,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:07:40','2020-01-03 10:07:40'),(24,'Role Added','Admin added new sd',21,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 10:08:19','2020-01-03 10:08:19'),(25,'Role Added','Admin added new dsa',22,'App\\Models\\Role',1,'App\\User','roles','[]','store','2020-01-03 10:13:33','2020-01-03 10:13:33'),(26,'Tenant Added','Admin added new sda',2,'App\\Models\\Tenant',1,'App\\User','tenants','[]','store','2020-01-03 10:13:49','2020-01-03 10:13:49'),(27,'Tenant Deleted','Admin deleted sda',2,'App\\Models\\Tenant',1,'App\\User','tenants','[]','delete','2020-01-03 10:13:59','2020-01-03 10:13:59'),(28,'Role Deleted','Admin deleted dsa',22,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:14:05','2020-01-03 10:14:05'),(29,'Role Deleted','Admin deleted sd',21,'App\\Models\\Role',1,'App\\User','roles','[]','delete','2020-01-03 10:14:06','2020-01-03 10:14:06'),(30,'Tenant Updated','Admin updated uzair khan',1,'App\\Models\\Tenant',1,'App\\User','tenants','[]','update','2020-01-03 10:18:13','2020-01-03 10:18:13'),(31,'Role Updated','Admin updated Admin',1,'App\\Models\\Role',1,'App\\User','roles','[]','update','2020-01-03 11:16:29','2020-01-03 11:16:29'),(32,'Lease Added','Admin added new Lease 2',2,'App\\Models\\Lease',1,'App\\User','leases','[]','store','2020-01-03 11:35:42','2020-01-03 11:35:42'),(33,'Lease Added','Admin added new Lease 2',3,'App\\Models\\Lease',1,'App\\User','leases','[]','store','2020-01-03 11:37:20','2020-01-03 11:37:20'),(34,'Invoice Added','Admin added new uzair khan invoice',7,'App\\Models\\Invoice',1,'App\\User','invoices','[]','store','2020-01-03 11:48:49','2020-01-03 11:48:49'),(35,'Lease Added','Admin added new Lease 3',4,'App\\Models\\Lease',1,'App\\User','leases','[]','store','2020-01-03 11:55:25','2020-01-03 11:55:25'),(36,'Invoice Update','Admin update uzair khan invoice',4,'App\\Models\\Invoice',1,'App\\User','invoices','[]','update','2020-01-03 11:56:33','2020-01-03 11:56:33');
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log_tags`
--

LOCK TABLES `activity_log_tags` WRITE;
/*!40000 ALTER TABLE `activity_log_tags` DISABLE KEYS */;
INSERT INTO `activity_log_tags` VALUES (1,'property_added','[USER] added new [PROPERTY]','Property Added','[USER],[PROPERTY]',NULL,NULL),(2,'property_updated','[USER] updated [PROPERTY]','Property Updated','[USER],[PROPERTY]',NULL,NULL),(3,'bank_account_added','[USER] added new [BANK_ACCOUNT]','Bank Account Added','[USER],[BANK_ACCOUNT]',NULL,NULL),(4,'bank_account_updated','[USER] updated [BANK_ACCOUNT]','Bank Account Updated','[USER],[BANK_ACCOUNT]',NULL,NULL),(5,'bank_account_deleted','[USER] deleted [BANK_ACCOUNT]','Bank Account Deleted','[USER],[BANK_ACCOUNT]',NULL,NULL),(6,'property_deleted','[USER] deleted [PROPERTY]','Property Deleted','[USER],[PROPERTY]',NULL,NULL),(7,'lease_added','[USER] added new [LEASE]','Lease Added','[USER],[LEASE]',NULL,NULL),(8,'lease_updated','[USER] updated [LEASE]','Lease Updated','[USER],[LEASE]',NULL,NULL),(9,'lease_deleted','[USER] deleted [LEASE]','Lease Deleted','[USER],[LEASE]',NULL,NULL),(10,'invoice_added','[USER] added new [INVOICE] invoice','Invoice Added','[USER],[INVOICE]',NULL,NULL),(11,'invoice_update','[USER] update [INVOICE] invoice','Invoice Update','[USER],[INVOICE]',NULL,NULL),(12,'invoice_deleted','[USER] deleted [INVOICE] invoice','Invoice Deleted','[USER],[INVOICE]',NULL,NULL),(13,'role_added','[USER] added new [ROLE]','Role Added','[USER],[ROLE]',NULL,NULL),(14,'role_updated','[USER] updated [ROLE]','Role Updated','[USER],[ROLE]',NULL,NULL),(15,'role_deleted','[USER] deleted [ROLE]','Role Deleted','[USER],[ROLE]',NULL,NULL),(16,'tenant_added','[USER] added new [TENANT]','Tenant Added','[USER],[TENANT]',NULL,NULL),(17,'tenant_updated','[USER] updated [TENANT]','Tenant Updated','[USER],[TENANT]',NULL,NULL),(18,'tenant_deleted','[USER] deleted [TENANT]','Tenant Deleted','[USER],[TENANT]',NULL,NULL),(19,'user_added','[USER] added new [USER]','User Added','[USER],[USER]',NULL,NULL),(20,'user_updated','[USER] updated [USER]','User Updated','[USER],[USER]',NULL,NULL),(21,'user_deleted','[USER] deleted [USER]','User Deleted','[USER],[USER]',NULL,NULL),(22,'user_profile','[USER] updated his profile','User Updated','[USER]',NULL,NULL);
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
  `bank_name` varchar(100) DEFAULT NULL,
  `account_title` varchar(100) DEFAULT NULL,
  `account_number` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_accounts`
--

LOCK TABLES `bank_accounts` WRITE;
/*!40000 ALTER TABLE `bank_accounts` DISABLE KEYS */;
INSERT INTO `bank_accounts` VALUES (3,'JS Bank','uzair khan','32432342234432','2020-01-03 08:47:18','2020-01-03 08:47:18');
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
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile_number` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,5,1,75,'2020-01-02','2020-02-01',32213,8,1,'uzair khan','root@email.com','1234567890','dasds','2020-01-02 09:57:01','2020-01-02 10:24:58'),(2,6,1,74,'2020-01-02','2020-03-14',3323,7,NULL,'M uzair','root@email.com','1234567890','dasdsa','2020-01-02 10:00:28','2020-01-02 10:20:33'),(3,5,1,75,'2020-01-02','2020-04-16',32123,7,1,'uzair khan','root@email.com','1234567890','dsaads','2020-01-02 10:01:31','2020-01-02 10:20:45'),(4,5,1,75,'2020-01-02','2020-04-10',132321,7,1,'uzair khan','root@email.com','1234567890','dssas','2020-01-02 10:03:50','2020-01-03 11:56:33'),(7,5,1,75,'2020-01-01','2020-02-01',300,7,3,'uzair khan','root@email.com','1234567890','dssad','2020-01-03 11:48:49','2020-01-03 11:48:49');
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
  `lease_name` varchar(200) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `lease_status_id` int(11) DEFAULT NULL,
  `payer_name` varchar(100) DEFAULT NULL,
  `frequency` varchar(100) DEFAULT NULL,
  `amount_payable` double DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `enable_email` int(11) DEFAULT NULL,
  `enable_sms` int(11) DEFAULT NULL,
  `rental` varchar(100) DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leases`
--

LOCK TABLES `leases` WRITE;
/*!40000 ALTER TABLE `leases` DISABLE KEYS */;
INSERT INTO `leases` VALUES (1,'Lease 1',1,3,3,'M Uzair','weekly',212,4,'2020-01-01','2020-04-01','dasdsa',231321,0,1,'residential',1,75,'2020-01-01 11:37:06','2020-01-02 07:47:56'),(3,'Lease 2',1,4,3,'Subhan','weekly',300,3,'2020-01-03','2020-08-01','adsas',300,1,1,'commercial',1,75,'2020-01-03 11:37:20','2020-01-03 11:37:20'),(4,'Lease 3',1,4,3,'uzair khan','weekly',100,3,'2020-01-01','2020-03-01','assd',100,0,1,'commercial',1,75,'2020-01-03 11:55:25','2020-01-03 11:55:25');
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
  `parent` int(10) unsigned NOT NULL,
  `permissions_enabled` int(11) DEFAULT NULL,
  `permissions_table` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` int(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,'dashboard','Dashboard','home','mdi mdi-home',0,NULL,NULL,1,NULL,NULL),(2,'settings','Settings','#','mdi mdi-home',0,NULL,NULL,6,NULL,NULL),(3,'users','User Management','users.show','mdi mdi-home',2,NULL,NULL,NULL,NULL,NULL),(4,'properties','Properties','properties.show','mdi mdi-home',0,NULL,NULL,2,NULL,NULL),(5,'leases','Leases','leases.show','mdi mdi-home',0,NULL,NULL,3,NULL,NULL),(6,'invoices','Invoices','invoices.show','mdi mdi-home',0,NULL,NULL,4,NULL,NULL),(7,'tenants','Tenants','tenants.show','mdi mdi-home',0,NULL,NULL,5,NULL,NULL),(8,'roles','Role Management','roles.show','mdi mdi-home',2,NULL,NULL,NULL,NULL,NULL),(9,'bank_accounts','Bank Account','bank_accounts.show','mdi mdi-home',2,NULL,NULL,NULL,NULL,NULL),(10,'users','User Profile','users.profile','mdi mdi-home',2,NULL,NULL,NULL,NULL,NULL),(11,'activity_logs','Activity Logs','activity_logs.show','mdi mdi-home',2,NULL,NULL,NULL,NULL,NULL),(12,'languages','Language Settings','languages.language','mdi mdi-home',2,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES (1,'Online','online','properties'),(2,'Offline','offline','properties'),(3,'Online','online','leases'),(4,'Offline','offline','leases');
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
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (25,'properties','6',0,0,0,0,1,'2020-01-03 03:02:32','2020-01-03 03:02:32'),(26,'leases','6',0,0,0,0,0,'2020-01-03 03:02:32','2020-01-03 03:02:32'),(27,'invoices','6',0,0,0,0,0,'2020-01-03 03:02:32','2020-01-03 03:02:32'),(28,'tenants','6',0,0,0,0,0,'2020-01-03 03:02:32','2020-01-03 03:02:32'),(29,'users','6',0,0,0,0,0,'2020-01-03 03:02:33','2020-01-03 03:02:33'),(30,'roles','6',0,0,0,0,0,'2020-01-03 03:02:33','2020-01-03 03:02:33'),(67,'properties','4',1,1,1,1,1,'2020-01-03 03:12:24','2020-01-03 03:12:24'),(68,'leases','4',0,0,0,0,1,'2020-01-03 03:12:24','2020-01-03 03:12:24'),(69,'invoices','4',0,0,0,0,0,'2020-01-03 03:12:24','2020-01-03 03:12:24'),(70,'tenants','4',0,0,0,0,0,'2020-01-03 03:12:24','2020-01-03 03:12:24'),(71,'users','4',0,0,0,0,0,'2020-01-03 03:12:24','2020-01-03 03:12:24'),(72,'roles','4',0,0,0,0,0,'2020-01-03 03:12:24','2020-01-03 03:12:24'),(95,'properties','14',0,0,0,0,1,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(96,'leases','14',0,0,0,0,0,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(97,'invoices','14',0,0,0,0,0,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(98,'tenants','14',0,0,0,0,0,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(99,'users','14',0,0,0,0,0,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(100,'roles','14',0,0,0,0,0,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(101,'bank_accounts','14',0,0,0,0,0,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(102,'activity_logs','14',0,0,0,0,0,'2020-01-03 09:27:53','2020-01-03 09:27:53'),(103,'properties','15',0,0,0,0,0,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(104,'leases','15',0,0,0,0,0,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(105,'invoices','15',0,0,0,0,1,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(106,'tenants','15',0,0,0,0,0,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(107,'users','15',0,0,0,0,0,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(108,'roles','15',0,0,0,0,0,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(109,'bank_accounts','15',0,0,0,0,0,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(110,'activity_logs','15',0,0,0,0,0,'2020-01-03 09:29:10','2020-01-03 09:29:10'),(111,'properties','16',0,0,0,0,1,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(112,'leases','16',0,0,0,0,0,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(113,'invoices','16',0,0,0,0,0,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(114,'tenants','16',0,0,0,0,0,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(115,'users','16',0,0,0,0,0,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(116,'roles','16',0,0,0,0,0,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(117,'bank_accounts','16',0,0,0,0,0,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(118,'activity_logs','16',0,0,0,0,0,'2020-01-03 09:56:15','2020-01-03 09:56:15'),(119,'properties','17',0,0,0,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(120,'leases','17',0,0,0,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(121,'invoices','17',0,0,1,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(122,'tenants','17',0,0,0,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(123,'users','17',0,0,0,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(124,'roles','17',0,0,0,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(125,'bank_accounts','17',0,0,0,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(126,'activity_logs','17',0,0,0,0,0,'2020-01-03 09:58:20','2020-01-03 09:58:20'),(127,'activity_logs','18',0,0,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(128,'bank_accounts','18',0,0,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(129,'invoices','18',0,1,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(130,'leases','18',0,0,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(131,'properties','18',0,0,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(132,'roles','18',0,0,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(133,'tenants','18',0,0,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(134,'users','18',0,0,0,0,0,'2020-01-03 09:58:41','2020-01-03 09:58:41'),(135,'properties','19',0,0,1,1,1,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(136,'leases','19',0,0,0,0,0,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(137,'invoices','19',0,0,0,0,0,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(138,'tenants','19',0,0,0,0,0,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(139,'users','19',0,0,0,0,0,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(140,'roles','19',0,0,0,0,0,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(141,'bank_accounts','19',0,0,0,0,0,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(142,'activity_logs','19',0,0,0,0,0,'2020-01-03 10:04:09','2020-01-03 10:04:09'),(143,'activity_logs','20',0,0,0,0,0,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(144,'bank_accounts','20',0,0,0,0,0,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(145,'invoices','20',0,0,0,0,0,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(146,'leases','20',0,0,0,0,0,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(147,'properties','20',0,0,0,0,0,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(148,'roles','20',0,0,0,0,0,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(149,'tenants','20',0,0,0,0,0,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(150,'users','20',0,0,0,0,1,'2020-01-03 10:06:44','2020-01-03 10:06:44'),(151,'properties','21',0,0,0,0,1,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(152,'leases','21',0,0,0,0,0,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(153,'invoices','21',0,0,0,0,0,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(154,'tenants','21',0,0,0,0,0,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(155,'users','21',0,0,0,0,0,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(156,'roles','21',0,0,0,0,0,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(157,'bank_accounts','21',0,0,0,0,0,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(158,'activity_logs','21',0,0,0,0,0,'2020-01-03 10:08:19','2020-01-03 10:08:19'),(159,'properties','22',0,0,0,0,1,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(160,'leases','22',0,0,0,0,0,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(161,'invoices','22',0,0,0,0,0,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(162,'tenants','22',0,0,0,0,0,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(163,'users','22',0,0,0,0,0,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(164,'roles','22',0,0,0,0,0,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(165,'bank_accounts','22',0,0,0,0,0,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(166,'activity_logs','22',0,0,0,0,0,'2020-01-03 10:13:33','2020-01-03 10:13:33'),(167,'properties','1',1,1,1,1,1,'2020-01-03 11:16:29','2020-01-03 11:16:29'),(168,'leases','1',1,1,1,1,1,'2020-01-03 11:16:29','2020-01-03 11:16:29'),(169,'invoices','1',1,1,1,1,1,'2020-01-03 11:16:29','2020-01-03 11:16:29'),(170,'tenants','1',1,1,1,1,1,'2020-01-03 11:16:29','2020-01-03 11:16:29'),(171,'users','1',1,1,1,1,1,'2020-01-03 11:16:29','2020-01-03 11:16:29'),(172,'roles','1',1,1,1,1,1,'2020-01-03 11:16:29','2020-01-03 11:16:29'),(173,'bank_accounts','1',1,1,1,1,1,'2020-01-03 11:16:29','2020-01-03 11:16:29'),(174,'activity_logs','1',1,1,1,1,1,'2020-01-03 11:16:29','2020-01-03 11:16:29'),(175,'languages','1',1,1,1,1,1,'2020-01-03 11:16:29','2020-01-03 11:16:29');
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
  `name` varchar(200) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `payment_method_id` varchar(45) DEFAULT NULL,
  `property_status_id` int(11) DEFAULT NULL,
  `contact` varchar(200) DEFAULT NULL,
  `region` varchar(200) DEFAULT NULL,
  `paci_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `bank` varchar(200) DEFAULT NULL,
  `land_lord_id` int(11) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `properties`
--

LOCK TABLES `properties` WRITE;
/*!40000 ALTER TABLE `properties` DISABLE KEYS */;
INSERT INTO `properties` VALUES (1,'Property 1','Karachi',NULL,'2',1,'1234567890','sindh',2,1,'Silk Bank',2,'DHA','2020-01-01 03:38:12','2020-01-01 10:28:56'),(5,'Property 2','Islamabad',NULL,'2',2,'1234567890','sindh',1,1,'Silk Bank',2,'DHA','2020-01-01 06:38:59','2020-01-01 10:17:09'),(6,'Property 3','Islamabad',NULL,'1',1,'1234567890','sindh',1,1,'Silk Bank',3,'DHA','2020-01-01 09:08:49','2020-01-03 02:40:46');
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
  `name` varchar(100) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','admin','2020-01-03 02:58:25','2020-01-03 02:58:25'),(2,'Land Lord','land-lord','2020-01-03 02:58:25','2020-01-03 02:58:25'),(4,'Property Manager','property-manager','2020-01-03 02:59:43','2020-01-03 02:59:43');
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
  `status` varchar(100) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `module` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statuses`
--

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;
INSERT INTO `statuses` VALUES (1,'Active','active','properties'),(2,'In Active','in-active','properties'),(3,'Active','active','leases'),(4,'In Active','in-active','leases'),(5,'Active','active','tenants'),(6,'In Active','in-active','tenants'),(7,'Active','active','invoices'),(8,'In Active','in-active','invoices'),(9,'Active','active','users'),(10,'In Active','in-active','users');
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
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact_number` varchar(45) DEFAULT NULL,
  `national_id` varchar(45) DEFAULT NULL,
  `tenant_status_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenants`
--

LOCK TABLES `tenants` WRITE;
/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;
INSERT INTO `tenants` VALUES (1,'uzair khan','root@email.com','1234567890','2',5,'2020-01-02 05:52:03','2020-01-03 02:46:53');
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
  `name` varchar(200) DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `module` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` VALUES (1,'Lease','lease','properties'),(2,'Installments','installments','properties'),(3,'Rental','rental','leases'),(4,'Installments','installments','leases'),(5,'Lease','lease','invoices'),(6,'Non Lease','non-lease','invoices');
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
  `number` varchar(45) DEFAULT NULL,
  `size` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `no_of_bedrooms` int(11) DEFAULT NULL,
  `no_of_bathrooms` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (54,5,'1','1','residential',1,1,'2020-01-01 10:17:09','2020-01-01 10:17:09'),(74,1,'1','1','commercial',NULL,NULL,'2020-01-02 02:48:32','2020-01-02 02:48:32'),(75,1,'2','2','residential',2,2,'2020-01-02 02:48:32','2020-01-02 02:48:32');
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
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_status_id` int(11) DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@realestate.com',NULL,'$2y$10$eMgUi1v3s.a5xXJDYyv7muDG505.xSwFRL/kDL/u0xpcJVo7o9M5q',NULL,1,'DHa','123456789',9,'/files/1578044875profile-avatar.png','2019-12-31 10:22:21','2020-01-03 08:43:27'),(2,'Land Lord','landlord@realestate.com',NULL,'$2y$10$yQNGD0mwIEHKnBDfNnmeYOpUKF5LYP5NV.y6BQmemH0ESQO.Inc0y',NULL,2,NULL,NULL,9,NULL,'2019-12-31 10:22:21','2019-12-31 10:22:21'),(3,'uzair khan','root@email.com',NULL,NULL,NULL,2,NULL,NULL,9,NULL,'2020-01-02 11:10:13','2020-01-03 02:40:33');
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

-- Dump completed on 2020-01-03 22:06:11
