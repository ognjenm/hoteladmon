-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-05-2014 a las 21:10:54
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
-- Estructura de tabla para la tabla `contracts`
--

CREATE TABLE IF NOT EXISTS `contracts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_information_id` int(11) DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Title',
  `content` text CHARACTER SET utf8 COMMENT 'Content',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contract_information`
--

CREATE TABLE IF NOT EXISTS `contract_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lessee` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Leessee',
  `owner` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Owner',
  `property_location` tinytext CHARACTER SET utf8 COMMENT 'Property Location',
  `paydays` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Paydays',
  `amount_rent` decimal(10,2) DEFAULT NULL COMMENT 'Amount Of Rent',
  `forced_months` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Forced Months',
  `inception_lease` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Inception Of The Lease',
  `end_lease` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'End Of The Lease',
  `payment_services` decimal(10,2) DEFAULT NULL COMMENT 'Payment For Services',
  `monthly_payment_arrears` int(11) DEFAULT NULL COMMENT 'Monthly Payment Arrears',
  `new_rent_payment` decimal(10,2) DEFAULT NULL COMMENT 'New Rent Payment',
  `monthly_payment_increase` int(11) DEFAULT NULL COMMENT 'Monthly Payment Increase',
  `penalty_nonpayment` int(11) DEFAULT NULL COMMENT 'Penalty for non-payment of monthly rent',
  `deposit_guarantee` decimal(10,2) DEFAULT NULL COMMENT 'Deposit  Of Guarantee',
  `name_surety` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Name Of The Surety',
  `address_surety` tinytext CHARACTER SET utf8 COMMENT 'Address Of The Surety',
  `property_address_surety` tinytext CHARACTER SET utf8 COMMENT 'Property Address Of The Surety',
  `address_public_register` tinytext CHARACTER SET utf8 COMMENT 'Address public register where the property is registered',
  `date_signature` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Date Of Signature',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
