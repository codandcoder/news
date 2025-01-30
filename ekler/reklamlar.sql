/*
MySQL Data Transfer
Source Host: localhost
Source Database: nrnewsv1
Target Host: localhost
Target Database: nrnewsv1
Date: 22.04.2008 18:32:43
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for reklamlar
-- ----------------------------
CREATE TABLE `reklamlar` (
  `reklamid` int(11) unsigned NOT NULL auto_increment,
  `baslik` varchar(255) default NULL,
  `bolge` varchar(40) NOT NULL,
  `tip` tinyint(1) NOT NULL default '0',
  `dosyaadresi` varchar(255) default NULL,
  `url` varchar(255) default NULL,
  `hit` int(11) NOT NULL default '0',
  `tarih` int(11) NOT NULL default '0',
  `genislik` int(11) NOT NULL,
  `yukseklik` int(11) NOT NULL,
  `kod` text,
  `durum` enum('Y','N') NOT NULL default 'Y',
  PRIMARY KEY  (`reklamid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `reklamlar` VALUES ('1', 'Nizip Rehber Reklam?', 'ust', '2', 'images/niziprehber468x60.gif', 'http://www.niziprehber.com', '0', '1202452121', '468', '60', '', 'Y');
INSERT INTO `reklamlar` VALUES ('2', 'Deneme Sol Reklamý', 'sol_1', '1', 'images/niziprehber468x60.gif', 'http://www.niziprehber.com', '2', '1208878010', '120', '100', '', 'Y');
