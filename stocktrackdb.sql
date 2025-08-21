-- Adminer 4.7.9 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `stocktrackdb`;
CREATE DATABASE `stocktrackdb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `stocktrackdb`;

DROP TABLE IF EXISTS `asset_category`;
CREATE TABLE `asset_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_NAME` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

TRUNCATE `asset_category`;
INSERT INTO `asset_category` (`id`, `CATEGORY_NAME`) VALUES
(19,	'Computer Parts'),
(22,	'Test Asset 1'),
(23,	'Computer Parts'),
(24,	'Personal Computer'),
(25,	'Central Processing Unit');

DROP TABLE IF EXISTS `asset_transfer_asset_details`;
CREATE TABLE `asset_transfer_asset_details` (
  `ASSET_TRANSFER_NO` varchar(100) NOT NULL,
  `SERIAL_NO` varchar(100) NOT NULL,
  PRIMARY KEY (`ASSET_TRANSFER_NO`,`SERIAL_NO`),
  KEY `ASSET_TRANSFER_NO_SERIAL_NO` (`ASSET_TRANSFER_NO`,`SERIAL_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `asset_transfer_asset_details`;
INSERT INTO `asset_transfer_asset_details` (`ASSET_TRANSFER_NO`, `SERIAL_NO`) VALUES
('ATFN-00000001',	'00000000');

DROP TABLE IF EXISTS `asset_transfer_header`;
CREATE TABLE `asset_transfer_header` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `ASSET_TRANSFER_NO` varchar(100) NOT NULL,
  `TRANSACTION_DATE` date NOT NULL,
  `TRANSFERED_LOCATION_ID` varchar(100) NOT NULL,
  `LOCATION_ID` varchar(100) NOT NULL,
  `DATE_RECEIVED` date DEFAULT NULL,
  `TRANSFER_STATUS` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ASSET_TRANSFER_NO`),
  UNIQUE KEY `id` (`id`),
  KEY `asset_transfer_transfer_details_location_id_foreign` (`LOCATION_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `asset_transfer_header`;
INSERT INTO `asset_transfer_header` (`id`, `ASSET_TRANSFER_NO`, `TRANSACTION_DATE`, `TRANSFERED_LOCATION_ID`, `LOCATION_ID`, `DATE_RECEIVED`, `TRANSFER_STATUS`) VALUES
(28,	'ATFN-00000001',	'2024-12-21',	'1002',	'10',	'2024-12-21',	'RECEIVED');

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
  `INVENTORY_ID` varchar(100) NOT NULL,
  `ASSET_ID` varchar(100) DEFAULT NULL,
  `ASSET_TAG` varchar(100) NOT NULL,
  `SERIAL_NO` varchar(100) NOT NULL,
  `LOCATION_ID` varchar(100) NOT NULL,
  `USE_POLICY` varchar(100) NOT NULL,
  `SERVICE_LEVEL` varchar(100) NOT NULL,
  `BARCODE` varchar(100) NOT NULL,
  `PURCHASE_ORDER_NO` varchar(100) NOT NULL,
  `PURCHASE_DATE` date NOT NULL,
  `IN_SERVICE_DATE` date NOT NULL,
  `WARRANTY_START_DATE` date NOT NULL,
  `WARRANTY_EXPIRY` date NOT NULL,
  `FOR_DISPOSAL` int(1) NOT NULL DEFAULT 0,
  `IS_DISPOSED` int(11) DEFAULT 0,
  `FOR_TRANSFER` varchar(100) DEFAULT '0',
  `STATUS` varchar(100) DEFAULT 'GOOD',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`INVENTORY_ID`),
  UNIQUE KEY `id` (`id`),
  KEY `ASSET_ID_VENDOR_ID_INVENTORY_ID` (`ASSET_ID`,`INVENTORY_ID`),
  KEY `LOCATION_ID` (`LOCATION_ID`),
  CONSTRAINT `inventory_ibfk_3` FOREIGN KEY (`LOCATION_ID`) REFERENCES `location` (`LOCATION_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `inventory_ibfk_9` FOREIGN KEY (`ASSET_ID`) REFERENCES `product_list` (`ASSET_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `inventory`;

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

DROP TABLE IF EXISTS `product_list`;
CREATE TABLE `product_list` (
  `INDEX_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ASSET_ID` varchar(100) NOT NULL,
  `ASSET_CATEGORY` int(10) NOT NULL,
  `ASSET_NAME` varchar(100) NOT NULL,
  `ASSET_SUB_TYPE` varchar(100) NOT NULL,
  `EQUIPMENT_MODEL` varchar(100) DEFAULT NULL,
  `ASSET_DESCRIPTION` varchar(100) DEFAULT NULL,
  `COLOR` varchar(100) DEFAULT NULL,
  `WEIGHT` varchar(100) DEFAULT NULL,
  `DIMENSION` varchar(100) DEFAULT NULL,
  `LOGO` varchar(100) DEFAULT NULL,
  `PRODUCT_CATEGORY` varchar(100) NOT NULL,
  `MANUFACTURER` varchar(100) NOT NULL,
  `VENDOR_ID` varchar(100) NOT NULL,
  `COST` varchar(100) DEFAULT NULL,
  `WARRANTY_TERMS` varchar(100) NOT NULL,
  `USEFUL_LIFE` varchar(100) NOT NULL,
  `STATUS` varchar(100) NOT NULL,
  `FROM_DATE` date NOT NULL,
  `ASSET_CONDITION` varchar(100) NOT NULL,
  `DELETED` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ASSET_ID`),
  UNIQUE KEY `INDEX_ID` (`INDEX_ID`),
  KEY `product_list_vendor_id_foreign` (`VENDOR_ID`),
  KEY `ASSET_CATEGORY` (`ASSET_CATEGORY`),
  KEY `ASSET_ID` (`ASSET_ID`),
  CONSTRAINT `product_list_ibfk_4` FOREIGN KEY (`VENDOR_ID`) REFERENCES `supplier` (`SUPPLIER_ID`) ON UPDATE NO ACTION,
  CONSTRAINT `product_list_ibfk_5` FOREIGN KEY (`ASSET_CATEGORY`) REFERENCES `asset_category` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `product_list`;
INSERT INTO `product_list` (`INDEX_ID`, `ASSET_ID`, `ASSET_CATEGORY`, `ASSET_NAME`, `ASSET_SUB_TYPE`, `EQUIPMENT_MODEL`, `ASSET_DESCRIPTION`, `COLOR`, `WEIGHT`, `DIMENSION`, `LOGO`, `PRODUCT_CATEGORY`, `MANUFACTURER`, `VENDOR_ID`, `COST`, `WARRANTY_TERMS`, `USEFUL_LIFE`, `STATUS`, `FROM_DATE`, `ASSET_CONDITION`, `DELETED`) VALUES
(112,	'AST-00112',	19,	'A320M Pro4',	'Computer Desktop PC',	'A320M Pro4',	NULL,	NULL,	NULL,	NULL,	'',	'Hardware',	'ASRock',	'VR-0000134',	NULL,	'12 Months',	'12',	'In-Stock',	'2024-12-21',	'New',	1),
(113,	'AST-00113',	19,	'123',	'Laptop',	'123',	'N/A3',	'N/A',	'N/A',	'N/A',	NULL,	'Hardware',	'123',	'VR-0000134',	'N/A',	'132',	'123',	'In-Stock',	'2025-07-26',	'123',	1),
(114,	'AST-00114',	19,	'Test',	'Computer Desktop PC',	'1',	NULL,	NULL,	NULL,	NULL,	'',	'Software',	'1',	'VR-0000134',	NULL,	'1',	'1',	'Out of Stock',	'2025-07-26',	'11',	0),
(115,	'AST-00115',	19,	'asd',	'Laptop',	'dsa',	NULL,	'asd',	'asd',	NULL,	'',	'Hardware',	'asd',	'VR-0000134',	'asd',	'asd',	'1',	'In-Stock',	'2025-08-03',	'asd',	0),
(116,	'AST-00116',	19,	'12',	'Laptop',	'3',	NULL,	'3',	NULL,	NULL,	'',	'Hardware',	'3',	'VR-0000134',	'3',	'3',	'2',	'Out of Stock',	'2025-08-03',	'3',	0),
(117,	'AST-00117',	19,	'122',	'Computer Desktop PC',	'12',	NULL,	NULL,	NULL,	NULL,	'',	'Hardware',	'2',	'VR-0000134',	NULL,	'12',	'2',	'In-Stock',	'2025-08-03',	'12',	0),
(118,	'AST-00118',	19,	'32',	'Computer Desktop PC',	'2',	NULL,	NULL,	NULL,	NULL,	'',	'Hardware',	'23',	'VR-0000134',	NULL,	'23',	'3',	'In-Stock',	'2025-08-03',	'23',	0);

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
(132,	'VR-0000001',	'SUPPLIER 1',	'INTERNAL',	'SUPP',	'supplier@1.testing',	'1',	'supplieraddress1',	'Reene Brigette Beriso',	1),
(133,	'VR-0000133',	'o',	'lhj',	'kjk',	'wilfredo@gmail.com',	'kjjk',	'kj',	'Wilfredo Domanico',	1),
(134,	'VR-0000134',	'AMD',	'VENDOR',	'AMD HEAD',	'amd@test.com',	'09552347698',	'This is a random address',	'Admin Account',	0),
(135,	'VR-0000135',	'12',	'INTERNAL',	'12',	'12@sadas',	'12',	'1233',	'Admin Account',	0),
(136,	'VR-0000136',	'123',	'PROVIDER-MAINTENANCE',	'123',	'123@asdas',	'23',	'23',	'Admin Account',	0),
(137,	'VR-0000137',	'1',	'VENDOR',	'13',	'1313@asdsa',	'13',	'13',	'Admin Account',	0),
(138,	'VR-0000138',	'2323',	'SERVICE PROVIDER-WAREHOUSE',	'2323',	'asddads@asdas',	'2323',	'2323',	'Admin Account',	0);

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
(1,	'0000000',	'Admin',	'Account',	'admin@gmail.com',	'$2y$10$dWETG0bU4AA98kS7rxPSd.HFcNjZVBEtW0Yy3PeTtyCL34/X2GTgu',	NULL,	'ACTIVE',	'000000',	'1',	NULL,	0),
(2,	'0000001',	'Default User',	'Account 1',	'defaultuser1@gmail.com',	'$2y$10$oAhnUgEP2GaOeqX5tqmZF.o1XywQKMOc1N47Yai5slhdaX14fPQzu',	NULL,	'ACTIVE',	'000001',	'2',	NULL,	0),
(3,	'0000002',	'Default User',	'Account 2',	'defaultuser2@gmail.com',	'$2y$10$oAhnUgEP2GaOeqX5tqmZF.o1XywQKMOc1N47Yai5slhdaX14fPQzu',	NULL,	'ACTIVE',	'000002',	'2',	NULL,	0);

DROP TABLE IF EXISTS `user_role_permission`;
CREATE TABLE `user_role_permission` (
  `ROLE_ID` bigint(20) unsigned NOT NULL,
  `PRODUCT_CATALOG` tinyint(1) NOT NULL DEFAULT 0,
  `ADD_PRODUCT` tinyint(1) NOT NULL DEFAULT 0,
  `EDIT_PRODUCT` tinyint(1) NOT NULL DEFAULT 0,
  `DELETE_PRODUCT` tinyint(1) NOT NULL DEFAULT 0,
  `ADD_ASSET_CATEGORY` tinyint(1) NOT NULL DEFAULT 0,
  `EDIT_ASSET_CATEGORY` tinyint(1) NOT NULL DEFAULT 0,
  `DELETE_ASSET_CATEGORY` tinyint(1) NOT NULL DEFAULT 0,
  `INVENTORY` tinyint(1) NOT NULL DEFAULT 0,
  `CREATE_ASSET_TRANSFER` tinyint(1) NOT NULL DEFAULT 0,
  `RECEIVE_ASSET_TRANSFER` tinyint(1) NOT NULL DEFAULT 0,
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
  `BULKLOAD_USER` tinyint(1) NOT NULL DEFAULT 0,
  `BULKLOAD_INVENTORY` tinyint(1) NOT NULL DEFAULT 0,
  `BULKLOAD_PRODUCT` tinyint(1) NOT NULL DEFAULT 0,
  `BULKLOAD_SUPPLIER` tinyint(1) NOT NULL DEFAULT 0,
  `BULKLOAD_LOCATION` tinyint(1) NOT NULL DEFAULT 0,
  `MANAGE_ROLE_ACCESS` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ROLE_ID`),
  KEY `user_role_permission_role_id_foreign` (`ROLE_ID`),
  CONSTRAINT `user_role_permission_ibfk_1` FOREIGN KEY (`ROLE_ID`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `user_role_permission`;
INSERT INTO `user_role_permission` (`ROLE_ID`, `PRODUCT_CATALOG`, `ADD_PRODUCT`, `EDIT_PRODUCT`, `DELETE_PRODUCT`, `ADD_ASSET_CATEGORY`, `EDIT_ASSET_CATEGORY`, `DELETE_ASSET_CATEGORY`, `INVENTORY`, `CREATE_ASSET_TRANSFER`, `RECEIVE_ASSET_TRANSFER`, `SUPPLIER`, `ADD_SUPPLIER`, `EDIT_SUPPLIER`, `DELETE_SUPPLIER`, `ADMIN`, `ADD_USER`, `DELETE_USER`, `ADD_LOCATION`, `EDIT_LOCATION`, `DELETE_LOCATION`, `ADD_ROLE`, `EDIT_ROLE`, `DELETE_ROLE`, `BULKLOAD_USER`, `BULKLOAD_INVENTORY`, `BULKLOAD_PRODUCT`, `BULKLOAD_SUPPLIER`, `BULKLOAD_LOCATION`, `MANAGE_ROLE_ACCESS`) VALUES
(1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1,	1),
(2,	1,	0,	0,	0,	0,	0,	0,	1,	1,	1,	1,	0,	0,	0,	1,	0,	0,	0,	0,	0,	0,	0,	0,	0,	1,	0,	0,	0,	0);

-- 2025-08-03 07:45:09
