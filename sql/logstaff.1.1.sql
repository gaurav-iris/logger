-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2014 at 07:56 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `logstaff`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE IF NOT EXISTS `activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timesheet_id` int(11) NOT NULL,
  `screenshot` int(11) NOT NULL,
  `keystrokes` int(11) NOT NULL,
  `mouseclicks` int(11) NOT NULL,
  `notes` text NOT NULL,
  `type` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `controller` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `menu_type` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE IF NOT EXISTS `organizations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `timezone_id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Organizations belongs to users' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `user_id`, `title`, `slug`, `description`, `timezone_id`, `logo`, `created`, `updated`) VALUES
(1, 1, 'Hansoftz', 'hansoftz', 'This is my new company started in the year 2014, Aug', 1, '', 1407994591, 1407994713),
(2, 2, 'Sansoftz', 'sansoftz', 'My wife''s company', 2, '', 1407995147, 1407995720);

-- --------------------------------------------------------

--
-- Table structure for table `organizations_projects`
--

CREATE TABLE IF NOT EXISTS `organizations_projects` (
  `organization_id` bigint(20) NOT NULL,
  `project_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Organizations 2 Projects Relation';

--
-- Dumping data for table `organizations_projects`
--

INSERT INTO `organizations_projects` (`organization_id`, `project_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `organizations_users`
--

CREATE TABLE IF NOT EXISTS `organizations_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `organization_id` bigint(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Organizations 2 Users Relation' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `organizations_users`
--

INSERT INTO `organizations_users` (`id`, `organization_id`, `user_id`, `role_id`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 2),
(3, 2, 1, 2),
(5, 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(155) NOT NULL,
  `description` longtext NOT NULL,
  `last_activity` datetime NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Project Entity' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `slug`, `description`, `last_activity`, `created`, `updated`, `status`) VALUES
(1, 'wwwalls.com', 'wwwalls', 'our wallpapers website', '2014-08-14 07:56:00', '2014-08-14 07:56:59', '2014-08-14 07:56:59', 1),
(2, 'Staff Logger', 'staff-logger', 'this is current application project proposed', '2014-08-14 07:57:00', '2014-08-14 07:57:58', '2014-08-14 07:57:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `created`, `updated`, `status`) VALUES
(1, 'Administrator', '2014-08-14 07:43:27', '2014-08-14 07:43:27', 1),
(2, 'Moderator', '2014-08-14 07:53:21', '2014-08-14 07:53:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `startdate` datetime NOT NULL,
  `enddate` datetime NOT NULL,
  `status` tinytext NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `project_id`, `user_id`, `title`, `startdate`, `enddate`, `status`, `created`, `updated`) VALUES
(1, 2, 1, 'Define the database schema', '2014-08-14 07:58:00', '2014-08-17 07:58:00', '1', '2014-08-14 07:58:52', '2014-08-14 08:00:33');

-- --------------------------------------------------------

--
-- Table structure for table `timesheets`
--

CREATE TABLE IF NOT EXISTS `timesheets` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(255) NOT NULL,
  `project_id` bigint(11) NOT NULL,
  `timezone_id` int(11) NOT NULL,
  `session_id` varchar(60) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `duration` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE IF NOT EXISTS `timezones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `value` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='All Timezones' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `title`, `value`, `status`) VALUES
(1, 'Asia Kolkata', 'Asia Kolkata', 1),
(2, 'New York/America', 'New York/America', 1),
(3, 'Australia/Sydney', 'Australia/Sydney', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `created`, `updated`, `status`) VALUES
(1, 'gauravmehra', 'Gaurav', 'Mehra', 'gauravmehra1987@gmail.com', '0', '2014-08-14 07:35:35', '2014-08-14 07:35:35', 1),
(2, 'sandeepkaur', 'Sandeep', 'Kaur', 'sandeepkaurmultani@gmail.com', '0', '2014-08-14 07:39:16', '2014-08-14 07:54:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE IF NOT EXISTS `user_settings` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='User Preffernces and Settings' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
