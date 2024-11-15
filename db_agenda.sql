-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2024 at 05:23 AM
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
  `jamPelajaran` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `guruID` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(15) NOT NULL,
  `jk` enum('L','P') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`guruID`, `nama`, `nip`, `jk`) VALUES
(4, 'Ahmad Nursoheh', '2143124', 'P');

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
(1, 1, '2024-11-15 04:10:57', '0000-00-00 00:00:00', 'Hadir', 'Belum');

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
(2, 2, 'Sakit', '2024-10-15 11:02:22'),
(3, 1, 'Izin', '2024-10-15 11:09:37'),
(4, 2, 'Izin', '2024-10-15 11:13:00'),
(5, 2, 'Sakit', '2024-11-15 11:16:32'),
(6, 3, 'Sakit', '2024-11-15 11:16:38');

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
  `uid` varchar(20) NOT NULL,
  `nisn` varchar(15) NOT NULL,
  `nipd` varchar(15) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `kelas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`siswaID`, `nama`, `uid`, `nisn`, `nipd`, `jk`, `kelas`) VALUES
(1, 'Ahmad Daffa', 'US1234PIK', '0076756001', '2223.10.016', 'L', '12 RPL 1'),
(2, 'Alber Galih Antoni', 'AOJ1782NJ', '0067398146', '2223.10.030', 'L', '12 RPL 1'),
(3, 'Ameliya Nofitasari', '1203UASD2', '0071002689', '2223.10.047', 'P', '12 RPL 1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('Kepala Sekolah','Admin','Sekretaris','Guru') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `level`) VALUES
(1, 'admin', '$2y$10$ihaMnfyH2lqHme3YUiMybOiP3dTCBUu4nkw5tU4nuDMO1G6cqK6/e', 'Admin'),
(2, '12rpl1', '$2y$10$lJcXelw7ULF4JK9FJScmF.mA8O/9GnZSQ1FaFPEBylyzw6e2ZrVZW', 'Sekretaris');

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
  ADD PRIMARY KEY (`guruID`);

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
  MODIFY `agendaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `guruID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kehadiran`
--
ALTER TABLE `kehadiran`
  MODIFY `kehadiranID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `keterangan`
--
ALTER TABLE `keterangan`
  MODIFY `keteranganID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `siswaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
