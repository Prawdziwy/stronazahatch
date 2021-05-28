-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Czas generowania: 28 Maj 2021, 02:17
-- Wersja serwera: 10.5.4-MariaDB-1:10.5.4+maria~stretch
-- Wersja PHP: 7.0.33-0+deb9u8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `zahatch`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `userid` decimal(50,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `invites`
--

CREATE TABLE `invites` (
  `id` int(11) NOT NULL,
  `userid` decimal(50,0) NOT NULL,
  `druzyna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `matches`
--

CREATE TABLE `matches` (
  `id` int(11) NOT NULL,
  `druzyna1` int(11) NOT NULL,
  `druzyna2` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `wygrany` int(11) NOT NULL DEFAULT 0,
  `mvp` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `nazwa` text NOT NULL,
  `userid` decimal(50,0) NOT NULL,
  `dywizja` int(11) NOT NULL DEFAULT 1,
  `druzyna` int(11) NOT NULL DEFAULT 0,
  `nickeune` text NOT NULL,
  `pozycja` int(11) NOT NULL DEFAULT 1,
  `pozycjadruga` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rosters`
--

CREATE TABLE `rosters` (
  `id` int(11) NOT NULL,
  `druzyna` int(11) NOT NULL,
  `top` decimal(50,0) DEFAULT NULL,
  `jungle` decimal(50,0) DEFAULT NULL,
  `mid` decimal(50,0) DEFAULT NULL,
  `adcarry` decimal(50,0) DEFAULT NULL,
  `support` decimal(50,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `scrims`
--

CREATE TABLE `scrims` (
  `id` int(11) NOT NULL,
  `druzyna` int(11) NOT NULL DEFAULT 0,
  `godzina1` int(11) NOT NULL DEFAULT 14,
  `godzina2` int(11) NOT NULL DEFAULT 18,
  `dni1` int(5) NOT NULL DEFAULT 1,
  `dni2` int(5) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `scrimsasks`
--

CREATE TABLE `scrimsasks` (
  `id` int(11) NOT NULL,
  `skrim` int(11) NOT NULL DEFAULT 0,
  `druzyna` int(11) NOT NULL DEFAULT 0,
  `data1` datetime NOT NULL,
  `data2` datetime NOT NULL,
  `data3` datetime NOT NULL,
  `akceptowany` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `scrimscertainasks`
--

CREATE TABLE `scrimscertainasks` (
  `id` int(11) NOT NULL,
  `druzynapytajaca` int(11) NOT NULL DEFAULT 0,
  `druzynapytana` int(11) NOT NULL DEFAULT 0,
  `data1` datetime NOT NULL,
  `data2` datetime NOT NULL,
  `data3` datetime NOT NULL,
  `akceptowany` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `lider` decimal(50,0) NOT NULL,
  `nazwa` mediumtext NOT NULL,
  `potwierdzony` int(11) NOT NULL DEFAULT 0,
  `gotowy` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `votemvp`
--

CREATE TABLE `votemvp` (
  `mecz` int(11) NOT NULL,
  `top` int(20) NOT NULL DEFAULT 0,
  `jungle` int(20) NOT NULL DEFAULT 0,
  `mid` int(20) NOT NULL DEFAULT 0,
  `adcarry` int(20) NOT NULL DEFAULT 0,
  `support` int(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `mecz` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invites`
--
ALTER TABLE `invites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matches_ibfk_1` (`druzyna1`),
  ADD KEY `matches_ibfk_2` (`druzyna2`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rosters`
--
ALTER TABLE `rosters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scrims`
--
ALTER TABLE `scrims`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scrims_ibfk_1` (`druzyna`);

--
-- Indexes for table `scrimsasks`
--
ALTER TABLE `scrimsasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scrimsasks_ibfk_1` (`skrim`),
  ADD KEY `scrimsasks_ibfk_2` (`druzyna`);

--
-- Indexes for table `scrimscertainasks`
--
ALTER TABLE `scrimscertainasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scrimscertainasks_ibfk_1` (`druzynapytajaca`),
  ADD KEY `scrimscertainasks_ibfk_2` (`druzynapytana`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votemvp`
--
ALTER TABLE `votemvp`
  ADD KEY `votemvp_ibfk_1` (`mecz`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `votes_ibfk_1` (`userid`),
  ADD KEY `votes_ibfk_2` (`mecz`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `invites`
--
ALTER TABLE `invites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT dla tabeli `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT dla tabeli `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT dla tabeli `rosters`
--
ALTER TABLE `rosters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT dla tabeli `scrims`
--
ALTER TABLE `scrims`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT dla tabeli `scrimsasks`
--
ALTER TABLE `scrimsasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `scrimscertainasks`
--
ALTER TABLE `scrimscertainasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT dla tabeli `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`druzyna1`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`druzyna2`) REFERENCES `teams` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `scrims`
--
ALTER TABLE `scrims`
  ADD CONSTRAINT `scrims_ibfk_1` FOREIGN KEY (`druzyna`) REFERENCES `teams` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `scrimsasks`
--
ALTER TABLE `scrimsasks`
  ADD CONSTRAINT `scrimsasks_ibfk_1` FOREIGN KEY (`skrim`) REFERENCES `scrims` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `scrimsasks_ibfk_2` FOREIGN KEY (`druzyna`) REFERENCES `teams` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `scrimscertainasks`
--
ALTER TABLE `scrimscertainasks`
  ADD CONSTRAINT `scrimscertainasks_ibfk_1` FOREIGN KEY (`druzynapytajaca`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `scrimscertainasks_ibfk_2` FOREIGN KEY (`druzynapytana`) REFERENCES `teams` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `votemvp`
--
ALTER TABLE `votemvp`
  ADD CONSTRAINT `votemvp_ibfk_1` FOREIGN KEY (`mecz`) REFERENCES `matches` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `players` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`mecz`) REFERENCES `matches` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
