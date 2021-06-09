-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Aug 19, 2020 at 05:37 AM
-- Server version: 10.2.14-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `familytree`
--
DROP DATABASE IF EXISTS `familytree`;
CREATE DATABASE IF NOT EXISTS `familytree` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `familytree`;

-- --------------------------------------------------------

--
-- Table structure for table `member_detail`
--

DROP TABLE IF EXISTS `member_detail`;
CREATE TABLE IF NOT EXISTS `member_detail` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `first_name` varchar(64) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(64) CHARACTER SET utf8 NOT NULL,
  `spouse_name` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `member_img` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `member_detail`
--

TRUNCATE TABLE `member_detail`;
--
-- Dumping data for table `member_detail`
--

INSERT INTO `member_detail` (`member_id`, `parent_id`, `first_name`, `last_name`, `spouse_name`, `member_img`) VALUES
(1, NULL, 'Mathai', 'K.P', 'Elamma', '159'),
(2, 1, 'Thambi', 'K.M', 'Santha', ''),
(3, 1, 'Leelamma', 'K.M', 'Raju', '1597'),
(4, 2, 'Shuba', 'Thambi', 'Peter', ''),
(5, 2, 'Cleena', 'Thambi', 'Manoj', ''),
(6, 2, 'Liju', 'Thambi', 'Deepa', ''),
(7, 3, 'Suja', 'C Raju', 'Kishore', ''),
(8, 3, 'Suma', 'C Raju', 'Shabu', '1596'),
(9, 4, 'Thomas', 'Peter', '', 'dd'),
(10, 6, 'Nayan', 'Liju', '', ''),
(11, 6, 'Kevin', 'Liju', '', ''),
(12, 5, 'Kripa', 'Manoj', '', ''),
(14, 4, 'Ghees', 'Peter', '', ''),
(15, 7, 'Aaron', '', '', '456'),
(16, 8, 'Ann', 'Shabu', '', '519'),
(20, 8, 'Ashwin', 'Shabu', '', ''),
(24, 1, 'Joy', 'K.M', 'Ammini', ''),
(25, 24, 'Jiyamol', 'K Joy', 'Biju', ''),
(26, 24, 'Gintumol', 'K Joy', '', ''),
(27, 1, 'Baby', 'K.M', 'Susy', ''),
(28, 27, 'Midhun', 'B Mathew', 'Susan', ''),
(29, 27, 'Paul', 'Baby Kanneth', '', ''),
(30, 28, 'Ryan', 'Midhun', '', ''),
(31, 28, 'Aiden', 'Midhun', '', ''),
(32, 25, 'Thomaskutty', 'Biju', '', ''),
(33, 25, 'Kunjus', 'Biju', '', ''),
(34, 28, 'Test', 'Midhun', '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
