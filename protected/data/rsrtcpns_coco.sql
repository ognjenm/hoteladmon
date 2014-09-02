-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2014 a las 01:33:17
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
-- Estructura de tabla para la tabla `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT 'Name',
  `description` varchar(500) DEFAULT NULL COMMENT 'Description',
  `date_start` datetime DEFAULT NULL COMMENT 'Date Start',
  `date_due` datetime DEFAULT NULL COMMENT 'Date Due',
  `date_finish` datetime DEFAULT NULL COMMENT 'Date Finish',
  `date_entered` datetime DEFAULT NULL COMMENT 'Date Entered',
  `status` int(11) DEFAULT NULL COMMENT 'Status',
  `duration` int(11) DEFAULT NULL COMMENT 'Duration',
  `duration_unit` varchar(20) DEFAULT NULL COMMENT 'Duration Unit',
  `priority` int(11) DEFAULT NULL COMMENT 'Priority',
  `department` int(11) DEFAULT NULL COMMENT 'Department',
  `isclose` tinyint(4) DEFAULT '0',
  `days_after_date_due` int(11) DEFAULT NULL COMMENT 'Days After Date Due',
  `zone` int(11) DEFAULT NULL COMMENT 'Zone',
  `employee_id` int(11) DEFAULT NULL COMMENT 'Employe',
  `isgroup` tinyint(4) DEFAULT '0',
  `group_assigned_id` int(11) DEFAULT NULL,
  `accepted_by` int(11) DEFAULT '0' COMMENT 'Accepted By',
  `parent_id` int(11) DEFAULT '0',
  `frecuency` varchar(50) DEFAULT NULL COMMENT 'Frecuency',
  `created_by` int(11) DEFAULT '0' COMMENT 'Created By',
  `providers` varchar(300) CHARACTER SET latin1 DEFAULT NULL,
  `accepted_users` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
