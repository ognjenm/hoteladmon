-- phpMyAdmin SQL Dump
-- version 4.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-07-2014 a las 01:25:09
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
-- Estructura de tabla para la tabla `keep_items`
--

CREATE TABLE IF NOT EXISTS `keep_items` (
`id` int(11) NOT NULL,
  `keep_id` int(11) NOT NULL,
  `texto` tinytext CHARACTER SET utf8 COMMENT 'Text'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `keep_main`
--

CREATE TABLE IF NOT EXISTS `keep_main` (
`id` int(11) NOT NULL,
  `title` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Title',
  `image` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Image',
  `remember` datetime DEFAULT NULL COMMENT 'Remember',
  `active` tinyint(4) DEFAULT NULL,
  `datetime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `keep_items`
--
ALTER TABLE `keep_items`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_keep_items_keep_main1_idx` (`keep_id`);

--
-- Indices de la tabla `keep_main`
--
ALTER TABLE `keep_main`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `keep_items`
--
ALTER TABLE `keep_items`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de la tabla `keep_main`
--
ALTER TABLE `keep_main`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `keep_items`
--
ALTER TABLE `keep_items`
ADD CONSTRAINT `fk_keep_items_keep_main1` FOREIGN KEY (`keep_id`) REFERENCES `keep_main` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
