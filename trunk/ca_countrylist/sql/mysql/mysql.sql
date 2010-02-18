CREATE TABLE IF NOT EXISTS `ezcountryinfo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `country_code` text NOT NULL,
  `languages` text NOT NULL,
  `continent` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
