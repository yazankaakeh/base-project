-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 01, 2025 at 01:52 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mps-c`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

/*CREATE TABLE `cities` (
  `id` int NOT NULL,
  `country_id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `plate_no` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `phone_code` varchar(7) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
*/
--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `name`, `plate_no`, `phone_code`) VALUES
(1, 230, 'ADANA', '1', '322'),
(2, 230, 'ADIYAMAN', '2', '416'),
(3, 230, 'AFYONKARAHİSAR', '3', '272'),
(4, 230, 'AĞRI', '4', '472'),
(5, 230, 'AKSARAY', '68', '382'),
(6, 230, 'AMASYA', '5', '358'),
(7, 230, 'ANKARA', '6', '312'),
(8, 230, 'ANTALYA', '7', '242'),
(9, 230, 'ARDAHAN', '75', '478'),
(10, 230, 'ARTVİN', '8', '466'),
(11, 230, 'AYDIN', '9', '256'),
(12, 230, 'BALIKESİR', '10', '266'),
(13, 230, 'BARTIN', '74', '378'),
(14, 230, 'BATMAN', '72', '488'),
(15, 230, 'BAYBURT', '69', '458'),
(16, 230, 'BİLECİK', '11', '228'),
(17, 230, 'BİNGÖL', '12', '426'),
(18, 230, 'BİTLİS', '13', '434'),
(19, 230, 'BOLU', '14', '374'),
(20, 230, 'BURDUR', '15', '248'),
(21, 230, 'BURSA', '16', '224'),
(22, 230, 'ÇANAKKALE', '17', '286'),
(23, 230, 'ÇANKIRI', '18', '376'),
(24, 230, 'ÇORUM', '19', '364'),
(25, 230, 'DENİZLİ', '20', '258'),
(26, 230, 'DİYARBAKIR', '21', '412'),
(27, 230, 'DÜZCE', '81', '380'),
(28, 230, 'EDİRNE', '22', '284'),
(29, 230, 'ELAZIĞ', '23', '424'),
(30, 230, 'ERZİNCAN', '24', '446'),
(31, 230, 'ERZURUM', '25', '442'),
(32, 230, 'ESKİŞEHİR', '26', '222'),
(33, 230, 'GAZİANTEP', '27', '342'),
(34, 230, 'GİRESUN', '28', '454'),
(35, 230, 'GÜMÜŞHANE', '29', '456'),
(36, 230, 'HAKKARİ', '30', '438'),
(37, 230, 'HATAY', '31', '326'),
(38, 230, 'IĞDIR', '76', '476'),
(39, 230, 'ISPARTA', '32', '246'),
(40, 230, 'İSTANBUL', '34', '212-216'),
(41, 230, 'İZMİR', '35', '232'),
(42, 230, 'KAHRAMANMARAŞ', '46', '344'),
(43, 230, 'KARABÜK', '78', '370'),
(44, 230, 'KARAMAN', '70', '338'),
(45, 230, 'KARS', '36', '474'),
(46, 230, 'KASTAMONU', '37', '366'),
(47, 230, 'KAYSERİ', '38', '352'),
(48, 230, 'KIRIKKALE', '71', '318'),
(49, 230, 'KIRKLARELİ', '39', '288'),
(50, 230, 'KIRŞEHİR', '40', '386'),
(51, 230, 'KİLİS', '79', '348'),
(52, 230, 'KOCAELİ', '41', '262'),
(53, 230, 'KONYA', '42', '332'),
(54, 230, 'KÜTAHYA', '43', '274'),
(55, 230, 'MALATYA', '44', '422'),
(56, 230, 'MANİSA', '45', '236'),
(57, 230, 'MARDİN', '47', '482'),
(58, 230, 'MERSİN', '33', '324'),
(59, 230, 'MUĞLA', '48', '252'),
(60, 230, 'MUŞ', '49', '436'),
(61, 230, 'NEVŞEHİR', '50', '384'),
(62, 230, 'NİĞDE', '51', '388'),
(63, 230, 'ORDU', '52', '452'),
(64, 230, 'OSMANİYE', '80', '328'),
(65, 230, 'RİZE', '53', '464'),
(66, 230, 'SAKARYA', '54', '264'),
(67, 230, 'SAMSUN', '55', '362'),
(68, 230, 'SİİRT', '56', '484'),
(69, 230, 'SİNOP', '57', '368'),
(70, 230, 'SİVAS', '58', '346'),
(71, 230, 'ŞANLIURFA', '63', '414'),
(72, 230, 'ŞIRNAK', '73', '486'),
(73, 230, 'TEKİRDAĞ', '59', '282'),
(74, 230, 'TOKAT', '60', '356'),
(75, 230, 'TRABZON', '61', '462'),
(76, 230, 'TUNCELİ', '62', '428'),
(77, 230, 'UŞAK', '64', '276'),
(78, 230, 'VAN', '65', '432'),
(79, 230, 'YALOVA', '77', '226'),
(80, 230, 'YOZGAT', '66', '354'),
(81, 230, 'ZONGULDAK', '67', '372');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
/*ALTER TABLE `cities`
DROP PRIMARY KEY,
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_City_CountryID` (`country_id`) USING BTREE;
*/
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
/*ALTER TABLE `cities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
*/
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
/*ALTER TABLE `cities`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;*/

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
