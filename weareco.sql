-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 25-11-2018 a las 19:10:00
-- Versión del servidor: 5.7.19
-- Versión de PHP: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `weareco`
--
CREATE DATABASE IF NOT EXISTS `weareco` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `weareco`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cab_factura`
--

DROP TABLE IF EXISTS `cab_factura`;
CREATE TABLE IF NOT EXISTS `cab_factura` (
  `id_factura` int(11) NOT NULL,
  `fact2cliente` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  PRIMARY KEY (`id_factura`),
  KEY `fact2cliente` (`fact2cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellidos` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `usuario` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `det_factura`
--

DROP TABLE IF EXISTS `det_factura`;
CREATE TABLE IF NOT EXISTS `det_factura` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `det2fact` int(11) NOT NULL,
  `det2prod` int(11) NOT NULL,
  `cant` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `det2fact` (`det2fact`),
  KEY `det2prod` (`det2prod`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

DROP TABLE IF EXISTS `direcciones`;
CREATE TABLE IF NOT EXISTS `direcciones` (
  `id_direccion` int(11) NOT NULL AUTO_INCREMENT,
  `direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `cp` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` enum('fac','env') COLLATE utf8_spanish_ci NOT NULL,
  `direcc2cliente` int(11) NOT NULL,
  PRIMARY KEY (`id_direccion`),
  KEY `direcc2cliente` (`direcc2cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donaciones`
--

DROP TABLE IF EXISTS `donaciones`;
CREATE TABLE IF NOT EXISTS `donaciones` (
  `id_donaciones` int(11) NOT NULL,
  `don2fact` int(11) NOT NULL,
  `monto` float(11,2) NOT NULL,
  PRIMARY KEY (`id_donaciones`),
  KEY `don2fact` (`don2fact`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `img` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cab_factura`
--
ALTER TABLE `cab_factura`
  ADD CONSTRAINT `cab_factura_ibfk_1` FOREIGN KEY (`fact2cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `det_factura`
--
ALTER TABLE `det_factura`
  ADD CONSTRAINT `det_factura_ibfk_2` FOREIGN KEY (`det2prod`) REFERENCES `productos` (`id_producto`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `det_factura_ibfk_3` FOREIGN KEY (`det2fact`) REFERENCES `cab_factura` (`id_factura`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `direcciones_ibfk_1` FOREIGN KEY (`direcc2cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `donaciones`
--
ALTER TABLE `donaciones`
  ADD CONSTRAINT `donaciones_ibfk_1` FOREIGN KEY (`don2fact`) REFERENCES `cab_factura` (`id_factura`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;
