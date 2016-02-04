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
/*Data for the table `administrator` */

insert  into `administrator`(`admin_id`,`session_id`,`name`,`last_name`,`email`,`password`,`active`,`creation_date`,`modification_date`,`last_login`,`photo`,`last_ip`) values (1,'2f95807f82bc26063fa3529124ae4f20','Donald','Leiva','admin@donaldleiva.com','$2y$12$F0DNl6Dk6cAHwzziB5PlHuLQXmJmzNxp1sv2mlyFp0ekZlQEYpXd2',1,'2013-10-01 10:00:00','2014-08-17 22:07:03','2016-02-01 17:37:21','2923d-20131106_103210b.jpg',0);

/*Data for the table `administrator_module` */

insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (1,'Menú principal','main_menu','',NULL,0);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (2,'Sistema','system','icon-cog\r\n',NULL,1);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (3,'Usuarios','users_management','',NULL,2);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (4,'Roles','role','',NULL,3);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (5,'Bitácora','admin_log','',NULL,4);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (6,'Parámetros','parameter','',NULL,5);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (7,'Contenido','content_menu','icon-list',NULL,6);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (8,'Contenido','content','',NULL,7);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (9,'Diputados','congressman_menu','icon-user',NULL,8);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (10,'Bancadas','political_party','',NULL,9);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (11,'Distritos','district','',NULL,10);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (12,'Diputados','congressman','',NULL,11);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (13,'Comisiones','commission','',NULL,12);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (14,'Sesiones','congress_session','',NULL,13);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (15,'Asistencias','attendance','',NULL,14);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (16,'Votaciones','vote','',NULL,15);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (17,'Actividades legislativas','law_menu','icon-book',NULL,16);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (18,'Actividades legislativas','law','',NULL,17);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (19,'Citaciones','citation','',NULL,18);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (20,'Pronunciamientos','statement','',NULL,19);
insert  into `administrator_module`(`module_id`,`name`,`internal_name`,`icon_class`,`description`,`order`) values (21,'Dictámenes','ruling','',NULL,20);

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

/*Data for the table `administrator_module_closure` */

insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,1,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,2,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,3,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (2,3,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (2,2,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (3,3,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,4,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (2,4,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (4,4,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,5,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (2,5,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (5,5,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,6,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (2,6,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (6,6,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,7,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (7,7,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,8,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (7,8,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (8,8,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,9,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,9,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,10,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,10,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (10,10,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,11,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,11,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (11,11,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,12,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,12,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (12,12,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,13,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,13,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (13,13,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,14,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,14,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (14,14,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,15,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,15,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (15,15,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,16,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (9,16,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (16,16,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,17,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (17,17,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,18,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (17,18,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (18,18,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,19,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (17,19,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (19,19,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,20,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (17,20,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (20,20,0);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (1,21,2);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (17,21,1);
insert  into `administrator_module_closure`(`parent`,`child`,`depth`) values (21,21,0);

/*Data for the table `administrator_to_role` */

insert  into `administrator_to_role`(`admin_id`,`role_id`) values (1,1);

/*Data for the table `citation_status` */

insert  into `citation_status`(`citation_status_id`,`name`) values (1,'Programada');
insert  into `citation_status`(`citation_status_id`,`name`) values (2,'En curso');
insert  into `citation_status`(`citation_status_id`,`name`) values (3,'Concluida');
insert  into `citation_status`(`citation_status_id`,`name`) values (4,'Cancelada');

/*Data for the table `congress_session_state` */

insert  into `congress_session_state`(`congress_session_state_id`,`name`) values (1,'Programada');
insert  into `congress_session_state`(`congress_session_state_id`,`name`) values (2,'Cancelada');
insert  into `congress_session_state`(`congress_session_state_id`,`name`) values (3,'En sesión');
insert  into `congress_session_state`(`congress_session_state_id`,`name`) values (4,'Finalizada');

/*Data for the table `content` */

insert  into `content`(`content_id`,`title`,`url_title`,`content`,`thumbnail`,`active`,`hits`,`creation_date`,`creation_admin_id`,`modification_date`,`modification_admin_id`) values (1,'Acerca de','','<h4 style=\"margin: 14px 0px 0px; padding: 0px; font-weight: normal; font-size: 13px; font-style: italic; color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans;\">\n	Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..</h4>\n','',0,0,'2015-11-17 12:52:34',1,'2015-11-17 12:52:34',1);
insert  into `content`(`content_id`,`title`,`url_title`,`content`,`thumbnail`,`active`,`hits`,`creation_date`,`creation_admin_id`,`modification_date`,`modification_admin_id`) values (2,'Texto página principal','','<h4 style=\"margin: 14px 0px 0px; padding: 0px; font-weight: normal; font-size: 13px; font-style: italic; color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans;\">\r\n	Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..</h4>\r\n','',0,0,'2015-11-17 12:52:34',1,'2015-11-17 12:52:34',1);
insert  into `content`(`content_id`,`title`,`url_title`,`content`,`thumbnail`,`active`,`hits`,`creation_date`,`creation_admin_id`,`modification_date`,`modification_admin_id`) values (3,'Anuncio página principal','','<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/Xj3UZXVJK_o\" frameborder=\"0\" allowfullscreen></iframe>','',0,0,'2015-11-17 12:52:34',1,'2016-01-15 11:09:09',1);
insert  into `content`(`content_id`,`title`,`url_title`,`content`,`thumbnail`,`active`,`hits`,`creation_date`,`creation_admin_id`,`modification_date`,`modification_admin_id`) values (4,'Bajo construcción','','','',0,0,'2016-01-17 17:36:15',1,'2016-01-17 17:36:15',1);

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

/*Data for the table `law_status` */

insert  into `law_status`(`law_status_id`,`name`,`order`,`icon`) values (1,'Presentada a Dirección Legislativa',1,'law_timeline_status_01.png');
insert  into `law_status`(`law_status_id`,`name`,`order`,`icon`) values (2,'En Evaluación por Comisión de Trabajo',2,'law_timeline_status_02.png');
insert  into `law_status`(`law_status_id`,`name`,`order`,`icon`) values (3,'Primer lectura',3,'law_timeline_status_03.png');
insert  into `law_status`(`law_status_id`,`name`,`order`,`icon`) values (4,'Segunda lectura',4,'law_timeline_status_04.png');
insert  into `law_status`(`law_status_id`,`name`,`order`,`icon`) values (5,'Tercera lectura',5,'law_timeline_status_05.png');
insert  into `law_status`(`law_status_id`,`name`,`order`,`icon`) values (6,'En Consulta por la Corte de Constitucionalidad',6,'law_timeline_status_06.png');
insert  into `law_status`(`law_status_id`,`name`,`order`,`icon`) values (7,'Rechazada por Votación',7,'law_timeline_status_07.png');
insert  into `law_status`(`law_status_id`,`name`,`order`,`icon`) values (8,'Aprobada',8,'law_timeline_status_08.png');
insert  into `law_status`(`law_status_id`,`name`,`order`,`icon`) values (9,'Vigente',9,'law_timeline_status_09.png');

/*Data for the table `law_type` */

insert  into `law_type`(`law_type_id`,`name`) values (1,'Iniciativa de ley');
insert  into `law_type`(`law_type_id`,`name`) values (2,'Acuerdo legislativo');
insert  into `law_type`(`law_type_id`,`name`) values (3,'Punto resolutivo');
insert  into `law_type`(`law_type_id`,`name`) values (4,'Moción privilegiada');

/*Data for the table `parameter` */

insert  into `parameter`(`key`,`value`,`description`,`type`) values ('email','admin@donaldleiva.com','Correo electrónico de remitente para mensajes del sistema.','string');
insert  into `parameter`(`key`,`value`,`description`,`type`) values ('timezone','-06','Huso horario','int');

/*Data for the table `role` */

insert  into `role`(`role_id`,`name`,`active`) values (1,'Administrador',1);

/*Data for the table `sex` */

insert  into `sex`(`sex_id`,`name`) values (1,'Femenino');
insert  into `sex`(`sex_id`,`name`) values (2,'Masculino');

/*Data for the table `vote_result` */

insert  into `vote_result`(`vote_result_id`,`name`) values (1,'Sí');
insert  into `vote_result`(`vote_result_id`,`name`) values (2,'No');
insert  into `vote_result`(`vote_result_id`,`name`) values (3,'Indeterminado');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
