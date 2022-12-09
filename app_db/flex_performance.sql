-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 05, 2022 at 06:47 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flex_performance`
--

-- --------------------------------------------------------

--
-- Table structure for table `bonus`
--

CREATE TABLE `bonus` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `name` int(11) NOT NULL,
  `init_author` varchar(10) DEFAULT NULL,
  `appr_author` varchar(10) DEFAULT NULL,
  `recom_author` varchar(110) NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL DEFAULT 0,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '1-Department, 2-Subdepartment',
  `hod` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reports_to` int(11) NOT NULL DEFAULT 3,
  `state` int(11) NOT NULL DEFAULT 1,
  `department_pattern` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_pattern` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(11) NOT NULL DEFAULT 1,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `region_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_10_05_104512_create_zones_table', 1),
(5, '2019_10_05_104513_create_regions_table', 1),
(6, '2019_10_05_104514_create_districts_table', 1),
(7, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(8, '2020_05_24_100000_create_sys_modules_table', 1),
(9, '2020_05_24_101033_create_roles_table', 1),
(10, '2020_05_24_101115_create_permissions_table', 1),
(11, '2020_05_24_102331_create_users_roles_table', 1),
(12, '2020_05_24_102403_create_roles_permissions_table', 1),
(13, '2020_06_01_135357_create_roles_sys_modules_table', 1),
(14, '2021_10_20_121145_create_designations_table', 1),
(15, '2022_01_08_063104_create_countries_table', 1),
(16, '2022_04_17_081429_create_departments_table', 1),
(17, '2022_11_22_140138_create_account_code_table', 1),
(18, '2022_11_22_140139_create_accountability_table', 1),
(19, '2022_11_22_140140_create_activation_deactivation_table', 1),
(20, '2022_11_22_140141_create_activities_table', 1),
(21, '2022_11_22_140142_create_activity_table', 1),
(22, '2022_11_22_140143_create_activity_cost_table', 1),
(23, '2022_11_22_140144_create_activity_grant_table', 1),
(24, '2022_11_22_140145_create_activity_results_table', 1),
(25, '2022_11_22_140146_create_allowance_logs_table', 1),
(26, '2022_11_22_140147_create_allowances_table', 1),
(27, '2022_11_22_140148_create_appreciation_table', 1),
(28, '2022_11_22_140149_create_arrears_table', 1),
(29, '2022_11_22_140150_create_arrears_logs_table', 1),
(30, '2022_11_22_140151_create_arrears_pendings_table', 1),
(31, '2022_11_22_140152_create_assignment_table', 1),
(32, '2022_11_22_140153_create_assignment_employee_table', 1),
(33, '2022_11_22_140154_create_assignment_exception_table', 1),
(34, '2022_11_22_140155_create_assignment_task_table', 1),
(35, '2022_11_22_140156_create_assignment_task_comment_table', 1),
(36, '2022_11_22_140157_create_assignment_task_logs_table', 1),
(37, '2022_11_22_140158_create_attendance_table', 1),
(38, '2022_11_22_140159_create_audit_logs_table', 1),
(39, '2022_11_22_140200_create_audit_purge_logs_table', 1),
(40, '2022_11_22_140201_create_bank_table', 1),
(41, '2022_11_22_140202_create_bank_branch_table', 1),
(42, '2022_11_22_140203_create_behaviour_table', 1),
(43, '2022_11_22_140204_create_bonus_table', 1),
(44, '2022_11_22_140205_create_bonus_logs_table', 1),
(45, '2022_11_22_140206_create_bonus_tags_table', 1),
(46, '2022_11_22_140207_create_branch_table', 1),
(47, '2022_11_22_140208_create_comments_table', 1),
(48, '2022_11_22_140209_create_company_emails_table', 1),
(49, '2022_11_22_140210_create_company_info_table', 1),
(50, '2022_11_22_140211_create_company_property_table', 1),
(51, '2022_11_22_140212_create_confirmed_imprest_table', 1),
(52, '2022_11_22_140213_create_confirmed_trainee_table', 1),
(53, '2022_11_22_140214_create_contract_table', 1),
(54, '2022_11_22_140215_create_country_table', 1),
(55, '2022_11_22_140216_create_deduction_table', 1),
(56, '2022_11_22_140217_create_deduction_logs_table', 1),
(57, '2022_11_22_140218_create_deduction_tags_table', 1),
(58, '2022_11_22_140219_create_deductions_table', 1),
(59, '2022_11_22_140220_create_deliverables_table', 1),
(60, '2022_11_22_140221_create_department_table', 1),
(61, '2022_11_22_140222_create_emp_allowances_table', 1),
(62, '2022_11_22_140223_create_emp_deductions_table', 1),
(63, '2022_11_22_140224_create_emp_role_table', 1),
(64, '2022_11_22_140225_create_emp_skills_table', 1),
(65, '2022_11_22_140226_create_employee_table', 1),
(66, '2022_11_22_140227_create_employee_activity_grant_table', 1),
(67, '2022_11_22_140228_create_employee_activity_grant_logs_table', 1),
(68, '2022_11_22_140229_create_employee_group_table', 1),
(69, '2022_11_22_140230_create_employee_overtime_table', 1),
(70, '2022_11_22_140231_create_exception_type_table', 1),
(71, '2022_11_22_140232_create_exit_list_table', 1),
(72, '2022_11_22_140233_create_expense_category_table', 1),
(73, '2022_11_22_140234_create_funder_table', 1),
(74, '2022_11_22_140235_create_grant_logs_table', 1),
(75, '2022_11_22_140236_create_grants_table', 1),
(76, '2022_11_22_140237_create_grievances_table', 1),
(77, '2022_11_22_140238_create_groups_table', 1),
(78, '2022_11_22_140239_create_imprest_table', 1),
(79, '2022_11_22_140240_create_imprest_requirement_table', 1),
(80, '2022_11_22_140241_create_leave_application_table', 1),
(81, '2022_11_22_140242_create_leave_type_table', 1),
(82, '2022_11_22_140243_create_leaves_table', 1),
(83, '2022_11_22_140244_create_loan_table', 1),
(84, '2022_11_22_140245_create_loan_application_table', 1),
(85, '2022_11_22_140246_create_loan_logs_table', 1),
(86, '2022_11_22_140247_create_loan_type_table', 1),
(87, '2022_11_22_140248_create_meals_deduction_table', 1),
(88, '2022_11_22_140249_create_mobile_service_provider_table', 1),
(89, '2022_11_22_140250_create_next_of_kin_table', 1),
(90, '2022_11_22_140251_create_notifications_table', 1),
(91, '2022_11_22_140252_create_once_off_deduction_table', 1),
(92, '2022_11_22_140253_create_organization_level_table', 1),
(93, '2022_11_22_140254_create_outcome_table', 1),
(94, '2022_11_22_140255_create_output_table', 1),
(95, '2022_11_22_140256_create_overtime_category_table', 1),
(96, '2022_11_22_140257_create_overtime_logs_table', 1),
(97, '2022_11_22_140258_create_overtimes_table', 1),
(98, '2022_11_22_140259_create_partial_payment_table', 1),
(99, '2022_11_22_140300_create_paused_task_table', 1),
(100, '2022_11_22_140301_create_paye_table', 1),
(101, '2022_11_22_140302_create_payroll_logs_table', 1),
(102, '2022_11_22_140303_create_payroll_months_table', 1),
(103, '2022_11_22_140304_create_pension_fund_table', 1),
(104, '2022_11_22_140305_create_permission_table', 1),
(105, '2022_11_22_140307_create_position_table', 1),
(106, '2022_11_22_140308_create_project_table', 1),
(107, '2022_11_22_140309_create_project_grant_table', 1),
(108, '2022_11_22_140310_create_project_segment_table', 1),
(109, '2022_11_22_140311_create_retire_table', 1),
(110, '2022_11_22_140312_create_role_table', 1),
(111, '2022_11_22_140313_create_shift_table', 1),
(112, '2022_11_22_140314_create_skills_table', 1),
(113, '2022_11_22_140315_create_strategy_table', 1),
(114, '2022_11_22_140316_create_talent_table', 1),
(115, '2022_11_22_140317_create_task_table', 1),
(116, '2022_11_22_140318_create_task_employee_table', 1),
(117, '2022_11_22_140319_create_task_ratings_table', 1),
(118, '2022_11_22_140320_create_task_resources_table', 1),
(119, '2022_11_22_140321_create_task_settings_table', 1),
(120, '2022_11_22_140322_create_temp_allowance_logs_table', 1),
(121, '2022_11_22_140323_create_temp_arrears_table', 1),
(122, '2022_11_22_140324_create_temp_deduction_logs_table', 1),
(123, '2022_11_22_140325_create_temp_loan_logs_table', 1),
(124, '2022_11_22_140326_create_temp_payroll_logs_table', 1),
(125, '2022_11_22_140327_create_training_application_table', 1),
(126, '2022_11_22_140328_create_training_budget_table', 1),
(127, '2022_11_22_140329_create_transfer_table', 1),
(128, '2022_11_22_140330_create_user_passwords_table', 1),
(129, '2022_11_28_062346_create_system_control_table', 1),
(130, '2022_11_28_132537_create_audit_trails_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sys_module_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `slug`, `sys_module_id`, `created_at`, `updated_at`) VALUES
(1, 'view-roles', 1, '2022-12-01 07:32:54', '2022-12-01 07:32:54'),
(2, 'add-roles', 1, '2022-12-01 07:32:54', '2022-12-01 07:32:54'),
(3, 'edit-roles', 1, '2022-12-01 07:32:54', '2022-12-01 07:32:54'),
(4, 'delete-roles', 1, '2022-12-01 07:32:54', '2022-12-01 07:32:54'),
(5, 'view-permission', 1, '2022-12-01 07:32:54', '2022-12-01 07:32:54'),
(6, 'add-permission', 1, '2022-12-01 07:32:54', '2022-12-01 07:32:54'),
(7, 'edit-permission', 1, '2022-12-01 07:32:54', '2022-12-01 07:32:54'),
(8, 'delete-permission', 1, '2022-12-01 07:32:54', '2022-12-01 07:32:54'),
(9, 'view-user', 1, '2022-12-01 07:32:54', '2022-12-01 07:32:54'),
(10, 'add-user', 1, '2022-12-01 07:32:54', '2022-12-01 07:32:54'),
(11, 'edit-user', 1, '2022-12-01 07:32:54', '2022-12-01 07:32:54'),
(12, 'delete-user', 1, '2022-12-01 07:32:54', '2022-12-01 07:32:54'),
(13, 'view-dashboard', 1, '2022-12-01 07:32:54', '2022-12-01 07:32:54');

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
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `zone_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles_sys_modules`
--

CREATE TABLE `roles_sys_modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `sys_module_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_control`
--

CREATE TABLE `system_control` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_modules`
--

CREATE TABLE `sys_modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sys_modules`
--

INSERT INTO `sys_modules` (`id`, `slug`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'manage-access-control', '2022-12-01 07:32:54', '2022-12-01 07:32:54', NULL),
(2, 'manage-payroll', '2022-12-01 07:32:54', '2022-12-01 07:32:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ctivity`
--

CREATE TABLE `tbl_ctivity` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_ref` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activityDate` date NOT NULL,
  `startTime` time NOT NULL,
  `finishTime` time NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `dateCreated` datetime NOT NULL,
  `createdBy` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_departments`
--

CREATE TABLE `tbl_departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_head_id` int(11) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `joining_date` timestamp NULL DEFAULT NULL,
  `active_status` int(11) DEFAULT NULL,
  `disabled` int(11) DEFAULT NULL,
  `disabled_date` date DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','unactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `added_by`, `phone`, `address`, `department_id`, `designation_id`, `joining_date`, `active_status`, `disabled`, `disabled_date`, `email`, `email_verified_at`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'CITS Test Account', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin@gmail.com', '2022-12-01 07:32:54', '$2y$10$QueW5thXzMAZIWqG3U587ezxMamKhqDitZgrNqJsQzNZG8rnTGkjm', 'active', 'kLUZt3K7qkofY3E762noDZiwUdpzt5ujUB0j14UAmTuWdKXMw6w3jQwb2myG', '2022-12-01 07:32:54', '2022-12-01 07:32:54');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE `zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_region_id_foreign` (`region_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_sys_module_id_foreign` (`sys_module_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regions_zone_id_foreign` (`zone_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `roles_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `roles_sys_modules`
--
ALTER TABLE `roles_sys_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_sys_modules_role_id_foreign` (`role_id`),
  ADD KEY `roles_sys_modules_sys_module_id_foreign` (`sys_module_id`);

--
-- Indexes for table `system_control`
--
ALTER TABLE `system_control`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_modules`
--
ALTER TABLE `sys_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_ctivity`
--
ALTER TABLE `tbl_ctivity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_departments`
--
ALTER TABLE `tbl_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `users_roles_role_id_foreign` (`role_id`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles_sys_modules`
--
ALTER TABLE `roles_sys_modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_control`
--
ALTER TABLE `system_control`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sys_modules`
--
ALTER TABLE `sys_modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_departments`
--
ALTER TABLE `tbl_departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_sys_module_id_foreign` FOREIGN KEY (`sys_module_id`) REFERENCES `sys_modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `regions`
--
ALTER TABLE `regions`
  ADD CONSTRAINT `regions_zone_id_foreign` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD CONSTRAINT `roles_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roles_sys_modules`
--
ALTER TABLE `roles_sys_modules`
  ADD CONSTRAINT `roles_sys_modules_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_sys_modules_sys_module_id_foreign` FOREIGN KEY (`sys_module_id`) REFERENCES `sys_modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `users_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
