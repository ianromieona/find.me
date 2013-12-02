-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 01, 2013 at 04:32 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `findme`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_rel`
--

CREATE TABLE IF NOT EXISTS `category_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catId` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category_rel_category_table1_idx` (`catId`),
  KEY `fk_category_rel_post_table1_idx` (`postId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `category_table`
--

CREATE TABLE IF NOT EXISTS `category_table` (
  `catId` int(11) NOT NULL AUTO_INCREMENT,
  `catName` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`catId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `category_table`
--

INSERT INTO `category_table` (`catId`, `catName`) VALUES
(1, 'Places'),
(2, 'Entertainment'),
(3, 'Apparel'),
(4, 'Foods'),
(5, 'Gadgets'),
(6, 'Collections');

-- --------------------------------------------------------

--
-- Table structure for table `logs_table`
--

CREATE TABLE IF NOT EXISTS `logs_table` (
  `logId` int(11) NOT NULL AUTO_INCREMENT,
  `logDetails` text,
  `dateTime` datetime DEFAULT NULL,
  `postId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`logId`),
  KEY `fk_logs_table_post_table1_idx` (`postId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `points_table`
--

CREATE TABLE IF NOT EXISTS `points_table` (
  `pointsId` int(11) NOT NULL AUTO_INCREMENT,
  `points` double DEFAULT NULL,
  `dateTime` datetime DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `pointsType` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pointsId`),
  KEY `fk_points_table_user_table1_idx` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `post_meta`
--

CREATE TABLE IF NOT EXISTS `post_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(45) DEFAULT NULL,
  `value` varchar(45) DEFAULT NULL,
  `post_table_postId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_meta_post_table1_idx` (`post_table_postId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `post_meta`
--

INSERT INTO `post_meta` (`id`, `key`, `value`, `post_table_postId`) VALUES
(1, 'bounty', '10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_relationship`
--

CREATE TABLE IF NOT EXISTS `post_relationship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postId` int(11) NOT NULL,
  `parentId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_relationship_post_table1_idx` (`postId`),
  KEY `fk_post_relationship_post_table2_idx` (`parentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `post_relationship`
--

INSERT INTO `post_relationship` (`id`, `postId`, `parentId`) VALUES
(1, 2, 1),
(2, 4, 1),
(3, 9, 1),
(4, 10, 1),
(5, 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_table`
--

CREATE TABLE IF NOT EXISTS `post_table` (
  `postId` int(11) NOT NULL AUTO_INCREMENT,
  `postType` varchar(200) DEFAULT NULL,
  `postTitle` text,
  `postContent` text,
  `postDate` datetime DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `walletType` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`postId`),
  KEY `fk_post_table_user_table1_idx` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `post_table`
--

INSERT INTO `post_table` (`postId`, `postType`, `postTitle`, `postContent`, `postDate`, `userId`, `walletType`, `status`) VALUES
(1, 'post', 'find me a beer that cost 10 tag', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2013-11-30 08:50:56', 1, 0, 1),
(2, 'answer', 'find me a beer that cost 10 tag', 'Lorem ', '2013-11-30 08:50:56', 2, 0, 1),
(4, 'answer', 'find me a beer that cost 10 tag', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.', '2013-11-30 08:50:56', 1, 0, 0),
(9, 'answer', '', 'qweqweqwe', '2013-12-01 03:31:41', 1, 0, 0),
(10, 'answer', '', 'qweqweqwe', '2013-12-01 03:31:44', 1, 0, 0),
(11, 'answer', '', 'werwqre', '2013-12-01 03:31:49', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tag_rel`
--

CREATE TABLE IF NOT EXISTS `tag_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tagId` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tag_rel_tag_table1_idx` (`tagId`),
  KEY `fk_tag_rel_post_table1_idx` (`postId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag_table`
--

CREATE TABLE IF NOT EXISTS `tag_table` (
  `tagId` int(11) NOT NULL AUTO_INCREMENT,
  `tagName` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tagId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_table`
--

CREATE TABLE IF NOT EXISTS `transaction_table` (
  `transactionId` int(11) NOT NULL AUTO_INCREMENT,
  `points` double DEFAULT NULL,
  `transactionDate` datetime DEFAULT NULL,
  `transactionFrom` int(11) NOT NULL,
  `transactionTo` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  PRIMARY KEY (`transactionId`),
  KEY `fk_transaction_table_user_table1_idx` (`transactionFrom`),
  KEY `fk_transaction_table_user_table2_idx` (`transactionTo`),
  KEY `fk_transaction_table_post_table1_idx` (`postId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_meta`
--

CREATE TABLE IF NOT EXISTS `user_meta` (
  `umetaId` int(11) NOT NULL AUTO_INCREMENT,
  `umetaValue` text,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`umetaId`),
  KEY `fk_user_meta_user_table_idx` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE IF NOT EXISTS `user_table` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `tagbond_id` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `userVerification` varchar(25) NOT NULL,
  `userRegDate` datetime NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`userId`, `tagbond_id`, `userName`, `userEmail`, `userVerification`, `userRegDate`) VALUES
(1, 10, 'Ian Romie', 'Ona Dev', '', '2013-12-01 00:17:24'),
(2, 647, 'Edbert Guinto', 'edbert@zeresoft.com', '', '2013-12-01 00:17:24');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_rel`
--
ALTER TABLE `category_rel`
  ADD CONSTRAINT `fk_category_rel_category_table1` FOREIGN KEY (`catId`) REFERENCES `category_table` (`catId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_category_rel_post_table1` FOREIGN KEY (`postId`) REFERENCES `post_table` (`postId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `logs_table`
--
ALTER TABLE `logs_table`
  ADD CONSTRAINT `fk_logs_table_post_table1` FOREIGN KEY (`postId`) REFERENCES `post_table` (`postId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `points_table`
--
ALTER TABLE `points_table`
  ADD CONSTRAINT `fk_points_table_user_table1` FOREIGN KEY (`userId`) REFERENCES `user_table` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `post_meta`
--
ALTER TABLE `post_meta`
  ADD CONSTRAINT `fk_post_meta_post_table1` FOREIGN KEY (`post_table_postId`) REFERENCES `post_table` (`postId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `post_relationship`
--
ALTER TABLE `post_relationship`
  ADD CONSTRAINT `fk_post_relationship_post_table1` FOREIGN KEY (`postId`) REFERENCES `post_table` (`postId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_post_relationship_post_table2` FOREIGN KEY (`parentId`) REFERENCES `post_table` (`postId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `post_table`
--
ALTER TABLE `post_table`
  ADD CONSTRAINT `fk_post_table_user_table1` FOREIGN KEY (`userId`) REFERENCES `user_table` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tag_rel`
--
ALTER TABLE `tag_rel`
  ADD CONSTRAINT `fk_tag_rel_tag_table1` FOREIGN KEY (`tagId`) REFERENCES `tag_table` (`tagId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tag_rel_post_table1` FOREIGN KEY (`postId`) REFERENCES `post_table` (`postId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transaction_table`
--
ALTER TABLE `transaction_table`
  ADD CONSTRAINT `fk_transaction_table_user_table1` FOREIGN KEY (`transactionFrom`) REFERENCES `user_table` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_transaction_table_user_table2` FOREIGN KEY (`transactionTo`) REFERENCES `user_table` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_transaction_table_post_table1` FOREIGN KEY (`postId`) REFERENCES `post_table` (`postId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_meta`
--
ALTER TABLE `user_meta`
  ADD CONSTRAINT `fk_user_meta_user_table` FOREIGN KEY (`userId`) REFERENCES `user_table` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
