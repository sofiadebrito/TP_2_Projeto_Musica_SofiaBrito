-- MySQL dump 10.13  Distrib 9.7.0, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: music_db
-- ------------------------------------------------------
-- Server version	9.7.0

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ 'cda11b2b-3e36-11f1-a0c0-ec2e9853b696:1-1382';

--
-- Table structure for table `artistas`
--

DROP TABLE IF EXISTS `artistas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `artistas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artistas`
--

/*!40000 ALTER TABLE `artistas` DISABLE KEYS */;
INSERT INTO `artistas` VALUES (1,'The xx'),(2,'Big Thief'),(3,'KNEECAP'),(4,'Gorillaz'),(5,'Slowdive'),(6,'Bad Gyal'),(7,'IDLES'),(8,'JADE'),(9,'Mike D'),(10,'Peggy Gou'),(11,'Dixon'),(12,'Xinobi');
/*!40000 ALTER TABLE `artistas` ENABLE KEYS */;

--
-- Table structure for table `concertos`
--

DROP TABLE IF EXISTS `concertos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `concertos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `artista_id` int NOT NULL,
  `palco_id` int NOT NULL,
  `dia_data` date NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `artista_id` (`artista_id`),
  KEY `palco_id` (`palco_id`),
  CONSTRAINT `concertos_ibfk_1` FOREIGN KEY (`artista_id`) REFERENCES `artistas` (`id`),
  CONSTRAINT `concertos_ibfk_2` FOREIGN KEY (`palco_id`) REFERENCES `palcos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `concertos`
--

/*!40000 ALTER TABLE `concertos` DISABLE KEYS */;
INSERT INTO `concertos` VALUES (1,1,1,'2026-06-11','23:40:00'),(2,2,3,'2026-06-11','20:45:00'),(3,3,2,'2026-06-11','01:00:00'),(4,4,1,'2026-06-12','23:00:00'),(5,5,3,'2026-06-12','20:50:00'),(6,6,2,'2026-06-12','00:45:00'),(7,7,1,'2026-06-13','22:00:00'),(8,8,2,'2026-06-13','20:55:00'),(9,9,2,'2026-06-13','19:35:00'),(10,10,1,'2026-06-14','21:00:00'),(11,11,4,'2026-06-14','19:00:00'),(12,12,2,'2026-06-14','17:00:00');
/*!40000 ALTER TABLE `concertos` ENABLE KEYS */;

--
-- Table structure for table `palcos`
--

DROP TABLE IF EXISTS `palcos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `palcos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `palcos`
--

/*!40000 ALTER TABLE `palcos` DISABLE KEYS */;
INSERT INTO `palcos` VALUES (1,'Palco Primavera'),(2,'Palco Vodafone'),(3,'Palco Estrella Damm'),(4,'Palco Cupra Pulse');
/*!40000 ALTER TABLE `palcos` ENABLE KEYS */;

--
-- Table structure for table `utilizadores`
--

DROP TABLE IF EXISTS `utilizadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilizadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilizadores`
--

/*!40000 ALTER TABLE `utilizadores` DISABLE KEYS */;
INSERT INTO `utilizadores` VALUES (1,'sofia','$2y$10$5k2hsZvfVXTbGjquVr6Cq.emnJ5X2E3LGvy/aHhEVGLsQX6b852y2');
/*!40000 ALTER TABLE `utilizadores` ENABLE KEYS */;

--
-- Dumping routines for database 'music_db'
--
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-09 12:20:39