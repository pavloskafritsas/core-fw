-- MySQL dump 10.13  Distrib 8.0.28, for Linux (x86_64)
--
-- Host: localhost    Database: core_db
-- ------------------------------------------------------
-- Server version	8.0.28-0ubuntu0.20.04.3

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

-- Δημιουργία βάσης δεδομένων
CREATE DATABASE `core_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

-- Χρήση της βάσης δεδομένων
USE `core_db`;

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date_time` datetime NOT NULL,
  `status` enum('Ολοκληρωμένο','Μη ολοκληρωμένο') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Μη ολοκληρωμένο',
  `user_id` bigint unsigned NOT NULL,
  `vaccination_center_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `appointments_user_id_foreign` (`user_id`),
  KEY `appointments_vaccination_center_id_foreign` (`vaccination_center_id`),
  CONSTRAINT `appointments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `appointments_vaccination_center_id_foreign` FOREIGN KEY (`vaccination_center_id`) REFERENCES `vaccination_centers` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointments`
--

LOCK TABLES `appointments` WRITE;
/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
INSERT INTO `appointments` VALUES (1,'2022-04-01 09:00:00','Μη ολοκληρωμένο',2,1);
/*!40000 ALTER TABLE `appointments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_vaccination_center`
--

DROP TABLE IF EXISTS `user_vaccination_center`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_vaccination_center` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `vaccination_center_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_vaccination_center_user_id_foreign` (`user_id`),
  KEY `user_vaccination_center_vaccination_center_id_foreign` (`vaccination_center_id`),
  CONSTRAINT `user_vaccination_center_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `user_vaccination_center_vaccination_center_id_foreign` FOREIGN KEY (`vaccination_center_id`) REFERENCES `vaccination_centers` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_vaccination_center`
--

LOCK TABLES `user_vaccination_center` WRITE;
/*!40000 ALTER TABLE `user_vaccination_center` DISABLE KEYS */;
INSERT INTO `user_vaccination_center` VALUES (1,4,1),(2,5,2);
/*!40000 ALTER TABLE `user_vaccination_center` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amka` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `afm` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('citizen','doctor') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_amka_unique` (`amka`),
  UNIQUE KEY `users_afm_unique` (`afm`),
  UNIQUE KEY `users_adt_unique` (`adt`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Γιώργος','Παπαδόπουλος','01234567890','123456789','ΑΖ123456','1985-04-10','male','papadopoulos@gmail.com','6971234567','citizen'),(2,'Αλέξης','Ιωάννου','09876543210','987654321','ΖΑ654321','1965-03-08',NULL,'','6971234567','citizen'),(3,'Ελένη','Καλογήρου','05555567890','567234678','BB333333','1970-06-20','female','','6939876543','citizen'),(4,'Κώστας','Παπαγιάννης','99999999999','777777777','ΑΑ000000','1960-01-01',NULL,'papadopoulos@gmail.com','6971234567','doctor'),(5,'Αθηνά','Κυριακού','11111111111','666666666','ΖΖ999999','1990-12-31',NULL,'','6990000000','doctor');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vaccination_centers`
--

DROP TABLE IF EXISTS `vaccination_centers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vaccination_centers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vaccination_centers_name_unique` (`name`),
  UNIQUE KEY `vaccination_centers_phone_unique` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vaccination_centers`
--

LOCK TABLES `vaccination_centers` WRITE;
/*!40000 ALTER TABLE `vaccination_centers` DISABLE KEYS */;
INSERT INTO `vaccination_centers` VALUES (1,'Λεωφ. Κηφισίας 39, Μαρούσι','Μέγα Εμβολιαστικό Κέντρο Προμηθέας','15123','+302132161000'),(2,'Εγνατία 154, ΔΕΘ, Θεσσαλονίκη','Μέγα Εμβολιαστικό Κέντρο ΔΕΘ','54636','+302310291111');
/*!40000 ALTER TABLE `vaccination_centers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-03 17:50:59
