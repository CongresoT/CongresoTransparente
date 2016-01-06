/*
SQLyog Ultimate v9.33 GA
MySQL - 5.5.44-0ubuntu0.12.04.1 : Database - congresotransparente
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `administrator` */

insert  into `administrator`(`admin_id`,`session_id`,`name`,`last_name`,`email`,`password`,`active`,`creation_date`,`modification_date`,`last_login`,`photo`,`last_ip`) values (1,'105df5449b010d74aaf73d53de311995','Donald','Leiva','admin@donaldleiva.com','$2y$12$F0DNl6Dk6cAHwzziB5PlHuLQXmJmzNxp1sv2mlyFp0ekZlQEYpXd2',1,'2013-10-01 10:00:00','2014-08-17 22:07:03','2015-12-22 04:07:47','2923d-20131106_103210b.jpg',3232235531);

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
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;

/*Data for the table `administrator_log` */

insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (1,1,'Donald Leiva inició sesión.','2015-11-17 12:40:59');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (2,1,'Se ingresó el contenido Acerca de con ID 1.','2015-11-17 12:52:34');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (3,1,'Donald Leiva inició sesión.','2015-12-08 15:53:26');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (4,1,'Donald Leiva inició sesión.','2015-12-09 13:34:43');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (5,1,'Donald Leiva inició sesión.','2015-12-09 19:00:50');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (6,1,'Donald Leiva inició sesión.','2015-12-10 10:40:36');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (7,1,'Se ingresó la ley Ley 1 con ID 1.','2015-12-10 13:21:13');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (8,1,'Se ingresó la ley Ley 2 con ID 2.','2015-12-10 13:21:57');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (9,1,'Se ingresó la ley Ley 3 con ID 3.','2015-12-10 13:26:05');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (10,1,'Se ingresó el distrito Lista Nacional con ID 0.','2015-12-10 13:26:58');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (11,1,'Se ingresó el distrito Municipios del departamento de Guatemala con ID 2.','2015-12-10 13:28:19');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (12,1,'Se ingresó el distrito Distrito Central con ID 3.','2015-12-10 13:28:26');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (13,1,'Se ingresó el distrito Huehuetenango con ID 4.','2015-12-10 13:28:34');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (14,1,'Se ingresó el distrito Alta Verapaz, San Marcos con ID 5.','2015-12-10 13:28:50');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (15,1,'Se ingresó el distrito Quiché con ID 6.','2015-12-10 13:28:57');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (16,1,'Se ingresó el distrito Quetzaltenango con ID 7.','2015-12-10 13:29:13');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (17,1,'Se ingresó el distrito Escuintla con ID 8.','2015-12-10 13:29:25');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (18,1,'Se ingresó el distrito Chimaltenango, Suchitepéquez con ID 9.','2015-12-10 13:29:32');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (19,1,'Se ingresó el distrito Jutiapa, Petén, Totonicapán con ID 10.','2015-12-10 13:29:40');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (20,1,'Se ingresó el distrito Chiquimula, Izabal, Jalapa, Retalhuleu, Sacatepéquez, Santa Rosa, Sololá con ID 11.','2015-12-10 13:29:50');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (21,1,'Se ingresó el distrito Baja Verapaz, Zacapa con ID 12.','2015-12-10 13:29:59');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (22,1,'Se ingresó el distrito El Progreso con ID 13.','2015-12-10 13:30:06');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (23,1,'Se ingresó la bancada Juan Francisco Pérez Ordóñez con ID 0.','2015-12-10 13:36:47');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (24,1,'Se ingresó la bancada Marta Andrea Sánchez Bellini con ID 2.','2015-12-10 13:38:53');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (25,1,'Se ingresó la bancada Óscar Javier Villafuerte Hernández con ID 3.','2015-12-10 13:40:31');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (26,1,'Se ingresó la bancada Sandra Pamela Méndez Castellanos con ID 4.','2015-12-10 13:42:16');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (27,1,'Se actualizó el diputado con ID 4.','2015-12-10 13:42:36');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (28,1,'Se actualizó el diputado con ID 1.','2015-12-10 13:45:52');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (29,1,'Se actualizó el diputado con ID 2.','2015-12-10 13:46:41');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (30,1,'Se actualizó el diputado con ID 3.','2015-12-10 13:46:58');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (31,1,'Se actualizó el diputado con ID 4.','2015-12-10 13:47:17');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (32,1,'Se ingresó voto de diputado con ID 1 sobre iniciativa con ID 1.','2015-12-10 17:23:14');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (33,1,'Se ingresó voto de diputado con ID 1 sobre iniciativa con ID 1.','2015-12-10 17:23:42');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (34,1,'Se ingresó voto de diputado con ID 1 sobre iniciativa con ID 1.','2015-12-10 17:24:27');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (35,1,'Se ingresó voto de diputado con ID 2 sobre iniciativa con ID 1.','2015-12-10 17:24:28');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (36,1,'Se ingresó voto de diputado con ID 2 sobre iniciativa con ID 1.','2015-12-10 17:24:29');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (37,1,'Se ingresó voto de diputado con ID 3 sobre iniciativa con ID 1.','2015-12-10 17:24:31');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (38,1,'Se ingresó voto de diputado con ID 4 sobre iniciativa con ID 1.','2015-12-10 17:24:33');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (39,1,'Se ingresó voto de diputado con ID 4 sobre iniciativa con ID 1.','2015-12-10 17:24:34');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (40,1,'Se ingresó voto de diputado con ID 1 sobre iniciativa con ID 1.','2015-12-10 17:24:35');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (41,1,'Se ingresó voto de diputado con ID 1 sobre iniciativa con ID 1.','2015-12-10 17:24:36');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (42,1,'Se ingresó voto de diputado con ID 3 sobre iniciativa con ID 1.','2015-12-10 17:24:39');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (43,1,'Se ingresó voto de diputado con ID 3 sobre iniciativa con ID 1.','2015-12-10 17:24:40');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (44,1,'Se ingresó voto de diputado con ID 3 sobre iniciativa con ID 1.','2015-12-10 17:24:41');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (45,1,'Se ingresó voto de diputado con ID 4 sobre iniciativa con ID 1.','2015-12-10 17:24:43');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (46,1,'Se ingresó voto de diputado con ID 4 sobre iniciativa con ID 1.','2015-12-10 17:24:44');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (47,1,'Se ingresó voto de diputado con ID 2 sobre iniciativa con ID 1.','2015-12-10 17:33:55');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (48,1,'Se ingresó voto de diputado con ID 2 sobre iniciativa con ID 1.','2015-12-10 17:33:56');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (49,1,'Se ingresó voto de diputado con ID 2 sobre iniciativa con ID 1.','2015-12-10 17:33:57');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (50,1,'Se ingresó voto de diputado con ID 2 sobre iniciativa con ID 1.','2015-12-10 17:33:58');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (51,1,'Se ingresó voto de diputado con ID 2 sobre iniciativa con ID 1.','2015-12-10 17:34:00');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (52,1,'Se ingresó voto de diputado con ID 2 sobre iniciativa con ID 1.','2015-12-10 17:34:01');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (53,1,'Se ingresó voto de diputado con ID 3 sobre iniciativa con ID 1.','2015-12-10 17:34:03');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (54,1,'Se ingresó voto de diputado con ID 3 sobre iniciativa con ID 1.','2015-12-10 17:34:04');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (55,1,'Se ingresó voto de diputado con ID 4 sobre iniciativa con ID 1.','2015-12-10 17:34:05');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (56,1,'Se ingresó voto de diputado con ID 4 sobre iniciativa con ID 1.','2015-12-10 17:34:07');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (57,1,'Se ingresó voto de diputado con ID 4 sobre iniciativa con ID 1.','2015-12-10 17:34:08');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (58,1,'Se ingresó voto de diputado con ID 2 sobre iniciativa con ID 1.','2015-12-10 17:38:58');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (59,1,'Se ingresó voto de diputado con ID 1 sobre iniciativa con ID 1.','2015-12-10 17:38:59');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (60,1,'Se ingresó voto de diputado con ID 4 sobre iniciativa con ID 1.','2015-12-10 17:39:08');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (61,1,'Se ingresó voto de diputado con ID 3 sobre iniciativa con ID 1.','2015-12-10 17:39:09');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (62,1,'Se ingresó voto de diputado con ID 2 sobre iniciativa con ID 1.','2015-12-10 17:39:10');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (63,1,'Se ingresó voto de diputado con ID 1 sobre iniciativa con ID 1.','2015-12-10 17:39:11');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (64,1,'Se ingresó voto de diputado con ID 2 sobre iniciativa con ID 1.','2015-12-10 17:39:12');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (65,1,'Se ingresó voto de diputado con ID 3 sobre iniciativa con ID 1.','2015-12-10 17:39:13');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (66,1,'Se ingresó voto de diputado con ID 4 sobre iniciativa con ID 1.','2015-12-10 17:39:14');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (67,1,'Se ingresó voto de diputado con ID 3 sobre iniciativa con ID 1.','2015-12-10 17:50:08');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (68,1,'Se ingresó voto de diputado con ID 3 sobre iniciativa con ID 1.','2015-12-10 17:50:08');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (69,1,'Se ingresó voto de diputado con ID 4 sobre iniciativa con ID 1.','2015-12-10 17:50:09');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (70,1,'Se ingresó voto de diputado con ID 4 sobre iniciativa con ID 1.','2015-12-10 17:50:10');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (71,1,'Se ingresó voto de diputado con ID 4 sobre iniciativa con ID 1.','2015-12-10 17:50:11');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (72,1,'Se eliminó voto de diputado con ID 1 sobre iniciativa con ID 1.','2015-12-10 17:52:20');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (73,1,'Se eliminó voto de diputado con ID 1 sobre iniciativa con ID 1.','2015-12-10 18:01:08');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (74,1,'Se agregó diputado con ID 1 al listado de votos sobre iniciativa con ID 1.','2015-12-10 18:01:19');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (75,1,'Se eliminó voto de diputado con ID 1 sobre iniciativa con ID 1.','2015-12-10 18:07:36');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (76,1,'Se agregó diputado con ID 1 al listado de votos sobre iniciativa con ID 1.','2015-12-10 18:09:50');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (77,1,'Se ingresó voto de diputado con ID 3 sobre iniciativa con ID 3.','2015-12-10 18:25:21');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (78,1,'Se ingresó voto de diputado con ID 2 sobre iniciativa con ID 3.','2015-12-10 18:25:21');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (79,1,'Se eliminó votos de todos los diputados sobre iniciativa con ID 3.','2015-12-10 18:26:17');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (80,1,'Se agregó diputado con ID 2 al listado de votos sobre iniciativa con ID 3.','2015-12-10 18:26:29');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (81,1,'Se ingresó voto de diputado con ID 2 sobre iniciativa con ID 2.','2015-12-10 18:41:08');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (82,1,'Se ingresó voto de diputado con ID 3 sobre iniciativa con ID 2.','2015-12-10 18:41:10');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (83,1,'Se ingresó voto de diputado con ID 4 sobre iniciativa con ID 2.','2015-12-10 18:41:11');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (84,1,'Se ingresó voto de diputado con ID 1 sobre iniciativa con ID 2.','2015-12-10 18:41:12');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (85,1,'Donald Leiva inició sesión.','2015-12-14 09:02:38');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (86,1,'Donald Leiva inició sesión.','2015-12-15 16:18:03');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (87,1,'Se ingresó la sesión con ID 1 con ID 1.','2015-12-15 16:58:45');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (88,1,'Se ingresó la sesión con ID 2 con ID 2.','2015-12-15 16:59:20');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (89,1,'Donald Leiva inició sesión.','2015-12-16 07:20:27');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (90,1,'Donald Leiva inició sesión.','2015-12-16 08:18:11');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (91,1,'Se ingresó asistencia de diputado con ID 1 sobre sesión con ID 2.','2015-12-16 08:18:36');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (92,1,'Se ingresó asistencia de diputado con ID 2 sobre sesión con ID 2.','2015-12-16 08:18:39');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (93,1,'Se ingresó asistencia de diputado con ID 3 sobre sesión con ID 2.','2015-12-16 08:18:40');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (94,1,'Se ingresó asistencia de diputado con ID 4 sobre sesión con ID 2.','2015-12-16 08:18:41');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (95,1,'Se ingresó asistencia de diputado con ID 1 sobre sesión con ID 2.','2015-12-16 08:19:01');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (96,1,'Se ingresó asistencia de diputado con ID 1 sobre sesión con ID 2.','2015-12-16 08:26:01');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (97,1,'Se ingresó asistencia de diputado con ID 2 sobre sesión con ID 2.','2015-12-16 08:26:05');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (98,1,'Se ingresó asistencia de diputado con ID 3 sobre sesión con ID 2.','2015-12-16 08:26:07');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (99,1,'Se ingresó asistencia de diputado con ID 4 sobre sesión con ID 2.','2015-12-16 08:26:08');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (100,1,'Se eliminó asistencia de diputado con ID 1 sobre sesión con ID 2.','2015-12-16 08:27:49');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (101,1,'Se agregó sesión con ID 1 al listado de votos sobre asistencia con ID 2.','2015-12-16 08:29:02');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (102,1,'Se eliminó asistencia de diputado con ID 2 sobre sesión con ID 2.','2015-12-16 08:30:16');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (103,1,'Se actualizó la sesión con ID 1.','2015-12-16 08:35:37');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (104,1,'Donald Leiva inició sesión.','2015-12-16 15:51:45');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (105,1,'Se ingresó la bancada Partido de prueba con ID 1.','2015-12-16 16:20:30');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (106,1,'Donald Leiva inició sesión.','2015-12-17 17:31:36');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (107,1,'Se ingresó la bancada con ID1 en el historial del diputado con ID 1.','2015-12-17 19:15:17');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (108,1,'Se ingresó la bancada con ID1 en el historial del diputado con ID 1.','2015-12-17 19:25:41');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (109,1,'Donald Leiva inició sesión.','2015-12-22 04:07:47');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (110,1,'Se ingresó la comisión Comisión 1 con ID 1.','2015-12-22 04:20:35');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (111,1,'Se ingresó el diputado con ID 1 en la comisión con ID 1.','2015-12-22 04:24:15');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (112,1,'Se ingresó el diputado con ID 2 en la comisión con ID 1.','2015-12-22 04:24:28');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (113,1,'Se ingresó el diputado con ID 3 en la comisión con ID 1.','2015-12-22 04:24:41');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (114,1,'Se ingresó el diputado con ID 4 en la comisión con ID 1.','2015-12-22 04:24:54');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (115,1,'Se ingresó el diputado con ID 1 en la actividad legislativa con ID 1.','2015-12-22 04:51:54');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (116,1,'Se ingresó la persona con nombre Pedro Arroyave en la actividad legislativa con ID 1.','2015-12-22 04:53:36');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (117,1,'Se actualizó la ley con ID 1.','2015-12-22 04:56:04');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (118,1,'Se actualizó la ley con ID 1.','2015-12-22 04:56:06');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (119,1,'Se actualizó la ley con ID 2.','2015-12-22 04:56:20');
insert  into `administrator_log`(`administrator_log_id`,`admin_id`,`description`,`creation_date`) values (120,1,'Se actualizó la ley con ID 3.','2015-12-22 04:56:31');

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `administrator_module` */

insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (1,'Menú principal','main_menu','',NULL,0);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (2,'Sistema','system','icon-cog\r\n',NULL,1);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (3,'Usuarios','users_management','',NULL,2);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (4,'Roles','role','',NULL,3);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (5,'Bitácora','admin_log','',NULL,4);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (6,'Parámetros','parameter','',NULL,5);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (7,'Contenido','content_menu','icon-list',NULL,6);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (8,'Contenido','content','',NULL,8);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (9,'Catálogos','catalogs','icon-book',NULL,9);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (10,'Bancadas','political_party','',NULL,10);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (11,'Distritos','district','',NULL,11);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (12,'Diputados','congressman','',NULL,12);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (13,'Leyes','law','',NULL,13);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (14,'Comisiones','commission','',NULL,14);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (15,'Sesiones','congress_session','',NULL,15);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (16,'Leyes presentadas','law_submitted','',NULL,16);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (17,'Votaciones','vote','',NULL,17);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (18,'Asistencias','attendance','',NULL,18);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (19,'Citaciones','citation','',NULL,19);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (20,'Pronunciamientos','statement','',NULL,20);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (21,'Dictámenes','ruling','',NULL,21);

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

/*Data for the table `administrator_module_access` */

insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,1,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,2,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,3,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,4,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,5,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,6,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,7,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,8,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,9,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,10,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,11,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,12,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,13,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,14,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,15,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,16,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,17,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,18,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,19,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,20,1,1,1);
insert  into `administrator_module_access`(`role_id`,`module_id`,`add`,`edit`,`delete`) values (1,21,1,1,1);

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

/*Data for the table `administrator_module_closure` */

insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,1,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,2,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (2,2,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (2,3,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,3,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (3,3,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (4,4,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (2,4,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,4,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (5,5,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (2,5,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,5,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (6,6,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (2,6,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,6,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (7,7,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,7,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (8,8,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (7,8,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,8,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,9,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,9,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (10,10,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,10,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,10,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (11,11,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,11,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,11,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (12,12,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,12,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,12,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (13,13,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,13,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,13,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (14,14,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,14,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,14,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (15,15,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,15,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,15,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (16,16,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,16,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,16,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (17,17,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,17,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,17,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (18,18,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,18,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,18,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (19,19,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,19,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,19,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (20,20,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,20,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,20,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (21,21,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,21,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,21,2);

/*Table structure for table `administrator_to_role` */

DROP TABLE IF EXISTS `administrator_to_role`;

CREATE TABLE `administrator_to_role` (
  `admin_id` int(11) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `administrator_to_role` */

insert  into `administrator_to_role`(`admin_id`,`role_id`) values (1,1);

/*Table structure for table `attendance` */

DROP TABLE IF EXISTS `attendance`;

CREATE TABLE `attendance` (
  `congressman_id` int(11) unsigned NOT NULL,
  `congress_session_id` int(11) unsigned NOT NULL,
  `attendance_state_id` tinyint(1) NOT NULL COMMENT '1 - Attended',
  UNIQUE KEY `state_id_UNIQUE` (`congressman_id`,`congress_session_id`),
  KEY `fk_attendance_congress_session1_idx` (`congress_session_id`),
  KEY `fk_attendance_congressman1_idx` (`congressman_id`),
  CONSTRAINT `fk_attendance_congressman1` FOREIGN KEY (`congressman_id`) REFERENCES `congressman` (`congressman_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_attendance_congress_session1` FOREIGN KEY (`congress_session_id`) REFERENCES `congress_session` (`congress_session_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `attendance` */

insert  into `attendance`(`congressman_id`,`congress_session_id`,`attendance_state_id`) values (1,2,4);
insert  into `attendance`(`congressman_id`,`congress_session_id`,`attendance_state_id`) values (3,2,3);
insert  into `attendance`(`congressman_id`,`congress_session_id`,`attendance_state_id`) values (4,2,3);

/*Table structure for table `attendance_state` */

DROP TABLE IF EXISTS `attendance_state`;

CREATE TABLE `attendance_state` (
  `attendance_state_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`attendance_state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `attendance_state` */

insert  into `attendance_state`(`attendance_state_id`,`name`) values (1,'Presente');
insert  into `attendance_state`(`attendance_state_id`,`name`) values (2,'Ausente');
insert  into `attendance_state`(`attendance_state_id`,`name`) values (3,'Ausente con excusa');
insert  into `attendance_state`(`attendance_state_id`,`name`) values (4,'Indeterminado');

/*Table structure for table `citation` */

DROP TABLE IF EXISTS `citation`;

CREATE TABLE `citation` (
  `citation_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `citation_status_id` int(11) unsigned NOT NULL COMMENT '1 - Programmed',
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

/*Data for the table `citation` */

/*Table structure for table `citation_status` */

DROP TABLE IF EXISTS `citation_status`;

CREATE TABLE `citation_status` (
  `citation_status_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`citation_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `citation_status` */

insert  into `citation_status`(`citation_status_id`,`name`) values (1,'Programada');
insert  into `citation_status`(`citation_status_id`,`name`) values (2,'En curso');
insert  into `citation_status`(`citation_status_id`,`name`) values (3,'Concluida');
insert  into `citation_status`(`citation_status_id`,`name`) values (4,'Cancelada');

/*Table structure for table `commission` */

DROP TABLE IF EXISTS `commission`;

CREATE TABLE `commission` (
  `comission_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`comission_id`),
  UNIQUE KEY `comission_id_UNIQUE` (`comission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `commission` */

insert  into `commission`(`comission_id`,`name`,`date`) values (1,'Comisión 1','2015-12-01');

/*Table structure for table `commission_to_congressman` */

DROP TABLE IF EXISTS `commission_to_congressman`;

CREATE TABLE `commission_to_congressman` (
  `congressman_id` int(11) unsigned NOT NULL,
  `comission_id` int(11) unsigned NOT NULL,
  `position` varchar(45) NOT NULL,
  `order` int(11) NOT NULL,
  KEY `fk_comission_to_congressman_congressman1_idx` (`congressman_id`),
  KEY `fk_comission_to_congressman_comission1_idx` (`comission_id`),
  CONSTRAINT `fk_comission_to_congressman_comission1` FOREIGN KEY (`comission_id`) REFERENCES `commission` (`comission_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comission_to_congressman_congressman1` FOREIGN KEY (`congressman_id`) REFERENCES `congressman` (`congressman_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `commission_to_congressman` */

insert  into `commission_to_congressman`(`congressman_id`,`comission_id`,`position`,`order`) values (1,1,'Presidente',1);
insert  into `commission_to_congressman`(`congressman_id`,`comission_id`,`position`,`order`) values (2,1,'Vicepresidente',2);
insert  into `commission_to_congressman`(`congressman_id`,`comission_id`,`position`,`order`) values (3,1,'Vocal I',3);
insert  into `commission_to_congressman`(`congressman_id`,`comission_id`,`position`,`order`) values (4,1,'Vocal II',4);

/*Table structure for table `commission_to_law` */

DROP TABLE IF EXISTS `commission_to_law`;

CREATE TABLE `commission_to_law` (
  `comission_id` int(11) unsigned NOT NULL,
  `law_id` int(11) unsigned NOT NULL,
  KEY `fk_table1_law1_idx` (`law_id`),
  KEY `fk_table1_comission1_idx` (`comission_id`),
  CONSTRAINT `fk_table1_comission1` FOREIGN KEY (`comission_id`) REFERENCES `commission` (`comission_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_law1` FOREIGN KEY (`law_id`) REFERENCES `law` (`law_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `commission_to_law` */

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `congress_session` */

insert  into `congress_session`(`congress_session_id`,`state_id`,`description_link`,`date_begin`,`date_end`,`description`) values (1,1,'','2015-12-01 05:00:00','2015-12-01 15:00:00','<p>\n	Esta es una prueba</p>\n');
insert  into `congress_session`(`congress_session_id`,`state_id`,`description_link`,`date_begin`,`date_end`,`description`) values (2,3,'','2015-12-12 05:00:00','2015-12-12 11:00:00','<p>\n	Esta es una sesi&oacute;n de prueba</p>\n');

/*Table structure for table `congress_session_state` */

DROP TABLE IF EXISTS `congress_session_state`;

CREATE TABLE `congress_session_state` (
  `congress_session_state_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`congress_session_state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `congress_session_state` */

insert  into `congress_session_state`(`congress_session_state_id`,`name`) values (1,'Programada');
insert  into `congress_session_state`(`congress_session_state_id`,`name`) values (2,'Cancelada');
insert  into `congress_session_state`(`congress_session_state_id`,`name`) values (3,'En sesión');
insert  into `congress_session_state`(`congress_session_state_id`,`name`) values (4,'Finalizada');

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
  `numero_legislaturas` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`congressman_id`),
  UNIQUE KEY `congressman_id_UNIQUE` (`congressman_id`),
  KEY `fk_congressman_district1_idx` (`district_id`),
  CONSTRAINT `fk_congressman_district1` FOREIGN KEY (`district_id`) REFERENCES `district` (`district_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `congressman` */

insert  into `congressman`(`congressman_id`,`district_id`,`names`,`last_names`,`birthday`,`sex_id`,`description`,`curriculum`,`photo`,`active`,`facebook_account`,`twitter_hashtag`,`twitter_account`,`numero_legislaturas`) values (1,3,'Juan Francisco','Pérez Ordóñez','1966-12-01',2,'',NULL,'d50d4-987a50fc07cfaa8a0996f3b98adb0673.jpg',1,'','','',2);
insert  into `congressman`(`congressman_id`,`district_id`,`names`,`last_names`,`birthday`,`sex_id`,`description`,`curriculum`,`photo`,`active`,`facebook_account`,`twitter_hashtag`,`twitter_account`,`numero_legislaturas`) values (2,13,'Marta Andrea','Sánchez Bellini','1971-06-15',1,'',NULL,'8cc98-img_0806-2.jpg',1,'','','',2);
insert  into `congressman`(`congressman_id`,`district_id`,`names`,`last_names`,`birthday`,`sex_id`,`description`,`curriculum`,`photo`,`active`,`facebook_account`,`twitter_hashtag`,`twitter_account`,`numero_legislaturas`) values (3,3,'Óscar Javier','Villafuerte Hernández','1981-09-03',2,'',NULL,'57ff0-6.jpg',1,'','','',1);
insert  into `congressman`(`congressman_id`,`district_id`,`names`,`last_names`,`birthday`,`sex_id`,`description`,`curriculum`,`photo`,`active`,`facebook_account`,`twitter_hashtag`,`twitter_account`,`numero_legislaturas`) values (4,13,'Sandra Pamela','Méndez Castellanos','1976-05-21',1,'',NULL,'2fb13-calvihs29.jpg',1,'','','',0);

/*Table structure for table `congressman_to_political_party` */

DROP TABLE IF EXISTS `congressman_to_political_party`;

CREATE TABLE `congressman_to_political_party` (
  `congressman_id` int(11) unsigned NOT NULL,
  `political_party_id` int(11) unsigned NOT NULL,
  `date_begin` date NOT NULL,
  `date_end` date DEFAULT NULL,
  KEY `fk_congressman_to_political_party_political_party1_idx` (`political_party_id`),
  KEY `fk_congressman_to_political_party_congressman1_idx` (`congressman_id`),
  CONSTRAINT `fk_congressman_to_political_party_congressman1` FOREIGN KEY (`congressman_id`) REFERENCES `congressman` (`congressman_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_congressman_to_political_party_political_party1` FOREIGN KEY (`political_party_id`) REFERENCES `political_party` (`political_party_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `congressman_to_political_party` */

insert  into `congressman_to_political_party`(`congressman_id`,`political_party_id`,`date_begin`,`date_end`) values (1,1,'2011-12-01',NULL);
insert  into `congressman_to_political_party`(`congressman_id`,`political_party_id`,`date_begin`,`date_end`) values (1,1,'2007-12-01','2010-12-01');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `content` */

insert  into `content`(`content_id`,`title`,`url_title`,`content`,`thumbnail`,`active`,`hits`,`creation_date`,`creation_admin_id`,`modification_date`,`modification_admin_id`) values (1,'Acerca de','','<h4 style=\"margin: 14px 0px 0px; padding: 0px; font-weight: normal; font-size: 13px; font-style: italic; color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans;\">\n	Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..</h4>\n','',0,0,'2015-11-17 12:52:34',1,'2015-11-17 12:52:34',1);

/*Table structure for table `district` */

DROP TABLE IF EXISTS `district`;

CREATE TABLE `district` (
  `district_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`district_id`),
  UNIQUE KEY `district_id_UNIQUE` (`district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `district` */

insert  into `district`(`district_id`,`name`) values (1,'Lista Nacional');
insert  into `district`(`district_id`,`name`) values (2,'Municipios del departamento de Guatemala');
insert  into `district`(`district_id`,`name`) values (3,'Distrito Central');
insert  into `district`(`district_id`,`name`) values (4,'Huehuetenango');
insert  into `district`(`district_id`,`name`) values (5,'Alta Verapaz, San Marcos');
insert  into `district`(`district_id`,`name`) values (6,'Quiché');
insert  into `district`(`district_id`,`name`) values (7,'Quetzaltenango');
insert  into `district`(`district_id`,`name`) values (8,'Escuintla');
insert  into `district`(`district_id`,`name`) values (9,'Chimaltenango, Suchitepéquez');
insert  into `district`(`district_id`,`name`) values (10,'Jutiapa, Petén, Totonicapán');
insert  into `district`(`district_id`,`name`) values (11,'Chiquimula, Izabal, Jalapa, Retalhuleu, Sacatepéquez, Santa Rosa, Sololá');
insert  into `district`(`district_id`,`name`) values (12,'Baja Verapaz, Zacapa');
insert  into `district`(`district_id`,`name`) values (13,'El Progreso');

/*Table structure for table `law` */

DROP TABLE IF EXISTS `law`;

CREATE TABLE `law` (
  `law_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `law_type_id` tinyint(1) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `number` varchar(45) NOT NULL,
  `presentation_date` date NOT NULL,
  `status_id` tinyint(1) unsigned NOT NULL COMMENT '1 - Primera lectura',
  `document` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`law_id`),
  UNIQUE KEY `law_id_UNIQUE` (`law_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `law` */

insert  into `law`(`law_id`,`law_type_id`,`name`,`description`,`number`,`presentation_date`,`status_id`,`document`) values (1,2,'Ley 1','<p>\n	<span style=\"color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span></p>\n','1','2015-12-01',2,NULL);
insert  into `law`(`law_id`,`law_type_id`,`name`,`description`,`number`,`presentation_date`,`status_id`,`document`) values (2,1,'Ley 2','<p>\n	<span style=\"color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span><span style=\"color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span></p>\n','20','2015-12-01',2,NULL);
insert  into `law`(`law_id`,`law_type_id`,`name`,`description`,`number`,`presentation_date`,`status_id`,`document`) values (3,3,'Ley 3','<p>\n	<span style=\"color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&nbsp;</span><span style=\"color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span></p>\n','354','2015-10-06',2,NULL);

/*Table structure for table `law_status` */

DROP TABLE IF EXISTS `law_status`;

CREATE TABLE `law_status` (
  `status_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `law_status` */

insert  into `law_status`(`status_id`,`name`) values (1,'Propuesta');
insert  into `law_status`(`status_id`,`name`) values (2,'Aprobada');

/*Table structure for table `law_timeline` */

DROP TABLE IF EXISTS `law_timeline`;

CREATE TABLE `law_timeline` (
  `law_timeline_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `law_id` int(11) unsigned NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`law_timeline_id`),
  UNIQUE KEY `law_timeline_id_UNIQUE` (`law_timeline_id`),
  KEY `fk_law_timeline_law1_idx` (`law_id`),
  CONSTRAINT `fk_law_timeline_law1` FOREIGN KEY (`law_id`) REFERENCES `law` (`law_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `law_timeline` */

/*Table structure for table `law_to_congressman` */

DROP TABLE IF EXISTS `law_to_congressman`;

CREATE TABLE `law_to_congressman` (
  `law_id` int(11) unsigned NOT NULL,
  `congressman_id` int(11) unsigned NOT NULL,
  KEY `fk_law_to_congressman_law1_idx` (`law_id`),
  KEY `fk_law_to_congressman_congressman1_idx` (`congressman_id`),
  CONSTRAINT `fk_law_to_congressman_congressman1` FOREIGN KEY (`congressman_id`) REFERENCES `congressman` (`congressman_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `law_to_congressman` */

insert  into `law_to_congressman`(`law_id`,`congressman_id`) values (1,1);

/*Table structure for table `law_to_person` */

DROP TABLE IF EXISTS `law_to_person`;

CREATE TABLE `law_to_person` (
  `law_id` int(11) unsigned NOT NULL,
  `full_name` varchar(255) NOT NULL,
  KEY `fk_law_to_person_law1_idx` (`law_id`),
  CONSTRAINT `fk_law_to_person_law1` FOREIGN KEY (`law_id`) REFERENCES `law` (`law_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `law_to_person` */

insert  into `law_to_person`(`law_id`,`full_name`) values (1,'Pedro Arroyave');

/*Table structure for table `law_type` */

DROP TABLE IF EXISTS `law_type`;

CREATE TABLE `law_type` (
  `law_type_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`law_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `law_type` */

insert  into `law_type`(`law_type_id`,`name`) values (1,'Iniciativa de ley');
insert  into `law_type`(`law_type_id`,`name`) values (2,'Acuerdo legislativo');
insert  into `law_type`(`law_type_id`,`name`) values (3,'Punto resolutivo');
insert  into `law_type`(`law_type_id`,`name`) values (4,'Moción privilegiada');

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

/*Data for the table `library` */

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

/*Data for the table `parameter` */

insert  into `parameter`(`key`,`value`,`description`,`type`) values ('email','admin@donaldleiva.com','Correo electrónico de remitente para mensajes del sistema.','string');
insert  into `parameter`(`key`,`value`,`description`,`type`) values ('timezone','-06','Huso horario','int');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `political_party` */

insert  into `political_party`(`political_party_id`,`full_name`,`short_name`,`logo`,`active`,`color`) values (1,'Partido de prueba','PP',NULL,1,'ff5656');

/*Table structure for table `role` */

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `role` */

insert  into `role`(`role_id`,`name`,`active`) values (1,'Administrador',1);

/*Table structure for table `ruling` */

DROP TABLE IF EXISTS `ruling`;

CREATE TABLE `ruling` (
  `ruling_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `law_id` int(11) unsigned NOT NULL,
  `description` varchar(1000) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`ruling_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ruling` */

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

/*Data for the table `session` */

/*Table structure for table `sex` */

DROP TABLE IF EXISTS `sex`;

CREATE TABLE `sex` (
  `sex_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`sex_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `sex` */

insert  into `sex`(`sex_id`,`name`) values (1,'Femenino');
insert  into `sex`(`sex_id`,`name`) values (2,'Masculino');

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

/*Data for the table `statement` */

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
  CONSTRAINT `fk_vote_congressman1` FOREIGN KEY (`congressman_id`) REFERENCES `congressman` (`congressman_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_vote_law1` FOREIGN KEY (`law_id`) REFERENCES `law` (`law_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `vote` */

insert  into `vote`(`law_id`,`congressman_id`,`date`,`vote_result_id`) values (1,1,NULL,3);
insert  into `vote`(`law_id`,`congressman_id`,`date`,`vote_result_id`) values (1,2,'2015-12-10',1);
insert  into `vote`(`law_id`,`congressman_id`,`date`,`vote_result_id`) values (1,3,'2015-12-10',3);
insert  into `vote`(`law_id`,`congressman_id`,`date`,`vote_result_id`) values (1,4,'2015-12-10',1);
insert  into `vote`(`law_id`,`congressman_id`,`date`,`vote_result_id`) values (2,1,'2015-12-10',2);
insert  into `vote`(`law_id`,`congressman_id`,`date`,`vote_result_id`) values (2,2,'2015-12-10',1);
insert  into `vote`(`law_id`,`congressman_id`,`date`,`vote_result_id`) values (2,3,'2015-12-10',2);
insert  into `vote`(`law_id`,`congressman_id`,`date`,`vote_result_id`) values (2,4,'2015-12-10',1);
insert  into `vote`(`law_id`,`congressman_id`,`date`,`vote_result_id`) values (3,2,NULL,3);

/*Table structure for table `vote_result` */

DROP TABLE IF EXISTS `vote_result`;

CREATE TABLE `vote_result` (
  `vote_result_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`vote_result_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `vote_result` */

insert  into `vote_result`(`vote_result_id`,`name`) values (1,'Sí');
insert  into `vote_result`(`vote_result_id`,`name`) values (2,'No');
insert  into `vote_result`(`vote_result_id`,`name`) values (3,'Indeterminado');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
