-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 19, 2022 at 12:37 AM
-- Server version: 10.3.34-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tammekandaxelikt_haaletus`
--

-- --------------------------------------------------------

--
-- Table structure for table `HAALETUS`
--

CREATE TABLE `HAALETUS` (
  `nimi` varchar(50) NOT NULL,
  `aeg` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `otsus` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `HAALETUS`
--

INSERT INTO `HAALETUS` (`nimi`, `aeg`, `otsus`) VALUES
('juhan', '2022-03-13 20:43:27', 'poolt'),
('ivan', '2022-03-13 20:46:55', 'vastu'),
('axel', '2022-03-16 10:15:05', 'poolt'),
('peeter', '2022-03-13 20:44:40', 'poolt'),
('juss', '2022-03-15 20:07:21', 'poolt'),
('taavi', '2022-03-13 20:24:07', 'haaletamata'),
('jyri', '2022-03-13 20:24:07', 'haaletamata'),
('kalle', '2022-03-13 20:24:07', 'haaletamata'),
('kaja', '2022-03-13 20:24:07', 'haaletamata'),
('mari', '2022-03-13 20:24:07', 'haaletamata'),
('karl', '2022-03-13 20:44:32', 'poolt');

--
-- Triggers `HAALETUS`
--
DELIMITER $$
CREATE TRIGGER `count_votes` AFTER UPDATE ON `HAALETUS` FOR EACH ROW UPDATE TULEMUSED SET arv = (SELECT COUNT(nimi) FROM HAALETUS WHERE otsus = 'poolt' OR otsus = 'vastu'), h_alguse_aeg = CURRENT_TIMESTAMP(), poolt = (SELECT COUNT(nimi) FROM HAALETUS WHERE otsus = 'poolt'), vastu = (SELECT COUNT(nimi) FROM HAALETUS WHERE otsus = 'vastu')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `TULEMUSED`
--

CREATE TABLE `TULEMUSED` (
  `arv` int(10) NOT NULL,
  `h_alguse_aeg` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `poolt` int(10) NOT NULL,
  `vastu` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TULEMUSED`
--

INSERT INTO `TULEMUSED` (`arv`, `h_alguse_aeg`, `poolt`, `vastu`) VALUES
(6, '2022-03-16 10:15:05', 5, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
