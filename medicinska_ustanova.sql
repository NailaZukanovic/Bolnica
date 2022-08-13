-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2022 at 07:39 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medicinska_ustanova`
--

-- --------------------------------------------------------

--
-- Table structure for table `izabrani_lekar`
--

CREATE TABLE `izabrani_lekar` (
  `id` int(11) NOT NULL,
  `id_lekar` int(9) NOT NULL,
  `id_pacijent` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `izabrani_lekar`
--

INSERT INTO `izabrani_lekar` (`id`, `id_lekar`, `id_pacijent`) VALUES
(2, 69, 70),
(3, 61, 64);

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `id` int(11) NOT NULL,
  `ime` varchar(30) NOT NULL,
  `prezime` varchar(30) NOT NULL,
  `korime` varchar(30) NOT NULL,
  `lozinka` varchar(30) NOT NULL,
  `pol` enum('musko','zensko') NOT NULL,
  `mesto_rodjenja` varchar(30) NOT NULL,
  `drzava_rodjenja` varchar(30) NOT NULL,
  `datum_rodjenja` date NOT NULL,
  `jmbg` int(13) NOT NULL,
  `telefon` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `slika` varchar(30) NOT NULL,
  `status` enum('pacijent','lekar','admin') NOT NULL,
  `status_odobrenja` enum('cekanje','odobren') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `ime`, `prezime`, `korime`, `lozinka`, `pol`, `mesto_rodjenja`, `drzava_rodjenja`, `datum_rodjenja`, `jmbg`, `telefon`, `email`, `slika`, `status`, `status_odobrenja`) VALUES
(58, 'admin1', 'admin1', 'admin1', 'admin1', 'musko', 'mesto', 'srbija', '1997-01-01', 111, '23423434', 'a@gmail.com', 'a.jpg', 'admin', 'odobren'),
(61, 'lekar3', 'lekar3', 'lekar3', 'lekar33', 'musko', 'mesto', 'srbija', '1997-01-01', 111, '23423434', 'd@gmail.com', 'a.jpg', 'lekar', 'odobren'),
(62, 'lekar4', 'lekar4', 'lekar4', 'lekar4', 'musko', 'mesto', 'srbija', '1997-01-01', 111, '23423434', 'd@gmail.com', 'a.jpg', 'lekar', 'odobren'),
(63, 'lekar5', 'lekar5', 'lekar5', 'lekar5', 'musko', 'mesto', 'srbija', '1997-01-01', 111, '23423434', 'd@gmail.com', 'a.jpg', 'lekar', 'cekanje'),
(64, 'pacijent1', 'pacijent1', 'pacijent1', 'pacijent1', 'musko', 'mesto', 'srbija', '1997-01-01', 111, '23423434', 'y@gmail.com', 'a.jpg', 'pacijent', 'odobren'),
(65, 'pacijent2', 'pacijent2', 'pacijent2', 'pacijent2', 'musko', 'mesto', 'srbija', '1997-01-01', 111, '23423434', 'h@gmail.com', 'a.jpg', 'pacijent', 'odobren'),
(66, 'pacijent3', 'pacijent3', 'pacijent3', 'pacijent3', 'musko', 'mesto', 'srbija', '1997-01-01', 111, '23423434', 'g@gmail.com', 'a.jpg', 'pacijent', 'odobren'),
(67, 'pacijent4', 'pacijent4', 'pacijent4', 'pacijent4', 'musko', 'mesto', 'srbija', '1997-01-01', 111, '23423434', 'g4@gmail.com', 'a.jpg', 'pacijent', 'cekanje'),
(68, 'pacijent5', 'pacijent5', 'pacijent5', 'pacijent5', 'musko', 'mesto', 'srbija', '1997-01-01', 111, '23423434', 'g5@gmail.com', 'a.jpg', 'pacijent', 'cekanje'),
(69, 'testLekar1', 'testLekar1', 'testLekar12773', 'testLekar1', 'musko', 'testLekar1', 'srbija', '2022-08-09', 2147483647, '0603655665', 'nemanja7popovic@gmail.com', 'zadruga.png', 'lekar', 'odobren'),
(70, 'testPacijent1', 'testPacijent1', 'testPacijent18436', 'testPacijent13', 'musko', 'mesto asd', 'srbija', '2022-08-09', 2147483647, '060 3655665', 'nemanja7popovic@gmail.com', 'zadruga.png', 'pacijent', 'odobren');

-- --------------------------------------------------------

--
-- Table structure for table `novosti`
--

CREATE TABLE `novosti` (
  `id` int(11) NOT NULL,
  `tip` enum('obavestenje','preporuka','zanimljivost') NOT NULL,
  `naslov` varchar(50) NOT NULL,
  `tekst` varchar(300) NOT NULL,
  `datum_objave` datetime NOT NULL DEFAULT current_timestamp(),
  `lekar_id` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `novosti`
--

INSERT INTO `novosti` (`id`, `tip`, `naslov`, `tekst`, `datum_objave`, `lekar_id`) VALUES
(1, 'obavestenje', 'obavestenje 1', 'e 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containin', '2022-08-10 05:55:53', 61),
(3, 'obavestenje', 'obavestenje 3', 'e 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containin', '2022-08-10 05:56:13', 61),
(4, 'preporuka', 'preporuka 1', 'e 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containin', '2022-08-10 05:56:21', 61),
(5, 'preporuka', 'preporuka 2', 'e 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containin', '2022-08-10 05:56:23', 61),
(6, 'preporuka', 'preporuka 3', 'e 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containin', '2022-08-10 05:56:26', 61),
(7, 'zanimljivost', 'zanimljivost 1', 'e 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containin', '2022-08-10 05:56:36', 61),
(8, 'zanimljivost', 'zanimljivost 2', 'e 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containin', '2022-08-10 05:56:40', 61),
(9, 'zanimljivost', 'zanimljivost 3', 'e 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containin', '2022-08-10 05:56:43', 61),
(10, 'preporuka', 'admin objava', 'admin objava', '2022-08-11 23:03:59', 58);

-- --------------------------------------------------------

--
-- Table structure for table `poruke`
--

CREATE TABLE `poruke` (
  `id` int(11) NOT NULL,
  `id_lekar` int(9) DEFAULT NULL,
  `id_pacijent` int(9) DEFAULT NULL,
  `poslao` enum('lekar','pacijent') NOT NULL,
  `vreme` datetime NOT NULL DEFAULT current_timestamp(),
  `poruka` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `poruke`
--

INSERT INTO `poruke` (`id`, `id_lekar`, `id_pacijent`, `poslao`, `vreme`, `poruka`) VALUES
(1, 61, 64, 'pacijent', '2022-08-10 03:29:32', 'test1'),
(2, 61, 64, 'lekar', '2022-08-10 03:30:05', 'test 2'),
(3, 61, 64, 'lekar', '2022-08-10 03:30:08', 'test 3'),
(4, 61, 64, 'pacijent', '2022-08-10 03:36:07', 'test 7'),
(10, 61, 64, 'pacijent', '2022-08-10 03:46:33', 'asd'),
(11, 61, 64, 'pacijent', '2022-08-10 06:05:37', 'a1'),
(14, 61, 64, 'lekar', '2022-08-10 06:08:09', 'b1'),
(15, 61, 64, 'pacijent', '2022-08-10 06:08:16', 'a2'),
(16, 61, 64, 'lekar', '2022-08-10 06:08:31', 'b2'),
(17, 61, 64, 'pacijent', '2022-08-10 06:08:36', 'a3'),
(18, 61, 64, 'lekar', '2022-08-10 06:08:41', 'b3');

-- --------------------------------------------------------

--
-- Table structure for table `promena_lekara`
--

CREATE TABLE `promena_lekara` (
  `id` int(11) NOT NULL,
  `id_pacijent` int(9) NOT NULL,
  `id_novi_lekar` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `slike`
--

CREATE TABLE `slike` (
  `id` int(11) NOT NULL,
  `ime` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slike`
--

INSERT INTO `slike` (`id`, `ime`) VALUES
(1, 'd1.jpg'),
(3, 'd3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `stare_lozinke`
--

CREATE TABLE `stare_lozinke` (
  `id` int(11) NOT NULL,
  `korime` varchar(30) NOT NULL,
  `lozinka` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stare_lozinke`
--

INSERT INTO `stare_lozinke` (`id`, `korime`, `lozinka`) VALUES
(1, 'testLekar12773', 'testLekar1'),
(2, 'testPacijent18436', 'testPacijent1'),
(8, 'testPacijent18436', 'testPacijent13'),
(9, 'lekar3', 'lekar33');

-- --------------------------------------------------------

--
-- Table structure for table `stomatoloske_usluge`
--

CREATE TABLE `stomatoloske_usluge` (
  `id` int(11) NOT NULL,
  `naziv` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stomatoloske_usluge`
--

INSERT INTO `stomatoloske_usluge` (`id`, `naziv`) VALUES
(1, 'pregled'),
(2, 'popravka zuba'),
(3, 'vadjenje zuba'),
(4, 'izbeljivanje zuba'),
(5, 'hirurska intervencija'),
(6, 'snimak'),
(7, 'zatvaranje lecenja'),
(8, 'kontrola');

-- --------------------------------------------------------

--
-- Table structure for table `termini`
--

CREATE TABLE `termini` (
  `id` int(11) NOT NULL,
  `id_usluga` int(9) NOT NULL,
  `id_pacijent` int(9) NOT NULL,
  `datum` date NOT NULL,
  `dodatni_podaci` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `termini`
--

INSERT INTO `termini` (`id`, `id_usluga`, `id_pacijent`, `datum`, `dodatni_podaci`) VALUES
(2, 2, 64, '2022-08-12', NULL),
(3, 1, 64, '2022-08-19', NULL),
(4, 5, 64, '2022-09-01', NULL),
(5, 2, 64, '2022-08-20', 'asd'),
(8, 2, 64, '2022-08-27', 'test'),
(9, 7, 64, '2022-08-30', 'pacijent zavrsio lecenje');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `izabrani_lekar`
--
ALTER TABLE `izabrani_lekar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_pacijent` (`id_pacijent`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `novosti`
--
ALTER TABLE `novosti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poruke`
--
ALTER TABLE `poruke`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promena_lekara`
--
ALTER TABLE `promena_lekara`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slike`
--
ALTER TABLE `slike`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stare_lozinke`
--
ALTER TABLE `stare_lozinke`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stomatoloske_usluge`
--
ALTER TABLE `stomatoloske_usluge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `termini`
--
ALTER TABLE `termini`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `izabrani_lekar`
--
ALTER TABLE `izabrani_lekar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `novosti`
--
ALTER TABLE `novosti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `poruke`
--
ALTER TABLE `poruke`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `promena_lekara`
--
ALTER TABLE `promena_lekara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `slike`
--
ALTER TABLE `slike`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stare_lozinke`
--
ALTER TABLE `stare_lozinke`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stomatoloske_usluge`
--
ALTER TABLE `stomatoloske_usluge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `termini`
--
ALTER TABLE `termini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
