-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2024 at 04:47 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_agenda`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `agendaID` int(11) NOT NULL,
  `guruID` int(11) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `KodeMapel` int(11) NOT NULL,
  `materi` varchar(255) NOT NULL,
  `keterangan` enum('Hadir','Tidak Hadir','Tugas') NOT NULL,
  `jamPelajaran` int(2) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `guruID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(15) NOT NULL,
  `jk` enum('L','P') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`guruID`, `userID`, `nama`, `nip`, `jk`) VALUES
(5, 4, 'Ahmad Nursohe', '123123', 'L'),
(7, 7, 'Wahib Mudhofir', '124412', 'L');

-- --------------------------------------------------------

--
-- Table structure for table `kehadiran`
--

CREATE TABLE `kehadiran` (
  `kehadiranID` int(11) NOT NULL,
  `siswaID` int(11) NOT NULL,
  `jamHadir` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jamPulang` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `keterangan` enum('Tidak Ada','Hadir','Sakit','Izin','Alpha') NOT NULL DEFAULT 'Tidak Ada',
  `ketPulang` enum('Sudah','Belum') NOT NULL DEFAULT 'Belum'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `keterangan`
--

CREATE TABLE `keterangan` (
  `keteranganID` int(11) NOT NULL,
  `siswaID` int(11) NOT NULL,
  `keterangan` enum('Sakit','Izin','Alpha') NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `KodeMapel` int(11) NOT NULL,
  `namaMapel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`KodeMapel`, `namaMapel`) VALUES
(1, 'B.Indonesia'),
(2, 'Matematika'),
(3, 'PP'),
(4, 'Seni Budaya'),
(5, 'BK');

-- --------------------------------------------------------

--
-- Table structure for table `setjam`
--

CREATE TABLE `setjam` (
  `jamID` int(11) NOT NULL,
  `jamPulang` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setjam`
--

INSERT INTO `setjam` (`jamID`, `jamPulang`) VALUES
(1, '07:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `siswaID` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `uid` varchar(20) NOT NULL DEFAULT 'Belum di set',
  `nisn` varchar(15) NOT NULL,
  `nipd` varchar(15) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `kelas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`siswaID`, `nama`, `uid`, `nisn`, `nipd`, `jk`, `kelas`) VALUES
(1, 'Ahmad Daffa', 'Belum di set', '0076756001', '2223.10.016', 'L', '12 RPL 1'),
(2, 'Alber Galih Antoni', 'Belum di set', '0067398146', '2223.10.030', 'L', '12 RPL 1'),
(3, 'Ameliya Nofitasari', 'Belum di set', '0071002689', '2223.10.047', 'P', '12 RPL 1'),
(4, 'AISYAH', 'Belum di set', '0065874852', '2223.10.025', 'P', '12 RPL 2'),
(5, 'ALVITA DAMAYANTI', 'Belum di set', '0073551189', '2223.10.037', 'P', '12 RPL 2'),
(6, 'ANAS SATORI', 'Belum di set', '0067332264', '2223.10.045', 'L', '12 RPL 2'),
(7, 'ANWAR HIDAYAT', 'Belum di set', '0065227836', '2223.10.049', 'L', '12 RPL 2'),
(8, 'BUNGA CITRA RAMADANI', 'Belum di set', '0067139484', '2223.10.065', 'P', '12 RPL 2'),
(9, 'DAHLAN APANDIANSAH', 'Belum di set', '0065213228', '2223.10.066', 'L', '12 RPL 2'),
(10, 'DEE OLIM', 'Belum di set', '0068827638', '2223.10.092', 'L', '12 RPL 2'),
(11, 'DIANA MARSELA', 'Belum di set', '0072231266', '2223.10.101', 'P', '12 RPL 2'),
(12, 'ENCIH UNAYAH', 'Belum di set', '0067393584', '2223.10.103', 'P', '12 RPL 2'),
(13, 'FAREL SEPTIAN YULIANTO', 'Belum di set', '0074484119', '2223.10.171', 'L', '12 RPL 2'),
(14, 'GILANG AHMADINATA', 'Belum di set', '0069756444', '2223.10.178', 'L', '12 RPL 2'),
(15, 'ITA AGUNG SAPUTRA', 'Belum di set', '0067364363', '2223.10.208', 'L', '12 RPL 2'),
(16, 'KRIS LAKSAMANA AL QAWIYY', 'Belum di set', '0067581567', '2223.10.246', 'L', '12 RPL 2'),
(17, 'LAURA MUTIA HEN', 'Belum di set', '0065904675', '2223.10.254', 'P', '12 RPL 2'),
(18, 'ISTA SUPRIYANI', 'Belum di set', '0067361554', '2223.10.274', 'P', '12 RPL 2'),
(19, 'MOZALIFA', 'Belum di set', '0072837938', '2223.10.280', 'P', '12 RPL 2'),
(20, 'MUHAMMAD ADHA REZA AFRIZA', 'Belum di set', '0072937844', '2223.10.287', 'L', '12 RPL 2'),
(21, 'MUTHIA NOVA SEVTIANI', 'Belum di set', '0078851992', '2223.10.301', 'P', '12 RPL 2'),
(22, 'NADIA MERLIANA', 'Belum di set', '0066980822', '2223.10.305', 'P', '12 RPL 2'),
(23, 'NENG GITA NOVIA', 'Belum di set', '0067980193', '2223.10.338', 'P', '12 RPL 2'),
(24, 'NURYANTI', 'Belum di set', '0067283103', '2223.10.346', 'P', '12 RPL 2'),
(25, 'POPY REVALINA', 'Belum di set', '0068898089', '2223.10.350', 'P', '12 RPL 2'),
(26, 'RATANSYAH', 'Belum di set', '0065560062', '2223.10.366', 'L', '12 RPL 2'),
(27, 'RAYNA SRI RAHAYU', 'Belum di set', '0072776587', '2223.10.387', 'P', '12 RPL 2'),
(28, 'RHADIT MIKA RAHIL', 'Belum di set', '0073789772', '2223.10.397', 'L', '12 RPL 2'),
(29, 'RINA', 'Belum di set', '0065239454', '2223.10.389', 'P', '12 RPL 2'),
(30, 'RIRIN DEWI ARYANI', 'Belum di set', '0065946703', '2223.10.394', 'P', '12 RPL 2'),
(31, 'ROMLAH', 'Belum di set', '0079804153', '2223.10.410', 'P', '12 RPL 2'),
(32, 'SANDI ALFITRI ANSYAH', 'Belum di set', '0061652067', '2223.10.421', 'L', '12 RPL 2'),
(33, 'SRI RAHAYU', 'Belum di set', '0067787262', '2223.10.422', 'P', '12 RPL 2'),
(34, 'TIARA ANGGISTINA', 'Belum di set', '0067663567', '2223.10.446', 'P', '12 RPL 2'),
(35, 'WINA AMELIA PUTRI', 'Belum di set', '0082214216', '2223.10.510', 'P', '12 RPL 2'),
(36, 'WULAN SARI', 'Belum di set', '0075859891', '2223.10.520', 'P', '12 RPL 2'),
(37, 'ZABRINA TRISTA MEILINA', 'Belum di set', '0071228103', '2223.10.533', 'P', '12 RPL 2');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('Kepala Sekolah','Admin','Sekretaris','Guru','Wakil Kepala Sekolah') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `level`) VALUES
(1, 'admin', '$2y$10$ihaMnfyH2lqHme3YUiMybOiP3dTCBUu4nkw5tU4nuDMO1G6cqK6/e', 'Admin'),
(2, '12 RPL 1', '$2y$10$lJcXelw7ULF4JK9FJScmF.mA8O/9GnZSQ1FaFPEBylyzw6e2ZrVZW', 'Sekretaris'),
(3, 'Budi Rukadi', '$2y$10$s/LwbsmCPpQx0/TkyKgH.OsmrNcAHvO1avyIx/GURtlWNYdoGJdAO', 'Wakil Kepala Sekolah'),
(4, 'sohe', '$2y$10$pnFqUmC/aKt1H0uASz.vDu6/0uwXZr.I9.8LKekOLO3FFxbRbYcRC', 'Guru'),
(5, 'rhdtrhl', '$2y$10$PeSrn90EFyjQBlX/coW2g.CpJOWRpal6qEEugKzo1lA9anwlFZbFu', 'Guru'),
(6, '12 RPL 2', '$2y$10$UVNqXxBl0Ru0UO7/etL66Od9hLHnmQETHDkGFIRnUH28zJ0fxR7ku', 'Sekretaris'),
(7, 'wahib', '$2y$10$DKgr0Zt052/Ovt/yh1hFuODUKkNVNRlRFjXCRfy12x7/0WxlMbchm', 'Guru');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`agendaID`),
  ADD KEY `guruID` (`guruID`,`KodeMapel`),
  ADD KEY `KodeMapel` (`KodeMapel`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`guruID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD PRIMARY KEY (`kehadiranID`),
  ADD KEY `siswaID` (`siswaID`);

--
-- Indexes for table `keterangan`
--
ALTER TABLE `keterangan`
  ADD PRIMARY KEY (`keteranganID`),
  ADD KEY `siswaID` (`siswaID`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`KodeMapel`);

--
-- Indexes for table `setjam`
--
ALTER TABLE `setjam`
  ADD PRIMARY KEY (`jamID`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`siswaID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `agendaID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `guruID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kehadiran`
--
ALTER TABLE `kehadiran`
  MODIFY `kehadiranID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keterangan`
--
ALTER TABLE `keterangan`
  MODIFY `keteranganID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `KodeMapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `setjam`
--
ALTER TABLE `setjam`
  MODIFY `jamID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `siswaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `agenda_ibfk_1` FOREIGN KEY (`guruID`) REFERENCES `guru` (`guruID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `agenda_ibfk_2` FOREIGN KEY (`KodeMapel`) REFERENCES `mapel` (`KodeMapel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD CONSTRAINT `kehadiran_ibfk_1` FOREIGN KEY (`siswaID`) REFERENCES `siswa` (`siswaID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keterangan`
--
ALTER TABLE `keterangan`
  ADD CONSTRAINT `keterangan_ibfk_1` FOREIGN KEY (`siswaID`) REFERENCES `siswa` (`siswaID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
