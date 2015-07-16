-- phpMiniAdmin dump 1.9.150108
-- Datetime: 2015-04-27 23:50:45
-- Host: 
-- Database: shortly

/*!40030 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

DROP TABLE IF EXISTS `link`;
CREATE TABLE `link` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `shortlink` varchar(20) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `uses` bigint(20) DEFAULT NULL,
  `lastUsed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `link` DISABLE KEYS */;
INSERT INTO `link` VALUES ('1','a','http://www.irishtimes.com/sport/soccer/english-soccer/heartbreak-for-aston-villa-as-manchester-city-strike-late-1.2189474','0',NULL),('2','b','http://www.irishtimes.com/sport/soccer/national-league/limerick-fc-denied-victory-by-late-shamrock-rovers-strike-1.2189489','0',NULL),('3','c','http://www.irishtimes.com/sport/rugby/pro12/munster-grab-bonus-point-but-fail-to-impress-against-treviso-1.2189450','0',NULL),('4','d','http://www.irishtimes.com/business/economy/euro-zone-warns-greece-no-cash-till-full-reform-deal-1.2187531','0',NULL),('5','e','http://www.irishtimes.com/business/economy/cantillon-2009-the-year-the-gini-was-let-out-of-its-bottle-1.2188527','0',NULL),('6','f','http://www.irishtimes.com/opinion/mediterranean-crisis-eu-must-protect-those-fleeing-conflict-peter-sutherland-1.2188400','0',NULL),('7','g','http://www.irishtimes.com/life-and-style/food-and-drink/barfly-lily-finnegan-s-whitestown-carlingford-co-louth-1.2189347','0',NULL),('8','h','http://www.irishtimes.com/culture/culture-shock-please-no-more-heroes-let-s-not-turn-the-obscenities-of-gallipoli-and-the-great-war-into-glory-1.21878','0',NULL),('9','i','http://www.irishtimes.com/business/agribusiness-and-food/award-winning-chef-reveals-titanic-restaurant-plans-for-belfast-1.2188589','0',NULL),('10','j','http://www.irishtimes.com/business/financial-services/dukes-and-aynsley-seek-departmental-files-on-them-as-ibrc-row-intensifies-1.2188542','0',NULL),('11','k','http://www.irishtimes.com/business/financial-services/banks-secure-judgments-of-almost-53m-in-last-three-months-1.2188541?mode=sample&auth-failed=1&pw','0',NULL),('12','l','http://www.irishtimes.com/life-and-style/homes-and-property/old-meets-new-on-cross-avenue-in-blackrock-1.2184919?mode=sample&auth-failed=1&pw-origin=h','0',NULL);
/*!40000 ALTER TABLE `link` ENABLE KEYS */;

DROP TABLE IF EXISTS `linklookup`;
CREATE TABLE `linklookup` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `shortLink` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `linklookup` DISABLE KEYS */;
INSERT INTO `linklookup` VALUES ('1','a'),('2','b'),('3','c'),('4','d'),('5','e'),('6','f'),('7','g'),('8','h'),('9','i'),('10','j'),('11','k'),('12','l'),('13','m'),('14','n'),('15','o'),('16','p'),('17','q'),('18','r'),('19','s'),('20','t'),('21','u'),('22','v'),('23','w'),('24','x'),('25','y'),('26','z'),('27','A'),('28','B'),('29','C'),('30','D'),('31','E'),('32','F'),('33','G'),('34','H'),('35','I'),('36','J'),('37','K'),('38','L'),('39','M'),('40','N'),('41','O'),('42','P'),('43','Q'),('44','R'),('45','S'),('46','T'),('47','U'),('48','V'),('49','W'),('50','X'),('51','Y'),('52','Z'),('53','0'),('54','1'),('55','2'),('56','3'),('57','4'),('58','5'),('59','6'),('60','7'),('61','8'),('62','9');
/*!40000 ALTER TABLE `linklookup` ENABLE KEYS */;

DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `linkId` bigint(20) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hostname` varchar(70) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `organisation` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Link2Id` (`linkId`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES ('1','12','23.20.150.13','2015-04-24 09:34:23','ec2-23-20-150-13.compute-1.amazonaws.com','Ashburn','US','39.0437','-77.4875','AS14618 Amazon.com, Inc.'),('2','12','93.20.150.16','2015-04-24 10:17:40','16.150.20.93.rev.sfr.net','Paris','FR','48.8600','2.3500','AS15557 Societe Francaise du Radiotelephone S.A'),('3','12','93.20.150.16','2015-04-24 11:17:40','16.150.20.93.rev.sfr.net','Paris','FR','48.8600','2.3500','AS15557 Societe Francaise du Radiotelephone S.A'),('4','12','93.20.150.22','2015-04-24 12:12:44','16.150.20.93.rev.sfr.net','Paris','FR','48.8600','2.3500','AS15557 Societe Francaise du Radiotelephone S.A'),('5','12','23.20.150.13','2015-04-24 13:13:05','ec2-23-20-150-13.compute-1.amazonaws.com','Ashburn','US','39.0437','-77.4875','AS14618 Amazon.com, Inc.'),('6','12','101.99.156.216','2015-04-24 10:29:19','No Hostname','Barrigada','GU','13.4443','144.7863','AS3605 Guam Cablevision, LLC'),('7','12','218.234.71.7','2015-04-27 21:26:59','No Hostname','Yongin','KR','37.5700','126.9800','AS9318 Hanaro Telecom Inc.'),('8','12','218.234.71.7','2015-04-27 21:26:59','No Hostname','Yongin','KR','37.5700','126.9800','AS9318 Hanaro Telecom Inc.'),('9','12','218.234.71.7','2015-04-27 21:26:59','No Hostname','Yongin','KR','37.5700','126.9800','AS9318 Hanaro Telecom Inc.'),('10','12','79.103.45.69','2015-04-24 16:04:19','79.103.45.69.dsl.dyn.forthnet.gr','Athens','GR','37.9667','23.7167','Forthnet'),('11','12','93.20.150.16','2015-04-24 21:02:03','16.150.20.93.rev.sfr.net','Paris','FR','48.8600','2.3500','AS15557 Societe Francaise du Radiotelephone S.A'),('12','12','177.42.113.51','2015-04-24 23:51:19','177.42.113.51.static.host.gvt.net.br','SimÃµes','BR','-7.6000','-40.8167','AS18881 Global Village Telecom'),('13','12','101.99.156.216','2015-04-25 05:29:19','No Hostname','Barrigada','GU','13.4443','144.7863','AS3605 Guam Cablevision, LLC'),('14','12','177.42.113.51','2015-04-25 10:51:19','177.42.113.51.static.host.gvt.net.br','SimÃµes','BR','-7.6000','-40.8167','AS18881 Global Village Telecom'),('15','12','23.20.150.13','2015-04-25 13:30:20','ec2-23-20-150-13.compute-1.amazonaws.com','Ashburn','US','39.0437','-77.4875','AS14618 Amazon.com, Inc.'),('16','12','84.203.3.233','2015-04-25 13:40:01','ip-84-203-3-233.broadband.digiweb.ie','Dundalk','IE','54.000','-6.4167',' Digiweb Ltd.'),('17','12','218.234.71.7','2015-04-27 21:26:59','No Hostname','Yongin','KR','37.5700','126.9800','AS9318 Hanaro Telecom Inc.'),('18','12','218.234.71.7','2015-04-27 21:26:59','No Hostname','Yongin','KR','37.5700','126.9800','AS9318 Hanaro Telecom Inc.'),('19','12','93.20.150.22','2015-04-25 14:12:44','16.150.20.93.rev.sfr.net','Paris','FR','48.8600','2.3500','AS15557 Societe Francaise du Radiotelephone S.A'),('20','12','93.20.150.22','2015-04-25 14:22:44','16.150.20.93.rev.sfr.net','Paris','FR','48.8600','2.3500','AS15557 Societe Francaise du Radiotelephone S.A'),('21','12','67.170.203.63','2015-04-25 11:34:20','c-67-170-203-63.hsd1.ca.comcast.net','San Francisco','US','37.7607','-122.4842','AS7922 Comcast Cable Communications, Inc.'),('22','12','79.103.45.69','2015-04-25 11:24:19','79.103.45.69.dsl.dyn.forthnet.gr','Athens','GR','37.9667','23.7167','Forthnet'),('23','12','79.103.45.69','2015-04-25 11:39:19','79.103.45.69.dsl.dyn.forthnet.gr','Athens','GR','37.9667','23.7167','Forthnet'),('24','12','93.20.150.16','2015-04-25 12:02:03','16.150.20.93.rev.sfr.net','Paris','FR','48.8600','2.3500','AS15557 Societe Francaise du Radiotelephone S.A'),('25','12','186.214.253.96','2015-04-25 13:10:20','186.214.253.96.static.host.gvt.net.br','Salvador','BR','-12.9833','-38.5167','AS18881 Global Village Telecom'),('26','12','186.214.253.96','2015-04-25 13:22:20','186.214.253.96.static.host.gvt.net.br','Salvador','BR','-12.9833','-38.5167','AS18881 Global Village Telecom'),('27','12','186.214.253.96','2015-04-25 13:45:20','186.214.253.96.static.host.gvt.net.br','Salvador','BR','-12.9833','-38.5167','AS18881 Global Village Telecom'),('28','12','218.234.71.7','2015-04-27 21:26:59','No Hostname','Yongin','KR','37.5700','126.9800','AS9318 Hanaro Telecom Inc.'),('29','12','67.170.203.63','2015-04-25 14:34:20','c-67-170-203-63.hsd1.ca.comcast.net','San Francisco','US','37.7607','-122.4842','AS7922 Comcast Cable Communications, Inc.'),('30','12','101.99.156.216','2015-04-25 15:09:19','No Hostname','Barrigada','GU','13.4443','144.7863','AS3605 Guam Cablevision, LLC'),('31','12','101.99.156.216','2015-04-25 15:23:19','No Hostname','Barrigada','GU','13.4443','144.7863','AS3605 Guam Cablevision, LLC'),('32','12','218.234.71.7','2015-04-27 21:26:59','No Hostname','Yongin','KR','37.5700','126.9800','AS9318 Hanaro Telecom Inc.'),('33','12','218.234.71.7','2015-04-27 21:26:59','No Hostname','Yongin','KR','37.5700','126.9800','AS9318 Hanaro Telecom Inc.'),('34','12','84.203.3.233','2015-04-25 17:40:01','ip-84-203-3-233.broadband.digiweb.ie','Dundalk','IE','54.000','-6.4167',' Digiweb Ltd.'),('35','12','84.203.3.233','2015-04-25 17:58:01','ip-84-203-3-233.broadband.digiweb.ie','Dundalk','IE','54.000','-6.4167',' Digiweb Ltd.'),('36','12','84.203.3.233','2015-04-25 20:24:01','ip-84-203-3-233.broadband.digiweb.ie','Dundalk','IE','54.000','-6.4167',' Digiweb Ltd.'),('37','12','84.203.3.233','2015-04-25 21:19:01','ip-84-203-3-233.broadband.digiweb.ie','Dundalk','IE','54.000','-6.4167',' Digiweb Ltd.'),('38','12','84.203.3.233','2015-04-25 21:25:20','ip-84-203-3-233.broadband.digiweb.ie','Dundalk','IE','54.000','-6.4167',' Digiweb Ltd.'),('39','12','67.170.203.63','2015-04-25 22:19:20','c-67-170-203-63.hsd1.ca.comcast.net','San Francisco','US','37.7607','-122.4842','AS7922 Comcast Cable Communications, Inc.'),('40','12','93.20.150.16','2015-04-25 23:02:03','16.150.20.93.rev.sfr.net','Paris','FR','48.8600','2.3500','AS15557 Societe Francaise du Radiotelephone S.A'),('41','12','177.42.113.51','2015-04-25 23:15:19','177.42.113.51.static.host.gvt.net.br','SimÃµes','BR','-7.6000','-40.8167','AS18881 Global Village Telecom'),('42','12','177.42.113.51','2015-04-25 23:25:19','177.42.113.51.static.host.gvt.net.br','SimÃµes','BR','-7.6000','-40.8167','AS18881 Global Village Telecom'),('43','12','177.42.113.51','2015-04-25 23:45:19','177.42.113.51.static.host.gvt.net.br','SimÃµes','BR','-7.6000','-40.8167','AS18881 Global Village Telecom'),('44','12','67.170.203.63','2015-04-26 00:01:20','c-67-170-203-63.hsd1.ca.comcast.net','San Francisco','US','37.7607','-122.4842','AS7922 Comcast Cable Communications, Inc.'),('45','12','67.170.203.63','2015-04-26 02:11:20','c-67-170-203-63.hsd1.ca.comcast.net','San Francisco','US','37.7607','-122.4842','AS7922 Comcast Cable Communications, Inc.'),('46','12','67.170.203.63','2015-04-26 05:02:20','c-67-170-203-63.hsd1.ca.comcast.net','San Francisco','US','37.7607','-122.4842','AS7922 Comcast Cable Communications, Inc.'),('47','12','67.170.203.63','2015-04-26 05:57:20','c-67-170-203-63.hsd1.ca.comcast.net','San Francisco','US','37.7607','-122.4842','AS7922 Comcast Cable Communications, Inc.'),('48','12','93.20.150.16','2015-04-26 06:02:03','16.150.20.93.rev.sfr.net','Paris','FR','48.8600','2.3500','AS15557 Societe Francaise du Radiotelephone S.A'),('49','12','218.234.71.7','2015-04-27 21:26:59','No Hostname','Yongin','KR','37.5700','126.9800','AS9318 Hanaro Telecom Inc.'),('50','12','186.214.253.96','2015-04-20 10:23:20','186.214.253.96.static.host.gvt.net.br','Salvador','BR','-12.9833','-38.5167','AS18881 Global Village Telecom'),('51','12','218.234.71.7','2015-04-27 21:26:59','No Hostname','Yongin','KR','37.5700','126.9800','AS9318 Hanaro Telecom Inc.'),('52','12','93.20.150.22','2015-04-26 00:12:44','16.150.20.93.rev.sfr.net','Paris','FR','48.8600','2.3500','AS15557 Societe Francaise du Radiotelephone S.A'),('53','12','84.203.3.233','2015-04-26 01:00:20','ip-84-203-3-233.broadband.digiweb.ie','Dundalk','IE','54.000','-6.4167',' Digiweb Ltd.'),('54','12','79.103.45.69','2015-04-26 01:24:19','79.103.45.69.dsl.dyn.forthnet.gr','Athens','GR','37.9667','23.7167','Forthnet'),('55','12','93.20.150.22','2015-04-26 01:32:44','16.150.20.93.rev.sfr.net','Paris','FR','48.8600','2.3500','AS15557 Societe Francaise du Radiotelephone S.A'),('56','12','218.234.71.7','2015-04-27 21:26:59','No Hostname','Yongin','KR','37.5700','126.9800','AS9318 Hanaro Telecom Inc.'),('57','12','218.234.71.7','2015-04-28 16:25:56','No Hostname','Yongin','KR','37.5700','126.9800','AS9318 Hanaro Telecom Inc.'),('58','12','218.234.71.7','2015-04-28 18:02:21','No Hostname','Yongin','KR','37.5700','126.9800','AS9318 Hanaro Telecom Inc.'),('59','12','218.234.71.7','2015-04-28 21:41:55','No Hostname','Yongin','KR','37.5700','126.9800','AS9318 Hanaro Telecom Inc.'),('60','12','195.132.185.61','2015-04-28 20:01:10','No Hostname','Marseille','FR','43.2854','5.3761','NC Numericable S.A.'),('61','12','195.132.185.61','2015-04-28 20:16:23','No Hostname','Marseille','FR','43.2854','5.3761','NC Numericable S.A.'),('62','12','195.132.185.61','2015-04-28 20:25:04','No Hostname','Marseille','FR','43.2854','5.3761','NC Numericable S.A.'),('63','12','195.132.185.61','2015-04-28 20:54:56','No Hostname','Marseille','FR','43.2854','5.3761','NC Numericable S.A.'),('64','12','195.132.185.61','2015-04-28 22:19:11','No Hostname','Marseille','FR','43.2854','5.3761','NC Numericable S.A.'),('65','12','195.132.185.61','2015-04-28 22:32:41','No Hostname','Marseille','FR','43.2854','5.3761','NC Numericable S.A.');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('1','alanhannaway1','c4cde7f7dbfb91020a6d8379f4b053a3','robert-forde@hotmail.com'),('2','administrator','af88a0ae641589b908fa8b31f0fcf6e1','robert-forde@hotmail.com'),('3','username1','51d25b4ae8ce20ad29b25cf4f2e23203','robert-forde@hotmail.com'),('4','username2','690a8d66c5fb67b23f45e286ddb57ead','robert-forde@hotmail.com');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

DROP TABLE IF EXISTS `userlink`;
CREATE TABLE `userlink` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) DEFAULT NULL,
  `linkId` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK1_user` (`userId`),
  KEY `FK1_link` (`linkId`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `userlink` DISABLE KEYS */;
INSERT INTO `userlink` VALUES ('1','3','1'),('2','3','2'),('3','3','3'),('4','3','4'),('6','3','6'),('7','3','7'),('8','3','8'),('9','3','9'),('10','3','10'),('11','3','11'),('12','3','12'),('13','4','1'),('14','4','12');
/*!40000 ALTER TABLE `userlink` ENABLE KEYS */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;


-- phpMiniAdmin dump end
