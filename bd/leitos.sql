-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 27-Jun-2020 às 21:26
-- Versão do servidor: 5.7.26
-- versão do PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leitos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_codigos`
--

DROP TABLE IF EXISTS `tb_codigos`;
CREATE TABLE IF NOT EXISTS `tb_codigos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_leitos`
--

DROP TABLE IF EXISTS `tb_leitos`;
CREATE TABLE IF NOT EXISTS `tb_leitos` (
  `cod_paciente` int(11) NOT NULL,
  `nome_paciente` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idade_paciente` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `patologia_paciente` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `uti_paciente` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enfermeiro_paciente` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quarto_paciente` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  PRIMARY KEY (`cod_paciente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_leitos`
--

INSERT INTO `tb_leitos` (`cod_paciente`, `nome_paciente`, `idade_paciente`, `patologia_paciente`, `uti_paciente`, `enfermeiro_paciente`, `quarto_paciente`, `data_cadastro`) VALUES
(1, 'João', '17', 'Câncer', 'UTI de São Paulo', 'Dr. Rafael', '504', '2020-06-18');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_login`
--

DROP TABLE IF EXISTS `tb_login`;
CREATE TABLE IF NOT EXISTS `tb_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_login`
--

INSERT INTO `tb_login` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'Gustavo', 'gustavoaqm11@gmail.com', 'gustavo123');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
