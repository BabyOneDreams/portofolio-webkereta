-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Feb 2025 pada 08.19
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penyewaantiket`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `phone_number`, `message`) VALUES
(1, 'Riszwan Rachman', 'babyonedreams@gmail.com', '81386810251', 'aDSDSD'),
(2, 'riszwan', 'iwan@gmail.com', '81386810251', 'asxasas'),
(3, 'ChristianSusanto', 'rickopermana68@gmail.com', '81386810251', 'oke');

-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE `level` (
  `id_level` int(11) NOT NULL,
  `nama_level` varchar(200) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`id_level`, `nama_level`, `email`, `password`) VALUES
(2, 'iwan', 'riswanrahman22@gmail.com', '$2y$10$FY3od8vc2ZoKuT48YYFoZehxELrAUwr9Zpny5hZN2YXgwGQmK8KrK'),
(4, 'Riszwan', 'wannn14@gmail.com', '$2y$10$mUwUD7GzSdh3HLTNn2hfQO/q.Ot/tTfc4CMmzz3AvFyzFt4UYtgHC'),
(5, 'Riszwan Rachman', 'babyonedreams@gmail.com', '$2y$10$pypch8tDHz5K6fGHKGtpTu8jQ5t7eHoQ4xHPrjgMeAVIRE0lQDosq');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `jumlah_bayar` decimal(10,0) NOT NULL,
  `metode_pembayaran` enum('Transfer Bank','E-Wallet','Kartu Kredit') DEFAULT NULL,
  `status_pembayaran` enum('pending','lunas','gagal') NOT NULL DEFAULT 'pending',
  `kode_pemesanan` varchar(255) DEFAULT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pemesanan`, `tanggal_pembayaran`, `jumlah_bayar`, `metode_pembayaran`, `status_pembayaran`, `kode_pemesanan`, `bukti_bayar`) VALUES
(44, 20, '2025-02-18', 1557727, 'Kartu Kredit', 'lunas', 'KT-841577', '67b3fb19161c49f477641-12f3-4e64-8dce-698526853241.jpeg'),
(45, 21, '2025-02-18', 15000, 'Transfer Bank', 'pending', 'KT-580821', '67b3fdd6b7ad0b836051b-bb60-400d-9a6b-c6b963656486.jpeg'),
(48, 28, '2025-02-18', 15000, 'E-Wallet', 'lunas', 'KT-760555', '67b4299de2fc8WhatsApp Image 2025-01-22 at 09.38.37.jpeg'),
(49, 30, '2025-02-18', 130000, 'Kartu Kredit', 'lunas', 'KT-302559', '67b433e342299WhatsApp Image 2025-01-22 at 09.38.37 (1).jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `kode_pemesanan` varchar(50) NOT NULL,
  `tanggal_pemesanan` date NOT NULL,
  `tempat_pemesanan` varchar(100) NOT NULL,
  `nama_penumpang` varchar(100) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `kode_kursi` varchar(50) NOT NULL,
  `id_rute` int(11) NOT NULL,
  `id_transportasi` int(11) NOT NULL,
  `nama_type` varchar(50) NOT NULL,
  `tanggal_berangkat` date NOT NULL,
  `jam_cekin` time NOT NULL,
  `jam_berangkat` time NOT NULL,
  `total_bayar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `kode_pemesanan`, `tanggal_pemesanan`, `tempat_pemesanan`, `nama_penumpang`, `id_pelanggan`, `kode_kursi`, `id_rute`, `id_transportasi`, `nama_type`, `tanggal_berangkat`, `jam_cekin`, `jam_berangkat`, `total_bayar`) VALUES
(20, 'KT-841577', '2025-02-18', 'Jakarta', 'niar', 38, 'K-506', 2, 1, '', '2025-02-18', '10:18:00', '10:18:00', 1557727),
(21, 'KT-580821', '2025-02-21', 'Jogja', 'niar', 38, 'K-949', 1, 2, '', '2025-02-20', '10:21:00', '10:21:00', 15000),
(27, 'KT-390800', '2025-02-12', 'surabaya', 'niar', 38, 'K-280', 2, 1, '', '2025-02-19', '13:22:00', '15:20:00', 1557727),
(28, 'KT-760555', '2025-02-18', 'Jakarta', 'Pak Ervan', 43, 'K-603', 1, 1, '', '2025-02-18', '13:35:00', '17:32:00', 15000),
(29, 'KT-380228', '2025-02-18', 'Jogja', 'Pak E', 43, 'K-529', 5, 1, '', '2025-02-18', '13:45:00', '13:48:00', 130000),
(30, 'KT-302559', '2025-02-18', 'Jogja', 'Pak E', 43, 'K-568', 4, 1, '', '2025-02-18', '14:21:00', '17:16:00', 130000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penumpang`
--

CREATE TABLE `penumpang` (
  `id_penumpang` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nama_penumpang` varchar(200) NOT NULL,
  `alamat_penumpang` varchar(200) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(200) NOT NULL,
  `telepon` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penumpang`
--

INSERT INTO `penumpang` (`id_penumpang`, `username`, `password`, `nama_penumpang`, `alamat_penumpang`, `tanggal_lahir`, `jenis_kelamin`, `telepon`) VALUES
(38, 'Niar', '$2y$10$FMUqaa7G8t8ZBJSEvhvvM.PCNfVstRld2ci5IBiZwCpMomlyG57uy', 'niar', 'Bali', '2025-01-26', 'Perempuan', '2893429'),
(39, 'Dinda', '$2y$10$75N.u84d4.wpr7SUFx8TuuU9cah5mpEl3oQtnpgnBnt42Q3IkubqO', 'Nda', 'Bali', '2025-01-27', 'Perempuan', '20910947'),
(40, 'Fexxy', '$2y$10$96J.WSsMT7MAWaBygBWYiODE5EZHgq2MMQPVfsNmCNmq8sdvUb2G2', 'febri', 'Papua', '2025-02-05', 'Laki-laki', '3924723'),
(41, '', '', 'Riszwan Rachman', 'bandung', '0000-00-00', '', '0844'),
(43, 'Ervan', '$2y$10$rFk3B9SDB.ysN0mgK8hBa.arTDBXyENd1QES9j185WCxy/u4t4ifu', 'Pak E', 'jakarta', '2025-02-18', 'Laki-laki', '023028858028');

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nama_petugas` varchar(200) NOT NULL,
  `id_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `username`, `password`, `nama_petugas`, `id_level`) VALUES
(6, 'Firda', '$2y$10$gTpfXg/qRh0j9yiM.sCdLO50II16JYRv5eTLalOWQwjfHmmeTSlTm', 'Ida', 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rute`
--

CREATE TABLE `rute` (
  `id_rute` int(11) NOT NULL,
  `tujuan` varchar(200) NOT NULL,
  `rute_awal` varchar(200) NOT NULL,
  `rute_akhir` varchar(200) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `id_transportasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rute`
--

INSERT INTO `rute` (`id_rute`, `tujuan`, `rute_awal`, `rute_akhir`, `harga`, `id_transportasi`) VALUES
(1, 'Bandung', 'Stasiun Senin', 'Stasiun Bandung', 15000, 1),
(2, 'Bandung', 'Stasiun Senin', 'Bondowoso', 1557727, 3),
(3, 'Sumatra', 'Stasiun Jatinegara', 'Stasiun Riau', 1500000, 10),
(4, 'Bali', 'Stasiun Senin', 'Bondowoso', 130000, 2),
(5, 'Bali', 'Stasiun Senin', 'Bondowoso', 130000, 2),
(6, 'Bandung', 'Stasiun Jatinegara', 'Bondowoso', 1500000000, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transportasi`
--

CREATE TABLE `transportasi` (
  `id_transportasi` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `jumlah_kursi` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `id_type_transportasi` int(11) DEFAULT NULL,
  `nama_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transportasi`
--

INSERT INTO `transportasi` (`id_transportasi`, `kode`, `jumlah_kursi`, `keterangan`, `id_type_transportasi`, `nama_type`) VALUES
(1, 'KA006', 150, 'Kereta Solo Balapan', 2, 'Bisnis'),
(2, 'KA006', 150, 'Kereta Solo Balapan', 2, ''),
(3, 'KA001', 300, 'Kereta Solo K', 1, ''),
(4, 'KA001', 300, 'Kereta Solo K', 1, ''),
(5, 'KA001', 300, 'Kereta Solo K', 1, ''),
(6, 'KA001', 300, 'Kereta Solo K', 1, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transportasii`
--

CREATE TABLE `transportasii` (
  `id_transportasi` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `nama_type` enum('Eksekutif','Bisnis','Ekonomi') NOT NULL,
  `kode_kursi` varchar(50) NOT NULL,
  `jumlah_kursi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transportasii`
--

INSERT INTO `transportasii` (`id_transportasi`, `keterangan`, `nama_type`, `kode_kursi`, `jumlah_kursi`) VALUES
(1, 'Kereta Solo Balapan', 'Eksekutif', 'K2', 300),
(2, 'Kereta Solo Balapan', 'Eksekutif', 'K2', 300);

-- --------------------------------------------------------

--
-- Struktur dari tabel `type_transportasi`
--

CREATE TABLE `type_transportasi` (
  `id_type_transportasi` int(11) NOT NULL,
  `nama_type` varchar(200) NOT NULL,
  `keterangan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `type_transportasi`
--

INSERT INTO `type_transportasi` (`id_type_transportasi`, `nama_type`, `keterangan`) VALUES
(1, 'Eksekutif', 'Kereta api eksekutif dengan fasilitas premium'),
(2, 'Bisnis', 'Kereta api bisnis dengan kenyamanan menengah'),
(3, 'Ekonomi', 'Kereta api ekonomi dengan tarif terjangkau');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas','penumpang') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `username`, `password`, `role`) VALUES
(1, 'Riszwan Rachman', 'Wannn', '$2y$10$m6O4hzdM96v4HqTFyFPnP.YVra.vBp/zk7ql/njPGjdmVl7EvLLni', 'admin'),
(2, 'Jonathan', 'BabyOneDreams', '$2y$10$zBWjTsCMuPxc02jdFAo/semfbIia7zqPvIi3HdeJePo2QT4UGZFz6', 'petugas'),
(3, 'riki', 'iki', '$2y$10$uOQ7FjIPOtu9x9zEj6BwnuHQqLx5vYqbJhd8U9ht08vAFGN.57fb6', 'penumpang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas','penumpang') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_users`, `username`, `password`, `role`) VALUES
(1, 'wann', '123', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD UNIQUE KEY `kode_pemesanan` (`kode_pemesanan`),
  ADD UNIQUE KEY `kode_kursi` (`kode_kursi`),
  ADD KEY `fk_pemesanan_pelanggan` (`id_pelanggan`),
  ADD KEY `fk_pemesanan_rute` (`id_rute`),
  ADD KEY `fk_pemesanan_transportasi` (`id_transportasi`);

--
-- Indeks untuk tabel `penumpang`
--
ALTER TABLE `penumpang`
  ADD PRIMARY KEY (`id_penumpang`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indeks untuk tabel `rute`
--
ALTER TABLE `rute`
  ADD PRIMARY KEY (`id_rute`);

--
-- Indeks untuk tabel `transportasi`
--
ALTER TABLE `transportasi`
  ADD PRIMARY KEY (`id_transportasi`),
  ADD KEY `id_type_transportasi` (`id_type_transportasi`);

--
-- Indeks untuk tabel `transportasii`
--
ALTER TABLE `transportasii`
  ADD PRIMARY KEY (`id_transportasi`);

--
-- Indeks untuk tabel `type_transportasi`
--
ALTER TABLE `type_transportasi`
  ADD PRIMARY KEY (`id_type_transportasi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `penumpang`
--
ALTER TABLE `penumpang`
  MODIFY `id_penumpang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `rute`
--
ALTER TABLE `rute`
  MODIFY `id_rute` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `transportasi`
--
ALTER TABLE `transportasi`
  MODIFY `id_transportasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `transportasii`
--
ALTER TABLE `transportasii`
  MODIFY `id_transportasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `type_transportasi`
--
ALTER TABLE `type_transportasi`
  MODIFY `id_type_transportasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `fk_pemesanan_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `penumpang` (`id_penumpang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pemesanan_rute` FOREIGN KEY (`id_rute`) REFERENCES `rute` (`id_rute`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pemesanan_transportasi` FOREIGN KEY (`id_transportasi`) REFERENCES `transportasi` (`id_transportasi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transportasi`
--
ALTER TABLE `transportasi`
  ADD CONSTRAINT `transportasi_ibfk_1` FOREIGN KEY (`id_type_transportasi`) REFERENCES `type_transportasi` (`id_type_transportasi`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
