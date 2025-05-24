-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: May 12, 2025 at 06:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_penjualan_toko_dafa_tani`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_detail`, `id_penjualan`, `id_produk`, `jumlah`, `harga`, `subtotal`, `status_dihapus`) VALUES
(1, 1, 1, 1, 95000.00, 95000.00, 1),
(2, 2, 1, 1, 95000.00, 95000.00, 1),
(7, 3, 1, 1, 95000.00, 95000.00, 0),
(8, 4, 20, 1, 25000.00, 25000.00, 0),
(9, 5, 20, 1, 25000.00, 25000.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `detail_stok_masuk`
--

CREATE TABLE `detail_stok_masuk` (
  `id_detail_stok_masuk` int(11) NOT NULL,
  `id_stok_masuk` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_beli` decimal(12,2) NOT NULL,
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_stok_masuk`
--

INSERT INTO `detail_stok_masuk` (`id_detail_stok_masuk`, `id_stok_masuk`, `id_produk`, `jumlah`, `harga_beli`, `status_dihapus`) VALUES
(1, 1, 1, 1, 65000.00, 1),
(2, 1, 21, 2, 23000.00, 1),
(6, 4, 1, 1, 65000.00, 0),
(11, 2, 20, 12, 21000.00, 0),
(12, 2, 1, 12, 65000.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `status_dihapus`) VALUES
(1, 'Pupuk Kering', 0),
(2, 'Pupuk Organik', 0),
(3, 'Pupuk Khusus Bawang', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `dibuat_pada` datetime DEFAULT current_timestamp(),
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `no_hp`, `alamat`, `dibuat_pada`, `status_dihapus`) VALUES
(1, 'Arif', '081232124654', 'Padang', '2025-05-04 22:03:29', 0),
(2, 'Andi', '081232124565', 'Solok', '2025-05-04 22:03:42', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `nama_pengguna` varchar(50) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `peran` enum('admin','kasir','pemilik') NOT NULL,
  `dibuat_pada` datetime DEFAULT current_timestamp(),
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_lengkap`, `nama_pengguna`, `kata_sandi`, `no_hp`, `alamat`, `jenis_kelamin`, `peran`, `dibuat_pada`, `status_dihapus`) VALUES
(1, 'Admin Utama', 'admin', '$2y$10$TSxrwy02BupTyuKxYZhi8etGqBjF.K//4QSqGkJTrhzoUJH9FNTVq', '081236644545', 'Padang', 'Laki-laki', 'admin', '2025-05-03 20:42:02', 0),
(23, 'Pemilik', 'pemilik', '$2y$10$ncXJJH60Nba8lreWWBWWzuix4xuRJzo7deK3HqFjkddVSI9PJ9X5O', '081232121232', 'Padang', 'Laki-laki', 'pemilik', '2025-05-04 00:27:19', 0),
(24, 'Kasir', 'kasir', '$2y$10$3Aa.XxLRet898OyJazxaOu97833LBejskCmcKN4oW1hwNXM0EgyCa', '081332123212', 'Padang', 'Laki-laki', 'kasir', '2025-05-04 00:27:41', 0);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `no_faktur_penjualan` varchar(100) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `total` decimal(12,2) NOT NULL,
  `diskon` decimal(12,2) DEFAULT 0.00,
  `bayar` decimal(12,2) NOT NULL,
  `kembalian` decimal(12,2) DEFAULT 0.00,
  `tanggal` datetime DEFAULT current_timestamp(),
  `id_pengguna` int(11) DEFAULT NULL,
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `no_faktur_penjualan`, `id_pelanggan`, `total`, `diskon`, `bayar`, `kembalian`, `tanggal`, `id_pengguna`, `status_dihapus`) VALUES
(1, 'TD-2025050712400546', 1, 85500.00, 10.00, 100000.00, 14500.00, '2025-05-07 17:40:00', 1, 1),
(2, 'TD-2025051202320031', 1, 95000.00, 0.00, 100000.00, 5000.00, '2025-05-12 07:32:00', 1, 1),
(3, 'TD-2025051202374582', 2, 95000.00, 0.00, 120000.00, 25000.00, '2025-05-12 07:37:00', 1, 0),
(4, 'TD-2025051204243474', 2, 22500.00, 10.00, 25000.00, 2500.00, '2025-05-12 09:24:00', 1, 0),
(5, 'TD-2025051216043641', 1, 25000.00, 0.00, 50000.00, 25000.00, '2025-04-01 21:04:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `kode_produk` varchar(255) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `harga_jual` decimal(12,2) NOT NULL,
  `harga_beli` decimal(12,2) NOT NULL,
  `stok` int(11) DEFAULT 0,
  `stok_minimum` int(11) DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `dibuat_pada` datetime DEFAULT current_timestamp(),
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `kode_produk`, `nama_produk`, `id_kategori`, `id_satuan`, `harga_jual`, `harga_beli`, `stok`, `stok_minimum`, `deskripsi`, `dibuat_pada`, `status_dihapus`) VALUES
(1, 'BRG001', 'Pupuk Herlena', 3, 14, 95000.00, 65000.00, 9, 10, 'Pupuk Untuk Bawang', '2025-05-04 19:50:06', 0),
(20, 'PPK001', 'Pupuk Urea 1kg', 2, 15, 25000.00, 21000.00, 9, 10, 'Pupuk nitrogen tinggi untuk pertumbuhan tanaman.', '2025-05-04 20:00:19', 0),
(21, 'PPK002', 'Pupuk NPK 16-16-16', 2, 15, 28000.00, 23000.00, 0, 15, 'Pupuk lengkap untuk semua jenis tanaman.', '2025-05-04 20:00:19', 0),
(22, 'PPK003', 'Pupuk Kompos Organik', 2, 15, 15000.00, 10000.00, 0, 5, 'Pupuk organik dari bahan alami untuk tanah subur.', '2025-05-04 20:00:19', 0),
(23, 'PPK004', 'Pupuk Kandang 5kg', 2, 15, 20000.00, 15000.00, 0, 10, 'Pupuk dari kotoran hewan untuk menyuburkan tanah.', '2025-05-04 20:00:19', 0),
(24, 'PPK005', 'Pupuk Daun Cair', 2, 1, 18000.00, 13000.00, 0, 5, 'Pupuk cair yang disemprotkan ke daun.', '2025-05-04 20:00:19', 0),
(25, 'BRG002', 'Apa', 1, 1, 10000.00, 5000.00, 0, 5, '', '2025-05-12 23:06:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(20) NOT NULL,
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`, `status_dihapus`) VALUES
(1, 'Liter', 0),
(2, 'PCS', 0),
(3, 'Set', 0),
(14, 'Karung', 0),
(15, 'KG', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stok_keluar`
--

CREATE TABLE `stok_keluar` (
  `id_stok_keluar` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `id_penjualan` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok_keluar`
--

INSERT INTO `stok_keluar` (`id_stok_keluar`, `id_produk`, `jumlah`, `id_penjualan`, `tanggal`, `status_dihapus`) VALUES
(1, 1, 1, 1, '2025-05-07 17:40:22', 1),
(2, 1, 1, 2, '2025-05-12 07:34:21', 1),
(7, 1, 1, 3, '2025-05-12 08:10:02', 0),
(8, 20, 1, 4, '2025-05-12 09:24:57', 0),
(9, 20, 1, 5, '2025-05-12 21:05:02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stok_masuk`
--

CREATE TABLE `stok_masuk` (
  `id_stok_masuk` int(11) NOT NULL,
  `no_invoice` varchar(100) NOT NULL,
  `nama_supplier` varchar(100) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `id_pengguna` int(11) DEFAULT NULL,
  `status_dihapus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok_masuk`
--

INSERT INTO `stok_masuk` (`id_stok_masuk`, `no_invoice`, `nama_supplier`, `tanggal`, `id_pengguna`, `status_dihapus`) VALUES
(1, 'F01', 'Pak Eko', '2025-05-05 23:07:00', 1, 1),
(2, 'F021', 'Pak Eko1', '2025-05-04 23:32:00', 1, 0),
(4, 'F01', 'Andi', '2025-05-04 23:39:00', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_penjualan` (`id_penjualan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `detail_stok_masuk`
--
ALTER TABLE `detail_stok_masuk`
  ADD PRIMARY KEY (`id_detail_stok_masuk`),
  ADD KEY `id_stok_masuk` (`id_stok_masuk`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `username` (`nama_pengguna`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_satuan` (`id_satuan`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  ADD PRIMARY KEY (`id_stok_keluar`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indexes for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD PRIMARY KEY (`id_stok_masuk`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `detail_stok_masuk`
--
ALTER TABLE `detail_stok_masuk`
  MODIFY `id_detail_stok_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  MODIFY `id_stok_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  MODIFY `id_stok_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`),
  ADD CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `detail_stok_masuk`
--
ALTER TABLE `detail_stok_masuk`
  ADD CONSTRAINT `detail_stok_masuk_ibfk_1` FOREIGN KEY (`id_stok_masuk`) REFERENCES `stok_masuk` (`id_stok_masuk`),
  ADD CONSTRAINT `detail_stok_masuk_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id_satuan`);

--
-- Constraints for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  ADD CONSTRAINT `stok_keluar_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`),
  ADD CONSTRAINT `stok_keluar_ibfk_2` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`);

--
-- Constraints for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD CONSTRAINT `stok_masuk_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
