-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.26 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table college_webaudit.scans
CREATE TABLE IF NOT EXISTS `scans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `started_date` datetime DEFAULT NULL,
  `finished_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users` (`user_id`),
  CONSTRAINT `fk_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table college_webaudit.scans: ~0 rows (approximately)
/*!40000 ALTER TABLE `scans` DISABLE KEYS */;
/*!40000 ALTER TABLE `scans` ENABLE KEYS */;


-- Dumping structure for table college_webaudit.scan_data
CREATE TABLE IF NOT EXISTS `scan_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `scan_id` int(10) unsigned NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_scan` (`scan_id`),
  CONSTRAINT `fk_scan` FOREIGN KEY (`scan_id`) REFERENCES `scans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table college_webaudit.scan_data: ~0 rows (approximately)
/*!40000 ALTER TABLE `scan_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `scan_data` ENABLE KEYS */;


-- Dumping structure for table college_webaudit.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(320) NOT NULL,
  `password` varchar(60) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table college_webaudit.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `role`, `created`) VALUES
	(1, 'admin@benscobie.com', '$2y$10$F0LnW1sU9.EdbgnFhbpOUeQ0JV1FL7NmmgYrFiGS6JakgzdKQG1NW', NULL, NULL, 0, '2015-10-17 15:12:35');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
