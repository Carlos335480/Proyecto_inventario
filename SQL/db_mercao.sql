-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2026 at 03:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_mercao`
--

-- --------------------------------------------------------

--
-- Table structure for table `compras`
--

CREATE TABLE `compras` (
  `idcompra` varchar(50) NOT NULL,
  `idproducto` varchar(50) DEFAULT NULL,
  `idcomprador` int(11) NOT NULL,
  `idvendedor` int(11) NOT NULL,
  `producto` varchar(150) NOT NULL,
  `comprador` varchar(100) NOT NULL,
  `vendedor` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `domicilio` varchar(255) NOT NULL,
  `tarjeta` varchar(20) DEFAULT NULL,
  `titular` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compras`
--

INSERT INTO `compras` (`idcompra`, `idproducto`, `idcomprador`, `idvendedor`, `producto`, `comprador`, `vendedor`, `precio`, `fecha`, `domicilio`, `tarjeta`, `titular`) VALUES
('69c1f19232130', NULL, 2, 2, 'wdfwe', 'Dan Alexander', 'Dan Alexander', 345.00, '2026-03-24 03:06:10', 'Edificio 1', '23543423', 'dan alexander'),
('69c1f36668d64', NULL, 2, 2, 'sosa y profe', 'Dan Alexander', 'Dan Alexander', 0.00, '2026-03-24 03:13:58', 'Edificio 2', '34235556756', 'sosa lopez');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `idproducto` varchar(50) NOT NULL,
  `idvendedor` int(11) NOT NULL,
  `vendedor` varchar(100) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descripcion` text NOT NULL,
  `fotos` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`idproducto`, `idvendedor`, `vendedor`, `titulo`, `precio`, `descripcion`, `fotos`, `fecha`) VALUES
('69c1eea3c5665', 2, 'Dan Alexander', 'wdfwe', 345.00, 'pptrof descripicon', 'a:1:{i:0;s:22:\"133653658556370962.jpg\";}', '2026-03-24 01:53:39'),
('69c1f33cb73b6', 2, 'Dan Alexander', 'sosa y profe', 0.00, 'regalo foto del profe y el sosa los veo en edificio 2', 'a:1:{i:0;s:9:\"sosa.jpeg\";}', '2026-03-24 02:13:16');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `foto`) VALUES
(1, 'Administrador', 'admin@admin', '12345', NULL),
(2, 'Dan Alexander', 'dan@gmail.com', '12345', NULL),
(69, 'sosa lopez', 'ckrakpower1000@gmail.com', '2143', 0x733a31303a2270657266696c2e706e67223b);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`idcompra`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
