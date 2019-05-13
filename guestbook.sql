/*
SQLyog Community v13.1.1 (64 bit)
MySQL - 10.1.37-MariaDB : Database - guestbook
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`guestbook` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `guestbook`;

/*Table structure for table `guest_message` */

DROP TABLE IF EXISTS `guest_message`;

CREATE TABLE `guest_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guest_name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `guest_message` */

insert  into `guest_message`(`id`,`guest_name`,`message`,`timestamp`,`is_deleted`) values 
(1,'fsdf','message','2019-05-11 12:41:24',0),
(2,'fsdf','fdsafdsafsd','2019-05-11 12:41:57',0),
(3,'test estrewt','ble bel bla bla \ntest test aaaaa\nbbbbbbbbb','2019-05-11 17:41:06',0),
(4,'sony nikon','sony nikon canon sigma tamron','2019-05-11 17:45:53',0),
(5,'test guest','test message\ntest message\ntest messagetest message\ntest message\ntest message','2019-05-11 17:47:38',0),
(6,'test guest2','test message\ntest message\ntest message test message test message test message test message test message test message','2019-05-11 17:48:18',1),
(7,'test guest 3','test mes test mess ge test message test message test message test message test message','2019-05-11 17:49:03',0),
(8,'test fist','aaaaaaaaaaaaa bbbbbbbbbb ccccccccccc ddddddddddd eeeeeeeee eeeeeeee','2019-05-11 18:09:30',0),
(9,'test','test rfdsafs fsdafdsa fasdfdsaf','2019-05-11 18:09:42',0),
(10,'test 5','test tesfas test5 fsasfdsafdsa','2019-05-11 18:09:51',0),
(11,'test test','tes test test test fdsafdsa dsfasdfds','2019-05-11 18:10:02',1),
(12,'test test test','test test test test test test test test  tese nua test test test test','2019-05-12 07:44:42',0),
(13,'test cai nao','test cai nao test cai nao test cai nao test cai nao','2019-05-12 07:45:06',0),
(14,'test the test','test the test test the test test the test test the test test the test test the test test the test test the test test the test test the test test the test test the test','2019-05-12 15:41:15',0),
(15,'fsdfdas','fdsafdsafdsa trewterwnb wgrew','2019-05-12 16:09:24',0),
(16,'fsadfdsa','fasdfdsa','2019-05-13 15:40:04',0);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`name`,`username`,`password`) values 
(1,'Admin','admin','e10adc3949ba59abbe56e057f20f883e');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
