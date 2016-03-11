CREATE TABLE `payments` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT(10) UNSIGNED NOT NULL,
	`transaction_id` VARCHAR(255) NOT NULL,
	`transaction_type` VARCHAR(50) NOT NULL,
	`currency` VARCHAR(3) NOT NULL,
	`gross_amount` DOUBLE(10,2) NOT NULL,
	`fee_amont` DOUBLE(10,2) NOT NULL,
	`tax_amount` DOUBLE(10,2) NOT NULL,
	`quantity` INT(10) NOT NULL,
	`provider` VARCHAR(20) NOT NULL,
	`status` TINYINT(2) UNSIGNED NOT NULL DEFAULT '0',
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX `fk_payments_user` (`user_id`),
	CONSTRAINT `fk_payments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=InnoDB;

CREATE TABLE `scans` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`website_id` INT(10) UNSIGNED NOT NULL,
	`status` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`created_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`started_date` DATETIME NULL DEFAULT NULL,
	`finished_date` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_scans_website` (`website_id`),
	CONSTRAINT `fk_scans_website` FOREIGN KEY (`website_id`) REFERENCES `websites` (`id`)
)
ENGINE=InnoDB;

CREATE TABLE `tests` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`scan_id` INT(10) UNSIGNED NOT NULL,
	`name` VARCHAR(50) NOT NULL,
	`status` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
	`started_date` DATETIME NULL DEFAULT NULL,
	`finished_date` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_tests_scan` (`scan_id`),
	CONSTRAINT `fk_tests_scan` FOREIGN KEY (`scan_id`) REFERENCES `scans` (`id`)
)
ENGINE=InnoDB;

CREATE TABLE `test_data` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`test_id` INT(10) UNSIGNED NOT NULL,
	`data_type` INT(10) UNSIGNED NOT NULL,
	`key` VARCHAR(255) NOT NULL,
	`value` VARCHAR(255) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_test_data_test` (`test_id`),
	CONSTRAINT `fk_test_data_test` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`)
)
ENGINE=InnoDB;

CREATE TABLE `users` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(320) NOT NULL,
	`password` VARCHAR(60) NOT NULL,
	`first_name` VARCHAR(255) NULL DEFAULT NULL,
	`last_name` VARCHAR(255) NULL DEFAULT NULL,
	`credit_amount` BIGINT(20) NOT NULL DEFAULT '0',
	`role` TINYINT(4) NOT NULL DEFAULT '0',
	`created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `email` (`email`)
)
ENGINE=InnoDB;

CREATE TABLE `websites` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`protocol` VARCHAR(5) NOT NULL,
	`hostname` VARCHAR(64) NOT NULL,
	`verified` BIT(1) NOT NULL DEFAULT b'0',
	`verification_content` VARCHAR(40) NULL DEFAULT NULL,
	`user_id` INT(10) UNSIGNED NOT NULL,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX `fk_websites_user` (`user_id`),
	CONSTRAINT `fk_websites_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
)
ENGINE=InnoDB;

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `credit_amount`, `role`, `created`) VALUES
	(1, 'admin@benscobie.com', '$2y$10$F0LnW1sU9.EdbgnFhbpOUeQ0JV1FL7NmmgYrFiGS6JakgzdKQG1NW', NULL, NULL, 0, 0, '2015-10-17 15:12:35');

INSERT INTO `websites` (`id`, `protocol`, `hostname`, `verified`, `verification_content`, `user_id`, `created`) VALUES
	(1, 'https', 'www.benscobie.com', b'1', '916ee861dc0eca87a6f948a3266a72ae85f3cc23', 1, '2016-01-29 21:04:36');

INSERT INTO `scans` (`id`, `website_id`, `status`, `created_date`, `started_date`, `finished_date`) VALUES
	(1, 1, 0, '2016-01-29 21:05:21', NULL, NULL);