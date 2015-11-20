-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-11-2015 a las 16:19:27
-- Versión del servidor: 5.6.26
-- Versión de PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `convivir`
--
/*CREATE DATABASE IF NOT EXISTS `convivir` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
/*USE `convivir`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriaproducto`
--

DROP TABLE IF EXISTS `categoriaproducto`;
CREATE TABLE `categoriaproducto` (
  `IdCategoria` int(11) NOT NULL,
  `Nombre` varchar(1000) NOT NULL,
  `IdTipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE `empresa` (
  `IdEmpresa` int(11) NOT NULL,
  `Nombre` varchar(512) NOT NULL,
  `NombreContacto` varchar(1000) NOT NULL,
  `EmailContacto` varchar(256) NOT NULL,
  `TelefonoContacto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadocertificacion`
--

DROP TABLE IF EXISTS `estadocertificacion`;
CREATE TABLE `estadocertificacion` (
  `IdEstadoCertificacion` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_producto`
--

DROP TABLE IF EXISTS `log_producto`;
CREATE TABLE `log_producto` (
  `IdMovimiento` int(11) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `Descripcion` varchar(8000) NOT NULL,
  `IdTipo` int(11) NOT NULL,
  `IdSubcategoria` int(11) NOT NULL,
  `IdEmpresa` int(11) NOT NULL,
  `IdCategoria` int(11) NOT NULL,
  `IdEstadoCertificacion` int(11) NOT NULL,
  `UsuarioModifica` varchar(200) DEFAULT 'anonymous',
  `FechaModificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Accion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
  `IdProducto` int(11) NOT NULL,
  `Descripcion` varchar(8000) NOT NULL,
  `IdTipo` int(11) NOT NULL,
  `IdSubcategoria` int(11) NOT NULL,
  `IdEmpresa` int(11) NOT NULL,
  `IdCategoria` int(11) NOT NULL,
  `IdEstadoCertificacion` int(11) DEFAULT NULL,
  `UsuarioModifica` varchar(200) DEFAULT NULL,
  `FechaModificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategoriaproducto`
--

DROP TABLE IF EXISTS `subcategoriaproducto`;
CREATE TABLE `subcategoriaproducto` (
  `IdSubcategoria` int(11) NOT NULL,
  `Nombre` varchar(1000) NOT NULL,
  `IdCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoproducto`
--

DROP TABLE IF EXISTS `tipoproducto`;
CREATE TABLE `tipoproducto` (
  `IdTipo` int(11) NOT NULL,
  `Nombre` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_pwd`
--

DROP TABLE IF EXISTS `user_pwd`;
CREATE TABLE `user_pwd` (
  `name` char(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pass` char(32) COLLATE latin1_general_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoriaproducto`
--
ALTER TABLE `categoriaproducto`
  ADD PRIMARY KEY (`IdCategoria`),
  ADD KEY `IdTipo` (`IdTipo`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`IdEmpresa`);

--
-- Indices de la tabla `estadocertificacion`
--
ALTER TABLE `estadocertificacion`
  ADD PRIMARY KEY (`IdEstadoCertificacion`);

--
-- Indices de la tabla `log_producto`
--
ALTER TABLE `log_producto`
  ADD PRIMARY KEY (`IdMovimiento`),
  ADD KEY `IdTipo_log1` (`IdTipo`),
  ADD KEY `IdSubcategoria_log1` (`IdSubcategoria`),
  ADD KEY `IdEmpresa_log1` (`IdEmpresa`),
  ADD KEY `IdCategoria_log1` (`IdCategoria`),
  ADD KEY `IdEstadoCertificacion_log` (`IdEstadoCertificacion`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`IdProducto`),
  ADD KEY `producto_ibfk_1` (`IdTipo`),
  ADD KEY `producto_ibfk_2` (`IdSubcategoria`),
  ADD KEY `producto_ibfk_3` (`IdEmpresa`),
  ADD KEY `producto_ibfk_4` (`IdCategoria`),
  ADD KEY `producto_ibfk_5` (`IdEstadoCertificacion`);

--
-- Indices de la tabla `subcategoriaproducto`
--
ALTER TABLE `subcategoriaproducto`
  ADD PRIMARY KEY (`IdSubcategoria`),
  ADD KEY `IdCategoria` (`IdCategoria`);

--
-- Indices de la tabla `tipoproducto`
--
ALTER TABLE `tipoproducto`
  ADD PRIMARY KEY (`IdTipo`);

--
-- Indices de la tabla `user_pwd`
--
ALTER TABLE `user_pwd`
  ADD PRIMARY KEY (`name`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoriaproducto`
--
ALTER TABLE `categoriaproducto`
  MODIFY `IdCategoria` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `IdEmpresa` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `estadocertificacion`
--
ALTER TABLE `estadocertificacion`
  MODIFY `IdEstadoCertificacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `log_producto`
--
ALTER TABLE `log_producto`
  MODIFY `IdMovimiento` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `IdProducto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `subcategoriaproducto`
--
ALTER TABLE `subcategoriaproducto`
  MODIFY `IdSubcategoria` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipoproducto`
--
ALTER TABLE `tipoproducto`
  MODIFY `IdTipo` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categoriaproducto`
--
ALTER TABLE `categoriaproducto`
  ADD CONSTRAINT `categoriaproducto_ibfk_1` FOREIGN KEY (`IdTipo`) REFERENCES `tipoproducto` (`IdTipo`);

--
-- Filtros para la tabla `log_producto`
--
ALTER TABLE `log_producto`
  ADD CONSTRAINT `producto_ibfk_1_log1` FOREIGN KEY (`IdTipo`) REFERENCES `tipoproducto` (`IdTipo`),
  ADD CONSTRAINT `producto_ibfk_2_log1` FOREIGN KEY (`IdSubcategoria`) REFERENCES `subcategoriaproducto` (`IdSubcategoria`),
  ADD CONSTRAINT `producto_ibfk_3_log1` FOREIGN KEY (`IdEmpresa`) REFERENCES `empresa` (`IdEmpresa`),
  ADD CONSTRAINT `producto_ibfk_4_log1` FOREIGN KEY (`IdCategoria`) REFERENCES `categoriaproducto` (`IdCategoria`),
  ADD CONSTRAINT `producto_ibfk_5_log1` FOREIGN KEY (`IdEstadoCertificacion`) REFERENCES `estadocertificacion` (`IdEstadoCertificacion`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`IdTipo`) REFERENCES `tipoproducto` (`IdTipo`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`IdSubcategoria`) REFERENCES `subcategoriaproducto` (`IdSubcategoria`),
  ADD CONSTRAINT `producto_ibfk_3` FOREIGN KEY (`IdEmpresa`) REFERENCES `empresa` (`IdEmpresa`),
  ADD CONSTRAINT `producto_ibfk_4` FOREIGN KEY (`IdCategoria`) REFERENCES `categoriaproducto` (`IdCategoria`),
  ADD CONSTRAINT `producto_ibfk_5` FOREIGN KEY (`IdEstadoCertificacion`) REFERENCES `estadocertificacion` (`IdEstadoCertificacion`);

--
-- Filtros para la tabla `subcategoriaproducto`
--
ALTER TABLE `subcategoriaproducto`
  ADD CONSTRAINT `subcategoriaproducto_ibfk_1` FOREIGN KEY (`IdCategoria`) REFERENCES `categoriaproducto` (`IdCategoria`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
