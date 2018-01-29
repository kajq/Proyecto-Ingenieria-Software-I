-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-01-2018 a las 05:35:19
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `taskmanager`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones`
--

CREATE TABLE `acciones` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `FK_cod_tarea` int(11) NOT NULL,
  `FK_cod_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_personales`
--

CREATE TABLE `datos_personales` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `FK_correo` varchar(100) NOT NULL,
  `fecha_nac` date NOT NULL,
  `telefono` varchar(8) DEFAULT NULL,
  `empresa` varchar(30) DEFAULT NULL,
  `puesto` varchar(30) DEFAULT NULL,
  `dias_record` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `datos_personales`
--

INSERT INTO `datos_personales` (`codigo`, `nombre`, `FK_correo`, `fecha_nac`, `telefono`, `empresa`, `puesto`, `dias_record`) VALUES
(3, 'Brayner', 'brayner@gmail.com', '2017-10-13', '123', '456', '789', 1),
(4, 'Keilor JimÃ©nez', 'keilorjimenez95@gmail.com', '1995-01-21', '89621230', 'Coocique', 'Informatico', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`codigo`, `descripcion`) VALUES
(1, 'Asignada'),
(2, 'Finalizada'),
(3, 'Cancelada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`codigo`, `descripcion`) VALUES
(1, '¿Nombre mascota favorita?'),
(2, '¿Comida favorita?'),
(3, '¿Número secreto?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `codigo` int(11) NOT NULL,
  `FK_propietario` int(11) NOT NULL,
  `FK_responsable` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `fecha_fin` date NOT NULL,
  `FK_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(15) NOT NULL,
  `FK_cod_pregunta` int(11) NOT NULL,
  `respuesta` varchar(100) NOT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`correo`, `contrasena`, `FK_cod_pregunta`, `respuesta`, `rol`) VALUES
('brayner@gmail.com', '123', 2, 'leche', 2),
('keilorjimenez95@gmail.com', '123456789', 3, '1230', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acciones`
--
ALTER TABLE `acciones`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `FK_cod_tarea` (`FK_cod_tarea`),
  ADD KEY `FK_cod_estado` (`FK_cod_estado`);

--
-- Indices de la tabla `datos_personales`
--
ALTER TABLE `datos_personales`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `FK_correo` (`FK_correo`) USING BTREE;

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `FK_propietario` (`FK_propietario`),
  ADD KEY `FK_responsable` (`FK_responsable`),
  ADD KEY `FK_estado` (`FK_estado`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`correo`),
  ADD KEY `FK_cod_pregunta` (`FK_cod_pregunta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acciones`
--
ALTER TABLE `acciones`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datos_personales`
--
ALTER TABLE `datos_personales`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acciones`
--
ALTER TABLE `acciones`
  ADD CONSTRAINT `acciones_ibfk_1` FOREIGN KEY (`FK_cod_tarea`) REFERENCES `tareas` (`codigo`),
  ADD CONSTRAINT `acciones_ibfk_2` FOREIGN KEY (`FK_cod_estado`) REFERENCES `estados` (`codigo`);

--
-- Filtros para la tabla `datos_personales`
--
ALTER TABLE `datos_personales`
  ADD CONSTRAINT `datos_personales_ibfk_1` FOREIGN KEY (`FK_correo`) REFERENCES `usuarios` (`correo`);

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`FK_propietario`) REFERENCES `datos_personales` (`codigo`),
  ADD CONSTRAINT `tareas_ibfk_2` FOREIGN KEY (`FK_responsable`) REFERENCES `datos_personales` (`codigo`),
  ADD CONSTRAINT `tareas_ibfk_3` FOREIGN KEY (`FK_estado`) REFERENCES `estados` (`codigo`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`FK_cod_pregunta`) REFERENCES `preguntas` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
