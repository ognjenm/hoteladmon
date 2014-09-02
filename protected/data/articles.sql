-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-05-2014 a las 01:25:52
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
-- Estructura de tabla para la tabla `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_id` int(11) NOT NULL COMMENT 'Provider',
  `name_article` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Name Article',
  `name_store` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Name Store',
  `name_invoice` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Name Invoice',
  `unit_measure_id` int(11) NOT NULL COMMENT 'Unit Of Measure',
  `code` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Code',
  `code_store` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Code Store',
  `code_invoice` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Code Invoice',
  `measure` varchar(50) DEFAULT NULL COMMENT 'Measure',
  `price` decimal(10,2) DEFAULT NULL COMMENT 'Price',
  `price_kg` decimal(10,2) DEFAULT NULL COMMENT 'Price X Kg',
  `date_price` date DEFAULT NULL COMMENT 'Date',
  `color` varchar(50) DEFAULT NULL COMMENT 'Color',
  `presentation` varchar(50) DEFAULT NULL COMMENT 'Presentation',
  `quantity` int(11) DEFAULT NULL COMMENT 'Quantity',
  `conversion_unit` varchar(50) DEFAULT NULL COMMENT 'Conversion Unit',
  `unit_price` decimal(10,2) DEFAULT NULL COMMENT 'Unit Price',
  `explanation` tinytext COMMENT 'Explanation',
  `notes` tinytext COMMENT 'Notes',
  `image` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Image',
  `barcode` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Barcode',
  `rating` int(11) DEFAULT NULL COMMENT 'Rating',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `articles`
--

INSERT INTO `articles` (`id`, `provider_id`, `name_article`, `name_store`, `name_invoice`, `unit_measure_id`, `code`, `code_store`, `code_invoice`, `measure`, `price`, `price_kg`, `date_price`, `color`, `presentation`, `quantity`, `conversion_unit`, `unit_price`, `explanation`, `notes`, `image`, `barcode`, `rating`) VALUES
(1, 290, 'GRAPAS', 'S', 'G', 2, '123', '1234', '12345', '5/8', NULL, '0.00', NULL, 'GRIS', 'BOLSA DE 100 PZAS', 1, 'PZA', '150.00', 'NONE', 'NONE', '', '123456', NULL),
(2, 290, 'BOLSAS', 'U', 'R', 2, '12345', '123456', '1234567', '1/2', NULL, '0.00', NULL, 'GRIS', 'BOLSA DE 100 PZAS', 1, 'PZA', '210.00', 'NONE', 'NONE', '', '123456789', NULL),
(3, 292, 'Luis Alfonso Hau Ojeda', 'Luis', 'Hau Ojeda', 2, '123', '1234', '12345', '5/8', NULL, '0.00', NULL, 'GRIS', 'BOLSA DE 100 PZAS', 1, 'PZA', '150.00', 'NONE', 'NONE', '', '123456', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
