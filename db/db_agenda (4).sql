-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2025 at 10:04 AM
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
  `kelasID` int(11) NOT NULL,
  `KodeMapel` int(11) NOT NULL,
  `materi` varchar(255) NOT NULL,
  `keterangan` enum('Hadir','Tidak Hadir','Tugas') NOT NULL,
  `jamPelajaran` int(2) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`agendaID`, `guruID`, `kelasID`, `KodeMapel`, `materi`, `keterangan`, `jamPelajaran`, `tanggal`) VALUES
(1, 8, 24, 2, 'Turunan', 'Hadir', 1, '2025-01-13 16:54:21');

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
(8, 8, 'Ahmad Nursoheh', '12302134', 'L');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `jurusanID` int(11) NOT NULL,
  `nama_jurusan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`jurusanID`, `nama_jurusan`) VALUES
(1, 'RPL'),
(2, 'DPIB'),
(3, 'TO'),
(4, 'AKKL'),
(5, 'FI');

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

--
-- Dumping data for table `kehadiran`
--

INSERT INTO `kehadiran` (`kehadiranID`, `siswaID`, `jamHadir`, `jamPulang`, `keterangan`, `ketPulang`) VALUES
(3, 2, '2025-01-09 09:39:30', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(5, 4, '2025-01-11 02:08:36', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(6, 5, '2025-01-11 02:14:34', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(7, 6, '2025-01-11 02:15:20', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(8, 7, '2025-01-11 02:15:51', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(9, 8, '2025-01-11 02:16:12', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(10, 10, '2025-01-11 02:16:54', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(11, 11, '2025-01-11 02:17:38', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(12, 12, '2025-01-11 02:18:31', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(13, 2, '2025-01-11 02:19:04', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(15, 15, '2025-01-11 02:20:15', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(16, 16, '2025-01-11 02:20:45', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(17, 17, '2025-01-11 02:21:11', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(18, 18, '2025-01-11 02:21:44', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(19, 19, '2025-01-11 02:22:14', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(20, 20, '2025-01-11 02:22:43', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(21, 21, '2025-01-11 02:23:04', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(22, 22, '2025-01-11 02:23:42', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(23, 23, '2025-01-11 02:24:05', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(24, 24, '2025-01-11 02:24:29', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(25, 25, '2025-01-11 02:24:58', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(26, 26, '2025-01-11 02:25:29', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(27, 27, '2025-01-11 02:25:58', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(28, 28, '2025-01-11 02:26:17', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(29, 29, '2025-01-11 02:26:38', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(30, 30, '2025-01-11 02:27:01', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(31, 31, '2025-01-11 02:27:22', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(32, 32, '2025-01-11 02:27:43', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(33, 33, '2025-01-11 02:28:33', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(34, 34, '2025-01-11 02:29:09', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(35, 35, '2025-01-11 02:29:35', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(36, 36, '2025-01-11 02:29:51', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(37, 10, '2025-01-13 08:35:01', '2025-01-13 08:46:19', 'Hadir', 'Sudah'),
(38, 7, '2025-01-13 08:47:34', '2025-01-13 08:48:07', 'Hadir', 'Sudah'),
(39, 6, '2025-01-13 08:47:53', '0000-00-00 00:00:00', 'Hadir', 'Belum');

-- --------------------------------------------------------

--
-- Table structure for table `kelasmaster`
--

CREATE TABLE `kelasmaster` (
  `kelasID` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `jurusanID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelasmaster`
--

INSERT INTO `kelasmaster` (`kelasID`, `nama_kelas`, `jurusanID`) VALUES
(21, '10 RPL 2', 1),
(22, '10 RPL 1', 1),
(23, '11 RPL 1', 1),
(24, '12 RPL 2', 1),
(25, '11 RPL 2', 1),
(26, '12 RPL 1', 1),
(27, '10 DPIB 1', 2),
(28, '10 DPIB 2', 2),
(29, '11 DPIB 1', 2),
(30, '11 DPIB 2', 2);

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

--
-- Dumping data for table `keterangan`
--

INSERT INTO `keterangan` (`keteranganID`, `siswaID`, `keterangan`, `tanggal`) VALUES
(1, 4, 'Izin', '2025-01-12 16:38:16');

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
-- Table structure for table `sekretaris`
--

CREATE TABLE `sekretaris` (
  `sekretarisID` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `siswaID` int(11) NOT NULL,
  `kelasID` int(11) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sekretaris`
--

INSERT INTO `sekretaris` (`sekretarisID`, `username`, `siswaID`, `kelasID`, `password`) VALUES
(4, 'alvita12rpl2', 5, 24, '$2y$10$7pen.G1vhejUSMpPlRps6.Z0VNzNh/7ZmGoMNze3CVDqWRkWheNAW'),
(5, 'diana12rpl2', 11, 24, '$2y$10$QO/JVl4yBbPwrjYj8Q6j4.2QSk7VuSPvSB3gVBcqbmtSmnHX0fVea');

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
(1, '15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `siswaID` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kelasID` int(11) NOT NULL,
  `uid` varchar(20) NOT NULL DEFAULT 'Belum di set',
  `nisn` varchar(15) NOT NULL,
  `nipd` varchar(15) NOT NULL,
  `jk` enum('L','P') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`siswaID`, `nama`, `kelasID`, `uid`, `nisn`, `nipd`, `jk`) VALUES
(2, 'Alber Galih Antoni', 26, '83A87E05', '0067398146', '2223.10.030', 'L'),
(4, 'AISYAH', 24, '23C67B05', '0065874852', '2223.10.025', 'P'),
(5, 'ALVITA DARMAYANTI', 24, '935B9005', '0073551189', '2223.10.037', 'P'),
(6, 'ANAS SATORI', 24, 'C3767A05', '0067332264', '2223.10.045', 'L'),
(7, 'ANWAR HIDAYAT', 24, 'A3319705', '0065227836', '2223.10.049', 'L'),
(8, 'BUNGA CITRA RAMADANI', 24, 'E3158905', '0067139484', '2223.10.065', 'P'),
(9, 'DAHLAN APANDIANSAH', 24, 'Belum di set', '0065213228', '2223.10.066', 'L'),
(10, 'DEDE OLIM', 24, '138C7C05', '0068827638', '2223.10.092', 'L'),
(11, 'DIANA MARSELA', 24, '23268E05', '0072231266', '2223.10.101', 'P'),
(12, 'ENCIH UNAYAH', 24, '33A58405', '0067393584', '2223.10.103', 'P'),
(13, 'FAREL SEPTIAN YULIANTO', 24, '83A87E05', '0074484119', '2223.10.171', 'L'),
(14, 'GILANG AHMADINATA', 24, '03D87B05', '0069756444', '2223.10.178', 'L'),
(15, 'ITA AGUNG SAPUTRA', 24, 'A36A9205', '0067364363', '2223.10.208', 'L'),
(16, 'KRIS LAKSAMANA AL QAWIYY', 24, '63307505', '0067581567', '2223.10.246', 'L'),
(17, 'LAURA MUTIA HEN', 24, '43777A05', '0065904675', '2223.10.254', 'P'),
(18, 'ISTA SUPRIYANI', 24, 'C3737E05', '0067361554', '2223.10.274', 'P'),
(19, 'MOZALIFA', 24, '939E6F05', '0072837938', '2223.10.280', 'P'),
(20, 'MUHAMMAD ADHA REZA AFRIZA', 24, '73749405', '0072937844', '2223.10.287', 'L'),
(21, 'MUTHIA NOVA SEVTIANI', 24, '934D8F05', '0078851992', '2223.10.301', 'P'),
(22, 'NADIA MERLIANA', 24, '23E7A205', '0066980822', '2223.10.305', 'P'),
(23, 'NENG GITA NOVIA', 24, '73178505', '0067980193', '2223.10.338', 'P'),
(24, 'NURYANTI', 24, '432A8C05', '0067283103', '2223.10.346', 'P'),
(25, 'POPY REVALINA', 24, '73FD7805', '0068898089', '2223.10.350', 'P'),
(26, 'RATANSYAH', 24, 'F3228405', '0065560062', '2223.10.366', 'L'),
(27, 'RAYNA SRI RAHAYU', 24, 'A32F7905', '0072776587', '2223.10.387', 'P'),
(28, 'RHADIT MIKA RAHIL', 24, '63C38D05', '0073789772', '2223.10.397', 'L'),
(29, 'RINA', 24, '83D36E05', '0065239454', '2223.10.389', 'P'),
(30, 'RIRIN DEWI ARYANI', 24, 'A3F79705', '0065946703', '2223.10.394', 'P'),
(31, 'ROMLAH', 24, '23318C05', '0079804153', '2223.10.410', 'P'),
(32, 'SANDI ALFITRI ANSYAH', 24, '83296E05', '0061652067', '2223.10.421', 'L'),
(33, 'SRI RAHAYU', 24, 'F3318005', '0067787262', '2223.10.422', 'P'),
(34, 'TIARA ANGGISTINA', 24, '03227105', '0067663567', '2223.10.446', 'P'),
(35, 'WINA AMELIA PUTRI', 24, 'C3B48205', '0082214216', '2223.10.510', 'P'),
(36, 'WULAN SARI', 24, '33F08605', '0075859891', '2223.10.520', 'P'),
(37, 'ZABRINA TRISTA MEILINA', 24, 'Belum di set', '0071228103', '2223.10.533', 'P');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('Kepala Sekolah','Admin','Guru','Wakil Kepala Sekolah') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `level`) VALUES
(1, 'admin', '$2y$10$ihaMnfyH2lqHme3YUiMybOiP3dTCBUu4nkw5tU4nuDMO1G6cqK6/e', 'Admin'),
(3, 'Budi Rukadi', '$2y$10$s/LwbsmCPpQx0/TkyKgH.OsmrNcAHvO1avyIx/GURtlWNYdoGJdAO', 'Wakil Kepala Sekolah'),
(5, 'rhdtrhl', '$2y$10$PeSrn90EFyjQBlX/coW2g.CpJOWRpal6qEEugKzo1lA9anwlFZbFu', 'Guru'),
(7, 'wahib', '$2y$10$DKgr0Zt052/Ovt/yh1hFuODUKkNVNRlRFjXCRfy12x7/0WxlMbchm', 'Guru'),
(8, 'sohe', '$2y$10$xfOnL5LaO.W6BUqaXjlrDekKkh6BIB4wQVmkncAJ9LfI.99ivw2RC', 'Guru');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`agendaID`),
  ADD KEY `guruID` (`guruID`,`KodeMapel`),
  ADD KEY `KodeMapel` (`KodeMapel`),
  ADD KEY `kelasID` (`kelasID`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`guruID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`jurusanID`);

--
-- Indexes for table `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD PRIMARY KEY (`kehadiranID`),
  ADD KEY `siswaID` (`siswaID`);

--
-- Indexes for table `kelasmaster`
--
ALTER TABLE `kelasmaster`
  ADD PRIMARY KEY (`kelasID`),
  ADD KEY `jurusanID` (`jurusanID`);

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
-- Indexes for table `sekretaris`
--
ALTER TABLE `sekretaris`
  ADD PRIMARY KEY (`sekretarisID`),
  ADD KEY `kelasID` (`kelasID`),
  ADD KEY `siswaID` (`siswaID`);

--
-- Indexes for table `setjam`
--
ALTER TABLE `setjam`
  ADD PRIMARY KEY (`jamID`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`siswaID`),
  ADD KEY `kelasID` (`kelasID`);

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
  MODIFY `agendaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `guruID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `jurusanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kehadiran`
--
ALTER TABLE `kehadiran`
  MODIFY `kehadiranID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `kelasmaster`
--
ALTER TABLE `kelasmaster`
  MODIFY `kelasID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `keterangan`
--
ALTER TABLE `keterangan`
  MODIFY `keteranganID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `KodeMapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sekretaris`
--
ALTER TABLE `sekretaris`
  MODIFY `sekretarisID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `agenda_ibfk_1` FOREIGN KEY (`guruID`) REFERENCES `guru` (`guruID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `agenda_ibfk_2` FOREIGN KEY (`KodeMapel`) REFERENCES `mapel` (`KodeMapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `agenda_ibfk_3` FOREIGN KEY (`kelasID`) REFERENCES `kelasmaster` (`kelasID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD CONSTRAINT `kehadiran_ibfk_1` FOREIGN KEY (`siswaID`) REFERENCES `siswa` (`siswaID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kelasmaster`
--
ALTER TABLE `kelasmaster`
  ADD CONSTRAINT `kelasmaster_ibfk_1` FOREIGN KEY (`jurusanID`) REFERENCES `jurusan` (`jurusanID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keterangan`
--
ALTER TABLE `keterangan`
  ADD CONSTRAINT `keterangan_ibfk_1` FOREIGN KEY (`siswaID`) REFERENCES `siswa` (`siswaID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sekretaris`
--
ALTER TABLE `sekretaris`
  ADD CONSTRAINT `sekretaris_ibfk_1` FOREIGN KEY (`kelasID`) REFERENCES `kelasmaster` (`kelasID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sekretaris_ibfk_2` FOREIGN KEY (`siswaID`) REFERENCES `siswa` (`siswaID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`kelasID`) REFERENCES `kelasmaster` (`kelasID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
