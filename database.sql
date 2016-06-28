-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.9 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for dim
DROP DATABASE IF EXISTS `dim`;
CREATE DATABASE IF NOT EXISTS `dim` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dim`;


-- Dumping structure for table dim.admin
DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(512) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table dim.admin: ~0 rows (approximately)
DELETE FROM `admin`;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`admin_id`, `admin_email`, `admin_password`) VALUES
	(1, 'mrc@mydavinci.nl', 'f5d303533ec18fb9389ffcb648d9d98431b5f5fc3e0478ccb96def93d8df14fb');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;


-- Dumping structure for table dim.event
DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `event_signup_start` datetime NOT NULL,
  `event_signup_end` datetime NOT NULL,
  `event_date` datetime NOT NULL,
  `event_choices_min` int(11) DEFAULT NULL,
  `event_choices_max` int(11) DEFAULT NULL,
  `event_participants_max` int(11) NOT NULL,
  `event_choices_multiple` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table dim.event: ~2 rows (approximately)
DELETE FROM `event`;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
/*!40000 ALTER TABLE `event` ENABLE KEYS */;


-- Dumping structure for table dim.option
DROP TABLE IF EXISTS `option`;
CREATE TABLE IF NOT EXISTS `option` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_event_id` int(11) NOT NULL,
  `option_name` varchar(255) NOT NULL,
  `option_limit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`option_id`),
  KEY `FK_option_event` (`option_event_id`),
  CONSTRAINT `FK_option_event` FOREIGN KEY (`option_event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table dim.option: ~4 rows (approximately)
DELETE FROM `option`;
/*!40000 ALTER TABLE `option` DISABLE KEYS */;
/*!40000 ALTER TABLE `option` ENABLE KEYS */;


-- Dumping structure for table dim.sector
DROP TABLE IF EXISTS `sector`;
CREATE TABLE IF NOT EXISTS `sector` (
  `sector_id` int(11) NOT NULL AUTO_INCREMENT,
  `sector_event_id` int(11) NOT NULL,
  `sector_name` varchar(255) NOT NULL,
  `sector_limit` int(11) NOT NULL,
  PRIMARY KEY (`sector_id`),
  KEY `FK_sector_event` (`sector_event_id`),
  CONSTRAINT `FK_sector_event` FOREIGN KEY (`sector_event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table dim.sector: ~4 rows (approximately)
DELETE FROM `sector`;
/*!40000 ALTER TABLE `sector` DISABLE KEYS */;
/*!40000 ALTER TABLE `sector` ENABLE KEYS */;


-- Dumping structure for table dim.timeslot
DROP TABLE IF EXISTS `timeslot`;
CREATE TABLE IF NOT EXISTS `timeslot` (
  `timeslot_id` int(11) NOT NULL AUTO_INCREMENT,
  `timeslot_event_id` int(11) NOT NULL,
  `timeslot_name` varchar(50) NOT NULL,
  `timeslot_limit` int(11) NOT NULL,
  PRIMARY KEY (`timeslot_id`),
  KEY `FK_timeslot_event` (`timeslot_event_id`),
  CONSTRAINT `FK_timeslot_event` FOREIGN KEY (`timeslot_event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table dim.timeslot: ~0 rows (approximately)
DELETE FROM `timeslot`;
/*!40000 ALTER TABLE `timeslot` DISABLE KEYS */;
/*!40000 ALTER TABLE `timeslot` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
