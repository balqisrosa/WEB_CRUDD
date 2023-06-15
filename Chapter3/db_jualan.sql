-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Bulan Mei 2023 pada 06.41
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_jualan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `admin_telp` varchar(20) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`admin_id`, `admin_name`, `username`, `password`, `admin_telp`, `admin_email`, `admin_address`) VALUES
(1, 'BaRa Store ', 'bara', '0192023a7bbd73250516f069df18b500', '+628814570820', 'barastore@gmail.com', 'Jl. Sariasih No. 54 Sarijadi Bandung, 40151, Jawa Barat Indonesia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_category`
--

CREATE TABLE `tb_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_category`
--

INSERT INTO `tb_category` (`category_id`, `category_name`) VALUES
(9, 'JACKET'),
(10, 'SKIRT'),
(11, 'HIGHWAIST'),
(12, 'HOODIE'),
(13, 'T-SHIRT '),
(15, 'JEANS'),
(16, 'SEPATU');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_product`
--

CREATE TABLE `tb_product` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_description` text NOT NULL,
  `product_image` varchar(100) NOT NULL,
  `product_status` tinyint(1) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_product`
--

INSERT INTO `tb_product` (`product_id`, `category_id`, `product_name`, `product_price`, `product_description`, `product_image`, `product_status`, `date_created`) VALUES
(2, 9, 'Jaket', 150000, '<p>Jaket Pria</p>\r\n', 'produk1673192096.jfif', 1, '2023-01-11 09:42:31'),
(3, 14, 'Dress ', 100000, '<p>Dress Aestetic</p>\r\n', 'produk1673192169.jfif', 1, '2023-01-11 09:42:19'),
(4, 10, 'Rok wanita', 90000, '<p>Rok Aestetic</p>\r\n', 'produk1673192215.jfif', 1, '2023-01-11 09:41:33'),
(7, 10, 'Rok ', 99000, '<p>Rok vintage</p>\r\n', 'produk1673358645.jfif', 1, '2023-01-11 09:41:20'),
(9, 12, 'Jaket ', 200000, '<p>Jaket aestetic</p>\r\n', 'produk1673358837.jfif', 1, '2023-01-11 09:40:59'),
(10, 9, 'Jaket', 300000, '<p>tess</p>\r\n', 'produk1673423751.jfif', 1, '2023-01-11 10:24:20'),
(11, 13, 'T-SHIRT ', 90000, '<p>T-shirt ori dari korea</p>\r\n', 'produk1673484317.jfif', 1, '2023-01-12 00:45:17'),
(12, 11, 'Highwaist', 200000, '<p>Hightwaist</p>\r\n', 'produk1673484375.jfif', 1, '2023-01-12 00:46:31'),
(13, 15, 'Jeans', 99000, '<p>jeans baru</p>\r\n', 'produk1673496593.jfif', 1, '2023-01-12 04:09:53'),
(14, 16, 'SEPATU', 500000, '<p>JUAL SEPATU MURAH ORI</p>\r\n', 'produk1673496803.jfif', 1, '2023-01-21 00:13:52');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indeks untuk tabel `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indeks untuk tabel `tb_product`
--
ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
