-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2019 at 09:14 PM
-- Server version: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.2.17-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webtech_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `body`
--

CREATE TABLE `body` (
  `id` int(10) NOT NULL,
  `id_student` varchar(10) NOT NULL,
  `zapocet` int(11) DEFAULT NULL,
  `skuska_rt` int(11) DEFAULT NULL,
  `skuska_ot` int(11) DEFAULT NULL,
  `spolu` int(11) DEFAULT NULL,
  `znamka` varchar(2) DEFAULT NULL,
  `rok` varchar(10) NOT NULL,
  `id_predmet` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `body`
--

INSERT INTO `body` (`id`, `id_student`, `zapocet`, `skuska_rt`, `skuska_ot`, `spolu`, `znamka`, `rok`, `id_predmet`) VALUES
(98285, '86251', 22, 40, 42, 64, 'E', '2017/2018', 9),
(98286, '84581', 12, 35, 62, 74, 'C', '2017/2018', 9),
(98287, '82898', 22, 80, NULL, 100, 'A', '2017/2018', 9),
(98289, '86179', 42, 35, 42, 87, 'B', '2018/2019', 10),
(98290, '82350', 50, 50, NULL, 100, 'A', '2018/2019', 10),
(98291, '87512', 41, 12, 40, 81, 'B', '2018/2019', 10),
(98292, '98256', 22, 4, 15, 17, 'FX', '2018/2019', 10),
(98306, '86251', 22, 40, 42, 64, 'E', '2012/2013', 14),
(98307, '84581', 12, 35, 62, 74, 'C', '2012/2013', 14),
(98308, '82898', 22, 80, NULL, 100, 'A', '2012/2013', 14),
(98309, '7', 33, 25, 42, 72, 'D', '2012/2013', 14),
(98310, '12321', 50, 50, NULL, 100, 'A', '2012/2013', 14),
(98313, '7', 33, 25, 42, 72, 'D', '2016/2017', 9),
(98314, '12321', 50, 50, NULL, 100, 'A', '2016/2017', 9),
(98315, '96521', 32, 25, 44, 72, 'D', '2016/2017', 9),
(98316, '96521', 32, 25, 44, 72, 'D', '2012/2013', 14),
(98317, '8', 50, 50, NULL, 100, 'A', '2017/2018', 9);

-- --------------------------------------------------------

--
-- Table structure for table `mails`
--

CREATE TABLE `mails` (
  `id` int(11) NOT NULL,
  `datumOdoslania` date NOT NULL,
  `menoStudenta` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `nazovSpravy` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mails`
--

INSERT INTO `mails` (`id`, `datumOdoslania`, `menoStudenta`, `nazovSpravy`) VALUES
(3, '2019-05-20', 'Priezvisko1 Meno1', 'blabla'),
(4, '2019-05-20', 'Priezvisko2 Meno2', 'blabla'),
(5, '2019-05-20', 'Priezvisko1 Meno1', 'Pristupove udaje'),
(6, '2019-05-20', 'Priezvisko2 Meno2', 'Pristupove udaje'),
(7, '2019-05-20', 'Priezvisko1 Meno1', 'Pristupove udaje'),
(8, '2019-05-20', 'Priezvisko2 Meno2', 'Pristupove udaje'),
(9, '2019-05-20', 'Priezvisko1 Meno1', 'Nazov'),
(10, '2019-05-20', 'Priezvisko2 Meno2', 'Nazov');

-- --------------------------------------------------------

--
-- Table structure for table `predmet`
--

CREATE TABLE `predmet` (
  `id` int(11) NOT NULL,
  `nazov` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `rok` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `predmet`
--

INSERT INTO `predmet` (`id`, `nazov`, `rok`) VALUES
(3, 'lll', 'das'),
(8, 'WEBTE', '2018/2019');

-- --------------------------------------------------------

--
-- Table structure for table `Predmety`
--

CREATE TABLE `Predmety` (
  `id` int(11) NOT NULL,
  `nazov` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Predmety`
--

INSERT INTO `Predmety` (`id`, `nazov`) VALUES
(9, 'WEBTE1'),
(10, 'WEBTE2'),
(14, 'MAT2');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `meno` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `heslo` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `type_of_user` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `meno`, `email`, `heslo`, `type_of_user`) VALUES
(1, 'admin1', 'admin1@stuba.sk', '$2y$10$w3qEqxjx7RSkrbR8G0zc4egfiqh9QZEbCl3JBjx.BMqBRYFpOnaoq', 'admin'),
(2, 'admin2', 'admin2@stuba.sk', '$2y$10$548lGnCDUwtXqbXi.W7GQOcdcNXPfBwkosorTVM22.Z0dPOXcJWgG', 'admin'),
(3, 'admin3', 'admin3@stuba.sk', '$2y$10$s.cD0zayvQxUKWweUDavi.Gd7n8Es0RRgChWWXf/tdC0p7Zttda.y', 'admin'),
(4, 'student1', 'student1@stuba.sk', '$2y$10$9pPRkWeALPoKTcpGA/4wuOe6aW04Iryoi4HpQkpZj3lYmxCDrH/g.', 'student'),
(5, 'xklementova', 'xklementova@stuba.sk', NULL, 'student'),
(6, 'xhricka', 'xhricka@stuba.sk', NULL, 'student'),
(12325, 'Michal Mrkvicka', 'xmoravek@stuba.sk', '$2y$10$feWPcuiQmTx8G0L.USvGWedXMwfLtQyW3fU9AF1JGLVBGvW08YAJW', 'admin'),
(12326, 'Michal Mrkvicka', 'xmrkvicka@stuba.sk', '$2y$10$K.2.UK1ctJvhFO/Dzt.RP.pPvvQSguFQMWCC27vRgjZh.EvwVSMVG', 'student'),
(12327, 'Matus Makovicka', 'xmakovicka@stuba.sk', '$2y$10$/hAWd8Aa7DEPjCcRG99YNu.podKZMCrSAsFVGNJuV1/DxbrHD0pGC', 'student'),
(12328, 'Dusan Xmlko', 'xmlko@stuba.sk', '$2y$10$G8q9Fj5LPk.B2vJw55M4uOT61vWsapdmLEKMuUW5AObNwcEBHgn/K', 'student'),
(12329, 'Matus Marko', 'xmarko@stuba.sk', '$2y$10$skurkGFYAX4OxQu3zly8Xu2OEkhPxl7MJPpuUd3qkIoIy51msu7b2', 'student'),
(12330, 'Dusan Balko', 'xbalko@stuba.sk', '$2y$10$S2LPbUa1nheItQVCxjU91uFjjWThv4gBt3Jd/mldDvm5852Bdng2S', 'student'),
(12331, 'Juro Prdka', 'xprdkam@stuba.sk', '$2y$10$dD8HjcNGSPSQY1KLMjwsyu3ruT3BGUDOtsQZN0GUa9m2P5bPGrVU.', 'student'),
(12332, 'Fero Riezlieng', 'xriezling@stuba.sk', '$2y$10$mhnRQ04DIIBRPlHz8k8hjO4ATVUH5PpPPEp66ul4QVj.8HokpG7xa', 'student'),
(12333, 'Juro Mnauko', 'xprdkam@stuba.sk', '', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `studenti`
--

CREATE TABLE `studenti` (
  `id` varchar(10) NOT NULL,
  `meno` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `studenti`
--

INSERT INTO `studenti` (`id`, `meno`) VALUES
('12321', 'Adrian Vallovics'),
('7', 'VladimÃ­r VinkoviÄ'),
('8', 'Ricardo Milos'),
('81581', 'Robert KazÃ­k'),
('82350', 'Jozef Mak'),
('82898', 'Marek HrÃ­bik'),
('84581', 'Jozef Mak'),
('86179', 'DÃ¡vid ZakhariÃ¡s'),
('86241', 'RenÃ© Balogh'),
('86251', 'RenÃ© Balogh'),
('87512', 'Marek NovÃ¡k'),
('96521', 'Filip Konc'),
('98256', 'Oliver GÃ¡l');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `cislo` int(11) NOT NULL,
  `body` int(11) NOT NULL DEFAULT '0',
  `suhlas` tinyint(4) NOT NULL DEFAULT '0',
  `id_predmet` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `cislo`, `body`, `suhlas`, `id_predmet`) VALUES
(19, 1, 50, 0, 8),
(20, 2, 0, 0, 8),
(21, 3, 36, 0, 8);

-- --------------------------------------------------------

--
-- Table structure for table `zaznam`
--

CREATE TABLE `zaznam` (
  `id` int(11) NOT NULL,
  `id_predmet` int(11) NOT NULL,
  `id_team` int(11) NOT NULL,
  `id_student` int(11) NOT NULL,
  `suhlas_kap` tinyint(4) DEFAULT '0',
  `suhlas_stud` tinyint(4) DEFAULT '0',
  `body_stud` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `zaznam`
--

INSERT INTO `zaznam` (`id`, `id_predmet`, `id_team`, `id_student`, `suhlas_kap`, `suhlas_stud`, `body_stud`) VALUES
(85, 8, 21, 5, 1, NULL, 4),
(86, 8, 21, 6, NULL, NULL, NULL),
(87, 8, 19, 12325, 0, 0, 0),
(88, 8, 19, 12326, 0, 0, 0),
(89, 8, 19, 12327, 0, 0, 0),
(90, 8, 19, 12328, 0, 0, 0),
(91, 8, 20, 12329, 0, 0, 0),
(92, 8, 20, 12330, 0, 0, 0),
(93, 8, 20, 12331, 0, 0, 0),
(94, 8, 20, 12333, 0, 0, 0),
(95, 8, 20, 12332, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `body`
--
ALTER TABLE `body`
  ADD PRIMARY KEY (`id`),
  ADD KEY `predmet_fk` (`id_predmet`),
  ADD KEY `student_fk` (`id_student`);

--
-- Indexes for table `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `predmet`
--
ALTER TABLE `predmet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Predmety`
--
ALTER TABLE `Predmety`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studenti`
--
ALTER TABLE `studenti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zaznam`
--
ALTER TABLE `zaznam`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `body`
--
ALTER TABLE `body`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98318;
--
-- AUTO_INCREMENT for table `mails`
--
ALTER TABLE `mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `predmet`
--
ALTER TABLE `predmet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `Predmety`
--
ALTER TABLE `Predmety`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `zaznam`
--
ALTER TABLE `zaznam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `body`
--
ALTER TABLE `body`
  ADD CONSTRAINT `predmet_fk` FOREIGN KEY (`id_predmet`) REFERENCES `Predmety` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_fk` FOREIGN KEY (`id_student`) REFERENCES `studenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
