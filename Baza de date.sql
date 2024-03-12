-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 22, 2023 at 10:59 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proiect1`
--

-- --------------------------------------------------------

--
-- Table structure for table `bilete`
--

DROP TABLE IF EXISTS `bilete`;
CREATE TABLE IF NOT EXISTS `bilete` (
  `id_ble` int NOT NULL AUTO_INCREMENT,
  `Valabilitate` varchar(255) NOT NULL,
  `Pret` decimal(10,2) NOT NULL,
  `Tip_bilet` varchar(255) NOT NULL,
  `id_eve` int NOT NULL,
  PRIMARY KEY (`id_ble`),
  KEY `ID_Eveniment` (`id_eve`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `colaboratori`
--

DROP TABLE IF EXISTS `colaboratori`;
CREATE TABLE IF NOT EXISTS `colaboratori` (
  `id_cli` int NOT NULL AUTO_INCREMENT,
  `Nume_colaborator` varchar(255) NOT NULL,
  `Contact` varchar(255) NOT NULL,
  `Adresa` varchar(255) DEFAULT NULL,
  `Tip_colaborator` varchar(255) DEFAULT NULL,
  `Suma` decimal(10,2) DEFAULT NULL,
  `Premii` varchar(255) DEFAULT NULL,
  `id_eve` int NOT NULL,
  PRIMARY KEY (`id_cli`),
  KEY `ID_Eveniment` (`id_eve`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `colaboratori`
--

INSERT INTO `colaboratori` (`id_cli`, `Nume_colaborator`, `Contact`, `Adresa`, `Tip_colaborator`, `Suma`, `Premii`, `id_eve`) VALUES
(8, 'Mercedes', 'contact@mercedes.com', 'Stuttgart, Germany', NULL, NULL, NULL, 10),
(9, 'Mastercard', 'contact@mastercard.com', 'Purchase, Harrison, New York, United States', NULL, NULL, NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `evenimente`
--

DROP TABLE IF EXISTS `evenimente`;
CREATE TABLE IF NOT EXISTS `evenimente` (
  `id_eve` int NOT NULL AUTO_INCREMENT,
  `Nume_Organizator` varchar(255) NOT NULL,
  `telefon_organizator` varchar(255) NOT NULL,
  `email_organizator` varchar(255) NOT NULL,
  `Denumire_Eveniment` varchar(255) NOT NULL,
  `Data_incepere` date NOT NULL,
  `Data_sfarsit` date NOT NULL,
  `Descriere` varchar(255) DEFAULT NULL,
  `id_lci` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_eve`),
  KEY `id_lci` (`id_lci`),
  KEY `id` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `evenimente`
--

INSERT INTO `evenimente` (`id_eve`, `Nume_Organizator`, `telefon_organizator`, `email_organizator`, `Denumire_Eveniment`, `Data_incepere`, `Data_sfarsit`, `Descriere`, `id_lci`, `id_user`) VALUES
(10, 'Alin Cret', '0711111111', 'alincret02@gmail.com', 'Worlds2023', '2023-11-01', '2023-11-08', 'Ceva', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `locatii`
--

DROP TABLE IF EXISTS `locatii`;
CREATE TABLE IF NOT EXISTS `locatii` (
  `id_lci` int NOT NULL AUTO_INCREMENT,
  `strada` varchar(30) NOT NULL,
  `numar` varchar(6) NOT NULL,
  `oras` varchar(30) NOT NULL,
  `judet` varchar(30) NOT NULL,
  `capacitate_maxima` int NOT NULL,
  `denumire` varchar(100) NOT NULL,
  PRIMARY KEY (`id_lci`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `locatii`
--

INSERT INTO `locatii` (`id_lci`, `strada`, `numar`, `oras`, `judet`, `capacitate_maxima`, `denumire`) VALUES
(1, 'Piata Lucian Blaga', '1-3', 'Cluj-Napoca', 'Cluj', 0, 'Casa de Cultura a Studentilor'),
(2, 'Str. Tiberiu Popoviciu', '2-4', 'Cluj-Napoca', 'Cluj', 0, 'Centrul Regional de Excelență pentru Industrii Creative'),
(3, 'Bulevardul Eroilor', '51', 'Cluj-Napoca', 'Cluj', 0, 'Cinema Victoria');

-- --------------------------------------------------------

--
-- Table structure for table `participanti`
--

DROP TABLE IF EXISTS `participanti`;
CREATE TABLE IF NOT EXISTS `participanti` (
  `id_pti` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nume` varchar(20) NOT NULL,
  `prenume` varchar(35) NOT NULL,
  `email` varchar(30) NOT NULL,
  `telefon` char(10) NOT NULL,
  PRIMARY KEY (`id_pti`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `participanti`
--

INSERT INTO `participanti` (`id_pti`, `username`, `password`, `nume`, `prenume`, `email`, `telefon`) VALUES
(5, 'client', '$2y$10$kCGInZlfvSQpmGaS49xQFekeLLsqxNILJTAr01yGqQiP/Vmi.hT4e', 'Cret', 'Alin', 'cretz_alin@yahoo.com', '0712345678');

-- --------------------------------------------------------

--
-- Table structure for table `speakeri`
--

DROP TABLE IF EXISTS `speakeri`;
CREATE TABLE IF NOT EXISTS `speakeri` (
  `id_ski` int NOT NULL AUTO_INCREMENT,
  `Nume_speaker` varchar(255) NOT NULL,
  `Prenume_speaker` varchar(255) NOT NULL,
  `Email_speaker` varchar(255) NOT NULL,
  `Nr_telefon_speaker` varchar(255) DEFAULT NULL,
  `id_eve` int NOT NULL,
  PRIMARY KEY (`id_ski`),
  KEY `ID_Eveniment` (`id_eve`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `speakeri`
--

INSERT INTO `speakeri` (`id_ski`, `Nume_speaker`, `Prenume_speaker`, `Email_speaker`, `Nr_telefon_speaker`, `id_eve`) VALUES
(15, 'Eefje', 'Depoortere', 'alincret02@gmail.com', '0712345679', 10),
(14, 'Caster', 'Jun', 'alincret02@gmail.com', '0712345678', 10);

-- --------------------------------------------------------

--
-- Table structure for table `useri`
--

DROP TABLE IF EXISTS `useri`;
CREATE TABLE IF NOT EXISTS `useri` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `useri`
--

INSERT INTO `useri` (`id_user`, `Username`, `Password`, `Email`) VALUES
(1, 'Al1nutz', '$2y$10$zecoyyJgJI1hjj4OaihBKuOfnU6HBRmCTnWX/UXE/XQ7eUz3lwvo.', 'alincret02@gmail.com'),
(2, 'Tudor', '$2y$10$3tY5Un3I9nSMwoHBgJDxTu.yzSNW3WsEItAwwuJQfLWkQSlUvNxI6', 'coblistudor@gmail.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
