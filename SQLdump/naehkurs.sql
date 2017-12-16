-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 16. Dez 2017 um 09:48
-- Server-Version: 10.1.28-MariaDB
-- PHP-Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `naehkurs`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE `benutzer` (
  `Benutzer_ID` int(10) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Passwort` varchar(32) NOT NULL,
  `Anrede` varchar(255) NOT NULL,
  `Vorname` varchar(255) NOT NULL,
  `Nachname` varchar(255) NOT NULL,
  `Adresse` varchar(255) NOT NULL,
  `PLZ` int(4) NOT NULL,
  `Ort` varchar(255) NOT NULL,
  `IsAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`Benutzer_ID`, `Email`, `Passwort`, `Anrede`, `Vorname`, `Nachname`, `Adresse`, `PLZ`, `Ort`, `IsAdmin`) VALUES
(1, 'babasti@yahoo.com', '1b9b325f68c0da13c2b77932adbf583f', 'male', 'barbara', 'stierli', 'rosengartenweg 14b', 5417, 'untersiggenthal', 0),
(2, 'hallo@hallo.com', '598d4c200461b81522a3328565c25f7c', 'male', 'rene', 'stierli', 'schlossbergweg 7', 5400, 'baden', 1),
(3, 'hallo@du.com', '598d4c200461b81522a3328565c25f7c', 'male', 'rene', 'stierli', 'fdskafda', 456415, 'dfsda', 0),
(4, 'kathasti@yahoo.de', '598d4c200461b81522a3328565c25f7c', 'female', 'katharina', 'stierli', 'landstrasse 108', 5430, 'wettingen', 0),
(5, 'anasti@bluewin.ch', '598d4c200461b81522a3328565c25f7c', 'female', 'Annas', 'Stierli', 'schlossbergweg 7', 5400, 'baden', 0),
(6, 'haseeb@fhnw.ch', '598d4c200461b81522a3328565c25f7c', 'female', 'haseeb', 'sheikh', 'musterstrasse 2', 5400, 'baden', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kurs`
--

CREATE TABLE `kurs` (
  `Kurs_ID` int(10) NOT NULL,
  `Kursname` varchar(255) NOT NULL,
  `Kursbeschreibung` varchar(255) NOT NULL,
  `Kursort` varchar(255) NOT NULL,
  `Kursdatum` date NOT NULL,
  `Kursstatus` varchar(255) NOT NULL,
  `Preis` int(10) NOT NULL,
  `Max_Plaetze` int(10) NOT NULL,
  `Min_Plaetze` int(10) NOT NULL,
  `Freie_Plaetze` int(10) NOT NULL,
  `Kurszeit` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `kurs`
--

INSERT INTO `kurs` (`Kurs_ID`, `Kursname`, `Kursbeschreibung`, `Kursort`, `Kursdatum`, `Kursstatus`, `Preis`, `Max_Plaetze`, `Min_Plaetze`, `Freie_Plaetze`, `Kurszeit`) VALUES
(1, 'Patchwork', 'afjdkaföjdklafjdlskaöfjsdklaöfjklsda', 'Baden', '2017-12-27', 'offen', 150, 6, 3, 0, '15:30'),
(2, 'Bademode', 'blablabla', 'Wettingen', '2017-12-26', 'offen', 150, 6, 3, 6, '20:00'),
(3, 'alt', 'fjsfklöa', 'baden', '2017-12-05', 'offen', 150, 6, 3, 6, '18:00'),
(4, 'Quilten', 'fjdkslaföjdasklfdjsal        ', 'Baden', '2018-02-05', '', 150, 6, 3, 6, NULL),
(5, 'Leder', 'fdjskafljsdakfjdsklaö4fdl        ', 'Baden', '2018-01-15', 'offen', 150, 6, 3, 6, NULL),
(6, 'Sticken', 'fjdksaöfjdksaöfjskl        ', 'Baden', '2018-05-06', 'offen', 150, 6, 3, 6, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kursanmeldung`
--

CREATE TABLE `kursanmeldung` (
  `Rechnung_ID` int(10) NOT NULL,
  `Benutzer_ID` int(10) NOT NULL,
  `Kurs_ID` int(10) NOT NULL,
  `Anmeldestatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `kursanmeldung`
--

INSERT INTO `kursanmeldung` (`Rechnung_ID`, `Benutzer_ID`, `Kurs_ID`, `Anmeldestatus`) VALUES
(1, 1, 1, 'offen'),
(2, 3, 1, 'offen\r\n'),
(3, 5, 1, 'offen'),
(4, 4, 1, 'definitiv');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`Benutzer_ID`);

--
-- Indizes für die Tabelle `kurs`
--
ALTER TABLE `kurs`
  ADD PRIMARY KEY (`Kurs_ID`);

--
-- Indizes für die Tabelle `kursanmeldung`
--
ALTER TABLE `kursanmeldung`
  ADD PRIMARY KEY (`Rechnung_ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `Benutzer_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `kurs`
--
ALTER TABLE `kurs`
  MODIFY `Kurs_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `kursanmeldung`
--
ALTER TABLE `kursanmeldung`
  MODIFY `Rechnung_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
