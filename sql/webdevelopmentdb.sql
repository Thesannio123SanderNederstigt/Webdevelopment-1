-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 15 apr 2024 om 19:57
-- Serverversie: 10.4.14-MariaDB
-- PHP-versie: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webdevelopmentdb`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bingocard`
--

CREATE TABLE `bingocard` (
  `id` varchar(40) NOT NULL,
  `userId` varchar(40) NOT NULL,
  `score` int(10) NOT NULL,
  `size` int(10) NOT NULL,
  `creationDate` varchar(40) NOT NULL,
  `lastAccessedOn` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `bingocard`
--

INSERT INTO `bingocard` (`id`, `userId`, `score`, `size`, `creationDate`, `lastAccessedOn`) VALUES
('212A4C3D-AC4B-4BA4-AC05-F68F4452AC84', '2D2DF76D-2F3C-4BA0-A3DF-9730D7A8F909', 0, 25, '2024-04-15 18:40:07', '2024-04-15 18:40:07'),
('3D7EFEEB-11F9-4E37-91D1-DFF5AA39B7C2', 'CF3FA866-72A4-476A-9935-7B69AB7DA056', 0, 16, '2024-04-15 18:38:25', '2024-04-15 18:38:25'),
('80C9E26B-AFE9-41D8-A1AA-67132AE67D22', '2D2DF76D-2F3C-4BA0-A3DF-9730D7A8F909', 0, 9, '2024-04-15 18:36:41', '2024-04-15 18:36:41'),
('BC1228A4-D5F7-4113-88DC-D754DE7B884F', 'EBF49A86-657B-4E3C-AE79-DD431681ED3B', 0, 9, '2024-04-15 18:41:34', '2024-04-15 18:41:34');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bingocarditem`
--

CREATE TABLE `bingocarditem` (
  `id` int(20) NOT NULL,
  `bingocardId` varchar(40) NOT NULL,
  `cardItemId` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `bingocarditem`
--

INSERT INTO `bingocarditem` (`id`, `bingocardId`, `cardItemId`) VALUES
(1, '80C9E26B-AFE9-41D8-A1AA-67132AE67D22', '7C5FB4C2-6C8B-4598-AF68-999136DA2AF7'),
(2, '80C9E26B-AFE9-41D8-A1AA-67132AE67D22', '108F4D89-0D1D-4B99-93A9-F2532492ADC0'),
(3, '80C9E26B-AFE9-41D8-A1AA-67132AE67D22', 'A96B736F-F0E6-47E9-8C72-EA230535442D'),
(4, '80C9E26B-AFE9-41D8-A1AA-67132AE67D22', '519FB920-52DD-4486-8B73-9E477C895339'),
(5, 'BC1228A4-D5F7-4113-88DC-D754DE7B884F', '7FDDC4A2-690A-4DA7-AFA6-A3C4F2EAD510'),
(6, 'BC1228A4-D5F7-4113-88DC-D754DE7B884F', '67E830D5-D170-459E-98BE-6A9E6C00F1AE'),
(7, 'BC1228A4-D5F7-4113-88DC-D754DE7B884F', '81F3E862-C260-4DA3-BC10-87A12CA49442'),
(8, '3D7EFEEB-11F9-4E37-91D1-DFF5AA39B7C2', 'F2898804-B64B-4978-B0F4-89625B4B3B2A'),
(9, '3D7EFEEB-11F9-4E37-91D1-DFF5AA39B7C2', 'FD549B4B-49CC-4BD2-B6AA-1628876784F6'),
(10, '212A4C3D-AC4B-4BA4-AC05-F68F4452AC84', 'B3E6D7FE-AA0D-4847-B18A-29AF0CC4EA95'),
(11, '212A4C3D-AC4B-4BA4-AC05-F68F4452AC84', '108F4D89-0D1D-4B99-93A9-F2532492ADC0'),
(12, '212A4C3D-AC4B-4BA4-AC05-F68F4452AC84', 'A96B736F-F0E6-47E9-8C72-EA230535442D');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `carditem`
--

CREATE TABLE `carditem` (
  `id` varchar(40) NOT NULL,
  `content` varchar(350) NOT NULL,
  `category` int(10) NOT NULL,
  `points` int(10) NOT NULL,
  `isPremiumItem` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `carditem`
--

INSERT INTO `carditem` (`id`, `content`, `category`, `points`, `isPremiumItem`) VALUES
('108F4D89-0D1D-4B99-93A9-F2532492ADC0', 'Het juiste meetinstrument vergeten om nu eindelijk eens die 90 graden kniehoeken goed te kunnen opmeten (verdorie)', 2, 15, 0),
('519FB920-52DD-4486-8B73-9E477C895339', 'Verhinderde toegangsmogelijkheden bij aankomst en/of vertrek van de sportclub', 4, 10, 0),
('67E830D5-D170-459E-98BE-6A9E6C00F1AE', 'Persoonlijke sportkleding, apparatuur of andere spullen vergeten mee terug te nemen na afloop van een wedstrijd', 0, 5, 0),
('7C5FB4C2-6C8B-4598-AF68-999136DA2AF7', 'De trainer heeft zich verslapen...alweer -_-', 1, 25, 1),
('7FDDC4A2-690A-4DA7-AFA6-A3C4F2EAD510', 'Persoonlijke sportkleding, apparatuur of andere spullen vergeten mee te nemen naar een wedstrijd', 0, 5, 0),
('81F3E862-C260-4DA3-BC10-87A12CA49442', 'Sportapparatuur, kleding of andere spullen vergeten mee terug te nemen na afloop van een training', 0, 5, 0),
('A96B736F-F0E6-47E9-8C72-EA230535442D', 'Keihard door al het verkeer op de baan racen voor een sprintwedstrijdje (aan de kant!!)', 3, 15, 0),
('B3E6D7FE-AA0D-4847-B18A-29AF0CC4EA95', 'Op tijd aanwezig zijn maar te weinig tijd nemen om goed in te rijden en/of warm te worden', 0, 10, 0),
('F2898804-B64B-4978-B0F4-89625B4B3B2A', 'Sportapparatuur, kleding of andere spullen vergeten mee te nemen naar de training', 5, 5, 0),
('FD549B4B-49CC-4BD2-B6AA-1628876784F6', 'Vergeten om jezelf afwezig te melden wanneer je weet dat je niet bij een training of wedstrijd aanwezig zult zijn', 0, 10, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sportsclub`
--

CREATE TABLE `sportsclub` (
  `id` varchar(40) NOT NULL,
  `clubname` varchar(40) NOT NULL,
  `description` varchar(350) NOT NULL,
  `foundedOn` varchar(40) NOT NULL,
  `membersAmount` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `sportsclub`
--

INSERT INTO `sportsclub` (`id`, `clubname`, `description`, `foundedOn`, `membersAmount`) VALUES
('7657F130-41E6-4228-94DA-BECDE110198D', 'IJsbaan en sportcomplex de Meent', 'IJsbaan de Meent in Alkmaar verzorgd in de winter naar eigen zeggen het ultieme wintersportgevoel in de winterzon op een half overdekte baan. Deze baan is al meer dan 50 jaar lang een iconisch symbool voor zowel de stad als de regio.', '1972-01-01 00:00:00', 3250),
('8F8BDDCF-D8FB-4FAB-B305-B82D149569AD', 'IJsclub voor Haarlem en omstreken', 'De IJsclub voor Haarlem en Omstreken is een schaatsvereniging in Haarlem-Noord. Deze club organiseert schaatstrainingen, wedstrijden, marathons en meer van September tot Maart van elk jaar.', '1869-01-22 00:00:00', 3500);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `isPremium` tinyint(1) NOT NULL,
  `cardsAmount` int(10) NOT NULL,
  `sharedCardsAmount` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `isAdmin`, `isPremium`, `cardsAmount`, `sharedCardsAmount`) VALUES
('2D2DF76D-2F3C-4BA0-A3DF-9730D7A8F909', 'SanderN', '$2y$10$DiSHmizwmggIUYEtmhBKl.Po.bjLPHWmT84VlY9d2cPOJKCXWJEnq', 'sandernederstigt@gmail.com', 1, 1, 0, 0),
('CF3FA866-72A4-476A-9935-7B69AB7DA056', 'JohnnyD#1', '$2y$10$iygYvRom20HJ4BzsSkauX.rieniB1Dhnb8.Vmykzh92Td3Gg2PGHG', 'Johndoe@hotmail.com', 0, 1, 0, 0),
('EBF49A86-657B-4E3C-AE79-DD431681ED3B', 'MarySue22', '$2y$10$B0rHlznJTtYFU/h1Y2YHiecfeh9mzUjHrFlHFLh41n8QBLOODbw1q', 'MarySue@hotmail.com', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `usersportsclub`
--

CREATE TABLE `usersportsclub` (
  `id` int(20) NOT NULL,
  `userId` varchar(40) NOT NULL,
  `sportsclubId` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `usersportsclub`
--

INSERT INTO `usersportsclub` (`id`, `userId`, `sportsclubId`) VALUES
(1, '2D2DF76D-2F3C-4BA0-A3DF-9730D7A8F909', '8F8BDDCF-D8FB-4FAB-B305-B82D149569AD'),
(2, 'CF3FA866-72A4-476A-9935-7B69AB7DA056', '8F8BDDCF-D8FB-4FAB-B305-B82D149569AD'),
(3, '2D2DF76D-2F3C-4BA0-A3DF-9730D7A8F909', '7657F130-41E6-4228-94DA-BECDE110198D'),
(4, 'EBF49A86-657B-4E3C-AE79-DD431681ED3B', '7657F130-41E6-4228-94DA-BECDE110198D');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `bingocard`
--
ALTER TABLE `bingocard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bingocard_user_fk` (`userId`);

--
-- Indexen voor tabel `bingocarditem`
--
ALTER TABLE `bingocarditem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bingocardItem_bingocard_fk` (`bingocardId`),
  ADD KEY `bingocardItem_cardItem_fk` (`cardItemId`);

--
-- Indexen voor tabel `carditem`
--
ALTER TABLE `carditem`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `sportsclub`
--
ALTER TABLE `sportsclub`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `usersportsclub`
--
ALTER TABLE `usersportsclub`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userSportsclub_user_fk` (`userId`),
  ADD KEY `userSportsclub_sportsclub_fk` (`sportsclubId`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `bingocarditem`
--
ALTER TABLE `bingocarditem`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `usersportsclub`
--
ALTER TABLE `usersportsclub`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `bingocard`
--
ALTER TABLE `bingocard`
  ADD CONSTRAINT `bingocard_user_fk` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `bingocarditem`
--
ALTER TABLE `bingocarditem`
  ADD CONSTRAINT `bingocardItem_bingocard_fk` FOREIGN KEY (`bingocardId`) REFERENCES `bingocard` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bingocardItem_cardItem_fk` FOREIGN KEY (`cardItemId`) REFERENCES `carditem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `usersportsclub`
--
ALTER TABLE `usersportsclub`
  ADD CONSTRAINT `userSportsclub_sportsclub_fk` FOREIGN KEY (`sportsclubId`) REFERENCES `sportsclub` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userSportsclub_user_fk` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
