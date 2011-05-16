-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 21, 2010 at 04:46 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mdp`
--

-- --------------------------------------------------------

--
-- Table structure for table `common_Articles`
--

DROP TABLE IF EXISTS `common_Articles`;
CREATE TABLE `common_Articles` (
  `article_id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) DEFAULT NULL,
  `body` varchar(1000) DEFAULT NULL,
  `post_timestamp` int(100) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `authentication_id` int(100) NOT NULL,
  PRIMARY KEY (`article_id`),
  KEY `authentication_id` (`authentication_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `common_Articles`
--

INSERT INTO `common_Articles` VALUES(10, 'NewArticle', 'NewArticleTestEdit yup yup yup yup.', 1285180051, 0, 0);
INSERT INTO `common_Articles` VALUES(11, 'Best Day Ever', 'This is a new news article. The other day we went on an awesome ride in the mountains. No one got hurt, so it was a good day. Horray!\n\nIt was a great day!', 1285269806, 0, 0);
INSERT INTO `common_Articles` VALUES(13, 'New News Article', 'paragraph1\nparagraph2\nparagraph3', 1285866771, 1, 3);
INSERT INTO `common_Articles` VALUES(14, 'Newest News', 'p1\np2\np3', 1285866835, 1, 3);
INSERT INTO `common_Articles` VALUES(15, 'Newer News Article', 'paragraphy1\nparagraphy2\nparagraphy3', 1285867307, 1, 3);
INSERT INTO `common_Articles` VALUES(16, 'Test News Article 1000', 'Whaaaaaat?\n\nReally?\n\n1000? No way!', 1285867349, 1, 3);
INSERT INTO `common_Articles` VALUES(2, 'Welcome to our new website!', 'We focus on brining a variety of unique content to the masses and we\\''re <br/>damned proud about what we create! . . .NOT.', 1279477800, 1, 3);
INSERT INTO `common_Articles` VALUES(34, 'posted by colehafner@gmail.com', 'seriously.', 1287944482, 0, 5);
INSERT INTO `common_Articles` VALUES(3, 'Check out our products...', 'We have a wide selection of products from dirt jumpers to road cruisers, to BMX. We got it all. And they\\''re not bad, okay, okay, they\\''re actually pretty effing spectacularrrrr! Ha, I\\''m a pirate! And they\\''re not bad, okay, okay, they\\''re actually pretty effing spectacularrrrr! Ha, I\\''m a pirate!\n\nhttp://www.facebook.com\n\nAnd they\\''re not bad, okay, okay, they\\''re actually pretty effing spectacularrrrr! Ha, I\\''m a pirate! And they\\''re not bad, okay, okay, they\\''re actually pretty effing spectacularrrrr! Ha, I\\''m a pirate!And they\\''re not bad, okay, okay, they\\''re actually pretty effing spectacularrrrr! Ha, I\\''m a pirate!', 1280339444, 1, 3);
INSERT INTO `common_Articles` VALUES(4, 'Welcome to the Administration Section', 'This is home article\nThis is second paragraph of home article', 1284592000, 1, 3);
INSERT INTO `common_Articles` VALUES(19, 'na2', 'test2', 1286559446, 0, 3);
INSERT INTO `common_Articles` VALUES(20, 'na3', 'test3', 1286559458, 0, 3);
INSERT INTO `common_Articles` VALUES(21, 'na4', 'test4----------', 1286559470, 1, 3);
INSERT INTO `common_Articles` VALUES(22, 'na5', 'test5', 1286559486, 0, 3);
INSERT INTO `common_Articles` VALUES(23, 'na6', 'tyest6', 1286559501, 0, 3);
INSERT INTO `common_Articles` VALUES(24, 'na7', 'tyest7', 1286559515, 0, 3);
INSERT INTO `common_Articles` VALUES(25, 'na8', 'test8', 1286559525, 0, 3);
INSERT INTO `common_Articles` VALUES(26, 'na9', 'test9', 1286559539, 1, 3);
INSERT INTO `common_Articles` VALUES(27, 'na10', 'test10\\\\\\\\np1\n\np2', 1286559551, 1, 3);
INSERT INTO `common_Articles` VALUES(48, 'I peed my pants!', 'Oh jeez! Wow! This was such a scaaaaary movie.', 1290008039, 1, 3);
INSERT INTO `common_Articles` VALUES(49, 'We Have Sweet Skillzz', 'This much is true.', 1286342250, 1, 3);
INSERT INTO `common_Articles` VALUES(50, 'Feature 2', 'Second Feature.', 1286342250, 1, 3);
INSERT INTO `common_Articles` VALUES(51, 'Third Feature', 'Okay.', 1286342250, 1, 3);
INSERT INTO `common_Articles` VALUES(0, NULL, NULL, NULL, 0, 0);
INSERT INTO `common_Articles` VALUES(36, 'This movie was greeeaaaat!', 'Hello world.', 1289469687, 1, 3);
INSERT INTO `common_Articles` VALUES(37, 'This is a test review.', 'Test review body.', 1289496174, 1, 3);
INSERT INTO `common_Articles` VALUES(38, 'Test', 'test', 1289496293, 1, 3);
INSERT INTO `common_Articles` VALUES(39, 'TestTitle', 'TestBody', 1289496584, 1, 3);
INSERT INTO `common_Articles` VALUES(40, 'TestTitleII', 'TestBodyII', 1289496620, 1, 3);
INSERT INTO `common_Articles` VALUES(41, 'test2', 'test32', 1289642647, 1, 3);
INSERT INTO `common_Articles` VALUES(42, 'Articleaslfkjasflk', 'adflkasjf;lsadfkj', 1289643091, 0, 3);
INSERT INTO `common_Articles` VALUES(43, 'TestArticle', 'TestArticle1 for the hangover. This is it.', 1289643197, 1, 3);
INSERT INTO `common_Articles` VALUES(44, 'Best Movie Evarrr!', 'Old school is hilarious! Will Ferrell and Vince Vaughn are at their best. This is a must see!', 1289643465, 1, 3);
INSERT INTO `common_Articles` VALUES(45, 'cool', 'yep', 1289647212, 1, 3);
INSERT INTO `common_Articles` VALUES(46, 'Wow', 'All I can say is \\''wow\\''.', 1289650005, 0, 3);
INSERT INTO `common_Articles` VALUES(47, 'The Best!-o-o-0', 'Mind blowing!!!!!------0-', 1289651873, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `common_ArticleToSection`
--

DROP TABLE IF EXISTS `common_ArticleToSection`;
CREATE TABLE `common_ArticleToSection` (
  `article_to_view_id` int(100) NOT NULL,
  `section_id` int(100) NOT NULL,
  PRIMARY KEY (`article_to_view_id`,`section_id`),
  KEY `section_id` (`section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `common_ArticleToSection`
--

INSERT INTO `common_ArticleToSection` VALUES(0, 2);
INSERT INTO `common_ArticleToSection` VALUES(2, 2);
INSERT INTO `common_ArticleToSection` VALUES(5, 2);
INSERT INTO `common_ArticleToSection` VALUES(6, 2);
INSERT INTO `common_ArticleToSection` VALUES(10, 3);
INSERT INTO `common_ArticleToSection` VALUES(11, 3);
INSERT INTO `common_ArticleToSection` VALUES(13, 3);
INSERT INTO `common_ArticleToSection` VALUES(14, 3);
INSERT INTO `common_ArticleToSection` VALUES(15, 3);
INSERT INTO `common_ArticleToSection` VALUES(16, 3);
INSERT INTO `common_ArticleToSection` VALUES(19, 4);
INSERT INTO `common_ArticleToSection` VALUES(20, 4);
INSERT INTO `common_ArticleToSection` VALUES(21, 4);
INSERT INTO `common_ArticleToSection` VALUES(22, 4);
INSERT INTO `common_ArticleToSection` VALUES(23, 4);
INSERT INTO `common_ArticleToSection` VALUES(24, 4);
INSERT INTO `common_ArticleToSection` VALUES(25, 4);
INSERT INTO `common_ArticleToSection` VALUES(26, 4);
INSERT INTO `common_ArticleToSection` VALUES(27, 4);
INSERT INTO `common_ArticleToSection` VALUES(34, 4);
INSERT INTO `common_ArticleToSection` VALUES(35, 6);
INSERT INTO `common_ArticleToSection` VALUES(36, 6);
INSERT INTO `common_ArticleToSection` VALUES(37, 6);
INSERT INTO `common_ArticleToSection` VALUES(38, 6);
INSERT INTO `common_ArticleToSection` VALUES(39, 6);
INSERT INTO `common_ArticleToSection` VALUES(40, 6);
INSERT INTO `common_ArticleToSection` VALUES(41, 6);
INSERT INTO `common_ArticleToSection` VALUES(42, 6);
INSERT INTO `common_ArticleToSection` VALUES(43, 8);
INSERT INTO `common_ArticleToSection` VALUES(44, 8);
INSERT INTO `common_ArticleToSection` VALUES(45, 7);
INSERT INTO `common_ArticleToSection` VALUES(46, 7);
INSERT INTO `common_ArticleToSection` VALUES(47, 10);
INSERT INTO `common_ArticleToSection` VALUES(48, 11);
INSERT INTO `common_ArticleToSection` VALUES(49, 12);
INSERT INTO `common_ArticleToSection` VALUES(50, 13);

-- --------------------------------------------------------

--
-- Table structure for table `common_ArticleToView`
--

DROP TABLE IF EXISTS `common_ArticleToView`;
CREATE TABLE `common_ArticleToView` (
  `article_to_view_id` int(100) NOT NULL AUTO_INCREMENT,
  `article_id` int(100) NOT NULL,
  `view_id` int(100) NOT NULL,
  PRIMARY KEY (`article_to_view_id`),
  KEY `article_id` (`article_id`),
  KEY `view_id` (`view_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `common_ArticleToView`
--

INSERT INTO `common_ArticleToView` VALUES(0, 0, 0);
INSERT INTO `common_ArticleToView` VALUES(2, 2, 6);
INSERT INTO `common_ArticleToView` VALUES(6, 4, 11);
INSERT INTO `common_ArticleToView` VALUES(5, 3, 3);
INSERT INTO `common_ArticleToView` VALUES(10, 10, 2);
INSERT INTO `common_ArticleToView` VALUES(11, 11, 2);
INSERT INTO `common_ArticleToView` VALUES(13, 13, 2);
INSERT INTO `common_ArticleToView` VALUES(14, 14, 2);
INSERT INTO `common_ArticleToView` VALUES(15, 15, 2);
INSERT INTO `common_ArticleToView` VALUES(16, 16, 2);
INSERT INTO `common_ArticleToView` VALUES(34, 34, 8);
INSERT INTO `common_ArticleToView` VALUES(19, 19, 8);
INSERT INTO `common_ArticleToView` VALUES(20, 20, 8);
INSERT INTO `common_ArticleToView` VALUES(21, 21, 8);
INSERT INTO `common_ArticleToView` VALUES(22, 22, 8);
INSERT INTO `common_ArticleToView` VALUES(23, 23, 8);
INSERT INTO `common_ArticleToView` VALUES(24, 24, 8);
INSERT INTO `common_ArticleToView` VALUES(25, 25, 8);
INSERT INTO `common_ArticleToView` VALUES(26, 26, 8);
INSERT INTO `common_ArticleToView` VALUES(27, 27, 8);
INSERT INTO `common_ArticleToView` VALUES(47, 48, 20);
INSERT INTO `common_ArticleToView` VALUES(35, 36, 20);
INSERT INTO `common_ArticleToView` VALUES(36, 37, 20);
INSERT INTO `common_ArticleToView` VALUES(37, 38, 20);
INSERT INTO `common_ArticleToView` VALUES(38, 39, 20);
INSERT INTO `common_ArticleToView` VALUES(39, 40, 20);
INSERT INTO `common_ArticleToView` VALUES(40, 41, 20);
INSERT INTO `common_ArticleToView` VALUES(41, 42, 20);
INSERT INTO `common_ArticleToView` VALUES(42, 43, 20);
INSERT INTO `common_ArticleToView` VALUES(43, 44, 20);
INSERT INTO `common_ArticleToView` VALUES(44, 45, 20);
INSERT INTO `common_ArticleToView` VALUES(45, 46, 20);
INSERT INTO `common_ArticleToView` VALUES(46, 47, 20);
INSERT INTO `common_ArticleToView` VALUES(48, 49, 6);
INSERT INTO `common_ArticleToView` VALUES(49, 50, 6);
INSERT INTO `common_ArticleToView` VALUES(50, 51, 6);

-- --------------------------------------------------------

--
-- Table structure for table `common_Authentication`
--

DROP TABLE IF EXISTS `common_Authentication`;
CREATE TABLE `common_Authentication` (
  `authentication_id` int(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(1000) DEFAULT NULL,
  `password` varchar(10000) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`authentication_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `common_Authentication`
--

INSERT INTO `common_Authentication` VALUES(0, NULL, NULL, 0);
INSERT INTO `common_Authentication` VALUES(2, 'devin-hill@hotmail.com', 'death666', 1);
INSERT INTO `common_Authentication` VALUES(3, 'admin@admin.com', 'admin', 1);
INSERT INTO `common_Authentication` VALUES(5, 'colehafner@gmail.com', 'dasldoof', 0);
INSERT INTO `common_Authentication` VALUES(6, 'cole@spawnordie.com', 'dasldoof', 0);

-- --------------------------------------------------------

--
-- Table structure for table `common_AuthenticationToPermission`
--

DROP TABLE IF EXISTS `common_AuthenticationToPermission`;
CREATE TABLE `common_AuthenticationToPermission` (
  `authentication_id` int(100) NOT NULL,
  `permission_id` int(100) NOT NULL,
  PRIMARY KEY (`authentication_id`,`permission_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `common_AuthenticationToPermission`
--

INSERT INTO `common_AuthenticationToPermission` VALUES(2, 2);
INSERT INTO `common_AuthenticationToPermission` VALUES(2, 3);
INSERT INTO `common_AuthenticationToPermission` VALUES(3, 2);
INSERT INTO `common_AuthenticationToPermission` VALUES(3, 3);
INSERT INTO `common_AuthenticationToPermission` VALUES(5, 2);
INSERT INTO `common_AuthenticationToPermission` VALUES(6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `common_Captcha`
--

DROP TABLE IF EXISTS `common_Captcha`;
CREATE TABLE `common_Captcha` (
  `captcha_id` int(100) NOT NULL AUTO_INCREMENT,
  `file_id` int(100) NOT NULL,
  `captcha_string` varchar(1000) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`captcha_id`),
  KEY `file_id` (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `common_Captcha`
--

INSERT INTO `common_Captcha` VALUES(0, 0, NULL, 0);
INSERT INTO `common_Captcha` VALUES(2, 14, 'vavaws', 1);
INSERT INTO `common_Captcha` VALUES(3, 15, 'pehuyar', 1);
INSERT INTO `common_Captcha` VALUES(4, 16, 'sagihen', 1);
INSERT INTO `common_Captcha` VALUES(5, 17, 'fatawir', 1);
INSERT INTO `common_Captcha` VALUES(6, 18, 'xum1nov', 1);

-- --------------------------------------------------------

--
-- Table structure for table `common_Contacts`
--

DROP TABLE IF EXISTS `common_Contacts`;
CREATE TABLE `common_Contacts` (
  `contact_id` int(100) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(1000) DEFAULT NULL,
  `last_name` varchar(1000) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `thumb_id` int(100) NOT NULL,
  `full_img_id` int(100) NOT NULL,
  `authentication_id` int(100) NOT NULL,
  `contact_type_id` int(100) NOT NULL,
  PRIMARY KEY (`contact_id`),
  KEY `thumb_id` (`thumb_id`),
  KEY `full_img_id` (`full_img_id`),
  KEY `authentication_id` (`authentication_id`),
  KEY `contact_type_id` (`contact_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `common_Contacts`
--

INSERT INTO `common_Contacts` VALUES(0, NULL, NULL, NULL, 0, 74, 0, 0, 8);
INSERT INTO `common_Contacts` VALUES(2, 'Devin', 'Hill', 'founder of madness entertainment.', 1, 90, 70, 2, 8);
INSERT INTO `common_Contacts` VALUES(3, 'New ', 'Crew', 'member.', 0, 72, 73, 0, 8);
INSERT INTO `common_Contacts` VALUES(4, 'New', 'Crewtwo', 'live crew.', 0, 87, 76, 6, 8);
INSERT INTO `common_Contacts` VALUES(5, 'Cole', 'Hafner', 'cole hafner is the creator of this website. he is proud of his work. ', 1, 91, 0, 3, 13);
INSERT INTO `common_Contacts` VALUES(6, 'Bill', 'Brasky', 'once lept from the empire state building and only sprained his ankle.', 0, 77, 0, 5, 8);
INSERT INTO `common_Contacts` VALUES(7, 'King', 'Cole', 'crest', 0, 79, 0, 0, 8);
INSERT INTO `common_Contacts` VALUES(8, 'Nate ', 'Albertson', 'he is the mic guy. booooooom! mic!', 1, 92, 0, 0, 8);
INSERT INTO `common_Contacts` VALUES(9, 'Luna', 'Dog', 'the mascot...', 0, 81, 82, 0, 8);
INSERT INTO `common_Contacts` VALUES(10, 'Luna', 'Tuna', 'this is another user to test the front end bizzznassss.', 0, 83, 84, 0, 8);
INSERT INTO `common_Contacts` VALUES(11, 'Dev', 'Test iii', 'test from dev.', 0, 0, 0, 0, 8);
INSERT INTO `common_Contacts` VALUES(12, 'Tim', 'Odonell', 'test', 0, 0, 0, 0, 8);
INSERT INTO `common_Contacts` VALUES(13, 'Chrome', 'Dev test', 'test', 0, 86, 85, 0, 8);

-- --------------------------------------------------------

--
-- Table structure for table `common_ContactTypes`
--

DROP TABLE IF EXISTS `common_ContactTypes`;
CREATE TABLE `common_ContactTypes` (
  `contact_type_id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`contact_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `common_ContactTypes`
--

INSERT INTO `common_ContactTypes` VALUES(8, 'Camera Man', 0);
INSERT INTO `common_ContactTypes` VALUES(10, 'Founder', 0);
INSERT INTO `common_ContactTypes` VALUES(0, NULL, 0);
INSERT INTO `common_ContactTypes` VALUES(11, 'Mobile safari test', 0);
INSERT INTO `common_ContactTypes` VALUES(12, 'Hello World', 1);
INSERT INTO `common_ContactTypes` VALUES(13, 'System Admin', 1);
INSERT INTO `common_ContactTypes` VALUES(14, 'Heather is Smelly', 0);

-- --------------------------------------------------------

--
-- Table structure for table `common_EnvVars`
--

DROP TABLE IF EXISTS `common_EnvVars`;
CREATE TABLE `common_EnvVars` (
  `env_var_id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `content` varchar(10000) DEFAULT NULL,
  PRIMARY KEY (`env_var_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `common_EnvVars`
--

INSERT INTO `common_EnvVars` VALUES(6, 'index_tagline', 1, 'We are just fantastic.');
INSERT INTO `common_EnvVars` VALUES(13, 'contact_mail_to', 1, 'devin-hill@hotmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `common_Files`
--

DROP TABLE IF EXISTS `common_Files`;
CREATE TABLE `common_Files` (
  `file_id` int(100) NOT NULL AUTO_INCREMENT,
  `file_type_id` int(100) NOT NULL,
  `file_name` varchar(1000) DEFAULT NULL,
  `upload_timestamp` int(100) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`file_id`),
  KEY `file_type_id` (`file_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

--
-- Dumping data for table `common_Files`
--

INSERT INTO `common_Files` VALUES(0, 0, NULL, NULL, 0);
INSERT INTO `common_Files` VALUES(2, 18, 'bike1_thumb.jpg', 1279471403, 1);
INSERT INTO `common_Files` VALUES(3, 18, 'bike1_full.jpg', 1279471403, 1);
INSERT INTO `common_Files` VALUES(4, 18, 'bike2_thumb.jpg', 1279471403, 1);
INSERT INTO `common_Files` VALUES(5, 18, 'bike2_full.jpg', 1279471403, 1);
INSERT INTO `common_Files` VALUES(6, 18, 'bike3_thumb.jpg', 1279471403, 1);
INSERT INTO `common_Files` VALUES(7, 18, 'bike3_full.jpg', 1279471403, 1);
INSERT INTO `common_Files` VALUES(8, 18, 'bike4_thumb.jpg', 1279471403, 1);
INSERT INTO `common_Files` VALUES(9, 18, 'bike4_full.jpg', 1279471403, 1);
INSERT INTO `common_Files` VALUES(10, 18, 'dirt_jumper.gif', 1279471403, 1);
INSERT INTO `common_Files` VALUES(11, 18, 'road_bike.gif', 1279471403, 1);
INSERT INTO `common_Files` VALUES(12, 18, 'bmx.gif', 1279471403, 1);
INSERT INTO `common_Files` VALUES(13, 18, 'custom_bike.gif', 1279471404, 1);
INSERT INTO `common_Files` VALUES(14, 18, 'captcha1.png', 1280338646, 1);
INSERT INTO `common_Files` VALUES(15, 18, 'captcha2.png', 1280338646, 1);
INSERT INTO `common_Files` VALUES(16, 18, 'captcha3.png', 1280338646, 1);
INSERT INTO `common_Files` VALUES(17, 18, 'captcha4.png', 1280338646, 1);
INSERT INTO `common_Files` VALUES(18, 18, 'captcha5.png', 1280338646, 1);
INSERT INTO `common_Files` VALUES(19, 18, 'captcha5.jpeg', 1284568306, 1);
INSERT INTO `common_Files` VALUES(20, 18, 'nav_about.png', 1284568306, 1);
INSERT INTO `common_Files` VALUES(21, 18, 'nav_bikes.png', 1284568306, 1);
INSERT INTO `common_Files` VALUES(22, 18, 'nav_contact.png', 1284568306, 1);
INSERT INTO `common_Files` VALUES(30, 18, 'img7.jpg', 1285318695, 1);
INSERT INTO `common_Files` VALUES(24, 18, 'img1.jpg', 1285318684, 1);
INSERT INTO `common_Files` VALUES(25, 18, 'img2.jpg', 1285318685, 1);
INSERT INTO `common_Files` VALUES(26, 18, 'img3.jpg', 1285318685, 1);
INSERT INTO `common_Files` VALUES(27, 18, 'img4.jpg', 1285318685, 1);
INSERT INTO `common_Files` VALUES(28, 18, 'img5.jpg', 1285318685, 1);
INSERT INTO `common_Files` VALUES(29, 18, 'img6.jpg', 1285318685, 1);
INSERT INTO `common_Files` VALUES(31, 18, 'image1_from_interface.png', 1285773136, 1);
INSERT INTO `common_Files` VALUES(32, 18, 'IMG_0017.JPG', 1285775201, 1);
INSERT INTO `common_Files` VALUES(33, 18, 'IMG_0040.JPG', 1285775256, 1);
INSERT INTO `common_Files` VALUES(34, 18, 'IMG_0083.JPG', 1285775442, 1);
INSERT INTO `common_Files` VALUES(35, 18, 'IMG_0034.JPG', 1285775521, 1);
INSERT INTO `common_Files` VALUES(36, 18, 'IMG_0136.JPG', 1285775564, 1);
INSERT INTO `common_Files` VALUES(37, 18, 'IMG_0001.JPG', 1285775771, 1);
INSERT INTO `common_Files` VALUES(38, 18, 'IMG_0003.JPG', 1285775946, 1);
INSERT INTO `common_Files` VALUES(60, 19, 'IMG_0002.JPG', 1287600353, 1);
INSERT INTO `common_Files` VALUES(40, 18, 'IMG_0019.JPG', 1285776230, 1);
INSERT INTO `common_Files` VALUES(41, 18, 'IMG_0039.JPG', 1285776327, 1);
INSERT INTO `common_Files` VALUES(42, 18, 'IMG_0069.JPG', 1285776990, 1);
INSERT INTO `common_Files` VALUES(43, 18, 'IMG_0005.JPG', 1285777112, 1);
INSERT INTO `common_Files` VALUES(44, 18, 'IMG_0421.JPG', 1285777112, 1);
INSERT INTO `common_Files` VALUES(45, 18, 'IMG_0420.JPG', 1285777112, 1);
INSERT INTO `common_Files` VALUES(46, 18, 'IMG_0418.JPG', 1285777265, 1);
INSERT INTO `common_Files` VALUES(47, 18, 'IMG_0417.JPG', 1285777265, 1);
INSERT INTO `common_Files` VALUES(48, 18, 'IMG_0416.JPG', 1285777265, 1);
INSERT INTO `common_Files` VALUES(49, 18, 'IMG_0415.JPG', 1285777317, 1);
INSERT INTO `common_Files` VALUES(50, 0, NULL, 1287083899, 1);
INSERT INTO `common_Files` VALUES(51, 18, 'calendar_2.png', 1287083977, 1);
INSERT INTO `common_Files` VALUES(52, 18, 'calendar_3.png', 1287084649, 1);
INSERT INTO `common_Files` VALUES(53, 18, 'nerds_1.png', 1287084833, 1);
INSERT INTO `common_Files` VALUES(54, 18, 'nerds_2.png', 1287085039, 1);
INSERT INTO `common_Files` VALUES(55, 18, 'nerds_3_bw.png', 1287085109, 1);
INSERT INTO `common_Files` VALUES(56, 19, 'devin_thumb.jpg', 1287527960, 1);
INSERT INTO `common_Files` VALUES(57, 19, 'devin_full_img.jpg', 1287527960, 1);
INSERT INTO `common_Files` VALUES(59, 19, 'baby_luna.jpg', 1287599727, 1);
INSERT INTO `common_Files` VALUES(61, 19, 'IMG_0006.JPG', 1287563180, 1);
INSERT INTO `common_Files` VALUES(62, 19, 'IMG_0008.JPG', 1287563305, 1);
INSERT INTO `common_Files` VALUES(63, 19, 'IMG_0242.JPG', 1287563992, 1);
INSERT INTO `common_Files` VALUES(64, 19, 'IMG_0075.JPG', 1287572235, 1);
INSERT INTO `common_Files` VALUES(65, 19, 'IMG_0237.JPG', 1287572680, 1);
INSERT INTO `common_Files` VALUES(66, 19, 'IMG_0642.JPG', 1287572810, 1);
INSERT INTO `common_Files` VALUES(67, 19, 'IMG_0226.JPG', 1287572860, 1);
INSERT INTO `common_Files` VALUES(68, 19, 'IMG_0231.JPG', 1287572922, 1);
INSERT INTO `common_Files` VALUES(69, 19, 'IMG_0192.JPG', 1287590967, 1);
INSERT INTO `common_Files` VALUES(70, 19, 'IMG_0198.JPG', 1287590981, 1);
INSERT INTO `common_Files` VALUES(71, 19, 'IMG_0010.JPG', 1287591868, 1);
INSERT INTO `common_Files` VALUES(72, 19, 'IMG_0129.JPG', 1287592280, 1);
INSERT INTO `common_Files` VALUES(73, 19, 'IMG_0169.JPG', 1287592400, 1);
INSERT INTO `common_Files` VALUES(74, 19, 'IMG_0220.JPG', 1287592444, 1);
INSERT INTO `common_Files` VALUES(75, 19, 'IMG_0009.JPG', 1287592486, 1);
INSERT INTO `common_Files` VALUES(76, 19, 'IMG_0183.JPG', 1287592496, 1);
INSERT INTO `common_Files` VALUES(77, 19, 'IMG_0133.JPG', 1287592834, 1);
INSERT INTO `common_Files` VALUES(78, 19, 'IMG_0114.JPG', 1287592868, 1);
INSERT INTO `common_Files` VALUES(79, 19, 'IMG_0387.JPG', 1287592991, 1);
INSERT INTO `common_Files` VALUES(80, 19, 'IMG_0224.JPG', 1287593092, 1);
INSERT INTO `common_Files` VALUES(81, 19, 'IMG_0011.JPG', 1287907610, 1);
INSERT INTO `common_Files` VALUES(82, 19, 'IMG_0093.JPG', 1287907644, 1);
INSERT INTO `common_Files` VALUES(83, 19, 'IMG_0140.JPG', 1287917663, 1);
INSERT INTO `common_Files` VALUES(84, 19, 'IMG_0096.JPG', 1287917681, 1);
INSERT INTO `common_Files` VALUES(85, 19, 'nav_bar_gradient_shadow.png', 1288172128, 1);
INSERT INTO `common_Files` VALUES(86, 19, 'ui-bg_flat_50_5c5c5c_40x100.png', 1288172150, 1);
INSERT INTO `common_Files` VALUES(87, 19, 'baby_luna.gif', 1289039941, 1);
INSERT INTO `common_Files` VALUES(88, 19, 'resize_luna.jpg', 1289039976, 1);
INSERT INTO `common_Files` VALUES(89, 19, '35204_1352824942894_1299521212_30803330_1092565_n.jpg', 1289040007, 1);
INSERT INTO `common_Files` VALUES(90, 19, 'ajones.jpg', 1289063710, 1);
INSERT INTO `common_Files` VALUES(91, 19, 'jasmith.jpg', 1289063857, 1);
INSERT INTO `common_Files` VALUES(92, 19, 'jriley.jpg', 1289063872, 1);

-- --------------------------------------------------------

--
-- Table structure for table `common_FileTypes`
--

DROP TABLE IF EXISTS `common_FileTypes`;
CREATE TABLE `common_FileTypes` (
  `file_type_id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `directory` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`file_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `common_FileTypes`
--

INSERT INTO `common_FileTypes` VALUES(0, NULL, 0, 'images');
INSERT INTO `common_FileTypes` VALUES(19, 'Contact Image', 1, 'images/contact_images');
INSERT INTO `common_FileTypes` VALUES(18, 'image', 1, 'images');

-- --------------------------------------------------------

--
-- Table structure for table `common_Permissions`
--

DROP TABLE IF EXISTS `common_Permissions`;
CREATE TABLE `common_Permissions` (
  `permission_id` int(100) NOT NULL AUTO_INCREMENT,
  `alias` varchar(1000) DEFAULT NULL,
  `title` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `common_Permissions`
--

INSERT INTO `common_Permissions` VALUES(0, NULL, NULL);
INSERT INTO `common_Permissions` VALUES(2, 'ADM', 'Administrator');
INSERT INTO `common_Permissions` VALUES(3, 'MOV', 'Can Add Movie');

-- --------------------------------------------------------

--
-- Table structure for table `common_Sections`
--

DROP TABLE IF EXISTS `common_Sections`;
CREATE TABLE `common_Sections` (
  `section_id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`section_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `common_Sections`
--

INSERT INTO `common_Sections` VALUES(0, NULL, 0);
INSERT INTO `common_Sections` VALUES(2, 'Main', 1);
INSERT INTO `common_Sections` VALUES(3, 'Happenings', 1);
INSERT INTO `common_Sections` VALUES(4, 'news-article', 1);
INSERT INTO `common_Sections` VALUES(5, 'video-4', 1);
INSERT INTO `common_Sections` VALUES(6, 'video-5', 1);
INSERT INTO `common_Sections` VALUES(7, 'video-6', 1);
INSERT INTO `common_Sections` VALUES(8, 'video-7', 1);
INSERT INTO `common_Sections` VALUES(9, 'video-8', 1);
INSERT INTO `common_Sections` VALUES(10, 'video-9', 1);
INSERT INTO `common_Sections` VALUES(11, 'feature-1', 1);
INSERT INTO `common_Sections` VALUES(12, 'feature-2', 1);
INSERT INTO `common_Sections` VALUES(13, 'feature-3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `common_Sessions`
--

DROP TABLE IF EXISTS `common_Sessions`;
CREATE TABLE `common_Sessions` (
  `session_id` varchar(32) NOT NULL,
  `authentication_id` int(100) NOT NULL,
  `start_timestamp` int(100) DEFAULT NULL,
  `end_timestamp` int(100) DEFAULT NULL,
  PRIMARY KEY (`session_id`),
  KEY `authentication_id` (`authentication_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `common_Sessions`
--

INSERT INTO `common_Sessions` VALUES('187cd78a3fe883053abb48b0dba8a3a1', 3, 1288078388, 1288079081);
INSERT INTO `common_Sessions` VALUES('8d6f7844e1d97ddc06cb6ac6376556cb', 6, 1288079143, 1288079172);
INSERT INTO `common_Sessions` VALUES('5882768eea83d92f15300e7cd044ca6c', 3, 1288166526, NULL);
INSERT INTO `common_Sessions` VALUES('32a515e7e160c591147e5443688c7305', 3, 1288171802, NULL);
INSERT INTO `common_Sessions` VALUES('a9ebc2155d4e76498acea39ab9260cda', 3, 1288172055, NULL);
INSERT INTO `common_Sessions` VALUES('dce87b3c0b2e82c8b0c7f275f570856a', 3, 1288212192, 1288212378);
INSERT INTO `common_Sessions` VALUES('5af58fafd2d5fad80f7a13a398676ac2', 3, 1288243163, NULL);
INSERT INTO `common_Sessions` VALUES('77f6e6e6eee578ce4af12bcffcdddd2e', 3, 1288461791, NULL);
INSERT INTO `common_Sessions` VALUES('b4d75a55ad5a0c9125b2bccb3d7841c8', 3, 1288631612, NULL);
INSERT INTO `common_Sessions` VALUES('c6557fb5f1f1fbbdc0cbbfc30ab7e622', 3, 1288685873, 1288685986);
INSERT INTO `common_Sessions` VALUES('ae8be71c66e6e98b23027f58eb3f605b', 3, 1289033307, NULL);
INSERT INTO `common_Sessions` VALUES('65d80cfac8ffcf97cf70c220aab08a49', 3, 1289036115, NULL);
INSERT INTO `common_Sessions` VALUES('8bea07fe31e207752c69abb58608d54f', 3, 1289077856, 1289077860);
INSERT INTO `common_Sessions` VALUES('b7f64f2da9f6af23448935508eb2ab1c', 3, 1289077988, 1289078012);
INSERT INTO `common_Sessions` VALUES('98be6105029986995a7acb13b48a102f', 3, 1289078024, 1289078627);
INSERT INTO `common_Sessions` VALUES('b03cfb89beeaa77385f8a8b75ac63193', 3, 1289078646, NULL);
INSERT INTO `common_Sessions` VALUES('1a5de211a832b45fad888780bd5e5eb5', 3, 1289188264, 1289200704);
INSERT INTO `common_Sessions` VALUES('69ffca9aea5937272386e5e07f672ed9', 2, 1289200723, NULL);
INSERT INTO `common_Sessions` VALUES('57c9c56e31f613b53a16d2ed90d67d89', 3, 1289363864, NULL);
INSERT INTO `common_Sessions` VALUES('b3c7448f17226fbbd62409eaef5f11a8', 3, 1289410401, NULL);
INSERT INTO `common_Sessions` VALUES('2891e703b8300acde561315bd7d2216f', 3, 1289447505, NULL);
INSERT INTO `common_Sessions` VALUES('7d9f94a5bdd45882173a8b8df1cac1ba', 3, 1289498546, NULL);
INSERT INTO `common_Sessions` VALUES('5b50eaca296bc89ea6cd9f98323d4b13', 3, 1289533667, NULL);
INSERT INTO `common_Sessions` VALUES('4f50fac8bb8e144f6775655bab29217e', 3, 1289593408, NULL);
INSERT INTO `common_Sessions` VALUES('885deb80a9813f19cc71cdfbd2692b16', 3, 1289679933, NULL);
INSERT INTO `common_Sessions` VALUES('fe912e1e03f340534a97af416fcc4676', 3, 1289781460, NULL);
INSERT INTO `common_Sessions` VALUES('e4c14dea99c95e1c9c24fcbae95cd552', 3, 1289970526, NULL);
INSERT INTO `common_Sessions` VALUES('999237dc39317a041f29a26234394940', 3, 1289974750, NULL);
INSERT INTO `common_Sessions` VALUES('fd9b0104653ed367dd3f280eaac963d8', 3, 1290017835, NULL);
INSERT INTO `common_Sessions` VALUES('e3be5657a7a47e9d5fb67e6c27c9f562', 3, 1290051026, NULL);
INSERT INTO `common_Sessions` VALUES('e4d73f07e79bed45171b99c9d61acf1a', 3, 1290249832, NULL);
INSERT INTO `common_Sessions` VALUES('0bcd36c20c829806e9901579c6572a6d', 3, 1290300179, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `common_States`
--

DROP TABLE IF EXISTS `common_States`;
CREATE TABLE `common_States` (
  `state_id` int(100) NOT NULL AUTO_INCREMENT,
  `abbrv` varchar(2) DEFAULT NULL,
  `full_name` varchar(1000) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`state_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `common_States`
--

INSERT INTO `common_States` VALUES(0, NULL, NULL, 0);
INSERT INTO `common_States` VALUES(2, 'AL', 'Alabama', 1);
INSERT INTO `common_States` VALUES(3, 'AK', 'Alaska', 1);
INSERT INTO `common_States` VALUES(4, 'AZ', 'Arizona', 1);
INSERT INTO `common_States` VALUES(5, 'AR', 'Arkansas', 1);
INSERT INTO `common_States` VALUES(6, 'CA', 'California', 1);
INSERT INTO `common_States` VALUES(7, 'CO', 'Colorado', 1);
INSERT INTO `common_States` VALUES(8, 'CT', 'Connecticut', 1);
INSERT INTO `common_States` VALUES(9, 'DE', 'Delaware', 1);
INSERT INTO `common_States` VALUES(10, 'FL', 'Florida', 1);
INSERT INTO `common_States` VALUES(11, 'GA', 'Georgia', 1);
INSERT INTO `common_States` VALUES(12, 'HI', 'Hawaii', 1);
INSERT INTO `common_States` VALUES(13, 'ID', 'Idaho', 1);
INSERT INTO `common_States` VALUES(14, 'IL', 'Illinois', 1);
INSERT INTO `common_States` VALUES(15, 'IN', 'Indiana', 1);
INSERT INTO `common_States` VALUES(16, 'IA', 'Iowa', 1);
INSERT INTO `common_States` VALUES(17, 'KS', 'Kansas', 1);
INSERT INTO `common_States` VALUES(18, 'KY', 'Kentucky', 1);
INSERT INTO `common_States` VALUES(19, 'LA', 'Louisiana', 1);
INSERT INTO `common_States` VALUES(20, 'ME', 'Maine', 1);
INSERT INTO `common_States` VALUES(21, 'MD', 'Maryland', 1);
INSERT INTO `common_States` VALUES(22, 'MA', 'Massachusetts', 1);
INSERT INTO `common_States` VALUES(23, 'MI', 'Michigan', 1);
INSERT INTO `common_States` VALUES(24, 'MN', 'Minnesota', 1);
INSERT INTO `common_States` VALUES(25, 'MS', 'Mississippi', 1);
INSERT INTO `common_States` VALUES(26, 'MO', 'Missouri', 1);
INSERT INTO `common_States` VALUES(27, 'MT', 'Montana', 1);
INSERT INTO `common_States` VALUES(28, 'NE', 'Nebraska', 1);
INSERT INTO `common_States` VALUES(29, 'NV', 'Nevada', 1);
INSERT INTO `common_States` VALUES(30, 'NH', 'New Hampshire', 1);
INSERT INTO `common_States` VALUES(31, 'NJ', 'New Jersey', 1);
INSERT INTO `common_States` VALUES(32, 'NM', 'New Mexico', 1);
INSERT INTO `common_States` VALUES(33, 'NY', 'New York', 1);
INSERT INTO `common_States` VALUES(34, 'NC', 'North Carolina', 1);
INSERT INTO `common_States` VALUES(35, 'ND', 'North Dakota', 1);
INSERT INTO `common_States` VALUES(36, 'OH', 'Ohio', 1);
INSERT INTO `common_States` VALUES(37, 'OK', 'Oklahoma', 1);
INSERT INTO `common_States` VALUES(38, 'OR', 'Oregon', 1);
INSERT INTO `common_States` VALUES(39, 'PA', 'Pennsylvania', 1);
INSERT INTO `common_States` VALUES(40, 'RI', 'Rhode Island', 1);
INSERT INTO `common_States` VALUES(41, 'SC', 'South Carolina', 1);
INSERT INTO `common_States` VALUES(42, 'SD', 'South Dakota', 1);
INSERT INTO `common_States` VALUES(43, 'TN', 'Tennessee', 1);
INSERT INTO `common_States` VALUES(44, 'TX', 'Texas', 1);
INSERT INTO `common_States` VALUES(45, 'UT', 'Utah', 1);
INSERT INTO `common_States` VALUES(46, 'VT', 'Vermont', 1);
INSERT INTO `common_States` VALUES(47, 'VA', 'Virginia', 1);
INSERT INTO `common_States` VALUES(48, 'WA', 'Washington', 1);
INSERT INTO `common_States` VALUES(49, 'WV', 'West Virginia', 1);
INSERT INTO `common_States` VALUES(50, 'WI', 'Wisconsin', 1);
INSERT INTO `common_States` VALUES(51, 'WY', 'Wyoming', 1);

-- --------------------------------------------------------

--
-- Table structure for table `common_Views`
--

DROP TABLE IF EXISTS `common_Views`;
CREATE TABLE `common_Views` (
  `view_id` int(100) NOT NULL AUTO_INCREMENT,
  `controller_name` varchar(1000) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `requires_auth` tinyint(1) DEFAULT '0',
  `show_in_nav` tinyint(1) DEFAULT '1',
  `alias` varchar(1000) DEFAULT NULL,
  `nav_priority` int(11) DEFAULT NULL,
  `nav_image_id` int(11) DEFAULT NULL,
  `parent_view_id` int(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`view_id`),
  KEY `nav_image_id` (`nav_image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `common_Views`
--

INSERT INTO `common_Views` VALUES(0, NULL, 0, 0, 1, NULL, NULL, NULL, 0);
INSERT INTO `common_Views` VALUES(6, 'Index', 1, 0, 1, 'Home', 1, 0, 0);
INSERT INTO `common_Views` VALUES(7, 'Productions', 1, 0, 1, 'Productions', 2, 0, 0);
INSERT INTO `common_Views` VALUES(8, 'News', 1, 0, 1, 'News', 3, 0, 0);
INSERT INTO `common_Views` VALUES(9, 'Jobs', 1, 0, 1, 'Jobs', 4, 0, 0);
INSERT INTO `common_Views` VALUES(10, 'Contacts', 1, 0, 1, 'Contact', 5, 0, 0);
INSERT INTO `common_Views` VALUES(11, 'Admin', 1, 1, 0, 'Administration', 0, 0, 0);
INSERT INTO `common_Views` VALUES(13, NULL, 1, 0, 1, 'Shorts', 1, 0, 7);
INSERT INTO `common_Views` VALUES(14, NULL, 1, 0, 1, 'Commercials', 2, 0, 7);
INSERT INTO `common_Views` VALUES(15, NULL, 1, 0, 1, 'Gags', 3, 0, 7);
INSERT INTO `common_Views` VALUES(16, NULL, 0, 0, 1, 'Production Pics', 4, 0, 7);
INSERT INTO `common_Views` VALUES(17, NULL, 1, 0, 1, 'Submissions', 1, 0, 9);
INSERT INTO `common_Views` VALUES(18, NULL, 1, 0, 1, 'Casting Calls', 2, 0, 9);
INSERT INTO `common_Views` VALUES(20, NULL, 1, 0, 1, 'Movie Reviews', 5, 0, 7);
