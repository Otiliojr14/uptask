-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 31, 2021 at 12:12 AM
-- Server version: 5.6.34-log
-- PHP Version: 7.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uptask`
--

-- --------------------------------------------------------

--
-- Table structure for table `proyectos`
--

CREATE TABLE `proyectos` (
  `id_proyecto` smallint(6) NOT NULL,
  `nombre_proyecto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proyectos`
--

INSERT INTO `proyectos` (`id_proyecto`, `nombre_proyecto`) VALUES
(1, 'Tienda Virtual'),
(2, 'Servicio Web'),
(3, 'Almacen'),
(4, 'Bodas');

-- --------------------------------------------------------

--
-- Table structure for table `tareas`
--

CREATE TABLE `tareas` (
  `id_tarea` smallint(6) NOT NULL,
  `nombre_tarea` varchar(100) NOT NULL,
  `estado_tarea` tinyint(1) NOT NULL DEFAULT '0',
  `proyecto_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tareas`
--

INSERT INTO `tareas` (`id_tarea`, `nombre_tarea`, `estado_tarea`, `proyecto_id`) VALUES
(2, 'Interfaz Visual', 1, 1),
(6, 'Agregar objetos', 0, 3),
(7, 'Codificación', 1, 1),
(10, 'Pruebas', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(2) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `user_name`, `user_password`) VALUES
(2, 'Dald', '$2y$10$3zSR1SL.KoinSnW3/JjDFuuIEP4Jbau/pUAWwmKzisaFahlfnyrJe'),
(3, 'admin', '$2y$10$tEsL0BoKBBTg8KWqividoOpHQbBwK66oLO0av6xULoZ4kthYO83Gq'),
(4, 'llimebo', '$2y$10$dRX6Wv0nPuEmpEThceeMfu01jEHVrQ1IdHgFiaJfPOb6MUVT1XKPW'),
(5, 'admin', '$2y$10$EImCleE.AEsgPRgmMv4U8usBjyoKxBkpGLt8REPPNIw0aEqsQw0he');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id_proyecto`);

--
-- Indexes for table `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `proyecto_id` (`proyecto_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id_proyecto` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id_tarea` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id_proyecto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
