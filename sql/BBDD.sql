CREATE DATABASE  IF NOT EXISTS `tzinavos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `tzinavos`;
-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 213.165.71.189    Database: tzinavos
-- ------------------------------------------------------
-- Server version	8.0.42-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ejercicios_asignados`
--

DROP TABLE IF EXISTS `ejercicios_asignados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ejercicios_asignados` (
  `id_ejercicio` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_asignacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_alumno` int NOT NULL,
  `id_entrenador` int NOT NULL,
  `completado` tinyint(1) DEFAULT '0',
  `fecha_completado` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_ejercicio`),
  KEY `id_alumno` (`id_alumno`),
  KEY `id_entrenador` (`id_entrenador`),
  CONSTRAINT `ejercicios_asignados_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ejercicios_asignados_ibfk_2` FOREIGN KEY (`id_entrenador`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ejercicios_asignados`
--

LOCK TABLES `ejercicios_asignados` WRITE;
/*!40000 ALTER TABLE `ejercicios_asignados` DISABLE KEYS */;
/*!40000 ALTER TABLE `ejercicios_asignados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id_evento` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_evento` timestamp NOT NULL,
  `fecha_publicacion_evento` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_entrenador` int NOT NULL,
  `fecha_evento_fin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_evento`),
  KEY `id_entrenador` (`id_entrenador`),
  CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`id_entrenador`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
INSERT INTO `eventos` VALUES (1,'Entrenamiento de fuerza','Sesión de fuerza enfocada en tren superior.','2025-05-02 00:00:00','2025-05-28 11:32:21',1,'2025-05-02 00:00:00'),(2,'Cardio intensivo','Circuito cardiovascular intenso.','2025-05-03 00:00:00','2025-05-28 11:32:21',1,'2025-05-04 00:00:00'),(3,'Clase de técnica','Perfeccionamiento de técnica de combate.','2025-05-05 00:00:00','2025-05-28 11:32:21',1,'2025-05-07 00:00:00'),(4,'Combates controlados','Simulaciones de combate supervisadas.','2025-05-08 00:00:00','2025-05-28 11:32:21',1,'2025-05-08 00:00:00'),(5,'Entrenamiento funcional','Sesión de funcionalidad total del cuerpo.','2025-05-10 00:00:00','2025-05-28 11:32:21',1,'2025-05-11 00:00:00'),(6,'Taller de grappling','Sesión especializada en agarres.','2025-05-12 00:00:00','2025-05-28 11:32:21',1,'2025-05-12 00:00:00'),(7,'Trabajo de suelo','Enfoque en técnicas de suelo.','2025-05-14 00:00:00','2025-05-28 11:32:21',1,'2025-05-16 00:00:00'),(8,'Cardio HIIT','Entrenamiento por intervalos de alta intensidad.','2025-05-18 00:00:00','2025-05-28 11:32:21',1,'2025-05-18 00:00:00'),(9,'Entrenamiento libre','Acceso libre al gimnasio con supervisión.','2025-05-20 00:00:00','2025-05-28 11:32:21',1,'2025-05-21 00:00:00'),(10,'Seminario MMA','Evento con invitado especial sobre MMA.','2025-05-23 00:00:00','2025-05-28 11:32:21',1,'2025-05-25 00:00:00'),(11,'Entrenamiento técnico','Refuerzo técnico general.','2025-06-01 00:00:00','2025-05-28 11:32:21',1,'2025-06-01 00:00:00'),(12,'Entrenamiento de piernas','Trabajo intensivo de piernas.','2025-06-03 00:00:00','2025-05-28 11:32:21',1,'2025-06-04 00:00:00'),(13,'Clínica de boxeo','Corrección técnica de boxeo.','2025-06-05 00:00:00','2025-05-28 11:32:21',1,'2025-06-07 00:00:00'),(14,'Entrenamiento mental','Técnicas de enfoque y concentración.','2025-06-08 00:00:00','2025-05-28 11:32:21',1,'2025-06-08 00:00:00'),(15,'Open mat','Entrenamiento libre para todos.','2025-06-10 00:00:00','2025-05-28 11:32:21',1,'2025-06-11 00:00:00'),(16,'Tácticas de combate','Planificación y ejecución estratégica.','2025-06-13 00:00:00','2025-05-28 11:32:21',1,'2025-06-15 00:00:00'),(17,'Entrenamiento mixto','Fuerza + técnica combinados.','2025-06-16 00:00:00','2025-05-28 11:32:21',1,'2025-06-16 00:00:00'),(18,'Clase de sparring','Combates de práctica.','2025-06-18 00:00:00','2025-05-28 11:32:21',1,'2025-06-19 00:00:00'),(19,'Resistencia extrema','Desarrollo físico extremo.','2025-06-21 00:00:00','2025-05-28 11:32:21',1,'2025-06-22 00:00:00'),(20,'Evaluación técnica','Valoración del progreso de los alumnos.','2025-06-25 00:00:00','2025-05-28 11:32:21',1,'2025-06-27 00:00:00');
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `foro`
--

DROP TABLE IF EXISTS `foro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `foro` (
  `id_mensaje` int NOT NULL AUTO_INCREMENT,
  `contenido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_mensaje` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id_mensaje`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `foro_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foro`
--

LOCK TABLES `foro` WRITE;
/*!40000 ALTER TABLE `foro` DISABLE KEYS */;
/*!40000 ALTER TABLE `foro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noticias`
--

DROP TABLE IF EXISTS `noticias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `noticias` (
  `id_noticia` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_publicacion_noticia` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_entrenador` int NOT NULL,
  PRIMARY KEY (`id_noticia`),
  KEY `id_entrenador` (`id_entrenador`),
  CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`id_entrenador`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noticias`
--

LOCK TABLES `noticias` WRITE;
/*!40000 ALTER TABLE `noticias` DISABLE KEYS */;
/*!40000 ALTER TABLE `noticias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contrasena` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('alumno','entrenador') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'alumno',
  `registrado` tinyint(1) DEFAULT '0',
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Entrenador Principal','mario.alvarez.1a@gmail.com','$2y$10$6IJnDpbLOQb3XXe3kyL/CuAI9jD9r/EBPAC1hDvMTVhzyJKimWpS6','entrenador',1,'2025-05-28 09:53:19');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-28 13:55:54