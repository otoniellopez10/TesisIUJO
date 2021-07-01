-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-06-2021 a las 21:51:17
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

--
-- Volcado de datos para la tabla `autor`
--

INSERT INTO `autor` (`id`, `nombre`, `estatus`) VALUES
(44, 'Otoniel López', 1),
(45, 'Candida Guerra', 1),
(46, 'Jorge Saens', 1),
(47, 'Pedro Pablo', 1),
(48, 'Lejon Jaramillo', 1),
(49, 'Robert Fisher', 1),
(50, 'Autor 1', 1),
(51, 'Autor 2', 1),
(52, 'Autor 3', 1),
(53, 'Colaborador 1', 1),
(54, 'Colaborador uno', 1),
(55, 'colaborador 1', 1),
(56, 'colaborador unoo', 1),
(57, 'Jorge Saens Editado', 1),
(58, 'Jorge', 1),
(59, 'Robert Fisher', 1),
(60, 'Robert Fisher 2', 1),
(61, 'Jorge Saens', 1),
(62, 'Jorge Saens', 1),
(63, 'otro para jorge', 1),
(64, 'Jorge Saens', 1),
(65, 'Robert Fisher', 1),
(66, 'Jorge Saens', 1),
(67, 'Jorge Saens 2', 1),
(68, 'Jorge Saens', 1),
(69, 'Otoniel López', 1),
(70, 'Candida Guerra', 1),
(71, 'colaborador 1', 1),
(72, 'colaborador unoo', 1),
(73, 'Colaborador 1', 1),
(74, 'Colaborador uno', 1),
(75, 'Autor de prueba', 1),
(76, 'Jorge Saens', 1),
(77, 'Jorge Saens', 1),
(78, 'jorge saens', 1),
(79, 'jorge saens', 1),
(80, 'jorge saens', 1),
(81, 'jorge saens', 1),
(82, 'Jorge Saens', 1),
(83, 'Otoniel López', 1),
(84, 'Candida Guerra', 1),
(85, 'HORACIO LOPEZ', 1),
(86, 'Otoniel López', 1),
(87, 'Candida Guerra', 1),
(88, 'Otoniel López', 1),
(89, 'Candida Guerra', 1),
(90, 'Horacio Lopez', 1),
(91, 'Otoniel López', 1),
(92, 'Candida Guerra', 1);

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

--
-- Volcado de datos para la tabla `calificacion_libro`
--

INSERT INTO `calificacion_libro` (`id`, `usuario_id`, `libro_id`, `calificacion`, `comentario`, `fecha`) VALUES
(16, 3, 35, 5, 'perfecto este libro', '2021-06-24 23:30:35'),
(18, 2, 35, 5, '5 estrellas', '2021-06-28 00:05:35'),
(20, 2, 33, 5, '5 estrellas!', '2021-06-28 17:38:52'),
(21, 3, 33, 3, 'muy bueno!', '2021-06-28 21:27:27');

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

--
-- Volcado de datos para la tabla `colaborador_libro`
--

INSERT INTO `colaborador_libro` (`id`, `usuario_id`, `libro_id`, `fecha_carga`) VALUES
(1, 2, 37, '2021-06-27 23:55:41'),
(2, 2, 38, '2021-06-27 23:56:30');

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

--
-- Volcado de datos para la tabla `descarga_libro`
--

INSERT INTO `descarga_libro` (`id`, `usuario_id`, `libro_id`, `fecha`) VALUES
(1, 3, 33, '2021-06-20 18:00:23'),
(2, 3, 34, '2021-06-20 18:00:49'),
(3, 3, 35, '2021-06-20 18:00:50'),
(4, 3, 36, '2021-06-20 18:00:52'),
(5, 3, 36, '2021-06-20 18:00:52'),
(6, 2, 34, '2021-06-21 04:27:34'),
(7, 2, 36, '2021-06-21 04:27:34'),
(8, 3, 33, '2021-06-27 22:10:29'),
(9, 3, 33, '2021-06-27 22:10:38'),
(10, 2, 35, '2021-06-28 21:51:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `usuario_id` int(10) NOT NULL,
  `libro_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`usuario_id`, `libro_id`) VALUES
(3, 35),
(3, 33),
(2, 35);

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

--
-- Volcado de datos para la tabla `libro`
--

INSERT INTO `libro` (`id`, `titulo`, `editorial`, `edicion`, `fecha`, `carrera`, `categoria`, `resumen`, `pdf`, `estatus`) VALUES
(32, 'El caballero de la armadura oxidada', 12, 'Primera edición', '2000-04-21', 10, 10, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto recusandae porro, quia earum nam accusamus numquam dicta qui consequuntur aliquid debitis consequatur deserunt illum possimus provident, nostrum excepturi soluta. Quas?', 'xzsBnIMcD6X1UKCufT8VplantillaDiploma.pdf', 0),
(33, 'Calculo I', 1, 'Primera edición', '2000-04-21', 10, 6, 'Libro inspirado en la matematica de Jorge Saens', 'SvcNIgLTKPHjewq3pXJWlic. grado 2 - 200204930883.pdf', 1),
(34, 'Ingles I', 2, 'Segunda edición', '2000-04-21', 10, 2, 'Libro de ingles por Pedro y Pablo con contenido para principiante', 'TVA9kHj3I2waP64qsgoSlic. grado 2 - 200204930883.pdf', 1),
(35, 'El Caballero de la armadura oxidada', 12, 'Primera edición', '1987-05-01', 10, 9, 'El Caballero de la Armadura Oxidada cuenta la historia de una caballero, que preocupado en sobremanera por las apariencias y el ser alabado por sus hazañas, las cuales realiza más por los aplausos que por una convicción', 'HKcBSg46FerkTZvbQxDfMOMENTO I.pdf', 1),
(36, 'Titulo de libro de ejemplo', 8, 'Primera edición', '2000-04-21', 10, 7, 'Libro de prueba con el fin de agregar mas contenido al sistema y probar su funcionamiento', '1aGNC6YgnBzIUdX7fMZPSCRUMstudy-SBOK-Guide-3rd-edition-Spanish.pdf', 0),
(37, 'Libro de prueba 2 editado', 2, 'Primera edición', '2000-04-30', 3, 1, 'Resumen del libro agregado por un colaborador editado 2', 'nsex7hBYcQXmwNIEqk81normas para elaborar informe pasantías.pdf', 1),
(38, 'Libro de prueba 1', 3, 'Segunda edición', '2000-04-22', 10, 2, 'resumen del segundo libro agregado por un colaborador', 'TO4jCPbzshy8riZSXEcNPlanilla Evaluación Tutor Empresarial firmada.pdf', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro_autor`
--

CREATE TABLE `libro_autor` (
  `libro_id` int(10) NOT NULL,
  `autor_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `libro_autor`
--

INSERT INTO `libro_autor` (`libro_id`, `autor_id`) VALUES
(32, 91),
(32, 92),
(33, 82),
(34, 47),
(34, 48),
(35, 65),
(36, 50),
(36, 51),
(36, 52),
(37, 73),
(37, 74),
(38, 75);

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
(12, 'Ediciones Obelisco', 1),
(13, 'Editorial de prueba', 1),
(14, 'Editorial de prueba 2', 1),
(15, 'Editorial de prueba 3', 1),
(16, 'Editorial de prueba 4', 1),
(17, 'Editorial de prueba 5', 1),
(19, 'editorial agregada por colaborador', 1);

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
(1, 27397595, 'Otoniel', 'Lopez', '04245274818', 1, 1, 1),
(2, 11111111, 'Juan', 'perez', '04245274818', 2, 2, 1),
(3, 27397595, 'Otoniel', 'López', '04245274818', 6, 3, 1),
(4, 20469887, 'Ana', 'López', '04245274818', 7, 4, 1);

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
(1, 'admin@tesis.com', '$2y$10$St71MD.ufAC1JkSAZ19oxOwxFgJlrLgJm1JxTgEtVC86wITu78S3.', 1, 1),
(2, 'colaborador@tesis.com', '$2y$10$2TSP.XTbPRzlbx6VKAAq0eOrHriL6NzTa2Zh7Q4Hz7M5dB03JQs3S', 2, 1),
(3, 'persona@tesis.com', '$2y$10$LzUZsLhSQwUiwHi0G5neW.EEvybb3t8P00vv0bSGbS4ogxcEkWEoO', 3, 1),
(4, 'analopez@tesis.com', '$2y$10$JzupBl5TnZ8pXEeOR3UKKujxlwlu.3yVIZ8KG81wrw6NM75PgaZF6', 2, 1);

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
-- Volcado de datos para la tabla `vista_libro`
--

INSERT INTO `vista_libro` (`id`, `usuario_id`, `libro_id`, `fecha`) VALUES
(2, 3, 34, '0000-00-00 00:00:00'),
(3, 3, 35, '2021-06-20 17:25:01'),
(5, 2, 33, '2021-06-21 04:19:32'),
(6, 2, 34, '2021-06-21 04:21:05'),
(7, 3, 33, '2021-06-26 23:18:04'),
(8, 3, 33, '2021-06-26 23:18:25'),
(9, 3, 33, '2021-06-27 22:09:39'),
(10, 3, 33, '2021-06-27 22:10:01'),
(11, 3, 33, '2021-06-27 22:10:25'),
(12, 3, 34, '2021-06-27 22:13:58'),
(13, 2, 37, '2021-06-28 00:04:35'),
(14, 2, 37, '2021-06-28 00:04:55'),
(15, 2, 35, '2021-06-28 03:07:49'),
(16, 2, 35, '2021-06-28 21:50:51');

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de la tabla `bitacora_libro`
--
ALTER TABLE `bitacora_libro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `bitacora_persona`
--
ALTER TABLE `bitacora_persona`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calificacion_libro`
--
ALTER TABLE `calificacion_libro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `colaborador_libro`
--
ALTER TABLE `colaborador_libro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `descarga_libro`
--
ALTER TABLE `descarga_libro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `persona_tipo`
--
ALTER TABLE `persona_tipo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `vista_libro`
--
ALTER TABLE `vista_libro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
