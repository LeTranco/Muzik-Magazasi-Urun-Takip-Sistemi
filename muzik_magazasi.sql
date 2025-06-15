-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 15, 2025 at 01:41 PM
-- Server version: 10.6.22-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbstorage23360859013`
--

-- --------------------------------------------------------

--
-- Table structure for table `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `kullanici_id` int(11) NOT NULL,
  `isim` varchar(50) NOT NULL,
  `soyisim` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sifre_hash` varchar(255) NOT NULL,
  `kayit_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kullanicilar`
--

INSERT INTO `kullanicilar` (`kullanici_id`, `isim`, `soyisim`, `email`, `sifre_hash`, `kayit_tarihi`) VALUES
(1, 'Ahmet Taha', 'Akgün', 'ahmettaha@gmail.com', '$2y$10$lmnopqrstuv1234567890abcdefg1234567890abcdefg1234567890', '2025-06-15 11:39:43'),
(2, 'Ahmet Taha', 'Akgün', 'ahmettt@gmail.com', '$2y$10$EJ8GVLe5Ff7Fkmd/TkFaquW3Xi9vb2pVqo7CG6YHtSjkCs/GO73S2', '2025-06-15 12:03:36'),
(3, 'Ahmet Taha', 'Akgün', 'ahmet@gmail.com', '$2y$10$75Iw1wo1TC9DkkMTz/r0MOMWsHtZaJlQM0p8RQDt28MKPrRZ3/n5y', '2025-06-15 12:31:26'),
(4, 'Ahmet Taha', 'Akgün', 'ahmett@gmail.com', '$2y$10$/YXb9wTIXze5MEWFsDvmVO2SGu54u1h0J51G6WnI2S0f9L3E8Nyky', '2025-06-15 12:32:47'),
(6, 'Ahmet Taha', 'Akgün', 'taha@gmail.com', '$2y$10$ld2Agmeki3yyR3JfedI9lemRCm1T1csrjtUjba/0zH3VlnW4wPiTi', '2025-06-15 12:38:45'),
(9, 'Ahmet Taha', 'Akgün', 'abc@gmail.com', '$2y$10$iiG6xVdWJ0QcDKGS2fZjbel8JRf1IMWNPje02XzH4LBu4vJmC7Ni6', '2025-06-15 12:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `urunler`
--

CREATE TABLE `urunler` (
  `urun_id` int(11) NOT NULL,
  `urun_adi` varchar(100) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `fiyat` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `eklenme_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `urunler`
--

INSERT INTO `urunler` (`urun_id`, `urun_adi`, `kategori`, `fiyat`, `stok`, `aciklama`, `eklenme_tarihi`) VALUES
(1, 'Yamaha Akustik Gitar', 'Gitar', 3500.00, 5, 'Kaliteli akustik gitar, doğal ahşap gövde.', '2025-06-15 11:39:43'),
(2, 'Casio Elektronik Klavye', 'Klavye', 2200.00, 3, '61 tuş, çoklu enstrüman sesi, ideal başlangıç seviyesi.', '2025-06-15 11:39:43'),
(3, 'Shure SM58 Mikrofon', 'Mikrofon', 1500.00, 10, 'Profesyonel vokal mikrofonu, sahne için uygun.', '2025-06-15 11:39:43'),
(4, 'Fender Jazz Bass', 'Bas Gitar', 7500.00, 2, 'Efsanevi Fender kalitesi, 4 telli bas gitar.', '2025-06-15 11:39:43'),
(5, 'Roland Elektronik Davul', 'Davul', 8800.00, 1, 'Sessiz çalışma, çoklu pad özellikleri, kayıt için ideal.', '2025-06-15 11:39:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`kullanici_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`urun_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `urunler`
--
ALTER TABLE `urunler`
  MODIFY `urun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
