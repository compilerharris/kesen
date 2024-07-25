-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 25, 2024 at 07:56 AM
-- Server version: 5.7.25
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
('9c3ea0ab-fa67-4bd5-97b5-4e6479b3c39a', 8, 'goyahi adstam', 'goyahi6237@adst.com', '078979879', NULL, 'sdad', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '1', NULL, NULL, NULL, NULL, NULL, 0, '2024-06-09 04:42:55', '2024-06-09 05:20:05', NULL, '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4'),
('9c6b53db-459e-4fc8-80c0-0e6ec3b7fad3', 9, 'Dr Reddys Laboratories', 'reddys@test.com', '8765678765', NULL, 'Mumbai', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '1', NULL, NULL, NULL, NULL, NULL, 1, '2024-07-01 10:00:23', '2024-07-01 10:00:23', NULL, '9c230458-53c7-422d-ad1e-a5bf5beebca1'),
('9c74e9a5-e681-4293-9295-ba6b0388648a', 10, 'Lupin Limited.', 'lupin@gmail.com', '7687654567', NULL, 'Andheri East, Mumbai', '9be5896f-f10e-4d49-b5f2-6c245b3ece18', '1', NULL, NULL, NULL, NULL, NULL, 1, '2024-07-06 09:51:41', '2024-07-16 11:41:00', NULL, '9c74e60c-bdf9-4000-8ddf-24bc75c0f09d'),
('9c74ed7e-4e97-4910-abff-61a76c568ea5', 11, 'KlinEra Global Services', 'klinera@gmail.com', '8768768766', NULL, 'Chembur Mumbai', '9be3fa93-49f5-4772-97c8-35ba796fa421', '1', NULL, NULL, NULL, NULL, NULL, 1, '2024-07-06 10:02:26', '2024-07-06 10:02:26', NULL, '9c74ebeb-0482-4f69-ae18-15d7b98e5ab9'),
('9c74f155-5296-4a30-b922-bf4462c9927a', 12, 'Find Creative Avenues LLP', 'find@test.com', '98987678767', NULL, 'mumbai', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '2', 'Advertisement ADV', NULL, NULL, NULL, NULL, 1, '2024-07-06 10:13:10', '2024-07-06 10:13:10', NULL, '9c74e60c-bdf9-4000-8ddf-24bc75c0f09d'),
('9c9112d5-5d96-456d-b60e-edd15b0c24e5', 13, 'Vedic Lifesciences', 'test@vedic.com', '8985458985', NULL, 'Mumbai', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '1', NULL, NULL, NULL, NULL, NULL, 1, '2024-07-20 09:50:01', '2024-07-20 09:50:01', NULL, '9c74ebeb-0482-4f69-ae18-15d7b98e5ab9');

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
('9c1ed3f2-9103-4589-8771-81cc550eeb0d', '9bc17857-0f6a-40d4-a9d9-87407d1a88b1', 'Haaris', '07897987982', NULL, 'shaikhhgr@gmail.com', 'asda', 1, '2024-05-24 09:19:48', '2024-07-14 18:09:22', NULL),
('9c3c7d40-3211-40de-bb6b-83005d696fa0', '9c3c5487-381e-4789-bed0-142f5cbf8d90', 'Khalid Kazi', '07897987123', NULL, 'kazi@adstam.com', 'Lawyer', 1, '2024-06-08 03:12:13', '2024-06-08 03:12:13', NULL),
('9c3f5092-0195-4267-be2b-7dd6ecdda1d3', '9c3c5487-381e-4789-bed0-142f5cbf8d90', 'Haaris', '789789798', NULL, 'haris@adstam.com', 'Manager', 1, '2024-06-09 12:54:46', '2024-06-09 12:54:46', NULL),
('9c6b546a-5e8b-4047-b9fa-1e0a500e3f51', '9c6b53db-459e-4fc8-80c0-0e6ec3b7fad3', 'Prasad Bangari', '6787676564', NULL, 'prasad@test.com', 'Manager', 1, '2024-07-01 10:01:56', '2024-07-01 10:01:56', NULL),
('9c6b54ac-7875-41db-b298-58f1f611f710', '9c6b53db-459e-4fc8-80c0-0e6ec3b7fad3', 'Prasad Bangari New', '4567654567', NULL, 'bangari@test.com', 'Sr. Manager', 1, '2024-07-01 10:02:40', '2024-07-01 10:02:40', NULL),
('9c74eb51-fc1e-4ff4-b935-19661f3aff7c', '9c74e9a5-e681-4293-9295-ba6b0388648a', 'Dr. Nikita Mare', '9370694199', NULL, 'compilerharris@gmail.com', 'Project Manager', 1, '2024-07-06 09:56:21', '2024-07-19 15:51:02', NULL),
('9c74ec05-53b9-4f7b-9d53-1341a84bc134', '9c74e9a5-e681-4293-9295-ba6b0388648a', 'Vishal Patel', '9823088050', NULL, 'test@gmail.com', 'Project Manager', 1, '2024-07-06 09:58:19', '2024-07-06 09:58:19', NULL),
('9c74ee72-b754-431f-abfd-9fc00574ba8b', '9c74ed7e-4e97-4910-abff-61a76c568ea5', 'Shushma Narawade', '9870002905', NULL, 'test1@gmail.com', 'Clinical Trial Assistant 1', 1, '2024-07-06 10:05:06', '2024-07-06 10:05:06', NULL),
('9c911339-97e8-42d4-9ac9-294d4865ff34', '9c9112d5-5d96-456d-b60e-edd15b0c24e5', 'Mansi Sawant', '02240348888', NULL, 'kesen@kesen.in', 'Project Manager', 1, '2024-07-20 09:51:07', '2024-07-20 10:19:54', NULL);

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
('9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', 18, '0003-LGS/2024-25', '9c3c5487-381e-4789-bed0-142f5cbf8d90', '9c3c7d40-3211-40de-bb6b-83005d696fa0', 'Estimate 002', 'INR', '5000', '1', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '2024-06-09 07:33:46', '2024-06-28 19:34:58', 'words', '2024-06-11'),
('9c6b66b2-2dd7-4be5-98d2-ff6e6dd1a011', 19, '0004-KLB/2024-25', '9c6b53db-459e-4fc8-80c0-0e6ec3b7fad3', '9c6b546a-5e8b-4047-b9fa-1e0a500e3f51', 'Patiend Diary', 'INR', '0', '1', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '2024-07-01 10:53:03', '2024-07-03 03:53:31', 'words', '2024-03-09'),
('9c70ce42-f706-480a-8e6e-5349790181ce', 20, '0005-KLB/2024-25', '9c6b53db-459e-4fc8-80c0-0e6ec3b7fad3', '9c6b54ac-7875-41db-b298-58f1f611f710', 'Patiend Diary New', 'INR', '0', '1', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '2024-07-04 03:21:47', '2024-07-04 03:34:57', 'unit', '2024-07-04'),
('9c7149e7-cecc-42b7-b0c1-496286bffea4', 21, '0006-KLB/2024-25', '9c6b53db-459e-4fc8-80c0-0e6ec3b7fad3', '9c6b546a-5e8b-4047-b9fa-1e0a500e3f51', 'Headline Test 2', 'INR', '0', '0', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '2024-07-04 09:07:31', '2024-07-04 09:07:31', 'words', '2024-07-04'),
('9c714e48-8e63-4888-9785-3359da2a7057', 22, '0007-KCP/2024-25', '9c3c5487-381e-4789-bed0-142f5cbf8d90', '9c3c7d40-3211-40de-bb6b-83005d696fa0', 'AK-US-001-0106_Initial Submission ICFs', 'INR', '0', '0', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '2024-07-04 09:19:46', '2024-07-04 09:19:46', 'words', '2024-07-04'),
('9c74f676-68d6-4e3f-b36b-7381aa046fac', 23, '0008-KLS/2024-25', '9c74e9a5-e681-4293-9295-ba6b0388648a', '9c74eb51-fc1e-4ff4-b935-19661f3aff7c', 'Hope Clinic Kit', 'INR', '0', '1', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '2024-07-06 10:27:30', '2024-07-06 10:51:19', 'words', '2024-07-02'),
('9c74f70a-d5b9-4078-b710-f6b73942c8f2', 24, '0009-KLS/2024-25', '9c74e9a5-e681-4293-9295-ba6b0388648a', '9c74eb51-fc1e-4ff4-b935-19661f3aff7c', 'Hope Clinic Kit', 'INR', '0', '0', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '2024-07-06 10:29:08', '2024-07-06 10:29:08', 'words', '2024-07-02'),
('9c74fc31-a621-42ca-a1a8-cdf9f0223085', 25, '0010-KLS/2024-25', '9c74e9a5-e681-4293-9295-ba6b0388648a', '9c74eb51-fc1e-4ff4-b935-19661f3aff7c', 'test', 'INR', '0', '1', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '2024-07-06 10:43:32', '2024-07-06 11:32:58', 'words', '2024-07-03'),
('9c750f94-8bfd-43ec-9dc4-bdfb503bfa97', 26, '0011-KLS/2024-25', '9c74e9a5-e681-4293-9295-ba6b0388648a', '9c74eb51-fc1e-4ff4-b935-19661f3aff7c', 'test headin', 'INR', '0', '1', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', '2024-07-06 11:37:45', '2024-07-06 11:37:57', 'words', '2024-07-06'),
('9c81e82c-daf1-464e-850d-b2fb6f590ab2', 27, '0012-KLS/2024-25', '9c74e9a5-e681-4293-9295-ba6b0388648a', '9c74ec05-53b9-4f7b-9d53-1341a84bc134', 'Headline New', 'INR', '0', '2', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', '2024-07-12 20:53:19', '2024-07-13 10:28:02', 'unit', '2024-07-13'),
('9c83065c-b799-4792-b151-d97c32dceb8a', 28, '0013-KCP/2024-25', '9bc17857-0f6a-40d4-a9d9-87407d1a88b1', '9c1ed3f2-9103-4589-8771-81cc550eeb0d', '123', 'INR', '0', '2', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', '2024-07-13 10:13:33', '2024-07-13 10:28:00', 'words', '2024-07-13'),
('9c830bd6-ba6c-4d57-949e-ee327353332a', 29, '0014-KCP/2024-25', '9bc17857-0f6a-40d4-a9d9-87407d1a88b1', '9c1ed3f2-9103-4589-8771-81cc550eeb0d', '123', 'INR', '0', '2', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', '2024-07-13 10:28:52', '2024-07-13 11:09:31', 'words', '2024-07-13'),
('9c83311c-35d4-4e30-bed3-93d232292f6d', 30, '0015-KCP/2024-25', '9bc17857-0f6a-40d4-a9d9-87407d1a88b1', '9c1ed3f2-9103-4589-8771-81cc550eeb0d', '1232', 'INR', '0', '1', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', '2024-07-13 12:13:05', '2024-07-14 11:18:47', 'words', '2024-07-13'),
('9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 31, '0016-KLS/2024-25', '9c74e9a5-e681-4293-9295-ba6b0388648a', '9c74ec05-53b9-4f7b-9d53-1341a84bc134', 'Hope Clinic Kit', 'INR', '0', '2', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', '2024-07-15 08:44:02', '2024-07-15 10:19:52', 'words', '2024-07-02'),
('9c870f46-c0e0-45a1-a089-a1a7303fe15f', 32, '0017-KLS/2024-25', '9c74e9a5-e681-4293-9295-ba6b0388648a', '9c74eb51-fc1e-4ff4-b935-19661f3aff7c', 'Hope Clinic Kit', 'INR', '0', '2', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', '2024-07-15 10:21:48', '2024-07-15 11:13:34', 'words', '2024-07-03'),
('9c872234-8071-46d6-95af-cc9dcd0ce341', 33, '0018-KLS/2024-25', '9c74e9a5-e681-4293-9295-ba6b0388648a', '9c74eb51-fc1e-4ff4-b935-19661f3aff7c', 'Hope Clinic Kit', 'INR', '0', '1', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', '2024-07-15 11:14:43', '2024-07-16 10:11:49', 'words', '2024-07-02'),
('9c88ed64-e465-410d-8946-4d5406d79bbd', 34, '0019-KLS/2024-25', '9c74e9a5-e681-4293-9295-ba6b0388648a', '9c74eb51-fc1e-4ff4-b935-19661f3aff7c', 'Hope Clinic Kit', 'INR', '0', '1', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', '2024-07-16 08:38:42', '2024-07-16 08:52:25', 'words', '2024-07-02'),
('9c9115ac-48df-4b0b-96f2-8c03df090bdc', 35, '0020-KLB/2024-25', '9c9112d5-5d96-456d-b60e-edd15b0c24e5', '9c911339-97e8-42d4-9ac9-294d4865ff34', 'LRP phase', 'INR', '1000', '1', '9c910dcc-d591-4db5-b30c-e407a3f039e7', '9c910dcc-d591-4db5-b30c-e407a3f039e7', '2024-07-20 09:57:58', '2024-07-20 10:12:39', 'words', '2024-07-20');

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
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `two_way_qc_t` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_way_qc_bt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `estimate_details`
--

INSERT INTO `estimate_details` (`id`, `sr_no`, `estimate_id`, `document_name`, `type`, `unit`, `rate`, `verification`, `verification_2`, `back_translation`, `layout_charges`, `layout_charges_2`, `lang`, `created_at`, `updated_at`, `two_way_qc_t`, `two_way_qc_bt`) VALUES
('9c3cf7bf-4147-40a3-8030-e49220d1065d', 21, '9c3cf7bf-39b1-4817-ab29-173f88624aac', 'Estimate_001', 'words', '400', '10.00', '10', NULL, '10', '0', '10', '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-06-08 08:54:44', '2024-06-22 18:54:22', '0', NULL),
('9c3d4415-0a4d-454f-bbcb-549ce6ee365c', 22, '9c3cf7bf-39b1-4817-ab29-173f88624aac', 'Estimate_001', 'words', '2', '300.00', '0', NULL, '500', '0', '1', '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-06-08 12:28:11', '2024-06-22 18:54:22', '0', NULL),
('9c3d467e-d0b7-43b5-8ea9-a6bdbb9c3eae', 28, '9c3cf7bf-39b1-4817-ab29-173f88624aac', 'Estimate_001', 'words', '2', '300.00', '0', NULL, '500', '0', '1', '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-06-08 12:34:56', '2024-06-22 18:54:22', '0', NULL),
('9c3eb083-c3b1-4186-96be-2d3183244870', 30, '9c3eb083-bd94-4bb6-bc2e-1eba8b85588e', 'Nothing', 'words', '13', '122.50', '2', '1', '2', '2', '10', '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-06-09 05:27:13', '2024-06-28 19:35:21', '10', NULL),
('9c3f2eca-aa44-4148-813b-77f2814c0be9', 41, '9c3eb083-bd94-4bb6-bc2e-1eba8b85588e', 'Nothing 001', 'words', '1', '10000.00', NULL, NULL, '100000', NULL, NULL, '9be697f2-6a98-440d-989f-ccc1cec89186', '2024-06-09 11:20:19', '2024-06-09 11:20:19', NULL, NULL),
('9c3f2eca-ab09-4371-a9cd-478299b53235', 42, '9c3eb083-bd94-4bb6-bc2e-1eba8b85588e', 'Nothing 001', 'words', '1', '10000.00', NULL, NULL, '100000', NULL, NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-06-09 11:20:19', '2024-06-09 11:20:19', NULL, NULL),
('9c3f3013-0c55-4015-bccd-0595ea381514', 50, '9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', 'Estimate 003', 'words', '100', '300.00', '16', '2', '200', '3', '2', '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-06-09 11:23:54', '2024-06-22 18:54:43', '12', NULL),
('9c3f3013-0d3f-4a55-b67d-be59d8bbe087', 51, '9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', 'Estimate 003', 'words', '100', '300.00', '16', '2', '200', '3', '2', '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-06-09 11:23:54', '2024-06-22 18:54:43', '12', NULL),
('9c59f817-eb6d-4478-b575-9ed3c4c9dec2', 63, '9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', 'Estimate 002', 'words', '1', '100.00', '14', '3', '100', '2', '10', '9be697f2-6a98-440d-989f-ccc1cec89186', '2024-06-22 18:54:43', '2024-06-22 18:54:43', '3', NULL),
('9c59f817-ebf0-490e-92ca-944b3dcd78de', 64, '9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', 'Estimate 002', 'words', '1', '100.00', '14', '3', '100', '2', '10', '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-06-22 18:54:43', '2024-06-22 18:54:43', '3', NULL),
('9c59f817-ec77-410d-ae8d-bdb7c164c22d', 65, '9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', 'Estimate 002', 'words', '1', '100.00', '14', '3', '100', '2', '10', '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-06-22 18:54:43', '2024-06-22 18:54:43', '3', NULL),
('9c59f831-68dc-473c-8601-073155011b57', 66, '9c3cf7bf-39b1-4817-ab29-173f88624aac', 'Estimate_001', 'words', '2', '300.00', '0', NULL, '500', '0', '1', '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-06-22 18:55:00', '2024-06-22 18:55:00', '0', NULL),
('9c6f782f-7cff-46fb-a2af-4784b562be79', 71, '9c6b66b2-2dd7-4be5-98d2-ff6e6dd1a011', 'Main Informed Consent Form_v1.1.0', 'words', '10375', '2.25', NULL, NULL, '2.25', NULL, NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-03 11:25:16', '2024-07-03 11:25:16', NULL, NULL),
('9c70d176-a3f0-4ac6-b799-734260c78ec3', 75, '9c70ce42-f706-480a-8e6e-5349790181ce', 'Secondary Informed Consent', 'unit', '23422', '2.50', '20', '20', '2', NULL, NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-04 03:30:44', '2024-07-04 03:32:15', NULL, NULL),
('9c70d176-a74c-446e-848a-7189cc2bd2ce', 76, '9c70ce42-f706-480a-8e6e-5349790181ce', 'Secondary Informed Consent 2', 'unit', '52235', '2.00', '15', '15', '2', NULL, NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-04 03:30:44', '2024-07-04 03:32:49', NULL, NULL),
('9c70d1bf-a020-400b-964a-ccacf8fe290e', 77, '9c70ce42-f706-480a-8e6e-5349790181ce', 'Secondary Informed Consent 3', 'unit', '26893', '1.50', '19', '19', '1.5', NULL, NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-04 03:31:32', '2024-07-04 03:32:49', NULL, NULL),
('9c70d353-06e9-4a1d-830e-5eb73e827a91', 78, '9c70ce42-f706-480a-8e6e-5349790181ce', 'Secondary Informed Consent', 'unit', '23422', '2.50', '20', '20', '2', NULL, NULL, '9be697f2-6a98-440d-989f-ccc1cec89186', '2024-07-04 03:35:57', '2024-07-04 03:35:57', NULL, NULL),
('9c70d353-0884-49da-8c3a-741e27d78ca5', 79, '9c70ce42-f706-480a-8e6e-5349790181ce', 'Secondary Informed Consent', 'unit', '23422', '2.50', '20', '20', '2', NULL, NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-04 03:35:57', '2024-07-04 03:35:57', NULL, NULL),
('9c7149e7-d943-4e2c-90fe-d0e794e106ae', 80, '9c7149e7-cecc-42b7-b0c1-496286bffea4', 'document1', 'words', '12412', '1.50', NULL, NULL, '1.5', NULL, NULL, '9be697f2-6a98-440d-989f-ccc1cec89186', '2024-07-04 09:07:31', '2024-07-04 09:07:31', NULL, NULL),
('9c714b9d-c7c6-45a1-b9d5-e35d7dd12427', 82, '9c7149e7-cecc-42b7-b0c1-496286bffea4', 'document1', 'words', '12412', '2.00', NULL, NULL, '2', NULL, NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-04 09:12:18', '2024-07-04 09:12:18', NULL, NULL),
('9c714cf7-a03d-479e-b265-84d2c154215c', 83, '9c7149e7-cecc-42b7-b0c1-496286bffea4', 'document1', 'words', '12412', '1.50', NULL, NULL, '1.5', NULL, NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-04 09:16:05', '2024-07-04 09:16:05', NULL, NULL),
('9c714e48-9034-4d40-8d37-c715ed474a9e', 85, '9c714e48-8e63-4888-9785-3359da2a7057', 'document1', 'words', '123', '2.00', NULL, NULL, NULL, NULL, NULL, '9be697f2-6a98-440d-989f-ccc1cec89186', '2024-07-04 09:19:46', '2024-07-04 09:19:46', NULL, NULL),
('9c714e48-911d-42f7-9590-010348b79454', 86, '9c714e48-8e63-4888-9785-3359da2a7057', 'document1', 'words', '123', '2.00', NULL, NULL, NULL, NULL, NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-04 09:19:46', '2024-07-04 09:19:46', NULL, NULL),
('9c714e48-91c0-4351-a5fd-74419894e87d', 87, '9c714e48-8e63-4888-9785-3359da2a7057', 'document1', 'words', '123', '2.00', NULL, NULL, NULL, NULL, NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-04 09:19:46', '2024-07-04 09:19:46', NULL, NULL),
('9c74f676-704d-4ace-84d2-8bb9a3f6c581', 88, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-06 10:27:30', '2024-07-15 09:24:10', NULL, NULL),
('9c74f676-7108-43bd-815f-d8b7d5ec8095', 89, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-06 10:27:30', '2024-07-15 09:24:10', NULL, NULL),
('9c74f676-714e-4de7-be40-7b55a3cc3abf', 90, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-06 10:27:30', '2024-07-15 09:24:10', NULL, NULL),
('9c74f676-719b-47ff-9b5a-bf7cf8d9951d', 91, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-06 10:27:30', '2024-07-15 09:24:10', NULL, NULL),
('9c74f676-71e8-4cc5-a7f6-bd573ef81a38', 92, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-06 10:27:30', '2024-07-15 09:24:10', NULL, NULL),
('9c74f676-7242-4810-9385-ffe29676c120', 93, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-06 10:27:30', '2024-07-15 09:24:10', NULL, NULL),
('9c74f676-7299-4ff0-a0ee-15baa9a132d5', 94, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-06 10:27:30', '2024-07-15 09:24:10', NULL, NULL),
('9c74f676-72e6-4587-b89f-4c86cce30afd', 95, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-06 10:27:30', '2024-07-15 09:24:10', NULL, NULL),
('9c74f676-7330-4589-9f94-2299a34e2f42', 96, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-06 10:27:30', '2024-07-15 09:24:10', NULL, NULL),
('9c74f676-73ae-4bfb-906d-e1c7f0f8dac2', 97, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-06 10:27:30', '2024-07-15 09:24:10', NULL, NULL),
('9c74f676-73f1-4526-becb-6c446320996b', 98, '9c74f676-68d6-4e3f-b36b-7381aa046fac', 'Clinic Poster', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-06 10:27:30', '2024-07-06 10:27:30', NULL, NULL),
('9c74f676-743a-4253-928b-1d1480056339', 99, '9c74f676-68d6-4e3f-b36b-7381aa046fac', 'Clinic Poster', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-06 10:27:30', '2024-07-06 10:27:30', NULL, NULL),
('9c74f676-74ce-4f79-be3f-6d46a31e7ec1', 100, '9c74f676-68d6-4e3f-b36b-7381aa046fac', 'Clinic Poster', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-06 10:27:30', '2024-07-06 10:27:30', NULL, NULL),
('9c74f676-7516-4200-9207-20805677bea0', 101, '9c74f676-68d6-4e3f-b36b-7381aa046fac', 'Clinic Poster', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-06 10:27:30', '2024-07-06 10:27:30', NULL, NULL),
('9c74f676-755e-49f1-980c-d835c33e7681', 102, '9c74f676-68d6-4e3f-b36b-7381aa046fac', 'Clinic Poster', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-06 10:27:30', '2024-07-06 10:27:30', NULL, NULL),
('9c74f676-759c-4b20-a255-bdac2add79f6', 103, '9c74f676-68d6-4e3f-b36b-7381aa046fac', 'Clinic Poster', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-06 10:27:30', '2024-07-06 10:27:30', NULL, NULL),
('9c74f676-75de-4df0-92c5-57825fd32b54', 104, '9c74f676-68d6-4e3f-b36b-7381aa046fac', 'Clinic Poster', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-06 10:27:30', '2024-07-06 10:27:30', NULL, NULL),
('9c74f676-761c-4c7f-9efc-d73bd3337a5b', 105, '9c74f676-68d6-4e3f-b36b-7381aa046fac', 'Clinic Poster', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-06 10:27:30', '2024-07-06 10:27:30', NULL, NULL),
('9c74f676-7658-42d5-a2a9-afcbeebba746', 106, '9c74f676-68d6-4e3f-b36b-7381aa046fac', 'Clinic Poster', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-06 10:27:30', '2024-07-06 10:27:30', NULL, NULL),
('9c74f676-769b-4a3d-b298-df6817984d33', 107, '9c74f676-68d6-4e3f-b36b-7381aa046fac', 'Clinic Poster', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-06 10:27:30', '2024-07-06 10:27:30', NULL, NULL),
('9c74f676-76d6-4127-a591-4e361e0d6a9a', 108, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'ISSUE INSERT 1', 'words', '1320', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-06 10:27:30', '2024-07-15 09:24:33', NULL, NULL),
('9c74f676-7712-451f-82c9-207ea0538864', 109, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'ISSUE INSERT 1', 'words', '1320', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-06 10:27:30', '2024-07-15 09:24:33', NULL, NULL),
('9c74f676-774c-4aac-b112-4e2bcfa27161', 110, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'ISSUE INSERT 1', 'words', '1320', '1.50', NULL, NULL, NULL, '6000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-06 10:27:30', '2024-07-15 09:24:33', NULL, NULL),
('9c74f676-79a1-4c1d-972c-718da0ed13ea', 118, '9c74f676-68d6-4e3f-b36b-7381aa046fac', 'Issue Insert 2', 'words', '1121', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-06 10:27:30', '2024-07-06 10:27:30', NULL, NULL),
('9c74f676-79e3-419b-8439-f05d1d96e66c', 119, '9c74f676-68d6-4e3f-b36b-7381aa046fac', 'Issue Insert 2', 'words', '1121', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-06 10:27:30', '2024-07-06 10:27:30', NULL, NULL),
('9c74f676-7a37-4239-a702-69a2eac07c12', 120, '9c74f676-68d6-4e3f-b36b-7381aa046fac', 'Issue Insert 2', 'words', '1121', '1.50', NULL, NULL, NULL, '6000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-06 10:27:30', '2024-07-06 10:27:30', NULL, NULL),
('9c74f70a-d6b7-4f2f-9f37-197fefc951e6', 121, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70a-d758-41c1-9e40-7ade27f6a462', 122, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70a-e643-4f26-94ad-a9aef6686b5d', 123, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70a-f492-4806-ba83-793cc1a18e8e', 124, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-036e-44c7-8ab7-1c2846a70026', 125, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0479-489b-abed-3e9c69570af3', 126, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0548-4bb7-aec5-618a776d3ef6', 127, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0607-405c-9793-64a205c47714', 128, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-06b7-49e9-ae20-eac88630092a', 129, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0737-4c7a-9ac6-b91494cd197f', 130, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-07a6-4d6d-accc-97c8490ac1e9', 131, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Clinic Poster', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0809-4a14-9db4-d62c3af79bae', 132, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Clinic Poster', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0868-46ed-a28e-0e41ed47d5d6', 133, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Clinic Poster', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-08c0-430d-b5ea-ef44f2894b46', 134, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Clinic Poster', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0918-4ca7-9bad-eeb77182daf8', 135, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Clinic Poster', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-096f-463c-a7a2-86b5bb4b6300', 136, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Clinic Poster', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-09cc-49bf-87b8-1ad0f5be1d78', 137, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Clinic Poster', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0a20-43b2-8dc3-51359025194e', 138, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Clinic Poster', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0a6a-4f78-95f9-f07f1f55238a', 139, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Clinic Poster', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0ab9-4efb-85ec-6511e9ed5b57', 140, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Clinic Poster', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0b10-4d06-958b-656664b056dd', 141, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Issue Insert 1', 'words', '1320', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0b67-4316-b93d-5dca371faaca', 142, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Issue Insert 1', 'words', '1320', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0bfc-4711-ab6d-dbb2e650fe7d', 143, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Issue Insert 1', 'words', '1320', '1.50', NULL, NULL, NULL, '6000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0c55-4346-adef-4f459ae8fd6a', 144, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'ISSUE INSERT 1', 'words', '1320', '1.75', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-06 10:29:08', '2024-07-15 09:24:33', NULL, NULL),
('9c74f70b-0ca1-411a-a64c-1bb799d8889b', 145, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'ISSUE INSERT 1', 'words', '1320', '1.75', NULL, NULL, NULL, '6000', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-06 10:29:08', '2024-07-15 09:24:33', NULL, NULL),
('9c74f70b-0d00-425c-856a-23ee967fac76', 146, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'ISSUE INSERT 1', 'words', '1320', '1.75', NULL, NULL, NULL, '6000', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-06 10:29:08', '2024-07-15 09:24:33', NULL, NULL),
('9c74f70b-0d59-4374-ac24-eae2d3bf6fe8', 147, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'ISSUE INSERT 1', 'words', '1320', '2.00', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-06 10:29:08', '2024-07-15 09:24:33', NULL, NULL),
('9c74f70b-0d9f-4546-986f-a024b59f5980', 148, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'ISSUE INSERT 1', 'words', '1320', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-06 10:29:08', '2024-07-15 09:24:33', NULL, NULL),
('9c74f70b-0ddf-463a-b77c-fc821b19f640', 149, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'ISSUE INSERT 1', 'words', '1320', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-06 10:29:08', '2024-07-15 09:24:33', NULL, NULL),
('9c74f70b-0e20-4c6c-829b-c4eeb0ca8c8d', 150, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'ISSUE INSERT 1', 'words', '1320', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-06 10:29:08', '2024-07-15 09:24:33', NULL, NULL),
('9c74f70b-0e91-4960-921b-7dd593152913', 151, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Issue Insert 2', 'words', '1121', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0ed1-4734-a7ac-809b7add9310', 152, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Issue Insert 2', 'words', '1121', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0f10-41d3-9f5a-82b9f1f220c2', 153, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Issue Insert 2', 'words', '1121', '1.50', NULL, NULL, NULL, '6000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0f55-4ed3-a199-cb07b6f5e4fb', 154, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Issue Insert 2', 'words', '1121', '1.75', NULL, NULL, NULL, '6000', NULL, NULL, '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0f97-4bc5-8972-e8d69d6af047', 155, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Issue Insert 2', 'words', '1121', '1.75', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-0fe0-455b-8715-e644fe2719d4', 156, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Issue Insert 2', 'words', '1121', '1.75', NULL, NULL, NULL, '6000', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-1030-495f-9a74-e76dfe0ad7f3', 157, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Issue Insert 2', 'words', '1121', '1.75', NULL, NULL, NULL, '6000', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-107c-4f87-bcd6-4943d8b6ee53', 158, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Issue Insert 2', 'words', '1121', '2.00', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-10b6-4850-9a57-f8da790b8a0d', 159, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Issue Insert 2', 'words', '1121', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-10ef-4ea9-80a5-c810ea000fcb', 160, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Issue Insert 2', 'words', '1121', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74f70b-112e-4139-88af-54c7b70311f2', 161, '9c74f70a-d5b9-4078-b710-f6b73942c8f2', 'Issue Insert 2', 'words', '1121', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-06 10:29:08', '2024-07-06 10:29:08', NULL, NULL),
('9c74fc31-a721-4689-bf69-b5426284bf74', 162, '9c74fc31-a621-42ca-a1a8-cdf9f0223085', 'Main Informed Consent Form_v1.1.0', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-06 10:43:32', '2024-07-06 10:43:32', NULL, NULL),
('9c74fc31-a769-4bb6-a785-d5f1e91ed056', 163, '9c74fc31-a621-42ca-a1a8-cdf9f0223085', 'Main Informed Consent Form_v1.1.0', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-06 10:43:32', '2024-07-06 10:43:32', NULL, NULL),
('9c74fc31-a7c1-4bed-91e6-c5093971d3dc', 164, '9c74fc31-a621-42ca-a1a8-cdf9f0223085', 'Main Informed Consent Form_v1.1.0', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-06 10:43:32', '2024-07-06 10:43:32', NULL, NULL),
('9c74fc89-3fa9-4179-aafe-fcac5deb7bed', 165, '9c74fc31-a621-42ca-a1a8-cdf9f0223085', 'Main Informed Consent Form_v1.1.0', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-06 10:44:29', '2024-07-06 10:44:29', NULL, NULL),
('9c74fc89-404c-4d23-8af9-9ec16c003e01', 166, '9c74fc31-a621-42ca-a1a8-cdf9f0223085', 'Main Informed Consent Form_v1.1.0', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-06 10:44:29', '2024-07-06 10:44:29', NULL, NULL),
('9c74fc89-40f0-45f6-b1a3-8f4bb3e2d303', 167, '9c74fc31-a621-42ca-a1a8-cdf9f0223085', 'Main Informed Consent Form_v1.1.0', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-06 10:44:29', '2024-07-06 10:44:29', NULL, NULL),
('9c750f94-8d86-43ef-b4f4-a4acd9d25b97', 168, '9c750f94-8bfd-43ec-9dc4-bdfb503bfa97', 'doc1', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-06 11:37:45', '2024-07-06 11:37:45', NULL, NULL),
('9c750f94-8de2-4e3a-ac0f-cabbb858c6ec', 169, '9c750f94-8bfd-43ec-9dc4-bdfb503bfa97', 'doc1', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-06 11:37:45', '2024-07-06 11:37:45', NULL, NULL),
('9c750f94-8e20-4fee-98e7-7199ae3ac534', 170, '9c750f94-8bfd-43ec-9dc4-bdfb503bfa97', 'doc1', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-06 11:37:45', '2024-07-06 11:37:45', NULL, NULL),
('9c83311c-3ae4-4414-a207-863be542ce30', 178, '9c83311c-35d4-4e30-bed3-93d232292f6d', '12331', 'words', '1', '132.00', NULL, NULL, NULL, NULL, NULL, '9be697f2-6a98-440d-989f-ccc1cec89186', '2024-07-13 12:13:05', '2024-07-13 12:13:05', NULL, NULL),
('9c86ec4f-f8de-45a6-ac0b-298fb0956eea', 179, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-fa1a-4fc0-98bd-c83239f466b3', 180, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-fa75-467c-8e23-e01fa0195359', 181, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-fadc-466d-885c-550cc8e36edc', 182, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-fb17-4305-b33e-c833f694418b', 183, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-fb53-42f4-bfd8-99b65bff0d62', 184, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-fbd8-43ca-ad6f-def175f2e91a', 185, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-fc3f-459b-9a1d-224f0116bca1', 186, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-fc9a-4ab2-b8be-225d3a316421', 187, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-fcf7-44b3-a3d6-d70cda1e5b98', 188, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-fd3b-4683-b124-515503799395', 189, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'IN CLINIC POSTER', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-fda4-46e6-99b6-1bd5572f82c5', 190, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'IN CLINIC POSTER', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-fe1a-44de-91c4-811c8aa53d8e', 191, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'IN CLINIC POSTER', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-fe57-4d84-800b-80c9c329e9b5', 192, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'IN CLINIC POSTER', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-fe91-473d-8c05-8d4470548255', 193, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'IN CLINIC POSTER', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-fee0-4269-a3c9-b575876754c0', 194, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'IN CLINIC POSTER', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-ff70-42e0-be8d-af047e7b1031', 195, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec4f-ffb8-4ea7-bcc2-c0cf7a2dba36', 196, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec50-0032-4d41-a2fb-17830720d150', 197, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86ec50-00ad-4170-8fff-442b206b45f6', 198, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-15 08:44:02', '2024-07-15 08:44:02', NULL, NULL),
('9c86faaa-3704-45fe-80c4-bcc017848e1b', 199, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'ISSUE INSERT 1', 'words', '1320', '1.50', NULL, NULL, NULL, '6000', NULL, NULL, '2024-07-15 09:24:10', '2024-07-15 09:24:10', NULL, NULL),
('9c86faaa-39b8-4535-a0e4-acad64610bb0', 200, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'ISSUE INSERT 1', 'words', '1320', '1.75', NULL, NULL, NULL, '6000', NULL, NULL, '2024-07-15 09:24:10', '2024-07-15 09:24:10', NULL, NULL),
('9c86faaa-3af9-48d5-b00b-207183425a43', 201, '9c86ec4f-f6b9-4106-a63e-f7136c8a8603', 'ISSUE INSERT 1', 'words', '1320', '2.00', NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-15 09:24:10', '2024-07-15 09:24:10', NULL, NULL),
('9c870f46-c340-4dfb-be1d-d47e2a2a1c36', 202, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-15 10:21:48', '2024-07-15 10:21:48', NULL, NULL),
('9c870f46-c410-412e-9a4f-8681ed29d995', 203, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-15 10:21:48', '2024-07-15 10:21:48', NULL, NULL),
('9c870f46-c486-49cd-b515-5a139ccf9951', 204, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-15 10:21:48', '2024-07-15 10:21:48', NULL, NULL),
('9c870f46-c4f8-4c30-9c9f-88c663444b9c', 205, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-15 10:21:48', '2024-07-15 10:21:48', NULL, NULL),
('9c870f46-c5b4-4a37-95f9-f53d69fe3315', 206, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-15 10:21:48', '2024-07-15 10:21:48', NULL, NULL),
('9c870f46-c651-47de-8697-320eae66b54d', 207, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-15 10:21:48', '2024-07-15 10:21:48', NULL, NULL),
('9c870f46-c6cc-4de0-b432-8ff666da0e5a', 208, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-15 10:21:48', '2024-07-15 10:21:48', NULL, NULL),
('9c870f46-c8d3-43ea-a352-578f7dad758b', 209, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-15 10:21:48', '2024-07-15 10:21:48', NULL, NULL),
('9c870f46-c928-4b05-8532-fa39ed1a3f81', 210, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-15 10:21:48', '2024-07-15 10:21:48', NULL, NULL),
('9c870f46-c9a3-40ff-a21f-9b74e839d677', 211, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-15 10:21:48', '2024-07-15 10:21:48', NULL, NULL),
('9c8712d0-b279-42ed-8065-e62414177fb6', 212, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'IN CLINIC POSTER', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, NULL, '2024-07-15 10:31:41', '2024-07-15 10:31:41', NULL, NULL),
('9c8712d0-b59c-4fd8-a813-1da92029bc91', 213, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'IN CLINIC POSTER', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, NULL, '2024-07-15 10:31:41', '2024-07-15 10:31:41', NULL, NULL),
('9c8712d0-b727-4e34-9dc6-f429e5335bc3', 214, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, NULL, '2024-07-15 10:31:41', '2024-07-15 10:31:41', NULL, NULL),
('9c87139f-f5e5-4e64-b0b7-7d9d50099e49', 215, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'IN CLINIC POSTER', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-15 10:33:57', '2024-07-15 10:33:57', NULL, NULL),
('9c87139f-f6d5-4467-9bfd-1b410ec2f07e', 216, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'IN CLINIC POSTER', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-15 10:33:57', '2024-07-15 10:33:57', NULL, NULL),
('9c87139f-f77e-4333-8ac6-4602394faed3', 217, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'IN CLINIC POSTER', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-15 10:33:57', '2024-07-15 10:33:57', NULL, NULL),
('9c87139f-f8b4-42bb-805d-f64db5fad727', 218, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'IN CLINIC POSTER', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-15 10:33:57', '2024-07-15 10:33:57', NULL, NULL),
('9c87139f-f949-4fea-9ec4-4c84fbb00570', 219, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'IN CLINIC POSTER', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-15 10:33:57', '2024-07-15 10:33:57', NULL, NULL),
('9c87139f-f9c4-43a8-abc7-bda809afdee9', 220, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'IN CLINIC POSTER', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-15 10:33:57', '2024-07-15 10:33:57', NULL, NULL),
('9c87139f-fb22-45b3-b483-c6a9c0ecf703', 221, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-15 10:33:57', '2024-07-15 10:33:57', NULL, NULL),
('9c87139f-fb9a-416d-a306-a9fbcfbdd833', 222, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-15 10:33:57', '2024-07-15 10:33:57', NULL, NULL),
('9c87139f-fc41-4c22-b482-d22229b53dc2', 223, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-15 10:33:57', '2024-07-15 10:33:57', NULL, NULL),
('9c87139f-fce9-4879-b209-e847d9416732', 224, '9c870f46-c0e0-45a1-a089-a1a7303fe15f', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-15 10:33:57', '2024-07-15 10:33:57', NULL, NULL),
('9c872234-8733-4da4-bf66-2d71c276efa2', 225, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-15 11:14:43', '2024-07-15 11:14:43', NULL, NULL),
('9c872234-87f8-49e8-8360-0874f314f005', 226, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-15 11:14:43', '2024-07-15 11:14:43', NULL, NULL),
('9c872234-8896-4e0d-bdf6-bbcb7b4eb46b', 227, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-15 11:14:43', '2024-07-15 11:14:43', NULL, NULL),
('9c872234-891c-4198-bc23-bcab13fc78b3', 228, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-15 11:14:43', '2024-07-15 11:14:43', NULL, NULL),
('9c872234-899b-485f-94b5-b39aa4d82dac', 229, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-15 11:14:43', '2024-07-15 11:14:43', NULL, NULL),
('9c872234-8a94-496d-a721-2e7bee44427b', 231, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-15 11:14:43', '2024-07-15 11:14:43', NULL, NULL),
('9c872234-8b07-4c80-a6ca-63951f6e84e4', 232, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-15 11:14:43', '2024-07-15 11:14:43', NULL, NULL),
('9c872234-8b78-43b0-95c5-23c1857f4235', 233, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-15 11:14:43', '2024-07-15 11:14:43', NULL, NULL),
('9c872234-8bf0-459f-ae0d-e4b9067615ad', 234, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-15 11:14:43', '2024-07-15 11:14:43', NULL, NULL),
('9c8766b6-0945-4575-9383-cd06b4b1c336', 235, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'IN CLINIC POSTER', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-15 14:26:17', '2024-07-15 14:26:17', NULL, NULL),
('9c8766b6-1039-40fc-a074-e14ba671c399', 236, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'IN CLINIC POSTER', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-15 14:26:17', '2024-07-15 14:26:17', NULL, NULL),
('9c8766b6-10c5-4806-919b-c3e79a8063b6', 237, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'IN CLINIC POSTER', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-15 14:26:17', '2024-07-15 14:26:17', NULL, NULL),
('9c8766b6-1171-4765-a168-bf9f6dcef5a3', 238, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'IN CLINIC POSTER', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-15 14:26:17', '2024-07-15 14:26:17', NULL, NULL),
('9c8766b6-1201-41cd-997f-03fa44489c95', 239, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'IN CLINIC POSTER', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-15 14:26:17', '2024-07-15 14:26:17', NULL, NULL),
('9c8766b6-12c7-4ab9-8b45-4aa243346307', 240, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'IN CLINIC POSTER', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-15 14:26:17', '2024-07-15 14:26:17', NULL, NULL),
('9c8766b6-13e6-4af5-bfc3-b23e6e2550f6', 241, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-15 14:26:17', '2024-07-15 14:26:17', NULL, NULL),
('9c8766b6-1462-48c1-9db5-be9afb0f1235', 242, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-15 14:26:17', '2024-07-15 14:26:17', NULL, NULL),
('9c8766b6-1505-4dcc-93cc-cfd1a89f1a4a', 243, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-15 14:26:17', '2024-07-15 14:26:17', NULL, NULL),
('9c8766b6-158f-4ed1-a316-6d59f7b068ff', 244, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-15 14:26:17', '2024-07-15 14:26:17', NULL, NULL),
('9c877001-04c6-4eef-8a19-447f2ed6dcca', 245, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 1', 'words', '1320', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-15 14:52:16', '2024-07-15 14:52:16', NULL, NULL),
('9c877001-05b7-4027-928a-c66d89ef6a79', 246, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 1', 'words', '1320', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-15 14:52:16', '2024-07-15 14:52:16', NULL, NULL),
('9c877001-064d-40d0-8c04-7b0c5b34f162', 247, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 1', 'words', '1320', '1.50', NULL, NULL, NULL, '6000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-15 14:52:16', '2024-07-15 14:52:16', NULL, NULL),
('9c877001-076c-4eba-a2a9-366094dc65fd', 248, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 1', 'words', '1320', '1.75', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-15 14:52:16', '2024-07-15 14:52:16', NULL, NULL),
('9c877001-07e8-49c2-a011-4525e844aa7d', 249, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 1', 'words', '1320', '1.75', NULL, NULL, NULL, '6000', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-15 14:52:16', '2024-07-15 14:52:16', NULL, NULL),
('9c877001-08a3-4c19-88da-c557f4d5ec8d', 250, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 1', 'words', '1320', '1.75', NULL, NULL, NULL, '6000', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-15 14:52:16', '2024-07-15 14:52:16', NULL, NULL),
('9c877001-0948-4d35-afa0-edda59bc265a', 251, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 1', 'words', '1320', '2.00', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-15 14:52:16', '2024-07-15 14:52:16', NULL, NULL),
('9c877001-09c7-4d1a-b228-efc976368a1b', 252, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 1', 'words', '1320', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-15 14:52:16', '2024-07-15 14:52:16', NULL, NULL),
('9c877001-0a6e-4a84-8dae-53d1262701a7', 253, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 1', 'words', '1320', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-15 14:52:16', '2024-07-15 14:52:16', NULL, NULL),
('9c877001-0b3c-4156-8146-d0e737defbdc', 254, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 1', 'words', '1320', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-15 14:52:16', '2024-07-15 14:52:16', NULL, NULL),
('9c87713d-f428-449d-8071-d977204ce63c', 255, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 2', 'words', '1121', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-15 14:55:44', '2024-07-15 14:55:44', NULL, NULL),
('9c87713d-f4ed-4826-92a4-62d0462dbaa4', 256, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 2', 'words', '1121', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-15 14:55:44', '2024-07-15 14:55:44', NULL, NULL),
('9c87713d-f5c4-46ed-bdc6-e7aea76d985e', 257, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 2', 'words', '1121', '1.50', NULL, NULL, NULL, '6000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-15 14:55:44', '2024-07-15 14:55:44', NULL, NULL),
('9c87713d-f673-4dec-9ffe-972a2b8f2f43', 258, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 2', 'words', '1121', '1.75', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-15 14:55:44', '2024-07-15 14:55:44', NULL, NULL),
('9c87713d-f6ea-401a-b865-5088c3153169', 259, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 2', 'words', '1121', '1.75', NULL, NULL, NULL, '6000', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-15 14:55:44', '2024-07-15 14:55:44', NULL, NULL),
('9c87713d-f75e-4606-b4a0-f4a7e61cf111', 260, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 2', 'words', '1121', '1.75', NULL, NULL, NULL, '6000', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-15 14:55:44', '2024-07-15 14:55:44', NULL, NULL),
('9c88cd4d-193e-4e40-a477-8e70636d6b60', 261, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-16 07:08:58', '2024-07-16 07:08:58', NULL, NULL),
('9c88cd4d-2d42-4e89-88e6-74a82a31da7e', 262, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 2', 'words', '1121', '2.00', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-16 07:08:58', '2024-07-16 07:08:58', NULL, NULL),
('9c88cd4d-2e61-4651-bc2d-c1c0dbe44b95', 263, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 2', 'words', '1121', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-16 07:08:58', '2024-07-16 07:08:58', NULL, NULL),
('9c88cd4d-2f38-4b4c-a6fd-442909f8aae0', 264, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 2', 'words', '1121', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-16 07:08:58', '2024-07-16 07:08:58', NULL, NULL),
('9c88cd4d-301e-4bd1-8d01-1ed1b7278a1e', 265, '9c872234-8071-46d6-95af-cc9dcd0ce341', 'ISSUE INSERT 2', 'words', '1121', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-16 07:08:58', '2024-07-16 07:08:58', NULL, NULL),
('9c88ed64-ec19-4337-8807-55e52b591530', 266, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-16 08:38:42', '2024-07-16 08:38:42', NULL, NULL),
('9c88ed64-ecb3-420c-826d-8b0f42fba139', 267, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-16 08:38:42', '2024-07-16 08:38:42', NULL, NULL),
('9c88ed64-ed37-45d8-bee7-489941372fc7', 268, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-16 08:38:42', '2024-07-16 08:38:42', NULL, NULL),
('9c88ed64-edb9-40a4-ac7f-f4301800f9b4', 269, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-16 08:38:42', '2024-07-16 08:38:42', NULL, NULL),
('9c88ed64-ee36-43c3-8003-4bcb2dad96bb', 270, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL),
('9c88ed64-ef2e-4e66-b7fa-4bbccfd85296', 271, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL),
('9c88ed64-f000-4d65-89d9-c5e41c95d0b4', 272, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL),
('9c88ed64-f093-446d-b8f9-e8057a970777', 273, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL),
('9c88ed64-f12e-4344-9a18-d284a7830d6e', 274, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL);
INSERT INTO `estimate_details` (`id`, `sr_no`, `estimate_id`, `document_name`, `type`, `unit`, `rate`, `verification`, `verification_2`, `back_translation`, `layout_charges`, `layout_charges_2`, `lang`, `created_at`, `updated_at`, `two_way_qc_t`, `two_way_qc_bt`) VALUES
('9c88ed64-f1dc-4a94-b3fe-ded69b389535', 275, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL),
('9c88ed64-f272-476f-bd6f-7e548ffc7abd', 276, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'IN CLINIC POSTER', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL),
('9c88ed64-f2f6-418b-a492-cf85d88b1d63', 277, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'IN CLINIC POSTER', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL),
('9c88ed64-f383-409d-88dd-9a05bc757043', 278, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'IN CLINIC POSTER', 'words', '427', '1.50', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL),
('9c88ed64-f415-42a7-9b26-b0b5d06a0e72', 279, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'IN CLINIC POSTER', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL),
('9c88ed64-f4e3-4b1e-83b2-877fce830cfc', 280, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'IN CLINIC POSTER', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL),
('9c88ed64-f5bc-45dd-bfe8-6f5fa8a246b0', 281, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'IN CLINIC POSTER', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL),
('9c88ed64-f656-4c34-b015-3c696010ee6e', 282, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL),
('9c88ed64-f6f0-4738-872e-f2989abd0464', 283, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL),
('9c88ed64-f806-425e-8865-ad6b33eef7bc', 284, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL),
('9c88ed64-f89a-4d7a-af59-f93c427425fe', 285, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-16 08:38:43', '2024-07-16 08:38:43', NULL, NULL),
('9c88f034-2c8a-4f11-b23e-44dcfe2c2e5d', 286, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'ISSUE INSERT 1', 'words', '1320', '1.50', NULL, NULL, NULL, '6000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-2def-4b9f-b7a0-d6a779d86519', 287, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'ISSUE INSERT 1', 'words', '1320', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-2e7d-4e11-8666-70bc3e0efdab', 288, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'ISSUE INSERT 1', 'words', '1320', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-2f7f-45de-b0de-8f16b4c0fa69', 289, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'ISSUE INSERT 1', 'words', '1320', '1.75', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-3070-4515-afea-785296b84fa0', 290, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'ISSUE INSERT 1', 'words', '1320', '1.75', NULL, NULL, NULL, '6000', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-30fd-4da5-afbc-6d8d9bbc9521', 291, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'ISSUE INSERT 1', 'words', '1320', '1.75', NULL, NULL, NULL, '6000', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-31ed-4062-80f5-98c61e5d13d5', 292, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'ISSUE INSERT 1', 'words', '1320', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-3296-4567-9311-a48a6d60715c', 293, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'ISSUE INSERT 1', 'words', '1320', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-332a-4f8c-b4b5-40a0c5eff511', 294, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'ISSUE INSERT 1', 'words', '1320', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-33b9-4414-af63-036481135448', 295, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'ISSUE INSERT 1', 'words', '1320', '2.00', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-348c-4f76-97cd-699f19cb4505', 296, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Issue Insert 2', 'words', '1121', '1.50', NULL, NULL, NULL, '6000', NULL, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-3681-4a04-9a9f-cd877a4730d6', 297, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Issue Insert 2', 'words', '1121', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-3710-4abd-a141-19717859b374', 298, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Issue Insert 2', 'words', '1121', '1.50', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-37cf-4aae-81b7-59a65bcba7cf', 299, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Issue Insert 2', 'words', '1121', '1.75', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-3927-4886-b35b-3f20541f038a', 300, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Issue Insert 2', 'words', '1121', '1.75', NULL, NULL, NULL, '6000', NULL, '9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-39d0-41d6-9304-ea4623538c12', 301, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Issue Insert 2', 'words', '1121', '1.75', NULL, NULL, NULL, '6000', NULL, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-3ac2-4f22-8e52-0f9236bec7ea', 302, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Issue Insert 2', 'words', '1121', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e7d1-43ec-4c68-a385-acbaee286b0d', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-3b45-4341-98af-8c98e32e5eeb', 303, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Issue Insert 2', 'words', '1121', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e87a-bd76-4ea3-9e6a-1153d47a6531', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-3c0e-4e8e-813f-f80809a0cf44', 304, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Issue Insert 2', 'words', '1121', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f034-3cd3-4bad-9753-7c33426869f2', 305, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Issue Insert 2', 'words', '1121', '2.00', NULL, NULL, NULL, '6000', NULL, '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-16 08:46:34', '2024-07-16 08:46:34', NULL, NULL),
('9c88f1a2-f0ca-4413-8f29-7bb8e41ac05d', 306, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e859-39af-4e4d-9e6e-adf1e787d1b6', '2024-07-16 08:50:34', '2024-07-16 08:50:34', NULL, NULL),
('9c88f1a2-f2dc-4a7c-b581-a2653deef625', 307, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Lama', 'words', '1', '500.00', NULL, NULL, NULL, '500', NULL, '9c74e83d-f4cd-4afe-aee1-49c9d26f2811', '2024-07-16 08:50:34', '2024-07-16 08:50:34', NULL, NULL),
('9c88f1a2-f702-4b38-b7d3-7c8ab0b760ce', 308, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'IN CLINIC POSTER', 'words', '427', '1.75', NULL, NULL, NULL, '1000', NULL, '9c74e859-39af-4e4d-9e6e-adf1e787d1b6', '2024-07-16 08:50:34', '2024-07-16 08:50:34', NULL, NULL),
('9c88f1a2-f844-4b1a-81e4-3ab71ffa1d92', 309, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'IN CLINIC POSTER', 'words', '427', '2.00', NULL, NULL, NULL, '1000', NULL, '9c74e83d-f4cd-4afe-aee1-49c9d26f2811', '2024-07-16 08:50:34', '2024-07-16 08:50:34', NULL, NULL),
('9c88f1a2-fcae-4c28-9992-402972d05161', 310, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'ISSUE INSERT 1', 'words', '1320', '1.75', NULL, NULL, NULL, '6000', NULL, '9c74e859-39af-4e4d-9e6e-adf1e787d1b6', '2024-07-16 08:50:34', '2024-07-16 08:50:34', NULL, NULL),
('9c88f1a2-fe91-4947-9c8d-920b4e01bfd6', 311, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'ISSUE INSERT 1', 'words', '1320', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e83d-f4cd-4afe-aee1-49c9d26f2811', '2024-07-16 08:50:34', '2024-07-16 08:50:34', NULL, NULL),
('9c88f1a3-0305-4e4b-96ac-96048e440600', 312, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Issue Insert 2', 'words', '1121', '1.75', NULL, NULL, NULL, '6000', NULL, '9c74e859-39af-4e4d-9e6e-adf1e787d1b6', '2024-07-16 08:50:34', '2024-07-16 08:50:34', NULL, NULL),
('9c88f1a3-0457-4371-9069-45fd97c088d8', 313, '9c88ed64-e465-410d-8946-4d5406d79bbd', 'Issue Insert 2', 'words', '1121', '2.00', NULL, NULL, NULL, '6000', NULL, '9c74e83d-f4cd-4afe-aee1-49c9d26f2811', '2024-07-16 08:50:34', '2024-07-16 08:50:34', NULL, NULL),
('9c9115ac-4e46-4adb-96ea-a00e9e273845', 314, '9c9115ac-48df-4b0b-96f2-8c03df090bdc', 'MAin ICD', 'words', '6915', '1.75', NULL, NULL, '1.75', '1000', '1000', '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '2024-07-20 09:57:58', '2024-07-20 10:05:14', NULL, NULL),
('9c9115ac-4f8b-4a93-a863-b45a51857da1', 315, '9c9115ac-48df-4b0b-96f2-8c03df090bdc', 'MAin ICD', 'words', '6915', '1.75', NULL, NULL, '1.75', '1000', '1000', '9c74e7f1-5425-41dc-9c20-7cbec90908a1', '2024-07-20 09:57:58', '2024-07-20 10:05:14', NULL, NULL),
('9c9115ac-5019-4fe2-8479-7270a6aa2779', 316, '9c9115ac-48df-4b0b-96f2-8c03df090bdc', 'MAin ICD', 'words', '6915', '1.50', NULL, NULL, '1.50', '1000', '1000', '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '2024-07-20 09:57:58', '2024-07-20 10:05:14', NULL, NULL),
('9c9115ac-50a2-4d07-b69f-3027d4333f61', 317, '9c9115ac-48df-4b0b-96f2-8c03df090bdc', 'MAin ICD', 'words', '6915', '1.50', NULL, NULL, '1.50', '1000', '1000', '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '2024-07-20 09:57:58', '2024-07-20 10:05:14', NULL, NULL),
('9c9115ac-515c-4b14-8250-6ff7ea9df71e', 318, '9c9115ac-48df-4b0b-96f2-8c03df090bdc', 'MAin ICD', 'words', '6915', '2.00', NULL, NULL, '2', '1000', '1000', '9c74e81d-3c13-4d00-8c36-dc2653c34777', '2024-07-20 09:57:58', '2024-07-20 10:05:14', NULL, NULL),
('9c9115ac-51e6-4717-90b5-eb322c6a3ccb', 319, '9c9115ac-48df-4b0b-96f2-8c03df090bdc', 'MAin ICD', 'words', '6915', '2.00', NULL, NULL, '2', '1000', '1000', '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '2024-07-20 09:57:58', '2024-07-20 10:05:14', NULL, NULL);

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
  `t_cr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t_cnc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t_dv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t_fqc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t_sentdate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_writer_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_pd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_cr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_cnc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_dv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_fqc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt_sentdate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimate_detail_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `v_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `v_employee_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `v_pd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `v_cr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `v2_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `v2_employee_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `v2_pd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `v2_cr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btv_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btv_employee_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btv_pd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btv_cr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t_pd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_cards`
--

INSERT INTO `job_cards` (`id`, `job_card_srno`, `sync_no`, `t_unit`, `bt_unit`, `job_no`, `created_at`, `updated_at`, `t_writer_code`, `t_cr`, `t_cnc`, `t_dv`, `t_fqc`, `t_sentdate`, `bt_writer_code`, `bt_pd`, `bt_cr`, `bt_cnc`, `bt_dv`, `bt_fqc`, `bt_sentdate`, `estimate_detail_id`, `v_unit`, `v_employee_code`, `v_pd`, `v_cr`, `v2_unit`, `v2_employee_code`, `v2_pd`, `v2_cr`, `btv_unit`, `btv_employee_code`, `btv_pd`, `btv_cr`, `t_pd`) VALUES
('9c3ddb14-8368-4a7f-bc9c-3f7b2dcd3e8d', 1, '1717908014191', '14', '12', '1', '2024-06-08 19:30:24', '2024-06-08 23:10:14', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-06-10', '102', '8', 'PANDU', '2024-06-12', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-06-11', '2024-06-10', '8', '8', 'PANDU', '2024-06-17', '9c3cf7bf-4147-40a3-8030-e49220d1065d', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('9c3deb51-96fb-4242-a364-2d9632262b49', 3, '1717908014191', '231', '321', '1', '2024-06-08 20:15:49', '2024-06-08 23:10:14', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-06-25', '8', '0', 'PANDU', '2024-06-24', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-06-04', '2024-06-04', '123', '12', 'NO PANDU', '2024-06-17', '9c3cf7bf-4147-40a3-8030-e49220d1065d', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('9c3deb9e-51ed-428b-b920-ebee6a35ca9b', 4, '1719511836859', '10', '10', '1', '2024-06-08 20:16:39', '2024-06-27 12:40:36', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-06-25', '12', '213', 'PANDU', '2024-06-18', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-06-10', '2024-06-19', '8', '123', '123', '2024-06-18', '9c3d4415-0a4d-454f-bbcb-549ce6ee365c', '76', '9c230458-53c7-422d-ad1e-a5bf5beebca1', '2024-06-27', '2024-06-27', '76', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '2024-06-27', '2024-06-27', '123', '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4', '2024-06-27', '2024-06-27', NULL),
('9c6621b3-b4e8-496e-9168-754dffe829ea', 8, '1719624660226', '14', '3', '2', '2024-06-28 20:01:00', '2024-06-28 20:01:00', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-06-29', 'C', '1', '1', '2024-06-29', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-06-29', '2024-06-29', 'CN', '8', NULL, '2024-06-29', '9c59f817-eb6d-4478-b575-9ed3c4c9dec2', '2', '9bea89ed-8044-49d8-8275-f3269a1dfd23', NULL, NULL, NULL, '9bea89ed-8044-49d8-8275-f3269a1dfd23', NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-29'),
('9c6f2311-417c-4f65-a9e1-6d0ae057abe0', 9, '1720011436362', '2', '2', '4', '2024-07-03 07:27:16', '2024-07-03 07:27:16', '9c6f0797-04a4-402e-a187-593facfae847', '2024-07-03', 'C', 'DV', 'PANDU', '2024-07-05', '9c6f0797-04a4-402e-a187-593facfae847', '2024-07-03', '2024-07-04', 'C', 'BT DV', 'PANDU', '2024-07-05', '9c6b66b2-3350-48e0-9c59-df4719fb2acf', '1', '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4', '2024-07-03', '2024-07-04', '1', '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4', '2024-07-03', '2024-07-03', '2', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '2024-07-04', '2024-07-04', '2024-07-03'),
('9c6f24cf-89af-4fbe-b9a0-f0fee9ebcfc3', 10, '1720012385543', '2', NULL, '4', '2024-07-03 07:32:08', '2024-07-03 07:43:05', '9c6f0e5b-161c-4941-92e5-6b99b3f97b0c', '2024-07-07', 'C', 'DV', 'PANDU', '2024-07-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c6b66b2-3417-4438-8445-4fee847347f8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-06'),
('9c6f2f19-28b3-427e-9ed0-e1804d77ba74', 11, '1720014407442', '1', '1', '4', '2024-07-03 08:00:54', '2024-07-03 08:16:47', '9c6b636f-cf17-4d00-9012-f7404dcd3f1a', '2024-07-06', 'C', 'DV', 'Tester', '2024-07-07', '9c6b636f-cf17-4d00-9012-f7404dcd3f1a', '2024-07-08', '2024-07-09', 'C', 'BT DV', 'PANDU', '2024-07-10', '9c6f08c1-ee9c-4a48-9b97-24962b41f78d', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-05'),
('9c6f320a-b119-4c77-9803-67f63a77ede5', 13, '1720014407442', '1', '1', '4', '2024-07-03 08:09:08', '2024-07-03 08:16:47', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-07-12', 'C', 'DV', 'QC', '2024-07-13', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-07-15', '2024-07-16', 'C', 'DV', 'Tester', '2024-07-17', '9c6f08c1-ee9c-4a48-9b97-24962b41f78d', '3', '9c6ed7f6-7601-4ea9-8cb4-91701bfa0f3f', '2024-07-12', '2024-07-13', NULL, NULL, NULL, NULL, '2', '9c230458-53c7-422d-ad1e-a5bf5beebca1', '2024-07-17', NULL, '2024-07-11'),
('9c6f80c0-a23e-4178-89ad-c6fefdfec723', 14, '1720027154108', '2', '1', '4', '2024-07-03 11:49:14', '2024-07-03 11:49:14', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-07-03', 'C', 'DV', 'PANDU', '2024-07-03', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-07-09', '2024-07-10', 'C', 'BT DV', 'PANDU', '2024-07-11', '9c6f782f-7cff-46fb-a2af-4784b562be79', '1', '9c6ed7f6-7601-4ea9-8cb4-91701bfa0f3f', '2024-07-05', '2024-07-06', '1', '9c6ed7f6-7601-4ea9-8cb4-91701bfa0f3f', '2024-07-07', '2024-07-08', '2', '9c6ed7f6-7601-4ea9-8cb4-91701bfa0f3f', '2024-07-11', '2024-07-12', '2024-07-03'),
('9c70d658-4c78-4d94-a1bb-a39b35099a82', 15, '1720106082219', '2', NULL, '5', '2024-07-04 03:44:23', '2024-07-04 09:44:42', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-07-05', 'C', 'DV', 'PANDU', '2024-07-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c70d176-a3f0-4ac6-b799-734260c78ec3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-04'),
('9c70d6eb-92c0-451f-96a0-486aa72ad856', 16, '1720085092651', '1', '1', '5', '2024-07-04 03:46:00', '2024-07-04 03:54:52', '9c6b636f-cf17-4d00-9012-f7404dcd3f1a', '2024-07-04', 'C', 'DV', 'Tester', '2024-07-05', '9c6b636f-cf17-4d00-9012-f7404dcd3f1a', '2024-07-05', '2024-07-05', 'C', NULL, NULL, NULL, '9c70d353-06e9-4a1d-830e-5eb73e827a91', '1', NULL, '2024-07-05', '2024-07-05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-04'),
('9c70d6eb-93d3-41de-a84a-99be91ce3043', 17, '1720085092651', '1', NULL, '5', '2024-07-04 03:46:00', '2024-07-04 03:54:52', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-07-07', 'C', 'DV', 'QC', '2024-07-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c70d353-06e9-4a1d-830e-5eb73e827a91', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-06'),
('9c70d8b7-e148-4bd2-ab1c-730561336472', 18, '1720085092651', '1', NULL, '5', '2024-07-04 03:51:01', '2024-07-04 03:54:52', '9c6b636f-cf17-4d00-9012-f7404dcd3f1a', '2024-07-04', 'C', 'DV', 'Pandu', '2024-07-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c70d353-06e9-4a1d-830e-5eb73e827a91', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-04'),
('9c70da17-e675-4fe9-bb70-01a89ec8b9bb', 19, '1720085092651', '1', NULL, '5', '2024-07-04 03:54:52', '2024-07-04 03:54:52', '9c6b636f-cf17-4d00-9012-f7404dcd3f1a', '2024-07-05', 'C', 'DV', 'QC', '2024-07-05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c70d353-06e9-4a1d-830e-5eb73e827a91', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-05'),
('9c71550e-6fdc-4c3d-b620-ffc3756de959', 20, '1720106082219', '1', NULL, '5', '2024-07-04 09:38:42', '2024-07-04 09:44:42', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-07-04', 'C', 'DV', 'QC', '2024-07-05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c70d176-a3f0-4ac6-b799-734260c78ec3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-04'),
('9c7156cd-c4eb-4a4e-b8d4-bde51f829e05', 21, '1720106082219', '1', NULL, '5', '2024-07-04 09:43:35', '2024-07-04 09:44:42', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-07-04', 'C', 'DV', 'Pandu', '2024-07-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c70d176-a3f0-4ac6-b799-734260c78ec3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-04'),
('9c715733-644e-4eed-ad68-a173b786c010', 22, '1720106082219', '1', NULL, '5', '2024-07-04 09:44:42', '2024-07-04 09:44:42', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-07-04', 'C', 'DV', 'QC', '2024-07-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c70d176-a3f0-4ac6-b799-734260c78ec3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-04'),
('9c715733-6589-4585-bd16-028c72b10a4a', 23, '1720106082219', '1', NULL, '5', '2024-07-04 09:44:42', '2024-07-04 09:44:42', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-07-04', 'C', 'DV', 'QC', '2024-07-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c70d176-a3f0-4ac6-b799-734260c78ec3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-04'),
('9c71694e-8c9e-42a7-ad8f-a5f6961e5198', 24, '1720109119928', '2', NULL, '6', '2024-07-04 10:35:19', '2024-07-04 10:35:19', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-07-04', 'C', NULL, 'PANDU', '2024-07-05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c70d176-a74c-446e-848a-7189cc2bd2ce', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-04'),
('9c751a70-b6a0-4d46-9a7e-0c441535193b', 25, '1721116326609', '5', NULL, '8', '2024-07-06 12:08:07', '2024-07-16 07:52:06', '9c74eff3-9b29-411b-a901-76040bcd701b', '2024-07-10', 'C', 'DV', NULL, '2024-07-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c750f94-8d86-43ef-b4f4-a4acd9d25b97', NULL, '9c74e8bd-caef-40f5-a08e-b973810b68f9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-06'),
('9c751a70-b7c8-419d-a69d-3a81f3e106aa', 26, '1721116326609', '3', NULL, '8', '2024-07-06 12:08:07', '2024-07-16 07:52:06', '9c6f0797-04a4-402e-a187-593facfae847', '2024-07-09', 'C', 'DV', NULL, '2024-07-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c750f94-8d86-43ef-b4f4-a4acd9d25b97', NULL, '9c6ed7f6-7601-4ea9-8cb4-91701bfa0f3f', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-06'),
('9c751e32-3289-4c9c-a2f0-62e6b45994d8', 27, '1720268317128', '2', NULL, '8', '2024-07-06 12:18:37', '2024-07-06 12:18:37', '9c74f0d3-86d4-4bcf-a672-2ba75a6285a8', '2024-07-10', 'C', 'DV', 'PANDU', '2024-07-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c750f94-8de2-4e3a-ac0f-cabbb858c6ec', NULL, '9c74e944-af2a-4a49-814f-6ace7a493e20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-06'),
('9c751eac-82fb-4198-9c89-9eae3e20d149', 28, '1720268397288', '5', NULL, '8', '2024-07-06 12:19:57', '2024-07-06 12:19:57', '9c74ef1e-8745-4cea-8303-56e4fa5fe54e', '2024-07-08', 'C', 'DV', 'PANDU', '2024-07-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c750f94-8e20-4fee-98e7-7199ae3ac534', NULL, '9c74e813-af78-477f-bc2c-997fe5964398', NULL, NULL, NULL, '9c74e760-dcef-4d5f-9486-ec235f463f7d', NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-06'),
('9c85c6d9-f190-4490-9adf-adf328caaad1', 29, '1721827971955', '2', NULL, '9', '2024-07-14 19:03:27', '2024-07-24 13:32:51', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', '2024-07-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c83311c-3ae4-4414-a207-863be542ce30', '1', NULL, '2024-07-16', '2024-07-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-15'),
('9c86e666-7f0f-464b-9645-4d2484591e32', 30, '1721827971955', '2', NULL, '9', '2024-07-15 08:27:30', '2024-07-24 13:32:51', '9c6b636f-cf17-4d00-9012-f7404dcd3f1a', '2024-07-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c83311c-3ae4-4414-a207-863be542ce30', '1', NULL, '2024-07-17', '2024-07-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-16'),
('9c89104f-b3da-42d5-a6d0-a6cb173f5e1e', 31, '1721124981113', '1', NULL, '7', '2024-07-16 10:16:21', '2024-07-16 10:16:21', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c872234-8733-4da4-bf66-2d71c276efa2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-16'),
('9c89104f-b519-441d-a331-7552b543d30b', 32, '1721124981113', '1', NULL, '7', '2024-07-16 10:16:21', '2024-07-16 10:16:21', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c872234-8733-4da4-bf66-2d71c276efa2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-17'),
('9c89141a-8541-42b0-a76d-a38e3658b20b', 33, '1721127586969', '1', NULL, '12', '2024-07-16 10:26:57', '2024-07-16 10:59:47', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c872234-8733-4da4-bf66-2d71c276efa2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-16'),
('9c89141a-865a-4519-8600-f4d02c5b738b', 34, '1721127586969', '1', NULL, '12', '2024-07-16 10:26:57', '2024-07-16 10:59:47', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c872234-8733-4da4-bf66-2d71c276efa2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-17'),
('9c891627-bd2b-4169-850f-5b8a6f78c945', 35, '1721125961554', '1', NULL, '12', '2024-07-16 10:32:41', '2024-07-16 10:32:41', '9c6f0797-04a4-402e-a187-593facfae847', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c872234-87f8-49e8-8360-0874f314f005', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-18'),
('9c891627-bee3-4551-8f9e-6150b65478d1', 36, '1721125961554', '2', NULL, '12', '2024-07-16 10:32:41', '2024-07-16 10:32:41', '9c74eff3-9b29-411b-a901-76040bcd701b', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c872234-87f8-49e8-8360-0874f314f005', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-19'),
('9c8916c8-1f7a-4087-a65a-c03706a7f433', 37, '1721126066665', '2', NULL, '12', '2024-07-16 10:34:26', '2024-07-16 10:34:26', '9c6f0e5b-161c-4941-92e5-6b99b3f97b0c', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c872234-8896-4e0d-bdf6-bbcb7b4eb46b', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-10'),
('9c892915-414c-4ca7-b11a-e89eade4fae8', 40, '1721129173544', '2', NULL, '12', '2024-07-16 11:25:37', '2024-07-16 11:26:13', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c872234-891c-4198-bc23-bcab13fc78b3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-10'),
('9c89294c-dc7e-48fc-8654-28bad2cb30d8', 41, '1721129173544', '1', NULL, '12', '2024-07-16 11:26:13', '2024-07-16 11:26:13', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c872234-891c-4198-bc23-bcab13fc78b3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-11'),
('9c892b3c-18cd-43c3-b351-00785a20daea', 42, '1721474223180', '5', NULL, '12', '2024-07-16 11:31:38', '2024-07-20 11:17:03', '9c74ef1e-8745-4cea-8303-56e4fa5fe54e', '2024-07-13', 'C', NULL, NULL, '2024-07-20', '9c74ef1e-8745-4cea-8303-56e4fa5fe54e', NULL, NULL, NULL, NULL, NULL, NULL, '9c872234-899b-485f-94b5-b39aa4d82dac', NULL, '9c74e813-af78-477f-bc2c-997fe5964398', '2024-07-15', '2024-07-17', NULL, NULL, NULL, NULL, '2', '9c74e760-dcef-4d5f-9486-ec235f463f7d', NULL, NULL, '2024-07-11'),
('9c893c06-4417-4f4e-8529-6a261213b67e', 43, '1721474223180', '1', '2', '12', '2024-07-16 12:18:34', '2024-07-20 11:17:03', '9c74ef1e-8745-4cea-8303-56e4fa5fe54e', NULL, NULL, NULL, NULL, NULL, '9c74ef1e-8745-4cea-8303-56e4fa5fe54e', '2024-07-19', '2024-07-19', NULL, NULL, NULL, NULL, '9c872234-899b-485f-94b5-b39aa4d82dac', '2', NULL, '2024-07-17', '2024-07-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-17'),
('9c8af566-3be2-462b-b8a5-a8951d6864fd', 44, '1721206365344', '5', NULL, '11', '2024-07-17 08:52:45', '2024-07-17 08:52:45', '9c74ef1e-8745-4cea-8303-56e4fa5fe54e', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c88ed64-ec19-4337-8807-55e52b591530', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-17'),
('9c8af566-42d4-4fea-929a-c2eed2433d8a', 45, '1721206365344', '3', NULL, '11', '2024-07-17 08:52:45', '2024-07-17 08:52:45', '9c74ef1e-8745-4cea-8303-56e4fa5fe54e', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c88ed64-ec19-4337-8807-55e52b591530', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-17'),
('9c914492-3d37-4acd-b4ba-29d3754bfd08', 46, '1721477346254', '10', '10', '13', '2024-07-20 12:09:06', '2024-07-20 12:09:06', '9c74ef1e-8745-4cea-8303-56e4fa5fe54e', '2024-07-20', 'C', NULL, NULL, NULL, '9c910e93-c5ec-4d9b-8549-7c346d926c0b', NULL, NULL, NULL, NULL, NULL, NULL, '9c9115ac-5019-4fe2-8479-7270a6aa2779', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-18'),
('9c914699-bb12-4a12-b602-909db683c4e8', 47, '1721477686709', '10', NULL, '13', '2024-07-20 12:14:46', '2024-07-20 12:14:46', '9c74eff3-9b29-411b-a901-76040bcd701b', '2024-07-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9c9115ac-50a2-4d07-b69f-3027d4333f61', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-19');

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
  `other_details` text COLLATE utf8mb4_unicode_ci,
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
  `po_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_amount` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_amount` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version_date` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operator` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_excel_downloaded` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_register`
--

INSERT INTO `job_register` (`id`, `sr_no`, `metrix`, `estimate_id`, `client_id`, `client_contact_person_id`, `client_accountant_person_id`, `category`, `handled_by_id`, `created_by_id`, `other_details`, `type`, `protocol_data`, `date`, `description`, `protocol_no`, `status`, `cancel_reason`, `created_at`, `updated_at`, `estimate_document_id`, `bill_date`, `bill_no`, `informed_to`, `invoice_date`, `sent_date`, `delivery_date`, `old_job_no`, `site_specific`, `site_specific_path`, `payment_status`, `payment_date`, `po_number`, `bill_amount`, `paid_amount`, `version_date`, `version_no`, `operator`, `is_excel_downloaded`) VALUES
('9c3d49fc-4d6a-4465-898f-bba1a12f855b', 1, '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9c3cf7bf-39b1-4817-ab29-173f88624aac', '9c3c5487-381e-4789-bed0-142f5cbf8d90', '9c3c7d40-3211-40de-bb6b-83005d696fa0', '9c230458-53c7-422d-ad1e-a5bf5beebca1', '1', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9c3cf7bf-39b1-4817-ab29-173f88624aac', 'site-specific', NULL, '2024-07-04', 'Estimate_001', '1231235', 1, NULL, '2024-06-08 12:44:42', '2024-06-09 11:00:27', 'Estimate_001', NULL, NULL, '9c3c7d40-3211-40de-bb6b-83005d696fa0', NULL, NULL, '2024-06-09', '12323', '1', NULL, 'Paid', '2024-06-11', '1123213', NULL, NULL, NULL, NULL, NULL, 0),
('9c3f3599-3d6b-4ed6-aca5-85c16a050d8e', 2, NULL, '9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', '9c3c5487-381e-4789-bed0-142f5cbf8d90', '9c3c7d40-3211-40de-bb6b-83005d696fa0', '9c230458-53c7-422d-ad1e-a5bf5beebca1', '1', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9c3cf7bf-39b1-4817-ab29-173f88624aac,9c3eb083-bd94-4bb6-bc2e-1eba8b85588e', 'site-specific', NULL, '2024-07-04', NULL, '1231235', 1, NULL, '2024-06-09 11:39:21', '2024-06-29 10:51:32', 'Estimate 002', '2024-06-24', '123123', NULL, '2024-06-25', '2024-06-25', '2024-06-25', '1234', NULL, NULL, 'Paid', '2024-06-24', '1123213', NULL, NULL, NULL, NULL, NULL, 0),
('9c3f3de4-6c75-499a-b866-8a5e7b16a4cb', 3, NULL, '9c3eb083-bd94-4bb6-bc2e-1eba8b85588e', '9c3c5487-381e-4789-bed0-142f5cbf8d90', '9c3c7d40-3211-40de-bb6b-83005d696fa0', '9c230458-53c7-422d-ad1e-a5bf5beebca1', '1', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9c3cf7bf-39b1-4817-ab29-173f88624aac,9c3eb083-bd94-4bb6-bc2e-1eba8b85588e,9c3eddc6-73ef-4400-a79b-f3e4f39e0a24', NULL, NULL, '2024-07-04', 'Nothing', '1231235', 1, NULL, '2024-06-09 12:02:32', '2024-06-09 12:02:32', 'Nothing', NULL, NULL, NULL, NULL, NULL, NULL, '12323', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('9c6eda92-db1a-4808-8202-44454d781910', 4, NULL, '9c6b66b2-2dd7-4be5-98d2-ff6e6dd1a011', '9c6b53db-459e-4fc8-80c0-0e6ec3b7fad3', '9c6b546a-5e8b-4047-b9fa-1e0a500e3f51', '9c230458-53c7-422d-ad1e-a5bf5beebca1', '1', '9c6ed7f6-7601-4ea9-8cb4-91701bfa0f3f', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9c3eb083-bd94-4bb6-bc2e-1eba8b85588e', NULL, NULL, '2024-07-03', 'Main', 'NU-01-001', 1, NULL, '2024-07-03 04:04:33', '2024-07-15 11:55:41', 'Main Informed Consent Form_v1.1.0', '2024-07-20', '0931', NULL, '2024-07-20', '2024-07-20', '2024-07-18', '43', NULL, NULL, 'Paid', '2024-07-20', '-', '50000', '50000', NULL, NULL, NULL, 0),
('9c70d395-c05c-4253-a397-5b40e9c27634', 5, NULL, '9c70ce42-f706-480a-8e6e-5349790181ce', '9c6b53db-459e-4fc8-80c0-0e6ec3b7fad3', '9c6b54ac-7875-41db-b298-58f1f611f710', '9c230458-53c7-422d-ad1e-a5bf5beebca1', '1', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9c6b66b2-2dd7-4be5-98d2-ff6e6dd1a011', NULL, NULL, '2024-07-07', NULL, 'NU-01-002', 2, 'on hold', '2024-07-04 03:36:40', '2024-07-15 11:57:28', 'Secondary Informed Consent', '2024-07-15', '0042', NULL, NULL, '2024-07-15', NULL, NULL, NULL, NULL, 'Partial', '2024-07-16', NULL, '75000', '50000', NULL, NULL, NULL, 0),
('9c716301-b359-453e-a928-e08ae914cab9', 6, NULL, '9c70ce42-f706-480a-8e6e-5349790181ce', '9c6b53db-459e-4fc8-80c0-0e6ec3b7fad3', '9c6b54ac-7875-41db-b298-58f1f611f710', '9c230458-53c7-422d-ad1e-a5bf5beebca1', '1', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9c3cf7bf-39b1-4817-ab29-173f88624aac', NULL, NULL, '2024-07-04', 'Secondary Informed Consent 2', '2342', 0, NULL, '2024-07-04 10:17:42', '2024-07-18 05:23:34', 'Secondary Informed Consent 2', '2024-07-10', '0052', NULL, NULL, '2024-07-10', NULL, NULL, NULL, NULL, 'Partial', '2024-07-11', NULL, '120000', '70000', NULL, NULL, NULL, 0),
('9c7500ba-10e0-4361-87ea-c09efa4d7785', 7, NULL, '9c74f676-68d6-4e3f-b36b-7381aa046fac', '9c74e9a5-e681-4293-9295-ba6b0388648a', '9c74eb51-fc1e-4ff4-b935-19661f3aff7c', '9c74e60c-bdf9-4000-8ddf-24bc75c0f09d', '1', '9c74e70f-934a-4577-a63f-e39b0798fb00', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9c3eb083-bd94-4bb6-bc2e-1eba8b85588e', NULL, NULL, '2024-07-19', 'Lama', 'D9098788988', 0, NULL, '2024-07-06 10:56:13', '2024-07-18 05:25:00', 'Lama', '2024-07-10', '5231', NULL, NULL, '2024-07-10', NULL, NULL, NULL, NULL, 'Paid', '2024-07-17', NULL, '140500', '140500', NULL, NULL, NULL, 0),
('9c750fea-7167-49e2-8b19-bbe2f9bc59e4', 8, NULL, '9c750f94-8bfd-43ec-9dc4-bdfb503bfa97', '9c74e9a5-e681-4293-9295-ba6b0388648a', '9c74eb51-fc1e-4ff4-b935-19661f3aff7c', '9c74e60c-bdf9-4000-8ddf-24bc75c0f09d', '1', '9c74e70f-934a-4577-a63f-e39b0798fb00', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c3eb083-bd94-4bb6-bc2e-1eba8b85588e', 'site-specific', NULL, '2024-07-10', NULL, '234', 1, NULL, '2024-07-06 11:38:41', '2024-07-18 05:26:02', 'doc1', '2024-07-09', '4567', NULL, NULL, '2024-07-16', '2024-07-06', '876', NULL, NULL, 'Partial', '2024-07-16', NULL, '90000', '50000', NULL, NULL, NULL, 0),
('9c85750d-e8c4-49c0-bd09-4dcaa459829a', 9, NULL, '9c83311c-35d4-4e30-bed3-93d232292f6d', '9bc17857-0f6a-40d4-a9d9-87407d1a88b1', '9c1ed3f2-9103-4589-8771-81cc550eeb0d', '9c0c9a65-6d41-4d2d-bd53-9621c793b5f4', '1', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9c73b245-bb2a-48e3-81db-5eee86932412', NULL, 'new', NULL, '2024-07-14', NULL, NULL, 0, NULL, '2024-07-14 15:14:44', '2024-07-18 05:27:51', '12331', '2024-07-16', '1422', NULL, NULL, '2024-07-17', NULL, '', NULL, NULL, 'Unpaid', NULL, NULL, '130000', NULL, NULL, NULL, NULL, 0),
('9c88f3b1-410a-47c0-ad72-22b6632dbac2', 10, NULL, '9c88ed64-e465-410d-8946-4d5406d79bbd', '9c74e9a5-e681-4293-9295-ba6b0388648a', '9c74eb51-fc1e-4ff4-b935-19661f3aff7c', '9c74e60c-bdf9-4000-8ddf-24bc75c0f09d', '2', '9c74e70f-934a-4577-a63f-e39b0798fb00', '9c73b245-bb2a-48e3-81db-5eee86932412', NULL, NULL, NULL, '2024-07-20', 'IN CLINIC POSTER', NULL, 0, NULL, '2024-07-16 08:56:19', '2024-07-16 08:56:19', 'IN CLINIC POSTER', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '210000', NULL, NULL, NULL, NULL, 0),
('9c8907d2-3d35-4221-aed9-1483cb3bcc2f', 11, NULL, '9c88ed64-e465-410d-8946-4d5406d79bbd', '9c74e9a5-e681-4293-9295-ba6b0388648a', '9c74eb51-fc1e-4ff4-b935-19661f3aff7c', '9c74e60c-bdf9-4000-8ddf-24bc75c0f09d', '2', '9c74e70f-934a-4577-a63f-e39b0798fb00', '9c73b245-bb2a-48e3-81db-5eee86932412', NULL, NULL, NULL, '2024-07-20', NULL, 'D5982C00001', 0, NULL, '2024-07-16 09:52:36', '2024-07-20 11:44:17', 'Lama', '2024-07-17', '7453', NULL, NULL, '2024-07-18', NULL, '', NULL, NULL, 'Partial', '2024-07-17', NULL, '271005', '100000', '2024-06-22', '1.0', NULL, 0),
('9c890fd1-d8c5-42a2-bfaf-2bfb2bbe0dae', 12, NULL, '9c872234-8071-46d6-95af-cc9dcd0ce341', '9c74e9a5-e681-4293-9295-ba6b0388648a', '9c74eb51-fc1e-4ff4-b935-19661f3aff7c', '9c74e60c-bdf9-4000-8ddf-24bc75c0f09d', '1', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9c73b245-bb2a-48e3-81db-5eee86932412', NULL, 'site-specific', NULL, '2024-07-20', NULL, NULL, 1, NULL, '2024-07-16 10:14:58', '2024-07-20 11:57:58', 'Lama', '2024-07-20', '12456', NULL, NULL, '2024-07-22', NULL, '', NULL, NULL, 'Paid', '2024-07-25', NULL, '200000', '200000', '2024-07-16', '1.1', 'Yes', 0),
('9c911cdd-eee0-4f3e-a33f-468cdadb62f7', 13, NULL, '9c9115ac-48df-4b0b-96f2-8c03df090bdc', '9c9112d5-5d96-456d-b60e-edd15b0c24e5', '9c911339-97e8-42d4-9ac9-294d4865ff34', '9c74ebeb-0482-4f69-ae18-15d7b98e5ab9', '1', '9c74e70f-934a-4577-a63f-e39b0798fb00', '9c910dcc-d591-4db5-b30c-e407a3f039e7', '9c3eb083-bd94-4bb6-bc2e-1eba8b85588e,9c6b66b2-2dd7-4be5-98d2-ff6e6dd1a011,9c74f676-68d6-4e3f-b36b-7381aa046fac', 'site-specific', NULL, '2024-07-22', NULL, 'D9856C00001', 0, NULL, '2024-07-20 10:18:04', '2024-07-24 09:18:43', 'MAin ICD', NULL, NULL, NULL, NULL, NULL, NULL, '43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

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
('9be697f2-6a98-440d-989f-ccc1cec89186', 3, 'English', 'ENG', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, NULL, '2024-07-16 10:25:40', '2024-04-26 10:25:40'),
('9c14bb75-32a9-47b9-b6ed-ec29944e78f9', 4, 'Urdu', 'URD', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, NULL, '2024-07-12 08:53:02', '2024-05-19 08:53:02'),
('9c14bb75-32a9-47b9-b6ed-ec29944e78f1', 5, 'Marathi', 'MAR', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, NULL, '2024-07-02 08:53:00', '2024-05-19 08:53:02'),
('9c14bb75-32a9-47b9-b6ed-ec29944e78f2', 6, 'Gujrati', 'GUJ', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, NULL, '2024-07-03 08:53:02', '2024-05-19 08:53:02'),
('9c14bb75-32a9-47b9-b6ed-ec29944e7810', 7, 'Tamil', 'TAM', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9c73b245-bb2a-48e3-81db-5eee86932412', 1, NULL, '2024-07-04 08:53:02', '2024-07-16 08:40:08'),
('9c6b62bf-02ad-40f8-aad9-631fbc8a7455', 8, 'Hindi', 'HIN', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, NULL, '2024-07-01 10:42:01', '2024-07-01 10:42:01'),
('9c74e7d1-43ec-4c68-a385-acbaee286b0d', 9, 'Assamese', 'ASM', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', 1, NULL, '2024-07-09 09:46:33', '2024-07-06 09:46:33'),
('9c74e7f1-5425-41dc-9c20-7cbec90908a1', 10, 'Malayalam', 'MAL', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', 1, NULL, '2024-07-07 09:46:54', '2024-07-06 09:46:54'),
('9c74e81d-3c13-4d00-8c36-dc2653c34777', 11, 'Punjabi', 'PUN', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', 1, NULL, '2024-07-11 09:47:23', '2024-07-06 09:47:23'),
('9c74e83d-f4cd-4afe-aee1-49c9d26f2811', 12, 'Oriya', 'ORI', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', 1, NULL, '2024-07-08 09:47:45', '2024-07-06 09:47:45'),
('9c74e859-39af-4e4d-9e6e-adf1e787d1b6', 13, 'Kannada', 'KAN', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', 1, NULL, '2024-07-06 09:48:03', '2024-07-06 09:48:03'),
('9c74e87a-bd76-4ea3-9e6a-1153d47a6531', 14, 'Bengali', 'BAN', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', 1, NULL, '2024-07-10 09:48:24', '2024-07-06 09:48:24'),
('9c74e8c5-d5c6-42ff-808e-12ccd5889ba4', 15, 'Telugu', 'TEL', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', 1, NULL, '2024-07-04 18:30:00', '2024-07-06 09:49:14');

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
(59, '2024_06_08_064243_add_accountant_in_client', 22),
(60, '2024_06_23_004720_add_column_verification_2_in_language_map', 23),
(61, '2024_06_23_004720_add_column_total_amount_in_writer_payment', 24);

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
(9, '9c230458-53c7-422d-ad1e-a5bf5beebca1', 3, NULL, NULL),
(11, '9bea89ed-8044-49d8-8275-f3269a1dfd23', 2, NULL, NULL),
(13, '9c73b245-bb2a-48e3-81db-5eee86932412', 1, NULL, NULL),
(14, '9c74e60c-bdf9-4000-8ddf-24bc75c0f09d', 3, NULL, NULL),
(17, '9c74e760-dcef-4d5f-9486-ec235f463f7d', 6, NULL, NULL),
(18, '9c74e813-af78-477f-bc2c-997fe5964398', 6, NULL, NULL),
(19, '9c74e85c-a404-4ed2-9f91-d2780219ff85', 6, NULL, NULL),
(20, '9c74e8bd-caef-40f5-a08e-b973810b68f9', 6, NULL, NULL),
(21, '9c74e944-af2a-4a49-814f-6ace7a493e20', 6, NULL, NULL),
(22, '9c74e9ed-1e37-424b-a4ea-5ea90d5aefd5', 6, NULL, NULL),
(23, '9c74eabd-5137-4ef3-8f16-bf0cfca18119', 5, NULL, NULL),
(24, '9c74eb56-8d8f-4812-ae28-dced95fc1970', 3, NULL, NULL),
(27, '9c74ee75-416f-4f85-9b4d-729882668f1e', 3, NULL, NULL),
(29, '9c6ed7f6-7601-4ea9-8cb4-91701bfa0f3f', 1, NULL, NULL),
(30, '9c910dcc-d591-4db5-b30c-e407a3f039e7', 2, NULL, NULL),
(31, '9c74e70f-934a-4577-a63f-e39b0798fb00', 5, NULL, NULL),
(32, '9c74ebeb-0482-4f69-ae18-15d7b98e5ab9', 3, NULL, NULL),
(33, '9c74e6b0-73c8-4211-bf64-b7ed8fc4893b', 2, NULL, NULL);

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
('9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, 'Dev', 'developer@kesen.com', '$2y$12$Gkl6UiIlDDdEZyrfoXWKiOQ6dKxf7m1Jt9jNcvBzCFvhclbdGOBAW', '7897979878', 'Dev', NULL, 'Mumbra', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, NULL, 'IR7DO84kV4LWGwk1TVSXfsQckfzW6dp3KKDlTke9vwO9nbjraQtGcl9D4Sru', '2024-04-21 16:50:21', '2024-04-21 16:50:21', NULL),
('9bea89ed-8044-49d8-8275-f3269a1dfd23', 2, 'Kesan Admin', 'admin@kesen.com', '$2y$12$MU8MJ8Fp6WB7hK997zEhj.AzN77BFx5wS6HDctitInw2.jLWXDODC', '07897987982', 'admin', NULL, 'test\r\ntest', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, '9be697f2-6a98-440d-989f-ccc1cec89186', '39wQu8kIs8IdGNoYPzOD5EhyVOfESnDtn2aF0lUuHNptNjrfWG97SY75z4yK', '2024-04-28 09:29:46', '2024-07-01 09:07:39', 'eyJpdiI6ImU4WEpxZjhKYzVkL1pvSUIzUkhRcGc9PSIsInZhbHVlIjoiWTFJV0lZa0NvL1hQS2JzMVJDMDVyUT09IiwibWFjIjoiMzQwODhmODExMjg2N2Q5MjA1ZDgzOGQxMWJhNDk1Nzc0NDg4YjViZDliZmE0ZDE3MTYwMzg0NzIyZmEyZDI1YyIsInRhZyI6IiJ9'),
('9c0c9a65-6d41-4d2d-bd53-9621c793b5f4', 3, 'goyahi adstam', 'goyahi6237@adstam.com', '$2y$12$H9Y0H2IqqhtLc/XXSblUfumVhWEpzJt6mwVrj3.sgGwws8fIUh0Y2', '078979879822', 'EMP002', '078979879821', 'test\r\ntest', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, '9be697f2-6a98-440d-989f-ccc1cec89186', NULL, '2024-05-15 07:53:58', '2024-05-15 07:53:58', 'eyJpdiI6IkxoaW0yQ3QvNDM2OFJjZHU1OFpwbUE9PSIsInZhbHVlIjoiY2ZlYUxtMXdKbHluRGF2NWZ6UFNqQnB3ZFV4dHZtcmUxeXhPK0NVNnB0Yz0iLCJtYWMiOiIyZjJhYWFmZTJjYTg4Y2Y2MDkyNjljMzUxNmU0OTM0OGFkZTZkMjFkNzZhNjBlYzk1NTA4YWQyMWQ0OTQyZjk5IiwidGFnIjoiIn0='),
('9c230458-53c7-422d-ad1e-a5bf5beebca1', 4, 'Hamza', 'hamza@kesan.com', '$2y$12$MRMYmB5YJ2sVUlH60GzQMeQlR79be8aRU6BM7GqW2/SsgGwYt4S9O', '07897987983', 'HM001', NULL, 'test\r\ntest', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 1, '9be697f2-6a98-440d-989f-ccc1cec89186', '8EpSJuGKePKMpEaY4qbo7wSOXfjqkceWKlR7yCLl0QG8mvjJrsl8wqvKN1gh', '2024-05-26 11:18:26', '2024-06-09 01:12:31', 'eyJpdiI6Imx3QVlhM2NwU04zYUJYOERiMTlwUGc9PSIsInZhbHVlIjoid0MvcHNRb2ZHeDBJLysyZmZqKzRodz09IiwibWFjIjoiYjA3MmYyNTQxNDliMDc4NmJlYTQ0NDZlNTUzNDUyMjg5MjA4NzQyZGI0MjIzYjhjYjU1YjQwY2Q4NDYzZmJkNyIsInRhZyI6IiJ9'),
('9c6ed7f6-7601-4ea9-8cb4-91701bfa0f3f', 5, 'Kalam Shaikh', 'kalam@kesen.com', '$2y$12$hqbydin3O3VBkPw3Lj9He.7K8lhbm.w.A5PBQW.qFehCWQDWjeZey', '7876545654', 'KAL', NULL, 'Mumbai', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bea89ed-8044-49d8-8275-f3269a1dfd23', 1, '9be697f2-6a98-440d-989f-ccc1cec89186', NULL, '2024-07-03 03:57:15', '2024-07-06 10:52:58', 'eyJpdiI6IlVHNFBjSWl2b05Eb1A1SEU0YXZHK0E9PSIsInZhbHVlIjoiOFlsMlpLZFJOWWwxQ2wybUUyQytVZz09IiwibWFjIjoiOTE2YTc3MTRlMWEzZDVhOTY1ZTE0NGE5YTA1NDI5MDg4MTc0NzRmMDQ3NDQxNDJhOGE1NGNjYzJhYmE5NjU1MSIsInRhZyI6IiJ9'),
('9c73b245-bb2a-48e3-81db-5eee86932412', 6, 'Kesen', 'kesen@kesen.in', '$2y$12$ZCxKdXorXdISUqMJC6H..eHtoU1TtiI7Fth21jZdB3pOCUoc/SSGW', '8787654321', 'CEO', NULL, 'mumbai', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', 1, '9be697f2-6a98-440d-989f-ccc1cec89186', 'CP9p6YV41udeduXID1yS21QF0PB5lFPqpftnDIb2nuDXLHomDEOX2LIqint8', '2024-07-05 19:21:00', '2024-07-05 19:21:00', 'eyJpdiI6ImY4MU5TdTdUamJCNExWQ2owQVhiUnc9PSIsInZhbHVlIjoicEh5ZkhlZjAwaGVyYkh5VTZ3Q2hLQT09IiwibWFjIjoiZjkyNDViNTU1ZDkzZDY2OGQzYTFkMmUwOGIwNjYxMWE4N2QyZWExMDFjZjMxMjBjNWQwODc1N2Y0MTNhNjRmYiIsInRhZyI6IiJ9'),
('9c74e60c-bdf9-4000-8ddf-24bc75c0f09d', 7, 'Mamta Naik', 'mamtanaik1410@gmail.com', '$2y$12$8wk/1Dhzh.eZyqgRm5tRa.t0xHUrD143Ctka/uZZKFdYMKtGo6m.O', '9876566765', 'MAM', NULL, 'Dadar', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', 1, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', NULL, '2024-07-06 09:41:37', '2024-07-06 09:41:37', 'eyJpdiI6IjBLeHRsOFN1YTJoQWwrcVV1Q3R6OXc9PSIsInZhbHVlIjoibk5SNlpnNjNDSkhmYnNTUzR0bkJKUT09IiwibWFjIjoiNmU5N2E4MzY3YzQ4NDE4N2UwNzlmNzJmZTJiYTZkMGVkZTNkOTM5ODM4Y2JmZWEwZGRkMjM4NGI3YzMwYmMzMiIsInRhZyI6IiJ9'),
('9c74e6b0-73c8-4211-bf64-b7ed8fc4893b', 8, 'Shanti Pillai', 'shantipillai@gmail.com', '$2y$12$5NixoWBkKNpZa/YOIZmoF.mt99akPCik117HTLRTf.toK2esLlqcy', '9839876765', 'SHA', NULL, 'Kalyan', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9c73b245-bb2a-48e3-81db-5eee86932412', 1, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', NULL, '2024-07-06 09:43:24', '2024-07-22 13:27:16', 'eyJpdiI6ImNUdzYzRytqMEkxblZpUkVFbnZtUlE9PSIsInZhbHVlIjoiRDNMTkdpd2x0bVlHVEkzMk9jekU1Zz09IiwibWFjIjoiNjk3OTUwY2U2NzdmOGJmZTZmNDBkMTE5OTU4MmQ2OTg0Yjg0YWNmNDRkNTNkYzEwZDNlMDkzZjY4MWFmYzZiMSIsInRhZyI6IiJ9'),
('9c74e70f-934a-4577-a63f-e39b0798fb00', 9, 'Madhu Yata', 'madhu@gmail.com', '$2y$12$sJqjt5DXHwJgqs6Z3gSHO.uuRBYV9evinqed4YRvg4FrbIzX8W2h6', '98767655455', 'MAD', NULL, 'Panvel', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9c910dcc-d591-4db5-b30c-e407a3f039e7', 1, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', NULL, '2024-07-06 09:44:26', '2024-07-20 10:39:22', 'eyJpdiI6ImYvWEpuRjJ0Y0todHpqTG5YMEpzdkE9PSIsInZhbHVlIjoiOG4wd2JwZUFGaTRrSGdmKzc1LzVsZz09IiwibWFjIjoiNjIwYWY0NTVhODhkYjcwMjRkODFkNzAxYTlhZDBlMTljZmRlMDc3MTNhMTZhM2Q3NWJlYmRjNmNmYTkzMDY0YyIsInRhZyI6IiJ9'),
('9c74e760-dcef-4d5f-9486-ec235f463f7d', 10, 'Aashika Thakkkar', 'aashika@gmail.com', '$2y$12$gbD0UU5yBCek8mxdX/slWOdehH.vAYGWHDTEje5uD9sQYZ8MKrLsC', '8976765456', 'ASK', NULL, 'GHatkopar', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', 1, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', NULL, '2024-07-06 09:45:20', '2024-07-06 09:45:20', 'eyJpdiI6InE3bml3TUhqdU9aZXgwUSs5YkhyV1E9PSIsInZhbHVlIjoic0o4K2VISUxsYjBqaXRkeXlBN3dGdz09IiwibWFjIjoiZjEzOTRhMDMxMjMzOWNlZTUxMDQ2ZWExNWM5OGYxN2ZkZDZmMTg2OTIxNTc0MTBjYWJkZTNhNDVkMTY2NGE2ZSIsInRhZyI6IiJ9'),
('9c74e813-af78-477f-bc2c-997fe5964398', 11, 'Neeraj Sharma', 'neeraj@gmail.com', '$2y$12$JTbJCQAt7/c14598HdYgD.FGBIDiiSwj3AuGibQvbJHSnzUT9I06.', '9898767876', 'NER', NULL, 'Virar', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', 1, '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', NULL, '2024-07-06 09:47:17', '2024-07-06 09:47:17', 'eyJpdiI6IlhzM29VdktacFVmNnJRVGtMeUZtS1E9PSIsInZhbHVlIjoiTzlveWFjNC9WM3FKUVA2TzErTlpwQT09IiwibWFjIjoiYTlkNTY2MjBjMjVkNjYwZTBkNWE5YWQyZDM5NWZhN2Y0MDAzNTc1ODA4NmU5MjQ2ODE5NTQ5ZjI4OTRlZTRkZCIsInRhZyI6IiJ9'),
('9c74e85c-a404-4ed2-9f91-d2780219ff85', 12, 'Amruta Salukhen', 'amruta@gmail.com', '$2y$12$ysSjXctzqW9ZY3GSB8gPrOdFKWuyGrYJZLAuw5jEhblWGvo4x4fAm', '7876567876', 'AMR', NULL, 'Dadar', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', 1, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', NULL, '2024-07-06 09:48:05', '2024-07-06 09:48:05', 'eyJpdiI6IkpXV25HZTVXVU5VSGY0UncyU2hrUnc9PSIsInZhbHVlIjoiSitDSTBqdWZhUG5pMDJkQnpYanpCUT09IiwibWFjIjoiYWFjNzFjYWQ5ZmYyZDcyNGNkM2RlNzFiM2E5NzQ3ZjcxNzc2ZjY3MTZiOGNhNDIzMDI1NGVkNDg0YWVjMzRkMiIsInRhZyI6IiJ9'),
('9c74e8bd-caef-40f5-a08e-b973810b68f9', 13, 'Omkar Marathe', 'omkar@gmail.com', '$2y$12$EVU6LfKb/N6RtECYYDSdoOMKlWPUt4qG81bzFHJxFWjlEvHO7pbzG', '8787656786', 'OMI', NULL, 'Dombivali', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', 1, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', NULL, '2024-07-06 09:49:08', '2024-07-06 09:49:08', 'eyJpdiI6IjZQbHkwVUEvSUppVGt3cHRWeUk3Qnc9PSIsInZhbHVlIjoiOURmb3RYcDlkY1lqWkRsOHF6cFRKZz09IiwibWFjIjoiZDQ0ODJjYWViZTI2OWI5MmRlYzE3ZTIzYThhNmQ1ZDAzNzE4YzllYTBjMTA3NmY5NDM0NTU3MjAzMGY3MDg3YSIsInRhZyI6IiJ9'),
('9c74e944-af2a-4a49-814f-6ace7a493e20', 14, 'Priya Bhanushali', 'priya@gmail.com', '$2y$12$jn8OHxA.RIXDjhSeiuuX.eQbYfvKXKqe/DcS0YkrATmU39ADjH882', '87876567889', 'PRI', NULL, 'Dombivali', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', 1, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', NULL, '2024-07-06 09:50:37', '2024-07-06 09:50:37', 'eyJpdiI6IndnYityV3FkK0FDaWJlaWt1NU5nTEE9PSIsInZhbHVlIjoiM3NOSEVrK1dpUlExakcrRC9UY3YyQT09IiwibWFjIjoiODFkMjA3ZDE4ZTlmNDk4YTgxZGZlZTMzZmM5M2FiNjNlOWUwMDM0NjQ1NDdlOGI0YmU2NmI5OTA1ZWYyZjcxNyIsInRhZyI6IiJ9'),
('9c74e9ed-1e37-424b-a4ea-5ea90d5aefd5', 15, 'Shraddha Mange', 'shraddha@gmail.com', '$2y$12$uNpt8BXBcaGTDw098mF9I.MlqCbl3EtvNh5WNh5Qq9ThINOmJD8bW', '7876567687', 'SHM', NULL, 'Ghatkopar', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', 1, '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', NULL, '2024-07-06 09:52:27', '2024-07-20 09:52:12', 'eyJpdiI6Imp6dTJvZVIxK3ZnenE1QXFzekcwdFE9PSIsInZhbHVlIjoiWFZxcVhMbE5oMEJmWTRMU0EvK1JrQT09IiwibWFjIjoiZjhlZTM5MzZmMWJiZmMzMDNiYWEyMzBiMzcyZDM1ZTkyOTcyZjZhODQ3NGVmNzA1MTM1NTYyOGMzODM5NjM5YSIsInRhZyI6IiJ9'),
('9c74eabd-5137-4ef3-8f16-bf0cfca18119', 16, 'Milind Chaubal', 'milind@gmail.com', '$2y$12$WFav.R5HVDWaqUwoCZ9WDOrl.qHxNKCuNEbRMDjav3v/04X465xkO', '8787656787', 'MIL', NULL, 'Borivali', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', 1, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', NULL, '2024-07-06 09:54:44', '2024-07-06 09:54:44', 'eyJpdiI6InUwN1NpMCtlUE5PY0dlYWdOV3lOcmc9PSIsInZhbHVlIjoiRE9mSTI5SVowUzAvQXIxR2cwYWJhZz09IiwibWFjIjoiY2YwMmJhNDkzMzU4MWE3YjNhMmU1ZTBlMTliYTllYzE3MWM4ZmEzMGIzYzk1ODczMDJkMDg1MjVhMDY1MzRjYSIsInRhZyI6IiJ9'),
('9c74eb56-8d8f-4812-ae28-dced95fc1970', 17, 'Vanitha Karkera', 'vanithaganeshk@gmail.com', '$2y$12$zhl1CpNV8zfi9ha2l9KKiejPQNPv3VEjYUALb64fZxdWPZ57Ch78y', '9898767800', 'VAN', NULL, 'Bhandup', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', 1, '9c14bb75-32a9-47b9-b6ed-ec29944e7810', NULL, '2024-07-06 09:56:24', '2024-07-06 09:56:24', 'eyJpdiI6Im0zUk9wcDJ0OTRpOFBZUUhRODVWWHc9PSIsInZhbHVlIjoiU1l1YmdHTDI3eUJTTWloT0hUWU1Rdz09IiwibWFjIjoiMTllOWVmYTIwNDQ4ZTkwZTUyNDBlNTQwMzQ4ODkzYjIwODEyY2QzMTIwZTAzYjIzMzBlMTA0NTZkM2FjYTY2YyIsInRhZyI6IiJ9'),
('9c74ebeb-0482-4f69-ae18-15d7b98e5ab9', 18, 'Sudha David', 'sudhajustindavid@gmail.com', '$2y$12$W7nzp1tOyLwpF7WvSnG2SOg.9QrhKRZp/pYt1huULZehk4hFztE3G', '98787667658', 'SUD', NULL, 'Kalyan', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9c73b245-bb2a-48e3-81db-5eee86932412', 1, '9c74e7f1-5425-41dc-9c20-7cbec90908a1', NULL, '2024-07-06 09:58:01', '2024-07-20 11:54:48', 'eyJpdiI6IjVXMHQ1NUUwUTRYbDBHMnlhRTIzVUE9PSIsInZhbHVlIjoiUDRndjErdzV5WHdKSG05RVFtRW9ZUT09IiwibWFjIjoiZjRmNmZjNTUxNWNlZTFiNmY5MjA0YmRhNmMyMjBkZGZkZmMxM2I0ZmMzNWE0OGE0YWVmMmY5MmU5NDUwMDUwOSIsInRhZyI6IiJ9'),
('9c74ee75-416f-4f85-9b4d-729882668f1e', 19, 'Mansi Naik', 'naikmansi1710@gmail.com', '$2y$12$eyGvOKtl27P7CrX6U/paA.3S1uZb3/jbt4.NefOhZSx7ykYao.M8.', '9878987656', 'MAN', NULL, 'Kalyan', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', 1, '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', NULL, '2024-07-06 10:05:08', '2024-07-06 10:05:08', 'eyJpdiI6IlMvT1pwTndOYmZTeEpoeWx3bndjT0E9PSIsInZhbHVlIjoiemtNMWIwMk00cWJ4MVRTUG1iRDBrdz09IiwibWFjIjoiZmQxZDg0MGRjNmQ1ZDkzMGI4MDM5NWM3N2JhMTNkYzBiY2NjNGUzN2JjYjM3MjgxYWViMzE4NmVkYzY2ZmFiYiIsInRhZyI6IiJ9'),
('9c910dcc-d591-4db5-b30c-e407a3f039e7', 20, 'Ritesh Jadhav', 'riteshpjadhav8805@gmail.com', '$2y$12$ziEJdviXVd8ePslXbx1da.DJp3o/M8dNXO7l3Y8N6qP8HdojOAk4u', '8082265062', 'RIT', NULL, 'Bhandup', '9c73b245-bb2a-48e3-81db-5eee86932412', '9c73b245-bb2a-48e3-81db-5eee86932412', 1, '9be697f2-6a98-440d-989f-ccc1cec89186', NULL, '2024-07-20 09:35:57', '2024-07-20 09:35:57', 'eyJpdiI6Im1Ga2IwYnNzN3FDVGVoOG9MbmYrd3c9PSIsInZhbHVlIjoiSmUzUmRJZ0NZYzF0eWJobHBMNDR6QT09IiwibWFjIjoiZThiNmVmNzExNjljM2E4MzZjMDJjNDAzNGEwOTMzOTFlOTRiNGVlNzRhYWVmOGExM2ZmMWFlYTQ5OWIwYWVlMiIsInRhZyI6IiJ9');

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
('9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', 1, 'Obaid', 'goyahi6237@adstam.com', 'test\r\ntest', 'OBD', '07897987982', NULL, 1, '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '2024-05-01 09:55:12', '2024-06-08 20:43:07'),
('9c6b636f-cf17-4d00-9012-f7404dcd3f1a', 2, 'John Kurian', 'john@test.com', 'Pune', 'JOH', '6565765676', NULL, 1, '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '2024-07-01 10:43:57', '2024-07-01 10:43:57'),
('9c6f0797-04a4-402e-a187-593facfae847', 3, 'Manish', 'manish@test.com', 'Thane', 'MAN', '8765434543', NULL, 1, '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '2024-07-03 06:10:26', '2024-07-03 06:10:26'),
('9c6f0e5b-161c-4941-92e5-6b99b3f97b0c', 4, 'Jethalaal', 'jethalaal@test.com', 'Gujrat', 'JET', '7656787654', NULL, 1, '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', '2024-07-03 06:29:21', '2024-07-14 13:33:07'),
('9c74ef1e-8745-4cea-8303-56e4fa5fe54e', 5, 'Virender Singh', 'kesen@kesen.in', 'UP', 'VIR', '8779224776', NULL, 1, '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9c73b245-bb2a-48e3-81db-5eee86932412', '2024-07-06 10:06:58', '2024-07-17 09:21:27'),
('9c74eff3-9b29-411b-a901-76040bcd701b', 6, 'Snehal Mahajan', 'test@gmail.com', 'Mulund', 'SNM', '9878987656', NULL, 1, '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '2024-07-06 10:09:18', '2024-07-06 10:09:18'),
('9c74f0d3-86d4-4bcf-a672-2ba75a6285a8', 7, 'Kalpesh Shah', 'angelamitra2019@gmail.com', 'Surat, Gujarat', 'KLS', '987876567877', NULL, 1, '9bea89ed-8044-49d8-8275-f3269a1dfd23', '9bea89ed-8044-49d8-8275-f3269a1dfd23', '2024-07-06 10:11:45', '2024-07-06 10:11:45'),
('9c910e93-c5ec-4d9b-8549-7c346d926c0b', 8, 'Arun Singh', 'test@test.com', 'Mumbai', 'ARS', '8765676543', NULL, 1, '9c910dcc-d591-4db5-b30c-e407a3f039e7', '9c910dcc-d591-4db5-b30c-e407a3f039e7', '2024-07-20 09:38:07', '2024-07-20 09:38:07');

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `verification_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `writer_language_maps`
--

INSERT INTO `writer_language_maps` (`id`, `language_id`, `writer_id`, `per_unit_charges`, `checking_charges`, `bt_charges`, `bt_checking_charges`, `advertising_charges`, `created_at`, `updated_at`, `verification_2`) VALUES
('3', '9be697f2-6a98-440d-989f-ccc1cec89186', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', 12, 10, 12, 12, 21, '2024-05-02 11:42:23', '2024-06-22 19:18:18', '12'),
('9c27a8db-3b0b-4761-94c2-52756aaf925d', '9c14bb75-32a9-47b9-b6ed-ec29944e78f9', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', 12, 10, 12, 12, 21, '2024-05-28 18:41:45', '2024-06-29 00:51:26', '10'),
('9c6689f0-7ca4-4c54-bc51-2b317689aec6', '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', 12, 10, 12, 12, 21, '2024-06-29 00:52:28', '2024-06-29 00:52:28', '12'),
('9c668a04-5bf6-4e81-8a5a-c655c59ff1f1', '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', 12, 10, 12, 12, 21, '2024-06-29 00:52:41', '2024-06-29 00:52:41', '10'),
('9c668a1f-dc3d-40b0-b805-021cfea4ae9b', '9c14bb75-32a9-47b9-b6ed-ec29944e7810', '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', 15, 10, 12, 12, 21, '2024-06-29 00:52:59', '2024-06-29 00:52:59', '12'),
('9c6b6c61-f945-400a-b230-d708202fe9bc', '9be697f2-6a98-440d-989f-ccc1cec89186', '9c6b636f-cf17-4d00-9012-f7404dcd3f1a', 45, 20, 45, 20, 45, '2024-07-01 11:08:57', '2024-07-01 11:08:57', '20'),
('9c6f083c-1801-435c-9731-e35fdd1e7c1a', '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '9c6f0797-04a4-402e-a187-593facfae847', 40, 26, 50, 26, 47, '2024-07-03 06:12:14', '2024-07-03 06:12:14', '26'),
('9c6f0e8b-5551-4efc-9cbf-0a9537a7c6e7', '9c14bb75-32a9-47b9-b6ed-ec29944e78f2', '9c6f0e5b-161c-4941-92e5-6b99b3f97b0c', 55, 24, 56, 24, 56, '2024-07-03 06:29:53', '2024-07-03 06:29:53', '24'),
('9c74ef88-b19e-45fb-b3e6-88aa23542d2e', '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '9c74ef1e-8745-4cea-8303-56e4fa5fe54e', 45, 20, 45, 20, 45, '2024-07-06 10:08:08', '2024-07-06 10:08:08', '0'),
('9c74f065-313d-4537-b821-c6519c0af682', '9c14bb75-32a9-47b9-b6ed-ec29944e78f1', '9c74eff3-9b29-411b-a901-76040bcd701b', 45, 20, 45, 20, 45, '2024-07-06 10:10:33', '2024-07-06 10:10:33', '0'),
('9c910f46-dfe3-4f9b-be2b-5c164cad9e01', '9c6b62bf-02ad-40f8-aad9-631fbc8a7455', '9c910e93-c5ec-4d9b-8549-7c346d926c0b', 45, 20, 45, 20, 80, '2024-07-20 09:40:04', '2024-07-20 09:40:04', '0');

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
  `performance_charge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deductible` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `writer_payments`
--

INSERT INTO `writer_payments` (`id`, `sr_no`, `writer_id`, `payment_method`, `metrix`, `apply_gst`, `apply_tds`, `period_from`, `period_to`, `online_ref_no`, `cheque_no`, `performance_charge`, `deductible`, `created_at`, `updated_at`, `total_amount`) VALUES
('9c0cd2fd-572e-474f-b03c-1d205ad2cb6f', 1, '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', 'Cash', '9be3fa93-49f5-4772-97c8-35ba796fa421', 1, 1, '2024-05-01', '2024-05-31', 'asdasd', '1231212', '32.05', '1323', '2024-05-15 10:32:13', '2024-06-29 00:22:00', NULL),
('9c531600-39d9-4c4d-9129-a2d53f9c9daa', 2, '9bf09bf8-8f3c-412c-9c96-aaf60d8a2ea2', 'NEFT', '9bc17857-0f6a-40d4-a9d9-87407d1a88b2', 0, 1, '2024-06-01', '2024-06-30', 'asdasd', NULL, '2000', '10', '2024-06-19 08:47:33', '2024-06-29 00:25:47', NULL),
('9c752caf-ad17-4604-a12e-aeb4ec492433', 3, '9c74ef1e-8745-4cea-8303-56e4fa5fe54e', 'NEFT', '9be5896f-f10e-4d49-b5f2-6c245b3ece18', 1, 1, '2024-07-01', '2024-07-06', NULL, NULL, '500', '50', '2024-07-06 12:59:08', '2024-07-15 18:27:11', '693'),
('9c7531cc-fe6e-42f9-b401-463e5efa4e71', 4, '9c74eff3-9b29-411b-a901-76040bcd701b', 'NEFT', '9bc17857-0f6a-40d4-a9d9-87407d1a88b1', 0, 1, '2024-07-20', '2024-07-20', NULL, NULL, NULL, NULL, '2024-07-06 13:13:26', '2024-07-20 12:15:36', '405'),
('9c8b013a-7eb6-41fc-9079-1d8279939467', 5, '9c74ef1e-8745-4cea-8303-56e4fa5fe54e', 'NEFT', '9bc17857-0f6a-40d4-a9d9-87407d1a88b1', 1, 1, '2024-07-17', '2024-07-17', NULL, NULL, '500', '100', '2024-07-17 09:25:49', '2024-07-17 09:25:49', '789');

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
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `estimates`
--
ALTER TABLE `estimates`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `estimate_details`
--
ALTER TABLE `estimate_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=320;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_cards`
--
ALTER TABLE `job_cards`
  MODIFY `job_card_srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `job_register`
--
ALTER TABLE `job_register`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `writers`
--
ALTER TABLE `writers`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `writer_payments`
--
ALTER TABLE `writer_payments`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
