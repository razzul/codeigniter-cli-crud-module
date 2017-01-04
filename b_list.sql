-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2016 at 08:20 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `b_list`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_business`
--

CREATE TABLE IF NOT EXISTS `tbl_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category` text NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `logo` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_business`
--

INSERT INTO `tbl_business` (`id`, `user_id`, `category`, `company_name`, `description`, `logo`, `status`, `created`, `modified`, `deleted`) VALUES
(1, 1, '[{"category":"cat 1","sub_category":"sub cat 2"},{"category":"cat 1","sub_category":"sub cat 2"},{"category":"cat 1","sub_category":"sub cat 1"}]', 'aaaa', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ut justo purus. Morbi maximus sollicitudin dui, vel suscipit elit aliquam sit amet. Donec velit metus, consequat pharetra felis vitae, luctus mattis est.', '', 0, '2015-07-25 14:05:30', '0000-00-00 00:00:00', 0),
(2, 1, '[{"category":"cat 1","sub_category":"sub cat 1"},{"category":"cat 1","sub_category":"sub cat 2"},{"category":"cat 1","sub_category":"sub cat 2"}]', 'aaaa', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ut justo purus. Morbi maximus sollicitudin dui, vel suscipit elit aliquam sit amet. Donec velit metus, consequat pharetra felis vitae, luctus mattis est.', '', 0, '2015-07-25 14:09:53', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_business_contact`
--

CREATE TABLE IF NOT EXISTS `tbl_business_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `website` varchar(255) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `location` varchar(255) NOT NULL,
  `sub_location` varchar(255) NOT NULL,
  `street` text NOT NULL,
  `has_map` tinyint(4) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_business_contact`
--

INSERT INTO `tbl_business_contact` (`id`, `business_id`, `website`, `phone`, `location`, `sub_location`, `street`, `has_map`, `latitude`, `longitude`, `email`, `contact_person`) VALUES
(1, 1, 'sdfsdfs', 9007934803, 'sdfsd', 'sdf', 'asd', 0, 0, 0, 'rajulmondal5@gmail.com', 'asd'),
(2, 2, 'asdasd', 9007934803, 'asdasd', 'asd', 'asd', 0, 0, 0, 'rajulmondal5@gmail.com', 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_business_review`
--

CREATE TABLE IF NOT EXISTS `tbl_business_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(5) NOT NULL,
  `title` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_business_review`
--

INSERT INTO `tbl_business_review` (`id`, `business_id`, `user_id`, `rating`, `title`, `comment`, `name`, `email`, `phone`, `status`, `created`, `modified`, `deleted`) VALUES
(1, 1, 1, 5, 'ra', 'fg', 'sourav', 'rajulmondal5@gmail.com', 9007934803, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 2, 1, 5, 'ra', 'asdasd', 'sourav', 'rajulmondal5@gmail.com', 9007934803, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 2, 1, 1, 'ra', 'asda', 'sourav', 'rajulmondal5@gmail.com', 9007934803, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, 1, 1, 1, 'ra', 'asdasd', 'sourav', 'rajulmondal5@gmail.com', 9007934803, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, 2, 1, 5, 'ra', 'dfsdfsd', 'sourav', 'rajulmondal5@gmail.com', 9007934803, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_packages`
--

CREATE TABLE IF NOT EXISTS `tbl_packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('Free','Stanard','Featured') NOT NULL,
  `price` float NOT NULL,
  `template` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_packages`
--

INSERT INTO `tbl_packages` (`id`, `type`, `price`, `template`) VALUES
(1, 'Free', 0, '<ul>\n            <li><b>It''s FREE!</b></li>\n            <li>Regular Listing</li>\n            <li>Add your listing in up to 1 category</li>\n            <li>NoFollow Link</li>\n            <!-- <li>Listings usually reviewed (and if approved, added to the website) within 1 week</li> -->\n        </ul>'),
(2, 'Stanard', 14.9, '<ul>\r\n            <li><b>$14.90</b></li>\r\n            <li>Regular Listing</li>\r\n            <li>Add your listing in up to 1 category</li>\r\n            <li>Follow Link</li>\r\n            <!-- <li>Your listing will be reviewed with priority, usually within one business day</li> -->\r\n        </ul>'),
(3, 'Featured', 49, '<ul>\r\n            <li><b>$49.00</b></li>\r\n            <li>Featured Listing</li>\r\n            <li>Add your listing in up to 3 categories</li>\r\n            <li>Follow Link</li>\r\n            <!-- <li>Your listing will be reviewed with the highest priority and will have a featured status</li> -->\r\n        </ul>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `subscribe` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `first_name`, `last_name`, `status`, `created`, `modified`, `subscribe`, `deleted`) VALUES
(1, 'rajulmondal5', '8d075bac4012c86d51b233f679c042f7', 'Rajul', 'Mondal', 1, '2015-07-24 15:31:05', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_contact`
--

CREATE TABLE IF NOT EXISTS `tbl_user_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `facebook_url` varchar(255) NOT NULL,
  `twitter_url` varchar(255) NOT NULL,
  `website_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_user_contact`
--

INSERT INTO `tbl_user_contact` (`id`, `user_id`, `email`, `phone`, `facebook_url`, `twitter_url`, `website_url`) VALUES
(1, 1, 'rajulmondal5@gmail.com', 7685856006, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_package`
--

CREATE TABLE IF NOT EXISTS `tbl_user_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_user_package`
--

INSERT INTO `tbl_user_package` (`id`, `user_id`, `package_id`) VALUES
(1, 1, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
