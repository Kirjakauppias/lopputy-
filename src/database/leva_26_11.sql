-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql_db
-- Generation Time: 26.11.2024 klo 06:05
-- Palvelimen versio: 8.3.0
-- PHP Version: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leva`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `company`
--

CREATE TABLE `company` (
  `company_id` int NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zipcode` varchar(5) DEFAULT NULL,
  `postplace` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `description` text,
  `user_id` int NOT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `company_url` varchar(255) NOT NULL,
  `slogan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Vedos taulusta `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `company_number`, `address`, `zipcode`, `postplace`, `email`, `phone_number`, `description`, `user_id`, `updated_at`, `company_url`, `slogan`) VALUES
(1, 'EsteriTesteriPEsteri', '2324322-9', 'Esterinkatu 3 B 56', '12345', 'Kuopio', 'esrter@345.com', '0556789045', 'Jotain tekstiä tähän.', 1, '2024-11-09 14:50:54', 'esteritesteripesteri.php', NULL),
(5, 'Mikon Yritys 2', '2111111-1', 'Katu', '00001', 'Kuopio', 'Testitesti2@gmail.com', '0441234567', 'Testi testi 123', 2, '2024-11-09 14:51:22', 'mikon-yritys-2.php', NULL),
(10, 'MTestaaja', '5678905-1', 'Mtestikatu', '40640', 'Jyväskylä', 'MTestaaja@testi.com', '0554567890', '', 4, '2024-11-09 14:51:42', 'mtestaaja.php', NULL),
(11, 'Jaskan Yritys', '0000000-1', 'Jaskakatu', '00001', 'Helsinki', 'Jaskanyritys@gmail.com', '0506678905', 'Jaskan yritys', 5, '2024-11-09 14:52:01', 'jaskan-yritys.php', NULL),
(12, 'TestiStmt', '6789056-0', 'Katu', '67889', 'Kuopio', 'TestiStm@gmial.com', '0441234567', 'Testi', 3, '2024-11-09 14:50:09', 'testistmt.php', NULL),
(13, 'Mikon Yritys 5', '3454678-9', 'Mikko', '45678', 'Kuopio', 'mikko@osoite.com', '0441234567', 'Jotain', 6, '2024-11-11 15:24:13', 'mikon-yritys.php', NULL),
(14, 'Ferrari', '1111111-1', 'Ferrarikatu', '00001', 'Helsinkin', 'Ferrari@ori.com', '0441234567', 'Kimin ferrari.', 16, '2024-11-13 08:14:44', 'ferrari.php', NULL),
(15, 'Winnipeg Jets', '5555555-5', 'Winnipekki', '44444', 'Winnipekki', 'Teemu@winnipeg.com', '0441234567', 'Lätkää.', 17, '2024-11-13 08:35:06', 'winnipeg-jets.php', NULL),
(16, 'dbConnectTesti', '6666666-6', 'Testi', '56443', 'Kuopio', 'dbConnect@testi.fi', '0441234567', 'Testiä', 18, '2024-11-13 09:48:04', 'dbconnecttesti.php', NULL),
(17, 'Roopen Koronkiskonta', '9999999-9', 'Rahakatu 1000', '00001', 'Helsinkin', 'Koronkiskonta@gmail.com', '0441234567', 'Rahaa tänne nyt.', 19, '2024-11-13 09:59:47', 'roopen-koronkiskonta.php', NULL),
(18, 'Kraken', '9876543-1', 'Kraken', '00001', 'Kuopio', 'Kreken@kraken.com', '0445432156', 'Testiä', 20, '2024-11-13 11:39:26', 'kraken.php', NULL),
(19, 'Makkaratehdas Salami', '4567890-1', 'Salamikatu 4', '00001', 'Helsinkin', 'Salami@makkara.com', '0441234567', 'Makkaratehdas Salami on kuvitteellinen suomalainen yritys, joka on tunnettu korkealaatuisista ja perinteikkäistä makkaroistaan. Perustettu 1950-luvulla pienessä kylässä, Salami on kasvanut vuosikymmenten aikana arvostetuksi makkaranvalmistajaksi, joka yhdistää vanhat perinteet ja modernit valmistusmenetelmät.\n\nTehtaan tuotevalikoima sisältää laajan kirjon makkaroita: mausteisia grillimakkaroita, mietoja nakkimakkaroita, käsityönä valmistettuja artesaanimakkaroita sekä monipuolisia kasvisvaihtoehtoja. Salamin toimintaa ohjaa vahva sitoutuminen laatuun, puhtaisiin raaka-aineisiin ja kestävään tuotantoon. Yrityksellä on omat salaiset reseptinsä, jotka takaavat ainutlaatuisen maun ja korkean asiakastyytyväisyyden.\n\nSalamin makkaratehdas on myös aktiivinen paikallisyhteisössään ja osallistuu usein erilaisiin tapahtumiin, kuten makkarafestivaaleihin ja hyväntekeväisyystempauksiin. Näin Salami ei ole pelkästään makkaratehdas, vaan osa suomalaista ruokakulttuuria ja yhteisöllisyyttä.', 21, '2024-11-13 12:34:45', 'makkaratehdas-salami.php', NULL),
(20, 'Esko Firma', '0987653-4', 'Eskokatu', '00001', 'Helsinki', 'Esko@jotain.com', '0441234556', 'Tietoa', 22, '2024-11-13 14:07:48', 'esko-firma.php', NULL),
(21, 'Maunon Ennustukset', '6543267-9', 'Maunokatu', '55555', 'Paikkakunta', 'maunonennustukset@hotmail.com', '0441234567', 'Maunon ennustuksia jo vuodesta 2024.', 23, '2024-11-14 08:05:01', 'maunon-ennustukset.php', NULL),
(22, 'Litti Hitti', '5678435-6', 'Littikatu', '43321', 'Kuopio', 'Littihitti@gmail.com', '0445432156', 'Littihitti', 24, '2024-11-14 18:40:52', 'litti-hitti.php', NULL),
(23, 'Kuljetus Punakuono', '6543675-7', 'Punakuonokuja', '54324', 'Korvatunturi', 'punis@hotmail.com', '0441234567', 'Testi', 25, '2024-11-15 15:36:37', 'kuljetus-punakuono.php', NULL),
(24, 'Joulupukin Paja', '3456789-1', 'Katu', '54324', 'Kuopio', 'Testitesti3@gmail.com', '0441234567', 'Testi', 26, '2024-11-15 15:41:20', 'joulupukin-paja.php', NULL),
(25, 'Käpy Oy', '5678905-2', 'Kapy', '56443', 'KPO', 'Kapy@kapy.com', '0445432156', 'Tietoa', 27, '2024-11-15 15:44:37', 'k-py-oy.php', NULL),
(26, 'Pouttu', '5678905-3', 'Pottu', '56443', 'KPO', 'pottu@pottu.fi', '0445432156', 'Tietoa', 28, '2024-11-15 15:49:49', 'pouttu.php', NULL),
(27, 'Zencafe', '5678905-4', 'katu', '00001', 'HKL', 'zencafe@htomail.com', '0445432156', 'Jee', 29, '2024-11-15 15:52:17', 'zencafe.php', NULL),
(28, 'U2', '6543267-0', 'Katu', '00001', 'HKL', 'u2@hotmail.com', '0441234567', 'Testi', 30, '2024-11-15 15:55:09', 'u.php', NULL),
(29, 'Kaapo', '0567432-7', 'katu', '05555', 'KPO', 'kaapo@hotmail.com', '044433334', 'Testi', 31, '2024-11-15 15:59:47', 'kaapo.php', NULL),
(30, 'Petushop', '6543453-4', 'Katu', '05556', 'KPO', 'Petu@gmail.com', '0443434423', 'jesh', 32, '2024-11-15 16:02:11', 'petushop.php', NULL),
(31, 'Jyrkin Pyrkyrit', '5434456-8', 'Katu', '04445', 'KPO', 'jyrki@pyrkyrit.com', '0445464564', 'Testi', 33, '2024-11-15 17:52:27', 'jyrkin-pyrkyrit.php', NULL),
(32, 'Sillan Sipuli', '8665343-6', 'Kato', '74578', 'KPO', 'silla@sipuli.com', '0445665656', 'Tietoa', 34, '2024-11-15 18:02:42', 'sillan-sipuli.php', NULL),
(33, 'Puhelinlangat laulaa', '5698741-6', 'katrinraitti 4', '10100', 'Katrila', 'laululintu@katri.com', '040258258', 'Puhelinlangat laulaa ja taivaalla loistaa kuu maantiellä vihellellen kun kulkijapoika käy puhelinlangat laulaa ja pilvistä katsoo kuu kulkijan taipaleella ei huolien häivää näy Heinälatoon yöksi hän majoittuu ja eväitänsä maistelee kullastansa siellä hän uneksuu kun unian hän vetelee puhelinlangat laulaa ja kuutamo kirkas on vapaa kuin taivaan lintu on kulkija huoleton Puhelinlangat laulaa ja taivaalla loistaa kuu maantiellä vihellellen kun kulkijapoika käy puhelinlangat laulaa ja pilvistä katsoo kuu kulkijan taipaleella ei huolien häivää näy Tyttö jossain kaukana odottaa kaipaus rinnassaan riemumielellä kulkija vaeltaa kaunokaista katsomaan puhelinlangat laulaa ja taruja kertoilee maanteiden romantiikkaa ne tuulessa soittelee', 35, '2024-11-17 18:24:43', 'puhelinlangat-laulaa.php', NULL),
(34, 'PalloPää', '5698743-5', 'palopäänraitti 2', '10100', 'pällola', 'pallo@paa.fi', '040369369', 'asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö asdfghjklwertyuiopdfghjklö', 36, '2024-11-17 18:36:28', 'pallop.php', NULL),
(35, 'sakodjaoI', '4689596-1', 'dsoapfkspo 8', '10100', 'depswo', 'KASsk@mkdlsa.fi', '040369369', 'dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ dsafkspoAÅ', 37, '2024-11-17 18:48:33', 'sakodjaoi.php', NULL),
(36, 'Maken Poliisikoulu', '3454355-6', 'Pamppukatu', '70110', 'KPO', 'pamppu@gmail.com', '044353453', 'Jadajada.', 38, '2024-11-18 08:02:27', 'maken-poliisikoulu.php', 'Poliisi pamputtaa'),
(37, 'Sipulia', '3454354-3', 'Sibali', '70111', 'KPO', 'sipulia@gmail.com', '0454535433', 'Sibalia', 39, '2024-11-18 08:06:04', 'sipulia.php', 'Ei itku auta'),
(38, 'Poikainkoulu', '4398534-4', 'Oppitie', '70110', 'KPO', 'oppi@oja.com', '0443553535', 'Oppia', 40, '2024-11-18 08:10:52', 'poikainkoulu.php', 'Oppi ja oja'),
(39, 'Mirjan Mehu', '3453454-4', 'Osoite', '45456', 'Kuopioo', 'mehu@hotmail.com', '044534435', 'Tervetuloa tutustumaan Mirjan Mehuun, kotimaiseen yritykseen, joka on omistautunut tarjoamaan aidosti luonnollisia ja herkullisia mehuja. Meille laatu ja maku ovat sydämenasia, ja jokainen pisara mehua kertoo tarinaa suomalaisista metsistä, puutarhoista ja pelloista.\n\nMirjan Mehu valmistetaan huolella valikoiduista, kotimaisista marjoista ja hedelmistä, joiden puhtaus ja laatu ovat meille ensiarvoisen tärkeitä. Valmistusprosessi on suunniteltu kunnioittamaan raaka-aineita, eikä mehuissamme ole keinotekoisia lisäaineita tai ylimääräistä sokeria. Lisäksi toiminnassamme korostuvat vastuullisuus ja kestävä kehitys. Suosimme paikallisia viljelijöitä, käytämme kierrätettäviä pakkauksia ja minimoimme ympäristövaikutukset.\n\nValikoimaamme kuuluu sekä perinteisiä että yllättäviä makuja. Klassiset mustikka, puolukka ja mansikka ovat monien suosikkeja, kun taas omena-inkivääri tai mustaherukka-raparperi tarjoavat kiinnostavia vaihtoehtoja niille, jotka kaipaavat jotakin uutta. Lisäksi tarjoamme sesongin mukaisia kausimakuja, jotka ilahduttavat rajoitetuissa erissä.\n\nMirjan Mehu on täydellinen valinta jokaiseen hetkeen, olipa kyseessä aamuinen virkistys, hemmotteluhetki arjen keskellä tai juhlapöydän kruunu. Jokainen pullo on tehty rakkaudella, jotta voit nauttia luonnon raikkaudesta ja aidosta mausta.\n\nMirjan Mehu – maista ja tunne ero. Tuo luonnon parhaat maut osaksi omaa arkeasi!', 41, '2024-11-25 14:08:42', 'mirjan-mehu.php', 'Nam Nam Mehua'),
(40, 'Vieheet Oy', '5554332-6', 'Katu', '70100', 'KPO', 'vieheet@gmail.com', '0445445444', 'Tietoa', 42, '2024-11-25 15:00:22', 'vieheet-oy.php', 'Loiskis!'),
(41, 'Essin Vieheet', '4545645-5', 'Katu', '70100', 'KPO', 'vieheet2@hotmail.com', '044353533', 'Tietoa', 44, '2024-11-25 15:04:59', 'essin-vieheet.php', 'Loiskit!'),
(42, 'UFO', '4535343-4', 'Ufokatu', '70100', 'Kuopio', 'ufo@gmail.com', '0443543453', 'Testi', 45, '2024-11-25 15:11:16', 'ufo.php', 'Lentävää lautasta');

-- --------------------------------------------------------

--
-- Rakenne taululle `company_style`
--

CREATE TABLE `company_style` (
  `style_id` int NOT NULL,
  `company_id` int NOT NULL,
  `background_color` varchar(7) DEFAULT '#FFFFFF',
  `text_color` varchar(7) DEFAULT '#333333',
  `header_color` varchar(7) DEFAULT '#004080',
  `footer_color` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '#F1F1F1',
  `header_font` varchar(255) DEFAULT 'Arial, sans-serif',
  `display_font` varchar(255) DEFAULT 'Verdana, sans-serif',
  `footer_font` varchar(255) DEFAULT 'Tahoma, sans-serif',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Vedos taulusta `company_style`
--

INSERT INTO `company_style` (`style_id`, `company_id`, `background_color`, `text_color`, `header_color`, `footer_color`, `header_font`, `display_font`, `footer_font`, `updated_at`) VALUES
(2, 32, '#FFFFFF', '#333333', '#004080', '#333333', 'Arial, sans-serif', 'Verdana, sans-serif', 'Tahoma, sans-serif', '2024-11-15 18:02:42'),
(3, 33, '#ff80c0', '#8000ff', '#000000', '#c0c0c0', 'Georgia, serif', 'Times New Roman, serif', 'Arial, sans-serif', '2024-11-17 18:29:57'),
(4, 34, '#ffffff', '#333333', '#004080', '#333333', 'Arial, sans-serif', 'Verdana, sans-serif', 'Tahoma, sans-serif', '2024-11-17 18:36:37'),
(5, 35, '#FFFFFF', '#333333', '#004080', '#333333', 'Arial, sans-serif', 'Verdana, sans-serif', 'Tahoma, sans-serif', '2024-11-17 18:48:33'),
(6, 36, '#d33c3c', '#333333', '#004080', '#333333', 'Arial, sans-serif', 'Times New Roman, serif', 'Georgia, serif', '2024-11-18 15:32:04'),
(7, 37, '#ecd909', '#f22b07', '#f5a905', '#f56505', 'Georgia, serif', 'Georgia, serif', 'Georgia, serif', '2024-11-18 08:13:10'),
(8, 38, '#f556a3', '#fb0e0e', '#f8f7f7', '#5476de', 'Arial, sans-serif', 'Tahoma, sans-serif', 'Times New Roman, serif', '2024-11-18 14:49:33'),
(9, 39, '#401cf2', '#e8d1ca', '#4d5841', '#f736d3', 'Georgia, serif', 'Times New Roman, serif', 'Arial, sans-serif', '2024-11-25 11:53:30'),
(10, 40, '#FFFFFF', '#333333', '#004080', '#333333', 'Arial, sans-serif', 'Verdana, sans-serif', 'Tahoma, sans-serif', '2024-11-25 15:00:22'),
(11, 41, '#FFFFFF', '#333333', '#004080', '#333333', 'Arial, sans-serif', 'Verdana, sans-serif', 'Tahoma, sans-serif', '2024-11-25 15:04:59'),
(12, 42, '#ee1b1b', '#333333', '#338ce6', '#d9a1c2', 'Arial, sans-serif', 'Verdana, sans-serif', 'Tahoma, sans-serif', '2024-11-25 15:29:23');

-- --------------------------------------------------------

--
-- Rakenne taululle `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Vedos taulusta `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `username`, `email`, `password`, `status`, `last_login`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Jaska', 'Jokunen', 'Testi', 'eskonen@gmail.com', '$2y$10$c9l75xeDk9zUUTb4QxXx1epihW4EJl2EnaOIRlYDR01RJp4rwMsZW', 'customer', NULL, '2024-10-28 07:58:46', '2024-11-11 14:52:32', NULL),
(2, 'Testi2', 'Testi2', 'testi2', 'testi2@gmail.com', '$2y$10$J4CXuyd3AZOqg7zY8rmKKeghBCNX8sBtns4iZAN2HTjWs0Oyl8J.W', 'customer', NULL, '2024-10-28 12:11:40', '2024-10-28 12:11:40', NULL),
(3, 'TestiStmt', 'TestiStmt', 'TestiStmt', 'TestiStmt@gmail.com', '$2y$10$cGNqWSAZ4ZXUQRveIfu5uOEfnXB.I7ERLZKo53anybBPCHl3uhtEq', 'customer', NULL, '2024-10-28 12:19:30', '2024-10-28 12:19:30', NULL),
(4, 'Mikko', 'Testaaja', 'MikkoTestaaja', 'MikkoTestaaja@gmail.com', '$2y$10$joIy8tHTL4uHGTLbiK8M1OQg.VT96wEEGE9MVZNfUQaQ0aWtF3blK', 'customer', NULL, '2024-10-30 06:58:15', '2024-10-30 06:58:15', NULL),
(5, 'Jaska', 'Jokunen', 'Jaska', 'jaska@gmail.com', '$2y$10$eUxfSHNQZENN/lXC/fTpdOz6M1GqpgdQb/eis62haRw9He9qnX3JC', 'customer', NULL, '2024-11-09 14:25:48', '2024-11-09 14:25:48', NULL),
(6, 'Mikko', 'Asiakas', 'Mikis', 'mikis@gmail.com', '$2y$10$1B80IyRxG2ihrXXAp5km8u0A1Ntgou3sbll7CtC4Ll87ehlsNq3v.', 'customer', NULL, '2024-11-11 15:22:57', '2024-11-11 15:22:57', NULL),
(10, 'Sepi', 'Kumpulainen', 'Sepi', 'sepi@sepi.com', '$2y$10$q0IBHPEU0Qoh5wSCjQxR6.V1njgSPRE2kcMkc71GlthIrQoDfjESW', 'customer', NULL, '2024-11-12 09:44:12', '2024-11-12 09:44:12', NULL),
(11, 'Sepi', 'Kumpulainen', 'Sepi3', 'sepi@gmail.com', '$2y$10$2iJV6vH3iw5owMMr7abDdepsZe22/8Nn42tMNfZ24yQOBqeJlfoo.', 'customer', NULL, '2024-11-12 09:45:21', '2024-11-12 09:45:21', NULL),
(12, 'Sepi', 'Seppe', 'SEppe', 'seppe@gmail.com', '$2y$10$usIZR3PDVcj2M1.kXQ7kZ.klvLSLmiYepvw1t8BwpVGOYWbsdx51y', 'customer', NULL, '2024-11-12 09:52:52', '2024-11-12 09:52:52', NULL),
(13, 'SEpi', 'Seppe', 'Seppe6', 'seppe@gmail.copm', '$2y$10$iZ398bys2viV1Zd64McVOe6GUSSo88imfqvD31Rp/8qAOJzfHjtNi', 'customer', NULL, '2024-11-12 09:55:25', '2024-11-12 09:55:25', NULL),
(14, 'SEpi', 'sepe', 'sepesusi', 'se@se.com', '$2y$10$bJo2wAbXx.goJUYSmJRJIuiBNUTYmtgV9ODufqQe296Wy1/mzhfLu', 'customer', NULL, '2024-11-12 09:56:51', '2024-11-12 09:56:51', NULL),
(15, 'Milla', 'Magia', 'Magia', 'mmagia@gmail.com', '$2y$10$0CQlDyiTl5HVU37ErOjVd./Ax1feZMAV9ZCxlql.v/RvDpNmsiU72', 'customer', NULL, '2024-11-12 09:58:23', '2024-11-12 09:58:23', NULL),
(16, 'Kimi', 'Räikkönen', 'Iceman', 'kimi@raikkonen.com', '$2y$10$YYZi3dD8iX.2aEc6dTshveOU1Wz5FUbn5Y2q7PeGfaUAPMwL2Ft4i', 'customer', NULL, '2024-11-13 08:13:18', '2024-11-13 08:13:18', NULL),
(17, 'Teemu', 'Selänne', 'Teme', 'teme@selanne.com', '$2y$10$1Pt3yBJQrcJCgbXIeGYLiOQGsirB5qUKgMcMv60sir4IYSnInbDpm', 'customer', NULL, '2024-11-13 08:32:55', '2024-11-13 08:32:55', NULL),
(18, 'Ari', 'Vatanen', 'dbconnect', 'ari@vatanen.com', '$2y$10$m4tWg.BBMPq/0OweyhDJR.Yn9uPbww7GyVR47jnsEEskawJ5YcoMu', 'customer', NULL, '2024-11-13 09:28:29', '2024-11-13 09:46:36', NULL),
(19, 'Roope', 'Ankka', 'onnenlantti', 'rahaa@hitosti.com', '$2y$10$ck6coIGLgYGRmgfIKFAYRODaxPZWfpv5IZ2z8JF3PAwi4Kuqs78b.', 'customer', NULL, '2024-11-13 09:57:03', '2024-11-13 09:57:03', NULL),
(20, 'Kraken', 'Kraken', 'Kraken', 'kraken@kraken.fi', '$2y$10$6aupb/hibpvmnpDIiBx9ieRj3EdkAdMl0tqWsy1TrzE50.a7ZCXHu', 'customer', NULL, '2024-11-13 11:38:34', '2024-11-13 11:38:34', NULL),
(21, 'Salami', 'Sulami', 'Silami', 'Solami@hotmail.com', '$2y$10$/4.KGGcGTp3WG4tdrVRvUefuuGdhyrt1gWA4W3aNr4PhxH.wNAspW', 'customer', NULL, '2024-11-13 12:32:37', '2024-11-13 12:32:37', NULL),
(22, 'Esko', 'Aho', 'esko', 'aho@esko.fi', '$2y$10$oDUMfYI74fA1179wAuhMkeT/6M.qVvZL0B0lc.qgxlSDugAtibPuq', 'customer', NULL, '2024-11-13 14:04:32', '2024-11-13 14:04:32', NULL),
(23, 'Mauno', 'Koivisto', 'mauno', 'mauno@koivisto.com', '$2y$10$bXKzO0I8NxurL4t47oakjuC8Iwbfen9KL4dZ46hSNinr5fOffdBFW', 'customer', NULL, '2024-11-14 08:01:21', '2024-11-14 08:01:21', NULL),
(24, 'Jari', 'Litmanen', 'litti', 'litti@litti.com', '$2y$10$ZtjRtMuA.hSYqFpA/8BPp.oAJ24k.UGb8bwkqlPLkB/i9O3hth7T6', 'customer', NULL, '2024-11-14 18:39:56', '2024-11-14 18:39:56', NULL),
(25, 'Petteri', 'Punakuono', 'punis', 'punis@korvatunturi.com', '$2y$10$sEDNXlhNhaM..Yn/zI3AduXE6KmU5kWdz.CGtkcQ1Mkdno5pYLIHC', 'customer', NULL, '2024-11-15 15:35:29', '2024-11-15 15:35:29', NULL),
(26, 'Joulu', 'Pukki', 'joulupukki', 'joulu@korvatunturi.fi', '$2y$10$0ThgVm0U19mJ/BHsEncbHue1faDpZXI5BOZT7jtfgoQJALkbzxInW', 'customer', NULL, '2024-11-15 15:39:47', '2024-11-15 15:39:47', NULL),
(27, 'Käpsy', 'Käpy', 'kapy', 'kapy@kapsy.fi', '$2y$10$yX4Pq0PtsITQcfm5WaciXulfWLZwgfdnovWAO0jI3Wq1kEfD6h8YK', 'customer', NULL, '2024-11-15 15:43:47', '2024-11-15 15:43:47', NULL),
(28, 'Pottu', 'Pää', 'pottu', 'pottu@gmail.com', '$2y$10$2ZiXMS.FnObmX24WGjumNer4bodt9wIYhurFQqUaYbcSwR2hOCRz.', 'customer', NULL, '2024-11-15 15:49:05', '2024-11-15 15:49:05', NULL),
(29, 'Zen', 'cafe', 'zencafe', 'zencafe@gmail.com', '$2y$10$WlmsfSX.paNqTWXQkc54QuFla0N87ueSBx55HDKFW8menPGQRfc9W', 'customer', NULL, '2024-11-15 15:51:33', '2024-11-15 15:51:33', NULL),
(30, 'Bono', 'Rokkari', 'bono', 'bono@u2.com', '$2y$10$rsG3sgbfKdpCKtkooe9dl.394le8CIhXNHLduBbuZSvXYtuuacVCG', 'customer', NULL, '2024-11-15 15:54:29', '2024-11-15 15:54:29', NULL),
(31, 'Kaapo', 'Kakko', 'kaapo', 'kaapo@hotmail.com', '$2y$10$D2nGBxAsJQamkCMIOiiTnOJBPb45CVe0bLeQIrNFxycqdZoZOTZZW', 'customer', NULL, '2024-11-15 15:58:54', '2024-11-15 15:58:54', NULL),
(32, 'Petu', 'Laine', 'petu', 'petu@gmail.com', '$2y$10$UCPezPKa5xewtsFfzbTCTOpo5vluP1zhsVzkeGzOVnT8z5aXr4Tlq', 'customer', NULL, '2024-11-15 16:01:24', '2024-11-15 16:01:24', NULL),
(33, 'Jyrki', 'Aho', 'jyrki', 'jyrki@jyrki.com', '$2y$10$OwHL2/k.sq.xMVFI1wHrIuHKs/DBRTqr1Fb9jk3ARlwJZY3HhDkW6', 'customer', NULL, '2024-11-15 17:51:31', '2024-11-15 17:51:31', NULL),
(34, 'Silla', 'Salminen', 'silla', 'silla@gmail.com', '$2y$10$B7mqg5pMGNr3f52KNnSX.u5F.xpxDfnz/kmEM8H0clXZjDd8a1KSO', 'customer', NULL, '2024-11-15 18:01:15', '2024-11-15 18:01:15', NULL),
(35, 'Katri', 'Helena', 'Katri', 'katri@helena.fi', '$2y$10$X4FXRCHF1XHMDGEPxy/ZiOtwHXkIvIwVU6KD23eVtHNTuvlyl2wgy', 'customer', NULL, '2024-11-17 18:19:18', '2024-11-17 18:19:18', NULL),
(36, 'Pallo', 'Pää', 'PalloPää', 'pallo@paa.fi', '$2y$10$NeYjEuluGRc71f7GdJCbx./IHYE1v.aUpd5DsLbSnVIZURveWb8jO', 'customer', NULL, '2024-11-17 18:34:49', '2024-11-17 18:34:49', NULL),
(37, 'Heidi', 'Kyrö', 'Heidi', 'heidi@kyro.fi', '$2y$10$WIdBozXy64XTH0/vigHHnenoNr39PpCMHs21KuJxDGuFUmmVb8TRi', 'customer', NULL, '2024-11-17 18:47:24', '2024-11-17 18:47:24', NULL),
(38, 'Marko', 'Kilpi', 'make', 'marko@kilpi.com', '$2y$10$vTDdyYe2lDL2gLSGPfti1OVt.z7.GiidoRCo8wCJUfVroY/cOXTgK', 'customer', NULL, '2024-11-18 07:54:37', '2024-11-18 07:54:37', NULL),
(39, 'Sanna', 'Sipuli', 'ssipuli', 'ssipuli@gmail.com', '$2y$10$BOheFDGVsmH/MBCiD1gKtuMUVfp295VCvSACTJJuBt6G3aVb5zu2K', 'customer', NULL, '2024-11-18 07:56:58', '2024-11-18 07:56:58', NULL),
(40, 'Tupu', 'Lupu', 'hupu', 'tupu@hupu.com', '$2y$10$UsgBH0PwgcPsJAT2xrQt2uV.hoSmS0HsGLa35cx.Bl696fQ17iTKu', 'customer', NULL, '2024-11-18 07:59:08', '2024-11-18 07:59:08', NULL),
(41, 'Mirja', 'Miettinen', 'mirja', 'mirja@gmail.com', '$2y$10$BKNxkDbGB0eaIgoRfkblduuxah2.qRb2NzFzJQ.IMMULGEqhVGhbG', 'customer', NULL, '2024-11-18 19:48:59', '2024-11-18 19:48:59', NULL),
(42, 'Jyrki', 'Perhko', 'perhko', 'osoite@gmail.com', '$2y$10$XJxyYMRwt0l6AXRIEoN05.A3y4bcYGnM8UYdDBaiGZbQh9whQA3vS', 'customer', NULL, '2024-11-25 14:59:05', '2024-11-25 14:59:05', NULL),
(43, 'Essi', 'Pietikäinen', 'essi', 'essi@gmail.com', '$2y$10$EPO3CZl39vsxBvdkmKGPyOHcg7.2q1Cnc0p1pcUklpyp.A0a9QC5q', 'customer', NULL, '2024-11-25 15:03:14', '2024-11-25 15:03:14', NULL),
(44, 'Essi', 'Pietikäinen', 'essi2', 'essi2@gmail.com', '$2y$10$mimAlrPTpOPjxMETdNJ5seHr6WbX6QdZNBY7JYD1HayH2oHoKOOFi', 'customer', NULL, '2024-11-25 15:04:09', '2024-11-25 15:04:09', NULL),
(45, 'Mikko', 'Lepistö', 'ufo', 'ufo@gmail.com', '$2y$10$arqLVlFIFWKc2CxTINLrE.VBlbmRwEFek1fhjIJJt5oZHgZ04HvBq', 'customer', NULL, '2024-11-25 15:10:20', '2024-11-25 15:10:20', NULL);

-- --------------------------------------------------------

--
-- Rakenne taululle `user_image`
--

CREATE TABLE `user_image` (
  `image_id` int NOT NULL,
  `user_id` int NOT NULL,
  `company_id` int NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Vedos taulusta `user_image`
--

INSERT INTO `user_image` (`image_id`, `user_id`, `company_id`, `file_path`, `uploaded_at`) VALUES
(1, 1, 1, './userImages/6721052927694_LeVaLogo1.png', '2024-10-29 15:54:17'),
(2, 1, 1, './userImages/6723c92f04496_LeVaLogo1.png', '2024-10-31 18:15:11'),
(3, 1, 1, './userImages/6728e7a35bb44_LeVaLogo1.png', '2024-11-04 15:26:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`),
  ADD UNIQUE KEY `company_url` (`company_url`),
  ADD KEY `fk_company_user` (`user_id`);

--
-- Indexes for table `company_style`
--
ALTER TABLE `company_style`
  ADD PRIMARY KEY (`style_id`),
  ADD KEY `fk_company_id` (`company_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_image`
--
ALTER TABLE `user_image`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `company_id` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `company_style`
--
ALTER TABLE `company_style`
  MODIFY `style_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `user_image`
--
ALTER TABLE `user_image`
  MODIFY `image_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `fk_company_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Rajoitteet taululle `company_style`
--
ALTER TABLE `company_style`
  ADD CONSTRAINT `fk_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE;

--
-- Rajoitteet taululle `user_image`
--
ALTER TABLE `user_image`
  ADD CONSTRAINT `user_image_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `user_image_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
