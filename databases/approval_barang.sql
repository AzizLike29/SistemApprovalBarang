-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 13, 2025 at 03:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `approval_barang`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_brg_keluar` bigint(20) UNSIGNED NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `jumlah` int(10) UNSIGNED NOT NULL,
  `tujuan` varchar(255) DEFAULT NULL,
  `keperluan` varchar(255) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `alasan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_brg_keluar`, `nama_barang`, `jumlah`, `tujuan`, `keperluan`, `tanggal`, `user_id`, `approved_by`, `is_approved`, `alasan`, `created_at`, `updated_at`) VALUES
(1, 'Mie Sedaap Cup Kari Ayam', 2, 'Keluar', 'pengiriman', '2025-11-22', 1, 1, 2, NULL, '2025-11-12 09:17:26', '2025-11-12 09:27:15'),
(2, 'Mie Sedaap Cup Kari Ayam', 1, 'Keluar', 'pengiriman', '2025-11-22', 1, 1, 2, NULL, '2025-11-12 09:37:26', '2025-11-12 09:37:59'),
(3, 'Mie Sedaap Tasty (mi lebar) Ayam Geprek', 11, 'Keluar', 'pengiriman', '2025-11-22', 1, 1, 2, NULL, '2025-11-12 09:40:49', '2025-11-12 09:41:32'),
(4, 'Mie Sedaap Soto', 3, 'Keluar', 'Pengiriman', '2025-11-15', 1, NULL, 0, NULL, '2025-11-12 20:48:54', '2025-11-12 20:48:54');

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_brg_masuk` bigint(20) UNSIGNED NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `jumlah` int(10) UNSIGNED NOT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `alasan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_brg_masuk`, `nama_barang`, `jumlah`, `supplier`, `tanggal`, `user_id`, `approved_by`, `is_approved`, `alasan`, `created_at`, `updated_at`) VALUES
(1, 'Mie Sedap', 2, 'PT Prakarsa Alam Segar (Wings Food)', '2025-11-15', 1, 1, 1, NULL, '2025-11-12 07:43:13', '2025-11-12 07:50:47'),
(2, 'Mie Sedaap Soto', 3, 'PT Prakarsa Alam Segar (Wings Food)', '2025-11-15', 1, 1, 1, NULL, '2025-11-12 07:50:14', '2025-11-12 07:51:40'),
(3, 'Mie Sedaap Cup Kari Ayam', 1, 'PT Prakarsa Alam Segar (Wings Food)', '2025-11-08', 1, 1, 1, NULL, '2025-11-12 07:53:09', '2025-11-12 07:55:53'),
(4, 'Mie Sedap', 3, 'PT Prakarsa Alam Segar (Wings Food)', '2025-11-15', 1, 1, 1, NULL, '2025-11-12 08:05:27', '2025-11-12 20:39:06'),
(5, 'Mie Sedap', 1, 'PT Prakarsa Alam Segar (Wings Food)', '2025-11-08', 1, 1, 1, NULL, '2025-11-12 08:07:51', '2025-11-12 20:39:32'),
(6, 'Mie Sedaap Cup Soto', 3, 'PT Prakarsa Alam Segar (Wings Food)', '2025-11-22', 1, 1, 2, NULL, '2025-11-12 08:15:30', '2025-11-12 20:40:21'),
(7, 'Mie Sedaap Cup Baso Spesial', 2, 'PT Prakarsa Alam Segar (Wings Food)', '2025-11-01', 1, 1, 2, NULL, '2025-11-12 08:34:31', '2025-11-12 08:34:54'),
(8, 'Mie Sedaap Tasty (mi lebar) Ayam Geprek', 11, 'PT Prakarsa Alam Segar (Wings Food)', '2025-11-08', 1, 1, 2, NULL, '2025-11-12 08:37:50', '2025-11-12 08:38:19'),
(9, 'Mie Sedaap Cup Baso Spesial', 2, 'PT Prakarsa Alam Segar (Wings Food)', '2025-11-15', 1, 1, 2, NULL, '2025-11-12 08:44:09', '2025-11-12 20:39:14'),
(10, 'Mie Sedaap Cup Ayam Bawang', 2, 'PT Prakarsa Alam Segar (Wings Food)', '2025-11-08', 1, 1, 2, NULL, '2025-11-12 08:50:51', '2025-11-12 20:40:31'),
(11, 'Indomie Goreng', 2, 'PT Prakarsa Alam Segar (Wings Food)', '2025-11-08', 1, 1, 2, NULL, '2025-11-12 09:00:49', '2025-11-12 09:01:27'),
(12, 'Mie Sedaap Cup Soto', 3, 'PT Prakarsa Alam Segar (Wings Food)', '2025-11-15', 1, 1, 2, NULL, '2025-11-12 09:34:04', '2025-11-12 09:34:39'),
(13, 'Mie Ayams', 2, 'PT Prakarsa Alam Segar (Wings Food)', '2025-11-14', 1, NULL, 0, NULL, '2025-11-12 09:37:02', '2025-11-12 20:39:25');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2025_11_11_034235_create_barang_masuk_table', 1),
(5, '2025_11_11_034750_create_barang_keluar_table', 1),
(6, '2025_11_11_035232_create_notifikasi_table', 1),
(7, '2025_11_12_022650_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` bigint(20) UNSIGNED NOT NULL,
  `jenis` enum('barang_masuk','barang_keluar') NOT NULL,
  `ref_id` bigint(20) UNSIGNED NOT NULL,
  `email_terkirim` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=terkirim, 0=belum',
  `telegram_terkirim` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=terkirim, 0=belum',
  `email_sent_at` datetime DEFAULT NULL,
  `telegram_sent_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `jenis`, `ref_id`, `email_terkirim`, `telegram_terkirim`, `email_sent_at`, `telegram_sent_at`, `created_at`) VALUES
(1, 'barang_masuk', 6, 1, 0, '2025-11-12 15:15:33', NULL, '2025-11-12 15:15:38'),
(2, 'barang_masuk', 7, 1, 0, '2025-11-12 15:34:35', NULL, '2025-11-12 15:34:37'),
(3, 'barang_masuk', 8, 1, 0, '2025-11-12 15:37:54', NULL, '2025-11-12 15:37:55'),
(4, 'barang_masuk', 9, 1, 0, '2025-11-12 15:44:13', NULL, '2025-11-12 15:44:15'),
(5, 'barang_masuk', 10, 1, 0, '2025-11-12 15:50:55', NULL, '2025-11-12 15:50:56'),
(6, 'barang_masuk', 11, 1, 0, '2025-11-12 16:00:54', NULL, '2025-11-12 16:00:55'),
(7, 'barang_keluar', 1, 1, 0, '2025-11-12 16:17:30', NULL, '2025-11-12 16:17:32'),
(8, 'barang_masuk', 12, 1, 0, '2025-11-12 16:34:08', NULL, '2025-11-12 16:34:09'),
(9, 'barang_masuk', 13, 1, 0, '2025-11-12 16:37:06', NULL, '2025-11-12 16:37:07'),
(10, 'barang_keluar', 2, 1, 0, '2025-11-12 16:37:29', NULL, '2025-11-12 16:37:30'),
(11, 'barang_keluar', 3, 1, 0, '2025-11-12 16:40:54', NULL, '2025-11-12 16:40:55'),
(12, 'barang_keluar', 4, 1, 0, '2025-11-13 03:49:05', NULL, '2025-11-13 03:49:09');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `telegram_chat_id` varchar(64) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `nama`, `email`, `password`, `no_telp`, `telegram_chat_id`, `remember_token`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Abdul Aziz Firdaus', 'abdulfirdaus590@gmail.com', '$2y$10$9JEBVcrsoCsGM9C0GobapuyVSt.fv6B.DQEllGDJT3kS/wBpj7coa', NULL, '', NULL, 'admin', '2025-11-12 07:39:56', '2025-11-12 20:50:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_brg_keluar`),
  ADD KEY `barang_keluar_user_id_foreign` (`user_id`),
  ADD KEY `barang_keluar_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_brg_masuk`),
  ADD KEY `barang_masuk_user_id_foreign` (`user_id`),
  ADD KEY `barang_masuk_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `notifikasi_jenis_ref_id_index` (`jenis`,`ref_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id_brg_keluar` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_brg_masuk` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id_users`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_keluar_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_users`) ON UPDATE CASCADE;

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id_users`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_users`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
