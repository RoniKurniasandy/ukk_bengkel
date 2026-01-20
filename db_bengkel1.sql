-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2026 at 01:27 AM
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
-- Database: `db_bengkel1`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `kendaraan_id` bigint(20) UNSIGNED NOT NULL,
  `layanan_id` bigint(20) UNSIGNED NOT NULL,
  `mekanik_id` bigint(20) UNSIGNED DEFAULT NULL,
  `keluhan` text DEFAULT NULL,
  `tanggal_booking` datetime NOT NULL,
  `jam_booking` time DEFAULT NULL,
  `status` enum('menunggu','disetujui','dikerjakan','ditolak','dibatalkan','selesai') NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `user_id`, `kendaraan_id`, `layanan_id`, `mekanik_id`, `keluhan`, `tanggal_booking`, `jam_booking`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 1, 2, 'aaoisdhuoiasd', '2026-01-14 00:00:00', '09:00:00', 'selesai', '2026-01-12 01:56:18', '2026-01-12 02:15:35'),
(2, 6, 1, 1, 2, 'maserfghsrgyuffjhsd', '2026-01-30 00:00:00', '09:36:00', 'selesai', '2026-01-12 02:32:44', '2026-01-12 03:53:27'),
(19, 6, 1, 1, 2, 'tfrdtrfcfr cr  rt', '2026-01-15 00:00:00', '09:20:00', 'selesai', '2026-01-13 02:16:12', '2026-01-13 03:03:26'),
(22, 14, 3, 1, 2, 'aqdada', '2026-01-16 00:00:00', '11:03:00', 'selesai', '2026-01-14 04:01:40', '2026-01-14 05:51:11'),
(23, 14, 4, 1, 2, 'mobil mogok', '2026-01-30 00:00:00', '13:08:00', 'selesai', '2026-01-14 06:03:33', '2026-01-14 06:12:52');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('kings-bengkel-mobil-cache-0716d9708d321ffb6a00818614779e779925365c', 'i:1;', 1768372567),
('kings-bengkel-mobil-cache-0716d9708d321ffb6a00818614779e779925365c:timer', 'i:1768372567;', 1768372567),
('kings-bengkel-mobil-cache-1574bddb75c78a6fd2251d61e2993b5146201319', 'i:1;', 1768369727),
('kings-bengkel-mobil-cache-1574bddb75c78a6fd2251d61e2993b5146201319:timer', 'i:1768369727;', 1768369727),
('laravel-cache-fa35e192121eabf3dabf9f5ea6abdbcbc107ac3b', 'i:2;', 1768362436),
('laravel-cache-fa35e192121eabf3dabf9f5ea6abdbcbc107ac3b:timer', 'i:1768362436;', 1768362436);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_servis`
--

CREATE TABLE `detail_servis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `servis_id` bigint(20) UNSIGNED NOT NULL,
  `stok_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_servis`
--

INSERT INTO `detail_servis` (`id`, `servis_id`, `stok_id`, `jumlah`, `harga_satuan`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 250000.00, 500000.00, '2026-01-12 01:57:55', '2026-01-12 01:57:55'),
(2, 9, 1, 4, 250000.00, 1000000.00, '2026-01-14 06:07:30', '2026-01-14 06:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
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
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `merk` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `plat_nomor` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id`, `user_id`, `merk`, `model`, `plat_nomor`, `created_at`, `updated_at`) VALUES
(1, 6, 'honda', 'suzuki', 'A 1234 B', '2026-01-12 01:55:58', '2026-01-12 01:55:58'),
(3, 14, 'asa', 'aaada', '2 ada 2', '2026-01-14 04:01:27', '2026-01-14 04:01:27'),
(4, 14, 'Yamaha', 'Jazz', 'P 2764 LA', '2026-01-14 06:02:33', '2026-01-14 06:02:33');

-- --------------------------------------------------------

--
-- Table structure for table `layanans`
--

CREATE TABLE `layanans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_layanan` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `estimasi_waktu` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `layanans`
--

INSERT INTO `layanans` (`id`, `nama_layanan`, `harga`, `estimasi_waktu`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Ganti Oli Mesin', 300000, '50 Menit', 'Ganti oli cepat dan akurat menggunakan oli berkualitas', '2026-01-12 01:43:04', '2026-01-13 05:57:25'),
(4, 'Ganti Oli', 50000, '30 Menit', 'Penggantian oli mesin dengan oli standar berkualitas.', '2026-01-14 07:14:45', '2026-01-14 07:14:45'),
(5, 'Service Ringan', 150000, '1 Jam', 'Pengecekan dan pembersihan komponen vital mesin, rem, dan filter udara.', '2026-01-14 07:14:45', '2026-01-14 07:14:45'),
(6, 'Service Besar', 500000, '3 Jam', 'Perawatan menyeluruh mesin, transmisi, dan kaki-kaki kendaraan.', '2026-01-14 07:14:45', '2026-01-14 07:14:45'),
(7, 'Tune Up', 250000, '2 Jam', 'Mengembalikan performa mesin ke kondisi optimal.', '2026-01-14 07:14:45', '2026-01-14 07:14:45'),
(8, 'Ganti Ban', 30000, '40 Menit', 'Jasa penggantian ban luar (tidak termasuk harga ban).', '2026-01-14 07:14:45', '2026-01-14 07:14:45'),
(9, 'Spooring & Balancing', 200000, '1.5 Jam', 'Penyetelan sudut roda dan penyeimbangan putaran roda.', '2026-01-14 07:14:45', '2026-01-14 07:14:45'),
(10, 'Cuci Mobil', 40000, '45 Menit', 'Pencucian body luar dan vakum interior.', '2026-01-14 07:14:45', '2026-01-14 07:14:45');

-- --------------------------------------------------------

--
-- Table structure for table `membership_tiers`
--

CREATE TABLE `membership_tiers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_level` varchar(255) NOT NULL,
  `min_transaksi` decimal(15,2) NOT NULL DEFAULT 0.00,
  `diskon_jasa` decimal(5,2) NOT NULL DEFAULT 0.00,
  `diskon_part` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `membership_tiers`
--

INSERT INTO `membership_tiers` (`id`, `nama_level`, `min_transaksi`, `diskon_jasa`, `diskon_part`, `created_at`, `updated_at`) VALUES
(1, 'Member Loyal', 5000000.00, 10.00, 10.00, '2026-01-13 02:26:42', '2026-01-13 02:26:42');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_10_060532_create_sessions_table', 1),
(5, '2025_10_13_063814_create_roles_and_user_roles_tables', 1),
(6, '2025_10_13_070000_create_layanans_table', 1),
(7, '2025_10_13_070500_create_stok_table', 1),
(8, '2025_10_13_071000_create_kendaraan_table', 1),
(9, '2025_10_13_072122_create_booking_table', 1),
(10, '2025_10_13_080000_create_servis_table', 1),
(11, '2025_10_14_031012_create_transaksi_table', 1),
(12, '2025_11_26_115438_create_detail_servis_table', 1),
(13, '2025_11_28_174859_create_pembayarans_table', 1),
(14, '2026_01_12_141941_create_membership_tiers_table', 2),
(15, '2026_01_12_141941_create_vouchers_table', 2),
(16, '2026_01_12_141942_add_discount_columns_to_users_table', 2),
(17, '2026_01_12_141943_add_discount_columns_to_transaksi_table', 2),
(18, '2026_01_13_082901_add_discount_columns_to_pembayarans_table', 3),
(19, '2026_01_14_080421_add_pending_phone_to_users_table', 4),
(20, '2026_01_14_080421_create_password_reset_tokens_table', 4),
(21, '2026_01_14_100940_add_email_verification_code_to_users_table', 5),
(22, '2026_01_14_111400_create_notifications_table', 6),
(23, '2026_01_14_140959_add_unique_to_no_hp_on_users_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('09d1e5cc-20e9-42d3-be38-12f222cc16fd', 'App\\Notifications\\BookingNotification', 'App\\Models\\User', 2, '{\"title\":\"Tugas Servis Baru\",\"message\":\"Anda ditugaskan untuk menservis P 2764 LA\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/mekanik\\/jadwal-servis\",\"icon\":\"bi-wrench\",\"type\":\"info\"}', NULL, '2026-01-14 06:06:18', '2026-01-14 06:06:18'),
('0aa6bd94-b70d-441b-8371-45e9fd4abb24', 'App\\Notifications\\BookingNotification', 'App\\Models\\User', 1, '{\"title\":\"Servis Diselesaikan Mekanik\",\"message\":\"Mekanik Joko Mechanic telah menyelesaikan servis untuk B 2345 C\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/servis\",\"icon\":\"bi-flag\",\"type\":\"info\"}', '2026-01-14 04:18:56', '2026-01-14 04:18:17', '2026-01-14 04:18:56'),
('26b03b52-d2c1-4107-9bf2-a27120ca3f07', 'App\\Notifications\\BookingNotification', 'App\\Models\\User', 1, '{\"title\":\"Servis Diselesaikan Mekanik\",\"message\":\"Mekanik Joko Mechanic telah menyelesaikan servis untuk 2 ada 2\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/servis\",\"icon\":\"bi-flag\",\"type\":\"info\"}', '2026-01-14 06:06:09', '2026-01-14 05:51:15', '2026-01-14 06:06:09'),
('62833cca-cd1d-46c1-ad00-07fb1e98eaad', 'App\\Notifications\\BookingNotification', 'App\\Models\\User', 7, '{\"title\":\"Servis Selesai\",\"message\":\"Kendaraan Anda (B 2345 C) sudah selesai diservis!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pelanggan\\/servis\",\"icon\":\"bi-check-circle\",\"type\":\"success\"}', NULL, '2026-01-14 04:18:19', '2026-01-14 04:18:19'),
('6ae7d30c-e740-4199-9864-b54ba4764cbc', 'App\\Notifications\\BookingNotification', 'App\\Models\\User', 14, '{\"title\":\"Servis Selesai\",\"message\":\"Kendaraan Anda (2 ada 2) sudah selesai diservis!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pelanggan\\/servis\",\"icon\":\"bi-check-circle\",\"type\":\"success\"}', '2026-01-14 06:01:46', '2026-01-14 05:51:11', '2026-01-14 06:01:46'),
('7d6870b5-0261-4dab-a3ac-91e680b6148c', 'App\\Notifications\\BookingNotification', 'App\\Models\\User', 1, '{\"title\":\"Booking Baru Masuk\",\"message\":\"Ada pesanan servis baru dari Bakron\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/servis\",\"icon\":\"bi-wrench\",\"type\":\"danger\"}', '2026-01-14 06:06:09', '2026-01-14 06:03:33', '2026-01-14 06:06:09'),
('d7bf55e7-9a4b-4189-bd43-821d12d41d18', 'App\\Notifications\\BookingNotification', 'App\\Models\\User', 14, '{\"title\":\"Booking Disetujui\",\"message\":\"Booking Anda untuk P 2764 LA telah disetujui.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pelanggan\\/booking\",\"icon\":\"bi-check-circle\",\"type\":\"success\"}', '2026-01-14 06:24:52', '2026-01-14 06:06:15', '2026-01-14 06:24:52'),
('dda43327-ee12-41ca-aa25-3bda8b6c737b', 'App\\Notifications\\BookingNotification', 'App\\Models\\User', 1, '{\"title\":\"Servis Diselesaikan Mekanik\",\"message\":\"Mekanik Joko Mechanic telah menyelesaikan servis untuk P 2764 LA\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/servis\",\"icon\":\"bi-flag\",\"type\":\"info\"}', '2026-01-14 06:15:06', '2026-01-14 06:12:55', '2026-01-14 06:15:06'),
('ece3c20a-6ca3-402c-a34a-7b224d5e5b8a', 'App\\Notifications\\BookingNotification', 'App\\Models\\User', 14, '{\"title\":\"Servis Selesai\",\"message\":\"Kendaraan Anda (P 2764 LA) sudah selesai diservis!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pelanggan\\/servis\",\"icon\":\"bi-check-circle\",\"type\":\"success\"}', '2026-01-14 06:24:52', '2026-01-14 06:12:52', '2026-01-14 06:24:52'),
('efc628de-aa9a-4415-b720-e28390739036', 'App\\Notifications\\BookingNotification', 'App\\Models\\User', 1, '{\"title\":\"Servis Diselesaikan Mekanik\",\"message\":\"Mekanik Joko Mechanic telah menyelesaikan servis untuk B 2345 C\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/servis\",\"icon\":\"bi-flag\",\"type\":\"info\"}', '2026-01-14 04:18:56', '2026-01-14 04:18:22', '2026-01-14 04:18:56'),
('f20b6092-3179-4b8c-ba9f-93c54793c050', 'App\\Notifications\\BookingNotification', 'App\\Models\\User', 7, '{\"title\":\"Servis Selesai\",\"message\":\"Kendaraan Anda (B 2345 C) sudah selesai diservis!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pelanggan\\/servis\",\"icon\":\"bi-check-circle\",\"type\":\"success\"}', NULL, '2026-01-14 04:18:14', '2026-01-14 04:18:14'),
('fea4bdb9-172e-4bfb-ade9-1ffecfcdd15e', 'App\\Notifications\\BookingNotification', 'App\\Models\\User', 14, '{\"title\":\"Servis Dimulai\",\"message\":\"Mekanik kami sudah mulai mengerjakan kendaraan Anda (P 2764 LA)\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/pelanggan\\/servis\",\"icon\":\"bi-wrench\",\"type\":\"primary\"}', '2026-01-14 06:24:52', '2026-01-14 06:06:32', '2026-01-14 06:24:52');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `servis_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `subtotal` decimal(15,2) DEFAULT NULL,
  `diskon_member` decimal(15,2) NOT NULL DEFAULT 0.00,
  `diskon_voucher` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kode_voucher` varchar(255) DEFAULT NULL,
  `grand_total` decimal(15,2) DEFAULT NULL,
  `jenis_pembayaran` enum('dp','pelunasan','full') NOT NULL,
  `metode_pembayaran` varchar(255) NOT NULL DEFAULT 'tunai',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status` enum('pending','diterima','ditolak') NOT NULL DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `diskon_manual` decimal(15,2) NOT NULL DEFAULT 0.00,
  `alasan_diskon_manual` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayarans`
--

INSERT INTO `pembayarans` (`id`, `servis_id`, `jumlah`, `subtotal`, `diskon_member`, `diskon_voucher`, `kode_voucher`, `grand_total`, `jenis_pembayaran`, `metode_pembayaran`, `bukti_pembayaran`, `status`, `catatan`, `created_at`, `updated_at`, `diskon_manual`, `alasan_diskon_manual`) VALUES
(1, 1, 500000.00, NULL, 0.00, 0.00, NULL, NULL, 'dp', 'transfer', 'bukti_pembayaran/sCpHLKWoEOttRKX2jGo7llMsXGyHVIuiaUtjWo0X.png', 'diterima', NULL, '2026-01-12 01:58:50', '2026-01-12 02:09:39', 0.00, NULL),
(2, 1, 800000.00, NULL, 0.00, 0.00, NULL, NULL, 'full', 'tunai', NULL, 'diterima', NULL, '2026-01-12 02:15:56', '2026-01-12 02:20:50', 0.00, NULL),
(3, 2, 200000.00, NULL, 0.00, 0.00, NULL, NULL, 'dp', 'tunai', NULL, 'ditolak', 'sxsxsx', '2026-01-12 03:52:26', '2026-01-12 03:53:05', 0.00, NULL),
(4, 2, 200000.00, NULL, 0.00, 0.00, NULL, NULL, 'dp', 'tunai', NULL, 'diterima', NULL, '2026-01-12 03:52:26', '2026-01-12 03:52:50', 0.00, NULL),
(5, 2, 100000.00, NULL, 0.00, 0.00, NULL, NULL, 'pelunasan', 'tunai', NULL, 'diterima', NULL, '2026-01-12 04:01:14', '2026-01-12 04:01:27', 0.00, NULL),
(9, 5, 250000.00, NULL, 0.00, 0.00, NULL, NULL, 'full', 'tunai', NULL, 'diterima', 'Pembayaran Manual Admin', '2026-01-13 02:29:00', '2026-01-13 02:29:00', 0.00, NULL),
(13, 8, 200000.00, 300000.00, 0.00, 60000.00, 'KING99', 240000.00, 'dp', 'tunai', NULL, 'diterima', NULL, '2026-01-14 04:20:38', '2026-01-14 04:20:51', 0.00, NULL),
(14, 8, 100000.00, 300000.00, 0.00, 0.00, NULL, 300000.00, 'pelunasan', 'tunai', NULL, 'diterima', NULL, '2026-01-14 05:52:45', '2026-01-14 05:52:56', 0.00, NULL),
(15, 9, 1300000.00, 1300000.00, 0.00, 0.00, NULL, 1300000.00, 'full', 'tunai', NULL, 'diterima', NULL, '2026-01-14 06:13:36', '2026-01-14 06:14:11', 0.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Akses penuh ke sistem', NULL, NULL),
(2, 'mekanik', 'Mengelola servis kendaraan', NULL, NULL),
(3, 'pelanggan', 'Melakukan booking dan melihat status servis', NULL, NULL),
(4, 'admin', 'Akses penuh ke sistem', NULL, NULL),
(5, 'mekanik', 'Mengelola servis kendaraan', NULL, NULL),
(6, 'pelanggan', 'Melakukan booking dan melihat status servis', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servis`
--

CREATE TABLE `servis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mekanik_id` bigint(20) UNSIGNED DEFAULT NULL,
  `estimasi_biaya` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` enum('dikerjakan','selesai') NOT NULL DEFAULT 'dikerjakan',
  `status_pembayaran` enum('belum_bayar','dp_lunas','lunas') NOT NULL DEFAULT 'belum_bayar',
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `servis`
--

INSERT INTO `servis` (`id`, `booking_id`, `mekanik_id`, `estimasi_biaya`, `status`, `status_pembayaran`, `waktu_mulai`, `waktu_selesai`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 800000.00, 'selesai', 'lunas', '2026-01-12 08:57:18', '2026-01-12 09:15:35', '2026-01-12 01:57:18', '2026-01-12 02:20:50'),
(2, 2, 2, 300000.00, 'selesai', 'lunas', '2026-01-12 10:51:43', '2026-01-12 10:53:27', '2026-01-12 03:51:43', '2026-01-12 04:01:27'),
(5, 19, 2, 300000.00, 'selesai', 'lunas', '2026-01-13 09:18:03', '2026-01-13 10:03:26', '2026-01-13 02:18:03', '2026-01-13 03:03:26'),
(8, 22, 2, 300000.00, 'selesai', 'lunas', '2026-01-14 11:02:14', '2026-01-14 12:51:11', '2026-01-14 04:02:14', '2026-01-14 05:52:56'),
(9, 23, 2, 1300000.00, 'selesai', 'lunas', '2026-01-14 13:06:32', '2026-01-14 13:12:52', '2026-01-14 06:06:32', '2026-01-14 06:14:11');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1SNqbaAptQwCFHyoW05CnmsnnFBIJq2nBnTdmi0i', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaVJzcHJMc3h3aFZyN0Qwc1ZPOTV0VVRhZldVaWJmWk9PVG5SY1Z0byI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768375732),
('9kNzxeZfXJdHOpWohLJxzAcTaF4WR0PQS9b0z5u5', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYWpzczVBSHdLVjJBTTdSck1GQkU3WVE2dTJSSDVpS0ZMTHg0RzgzRyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3BlbGFuZ2dhbi9zZXJ2aXMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3BlbGFuZ2dhbi9zZXJ2aXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNDt9', 1768377966),
('bEAX1HjzwkefxjsAau5H3wJDSMdzRwFQMyRQkYXj', 17, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVHF5Z2I4T2hmUzZyMjdjTExuVVRqc3Fxdm9STnl2eHVKUjZrTUwwTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZWxhbmdnYW4vZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTc7fQ==', 1768374815),
('MXOcdLZ8Co05NbuPSgPAR3yDJOkIaLHbtiaWG5vq', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS3lGTnZSMndSZkNGTWdJUUNRN013dDA2VllzNHVueEx6MGpGUTRPaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZWthbmlrL3NlcnZpcy1kaWtlcmpha2FuIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1768371177),
('P4I4iFz9xeF2Fw9RViXwT0ORBXD6gd2SyrAiWyyi', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUTk0V3dOUk1NWmY1WWphQ094bVZ0OVExd1NvSmF1elRSdzlIS2pHSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi90cmFuc2Frc2kiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1768378134);

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE `stok` (
  `stok_id` bigint(20) UNSIGNED NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 0,
  `nomor_seri` varchar(255) DEFAULT NULL,
  `harga_beli` decimal(12,2) NOT NULL DEFAULT 0.00,
  `harga_jual` decimal(12,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok`
--

INSERT INTO `stok` (`stok_id`, `kode_barang`, `nama_barang`, `satuan`, `jumlah`, `nomor_seri`, `harga_beli`, `harga_jual`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'B001', 'Ban Mobil Ace', NULL, 99, 'BM0012q', 200000.00, 250000.00, 'Ban Mobil merk yamahahA', '2026-01-12 01:34:59', '2026-01-14 06:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `servis_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stok_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `jenis_transaksi` enum('pemasukan','pengeluaran') NOT NULL DEFAULT 'pemasukan',
  `sumber` varchar(255) NOT NULL DEFAULT 'servis',
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `diskon_member` decimal(15,2) NOT NULL DEFAULT 0.00,
  `diskon_voucher` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kode_voucher` varchar(255) DEFAULT NULL,
  `diskon_manual` decimal(15,2) NOT NULL DEFAULT 0.00,
  `alasan_diskon_manual` varchar(255) DEFAULT NULL,
  `grand_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`transaksi_id`, `user_id`, `servis_id`, `stok_id`, `jumlah`, `jenis_transaksi`, `sumber`, `subtotal`, `diskon_member`, `diskon_voucher`, `kode_voucher`, `diskon_manual`, `alasan_diskon_manual`, `grand_total`, `total`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 1, 12, 'pengeluaran', 'belanja_stok', 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0.00, 2400000.00, 'selesai', 'Belanja Stok Baru: Ban Mobil', '2026-01-12 01:34:59', '2026-01-12 01:34:59'),
(2, 1, 1, NULL, NULL, 'pemasukan', 'servis', 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0.00, 500000.00, 'selesai', 'Pembayaran DP - Servis #1 (Sisa: Rp 300.000)', '2026-01-12 02:09:39', '2026-01-12 02:09:39'),
(3, 2, 1, NULL, NULL, 'pemasukan', 'servis', 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0.00, 800000.00, 'pending', 'Servis Selesai oleh Mekanik - A 1234 B', '2026-01-12 02:15:35', '2026-01-12 02:15:35'),
(4, 1, 1, NULL, NULL, 'pemasukan', 'servis', 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0.00, 800000.00, 'selesai', 'Pembayaran Lunas - Servis #1', '2026-01-12 02:20:50', '2026-01-12 02:20:50'),
(5, 1, 2, NULL, NULL, 'pemasukan', 'servis', 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0.00, 200000.00, 'selesai', 'Pembayaran DP - Servis #2 (Sisa: Rp 100.000)', '2026-01-12 03:52:50', '2026-01-12 03:52:50'),
(6, 2, 2, NULL, NULL, 'pemasukan', 'servis', 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0.00, 300000.00, 'pending', 'Servis Selesai oleh Mekanik - A 1234 B', '2026-01-12 03:53:27', '2026-01-12 03:53:27'),
(7, 1, 2, NULL, NULL, 'pemasukan', 'servis', 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0.00, 100000.00, 'selesai', 'Pembayaran Pelunasan - Servis #2', '2026-01-12 04:01:27', '2026-01-12 04:01:27'),
(11, 2, NULL, NULL, NULL, 'pemasukan', 'servis', 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0.00, 300000.00, 'pending', 'Servis Selesai oleh Mekanik - B 2345 C', '2026-01-13 02:02:45', '2026-01-13 02:02:45'),
(13, 2, NULL, NULL, NULL, 'pemasukan', 'servis', 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0.00, 450000.00, 'pending', 'Servis Selesai oleh Mekanik - B 2345 C', '2026-01-13 02:17:58', '2026-01-13 02:17:58'),
(14, 1, 5, NULL, NULL, 'pemasukan', 'servis', 300000.00, 0.00, 0.00, NULL, 50000.00, 'pengerjaan lebih dari estimasi', 250000.00, 250000.00, 'selesai', 'Pembayaran Manual (Tunai) - Servis #5 (Lunas)', '2026-01-13 02:29:00', '2026-01-13 02:29:00'),
(15, 2, 5, NULL, NULL, 'pemasukan', 'servis', 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0.00, 300000.00, 'pending', 'Servis Selesai oleh Mekanik - A 1234 B', '2026-01-13 03:03:26', '2026-01-13 03:03:26'),
(16, 1, NULL, NULL, NULL, 'pemasukan', 'servis', 450000.00, 0.00, 50000.00, 'bengkel50k', 50000.00, 'orang pentiing', 350000.00, 350000.00, 'selesai', 'Pembayaran Manual (Tunai) - Servis #6 (Lunas)', '2026-01-13 03:04:48', '2026-01-13 03:04:48'),
(17, 2, NULL, NULL, NULL, 'pemasukan', 'servis', 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0.00, 450000.00, 'pending', 'Servis Selesai oleh Mekanik - A 1234 B', '2026-01-13 03:25:14', '2026-01-13 03:25:14'),
(19, 1, NULL, 1, 93, 'pengeluaran', 'belanja_stok', 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0.00, 18600000.00, 'selesai', 'Restock Barang: Ban Mobil Ace', '2026-01-13 04:07:51', '2026-01-13 04:07:51'),
(20, 1, NULL, NULL, NULL, 'pemasukan', 'servis', 300000.00, 0.00, 60000.00, 'KING99', 40000.00, 'orang pentiing', 200000.00, 100000.00, 'selesai', 'Pembayaran Manual (Transfer) - Servis #7 (Lunas)', '2026-01-13 04:12:47', '2026-01-13 04:12:47'),
(21, 2, NULL, NULL, NULL, 'pemasukan', 'servis', 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0.00, 300000.00, 'pending', 'Servis Selesai oleh Mekanik - B 2345 C', '2026-01-14 04:18:18', '2026-01-14 04:18:18'),
(22, 2, NULL, NULL, NULL, 'pemasukan', 'servis', 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0.00, 300000.00, 'pending', 'Servis Selesai oleh Mekanik - B 2345 C', '2026-01-14 04:18:23', '2026-01-14 04:18:23'),
(23, 14, 8, NULL, NULL, 'pemasukan', 'servis', 300000.00, 0.00, 60000.00, 'KING99', 0.00, NULL, 240000.00, 200000.00, 'selesai', 'Pembayaran DP - Servis #8 (Sisa: Rp 40.000)', '2026-01-14 04:20:51', '2026-01-14 04:20:51'),
(24, 2, 8, NULL, NULL, 'pemasukan', 'servis', 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0.00, 300000.00, 'pending', 'Servis Selesai oleh Mekanik - 2 ada 2', '2026-01-14 05:51:16', '2026-01-14 05:51:16'),
(25, 14, 8, NULL, NULL, 'pemasukan', 'servis', 300000.00, 0.00, 0.00, NULL, 0.00, NULL, 300000.00, 100000.00, 'selesai', 'Pembayaran Pelunasan - Servis #8', '2026-01-14 05:52:56', '2026-01-14 05:52:56'),
(26, 14, 9, NULL, NULL, 'pemasukan', 'servis', 1300000.00, 0.00, 0.00, NULL, 0.00, NULL, 1300000.00, 1300000.00, 'selesai', 'Pembayaran Lunas - Servis #9', '2026-01-14 06:14:11', '2026-01-14 06:14:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `email_verification_code` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `total_transaksi` decimal(15,2) NOT NULL DEFAULT 0.00,
  `membership_tier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `pending_no_hp` varchar(255) DEFAULT NULL,
  `phone_verification_code` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'pelanggan',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `email_verified_at`, `email_verification_code`, `password`, `total_transaksi`, `membership_tier_id`, `foto`, `no_hp`, `pending_no_hp`, `phone_verification_code`, `alamat`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Bengkel', 'admin@bengkel.com', '2026-01-14 03:48:18', NULL, '$2y$12$3vhej7c.tWpiO8O7xetKqe24suQPCN602YDy1VMj5Q.5h2RYRlzse', 2200000.00, NULL, '1768286874_ppBengkel.jpg', '081234567890', NULL, NULL, 'Jl. Raya Utama No. 1 Indonesia Raya', 'admin', NULL, '2026-01-12 01:33:03', '2026-01-14 03:48:18'),
(2, 'Joko Mechanic', 'joko@bengkel.com', '2026-01-14 03:48:18', NULL, '$2y$12$9Q9foLBnoY2dWIbjNtGbQOriLaxft/lVXKjNflwQRyRxQJ0AalLP.', 0.00, NULL, NULL, '08155667788', NULL, NULL, 'Jl. Kenanga No. 10', 'mekanik', NULL, '2026-01-12 01:33:03', '2026-01-14 03:48:18'),
(3, 'Andi Mechanic', 'andi@bengkel.com', '2026-01-14 03:48:18', NULL, '$2y$12$xtPXdsZk3w5ir5sSBZ5JsOr2sK/a33kgoEMqsFBkGoaxN9INmmkqe', 0.00, NULL, NULL, '08166778899', NULL, NULL, 'Jl. Flamboyan No. 12', 'mekanik', NULL, '2026-01-12 01:33:03', '2026-01-14 03:48:18'),
(4, 'Budi Santoso', 'budi@gmail.com', '2026-01-14 03:48:18', NULL, '$2y$12$Xlz496C3nEGmYd1N6EHJTObPhaQ6SdCr6khOhBtN60ohkO81EhbSq', 0.00, NULL, NULL, '08122334455', NULL, NULL, 'Jl. Melati No. 5', 'pelanggan', NULL, '2026-01-12 01:33:04', '2026-01-14 03:48:18'),
(5, 'Siti Aminah', 'siti@gmail.com', '2026-01-14 03:48:18', NULL, '$2y$12$jva2d1l1Xu7h1O46ldbsReASef2YiihdwuqMeNwAEmBJ8jIyTjJWG', 0.00, NULL, NULL, '08133445566', NULL, NULL, 'Jl. Mawar No. 8', 'pelanggan', NULL, '2026-01-12 01:33:04', '2026-01-14 03:48:18'),
(6, 'Akbar Sukabar', 'akbar@gmail.co.id', '2026-01-14 03:48:18', NULL, '$2y$12$s12DQXFLILlfNIsLrZOefutz06Soh49MfAvvs8jg0fm7iebnnBUBW', 0.00, NULL, '1768286952_boboiboy_topan.jpg', '081234567729', NULL, NULL, 'Jl. Ahmad Yani Surabaya Jawatimur Indonesia', 'pelanggan', NULL, '2026-01-12 01:55:28', '2026-01-14 03:48:18'),
(14, 'Bakron', 'ronigacorrr@gmail.com', '2026-01-14 03:46:42', NULL, '$2y$12$2YkKlfDcY7HgsAwVevzFWeF0oKF8oND/XdCJl8dn00KkYYgDZHpAe', 1600000.00, NULL, NULL, NULL, NULL, NULL, NULL, 'pelanggan', NULL, '2026-01-14 02:08:34', '2026-01-14 06:14:11'),
(15, 'sahuvdytuasdyta', 'aftdart@gmail.co', NULL, '104985', '$2y$12$sjm/q.xhhu8sQz1cN7xI/eK7pXOg1T4x0Wj2Dzg.LdpW1MsUzNagq', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, 'pelanggan', NULL, '2026-01-14 04:10:08', '2026-01-14 04:10:08'),
(17, 'Fajri Sukarji', 'fajriharianto2@gmail.com', '2026-01-14 06:35:07', NULL, '$2y$12$k2BnMZ2y6gSOFvpMTYdcVObcN5TOdoI3ikuSpVsnebZY.PiwftCpG', 0.00, NULL, '1768372519_boboiboy_api.jpg', NULL, NULL, NULL, NULL, 'pelanggan', NULL, '2026-01-14 06:34:39', '2026-01-14 06:59:07');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 3),
(5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `tipe_diskon` enum('nominal','persen') NOT NULL DEFAULT 'nominal',
  `nilai` decimal(15,2) NOT NULL,
  `min_transaksi` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kuota` int(11) NOT NULL DEFAULT 0,
  `tgl_mulai` datetime DEFAULT NULL,
  `tgl_berakhir` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `kode`, `tipe_diskon`, `nilai`, `min_transaksi`, `kuota`, `tgl_mulai`, `tgl_berakhir`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'BENGKEL50K', 'nominal', 50000.00, 50000.00, 0, '2026-01-05 00:00:00', '2026-01-13 00:00:00', 1, '2026-01-13 00:32:28', '2026-01-13 03:04:48'),
(3, 'KING99', 'persen', 20.00, 200000.00, 98, '2026-01-13 00:00:00', '2026-01-22 00:00:00', 1, '2026-01-13 04:10:32', '2026-01-14 06:12:26'),
(4, 'DISC1JT', 'nominal', 500000.00, 1000000.00, 2, '2026-01-13 00:00:00', '2026-01-14 00:00:00', 1, '2026-01-14 06:12:05', '2026-01-14 06:12:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `booking_user_id_foreign` (`user_id`),
  ADD KEY `booking_kendaraan_id_foreign` (`kendaraan_id`),
  ADD KEY `booking_layanan_id_foreign` (`layanan_id`),
  ADD KEY `booking_mekanik_id_foreign` (`mekanik_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `detail_servis`
--
ALTER TABLE `detail_servis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `detail_servis_servis_id_stok_id_unique` (`servis_id`,`stok_id`),
  ADD KEY `detail_servis_stok_id_foreign` (`stok_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kendaraan_plat_nomor_unique` (`plat_nomor`),
  ADD KEY `kendaraan_user_id_foreign` (`user_id`);

--
-- Indexes for table `layanans`
--
ALTER TABLE `layanans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership_tiers`
--
ALTER TABLE `membership_tiers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `membership_tiers_nama_level_unique` (`nama_level`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayarans_servis_id_foreign` (`servis_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `role_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `servis`
--
ALTER TABLE `servis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `servis_booking_id_foreign` (`booking_id`),
  ADD KEY `servis_mekanik_id_foreign` (`mekanik_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`stok_id`),
  ADD UNIQUE KEY `stok_kode_barang_unique` (`kode_barang`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transaksi_id`),
  ADD KEY `transaksi_user_id_foreign` (`user_id`),
  ADD KEY `transaksi_servis_id_foreign` (`servis_id`),
  ADD KEY `transaksi_stok_id_foreign` (`stok_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_no_hp_unique` (`no_hp`),
  ADD KEY `users_membership_tier_id_foreign` (`membership_tier_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `user_roles_role_id_foreign` (`role_id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vouchers_kode_unique` (`kode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `detail_servis`
--
ALTER TABLE `detail_servis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `layanans`
--
ALTER TABLE `layanans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `membership_tiers`
--
ALTER TABLE `membership_tiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pembayarans`
--
ALTER TABLE `pembayarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `servis`
--
ALTER TABLE `servis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `stok_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `transaksi_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_kendaraan_id_foreign` FOREIGN KEY (`kendaraan_id`) REFERENCES `kendaraan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_layanan_id_foreign` FOREIGN KEY (`layanan_id`) REFERENCES `layanans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_mekanik_id_foreign` FOREIGN KEY (`mekanik_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `booking_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detail_servis`
--
ALTER TABLE `detail_servis`
  ADD CONSTRAINT `detail_servis_servis_id_foreign` FOREIGN KEY (`servis_id`) REFERENCES `servis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_servis_stok_id_foreign` FOREIGN KEY (`stok_id`) REFERENCES `stok` (`stok_id`);

--
-- Constraints for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD CONSTRAINT `kendaraan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD CONSTRAINT `pembayarans_servis_id_foreign` FOREIGN KEY (`servis_id`) REFERENCES `servis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE;

--
-- Constraints for table `servis`
--
ALTER TABLE `servis`
  ADD CONSTRAINT `servis_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `servis_mekanik_id_foreign` FOREIGN KEY (`mekanik_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_servis_id_foreign` FOREIGN KEY (`servis_id`) REFERENCES `servis` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transaksi_stok_id_foreign` FOREIGN KEY (`stok_id`) REFERENCES `stok` (`stok_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transaksi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_membership_tier_id_foreign` FOREIGN KEY (`membership_tier_id`) REFERENCES `membership_tiers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
