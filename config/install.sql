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
	`status` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`url` VARCHAR(255) NOT NULL,
	`user_id` INT(10) UNSIGNED NOT NULL,
	`created_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`started_date` TIMESTAMP NULL DEFAULT NULL,
	`finished_date` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_users` (`user_id`),
	CONSTRAINT `fk_scans_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=InnoDB;

CREATE TABLE `scan_data` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`scan_id` INT(10) UNSIGNED NOT NULL,
	`data_type` INT(10) UNSIGNED NOT NULL,
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
	`first_name` VARCHAR(255) NULL DEFAULT NULL,
	`last_name` VARCHAR(255) NULL DEFAULT NULL,
	`credit_amount` BIGINT(20) NOT NULL DEFAULT '0',
	`role` TINYINT(4) NOT NULL DEFAULT '0',
	`created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `email` (`email`)
)
ENGINE=InnoDB;

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `credit_amount`, `role`, `created`) VALUES
	(1, 'admin@benscobie.com', '$2y$10$F0LnW1sU9.EdbgnFhbpOUeQ0JV1FL7NmmgYrFiGS6JakgzdKQG1NW', NULL, NULL, 0, 0, '2015-10-17 15:12:35');