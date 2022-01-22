-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2021 at 09:36 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_product`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(8) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$nYpcbfOEozWY8rKyvb5/5ueulsCWxHXX4OF4bA5JR6GqGMe.nQPOC'),
(2, 'host', '$2y$10$kUkqRPvrCxQNwS7LhNfJuOhkarHtu9512QI0B4ucgCWjris.c8Hz.');

-- --------------------------------------------------------

--
-- Table structure for table `tb_bio_mhs`
--

CREATE TABLE `tb_bio_mhs` (
  `id_mhs` varchar(50) NOT NULL,
  `nama_depan` varchar(50) DEFAULT NULL,
  `nama_belakang` varchar(50) DEFAULT NULL,
  `nim` char(50) DEFAULT NULL,
  `ttl` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `prodi` varchar(50) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kab_kota` varchar(50) DEFAULT NULL,
  `provinsi` varchar(50) DEFAULT NULL,
  `telepon` char(15) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `email_mhs` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tgl_daftar` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_bio_mhs`
--

INSERT INTO `tb_bio_mhs` (`id_mhs`, `nama_depan`, `nama_belakang`, `nim`, `ttl`, `jenis_kelamin`, `prodi`, `jurusan`, `alamat`, `kab_kota`, `provinsi`, `telepon`, `foto`, `email_mhs`, `password`, `tgl_daftar`) VALUES
('0bf85eb0-7997-4573-a0bd-e64c658f8ecf', 'MOH.', 'IBNU NADHIR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'moh.19020@mhs.unesa.ac.id', '$2y$10$ex8yfMM4w2iE4/aDN2hOuevLhVVgFLO3FFMrMFuvptMCtdA0moz9G', '2021-04-21 08:26:02'),
('2895c530-d10e-40b0-a944-d643d4cf41e2', 'AKBAR', 'RAKASIWI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'akabar.19077@mhs.unesa.ac.id', '$2y$10$07OZ3A6Ute11ctZBCcSwF.wBdYyMUmT3hko/F201tvkUJ0LMi5yqS', '2021-04-21 08:32:11'),
('33463510-199a-4376-9f43-2c51428a158e', 'ELSA', 'DWI HANDAYANI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'elsa.19035@mhs.unesa.ac.id', '$2y$10$Z8ouy72e8J.zf6W0fyeIe.rRebZQwhAO2pvwhoQ8fUCMivGfOgcA.', '2021-04-21 08:31:51'),
('33849715-84f4-4300-a595-db9c287c296a', 'MUKHAMMAD', ' RIZAL BAYHAQI P.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mukhammad.19023@mhs.unesa.ac.id', '$2y$10$8y5O6VUvMMhevBYMUkcOOu5RQNlWpLsxQMd2icy2ccatIJSa5/P.6', '2021-04-21 08:27:41'),
('354e745b-cf2b-4b8b-8d56-c3531b7ebb84', 'NUR', 'WULAN CAHYANI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nur.19010@mhs.unesa.ac.id', '$2y$10$bnjBnUde.6wBZzJ6B89GaeQfKEHffwoLJMvL7YOVuT.sa.h6OzsVq', '2021-04-21 08:22:12'),
('3de7a905-195a-4651-8615-9a464f15b68b', 'GUSTI', 'GAGAS SAMUDRA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gusti.19022@mhs.unesa.ac.id', '$2y$10$jYTsRC.rFqrMX4z52UHrGOHi8J6rM3Oh4GAXlS.5xqUedGkYNbddG', '2021-04-21 08:26:34'),
('41eb65c4-277c-41cb-ae11-9135ea54985b', 'ANNISA', 'RUSYDIAN SABILA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'annisa.19004@mhs.unesa.ac.id', '$2y$10$6FE3uZwetY6cl7c.dSgAmuntv0A9a6ViS7YCISlllbb7Um14UGoW.', '2021-04-21 08:20:12'),
('42702a98-9ca6-4ae4-9b72-b16a47b0e46b', 'HAFIDH', 'AHMAD FAUZAN', '19051397027', '2001-04-08', 'L', 'D4 MANAJEMEN INFORMATIKA', 'TEKNIK INFORMATIKA', 'JL. MANYAR NO.22 RT.033 RW.009', 'MADIUN', 'JAWA TIMUR', '089629684850', '60858d0fbf1dd.jpg', 'hafidh.19027@mhs.unesa.ac.id', '$2y$10$WdZqrmOenv55pnTDnCLIy.2u3LpBB60HWmJr8OE7Y/s/3K8B.4u2u', '2021-04-21 07:48:03'),
('452c42f9-dee8-4121-af38-561cde365da0', 'MUHAMMAD', 'DZIKRUL HAKAM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'muhammaddzikrul.19001@mhs.unesa.ac.id', '$2y$10$an2GDOLM0XzimxHfbUWPvOi/dIRULDDB3fLfHI33OozP4SfiNSVE2', '2021-04-21 08:19:19'),
('4d4c50ea-6625-45d6-9c26-13997ca75f06', 'TAUFIK', 'NURRAHMAN', '19051397019', '2001-01-01', 'L', 'D4 MANAJEMEN INFORMATIKA', 'TEKNIK INFORMATIKA', 'JL. NGANJUK RAYA NO.100', 'NGANJUK', 'JAWA TIMUR', '089518790298', '607fd962b8442.jpg', 'taufik.19019@mhs.unesa.ac.id', '$2y$10$qUXjJoz9QG.6jYeV8AzliOXqGo8uWKiWyFjIcKQWjLvg0NSs8C0NG', '2021-04-21 07:49:25'),
('6a179207-cd44-444d-939d-4247ac208b4f', 'TANIA', 'NASTIKA P.M.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tania.19026@mhs.unesa.ac.id', '$2y$10$NKm3NzTDwnToMMTtWF.mJuUafzm5HrEazAgvfjhKW3tj1Fe9g3Be.', '2021-04-21 08:29:02'),
('8877adaf-1dc4-4a25-8564-2551c23f6a89', 'SHALU', 'LAELA MADHU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'shalu.19025@mhs.unesa.ac.id', '$2y$10$2QB8HR0eKBGYVhl0sDtC5.kRXd2OtlmLQQELyQbdoqAWv0NwVX29a', '2021-04-21 08:28:42'),
('91ee8c4b-9318-4a3f-a3ec-e4e9444b279a', 'NI', 'MADE WIDIASANTI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ni.19002@mhs.unesa.ac.id', '$2y$10$F/4UeWXH7cOt/xz7TgnFVO9jJZEFiSPa6I7jXu4dmxZUXQOmLnfOC', '2021-04-21 08:19:44'),
('94516efc-00ea-43d0-b888-a303a826afbb', 'MUHAMAD', 'SAIFUL ADIM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'muhamad.19009@mhs.unesa.ac.id', '$2y$10$7cTnuV2ToHPa9Q5E9jA6G./4PX1QkP7lzJEsrMcdjIkQDRAlRygP6', '2021-04-21 08:21:51'),
('a6350b63-5cff-4dd1-9185-6c40455b2877', 'OTNIEL', 'IULIANO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'otniel.19028@mhs.unesa.ac.id', '$2y$10$mnsTCfpUTqByrc3fHwPpUOMW5GThm2Htv9P2fQ3v4CM.JEa0n3BXK', '2021-04-21 08:29:25'),
('ae865fbf-e5c1-40a1-9f13-7baba0dbce80', 'FINA', 'MAULIDIYAH N.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fina.19034@mhs.unesa.ac.id', '$2y$10$mfuc4zbZku/R7RM.A1JzVuLWDi0pq8dcIHoyIxh5JgXuEr7wkOd9m', '2021-04-21 08:31:13'),
('aefbb7a3-2a91-4834-a5bc-c77d6a5df0aa', 'IMANUELA', 'GLORIAGNYS NATALIA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'imanuela.19032@mhs.unesa.ac.id', '$2y$10$OsDLxbo7y2U0DMCoeOWdu./OgUC9AVQmapikn6nb5aah3tJyu/qk2', '2021-04-21 08:30:45'),
('b09294f3-a3e8-4959-8ec1-9135e9c0c1fa', 'FACHREZA', 'NORRAHMA', '19051397036', '2003-03-03', 'P', 'D4 MANAJEMEN INFORMATIKA ', 'TEKNIK INFORMATIKA', 'JL. MAGETAN RAYA NO.100', 'MAGETAN', 'JAWA TIMUR', '089582793091', '607fdca0a7530.png', 'fachreza.19036@mhs.unesa.ac.id', '$2y$10$.VNXmUeWZCyBl3bNzjLS9eLIhtRVxYCIMLjbo2NH04nLomwNxv2.K', '2021-04-21 08:01:24'),
('b6032e04-ff5e-4ee2-ad95-c6ee794da323', 'WILLYTA', 'ASMARA DIYA ABADI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'willyta.19017@mhs.unesa.ac.id', '$2y$10$1vB4ljl8VzVIDE7/Rx0FBeD.df/dEVSNp6g2KGItSccKRXBc8OL5.', '2021-04-21 08:24:52'),
('b640ecf2-daf3-4477-88c9-02e06e86cab6', 'ZULFA', 'ALFIN NABILAH', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'zulfa.19024@mhs.unesa.ac.id', '$2y$10$xR3oKhmbFTRC6yk4UBLaxe9is2tAc5n7VlpqkIwPZhSthzPKja37C', '2021-04-21 08:28:10'),
('b946be2c-3b99-4e60-b21c-ffa72fbcf30f', 'IMAM', 'ARIEF AL BAIHAQY', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'imam.19006@mhs.unesa.ac.id', '$2y$10$NCG4wuQ34C.BPC4/k8fpU.OB1J.WfLrpwoyhNr.uFC0OuUCFT10/K', '2021-04-21 08:21:05'),
('c9a3eb2d-20d7-4ff2-bcbe-136bce7030cb', 'ADE', 'NEVIYANI', '19051397018', '2002-02-02', 'P', 'D4 MANAJEMEN INFORMATIKA', 'TEKNIK INFORMATIKA', 'JL. SIDOARJO RAYA NO.100', 'SIDOARJO', 'JAWA TIMUR', '089519802900', '607fdc5f31a99.jpg', 'ade.19018@mhs.unesa.ac.id', '$2y$10$Y6GV3TvMJxBclmMboe/wWO7O2QfDjh17qXmfoT9eawjwhAoAz/RnO', '2021-04-21 08:01:59'),
('e1abe4ad-fb55-4ead-bb97-ce54db5f5938', 'MUHAMMAD', 'AZIIZ PRANAJA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'muhammadaziiz.19030@mhs.unesa.ac.id', '$2y$10$Cu27Po3AY8fLxphvTH4t1ee.WypJOVBcg4MhtUEoT6mip5GaDubqC', '2021-04-21 08:30:15'),
('f2480f02-10a4-4b11-8179-e7755a0cd36a', 'ALVIRA', 'RHIZA RIDWANI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'alvira.19007@mhs.unesa.ac.id', '$2y$10$8mWISowXKShBt09Hj2B4QeXVrwmxd4x7cLl7aP0.l.gedcveTSFFG', '2021-04-21 08:21:29'),
('f2f5016c-fe23-40b8-9bad-a7caa8051ceb', 'ANDINI', 'RAMADHANTI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'andini.19029@mhs.unesa.ac.id', '$2y$10$JCcqPcEHsVvBZuWh4pW3SOblQlhtYV3MBbhU/.5SaFNDORnTEjG5i', '2021-04-21 08:29:46'),
('f81cd39b-619c-40ec-9de3-da313501789a', 'AMALIA', 'FANDANING TYAS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'amalia.19012@mhs.unesa.ac.id', '$2y$10$UAM.dClaj9oZCtEzX67uwOGM9RZVkzXeJKTIFCklycaS4jI3rOyga', '2021-04-21 08:23:39');

-- --------------------------------------------------------

--
-- Table structure for table `tb_bio_tester`
--

CREATE TABLE `tb_bio_tester` (
  `id_tester` varchar(50) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `nip` char(50) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `ttl` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kab_kota` varchar(50) DEFAULT NULL,
  `provinsi` varchar(50) DEFAULT NULL,
  `telepon` char(15) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `email_tester` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tgl_daftar` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_bio_tester`
--

INSERT INTO `tb_bio_tester` (`id_tester`, `nama_lengkap`, `nip`, `jabatan`, `ttl`, `jenis_kelamin`, `alamat`, `kab_kota`, `provinsi`, `telepon`, `foto`, `email_tester`, `password`, `tgl_daftar`) VALUES
('2cc38622-bff1-4938-921c-373864098fa5', 'REZA KURNIA S', '19051397021', 'SOFTWARE DEVELOPER', '2001-01-01', 'L', 'JL. JOMBANG RAYA NO.100', 'JOMBANG', 'JAWA TIMUR', '089509800192', '607fde9c5fb7e.jpg', 'reza.19021@mhs.unesa.ac.id', '$2y$10$rkWkyU2rIZdYCUXTuvsis.8yZCBj3Qp6AXi0WVvTMVlePfQ03L42i', '2021-04-21 08:08:18'),
('2da6fb2b-cea2-4cdb-9806-6fa5306753d9', 'KHARISMAHARANI AISYAH PUTRI', '19051397015', 'SEO SPECIALIST', '2003-03-03', 'P', 'JL. SIDOARJO RAYA NO.100', 'SIDOARJO', 'JAWA TIMUR', '08958290123', '6086e42add8dd.jpeg', 'kharismaharani.19015@mhs.unesa.ac.id', '$2y$10$tcRAzXy3dVlafyk/pKdq7uHwyXqJ3/sTQFZYMA5IMy6lTwWBPO03y', '2021-04-21 08:10:34'),
('34956c6f-8dcb-470b-bc15-30db69a4db1c', 'NOVAN ARI PRADANA', '19051397013', 'SECURITY ENGINEER', '2004-04-04', 'L', 'JL. SURABAYA RAYA NO.100', 'SURABAYA', 'JAWA TIMUR', '089582982212', '607fe47c09a4e.jpeg', 'novan.19013@mhs.unesa.ac.id', '$2y$10$1TMkHEB5jf0Svj2FrpkcMudzRJX2H73mSn9StKqjh.St7w2v/1De2', '2021-04-21 08:33:55'),
('cf7e1fc7-04aa-478d-9470-08f173fcdde7', 'HAFIDH SOEKMA ARDIANSYAH', '19051397031', 'WEB DEVELOPER', '2002-02-02', 'L', 'JL. PASURUAN RAYA NO.100', 'PASURUAN', 'JAWA TIMUR', '089528901922', '607fdee9f2442.jpg', 'hafidh.19031@mhs.unesa.ac.id', '$2y$10$VdH5pKDo7y9xUlbwv9p5q.k34aqgHkoBqTpy6PQjVviDQcLjnfIhi', '2021-04-21 08:09:37');

-- --------------------------------------------------------

--
-- Table structure for table `tb_comments`
--

CREATE TABLE `tb_comments` (
  `id_comments` int(11) NOT NULL,
  `id_product` varchar(50) DEFAULT NULL,
  `id_tester` varchar(50) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `tgl_comment` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_comments`
--

INSERT INTO `tb_comments` (`id_comments`, `id_product`, `id_tester`, `comment`, `tgl_comment`) VALUES
(8, '33b46dd0-fca5-4a4f-8748-28de55d25862', '2da6fb2b-cea2-4cdb-9806-6fa5306753d9', 'MENURUT SAYA, UNTUK TAMPILAN VISUAL UNTUK USER SUDAH CUKUP BAGUS, LALU NAVBAR JUGA SUDAH ADA SEHINGGA MUDAH UNTUK PENGOPERASIANNYA', '2021-04-23 07:49:06'),
(9, '33b46dd0-fca5-4a4f-8748-28de55d25862', '2da6fb2b-cea2-4cdb-9806-6fa5306753d9', 'OIYA LUPA, UNTUK APLIKASI WEB YANG DIBUAT JUGA NANTINYA PASTI SANGAT MEMBANTU MASYARAKAT', '2021-04-23 07:50:02'),
(10, '33b46dd0-fca5-4a4f-8748-28de55d25862', '2cc38622-bff1-4938-921c-373864098fa5', 'TAMPILAN SUDAH CUKUP MEMUASKAN, MUNGKIN UNTUK KEDEPANNYA BISA LEBIH DI PERHATIKAN BUG AND REPORT NYA', '2021-04-23 07:50:55'),
(11, '9945a803-59fc-4c65-b9c4-8aeeee4ce8b7', '2da6fb2b-cea2-4cdb-9806-6fa5306753d9', 'FRONT-END YANG ANDA BUAT SANGAT BAGUS DAN MENGESANKAN, DENGAN TAMPILAN SEPERTI ITU SAYA YAKIN MUDAH UNTUK MENGAIT PARA CUSTOMER\r\n', '2021-04-24 17:56:34');

-- --------------------------------------------------------

--
-- Table structure for table `tb_products`
--

CREATE TABLE `tb_products` (
  `id_product` varchar(50) NOT NULL,
  `nama_tim` varchar(50) DEFAULT NULL,
  `id_mhs` varchar(50) DEFAULT NULL,
  `judul_prod` varchar(50) DEFAULT NULL,
  `deskripsi_prod` text DEFAULT NULL,
  `tgl_upload` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_products`
--

INSERT INTO `tb_products` (`id_product`, `nama_tim`, `id_mhs`, `judul_prod`, `deskripsi_prod`, `tgl_upload`) VALUES
('09011402-f081-48a7-9a20-57aa691dc23f', 'D4 MI 2019 A - KEL D', '42702a98-9ca6-4ae4-9b72-b16a47b0e46b', 'UNDRAW', 'UNDRAW MERUPAKAN APLIKASI YANG KAMI BANGUN GUNA MENYEDIAKAN KEPERLUAN PARA DEVELOPER WEB DALAM MEMBANGUN WEBSITE-NYA. APLIKASI INI MENYEDIAKAN BERBAGAI MACAM ICON DAN VECTOR, SEHINGGA DAPAT MEMBUAT TAMPILAN WEBSITE TERLIHAT ELEGANT', '2021-04-26 19:00:18'),
('31890fdf-feaa-4627-9140-2dcb8d641e52', 'D4 MI 2019 A - KEL D', '42702a98-9ca6-4ae4-9b72-b16a47b0e46b', 'CODE SAYA', 'CODE SAYA MERUPAKAN PLATFORM BELAJAR ONLINE DIMANA MATERI YANG DIAJARKAN BERKAITAN DENGAN IT. DI ERA SEKARANG, BELAJAR BUKANLAH MERUPAKAN HAL YANG SULIT DIKARENAKAN SUMBER MAUPUN FASILITAS PADA MASA SEKARANG SANGATLAH MUDAH UNTUK DIJANGKAU, OLEH KARENA ITU UNTUK MENUNJANG PARA ROOKIE DALAM MEMPELAJARI IT, MAKA APLIKASI INI KITA BUAT', '2021-04-26 19:05:13'),
('33b46dd0-fca5-4a4f-8748-28de55d25862', 'D4 MI 2019 A - KEL D', '42702a98-9ca6-4ae4-9b72-b16a47b0e46b', 'LOKER ONLINE', 'LOKER ONLINE ADALAH APLIKASI YANG DIBUAT GUNA MEMBANTU PARA PEMILIK PERUSAHAAN DALAM MENDAPATKAN KARYAWAN, DAN JUGA UNTUK PARA KARYAWAN YANG SEDANG MENCARI SEBUAH PERKERJAAN. DALAM APLIKASI INI, PARA PEMILIK PERUSAHAAN DAPAT MENAMPILKAN PADA WEB UNTUK PEKERJAAN YANG SEDANG MEMBUTUHKAN KARYAWAN, DIMANA DOMISILI TEMPAT INI BERADA, DAN BERAPA GAJI YANG DIBERIKAN, SEDANGKAN UNTUK PEKERJA, KITA DAPAT SEARCH DAERAH, JENIS PEKERJAAN, ATAU KISARAN GAJI YANG DIINGINKAN', '2021-04-22 13:09:35'),
('3cb26796-0ea7-48a7-a689-ef787b7b44a2', 'D4 MI 2019 A - KEL D', '42702a98-9ca6-4ae4-9b72-b16a47b0e46b', 'SPOTIFY', 'SPOTIFY MERUPAKAN PLATFORM BERSANTAI DIMANA APLIKASI INI MENYEDIAKAN BERBAGAI MACAM MUSIC, MAUPUN PODCAST, BERBEDA DENGAN YOUTUBE APLIKASI INI HANYA MENYEDIAKAN AUDIO SAJA TANPA VISUAL. AKAN TETAPI APLIKASI INI SANGAT NIKMAT UNTUK BERSANTAI DIKARENAKAN TIDAK TERDAPAT IKLAN DIDALAMNYA', '2021-04-26 19:11:51'),
('3e3991a6-52e6-422c-ad0f-7728961c332a', 'D4 MI 2019 A - KEL D', '42702a98-9ca6-4ae4-9b72-b16a47b0e46b', 'MOKARO', 'MOOKARO DICIPTAKAN GUNA MEMBANTU PARA DEVELOP ATAUPUN PELAJAR DALAM BELAJAR TENTANG DATABASE, KARENA APLKASI INI DAPAT MENYEDIAKAN DATA RANDOM SESUAI APA YANG MEREKA INGINKAN SEHINGGA UNTUK KEDEPANNYA MEREKA TINGGAL MENGINPUTKAN FIELD YANG DIINGINKAN DAN MENGIMPORTNYA PADA DATABASE APAPUN', '2021-04-26 18:55:21'),
('8feef41e-05cf-4fa5-b7a1-f13da5405567', 'D4 MI 2019 A - KEL D', '42702a98-9ca6-4ae4-9b72-b16a47b0e46b', 'GHITUB', 'GHITUB ADALAH APLIKASI YANG DIBUAT UNTUK PENGEMBANGAN PRODUCT ATAUPUN APLIKASI, DIMANA AKSES YANG DIBERIKAN DAPAT DIGUNAKAN OLEH SEMUA ORANG, SEHINGGA KETIKA KITA MEMILIKI KESULITAN, BUG ERROR ATAU SEBAGAINYA, ORANG DAPAT DENGAN MUDAH MEMBANTU DAN MEMBERIKAN CODE YANG BENAR. SEHINGGA IZIN YANG DIBERIKAN SANGAT UNIVERSAL. APLIKASI INI SANGAT BERGUNA BAGI PARA DEVELOPER', '2021-04-26 18:51:23'),
('9945a803-59fc-4c65-b9c4-8aeeee4ce8b7', 'D4 MI 2019 A - KEL 1', '4d4c50ea-6625-45d6-9c26-13997ca75f06', 'FILMI', 'WEB INI MERUPAKAN WEBSITE YANG MENAMPILKAN ATAU MENYUGUHKAN BERBAGAI MACAM FILM DARI BERBAGAI MACAM GENRE MULAI DARI FILM KELUARAN LAMA SAMPAI FILM KELUARAN YANG BARU, UNTUK AKSES PADA WEB INI SANGAT MUDAH DIMANA USER HANYA PERLU UNTUK MENDAFTAR SAJA, LALU UNTUK KEDEPANNYA MUNGKIN AKAN DI KENAI BIAYA UNTUK LAYANAN BULANANNYA. WEBSITE INI SANGAT DIREKOMENDASIKAN BAGI KALIAN YANG JENUH BERADA DIRUMAH, ATAU BINGUNG UNTUK MELAKUKAN SESUATU', '2021-04-22 11:30:54'),
('ba8c96a8-c366-4656-9a45-90accf20a305', 'D4 MI 2019 A - KEL D', '42702a98-9ca6-4ae4-9b72-b16a47b0e46b', 'IQ-CERTIFICATE', 'IQ-CETIFICATE MERUPAKAN APLIKASI UNTUK MELAKUKAN SERANGKAIAN DALAM TES IQ. TES IQ SANGAT PENTING DIAKRENAKAN DAPAT MENGUKUR KEMAMPUAN MAKSIMAL DARIPADA KAPASITAS OTAK YANG KITA MILIKI, PADA APLIKASI IN JUGA AKAN MEMBERIKAN CERTIFICATE GUNA SEBGAI BUKTI DARIPADA USER YANG TELAH MELAKSANAKAN TES', '2021-04-26 18:53:27');

-- --------------------------------------------------------

--
-- Table structure for table `tb_product_members`
--

CREATE TABLE `tb_product_members` (
  `id_product_members` int(11) NOT NULL,
  `id_product` varchar(50) DEFAULT NULL,
  `id_mhs` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_product_members`
--

INSERT INTO `tb_product_members` (`id_product_members`, `id_product`, `id_mhs`) VALUES
(87, '9945a803-59fc-4c65-b9c4-8aeeee4ce8b7', 'c9a3eb2d-20d7-4ff2-bcbe-136bce7030cb'),
(88, '9945a803-59fc-4c65-b9c4-8aeeee4ce8b7', 'b09294f3-a3e8-4959-8ec1-9135e9c0c1fa'),
(89, '9945a803-59fc-4c65-b9c4-8aeeee4ce8b7', '42702a98-9ca6-4ae4-9b72-b16a47b0e46b'),
(91, '33b46dd0-fca5-4a4f-8748-28de55d25862', 'c9a3eb2d-20d7-4ff2-bcbe-136bce7030cb'),
(92, '33b46dd0-fca5-4a4f-8748-28de55d25862', 'b09294f3-a3e8-4959-8ec1-9135e9c0c1fa'),
(93, '33b46dd0-fca5-4a4f-8748-28de55d25862', '4d4c50ea-6625-45d6-9c26-13997ca75f06'),
(161, '8feef41e-05cf-4fa5-b7a1-f13da5405567', 'c9a3eb2d-20d7-4ff2-bcbe-136bce7030cb'),
(162, '8feef41e-05cf-4fa5-b7a1-f13da5405567', 'b09294f3-a3e8-4959-8ec1-9135e9c0c1fa'),
(163, '8feef41e-05cf-4fa5-b7a1-f13da5405567', '4d4c50ea-6625-45d6-9c26-13997ca75f06'),
(164, 'ba8c96a8-c366-4656-9a45-90accf20a305', 'c9a3eb2d-20d7-4ff2-bcbe-136bce7030cb'),
(165, 'ba8c96a8-c366-4656-9a45-90accf20a305', 'b09294f3-a3e8-4959-8ec1-9135e9c0c1fa'),
(166, 'ba8c96a8-c366-4656-9a45-90accf20a305', '4d4c50ea-6625-45d6-9c26-13997ca75f06'),
(167, '3e3991a6-52e6-422c-ad0f-7728961c332a', 'c9a3eb2d-20d7-4ff2-bcbe-136bce7030cb'),
(168, '3e3991a6-52e6-422c-ad0f-7728961c332a', 'b09294f3-a3e8-4959-8ec1-9135e9c0c1fa'),
(169, '3e3991a6-52e6-422c-ad0f-7728961c332a', '4d4c50ea-6625-45d6-9c26-13997ca75f06'),
(170, '09011402-f081-48a7-9a20-57aa691dc23f', 'c9a3eb2d-20d7-4ff2-bcbe-136bce7030cb'),
(171, '09011402-f081-48a7-9a20-57aa691dc23f', 'b09294f3-a3e8-4959-8ec1-9135e9c0c1fa'),
(172, '09011402-f081-48a7-9a20-57aa691dc23f', '4d4c50ea-6625-45d6-9c26-13997ca75f06'),
(173, '31890fdf-feaa-4627-9140-2dcb8d641e52', 'c9a3eb2d-20d7-4ff2-bcbe-136bce7030cb'),
(174, '31890fdf-feaa-4627-9140-2dcb8d641e52', 'b09294f3-a3e8-4959-8ec1-9135e9c0c1fa'),
(175, '31890fdf-feaa-4627-9140-2dcb8d641e52', '4d4c50ea-6625-45d6-9c26-13997ca75f06'),
(176, '3cb26796-0ea7-48a7-a689-ef787b7b44a2', 'c9a3eb2d-20d7-4ff2-bcbe-136bce7030cb'),
(177, '3cb26796-0ea7-48a7-a689-ef787b7b44a2', 'b09294f3-a3e8-4959-8ec1-9135e9c0c1fa'),
(178, '3cb26796-0ea7-48a7-a689-ef787b7b44a2', '4d4c50ea-6625-45d6-9c26-13997ca75f06');

-- --------------------------------------------------------

--
-- Table structure for table `tb_product_thumbnails`
--

CREATE TABLE `tb_product_thumbnails` (
  `id_product_thumbnails` int(11) NOT NULL,
  `id_product` varchar(50) NOT NULL,
  `thumb_prod` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_product_thumbnails`
--

INSERT INTO `tb_product_thumbnails` (`id_product_thumbnails`, `id_product`, `thumb_prod`) VALUES
(18, '9945a803-59fc-4c65-b9c4-8aeeee4ce8b7', '60815e6ee6ef3.jpeg '),
(19, '9945a803-59fc-4c65-b9c4-8aeeee4ce8b7', '60815e6f2d2ef.png '),
(20, '9945a803-59fc-4c65-b9c4-8aeeee4ce8b7', '60815e6f046f8.png '),
(21, '9945a803-59fc-4c65-b9c4-8aeeee4ce8b7', '60815e6f107c2.png'),
(22, '33b46dd0-fca5-4a4f-8748-28de55d25862', '6081758fe0ab9.png'),
(23, '33b46dd0-fca5-4a4f-8748-28de55d25862', '6081758fa726d.png '),
(24, '33b46dd0-fca5-4a4f-8748-28de55d25862', '6081758fc9b68.png'),
(25, '33b46dd0-fca5-4a4f-8748-28de55d25862', '6081758fbd687.png '),
(50, '8feef41e-05cf-4fa5-b7a1-f13da5405567', '60870bab22c20.png'),
(51, '8feef41e-05cf-4fa5-b7a1-f13da5405567', '60870bab404f4.png'),
(52, '8feef41e-05cf-4fa5-b7a1-f13da5405567', '60870bab709fe.png'),
(53, '8feef41e-05cf-4fa5-b7a1-f13da5405567', '60870bab8656f.png'),
(54, 'ba8c96a8-c366-4656-9a45-90accf20a305', '60870c27b76ef.png'),
(55, 'ba8c96a8-c366-4656-9a45-90accf20a305', '60870c27d8e58.png'),
(56, 'ba8c96a8-c366-4656-9a45-90accf20a305', '60870c27e53fc.png'),
(57, 'ba8c96a8-c366-4656-9a45-90accf20a305', '60870c280cff5.png'),
(58, '3e3991a6-52e6-422c-ad0f-7728961c332a', '60870c99b826d.png'),
(59, '3e3991a6-52e6-422c-ad0f-7728961c332a', '60870c99c1765.png'),
(60, '09011402-f081-48a7-9a20-57aa691dc23f', '60870dc2a60a9.png'),
(61, '09011402-f081-48a7-9a20-57aa691dc23f', '60870dc2deaa8.png'),
(62, '31890fdf-feaa-4627-9140-2dcb8d641e52', '60870ee90e558.png'),
(63, '31890fdf-feaa-4627-9140-2dcb8d641e52', '60870ee91a4c1.png'),
(64, '31890fdf-feaa-4627-9140-2dcb8d641e52', '60870ee9328d2.png'),
(65, '31890fdf-feaa-4627-9140-2dcb8d641e52', '60870ee93d3fb.png'),
(66, '3cb26796-0ea7-48a7-a689-ef787b7b44a2', '60871078d8408.png'),
(67, '3cb26796-0ea7-48a7-a689-ef787b7b44a2', '60871079202b5.png'),
(68, '3cb26796-0ea7-48a7-a689-ef787b7b44a2', '608710795063f.png'),
(69, '3cb26796-0ea7-48a7-a689-ef787b7b44a2', '608710795c53f.png');

-- --------------------------------------------------------

--
-- Table structure for table `tb_reset_mhs`
--

CREATE TABLE `tb_reset_mhs` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `id_mhs` varchar(50) NOT NULL,
  `otp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_reset_tester`
--

CREATE TABLE `tb_reset_tester` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `id_tester` varchar(50) NOT NULL,
  `otp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_score`
--

CREATE TABLE `tb_score` (
  `id_score` int(11) NOT NULL,
  `id_product` varchar(50) NOT NULL,
  `id_tester` varchar(50) NOT NULL,
  `score` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_score`
--

INSERT INTO `tb_score` (`id_score`, `id_product`, `id_tester`, `score`) VALUES
(23, '33b46dd0-fca5-4a4f-8748-28de55d25862', 'cf7e1fc7-04aa-478d-9470-08f173fcdde7', '52'),
(26, '9945a803-59fc-4c65-b9c4-8aeeee4ce8b7', 'cf7e1fc7-04aa-478d-9470-08f173fcdde7', '61'),
(27, '9945a803-59fc-4c65-b9c4-8aeeee4ce8b7', '2da6fb2b-cea2-4cdb-9806-6fa5306753d9', '100'),
(28, '9945a803-59fc-4c65-b9c4-8aeeee4ce8b7', '2cc38622-bff1-4938-921c-373864098fa5', '100'),
(29, '3cb26796-0ea7-48a7-a689-ef787b7b44a2', '2da6fb2b-cea2-4cdb-9806-6fa5306753d9', '91'),
(30, '31890fdf-feaa-4627-9140-2dcb8d641e52', '2da6fb2b-cea2-4cdb-9806-6fa5306753d9', '85'),
(31, '8feef41e-05cf-4fa5-b7a1-f13da5405567', '2da6fb2b-cea2-4cdb-9806-6fa5306753d9', '100'),
(32, '3cb26796-0ea7-48a7-a689-ef787b7b44a2', '2cc38622-bff1-4938-921c-373864098fa5', '100'),
(33, '31890fdf-feaa-4627-9140-2dcb8d641e52', '2cc38622-bff1-4938-921c-373864098fa5', '76'),
(34, '8feef41e-05cf-4fa5-b7a1-f13da5405567', '2cc38622-bff1-4938-921c-373864098fa5', '76'),
(35, '3cb26796-0ea7-48a7-a689-ef787b7b44a2', 'cf7e1fc7-04aa-478d-9470-08f173fcdde7', '71'),
(36, '33b46dd0-fca5-4a4f-8748-28de55d25862', '2da6fb2b-cea2-4cdb-9806-6fa5306753d9', '100');

-- --------------------------------------------------------

--
-- Table structure for table `tb_survey`
--

CREATE TABLE `tb_survey` (
  `id_survey` int(8) NOT NULL,
  `id_mhs` varchar(50) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_survey`
--

INSERT INTO `tb_survey` (`id_survey`, `id_mhs`, `status`) VALUES
(1, '0bf85eb0-7997-4573-a0bd-e64c658f8ecf', 'SATISFYING'),
(2, '3de7a905-195a-4651-8615-9a464f15b68b', 'ENOUGH'),
(3, '4d4c50ea-6625-45d6-9c26-13997ca75f06', 'ENOUGH'),
(4, '6a179207-cd44-444d-939d-4247ac208b4f', 'LESS'),
(8, '42702a98-9ca6-4ae4-9b72-b16a47b0e46b', 'ENOUGH'),
(10, 'b09294f3-a3e8-4959-8ec1-9135e9c0c1fa', 'LESS'),
(11, 'e1abe4ad-fb55-4ead-bb97-ce54db5f5938', 'ENOUGH');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tb_bio_mhs`
--
ALTER TABLE `tb_bio_mhs`
  ADD PRIMARY KEY (`id_mhs`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indexes for table `tb_bio_tester`
--
ALTER TABLE `tb_bio_tester`
  ADD PRIMARY KEY (`id_tester`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `tb_comments`
--
ALTER TABLE `tb_comments`
  ADD PRIMARY KEY (`id_comments`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_tester` (`id_tester`);

--
-- Indexes for table `tb_products`
--
ALTER TABLE `tb_products`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_mhs` (`id_mhs`);

--
-- Indexes for table `tb_product_members`
--
ALTER TABLE `tb_product_members`
  ADD PRIMARY KEY (`id_product_members`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_mhs` (`id_mhs`);

--
-- Indexes for table `tb_product_thumbnails`
--
ALTER TABLE `tb_product_thumbnails`
  ADD PRIMARY KEY (`id_product_thumbnails`),
  ADD KEY `pt_product` (`id_product`);

--
-- Indexes for table `tb_reset_mhs`
--
ALTER TABLE `tb_reset_mhs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mhs` (`id_mhs`);

--
-- Indexes for table `tb_reset_tester`
--
ALTER TABLE `tb_reset_tester`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tester` (`id_tester`);

--
-- Indexes for table `tb_score`
--
ALTER TABLE `tb_score`
  ADD PRIMARY KEY (`id_score`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_tester` (`id_tester`);

--
-- Indexes for table `tb_survey`
--
ALTER TABLE `tb_survey`
  ADD PRIMARY KEY (`id_survey`),
  ADD KEY `id_mhs` (`id_mhs`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_comments`
--
ALTER TABLE `tb_comments`
  MODIFY `id_comments` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tb_product_members`
--
ALTER TABLE `tb_product_members`
  MODIFY `id_product_members` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `tb_product_thumbnails`
--
ALTER TABLE `tb_product_thumbnails`
  MODIFY `id_product_thumbnails` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tb_reset_mhs`
--
ALTER TABLE `tb_reset_mhs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_reset_tester`
--
ALTER TABLE `tb_reset_tester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_score`
--
ALTER TABLE `tb_score`
  MODIFY `id_score` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tb_survey`
--
ALTER TABLE `tb_survey`
  MODIFY `id_survey` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_comments`
--
ALTER TABLE `tb_comments`
  ADD CONSTRAINT `tc_product` FOREIGN KEY (`id_product`) REFERENCES `tb_products` (`id_product`) ON DELETE CASCADE,
  ADD CONSTRAINT `tc_tester` FOREIGN KEY (`id_tester`) REFERENCES `tb_bio_tester` (`id_tester`) ON DELETE NO ACTION;

--
-- Constraints for table `tb_products`
--
ALTER TABLE `tb_products`
  ADD CONSTRAINT `p_mhs` FOREIGN KEY (`id_mhs`) REFERENCES `tb_bio_mhs` (`id_mhs`) ON DELETE NO ACTION;

--
-- Constraints for table `tb_product_members`
--
ALTER TABLE `tb_product_members`
  ADD CONSTRAINT `pm_mhs` FOREIGN KEY (`id_mhs`) REFERENCES `tb_bio_mhs` (`id_mhs`) ON DELETE NO ACTION,
  ADD CONSTRAINT `pm_product` FOREIGN KEY (`id_product`) REFERENCES `tb_products` (`id_product`) ON DELETE CASCADE;

--
-- Constraints for table `tb_product_thumbnails`
--
ALTER TABLE `tb_product_thumbnails`
  ADD CONSTRAINT `pt_product` FOREIGN KEY (`id_product`) REFERENCES `tb_products` (`id_product`) ON DELETE CASCADE;

--
-- Constraints for table `tb_reset_mhs`
--
ALTER TABLE `tb_reset_mhs`
  ADD CONSTRAINT `rm_mhs` FOREIGN KEY (`id_mhs`) REFERENCES `tb_bio_mhs` (`id_mhs`) ON DELETE CASCADE;

--
-- Constraints for table `tb_reset_tester`
--
ALTER TABLE `tb_reset_tester`
  ADD CONSTRAINT `rt_tester` FOREIGN KEY (`id_tester`) REFERENCES `tb_bio_tester` (`id_tester`) ON DELETE CASCADE;

--
-- Constraints for table `tb_score`
--
ALTER TABLE `tb_score`
  ADD CONSTRAINT `ts_product` FOREIGN KEY (`id_product`) REFERENCES `tb_products` (`id_product`) ON DELETE CASCADE,
  ADD CONSTRAINT `ts_tester` FOREIGN KEY (`id_tester`) REFERENCES `tb_bio_tester` (`id_tester`) ON DELETE NO ACTION;

--
-- Constraints for table `tb_survey`
--
ALTER TABLE `tb_survey`
  ADD CONSTRAINT `s_mhs` FOREIGN KEY (`id_mhs`) REFERENCES `tb_bio_mhs` (`id_mhs`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
