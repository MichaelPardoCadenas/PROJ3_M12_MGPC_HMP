-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2025 a las 16:18:12
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rich_or_bust`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `answer_a` varchar(255) NOT NULL,
  `answer_b` varchar(255) NOT NULL,
  `answer_c` varchar(255) NOT NULL,
  `answer_d` varchar(255) NOT NULL,
  `correct_answer` enum('A','B','C','D') NOT NULL,
  `difficulty` tinyint(4) NOT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `questions`
--

INSERT INTO `questions` (`id`, `question_text`, `answer_a`, `answer_b`, `answer_c`, `answer_d`, `correct_answer`, `difficulty`, `category`) VALUES
(1, '¿Cuál es la capital de España?', 'Madrid', 'Barcelona', 'Sevilla', 'Valencia', 'A', 1, 'Geografía'),
(2, '¿Cuántos días tiene una semana?', '5', '6', '7', '8', 'C', 1, 'Cultura General'),
(3, '¿Quién escribió \"Cien años de soledad\"?', 'Gabriel García Márquez', 'Pablo Neruda', 'Mario Vargas Llosa', 'Julio Cortázar', 'A', 2, 'Literatura'),
(4, '¿En qué año se firmó la Declaración de Independencia de EE.UU.?', '1776', '1789', '1804', '1754', 'A', 2, 'Historia'),
(5, '¿Cuál es el elemento químico con número atómico 79?', 'Plata', 'Oro', 'Platino', 'Mercurio', 'B', 3, 'Ciencia'),
(6, '¿Qué matemático es conocido como el padre del álgebra?', 'Pitágoras', 'Euclides', 'Al-Juarismi', 'Arquímedes', 'C', 3, 'Matemáticas'),
(7, '¿Cuál es la capital de Francia?', 'Madrid', 'París', 'Roma', 'Londres', 'B', 1, 'Geografía'),
(9, '¿Qué color resulta de mezclar azul y amarillo?', 'Verde', 'Rojo', 'Naranja', 'Negro', 'A', 1, 'Arte'),
(10, '¿Qué número viene después del 4?', '6', '5', '3', '7', 'B', 1, 'Matemáticas'),
(11, '¿Cuál es el océano más grande?', 'Atlántico', 'Índico', 'Ártico', 'Pacífico', 'D', 1, 'Geografía'),
(12, '¿Qué planeta es el tercero desde el sol?', 'Venus', 'Marte', 'Tierra', 'Júpiter', 'C', 1, 'Ciencia'),
(13, '¿Qué animal hace “miau”?', 'Perro', 'Vaca', 'Gato', 'Caballo', 'C', 1, 'Cultura General'),
(14, '¿Qué fruta es amarilla y curvada?', 'Manzana', 'Banana', 'Pera', 'Naranja', 'B', 1, 'Cultura General'),
(15, '¿Cuántas patas tiene una araña?', '6', '8', '10', '12', 'B', 1, 'Biología'),
(16, '¿Qué instrumento tiene teclas blancas y negras?', 'Guitarra', 'Piano', 'Violín', 'Flauta', 'B', 1, 'Música'),
(18, '¿En qué continente está Egipto?', 'Asia', 'África', 'Europa', 'América', 'B', 2, 'Geografía'),
(19, '¿Cuál es el idioma más hablado en el mundo?', 'Inglés', 'Chino mandarín', 'Español', 'Árabe', 'B', 2, 'Cultura General'),
(20, '¿Qué gas respiramos del aire?', 'Dióxido de carbono', 'Hidrógeno', 'Oxígeno', 'Nitrógeno', 'C', 2, 'Ciencia'),
(21, '¿Cuál es el resultado de 9x8?', '72', '81', '64', '69', 'A', 2, 'Matemáticas'),
(22, '¿Quién pintó la Mona Lisa?', 'Van Gogh', 'Picasso', 'Leonardo da Vinci', 'Rembrandt', 'C', 2, 'Arte'),
(23, '¿Qué país tiene forma de bota?', 'España', 'Italia', 'Grecia', 'Alemania', 'B', 2, 'Geografía'),
(24, '¿Qué sistema del cuerpo transporta sangre?', 'Digestivo', 'Nervioso', 'Respiratorio', 'Circulatorio', 'D', 2, 'Biología'),
(25, '¿Qué metal es líquido a temperatura ambiente?', 'Plomo', 'Hierro', 'Mercurio', 'Oro', 'C', 2, 'Ciencia'),
(26, '¿Cuál es el cuarto planeta desde el sol?', 'Tierra', 'Marte', 'Júpiter', 'Saturno', 'B', 2, 'Ciencia'),
(27, '¿En qué año cayó el Imperio Romano de Occidente?', '395', '410', '476', '500', 'C', 3, 'Historia'),
(28, '¿Quién desarrolló la teoría de la relatividad?', 'Newton', 'Einstein', 'Tesla', 'Galileo', 'B', 3, 'Física'),
(29, '¿Cuál es el símbolo químico del oro?', 'Ag', 'O', 'Au', 'Gd', 'C', 3, 'Química'),
(30, '¿Qué filósofo escribió “La República”?', 'Aristóteles', 'Sócrates', 'Platón', 'Descartes', 'C', 3, 'Filosofía'),
(31, '¿Cuál es la capital de Mongolia?', 'Ulán Bator', 'Bakú', 'Astana', 'Tiflis', 'A', 3, 'Geografía'),
(32, '¿Qué constante representa el número de Avogadro?', '6.022e23', '9.81', '3.14', '1.618', 'A', 3, 'Química'),
(33, '¿Qué pintor es considerado el padre del cubismo?', 'Picasso', 'Miró', 'Dalí', 'Cézanne', 'A', 3, 'Arte'),
(34, '¿Cuál es el idioma oficial de Irán?', 'Árabe', 'Urdu', 'Farsi', 'Hebreo', 'C', 3, 'Cultura General'),
(35, '¿Quién escribió “Crimen y castigo”?', 'Tolstói', 'Pushkin', 'Gogol', 'Dostoyevski', 'D', 3, 'Literatura'),
(36, '¿Cuál es la derivada de ln(x)?', 'x', '1/x', 'x ln(x)', 'ln(x)', 'B', 3, 'Matemáticas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `scores`
--

INSERT INTO `scores` (`id`, `user_id`, `score`, `created_at`) VALUES
(21, 3, 100, '2025-05-14 14:11:22'),
(22, 3, 50, '2025-05-14 15:31:51'),
(23, 7, 100, '2025-05-14 15:34:46'),
(24, 8, 2500, '2025-05-14 15:51:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'yeat666', '$2y$10$nJLn/ZR6NqpG5QQP9yueCuuk.f4ouZVPUE3ZXmZS2Ty9xToeLTH5O', '2025-04-25 19:13:55'),
(2, 'gucciMane', '$2y$10$J9zUtNhZ9ILwvmeezdOu8OXcx.L5zWehH66O1yzAtuOgjj7MXRc2G', '2025-05-06 19:39:01'),
(3, 'michael', '$2y$10$XBBrjSULwrRIontOaqE.bus18WNryWQEpz5QZc9Q7gvuKLU5tQtJ2', '2025-05-07 16:41:51'),
(4, 'hugo', '$2y$10$IRrV3be.TWNqgy8GMCnhzOfB9Pf4hOmKcz/P1mzt80GU.okH2JdlS', '2025-05-07 18:06:23'),
(5, 'luis', '$2y$10$pYEoqVQHDJkk8bBnCFobmOtuLVTP7x8P8JMTL9AdKPREfutGTjiQ.', '2025-05-09 16:38:40'),
(6, 'test', '$2y$10$UOKDg6eBm2u5SqQx1DtLcO1jvzclFu88AREUJRs3LsLm8tkoh4PG6', '2025-05-13 17:44:59'),
(7, 'john', '$2y$10$GK.IqF2SPmNDEEMWLqCeo.5AQQ5QxZiJ0yZdWu3uVYlDtfvneaXYm', '2025-05-14 15:34:12'),
(8, 'joanygabriel', '$2y$10$LTr9OutPjDH8B1etV3S79uSpNfMalsvvv9tzZO5/lClgUE/bkGufi', '2025-05-14 15:46:45');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
