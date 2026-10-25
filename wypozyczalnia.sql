-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 04, 2025 at 09:50 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wypozyczalnia`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id_klienta` int(11) NOT NULL,
  `imie` varchar(100) NOT NULL,
  `nazwisko` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefon` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klienci`
--

INSERT INTO `klienci` (`id_klienta`, `imie`, `nazwisko`, `email`, `telefon`) VALUES
(8, 'Anna', 'Środa', 'annasroda@gmail.com', '500100100'),
(9, 'Piotr', 'Kowalski', 'piotrkowalski@gmail.com', '510610710'),
(10, 'Jan', 'Nowak', 'jannowak@gmail.com', '654789001');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pojazdy`
--

CREATE TABLE `pojazdy` (
  `id` int(11) NOT NULL,
  `typ` varchar(50) NOT NULL,
  `marka` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `rok_produkcji` int(11) NOT NULL,
  `cena_za_dzien` decimal(10,2) NOT NULL,
  `dostepnosc` tinyint(1) NOT NULL,
  `zdjecie` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pojazdy`
--

INSERT INTO `pojazdy` (`id`, `typ`, `marka`, `model`, `rok_produkcji`, `cena_za_dzien`, `dostepnosc`, `zdjecie`) VALUES
(1, 'osobowy', 'Dodge', 'Charger', 1970, 50.00, 1, 'img/dodge1.webp'),
(2, 'osobowy', 'Dodge', 'Challenger Shaker Widebody', 2010, 50.00, 1, 'img/dodge2.jpg'),
(3, 'osobowy', 'Dodge', 'Durango 5,7 R/T', 2009, 50.00, 1, 'img/dodge3.webp'),
(4, 'osobowy', 'Mercedes-Benz', 'A 180 AMG Line', 2019, 60.00, 1, 'img/mercedes1.jpg'),
(5, 'osobowy', 'Mercedes-Benz', 'S 500 4MATIC', 2022, 120.00, 1, 'img/mercedes2.jpg'),
(6, 'osobowy', 'Mercedes-Benz', 'GLE 400d Coupe', 2021, 100.00, 1, 'img/mercedes3.jpg'),
(7, 'osobowy', 'Toyota', 'Supra GR 3.0', 2021, 90.00, 1, 'img/toyota1.jpg'),
(8, 'osobowy', 'Toyota', 'Corolla Hybrid', 2020, 60.00, 1, 'img/toyota2.webp'),
(9, 'osobowy', 'Toyota', 'Land Cruiser V8', 2015, 100.00, 1, 'img/toyota3.jpg'),
(10, 'dostawczy', 'Volkswagen', 'Crafter Furgon', 2021, 120.00, 1, 'img/volkswagen1.webp'),
(11, 'dostawczy', 'Volkswagen', 'Transporter T6.1', 2020, 100.00, 1, 'img/volkswagen2.jpg'),
(12, 'dostawczy', 'Volkswagen', 'Caddy Cargo Maxi', 2022, 90.00, 1, 'img/volkswagen3.jpg'),
(13, 'dostawczy', 'Peugeot', 'Boxer Furgon L3H2', 2001, 10.00, 1, 'img/peugeot1.webp'),
(14, 'dostawczy', 'Peugeot', 'Expert Long', 2020, 95.00, 1, 'img/peugeot2.jpg'),
(15, 'dostawczy', 'Peugeot', 'Partner Van', 2019, 80.00, 1, 'img/peugeot3.webp'),
(16, 'dostawczy', 'Citroën', 'Jumper L3H2 2.2 HDi', 2018, 80.00, 1, 'img/citroen1.webp'),
(17, 'dostawczy', 'Citroën', 'Berlingo Van 1.5 BlueHDi', 2020, 70.00, 1, 'img/citroen2.jpg'),
(18, 'dostawczy', 'Citroën', 'Jumpy 2.0 BlueHDi XL', 2019, 75.00, 1, 'img/citroen3.jpg'),
(19, 'skuter', 'Honda', 'PCX125', 2007, 60.00, 1, 'img/honda1.jpg'),
(20, 'skuter', 'Honda', 'Forza125', 2007, 60.00, 1, 'img/honda2.jpg'),
(21, 'skuter', 'Honda', 'SH125i', 2007, 60.00, 1, 'img/honda3.jpg'),
(22, 'skuter', 'Suzuki', 'Address 110', 2015, 65.00, 1, 'img/suzuki1.jpg'),
(23, 'skuter', 'Suzuki', 'Burgman 125', 2016, 70.00, 1, 'img/suzuki2.jpg'),
(24, 'skuter', 'Suzuki', 'Lets 125', 2017, 60.00, 1, 'img/suzuki3.jpg'),
(25, 'skuter', 'Junak', 'N-125', 2018, 55.00, 1, 'img/junak1.jpg'),
(26, 'skuter', 'Junak', 'City 125', 2019, 50.00, 1, 'img/junak2.jpg'),
(27, 'skuter', 'Junak', 'Eco 125', 2020, 45.00, 1, 'img/junak3.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wypozyczenia`
--

CREATE TABLE `wypozyczenia` (
  `id_wypozyczenia` int(11) NOT NULL,
  `id_pojazdu` int(11) NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `data_wypozyczenia` date NOT NULL,
  `data_zwrotu` date NOT NULL,
  `rzeczywista_data_zwrotu` date DEFAULT NULL,
  `status` varchar(50) DEFAULT 'wypożyczony'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wypozyczenia`
--

INSERT INTO `wypozyczenia` (`id_wypozyczenia`, `id_pojazdu`, `id_klienta`, `data_wypozyczenia`, `data_zwrotu`, `rzeczywista_data_zwrotu`, `status`) VALUES
(10, 14, 8, '2025-04-21', '2025-04-28', '2025-04-28', 'zwrócony'),
(11, 27, 9, '2025-04-30', '2025-05-30', NULL, 'wypożyczony'),
(13, 8, 9, '2025-05-01', '2025-06-01', NULL, 'wypożyczony'),
(14, 12, 10, '2025-05-01', '2025-07-01', NULL, 'wypożyczony');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`id_klienta`);

--
-- Indeksy dla tabeli `pojazdy`
--
ALTER TABLE `pojazdy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  ADD PRIMARY KEY (`id_wypozyczenia`),
  ADD KEY `id_pojazdu` (`id_pojazdu`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id_klienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pojazdy`
--
ALTER TABLE `pojazdy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  MODIFY `id_wypozyczenia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  ADD CONSTRAINT `wypozyczenia_ibfk_1` FOREIGN KEY (`id_pojazdu`) REFERENCES `pojazdy` (`id`),
  ADD CONSTRAINT `wypozyczenia_ibfk_2` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
