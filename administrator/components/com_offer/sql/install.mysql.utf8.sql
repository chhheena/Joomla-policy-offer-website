CREATE TABLE IF NOT EXISTS `#__offer_customer` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`state` TINYINT(1)  NOT NULL  DEFAULT 1,
`ordering` INT(11)  NOT NULL  DEFAULT 0,
`checked_out` INT(11)  NOT NULL  DEFAULT 0,
`checked_out_time` DATETIME NOT NULL  DEFAULT "0000-00-00 00:00:00",
`created_by` INT(11)  NOT NULL  DEFAULT 0,
`modified_by` INT(11)  NOT NULL  DEFAULT 0,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

