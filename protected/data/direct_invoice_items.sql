-- phpMyAdmin SQL Dump
-- version 4.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-06-2014 a las 01:35:56
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
-- Estructura de tabla para la tabla `direct_invoice_items`
--

CREATE TABLE IF NOT EXISTS `direct_invoice_items` (
`id` int(11) NOT NULL,
  `direct_invoice_id` int(11) NOT NULL COMMENT 'Direct Invoice',
  `quantity` int(11) NOT NULL COMMENT 'Quantity',
  `unit_measure_id` int(11) DEFAULT NULL COMMENT 'Unit of measure',
  `code_invoice` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Code Invoice',
  `presentation` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Presentation',
  `price` decimal(10,2) DEFAULT NULL COMMENT 'Price',
  `amount` decimal(10,2) DEFAULT NULL COMMENT 'Amount'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `direct_invoice_items`
--
ALTER TABLE `direct_invoice_items`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_direct_invoice_items_direct_invoice1_idx` (`direct_invoice_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `direct_invoice_items`
--
ALTER TABLE `direct_invoice_items`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `direct_invoice_items`
--
ALTER TABLE `direct_invoice_items`
ADD CONSTRAINT `fk_direct_invoice_items_direct_invoice1` FOREIGN KEY (`direct_invoice_id`) REFERENCES `direct_invoice` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
