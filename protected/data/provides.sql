-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-05-2014 a las 01:28:12
-- Versión del servidor: 5.5.32
-- Versión de PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `rsrtcpns_coco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `providers`
--

CREATE TABLE IF NOT EXISTS `providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `middle_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `prefix` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `suffix` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `full_name` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `education_title` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `nickname` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `company` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `organization` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `department` varchar(50) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `job_title` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `note` tinytext CHARACTER SET utf8,
  `telephone_work1` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `telephone_work2` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `telephone_home1` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `telephone_home2` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `cell_phone` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `car_phone` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `pager` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `additional_telephone` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `fax_work` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `fax_home` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `isdn` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `preferred_telephone` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `telex` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `work_street` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `work_neighborhood` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `work_city` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `work_region` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `work_country` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `work_zip` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `home_street` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `home_zip` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `home_city` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `home_region` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `home_country` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `postal_street` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `postal_zip` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `postal_city` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `postal_region` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `postal_country` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `url_work` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `role` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `email_work` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `email_home` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `rfc` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `outside_number` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `internal_number` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `reference` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `account_number` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `n_degrees` int(11) DEFAULT '0',
  `n_minuts` int(11) DEFAULT '0',
  `n_seconds` decimal(10,4) DEFAULT '0.0000',
  `w_degrees` int(11) DEFAULT '0',
  `w_minuts` int(11) DEFAULT '0',
  `w_seconds` decimal(10,4) DEFAULT '0.0000',
  `municipality` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `latitude` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Latitude',
  `longitude` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Longitude',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
