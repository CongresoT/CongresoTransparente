/*
SQLyog Ultimate v9.33 GA
MySQL - 5.6.21 : Database - congresotransparente
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `administrator` */

DROP TABLE IF EXISTS `administrator`;

CREATE TABLE `administrator` (
  `admin_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `creation_date` datetime NOT NULL,
  `modification_date` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `photo` varchar(32) NOT NULL,
  `last_ip` int(10) unsigned NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `administrator_log` */

DROP TABLE IF EXISTS `administrator_log`;

CREATE TABLE `administrator_log` (
  `administrator_log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned NOT NULL,
  `description` varchar(500) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`administrator_log_id`),
  UNIQUE KEY `administrator_log_id_UNIQUE` (`administrator_log_id`),
  KEY `fk_administrator_log_administrator_idx` (`admin_id`),
  CONSTRAINT `fk_administrator_log_administrator` FOREIGN KEY (`admin_id`) REFERENCES `administrator` (`admin_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `administrator_module` */

DROP TABLE IF EXISTS `administrator_module`;

CREATE TABLE `administrator_module` (
  `module_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `internal_name` varchar(45) NOT NULL,
  `icon_class` varchar(20) NOT NULL,
  `description` text,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `id_modulo_UNIQUE` (`module_id`),
  UNIQUE KEY `nombre_clave_UNIQUE` (`internal_name`),
  UNIQUE KEY `orden_UNIQUE` (`order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `administrator_module_access` */

DROP TABLE IF EXISTS `administrator_module_access`;

CREATE TABLE `administrator_module_access` (
  `role_id` int(11) unsigned NOT NULL,
  `module_id` int(11) unsigned NOT NULL,
  `add` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `edit` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  KEY `fk_administrator_module_access_role1_idx` (`role_id`),
  KEY `fk_administrator_module_access_administrator_module1_idx` (`module_id`),
  CONSTRAINT `fk_administrator_module_access_administrator_module1` FOREIGN KEY (`module_id`) REFERENCES `administrator_module` (`module_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_administrator_module_access_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `administrator_module_closure` */

DROP TABLE IF EXISTS `administrator_module_closure`;

CREATE TABLE `administrator_module_closure` (
  `parent` int(11) unsigned NOT NULL,
  `child` int(11) unsigned NOT NULL,
  `depth` tinyint(1) NOT NULL,
  KEY `fk_administrator_module_closure_administrator_module1_idx` (`parent`),
  KEY `fk_administrator_module_closure_administrator_module2_idx` (`child`),
  CONSTRAINT `fk_administrator_module_closure_administrator_module1` FOREIGN KEY (`parent`) REFERENCES `administrator_module` (`module_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_administrator_module_closure_administrator_module2` FOREIGN KEY (`child`) REFERENCES `administrator_module` (`module_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `administrator_to_role` */

DROP TABLE IF EXISTS `administrator_to_role`;

CREATE TABLE `administrator_to_role` (
  `admin_id` int(11) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `attendance` */

DROP TABLE IF EXISTS `attendance`;

CREATE TABLE `attendance` (
  `congressman_id` int(11) unsigned NOT NULL,
  `congress_session_id` int(11) unsigned NOT NULL,
  `attendance_state_id` tinyint(1) NOT NULL COMMENT '1 - Attended',
  UNIQUE KEY `state_id_UNIQUE` (`congressman_id`,`congress_session_id`),
  KEY `fk_attendance_congress_session1_idx` (`congress_session_id`),
  KEY `fk_attendance_congressman1_idx` (`congressman_id`),
  CONSTRAINT `fk_attendance_congress_session1` FOREIGN KEY (`congress_session_id`) REFERENCES `congress_session` (`congress_session_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_attendance_congressman1` FOREIGN KEY (`congressman_id`) REFERENCES `congressman` (`congressman_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `attendance_state` */

DROP TABLE IF EXISTS `attendance_state`;

CREATE TABLE `attendance_state` (
  `attendance_state_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `color` varchar(7) DEFAULT NULL,
  `order` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`attendance_state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `citation` */

DROP TABLE IF EXISTS `citation`;

CREATE TABLE `citation` (
  `citation_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `citation_status_id` int(11) unsigned NOT NULL COMMENT '1 - Programmed',
  `congressman_id` int(11) unsigned NOT NULL,
  `person_name` varchar(200) NOT NULL,
  `location` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `subject` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `attachment` varchar(100) DEFAULT NULL,
  `audio` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`citation_id`),
  UNIQUE KEY `citation_id_UNIQUE` (`citation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `citation_status` */

DROP TABLE IF EXISTS `citation_status`;

CREATE TABLE `citation_status` (
  `citation_status_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`citation_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `commission` */

DROP TABLE IF EXISTS `commission`;

CREATE TABLE `commission` (
  `comission_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`comission_id`),
  UNIQUE KEY `comission_id_UNIQUE` (`comission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `commission_to_congressman` */

DROP TABLE IF EXISTS `commission_to_congressman`;

CREATE TABLE `commission_to_congressman` (
  `congressman_id` int(11) unsigned NOT NULL,
  `comission_id` int(11) unsigned NOT NULL,
  `position` varchar(45) NOT NULL,
  `order` int(11) NOT NULL,
  KEY `fk_comission_to_congressman_congressman1_idx` (`congressman_id`),
  KEY `fk_comission_to_congressman_comission1_idx` (`comission_id`),
  CONSTRAINT `fk_comission_to_congressman_comission1` FOREIGN KEY (`comission_id`) REFERENCES `commission` (`comission_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_comission_to_congressman_congressman1` FOREIGN KEY (`congressman_id`) REFERENCES `congressman` (`congressman_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `commission_to_law` */

DROP TABLE IF EXISTS `commission_to_law`;

CREATE TABLE `commission_to_law` (
  `comission_id` int(11) unsigned NOT NULL,
  `law_id` int(11) unsigned NOT NULL,
  KEY `fk_table1_law1_idx` (`law_id`),
  KEY `fk_table1_comission1_idx` (`comission_id`),
  CONSTRAINT `fk_table1_comission1` FOREIGN KEY (`comission_id`) REFERENCES `commission` (`comission_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_table1_law1` FOREIGN KEY (`law_id`) REFERENCES `law` (`law_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `congress_session` */

DROP TABLE IF EXISTS `congress_session`;

CREATE TABLE `congress_session` (
  `congress_session_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `state_id` tinyint(1) unsigned NOT NULL COMMENT '1 - Programmed',
  `description_link` varchar(255) NOT NULL,
  `date_begin` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`congress_session_id`),
  UNIQUE KEY `congress_session_id_UNIQUE` (`congress_session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `congress_session_state` */

DROP TABLE IF EXISTS `congress_session_state`;

CREATE TABLE `congress_session_state` (
  `congress_session_state_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`congress_session_state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `congressman` */

DROP TABLE IF EXISTS `congressman`;

CREATE TABLE `congressman` (
  `congressman_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `district_id` int(11) unsigned NOT NULL,
  `names` varchar(100) NOT NULL,
  `last_names` varchar(100) NOT NULL,
  `birthday` date NOT NULL,
  `sex_id` tinyint(3) unsigned NOT NULL COMMENT '1 - Female',
  `description` text NOT NULL,
  `curriculum` varchar(100) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `active` tinyint(3) unsigned NOT NULL,
  `facebook_account` varchar(100) NOT NULL,
  `twitter_hashtag` varchar(45) NOT NULL,
  `twitter_account` varchar(100) NOT NULL,
  `periods` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`congressman_id`),
  UNIQUE KEY `congressman_id_UNIQUE` (`congressman_id`),
  KEY `fk_congressman_district1_idx` (`district_id`),
  CONSTRAINT `fk_congressman_district1` FOREIGN KEY (`district_id`) REFERENCES `district` (`district_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `congressman_to_political_party` */

DROP TABLE IF EXISTS `congressman_to_political_party`;

CREATE TABLE `congressman_to_political_party` (
  `congressman_id` int(11) unsigned NOT NULL,
  `political_party_id` int(11) unsigned NOT NULL,
  `date_begin` date NOT NULL,
  `date_end` date DEFAULT NULL,
  KEY `fk_congressman_to_political_party_political_party1_idx` (`political_party_id`),
  KEY `fk_congressman_to_political_party_congressman1_idx` (`congressman_id`),
  CONSTRAINT `fk_congressman_to_political_party_congressman1` FOREIGN KEY (`congressman_id`) REFERENCES `congressman` (`congressman_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_congressman_to_political_party_political_party1` FOREIGN KEY (`political_party_id`) REFERENCES `political_party` (`political_party_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `content` */

DROP TABLE IF EXISTS `content`;

CREATE TABLE `content` (
  `content_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url_title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `thumbnail` varchar(100) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `hits` int(11) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `creation_admin_id` int(10) unsigned NOT NULL,
  `modification_date` datetime NOT NULL,
  `modification_admin_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`content_id`),
  UNIQUE KEY `content_id_UNIQUE` (`content_id`),
  KEY `fk_content_administrator1_idx` (`creation_admin_id`),
  KEY `fk_content_administrator2_idx` (`modification_admin_id`),
  CONSTRAINT `fk_content_administrator1` FOREIGN KEY (`creation_admin_id`) REFERENCES `administrator` (`admin_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_content_administrator2` FOREIGN KEY (`modification_admin_id`) REFERENCES `administrator` (`admin_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `district` */

DROP TABLE IF EXISTS `district`;

CREATE TABLE `district` (
  `district_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`district_id`),
  UNIQUE KEY `district_id_UNIQUE` (`district_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `law` */

DROP TABLE IF EXISTS `law`;

CREATE TABLE `law` (
  `law_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `law_type_id` tinyint(1) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `number` varchar(45) NOT NULL,
  `presentation_date` date NOT NULL,
  `law_status_id` tinyint(1) unsigned NOT NULL COMMENT '1 - Primera lectura',
  `document` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`law_id`),
  UNIQUE KEY `law_id_UNIQUE` (`law_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `law_status` */

DROP TABLE IF EXISTS `law_status`;

CREATE TABLE `law_status` (
  `law_status_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `order` tinyint(1) unsigned DEFAULT NULL,
  `icon` varchar(100) NOT NULL,
  PRIMARY KEY (`law_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `law_timeline` */

DROP TABLE IF EXISTS `law_timeline`;

CREATE TABLE `law_timeline` (
  `law_timeline_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `law_id` int(11) unsigned NOT NULL,
  `law_status_id` int(11) unsigned DEFAULT NULL,
  `description` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`law_timeline_id`),
  UNIQUE KEY `law_timeline_id_UNIQUE` (`law_timeline_id`),
  KEY `fk_law_timeline_law1_idx` (`law_id`),
  CONSTRAINT `fk_law_timeline_law1` FOREIGN KEY (`law_id`) REFERENCES `law` (`law_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `law_to_congressman` */

DROP TABLE IF EXISTS `law_to_congressman`;

CREATE TABLE `law_to_congressman` (
  `law_id` int(11) unsigned NOT NULL,
  `congressman_id` int(11) unsigned NOT NULL,
  KEY `fk_law_to_congressman_law1_idx` (`law_id`),
  KEY `fk_law_to_congressman_congressman1_idx` (`congressman_id`),
  CONSTRAINT `fk_law_to_congressman_congressman1` FOREIGN KEY (`congressman_id`) REFERENCES `congressman` (`congressman_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `law_to_person` */

DROP TABLE IF EXISTS `law_to_person`;

CREATE TABLE `law_to_person` (
  `law_id` int(11) unsigned NOT NULL,
  `full_name` varchar(255) NOT NULL,
  KEY `fk_law_to_person_law1_idx` (`law_id`),
  CONSTRAINT `fk_law_to_person_law1` FOREIGN KEY (`law_id`) REFERENCES `law` (`law_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `law_type` */

DROP TABLE IF EXISTS `law_type`;

CREATE TABLE `law_type` (
  `law_type_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`law_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `library` */

DROP TABLE IF EXISTS `library`;

CREATE TABLE `library` (
  `library_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `publish_date` datetime NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `description` text NOT NULL,
  `file_type_id` tinyint(1) unsigned NOT NULL COMMENT '1 - Paper/Espectador ',
  `filename` varchar(100) NOT NULL,
  PRIMARY KEY (`library_id`),
  UNIQUE KEY `library_id_UNIQUE` (`library_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `parameter` */

DROP TABLE IF EXISTS `parameter`;

CREATE TABLE `parameter` (
  `key` varchar(45) NOT NULL,
  `value` varchar(255) NOT NULL,
  `description` text,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`key`,`type`),
  UNIQUE KEY `idparameters_UNIQUE` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `political_party` */

DROP TABLE IF EXISTS `political_party`;

CREATE TABLE `political_party` (
  `political_party_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `short_name` varchar(45) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `color` varchar(6) NOT NULL,
  PRIMARY KEY (`political_party_id`),
  UNIQUE KEY `political_party_id_UNIQUE` (`political_party_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `role` */

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `ruling` */

DROP TABLE IF EXISTS `ruling`;

CREATE TABLE `ruling` (
  `ruling_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `law_id` int(11) unsigned NOT NULL,
  `comission_id` int(11) unsigned DEFAULT NULL,
  `description` varchar(1000) NOT NULL,
  `creation_date` datetime NOT NULL,
  `result` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`ruling_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `session` */

DROP TABLE IF EXISTS `session`;

CREATE TABLE `session` (
  `session_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL,
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  UNIQUE KEY `session_id_UNIQUE` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `sex` */

DROP TABLE IF EXISTS `sex`;

CREATE TABLE `sex` (
  `sex_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`sex_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `statement` */

DROP TABLE IF EXISTS `statement`;

CREATE TABLE `statement` (
  `statement_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `congressman_id` int(11) unsigned NOT NULL,
  `subject` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`statement_id`),
  UNIQUE KEY `statement_id_UNIQUE` (`statement_id`),
  KEY `fk_statement_congressman1_idx` (`congressman_id`),
  CONSTRAINT `fk_statement_congressman1` FOREIGN KEY (`congressman_id`) REFERENCES `congressman` (`congressman_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `vote` */

DROP TABLE IF EXISTS `vote`;

CREATE TABLE `vote` (
  `law_id` int(11) unsigned NOT NULL,
  `congressman_id` int(11) unsigned NOT NULL,
  `date` date DEFAULT NULL,
  `vote_result_id` tinyint(3) unsigned NOT NULL COMMENT '0 - No vote',
  UNIQUE KEY `uq_law_coongressman` (`law_id`,`congressman_id`),
  KEY `fk_vote_law1_idx` (`law_id`),
  KEY `fk_vote_congressman1_idx` (`congressman_id`),
  CONSTRAINT `fk_vote_congressman1` FOREIGN KEY (`congressman_id`) REFERENCES `congressman` (`congressman_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_vote_law1` FOREIGN KEY (`law_id`) REFERENCES `law` (`law_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `vote_result` */

DROP TABLE IF EXISTS `vote_result`;

CREATE TABLE `vote_result` (
  `vote_result_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`vote_result_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
