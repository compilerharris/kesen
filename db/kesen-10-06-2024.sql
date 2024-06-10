-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 09, 2024 at 06:35 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kesen`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `srno` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `metrix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `protocol_data` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountant` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimate_company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `client_accountant_person_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `srno`, `name`, `email`, `phone_no`, `landline`, `address`, `metrix`, `type`, `protocol_data`, `accountant`, `estimate_company`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`, `deleted_at`, `client_accountant_person_id`) VALUES
('9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, 'Test', 'test@gmail.com', '12123123123', NULL, 'Mumbra Kausa', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '1', NULL, '1', '1', '1', '1', 0, '2024-04-23 17:11:11', '2024-06-09 05:20:14', NULL, '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4'),
('9bc17857-0f6a-40d4-a9d9-87407d1a88b1', 4, '122Test', 'test123@gmail.com', '12123123112', NULL, 'Mumbra Kausa Test', '9be3fa93-49f5-4772-97c8-35ba796fa421', '2', 'Advertisement ADV', '1', '1', '1', '1', 1, '2024-04-23 17:11:11', '2024-06-08 01:14:35', NULL, '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4'),
('9be29ab2-1cfb-44a0-9a9d-0c03bfb79806', 5, 'goyahi adstam', 'goyahi6237@adstam.com', '07897987982', NULL, 'Mumbra Kausa adstam', '9be5896f-f10e-4d49-b5f2-6c245b3ece18', '2', 'Advertisement ADV', NULL, NULL, NULL, NULL, 0, '2024-04-24 10:50:02', '2024-06-08 01:30:19', NULL, '9c230458-53c7-422d-ad1e-a5bf5beebca1'),
('9c3c537d-71e9-4e58-9b53-d6a8de9642a9', 6, 'goyahi adstam', 'goyahi7@adstam.com', '07897987986', NULL, 'test\r\ntest', '9bc17857-0f6a-40d4-a9d9-87407d1a88b1', '1', NULL, NULL, NULL, NULL, NULL, 1, '2024-06-08 01:15:27', '2024-06-08 01:15:27', NULL, '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4'),
('9c3c5487-381e-4789-bed0-142f5cbf8d90', 7, 'Obaid Kazi', 'obaidkazi123@gmail.com', '07897987912', NULL, 'Mumbra', '9be3fa93-49f5-4772-97c8-35ba796fa421', '1', NULL, NULL, NULL, NULL, NULL, 1, '2024-06-08 01:18:21', '2024-06-09 12:47:37', NULL, '9c230458-53c7-422d-ad1e-a5bf5beebca1'),
('9c3ea0ab-fa67-4bd5-97b5-4e6479b3c39a', 8, 'goyahi adstam', 'goyahi6237@adst.com', '078979879', NULL, 'sdad', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '1', NULL, NULL, NULL, NULL, NULL, 0, '2024-06-09 04:42:55', '2024-06-09 05:20:05', NULL, '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4');

-- --------------------------------------------------------

--
-- Table structure for table `contact_persons`
--

CREATE TABLE `contact_persons` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_persons`
--

INSERT INTO `contact_persons` (`id`, `client_id`, `name`, `phone_no`, `landline`, `email`, `designation`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('9c0415d1-ed04-4658-9544-1f85949b88e7', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 'goyahi adstam', '078979879', '07897987982', 'goyah237@adstam.com', 'asda', 1, '2024-05-11 02:16:38', '2024-05-11 02:16:38', NULL),
('9c1ed3f2-9103-4589-8771-81cc550eeb0d', '9bc17857-0f6a-40d4-a9d9-87407d1a88b1', 'Haaris', '07897987982', '07897987182', 'goyahi6237@adstam.com', 'asda', 1, '2024-05-24 09:19:48', '2024-05-24 09:19:48', NULL),
('9c3c7d40-3211-40de-bb6b-83005d696fa0', '9c3c5487-381e-4789-bed0-142f5cbf8d90', 'Khalid Kazi', '07897987123', NULL, 'kazi@adstam.com', 'Lawyer', 1, '2024-06-08 03:12:13', '2024-06-08 03:12:13', NULL),
('9c3f5092-0195-4267-be2b-7dd6ecdda1d3', '9c3c5487-381e-4789-bed0-142f5cbf8d90', 'Haaris', '789789798', NULL, 'haris@adstam.com', 'Manager', 1, '2024-06-09 12:54:46', '2024-06-09 12:54:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `error_logs`
--

CREATE TABLE `error_logs` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimates`
--

CREATE TABLE `estimates` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sr_no` int(11) NOT NULL,
  `estimate_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_contact_person_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `headline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL DEFAULT '2024-06-03'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `estimates`
--

INSERT INTO `estimates` (`id`, `sr_no`, `estimate_no`, `client_id`, `client_contact_person_id`, `headline`, `currency`, `discount`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `type`, `date`) VALUES
('9c3cf7bf-39b1-4817-ab29-173f88624aac', 16, '0001-KLB/2024-25', '9c3c5487-381e-4789-bed0-142f5cbf8d90', '9c3c7d40-3211-40de-bb6b-83005d696fa0', 'Estimate 001', 'INR', '10', '1', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '2024-06-08 08:54:44', '2024-06-09 09:32:22', 'words', '2024-06-08'),
('9c3eb083-bd94-4bb6-bc2e-1eba8b85588e', 17, '0002-KLB/2024-25', '9c3c5487-381e-4789-bed0-142f5cbf8d90', '9c3c7d40-3211-40de-bb6b-83005d696fa0', 'Nothing', 'IDR', '100', '1', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '2024-06-09 05:27:13', '2024-06-09 05:27:13', 'words', '2024-06-11'),
('9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', 18, '0003-LGS/2024-25', '9c3c5487-381e-4789-bed0-142f5cbf8d90', '9c3c7d40-3211-40de-bb6b-83005d696fa0', 'Estimate 002', 'INR', '5000', '1', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '2024-06-09 07:33:46', '2024-06-09 11:34:39', 'words', '2024-06-11');

-- --------------------------------------------------------

--
-- Table structure for table `estimate_details`
--

CREATE TABLE `estimate_details` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sr_no` int(11) NOT NULL,
  `estimate_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `verification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_2` varchar(2555) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `back_translation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `layout_charges` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `layout_charges_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `two_way_qc_t` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_way_qc_bt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `estimate_details`
--

INSERT INTO `estimate_details` (`id`, `sr_no`, `estimate_id`, `document_name`, `type`, `unit`, `rate`, `verification`, `verification_2`, `back_translation`, `layout_charges`, `layout_charges_2`, `lang`, `created_at`, `updated_at`, `two_way_qc_t`, `two_way_qc_bt`) VALUES
('9c3cf7bf-4147-40a3-8030-e49220d1065d', 21, '9c3cf7bf-39b1-4817-ab29-173f88624aac', 'Estimate_001', 'words', '400', '10.00', '10', '2', '10', '0', '10', '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-06-08 08:54:44', '2024-06-09 09:32:22', '0', '0'),
('9c3d4415-0a4d-454f-bbcb-549ce6ee365c', 22, '9c3cf7bf-39b1-4817-ab29-173f88624aac', 'Estimate_001', 'words', '2', '300.00', '0', '1', '500', '0', '1', '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-06-08 12:28:11', '2024-06-09 09:32:22', '0', '0'),
('9c3d4547-3945-4f9a-b8ec-2c3d4cc46f34', 23, '9c3cf7bf-39b1-4817-ab29-173f88624aac', 'Estimate_001', 'words', '2', '300.00', '0', '1', '500', '0', '1', '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-06-08 12:31:32', '2024-06-09 09:32:22', '0', '0'),
('9c3d467e-cf6c-4cac-8967-6f47b8eb8396', 27, '9c3cf7bf-39b1-4817-ab29-173f88624aac', 'Estimate_001', 'words', '2', '300.00', '0', '1', '500', '0', '1', '9be697f2-6a98-440d-989f-ccc1cec89186', '2024-06-08 12:34:56', '2024-06-09 09:32:22', '0', '0'),
('9c3d467e-d0b7-43b5-8ea9-a6bdbb9c3eae', 28, '9c3cf7bf-39b1-4817-ab29-173f88624aac', 'Estimate_001', 'words', '2', '300.00', '0', '1', '500', '0', '1', '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-06-08 12:34:56', '2024-06-09 09:32:22', '0', '0'),
('9c3d467e-d12f-4ec4-838f-e9306b553fed', 29, '9c3cf7bf-39b1-4817-ab29-173f88624aac', 'Estimate_001', 'words', '2', '300.00', '0', '1', '500', '0', '1', '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-06-08 12:34:56', '2024-06-09 09:32:22', '0', '0'),
('9c3eb083-c3b1-4186-96be-2d3183244870', 30, '9c3eb083-bd94-4bb6-bc2e-1eba8b85588e', 'Nothing', 'words', '13', '122.50', '2', '1', '2', '2', '10', '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-06-09 05:27:13', '2024-06-09 05:27:13', '10', '0'),
('9c3f08a6-0b50-4eb2-b06a-75d48808f96a', 34, '9c3cf7bf-39b1-4817-ab29-173f88624aac', 'Estimate_001', 'words', '100', '100.00', '1', NULL, '12', '3', '2', '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-06-09 09:33:39', '2024-06-09 09:33:39', '0', '2'),
('9c3f2dd0-5e94-466e-8706-2054694db1af', 35, '9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', 'Estimate 002', 'words', '1', '300.00', '12', '10', '200', '2', '2', '9be697f2-6a98-440d-989f-ccc1cec89186', '2024-06-09 11:17:35', '2024-06-09 11:33:33', '10', '122'),
('9c3f2e72-e863-4ac6-9937-a62a5eb678c0', 38, '9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', 'Estimate 002', 'words', '1', '100.00', '14', '3', '100', '2', '10', '9be697f2-6a98-440d-989f-ccc1cec89186', '2024-06-09 11:19:21', '2024-06-09 11:33:33', '3', '1'),
('9c3f2eca-aa44-4148-813b-77f2814c0be9', 41, '9c3eb083-bd94-4bb6-bc2e-1eba8b85588e', 'Nothing 001', 'words', '1', '10000.00', NULL, NULL, '100000', NULL, NULL, '9be697f2-6a98-440d-989f-ccc1cec89186', '2024-06-09 11:20:19', '2024-06-09 11:20:19', NULL, NULL),
('9c3f2eca-ab09-4371-a9cd-478299b53235', 42, '9c3eb083-bd94-4bb6-bc2e-1eba8b85588e', 'Nothing 001', 'words', '1', '10000.00', NULL, NULL, '100000', NULL, NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-06-09 11:20:19', '2024-06-09 11:20:19', NULL, NULL),
('9c3f2eca-ab88-4126-a354-ca4b8f392ffc', 43, '9c3eb083-bd94-4bb6-bc2e-1eba8b85588e', 'Nothing 001', 'words', '1', '10000.00', NULL, NULL, '100000', NULL, NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-06-09 11:20:19', '2024-06-09 11:20:19', NULL, NULL),
('9c3f3013-0b8f-4294-bfea-04ef14f018d3', 48, '9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', 'Estimate 003', 'words', '100', '300.00', '16', '2', '200', '3', '2', '9be697f2-6a98-440d-989f-ccc1cec89186', '2024-06-09 11:23:54', '2024-06-09 11:33:33', '12', '3'),
('9c3f3013-0be5-4b5e-b584-0ab03f6e8d79', 49, '9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', 'Estimate 003', 'words', '100', '300.00', '16', '2', '200', '3', '2', '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-06-09 11:23:54', '2024-06-09 11:33:33', '12', '3'),
('9c3f3013-0c55-4015-bccd-0595ea381514', 50, '9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', 'Estimate 003', 'words', '100', '300.00', '16', '2', '200', '3', '2', '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-06-09 11:23:54', '2024-06-09 11:33:33', '12', '3'),
('9c3f3013-0d3f-4a55-b67d-be59d8bbe087', 51, '9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', 'Estimate 003', 'words', '100', '300.00', '16', '2', '200', '3', '2', '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-06-09 11:23:54', '2024-06-09 11:33:33', '12', '3'),
('9c3f33eb-7cd8-4b05-ba94-adf92ce26795', 60, '9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', 'Estimate 002', 'words', '1', '100.00', '14', '3', '100', '2', '10', '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-06-09 11:34:39', '2024-06-09 11:34:39', '3', '1'),
('9c3f33eb-7db9-474e-847b-d56ea00016ce', 61, '9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', 'Estimate 002', 'words', '1', '100.00', '14', '3', '100', '2', '10', '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-06-09 11:34:39', '2024-06-09 11:34:39', '3', '1');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_cards`
--

CREATE TABLE `job_cards` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_card_srno` int(11) NOT NULL,
  `sync_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `t_writer_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_two_way_emp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t_emp_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_pd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_cr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_cnc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_dv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_fqc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_sentdate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bt_writer_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_emp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_two_way_emp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_pd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_cr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_cnc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_dv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_fqc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_sentdate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimate_detail_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_cards`
--

INSERT INTO `job_cards` (`id`, `job_card_srno`, `sync_no`, `t_unit`, `bt_unit`, `job_no`, `created_at`, `updated_at`, `t_writer_code`, `t_two_way_emp_code`, `t_emp_code`, `t_pd`, `t_cr`, `t_cnc`, `t_dv`, `t_fqc`, `t_sentdate`, `bt_writer_code`, `bt_emp_code`, `bt_two_way_emp_code`, `bt_pd`, `bt_cr`, `bt_cnc`, `bt_dv`, `bt_fqc`, `bt_sentdate`, `estimate_detail_id`) VALUES
('9c3ddb14-8368-4a7f-bc9c-3f7b2dcd3e8d', 1, '1717908014191', '14', '12', '1', '2024-06-08 19:30:24', '2024-06-08 23:10:14', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4', '2024-06-09', '2024-06-10', '102', '8', 'PANDU', '2024-06-12', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4', '9c230458-53c7-422d-ad1e-a5bf5beebca1', '2024-06-11', '2024-06-10', '8', '8', 'PANDU', '2024-06-17', '9c3cf7bf-4147-40a3-8030-e49220d1065d'),
('9c3deb51-96fb-4242-a364-2d9632262b49', 3, '1717908014191', '231', '321', '1', '2024-06-08 20:15:49', '2024-06-08 23:10:14', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '9c230458-53c7-422d-ad1e-a5bf5beebca1', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '2024-06-25', '2024-06-25', '8', '0', 'PANDU', '2024-06-24', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9c230458-53c7-422d-ad1e-a5bf5beebca1', '2024-06-04', '2024-06-04', '123', '12', 'NO PANDU', '2024-06-17', '9c3cf7bf-4147-40a3-8030-e49220d1065d'),
('9c3deb9e-51ed-428b-b920-ebee6a35ca9b', 4, '1717908054435', '10', '10', '1', '2024-06-08 20:16:39', '2024-06-08 23:10:54', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '2024-06-10', '2024-06-25', '12', '213', 'PANDU', '2024-06-18', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '2024-06-10', '2024-06-19', '8', '123', NULL, '2024-06-18', '9c3d4415-0a4d-454f-bbcb-549ce6ee365c'),
('9c3f49fc-4d0b-4af9-b222-96ba6dda81cf', 5, '1717956381441', '14', '12', '2', '2024-06-09 12:36:21', '2024-06-09 12:36:21', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '2024-06-10', '2024-06-10', '102', 'Pandu', 'Pandu', '2024-06-11', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4', '2024-06-11', '2024-06-19', '8', 'Pandu', 'Pandu', '2024-06-09', '9c3f2dd0-5e94-466e-8706-2054694db1af'),
('9c3f4a9f-7722-4d62-95ff-cb25c1d29826', 6, '1717956488373', '14', NULL, '2', '2024-06-09 12:38:08', '2024-06-09 12:38:08', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4', '9c230458-53c7-422d-ad1e-a5bf5beebca1', '2024-06-11', '2024-06-18', '102', '213', 'PANDU', '2024-06-13', NULL, NULL, NULL, '2024-06-09', '2024-06-09', NULL, NULL, NULL, '2024-06-09', '9c3f2e72-e863-4ac6-9937-a62a5eb678c0'),
('9c3f4b97-7195-422a-adb2-3c87737e11ab', 7, '1717956650888', '14', NULL, '2', '2024-06-09 12:40:50', '2024-06-09 12:40:50', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '2024-06-19', '2024-06-16', '102', 'Pandu', 'Pandu', '2024-06-09', NULL, NULL, NULL, '2024-06-09', '2024-06-09', NULL, NULL, NULL, '2024-06-09', '9c3f33eb-7cd8-4b05-ba94-adf92ce26795');

-- --------------------------------------------------------

--
-- Table structure for table `job_register`
--

CREATE TABLE `job_register` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sr_no` int(11) NOT NULL,
  `metrix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimate_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_contact_person_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_accountant_person_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `handled_by_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `protocol_data` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL DEFAULT '2024-05-14',
  `description` text COLLATE utf8mb4_unicode_ci,
  `protocol_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `cancel_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estimate_document_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_no` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `informed_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_job_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_specific` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_specific_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `po_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_register`
--

INSERT INTO `job_register` (`id`, `sr_no`, `metrix`, `estimate_id`, `client_id`, `client_contact_person_id`, `client_accountant_person_id`, `category`, `handled_by_id`, `created_by_id`, `other_details`, `type`, `protocol_data`, `date`, `description`, `protocol_no`, `status`, `cancel_reason`, `created_at`, `updated_at`, `estimate_document_id`, `bill_date`, `bill_no`, `informed_to`, `invoice_date`, `sent_date`, `delivery_date`, `old_job_no`, `site_specific`, `site_specific_path`, `payment_status`, `payment_date`, `po_number`) VALUES
('9c3d49fc-4d6a-4465-898f-bba1a12f855b', 1, '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9c3cf7bf-39b1-4817-ab29-173f88624aac', '9c3c5487-381e-4789-bed0-142f5cbf8d90', '9c3c7d40-3211-40de-bb6b-83005d696fa0', '9c230458-53c7-422d-ad1e-a5bf5beebca1', '1', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9c3cf7bf-39b1-4817-ab29-173f88624aac', 'site-specific', NULL, '2024-06-08', 'Estimate_001', '1231235', 1, NULL, '2024-06-08 12:44:42', '2024-06-09 11:00:27', 'Estimate_001', NULL, NULL, '9c3c7d40-3211-40de-bb6b-83005d696fa0', NULL, NULL, '2024-06-09', '12323', '1', NULL, 'Paid', '2024-06-11', '1123213'),
('9c3f3599-3d6b-4ed6-aca5-85c16a050d8e', 2, NULL, '9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', '9c3c5487-381e-4789-bed0-142f5cbf8d90', '9c3c7d40-3211-40de-bb6b-83005d696fa0', '9c230458-53c7-422d-ad1e-a5bf5beebca1', '1', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9c3cf7bf-39b1-4817-ab29-173f88624aac,9c3eb083-bd94-4bb6-bc2e-1eba8b85588e', 'site-specific', NULL, '2024-06-13', NULL, '1231235', 0, NULL, '2024-06-09 11:39:21', '2024-06-09 11:57:56', 'Estimate 002', NULL, NULL, NULL, NULL, NULL, '2024-06-20', '1234', NULL, NULL, 'Paid', '2024-06-12', '1123213'),
('9c3f3de4-6c75-499a-b866-8a5e7b16a4cb', 3, NULL, '9c3eb083-bd94-4bb6-bc2e-1eba8b85588e', '9c3c5487-381e-4789-bed0-142f5cbf8d90', '9c3c7d40-3211-40de-bb6b-83005d696fa0', '9c230458-53c7-422d-ad1e-a5bf5beebca1', '1', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9c3cf7bf-39b1-4817-ab29-173f88624aac,9c3eb083-bd94-4bb6-bc2e-1eba8b85588e,9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', NULL, NULL, '2024-06-12', 'Nothing', '1231235', 1, NULL, '2024-06-09 12:02:32', '2024-06-09 12:02:32', 'Nothing', NULL, NULL, NULL, NULL, NULL, NULL, '12323', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sr_no` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `sr_no`, `name`, `code`, `created_by`, `updated_by`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
('9be697f2-6a98-440d-989f-ccc1cec89186', 3, 'English', 'ENG', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, NULL, '2024-04-26 10:25:40', '2024-04-26 10:25:40'),
('9c14bb75-32a9-47b9-b6ed-ec29944e78f9', 4, 'Urdu', 'URD', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, NULL, '2024-05-19 08:53:02', '2024-05-19 08:53:02'),
('9c14bb75-32a9-47b9-b6ed-ec29944e78f1', 5, 'Marathi', 'MAR', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, NULL, '2024-05-19 08:53:02', '2024-05-19 08:53:02'),
('9c14bb75-32a9-47b9-b6ed-ec29944e78f2', 6, 'Gujrati', 'GUJ', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, NULL, '2024-05-19 08:53:02', '2024-05-19 08:53:02'),
('9c14bb75-32a9-47b9-b6ed-ec29944e7810', 7, 'Tamil', 'TML', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, NULL, '2024-05-19 08:53:02', '2024-05-19 08:53:02');

-- --------------------------------------------------------

--
-- Table structure for table `metrices`
--

CREATE TABLE `metrices` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metrices`
--

INSERT INTO `metrices` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
('9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 'KeSen Language Bureau(KLB)', 'KLB', '2024-06-03 04:10:02', '2024-06-03 04:10:02'),
('9bc17857-0f6a-40d4-a9d9-87407d1a88b1', 'Linguistic Systems ( LGS )', 'LGS', '2024-06-03 04:13:44', '2024-06-03 04:13:44'),
('9be3fa93-49f5-4772-97c8-35ba796fa421', 'KeSen Communications LLP ( KCP )', 'KCP', '2024-06-03 04:14:35', '2024-06-03 04:14:35'),
('9be5896f-f10e-4d49-b5f2-6c245b3ece18', 'KeSen Linguistic Services LLP ( KLS )', 'KLS', '2024-06-03 04:14:56', '2024-06-03 04:14:56');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(24, '2014_10_12_000000_create_users_table', 1),
(25, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(26, '2014_10_12_100000_create_password_resets_table', 1),
(27, '2019_08_19_000000_create_failed_jobs_table', 1),
(28, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(29, '2024_03_12_094811_create_error_log_table', 1),
(30, '2024_04_21_163421_create_permission_tables', 1),
(31, '2024_04_21_164051_create_table_on_off_system', 2),
(34, '2024_04_23_164204_create_client_table', 3),
(35, '2024_04_25_144048_create_contact_persons_table', 4),
(36, '2024_04_26_141501_create_languages_table', 5),
(37, '2024_04_28_143113_add_column_plain_password_in_user_table', 6),
(38, '2024_04_28_161237_craete_table_role_user', 7),
(39, '2024_05_01_140342_create_writers_table', 8),
(40, '2024_05_01_141651_create_writer_language_map_table', 9),
(41, '2024_05_07_142251_create_job_cards_table', 10),
(45, '2024_05_09_162657_create_estimates_table', 11),
(46, '2024_05_11_142215_add_columns_pdf_in_estimate_table', 12),
(47, '2024_05_14_124310_create_job_register_table', 13),
(48, '2024_05_15_152623_create_writer_payment_table', 14),
(49, '2024_05_25_165718_create_estimate_details_table', 15),
(50, '2024_05_26_161210_add_column_estimate_document_in_job_register', 16),
(51, '2024_06_03_035710_create_metrices_table', 17),
(52, '2024_06_03_044215_add_column_type_in_estimate', 18),
(53, '2024_06_03_044742_add_column_date_in_estimate', 19),
(56, '2024_06_03_044917_remove_column_amount_in_estimate', 20),
(58, '2024_06_03_044215_add_column_type_in_estimate_details', 21),
(59, '2024_06_08_064243_add_accountant_in_client', 22);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `on_off_system`
--

CREATE TABLE `on_off_system` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `is_maintenance` tinyint(1) NOT NULL DEFAULT '0',
  `is_force_off` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'write', 'web', '2024-04-28 10:35:19', '2024-04-28 10:35:19'),
(2, 'read', 'web', '2024-04-28 10:35:22', '2024-04-28 10:35:22'),
(3, 'delete', 'web', '2024-04-28 10:35:29', '2024-04-28 10:35:29'),
(4, 'all', 'web', '2024-04-28 10:35:33', '2024-04-28 10:35:33');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `team_id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'CEO', 'web', '2024-04-28 10:00:34', '2024-04-28 10:00:34'),
(2, NULL, 'Admin', 'web', '2024-04-28 10:00:43', '2024-04-28 10:00:43'),
(3, NULL, 'Accounts', 'web', '2024-04-28 10:00:52', '2024-04-28 10:00:52'),
(5, NULL, 'Project Manager', 'web', '2024-04-28 10:01:21', '2024-04-28 10:01:21'),
(6, NULL, 'Quality Control Executive', 'web', '2024-04-28 10:01:43', '2024-04-28 10:01:43'),
(7, NULL, 'Developer', 'web', '2024-04-28 16:07:36', '2024-04-28 16:07:36');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(4, 1),
(4, 7);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(38) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(6, '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4', 3, NULL, NULL),
(7, '9bea89ed-8044-49d8-8275-f3269a1dfd23', 2, NULL, NULL),
(9, '9c230458-53c7-422d-ad1e-a5bf5beebca1', 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `srno` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `landline` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(2) NOT NULL,
  `language_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `plain_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `srno`, `name`, `email`, `password`, `phone`, `code`, `landline`, `address`, `created_by`, `updated_by`, `status`, `language_id`, `remember_token`, `created_at`, `updated_at`, `plain_password`) VALUES
('9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, 'Dev', 'developer@kesen.com', '$2y$12$Gkl6UiIlDDdEZyrfoXWKiOQ6dKxf7m1Jt9jNcvBzCFvhclbdGOBAW', '7897979878', 'Dev', NULL, 'Mumbra', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, NULL, '5HhzJJwBGYT4PbkzYAaV8e4lU3JJqTnbQqhiRQPKYErBYG4ZZPjjTfJoPPsY', '2024-04-21 16:50:21', '2024-04-21 16:50:21', NULL),
('9bea89ed-8044-49d8-8275-f3269a1dfd23', 2, 'Kesan Admin', 'admin@kesen.com', '$2y$12$J/6mlpA8CnYaQsRTmnL.uOz5wRlE/tqEC.06hU.FvsbZkV5JJJZFa', '07897987982', 'KbKq', '07897987982', 'test\r\ntest', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, '9be697f2-6a98-440d-989f-ccc1cec89186', NULL, '2024-04-28 09:29:46', '2024-05-26 11:15:35', 'eyJpdiI6IkFiMWdlTFJ6QTJwQkM0R0d2NFcrRkE9PSIsInZhbHVlIjoiRDdIYnVRbGFjTVpaTm4xb3NYUlRGZz09IiwibWFjIjoiMDUxYzc3ZjI2OTc5NzVlNjBiMGRhMDJmZWY1OWM0N2MzYjVhOGI5NjUxZGYyNjlmYjQwODg3ZDQwNDcyN2M2OCIsInRhZyI6IiJ9'),
('9c0c9a65-6d41-4d2d-bd53-9621c793b5f4', 3, 'goyahi adstam', 'goyahi6237@adstam.com', '$2y$12$H9Y0H2IqqhtLc/XXSblUfumVhWEpzJt6mwVrj3.sgGwws8fIUh0Y2', '078979879822', 'EMP002', '078979879821', 'test\r\ntest', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, '9be697f2-6a98-440d-989f-ccc1cec89186', NULL, '2024-05-15 07:53:58', '2024-05-15 07:53:58', 'eyJpdiI6IkxoaW0yQ3QvNDM2OFJjZHU1OFpwbUE9PSIsInZhbHVlIjoiY2ZlYUxtMXdKbHluRGF2NWZ6UFNqQnB3ZFV4dHZtcmUxeXhPK0NVNnB0Yz0iLCJtYWMiOiIyZjJhYWFmZTJjYTg4Y2Y2MDkyNjljMzUxNmU0OTM0OGFkZTZkMjFkNzZhNjBlYzk1NTA4YWQyMWQ0OTQyZjk5IiwidGFnIjoiIn0='),
('9c230458-53c7-422d-ad1e-a5bf5beebca1', 4, 'Hamza', 'hamza@kesan.com', '$2y$12$MRMYmB5YJ2sVUlH60GzQMeQlR79be8aRU6BM7GqW2/SsgGwYt4S9O', '07897987983', 'HM001', NULL, 'test\r\ntest', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, '9be697f2-6a98-440d-989f-ccc1cec89186', NULL, '2024-05-26 11:18:26', '2024-06-09 01:12:31', 'eyJpdiI6Imx3QVlhM2NwU04zYUJYOERiMTlwUGc9PSIsInZhbHVlIjoid0MvcHNRb2ZHeDBJLysyZmZqKzRodz09IiwibWFjIjoiYjA3MmYyNTQxNDliMDc4NmJlYTQ0NDZlNTUzNDUyMjg5MjA4NzQyZGI0MjIzYjhjYjU1YjQwY2Q4NDYzZmJkNyIsInRhZyI6IiJ9');

-- --------------------------------------------------------

--
-- Table structure for table `writers`
--

CREATE TABLE `writers` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sr_no` int(11) NOT NULL,
  `writer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `writers`
--

INSERT INTO `writers` (`id`, `sr_no`, `writer_name`, `email`, `address`, `code`, `phone_no`, `landline`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
('9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', 1, 'Obaid', 'goyahi6237@adstam.com', 'test\r\ntest', 'OBD', '07897987982', NULL, 1, '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '2024-05-01 09:55:12', '2024-06-08 20:43:07');

-- --------------------------------------------------------

--
-- Table structure for table `writer_language_maps`
--

CREATE TABLE `writer_language_maps` (
  `id` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `writer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `per_unit_charges` int(11) NOT NULL,
  `checking_charges` int(11) NOT NULL,
  `bt_charges` int(11) NOT NULL,
  `bt_checking_charges` int(11) NOT NULL,
  `advertising_charges` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `writer_language_maps`
--

INSERT INTO `writer_language_maps` (`id`, `language_id`, `writer_id`, `per_unit_charges`, `checking_charges`, `bt_charges`, `bt_checking_charges`, `advertising_charges`, `created_at`, `updated_at`) VALUES
('3', '9be697f2-6a98-440d-989f-ccc1cec89186', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', 12, 10, 12, 12, 21, '2024-05-02 11:42:23', '2024-05-02 11:42:23'),
('9c27a8db-3b0b-4761-94c2-52756aaf925d', '9be697f2-6a98-440d-989f-ccc1cec89186', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', 12, 10, 12, 12, 21, '2024-05-28 18:41:45', '2024-05-28 18:41:45');

-- --------------------------------------------------------

--
-- Table structure for table `writer_payments`
--

CREATE TABLE `writer_payments` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sr_no` int(11) NOT NULL,
  `writer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metrix` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_gst` tinyint(1) NOT NULL DEFAULT '0',
  `apply_tds` tinyint(1) NOT NULL DEFAULT '0',
  `period_from` date NOT NULL,
  `period_to` date NOT NULL,
  `online_ref_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `performance_charge` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deductible` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `writer_payments`
--

INSERT INTO `writer_payments` (`id`, `sr_no`, `writer_id`, `payment_method`, `metrix`, `apply_gst`, `apply_tds`, `period_from`, `period_to`, `online_ref_no`, `cheque_no`, `performance_charge`, `deductible`, `created_at`, `updated_at`) VALUES
('9c0cd2fd-572e-474f-b03c-1d205ad2cb6f', 1, '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', 'Card', 'KeSen Language Bureau ( KLB )', 1, 1, '2024-05-15', '2024-05-15', 'asdasd', '1231212', '32.05', '1323', '2024-05-15 10:32:13', '2024-05-15 10:52:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`srno`),
  ADD UNIQUE KEY `clients_email_unique` (`email`),
  ADD UNIQUE KEY `clients_phone_no_unique` (`phone_no`),
  ADD UNIQUE KEY `clients_landline_unique` (`landline`);

--
-- Indexes for table `contact_persons`
--
ALTER TABLE `contact_persons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contact_persons_phone_no_unique` (`phone_no`),
  ADD UNIQUE KEY `contact_persons_landline_unique` (`landline`),
  ADD UNIQUE KEY `contact_persons_email_unique` (`email`);

--
-- Indexes for table `error_logs`
--
ALTER TABLE `error_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estimates`
--
ALTER TABLE `estimates`
  ADD PRIMARY KEY (`sr_no`),
  ADD UNIQUE KEY `estimates_estimate_no_unique` (`estimate_no`);

--
-- Indexes for table `estimate_details`
--
ALTER TABLE `estimate_details`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `job_cards`
--
ALTER TABLE `job_cards`
  ADD PRIMARY KEY (`job_card_srno`);

--
-- Indexes for table `job_register`
--
ALTER TABLE `job_register`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`team_id`,`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  ADD KEY `model_has_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `model_has_permissions_team_foreign_key_index` (`team_id`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`team_id`,`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  ADD KEY `model_has_roles_role_id_foreign` (`role_id`),
  ADD KEY `model_has_roles_team_foreign_key_index` (`team_id`);

--
-- Indexes for table `on_off_system`
--
ALTER TABLE `on_off_system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_team_id_name_guard_name_unique` (`team_id`,`name`,`guard_name`),
  ADD KEY `roles_team_foreign_key_index` (`team_id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`srno`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_code_unique` (`code`);

--
-- Indexes for table `writers`
--
ALTER TABLE `writers`
  ADD PRIMARY KEY (`sr_no`),
  ADD UNIQUE KEY `writers_id_unique` (`id`),
  ADD UNIQUE KEY `writers_email_unique` (`email`);

--
-- Indexes for table `writer_language_maps`
--
ALTER TABLE `writer_language_maps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `writer_payments`
--
ALTER TABLE `writer_payments`
  ADD PRIMARY KEY (`sr_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `estimates`
--
ALTER TABLE `estimates`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `estimate_details`
--
ALTER TABLE `estimate_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_cards`
--
ALTER TABLE `job_cards`
  MODIFY `job_card_srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `job_register`
--
ALTER TABLE `job_register`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `on_off_system`
--
ALTER TABLE `on_off_system`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `writers`
--
ALTER TABLE `writers`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `writer_payments`
--
ALTER TABLE `writer_payments`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
