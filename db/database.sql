-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.0.30 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para banco_eventos
DROP DATABASE IF EXISTS `banco_eventos`;
CREATE DATABASE IF NOT EXISTS `banco_eventos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `banco_eventos`;

-- Copiando estrutura para tabela banco_eventos.eventos
DROP TABLE IF EXISTS `eventos`;
CREATE TABLE IF NOT EXISTS `eventos` (
  `id_event` int NOT NULL AUTO_INCREMENT,
  `id_org` int NOT NULL,
  `name_event` varchar(100) DEFAULT NULL,
  `description_event` text,
  `start_date_event` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `address_event` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `event_type` enum('Presencial','Online','Híbrido') DEFAULT 'Presencial',
  `capacity` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `status_event` enum('Ativo','Cancelado','Encerrado') DEFAULT 'Ativo',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_event`),
  KEY `id_org` (`id_org`),
  CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`id_org`) REFERENCES `organizadores` (`id_org`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela banco_eventos.eventos: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela banco_eventos.interacoes
DROP TABLE IF EXISTS `interacoes`;
CREATE TABLE IF NOT EXISTS `interacoes` (
  `id_interactions` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_event` int NOT NULL,
  `tipo` enum('like','subscribe','favorite') NOT NULL,
  PRIMARY KEY (`id_interactions`),
  UNIQUE KEY `id_user` (`id_user`,`id_event`,`tipo`),
  KEY `id_event` (`id_event`),
  CONSTRAINT `interacoes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_user`) ON DELETE CASCADE,
  CONSTRAINT `interacoes_ibfk_2` FOREIGN KEY (`id_event`) REFERENCES `eventos` (`id_event`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela banco_eventos.interacoes: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela banco_eventos.organizadores
DROP TABLE IF EXISTS `organizadores`;
CREATE TABLE IF NOT EXISTS `organizadores` (
  `id_org` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `name_fugleman` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `type_org` enum('Pessoa Física','Empresa') DEFAULT 'Pessoa Física',
  PRIMARY KEY (`id_org`),
  UNIQUE KEY `email` (`email`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `organizadores_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela banco_eventos.organizadores: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela banco_eventos.usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `name_user` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela banco_eventos.usuarios: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
