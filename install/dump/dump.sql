-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 14 Agu 2018 pada 13.08
-- Versi server: 5.7.19
-- Versi PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `install`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat_room`
--

CREATE TABLE `chat_room` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `chat` text NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `chat_room`
--

INSERT INTO `chat_room` (`id`, `id_user`, `chat`, `waktu`) VALUES
(63, 6, 'test chat', '2018-08-14 09:27:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `nilai` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `nama`, `nilai`) VALUES
(1, 'nama_aplikasi', 'SIMPLE USER'),
(2, 'sistem_email', '0'),
(3, 'smtp_email', ''),
(4, 'smtp_password', ''),
(5, 'smtp_port', ''),
(6, 'smtp_host', ''),
(7, 'smtp_email_charset', 'utf-8'),
(8, 'email_protocol', 'smtp'),
(9, 'smtp_encryption', ''),
(10, 'smtp_username', ''),
(11, 'smtp_test_email_sukses', '0'),
(12, 'fb_app_id', ''),
(13, 'fb_app_secret', ''),
(14, 'fb_login', '0'),
(15, 'g_client_id', ''),
(16, 'g_client_secret', ''),
(17, 'g_login', '0'),
(18, 'git_login', '0'),
(19, 'git_client_id', ''),
(20, 'git_client_secret', ''),
(21, 'tw_login', '0'),
(22, 'tw_api_key', ''),
(23, 'tw_secret_key', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_oauth` varchar(100) NOT NULL,
  `provider_oauth` varchar(100) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `kunci_unik` varchar(300) DEFAULT NULL,
  `foto` varchar(255) NOT NULL DEFAULT 'user.png',
  `level` tinyint(1) NOT NULL DEFAULT '2',
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `id_oauth`, `provider_oauth`, `nama`, `email`, `password`, `kunci_unik`, `foto`, `level`, `status`) VALUES
(6, '0', NULL, 'FIAND T', 'admin@admin.com', '$argon2i$v=19$m=1024,t=4,p=3$aHY2UnkyQXFVRmYxNmdvNQ$ToW5UlL5d2hV5PM5U8Jm9bPNEWG7jB85OBGX239xvGY', NULL, 'user.png', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_log`
--

CREATE TABLE `users_log` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `log` varchar(255) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users_log`
--

INSERT INTO `users_log` (`id`, `id_user`, `log`, `time`) VALUES
(317, 6, 'Melakukan login', '2018-08-14 08:27:42'),
(318, 6, 'Melakukan login', '2018-08-14 08:28:01'),
(319, 6, 'Melakukan login', '2018-08-14 08:53:13'),
(320, 6, 'Melakukan login', '2018-08-14 08:54:42'),
(322, 6, 'Melakukan login', '2018-08-14 09:04:10'),
(328, 6, 'Melakukan login', '2018-08-14 12:47:37'),
(329, 6, 'Melakukan login', '2018-08-14 12:48:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_session`
--

CREATE TABLE `users_session` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `chat_room`
--
ALTER TABLE `chat_room`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users_log`
--
ALTER TABLE `users_log`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users_session`
--
ALTER TABLE `users_session`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `chat_room`
--
ALTER TABLE `chat_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT untuk tabel `users_log`
--
ALTER TABLE `users_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=330;

--
-- AUTO_INCREMENT untuk tabel `users_session`
--
ALTER TABLE `users_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
