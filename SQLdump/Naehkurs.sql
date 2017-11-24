-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 24. Nov 2017 um 09:55
-- Server-Version: 10.1.26-MariaDB
-- PHP-Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `Naehkurs`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Benutzer`
--

CREATE TABLE `Benutzer` (
  `Benutzer_ID` int(10) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Passwort` varchar(32) NOT NULL,
  `Anrede` varchar(255) NOT NULL,
  `Vorname` varchar(255) NOT NULL,
  `Nachname` varchar(255) NOT NULL,
  `Adresse` varchar(255) NOT NULL,
  `PLZ` int(4) NOT NULL,
  `Ort` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Kurs`
--

CREATE TABLE `Kurs` (
  `Kurs_ID` int(10) NOT NULL,
  `Kursname` varchar(255) NOT NULL,
  `Kursbeschreibung` varchar(255) NOT NULL,
  `Kursort` varchar(255) NOT NULL,
  `Kursdatum` date NOT NULL,
  `Kursstatus` varchar(255) NOT NULL,
  `Preis` int(10) NOT NULL,
  `Max_Plaetze` int(10) NOT NULL,
  `Min_Plaetze` int(10) NOT NULL,
  `Freie_Plaetze` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Kursanmeldung`
--

CREATE TABLE `Kursanmeldung` (
  `Kursanmeldung_ID` int(10) NOT NULL,
  `Benutzer_ID` int(10) NOT NULL,
  `Kurs_ID` int(10) NOT NULL,
  `Anmeldestatus` varchar(255) NOT NULL,
  `Rechnung_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `Benutzer`
--
ALTER TABLE `Benutzer`
  ADD PRIMARY KEY (`Benutzer_ID`);

--
-- Indizes für die Tabelle `Kurs`
--
ALTER TABLE `Kurs`
  ADD PRIMARY KEY (`Kurs_ID`);

--
-- Indizes für die Tabelle `Kursanmeldung`
--
ALTER TABLE `Kursanmeldung`
  ADD PRIMARY KEY (`Kursanmeldung_ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `Benutzer`
--
ALTER TABLE `Benutzer`
  MODIFY `Benutzer_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `Kurs`
--
ALTER TABLE `Kurs`
  MODIFY `Kurs_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `Kursanmeldung`
--
ALTER TABLE `Kursanmeldung`
  MODIFY `Kursanmeldung_ID` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
