-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 28-01-2013 a las 19:05:40
-- Versión del servidor: 5.5.29
-- Versión de PHP: 5.3.10-1ubuntu3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `tifosi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cancha`
--

CREATE TABLE IF NOT EXISTS `cancha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(55) DEFAULT NULL,
  `obs` varchar(250) DEFAULT NULL,
  `id_sucursal` int(11) NOT NULL,
  PRIMARY KEY (`id`,`id_sucursal`),
  KEY `fk_cancha_1_idx` (`id_sucursal`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `cancha`
--

INSERT INTO `cancha` (`id`, `nombre`, `obs`, `id_sucursal`) VALUES
(1, 'Cancha1', NULL, 1),
(2, 'Cancha2', NULL, 1),
(3, 'Cancha3', NULL, 1),
(4, 'Cancha4', NULL, 1),
(5, 'Cancha1', NULL, 2),
(6, 'Cancha2', NULL, 2),
(7, 'Cancha3', NULL, 2),
(8, 'Cancha1', NULL, 3),
(9, 'Cancha2', NULL, 3),
(10, 'Cancha3', NULL, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_sucursal` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `tel` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_sucursal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_horario`
--

CREATE TABLE IF NOT EXISTS `cuenta_horario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) DEFAULT NULL,
  `hs_apertura` datetime DEFAULT NULL,
  `hs_cierre` datetime DEFAULT NULL,
  `id_horario_cancha` int(11) DEFAULT NULL,
  `id_cancha` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cuenta_horario_1_idx` (`id_horario_cancha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE IF NOT EXISTS `empleado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL,
  `id_sucursal` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_empleado_1_idx` (`id_sucursal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_cancha`
--

CREATE TABLE IF NOT EXISTS `horario_cancha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` varchar(45) NOT NULL,
  `precio` varchar(45) DEFAULT NULL,
  `retraso` varchar(45) NOT NULL,
  `obs` varchar(250) DEFAULT NULL,
  `id_cancha` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_horario_cancha_1_idx` (`id_cancha`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=92 ;

--
-- Volcado de datos para la tabla `horario_cancha`
--

INSERT INTO `horario_cancha` (`id`, `nombre`, `estado`, `precio`, `retraso`, `obs`, `id_cancha`, `fecha`, `id_sucursal`) VALUES
(1, '14', '', '150', '', NULL, 1, '0000-00-00 00:00:00', 1),
(2, '14', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 2),
(3, '14', '', '150', '', NULL, 2, '0000-00-00 00:00:00', 1),
(4, '14', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 1),
(5, '14', '', '170', '', NULL, 4, '0000-00-00 00:00:00', 1),
(6, '15', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 1),
(7, '15', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 1),
(8, '15', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 1),
(9, '15', '', '170', '', NULL, 4, '0000-00-00 00:00:00', 1),
(10, '16', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 1),
(11, '16', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 1),
(12, '16', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 1),
(13, '16', '', '170', '', NULL, 4, '0000-00-00 00:00:00', 1),
(14, '17', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 1),
(15, '17', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 1),
(16, '17', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 1),
(17, '17', '', '170', '', NULL, 4, '0000-00-00 00:00:00', 1),
(18, '18', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 1),
(19, '18', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 1),
(20, '18', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 1),
(21, '18', '', '170', '', NULL, 4, '0000-00-00 00:00:00', 1),
(22, '19', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 1),
(23, '19', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 1),
(24, '19', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 1),
(25, '19', '', '170', '', NULL, 4, '0000-00-00 00:00:00', 1),
(26, '20', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 1),
(27, '20', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 1),
(28, '20', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 1),
(29, '20', '', '170', '', NULL, 4, '0000-00-00 00:00:00', 1),
(30, '21', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 1),
(31, '21', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 1),
(32, '21', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 1),
(33, '21', '', '170', '', NULL, 4, '0000-00-00 00:00:00', 1),
(34, '22', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 1),
(35, '22', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 1),
(36, '22', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 1),
(37, '22', '', '170', '', NULL, 4, '0000-00-00 00:00:00', 1),
(38, '14', '', '150', '', NULL, 1, '0000-00-00 00:00:00', 2),
(39, '14', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 2),
(40, '14', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 2),
(41, '15', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 2),
(42, '15', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 2),
(43, '15', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 2),
(44, '16', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 2),
(45, '16', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 2),
(46, '16', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 2),
(47, '17', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 2),
(48, '17', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 2),
(49, '17', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 2),
(50, '18', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 2),
(51, '18', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 2),
(52, '18', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 2),
(53, '19', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 2),
(54, '19', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 2),
(55, '19', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 2),
(56, '20', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 2),
(57, '20', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 2),
(58, '20', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 2),
(59, '21', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 2),
(60, '21', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 2),
(61, '21', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 2),
(62, '22', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 2),
(63, '22', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 2),
(64, '22', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 2),
(65, '14', '', '150', '', NULL, 1, '0000-00-00 00:00:00', 3),
(66, '14', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 3),
(67, '14', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 3),
(68, '15', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 3),
(69, '15', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 3),
(70, '15', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 3),
(71, '16', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 3),
(72, '16', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 3),
(73, '16', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 3),
(74, '17', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 3),
(75, '17', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 3),
(76, '17', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 3),
(77, '18', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 3),
(78, '18', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 3),
(79, '18', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 3),
(80, '19', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 3),
(81, '19', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 3),
(82, '19', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 3),
(83, '20', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 3),
(84, '20', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 3),
(85, '20', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 3),
(86, '21', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 3),
(87, '21', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 3),
(88, '21', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 3),
(89, '22', '', '170', '', NULL, 1, '0000-00-00 00:00:00', 3),
(90, '22', '', '170', '', NULL, 2, '0000-00-00 00:00:00', 3),
(91, '22', '', '170', '', NULL, 3, '0000-00-00 00:00:00', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_sucursal`
--

CREATE TABLE IF NOT EXISTS `movimiento_sucursal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'es el id del movimiento registrado en la cuenta',
  `id_sucursal` int(11) NOT NULL,
  `detalle` varchar(255) NOT NULL DEFAULT 'movimiento',
  `ingreso` decimal(10,2) DEFAULT NULL,
  `egreso` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cuenta_sucursal_2_idx` (`id_empleado`),
  KEY `fk_cuenta_sucursal_3_idx` (`id_sucursal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `p_pedido` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `id_sucursal` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_producto_1_idx` (`id_sucursal`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `codigo`, `descripcion`, `marca`, `precio`, `p_pedido`, `stock`, `id_sucursal`) VALUES
(2, '01', 'coca cola 1,5lt', 'coca cola', 10.00, 20, 1000, 1),
(3, '02', 'cerveza quilmes 970', 'quilmes', 12.00, 50, 1200, 1),
(4, '03', 'papas fritas 250g', 'lays', 6.00, 20, 1300, 1),
(5, '04', 'gatorade 500ml', 'gatorade', 7.00, 10, 200, 1),
(6, '05', 'cerveza estella artois 1l', 'estella artois', 15.00, 50, 600, 1),
(7, '06', 'seven up 1,5l', 'seven up', 13.00, 40, 200, 1),
(8, '07', 'agua mineral sin gas 1l', 'eco de los andes', 10.00, 30, 230, 1),
(9, '08', 'paso de los toros pomelo 1l', 'paso de los toros', 13.00, 30, 320, 1),
(10, '09', 'fanta 1,5l', 'fanta', 15.00, 20, 320, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_cuenta`
--

CREATE TABLE IF NOT EXISTS `producto_cuenta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cuenta_horario` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `id_sucursal` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_producto_cuenta_1_idx` (`id_cuenta_horario`),
  KEY `fk_producto_cuenta_2_idx` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_trans`
--

CREATE TABLE IF NOT EXISTS `product_trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `hora` datetime DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL COMMENT '(venta,compra,predida)',
  `precio` decimal(10,2) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_trans_1_idx` (`id_producto`),
  KEY `fk_product_trans_2_idx` (`id_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE IF NOT EXISTS `sucursal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`id`, `nombre`, `direccion`) VALUES
(1, 'Alverdi', 'don orione 123'),
(2, 'Capitan Vermudez', 'calle falsa123');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuenta_horario`
--
ALTER TABLE `cuenta_horario`
  ADD CONSTRAINT `fk_cuenta_horario_1` FOREIGN KEY (`id_horario_cancha`) REFERENCES `horario_cancha` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_empleado_1` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `movimiento_sucursal`
--
ALTER TABLE `movimiento_sucursal`
  ADD CONSTRAINT `fk_cuenta_sucursal_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_1` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto_cuenta`
--
ALTER TABLE `producto_cuenta`
  ADD CONSTRAINT `fk_producto_cuenta_1` FOREIGN KEY (`id_cuenta_horario`) REFERENCES `cuenta_horario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_cuenta_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `product_trans`
--
ALTER TABLE `product_trans`
  ADD CONSTRAINT `fk_product_trans_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
