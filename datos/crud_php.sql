--
-- Base de datos: `crud_php`
--
CREATE DATABASE IF NOT EXISTS `crud_php` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `crud_php`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(6) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `DNI` varchar(15) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `rol` enum('USER','ADMIN') NOT NULL DEFAULT 'USER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `DNI`, `fecha_nacimiento`, `correo`, `password`, `fecha_creacion`, `rol`) VALUES
(11, 'Rafael', 'López Plana', '12345678Z', '2024-09-18', 'asdasda2@asdasda.es', '1234\r\n', '2025-04-12 16:21:50', 'ADMIN'),
(32, 'Miguel', 'Romero Castro', '90123456I', '1982-07-25', 'miguel.romero@example.com', '', '2025-04-12 16:21:50', 'USER'),
(33, 'Lucía', 'Ruiz Mendoza', '01234567J', '1993-04-12', 'lucia.ruiz2@example.com', '', '2025-04-12 16:21:50', 'USER'),
(34, 'rafa', 'lp', '33334444A', '1980-08-30', 'a@z.es', '$2y$10$9.dqxvfQqTrcO1liS9p7J.qcpWrvMHZ6xJVNdWGyWS/xlAuRAhQ0m', '2025-04-17 09:53:26', 'USER'),
(35, 'Admin', 'Root', '00000000A', '1990-01-01', 'z@a.es', '$2y$10$wjTItm37ig9l.jSp6Z5Vo.7CQpFcZii472yioisGx5ne5HAwtdKmu', '2025-04-20 08:14:53', 'ADMIN'),
(36, 'asd', 'das', '', '1986-07-23', 'a@b.es', '$2y$10$rFDBXrvZlzFbYkm5qdBnyuKj12wW.6TXsqoh2ydM.sJ0T/CeREn/G', '2025-04-21 05:27:41', 'USER');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);
