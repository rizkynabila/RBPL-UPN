-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2024 at 10:18 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barokah_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `kode_produk` varchar(6) NOT NULL,
  `nama_produk` varchar(50) NOT NULL,
  `harga_produk` int(10) NOT NULL,
  `stok_produk` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`kode_produk`, `nama_produk`, `harga_produk`, `stok_produk`) VALUES
('ACS001', 'Speaker Masteran Basic', 300000, 37),
('ACS002', 'Speaker Masteran Special', 350000, 100),
('ACS003', 'Stoper Sangkar Love Bird', 30000, 18),
('ACS004', 'Stoper Sangkar Kotak', 15000, 132),
('ACS005', 'Stoper Sangkar Murai', 20000, 72),
('ACS006', 'Jeruji Fiber C', 50000, 84),
('ACS007', 'Tangkringan Parrot', 65000, 15);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `kode_transaksi` varchar(7) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `nama_pembeli` varchar(100) NOT NULL,
  `total_harga` int(20) NOT NULL,
  `total_dibayar` int(20) NOT NULL,
  `kembalian` int(20) NOT NULL,
  `jenis_pembayaran` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`kode_transaksi`, `tanggal_transaksi`, `nama_pembeli`, `total_harga`, `total_dibayar`, `kembalian`, `jenis_pembayaran`) VALUES
('BR00001', '2024-06-18', 'attar', 500000, 600000, 100000, 'Tunai'),
('BR00002', '2024-06-18', 'Nadia', 3500000, 4000000, 500000, 'Tunai'),
('BR00003', '2024-06-18', 'Bambang', 150000, 200000, 50000, 'Tunai');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `kode_transaksi_detail` varchar(8) NOT NULL,
  `kode_transaksi` varchar(7) NOT NULL,
  `kode_produk` varchar(6) NOT NULL,
  `jumlah_produk` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`kode_transaksi_detail`, `kode_transaksi`, `kode_produk`, `jumlah_produk`) VALUES
('BRT00001', 'BR00001', 'Acs001', 2),
('BRT00002', 'BR00002', 'ACS002', 10),
('BRT00003', 'BR00003', 'ACS003', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(3) NOT NULL,
  `nama` varchar(10) NOT NULL,
  `username` varchar(12) NOT NULL,
  `password` varchar(15) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `nama`, `username`, `password`, `role`) VALUES
('U01', 'Susi', 'Susi', 'susi123', 'Owner'),
('U02', 'Eko', 'Eko', 'eko123', 'Admin'),
('U03', 'Didit', 'Didit', 'didit123', 'Kasir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`kode_produk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`kode_transaksi`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`kode_transaksi_detail`),
  ADD KEY `kode_produk` (`kode_produk`),
  ADD KEY `kode_transaksi` (`kode_transaksi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`kode_produk`) REFERENCES `produk` (`kode_produk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
