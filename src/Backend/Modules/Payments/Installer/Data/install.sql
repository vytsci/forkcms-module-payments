DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `method_name` varchar(255) DEFAULT NULL,
  `status` enum('pending','success','failure') DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `currency` varchar(5) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `external_id` int(11) DEFAULT NULL,
  `callback_info` varchar(45) DEFAULT 'callbackPaymentsInfo',
  `callback_success` varchar(255) DEFAULT 'callbackPaymentsSuccess',
  `callback_failure` varchar(255) DEFAULT 'callbackPaymentsFailure',
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `PROFILE` (`profile_id`),
  KEY `METHOD` (`method_name`),
  CONSTRAINT `fk_payments_to_methods` FOREIGN KEY (`method_name`) REFERENCES `payments_methods` (`name`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_payments_to_profiles` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `payments_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments_methods` (
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `installed_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
