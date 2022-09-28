-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.7.24 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla greenflame.access_types
CREATE TABLE IF NOT EXISTS `access_types` (
  `code` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla greenflame.access_types: ~3 rows (aproximadamente)
DELETE FROM `access_types`;
/*!40000 ALTER TABLE `access_types` DISABLE KEYS */;
INSERT INTO `access_types` (`code`, `name`, `display_order`) VALUES
	('A', 'Agency', 2),
	('C', 'Corporate', 3),
	('F', 'Customer', 1);
/*!40000 ALTER TABLE `access_types` ENABLE KEYS */;

-- Volcando estructura para tabla greenflame.brands
CREATE TABLE IF NOT EXISTS `brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla greenflame.brands: ~3 rows (aproximadamente)
DELETE FROM `brands`;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` (`id`, `name`, `display_order`, `active`) VALUES
	(1, 'Avis', 1, 1),
	(2, 'Budget', 2, 1),
	(3, 'Payless', 3, 1);
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;

-- Volcando estructura para tabla greenflame.discounts
CREATE TABLE IF NOT EXISTS `discounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `priority` int(10) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `region_id` bigint(20) unsigned NOT NULL,
  `brand_id` bigint(20) unsigned NOT NULL,
  `access_type_code` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `discounts_region_id_foreign` (`region_id`),
  KEY `discounts_brand_id_foreign` (`brand_id`),
  KEY `discounts_access_type_code_foreign` (`access_type_code`),
  CONSTRAINT `discounts_access_type_code_foreign` FOREIGN KEY (`access_type_code`) REFERENCES `access_types` (`code`),
  CONSTRAINT `discounts_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  CONSTRAINT `discounts_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla greenflame.discounts: ~12 rows (aproximadamente)
DELETE FROM `discounts`;
/*!40000 ALTER TABLE `discounts` DISABLE KEYS */;
INSERT INTO `discounts` (`id`, `name`, `start_date`, `end_date`, `priority`, `active`, `region_id`, `brand_id`, `access_type_code`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'ff', '2022-09-27 16:53:27', '2022-09-27 16:53:28', 0, 0, 4, 1, 'F', '2022-09-27 16:53:37', '2022-09-27 16:53:38', NULL),
	(2, 'Nueva', '2022-09-26 00:00:00', '2022-09-27 00:00:00', 12, 0, 1, 1, 'F', '2022-09-27 23:31:31', '2022-09-27 23:31:31', NULL),
	(3, 'Nueva1', '2022-09-26 00:00:00', '2022-09-27 00:00:00', 12, 1, 1, 1, 'F', '2022-09-27 23:31:48', '2022-09-27 23:31:48', NULL),
	(4, 'Nueva2', '2022-09-26 00:00:00', '2022-09-27 00:00:00', 12, 1, 1, 1, 'F', '2022-09-27 23:42:29', '2022-09-27 23:42:29', NULL),
	(5, 'Nueva3', '2022-09-13 00:00:00', '2022-09-21 00:00:00', 12, 0, 1, 1, 'F', '2022-09-27 23:43:37', '2022-09-27 23:43:37', NULL),
	(6, 'Nueva4', '2022-09-20 00:00:00', '2022-09-29 00:00:00', 12, 0, 1, 1, 'F', '2022-09-27 23:46:59', '2022-09-27 23:46:59', NULL),
	(7, 'Nueva5', '2022-09-28 00:00:00', '2022-10-06 00:00:00', 14, 0, 1, 3, 'F', '2022-09-27 23:47:31', '2022-09-28 17:13:23', '2022-09-28 17:13:23'),
	(8, 'Nueva7', '2022-10-04 00:00:00', '2022-11-04 00:00:00', 12, 1, 4, 1, 'F', '2022-09-27 23:52:39', '2022-09-28 17:12:51', '2022-09-28 17:12:51'),
	(9, 'Nueva8', '2022-10-04 00:00:00', '2022-11-04 00:00:00', 12, 1, 1, 2, 'C', '2022-09-27 23:54:45', '2022-09-28 18:57:13', NULL),
	(10, 'dsdsds', '2022-10-05 00:00:00', '2022-10-06 00:00:00', 8, 0, 4, 1, 'F', '2022-09-27 23:56:14', '2022-09-27 23:56:14', NULL),
	(11, 'dsdsds45', '2022-10-05 00:00:00', '2022-10-06 00:00:00', 12, 1, 2, 2, 'A', '2022-09-27 23:57:05', '2022-09-27 23:57:05', NULL),
	(12, 'dsdsds4554', '2022-10-04 00:00:00', '2022-10-05 00:00:00', 12, 1, 1, 1, 'F', '2022-09-28 00:06:47', '2022-09-28 00:06:47', NULL),
	(13, 'r32r23', '2022-10-04 00:00:00', '2022-10-05 00:00:00', 12, 0, 1, 3, 'A', '2022-09-28 00:08:23', '2022-09-28 00:08:23', NULL),
	(14, 'Nueva7', '2022-10-04 00:00:00', '2022-10-05 00:00:00', 44, 0, 1, 1, 'F', '2022-09-28 18:45:54', '2022-09-28 18:45:54', NULL),
	(15, 'Nueva9', '2022-09-06 00:00:00', '2022-09-07 00:00:00', 11, 0, 1, 1, 'F', '2022-09-28 18:46:34', '2022-09-28 18:46:34', NULL);
/*!40000 ALTER TABLE `discounts` ENABLE KEYS */;

-- Volcando estructura para tabla greenflame.discount_ranges
CREATE TABLE IF NOT EXISTS `discount_ranges` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `from_days` int(10) unsigned NOT NULL,
  `to_days` int(10) unsigned NOT NULL,
  `discount` double DEFAULT NULL,
  `code` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `discount_ranges_discount_id_foreign` (`discount_id`),
  CONSTRAINT `discount_ranges_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla greenflame.discount_ranges: ~8 rows (aproximadamente)
DELETE FROM `discount_ranges`;
/*!40000 ALTER TABLE `discount_ranges` DISABLE KEYS */;
INSERT INTO `discount_ranges` (`id`, `from_days`, `to_days`, `discount`, `code`, `discount_id`, `created_at`, `updated_at`) VALUES
	(6, 12, 32, NULL, 'sda', 10, '2022-09-27 23:56:14', '2022-09-27 23:56:14'),
	(7, 12, 54, 14, NULL, 10, '2022-09-27 23:56:14', '2022-09-27 23:56:14'),
	(8, 12, 32, NULL, 'sda', 11, '2022-09-27 23:57:05', '2022-09-27 23:57:05'),
	(9, 12, 32, NULL, '43', 12, '2022-09-28 00:06:47', '2022-09-28 00:06:47'),
	(10, 12, 32, 34, NULL, 13, '2022-09-28 00:08:23', '2022-09-28 00:08:23'),
	(21, 12, 66, NULL, 'bgntfrr', 14, '2022-09-28 18:45:54', '2022-09-28 18:45:54'),
	(22, 1, 56, 12, NULL, 15, '2022-09-28 18:46:34', '2022-09-28 18:46:34'),
	(27, 12, 32, NULL, 'fdwe', 9, '2022-09-28 18:57:13', '2022-09-28 18:57:13'),
	(28, 34, 54, NULL, 'fccc', 9, '2022-09-28 18:57:13', '2022-09-28 18:57:13');
/*!40000 ALTER TABLE `discount_ranges` ENABLE KEYS */;

-- Volcando estructura para tabla greenflame.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla greenflame.failed_jobs: ~0 rows (aproximadamente)
DELETE FROM `failed_jobs`;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Volcando estructura para tabla greenflame.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla greenflame.migrations: ~9 rows (aproximadamente)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2022_09_27_131356_create_regions_table', 1),
	(6, '2022_09_27_131414_create_brands_table', 1),
	(7, '2022_09_27_131439_create_access_types_table', 1),
	(8, '2022_09_27_131455_create_discounts_table', 1),
	(9, '2022_09_27_131513_create_discount_ranges_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Volcando estructura para tabla greenflame.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla greenflame.password_resets: ~0 rows (aproximadamente)
DELETE FROM `password_resets`;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Volcando estructura para tabla greenflame.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla greenflame.personal_access_tokens: ~0 rows (aproximadamente)
DELETE FROM `personal_access_tokens`;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Volcando estructura para tabla greenflame.regions
CREATE TABLE IF NOT EXISTS `regions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla greenflame.regions: ~4 rows (aproximadamente)
DELETE FROM `regions`;
/*!40000 ALTER TABLE `regions` DISABLE KEYS */;
INSERT INTO `regions` (`id`, `code`, `name`, `display_order`) VALUES
	(1, 'NAM', 'North America & Canada', 1),
	(2, 'EMEA', 'Europe, Middle East and Africa', 2),
	(3, 'LAC', 'Latin America & the Caribbean', 3),
	(4, 'APAC', 'Asia Pacific', 4);
/*!40000 ALTER TABLE `regions` ENABLE KEYS */;

-- Volcando estructura para tabla greenflame.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla greenflame.users: ~0 rows (aproximadamente)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Clemmie Bartell', 'admin@example.com', '2022-09-27 19:46:42', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2KTcgOTynD', '2022-09-27 19:46:42', '2022-09-27 19:46:42');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
