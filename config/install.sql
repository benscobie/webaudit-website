CREATE TABLE `payments` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT(10) UNSIGNED NOT NULL,
	`method` VARCHAR(20) NOT NULL,
	`amount` VARCHAR(20) NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_payments_user` (`user_id`),
	CONSTRAINT `fk_payments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=InnoDB;

CREATE TABLE `scans` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`status` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`url` VARCHAR(255) NOT NULL,
	`user_id` INT(10) UNSIGNED NOT NULL,
	`created_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`started_date` DATETIME NULL DEFAULT NULL,
	`finished_date` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_users` (`user_id`),
	CONSTRAINT `fk_scans_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=InnoDB;

CREATE TABLE `scan_data` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`scan_id` INT(10) UNSIGNED NOT NULL,
	`key` VARCHAR(255) NOT NULL,
	`value` VARCHAR(255) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_scan` (`scan_id`),
	CONSTRAINT `fk_scan_data_scan` FOREIGN KEY (`scan_id`) REFERENCES `scans` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=InnoDB;

CREATE TABLE `users` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(320) NOT NULL,
	`password` VARCHAR(60) NOT NULL,
	`name` VARCHAR(255) NULL DEFAULT NULL,
	`role` TINYINT(4) NOT NULL DEFAULT '0',
	`created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `email` (`email`)
)
ENGINE=InnoDB;

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `role`, `created`) VALUES
	(1, 'admin@benscobie.com', '$2y$10$F0LnW1sU9.EdbgnFhbpOUeQ0JV1FL7NmmgYrFiGS6JakgzdKQG1NW', NULL, NULL, 0, '2015-10-17 15:12:35');