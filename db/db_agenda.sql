-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11 Jan 2025 pada 04.40
-- Versi Server: 10.1.29-MariaDB
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
-- Struktur dari tabel `agenda`
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
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `guruID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(15) NOT NULL,
  `jk` enum('L','P') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`guruID`, `userID`, `nama`, `nip`, `jk`) VALUES
(5, 4, 'Ahmad Nursohe', '123123', 'L'),
(7, 7, 'Wahib Mudhofir', '124412', 'L');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kehadiran`
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
-- Dumping data untuk tabel `kehadiran`
--

INSERT INTO `kehadiran` (`kehadiranID`, `siswaID`, `jamHadir`, `jamPulang`, `keterangan`, `ketPulang`) VALUES
(1, 1, '2025-01-07 10:42:54', '2025-01-07 10:43:03', 'Hadir', 'Sudah'),
(2, 1, '2025-01-09 09:36:41', '2025-01-09 09:37:12', 'Hadir', 'Sudah'),
(3, 2, '2025-01-09 09:39:30', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(4, 3, '2025-01-10 09:23:52', '2025-01-10 09:24:03', 'Hadir', 'Sudah'),
(5, 4, '2025-01-11 02:08:36', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(6, 5, '2025-01-11 02:14:34', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(7, 6, '2025-01-11 02:15:20', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(8, 7, '2025-01-11 02:15:51', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(9, 8, '2025-01-11 02:16:12', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(10, 10, '2025-01-11 02:16:54', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(11, 11, '2025-01-11 02:17:38', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(12, 12, '2025-01-11 02:18:31', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(13, 2, '2025-01-11 02:19:04', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
(14, 1, '2025-01-11 02:19:31', '0000-00-00 00:00:00', 'Hadir', 'Belum'),
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
(36, 36, '2025-01-11 02:29:51', '0000-00-00 00:00:00', 'Hadir', 'Belum');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keterangan`
--

CREATE TABLE `keterangan` (
  `keteranganID` int(11) NOT NULL,
  `siswaID` int(11) NOT NULL,
  `keterangan` enum('Sakit','Izin','Alpha') NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `KodeMapel` int(11) NOT NULL,
  `namaMapel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`KodeMapel`, `namaMapel`) VALUES
(1, 'B.Indonesia'),
(2, 'Matematika'),
(3, 'PP'),
(4, 'Seni Budaya'),
(5, 'BK');

-- --------------------------------------------------------

--
-- Struktur dari tabel `setjam`
--

CREATE TABLE `setjam` (
  `jamID` int(11) NOT NULL,
  `jamPulang` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `setjam`
--

INSERT INTO `setjam` (`jamID`, `jamPulang`) VALUES
(1, '15:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
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
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`siswaID`, `nama`, `uid`, `nisn`, `nipd`, `jk`, `kelas`) VALUES
(1, 'Ahmad Daffa', '03D87B05', '0076756001', '2223.10.016', 'L', '12 RPL 1'),
(2, 'Alber Galih Antoni', '83A87E05', '0067398146', '2223.10.030', 'L', '12 RPL 1'),
(3, 'Ameliya Nofitasari', '93A91536', '0071002689', '2223.10.047', 'P', '12 RPL 1'),
(4, 'AISYAH', '23C67B05', '0065874852', '2223.10.025', 'P', '12 RPL 2'),
(5, 'ALVITA DAMAYANTI', '935B9005', '0073551189', '2223.10.037', 'P', '12 RPL 2'),
(6, 'ANAS SATORI', 'C3767A05', '0067332264', '2223.10.045', 'L', '12 RPL 2'),
(7, 'ANWAR HIDAYAT', 'A3319705', '0065227836', '2223.10.049', 'L', '12 RPL 2'),
(8, 'BUNGA CITRA RAMADANI', 'E3158905', '0067139484', '2223.10.065', 'P', '12 RPL 2'),
(9, 'DAHLAN APANDIANSAH', 'Belum di set', '0065213228', '2223.10.066', 'L', '12 RPL 2'),
(10, 'DEE OLIM', '138C7C05', '0068827638', '2223.10.092', 'L', '12 RPL 2'),
(11, 'DIANA MARSELA', '23268E05', '0072231266', '2223.10.101', 'P', '12 RPL 2'),
(12, 'ENCIH UNAYAH', '33A58405', '0067393584', '2223.10.103', 'P', '12 RPL 2'),
(13, 'FAREL SEPTIAN YULIANTO', '83A87E05', '0074484119', '2223.10.171', 'L', '12 RPL 2'),
(14, 'GILANG AHMADINATA', '03D87B05', '0069756444', '2223.10.178', 'L', '12 RPL 2'),
(15, 'ITA AGUNG SAPUTRA', 'A36A9205', '0067364363', '2223.10.208', 'L', '12 RPL 2'),
(16, 'KRIS LAKSAMANA AL QAWIYY', '63307505', '0067581567', '2223.10.246', 'L', '12 RPL 2'),
(17, 'LAURA MUTIA HEN', '43777A05', '0065904675', '2223.10.254', 'P', '12 RPL 2'),
(18, 'ISTA SUPRIYANI', 'C3737E05', '0067361554', '2223.10.274', 'P', '12 RPL 2'),
(19, 'MOZALIFA', '939E6F05', '0072837938', '2223.10.280', 'P', '12 RPL 2'),
(20, 'MUHAMMAD ADHA REZA AFRIZA', '73749405', '0072937844', '2223.10.287', 'L', '12 RPL 2'),
(21, 'MUTHIA NOVA SEVTIANI', '934D8F05', '0078851992', '2223.10.301', 'P', '12 RPL 2'),
(22, 'NADIA MERLIANA', '23E7A205', '0066980822', '2223.10.305', 'P', '12 RPL 2'),
(23, 'NENG GITA NOVIA', '73178505', '0067980193', '2223.10.338', 'P', '12 RPL 2'),
(24, 'NURYANTI', '432A8C05', '0067283103', '2223.10.346', 'P', '12 RPL 2'),
(25, 'POPY REVALINA', '73FD7805', '0068898089', '2223.10.350', 'P', '12 RPL 2'),
(26, 'RATANSYAH', 'F3228405', '0065560062', '2223.10.366', 'L', '12 RPL 2'),
(27, 'RAYNA SRI RAHAYU', 'A32F7905', '0072776587', '2223.10.387', 'P', '12 RPL 2'),
(28, 'RHADIT MIKA RAHIL', '63C38D05', '0073789772', '2223.10.397', 'L', '12 RPL 2'),
(29, 'RINA', '83D36E05', '0065239454', '2223.10.389', 'P', '12 RPL 2'),
(30, 'RIRIN DEWI ARYANI', 'A3F79705', '0065946703', '2223.10.394', 'P', '12 RPL 2'),
(31, 'ROMLAH', '23318C05', '0079804153', '2223.10.410', 'P', '12 RPL 2'),
(32, 'SANDI ALFITRI ANSYAH', '83296E05', '0061652067', '2223.10.421', 'L', '12 RPL 2'),
(33, 'SRI RAHAYU', 'F3318005', '0067787262', '2223.10.422', 'P', '12 RPL 2'),
(34, 'TIARA ANGGISTINA', '03227105', '0067663567', '2223.10.446', 'P', '12 RPL 2'),
(35, 'WINA AMELIA PUTRI', 'C3B48205', '0082214216', '2223.10.510', 'P', '12 RPL 2'),
(36, 'WULAN SARI', '33F08605', '0075859891', '2223.10.520', 'P', '12 RPL 2'),
(37, 'ZABRINA TRISTA MEILINA', 'Belum di set', '0071228103', '2223.10.533', 'P', '12 RPL 2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('Kepala Sekolah','Admin','Sekretaris','Guru','Wakil Kepala Sekolah') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
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
  MODIFY `kehadiranID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `agenda_ibfk_1` FOREIGN KEY (`guruID`) REFERENCES `guru` (`guruID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `agenda_ibfk_2` FOREIGN KEY (`KodeMapel`) REFERENCES `mapel` (`KodeMapel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD CONSTRAINT `kehadiran_ibfk_1` FOREIGN KEY (`siswaID`) REFERENCES `siswa` (`siswaID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `keterangan`
--
ALTER TABLE `keterangan`
  ADD CONSTRAINT `keterangan_ibfk_1` FOREIGN KEY (`siswaID`) REFERENCES `siswa` (`siswaID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
