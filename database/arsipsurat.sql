-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Jun 2025 pada 14.42
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arsipsurat`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `disposisi`
--

CREATE TABLE `disposisi` (
  `id_disposisi` int(11) NOT NULL,
  `pengisi` varchar(100) NOT NULL,
  `tujuan` varchar(200) NOT NULL,
  `instruksi` varchar(200) NOT NULL,
  `catatan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `disposisi`
--

INSERT INTO `disposisi` (`id_disposisi`, `pengisi`, `tujuan`, `instruksi`, `catatan`) VALUES
(3, 'Kepala Divisi IT', 'Komisaris CV. Saung IT Bumiayu', 'Mohon ditindaklanjuti sesegera mungkin', 'Surat dari UMBS terkait kerja praktik mahasiswa mulai april 2025.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suratkeluar`
--

CREATE TABLE `suratkeluar` (
  `id_suratkeluar` int(11) NOT NULL,
  `no_suratkeluar` varchar(100) NOT NULL,
  `judul_suratkeluar` varchar(200) NOT NULL,
  `tujuan` varchar(200) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `keterangan` varchar(1000) NOT NULL,
  `berkas_suratkeluar` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `suratkeluar`
--

INSERT INTO `suratkeluar` (`id_suratkeluar`, `no_suratkeluar`, `judul_suratkeluar`, `tujuan`, `tanggal_keluar`, `keterangan`, `berkas_suratkeluar`) VALUES
(14, '9/--DEKSTK/II.3.AU/O/2025', 'Permohonan Kerja Praktik Mahasiswa UMBS', 'Instansi CV. Saung IT Bumiayu', '2025-03-31', 'Permohonan Kerja Praktik Mahasiswa UMBS', 'uploads/1749995071_surat permohonan kpm.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suratmasuk`
--

CREATE TABLE `suratmasuk` (
  `id_suratmasuk` int(11) NOT NULL,
  `no_surat` varchar(100) NOT NULL,
  `judul_surat` varchar(200) NOT NULL,
  `asal_surat` varchar(200) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `berkas_surat_masuk` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `suratmasuk`
--

INSERT INTO `suratmasuk` (`id_suratmasuk`, `no_surat`, `judul_surat`, `asal_surat`, `tanggal_masuk`, `tanggal_keluar`, `keterangan`, `berkas_surat_masuk`) VALUES
(16, '9/-/DEKSTK/II.3.AU/O/2025', 'Permohonan Kerja Praktek Mahasiswa UMBS', 'UNIVERSITAS MUHAMMADIYAH BREBES', '2025-03-19', '2025-03-31', 'Permohonan Kerja Praktek Mahasiswa UMBS', 'uploads/1749994967_surat permohonan kpm.pdf'),
(17, '10/-/DEKSTK/II.3.AU/O/2025', 'Surat Ijin/Tugas Praktik/Magang', 'UNIVERSITAS MUHAMMADIYAH BREBES', '2025-04-22', '2025-05-10', 'Surat ijin KPM Mahasiswa UMBS', 'uploads/1749995833_surat ijin tugas kpm.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama_lengkap`, `level`) VALUES
(3, 'SAUNG IT', '$2y$10$9ruygJ1bsVYfRTfCQSXtK.gv2BQpsh53T6kLoMzr0Gx0z3XKPixNq', 'SAUNG IT', 1),
(6, 'ashabul', '$2y$10$DRhmvRgQZohapoxciyg8pe6dX984k5V/YEcOSxL6fWsRd2dqZx6b6', 'Ashabul', 2),
(7, 'yamin', '$2y$10$3Plseh1bhGPJpEUF4EbNv.RgkE3ZPYZptVk.5C074ABqtN6urpuPK', 'ASHABUL YAMIN', 2);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `disposisi`
--
ALTER TABLE `disposisi`
  ADD PRIMARY KEY (`id_disposisi`);

--
-- Indeks untuk tabel `suratkeluar`
--
ALTER TABLE `suratkeluar`
  ADD PRIMARY KEY (`id_suratkeluar`);

--
-- Indeks untuk tabel `suratmasuk`
--
ALTER TABLE `suratmasuk`
  ADD PRIMARY KEY (`id_suratmasuk`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `id_disposisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `suratkeluar`
--
ALTER TABLE `suratkeluar`
  MODIFY `id_suratkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `suratmasuk`
--
ALTER TABLE `suratmasuk`
  MODIFY `id_suratmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
