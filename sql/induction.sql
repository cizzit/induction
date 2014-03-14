-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 31, 2009 at 07:31 AM
-- Server version: 5.0.67
-- PHP Version: 5.2.6-2ubuntu4.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `induction`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(2) NOT NULL auto_increment,
  `variable` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `variable`, `value`) VALUES
(1, 'USERinterval', '6'),
(2, 'resetdate', '25032009'),
(3, 'secmonth', '2628000'),
(4, 'report1', '1238439758'),
(5, 'report2', '1238409833'),
(6, 'report3', ''),
(7, 'report4', '1238410329'),
(8, 'report5', ''),
(9, 'report6', '1238410322'),
(10, 'report7', '1238409843');

-- --------------------------------------------------------

--
-- Table structure for table `sepai`
--

CREATE TABLE IF NOT EXISTS `sepai` (
  `bbb` varchar(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sepai`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL auto_increment,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(150) NOT NULL,
  `misc` varchar(255) default NULL COMMENT 'contractor id for contractors, contact name for visitors',
  `datebirth` varchar(15) NOT NULL,
  `datelast` varchar(15) default NULL,
  `course` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `misc`, `datebirth`, `datelast`, `course`) VALUES
(1, 'Testy', 'McTest', NULL, '01011970', '0', 'contractor');
