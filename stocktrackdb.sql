-- Adminer 4.7.9 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `stocktrackdb`;
CREATE DATABASE `stocktrackdb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `stocktrackdb`;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `failed_jobs`;

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE `inventory` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `PRODUCT_ID` varchar(100) NOT NULL,
  `SERIAL_NO` varchar(100) NOT NULL,
  `LOCATION_ID` varchar(100) NOT NULL,
  `PURCHASE_DATE` date NOT NULL,
  `FOR_TRANSFER` varchar(100) DEFAULT '0',
  `STATUS` varchar(100) DEFAULT 'GOOD',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`PRODUCT_ID`,`SERIAL_NO`),
  UNIQUE KEY `id` (`id`),
  KEY `ASSET_ID_VENDOR_ID_INVENTORY_ID` (`PRODUCT_ID`),
  KEY `LOCATION_ID` (`LOCATION_ID`),
  CONSTRAINT `fk_inventory_product` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `product_list` (`PRODUCT_ID`),
  CONSTRAINT `inventory_ibfk_3` FOREIGN KEY (`LOCATION_ID`) REFERENCES `location` (`LOCATION_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `inventory_ibfk_9` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `product_list` (`PRODUCT_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `inventory`;
INSERT INTO `inventory` (`id`, `PRODUCT_ID`, `SERIAL_NO`, `LOCATION_ID`, `PURCHASE_DATE`, `FOR_TRANSFER`, `STATUS`, `created_at`, `updated_at`) VALUES
(9,	'PROD-000002',	'000',	'000001',	'2025-08-25',	'0',	'GOOD',	NULL,	NULL);

DROP TABLE IF EXISTS `inventory_to_receive`;
CREATE TABLE `inventory_to_receive` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `TRANSACTION_REF_NO` varchar(100) NOT NULL,
  `ASSET_ID` varchar(100) NOT NULL,
  `TRANSACTION_DATE` date NOT NULL,
  `LOCATION_ID` varchar(100) NOT NULL,
  `CREATED_BY` varchar(100) NOT NULL,
  `ASSET_CUSTODIAN` varchar(100) NOT NULL,
  `PURCHASER_ORDER_NO` varchar(100) NOT NULL,
  `PURCHASE_ORDER_DATE` varchar(100) NOT NULL,
  `ASSET_AGE` varchar(100) NOT NULL,
  `IN_SERVICE_DATE` varchar(100) NOT NULL,
  `WARRANTY_START_DATE` varchar(100) NOT NULL,
  `WARRANTY_EXPIRY` varchar(100) NOT NULL,
  `QUANTITY_PURCHASED` varchar(100) NOT NULL,
  `QUANTITY_DELIVERED` int(11) NOT NULL DEFAULT 0,
  `STATUS` varchar(100) NOT NULL,
  `DELIVERY_SI_NO` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`TRANSACTION_REF_NO`),
  UNIQUE KEY `id` (`id`),
  KEY `inventory_to_receive_location_id_foreign` (`LOCATION_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `inventory_to_receive`;

DROP TABLE IF EXISTS `inventory_to_receive_delivery_details`;
CREATE TABLE `inventory_to_receive_delivery_details` (
  `UNIQUE_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TRANSACTION_REF_NO` varchar(191) NOT NULL,
  `SI_DR_NO` varchar(191) NOT NULL,
  `QUANTITY_DELIVERED` int(11) NOT NULL,
  `DATE_DELIVERED` date NOT NULL,
  `SERIAL_NO` varchar(191) NOT NULL,
  `ASSET_TAG_NO` varchar(191) NOT NULL,
  `ASSET_CONDITION` varchar(191) NOT NULL,
  `DELIVERY_STATUS` varchar(191) NOT NULL,
  `ASSET_STATUS` varchar(191) NOT NULL,
  `REMARKS` varchar(191) NOT NULL,
  PRIMARY KEY (`UNIQUE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

TRUNCATE `inventory_to_receive_delivery_details`;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(100) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `jobs`;

DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `LOCATION_ID` varchar(100) NOT NULL,
  `LOCATION` varchar(100) NOT NULL,
  `UPDATED_BY` varchar(100) NOT NULL,
  `DELETED` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`LOCATION_ID`),
  KEY `LOCATION_ID` (`LOCATION_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `location`;
INSERT INTO `location` (`LOCATION_ID`, `LOCATION`, `UPDATED_BY`, `DELETED`) VALUES
('000000',	'All Location',	'Admin Account',	0),
('000001',	'Default Location 1',	'Admin Account',	0),
('000002',	'Default Location 2',	'Admin Account',	0);

DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `AUDIT_ID` varchar(100) NOT NULL,
  `IP` varchar(100) NOT NULL,
  `USER_ID` varchar(100) NOT NULL,
  `USERFULLNAME` varchar(100) NOT NULL,
  `EVENT` varchar(100) NOT NULL,
  `MODULE` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`AUDIT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `logs`;
INSERT INTO `logs` (`AUDIT_ID`, `IP`, `USER_ID`, `USERFULLNAME`, `EVENT`, `MODULE`, `created_at`, `updated_at`) VALUES
('0000001',	'192.168.25.251',	'00000000',	'JIMAC SENDER',	'LOGGED IN',	'AUTH',	'2024-04-04 00:43:30',	'2024-04-04 00:43:30'),
('0000002',	'192.168.25.251',	'00000000',	'JIMAC SENDER',	'UPDATE',	'USER',	'2024-04-04 00:46:54',	'2024-04-04 00:46:54'),
('0000003',	'192.168.25.251',	'00000000',	'JIMAC SENDER',	'LOGGED OUT',	'AUTH',	'2024-04-04 00:47:21',	'2024-04-04 00:47:21'),
('0000004',	'192.168.25.251',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-04 00:47:26',	'2024-04-04 00:47:26'),
('0000005',	'192.168.25.251',	'00000001',	'Reene Brigette Beriso',	'LOGGED OUT',	'AUTH',	'2024-04-04 00:47:39',	'2024-04-04 00:47:39'),
('0000006',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-04 09:14:52',	'2024-04-04 09:14:52'),
('0000007',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'UPDATE',	'USER',	'2024-04-04 09:42:27',	'2024-04-04 09:42:27'),
('0000008',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'BULK LOAD',	'2024-04-04 10:19:04',	'2024-04-04 10:19:04'),
('0000009',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'BULK LOAD',	'2024-04-04 10:48:42',	'2024-04-04 10:48:42'),
('0000010',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'BULK LOAD',	'2024-04-04 10:51:21',	'2024-04-04 10:51:21'),
('0000011',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'USER',	'2024-04-04 10:55:13',	'2024-04-04 10:55:13'),
('0000012',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'UPDATE',	'USER',	'2024-04-04 10:55:33',	'2024-04-04 10:55:33'),
('0000013',	'192.168.25.20',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-04 10:55:53',	'2024-04-04 10:55:53'),
('0000014',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'USER',	'2024-04-04 10:58:39',	'2024-04-04 10:58:39'),
('0000015',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'UPDATE',	'USER',	'2024-04-04 10:58:57',	'2024-04-04 10:58:57'),
('0000016',	'192.168.25.20',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED OUT',	'AUTH',	'2024-04-04 10:59:12',	'2024-04-04 10:59:12'),
('0000017',	'192.168.25.20',	'00012855',	'CDI CDO Alvin Jay Magusara',	'LOGGED IN',	'AUTH',	'2024-04-04 10:59:18',	'2024-04-04 10:59:18'),
('0000018',	'192.168.1.38',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-04 14:02:55',	'2024-04-04 14:02:55'),
('0000019',	'192.168.1.38',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'BULK LOAD',	'2024-04-04 14:03:48',	'2024-04-04 14:03:48'),
('0000020',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-05 04:42:46',	'2024-04-05 04:42:46'),
('0000021',	'192.168.25.20',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-05 04:44:26',	'2024-04-05 04:44:26'),
('0000022',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'UPDATE',	'USER',	'2024-04-05 04:58:40',	'2024-04-05 04:58:40'),
('0000023',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'LOGGED OUT',	'AUTH',	'2024-04-05 04:59:17',	'2024-04-05 04:59:17'),
('0000024',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-05 04:59:25',	'2024-04-05 04:59:25'),
('0000025',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'LOGGED OUT',	'AUTH',	'2024-04-05 06:25:03',	'2024-04-05 06:25:03'),
('0000026',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-05 06:26:58',	'2024-04-05 06:26:58'),
('0000027',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'LOGGED OUT',	'AUTH',	'2024-04-05 06:54:27',	'2024-04-05 06:54:27'),
('0000028',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-05 06:56:27',	'2024-04-05 06:56:27'),
('0000029',	'192.168.1.38',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-06 02:00:18',	'2024-04-06 02:00:18'),
('0000030',	'192.168.1.38',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-06 09:09:39',	'2024-04-06 09:09:39'),
('0000031',	'192.168.1.38',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-06 09:54:16',	'2024-04-06 09:54:16'),
('0000032',	'192.168.1.38',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'LOCATION MANAGEMENT',	'2024-04-06 11:53:24',	'2024-04-06 11:53:24'),
('0000033',	'192.168.1.38',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-06 12:22:04',	'2024-04-06 12:22:04'),
('0000034',	'192.168.1.38',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'PRODUCT LIST',	'2024-04-06 13:57:01',	'2024-04-06 13:57:01'),
('0000035',	'192.168.1.38',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'PRODUCT LIST',	'2024-04-06 13:58:05',	'2024-04-06 13:58:05'),
('0000036',	'192.168.1.38',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'PRODUCT LIST',	'2024-04-06 14:04:51',	'2024-04-06 14:04:51'),
('0000037',	'192.168.1.38',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'PRODUCT LIST',	'2024-04-06 14:05:49',	'2024-04-06 14:05:49'),
('0000038',	'192.168.1.38',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'PRODUCT LIST',	'2024-04-06 14:06:27',	'2024-04-06 14:06:27'),
('0000039',	'192.168.1.38',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'PRODUCT LIST',	'2024-04-06 14:07:18',	'2024-04-06 14:07:18'),
('0000040',	'192.168.1.38',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'PRODUCT LIST',	'2024-04-06 14:08:06',	'2024-04-06 14:08:06'),
('0000041',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-07 23:32:33',	'2024-04-07 23:32:33'),
('0000042',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-08 02:07:59',	'2024-04-08 02:07:59'),
('0000043',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-08 06:40:25',	'2024-04-08 06:40:25'),
('0000044',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'UPDATE',	'USER',	'2024-04-08 06:41:47',	'2024-04-08 06:41:47'),
('0000045',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'UPDATE',	'USER',	'2024-04-08 06:43:05',	'2024-04-08 06:43:05'),
('0000046',	'192.168.1.38',	'0012862',	'5L NCR & RIZAL Marjhun Mallapre',	'LOGGED IN',	'AUTH',	'2024-04-08 07:03:08',	'2024-04-08 07:03:08'),
('0000047',	'10.88.80.11',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-08 07:43:30',	'2024-04-08 07:43:30'),
('0000048',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'UPDATE',	'USER',	'2024-04-08 08:30:22',	'2024-04-08 08:30:22'),
('0000049',	'10.88.80.3',	'0012859',	'CDI JENNY\'S Argie Undaloc',	'LOGGED IN',	'AUTH',	'2024-04-08 08:32:55',	'2024-04-08 08:32:55'),
('0000050',	'10.88.80.3',	'0012859',	'CDI JENNY\'S Argie Undaloc',	'LOGGED IN',	'AUTH',	'2024-04-08 08:49:09',	'2024-04-08 08:49:09'),
('0000051',	'192.168.25.20',	'00000001',	'Reene Brigette Beriso',	'UPDATE',	'USER',	'2024-04-08 08:53:36',	'2024-04-08 08:53:36'),
('0000052',	'192.168.1.38',	'0012862',	'5L NCR & RIZAL Marjhun Mallapre',	'LOGGED IN',	'AUTH',	'2024-04-09 07:20:52',	'2024-04-09 07:20:52'),
('0000053',	'192.168.1.38',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-09 07:25:54',	'2024-04-09 07:25:54'),
('0000054',	'192.168.1.38',	'00000001',	'Reene Brigette Beriso',	'UPDATE',	'USER',	'2024-04-09 07:36:42',	'2024-04-09 07:36:42'),
('0000055',	'192.168.1.38',	'0012862',	'5L NCR & RIZAL Marjhun Mallapre',	'LOGGED IN',	'AUTH',	'2024-04-11 03:55:50',	'2024-04-11 03:55:50'),
('0000056',	'192.168.1.38',	'0012862',	'5L NCR & RIZAL Marjhun Mallapre',	'LOGGED IN',	'AUTH',	'2024-04-12 04:21:34',	'2024-04-12 04:21:34'),
('0000057',	'10.88.80.7',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-15 00:55:24',	'2024-04-15 00:55:24'),
('0000058',	'192.168.1.38',	'0012862',	'5L NCR & RIZAL Marjhun Mallapre',	'LOGGED IN',	'AUTH',	'2024-04-16 03:23:41',	'2024-04-16 03:23:41'),
('0000059',	'10.88.80.2',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-17 01:15:06',	'2024-04-17 01:15:06'),
('0000060',	'192.168.25.50',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-18 02:22:31',	'2024-04-18 02:22:31'),
('0000061',	'192.168.25.50',	'00000001',	'Reene Brigette Beriso',	'UPDATE',	'USER',	'2024-04-18 02:29:58',	'2024-04-18 02:29:58'),
('0000062',	'10.88.80.13',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-18 03:42:40',	'2024-04-18 03:42:40'),
('0000063',	'192.168.25.50',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'PRODUCT LIST',	'2024-04-18 03:47:36',	'2024-04-18 03:47:36'),
('0000064',	'192.168.25.50',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'RECEIVE',	'2024-04-18 03:51:38',	'2024-04-18 03:51:38'),
('0000065',	'192.168.25.50',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-18 03:54:34',	'2024-04-18 03:54:34'),
('0000066',	'192.168.25.50',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'RECEIVE',	'2024-04-18 05:28:49',	'2024-04-18 05:28:49'),
('0000067',	'10.88.80.11',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-18 06:41:17',	'2024-04-18 06:41:17'),
('0000068',	'192.168.25.50',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-19 05:16:43',	'2024-04-19 05:16:43'),
('0000069',	'10.88.80.13',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-22 02:52:36',	'2024-04-22 02:52:36'),
('0000070',	'10.88.80.15',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-23 05:12:21',	'2024-04-23 05:12:21'),
('0000071',	'192.168.25.50',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-23 05:13:54',	'2024-04-23 05:13:54'),
('0000072',	'192.168.25.50',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-23 05:25:57',	'2024-04-23 05:25:57'),
('0000073',	'192.168.25.50',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'RECEIVE',	'2024-04-23 07:24:42',	'2024-04-23 07:24:42'),
('0000074',	'192.168.25.50',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-23 07:30:20',	'2024-04-23 07:30:20'),
('0000075',	'192.168.25.50',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'PRODUCT LIST',	'2024-04-23 07:51:20',	'2024-04-23 07:51:20'),
('0000076',	'192.168.25.50',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'RECEIVE',	'2024-04-23 07:54:05',	'2024-04-23 07:54:05'),
('0000077',	'192.168.25.50',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'PRODUCT LIST',	'2024-04-23 08:16:19',	'2024-04-23 08:16:19'),
('0000078',	'192.168.25.50',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'RECEIVE',	'2024-04-23 08:17:46',	'2024-04-23 08:17:46'),
('0000079',	'192.168.25.50',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'RECEIVE',	'2024-04-23 08:50:30',	'2024-04-23 08:50:30'),
('0000080',	'10.88.80.4',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-23 08:56:40',	'2024-04-23 08:56:40'),
('0000081',	'192.168.25.50',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-24 01:27:47',	'2024-04-24 01:27:47'),
('0000082',	'10.88.80.14',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-24 05:44:47',	'2024-04-24 05:44:47'),
('0000083',	'192.168.25.50',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-24 05:51:09',	'2024-04-24 05:51:09'),
('0000084',	'10.88.80.14',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-24 09:20:34',	'2024-04-24 09:20:34'),
('0000085',	'10.88.80.12',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-25 05:14:24',	'2024-04-25 05:14:24'),
('0000086',	'192.168.25.50',	'00012577',	'IMPEXTIC PASIG Ayen Garcia',	'LOGGED IN',	'AUTH',	'2024-04-25 10:52:45',	'2024-04-25 10:52:45'),
('0000087',	'192.168.25.251',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-29 02:31:01',	'2024-04-29 02:31:01'),
('0000088',	'192.168.1.201',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-29 07:36:14',	'2024-04-29 07:36:14'),
('0000089',	'192.168.1.201',	'00000001',	'Reene Brigette Beriso',	'CREATE',	'USER',	'2024-04-29 07:44:18',	'2024-04-29 07:44:18'),
('0000090',	'192.168.1.201',	'00000001',	'Reene Brigette Beriso',	'LOGGED OUT',	'AUTH',	'2024-04-29 07:44:21',	'2024-04-29 07:44:21'),
('0000091',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 07:44:25',	'2024-04-29 07:44:25'),
('0000092',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 07:44:43',	'2024-04-29 07:44:43'),
('0000093',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 07:49:19',	'2024-04-29 07:49:19'),
('0000094',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 07:49:24',	'2024-04-29 07:49:24'),
('0000095',	'192.168.1.140',	'00012869',	'TEST TEST',	'CREATE',	'PRODUCT LIST',	'2024-04-29 07:49:27',	'2024-04-29 07:49:27'),
('0000096',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 07:51:00',	'2024-04-29 07:51:00'),
('0000097',	'192.168.1.140',	'00012869',	'TEST TEST',	'CREATE',	'PRODUCT LIST',	'2024-04-29 07:51:06',	'2024-04-29 07:51:06'),
('0000098',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 07:51:38',	'2024-04-29 07:51:38'),
('0000099',	'192.168.1.140',	'00012869',	'TEST TEST',	'CREATE',	'PRODUCT LIST',	'2024-04-29 07:51:43',	'2024-04-29 07:51:43'),
('0000100',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 08:03:13',	'2024-04-29 08:03:13'),
('0000101',	'192.168.1.140',	'00012869',	'TEST TEST',	'CREATE',	'PRODUCT LIST',	'2024-04-29 08:03:19',	'2024-04-29 08:03:19'),
('0000102',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 08:11:18',	'2024-04-29 08:11:18'),
('0000103',	'192.168.1.140',	'00012869',	'TEST TEST',	'CREATE',	'PRODUCT LIST',	'2024-04-29 08:11:24',	'2024-04-29 08:11:24'),
('0000104',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 08:11:55',	'2024-04-29 08:11:55'),
('0000105',	'192.168.1.140',	'00012869',	'TEST TEST',	'CREATE',	'PRODUCT LIST',	'2024-04-29 08:12:02',	'2024-04-29 08:12:02'),
('0000106',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED OUT',	'AUTH',	'2024-04-29 08:12:52',	'2024-04-29 08:12:52'),
('0000107',	'192.168.1.201',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-04-29 08:12:59',	'2024-04-29 08:12:59'),
('0000108',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 08:16:39',	'2024-04-29 08:16:39'),
('0000109',	'192.168.1.140',	'00012869',	'TEST TEST',	'CREATE',	'PRODUCT LIST',	'2024-04-29 08:16:45',	'2024-04-29 08:16:45'),
('0000110',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 09:02:46',	'2024-04-29 09:02:46'),
('0000111',	'192.168.1.140',	'00012869',	'TEST TEST',	'CREATE',	'PRODUCT LIST',	'2024-04-29 09:02:52',	'2024-04-29 09:02:52'),
('0000112',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 09:05:07',	'2024-04-29 09:05:07'),
('0000113',	'192.168.1.140',	'00012869',	'TEST TEST',	'CREATE',	'PRODUCT LIST',	'2024-04-29 09:05:14',	'2024-04-29 09:05:14'),
('0000114',	'192.168.1.201',	'00000001',	'Reene Brigette Beriso',	'LOGGED OUT',	'AUTH',	'2024-04-29 09:10:31',	'2024-04-29 09:10:31'),
('0000115',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 09:10:34',	'2024-04-29 09:10:34'),
('0000116',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 09:57:07',	'2024-04-29 09:57:07'),
('0000117',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 09:59:20',	'2024-04-29 09:59:20'),
('0000118',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 10:02:00',	'2024-04-29 10:02:00'),
('0000119',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 10:03:02',	'2024-04-29 10:03:02'),
('0000120',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 10:03:36',	'2024-04-29 10:03:36'),
('0000121',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 10:04:06',	'2024-04-29 10:04:06'),
('0000122',	'192.168.1.140',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-29 10:06:42',	'2024-04-29 10:06:42'),
('0000123',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-30 03:14:24',	'2024-04-30 03:14:24'),
('0000124',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-30 05:35:58',	'2024-04-30 05:35:58'),
('0000125',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED OUT',	'AUTH',	'2024-04-30 05:53:04',	'2024-04-30 05:53:04'),
('0000126',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-30 05:53:21',	'2024-04-30 05:53:21'),
('0000127',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED OUT',	'AUTH',	'2024-04-30 05:54:47',	'2024-04-30 05:54:47'),
('0000128',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-30 05:55:04',	'2024-04-30 05:55:04'),
('0000129',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED OUT',	'AUTH',	'2024-04-30 05:57:08',	'2024-04-30 05:57:08'),
('0000130',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-30 06:12:02',	'2024-04-30 06:12:02'),
('0000131',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-30 06:18:27',	'2024-04-30 06:18:27'),
('0000132',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED OUT',	'AUTH',	'2024-04-30 06:18:57',	'2024-04-30 06:18:57'),
('0000133',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-30 06:24:34',	'2024-04-30 06:24:34'),
('0000134',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED OUT',	'AUTH',	'2024-04-30 06:31:10',	'2024-04-30 06:31:10'),
('0000135',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-30 06:31:30',	'2024-04-30 06:31:30'),
('0000136',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED OUT',	'AUTH',	'2024-04-30 06:55:23',	'2024-04-30 06:55:23'),
('0000137',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-30 06:55:46',	'2024-04-30 06:55:46'),
('0000138',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED OUT',	'AUTH',	'2024-04-30 06:56:15',	'2024-04-30 06:56:15'),
('0000139',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-30 07:07:29',	'2024-04-30 07:07:29'),
('0000140',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-30 08:00:36',	'2024-04-30 08:00:36'),
('0000141',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-30 08:00:48',	'2024-04-30 08:00:48'),
('0000142',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED OUT',	'AUTH',	'2024-04-30 08:52:37',	'2024-04-30 08:52:37'),
('0000143',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-04-30 08:52:40',	'2024-04-30 08:52:40'),
('0000144',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-02 00:25:40',	'2024-05-02 00:25:40'),
('0000145',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-02 00:49:27',	'2024-05-02 00:49:27'),
('0000146',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-02 00:50:55',	'2024-05-02 00:50:55'),
('0000147',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-02 01:05:12',	'2024-05-02 01:05:12'),
('0000148',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-02 05:03:17',	'2024-05-02 05:03:17'),
('0000149',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-02 05:56:10',	'2024-05-02 05:56:10'),
('0000150',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED OUT',	'AUTH',	'2024-05-02 09:26:56',	'2024-05-02 09:26:56'),
('0000151',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-02 09:27:01',	'2024-05-02 09:27:01'),
('0000152',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-03 00:27:44',	'2024-05-03 00:27:44'),
('0000153',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-03 09:55:48',	'2024-05-03 09:55:48'),
('0000154',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-06 02:33:15',	'2024-05-06 02:33:15'),
('0000155',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-06 06:11:02',	'2024-05-06 06:11:02'),
('0000156',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-08 00:40:59',	'2024-05-08 00:40:59'),
('0000157',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-08 00:44:43',	'2024-05-08 00:44:43'),
('0000158',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-08 03:36:26',	'2024-05-08 03:36:26'),
('0000159',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-09 00:14:38',	'2024-05-09 00:14:38'),
('0000160',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-10 07:15:34',	'2024-05-10 07:15:34'),
('0000161',	'192.168.1.201',	'00012869',	'TEST TEST',	'CREATE',	'SOFTWARE LICENSE',	'2024-05-10 08:01:53',	'2024-05-10 08:01:53'),
('0000162',	'192.168.1.201',	'00012869',	'TEST TEST',	'UPDATE',	'SOFTWARE LICENSE',	'2024-05-10 09:11:38',	'2024-05-10 09:11:38'),
('0000163',	'192.168.1.201',	'00012869',	'TEST TEST',	'UPDATE',	'SOFTWARE LICENSE',	'2024-05-10 09:12:06',	'2024-05-10 09:12:06'),
('0000164',	'192.168.1.201',	'00012869',	'TEST TEST',	'UPDATE',	'SOFTWARE LICENSE',	'2024-05-10 09:12:43',	'2024-05-10 09:12:43'),
('0000165',	'192.168.1.201',	'00012869',	'TEST TEST',	'UPDATE',	'SOFTWARE LICENSE',	'2024-05-10 09:12:56',	'2024-05-10 09:12:56'),
('0000166',	'192.168.1.201',	'00012869',	'TEST TEST',	'UPDATE',	'SOFTWARE LICENSE',	'2024-05-10 09:14:04',	'2024-05-10 09:14:04'),
('0000167',	'192.168.1.201',	'00012869',	'TEST TEST',	'UPDATE',	'SOFTWARE LICENSE',	'2024-05-10 09:14:41',	'2024-05-10 09:14:41'),
('0000168',	'192.168.1.201',	'00012869',	'TEST TEST',	'UPDATE',	'SOFTWARE LICENSE',	'2024-05-10 09:15:51',	'2024-05-10 09:15:51'),
('0000169',	'192.168.1.201',	'00012869',	'TEST TEST',	'UPDATE',	'SOFTWARE LICENSE',	'2024-05-10 09:15:55',	'2024-05-10 09:15:55'),
('0000170',	'192.168.1.201',	'00012869',	'TEST TEST',	'UPDATE',	'SOFTWARE LICENSE',	'2024-05-10 09:20:28',	'2024-05-10 09:20:28'),
('0000171',	'192.168.1.201',	'00012869',	'TEST TEST',	'UPDATE',	'SOFTWARE LICENSE',	'2024-05-10 09:20:53',	'2024-05-10 09:20:53'),
('0000172',	'192.168.1.201',	'00012869',	'TEST TEST',	'UPDATE',	'SOFTWARE LICENSE',	'2024-05-10 09:21:13',	'2024-05-10 09:21:13'),
('0000173',	'192.168.1.201',	'00012869',	'TEST TEST',	'UPDATE',	'SOFTWARE LICENSE',	'2024-05-10 09:27:22',	'2024-05-10 09:27:22'),
('0000174',	'192.168.1.201',	'00012869',	'TEST TEST',	'UPDATE',	'SOFTWARE LICENSE',	'2024-05-10 09:28:25',	'2024-05-10 09:28:25'),
('0000175',	'192.168.1.201',	'00012869',	'TEST TEST',	'CREATE',	'SOFTWARE LICENSE',	'2024-05-10 09:31:51',	'2024-05-10 09:31:51'),
('0000176',	'192.168.1.201',	'00012869',	'TEST TEST',	'CREATE',	'SOFTWARE LICENSE',	'2024-05-10 09:32:11',	'2024-05-10 09:32:11'),
('0000177',	'192.168.1.201',	'00012869',	'TEST TEST',	'UPDATE',	'SOFTWARE LICENSE',	'2024-05-10 09:32:19',	'2024-05-10 09:32:19'),
('0000178',	'192.168.1.201',	'00012869',	'TEST TEST',	'CREATE',	'PRODUCT LIST',	'2024-05-10 09:34:45',	'2024-05-10 09:34:45'),
('0000179',	'192.168.1.201',	'00012869',	'TEST TEST',	'LOGGED IN',	'AUTH',	'2024-05-13 09:28:17',	'2024-05-13 09:28:17'),
('0000180',	'192.168.1.201',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-05-14 02:34:20',	'2024-05-14 02:34:20'),
('0000181',	'192.168.1.201',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-05-14 02:49:58',	'2024-05-14 02:49:58'),
('0000182',	'192.168.1.201',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-05-14 03:22:56',	'2024-05-14 03:22:56'),
('0000183',	'127.0.0.1',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-05-14 07:02:53',	'2024-05-14 07:02:53'),
('0000184',	'127.0.0.1',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-05-14 07:42:18',	'2024-05-14 07:42:18'),
('0000185',	'127.0.0.1',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-05-14 08:18:50',	'2024-05-14 08:18:50'),
('0000186',	'127.0.0.1',	'00000001',	'Reene Brigette Beriso',	'LOGGED IN',	'AUTH',	'2024-05-15 02:39:16',	'2024-05-15 02:39:16');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(100) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2019_12_14_000001_create_personal_access_tokens_table',	1),
(2,	'2023_03_22_062745_create_warehouse_receive_table',	1),
(3,	'2023_03_22_06446_create_users_table',	1),
(4,	'2023_03_22_06446_create_vendor_table',	1),
(5,	'2023_03_27_030724_create__l_o_c_a_t_i_o_n_table',	1),
(6,	'2023_03_27_030725_create__g_r_o_u_p_table',	1),
(7,	'2023_03_27_030726_create_product_list_table',	1),
(8,	'2023_03_27_030727_create__i_n_v_e_n_t_o_r_y__l_i_s_t_table',	1),
(9,	'2023_03_27_064038_create__s_u_g_b_g_r_o_u_p_table',	1),
(10,	'2023_03_28_055731_update__s_u_b_g_r_o_u_p_table',	1),
(11,	'2023_03_28_065437_update__s_u_b_g_r_o_u_p2_table',	1),
(12,	'2023_03_30_012540_create_asset_transfer_trasfer_details_table',	1),
(13,	'2023_03_30_013539_create_asset_transfer_asset_details_table',	1),
(14,	'2023_04_11_052933_create_jobs_table',	1),
(15,	'2023_04_25_073205_create__a_s_s_e_t_r_e_q_u_e_s_t_table',	1),
(16,	'2023_04_26_020301_create__a_s_s_e_t_r_e_q_u_e_s_t_d_e_t_a_i_l_s_table',	1),
(17,	'2023_04_27_062754_create_notifications_table',	1),
(18,	'2023_05_02_014709_create__i_n_s_t_a_l_l_e_d_s_o_f_w_a_r_e_table',	1),
(19,	'2023_05_02_052017_create__c_o_n_t_r_a_c_t_s_table',	1),
(20,	'2023_05_02_065529_create__v_e_n_d_o_r__s_c_o_r_e_c_a_r_d_table',	1),
(21,	'2023_05_02_074204_create__i_n_v_e_n_t_o_r_y__t_r_a_n_s_a_c_t_i_o_n_table',	1),
(22,	'2023_05_09_020752_create_disposal_table',	1),
(23,	'2023_05_09_064357_create__d_i_s_p_o_s_a_l__d_e_t_a_i_l_s_table',	1),
(24,	'2023_05_14_091851_create__i_n_v_e_n_t_o_r_y__d_e_t_a_i_l_s_table',	1),
(25,	'2023_05_17_090005_create__g_l_o_b_a_l_table',	1),
(26,	'2023_05_22_063309_create__a_s_s_e_t__r_e_q_u_e_s_t__h_e_a_d_e_r_table',	1),
(27,	'2023_05_29_085816_create_inventory_movement_table',	1),
(28,	'2023_05_31_071621_create__l_o_g_s_table',	1),
(29,	'2023_07_03_070610_create_users_role_table',	1),
(30,	'2023_07_03_070639_create_users_list_of_roles_table',	1),
(31,	'2023_07_03_071515_create_user_role_permission_table',	1),
(32,	'2023_07_03_071517_create__u_s_e_r_s__g_r_o_u_p_table',	1),
(33,	'2023_07_04_030723_create_supplier_details_table',	1),
(34,	'2023_07_05_013503_create_software_license_table',	1),
(35,	'2023_07_13_053043_create_inventory_to_receive_table',	1),
(36,	'2023_07_13_061433_update_productlist_table',	2),
(37,	'2023_07_17_030849_create_peripheral_title_table',	2),
(38,	'2023_07_17_031053_create_peripherals_table',	2),
(39,	'2023_07_17_100107_update_inventory_table',	3),
(41,	'2023_08_02_080312_put_updated_by_on_role_group_location',	4),
(42,	'2023_08_07_094156_update_asset_movement_table',	5),
(43,	'2023_08_08_062123_create_help_table',	6),
(44,	'2023_08_18_003453_add_from_id_to_help_table',	6),
(45,	'2023_09_01_004440_failed_login_table',	7);

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(100) NOT NULL,
  `notifiable_type` varchar(100) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `notifications`;
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('23fe4182-58d8-422a-9165-bdaf7c5bcb94',	'App\\Notifications\\AssetMovementNotification',	'App\\Models\\User',	12869,	'{\"message\":\"New Asset Transfer was pending to be Approve!\",\"url\":\"http:\\/\\/192.168.1.201:8005\\/StockManagement\\/AssetTransferApproval\"}',	NULL,	'2024-04-30 08:02:30',	'2024-04-30 08:02:30'),
('7275617d-661d-46d3-8f18-0fef1897ef8d',	'App\\Notifications\\AssetMovementNotification',	'App\\Models\\User',	12862,	'{\"message\":\"New Asset Transfer was pending to be Approve!\",\"url\":\"http:\\/\\/192.168.25.251:8000\\/StockManagement\\/AssetTransferApproval\"}',	'2024-04-12 04:22:26',	'2024-04-12 04:22:21',	'2024-04-12 04:22:26'),
('7a8b6c25-7528-45c0-9399-3c33213cb7ea',	'App\\Notifications\\AssetMovementNotification',	'App\\Models\\User',	12577,	'{\"message\":\"New Asset Transfer was pending to be Approve!\",\"url\":\"http:\\/\\/192.168.1.201:8005\\/StockManagement\\/AssetTransferApproval\"}',	NULL,	'2024-04-29 10:12:17',	'2024-04-29 10:12:17'),
('8e9c4d97-bad0-4742-bd7b-931b5607f9d7',	'App\\Notifications\\AssetMovementNotification',	'App\\Models\\User',	12577,	'{\"message\":\"New Asset Transfer was pending to be Approve!\",\"url\":\"http:\\/\\/192.168.1.201:8005\\/StockManagement\\/AssetTransferApproval\"}',	NULL,	'2024-04-29 10:11:37',	'2024-04-29 10:11:37'),
('b48335b1-a8a5-42ba-b106-a09c998e2dc4',	'App\\Notifications\\AssetMovementNotification',	'App\\Models\\User',	1708,	'{\"message\":\"You have an item that is pending to receive\",\"url\":\"http:\\/\\/192.168.25.251:8000\\/StockManagement\\/AssetTransferReceiving\"}',	NULL,	'2024-04-12 04:49:48',	'2024-04-12 04:49:48'),
('c6a69ad7-5cc8-4013-b604-e78a4166e177',	'App\\Notifications\\AssetMovementNotification',	'App\\Models\\User',	29,	'{\"message\":\"You have an item that is pending to receive\",\"url\":\"http:\\/\\/192.168.25.251:8000\\/StockManagement\\/AssetTransferReceiving\"}',	NULL,	'2024-04-09 07:40:09',	'2024-04-09 07:40:09'),
('e92d60d3-4c1b-412e-b6e7-be528555afc8',	'App\\Notifications\\AssetMovementNotification',	'App\\Models\\User',	12869,	'{\"message\":\"New Asset Transfer was pending to be Approve!\",\"url\":\"http:\\/\\/192.168.1.201:8005\\/StockManagement\\/AssetTransferApproval\"}',	NULL,	'2024-04-29 10:12:17',	'2024-04-29 10:12:17'),
('ece902a6-41a7-4987-b17c-ae7be7f813ad',	'App\\Notifications\\AssetMovementNotification',	'App\\Models\\User',	12869,	'{\"message\":\"New Asset Transfer was pending to be Approve!\",\"url\":\"http:\\/\\/192.168.1.201:8005\\/StockManagement\\/AssetTransferApproval\"}',	NULL,	'2024-04-29 10:11:37',	'2024-04-29 10:11:37'),
('ffcbf7e4-9dad-4b74-9d3f-7b1202c35195',	'App\\Notifications\\AssetMovementNotification',	'App\\Models\\User',	12577,	'{\"message\":\"New Asset Transfer was pending to be Approve!\",\"url\":\"http:\\/\\/192.168.1.201:8005\\/StockManagement\\/AssetTransferApproval\"}',	NULL,	'2024-04-30 08:02:30',	'2024-04-30 08:02:30');

DROP TABLE IF EXISTS `password_reset_temp`;
CREATE TABLE `password_reset_temp` (
  `email` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `expDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

TRUNCATE `password_reset_temp`;

DROP TABLE IF EXISTS `peripherals`;
CREATE TABLE `peripherals` (
  `PERIPHERALS_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ASSET_ID` varchar(100) NOT NULL,
  `SUB_ASSET_ID` varchar(100) NOT NULL,
  `SUB_ASSET_NAME` varchar(100) NOT NULL,
  `SUB_ASSET_SUBTYPE` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`SUB_ASSET_ID`),
  UNIQUE KEY `UNIQUE` (`PERIPHERALS_ID`),
  KEY `SUB_ASSET_ID_ASSET_ID` (`SUB_ASSET_ID`,`ASSET_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `peripherals`;

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(100) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `personal_access_tokens`;

DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_NAME` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

TRUNCATE `product_category`;
INSERT INTO `product_category` (`id`, `CATEGORY_NAME`) VALUES
(19,	'Processors (CPU)'),
(25,	'Memory (RAM)'),
(27,	'Storage Devices'),
(28,	'Motherboards'),
(29,	'Power Supply Units (PSU)'),
(30,	'Computer Cases / Chassis'),
(31,	'Monitors & Displays'),
(32,	'Keyboards & Input Devices'),
(33,	'Cables & Adapters'),
(34,	'Printers & Scanners');

DROP TABLE IF EXISTS `product_list`;
CREATE TABLE `product_list` (
  `INDEX_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `PRODUCT_ID` varchar(100) NOT NULL,
  `PRODUCT_CATEGORY` int(10) NOT NULL,
  `PRODUCT_NAME` varchar(100) NOT NULL,
  `EQUIPMENT_MODEL` varchar(100) DEFAULT NULL,
  `PRODUCT_DESCRIPTION` varchar(100) DEFAULT NULL,
  `COLOR` varchar(100) DEFAULT NULL,
  `WEIGHT` varchar(100) DEFAULT NULL,
  `DIMENSION` varchar(100) DEFAULT NULL,
  `LOGO` varchar(100) DEFAULT NULL,
  `MANUFACTURER` varchar(100) NOT NULL,
  `VENDOR_ID` varchar(100) NOT NULL,
  `USEFUL_LIFE` varchar(100) NOT NULL,
  `STATUS` varchar(100) NOT NULL,
  `FROM_DATE` date NOT NULL,
  `PRODUCT_CONDITION` varchar(100) NOT NULL,
  `DELETED` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`PRODUCT_ID`),
  UNIQUE KEY `INDEX_ID` (`INDEX_ID`),
  KEY `product_list_vendor_id_foreign` (`VENDOR_ID`),
  KEY `ASSET_CATEGORY` (`PRODUCT_CATEGORY`),
  KEY `ASSET_ID` (`PRODUCT_ID`),
  CONSTRAINT `product_list_ibfk_4` FOREIGN KEY (`VENDOR_ID`) REFERENCES `supplier` (`SUPPLIER_ID`) ON UPDATE NO ACTION,
  CONSTRAINT `product_list_ibfk_5` FOREIGN KEY (`PRODUCT_CATEGORY`) REFERENCES `product_category` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `product_list`;
INSERT INTO `product_list` (`INDEX_ID`, `PRODUCT_ID`, `PRODUCT_CATEGORY`, `PRODUCT_NAME`, `EQUIPMENT_MODEL`, `PRODUCT_DESCRIPTION`, `COLOR`, `WEIGHT`, `DIMENSION`, `LOGO`, `MANUFACTURER`, `VENDOR_ID`, `USEFUL_LIFE`, `STATUS`, `FROM_DATE`, `PRODUCT_CONDITION`, `DELETED`) VALUES
(130,	'PROD-000001',	19,	'Intel Core i7',	'i7-12700K',	'12th Gen Intel Processor',	'Silver',	'100g',	'37.5 x 37.5 mm',	NULL,	'Intel',	'VR-0000001',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(131,	'PROD-000002',	25,	'Corsair Vengeance RAM',	'CMW16GX4M2C3200C16',	'DDR4 Memory 16GB Kit',	'Black',	'50g',	'133.35 x 34.04 mm',	NULL,	'Corsair',	'VR-0000002',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(132,	'PROD-000003',	27,	'Samsung SSD 1TB',	'870 EVO',	'Solid State Drive',	'Black',	'45g',	'100 x 70 x 7 mm',	NULL,	'Samsung',	'VR-0000003',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(133,	'PROD-000004',	28,	'ASUS Prime Motherboard',	'Z690-A',	'Intel 12th Gen Motherboard',	'Black/White',	'1.5kg',	'305 x 244 mm',	NULL,	'ASUS',	'VR-0000004',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(134,	'PROD-000005',	29,	'Corsair PSU',	'RM750x',	'750W Fully Modular Power Supply',	'Black',	'2kg',	'160 x 150 x 86 mm',	NULL,	'Corsair',	'VR-0000005',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(135,	'PROD-000006',	30,	'NZXT H510 Case',	'H510',	'Mid Tower Case',	'White/Black',	'6.6kg',	'210 x 460 x 428 mm',	NULL,	'NZXT',	'VR-0000006',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(136,	'PROD-000007',	31,	'Dell Monitor',	'U2720Q',	'27\" 4K UHD Monitor',	'Black',	'4.5kg',	'611.3 x 185 x 410.2 mm',	NULL,	'Dell',	'VR-0000007',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(137,	'PROD-000008',	32,	'Logitech Keyboard',	'G213',	'RGB Gaming Keyboard',	'Black',	'1kg',	'452 x 218 x 33 mm',	NULL,	'Logitech',	'VR-0000008',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(138,	'PROD-000009',	33,	'HDMI Cable',	'2.0 High Speed',	'2m HDMI Cable',	'Black',	'200g',	'2m',	NULL,	'Generic',	'VR-0000009',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(139,	'PROD-000010',	34,	'HP LaserJet Printer',	'M404dn',	'Monochrome Laser Printer',	'White',	'8kg',	'381 x 357 x 216 mm',	NULL,	'HP',	'VR-0000010',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(140,	'PROD-000011',	19,	'AMD Ryzen 9',	'5900X',	'12-Core Processor',	'Silver',	'90g',	'40 x 40 mm',	NULL,	'AMD',	'VR-0000002',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(141,	'PROD-000012',	25,	'Kingston Fury RAM',	'KF432C16BBK2/16',	'DDR4 16GB Kit',	'Black',	'48g',	'133 x 32 mm',	NULL,	'Kingston',	'VR-0000003',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(142,	'PROD-000013',	27,	'WD Blue HDD 2TB',	'WD20EZAZ',	'7200 RPM Hard Disk Drive',	'Blue',	'600g',	'147 x 101.6 x 26.1 mm',	NULL,	'Western Digital',	'VR-0000004',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(143,	'PROD-000014',	28,	'MSI MAG Motherboard',	'B550 TOMAHAWK',	'AMD AM4 ATX Motherboard',	'Black/Grey',	'1.4kg',	'305 x 244 mm',	NULL,	'MSI',	'VR-0000005',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(144,	'PROD-000015',	29,	'Seasonic Focus PSU',	'GX-650',	'650W Gold Modular PSU',	'Black',	'1.8kg',	'150 x 140 x 86 mm',	NULL,	'Seasonic',	'VR-0000006',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(145,	'PROD-000016',	30,	'Cooler Master Case',	'MasterBox NR600',	'ATX Mid Tower Case',	'Black',	'6kg',	'209 x 478 x 473 mm',	NULL,	'Cooler Master',	'VR-0000007',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(146,	'PROD-000017',	31,	'LG UltraGear Monitor',	'27GN950-B',	'27\" 4K Nano IPS Gaming Monitor',	'Black/Red',	'6.5kg',	'609 x 291 x 574 mm',	NULL,	'LG',	'VR-0000008',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(147,	'PROD-000018',	32,	'Razer Gaming Mouse',	'DeathAdder V2',	'Ergonomic Wired Gaming Mouse',	'Black/Green',	'82g',	'127 x 61.7 x 42.7 mm',	NULL,	'Razer',	'VR-0000009',	'60',	'In-Stock',	'2025-08-22',	'New',	0),
(148,	'PROD-000019',	33,	'USB-C Adapter',	'UC-A1',	'USB-C to HDMI Adapter',	'Gray',	'30g',	'60 x 20 x 10 mm',	NULL,	'Anker',	'VR-0000010',	'36',	'In-Stock',	'2025-08-22',	'New',	0),
(149,	'PROD-000020',	34,	'Canon Inkjet Printer',	'PIXMA G3010',	'Wireless All-in-One Ink Tank Printer',	'Black',	'6.4kg',	'445 x 330 x 163 mm',	NULL,	'Canon',	'VR-0000001',	'60',	'In-Stock',	'2025-08-22',	'New',	0);

DROP TABLE IF EXISTS `product_transfer_header`;
CREATE TABLE `product_transfer_header` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `PRODUCT_TRANSFER_NO` varchar(100) NOT NULL,
  `TRANSACTION_DATE` date NOT NULL,
  `TRANSFERED_LOCATION_ID` varchar(100) NOT NULL,
  `LOCATION_ID` varchar(100) NOT NULL,
  `DATE_RECEIVED` date DEFAULT NULL,
  `TRANSFER_STATUS` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`PRODUCT_TRANSFER_NO`),
  UNIQUE KEY `id` (`id`),
  KEY `asset_transfer_transfer_details_location_id_foreign` (`LOCATION_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `product_transfer_header`;

DROP TABLE IF EXISTS `product_transfer_product_details`;
CREATE TABLE `product_transfer_product_details` (
  `PRODUCT_TRANSFER_NO` varchar(100) NOT NULL,
  `SERIAL_NO` varchar(100) NOT NULL,
  PRIMARY KEY (`PRODUCT_TRANSFER_NO`,`SERIAL_NO`),
  KEY `ASSET_TRANSFER_NO_SERIAL_NO` (`PRODUCT_TRANSFER_NO`,`SERIAL_NO`),
  CONSTRAINT `product_transfer_product_details_ibfk_1` FOREIGN KEY (`PRODUCT_TRANSFER_NO`) REFERENCES `product_transfer_header` (`PRODUCT_TRANSFER_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `product_transfer_product_details`;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ROLE` varchar(100) NOT NULL,
  `CREATED_BY` varchar(100) NOT NULL,
  `UPDATED_BY` varchar(100) NOT NULL,
  `DELETED` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `roles`;
INSERT INTO `roles` (`id`, `ROLE`, `CREATED_BY`, `UPDATED_BY`, `DELETED`) VALUES
(1,	'Admin Account',	'Admin Account',	'Admin Account',	0),
(2,	'User Account',	'Admin Account',	'Admin Account',	0);

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `UNIQUE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SUPPLIER_ID` varchar(10) NOT NULL,
  `SUPP_NAME` varchar(100) NOT NULL,
  `TYPE` varchar(100) NOT NULL,
  `CONTACT_NAME` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `CONTACT_NO` varchar(20) NOT NULL,
  `ADDRESS` varchar(100) NOT NULL,
  `UPDATED_BY` varchar(100) NOT NULL,
  `DELETED` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`SUPPLIER_ID`),
  UNIQUE KEY `id` (`UNIQUE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `supplier`;
INSERT INTO `supplier` (`UNIQUE_ID`, `SUPPLIER_ID`, `SUPP_NAME`, `TYPE`, `CONTACT_NAME`, `EMAIL`, `CONTACT_NO`, `ADDRESS`, `UPDATED_BY`, `DELETED`) VALUES
(1,	'VR-0000001',	'TechSource Distributors Inc.',	'Distributor',	'Maria Santos',	'maria.santos@techsource.com',	'+63 917 123 4567',	'12th Floor, Tech Tower, Makati City',	'Admin Account',	0),
(140,	'VR-0000002',	'Global IT Solutions Co.',	'Reseller',	'John Dela Cruz',	'john.delacruz@gitsolutions.ph',	'+63 918 234 5678',	'Ortigas Center, Pasig City',	'system',	0),
(141,	'VR-0000003',	'MicroHub Electronics',	'Retailer',	'Anna Lim',	'anna.lim@microhub.ph',	'+63 917 345 6789',	'SM North EDSA, Quezon City',	'system',	0),
(142,	'VR-0000004',	'NextGen Computer Supplies',	'Distributor',	'Robert Tan',	'robert.tan@nextgen.com.ph',	'+63 917 456 7890',	'Cebu Business Park, Cebu City',	'system',	0),
(143,	'VR-0000005',	'Pacific Digital Traders',	'Wholesaler',	'Sarah Mendoza',	'sarah.mendoza@pacificdt.ph',	'+63 918 567 8901',	'J.P. Laurel Ave, Davao City',	'system',	0),
(144,	'VR-0000006',	'Silverline Hardware & Peripherals',	'Retailer',	'James Ong',	'james.ong@silverline.com',	'+63 917 678 9012',	'Ayala Malls, Makati City',	'system',	0),
(145,	'VR-0000007',	'PrimeTech Components',	'Manufacturer',	'Karen Reyes',	'karen.reyes@primetech.com.ph',	'+63 918 789 0123',	'Carmelray Industrial Park, Laguna',	'system',	0),
(146,	'VR-0000008',	'Evergreen Systems Supply',	'Distributor',	'Michael Cruz',	'michael.cruz@evergreensupply.ph',	'+63 917 890 1234',	'Clark Freeport Zone, Pampanga',	'system',	0),
(147,	'VR-0000009',	'Infinity Gadgets & Parts',	'Reseller',	'Patricia Gomez',	'patricia.gomez@infinitygadgets.ph',	'+63 918 901 2345',	'Robinsons Place, Manila',	'system',	0),
(148,	'VR-0000010',	'Vertex Technology Distributors',	'Distributor',	'Daniel Navarro',	'daniel.navarro@vertextech.ph',	'+63 917 012 3456',	'IT Park, Lahug, Cebu City',	'system',	0);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `USER_ID` varchar(100) NOT NULL,
  `FIRST_NAME` varchar(100) NOT NULL,
  `LAST_NAME` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `PROFILE_PICTURE` varchar(100) DEFAULT NULL,
  `ACC_STATUS` varchar(100) NOT NULL,
  `LOCATION_ID` varchar(100) DEFAULT NULL,
  `ROLE_ID` varchar(100) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `DELETED` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`USER_ID`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `id` (`id`),
  KEY `LOCATION_ID` (`LOCATION_ID`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`LOCATION_ID`) REFERENCES `location` (`LOCATION_ID`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `users`;
INSERT INTO `users` (`id`, `USER_ID`, `FIRST_NAME`, `LAST_NAME`, `email`, `password`, `PROFILE_PICTURE`, `ACC_STATUS`, `LOCATION_ID`, `ROLE_ID`, `remember_token`, `DELETED`) VALUES
(1,	'0000000',	'Admin',	'Account',	'admin@gmail.com',	'$2y$10$dWETG0bU4AA98kS7rxPSd.HFcNjZVBEtW0Yy3PeTtyCL34/X2GTgu',	NULL,	'Active',	'000000',	'1',	NULL,	0),
(2,	'0000001',	'Default User',	'Account 1',	'defaultuser1@gmail.com',	'$2y$10$oAhnUgEP2GaOeqX5tqmZF.o1XywQKMOc1N47Yai5slhdaX14fPQzu',	NULL,	'Active',	'000001',	'2',	NULL,	0),
(3,	'0000002',	'Default User',	'Account 2',	'defaultuser2@gmail.com',	'$2y$10$oAhnUgEP2GaOeqX5tqmZF.o1XywQKMOc1N47Yai5slhdaX14fPQzu',	NULL,	'Active',	'000002',	'2',	NULL,	0);

DROP TABLE IF EXISTS `user_role_permission`;
CREATE TABLE `user_role_permission` (
  `ROLE_ID` bigint(20) unsigned NOT NULL,
  `PRODUCT_CATALOG` tinyint(1) NOT NULL DEFAULT 0,
  `ADD_PRODUCT` tinyint(1) NOT NULL DEFAULT 0,
  `EDIT_PRODUCT` tinyint(1) NOT NULL DEFAULT 0,
  `DELETE_PRODUCT` tinyint(1) NOT NULL DEFAULT 0,
  `ADD_PRODUCT_CATEGORY` tinyint(1) NOT NULL DEFAULT 0,
  `EDIT_PRODUCT_CATEGORY` tinyint(1) NOT NULL DEFAULT 0,
  `DELETE_PRODUCT_CATEGORY` tinyint(1) NOT NULL DEFAULT 0,
  `INVENTORY` tinyint(1) NOT NULL DEFAULT 0,
  `CREATE_PRODUCT_TRANSFER` tinyint(1) NOT NULL DEFAULT 0,
  `RECEIVE_PRODUCT_TRANSFER` tinyint(1) NOT NULL DEFAULT 0,
  `SUPPLIER` tinyint(1) NOT NULL DEFAULT 0,
  `ADD_SUPPLIER` tinyint(1) NOT NULL DEFAULT 0,
  `EDIT_SUPPLIER` tinyint(1) NOT NULL DEFAULT 0,
  `DELETE_SUPPLIER` tinyint(1) NOT NULL DEFAULT 0,
  `ADMIN` tinyint(1) NOT NULL DEFAULT 0,
  `ADD_USER` tinyint(1) NOT NULL DEFAULT 0,
  `DELETE_USER` tinyint(1) NOT NULL DEFAULT 0,
  `ADD_LOCATION` tinyint(1) NOT NULL DEFAULT 0,
  `EDIT_LOCATION` tinyint(1) NOT NULL DEFAULT 0,
  `DELETE_LOCATION` tinyint(1) NOT NULL DEFAULT 0,
  `ADD_ROLE` tinyint(1) NOT NULL DEFAULT 0,
  `EDIT_ROLE` tinyint(1) NOT NULL DEFAULT 0,
  `DELETE_ROLE` tinyint(1) NOT NULL DEFAULT 0,
  `MANAGE_ROLE_ACCESS` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ROLE_ID`),
  KEY `user_role_permission_role_id_foreign` (`ROLE_ID`),
  CONSTRAINT `user_role_permission_ibfk_1` FOREIGN KEY (`ROLE_ID`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `user_role_permission`;
INSERT INTO `user_role_permission` (`ROLE_ID`, `PRODUCT_CATALOG`, `ADD_PRODUCT`, `EDIT_PRODUCT`, `DELETE_PRODUCT`, `ADD_PRODUCT_CATEGORY`, `EDIT_PRODUCT_CATEGORY`, `DELETE_PRODUCT_CATEGORY`, `INVENTORY`, `CREATE_PRODUCT_TRANSFER`, `RECEIVE_PRODUCT_TRANSFER`, `SUPPLIER`, `ADD_SUPPLIER`, `EDIT_SUPPLIER`, `DELETE_SUPPLIER`, `ADMIN`, `ADD_USER`, `DELETE_USER`, `ADD_LOCATION`, `EDIT_LOCATION`, `DELETE_LOCATION`, `ADD_ROLE`, `EDIT_ROLE`, `DELETE_ROLE`, `MANAGE_ROLE_ACCESS`) VALUES
(1,	1,	1,	1,	1,	1,	1,	1,	0,	0,	0,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1),
(2,	1,	0,	0,	0,	0,	0,	0,	1,	1,	1,	1,	0,	0,	0,	1,	0,	0,	0,	0,	0,	0,	0,	0,	0);

-- 2025-08-25 07:28:22
