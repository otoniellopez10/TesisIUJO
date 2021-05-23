-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-05-2021 a las 18:56:22
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tesis`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `id_libro` int(10) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `autor` int(5) DEFAULT NULL,
  `editorial` int(5) DEFAULT NULL,
  `edicion` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `categoria` int(5) DEFAULT NULL,
  `materia` int(5) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `estatus` int(10) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro_autor`
--

CREATE TABLE `libro_autor` (
  `id` int(5) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `estatus` int(10) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro_categoria`
--

CREATE TABLE `libro_categoria` (
  `id` int(5) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estatus` int(10) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `libro_categoria`
--

INSERT INTO `libro_categoria` (`id`, `nombre`, `estatus`) VALUES
(1, 'Literatura', 1),
(2, 'Ciencia ficción', 1),
(3, 'Fantasía', 1),
(4, 'Novela', 1),
(5, 'Drama', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro_editorial`
--

CREATE TABLE `libro_editorial` (
  `id` int(5) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estatus` int(10) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `libro_editorial`
--

INSERT INTO `libro_editorial` (`id`, `nombre`, `estatus`) VALUES
(1, 'Santillana', 1),
(2, 'Caracol', 1),
(3, 'Planeta', 1),
(4, 'Editorial 4', 1),
(5, 'Editorial 5', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro_materia`
--

CREATE TABLE `libro_materia` (
  `id` int(5) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estatus` int(10) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `libro_materia`
--

INSERT INTO `libro_materia` (`id`, `nombre`, `estatus`) VALUES
(1, 'Matemática', 1),
(2, 'Lógica', 1),
(3, 'programación', 1),
(4, 'Lenguaje', 1),
(5, 'Análisis', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(10) NOT NULL,
  `cedula` int(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `usuario_id` int(10) NOT NULL,
  `estatus` int(10) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_datos`
--

CREATE TABLE `usuario_datos` (
  `id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol_id` int(10) NOT NULL,
  `estatus` int(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE `usuario_rol` (
  `id` int(5) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estatus` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`id`, `nombre`, `estatus`) VALUES
(1, 'Estudiante', 1),
(2, 'Docente', 1),
(3, 'Coordinador', 1),
(4, 'Director', 1),
(5, 'Administrativo', 1),
(6, 'Obrero', 1),
(7, 'Otro', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id_libro`),
  ADD KEY `autor` (`autor`,`editorial`,`categoria`,`materia`),
  ADD KEY `categoria` (`categoria`),
  ADD KEY `editorial` (`editorial`),
  ADD KEY `materia` (`materia`);

--
-- Indices de la tabla `libro_autor`
--
ALTER TABLE `libro_autor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `libro_categoria`
--
ALTER TABLE `libro_categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `libro_editorial`
--
ALTER TABLE `libro_editorial`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `libro_materia`
--
ALTER TABLE `libro_materia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuario_datos`
--
ALTER TABLE `usuario_datos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol_id` (`rol_id`);

--
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `id_libro` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `libro_autor`
--
ALTER TABLE `libro_autor`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `libro_categoria`
--
ALTER TABLE `libro_categoria`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `libro_editorial`
--
ALTER TABLE `libro_editorial`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `libro_materia`
--
ALTER TABLE `libro_materia`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario_datos`
--
ALTER TABLE `usuario_datos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `libro`
--
ALTER TABLE `libro`
  ADD CONSTRAINT `libro_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `libro_autor` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `libro_ibfk_2` FOREIGN KEY (`categoria`) REFERENCES `libro_categoria` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `libro_ibfk_3` FOREIGN KEY (`editorial`) REFERENCES `libro_editorial` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `libro_ibfk_4` FOREIGN KEY (`materia`) REFERENCES `libro_materia` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario_datos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_datos`
--
ALTER TABLE `usuario_datos`
  ADD CONSTRAINT `usuario_datos_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `usuario_rol` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
