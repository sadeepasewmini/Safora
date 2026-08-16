-- MySQL dump 10.13  Distrib 9.1.0, for Win64 (x86_64)
--
-- Host: localhost    Database: safora_db
-- ------------------------------------------------------
-- Server version	9.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alerts`
--

DROP TABLE IF EXISTS `alerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alerts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('wildlife','crime','weather','road_closure','general') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `area_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Island-wide',
  `severity` enum('info','warning','danger','critical') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'warning',
  `published_by` bigint unsigned DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alerts_published_by_foreign` (`published_by`),
  CONSTRAINT `alerts_published_by_foreign` FOREIGN KEY (`published_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alerts`
--

LOCK TABLES `alerts` WRITE;
/*!40000 ALTER TABLE `alerts` DISABLE KEYS */;
INSERT INTO `alerts` VALUES (1,'🐘 Wild Elephant Highway Warning','Active wild elephant movement reported along Habarana-Trincomalee main road. Motorists are strictly advised to maintain safe speed and avoid night travel.','wildlife','Habarana','warning',1,1,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(2,'🐊 Crocodile Warning - Bentota River','Increased crocodile sightings reported near river banks. Residents and tourists are advised to avoid swimming or entering the water.','wildlife','Bentota','danger',1,1,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(3,'🌧️ Heavy Rainfall & Flash Flood Advisory','Severe weather forecast for Western and Sabaragamuwa provinces. Stay alert for low-lying water logging.','weather','Western Province','info',1,1,'2026-08-16 04:11:07','2026-08-16 04:11:07');
/*!40000 ALTER TABLE `alerts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_categories`
--

DROP TABLE IF EXISTS `incident_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('crime','wildlife','disaster','road') COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bi-exclamation-triangle',
  `risk_level` enum('low','medium','high','critical') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `incident_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_categories`
--

LOCK TABLES `incident_categories` WRITE;
/*!40000 ALTER TABLE `incident_categories` DISABLE KEYS */;
INSERT INTO `incident_categories` VALUES (1,'Elephant Crossing','elephant-crossing','wildlife','bi-bounding-box-circles','high','2026-08-16 04:11:07','2026-08-16 04:11:07'),(2,'Leopard Sighting','leopard-sighting','wildlife','bi-eye-fill','high','2026-08-16 04:11:07','2026-08-16 04:11:07'),(3,'Crocodile Sighting','crocodile-sighting','wildlife','bi-water','high','2026-08-16 04:11:07','2026-08-16 04:11:07'),(4,'Wild Boar Attack','wild-boar-attack','wildlife','bi-shield-exclamation','medium','2026-08-16 04:11:07','2026-08-16 04:11:07'),(5,'Snake Sighting','snake-sighting','wildlife','bi-bug','medium','2026-08-16 04:11:07','2026-08-16 04:11:07'),(6,'Theft / Snatching','theft-snatching','crime','bi-bag-dash','medium','2026-08-16 04:11:07','2026-08-16 04:11:07'),(7,'Harassment Zone','harassment-zone','crime','bi-exclamation-octagon','high','2026-08-16 04:11:07','2026-08-16 04:11:07'),(8,'Robbery','robbery','crime','bi-slash-circle','critical','2026-08-16 04:11:07','2026-08-16 04:11:07'),(9,'Suspicious Activity','suspicious-activity','crime','bi-question-circle','low','2026-08-16 04:11:07','2026-08-16 04:11:07'),(10,'Flood Warning','flood-warning','disaster','bi-tsunami','critical','2026-08-16 04:11:07','2026-08-16 04:11:07'),(11,'Landslide Risk','landslide-risk','disaster','bi-triangle-half','critical','2026-08-16 04:11:07','2026-08-16 04:11:07'),(12,'Fallen Trees','fallen-trees','disaster','bi-tree','medium','2026-08-16 04:11:07','2026-08-16 04:11:07'),(13,'Fire Hazard','fire-hazard','disaster','bi-fire','critical','2026-08-16 04:11:07','2026-08-16 04:11:07'),(14,'Road Accident','road-accident','road','bi-car-front','high','2026-08-16 04:11:07','2026-08-16 04:11:07'),(15,'Traffic Block','traffic-block','road','bi-stop-sign','low','2026-08-16 04:11:07','2026-08-16 04:11:07');
/*!40000 ALTER TABLE `incident_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_images`
--

DROP TABLE IF EXISTS `incident_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `incident_id` bigint unsigned NOT NULL,
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `incident_images_incident_id_foreign` (`incident_id`),
  CONSTRAINT `incident_images_incident_id_foreign` FOREIGN KEY (`incident_id`) REFERENCES `incidents` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_images`
--

LOCK TABLES `incident_images` WRITE;
/*!40000 ALTER TABLE `incident_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `incident_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incidents`
--

DROP TABLE IF EXISTS `incidents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incidents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `category_id` bigint unsigned NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'General Area',
  `severity` enum('low','medium','high','critical') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `status` enum('pending','verified','rejected','resolved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `verified_by` bigint unsigned DEFAULT NULL,
  `resolved_by` bigint unsigned DEFAULT NULL,
  `moderator_notes` text COLLATE utf8mb4_unicode_ci,
  `views_count` int NOT NULL DEFAULT '0',
  `upvotes_count` int NOT NULL DEFAULT '1',
  `downvotes_count` int NOT NULL DEFAULT '0',
  `sms_gateway_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `incidents_user_id_foreign` (`user_id`),
  KEY `incidents_category_id_foreign` (`category_id`),
  KEY `incidents_verified_by_foreign` (`verified_by`),
  KEY `incidents_resolved_by_foreign` (`resolved_by`),
  CONSTRAINT `incidents_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `incident_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `incidents_resolved_by_foreign` FOREIGN KEY (`resolved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `incidents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `incidents_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incidents`
--

LOCK TABLES `incidents` WRITE;
/*!40000 ALTER TABLE `incidents` DISABLE KEYS */;
INSERT INTO `incidents` VALUES (1,5,1,'Wild Elephants crossing Habarana-Trinco Main Road','A herd of three wild elephants including a young calf spotted crossing the main highway near 14th Mile Post.',8.0372000,80.7517000,'Habarana Highway, North Central Province','Habarana','high','verified',2,NULL,NULL,142,1,0,NULL,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(2,6,3,'Crocodile spotted near Bentota Riverbank','Large mugger crocodile seen resting on the grassy bank near local bathing spot.',6.4251000,79.9984000,'River Road, Bentota','Bentota','high','verified',2,NULL,NULL,98,1,0,NULL,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(3,7,7,'Poorly lit walkway near Fort Station','Streetlights non-functional for past 3 days. Frequent harassment reported by evening commuters.',6.9344000,79.8504000,'Station Road, Colombo Fort','Colombo Fort','medium','verified',2,NULL,NULL,210,1,0,NULL,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(4,5,10,'Flash Flooding on Kandy-Colombo Road','Water level rising quickly near Kiribathgoda junction due to heavy monsoon downpour.',6.9801000,79.9234000,'Kandy Road, Kiribathgoda','Kiribathgoda','critical','pending',NULL,NULL,NULL,45,1,0,NULL,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(5,6,9,'Suspicious vehicle lurking near Yatihalagala School','Unregistered van parked near school gate during evening dismissal hours.',7.3095438,80.5694720,'Yatihalagala Road, Katugastota, Kandy','Katugastota','medium','pending',NULL,NULL,NULL,62,1,0,NULL,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(6,5,2,'Leopard spotted near tea estate boundary','Local villagers reported an adult leopard near the forest buffer line in Hatton.',6.8924000,80.5968000,'Norwood Estate, Hatton','Hatton','high','verified',2,NULL,NULL,310,1,0,NULL,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(7,6,12,'Tree Fallen on Peradeniya Main Road','Large banyan tree branch cleared by RDA emergency team.',7.2642000,80.5930000,'Peradeniya Road, Kandy','Peradeniya','medium','resolved',NULL,4,NULL,180,1,0,NULL,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(8,7,14,'False Alarm / Duplicate Traffic Accident Report','Report submitted with incorrect coordinates and fake image.',6.9271000,79.8612000,'Galle Road, Colombo','Colombo','low','rejected',NULL,NULL,'Flagged as duplicate fake report by Safety Review Moderator',12,1,0,NULL,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(9,6,7,'Unlit corridor near Yatihalagala Boarding Area','Dark stretch of road behind medical center requires immediate streetlight installation.',7.3095438,80.5694720,'Yatihalagala Medical Center Lane, Katugastota, Kandy','Katugastota','medium','pending',NULL,NULL,NULL,74,1,0,NULL,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(10,5,11,'Minor Earth Slip on Ella Pass Highway','Loose rocks sliding near turn 4. RDA road sign posted.',6.8667000,81.0466000,'Ella-Wellawaya Pass','Ella','high','verified',2,NULL,NULL,240,1,0,NULL,'2026-08-16 04:11:07','2026-08-16 04:11:07');
/*!40000 ALTER TABLE `incidents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_07_24_000001_create_incident_categories_table',1),(5,'2026_07_24_000002_create_incidents_table',1),(6,'2026_07_24_000003_create_incident_images_table',1),(7,'2026_07_24_000004_create_safe_places_table',1),(8,'2026_07_24_000005_create_alerts_table',1),(9,'2026_07_24_000006_create_sos_requests_table',1),(10,'2026_07_24_000007_add_community_votes_to_incidents_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `safe_places`
--

DROP TABLE IF EXISTS `safe_places`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `safe_places` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('police','hospital','fire_station','shelter','pharmacy') COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_24_7` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `safe_places`
--

LOCK TABLES `safe_places` WRITE;
/*!40000 ALTER TABLE `safe_places` DISABLE KEYS */;
INSERT INTO `safe_places` VALUES (1,'Yatihalagala Medical Center & Safe Haven','hospital','Yatihalagala Road, Katugastota, Kandy','Yatihalagala',7.3095438,80.5694720,'081-2244555',1,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(2,'Katugastota Police Station','police','Kurunegala Road, Katugastota, Kandy','Katugastota',7.3140000,80.6210000,'081-2492222',1,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(3,'Habarana Police Station','police','Trincomalee Road, Habarana','Habarana',8.0360000,80.7530000,'066-2270222',1,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(4,'Colombo National Hospital','hospital','E.W. Perera Mawatha, Colombo 10','Colombo',6.9189000,79.8687000,'011-2691111',1,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(5,'Fort Police Station','police','Chaithya Road, Colombo 01','Colombo Fort',6.9350000,79.8460000,'011-2433333',1,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(6,'Kandy General Hospital','hospital','William Gopallawa Mawatha, Kandy','Kandy',7.2906000,80.6337000,'081-2222261',1,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(7,'Peradeniya Teaching Hospital & Emergency Clinic','hospital','Gaborone Road, Peradeniya','Peradeniya',7.2612000,80.5925000,'081-2388000',1,'2026-08-16 04:11:07','2026-08-16 04:11:07'),(8,'Galle Fire Station','fire_station','Main Street, Galle Fort','Galle',6.0329000,80.2168000,'091-2234000',1,'2026-08-16 04:11:07','2026-08-16 04:11:07');
/*!40000 ALTER TABLE `safe_places` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sos_requests`
--

DROP TABLE IF EXISTS `sos_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sos_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `user_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','responded','resolved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sos_requests_user_id_foreign` (`user_id`),
  CONSTRAINT `sos_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sos_requests`
--

LOCK TABLES `sos_requests` WRITE;
/*!40000 ALTER TABLE `sos_requests` DISABLE KEYS */;
INSERT INTO `sos_requests` VALUES (1,5,'Kavindu Perera','0719876543',6.9271000,79.8612000,'Town Hall, Colombo 07','active','Emergency SOS triggered via mobile button','2026-08-16 04:11:07','2026-08-16 04:11:07'),(2,6,'Anusha Perera','0781122334',7.3095438,80.5694720,'Yatihalagala Road, Katugastota, Kandy','resolved','Resolved by Police Dispatcher','2026-08-16 04:11:07','2026-08-16 04:11:07');
/*!40000 ALTER TABLE `sos_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','moderator','authority','public_user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public_user',
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Master System Admin','admin@safora.lk','0771234567','admin',NULL,NULL,'$2y$12$cPDGknyiLQyF6kAIWbgH1Otp5sNpszmBs0jc1GVcMWTU96ysS/sCy',NULL,'2026-08-16 04:11:05','2026-08-16 04:11:05'),(2,'Safety Review Moderator','moderator@safora.lk','0777654321','moderator',NULL,NULL,'$2y$12$zQ9SZbxBoETbhcmngEw/kun/MMRp4EJwCmQ3P4ZQXAaLTm3rHZlAm',NULL,'2026-08-16 04:11:05','2026-08-16 04:11:05'),(3,'Habarana Police Station','police@safora.lk','0662270222','authority',NULL,NULL,'$2y$12$LDSIIUJA2HwuG6291l6xcepNlhvM0XatXKvcxJEpyTsDxCAEorZ3S',NULL,'2026-08-16 04:11:06','2026-08-16 04:11:06'),(4,'Kandy Central Police Station','kandy_police@safora.lk','0812222222','authority',NULL,NULL,'$2y$12$ZmGOwqbDksL389uVxKWB8OLCY9tM2mX4jWpQ6mv0QHPPIk1C7aYxi',NULL,'2026-08-16 04:11:06','2026-08-16 04:11:06'),(5,'Kavindu Perera','user@safora.lk','0719876543','public_user',NULL,NULL,'$2y$12$/rCvrqCHrK33qL8b6XYhi.nLGICYSrOtCyjQdfGcPfNH6euN3ogc6',NULL,'2026-08-16 04:11:06','2026-08-16 04:11:06'),(6,'Anusha Perera','anusha@safora.lk','0781122334','public_user',NULL,NULL,'$2y$12$Wyek/nGMAdLxmEul/YXNxOqL/rlq4LzwNhMTnfOKVPnar2HIfD2ly',NULL,'2026-08-16 04:11:06','2026-08-16 04:11:06'),(7,'Sanduni Silva','sanduni@safora.lk','0759988776','public_user',NULL,NULL,'$2y$12$muKgqnWZadUPArLe6LAiLOS7PnUbYQ1cX.s15YTHCai07xUlu6RxO',NULL,'2026-08-16 04:11:07','2026-08-16 04:11:07');
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

-- Dump completed on 2026-08-16 15:11:12
