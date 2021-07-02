-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-07-2021 a las 05:26:55
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Estructura de tabla para la tabla `autor`
--

CREATE TABLE `autor` (
  `id` int(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `estatus` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_libro`
--

CREATE TABLE `bitacora_libro` (
  `id` int(10) NOT NULL,
  `usuario_id` int(10) NOT NULL,
  `libro_id` int(10) NOT NULL,
  `operacion` varchar(255) NOT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_persona`
--

CREATE TABLE `bitacora_persona` (
  `id` int(10) NOT NULL,
  `persona_id` int(10) NOT NULL,
  `operacion` varchar(255) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion_libro`
--

CREATE TABLE `calificacion_libro` (
  `id` int(10) NOT NULL,
  `usuario_id` int(10) NOT NULL,
  `libro_id` int(10) NOT NULL,
  `calificacion` int(10) NOT NULL,
  `comentario` varchar(255) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colaborador_libro`
--

CREATE TABLE `colaborador_libro` (
  `id` int(10) NOT NULL,
  `usuario_id` int(10) NOT NULL,
  `libro_id` int(10) NOT NULL,
  `fecha_carga` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descarga_libro`
--

CREATE TABLE `descarga_libro` (
  `id` int(10) NOT NULL,
  `usuario_id` int(10) NOT NULL,
  `libro_id` int(10) NOT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `usuario_id` int(10) NOT NULL,
  `libro_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `id` int(10) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `editorial` int(10) NOT NULL,
  `edicion` varchar(50) DEFAULT NULL,
  `fecha` date NOT NULL,
  `carrera` int(10) NOT NULL,
  `categoria` int(10) DEFAULT NULL,
  `resumen` varchar(500) DEFAULT NULL,
  `pdf` varchar(255) NOT NULL,
  `estatus` int(10) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro_autor`
--

CREATE TABLE `libro_autor` (
  `libro_id` int(10) NOT NULL,
  `autor_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro_carrera`
--

CREATE TABLE `libro_carrera` (
  `id` int(5) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estatus` int(10) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `libro_carrera`
--

INSERT INTO `libro_carrera` (`id`, `nombre`, `estatus`) VALUES
(1, 'Administración', 1),
(2, 'Contaduría', 1),
(3, 'Informática', 1),
(4, 'Mecánica', 1),
(5, 'Electrónica', 1),
(6, 'Electrotecnia', 1),
(7, 'Educación Especial', 1),
(8, 'Educación preescolar', 1),
(9, 'Educación Integral', 1),
(10, 'General', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro_categoria`
--

CREATE TABLE `libro_categoria` (
  `id` int(5) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estatus` int(10) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `libro_categoria`
--

INSERT INTO `libro_categoria` (`id`, `nombre`, `estatus`) VALUES
(1, 'Lenguaje', 1),
(2, 'Idiomas', 1),
(3, 'Matemática', 1),
(4, 'Contabilidad', 1),
(5, 'Software', 1),
(6, 'Cálculo', 1),
(7, 'Computación', 1),
(8, 'Historia', 1),
(9, 'Literatura', 1),
(10, 'Filosofía', 1),
(11, 'Gastronomía', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro_editorial`
--

CREATE TABLE `libro_editorial` (
  `id` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estatus` int(10) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `libro_editorial`
--

INSERT INTO `libro_editorial` (`id`, `nombre`, `estatus`) VALUES
(0, 'Sin editorial', 1),
(1, 'Santillana', 1),
(2, 'Planeta', 1),
(3, 'Alpha Decay', 1),
(4, 'Penguin Random House Grupo Editorial', 1),
(5, 'Anagrama editorial', 1),
(6, 'Blackie Books', 1),
(7, 'Seix Barral', 1),
(8, 'Libros del Asteroide', 1),
(9, 'Malpaso', 1),
(10, 'Sexto Piso', 1),
(12, 'Ediciones Obelisco', 1);

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
  `persona_tipo` int(10) NOT NULL,
  `usuario_id` int(10) NOT NULL,
  `estatus` int(10) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `cedula`, `nombre`, `apellido`, `telefono`, `persona_tipo`, `usuario_id`, `estatus`) VALUES
(1, 0, 'Administrador', ' ', '', 5, 1, 1);

--
-- Disparadores `persona`
--
DELIMITER $$
CREATE TRIGGER `Registro` AFTER INSERT ON `persona` FOR EACH ROW INSERT INTO bitacora_persona (persona_id,operacion) VALUES (new.id, CONCAT( new.nombre, " ", new.apellido, " se ha registrado en el sistema." ))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona_tipo`
--

CREATE TABLE `persona_tipo` (
  `id` int(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `estatus` int(10) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona_tipo`
--

INSERT INTO `persona_tipo` (`id`, `nombre`, `estatus`) VALUES
(1, 'Estudiante', 1),
(2, 'Docente', 1),
(3, 'Coordinador', 1),
(4, 'Directivo', 1),
(5, 'Administracion', 1),
(6, 'Obrero', 1),
(7, 'Otro', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol_id` int(10) NOT NULL,
  `estatus` int(10) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `password`, `rol_id`, `estatus`) VALUES
(1, 'admin@tesis.com', '$2y$10$St71MD.ufAC1JkSAZ19oxOwxFgJlrLgJm1JxTgEtVC86wITu78S3.', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE `usuario_rol` (
  `id` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estatus` int(10) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`id`, `nombre`, `estatus`) VALUES
(1, 'Administrador', 1),
(2, 'Colaborador', 1),
(3, 'Usuario', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vista_libro`
--

CREATE TABLE `vista_libro` (
  `id` int(10) NOT NULL,
  `usuario_id` int(10) NOT NULL,
  `libro_id` int(10) NOT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bitacora_libro`
--
ALTER TABLE `bitacora_libro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `libro_id` (`libro_id`);

--
-- Indices de la tabla `bitacora_persona`
--
ALTER TABLE `bitacora_persona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persona_id` (`persona_id`);

--
-- Indices de la tabla `calificacion_libro`
--
ALTER TABLE `calificacion_libro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `libro_id` (`libro_id`);

--
-- Indices de la tabla `colaborador_libro`
--
ALTER TABLE `colaborador_libro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `libro_id` (`libro_id`);

--
-- Indices de la tabla `descarga_libro`
--
ALTER TABLE `descarga_libro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `libro_id` (`libro_id`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `libro_id` (`libro_id`);

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pdf` (`pdf`),
  ADD KEY `autor` (`editorial`,`carrera`,`categoria`),
  ADD KEY `categoria` (`carrera`),
  ADD KEY `editorial` (`editorial`),
  ADD KEY `materia` (`categoria`),
  ADD KEY `tema` (`categoria`);

--
-- Indices de la tabla `libro_autor`
--
ALTER TABLE `libro_autor`
  ADD KEY `libro_id` (`libro_id`,`autor_id`),
  ADD KEY `autor_id` (`autor_id`) USING BTREE;

--
-- Indices de la tabla `libro_carrera`
--
ALTER TABLE `libro_carrera`
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
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `persona_tipo` (`persona_tipo`);

--
-- Indices de la tabla `persona_tipo`
--
ALTER TABLE `persona_tipo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol_id` (`rol_id`);

--
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vista_libro`
--
ALTER TABLE `vista_libro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `libro_id` (`libro_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autor`
--
ALTER TABLE `autor`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bitacora_libro`
--
ALTER TABLE `bitacora_libro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bitacora_persona`
--
ALTER TABLE `bitacora_persona`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calificacion_libro`
--
ALTER TABLE `calificacion_libro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `colaborador_libro`
--
ALTER TABLE `colaborador_libro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `descarga_libro`
--
ALTER TABLE `descarga_libro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `libro_carrera`
--
ALTER TABLE `libro_carrera`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `libro_categoria`
--
ALTER TABLE `libro_categoria`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `libro_editorial`
--
ALTER TABLE `libro_editorial`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `persona_tipo`
--
ALTER TABLE `persona_tipo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `vista_libro`
--
ALTER TABLE `vista_libro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bitacora_libro`
--
ALTER TABLE `bitacora_libro`
  ADD CONSTRAINT `bitacora_libro_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bitacora_libro_ibfk_2` FOREIGN KEY (`libro_id`) REFERENCES `libro` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `bitacora_persona`
--
ALTER TABLE `bitacora_persona`
  ADD CONSTRAINT `bitacora_persona_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `calificacion_libro`
--
ALTER TABLE `calificacion_libro`
  ADD CONSTRAINT `calificacion_libro_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `calificacion_libro_ibfk_2` FOREIGN KEY (`libro_id`) REFERENCES `libro` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `colaborador_libro`
--
ALTER TABLE `colaborador_libro`
  ADD CONSTRAINT `colaborador_libro_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `colaborador_libro_ibfk_2` FOREIGN KEY (`libro_id`) REFERENCES `libro` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `descarga_libro`
--
ALTER TABLE `descarga_libro`
  ADD CONSTRAINT `descarga_libro_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `descarga_libro_ibfk_2` FOREIGN KEY (`libro_id`) REFERENCES `libro` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`libro_id`) REFERENCES `libro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `libro`
--
ALTER TABLE `libro`
  ADD CONSTRAINT `libro_ibfk_3` FOREIGN KEY (`editorial`) REFERENCES `libro_editorial` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `libro_ibfk_5` FOREIGN KEY (`carrera`) REFERENCES `libro_carrera` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `libro_ibfk_6` FOREIGN KEY (`categoria`) REFERENCES `libro_categoria` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `libro_autor`
--
ALTER TABLE `libro_autor`
  ADD CONSTRAINT `libro_autor_ibfk_3` FOREIGN KEY (`autor_id`) REFERENCES `autor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `libro_autor_ibfk_4` FOREIGN KEY (`libro_id`) REFERENCES `libro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `persona_ibfk_2` FOREIGN KEY (`persona_tipo`) REFERENCES `persona_tipo` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `usuario_rol` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `vista_libro`
--
ALTER TABLE `vista_libro`
  ADD CONSTRAINT `vista_libro_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `vista_libro_ibfk_2` FOREIGN KEY (`libro_id`) REFERENCES `libro` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
