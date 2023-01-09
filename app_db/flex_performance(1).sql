-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 09, 2022 at 07:12 AM
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
-- Table structure for table `accountability`
--

CREATE TABLE `accountability` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `remarks` varchar(300) DEFAULT NULL,
  `position_ref` int(11) NOT NULL,
  `author` varchar(10) NOT NULL DEFAULT '25500005',
  `weighting` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `account_code`
--

CREATE TABLE `account_code` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_code`
--

INSERT INTO `account_code` (`id`, `name`, `code`, `status`) VALUES
(1, 'Basic Salary', '2301', 1),
(2, 'Gross Salary', '2002', 1),
(3, 'Overtime', '3927', 1),
(4, 'PAYE', '2444', 1),
(5, 'Salary Arrears', '2893', 1),
(6, 'Imprest', '2525', 1),
(7, 'Leave', '2778', 1),
(8, 'Bonus', '2099', 1),
(9, 'Pension', '4289', 1),
(10, 'Employee Salary (Gross)', '3000', 1),
(11, 'Employer’s Tax Contributions', '3025', 1),
(12, 'Employer’s Pension Contributions', '3050', 1),
(13, 'Employee Relocation Cost', '3275', 1),
(14, 'temporary Allowances', '3520', 1),
(15, 'temporary/Staff Control Account ', '1717', 1),
(16, 'Salary Accrual', '1710', 1),
(17, 'TZS Bank Account for salary payments', 'CBTZ001', 1);

-- --------------------------------------------------------

--
-- Table structure for table `activation_deactivation`
--

CREATE TABLE `activation_deactivation` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `state` int(11) NOT NULL COMMENT '0-Deactivated, 1-Activated, 2-Request for Activation, 3-Request for Deactivation',
  `current_state` int(11) NOT NULL DEFAULT 0 COMMENT '0-active, 1-committed',
  `notification` int(1) NOT NULL DEFAULT 1 COMMENT '0-seen, 1-not seen',
  `dated` datetime NOT NULL DEFAULT current_timestamp(),
  `author` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activation_deactivation`
--

INSERT INTO `activation_deactivation` (`id`, `empID`, `state`, `current_state`, `notification`, `dated`, `author`) VALUES
(1, 'TZ1118808', 3, 1, 1, '2020-06-05 08:44:51', 'TZ1113936'),
(2, '123456', 3, 1, 1, '2020-06-06 04:10:27', 'TZ1113936'),
(3, '123456', 0, 1, 1, '2020-06-06 04:11:52', 'TZ1113936'),
(4, '123456', 2, 1, 1, '2020-06-06 05:45:12', 'TZ1114433'),
(5, '123456', 1, 1, 1, '2020-06-06 05:45:34', 'TZ1114433'),
(6, '123456', 3, 0, 1, '2020-06-13 08:33:49', 'TZ1113936'),
(7, '123456', 4, 4, 1, '2020-06-13 08:49:56', 'TZ1114433'),
(8, '123456', 4, 4, 1, '2020-06-13 08:49:56', 'TZ1114433'),
(9, '112233', 3, 0, 1, '2020-06-19 07:18:58', 'TZ1113936'),
(10, '112233', 4, 4, 1, '2020-06-19 07:20:11', 'TZ1114433'),
(11, '112233', 4, 4, 1, '2020-06-19 07:20:11', 'TZ1114433'),
(12, 'V1123660', 3, 0, 1, '2020-06-19 07:23:03', 'TZ1114433'),
(13, 'V1120922', 3, 0, 1, '2020-06-19 07:23:50', 'TZ1114433'),
(14, 'TZ1123840', 3, 0, 1, '2020-06-19 07:26:07', 'TZ1114433'),
(15, 'V1123660', 4, 4, 1, '2020-06-19 07:28:47', 'TZ1113936'),
(16, 'V1123660', 4, 4, 1, '2020-06-19 07:28:47', 'TZ1113936'),
(17, 'V1120922', 4, 4, 1, '2020-06-19 07:28:54', 'TZ1113936'),
(18, 'V1120922', 4, 4, 1, '2020-06-19 07:28:54', 'TZ1113936'),
(19, 'TZ1123840', 4, 4, 1, '2020-06-19 07:29:00', 'TZ1113936'),
(20, 'TZ1123840', 4, 4, 1, '2020-06-19 07:29:00', 'TZ1113936'),
(21, '9876654321', 3, 0, 1, '2020-06-29 08:17:10', 'TZ1113936'),
(22, '9876654321', 4, 4, 1, '2020-06-29 08:18:04', 'TZ1114433'),
(23, '9876654321', 4, 4, 1, '2020-06-29 08:18:04', 'TZ1114433'),
(24, '255017', 0, 0, 1, '2020-09-02 01:49:41', '255001'),
(25, '255019', 0, 0, 1, '2020-09-02 01:50:57', '255024'),
(26, '255027', 3, 0, 1, '2020-09-02 01:57:26', '255001'),
(27, '255027', 4, 4, 1, '2020-09-02 02:01:09', '255024'),
(28, '255027', 4, 4, 1, '2020-09-02 02:01:09', '255024'),
(29, '255027', 4, 4, 1, '2020-09-02 02:01:09', '255024'),
(30, '255027', 4, 4, 1, '2020-09-02 02:01:09', '255024'),
(31, '255016', 0, 0, 1, '2020-09-02 02:33:45', '255001'),
(32, '255017', 3, 0, 1, '2021-05-20 03:25:31', '255001'),
(33, '255019', 3, 0, 1, '2022-09-14 08:51:28', '255001');

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cost` int(100) NOT NULL,
  `target` int(100) NOT NULL,
  `deliverable_id` int(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `state` int(100) NOT NULL DEFAULT 1,
  `managed_by` int(100) NOT NULL,
  `document` varchar(100) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `name`, `cost`, `target`, `deliverable_id`, `description`, `state`, `managed_by`, `document`, `start_date`, `end_date`) VALUES
(4, 'performance', 200, 200, 1, 'testing', 1, 255028, '', '2022-10-05 00:00:00', '2022-10-12 00:00:00'),
(5, 'Programming', 2000000, 200000000, 1, 'test', 1, 255028, '', '2022-10-06 00:00:00', '2022-10-20 00:00:00'),
(6, 'Negotiatng price below 2,500 per kilo', 5000000, 5, 4, 'The bank has to buy 5 godowns of Korosho from big farmers', 1, 255010, '', '2022-01-01 00:00:00', '2022-10-13 00:00:00'),
(7, 'Negotiating price below 2000 per kilo', 5000000, 5, 5, 'The bank has to buy 5 godowns of Korosho', 1, 255010, '', '2022-01-01 00:00:00', '2022-10-31 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `project_ref` varchar(50) NOT NULL,
  `activityDate` date NOT NULL,
  `startTime` time NOT NULL,
  `finishTime` time NOT NULL,
  `isActive` int(1) NOT NULL DEFAULT 1,
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `name`, `code`, `description`, `project_ref`, `activityDate`, `startTime`, `finishTime`, `isActive`, `dateCreated`, `createdBy`) VALUES
(1, 'Default Activity - People resourcing', 'AC0018', 'People resourcing – staff members', 'SP008', '2020-04-15', '04:00:00', '14:00:00', 1, '2020-04-15 07:42:25', '2550001'),
(11, 'AA91', 'AA91', 'ICS-Personnel costs:Incl. all taxes-In country PSs', 'SP008', '0000-00-00', '00:00:00', '00:00:00', 1, '2020-05-19 01:32:19', ''),
(12, 'A0234DFI', 'A0234DFI', 'National Staff Costs', 'SP008', '0000-00-00', '00:00:00', '00:00:00', 1, '2020-05-19 01:33:04', ''),
(13, 'AC0030', 'AC0030', 'AC0030', 'SP008', '0000-00-00', '00:00:00', '00:00:00', 1, '2020-05-19 01:33:33', ''),
(14, 'A0002RAN', 'A0002RAN', 'Programme Management - National staff payroll', 'SP008', '0000-00-00', '00:00:00', '00:00:00', 1, '2020-05-19 01:34:07', ''),
(15, 'A0006PES', 'A0006PES', 'Staff Salaries', 'SP032', '0000-00-00', '00:00:00', '00:00:00', 0, '2020-05-19 01:35:02', ''),
(18, 'A0035KPM', 'A0035KPM', 'A0035KPM', 'SP062', '0000-00-00', '00:00:00', '00:00:00', 0, '2020-05-19 01:38:59', ''),
(19, 'A0002DFA', 'A0002DFA', 'Remuneration - Local employees', 'SP008', '0000-00-00', '00:00:00', '00:00:00', 1, '2020-05-19 22:29:58', ''),
(20, 'A0016SAS', 'A0016SAS', 'Staff Salaries', 'SP040', '0000-00-00', '00:00:00', '00:00:00', 0, '2020-05-20 06:28:38', ''),
(22, 'JKS001', 'JKS001', 'Test Activity', 'SP008', '0000-00-00', '00:00:00', '00:00:00', 0, '2020-06-16 06:41:27', ''),
(23, 'JJ001A1', 'JJ001A1', 'JJ001A1 Decription', 'JJ001', '0000-00-00', '00:00:00', '00:00:00', 0, '2020-06-16 11:26:13', ''),
(24, 'JJ001A2', 'JJ001A2', 'JJ001A2 description', 'JJ001', '0000-00-00', '00:00:00', '00:00:00', 0, '2020-06-16 11:26:52', ''),
(25, 'JJ001A3', 'JJ001A3', 'JJ001A3 description', 'JJ001', '0000-00-00', '00:00:00', '00:00:00', 0, '2020-06-16 11:28:27', '');

-- --------------------------------------------------------

--
-- Table structure for table `activity_cost`
--

CREATE TABLE `activity_cost` (
  `id` int(11) NOT NULL,
  `emp_id` varchar(45) DEFAULT NULL,
  `project` varchar(45) NOT NULL,
  `activity` varchar(45) NOT NULL,
  `assignment` varchar(45) NOT NULL,
  `cost_category` varchar(45) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `document` varchar(100) DEFAULT NULL,
  `status` varchar(45) DEFAULT '1',
  `created_by` varchar(45) NOT NULL,
  `approved_by` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `activity_grant`
--

CREATE TABLE `activity_grant` (
  `id` bigint(20) NOT NULL,
  `activity_code` varchar(50) NOT NULL,
  `grant_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_grant`
--

INSERT INTO `activity_grant` (`id`, `activity_code`, `grant_code`) VALUES
(1, 'AC0018', 'VSO'),
(7, 'AA91', 'DFI024'),
(8, 'A0234DFI', 'DFI025'),
(9, 'AC0030', 'DFI032'),
(10, 'A0002RAN', 'RAN005'),
(11, 'A0006PES', 'PES004'),
(14, 'A0035KPM', 'KPM002'),
(15, 'A0002DFA', 'DFA001'),
(17, 'A0035KPM', 'VSO'),
(18, 'A0016SAS - NLD001', 'NLD001'),
(21, 'A0016SAS - NLD001', 'SAS005'),
(22, 'A0016SAS', 'NLD001'),
(23, 'A0016SAS', 'SAS005'),
(24, 'JKS001', 'RAN005'),
(25, 'JJ001A1', 'JJ001A'),
(26, 'JJ001A2', 'JJ001A'),
(27, 'JJ001A3', 'JJ001B');

-- --------------------------------------------------------

--
-- Table structure for table `activity_results`
--

CREATE TABLE `activity_results` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cost` int(100) NOT NULL,
  `target` int(100) NOT NULL,
  `result` int(100) NOT NULL,
  `emp_id` int(100) NOT NULL,
  `exactly_cost` int(100) NOT NULL,
  `activity_id` int(100) NOT NULL,
  `deliverable_id` int(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `state` int(100) NOT NULL DEFAULT 1,
  `managed_by` int(100) NOT NULL,
  `document` varchar(100) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity_results`
--

INSERT INTO `activity_results` (`id`, `name`, `cost`, `target`, `result`, `emp_id`, `exactly_cost`, `activity_id`, `deliverable_id`, `description`, `state`, `managed_by`, `document`, `start_date`, `end_date`) VALUES
(4, 'performance', 200, 200, 20, 255028, 400, 4, 1, 'testing', 1, 255028, '', '2022-10-05 00:00:00', '2022-10-12 00:00:00'),
(5, 'performance', 200, 200, 300, 255028, 500, 4, 1, 'testing', 1, 255028, '', '2022-10-05 00:00:00', '2022-10-12 00:00:00'),
(6, 'performance', 200, 200, 300, 255028, 500, 4, 1, 'testing', 1, 255028, '', '2022-10-05 00:00:00', '2022-10-12 00:00:00'),
(7, 'performance', 200, 200, 70, 255028, 8, 4, 1, 'testing', 1, 255028, '', '2022-10-05 00:00:00', '2022-10-12 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `allowances`
--

CREATE TABLE `allowances` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `percent` double(10,3) NOT NULL DEFAULT 0.000,
  `mode` int(1) NOT NULL DEFAULT 1 COMMENT '1-fixed value, 2-percent value depending basic salary ',
  `apply_to` int(1) NOT NULL DEFAULT 0 COMMENT '1-apply to all, 2-apply to specific',
  `state` int(1) NOT NULL DEFAULT 1 COMMENT '1-active, 0-inactive',
  `created_by` varchar(10) DEFAULT NULL,
  `created_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allowances`
--

INSERT INTO `allowances` (`id`, `name`, `code`, `amount`, `percent`, `mode`, `apply_to`, `state`, `created_by`, `created_on`) VALUES
(14, 'Housing Allowance', 0, '300000.00', 0.000, 1, 0, 1, NULL, '2020-06-19 09:32:36'),
(15, 'Transport Allowance', 0, '20000.00', 0.000, 1, 0, 1, NULL, '2022-10-02 03:56:16');

-- --------------------------------------------------------

--
-- Table structure for table `allowance_logs`
--

CREATE TABLE `allowance_logs` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `allowanceID` int(11) NOT NULL DEFAULT 6,
  `description` varchar(50) NOT NULL DEFAULT 'Unclassified',
  `policy` varchar(50) NOT NULL DEFAULT 'Fixed Amount',
  `amount` decimal(20,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allowance_logs`
--

INSERT INTO `allowance_logs` (`id`, `empID`, `allowanceID`, `description`, `policy`, `amount`, `payment_date`) VALUES
(1, '5050', 6, 'Refund', 'Fixed Amount', '100000.00', '2022-10-04'),
(2, '5050', 6, 'Overtime', 'Fixed Amount', '6250.00', '2022-10-04');

-- --------------------------------------------------------

--
-- Table structure for table `appreciation`
--

CREATE TABLE `appreciation` (
  `id` int(11) NOT NULL,
  `empID` varchar(12) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date_apprd` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appreciation`
--

INSERT INTO `appreciation` (`id`, `empID`, `description`, `date_apprd`) VALUES
(12, '2550001', 'Completed The Development of HR, Payroll and Performance Information System', '2019-07-24'),
(13, '2550001', '', '2020-04-26'),
(14, '2550005', '', '2020-04-26'),
(15, '2550013', '', '2020-05-10'),
(16, '2550013', 'Deployment of Flex Performance for HR and Payroll Management', '2020-05-11');

-- --------------------------------------------------------

--
-- Table structure for table `arrears`
--

CREATE TABLE `arrears` (
  `id` bigint(20) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `paid` decimal(15,2) NOT NULL DEFAULT 0.00,
  `amount_last_paid` decimal(15,2) NOT NULL DEFAULT 0.00,
  `last_paid_date` date NOT NULL,
  `payroll_date` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '0-Payment Completed, 1-Payment Not Completed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `arrears`
--

INSERT INTO `arrears` (`id`, `empID`, `amount`, `paid`, `amount_last_paid`, `last_paid_date`, `payroll_date`, `status`) VALUES
(1, '255017', '1000000.00', '1000000.00', '1000000.00', '2020-07-09', '2019-02-19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `arrears_logs`
--

CREATE TABLE `arrears_logs` (
  `id` bigint(20) NOT NULL,
  `arrear_id` bigint(20) NOT NULL,
  `amount_paid` decimal(15,2) NOT NULL,
  `init_by` varchar(10) NOT NULL,
  `confirmed_by` varchar(10) NOT NULL,
  `payment_date` date NOT NULL,
  `payroll_date` date NOT NULL COMMENT 'Payroll Month in Which This Arrears Payment Was done'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `arrears_logs`
--

INSERT INTO `arrears_logs` (`id`, `arrear_id`, `amount_paid`, `init_by`, `confirmed_by`, `payment_date`, `payroll_date`) VALUES
(1, 1, '1000000.00', '255001', '255073', '2022-08-31', '2022-08-31');

-- --------------------------------------------------------

--
-- Table structure for table `arrears_pendings`
--

CREATE TABLE `arrears_pendings` (
  `id` int(11) NOT NULL,
  `arrear_id` bigint(20) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '1-Confirmed, 0-Not Confirmed',
  `init_by` varchar(10) NOT NULL,
  `date_confirmed` date NOT NULL,
  `confirmed_by` varchar(10) NOT NULL,
  `date_recommended` varchar(110) NOT NULL,
  `recommended_by` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `project` varchar(45) NOT NULL,
  `activity` varchar(45) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `assigned_by` varchar(45) NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  `progress` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`id`, `name`, `project`, `activity`, `start_date`, `end_date`, `description`, `assigned_by`, `status`, `progress`) VALUES
(2, 'Msalato girls training', 'SP008', 'AA91', '2020-07-09', '2020-07-17', 'Msalato girls training', '255010', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assignment_employee`
--

CREATE TABLE `assignment_employee` (
  `id` int(11) NOT NULL,
  `assignment_id` varchar(45) NOT NULL,
  `emp_id` varchar(45) NOT NULL,
  `status` varchar(45) DEFAULT '0',
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment_employee`
--

INSERT INTO `assignment_employee` (`id`, `assignment_id`, `emp_id`, `status`, `date`) VALUES
(7, '2', '255001', '0', NULL),
(8, '2', '255010', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assignment_exception`
--

CREATE TABLE `assignment_exception` (
  `id` int(11) NOT NULL,
  `assignment_id` varchar(45) NOT NULL,
  `emp_id` varchar(45) NOT NULL,
  `exception_type` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(45) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_task`
--

CREATE TABLE `assignment_task` (
  `id` int(11) NOT NULL,
  `assignment_employee_id` int(11) NOT NULL,
  `task_name` varchar(200) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `status` varchar(45) DEFAULT '0',
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment_task`
--

INSERT INTO `assignment_task` (`id`, `assignment_employee_id`, `task_name`, `description`, `start_date`, `end_date`, `remarks`, `status`, `date`) VALUES
(3, 8, 'Material Prep', 'Material Prep Desc', '2020-07-09 15:13:00', '2020-07-15 15:13:00', NULL, '1', '2020-04-25'),
(4, 7, 'Notice preparation', 'This includes presentation and detailed notice preps', '2020-07-10 07:45:00', '2020-07-10 00:45:00', NULL, '1', '2020-04-25'),
(5, 8, 'Presentations', 'Teaching', '2020-07-10 06:51:00', '2020-07-10 00:51:00', NULL, '1', '2020-04-25');

-- --------------------------------------------------------

--
-- Table structure for table `assignment_task_comment`
--

CREATE TABLE `assignment_task_comment` (
  `id` int(11) NOT NULL,
  `task_id` varchar(45) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `remark_by` varchar(45) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment_task_comment`
--

INSERT INTO `assignment_task_comment` (`id`, `task_id`, `remarks`, `remark_by`, `date`) VALUES
(8, '3', 'This was interesting ', '255010', '2020-07-10 07:53:06');

-- --------------------------------------------------------

--
-- Table structure for table `assignment_task_logs`
--

CREATE TABLE `assignment_task_logs` (
  `id` int(11) NOT NULL,
  `assignment_employee_id` int(11) NOT NULL,
  `emp_id` varchar(200) NOT NULL,
  `task_name` varchar(200) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `status` varchar(45) DEFAULT '0',
  `payroll_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment_task_logs`
--

INSERT INTO `assignment_task_logs` (`id`, `assignment_employee_id`, `emp_id`, `task_name`, `description`, `start_date`, `end_date`, `remarks`, `status`, `payroll_date`) VALUES
(4, 2, '255010', 'Material Prep', 'Material Prep Desc', '2020-07-09 15:13:00', '2020-07-15 15:13:00', NULL, '1', '2020-04-25 00:00:00'),
(5, 2, '255001', 'Notice preparation', 'This includes presentation and detailed notice preps', '2020-07-10 07:45:00', '2020-07-10 00:45:00', NULL, '1', '2020-04-25 00:00:00'),
(6, 2, '255010', 'Presentations', 'Teaching', '2020-07-10 06:51:00', '2020-07-10 00:51:00', NULL, '1', '2020-04-25 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `due_in` datetime DEFAULT current_timestamp(),
  `due_out` timestamp NULL DEFAULT current_timestamp(),
  `state` int(1) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `empID`, `due_in`, `due_out`, `state`) VALUES
(64, '2550001', '2020-04-26 07:38:52', '2020-04-26 12:38:52', 1),
(65, '0970020', '2020-05-08 12:32:14', '2020-05-08 17:32:14', 1),
(66, '2550017', '2020-05-08 12:39:58', '2020-05-08 17:39:58', 1),
(67, '2540018', '2020-05-08 01:43:35', '2020-05-08 06:43:35', 1),
(68, '2550001', '2020-05-08 02:40:45', '2020-05-08 07:40:45', 1),
(69, '0010019', '2020-05-08 06:19:49', '2020-05-08 11:19:49', 1),
(70, '2540018', '2020-05-09 12:13:38', '2020-05-09 17:13:38', 1),
(71, '2550001', '2020-05-09 12:13:51', '2020-05-09 17:13:51', 1),
(72, '2540018', '2020-05-09 12:14:08', '2020-05-09 17:14:08', 1),
(73, '2540018', '2020-05-09 12:14:23', '2020-05-09 17:14:23', 1),
(74, '2550001', '2020-05-10 11:39:14', '2020-05-10 16:39:14', 1),
(75, '2550017', '2020-05-12 05:22:04', '2020-05-12 10:22:04', 1),
(76, '2550001', '2020-05-15 04:49:39', '2020-05-15 09:49:39', 1),
(77, '2550001', '2020-05-17 09:00:45', '2020-05-17 14:00:45', 1),
(78, '2550021', '2020-05-17 09:13:52', '2020-05-17 14:13:52', 1),
(79, '2550001', '2020-05-18 11:25:05', '2020-05-18 16:25:05', 1),
(80, 'TZ1114433', '2020-05-21 05:39:21', '2020-05-21 10:39:21', 1),
(81, 'TZ1114433', '2020-05-23 04:03:35', '2020-05-23 09:03:35', 1),
(82, 'TZ1114433', '2020-06-03 10:05:33', '2020-06-03 15:05:33', 1),
(83, 'TZ1114433', '2020-06-04 04:28:49', '2020-06-04 09:28:49', 1),
(84, 'TZ346', '2020-06-05 11:11:16', '2020-06-05 16:11:16', 1),
(85, 'TZ1114433', '2020-06-05 11:18:03', '2020-06-05 16:18:03', 1),
(86, 'TZ394', '2020-06-05 11:18:47', '2020-06-05 16:18:47', 1),
(87, 'TZ1110594', '2020-06-05 11:24:57', '2020-06-05 16:24:57', 1),
(88, 'TZ1113936', '2020-06-05 12:31:49', '2020-06-05 17:31:49', 1),
(89, 'UG213', '2020-06-05 05:05:05', '2020-06-05 10:05:05', 1),
(90, 'TZ1113936', '2020-06-06 08:37:29', '2020-06-06 13:37:29', 1),
(91, 'TZ1114433', '2020-06-06 08:37:56', '2020-06-06 13:37:56', 1),
(92, 'TZ394', '2020-06-06 09:57:11', '2020-06-06 14:57:11', 1),
(93, 'UG213', '2020-06-06 09:57:29', '2020-06-06 14:57:29', 1),
(94, '123456', '2020-06-06 12:07:45', '2020-06-06 17:07:45', 1),
(95, 'TZ346', '2020-06-06 01:52:23', '2020-06-06 06:52:23', 1),
(96, 'TZ1110431', '2020-06-06 03:32:32', '2020-06-06 08:32:32', 1),
(97, 'TZ1113936', '2020-06-13 11:52:50', '2020-06-13 16:52:50', 1),
(98, 'TZ1114433', '2020-06-13 11:54:12', '2020-06-13 16:54:12', 1),
(99, 'TZ394', '2020-06-13 01:54:40', '2020-06-13 06:54:40', 1),
(100, 'UG213', '2020-06-13 03:05:44', '2020-06-13 08:05:44', 1),
(101, 'TZ1114433', '2020-06-15 07:36:42', '2020-06-15 12:36:42', 1),
(102, 'TZ394', '2020-06-15 07:50:06', '2020-06-15 12:50:06', 1),
(103, 'TZ1113936', '2020-06-15 07:52:20', '2020-06-15 12:52:20', 1),
(104, 'TZ346', '2020-06-15 09:01:57', '2020-06-15 14:01:57', 1),
(105, 'TZ1110594', '2020-06-15 10:04:06', '2020-06-15 15:04:06', 1),
(106, 'UG213', '2020-06-15 03:47:00', '2020-06-15 08:47:00', 1),
(107, 'TZ1114433', '2020-06-16 12:06:19', '2020-06-16 17:06:27', 2),
(108, 'TZ394', '2020-06-16 12:11:17', '2020-06-16 17:11:17', 1),
(109, 'UG213', '2020-06-16 07:09:09', '2020-06-16 12:09:09', 1),
(110, 'TZ1113936', '2020-06-16 03:02:52', '2020-06-16 08:02:52', 1),
(111, 'TZ1114433', '2020-06-18 08:18:27', '2020-06-18 13:18:27', 1),
(112, 'TZ394', '2020-06-18 08:18:33', '2020-06-18 13:18:33', 1),
(113, 'TZ1110594', '2020-06-18 03:54:53', '2020-06-18 08:54:53', 1),
(114, 'TZ346', '2020-06-18 03:55:08', '2020-06-18 08:55:08', 1),
(115, 'TZ1113936', '2020-06-18 03:56:18', '2020-06-18 08:56:18', 1),
(116, 'TZ346', '2020-06-19 01:04:29', '2020-06-19 06:04:29', 1),
(117, 'UG213', '2020-06-19 01:10:29', '2020-06-19 06:10:29', 1),
(118, 'TZ1113936', '2020-06-19 01:10:36', '2020-06-19 06:10:36', 1),
(119, 'TZ1114433', '2020-06-19 03:28:14', '2020-06-19 08:28:14', 1),
(120, 'TZ1114433', '2020-06-20 04:48:47', '2020-06-20 09:48:47', 1),
(121, 'TZ1113936', '2020-06-20 11:36:18', '2020-06-20 16:36:18', 1),
(122, 'TZ346', '2020-06-20 11:46:08', '2020-06-20 16:46:08', 1),
(123, 'TZ1110594', '2020-06-20 11:47:11', '2020-06-20 16:47:11', 1),
(124, 'TZ1110594', '2020-06-22 07:12:56', '2020-06-22 12:12:56', 1),
(125, 'TZ346', '2020-06-22 07:34:19', '2020-06-22 12:34:19', 1),
(126, 'TZ1113936', '2020-06-22 07:40:55', '2020-06-22 12:40:55', 1),
(127, 'TZ1113936', '2020-06-22 07:41:04', '2020-06-22 12:41:04', 1),
(128, 'UG213', '2020-06-22 09:09:20', '2020-06-22 14:09:20', 1),
(129, 'TZ394', '2020-06-22 09:09:29', '2020-06-22 14:09:29', 1),
(130, 'TZ1114433', '2020-06-22 11:26:50', '2020-06-22 16:26:50', 1),
(131, 'S21179', '2020-06-22 11:48:32', '2020-06-22 16:48:32', 1),
(132, 'TZ1110431', '2020-06-22 09:29:06', '2020-06-22 14:29:13', 2),
(133, 'TZ1114433', '2020-06-23 01:29:48', '2020-06-23 06:29:48', 1),
(134, 'TZ1114433', '2020-06-26 11:32:37', '2020-06-26 16:32:37', 1),
(135, 'TZ394', '2020-06-26 12:39:03', '2020-06-26 17:39:03', 1),
(136, 'TZ1114433', '2020-06-27 08:56:11', '2020-06-27 13:56:11', 1),
(137, 'TZ394', '2020-06-29 06:51:00', '2020-06-29 11:51:00', 1),
(138, 'S21179', '2020-07-08 10:27:24', '2020-07-08 15:27:24', 1),
(139, '255001', '2020-08-04 12:39:14', '2020-08-04 17:39:14', 1),
(140, '255001', '2020-09-02 10:47:18', '2020-09-02 15:47:18', 1),
(141, '255001', '2022-09-14 12:00:05', '2022-09-14 12:00:05', 1),
(142, '255010', '2022-09-14 12:59:50', '2022-09-14 12:59:50', 1),
(143, '255073', '2022-09-14 01:00:52', '2022-09-14 01:00:52', 1),
(144, '255001', '2022-09-15 06:32:55', '2022-09-15 06:32:55', 1),
(145, '255001', '2022-10-01 12:04:56', '2022-10-01 12:04:56', 1),
(146, '255001', '2022-10-04 09:17:54', '2022-10-04 09:17:54', 1),
(147, '5050', '2022-10-04 01:49:42', '2022-10-04 01:49:42', 1),
(148, '9090', '2022-10-04 04:36:04', '2022-10-04 04:36:04', 1),
(149, '255010', '2022-10-06 07:27:29', '2022-10-06 07:55:49', 2),
(150, '255001', '2022-10-06 07:54:54', '2022-10-06 07:54:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `description` varchar(200) NOT NULL,
  `agent` varchar(100) NOT NULL,
  `platform` varchar(100) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `due_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `empID`, `description`, `agent`, `platform`, `ip_address`, `due_date`) VALUES
(1, 'TZ346', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-07 06:14:08'),
(2, 'TZ1110594', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-07 06:17:29'),
(3, 'TZ394', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-07 06:18:17'),
(4, 'TZ394', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-07 06:19:47'),
(5, 'S21179', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-07 06:20:00'),
(6, 'TZ346', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-07 06:39:19'),
(7, 'TZ1114433', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-07 06:39:27'),
(8, 'S21179', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-07 06:43:17'),
(9, 'TZ1114433', 'Logged out', 'Firefox 78.0', 'Windows 10', '169.255.114.92', '2020-07-07 06:43:40'),
(10, 'TZ1114433', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-07 06:43:52'),
(11, 'TZ1114433', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '156.159.205.18', '2020-07-07 12:44:29'),
(12, 'TZ1114433', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '156.159.205.18', '2020-07-07 12:45:06'),
(13, 'TZ1114433', 'Logged In', 'Chrome 83.0.4103.106', 'Android', '41.75.223.154', '2020-07-07 22:45:44'),
(14, 'TZ1114433', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 00:27:29'),
(15, 'S21179', 'Logged In', 'Firefox 78.0', 'Windows 10', '169.255.114.92', '2020-07-08 00:36:23'),
(16, 'TZ1114433', 'Run payroll of date 2019-01-23', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 00:38:34'),
(17, 'TZ394', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 00:38:42'),
(18, 'TZ1114433', 'Generating checklist with arrears payment of payroll of date 2019-01-23', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 00:39:02'),
(19, 'TZ394', 'Recommendation of payroll of date 2020-07-08', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 00:43:57'),
(20, 'S21179', 'Approved payment of payroll of date 2019-01-23', 'Firefox 78.0', 'Windows 10', '169.255.114.92', '2020-07-08 00:53:50'),
(21, 'TZ1114433', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 01:04:06'),
(22, 'TZ1114433', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 01:16:53'),
(23, '255005', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 01:17:13'),
(24, '255005', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 01:17:17'),
(25, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 01:20:51'),
(26, '255001', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 01:24:44'),
(27, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 01:24:56'),
(28, '255001', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 01:36:05'),
(29, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 01:36:16'),
(30, '255001', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 01:53:08'),
(31, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 01:53:16'),
(32, 'TZ1114433', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 02:09:28'),
(33, '255001', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 02:25:44'),
(34, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 02:25:54'),
(35, 'S21179', 'Logged out', 'Firefox 78.0', 'Windows 10', '169.255.114.92', '2020-07-08 02:27:30'),
(36, 'TZ394', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 02:27:51'),
(37, '255001', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 02:48:13'),
(38, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 03:18:17'),
(39, '255010', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '156.157.14.75', '2020-07-08 03:40:14'),
(40, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 04:18:02'),
(41, '255010', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '156.157.14.75', '2020-07-08 04:24:22'),
(42, '255010', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '156.157.14.75', '2020-07-08 04:24:26'),
(43, '255073', 'Logged In', 'Firefox 78.0', 'Windows 10', '156.157.14.75', '2020-07-08 04:24:54'),
(44, '255001', 'Run payroll of date 2019-01-29', 'Chrome 83.0.4103.116', 'Windows 10', '156.157.14.75', '2020-07-08 04:26:04'),
(45, '255001', 'Generating checklist of full payment of payroll of date 2019-01-29', 'Chrome 83.0.4103.116', 'Windows 10', '156.157.14.75', '2020-07-08 04:26:11'),
(46, '255001', 'Generating checklist of full payment of payroll of date 2019-01-29', 'Chrome 83.0.4103.116', 'Windows 10', '156.157.14.75', '2020-07-08 04:35:07'),
(47, '255010', 'Recommendation of payroll of date 2020-07-08', 'Chrome 83.0.4103.116', 'Windows 10', '156.157.14.75', '2020-07-08 04:35:31'),
(48, '255073', 'Approved payment of payroll of date 2019-01-29', 'Firefox 78.0', 'Windows 10', '156.157.14.75', '2020-07-08 04:35:53'),
(49, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 04:39:08'),
(50, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '156.157.14.75', '2020-07-08 05:29:38'),
(51, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 05:54:35'),
(52, '255010', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '156.157.14.75', '2020-07-08 05:56:33'),
(53, '255010', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '156.157.14.75', '2020-07-08 05:57:35'),
(54, '255001', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 06:25:21'),
(55, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-08 07:04:15'),
(56, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-09 06:28:02'),
(57, '255010', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-09 06:28:29'),
(58, '255073', 'Logged In', 'Firefox 78.0', 'Windows 10', '169.255.114.92', '2020-07-09 06:29:14'),
(59, '255001', 'Created New Overtime ', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-09 02:49:25'),
(60, '255001', 'Created New Overtime ', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-09 02:51:29'),
(61, '255001', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '197.186.150.54', '2020-07-09 07:48:29'),
(62, '255010', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '197.186.150.54', '2020-07-09 07:49:08'),
(63, '255073', 'Logged out', 'Firefox 78.0', 'Windows 10', '197.186.150.54', '2020-07-09 07:49:14'),
(64, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '197.186.150.54', '2020-07-09 07:52:31'),
(65, '255010', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '197.186.150.54', '2020-07-09 07:52:46'),
(66, '255073', 'Logged In', 'Firefox 78.0', 'Windows 10', '197.186.150.54', '2020-07-09 07:53:01'),
(67, '255001', 'Run payroll of date 2019-02-19', 'Chrome 83.0.4103.116', 'Windows 10', '197.186.150.54', '2020-07-09 08:50:54'),
(68, '255001', 'Generating checklist with arrears payment of payroll of date 2019-02-19', 'Chrome 83.0.4103.116', 'Windows 10', '197.186.150.54', '2020-07-09 08:51:49'),
(69, '255010', 'Recommendation of payroll of date 2020-07-09', 'Chrome 83.0.4103.116', 'Windows 10', '197.186.150.54', '2020-07-09 09:04:24'),
(70, '255073', 'Approved payment of payroll of date 2019-02-19', 'Firefox 78.0', 'Windows 10', '197.186.150.54', '2020-07-09 09:06:28'),
(71, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-09 23:40:14'),
(72, '255010', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-09 23:41:04'),
(73, '255001', 'Logged In', 'Chrome 83.0.4103.97', 'Windows 10', '169.255.114.92', '2020-07-13 05:19:19'),
(74, '255001', 'Logged out', 'Chrome 83.0.4103.97', 'Windows 10', '169.255.114.92', '2020-07-13 05:19:53'),
(75, '255010', 'Logged In', 'Chrome 83.0.4103.97', 'Windows 10', '169.255.114.92', '2020-07-13 05:20:32'),
(76, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-14 04:25:16'),
(77, '255001', 'Registered New Employee ', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-14 12:26:26'),
(78, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-15 05:06:54'),
(79, '255001', 'Logged In', 'Firefox 58.0', 'Linux', '156.157.57.240', '2020-07-15 09:01:13'),
(80, '255001', 'Run payroll of date 2020-07-19', 'Firefox 58.0', 'Linux', '156.157.57.240', '2020-07-15 09:03:22'),
(81, '255001', 'Generating checklist with arrears payment of payroll of date 2020-07-19', 'Firefox 58.0', 'Linux', '156.157.57.240', '2020-07-15 09:04:30'),
(82, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-16 04:38:58'),
(83, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-16 04:51:07'),
(84, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-16 06:29:01'),
(85, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-16 06:44:36'),
(86, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '197.187.156.231', '2020-07-16 07:04:33'),
(87, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-16 08:19:58'),
(88, '255001', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-16 08:20:20'),
(89, '255010', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-16 08:20:27'),
(90, '255010', 'Logged out', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-16 08:20:54'),
(91, '255001', 'Logged In', 'Chrome 83.0.4103.116', 'Windows 10', '169.255.114.92', '2020-07-20 04:26:32'),
(92, '255001', 'Logged In', 'Chrome 84.0.4147.105', 'Windows 10', '169.255.114.180', '2020-07-30 06:32:07'),
(93, '255001', 'Run payroll of date 2020-07-22', 'Chrome 84.0.4147.105', 'Windows 10', '169.255.114.180', '2020-07-30 08:16:02'),
(94, '255014', 'Logged In', 'Chrome 84.0.4147.105', 'Windows 10', '197.250.227.193', '2020-08-01 00:57:50'),
(95, '255014', 'Logged out', 'Chrome 84.0.4147.105', 'Windows 10', '197.250.227.193', '2020-08-01 01:01:06'),
(96, '255001', 'Logged In', 'Chrome 84.0.4147.105', 'Windows 10', '197.250.227.193', '2020-08-01 01:01:36'),
(97, '255001', 'Logged out', 'Chrome 84.0.4147.105', 'Windows 10', '197.250.227.193', '2020-08-01 01:57:00'),
(98, '255024', 'Logged In', 'Chrome 84.0.4147.105', 'Windows 10', '197.250.227.193', '2020-08-01 01:57:26'),
(99, '255001', 'Logged In', 'Chrome 84.0.4147.105', 'Windows 10', '169.255.114.92', '2020-08-04 04:38:09'),
(100, '255001', 'Logged out', 'Chrome 84.0.4147.105', 'Windows 10', '169.255.114.92', '2020-08-04 04:39:18'),
(101, '255024', 'Logged In', 'Chrome 84.0.4147.105', 'Windows 10', '169.255.114.92', '2020-08-04 05:02:34'),
(102, '255001', 'Logged In', 'Chrome 84.0.4147.105', 'Windows 10', '169.255.114.92', '2020-08-05 04:47:01'),
(103, '255001', 'Logged out', 'Chrome 84.0.4147.105', 'Windows 10', '169.255.114.92', '2020-08-05 04:48:08'),
(104, '255001', 'Logged In', 'Chrome 84.0.4147.105', 'Windows 10', '169.255.114.92', '2020-08-05 05:20:44'),
(105, '255024', 'Logged In', 'Chrome 84.0.4147.105', 'Windows 10', '169.255.114.92', '2020-08-05 07:31:24'),
(106, '255001', 'Logged In', 'Chrome 84.0.4147.125', 'Windows 10', '169.255.114.92', '2020-08-18 09:43:20'),
(107, '255001', 'Logged In', 'Chrome 84.0.4147.125', 'Windows 10', '41.78.171.49', '2020-08-18 09:43:20'),
(108, '255001', 'Logged out', 'Chrome 84.0.4147.125', 'Windows 10', '41.78.171.49', '2020-08-18 10:11:36'),
(109, '255001', 'Logged out', 'Chrome 84.0.4147.125', 'Windows 10', '169.255.114.92', '2020-08-18 10:35:17'),
(110, '255001', 'Logged In', 'Chrome 84.0.4147.135', 'Windows 10', '169.255.114.92', '2020-08-21 02:49:01'),
(111, '255001', 'Generating checklist of full payment of payroll of date 2020-07-22', 'Chrome 84.0.4147.135', 'Windows 10', '169.255.114.92', '2020-08-21 02:49:29'),
(112, '255001', 'Logged In', 'Chrome 84.0.4147.135', 'Windows 10', '169.255.114.92', '2020-08-27 06:59:22'),
(113, '255001', 'Logged In', 'Chrome 84.0.4147.135', 'Windows 10', '169.255.114.92', '2020-08-28 08:26:16'),
(114, '255001', 'Logged out', 'Chrome 84.0.4147.135', 'Windows 10', '169.255.114.92', '2020-08-28 08:43:26'),
(115, '255001', 'Logged In', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-01 02:53:12'),
(116, '255001', 'Logged In', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 00:03:28'),
(117, '255001', 'Assigned a Deduction to an Employee of ID =255001', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 08:27:15'),
(118, '255001', 'Removed From Deduction an Employees of IDs =255001', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 08:27:29'),
(119, '255001', 'Assigned a Deduction to a Group of ID =14', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 08:28:27'),
(120, '255001', 'Removed From Deduction Groups of IDs =14', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 08:28:44'),
(121, '255001', 'Logged out', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 01:42:56'),
(122, '255005', 'Logged In', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 01:43:06'),
(123, '255005', 'Logged out', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 01:44:00'),
(124, '255010', 'Logged In', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 01:44:10'),
(125, '255010', 'Logged out', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 01:48:45'),
(126, '255001', 'Logged In', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 01:49:11'),
(127, '255001', 'Logged out', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 01:50:07'),
(128, '255024', 'Logged In', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 01:50:17'),
(129, '255024', 'Logged out', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 01:52:04'),
(130, '255014', 'Logged In', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 01:52:18'),
(131, '255014', 'Logged out', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 01:53:18'),
(132, '255001', 'Logged In', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 01:53:24'),
(133, '255001', 'Requested Deactivation of an Employee with ID =255027', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 09:57:26'),
(134, '255001', 'Logged out', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 01:59:18'),
(135, '255024', 'Logged In', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 01:59:29'),
(136, '255024', 'Exit Confirm Employee of ID =255027', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 10:01:09'),
(137, '255024', 'Exit Confirm Employee of ID =255027', 'Firefox 80.0', 'Linux', '169.255.114.92', '2020-09-02 10:01:09'),
(138, '255001', 'Logged In', 'Chrome 85.0.4183.83', 'Windows 10', '169.255.114.92', '2020-09-02 02:23:24'),
(139, '255001', 'Logged In', 'Chrome 84.0.4147.135', 'Windows 10', '155.12.63.158', '2020-09-02 02:27:18'),
(140, '255010', 'Logged In', 'Chrome 85.0.4183.83', 'Windows 10', '155.12.63.158', '2020-09-02 02:27:28'),
(141, '255073', 'Logged In', 'Firefox 80.0', 'Windows 10', '155.12.63.158', '2020-09-02 02:27:44'),
(142, '255001', 'Activation of Employee with ID =255019', 'Chrome 85.0.4183.83', 'Windows 10', '169.255.114.92', '2020-09-02 10:32:27'),
(143, '255001', 'Activation of Employee with ID =255017', 'Chrome 85.0.4183.83', 'Windows 10', '169.255.114.92', '2020-09-02 10:32:33'),
(144, '255001', 'Requested Deactivation of an Employee with ID =255016', 'Chrome 85.0.4183.83', 'Windows 10', '169.255.114.92', '2020-09-02 10:33:45'),
(145, '255001', 'Exit Cancelled of an Employee with ID =255016', 'Chrome 85.0.4183.83', 'Windows 10', '169.255.114.92', '2020-09-02 10:33:56'),
(146, '255001', 'Activation of Employee with ID =255016', 'Chrome 85.0.4183.83', 'Windows 10', '169.255.114.92', '2020-09-02 10:34:02'),
(147, '255001', 'Logged out', 'Chrome 85.0.4183.83', 'Windows 10', '169.255.114.92', '2020-09-02 02:50:45'),
(148, '255001', 'Run payroll of date 2020-04-25', 'Chrome 84.0.4147.135', 'Windows 10', '155.12.63.158', '2020-09-02 03:01:06'),
(149, '255001', 'Generating checklist of full payment of payroll of date 2020-04-25', 'Chrome 84.0.4147.135', 'Windows 10', '155.12.63.158', '2020-09-02 03:02:09'),
(150, '255010', 'Recommendation of payroll of date 2020-09-02', 'Chrome 85.0.4183.83', 'Windows 10', '155.12.63.158', '2020-09-02 03:07:34'),
(151, '255073', 'Approved payment of payroll of date 2020-04-25', 'Firefox 80.0', 'Windows 10', '155.12.63.158', '2020-09-02 03:08:13'),
(152, '255001', 'Run payroll of date 2020-09-09', 'Chrome 84.0.4147.135', 'Windows 10', '155.12.63.158', '2020-09-02 03:17:12'),
(153, '255001', 'Generating checklist of full payment of payroll of date 2020-04-25', 'Chrome 84.0.4147.135', 'Windows 10', '155.12.63.158', '2020-09-02 03:18:14'),
(154, '255001', 'Logged out', 'Chrome 84.0.4147.135', 'Windows 10', '197.250.228.252', '2020-09-02 03:36:26'),
(155, '255001', 'Logged In', 'Chrome 85.0.4183.83', 'Windows 10', '169.255.114.92', '2020-09-09 07:30:25'),
(156, '255001', 'Logged out', 'Chrome 85.0.4183.83', 'Windows 10', '169.255.114.92', '2020-09-09 07:41:42'),
(157, '255001', 'Logged In', 'Chrome 85.0.4183.102', 'Windows 10', '169.255.114.92', '2020-09-10 03:44:48'),
(158, '255001', 'Logged In', 'Chrome 85.0.4183.102', 'Windows 10', '169.255.114.92', '2020-09-10 05:53:23'),
(159, '255001', 'Logged In', 'Chrome 85.0.4183.102', 'Windows 10', '169.255.114.92', '2020-09-11 04:13:41'),
(160, '255001', 'Logged In', 'Chrome 85.0.4183.102', 'Windows 10', '169.255.114.92', '2020-09-15 07:00:48'),
(161, '255001', 'Logged out', 'Chrome 85.0.4183.102', 'Windows 10', '169.255.114.92', '2020-09-15 07:02:31'),
(162, '255001', 'Logged In', 'Chrome 85.0.4183.102', 'Windows 10', '169.255.114.92', '2020-09-15 08:09:54'),
(163, '255001', 'Logged out', 'Chrome 85.0.4183.102', 'Windows 10', '169.255.114.92', '2020-09-15 08:11:01'),
(164, '255001', 'Logged In', 'Chrome 85.0.4183.102', 'Windows 10', '169.255.114.92', '2020-09-16 06:41:01'),
(165, '255001', 'Logged In', 'Chrome 86.0.4240.75', 'Windows 10', '197.250.227.68', '2020-10-16 06:52:21'),
(166, '255001', 'Logged In', 'Chrome 86.0.4240.75', 'Windows 10', '169.255.114.180', '2020-10-23 03:46:23'),
(167, '255001', 'Logged In', 'Chrome 86.0.4240.183', 'Windows 10', '169.255.114.180', '2020-11-10 22:54:19'),
(168, '255001', 'Logged In', 'Chrome 86.0.4240.183', 'Windows 10', '169.255.114.180', '2020-11-10 22:54:19'),
(169, '255001', 'Logged In', 'Chrome 90.0.4430.212', 'Windows 10', '169.255.114.182', '2021-05-20 02:12:17'),
(170, '255001', 'Requested Deactivation of an Employee with ID =255017', 'Chrome 90.0.4430.212', 'Windows 10', '169.255.114.182', '2021-05-20 11:25:31'),
(171, '255001', 'Logged In', 'Chrome 91.0.4472.114', 'Windows 10', '169.255.114.182', '2021-06-24 02:00:38'),
(172, '255001', 'Logged In', 'Chrome 104.0.5112.115', 'Windows 10', '169.255.114.182', '2022-09-09 08:44:50'),
(173, '255001', 'Logged In', 'Chrome 104.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-09 08:47:35'),
(174, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-09 08:53:33'),
(175, '255001', 'Logged In', 'Chrome 104.0.5112.102', 'Windows 10', '41.222.181.188', '2022-09-13 09:40:57'),
(176, '255001', 'Logged out', 'Chrome 104.0.5112.102', 'Windows 10', '41.222.181.188', '2022-09-13 09:51:29'),
(177, '255034', 'Logged In', 'Chrome 104.0.5112.102', 'Windows 10', '41.222.181.188', '2022-09-13 09:51:37'),
(178, '255034', 'Logged out', 'Chrome 104.0.5112.102', 'Windows 10', '41.222.181.188', '2022-09-13 09:51:45'),
(179, '255034', 'Logged In', 'Chrome 104.0.5112.102', 'Windows 10', '41.222.181.188', '2022-09-13 09:51:58'),
(180, '255001', 'Logged In', 'Chrome 104.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 08:29:57'),
(181, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 08:31:40'),
(182, '255001', 'Requested Deactivation of an Employee with ID =255019', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 11:51:28'),
(183, '255001', 'Run payroll of date 2022-09-14', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 09:39:08'),
(184, '255001', 'Generating checklist of full payment of payroll of date 2022-09-14', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 09:53:19'),
(185, '255001', 'Logged out', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 09:54:05'),
(186, '255010', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 09:54:50'),
(187, '255010', 'Logged out', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 09:55:59'),
(188, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 09:56:09'),
(189, '255001', 'Logged out', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 09:57:52'),
(190, '255010', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 09:58:06'),
(191, '255010', 'Recommendation of Arreas on date 2022-09-14', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 09:58:38'),
(192, '255010', 'Recommendation of payroll of date 2022-09-14', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 09:59:25'),
(193, '255010', 'Logged out', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 09:59:57'),
(194, '255073', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 10:00:23'),
(195, '255073', 'Approved payment of payroll of date 2022-09-14', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 10:02:50'),
(196, '255073', 'Logged out', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 10:03:37'),
(197, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 10:03:50'),
(198, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 10:08:58'),
(199, '255001', 'Logged out', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 10:10:24'),
(200, '255010', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 10:10:35'),
(201, '255010', 'Logged out', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 10:12:27'),
(202, '255073', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 10:12:38'),
(203, '255001', 'Logged In', 'Chrome 103.0.0.0', 'Android', '197.250.228.126', '2022-09-14 10:36:54'),
(204, '255034', 'Logged In', 'Chrome 104.0.5112.102', 'Windows 10', '169.255.114.182', '2022-09-14 10:42:23'),
(205, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 10:44:14'),
(206, '255001', 'Logged out', 'Chrome 105.0.0.0', 'Windows 10', '197.250.228.254', '2022-09-14 10:50:12'),
(207, '255001', 'Logged In', 'Firefox 104.0', 'Windows 10', '197.250.228.126', '2022-09-14 10:54:36'),
(208, '255001', 'Logged In', 'Firefox 104.0', 'Windows 10', '197.250.228.254', '2022-09-14 10:55:16'),
(209, '255001', 'Logged In', 'Firefox 104.0', 'Windows 10', '197.250.228.254', '2022-09-14 10:56:17'),
(210, '255001', 'Logged In', 'Firefox 104.0', 'Windows 10', '197.250.228.126', '2022-09-14 11:01:03'),
(211, '255001', 'Run payroll of date 2022-08-31', 'Firefox 104.0', 'Windows 10', '197.250.228.126', '2022-09-14 11:02:31'),
(212, '255001', 'Logged out', 'Firefox 104.0', 'Windows 10', '197.250.228.126', '2022-09-14 11:03:00'),
(213, '255010', 'Logged In', 'Firefox 104.0', 'Windows 10', '197.250.228.254', '2022-09-14 11:03:28'),
(214, '255010', 'Recommendation of payroll of date 2022-09-14', 'Firefox 104.0', 'Windows 10', '197.250.228.254', '2022-09-14 11:03:52'),
(215, '255010', 'Logged out', 'Firefox 104.0', 'Windows 10', '197.250.228.126', '2022-09-14 11:06:06'),
(216, '255073', 'Logged In', 'Firefox 104.0', 'Windows 10', '197.250.228.254', '2022-09-14 11:09:24'),
(217, '255073', 'Approved payment of payroll of date 2022-08-31', 'Firefox 104.0', 'Windows 10', '197.250.228.254', '2022-09-14 11:09:42'),
(218, '255073', 'Logged out', 'Firefox 104.0', 'Windows 10', '197.250.228.254', '2022-09-14 11:10:20'),
(219, '255001', 'Logged In', 'Firefox 104.0', 'Windows 10', '197.250.228.126', '2022-09-14 11:10:34'),
(220, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 11:25:18'),
(221, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 11:25:40'),
(222, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 11:27:00'),
(223, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 11:30:58'),
(224, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 11:37:05'),
(225, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 11:37:24'),
(226, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 11:37:42'),
(227, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 11:38:44'),
(228, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 11:39:53'),
(229, '255073', 'Logged out', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 12:14:54'),
(230, '255001', 'Logged In', 'Chrome 104.0.5112.102', 'Windows 10', '169.255.114.182', '2022-09-14 12:22:38'),
(231, '255001', 'Logged In', 'Chrome 104.0.5112.102', 'Windows 10', '169.255.114.182', '2022-09-14 12:22:48'),
(232, '255001', 'Logged In', 'Chrome 104.0.5112.102', 'Windows 10', '169.255.114.182', '2022-09-14 12:25:49'),
(233, '255001', 'Logged In', 'Chrome 104.0.5112.102', 'Windows 10', '169.255.114.182', '2022-09-14 12:26:21'),
(234, '255001', 'Logged In', 'Chrome 107.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 12:27:19'),
(235, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-09-14 14:21:13'),
(236, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '197.250.228.126', '2022-09-15 15:32:41'),
(237, '255001', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '197.215.249.182', '2022-10-01 07:32:40'),
(238, '255001', 'Registered New Employee ', 'Chrome 106.0.0.0', 'Windows 10', '197.215.249.182', '2022-10-01 11:05:06'),
(239, '255001', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '197.215.249.182', '2022-10-01 08:16:42'),
(240, '255010', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '197.215.249.182', '2022-10-01 08:17:44'),
(241, '255028', 'Logged In', 'Firefox 91.0', 'Windows 10', '154.74.127.179', '2022-10-01 08:44:19'),
(242, '255010', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '197.215.249.182', '2022-10-01 08:52:09'),
(243, '255001', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '197.215.249.182', '2022-10-01 08:52:20'),
(244, '255028', 'Logged In', 'Firefox 91.0', 'Windows 10', '41.222.180.166', '2022-10-02 03:42:43'),
(245, '255028', 'Created New Deduction ', 'Firefox 91.0', 'Windows 10', '41.222.180.166', '2022-10-02 06:51:32'),
(246, '255028', 'Created New Overtime ', 'Firefox 91.0', 'Windows 10', '41.222.180.166', '2022-10-02 06:54:58'),
(247, '255028', 'Created New Allowance ', 'Firefox 91.0', 'Windows 10', '41.222.180.166', '2022-10-02 06:56:16'),
(248, '255028', 'Created New Role with empty permission set', 'Firefox 91.0', 'Windows 10', '41.222.180.166', '2022-10-02 06:56:57'),
(249, '255028', 'Run payroll of date 2022-10-02', 'Firefox 91.0', 'Windows 10', '41.222.180.166', '2022-10-02 04:06:36'),
(250, '255028', 'Generating checklist of full payment of payroll of date 2022-10-02', 'Firefox 91.0', 'Windows 10', '41.222.180.166', '2022-10-02 04:53:30'),
(251, '255025', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.180.166', '2022-10-02 05:10:08'),
(252, '255028', 'Registered New Employee ', 'Firefox 91.0', 'Windows 10', '41.222.180.166', '2022-10-02 08:18:33'),
(253, '255028', 'Logged out', 'Firefox 91.0', 'Windows 10', '41.222.180.166', '2022-10-02 05:21:05'),
(254, '255001', 'Logged In', 'Firefox 91.0', 'Windows 10', '41.222.180.166', '2022-10-02 05:21:52'),
(255, '255001', 'Registered New Employee ', 'Firefox 91.0', 'Windows 10', '41.222.180.166', '2022-10-02 08:27:01'),
(256, '255028', 'Logged In', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 05:57:14'),
(257, '255001', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 06:06:30'),
(258, '255028', 'Logged out', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 06:07:28'),
(259, '255028', 'Logged out', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 06:08:03'),
(260, '255001', 'Logged In', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 06:10:44'),
(261, '255001', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 06:18:34'),
(262, '255001', 'Registered New Employee ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 09:29:33'),
(263, '255001', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 06:29:58'),
(264, '255001', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 06:31:32'),
(265, '255073', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 06:31:49'),
(266, '255073', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 06:32:48'),
(267, '255025', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 06:33:27'),
(268, '255025', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 06:33:51'),
(269, '255034', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 06:34:17'),
(270, '255034', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 06:35:40'),
(271, '255028', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 06:36:08'),
(272, '255028', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 06:40:33'),
(273, '255025', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 06:40:40'),
(274, '255025', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 06:48:18'),
(275, '255010', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 06:48:45'),
(276, '255010', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 06:49:53'),
(277, '255001', 'Registered New Employee ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 10:01:13'),
(278, '255001', 'Registered New Employee ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 10:17:57'),
(279, '255001', 'Registered New Employee ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 10:50:55'),
(280, '255001', 'Registered New Employee ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 10:57:49'),
(281, '255001', 'Registered New Employee ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 11:08:19'),
(282, '255001', 'Registered New Employee ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 11:24:04'),
(283, '255001', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 08:31:52'),
(284, '255001', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 08:32:28'),
(285, '255025', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 08:33:18'),
(286, '255025', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 08:39:33'),
(287, '9090', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 08:39:53'),
(288, '9090', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 08:41:13'),
(289, '9090', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 08:45:29'),
(290, '255001', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 08:45:58'),
(291, '255001', 'Registered New Employee ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 12:03:13'),
(292, '255001', 'Registered New Employee ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 12:08:47'),
(293, '255001', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 09:13:45'),
(294, '255025', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 09:15:04'),
(295, '255001', 'Registered New Employee ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 12:18:56'),
(296, '255001', 'Assigned a Role with IDs  2  to User with ID 9090 ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 12:23:25'),
(297, '255025', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 09:25:47'),
(298, '9090', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 09:26:07'),
(299, '255001', 'Assigned a Role with IDs  25  to User with ID 9090 ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 12:27:11'),
(300, '9090', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 09:27:32'),
(301, '9090', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 09:27:37'),
(302, '255001', 'Revoked a Role with IDs  25  to User with ID 9090 ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 12:31:05'),
(303, '255001', 'Revoked a Role with IDs  2  to User with ID 9090 ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 12:31:12'),
(304, '255001', 'Assigned a Role with IDs  2  to User with ID 9090 ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 12:31:22'),
(305, '255001', 'Registered New Employee ', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 12:35:48'),
(306, '9090', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 09:37:36'),
(307, '5050', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 09:37:46'),
(308, '5050', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 09:38:21'),
(309, '5050', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 09:51:34'),
(310, '9090', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 09:51:41'),
(311, '255001', 'Logged out', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 10:12:35'),
(312, '5050', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 10:13:44'),
(313, '5050', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 10:14:42'),
(314, '5050', 'Logged In', 'Firefox 91.0', 'Windows 10', '41.222.179.146', '2022-10-04 10:15:02'),
(315, '5050', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 10:15:34'),
(316, '5050', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 10:16:01'),
(317, '9090', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 10:16:17'),
(318, '5050', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 10:16:30'),
(319, '5050', 'Logged out', 'Chrome 104.0.0.0', 'Linux', '41.222.179.146', '2022-10-04 10:16:34'),
(320, '5050', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 10:16:50'),
(321, '5050', 'Logged out', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 10:49:49'),
(322, '9090', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 10:50:07'),
(323, '255001', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 12:41:24'),
(324, '255001', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 12:41:29'),
(325, '5050', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 12:43:19'),
(326, '5050', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 13:34:51'),
(327, '9090', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 13:35:19'),
(328, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 13:36:49'),
(329, '255001', 'Logged out', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 13:40:02'),
(330, '255010', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 13:41:10'),
(331, '9090', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 13:46:47'),
(332, '255001', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 13:47:27'),
(333, '255073', 'Logged In', 'Firefox 104.0', 'Windows 10', '169.255.114.182', '2022-10-04 14:00:49'),
(334, '255001', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 14:06:28'),
(335, '5050', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 14:06:59'),
(336, '5050', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 14:07:21'),
(337, '255001', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 14:07:41'),
(338, '255001', 'Run payroll of date 2022-10-04', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 14:08:27'),
(339, '255010', 'Recommendation of payroll of date 2022-10-04', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 14:09:32'),
(340, '255073', 'Approved payment of payroll of date 2022-10-04', 'Firefox 104.0', 'Windows 10', '169.255.114.182', '2022-10-04 14:09:59'),
(341, '255001', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 14:12:43'),
(342, '5050', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-04 14:12:57'),
(343, '255028', 'Logged In', 'Firefox 91.0', 'Windows 10', '127.0.0.1', '2022-10-05 17:58:26'),
(344, '255028', 'Logged out', 'Firefox 91.0', 'Windows 10', '127.0.0.1', '2022-10-05 23:38:05'),
(345, '5050', 'Logged In', 'Firefox 91.0', 'Windows 10', '127.0.0.1', '2022-10-05 23:38:30'),
(346, '5050', 'Logged out', 'Firefox 91.0', 'Windows 10', '127.0.0.1', '2022-10-05 23:46:49'),
(347, '255028', 'Logged In', 'Firefox 91.0', 'Windows 10', '127.0.0.1', '2022-10-05 23:46:54'),
(348, '255028', 'Logged out', 'Firefox 91.0', 'Windows 10', '127.0.0.1', '2022-10-06 01:02:53'),
(349, '255028', 'Logged In', 'Firefox 91.0', 'Windows 10', '127.0.0.1', '2022-10-06 01:03:01'),
(350, '255028', 'Logged In', 'Firefox 91.0', 'Windows 10', '127.0.0.1', '2022-10-06 04:57:25'),
(351, '255028', 'Logged In', 'Firefox 91.0', 'Windows 10', '154.74.127.164', '2022-10-06 01:19:26'),
(352, '255001', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 04:00:10'),
(353, '255001', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 04:04:01'),
(354, '255010', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 04:04:25'),
(355, '255010', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 04:27:36'),
(356, '255001', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 04:30:20'),
(357, '255001', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 04:54:59'),
(358, '255010', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 04:55:18'),
(359, '255010', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 04:55:57'),
(360, '255001', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 04:56:16'),
(361, '255001', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 04:58:57'),
(362, '255010', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 04:59:22'),
(363, '255010', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 05:00:13'),
(364, '255001', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 05:00:28'),
(365, '255001', 'Revoked a Role with IDs  25  to User with ID 255001 ', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 08:02:10'),
(366, '255001', 'Assigned a Role with IDs  13  to User with ID 255001 ', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 08:02:22'),
(367, '255001', 'Assigned a Role with IDs  26  to User with ID 255001 ', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 08:02:31'),
(368, '255001', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 05:03:04'),
(369, '255001', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 05:03:15'),
(370, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 05:21:42'),
(371, '255001', 'Logged out', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 05:22:16'),
(372, '255001', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 05:22:26'),
(373, '255028', 'Logged In', 'Firefox 91.0', 'Windows 10', '169.255.114.182', '2022-10-06 05:26:06'),
(374, '255028', 'Logged In', 'Firefox 91.0', 'Windows 10', '41.222.179.152', '2022-10-06 08:03:10'),
(375, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-06 13:00:17'),
(376, '255001', 'Logged In', 'Chrome 105.0.0.0', 'Windows 10', '169.255.114.182', '2022-10-07 09:58:41'),
(377, '255001', 'Logged In', 'Chrome 106.0.0.0', 'Windows 10', '197.250.227.122', '2022-10-14 08:07:14'),
(378, '255001', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '169.255.114.182', '2022-10-17 13:58:54'),
(379, '5050', 'Logged In', 'Chrome 104.0.0.0', 'Linux', '169.255.114.182', '2022-10-17 13:59:36'),
(380, '255028', 'Logged In', 'Firefox 91.0', 'Windows 10', '169.255.114.182', '2022-10-17 14:00:21'),
(381, '255028', 'Logged In', 'Firefox 91.0', 'Windows 10', '169.255.114.182', '2022-10-17 14:00:27'),
(382, '255028', 'Logged In', 'Firefox 91.0', 'Windows 10', '169.255.114.182', '2022-10-17 14:00:44'),
(383, '255028', 'Logged In', 'Chrome 107.0.0.0', 'Windows 10', '169.255.114.182', '2022-11-23 07:09:29'),
(384, '255028', 'Registered New Employee ', 'Chrome 107.0.0.0', 'Windows 10', '169.255.114.182', '2022-11-23 10:45:50'),
(385, '255028', 'Run payroll of date 2022-11-23', 'Chrome 107.0.0.0', 'Windows 10', '169.255.114.182', '2022-11-23 08:05:22'),
(386, '255028', 'Logged out', 'Chrome 107.0.0.0', 'Windows 10', '169.255.114.182', '2022-11-23 08:09:06'),
(387, '255001', 'Logged In', 'Chrome 107.0.0.0', 'Windows 10', '169.255.114.182', '2022-11-23 08:09:26'),
(388, '255001', 'Recommendation of payroll of date 2022-11-23', 'Chrome 107.0.0.0', 'Windows 10', '169.255.114.182', '2022-11-23 08:10:28'),
(389, '255001', 'Recommendation of payroll of date 2022-11-23', 'Chrome 107.0.0.0', 'Windows 10', '169.255.114.182', '2022-11-23 08:10:28');

-- --------------------------------------------------------

--
-- Table structure for table `audit_purge_logs`
--

CREATE TABLE `audit_purge_logs` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `agent` varchar(100) DEFAULT NULL,
  `platform` varchar(100) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audit_purge_logs`
--

INSERT INTO `audit_purge_logs` (`id`, `empID`, `description`, `agent`, `platform`, `ip_address`, `due_date`) VALUES
(4, 'TZ1114433', 'Cleared Audit logs', 'Firefox 78.0', NULL, '169.255.114.92', '2020-07-07 14:08:09');

-- --------------------------------------------------------

--
-- Table structure for table `audit_trails`
--

CREATE TABLE `audit_trails` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_performed` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `risk` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_trails`
--

INSERT INTO `audit_trails` (`id`, `user_id`, `user_name`, `user_email`, `action_performed`, `ip_address`, `user_agent`, `risk`, `created_at`, `updated_at`) VALUES
(1, 1, 'CITS Test Account', 'admin@gmail.com', 'Employee Created', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 3, '2022-12-05 08:50:54', '2022-12-05 08:50:54'),
(2, 1, 'CITS Test Account', 'admin@gmail.com', 'Employee Created', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 3, '2022-12-05 08:55:02', '2022-12-05 08:55:02'),
(3, 1, 'CITS Test Account', 'admin@gmail.com', 'Generating checklist of full payment of payroll of date 2022-11-23', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; rv:91.0) Gecko/20100101 Firefox/91.0', 2, '2022-12-05 09:48:10', '2022-12-05 09:48:10'),
(4, 1, 'CITS Test Account', 'admin@gmail.com', 'Generating checklist of full payment of payroll of date 2022-11-23', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; rv:91.0) Gecko/20100101 Firefox/91.0', 2, '2022-12-05 09:49:52', '2022-12-05 09:49:52'),
(5, 1, 'CITS Test Account', 'admin@gmail.com', 'Generating checklist of full payment of payroll of date 2022-12-06', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; rv:91.0) Gecko/20100101 Firefox/91.0', 2, '2022-12-06 05:52:37', '2022-12-06 05:52:37'),
(6, 1, 'CITS Test Account', 'admin@gmail.com', 'Run payroll of date 2022-12-06', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; rv:91.0) Gecko/20100101 Firefox/91.0', 1, '2022-12-06 06:13:31', '2022-12-06 06:13:31'),
(7, 1, 'CITS Test Account', 'admin@gmail.com', 'Generating checklist of full payment of payroll of date 2022-12-06', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; rv:91.0) Gecko/20100101 Firefox/91.0', 2, '2022-12-06 07:33:08', '2022-12-06 07:33:08'),
(8, 1, 'CITS Test Account', 'admin@gmail.com', 'Run payroll of date 2022-11-07', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; rv:91.0) Gecko/20100101 Firefox/91.0', 1, '2022-12-08 03:28:39', '2022-12-08 03:28:39'),
(9, 1, 'CITS Test Account', 'admin@gmail.com', 'Generating checklist of full payment of payroll of date 2022-11-07', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; rv:91.0) Gecko/20100101 Firefox/91.0', 2, '2022-12-08 03:45:23', '2022-12-08 03:45:23'),
(10, 1, 'CITS Test Account', 'admin@gmail.com', 'Run payroll of date 2022-12-08', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; rv:91.0) Gecko/20100101 Firefox/91.0', 1, '2022-12-08 04:40:44', '2022-12-08 04:40:44'),
(11, 1, 'CITS Test Account', 'admin@gmail.com', 'Run payroll of date 2022-12-08', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 1, '2022-12-08 08:55:44', '2022-12-08 08:55:44');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `abbr` varchar(10) NOT NULL,
  `bank_code` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `name`, `abbr`, `bank_code`) VALUES
(1, 'CRDB Plc', 'CRDB', '003'),
(2, 'National Bank of Commerce', 'NBC', '015'),
(3, 'NMB Plc', 'NMB', '016'),
(4, 'Standard Chartered Bank', 'SCB', '005'),
(5, 'MWP', 'MWP', '000'),
(6, 'Barclays Bank ', 'Barclays', '020'),
(7, 'LLOYDS BANK', 'LLOYDS BAN', 'xxx'),
(8, 'Stanbic Bank', 'Stanbic', '006'),
(12, 'CBA BANK', 'CBA', '023'),
(10, 'EQUITY BANK', 'EQUITY', '047'),
(11, 'Banc ABC', 'Banc ABC', '034'),
(13, 'UBA BANK', 'UBA BANK', '038'),
(14, 'NBC', 'vv', '45');

-- --------------------------------------------------------

--
-- Table structure for table `bank_branch`
--

CREATE TABLE `bank_branch` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `bank` int(11) NOT NULL,
  `street` varchar(30) NOT NULL,
  `region` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `branch_code` varchar(10) NOT NULL,
  `swiftcode` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank_branch`
--

INSERT INTO `bank_branch` (`id`, `name`, `bank`, `street`, `region`, `country`, `branch_code`, `swiftcode`) VALUES
(1, 'UDOM', 1, 'UDOM', 'Dodoma Tanzania', 'Tanzania DRC', '050', '050'),
(2, 'Bukoba', 2, 'Bank Street', 'Bukoba', 'Tanzania', '027', '23931'),
(3, 'Lumumba', 1, 'Lumumba', 'Dar es Salaam', 'Tanzania', '001', '001'),
(4, 'Muhimbili', 3, 'Muhimbili', 'Dar es Salaam', 'Tanzania', '209', '209'),
(5, 'Mlimani', 1, 'University', 'Region', 'Tanzania', '027', '112233'),
(6, 'Head Office', 11, 'Upanga', 'Dar es Salaam', 'Tanzania', '001', '001'),
(7, 'Ohio Street Branch ', 6, 'Ohio', 'Dar es Salaam', 'Tanzania', '001', '001'),
(8, 'Slipway Branch', 6, 'Masaki', 'Dar es Salaam', 'Tanzania', '004', '004'),
(9, 'Mikocheni Branch', 6, 'Mikocheni', 'Dar es Salaam', 'Tanzania', '014', '014'),
(10, 'Mwenge Branch', 6, 'Mwenge', 'Dar es Salaam', 'Tanzania', '012', '012'),
(11, 'Azikiwe', 1, 'Dar es salaam', 'Dar es Salaam', 'Tanzania', '014', '014'),
(12, 'Dodoma Branch', 1, 'Dodoma', 'Dodoma', 'Tanzania', '015', '015'),
(13, 'UDSM Branch', 1, 'Mlimani', 'Dar es Salaam', 'Tanzania', '036', '036'),
(14, 'MPESA', 5, 'Tanzania', 'Tanzania', 'Tanzania', '000', '000'),
(21, 'TIGOP', 5, 'Tanzania', 'Tanzania', 'Tanzania', '000', '000'),
(16, 'Corporate', 2, 'Dar es Salaam', 'Dar es Salaam', 'Tanzania', '011', '011'),
(17, 'Bank House', 3, 'Dar es Salaam', 'Dar es Salaam', 'Tanzania', '201', '201'),
(18, 'Lindi Branch', 3, 'Lindi', 'Lindi', 'Tanzania', '702', '702'),
(19, 'NIC Life House Branch', 4, 'Dar es Salaam', 'Dar es Salaam', 'Tanzania', '080', '080'),
(20, 'Mwanza Branch', 8, 'Tanzania', 'Mwanza', 'Tanzania', '005', '005'),
(22, 'Z-Pesa', 5, 'Tanzainia', 'Tanzania', 'Tanzania', '000', '000'),
(23, 'Airtel Money', 5, 'Tanzania', 'Tanzania', 'Tanzania', '000', '000'),
(24, 'Hallo-Pesa', 5, 'Tanzania', 'Tanzania', 'Tanzania', '000', '000'),
(25, 'Kariakoo Branch', 11, 'Kariakoo', 'Dar es Salaam', 'Tanzania', '005', '005'),
(26, 'Kisutu Branch', 6, 'Kisutu', 'Dar es Salaam', 'Tanzania ', '015', '015'),
(27, 'Iringa Branch', 6, 'Iringa', 'Iringa ', 'Tanzania ', '053', '053'),
(28, 'Slipway Branch', 6, 'Slipway', 'Dar Es Salaam ', 'Tanzania ', '004', '004'),
(29, 'Mikocheni Branch', 6, 'Mikocheni', 'Dar es Saaam', 'Tanzania ', '014', '014'),
(30, 'Mwenge Branch ', 6, 'Mwenge', 'Dar es Salaam', 'Tanzania', '012', '012'),
(31, 'Dodoma Branch ', 1, 'Dodoma', 'Dodoma', 'Tanzania ', '015', '015'),
(32, 'UDSM Branch', 1, 'Mlimani', 'Dar es Salaam', 'Tanzania ', '036', '036'),
(33, 'Lindi Branch ', 3, 'Lindi', 'Lindi', 'Tanzania ', '702', '702'),
(34, 'Kijitonyama', 1, 'Kijitonyama', 'Dar es Salaam', 'Tanzania ', '029', '029'),
(35, 'Samora', 12, 'Samora', 'Dar es Salaam', 'Tanzania ', '001', '001'),
(36, 'Main Branch', 13, 'Pugu Road ', 'Dar es Salaam', 'Tanzania ', '601', '601'),
(37, 'Mnazi Mmoja', 2, 'Mnazi Mmoja', 'Dar es Salaam', 'Tanzania', '018', '018'),
(38, 'Mwenge ', 10, 'Mwenge', 'Dar es Salaam', 'Tanzania ', '007', '007'),
(39, '000', 7, '000', '000', 'UK', '000', '000'),
(40, 'Azikiwe branch', 14, 'azikiwe s', 'dar es salaam', 'tanzania', '089', '0453');

-- --------------------------------------------------------

--
-- Table structure for table `behaviour`
--

CREATE TABLE `behaviour` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` varchar(300) NOT NULL,
  `marks` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `behaviour`
--

INSERT INTO `behaviour` (`id`, `title`, `description`, `marks`) VALUES
(1, 'Communication', 'Communication with their colleagues an Line manager for the entire task period', 25),
(2, 'Excellence', 'The quality and Standard of work ', 25),
(3, 'Teamwork', 'Collaboration  with other members', 25),
(5, 'Commitment ', 'Demonstrate ownership', 25);

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
  `state` int(1) NOT NULL COMMENT '0-set,1-approved, 2-recommended'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bonus_logs`
--

CREATE TABLE `bonus_logs` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `name` int(11) NOT NULL,
  `init_author` varchar(10) DEFAULT NULL,
  `appr_author` varchar(10) DEFAULT NULL,
  `payment_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bonus_logs`
--

INSERT INTO `bonus_logs` (`id`, `empID`, `amount`, `name`, `init_author`, `appr_author`, `payment_date`) VALUES
(1, '5050', '100000.00', 19, '255001', '255073', '2022-10-04');

-- --------------------------------------------------------

--
-- Table structure for table `bonus_tags`
--

CREATE TABLE `bonus_tags` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bonus_tags`
--

INSERT INTO `bonus_tags` (`id`, `name`) VALUES
(18, 'Severance Pay'),
(17, 'Acting Allowance'),
(15, 'Annual Leave Pay'),
(16, 'Relocation Allowance'),
(19, 'Refund');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(4) NOT NULL DEFAULT '0',
  `street` varchar(50) NOT NULL,
  `region` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `name`, `code`, `street`, `region`, `country`) VALUES
(1, 'Dar Office', '001', 'Daima Street', 'Dar es Salaam', '255'),
(2, ' Mwanza Office', '002', 'Mwanza', 'Mwanza', '255'),
(3, 'Zanzibar Office', '003', 'Zanzibar', 'Zanzibar', '255'),
(4, 'Shinyanga Office', '004', 'Shinyanga', 'Shinyanga', '255'),
(5, 'Mtwara Office', '005', 'Mtwara', 'Mtwara', '255'),
(6, 'Kagera Office', '006', 'Kagera', 'Kagera', '255'),
(7, 'Iringa', '007', 'Iringa', 'Iringa', '255'),
(8, 'Lindi', '008', 'Lindi', 'Lindi', '255'),
(9, 'Bukoba', '009', '000', 'Kagera', '255');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `staff` varchar(8) DEFAULT NULL,
  `comment` varchar(500) NOT NULL,
  `comment_type` int(1) NOT NULL DEFAULT 1 COMMENT '1-Normal comments, 2-Rejection Comments',
  `timesent` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_emails`
--

CREATE TABLE `company_emails` (
  `id` int(11) NOT NULL,
  `host` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `secure` varchar(20) NOT NULL COMMENT 'SMTPSecure',
  `port` int(11) NOT NULL,
  `use_as` int(1) NOT NULL COMMENT '1-Send Payslip',
  `state` int(1) NOT NULL DEFAULT 1 COMMENT '1-active, 0-Not active'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_emails`
--

INSERT INTO `company_emails` (`id`, `host`, `username`, `password`, `name`, `email`, `secure`, `port`, `use_as`, `state`) VALUES
(4, 'chi-node11.websitehostserver.net', 'flex@cits.co.tz', 'cits@2020', 'VSO HR', 'flex@cits.co.tz', 'tls', 587, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

CREATE TABLE `company_info` (
  `id` int(11) NOT NULL,
  `tin` varchar(11) DEFAULT NULL,
  `cname` varchar(100) DEFAULT NULL,
  `postal_address` varchar(50) DEFAULT NULL,
  `postal_city` varchar(50) DEFAULT NULL,
  `phone_no1` varchar(15) DEFAULT NULL,
  `phone_no2` varchar(15) DEFAULT NULL,
  `phone_no3` varchar(15) DEFAULT NULL,
  `fax_no` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `plot_no` varchar(20) DEFAULT NULL,
  `block_no` varchar(20) DEFAULT NULL,
  `street` varchar(50) DEFAULT NULL,
  `branch` varchar(50) DEFAULT NULL,
  `wcf_reg_no` varchar(50) DEFAULT NULL,
  `heslb_code_no` varchar(20) DEFAULT NULL,
  `business_nature` varchar(100) DEFAULT NULL,
  `company_type` varchar(50) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `nssf_control_number` varchar(200) NOT NULL,
  `nssf_reg` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_info`
--

INSERT INTO `company_info` (`id`, `tin`, `cname`, `postal_address`, `postal_city`, `phone_no1`, `phone_no2`, `phone_no3`, `fax_no`, `email`, `plot_no`, `block_no`, `street`, `branch`, `wcf_reg_no`, `heslb_code_no`, `business_nature`, `company_type`, `logo`, `nssf_control_number`, `nssf_reg`) VALUES
(1, '101359468', 'VSO Tanzania', 'P.O. Box 6297', 'Dar es Salaam', '+255222780120', ' ', ' ', ' ', 'tanzania.info@vsoint.org', '100, House 16', ' ', 'Daima Street-Mikocheni B', 'Dar es Salaam', ' ', ' 991110557357', 'Non-Governmental Organisation', 'Entity', '/uploads/logo/logo.png', '991110557357', '1004780');

-- --------------------------------------------------------

--
-- Table structure for table `company_property`
--

CREATE TABLE `company_property` (
  `id` int(11) NOT NULL,
  `prop_type` varchar(100) DEFAULT NULL,
  `prop_name` varchar(100) DEFAULT NULL,
  `serial_no` varchar(100) DEFAULT NULL,
  `given_to` varchar(10) NOT NULL,
  `given_by` varchar(10) DEFAULT NULL,
  `dated_on` datetime NOT NULL DEFAULT current_timestamp(),
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_property`
--

INSERT INTO `company_property` (`id`, `prop_type`, `prop_name`, `serial_no`, `given_to`, `given_by`, `dated_on`, `isActive`) VALUES
(6, 'Employee Package', 'Employee ID, Health Insuarance Card, Email Address and System Access', '2550007', '2550007', '2550001', '2020-04-25 23:59:53', 1),
(7, 'Employee Package', 'Employee ID, Health Insuarance Card, Email Address and System Access', '2550008', '2550008', '2550001', '2020-04-26 00:03:21', 1),
(8, 'Employee Package', 'Employee ID, Health Insuarance Card, Email Address and System Access', '2550009', '2550009', '2550001', '2020-04-26 00:04:54', 1),
(9, 'Employee Package', 'Employee ID, Health Insuarance Card, Email Address and System Access', '2550010', '2550010', '2550001', '2020-04-26 00:04:54', 1),
(13, 'Employee Package', 'Employee ID, Health Insuarance Card, Email Address and System Access', '0970014', '0970014', '2550001', '2020-04-30 14:53:29', 1),
(14, 'Employee Package', 'Employee ID, Health Insuarance Card, Email Address and System Access', '0970015', '0970015', '2550001', '2020-05-01 00:31:26', 1),
(15, 'Employee Package', 'Employee ID, Health Insuarance Card, Email Address and System Access', '0010016', '0010016', '2550001', '2020-05-01 01:13:20', 1),
(18, 'Employee Package', 'Employee ID, Health Insuarance Card, Email Address and System Access', '0010019', '0010019', '2550001', '2020-05-07 13:02:39', 1),
(19, 'Employee Package', 'Employee ID, Health Insuarance Card, Email Address and System Access', '0970020', '0970020', '2550001', '2020-05-07 13:07:04', 1),
(22, 'Employee Package', 'Employee ID, Health Insuarance Card Email and System Access', '123456', '123456', 'TZ1114433', '2020-06-06 05:45:34', 1);

-- --------------------------------------------------------

--
-- Table structure for table `confirmed_imprest`
--

CREATE TABLE `confirmed_imprest` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `imprestID` int(11) NOT NULL,
  `initial` decimal(15,2) NOT NULL,
  `final` decimal(15,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '1-resolved, 0-not resolved',
  `date_resolved` date NOT NULL,
  `date_confirmed` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `confirmed_trainee`
--

CREATE TABLE `confirmed_trainee` (
  `id` int(11) NOT NULL,
  `skillsID` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `cost` decimal(15,2) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '0-On Training, 1-Graduated, 2-Paused',
  `recommended_by` varchar(10) NOT NULL,
  `date_recommended` date NOT NULL DEFAULT '2019-07-29',
  `approved_by` varchar(10) NOT NULL,
  `date_approved` date NOT NULL DEFAULT '2019-07-29',
  `confirmed_by` varchar(10) NOT NULL,
  `date_confirmed` date NOT NULL DEFAULT '2019-07-29',
  `application_date` date NOT NULL,
  `accepted_by` varchar(10) NOT NULL,
  `date_accepted` date NOT NULL,
  `certificate` varchar(100) NOT NULL,
  `remarks` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE `contract` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `duration` double DEFAULT NULL,
  `reminder` int(2) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contract`
--

INSERT INTO `contract` (`id`, `name`, `duration`, `reminder`, `state`) VALUES
(2, 'temporary', 0.5, 2, 1),
(3, 'Permanent', 60, 6, 1),
(4, 'Internship', 1, 2, 0),
(5, 'Temporary', 1, 3, 1);

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
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(56) NOT NULL,
  `code` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `code`) VALUES
(1, 'Tanzania (United Republic)', 255),
(2, 'Kenya', 254),
(3, 'Uganda', 256),
(6, 'USA', 1),
(7, 'Oman', 97),
(8, 'UK', 44);

-- --------------------------------------------------------

--
-- Table structure for table `deduction`
--

CREATE TABLE `deduction` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `code` int(11) NOT NULL,
  `rate_employee` double DEFAULT NULL,
  `rate_employer` double DEFAULT NULL,
  `remarks` varchar(100) NOT NULL,
  `is_active` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deduction`
--

INSERT INTO `deduction` (`id`, `name`, `code`, `rate_employee`, `rate_employer`, `remarks`, `is_active`) VALUES
(2, 'WCF', 4216, 0, 0.01, 'From Gross Salary', 1),
(3, 'HESLB', 4584, 0.15, 0, 'From Basic Salary', 1),
(4, 'SDL', 4176, 0, 0.045, 'From Gross Salary', 1),
(7, 'Salary Advance', 4551, 0.3, 0, 'From Basic Salary', 1),
(8, 'Day Overtime (150%)', 4432, 0, 0, 'From Basic Salary', 1),
(9, 'Medical', 4913, 0, 0, 'From Basic Salary', 1);

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `percent` double NOT NULL DEFAULT 0,
  `apply_to` int(1) NOT NULL COMMENT '1-apply to all, 2-apply to specific',
  `mode` int(11) NOT NULL DEFAULT 1 COMMENT '1-fixed amount, 2-from basic salary, 3-from gross',
  `state` int(11) NOT NULL DEFAULT 1 COMMENT '1-active, 0-inactive'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `name`, `code`, `amount`, `percent`, `apply_to`, `mode`, `state`) VALUES
(1, 'TUICO', 4389, '1000.00', 0, 0, 2, 1),
(2, 'Monthly Deduction', 4499, '42500.00', 0, 0, 2, 1),
(4, 'Transport Contribution', 0, '20000.00', 0, 2, 2, 1),
(5, 'Maji', 0, '0.00', 0, 2, 2, 1),
(6, 'SACOS', 0, '0.00', 0.05, 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `deduction_logs`
--

CREATE TABLE `deduction_logs` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `description` varchar(50) NOT NULL DEFAULT 'Unclassified',
  `policy` varchar(50) NOT NULL DEFAULT 'Fixed Amount',
  `paid` decimal(15,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deduction_tags`
--

CREATE TABLE `deduction_tags` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deduction_tags`
--

INSERT INTO `deduction_tags` (`id`, `name`) VALUES
(1, 'TUICO'),
(2, 'Monthly Deduction');

-- --------------------------------------------------------

--
-- Table structure for table `deliverables`
--

CREATE TABLE `deliverables` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cost` int(100) NOT NULL,
  `target` int(100) NOT NULL,
  `project_id` int(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `state` int(100) NOT NULL DEFAULT 1,
  `managed_by` int(100) NOT NULL,
  `document` varchar(100) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deliverables`
--

INSERT INTO `deliverables` (`id`, `name`, `cost`, `target`, `project_id`, `description`, `state`, `managed_by`, `document`, `start_date`, `end_date`) VALUES
(1, 'sam', 200, 200, 1, 'Livelihood', 1, 255028, '', '2022-10-05 00:00:00', '2022-10-12 00:00:00'),
(2, 'sam2', 400, 300, 1, 'Livelihood', 1, 255010, '', '2022-10-05 00:00:00', '2022-10-12 00:00:00'),
(3, 'samwel', 3000, 300, 1, 'majaribio', 1, 255028, '', '2022-10-05 00:00:00', '2022-10-12 00:00:00'),
(4, 'Getting 10 big farmers', 5000000, 5, 8, 'The bank has to buy 5 godowns of Korosho from big farmers', 1, 255010, '', '2022-01-01 00:00:00', '2022-06-01 00:00:00'),
(5, 'Obtaining 100 smallholderfarmers', 5000000, 5, 8, 'The bank has to buy 5 godowns of Korosho', 1, 255010, '', '2022-01-01 00:00:00', '2022-12-31 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `code` int(5) NOT NULL DEFAULT 0,
  `name` varchar(100) NOT NULL,
  `type` int(1) NOT NULL DEFAULT 1 COMMENT '1-Department, 2-Subdepartment',
  `hod` varchar(15) DEFAULT NULL,
  `reports_to` int(11) NOT NULL DEFAULT 3,
  `state` int(1) NOT NULL DEFAULT 1,
  `department_pattern` varchar(6) NOT NULL,
  `parent_pattern` varchar(6) NOT NULL,
  `level` int(11) NOT NULL DEFAULT 1,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `code`, `name`, `type`, `hod`, `reports_to`, `state`, `department_pattern`, `parent_pattern`, `level`, `created_by`, `created_on`) VALUES
(1, 10001, 'Finance', 1, 'TZ1117437', 3, 1, 'ewqacr', '0', 0, 'TZ1114433', '2019-03-18 03:16:43'),
(2, 2, 'People and Operations', 1, 'TZ1118959', 3, 1, 'cmyvrt', 'ewqacr', 1, 'TZ1114433', '2020-04-26 01:14:02'),
(3, 3, 'Contry Director\'s Office', 1, 'S21179', 1, 1, 'iaumqz', 'ewqacr', 1, 'TZ1114433', '2020-04-26 01:17:09'),
(4, 4, 'Programmes', 1, 'UG213', 3, 1, 'jobkeu', 'ewqacr', 1, 'TZ1114433', '2020-04-26 01:20:44'),
(5, 5, 'Test dept', 1, '255002', 1, 1, 'ewctfr', 'ewqacr', 1, '255001', '2020-09-02 01:14:38'),
(6, 6, 'ICT', 1, '255006', 3, 1, 'cayiyv', 'iaumqz', 2, '255001', '2022-09-14 09:10:18'),
(7, 7, 'ICT depertment', 1, '255001', 6, 0, 'ksnhti', 'cayiyv', 3, '255028', '2022-10-02 03:59:59'),
(8, 8, 'Software', 1, '255025', 6, 1, 'bkxyzd', 'cayiyv', 3, '255001', '2022-10-04 06:12:31');

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
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `emp_id` varchar(10) NOT NULL,
  `old_emp_id` varchar(110) NOT NULL DEFAULT '0',
  `password_set` varchar(10) DEFAULT '0',
  `fname` varchar(20) DEFAULT NULL,
  `mname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `nationality` varchar(5) NOT NULL DEFAULT '255',
  `merital_status` varchar(20) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `branch` varchar(5) NOT NULL DEFAULT '001',
  `shift` int(11) NOT NULL DEFAULT 1,
  `organization` int(11) NOT NULL DEFAULT 1 COMMENT 'For Productivity Purpose',
  `line_manager` varchar(50) DEFAULT NULL,
  `contract_type` varchar(100) DEFAULT NULL,
  `contract_renewal_date` date DEFAULT NULL,
  `salary` decimal(15,2) DEFAULT NULL,
  `postal_address` varchar(100) DEFAULT NULL,
  `postal_city` varchar(50) DEFAULT 'Mwanza',
  `physical_address` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `photo` varchar(100) DEFAULT '/uploads/userprofile/user.png',
  `is_expatriate` int(1) NOT NULL DEFAULT 0 COMMENT '1-expatriate, 0-Normal',
  `home` varchar(100) DEFAULT NULL,
  `bank` int(11) NOT NULL,
  `bank_branch` int(11) NOT NULL,
  `account_no` varchar(30) DEFAULT NULL,
  `pension_fund` int(11) NOT NULL,
  `pf_membership_no` varchar(20) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `state` int(10) NOT NULL DEFAULT 1,
  `login_user` int(110) NOT NULL DEFAULT 0 COMMENT '0-normal users, 1-user only to login no payment process',
  `last_updated` date DEFAULT NULL,
  `last_login` varchar(20) DEFAULT NULL,
  `retired` int(11) NOT NULL DEFAULT 1,
  `contract_end` date DEFAULT NULL,
  `tin` varchar(200) DEFAULT NULL,
  `national_id` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `emp_id`, `old_emp_id`, `password_set`, `fname`, `mname`, `lname`, `birthdate`, `gender`, `nationality`, `merital_status`, `hire_date`, `department`, `position`, `branch`, `shift`, `organization`, `line_manager`, `contract_type`, `contract_renewal_date`, `salary`, `postal_address`, `postal_city`, `physical_address`, `mobile`, `email`, `photo`, `is_expatriate`, `home`, `bank`, `bank_branch`, `account_no`, `pension_fund`, `pf_membership_no`, `username`, `password`, `state`, `login_user`, `last_updated`, `last_login`, `retired`, `contract_end`, `tin`, `national_id`) VALUES
(1, '255001', '0', '0', 'Org.', 'Employee', '1', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 2, 93, '001', 1, 1, 'TZ394', '3', '2020-05-18', '4801328.97', 'P.O Box DSM', 'Dar es Salaama', 'Dar es Salaam', '0754480925', 'james.sweke@cits.co.tz', 'user_255001.jpeg', 0, 'Dar es Salaam', 6, 8, '0041001836', 2, '54913241', '255001', '$2y$10$cuAOvfpGSYPLmwONROf9J.WpmZf0.sIq/si7gkSZZSjr7KmV5SrXG', 1, 0, '2022-09-14', '2022-11-23', 1, NULL, NULL, NULL),
(2, '255002', '0', '0', 'Org.', 'Employee', '2', '1990-04-03', 'Female', '255', 'Married', '2018-01-01', 2, 98, '001', 1, 1, 'TZ1118959', '3', '2020-05-18', '3058904.52', '', 'Dar Es Salaam', '', '0755935904', 'james.sweke@cits.co.tz', '', 0, '', 6, 8, '0041048166', 2, '54913047', '255002', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(3, '255003', '0', '0', 'Org.', 'Employee', '3', '1990-04-03', 'Female', '255', 'Married', '2018-01-01', 2, 101, '001', 1, 1, 'TZ1110882', '5', '2020-05-18', '734341.96', '', 'Dar Es Salaam', '', '0762105611', 'james.sweke@cits.co.tz', '', 0, '', 11, 6, '1092873310', 3, '', '255003', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-06-22', '2020-06-29', 1, NULL, NULL, NULL),
(4, '255004', '0', '0', 'Org.', 'Employee', '4', '1990-04-03', 'Female', '255', 'Married', '2018-01-01', 2, 97, '001', 1, 1, 'TZ1118959', '3', '2020-05-18', '3058904.52', '', 'Dar Es Salaam', '', '0758808827', 'james.sweke@cits.co.tz', '', 0, '', 6, 30, '0121018241', 2, '54913055', '255004', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(5, '255005', '0', '0', 'Org.', 'Employee', '5', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 4, 102, '001', 1, 1, 'TZ1110594', '5', '2020-05-18', '1137796.44', '', 'Shinyanga', '', '0767930433', 'james.sweke@cits.co.tz', '', 0, '', 6, 8, '0041031360', 2, '54913217', '255005', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-06-05', '2020-09-02', 1, NULL, NULL, NULL),
(6, '255006', '0', '0', 'Org.', 'Employee', '6', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 2, 100, '001', 1, 1, 'TZ1110882', '3', '2020-05-18', '952422.51', '', 'Dar Es Salaam', '', '0686195029', 'james.sweke@cits.co.tz', '', 0, '', 6, 9, '0141016008', 2, '54913012', '255006', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(7, '255007', '0', '0', 'Org.', 'Employee', '7', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 2, 100, '001', 1, 1, 'TZ1110882', '3', '2020-05-18', '952422.40', '', 'Dar Es Salaam', '', '0768641015', 'james.sweke@cits.co.tz', '', 0, '', 6, 8, '0041038284', 2, '54913004', '255007', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(8, '255008', '0', '0', 'Org.', 'Employee', '8', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 4, 81, '001', 1, 1, 'UG213', '3', '2020-05-18', '8288034.48', '', 'Dar es Salaam', '', '0759980883', 'james.sweke@cits.co.tz', '', 0, '', 11, 6, '1317213316', 2, '54913209', '255008', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-06-23', '', 1, NULL, NULL, NULL),
(9, '255009', '0', '0', 'Org.', 'Employee', '9', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 4, 86, '001', 1, 1, 'TZ350', '5', '2020-05-18', '4411390.12', '', 'Kagera', '', '0757418068', 'james.sweke@cits.co.tz', '', 0, '', 6, 8, '0041043156', 2, '54913128', '255009', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(10, '255010', '0', '0', 'Org.', 'Employee', '10', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 2, 80, '001', 1, 1, 'TZ1118808', '3', '2020-05-18', '4286423.54', '', 'Dar es Salaam', '', '0753577068', 'james.sweke@cits.co.tz', '', 0, '', 6, 8, '0041026367', 2, '54913071', '255010', '$2y$10$cuAOvfpGSYPLmwONROf9J.WpmZf0.sIq/si7gkSZZSjr7KmV5SrXG', 1, 0, '2020-06-26', '2022-10-06', 1, NULL, NULL, NULL),
(11, '255011', '0', '0', 'Org.', 'Employee', '11', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 4, 86, '001', 1, 1, 'TZ350', '5', '2020-05-18', '4411390.12', '', 'Mwanza', '', '0786607397', 'james.sweke@cits.co.tz', '', 0, '', 6, 9, '0141091611', 2, '54913225', '255011', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(12, '255012', '0', '0', 'Org.', 'Employee', '12', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 4, 86, '005', 1, 1, 'TZ350', '5', '2020-05-18', '4411390.12', '', 'Mtwara', '', '0715045766', 'james.sweke@cits.co.tz', '', 0, '', 3, 18, '70210029252', 2, '45011553', '255012', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(13, '255013', '0', '0', 'Org.', 'Employee', '13', '1990-04-03', 'Female', '255', 'Married ', '2018-01-01', 4, 89, '001', 1, 1, 'TZ350', '5', '2020-05-18', '3130198.01', '', 'Iringa', '', '0769656796', 'james.sweke@cits.co.tz', '', 0, '', 6, 9, '0041023538', 2, '54913063', '255013', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(14, '255014', '0', '0', 'Org.', 'Employee', '14', '1990-04-03', 'Female', '255', 'Single', '2018-01-01', 4, 82, '001', 1, 1, 'UG213', '5', '2020-05-18', '6248835.86', '', 'Dar Es Salaam', '', '0753815464', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0152264454800', 2, '54913160', '255014', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '2020-09-02', 1, NULL, NULL, NULL),
(15, '255015', '0', '0', 'Org.', 'Employee', '15', '1990-04-03', 'Female', '255', 'Married', '2018-01-01', 4, 89, '002', 1, 1, 'T1114490', '5', '2020-05-18', '3034751.60', '', 'Mwanza', '', '0759546102', 'james.sweke@cits.co.tz', '', 0, '', 3, 17, '52010002523', 2, '54913098', '255015', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '2020-06-22', 1, NULL, NULL, NULL),
(16, '255016', '0', '0', 'Org.', 'Employee', '16', '1990-04-03', 'Female', '255', 'Married', '2018-01-01', 2, 85, '001', 1, 1, '255025', '5', '2020-05-18', '3058904.52', '', 'Dar Es Salaam', '', '0683210966', 'james.sweke@cits.co.tz', '', 0, '', 1, 12, '0152218559900', 2, '54913039', '255016', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, '2020-09-09', NULL, NULL),
(17, '255017', '0', '0', 'Org.', 'Employee', '17', '1990-04-03', 'Male', '255', 'Married ', '2018-01-01', 1, 83, '001', 1, 1, 'TZ1117437', '5', '2020-05-18', '6242400.01', '', 'Dar Es Salaam', '', '0713136713', 'james.sweke@cits.co.tz', '', 0, '', 1, 13, '0112088479300', 2, '62540521', '255017', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 3, 0, '2020-05-20', '2020-06-12', 1, '2021-05-19', NULL, ''),
(18, '255018', '0', '0', 'Org.', 'Employee', '18', '1990-04-03', 'Female', '255', 'Married ', '2018-01-01', 4, 95, '006', 1, 1, 'TZ350', '5', '2020-05-18', '1788796.34', '', 'Kagera', '', '0757964532', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0152216162400', 2, '64528642', '255018', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(19, '255019', '0', '0', 'Org.', 'Employee', '19', '1990-04-03', 'Female', '255', 'single', '2018-01-01', 1, 90, '001', 1, 1, 'TZ1117437', '5', '2020-05-18', '4286423.54', '', 'Dar es Salaam', '', '0789608648', 'james.sweke@cits.co.tz', '', 0, '', 6, 8, '0041017546', 2, '54913187', '255019', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 3, 0, '2020-06-22', '', 1, '2022-09-14', NULL, NULL),
(20, '255020', '0', '0', 'Org.', 'Employee', '20', '1990-04-03', 'Male', '255', 'single', '2018-01-01', 4, 91, '001', 1, 1, 'T1114490', '5', '2020-05-18', '3034751.60', '', 'Dar Es Salaam', '', '0755839489', 'james.sweke@cits.co.tz', '', 0, '', 10, 38, '3001111356328', 2, '54913500', '255020', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(21, '255021', '0', '0', 'Org.', 'Employee', '21', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 2, 99, '001', 1, 1, 'TZ1110882', '5', '2020-05-18', '1137796.45', '', 'Dar es Salaam', '', '0752462293', 'james.sweke@cits.co.tz', '', 0, '', 6, 9, '0141174703', 2, '50501879', '255021', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(22, '255022', '0', '0', 'Org.', 'Employee', '22', '1990-04-03', 'Male', '255', 'single', '2018-01-01', 4, 88, '001', 1, 1, 'T1114490', '5', '2020-05-18', '4411390.12', '', 'Dar Es Salaam', '', '0754288887', 'james.sweke@cits.co.tz', '', 0, '', 4, 19, '0100303584200', 2, '64500675', '255022', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(23, '255023', '0', '0', 'Org.', 'Employee', '23', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 2, 100, '001', 1, 1, 'TZ1110882', '3', '2020-05-18', '952422.40', '', 'Dar es Salaam', '', '0653341020', 'james.sweke@cits.co.tz', '', 0, '', 6, 8, '0041574224', 2, '61993573', '255023', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(24, '255024', '0', '0', 'Org.', 'Employee', '24', '1990-04-03', 'Male', '255', 'Married ', '2018-01-01', 2, 100, '001', 1, 1, 'TZ1110882', '3', '2020-05-18', '539706.03', '', 'Dar Es Salaam', '', '0743202836', 'james.sweke@cits.co.tz', '', 0, '', 6, 8, '0141344137', 2, '61993581', '255024', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-06-19', '2020-09-02', 1, NULL, NULL, NULL),
(25, '255025', '0', '0', 'Org.', 'Employee', '25', '1990-04-03', 'Male', '255', 'Married ', '2018-01-01', 2, 75, '001', 1, 1, 'TZ1118959', '5', '2020-05-18', '5001834.65', '', 'Dar Es Salaam', '', '0713596257', 'james.sweke@cits.co.tz', '', 0, '', 8, 20, '9120001042066', 2, ' 50415549', '255025', '$2y$10$cuAOvfpGSYPLmwONROf9J.WpmZf0.sIq/si7gkSZZSjr7KmV5SrXG', 1, 0, '2020-05-20', '2022-10-04', 1, NULL, NULL, NULL),
(26, '255026', '0', '0', 'Org.', 'Employee', '26', '1990-04-03', 'Male', '255', 'Single', '2018-01-01', 4, 88, '004', 1, 1, 'TZ1123833', '5', '2020-05-18', '3034751.60', '', 'Shinyanga', '', '0766523521', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0152258731600', 2, '54913381', '255026', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(27, '255027', '0', '0', 'Org.', 'Employee', '27', '1990-04-03', 'Female', '255', 'single', '2018-01-01', 1, 96, '001', 1, 1, 'TZ1118808', '5', '2020-05-18', '2073728.75', '', 'Dar es Salaam', '', '0758303880', 'james.sweke@cits.co.tz', '', 0, '', 3, 17, '22510043246', 2, '54913527', '255027', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 4, 0, '2020-09-02', '2020-06-29', 1, '2020-09-02', NULL, NULL),
(28, '255028', '0', '0', 'Org.', 'Employee', '28', '1990-04-03', 'Female', '255', 'Married', '2018-01-01', 4, 87, '001', 1, 1, '255044', '5', '2020-05-18', '4411390.12', '', 'Iringa', '', '0767100402', 'james.sweke@cits.co.tz', '', 0, '', 6, 27, '0531022602', 2, '55487351', '255028', '$2y$10$cuAOvfpGSYPLmwONROf9J.WpmZf0.sIq/si7gkSZZSjr7KmV5SrXG', 1, 0, '2020-05-21', '2022-11-23', 1, NULL, NULL, NULL),
(29, '255029', '0', '0', 'Org.', 'Employee', '29', '1990-04-03', 'Female', '255', 'Married', '2018-01-01', 1, 78, '001', 1, 1, '255001', '3', '2020-05-18', '9727740.00', '', 'Dar es Salaam', 'dodoma', '0754346595', 'james.sweke@cits.co.tz', 'user_255029.jpeg', 0, '', 1, 34, '01J2456602600', 2, '37085239', '255029', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2022-10-04', '', 1, NULL, NULL, NULL),
(30, '255030', '0', '0', 'Org.', 'Employee', '30', '1990-04-03', 'Female', '255', 'single', '2018-01-01', 4, 89, '006', 1, 1, 'T1114490', '5', '2020-05-18', '3034751.60', '', 'Kagera', '', '0622378937', 'james.sweke@cits.co.tz', '', 0, '', 3, 17, '22910018423', 2, '54915465', '255030', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(31, '255031', '0', '0', 'Org.', 'Employee', '31', '1990-04-03', 'Male', '255', 'single', '2018-01-01', 4, 89, '006', 1, 1, 'T1114490', '5', '2020-05-18', '3034751.60', '', 'Kagera', '', '0762261265', 'james.sweke@cits.co.tz', '', 0, '', 3, 17, '31810018271', 2, '54915430', '255031', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(32, '255032', '0', '0', 'Org.', 'Employee', '32', '1990-04-03', 'Female', '255', 'Married ', '2018-01-01', 4, 88, '001', 1, 1, 'TZ1110594', '5', '2020-05-18', '3013177.00', '', 'Dar Es Salaam', '', '0682296367', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0112077702900', 2, '54915414', '255032', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(33, '255033', '0', '0', 'Org.', 'Employee', '33', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 2, 100, '001', 1, 1, 'TZ1110882', '5', '2020-05-18', '952422.40', '', 'Dar es Salaam', '', '0756583506', 'james.sweke@cits.co.tz', '', 0, '', 3, 17, '22610017364', 2, ' 63823780', '255033', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(34, '255034', '0', '0', 'Org.', 'Employee', '34', '1990-04-03', 'Female', '255', 'Single', '2018-01-01', 2, 80, '001', 1, 1, '255001', '5', '2020-05-18', '9987840.00', '', 'Dar es Salaam', '', '0756670400', 'james.sweke@cits.co.tz', '', 0, '', 6, 7, '0011012310', 2, '33937036', '255034', '$2y$10$cuAOvfpGSYPLmwONROf9J.WpmZf0.sIq/si7gkSZZSjr7KmV5SrXG', 1, 0, '2020-05-19', '2022-10-04', 1, NULL, NULL, NULL),
(35, '255035', '0', '0', 'Org.', 'Employee', '35', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 1, 90, '001', 1, 1, 'TZ1117437', '5', '2020-05-18', '4286423.54', '', 'Dar Es Salaam', '', '0762196941', 'james.sweke@cits.co.tz', '', 0, '', 2, 37, '047163013910', 2, '63827603', '255035', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(36, '255036', '0', '0', 'Org.', 'Employee', '36', '1990-04-03', 'Male', '255', 'single', '2018-01-01', 4, 88, '002', 1, 1, 'TZ350', '5', '2020-05-18', '3130198.01', '', 'Mwanza', '', '0753954027', 'james.sweke@cits.co.tz', '', 0, '', 3, 17, '30510013213', 2, '2398369', '255036', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(37, '255037', '0', '0', 'Org.', 'Employee', '37', '1990-04-03', 'Male', '255', 'single', '2018-01-01', 4, 88, '005', 1, 1, 'T1114490', '5', '2020-05-18', '3034751.60', '', 'Mtwara', '', '0746399265', 'james.sweke@cits.co.tz', '', 0, '', 3, 17, '22310031304', 2, '63925125', '255037', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(38, '255038', '0', '0', 'Org.', 'Employee', '38', '1990-04-03', 'Female', '255', 'Married ', '2018-01-01', 4, 89, '006', 1, 1, 'T1114490', '5', '2020-05-18', '3034751.60', '', 'Kagera', '', '0717641518', 'james.sweke@cits.co.tz', '', 0, '', 3, 17, '24710002402', 2, '64271706', '255038', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(39, '255039', '0', '0', 'Org.', 'Employee', '39', '1990-04-03', 'Female', '44', 'single', '2018-01-01', 4, 79, '001', 1, 1, '255001', '5', '2020-05-18', '8238655.60', '', 'Dar Es Salaam', '', '0758230120', 'james.sweke@cits.co.tz', '', 1, '', 7, 39, '00654831', 2, '54913543', '255039', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '2020-06-22', 1, NULL, NULL, NULL),
(40, '255040', '0', '0', 'Org.', 'Employee', '40', '1990-04-03', 'Male', '255', 'single', '2018-01-01', 4, 88, '002', 1, 1, 'TZ390', '5', '2020-05-18', '3034751.60', '', 'Mwanza', '', '0766093211', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0152268709100', 2, '58069704', '255040', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(41, '255041', '0', '0', 'Org.', 'Employee', '41', '1990-04-03', 'Male', '255', 'single', '2018-01-01', 4, 88, '005', 1, 1, 'TZ1110594', '5', '2020-05-18', '4411390.12', 'P.O Box Mtwara', 'Mtwara', '', '0767353542', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '01J2028537400', 2, '53811216', '255041', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-06-22', '', 1, NULL, NULL, NULL),
(42, '255042', '0', '0', 'Org.', 'Employee', '42', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 4, 94, '001', 1, 1, 'T1114490', '5', '2020-05-18', '1788796.34', '', 'Dar Es Salaam', '', '0743330220', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0152317686200', 2, '45033376', '255042', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(43, '255043', '0', '0', 'Org.', 'Employee', '43', '1990-04-03', 'Male', '255', 'single', '2018-01-01', 4, 95, '004', 1, 1, 'TZ390', '5', '2020-05-18', '1788796.34', '', 'Shinyanga', '', '0762087974', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0152213480500', 2, '59245433', '255043', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-21', '', 1, NULL, NULL, NULL),
(44, '255044', '0', '0', 'Org.', 'Employee', '44', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 2, 97, '001', 1, 1, 'TZ1118959', '5', '2020-05-18', '3058904.52', '', 'Dar es Salaam', '', '0757361092', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0152294853000', 2, '65485076', '255044', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-06-23', '', 1, NULL, NULL, NULL),
(45, '255045', '0', '0', 'Org.', 'Employee', '45', '1990-04-03', 'Female', '255', 'Married', '2018-01-01', 4, 86, '002', 1, 1, 'TZ1110594', '5', '2020-05-18', '4411390.12', '', 'Mwanza', '', '0713656603', 'james.sweke@cits.co.tz', '', 0, '', 4, 19, '0100301355000', 2, '40085031', '255045', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(46, '255046', '0', '0', 'Org.', 'Employee', '46', '1990-04-03', 'Female ', '255', 'Single', '2018-01-01', 4, 88, '006', 1, 1, 'T1114490', '5', '2020-05-18', '2731276.44', '', 'Kagera', '', '0785018010', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0152404567700', 2, '', '255046', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 4, 0, '2020-06-19', '', 1, NULL, NULL, NULL),
(47, '255047', '0', '0', 'Org.', 'Employee', '47', '1990-04-03', 'Male', '255', 'Single', '2018-01-01', 4, 88, '003', 1, 1, 'TZ1123833', '5', '2020-05-18', '3034751.60', '', 'Zanzibar', '', '0764043863', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0152352041600', 2, '60555688', '255047', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(48, '255048', '0', '0', 'Org.', 'Employee', '48', '1990-04-03', 'Male', '255', 'single', '2018-01-01', 4, 111, '001', 1, 1, 'TZ350', '2', '2020-05-18', '630000.00', '', 'Dar Es Salaam', '', '0768991164', 'james.sweke@cits.co.tz', '', 0, '', 5, 14, '0768991164', 2, '64534804', '255048', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 4, 0, '2020-06-19', '', 1, NULL, NULL, NULL),
(49, '255049', '0', '0', 'Org.', 'Employee', '49', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 4, 105, '002', 1, 1, 'TZ1110594', '2', '2020-05-18', '630000.00', '', 'Mwanza', '', '0757267152', 'james.sweke@cits.co.tz', '', 0, '', 5, 14, '0765146120', 2, '45041342', '255049', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(50, '255050', '0', '0', 'Org.', 'Employee', '50', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 4, 107, '002', 1, 1, 'TZ350', '2', '2020-05-18', '630000.00', '', 'Mwanza', '', '0752628271', 'james.sweke@cits.co.tz', '', 0, '', 3, 17, '51110014190', 2, '63226758', '255050', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(51, '255051', '0', '0', 'Org.', 'Employee', '51', '1990-04-03', 'Female', '255', 'Married ', '2018-01-01', 4, 113, '005', 1, 1, 'TZ390', '2', '2020-05-18', '630000.00', '', 'Mtwara', '', '0753013674', 'james.sweke@cits.co.tz', '', 0, '', 5, 14, '0753013674', 2, '60656298', '255051', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(52, '255052', '0', '0', 'Org.', 'Employee', '52', '1990-04-03', 'Female', '255', 'Married ', '2018-01-01', 4, 126, '002', 1, 1, 'TZ390', '2', '2020-05-18', '630000.00', '', 'Mwanza', '', '0766303940', 'james.sweke@cits.co.tz', '', 0, '', 5, 21, '0675559454', 2, '64672263', '255052', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(53, '255053', '0', '0', 'Org.', 'Employee', '53', '1990-04-03', 'Male', '255', 'Single', '2018-01-01', 4, 119, '009', 1, 1, 'TZ1110594', '2', '2020-05-18', '630000.00', '', 'Bukoba', '', '0759037671', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0112583358400', 2, '62565761', '255053', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(54, '255054', '0', '0', 'Org.', 'Employee', '54', '1990-04-03', 'Male', '255', 'single', '2018-01-01', 4, 121, '001', 1, 1, 'TZ354', '2', '2020-05-18', '630000.00', '', 'Kagera', '', '0768416057', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0152218089400', 2, '45043126', '255054', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-06-23', '', 1, NULL, NULL, NULL),
(55, '255055', '0', '0', 'Org.', 'Employee', '55', '1990-04-03', 'Male', '255', 'Married ', '2018-01-01', 4, 124, '008', 1, 1, 'TZ1110594', '2', '2020-05-18', '630000.00', '', 'Lindi', '', '0759209738', 'james.sweke@cits.co.tz', '', 0, '', 3, 18, '32610002345', 2, '65579771', '255055', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(56, '255056', '0', '0', 'Org.', 'Employee', '56', '1990-04-03', 'Male', '255', 'single', '2018-01-01', 4, 124, '005', 1, 1, 'TZ1110594', '2', '2020-05-18', '630000.00', '', 'Mtwara', '', '0752711205', 'james.sweke@cits.co.tz', '', 0, '', 5, 14, '0752711205', 2, '45003239', '255056', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(57, '255057', '0', '0', 'Org.', 'Employee', '57', '1990-04-03', 'Male', '255', 'Married ', '2018-01-01', 4, 115, '005', 1, 1, 'TZ350', '2', '2020-05-18', '630000.00', '', 'Mwanza', '', '0769376846', 'james.sweke@cits.co.tz', '', 0, '', 5, 14, '0769376846', 2, '63226758', '255057', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 4, 0, '2020-06-19', '', 1, NULL, NULL, NULL),
(58, '255058', '0', '0', 'Org.', 'Employee', '58', '1990-04-03', 'Female', '255', 'Married ', '2018-01-01', 4, 105, '005', 1, 1, 'TZ396', '2', '2020-05-18', '630000.00', '', 'Mtwara', '', '0769306663', 'james.sweke@cits.co.tz', '', 0, '', 5, 14, '0769306663', 2, '65668480', '255058', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(59, '255059', '0', '0', 'Org.', 'Employee', '59', '1990-04-03', 'Male', '255', 'Single', '2018-01-01', 4, 107, '008', 1, 1, 'TZ396', '2', '2020-05-18', '630000.00', '', 'Lindi', '', '0769879297', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0152083918300', 2, '63060434', '255059', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(60, '255060', '0', '0', 'Org.', 'Employee', '60', '1990-04-03', 'Female', '255', 'Married', '2018-01-01', 4, 107, '007', 1, 1, 'TZ1110882', '2', '2020-05-18', '630000.00', '', 'Iringa', '', '0757149775', 'james.sweke@cits.co.tz', '', 0, '', 3, 4, '20610000315', 2, '62491342', '255060', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-21', '', 1, NULL, NULL, NULL),
(61, '255061', '0', '0', 'Org.', 'Employee', '61', '1990-04-03', 'Male', '255', 'single', '2018-01-01', 4, 107, '007', 1, 1, 'TZ392', '2', '2020-05-18', '630000.00', '', 'Iringa', '', '0765413872', 'james.sweke@cits.co.tz', '', 0, '', 5, 14, '0765413872', 2, '64424103', '255061', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(62, '255062', '0', '0', 'Org.', 'Employee', '62', '1990-04-03', 'Female', '255', 'single', '2018-01-01', 4, 107, '002', 1, 1, 'TZ392', '2', '2020-05-18', '630000.00', '', 'Mwanza', '', '0757267152', 'james.sweke@cits.co.tz', '', 0, '', 5, 14, '24710002402', 2, '65612124', '255062', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(63, '255063', '0', '0', 'Org.', 'Employee', '63', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 4, 114, '009', 1, 1, 'TZ1110594', '2', '2020-05-18', '630000.00', '', 'Bukoba', '', '0754819800', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0152290741600', 2, '66415403', '255063', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(64, '255064', '0', '0', 'Org.', 'Employee', '64', '1990-04-03', 'Female', '255', 'Single', '2018-01-01', 2, 80, '001', 1, 1, 'TZ390', '2', '2020-05-18', '630000.00', '', 'Mwanza', '', '0769739534', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0152222014500', 2, '61851930', '255064', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(65, '255065', '0', '0', 'Org.', 'Employee', '65', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 4, 125, '002', 1, 1, 'TZ390', '2', '2020-05-18', '630000.00', '', 'Mwanza', '', '0766840653', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0152279732300', 2, '58617817', '255065', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-19', '', 1, NULL, NULL, NULL),
(66, '255066', '0', '0', 'Org.', 'Employee', '66', '1990-04-03', 'Female', '255', 'Married ', '2018-01-01', 4, 110, '002', 1, 1, 'TZ1123833', '2', '2020-05-18', '630000.00', '', 'Mwanza', '', '0768407273', 'james.sweke@cits.co.tz', '', 0, '', 1, 34, '0152353551300', 2, '66619556 ', '255066', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-20', '', 1, NULL, NULL, NULL),
(67, '255067', '0', '0', 'Org.', 'Employee', '67', '1990-04-03', 'Female', '255', 'Married ', '2018-01-01', 4, 109, '002', 1, 1, 'TZ1123833', '2', '2020-05-18', '630000.00', '', 'Mwanza', '', '0767858737', 'james.sweke@cits.co.tz', '', 0, '', 3, 17, '23710010594', 2, '63626195', '255067', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-05-21', '', 1, NULL, NULL, NULL),
(68, '255068', '0', '0', 'Org.', 'Employee', '68', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 4, 120, '006', 1, 1, 'TZ354', '2', '2020-05-18', '630000.00', '', 'Kagera', '', '0754755564', 'james.sweke@cits.co.tz', '', 0, '', 2, 2, '027163008371', 3, 'Retired', '255068', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-06-22', '', 2, NULL, NULL, NULL),
(69, '255069', '0', '1', 'Org.', 'Employee', '69', '1990-04-03', 'Male', '255', 'Married', '2018-01-01', 4, 103, '006', 1, 1, 'TZ354', '2', '2020-05-18', '630000.00', '', 'Kagera', '', '0762283462', 'james.sweke@cits.co.tz', '', 0, '', 3, 17, '70210027551', 2, '63370107', '255069', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-06-03', '', 1, NULL, NULL, NULL),
(79, '255070', '0', '0', 'Org.', 'Employee', '70', '1994-03-10', 'Female', '255', 'Single', '2020-06-19', 4, 95, '001', 1, 1, 'TZ1110594', '5', '2020-06-19', '1311783.98', '', '', '', '0763363189', 'james.sweke@cits.co.tz', 'user.png', 0, '', 3, 17, '20810001347', 2, '64436438', '255070', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-06-19', NULL, 1, NULL, NULL, NULL),
(80, '255071', '0', '0', 'Org.', 'Employee', '71', '1990-08-01', 'Male', '255', 'Single', '2020-06-19', 4, 127, '004', 1, 1, 'TZ1123833', '2', '2020-06-19', '630000.00', '', '', '', '0764400281', 'james.sweke@cits.co.tz', 'user.png', 0, '', 5, 14, '0764400281', 2, '63637928', '255071', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86\r\n', 1, 0, '2020-06-23', NULL, 1, NULL, NULL, NULL),
(81, '255072', '0', '0', 'Org.', 'Employee', '72', '1988-09-13', 'Male', '255', 'Married', '2020-06-19', 4, 128, '004', 1, 1, 'TZ1123833', '2', '2020-06-19', '630000.00', '', '', '', '0765413873', 'james.sweke@cits.co.tz', 'user.png', 0, '', 5, 14, '', 2, '39077799', '255072', '$2y$10$Udt3usVBxKupG9BQDpqGxugW5Ix/8CZs4OoFYFkc3vA7wC6SCPH86', 1, 0, '2020-06-22', NULL, 1, NULL, NULL, NULL),
(82, '255073', '0', '0', 'Org.', 'Employee', '73', '1966-12-09', 'Female', '44', 'Married', '2020-06-22', 3, 77, '001', 1, 1, '255001', '5', '2020-06-22', '5000000.00', '', '', '', '0744663664', 'james.sweke@cits.co.tz', 'user.png', 1, '', 6, 8, '0041005823', 2, '000', '255073', '$2y$10$cuAOvfpGSYPLmwONROf9J.WpmZf0.sIq/si7gkSZZSjr7KmV5SrXG', 1, 1, '2020-06-22', '2022-10-04', 1, NULL, NULL, NULL),
(85, 'Auto111222', '0', '1', 'Samson', 'J', 'Jumanne', '1995-10-01', 'Male', '255', 'Single', '2022-10-01', 2, 84, '002', 1, 1, '255034', '3', '2022-10-01', '2700000.00', 'Kigoma street', 'Mwanza', 'Nyanza street', '0756221122', 'samwel.herman@cits.co.tz', 'user.png', 0, 'Nyanza street', 2, 2, '', 2, 'Auto111222', 'Auto111222', '$2y$10$lVki/cTlXJTCf5oUx5jAR.NtCLMdhbzeUvYPn2CQNV1lqjDSsbjNi', 1, 0, '2022-10-04', NULL, 1, '2029-10-01', 'Auto11122', 'Auto111222'),
(89, '87', '0', '1', 'samwel', 'H', 'kaviranga', '1986-09-30', 'Female', '255', 'Single', '2022-10-02', 2, 93, '001', 1, 1, '255025', '3', '2022-10-02', '2700000.00', '99 dar es salaa', 'dsm', 'dsm', '0745434323', 'samwel@gmail.com', 'user.png', 0, 'dsm', 3, 17, '888888888888888', 3, '67789', '87', '$2y$10$x/vgcAB9T0NpqiKkHINC.ODm8hMdVzbQm/K5aosAu3hSCO4zzHSbO', 5, 0, NULL, NULL, 1, '2024-10-03', '777777777777777', '77777777777777777777777'),
(93, '3453', '0', '1', 'samwel', 'h', 'kaviranga', '2004-10-02', 'Male', '255', 'Single', '2022-10-02', 2, 85, '001', 1, 1, '255025', '3', '2022-10-02', '2700000.00', 'dar', 'dodoma', 'mbezi', '0756453423', 'samwel@gmail.com', 'user.png', 0, 'mbezi', 1, 1, '344444444444444', 3, '4532', '3453', '$2y$10$eYGO2DAXlIhliuwqE8IXA.RAF0m8XhvWC6rDksQPv6vybw1RSwkf2', 5, 0, NULL, NULL, 1, '2024-10-08', '44444444', '44444444444444'),
(94, '1111', '0', '1', 'samwel', 'mwakalebela', 'mwakasiku', '1985-10-01', 'Male', '255', 'Married', '2022-10-04', 8, 131, '001', 1, 1, '255028', '3', '2022-10-04', '3000000.00', 'dar es salaam', 'dsm', 'dar es sallam', '0786564534', 'samwelherman85@gmail.com', 'user.png', 0, 'dar es sallam', 2, 37, '1232312324', 2, '1111', '1111', '$2y$10$hygRZZ./AvKhVRRVAego7utA74PEj4vqqbdhQvRBAxLR8jRZjz9Bu', 5, 0, NULL, NULL, 1, '2022-10-04', '1111111111', '111111111111111111'),
(96, '2554', '0', '1', 'samwel', 'mwakalebela', 'mwakasiku', '1985-10-01', 'Male', '255', 'Married', '2022-10-04', 8, 131, '001', 1, 1, '255028', '3', '2022-10-04', '3000000.00', 'dar es salaam', 'dsm', 'dar es sallam', '0786564534', 'samwelherman85@gmail.com', 'user.png', 0, 'dar es sallam', 2, 37, '1232312324', 2, '1111', '2554', '$2y$10$BOYIEyA/hxynlRvP417AHOKhYZHnHMAXKVzZnLE98iC18UHxdbTc6', 5, 0, NULL, NULL, 1, '2022-10-04', '1111111111', '111111111111111111'),
(97, 'Auto111333', '0', '1', 'samwel', 's', 'rajabu', '1989-10-12', 'Male', '255', 'Single', '2022-10-04', 2, 80, '002', 1, 1, '255034', '3', '2022-10-04', '4900000.00', '', 'mbezi street', 'dsm', '0765454334', 'samwel.herman1@cits.co.tz', 'user.png', 0, 'dsm', 4, 19, '111111111111111', 3, 'Auto111333', 'Auto111333', '$2y$10$x1Qp09FjPc5pOcpLIqz9v.9ys1PNo6NE0WGDDTSWOAvsFAbNCq0wC', 5, 0, NULL, NULL, 1, '2025-10-15', '11111111', '1111111111111111111'),
(98, '54321', '0', '1', 'samwel', 'herman', 'obadia', '1992-10-06', 'Male', '255', 'Single', '2021-09-29', 2, 84, '002', 1, 1, '255010', '3', '2022-10-04', '3000000.00', 'dsm', 'dsm', '', '0765453423', 'samwel.herman1@cits.co.tz', 'user.png', 0, '', 2, 16, '100000000', 3, '54321', '54321', '$2y$10$d8acZRImoz7XJvr6ruN3QujA5Hwkf5lpJ/AUerXiM.rAcyeJJ/z/S', 5, 0, NULL, NULL, 1, '2023-10-26', '434322344', '123232321232323232123'),
(99, '4321', '0', '1', 'samwel', 'herman', 'obadia', '2004-10-04', 'Male', '255', 'Single', '2022-10-19', 8, 130, '001', 1, 1, '255073', '3', '2022-10-04', '3000000.00', 'dsm', 'dsm', 'dsm', '0763434323', 'samwel.herman@cits.co.tz', 'user.png', 0, 'dsm', 2, 16, '1111111111111', 3, '4321', '4321', '$2y$10$SZS24Akvta.rYkfHPQCRx.UtBdtv9GV0yA.NeH7reP3gSeeeuxfg2', 5, 0, NULL, NULL, 1, '2023-09-27', '12121212121', '1121212121212121212121'),
(101, '123456', '0', '1', 'martin', 'l', 'kaboja', '1996-10-11', 'Male', '255', 'Single', '2021-10-15', 8, 130, '001', 1, 1, '255073', '3', '2022-10-04', '3000000.00', 'dodoma', 'dodoma', 'dodoma', '071543234323', 'samwel.herman@cits.co.tz', 'user.png', 0, 'dodoma', 2, 2, '111111111111111', 3, '123456', '123456', '$2y$10$urV5U1FaNv0fK5ReUgs/SOzvUGBQG89D8TPEYGXXfaayrJvHhvD/O', 5, 0, NULL, NULL, 1, '2022-10-04', '5432123', '21212121222323232322'),
(102, '9090', '0', '0', 'samwel', 'h', 'obadia', '1991-10-17', 'Male', '255', 'Single', '2021-10-13', 8, 131, '001', 1, 1, '255029', '3', '2022-10-04', '3000000.00', 'dsm', 'dsmdsm', 'dsm', '0714323212', 'samwelherman85@gmail.com', 'user.png', 0, 'dsm', 2, 16, '123443333', 2, '9090', '9090', '$2y$10$0pYqThbNg20qnriVLlgIoOYn8kAAQqNCM9AHQOEiua.YYcd1hIVyW', 1, 0, '2022-10-04', '2022-10-04', 1, '2023-10-05', '33213434323', '232322222222333'),
(103, '8080', '0', '1', 'Deoglas', 'm', 'mwalusajo', '1987-10-09', 'Male', '255', 'Single', '2022-10-12', 8, 130, '001', 1, 1, '255073', '3', '2022-10-04', '3000000.00', 'dsm', 'dsm', 'dsm', '0756453432', 'deoglas@gmail.com', 'user.png', 0, 'dsm', 2, 16, '1212123323', 2, '8080', '8080', '$2y$10$K35ZabEO6zQauO6EQC0DYexgbVYnc7cQBDpKck482isc7hBUMKPi6', 5, 0, NULL, NULL, 1, '2024-10-16', '3214532434', '212323212323'),
(104, '7070', '0', '1', 'douglas', 'douglas', 'kblWy8rQ', '1987-10-15', 'Male', '255', 'Single', '2021-10-07', 8, 130, '001', 1, 1, '255073', '3', '2022-10-04', '3000000.00', 'dsm', 'dsm', 'dsm', '0754342312', 'samwel.herman@cits.co.tz', 'user.png', 0, 'dsm', 2, 2, '', 2, '7070', '7070', '$2y$10$c6yNnw4eEAisw671Ez9rN.UXbO8wMFSpSHkdL7JCLTuXVsTyGRCaq', 1, 0, NULL, NULL, 1, '2024-10-10', '54366273743', '1223233122'),
(105, '6060', '0', '1', 'monica', 'obadia', '@JX$Vvx4', '1986-10-09', 'Male', '255', 'Single', '2023-10-04', 2, 85, '001', 1, 1, '255025', '3', '2022-10-04', '3000000.00', 'dsm', 'dsm', 'dsm', '0756453423', 'monica@gmail.com', 'user_6060.jpeg', 0, 'dsm', 1, 3, '6736768655', 2, '6060', '6060', '$2y$10$4acy61CSkojZ7M.05Iy8veFvlRiGfXVWad8gixEVZ4O5DMb0.1PjW', 5, 0, '2022-10-04', NULL, 1, '2023-10-11', '54432637', '442434442524'),
(106, '5050', '0', '0', 'Douglas', 'ForTes', 'EdVtsx46', '2004-09-29', 'Male', '255', 'Single', '2021-01-14', 8, 130, '001', 1, 1, '9090', '3', '2022-10-04', '3000000.00', 'dsm', 'dsm', 'dsm', '0785453423', 'samwelherman85@gmail.com', 'user.png', 0, 'dsm', 2, 2, '34345334323', 2, '5050', '5050', '$2y$10$67Q0QbsKfrTDlu.aiF6iqOoyTNceoGIINoDqqZj5p6BjWg1eFWMbC', 1, 0, '2022-10-04', '2022-10-17', 1, '2024-10-09', '2312343243', '1234345343'),
(107, '112', '0', '1', 'Laison', 'Marko', 'ZbzvYFq4', '2004-11-02', 'Male', '44', 'Single', '2022-11-23', 1, 96, '002', 1, 1, '255001', '3', '2022-11-23', '1500000.00', 'Sinza', 'Dar es salaam', 'Kijitonyama', '0123123123', 'laisonmarko@gmail.com', 'user.png', 0, 'Kijitonyama', 3, 17, '21312312312312', 2, '21', '112', '$2y$10$gxKKucyeD5Fbm6zppJHn1eQnUPptFbwidw6t.i4cXdm60oBQlxCOa', 5, 0, NULL, NULL, 1, '2023-11-24', '12121212', '2131231231231212');

-- --------------------------------------------------------

--
-- Table structure for table `employee_activity_grant`
--

CREATE TABLE `employee_activity_grant` (
  `id` bigint(20) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `activity_code` varchar(50) NOT NULL,
  `grant_code` varchar(50) NOT NULL,
  `percent` decimal(5,2) NOT NULL,
  `isActive` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_activity_grant`
--

INSERT INTO `employee_activity_grant` (`id`, `empID`, `activity_code`, `grant_code`, `percent`, `isActive`) VALUES
(1, '255001', 'AC0018', 'VSO', '80.00', 1),
(12, '255002', 'AC0018', 'VSO', '100.00', 1),
(13, '255003', 'AC0018', 'VSO', '100.00', 1),
(24, '255004', 'AC0018', 'VSO', '100.00', 1),
(31, '255005', 'AC0018', 'VSO', '100.00', 1),
(32, '255006', 'AC0018', 'VSO', '100.00', 1),
(33, '255007', 'AC0018', 'VSO', '100.00', 1),
(34, '255008', 'AC0018', 'VSO', '100.00', 1),
(50, '255009', 'AC0018', 'VSO', '100.00', 1),
(51, '255010', 'AC0018', 'VSO', '100.00', 1),
(52, '255011', 'AC0018', 'VSO', '100.00', 1),
(53, '255012', 'AC0018', 'VSO', '100.00', 1),
(54, '255013', 'AC0018', 'VSO', '100.00', 1),
(62, '255014', 'AC0018', 'VSO', '100.00', 1),
(66, '255015', 'AC0018', 'VSO', '100.00', 1),
(71, '255016', 'AC0018', 'VSO', '100.00', 1),
(72, '255017', 'AC0018', 'VSO', '100.00', 1),
(73, '255018', 'AC0018', 'VSO', '100.00', 1),
(74, '255019', 'AC0018', 'VSO', '100.00', 1),
(80, '255020', 'AC0018', 'VSO', '100.00', 1),
(81, '255021', 'AC0018', 'VSO', '100.00', 1),
(82, '255022', 'AC0018', 'VSO', '100.00', 1),
(83, '255023', 'AC0018', 'VSO', '100.00', 1),
(86, '255024', 'AC0018', 'VSO', '100.00', 1),
(87, '255025', 'AC0018', 'VSO', '100.00', 1),
(88, '255026', 'AC0018', 'VSO', '100.00', 1),
(89, '255027', 'AC0018', 'VSO', '100.00', 1),
(90, '255028', 'AC0018', 'VSO', '100.00', 1),
(91, '255029', 'AC0018', 'VSO', '100.00', 1),
(92, '255030', 'AC0018', 'VSO', '100.00', 1),
(93, '255031', 'AC0018', 'VSO', '100.00', 1),
(99, '255032', 'AC0018', 'VSO', '100.00', 1),
(100, '255033', 'AC0018', 'VSO', '100.00', 1),
(101, '255034', 'AC0018', 'VSO', '100.00', 1),
(104, '255035', 'AC0018', 'VSO', '100.00', 1),
(105, '255036', 'AC0018', 'VSO', '100.00', 1),
(106, '255037', 'AC0018', 'VSO', '100.00', 1),
(107, '255038', 'AC0018', 'VSO', '100.00', 1),
(108, '255039', 'AC0018', 'VSO', '100.00', 1),
(109, '255040', 'AC0018', 'VSO', '100.00', 1),
(110, '255041', 'AC0018', 'VSO', '100.00', 1),
(112, '255042', 'AC0018', 'VSO', '100.00', 1),
(113, '255043', 'AC0018', 'VSO', '100.00', 1),
(116, '255044', 'AC0018', 'VSO', '100.00', 1),
(117, '255045', 'AC0018', 'VSO', '100.00', 1),
(118, '255046', 'AC0018', 'VSO', '100.00', 1),
(119, '255047', 'AC0018', 'VSO', '100.00', 1),
(120, '255048', 'AC0018', 'VSO', '100.00', 1),
(121, '255049', 'AC0018', 'VSO', '100.00', 1),
(123, '255050', 'AC0018', 'VSO', '100.00', 1),
(124, '255051', 'AC0018', 'VSO', '100.00', 1),
(125, '255052', 'AC0018', 'VSO', '100.00', 1),
(126, '255053', 'AC0018', 'VSO', '100.00', 1),
(127, '255054', 'AC0018', 'VSO', '100.00', 1),
(128, '255055', 'AC0018', 'VSO', '100.00', 1),
(130, '255056', 'AC0018', 'VSO', '100.00', 1),
(132, '255057', 'AC0018', 'VSO', '100.00', 1),
(133, '255058', 'AC0018', 'VSO', '100.00', 1),
(135, '255059', 'AC0018', 'VSO', '100.00', 1),
(136, '255060', 'AC0018', 'VSO', '100.00', 1),
(137, '255061', 'AC0018', 'VSO', '100.00', 1),
(139, '255062', 'AC0018', 'VSO', '100.00', 1),
(140, '255063', 'AC0018', 'VSO', '100.00', 1),
(141, '255064', 'AC0018', 'VSO', '100.00', 1),
(142, '255065', 'AC0018', 'VSO', '100.00', 1),
(143, '255066', 'AC0018', 'VSO', '100.00', 1),
(144, '255067', 'AC0018', 'VSO', '100.00', 1),
(147, '255068', 'AC0018', 'VSO', '100.00', 1),
(148, '255069', 'AC0018', 'VSO', '100.00', 1),
(149, '255070', 'AC0018', 'VSO', '100.00', 1),
(150, '255071', 'AC0018', 'VSO', '100.00', 1),
(151, '255072', 'AC0018', 'VSO', '100.00', 1),
(152, '255073', 'AC0018', 'VSO', '100.00', 1),
(153, '255074', 'AC0018', 'VSO', '100.00', 1),
(154, '255075', 'AC0018', 'VSO', '100.00', 1),
(155, '255076', 'AC0018', 'VSO', '100.00', 1),
(156, '255077', 'AC0018', 'VSO', '100.00', 1),
(157, '255078', 'AC0018', 'VSO', '100.00', 1),
(158, '255079', 'AC0018', 'VSO', '100.00', 1),
(159, '255080', 'AC0018', 'VSO', '100.00', 1),
(166, '255081', 'AC0018', 'VSO', '100.00', 1),
(167, '255082', 'AC0018', 'VSO', '100.00', 1),
(168, '255083', 'AC0018', 'VSO', '100.00', 1),
(169, '255084', 'AC0018', 'VSO', '100.00', 1),
(170, '255085', 'AC0018', 'VSO', '100.00', 1),
(171, '255086', 'AC0018', 'VSO', '100.00', 1),
(172, '255087', 'AC0018', 'VSO', '100.00', 1),
(174, '255088', 'AC0018', 'VSO', '100.00', 0),
(177, '255089', 'AC0018', 'VSO', '100.00', 0),
(178, '255090', 'AC0018', 'VSO', '100.00', 0),
(179, '255091', 'AC0018', 'VSO', '100.00', 0),
(180, '255092', 'AC0018', 'VSO', '100.00', 0),
(181, '255093', 'AC0018', 'VSO', '100.00', 0),
(182, '255094', 'AC0018', 'VSO', '100.00', 1),
(183, '255095', 'AC0018', 'VSO', '100.00', 1),
(184, '255096', 'AC0018', 'VSO', '100.00', 1),
(185, '255097', 'AC0018', 'VSO', '100.00', 1),
(186, '255098', 'AC0018', 'VSO', '100.00', 0),
(187, '255099', 'AC0018', 'VSO', '100.00', 1),
(188, '255100', 'AC0018', 'VSO', '100.00', 1),
(189, '255101', 'AC0018', 'VSO', '100.00', 1),
(190, '255102', 'AC0018', 'VSO', '100.00', 1),
(191, '255103', 'AC0018', 'VSO', '100.00', 1),
(192, '255104', 'AC0018', 'VSO', '100.00', 1),
(193, '255105', 'AC0018', 'VSO', '100.00', 1),
(194, '255106', 'AC0018', 'VSO', '100.00', 1),
(195, '255107', 'AC0018', 'VSO', '100.00', 1),
(196, '255108', 'AC0018', 'VSO', '100.00', 1),
(197, '255109', 'AC0018', 'VSO', '100.00', 1),
(198, '255110', 'AC0018', 'VSO', '100.00', 1),
(199, '255111', 'AC0018', 'VSO', '100.00', 1),
(200, '255112', 'AC0018', 'VSO', '100.00', 1),
(201, '255113', 'AC0018', 'VSO', '100.00', 1),
(202, '255114', 'AC0018', 'VSO', '100.00', 1),
(203, '255115', 'AC0018', 'VSO', '100.00', 1),
(204, '255116', 'AC0018', 'VSO', '100.00', 1),
(205, '255117', 'AC0018', 'VSO', '100.00', 1),
(206, '255118', 'AC0018', 'VSO', '100.00', 1),
(207, '255119', 'AC0018', 'VSO', '100.00', 1),
(208, '255120', 'AC0018', 'VSO', '100.00', 1),
(209, '255121', 'AC0018', 'VSO', '100.00', 1),
(211, '255001', 'AA91', 'DFI024', '20.00', 1),
(212, '255002', 'A0006PES', 'PES004', '0.00', 0),
(213, '255004', 'A0016SAS', 'SAS005', '0.00', 0),
(214, '255007', 'A0016SAS', 'SAS005', '0.00', 0),
(216, 'Auto111222', 'AC0018', 'VSO', '100.00', 1),
(217, '87', 'AC0018', 'VSO', '100.00', 1),
(218, '3453', 'AC0018', 'VSO', '100.00', 1),
(219, '1111', 'AC0018', 'VSO', '100.00', 1),
(220, '2554', 'AC0018', 'VSO', '100.00', 1),
(221, 'Auto111333', 'AC0018', 'VSO', '100.00', 1),
(222, '54321', 'AC0018', 'VSO', '100.00', 1),
(223, '4321', 'AC0018', 'VSO', '100.00', 1),
(224, '123456', 'AC0018', 'VSO', '100.00', 1),
(225, '9090', 'AC0018', 'VSO', '100.00', 1),
(226, '8080', 'AC0018', 'VSO', '100.00', 1),
(227, '7070', 'AC0018', 'VSO', '100.00', 1),
(228, '6060', 'AC0018', 'VSO', '100.00', 1),
(229, '5050', 'AC0018', 'VSO', '100.00', 1),
(230, '112', 'AC0018', 'VSO', '100.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_activity_grant_logs`
--

CREATE TABLE `employee_activity_grant_logs` (
  `id` int(11) NOT NULL,
  `empID` varchar(45) DEFAULT NULL,
  `activity_code` varchar(45) DEFAULT NULL,
  `grant_code` varchar(45) DEFAULT NULL,
  `percent` varchar(45) DEFAULT NULL,
  `isActive` varchar(45) DEFAULT NULL,
  `payroll_date` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_activity_grant_logs`
--

INSERT INTO `employee_activity_grant_logs` (`id`, `empID`, `activity_code`, `grant_code`, `percent`, `isActive`, `payroll_date`) VALUES
(1, '255001', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(2, '255002', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(3, '255003', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(4, '255004', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(5, '255005', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(6, '255006', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(7, '255007', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(8, '255008', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(9, '255009', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(10, '255010', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(11, '255011', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(12, '255012', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(13, '255013', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(14, '255014', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(15, '255015', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(16, '255016', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(17, '255017', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(18, '255018', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(19, '255019', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(20, '255020', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(21, '255021', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(22, '255022', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(23, '255023', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(24, '255024', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(25, '255025', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(26, '255026', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(27, '255027', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(28, '255028', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(29, '255029', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(30, '255030', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(31, '255031', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(32, '255032', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(33, '255033', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(34, '255034', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(35, '255035', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(36, '255036', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(37, '255037', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(38, '255038', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(39, '255039', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(40, '255040', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(41, '255041', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(42, '255042', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(43, '255043', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(44, '255044', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(45, '255045', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(46, '255046', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(47, '255047', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(48, '255048', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(49, '255049', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(50, '255050', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(51, '255051', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(52, '255052', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(53, '255053', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(54, '255054', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(55, '255055', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(56, '255056', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(57, '255057', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(58, '255058', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(59, '255059', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(60, '255060', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(61, '255061', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(62, '255062', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(63, '255063', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(64, '255064', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(65, '255065', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(66, '255066', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(67, '255067', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(68, '255068', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(69, '255069', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(70, '255070', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(71, '255071', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(72, '255072', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(73, '255073', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(74, '255074', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(75, '255075', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(76, '255076', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(77, '255077', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(78, '255078', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(79, '255079', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(80, '255080', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(81, '255081', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(82, '255082', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(83, '255083', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(84, '255084', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(85, '255085', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(86, '255086', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(87, '255087', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(88, '255088', 'AC0018', 'VSO', '100.00', '0', '2019-01-29'),
(89, '255089', 'AC0018', 'VSO', '100.00', '0', '2019-01-29'),
(90, '255090', 'AC0018', 'VSO', '100.00', '0', '2019-01-29'),
(91, '255091', 'AC0018', 'VSO', '100.00', '0', '2019-01-29'),
(92, '255092', 'AC0018', 'VSO', '100.00', '0', '2019-01-29'),
(93, '255093', 'AC0018', 'VSO', '100.00', '0', '2019-01-29'),
(94, '255094', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(95, '255095', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(96, '255096', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(97, '255097', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(98, '255098', 'AC0018', 'VSO', '100.00', '0', '2019-01-29'),
(99, '255099', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(100, '255100', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(101, '255101', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(102, '255102', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(103, '255103', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(104, '255104', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(105, '255105', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(106, '255106', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(107, '255107', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(108, '255108', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(109, '255109', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(110, '255110', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(111, '255111', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(112, '255112', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(113, '255113', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(114, '255114', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(115, '255115', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(116, '255116', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(117, '255117', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(118, '255118', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(119, '255119', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(120, '255120', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(121, '255121', 'AC0018', 'VSO', '100.00', '1', '2019-01-29'),
(122, '255001', 'AC0018', 'VSO', '80.00', '1', '2019-02-19'),
(123, '255002', 'AC0018', 'VSO', '63.00', '1', '2019-02-19'),
(124, '255003', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(125, '255004', 'AC0018', 'VSO', '60.00', '1', '2019-02-19'),
(126, '255005', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(127, '255006', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(128, '255007', 'AC0018', 'VSO', '48.00', '1', '2019-02-19'),
(129, '255008', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(130, '255009', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(131, '255010', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(132, '255011', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(133, '255012', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(134, '255013', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(135, '255014', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(136, '255015', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(137, '255016', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(138, '255017', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(139, '255018', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(140, '255019', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(141, '255020', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(142, '255021', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(143, '255022', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(144, '255023', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(145, '255024', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(146, '255025', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(147, '255026', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(148, '255027', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(149, '255028', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(150, '255029', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(151, '255030', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(152, '255031', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(153, '255032', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(154, '255033', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(155, '255034', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(156, '255035', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(157, '255036', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(158, '255037', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(159, '255038', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(160, '255039', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(161, '255040', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(162, '255041', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(163, '255042', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(164, '255043', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(165, '255044', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(166, '255045', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(167, '255046', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(168, '255047', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(169, '255048', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(170, '255049', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(171, '255050', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(172, '255051', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(173, '255052', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(174, '255053', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(175, '255054', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(176, '255055', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(177, '255056', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(178, '255057', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(179, '255058', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(180, '255059', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(181, '255060', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(182, '255061', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(183, '255062', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(184, '255063', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(185, '255064', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(186, '255065', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(187, '255066', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(188, '255067', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(189, '255068', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(190, '255069', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(191, '255070', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(192, '255071', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(193, '255072', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(194, '255073', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(195, '255074', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(196, '255075', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(197, '255076', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(198, '255077', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(199, '255078', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(200, '255079', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(201, '255080', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(202, '255081', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(203, '255082', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(204, '255083', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(205, '255084', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(206, '255085', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(207, '255086', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(208, '255087', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(209, '255088', 'AC0018', 'VSO', '100.00', '0', '2019-02-19'),
(210, '255089', 'AC0018', 'VSO', '100.00', '0', '2019-02-19'),
(211, '255090', 'AC0018', 'VSO', '100.00', '0', '2019-02-19'),
(212, '255091', 'AC0018', 'VSO', '100.00', '0', '2019-02-19'),
(213, '255092', 'AC0018', 'VSO', '100.00', '0', '2019-02-19'),
(214, '255093', 'AC0018', 'VSO', '100.00', '0', '2019-02-19'),
(215, '255094', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(216, '255095', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(217, '255096', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(218, '255097', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(219, '255098', 'AC0018', 'VSO', '100.00', '0', '2019-02-19'),
(220, '255099', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(221, '255100', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(222, '255101', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(223, '255102', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(224, '255103', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(225, '255104', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(226, '255105', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(227, '255106', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(228, '255107', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(229, '255108', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(230, '255109', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(231, '255110', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(232, '255111', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(233, '255112', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(234, '255113', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(235, '255114', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(236, '255115', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(237, '255116', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(238, '255117', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(239, '255118', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(240, '255119', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(241, '255120', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(242, '255121', 'AC0018', 'VSO', '100.00', '1', '2019-02-19'),
(243, '255001', 'AA91', 'DFI024', '20.00', '1', '2019-02-19'),
(244, '255002', 'A0006PES', 'PES004', '37.00', '1', '2019-02-19'),
(245, '255004', 'A0016SAS', 'SAS005', '40.00', '1', '2019-02-19'),
(246, '255007', 'A0016SAS', 'SAS005', '52.00', '1', '2019-02-19'),
(497, '255001', 'AC0018', 'VSO', '80.00', '1', '2020-04-25'),
(498, '255002', 'AC0018', 'VSO', '63.00', '1', '2020-04-25'),
(499, '255003', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(500, '255004', 'AC0018', 'VSO', '60.00', '1', '2020-04-25'),
(501, '255005', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(502, '255006', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(503, '255007', 'AC0018', 'VSO', '48.00', '1', '2020-04-25'),
(504, '255008', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(505, '255009', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(506, '255010', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(507, '255011', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(508, '255012', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(509, '255013', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(510, '255014', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(511, '255015', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(512, '255016', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(513, '255017', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(514, '255018', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(515, '255019', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(516, '255020', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(517, '255021', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(518, '255022', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(519, '255023', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(520, '255024', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(521, '255025', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(522, '255026', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(523, '255027', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(524, '255028', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(525, '255029', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(526, '255030', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(527, '255031', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(528, '255032', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(529, '255033', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(530, '255034', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(531, '255035', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(532, '255036', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(533, '255037', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(534, '255038', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(535, '255039', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(536, '255040', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(537, '255041', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(538, '255042', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(539, '255043', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(540, '255044', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(541, '255045', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(542, '255046', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(543, '255047', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(544, '255048', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(545, '255049', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(546, '255050', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(547, '255051', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(548, '255052', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(549, '255053', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(550, '255054', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(551, '255055', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(552, '255056', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(553, '255057', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(554, '255058', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(555, '255059', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(556, '255060', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(557, '255061', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(558, '255062', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(559, '255063', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(560, '255064', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(561, '255065', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(562, '255066', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(563, '255067', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(564, '255068', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(565, '255069', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(566, '255070', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(567, '255071', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(568, '255072', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(569, '255073', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(570, '255074', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(571, '255075', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(572, '255076', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(573, '255077', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(574, '255078', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(575, '255079', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(576, '255080', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(577, '255081', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(578, '255082', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(579, '255083', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(580, '255084', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(581, '255085', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(582, '255086', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(583, '255087', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(584, '255088', 'AC0018', 'VSO', '100.00', '0', '2020-04-25'),
(585, '255089', 'AC0018', 'VSO', '100.00', '0', '2020-04-25'),
(586, '255090', 'AC0018', 'VSO', '100.00', '0', '2020-04-25'),
(587, '255091', 'AC0018', 'VSO', '100.00', '0', '2020-04-25'),
(588, '255092', 'AC0018', 'VSO', '100.00', '0', '2020-04-25'),
(589, '255093', 'AC0018', 'VSO', '100.00', '0', '2020-04-25'),
(590, '255094', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(591, '255095', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(592, '255096', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(593, '255097', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(594, '255098', 'AC0018', 'VSO', '100.00', '0', '2020-04-25'),
(595, '255099', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(596, '255100', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(597, '255101', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(598, '255102', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(599, '255103', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(600, '255104', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(601, '255105', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(602, '255106', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(603, '255107', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(604, '255108', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(605, '255109', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(606, '255110', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(607, '255111', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(608, '255112', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(609, '255113', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(610, '255114', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(611, '255115', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(612, '255116', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(613, '255117', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(614, '255118', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(615, '255119', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(616, '255120', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(617, '255121', 'AC0018', 'VSO', '100.00', '1', '2020-04-25'),
(618, '255001', 'AA91', 'DFI024', '20.00', '1', '2020-04-25'),
(619, '255002', 'A0006PES', 'PES004', '37.00', '1', '2020-04-25'),
(620, '255004', 'A0016SAS', 'SAS005', '40.00', '1', '2020-04-25'),
(621, '255007', 'A0016SAS', 'SAS005', '52.00', '1', '2020-04-25'),
(747, '255001', 'AC0018', 'VSO', '80.00', '1', '2022-09-14'),
(748, '255002', 'AC0018', 'VSO', '63.00', '1', '2022-09-14'),
(749, '255003', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(750, '255004', 'AC0018', 'VSO', '60.00', '1', '2022-09-14'),
(751, '255005', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(752, '255006', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(753, '255007', 'AC0018', 'VSO', '48.00', '1', '2022-09-14'),
(754, '255008', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(755, '255009', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(756, '255010', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(757, '255011', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(758, '255012', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(759, '255013', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(760, '255014', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(761, '255015', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(762, '255016', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(763, '255017', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(764, '255018', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(765, '255019', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(766, '255020', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(767, '255021', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(768, '255022', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(769, '255023', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(770, '255024', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(771, '255025', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(772, '255026', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(773, '255027', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(774, '255028', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(775, '255029', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(776, '255030', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(777, '255031', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(778, '255032', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(779, '255033', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(780, '255034', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(781, '255035', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(782, '255036', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(783, '255037', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(784, '255038', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(785, '255039', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(786, '255040', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(787, '255041', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(788, '255042', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(789, '255043', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(790, '255044', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(791, '255045', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(792, '255046', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(793, '255047', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(794, '255048', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(795, '255049', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(796, '255050', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(797, '255051', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(798, '255052', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(799, '255053', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(800, '255054', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(801, '255055', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(802, '255056', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(803, '255057', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(804, '255058', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(805, '255059', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(806, '255060', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(807, '255061', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(808, '255062', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(809, '255063', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(810, '255064', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(811, '255065', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(812, '255066', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(813, '255067', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(814, '255068', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(815, '255069', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(816, '255070', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(817, '255071', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(818, '255072', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(819, '255073', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(820, '255074', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(821, '255075', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(822, '255076', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(823, '255077', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(824, '255078', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(825, '255079', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(826, '255080', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(827, '255081', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(828, '255082', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(829, '255083', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(830, '255084', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(831, '255085', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(832, '255086', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(833, '255087', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(834, '255088', 'AC0018', 'VSO', '100.00', '0', '2022-09-14'),
(835, '255089', 'AC0018', 'VSO', '100.00', '0', '2022-09-14'),
(836, '255090', 'AC0018', 'VSO', '100.00', '0', '2022-09-14'),
(837, '255091', 'AC0018', 'VSO', '100.00', '0', '2022-09-14'),
(838, '255092', 'AC0018', 'VSO', '100.00', '0', '2022-09-14'),
(839, '255093', 'AC0018', 'VSO', '100.00', '0', '2022-09-14'),
(840, '255094', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(841, '255095', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(842, '255096', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(843, '255097', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(844, '255098', 'AC0018', 'VSO', '100.00', '0', '2022-09-14'),
(845, '255099', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(846, '255100', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(847, '255101', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(848, '255102', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(849, '255103', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(850, '255104', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(851, '255105', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(852, '255106', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(853, '255107', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(854, '255108', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(855, '255109', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(856, '255110', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(857, '255111', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(858, '255112', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(859, '255113', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(860, '255114', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(861, '255115', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(862, '255116', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(863, '255117', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(864, '255118', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(865, '255119', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(866, '255120', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(867, '255121', 'AC0018', 'VSO', '100.00', '1', '2022-09-14'),
(868, '255001', 'AA91', 'DFI024', '20.00', '1', '2022-09-14'),
(869, '255002', 'A0006PES', 'PES004', '37.00', '1', '2022-09-14'),
(870, '255004', 'A0016SAS', 'SAS005', '40.00', '1', '2022-09-14'),
(871, '255007', 'A0016SAS', 'SAS005', '52.00', '1', '2022-09-14'),
(872, '255001', 'AC0018', 'VSO', '80.00', '1', '2022-08-31'),
(873, '255002', 'AC0018', 'VSO', '63.00', '1', '2022-08-31'),
(874, '255003', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(875, '255004', 'AC0018', 'VSO', '60.00', '1', '2022-08-31'),
(876, '255005', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(877, '255006', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(878, '255007', 'AC0018', 'VSO', '48.00', '1', '2022-08-31'),
(879, '255008', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(880, '255009', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(881, '255010', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(882, '255011', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(883, '255012', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(884, '255013', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(885, '255014', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(886, '255015', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(887, '255016', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(888, '255017', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(889, '255018', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(890, '255019', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(891, '255020', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(892, '255021', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(893, '255022', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(894, '255023', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(895, '255024', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(896, '255025', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(897, '255026', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(898, '255027', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(899, '255028', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(900, '255029', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(901, '255030', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(902, '255031', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(903, '255032', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(904, '255033', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(905, '255034', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(906, '255035', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(907, '255036', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(908, '255037', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(909, '255038', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(910, '255039', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(911, '255040', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(912, '255041', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(913, '255042', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(914, '255043', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(915, '255044', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(916, '255045', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(917, '255046', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(918, '255047', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(919, '255048', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(920, '255049', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(921, '255050', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(922, '255051', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(923, '255052', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(924, '255053', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(925, '255054', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(926, '255055', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(927, '255056', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(928, '255057', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(929, '255058', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(930, '255059', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(931, '255060', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(932, '255061', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(933, '255062', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(934, '255063', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(935, '255064', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(936, '255065', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(937, '255066', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(938, '255067', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(939, '255068', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(940, '255069', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(941, '255070', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(942, '255071', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(943, '255072', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(944, '255073', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(945, '255074', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(946, '255075', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(947, '255076', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(948, '255077', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(949, '255078', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(950, '255079', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(951, '255080', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(952, '255081', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(953, '255082', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(954, '255083', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(955, '255084', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(956, '255085', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(957, '255086', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(958, '255087', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(959, '255088', 'AC0018', 'VSO', '100.00', '0', '2022-08-31'),
(960, '255089', 'AC0018', 'VSO', '100.00', '0', '2022-08-31'),
(961, '255090', 'AC0018', 'VSO', '100.00', '0', '2022-08-31'),
(962, '255091', 'AC0018', 'VSO', '100.00', '0', '2022-08-31'),
(963, '255092', 'AC0018', 'VSO', '100.00', '0', '2022-08-31'),
(964, '255093', 'AC0018', 'VSO', '100.00', '0', '2022-08-31'),
(965, '255094', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(966, '255095', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(967, '255096', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(968, '255097', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(969, '255098', 'AC0018', 'VSO', '100.00', '0', '2022-08-31'),
(970, '255099', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(971, '255100', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(972, '255101', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(973, '255102', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(974, '255103', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(975, '255104', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(976, '255105', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(977, '255106', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(978, '255107', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(979, '255108', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(980, '255109', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(981, '255110', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(982, '255111', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(983, '255112', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(984, '255113', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(985, '255114', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(986, '255115', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(987, '255116', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(988, '255117', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(989, '255118', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(990, '255119', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(991, '255120', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(992, '255121', 'AC0018', 'VSO', '100.00', '1', '2022-08-31'),
(993, '255001', 'AA91', 'DFI024', '20.00', '1', '2022-08-31'),
(994, '255002', 'A0006PES', 'PES004', '37.00', '1', '2022-08-31'),
(995, '255004', 'A0016SAS', 'SAS005', '40.00', '1', '2022-08-31'),
(996, '255007', 'A0016SAS', 'SAS005', '52.00', '1', '2022-08-31'),
(1123, '255001', 'AC0018', 'VSO', '80.00', '1', '2022-10-04'),
(1124, '255002', 'AC0018', 'VSO', '63.00', '1', '2022-10-04'),
(1125, '255003', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1126, '255004', 'AC0018', 'VSO', '60.00', '1', '2022-10-04'),
(1127, '255005', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1128, '255006', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1129, '255007', 'AC0018', 'VSO', '48.00', '1', '2022-10-04'),
(1130, '255008', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1131, '255009', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1132, '255010', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1133, '255011', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1134, '255012', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1135, '255013', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1136, '255014', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1137, '255015', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1138, '255016', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1139, '255017', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1140, '255018', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1141, '255019', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1142, '255020', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1143, '255021', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1144, '255022', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1145, '255023', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1146, '255024', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1147, '255025', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1148, '255026', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1149, '255027', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1150, '255028', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1151, '255029', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1152, '255030', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1153, '255031', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1154, '255032', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1155, '255033', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1156, '255034', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1157, '255035', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1158, '255036', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1159, '255037', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1160, '255038', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1161, '255039', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1162, '255040', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1163, '255041', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1164, '255042', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1165, '255043', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1166, '255044', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1167, '255045', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1168, '255046', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1169, '255047', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1170, '255048', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1171, '255049', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1172, '255050', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1173, '255051', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1174, '255052', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1175, '255053', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1176, '255054', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1177, '255055', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1178, '255056', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1179, '255057', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1180, '255058', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1181, '255059', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1182, '255060', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1183, '255061', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1184, '255062', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1185, '255063', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1186, '255064', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1187, '255065', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1188, '255066', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1189, '255067', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1190, '255068', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1191, '255069', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1192, '255070', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1193, '255071', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1194, '255072', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1195, '255073', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1196, '255074', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1197, '255075', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1198, '255076', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1199, '255077', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1200, '255078', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1201, '255079', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1202, '255080', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1203, '255081', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1204, '255082', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1205, '255083', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1206, '255084', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1207, '255085', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1208, '255086', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1209, '255087', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1210, '255088', 'AC0018', 'VSO', '100.00', '0', '2022-10-04'),
(1211, '255089', 'AC0018', 'VSO', '100.00', '0', '2022-10-04'),
(1212, '255090', 'AC0018', 'VSO', '100.00', '0', '2022-10-04'),
(1213, '255091', 'AC0018', 'VSO', '100.00', '0', '2022-10-04'),
(1214, '255092', 'AC0018', 'VSO', '100.00', '0', '2022-10-04'),
(1215, '255093', 'AC0018', 'VSO', '100.00', '0', '2022-10-04'),
(1216, '255094', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1217, '255095', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1218, '255096', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1219, '255097', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1220, '255098', 'AC0018', 'VSO', '100.00', '0', '2022-10-04'),
(1221, '255099', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1222, '255100', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1223, '255101', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1224, '255102', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1225, '255103', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1226, '255104', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1227, '255105', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1228, '255106', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1229, '255107', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1230, '255108', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1231, '255109', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1232, '255110', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1233, '255111', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1234, '255112', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1235, '255113', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1236, '255114', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1237, '255115', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1238, '255116', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1239, '255117', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1240, '255118', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1241, '255119', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1242, '255120', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1243, '255121', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1244, '255001', 'AA91', 'DFI024', '20.00', '1', '2022-10-04'),
(1245, '255002', 'A0006PES', 'PES004', '37.00', '1', '2022-10-04'),
(1246, '255004', 'A0016SAS', 'SAS005', '40.00', '1', '2022-10-04'),
(1247, '255007', 'A0016SAS', 'SAS005', '52.00', '1', '2022-10-04'),
(1248, 'Auto111222', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1249, '87', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1250, '3453', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1251, '1111', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1252, '2554', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1253, 'Auto111333', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1254, '54321', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1255, '4321', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1256, '123456', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1257, '9090', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1258, '8080', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1259, '7070', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1260, '6060', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1261, '5050', 'AC0018', 'VSO', '100.00', '1', '2022-10-04'),
(1402, '255001', 'AC0018', 'VSO', '80.00', '1', '2022-11-06'),
(1403, '255002', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1404, '255003', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1405, '255004', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1406, '255005', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1407, '255006', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1408, '255007', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1409, '255008', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1410, '255009', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1411, '255010', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1412, '255011', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1413, '255012', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1414, '255013', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1415, '255014', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1416, '255015', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1417, '255016', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1418, '255017', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1419, '255018', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1420, '255019', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1421, '255020', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1422, '255021', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1423, '255022', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1424, '255023', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1425, '255024', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1426, '255025', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1427, '255026', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1428, '255027', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1429, '255028', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1430, '255029', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1431, '255030', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1432, '255031', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1433, '255032', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1434, '255033', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1435, '255034', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1436, '255035', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1437, '255036', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1438, '255037', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1439, '255038', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1440, '255039', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1441, '255040', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1442, '255041', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1443, '255042', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1444, '255043', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1445, '255044', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1446, '255045', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1447, '255046', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1448, '255047', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1449, '255048', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1450, '255049', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1451, '255050', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1452, '255051', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1453, '255052', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1454, '255053', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1455, '255054', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1456, '255055', 'AC0018', 'VSO', '100.00', '1', '2022-11-06');
INSERT INTO `employee_activity_grant_logs` (`id`, `empID`, `activity_code`, `grant_code`, `percent`, `isActive`, `payroll_date`) VALUES
(1457, '255056', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1458, '255057', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1459, '255058', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1460, '255059', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1461, '255060', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1462, '255061', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1463, '255062', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1464, '255063', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1465, '255064', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1466, '255065', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1467, '255066', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1468, '255067', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1469, '255068', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1470, '255069', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1471, '255070', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1472, '255071', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1473, '255072', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1474, '255073', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1475, '255074', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1476, '255075', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1477, '255076', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1478, '255077', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1479, '255078', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1480, '255079', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1481, '255080', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1482, '255081', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1483, '255082', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1484, '255083', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1485, '255084', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1486, '255085', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1487, '255086', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1488, '255087', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1489, '255088', 'AC0018', 'VSO', '100.00', '0', '2022-11-06'),
(1490, '255089', 'AC0018', 'VSO', '100.00', '0', '2022-11-06'),
(1491, '255090', 'AC0018', 'VSO', '100.00', '0', '2022-11-06'),
(1492, '255091', 'AC0018', 'VSO', '100.00', '0', '2022-11-06'),
(1493, '255092', 'AC0018', 'VSO', '100.00', '0', '2022-11-06'),
(1494, '255093', 'AC0018', 'VSO', '100.00', '0', '2022-11-06'),
(1495, '255094', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1496, '255095', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1497, '255096', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1498, '255097', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1499, '255098', 'AC0018', 'VSO', '100.00', '0', '2022-11-06'),
(1500, '255099', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1501, '255100', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1502, '255101', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1503, '255102', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1504, '255103', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1505, '255104', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1506, '255105', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1507, '255106', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1508, '255107', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1509, '255108', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1510, '255109', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1511, '255110', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1512, '255111', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1513, '255112', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1514, '255113', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1515, '255114', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1516, '255115', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1517, '255116', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1518, '255117', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1519, '255118', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1520, '255119', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1521, '255120', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1522, '255121', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1523, '255001', 'AA91', 'DFI024', '20.00', '1', '2022-11-06'),
(1524, '255002', 'A0006PES', 'PES004', '0.00', '0', '2022-11-06'),
(1525, '255004', 'A0016SAS', 'SAS005', '0.00', '0', '2022-11-06'),
(1526, '255007', 'A0016SAS', 'SAS005', '0.00', '0', '2022-11-06'),
(1527, 'Auto111222', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1528, '87', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1529, '3453', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1530, '1111', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1531, '2554', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1532, 'Auto111333', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1533, '54321', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1534, '4321', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1535, '123456', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1536, '9090', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1537, '8080', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1538, '7070', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1539, '6060', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1540, '5050', 'AC0018', 'VSO', '100.00', '1', '2022-11-06'),
(1541, '112', 'AC0018', 'VSO', '100.00', '1', '2022-11-06');

-- --------------------------------------------------------

--
-- Table structure for table `employee_group`
--

CREATE TABLE `employee_group` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `group_name` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_group`
--

INSERT INTO `employee_group` (`id`, `empID`, `group_name`) VALUES
(63, '255001', 15),
(64, '255024', 15),
(65, '255010', 16),
(66, '255073', 17),
(67, '255029', 17),
(68, '255039', 17),
(69, '255034', 17),
(70, '255029', 2),
(71, '255034', 2),
(72, '255039', 2),
(73, '255014', 2),
(74, '255010', 2),
(75, '255073', 2),
(76, '255050', 18),
(77, '255049', 14),
(78, '255050', 14),
(79, '255051', 14),
(80, '255052', 14),
(81, '255053', 14),
(82, '255054', 14),
(83, '255055', 14),
(84, '255056', 14),
(85, '255058', 14),
(86, '255059', 14),
(87, '255060', 14),
(88, '255061', 14),
(89, '255062', 14),
(90, '255063', 14),
(91, '255064', 14),
(92, '255065', 14),
(93, '255066', 14),
(94, '255067', 14),
(95, '255068', 14),
(96, '255069', 14),
(97, '255071', 14),
(98, '255072', 14),
(109, 'Auto111222', 1),
(110, '87', 1),
(111, '3453', 1),
(112, '1111', 1),
(113, '2554', 1),
(114, 'Auto111333', 1),
(115, '54321', 1),
(116, '4321', 1),
(117, '123456', 1),
(118, '9090', 1),
(119, '8080', 1),
(120, '7070', 1),
(121, '6060', 1),
(122, '5050', 1),
(123, '112', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_overtime`
--

CREATE TABLE `employee_overtime` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `time_start` datetime NOT NULL,
  `time_end` datetime NOT NULL,
  `overtime_type` int(1) NOT NULL DEFAULT 0 COMMENT '0-Day, 1-Night',
  `overtime_category` int(11) NOT NULL,
  `reason` varchar(300) NOT NULL,
  `final_line_manager_comment` varchar(200) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `application_time` datetime DEFAULT current_timestamp(),
  `status` int(11) NOT NULL COMMENT '0-requested, 1-recommended, 2-approved by HR, 3-Held by Line Manager, 4-Denied By HR, 5-Confirmed by line',
  `linemanager` varchar(10) DEFAULT NULL,
  `hr` varchar(10) NOT NULL,
  `time_recommended_line` datetime NOT NULL,
  `time_approved_hr` date NOT NULL,
  `time_confirmed_line` datetime NOT NULL,
  `cd` varchar(110) NOT NULL,
  `time_approved_cd` varchar(110) NOT NULL,
  `finance` varchar(110) NOT NULL,
  `time_approved_fin` varchar(110) NOT NULL,
  `commit` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_overtime`
--

INSERT INTO `employee_overtime` (`id`, `empID`, `time_start`, `time_end`, `overtime_type`, `overtime_category`, `reason`, `final_line_manager_comment`, `remarks`, `application_time`, `status`, `linemanager`, `hr`, `time_recommended_line`, `time_approved_hr`, `time_confirmed_line`, `cd`, `time_approved_cd`, `finance`, `time_approved_fin`, `commit`) VALUES
(5, 'TZ346', '2020-06-29 02:00:00', '2020-06-29 03:00:00', 1, 2, 'nn', '', '', '2020-06-29 01:37:03', 2, 'TZ1110594', 'TZ1114433', '2020-06-29 00:00:00', '2020-06-29', '2020-06-29 01:37:03', 'S21179', '2020-06-29', 'TZ394', '2020-06-29', 0),
(6, 'TZ346', '2020-06-29 03:00:00', '2020-06-29 06:00:00', 1, 1, 'over', '', '', '2020-06-29 02:03:37', 2, 'TZ1110594', 'TZ1114433', '2020-06-29 00:00:00', '2020-06-29', '2020-06-29 02:03:37', 'S21179', '2020-06-29', 'TZ394', '2020-06-29', 0),
(7, 'TZ346', '2020-07-01 17:00:00', '2020-07-01 20:00:00', 0, 1, 'Normal Overtime1', '', '', '2020-07-01 00:05:09', 2, 'TZ1110594', 'TZ1114433', '2020-07-01 00:00:00', '2020-07-01', '2020-07-01 08:05:09', 'S21179', '2020-07-01', 'TZ394', '2020-07-01', 0),
(8, 'TZ346', '2020-07-02 08:00:00', '2020-07-02 17:00:00', 0, 2, 'Holiday overtime2', '', '', '2020-07-01 00:07:52', 2, 'TZ1110594', 'TZ1114433', '2020-07-01 00:00:00', '2020-07-01', '2020-07-01 08:07:52', 'S21179', '2020-07-01', 'TZ394', '2020-07-01', 0),
(9, 'TZ346', '2020-07-03 20:00:00', '2020-07-04 06:00:00', 1, 3, 'Night overtime3', '', '', '2020-07-01 00:09:59', 2, 'TZ1110594', 'TZ1114433', '2020-07-01 00:00:00', '2020-07-01', '2020-07-01 08:09:59', 'S21179', '2020-07-01', 'TZ394', '2020-07-01', 0),
(10, 'TZ1114433', '2020-07-01 20:00:00', '2020-07-01 23:30:00', 1, 3, 'Night Shift', '', '', '2020-07-01 02:39:15', 2, 'TZ394', 'TZ1113936', '2020-07-01 00:00:00', '2020-07-01', '2020-07-01 10:39:15', 'S21179', '2020-07-01', 'TZ394', '2020-07-01', 0),
(11, 'TZ346', '2020-07-01 17:00:00', '2020-07-01 20:00:00', 0, 1, 'Normal Overtime1', '', '', '2020-07-01 02:47:10', 2, 'TZ1110594', 'TZ1114433', '2020-07-01 00:00:00', '2020-07-01', '2020-07-01 10:47:10', 'S21179', '2020-07-01', 'TZ394', '2020-07-01', 0),
(12, 'TZ346', '2020-07-01 08:00:00', '2020-07-01 17:00:00', 0, 2, 'Holiday overtime1', '', '', '2020-07-01 02:48:28', 2, 'TZ1110594', 'TZ1114433', '2020-07-01 00:00:00', '2020-07-01', '2020-07-01 10:48:28', 'S21179', '2020-07-01', 'TZ394', '2020-07-01', 0),
(13, 'TZ346', '2020-07-03 20:00:00', '2020-07-04 18:00:00', 0, 3, 'Night Shift1', '', '', '2020-07-01 02:49:17', 2, 'TZ1110594', 'TZ1114433', '2020-07-01 00:00:00', '2020-07-01', '2020-07-01 10:49:17', 'S21179', '2020-07-01', 'TZ394', '2020-07-01', 0),
(14, '255024', '2020-09-09 09:30:00', '2020-09-09 17:00:00', 0, 1, 'dkjbskdjc', '', '', '2020-09-02 02:33:14', 0, 'TZ1110882', '', '2020-09-02 10:33:14', '2020-09-02', '2020-09-02 10:33:14', '', '', '', '', 0),
(15, '255001', '2022-09-14 00:00:00', '2022-09-15 00:00:00', 0, 2, 'Working during Karume day', '', '', '2022-09-14 08:53:34', 0, 'TZ394', '', '2022-09-14 11:53:34', '2022-09-14', '2022-09-14 11:53:34', '', '', '', '', 0),
(16, '5050', '2022-10-04 17:00:00', '2022-10-04 18:00:00', 0, 1, 'Fixing Flex CRM issue2', 'Its critical, afanye kazi overtime Zanzibar', '', '2022-10-04 10:27:23', 2, '9090', '255001', '2022-10-04 00:00:00', '2022-10-04', '2022-10-04 01:27:23', '255073', '2022-10-04', '255010', '2022-10-04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `emp_allowances`
--

CREATE TABLE `emp_allowances` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `allowance` int(11) NOT NULL,
  `group_name` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_allowances`
--

INSERT INTO `emp_allowances` (`id`, `empID`, `allowance`, `group_name`) VALUES
(1, 'TZ1114433', 7, 0),
(2, 'V1119259', 6, 14),
(3, 'V1120850', 6, 14),
(4, 'V1117694', 6, 14),
(5, 'V1120365', 6, 14),
(6, 'V1120364', 6, 14),
(7, 'V1120726', 6, 14),
(8, 'V1107641', 6, 14),
(9, 'V1122495', 6, 14),
(10, 'V1122491', 6, 14),
(11, 'V1121008', 6, 14),
(12, 'V1116705', 6, 14),
(13, 'V1115825', 6, 14),
(14, 'V1118644', 6, 14),
(15, 'V1121009', 6, 14),
(16, 'V1122282', 6, 14),
(17, 'V1123869', 6, 14),
(18, 'V1123855', 6, 14),
(19, 'V1123868', 6, 14),
(21, 'V1123864', 6, 14),
(22, 'V11123974', 6, 14),
(23, 'V11123973', 6, 14),
(24, 'V1119259', 14, 14),
(25, 'V1120850', 14, 14),
(26, 'V1117694', 14, 14),
(27, 'V1120365', 14, 14),
(28, 'V1120364', 14, 14),
(29, 'V1120726', 14, 14),
(30, 'V1107641', 14, 14),
(31, 'V1122495', 14, 14),
(32, 'V1122491', 14, 14),
(33, 'V1121008', 14, 14),
(34, 'V1116705', 14, 14),
(35, 'V1115825', 14, 14),
(36, 'V1118644', 14, 14),
(37, 'V1121009', 14, 14),
(38, 'V1122282', 14, 14),
(39, 'V1123869', 14, 14),
(40, 'V1123855', 14, 14),
(41, 'V1123868', 14, 14),
(43, 'V1123864', 14, 14),
(44, 'V11123974', 14, 14),
(45, 'V11123973', 14, 14),
(46, 'V1123856', 6, 14),
(47, 'V1123856', 14, 14);

-- --------------------------------------------------------

--
-- Table structure for table `emp_deductions`
--

CREATE TABLE `emp_deductions` (
  `id` int(11) NOT NULL,
  `empID` varchar(50) NOT NULL,
  `deduction` int(11) NOT NULL,
  `group_name` int(11) NOT NULL DEFAULT 0 COMMENT '0- For individual'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emp_role`
--

CREATE TABLE `emp_role` (
  `id` int(11) NOT NULL,
  `userID` varchar(10) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `group_name` int(11) NOT NULL DEFAULT 0,
  `duedate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_role`
--

INSERT INTO `emp_role` (`id`, `userID`, `role`, `group_name`, `duedate`) VALUES
(3, '255025', 2, 2, '2020-05-18 20:19:04'),
(4, '255028', 13, 2, '2020-05-18 20:19:04'),
(43, '255029', 2, 2, '2020-07-08 04:10:56'),
(44, '255034', 28, 2, '2020-07-08 04:11:08'),
(45, '255039', 2, 2, '2020-07-08 04:11:35'),
(46, '255014', 2, 2, '2020-07-08 04:11:51'),
(47, '255010', 2, 2, '2020-07-08 04:12:14'),
(48, '255073', 2, 2, '2020-07-08 04:13:07'),
(49, '255001', 25, 15, '2020-07-08 04:18:50'),
(50, '255024', 25, 15, '2020-07-08 04:18:50'),
(51, '255010', 26, 16, '2020-07-08 04:19:26'),
(52, '255073', 27, 17, '2020-07-08 04:19:55'),
(53, '255029', 27, 17, '2020-07-08 04:19:55'),
(54, '255039', 27, 17, '2020-07-08 04:19:55'),
(55, '255034', 27, 17, '2020-07-08 04:19:55'),
(58, '9090', 2, 0, '2022-10-04 09:31:22'),
(59, '255001', 13, 0, '2022-10-06 05:02:22'),
(60, '255001', 26, 0, '2022-10-06 05:02:31');

-- --------------------------------------------------------

--
-- Table structure for table `emp_skills`
--

CREATE TABLE `emp_skills` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `skill_ID` int(11) NOT NULL,
  `certificate` varchar(50) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exception_type`
--

CREATE TABLE `exception_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` varchar(45) NOT NULL,
  `created_by` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exit_list`
--

CREATE TABLE `exit_list` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `initiator` varchar(50) NOT NULL,
  `reason` varchar(500) NOT NULL,
  `date_confirmed` date NOT NULL,
  `confirmed_by` varchar(10) NOT NULL,
  `exit_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exit_list`
--

INSERT INTO `exit_list` (`id`, `empID`, `initiator`, `reason`, `date_confirmed`, `confirmed_by`, `exit_date`) VALUES
(9, '255017', 'Employee', 'fdsf', '2021-05-20', '255001', '2021-05-19'),
(8, '255016', 'Employee', 'fads', '2020-09-02', '255001', '2020-09-09'),
(3, 'V1123660', 'Employer', 'End of Service', '2020-06-19', 'TZ1114433', NULL),
(4, 'V1120922', 'Employer', 'End of Service', '2020-06-19', 'TZ1114433', NULL),
(5, 'TZ1123840', 'Employer', 'End of Service', '2020-06-19', 'TZ1114433', NULL),
(7, '255027', 'Employee', '', '2020-09-02', '255001', '2020-09-02'),
(10, '255019', 'Employee', 'Resigned to pursue further studies', '2022-09-14', '255001', '2022-09-14');

-- --------------------------------------------------------

--
-- Table structure for table `expense_category`
--

CREATE TABLE `expense_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` varchar(45) NOT NULL,
  `created_by` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `funder`
--

CREATE TABLE `funder` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `createdOn` datetime NOT NULL DEFAULT current_timestamp(),
  `createdBy` varchar(10) NOT NULL,
  `status` varchar(45) NOT NULL DEFAULT '1',
  `country` varchar(25) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `funder`
--

INSERT INTO `funder` (`id`, `name`, `email`, `phone`, `description`, `createdOn`, `createdBy`, `status`, `country`, `type`) VALUES
(1, 'James Sweke', 'sweke@gmail.com', '0757628103', NULL, '2020-04-12 09:32:16', '2550001', '1', NULL, NULL),
(4, 'Miraji & Sons', 'miraji@sons.com', '02227732458', 'Yes', '2020-05-08 04:31:59', '0970020', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grants`
--

CREATE TABLE `grants` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `funder` varchar(45) NOT NULL,
  `amount` decimal(20,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `grants`
--

INSERT INTO `grants` (`id`, `code`, `name`, `description`, `funder`, `amount`) VALUES
(1, 'VSO', 'Unrestricted Funds', 'VSO Office Unrestricted Funds', '', NULL),
(7, 'DFI024', 'DFI024', 'DfID - ICS2 Transition', '', NULL),
(8, 'DFI025', 'DFI025', 'DfID  - Knowledge Exchange', '', NULL),
(9, 'DFI032', 'DFI032', 'DfID - temporarying for Development', '', NULL),
(10, 'RAN005', 'RAN005', 'Randstad Global Partnership 2016-19', '', NULL),
(11, 'PES004', 'PES004', 'Pestalozzi PCF for P677  - Part 2', '', NULL),
(12, 'NLD001', 'NLD001', 'VSO Netherlands (SAS005) - SP040', '', NULL),
(13, 'SAS005', 'SAS005', 'Sint Antonius Stichting - SP040', '', NULL),
(14, 'KPM002', 'KPM002', 'KPMG - SP062', '', NULL),
(15, 'DFA001', 'DFA001', 'Dept of Foreign Affairs Trade and Development P940', '', NULL),
(16, 'JJ001A', 'JJ001a', 'JJ001a Grant', '', NULL),
(17, 'JJ001B', 'JJ001b', 'JJ001b description', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grant_logs`
--

CREATE TABLE `grant_logs` (
  `id` int(11) NOT NULL,
  `funder` varchar(45) NOT NULL,
  `project` varchar(45) NOT NULL,
  `activity` varchar(45) NOT NULL,
  `mode` varchar(45) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` varchar(45) DEFAULT '0',
  `created_by` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grievances`
--

CREATE TABLE `grievances` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `title` varchar(200) NOT NULL DEFAULT 'N/A',
  `description` varchar(500) DEFAULT NULL,
  `attachment` varchar(200) DEFAULT NULL,
  `forwarded` int(1) NOT NULL DEFAULT 0,
  `support_document` varchar(100) DEFAULT 'N/A',
  `remarks` varchar(200) DEFAULT 'N/A',
  `recommendations` varchar(500) DEFAULT NULL,
  `forwarded_by` varchar(10) DEFAULT NULL,
  `forwarded_on` datetime DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '1-solved, 0-Not Solved',
  `anonymous` int(1) NOT NULL DEFAULT 0,
  `timed` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grievances`
--

INSERT INTO `grievances` (`id`, `empID`, `title`, `description`, `attachment`, `forwarded`, `support_document`, `remarks`, `recommendations`, `forwarded_by`, `forwarded_on`, `status`, `anonymous`, `timed`) VALUES
(1, '0970020', 'Malalamiko binafsi', 'Tununuliwe barakoa bwana... kama hiyo attached', '/uploads/grievances/FILE20200508-122806.pdf', 0, 'N/A', 'N/A', NULL, NULL, '2020-05-08 04:28:06', 1, 0, '2020-05-08 09:28:06');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `type` int(2) NOT NULL DEFAULT 1 COMMENT '1-Financial Group(Allowances, Bonuses and Deductions), 2-Role Group',
  `name` varchar(50) NOT NULL,
  `created_by` varchar(10) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `type`, `name`, `created_by`, `created_on`) VALUES
(1, 0, 'All Employees', 'TZ1114433', '2019-07-01 11:08:52'),
(2, 2, 'Line Managers', 'TZ1114433', '2019-07-01 11:08:52'),
(14, 1, 'temporarys H/A', 'TZ1114433', '2020-06-19 09:33:50'),
(15, 2, 'HR Group', 'TZ1113936', '2020-06-22 01:47:01'),
(16, 2, 'Finance Group', 'TZ1113936', '2020-06-22 01:47:25'),
(17, 2, 'Directors Group', 'TZ1113936', '2020-06-22 01:47:35'),
(18, 2, 'Administrators', 'TZ1113936', '2020-06-22 03:04:34'),
(19, 2, 'Observers', 'TZ1113936', '2020-06-29 05:53:34');

-- --------------------------------------------------------

--
-- Table structure for table `imprest`
--

CREATE TABLE `imprest` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `start` date NOT NULL DEFAULT '2019-07-21',
  `end` date NOT NULL DEFAULT '2019-07-21',
  `status` int(1) DEFAULT 0 COMMENT '0-Sent, 1-Recommended, 2-Approved, 3-Confirmed, 4-Retirement, 5-Confirm Retirement, 6- Disapproved, 7- Unconfirmed, 8-Not Retiredot Retired',
  `hr_recommend` varchar(110) NOT NULL,
  `date_hr_recommend` varchar(110) NOT NULL,
  `recommended_by` varchar(10) NOT NULL,
  `date_recommended` date NOT NULL,
  `approved_by` varchar(10) NOT NULL,
  `date_approved` date NOT NULL,
  `confirmed_by` varchar(10) NOT NULL DEFAULT '2550001',
  `date_confirmed` date NOT NULL DEFAULT '2019-10-05',
  `application_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `imprest`
--

INSERT INTO `imprest` (`id`, `empID`, `title`, `description`, `start`, `end`, `status`, `hr_recommend`, `date_hr_recommend`, `recommended_by`, `date_recommended`, `approved_by`, `date_approved`, `confirmed_by`, `date_confirmed`, `application_date`) VALUES
(2, 'TZ346', 'my imprest', 'work', '2020-06-30', '2020-07-07', 5, 'TZ1114433', '2020-06-29', 'TZ394', '2020-06-29', 'S21179', '2020-06-29', '2550001', '2020-06-29', '2020-06-29'),
(7, 'TZ1110594', 'Safari ya Kenya', 'Safari ya Kenya Test Bona', '2020-07-02', '2020-07-16', 5, 'TZ1114433', '2020-07-02', 'TZ394', '2020-07-02', 'S21179', '2020-07-02', '2550001', '2020-07-02', '2020-07-02'),
(9, 'TZ346', 'Safari ya Pemba', 'Safari ya Pemba Description', '2020-07-07', '2020-07-30', 5, 'TZ1114433', '2020-07-07', 'TZ394', '2020-07-07', 'S21179', '2020-07-07', '2550001', '2020-07-07', '2020-07-07'),
(12, '5050', 'Zanzibar MoL CRM fixing ', 'I am travelling to Zanzibar to fix MoL CRM', '2022-10-04', '2022-10-05', 2, '255001', '2022-10-04', '255010', '2022-10-04', '255073', '2022-10-04', '2550001', '2022-10-04', '2022-10-04');

-- --------------------------------------------------------

--
-- Table structure for table `imprest_requirement`
--

CREATE TABLE `imprest_requirement` (
  `id` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `evidence` varchar(200) NOT NULL,
  `imprestID` int(11) NOT NULL,
  `initial_amount` decimal(15,2) NOT NULL,
  `final_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `retired_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0-requested, 1-Approved, 2-Confirmed, 3-Retired, 4-Confirmed Retirement, 5-disapproved, 6-Not Confirmed, 7-Not Retired, 8-Not Confirmed Retirement',
  `due_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `imprest_requirement`
--

INSERT INTO `imprest_requirement` (`id`, `description`, `evidence`, `imprestID`, `initial_amount`, `final_amount`, `retired_amount`, `status`, `due_date`) VALUES
(13, 'Usafiri', '0', 7, '1000000.00', '100000.00', '0.00', 4, '2020-07-02'),
(14, 'fOOD and Accommodation', '0', 7, '1000000.00', '800000.00', '0.00', 4, '2020-07-02'),
(15, 'Dharula', '0', 7, '1700000.00', '1700000.00', '0.00', 4, '2020-07-02'),
(18, 'Usafiri', '0', 9, '1000000.00', '1000000.00', '0.00', 4, '2020-07-07'),
(19, 'Kulala na kula', '0', 9, '720000.00', '720000.00', '0.00', 4, '2020-07-07'),
(20, 'Dharula', '0', 9, '1212.00', '1212.00', '0.00', 4, '2020-07-07'),
(23, 'Usafiri', '0', 12, '30000.00', '25000.00', '0.00', 3, '2022-10-04'),
(24, 'Hotel', '0', 12, '50000.00', '50000.00', '0.00', 3, '2022-10-04'),
(25, 'Taxi', '0', 12, '20000.00', '20000.00', '0.00', 3, '2022-10-04');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(11) NOT NULL,
  `empID` varchar(11) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `days` int(3) DEFAULT 0,
  `leave_address` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `nature` varchar(50) DEFAULT '',
  `state` varchar(1) DEFAULT '1' COMMENT '0-completed, 1-on progress',
  `application_date` date DEFAULT NULL,
  `approved_by` varchar(10) DEFAULT NULL,
  `recommended_by` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `empID`, `start`, `end`, `days`, `leave_address`, `mobile`, `nature`, `state`, `application_date`, `approved_by`, `recommended_by`) VALUES
(1, 'TZ346', '2020-07-02', '2020-08-01', 30, 'dODOMA', '098765112', '1', '1', '2020-07-02', 'TZ1114433', 'TZ1114433'),
(2, 'TZ346', '2020-07-07', '2020-07-16', 9, 'Mwanza', '0987665544', '1', '1', '2020-07-01', 'TZ1114433', 'TZ1114433'),
(3, 'TZ346', '2020-07-03', '2020-07-06', 3, 'siha annual', '73488221', '1', '1', '2020-07-03', 'TZ1114433', 'TZ1114433'),
(4, 'TZ346', '2020-07-07', '2020-07-09', 2, 'siha exam', '9865', '2', '1', '2020-07-03', 'TZ1114433', 'TZ1114433'),
(5, 'TZ346', '2020-07-07', '2020-07-09', 2, 'siha exam', '9865', '2', '1', '2020-07-03', 'TZ1114433', 'TZ1114433'),
(6, '5050', '2020-07-22', '2020-08-27', -12, 'siha paternity', '8', '1', '1', '2020-07-03', 'TZ1114433', 'TZ1114433'),
(7, 'TZ346', '2020-07-13', '2020-07-15', 2, 'siha compassionate', '9', '6', '1', '2020-07-03', 'TZ1114433', 'TZ1114433'),
(8, 'TZ346', '2020-07-10', '2020-07-12', 2, 'siha sick', '7', '5', '1', '2020-07-03', 'TZ1114433', 'TZ1114433'),
(9, 'TZ346', '2020-07-06', '2020-07-13', 7, 'gu', '0789565656', '2', '1', '2020-07-06', 'TZ1114433', 'TZ1110594'),
(10, 'TZ346', '2020-07-07', '2020-07-17', 10, 'Kiabaha', 'sina', '1', '1', '2020-07-07', 'TZ1114433', 'TZ1110594'),
(11, '5050', '2022-10-05', '2022-10-07', 2, 'Mbagala Dar ', '0754210953', '1', '1', '2022-10-04', '255001', '9090');

-- --------------------------------------------------------

--
-- Table structure for table `leave_application`
--

CREATE TABLE `leave_application` (
  `id` int(11) NOT NULL,
  `empID` varchar(11) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `leave_address` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `nature` varchar(50) DEFAULT '1',
  `reason` varchar(500) DEFAULT NULL,
  `status` int(5) DEFAULT 0 COMMENT '0-Sent, 1-Recommended, 2-Approved, 3-Held, 4-Cancelled, 5-Disapproved by HR',
  `remarks` varchar(255) DEFAULT NULL,
  `notification` int(1) DEFAULT 2 COMMENT '0-seen, 1-Employee, 2-line manager, 3-hr approve, 4-seen by employee waiting hr',
  `application_date` date DEFAULT NULL,
  `approved_by_hr` varchar(15) DEFAULT NULL,
  `approved_date_hr` date DEFAULT NULL,
  `approved_by_line` varchar(15) DEFAULT NULL,
  `approved_date_line` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_application`
--

INSERT INTO `leave_application` (`id`, `empID`, `start`, `end`, `leave_address`, `mobile`, `nature`, `reason`, `status`, `remarks`, `notification`, `application_date`, `approved_by_hr`, `approved_date_hr`, `approved_by_line`, `approved_date_line`) VALUES
(6, 'TZ346', '2020-07-03', '2020-07-06', 'siha annual', '73488221', '1', 'siha annual', 2, NULL, 3, '2020-07-03', 'TZ1114433', '2020-07-03', 'TZ1114433', '2020-07-03'),
(7, 'TZ346', '2020-07-07', '2020-07-09', 'siha exam', '9865', '2', 'siha exam', 2, NULL, 3, '2020-07-03', 'TZ1114433', '2020-07-03', 'TZ1114433', '2020-07-03'),
(8, 'TZ346', '2020-07-10', '2020-07-12', 'siha sick', '7', '5', 'siha sick', 2, NULL, 3, '2020-07-03', 'TZ1114433', '2020-07-03', 'TZ1114433', '2020-07-03'),
(9, 'TZ346', '2020-07-13', '2020-07-15', 'siha compassionate', '9', '6', 'siha Compassionate ', 2, NULL, 3, '2020-07-03', 'TZ1114433', '2020-07-03', 'TZ1114433', '2020-07-03'),
(10, 'TZ346', '2020-07-22', '2020-08-27', 'siha paternity', '8', '7', 'siha partenity', 2, NULL, 3, '2020-07-03', 'TZ1114433', '2020-07-03', 'TZ1114433', '2020-07-03'),
(11, 'TZ346', '2020-07-06', '2020-07-13', 'gu', '0789565656', '2', 'kjsdjn', 2, NULL, 3, '2020-07-06', 'TZ1114433', '2020-07-06', 'TZ1110594', '2020-07-06'),
(12, 'TZ346', '2020-07-07', '2020-07-17', 'Kiabaha', 'sina', '1', 'No', 2, NULL, 3, '2020-07-07', 'TZ1114433', '2020-07-07', 'TZ1110594', '2020-07-07'),
(13, '255001', '2022-09-25', '2022-09-30', 'Zanzibar', '0676210953', '1', 'Well deserved leave', 0, NULL, 2, '2022-09-14', NULL, NULL, NULL, NULL),
(15, '5050', '2022-10-05', '2022-10-07', 'Mbagala Dar ', '0754210953', '1', 'Well deserved leave', 2, 'Aende Rikizo kafanya kazi sana', 3, '2022-10-04', '255001', '2022-10-04', '9090', '2022-10-04');

-- --------------------------------------------------------

--
-- Table structure for table `leave_type`
--

CREATE TABLE `leave_type` (
  `id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `gender` int(11) NOT NULL DEFAULT 0 COMMENT '0-All, 1-male, 2-female',
  `max_days` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_type`
--

INSERT INTO `leave_type` (`id`, `type`, `gender`, `max_days`) VALUES
(1, 'Annual', 0, NULL),
(2, 'Exam', 0, NULL),
(3, 'Maternity', 2, '125'),
(4, 'Widowed', 2, NULL),
(5, 'Sick', 0, NULL),
(6, 'Compassionate', 0, NULL),
(7, 'Partenity', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) DEFAULT NULL,
  `description` varchar(200) NOT NULL,
  `type` int(1) NOT NULL COMMENT '1-Salary Advance, 2-Forced Payments, 3-HESLB',
  `form_four_index_no` varchar(20) NOT NULL DEFAULT '0',
  `amount` decimal(15,2) DEFAULT NULL,
  `deduction_amount` decimal(15,2) NOT NULL,
  `application_date` date DEFAULT NULL,
  `state` int(2) DEFAULT 1 COMMENT '0-approved',
  `approved_hr` varchar(50) DEFAULT NULL,
  `approved_finance` varchar(50) DEFAULT NULL,
  `approved_date_hr` date DEFAULT NULL,
  `approved_date_finance` date DEFAULT NULL,
  `paid` decimal(15,2) DEFAULT NULL,
  `amount_last_paid` decimal(15,2) DEFAULT NULL,
  `last_paid_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`id`, `empID`, `description`, `type`, `form_four_index_no`, `amount`, `deduction_amount`, `application_date`, `state`, `approved_hr`, `approved_finance`, `approved_date_hr`, `approved_date_finance`, `paid`, `amount_last_paid`, `last_paid_date`) VALUES
(1, 'V1116705', 'HESLB', 3, 'S0127.0038.2007', '11151044.14', '0.00', '2020-06-23', 1, 'TZ1114433', 'TZ1118959', '2020-06-23', '2020-06-23', NULL, NULL, '2022-10-04'),
(2, 'TZ1118433', 'HESLB', 3, 'S0332.0069.2002', '2138441.15', '0.00', '2020-06-23', 0, 'TZ1114433', 'TZ1118959', '2020-06-23', '2020-06-23', '2138441.15', '0.00', '2018-02-19'),
(3, 'TZ1117612', 'HESLB', 3, 'S2034.0071.2010', '4867951.74', '0.00', '2020-06-23', 0, 'TZ1114433', 'TZ1118959', '2020-06-23', '2020-06-23', '4867951.74', '0.00', '2018-11-27'),
(4, 'V1117694', 'HESLB', 3, 'S1049.0083.2006', '3870104.39', '0.00', '2020-06-23', 0, 'TZ1114433', 'TZ1118959', '2020-06-23', '2020-06-23', '3870104.39', '0.00', '2019-01-23'),
(5, ' TZ1116298', 'HESLB', 3, 'S0109.0005.2008', '6175719.12', '0.00', '2020-06-23', 0, 'TZ1114433', 'TZ1118959', '2020-06-23', '2020-06-23', '6175719.12', '0.00', '2018-09-25'),
(23, 'TZ346', 'Salary Advance', 1, '0', '100000.00', '45009.00', '2020-07-01', 0, 'TZ1114433', 'S21179', '2020-07-01', '2020-07-01', '100000.00', '0.00', '2010-08-18'),
(24, 'TZ1114433', 'Salary Advance', 1, '0', '72000.00', '60000.00', '2020-07-01', 0, 'TZ1114433', 'S21179', '2020-07-01', '2020-07-01', '72000.00', '0.00', '2010-07-01'),
(25, '255001', 'HESLB', 3, '1234', '60000.00', '0.00', '2022-09-14', 0, '255001', '255073', '2022-09-14', '2022-09-14', '60000.00', '0.00', '2022-08-31'),
(26, '255001', 'Yes', 2, '0', '40000.00', '20000.00', '2022-09-14', 0, '255001', '255073', '2022-09-14', '2022-09-14', '40000.00', '0.00', '2022-10-04'),
(27, '255001', 'Salary Advance', 1, '0', '220000.00', '220000.00', '2022-09-14', 0, '255001', '255073', '2022-09-14', '2022-09-14', '220000.00', '0.00', '2022-08-31');

-- --------------------------------------------------------

--
-- Table structure for table `loan_application`
--

CREATE TABLE `loan_application` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL COMMENT '1-Salary Advance, 2-Forced Payments, 3-HESLB',
  `form_four_index_no` varchar(20) NOT NULL DEFAULT '0',
  `amount` decimal(15,2) DEFAULT NULL,
  `deduction_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `reason` varchar(200) DEFAULT NULL,
  `application_date` date DEFAULT NULL,
  `status` varchar(2) DEFAULT '0' COMMENT '0-Sent, 1-Recommended, 2-Approved, 3-Held, 4-Cancelled, 5-Disapproved ',
  `approved_hr` varchar(50) DEFAULT NULL,
  `approved_finance` varchar(50) DEFAULT NULL,
  `reason_hr` varchar(50) DEFAULT NULL,
  `reason_finance` varchar(200) DEFAULT NULL,
  `approved_date_hr` date DEFAULT NULL,
  `approved_date_finance` date DEFAULT NULL,
  `notification` int(2) DEFAULT 2 COMMENT '0-seen, 1-Employee, 2-hr recommend, 3-Finance Approve, 4-seen by employee waiting finance',
  `time_approved_cd` varchar(110) NOT NULL,
  `approved_cd` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan_application`
--

INSERT INTO `loan_application` (`id`, `empID`, `type`, `form_four_index_no`, `amount`, `deduction_amount`, `reason`, `application_date`, `status`, `approved_hr`, `approved_finance`, `reason_hr`, `reason_finance`, `approved_date_hr`, `approved_date_finance`, `notification`, `time_approved_cd`, `approved_cd`) VALUES
(1, ' TZ1116298', '3', 'S0109.0005.2008', '6175719.12', '0.00', 'Loan Board Deduction ', '2020-06-23', '2', 'TZ1114433', NULL, NULL, NULL, '2020-06-23', NULL, 1, '2020-06-23', 'TZ1118959'),
(2, 'V1117694', '3', 'S1049.0083.2006', '3870104.39', '0.00', 'Loan Board Deduction', '2020-06-23', '2', 'TZ1114433', NULL, NULL, NULL, '2020-06-23', NULL, 1, '2020-06-23', 'TZ1118959'),
(3, 'TZ1117612', '3', 'S2034.0071.2010', '4867951.74', '0.00', 'Loan Board Deduction', '2020-06-23', '2', 'TZ1114433', NULL, NULL, NULL, '2020-06-23', NULL, 1, '2020-06-23', 'TZ1118959'),
(4, 'TZ1118433', '3', 'S0332.0069.2002', '2138441.15', '0.00', 'Loan Board Deduction ', '2020-06-23', '2', 'TZ1114433', NULL, NULL, NULL, '2020-06-23', NULL, 1, '2020-06-23', 'TZ1118959'),
(5, 'V1116705', '3', 'S0127.0038.2007', '11151044.14', '0.00', 'Loan Board Deduction ', '2020-06-23', '2', 'TZ1114433', NULL, NULL, NULL, '2020-06-23', NULL, 1, '2020-06-23', 'TZ1118959'),
(6, 'TZ1114433', '1', '0', '100000.00', '60.00', 'SA', '2020-06-26', '2', 'TZ1114433', 'TZ394', NULL, NULL, '2020-06-26', '2020-06-26', 1, '2020-06-26', 'S21179'),
(8, 'TZ1114433', '1', '0', '20000.00', '1000.00', 'sick', '2020-06-29', '2', 'TZ1114433', 'TZ394', NULL, NULL, '2020-06-29', '2020-06-29', 1, '2020-06-29', 'S21179'),
(9, 'TZ346', '1', '0', '100000.00', '45009.00', 'Kutumia', '2020-07-01', '2', 'TZ1114433', 'TZ394', NULL, NULL, '2020-07-01', '2020-07-01', 1, '2020-07-01', 'S21179'),
(10, 'TZ1114433', '1', '0', '72000.00', '60000.00', 'yangu', '2020-07-01', '2', 'TZ1114433', 'TZ394', NULL, NULL, '2020-07-01', '2020-07-01', 1, '2020-07-01', 'S21179'),
(11, '255001', '1', '0', '220000.00', '220000.00', 'Nimekaukiwa', '2022-09-14', '2', '255001', '255010', NULL, NULL, '2022-09-14', '2022-09-14', 1, '2022-09-14', '255073'),
(12, '255001', '2', '0', '40000.00', '20000.00', 'Yes', '2022-09-14', '2', '255001', '255010', NULL, NULL, '2022-09-14', '2022-09-14', 1, '2022-09-14', '255073'),
(13, '255001', '3', '1234', '60000.00', '0.00', 'Yes2', '2022-09-14', '2', '255001', '255010', NULL, NULL, '2022-09-14', '2022-09-14', 1, '2022-09-14', '255073');

-- --------------------------------------------------------

--
-- Table structure for table `loan_logs`
--

CREATE TABLE `loan_logs` (
  `id` int(11) NOT NULL,
  `loanID` int(11) NOT NULL,
  `policy` double NOT NULL DEFAULT 0.15,
  `paid` decimal(15,2) DEFAULT NULL,
  `remained` decimal(15,2) NOT NULL,
  `payment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan_logs`
--

INSERT INTO `loan_logs` (`id`, `loanID`, `policy`, `paid`, `remained`, `payment_date`) VALUES
(1, 1, 0.15, NULL, '0.00', '2019-01-29'),
(2, 1, 0.15, NULL, '0.00', '2019-02-19'),
(3, 1, 0.15, NULL, '0.00', '2020-04-25'),
(4, 1, 0.15, NULL, '0.00', '2022-09-14'),
(5, 26, 20000, '20000.00', '20000.00', '2022-08-31'),
(6, 27, 220000, '220000.00', '0.00', '2022-08-31'),
(8, 1, 0.15, NULL, '0.00', '2022-08-31'),
(9, 25, 0.15, '720199.35', '60000.00', '2022-08-31'),
(10, 26, 20000, '40000.00', '0.00', '2022-10-04'),
(11, 1, 0.15, NULL, '0.00', '2022-10-04');

-- --------------------------------------------------------

--
-- Table structure for table `loan_type`
--

CREATE TABLE `loan_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan_type`
--

INSERT INTO `loan_type` (`id`, `name`, `code`) VALUES
(1, 'Salary Advance', 4551),
(2, 'Personal Forced Deduction', 4910),
(3, 'HESLB', 4584);

-- --------------------------------------------------------

--
-- Table structure for table `meals_deduction`
--

CREATE TABLE `meals_deduction` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `minimum_gross` double NOT NULL,
  `maximum_payment` double NOT NULL,
  `minimum_payment` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meals_deduction`
--

INSERT INTO `meals_deduction` (`id`, `name`, `minimum_gross`, `maximum_payment`, `minimum_payment`) VALUES
(1, 'Meals', 0, 0, 0);

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
-- Table structure for table `mobile_service_provider`
--

CREATE TABLE `mobile_service_provider` (
  `id` int(11) NOT NULL,
  `service_name` varchar(50) NOT NULL,
  `number_prefix` varchar(50) NOT NULL,
  `service_provider_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mobile_service_provider`
--

INSERT INTO `mobile_service_provider` (`id`, `service_name`, `number_prefix`, `service_provider_name`) VALUES
(1, 'M-Pesa', '075', 'Vodacom Tanzania'),
(2, 'TIGO PESA', '071', 'TIGO Tanzaniz'),
(3, 'Airtel Money', '078', 'Aitel Tanzania'),
(4, 'Halo Pesa', '062', 'Halotel'),
(5, 'EZY PESA', '077', 'Zantel'),
(6, 'T-PESA', '073', 'TTCL'),
(7, 'M-Pesa', '076', 'Vodacom Tanzania'),
(8, 'TIGO PESA', '067', 'TIGO Tanzaniz'),
(9, 'TIGO PESA', '065', 'TIGO Tanzania'),
(10, 'Airtel Money', '068', 'Airtel Tanzania'),
(11, 'Airtel Money', '069', 'Airtel Tanzania');

-- --------------------------------------------------------

--
-- Table structure for table `next_of_kin`
--

CREATE TABLE `next_of_kin` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `relationship` varchar(100) DEFAULT NULL,
  `postal_address` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `employee_fk` varchar(10) NOT NULL,
  `physical_address` varchar(100) DEFAULT NULL,
  `office_no` varchar(100) DEFAULT NULL,
  `added_on` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `next_of_kin`
--

INSERT INTO `next_of_kin` (`id`, `fname`, `mname`, `lname`, `relationship`, `postal_address`, `mobile`, `employee_fk`, `physical_address`, `office_no`, `added_on`) VALUES
(1, 'Juma', 'J.', 'David', 'Son/Doughter', 'Matosa-Goba', '076789543', '2550001', 'Matosa-Goba', '752548877', '2019-08-19');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `role` varchar(110) NOT NULL,
  `type` int(10) NOT NULL COMMENT '0-overtime, 1-imprest,2-payroll,3-avd_salary, 4-incentives',
  `message` varchar(110) NOT NULL,
  `for` int(10) NOT NULL,
  `recom_by` varchar(110) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `once_off_deduction`
--

CREATE TABLE `once_off_deduction` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `description` varchar(50) NOT NULL DEFAULT 'Unclassified',
  `policy` varchar(50) NOT NULL DEFAULT 'Fixed Amount',
  `paid` decimal(15,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `organization_level`
--

CREATE TABLE `organization_level` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `minSalary` decimal(15,2) NOT NULL,
  `maxSalary` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organization_level`
--

INSERT INTO `organization_level` (`id`, `name`, `minSalary`, `maxSalary`) VALUES
(1, 'Ancillary', '7200000.00', '23287386.00'),
(2, 'Officers & Assistants', '16339306.00', '36811329.00'),
(3, 'Project Managers & Coordinators', '31213952.00', '88558232.00'),
(4, 'Country Senior Managers / Global Managers', '57919786.00', '118282496.00'),
(5, 'Regional / Global Senior Managers', '89952970.00', '151527680.00'),
(6, 'Country Directors / Heads of Function (globally)', '119495544.00', '218320944.00'),
(7, 'Executive Board / Operations Directors', '197725000.00', '315000000.00'),
(8, 'temporarys', '100.00', '315000000.00');

-- --------------------------------------------------------

--
-- Table structure for table `outcome`
--

CREATE TABLE `outcome` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `assigned_by` varchar(10) NOT NULL,
  `assigned_to` varchar(10) NOT NULL,
  `isAssigned` int(1) NOT NULL DEFAULT 0,
  `strategy_ref` int(11) NOT NULL,
  `dated` datetime NOT NULL DEFAULT current_timestamp(),
  `author` varchar(10) NOT NULL,
  `indicator` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `outcome`
--

INSERT INTO `outcome` (`id`, `title`, `description`, `start`, `end`, `assigned_by`, `assigned_to`, `isAssigned`, `strategy_ref`, `dated`, `author`, `indicator`) VALUES
(1, 'Outcome1', 'Descriotion Outcome1', '2020-05-05', '2020-05-30', '2550001', '2550001', 1, 34, '2020-05-05 03:12:52', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `output`
--

CREATE TABLE `output` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `outcome_ref` int(1) NOT NULL,
  `strategy_ref` int(11) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `isAssigned` int(1) NOT NULL DEFAULT 0,
  `assigned_to` varchar(10) NOT NULL,
  `author` varchar(10) NOT NULL,
  `assigned_by` varchar(10) DEFAULT NULL,
  `remarks` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `output`
--

INSERT INTO `output` (`id`, `title`, `outcome_ref`, `strategy_ref`, `description`, `start`, `end`, `isAssigned`, `assigned_to`, `author`, `assigned_by`, `remarks`) VALUES
(1, 'Output1', 1, 34, 'Descriotion outcome1', '2020-05-05', '2020-05-30', 1, '2550002', '2550001', '2550001', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `overtimes`
--

CREATE TABLE `overtimes` (
  `id` int(11) NOT NULL,
  `overtimeID` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `time_start` datetime NOT NULL DEFAULT current_timestamp(),
  `time_end` datetime NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(15,4) NOT NULL,
  `linemanager` varchar(10) NOT NULL,
  `hr` varchar(10) NOT NULL,
  `application_time` datetime NOT NULL DEFAULT current_timestamp(),
  `confirmation_time` datetime NOT NULL DEFAULT current_timestamp(),
  `approval_time` date NOT NULL DEFAULT '2019-06-19',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '0-Waiting For Payment,1- Scheduled For Payment On Next Payroll'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `overtime_category`
--

CREATE TABLE `overtime_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `day_percent` decimal(10,4) NOT NULL,
  `night_percent` decimal(10,4) NOT NULL,
  `state` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `overtime_category`
--

INSERT INTO `overtime_category` (`id`, `name`, `day_percent`, `night_percent`, `state`) VALUES
(1, 'Normal Overtime', '0.5000', '0.5750', 1),
(2, 'Holiday Overtime', '1.0000', '1.1000', 1),
(3, 'Night Shift', '0.0200', '0.0500', 1),
(4, 'Overtime', '1.5000', '1.5750', 1),
(5, 'Overtime', '1.5000', '1.5750', 1),
(6, 'Overtime', '1.5000', '1.5750', 1),
(7, 'Overtime', '1.5000', '1.5750', 1),
(8, 'Public Holiday', '2.0000', '2.1000', 1),
(9, 'sunday Overtime', '0.2000', '0.2500', 1);

-- --------------------------------------------------------

--
-- Table structure for table `overtime_logs`
--

CREATE TABLE `overtime_logs` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `time_start` datetime NOT NULL DEFAULT current_timestamp(),
  `time_end` datetime NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(15,2) NOT NULL,
  `linemanager` varchar(10) NOT NULL,
  `hr` varchar(10) NOT NULL,
  `application_time` datetime NOT NULL DEFAULT current_timestamp(),
  `confirmation_time` datetime NOT NULL DEFAULT current_timestamp(),
  `approval_time` date NOT NULL DEFAULT '2019-06-19',
  `payment_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `overtime_logs`
--

INSERT INTO `overtime_logs` (`id`, `empID`, `time_start`, `time_end`, `amount`, `linemanager`, `hr`, `application_time`, `confirmation_time`, `approval_time`, `payment_date`) VALUES
(1, '5050', '2022-10-04 17:00:00', '2022-10-04 18:00:00', '6250.00', '9090', '255073', '2022-10-04 10:27:23', '2022-10-04 01:27:23', '2022-10-04', '2022-10-04');

-- --------------------------------------------------------

--
-- Table structure for table `partial_payment`
--

CREATE TABLE `partial_payment` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `days` varchar(45) DEFAULT NULL,
  `payroll_date` date DEFAULT NULL,
  `status` varchar(45) DEFAULT '0',
  `date` varchar(45) DEFAULT NULL,
  `init` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partial_payment`
--

INSERT INTO `partial_payment` (`id`, `empID`, `start_date`, `end_date`, `days`, `payroll_date`, `status`, `date`, `init`) VALUES
(12, 'TZ346', '2010-07-01', '2010-07-15', '15', '2010-07-01', '1', '2020-07-01', 'TZ1114433');

-- --------------------------------------------------------

--
-- Table structure for table `paused_task`
--

CREATE TABLE `paused_task` (
  `id` int(11) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `title` varchar(200) NOT NULL DEFAULT 'N/A',
  `initial_quantity` int(2) NOT NULL DEFAULT 1,
  `submitted_quantity` int(11) NOT NULL DEFAULT 0,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `assigned_to` varchar(50) DEFAULT NULL,
  `assigned_by` varchar(11) DEFAULT NULL,
  `date_assigned` date DEFAULT NULL,
  `progress` int(3) NOT NULL DEFAULT 0,
  `outcome_ref` int(11) NOT NULL,
  `strategy_ref` int(11) DEFAULT NULL,
  `output_ref` int(11) NOT NULL,
  `status` int(2) DEFAULT 0 COMMENT '0-assigned, 1- Submitted, 2-approved, 3-Cancelled, 4-overdue, 5-disapproved, 6-committed',
  `quantity` double DEFAULT 1,
  `quantity_type` int(11) NOT NULL DEFAULT 2 COMMENT '1-finencial quantity, 2-numerical quantity',
  `quality` double DEFAULT 1 COMMENT 'behaviour',
  `excess_points` double NOT NULL DEFAULT 0,
  `qb_ratio` varchar(15) DEFAULT '70:30' COMMENT 'quantity_behaviour Ratio',
  `monetaryValue` int(11) DEFAULT 0,
  `remarks` varchar(500) DEFAULT NULL,
  `isAssigned` int(11) NOT NULL DEFAULT 0,
  `notification` int(11) NOT NULL DEFAULT 1,
  `date_completed` date DEFAULT NULL,
  `date_marked` date DEFAULT NULL,
  `date_paused` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `paye`
--

CREATE TABLE `paye` (
  `id` int(11) NOT NULL,
  `minimum` decimal(15,2) DEFAULT NULL,
  `maximum` decimal(15,2) DEFAULT NULL,
  `rate` double(4,4) DEFAULT NULL,
  `excess_added` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paye`
--

INSERT INTO `paye` (`id`, `minimum`, `maximum`, `rate`, `excess_added`) VALUES
(2, '170000.00', '360000.00', 0.0900, '0.00'),
(3, '360000.00', '540000.00', 0.2000, '17100.00'),
(4, '540000.00', '720000.00', 0.2500, '53100.00'),
(5, '720000.00', '100000000.00', 0.3000, '98100.00');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_logs`
--

CREATE TABLE `payroll_logs` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `salary` decimal(15,2) DEFAULT NULL,
  `allowances` decimal(15,2) NOT NULL DEFAULT 0.00,
  `pension_employee` decimal(15,2) DEFAULT NULL,
  `pension_employer` decimal(15,2) DEFAULT NULL,
  `medical_employee` decimal(15,2) NOT NULL DEFAULT 0.00,
  `medical_employer` decimal(15,2) NOT NULL DEFAULT 0.00,
  `taxdue` decimal(15,2) DEFAULT NULL,
  `meals` decimal(15,2) NOT NULL DEFAULT 0.00,
  `department` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `branch` int(11) NOT NULL,
  `pension_fund` varchar(100) NOT NULL,
  `membership_no` varchar(20) NOT NULL DEFAULT 'PSSF/2019/000910',
  `sdl` decimal(15,2) NOT NULL,
  `wcf` decimal(15,2) NOT NULL,
  `less_takehome` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT '0-Complete Take Home',
  `due_date` datetime NOT NULL DEFAULT current_timestamp(),
  `payroll_date` date DEFAULT NULL,
  `bank` int(11) NOT NULL DEFAULT 1,
  `bank_branch` int(11) NOT NULL DEFAULT 1,
  `account_no` varchar(20) NOT NULL DEFAULT '0128J092341550'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `payroll_logs`
--

INSERT INTO `payroll_logs` (`id`, `empID`, `salary`, `allowances`, `pension_employee`, `pension_employer`, `medical_employee`, `medical_employer`, `taxdue`, `meals`, `department`, `position`, `branch`, `pension_fund`, `membership_no`, `sdl`, `wcf`, `less_takehome`, `due_date`, `payroll_date`, `bank`, `bank_branch`, `account_no`) VALUES
(1, '255001', '4801328.97', '0.00', '480132.90', '480132.90', '0.00', '0.00', '1178458.82', '0.00', 2, 93, 1, '2', '54913241', '216059.80', '48013.29', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 8, '0041001836'),
(2, '255002', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 98, 1, '2', '54913047', '137650.70', '30589.05', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 8, '0041048166'),
(3, '255004', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 97, 1, '2', '54913055', '137650.70', '30589.05', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 30, '0121018241'),
(4, '255005', '1137796.44', '0.00', '113779.64', '113779.64', '0.00', '0.00', '189305.04', '0.00', 4, 102, 1, '2', '54913217', '51200.84', '11377.96', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 8, '0041031360'),
(5, '255006', '952422.51', '0.00', '95242.25', '95242.25', '0.00', '0.00', '139254.08', '0.00', 2, 100, 1, '2', '54913012', '42859.01', '9524.23', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 9, '0141016008'),
(6, '255007', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', '54913004', '42859.01', '9524.22', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 8, '0041038284'),
(7, '255008', '8288034.48', '0.00', '828803.45', '828803.45', '0.00', '0.00', '2119869.31', '0.00', 4, 81, 1, '2', '54913209', '372961.55', '82880.34', '0.00', '2020-07-08 04:35:52', '2019-01-29', 11, 6, '1317213316'),
(8, '255009', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 1, '2', '54913128', '198512.56', '44113.90', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 8, '0041043156'),
(9, '255010', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 2, 80, 1, '2', '54913071', '192889.06', '42864.24', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 8, '0041026367'),
(10, '255011', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 1, '2', '54913225', '198512.56', '44113.90', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 9, '0141091611'),
(11, '255012', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 5, '2', '45011553', '198512.56', '44113.90', '0.00', '2020-07-08 04:35:52', '2019-01-29', 3, 18, '70210029252'),
(12, '255013', '3130198.01', '0.00', '313019.80', '313019.80', '0.00', '0.00', '727253.46', '0.00', 4, 89, 1, '2', '54913063', '140858.91', '31301.98', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 9, '0041023538'),
(13, '255014', '6248835.86', '0.00', '624883.59', '624883.59', '0.00', '0.00', '1569285.68', '0.00', 4, 82, 1, '2', '54913160', '281197.61', '62488.36', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0152264454800'),
(14, '255015', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 2, '2', '54913098', '136563.82', '30347.52', '0.00', '2020-07-08 04:35:52', '2019-01-29', 3, 17, '52010002523'),
(15, '255016', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 85, 1, '2', '54913039', '137650.70', '30589.05', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 12, '0152218559900'),
(16, '255017', '6242400.01', '0.00', '624240.00', '624240.00', '0.00', '0.00', '1567548.00', '0.00', 1, 83, 1, '2', '62540521', '280908.00', '62424.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 13, '0112088479300'),
(17, '255018', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 95, 6, '2', '64528642', '80495.84', '17887.96', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0152216162400'),
(18, '255019', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 1, 90, 1, '2', '54913187', '192889.06', '42864.24', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 8, '0041017546'),
(19, '255020', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 91, 1, '2', '54913500', '136563.82', '30347.52', '0.00', '2020-07-08 04:35:52', '2019-01-29', 10, 38, '3001111356328'),
(20, '255021', '1137796.45', '0.00', '113779.65', '113779.65', '0.00', '0.00', '189305.04', '0.00', 2, 99, 1, '2', '50501879', '51200.84', '11377.96', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 9, '0141174703'),
(21, '255022', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 88, 1, '2', '64500675', '198512.56', '44113.90', '0.00', '2020-07-08 04:35:52', '2019-01-29', 4, 19, '0100303584200'),
(22, '255023', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', '61993573', '42859.01', '9524.22', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 8, '0041574224'),
(23, '255024', '539706.03', '0.00', '53970.60', '53970.60', '0.00', '0.00', '42247.09', '0.00', 2, 100, 1, '2', '61993581', '24286.77', '5397.06', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 8, '0141344137'),
(24, '255025', '5001834.65', '0.00', '500183.47', '500183.47', '0.00', '0.00', '1232595.36', '0.00', 2, 75, 1, '2', ' 50415549', '225082.56', '50018.35', '0.00', '2020-07-08 04:35:52', '2019-01-29', 8, 20, '9120001042066'),
(25, '255026', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 4, '2', '54913381', '136563.82', '30347.52', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0152258731600'),
(26, '255027', '2073728.75', '0.00', '207372.88', '207372.88', '0.00', '0.00', '442006.76', '0.00', 1, 96, 1, '2', '54913527', '93317.79', '20737.29', '0.00', '2020-07-08 04:35:52', '2019-01-29', 3, 17, '22510043246'),
(27, '255028', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 87, 1, '2', '55487351', '198512.56', '44113.90', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 27, '0531022602'),
(28, '255029', '9727740.00', '0.00', '972774.00', '972774.00', '0.00', '0.00', '2508589.80', '0.00', 1, 78, 1, '2', '37085239', '437748.30', '97277.40', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '01J2456602600'),
(29, '255030', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '54915465', '136563.82', '30347.52', '0.00', '2020-07-08 04:35:52', '2019-01-29', 3, 17, '22910018423'),
(30, '255031', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '54915430', '136563.82', '30347.52', '0.00', '2020-07-08 04:35:52', '2019-01-29', 3, 17, '31810018271'),
(31, '255032', '3013177.00', '0.00', '301317.70', '301317.70', '0.00', '0.00', '695657.79', '0.00', 4, 88, 1, '2', '54915414', '135592.97', '30131.77', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0112077702900'),
(32, '255033', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', ' 63823780', '42859.01', '9524.22', '0.00', '2020-07-08 04:35:52', '2019-01-29', 3, 17, '22610017364'),
(33, '255034', '9987840.00', '0.00', '998784.00', '998784.00', '0.00', '0.00', '2578816.80', '0.00', 2, 80, 1, '2', '33937036', '449452.80', '99878.40', '0.00', '2020-07-08 04:35:52', '2019-01-29', 6, 7, '0011012310'),
(34, '255035', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 1, 90, 1, '2', '63827603', '192889.06', '42864.24', '0.00', '2020-07-08 04:35:52', '2019-01-29', 2, 37, '047163013910'),
(35, '255036', '3130198.01', '0.00', '313019.80', '313019.80', '0.00', '0.00', '727253.46', '0.00', 4, 88, 2, '2', '2398369', '140858.91', '31301.98', '0.00', '2020-07-08 04:35:52', '2019-01-29', 3, 17, '30510013213'),
(36, '255037', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 5, '2', '63925125', '136563.82', '30347.52', '0.00', '2020-07-08 04:35:52', '2019-01-29', 3, 17, '22310031304'),
(37, '255038', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '64271706', '136563.82', '30347.52', '0.00', '2020-07-08 04:35:52', '2019-01-29', 3, 17, '24710002402'),
(38, '255039', '8238655.60', '0.00', '823865.56', '823865.56', '0.00', '0.00', '2106537.01', '0.00', 4, 79, 1, '2', '54913543', '370739.50', '82386.56', '0.00', '2020-07-08 04:35:52', '2019-01-29', 7, 39, '00654831'),
(39, '255040', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 2, '2', '58069704', '136563.82', '30347.52', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0152268709100'),
(40, '255041', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 88, 5, '2', '53811216', '198512.56', '44113.90', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '01J2028537400'),
(41, '255042', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 94, 1, '2', '45033376', '80495.84', '17887.96', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0152317686200'),
(42, '255043', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 95, 4, '2', '59245433', '80495.84', '17887.96', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0152213480500'),
(43, '255044', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 97, 1, '2', '65485076', '137650.70', '30589.05', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0152294853000'),
(44, '255045', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 2, '2', '40085031', '198512.56', '44113.90', '0.00', '2020-07-08 04:35:52', '2019-01-29', 4, 19, '0100301355000'),
(45, '255047', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 3, '2', '60555688', '136563.82', '30347.52', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0152352041600'),
(46, '255049', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 105, 2, '2', '45041342', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 5, 14, '0765146120'),
(47, '255050', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 2, '2', '63226758', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 3, 17, '51110014190'),
(48, '255051', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 113, 5, '2', '60656298', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 5, 14, '0753013674'),
(49, '255052', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 126, 2, '2', '64672263', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 5, 21, '0675559454'),
(50, '255053', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 119, 9, '2', '62565761', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0112583358400'),
(51, '255054', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 121, 1, '2', '45043126', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0152218089400'),
(52, '255055', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 124, 8, '2', '65579771', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 3, 18, '32610002345'),
(53, '255056', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 124, 5, '2', '45003239', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 5, 14, '0752711205'),
(54, '255058', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 105, 5, '2', '65668480', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 5, 14, '0769306663'),
(55, '255059', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 8, '2', '63060434', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0152083918300'),
(56, '255060', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 7, '2', '62491342', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 3, 4, '20610000315'),
(57, '255061', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 7, '2', '64424103', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 5, 14, '0765413872'),
(58, '255062', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 2, '2', '65612124', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 5, 14, '24710002402'),
(59, '255063', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 114, 9, '2', '66415403', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0152290741600'),
(60, '255064', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 2, 80, 1, '2', '61851930', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0152222014500'),
(61, '255065', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 125, 2, '2', '58617817', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0152279732300'),
(62, '255066', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 110, 2, '2', '66619556 ', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 1, 34, '0152353551300'),
(63, '255067', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 109, 2, '2', '63626195', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 3, 17, '23710010594'),
(64, '255069', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 103, 6, '2', '63370107', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 3, 17, '70210027551'),
(65, '255070', '1311783.98', '0.00', '131178.40', '131178.40', '0.00', '0.00', '236281.67', '0.00', 4, 95, 1, '2', '64436438', '59030.28', '13117.84', '0.00', '2020-07-08 04:35:52', '2019-01-29', 3, 17, '20810001347'),
(66, '255071', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 127, 4, '2', '63637928', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 5, 14, '0764400281'),
(67, '255072', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 128, 4, '2', '39077799', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 5, 14, ''),
(68, '255003', '734341.96', '0.00', '0.00', '0.00', '0.00', '0.00', '102402.59', '0.00', 2, 101, 1, '3', '', '33045.39', '7343.42', '0.00', '2020-07-08 04:35:52', '2019-01-29', 11, 6, '1092873310'),
(69, '255068', '630000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '75600.00', '0.00', 4, 120, 6, '3', 'Retired', '28350.00', '6300.00', '0.00', '2020-07-08 04:35:52', '2019-01-29', 2, 2, '027163008371'),
(128, '255001', '4801328.97', '0.00', '480132.90', '480132.90', '0.00', '0.00', '1178458.82', '0.00', 2, 93, 1, '2', '54913241', '216059.80', '48013.29', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 8, '0041001836'),
(129, '255002', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 98, 1, '2', '54913047', '137650.70', '30589.05', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 8, '0041048166'),
(130, '255004', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 97, 1, '2', '54913055', '137650.70', '30589.05', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 30, '0121018241'),
(131, '255005', '1137796.44', '0.00', '113779.64', '113779.64', '0.00', '0.00', '189305.04', '0.00', 4, 102, 1, '2', '54913217', '51200.84', '11377.96', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 8, '0041031360'),
(132, '255006', '952422.51', '0.00', '95242.25', '95242.25', '0.00', '0.00', '139254.08', '0.00', 2, 100, 1, '2', '54913012', '42859.01', '9524.23', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 9, '0141016008'),
(133, '255007', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', '54913004', '42859.01', '9524.22', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 8, '0041038284'),
(134, '255008', '8288034.48', '0.00', '828803.45', '828803.45', '0.00', '0.00', '2119869.31', '0.00', 4, 81, 1, '2', '54913209', '372961.55', '82880.34', '0.00', '2020-07-09 09:06:27', '2019-02-19', 11, 6, '1317213316'),
(135, '255009', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 1, '2', '54913128', '198512.56', '44113.90', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 8, '0041043156'),
(136, '255010', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 2, 80, 1, '2', '54913071', '192889.06', '42864.24', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 8, '0041026367'),
(137, '255011', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 1, '2', '54913225', '198512.56', '44113.90', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 9, '0141091611'),
(138, '255012', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 5, '2', '45011553', '198512.56', '44113.90', '0.00', '2020-07-09 09:06:27', '2019-02-19', 3, 18, '70210029252'),
(139, '255013', '3130198.01', '0.00', '313019.80', '313019.80', '0.00', '0.00', '727253.46', '0.00', 4, 89, 1, '2', '54913063', '140858.91', '31301.98', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 9, '0041023538'),
(140, '255014', '6248835.86', '0.00', '624883.59', '624883.59', '0.00', '0.00', '1569285.68', '0.00', 4, 82, 1, '2', '54913160', '281197.61', '62488.36', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0152264454800'),
(141, '255015', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 2, '2', '54913098', '136563.82', '30347.52', '0.00', '2020-07-09 09:06:27', '2019-02-19', 3, 17, '52010002523'),
(142, '255016', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 85, 1, '2', '54913039', '137650.70', '30589.05', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 12, '0152218559900'),
(143, '255017', '6242400.01', '0.00', '624240.00', '624240.00', '0.00', '0.00', '1567548.00', '0.00', 1, 83, 1, '2', '62540521', '280908.00', '62424.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 13, '0112088479300'),
(144, '255018', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 95, 6, '2', '64528642', '80495.84', '17887.96', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0152216162400'),
(145, '255019', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 1, 90, 1, '2', '54913187', '192889.06', '42864.24', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 8, '0041017546'),
(146, '255020', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 91, 1, '2', '54913500', '136563.82', '30347.52', '0.00', '2020-07-09 09:06:27', '2019-02-19', 10, 38, '3001111356328'),
(147, '255021', '1137796.45', '0.00', '113779.65', '113779.65', '0.00', '0.00', '189305.04', '0.00', 2, 99, 1, '2', '50501879', '51200.84', '11377.96', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 9, '0141174703'),
(148, '255022', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 88, 1, '2', '64500675', '198512.56', '44113.90', '0.00', '2020-07-09 09:06:27', '2019-02-19', 4, 19, '0100303584200'),
(149, '255023', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', '61993573', '42859.01', '9524.22', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 8, '0041574224'),
(150, '255024', '539706.03', '0.00', '53970.60', '53970.60', '0.00', '0.00', '42247.09', '0.00', 2, 100, 1, '2', '61993581', '24286.77', '5397.06', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 8, '0141344137'),
(151, '255025', '5001834.65', '0.00', '500183.47', '500183.47', '0.00', '0.00', '1232595.36', '0.00', 2, 75, 1, '2', ' 50415549', '225082.56', '50018.35', '0.00', '2020-07-09 09:06:27', '2019-02-19', 8, 20, '9120001042066'),
(152, '255026', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 4, '2', '54913381', '136563.82', '30347.52', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0152258731600'),
(153, '255027', '2073728.75', '0.00', '207372.88', '207372.88', '0.00', '0.00', '442006.76', '0.00', 1, 96, 1, '2', '54913527', '93317.79', '20737.29', '0.00', '2020-07-09 09:06:27', '2019-02-19', 3, 17, '22510043246'),
(154, '255028', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 87, 1, '2', '55487351', '198512.56', '44113.90', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 27, '0531022602'),
(155, '255029', '9727740.00', '0.00', '972774.00', '972774.00', '0.00', '0.00', '2508589.80', '0.00', 1, 78, 1, '2', '37085239', '437748.30', '97277.40', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '01J2456602600'),
(156, '255030', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '54915465', '136563.82', '30347.52', '0.00', '2020-07-09 09:06:27', '2019-02-19', 3, 17, '22910018423'),
(157, '255031', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '54915430', '136563.82', '30347.52', '0.00', '2020-07-09 09:06:27', '2019-02-19', 3, 17, '31810018271'),
(158, '255032', '3013177.00', '0.00', '301317.70', '301317.70', '0.00', '0.00', '695657.79', '0.00', 4, 88, 1, '2', '54915414', '135592.97', '30131.77', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0112077702900'),
(159, '255033', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', ' 63823780', '42859.01', '9524.22', '0.00', '2020-07-09 09:06:27', '2019-02-19', 3, 17, '22610017364'),
(160, '255034', '9987840.00', '0.00', '998784.00', '998784.00', '0.00', '0.00', '2578816.80', '0.00', 2, 80, 1, '2', '33937036', '449452.80', '99878.40', '0.00', '2020-07-09 09:06:27', '2019-02-19', 6, 7, '0011012310'),
(161, '255035', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 1, 90, 1, '2', '63827603', '192889.06', '42864.24', '0.00', '2020-07-09 09:06:27', '2019-02-19', 2, 37, '047163013910'),
(162, '255036', '3130198.01', '0.00', '313019.80', '313019.80', '0.00', '0.00', '727253.46', '0.00', 4, 88, 2, '2', '2398369', '140858.91', '31301.98', '0.00', '2020-07-09 09:06:27', '2019-02-19', 3, 17, '30510013213'),
(163, '255037', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 5, '2', '63925125', '136563.82', '30347.52', '0.00', '2020-07-09 09:06:27', '2019-02-19', 3, 17, '22310031304'),
(164, '255038', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '64271706', '136563.82', '30347.52', '0.00', '2020-07-09 09:06:27', '2019-02-19', 3, 17, '24710002402'),
(165, '255039', '8238655.60', '0.00', '823865.56', '823865.56', '0.00', '0.00', '2106537.01', '0.00', 4, 79, 1, '2', '54913543', '370739.50', '82386.56', '0.00', '2020-07-09 09:06:27', '2019-02-19', 7, 39, '00654831'),
(166, '255040', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 2, '2', '58069704', '136563.82', '30347.52', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0152268709100'),
(167, '255041', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 88, 5, '2', '53811216', '198512.56', '44113.90', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '01J2028537400'),
(168, '255042', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 94, 1, '2', '45033376', '80495.84', '17887.96', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0152317686200'),
(169, '255043', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 95, 4, '2', '59245433', '80495.84', '17887.96', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0152213480500'),
(170, '255044', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 97, 1, '2', '65485076', '137650.70', '30589.05', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0152294853000'),
(171, '255045', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 2, '2', '40085031', '198512.56', '44113.90', '0.00', '2020-07-09 09:06:27', '2019-02-19', 4, 19, '0100301355000'),
(172, '255047', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 3, '2', '60555688', '136563.82', '30347.52', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0152352041600'),
(173, '255049', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 105, 2, '2', '45041342', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 5, 14, '0765146120'),
(174, '255050', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 2, '2', '63226758', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 3, 17, '51110014190'),
(175, '255051', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 113, 5, '2', '60656298', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 5, 14, '0753013674'),
(176, '255052', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 126, 2, '2', '64672263', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 5, 21, '0675559454'),
(177, '255053', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 119, 9, '2', '62565761', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0112583358400'),
(178, '255054', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 121, 1, '2', '45043126', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0152218089400'),
(179, '255055', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 124, 8, '2', '65579771', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 3, 18, '32610002345'),
(180, '255056', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 124, 5, '2', '45003239', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 5, 14, '0752711205'),
(181, '255058', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 105, 5, '2', '65668480', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 5, 14, '0769306663'),
(182, '255059', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 8, '2', '63060434', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0152083918300'),
(183, '255060', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 7, '2', '62491342', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 3, 4, '20610000315'),
(184, '255061', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 7, '2', '64424103', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 5, 14, '0765413872'),
(185, '255062', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 2, '2', '65612124', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 5, 14, '24710002402'),
(186, '255063', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 114, 9, '2', '66415403', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0152290741600'),
(187, '255064', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 2, 80, 1, '2', '61851930', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0152222014500'),
(188, '255065', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 125, 2, '2', '58617817', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0152279732300'),
(189, '255066', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 110, 2, '2', '66619556 ', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 1, 34, '0152353551300'),
(190, '255067', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 109, 2, '2', '63626195', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 3, 17, '23710010594'),
(191, '255069', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 103, 6, '2', '63370107', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 3, 17, '70210027551'),
(192, '255070', '1311783.98', '0.00', '131178.40', '131178.40', '0.00', '0.00', '236281.67', '0.00', 4, 95, 1, '2', '64436438', '59030.28', '13117.84', '0.00', '2020-07-09 09:06:27', '2019-02-19', 3, 17, '20810001347'),
(193, '255071', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 127, 4, '2', '63637928', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 5, 14, '0764400281'),
(194, '255072', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 128, 4, '2', '39077799', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 5, 14, ''),
(195, '255003', '734341.96', '0.00', '0.00', '0.00', '0.00', '0.00', '102402.59', '0.00', 2, 101, 1, '3', '', '33045.39', '7343.42', '0.00', '2020-07-09 09:06:27', '2019-02-19', 11, 6, '1092873310'),
(196, '255068', '630000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '75600.00', '0.00', 4, 120, 6, '3', 'Retired', '28350.00', '6300.00', '0.00', '2020-07-09 09:06:27', '2019-02-19', 2, 2, '027163008371'),
(197, '255001', '4801328.97', '0.00', '480132.90', '480132.90', '0.00', '0.00', '1178458.82', '0.00', 2, 93, 1, '2', '54913241', '216059.80', '48013.29', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 8, '0041001836'),
(198, '255002', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 98, 1, '2', '54913047', '137650.70', '30589.05', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 8, '0041048166'),
(199, '255004', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 97, 1, '2', '54913055', '137650.70', '30589.05', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 30, '0121018241'),
(200, '255005', '1137796.44', '0.00', '113779.64', '113779.64', '0.00', '0.00', '189305.04', '0.00', 4, 102, 1, '2', '54913217', '51200.84', '11377.96', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 8, '0041031360'),
(201, '255006', '952422.51', '0.00', '95242.25', '95242.25', '0.00', '0.00', '139254.08', '0.00', 2, 100, 1, '2', '54913012', '42859.01', '9524.23', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 9, '0141016008'),
(202, '255007', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', '54913004', '42859.01', '9524.22', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 8, '0041038284'),
(203, '255008', '8288034.48', '0.00', '828803.45', '828803.45', '0.00', '0.00', '2119869.31', '0.00', 4, 81, 1, '2', '54913209', '372961.55', '82880.34', '0.00', '2020-09-02 03:08:13', '2020-04-25', 11, 6, '1317213316'),
(204, '255009', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 1, '2', '54913128', '198512.56', '44113.90', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 8, '0041043156'),
(205, '255010', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 2, 80, 1, '2', '54913071', '192889.06', '42864.24', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 8, '0041026367'),
(206, '255011', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 1, '2', '54913225', '198512.56', '44113.90', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 9, '0141091611'),
(207, '255012', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 5, '2', '45011553', '198512.56', '44113.90', '0.00', '2020-09-02 03:08:13', '2020-04-25', 3, 18, '70210029252'),
(208, '255013', '3130198.01', '0.00', '313019.80', '313019.80', '0.00', '0.00', '727253.46', '0.00', 4, 89, 1, '2', '54913063', '140858.91', '31301.98', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 9, '0041023538'),
(209, '255014', '6248835.86', '0.00', '624883.59', '624883.59', '0.00', '0.00', '1569285.68', '0.00', 4, 82, 1, '2', '54913160', '281197.61', '62488.36', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0152264454800'),
(210, '255015', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 2, '2', '54913098', '136563.82', '30347.52', '0.00', '2020-09-02 03:08:13', '2020-04-25', 3, 17, '52010002523'),
(211, '255016', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 85, 1, '2', '54913039', '137650.70', '30589.05', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 12, '0152218559900'),
(212, '255017', '6242400.01', '0.00', '624240.00', '624240.00', '0.00', '0.00', '1567548.00', '0.00', 1, 83, 1, '2', '62540521', '280908.00', '62424.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 13, '0112088479300'),
(213, '255018', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 95, 6, '2', '64528642', '80495.84', '17887.96', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0152216162400'),
(214, '255019', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 1, 90, 1, '2', '54913187', '192889.06', '42864.24', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 8, '0041017546'),
(215, '255020', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 91, 1, '2', '54913500', '136563.82', '30347.52', '0.00', '2020-09-02 03:08:13', '2020-04-25', 10, 38, '3001111356328'),
(216, '255021', '1137796.45', '0.00', '113779.65', '113779.65', '0.00', '0.00', '189305.04', '0.00', 2, 99, 1, '2', '50501879', '51200.84', '11377.96', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 9, '0141174703'),
(217, '255022', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 88, 1, '2', '64500675', '198512.56', '44113.90', '0.00', '2020-09-02 03:08:13', '2020-04-25', 4, 19, '0100303584200'),
(218, '255023', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', '61993573', '42859.01', '9524.22', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 8, '0041574224'),
(219, '255024', '539706.03', '0.00', '53970.60', '53970.60', '0.00', '0.00', '42247.09', '0.00', 2, 100, 1, '2', '61993581', '24286.77', '5397.06', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 8, '0141344137'),
(220, '255025', '5001834.65', '0.00', '500183.47', '500183.47', '0.00', '0.00', '1232595.36', '0.00', 2, 75, 1, '2', ' 50415549', '225082.56', '50018.35', '0.00', '2020-09-02 03:08:13', '2020-04-25', 8, 20, '9120001042066'),
(221, '255026', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 4, '2', '54913381', '136563.82', '30347.52', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0152258731600'),
(222, '255028', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 87, 1, '2', '55487351', '198512.56', '44113.90', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 27, '0531022602'),
(223, '255029', '9727740.00', '0.00', '972774.00', '972774.00', '0.00', '0.00', '2508589.80', '0.00', 1, 78, 1, '2', '37085239', '437748.30', '97277.40', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '01J2456602600'),
(224, '255030', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '54915465', '136563.82', '30347.52', '0.00', '2020-09-02 03:08:13', '2020-04-25', 3, 17, '22910018423'),
(225, '255031', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '54915430', '136563.82', '30347.52', '0.00', '2020-09-02 03:08:13', '2020-04-25', 3, 17, '31810018271'),
(226, '255032', '3013177.00', '0.00', '301317.70', '301317.70', '0.00', '0.00', '695657.79', '0.00', 4, 88, 1, '2', '54915414', '135592.97', '30131.77', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0112077702900'),
(227, '255033', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', ' 63823780', '42859.01', '9524.22', '0.00', '2020-09-02 03:08:13', '2020-04-25', 3, 17, '22610017364'),
(228, '255034', '9987840.00', '0.00', '998784.00', '998784.00', '0.00', '0.00', '2578816.80', '0.00', 2, 80, 1, '2', '33937036', '449452.80', '99878.40', '0.00', '2020-09-02 03:08:13', '2020-04-25', 6, 7, '0011012310'),
(229, '255035', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 1, 90, 1, '2', '63827603', '192889.06', '42864.24', '0.00', '2020-09-02 03:08:13', '2020-04-25', 2, 37, '047163013910'),
(230, '255036', '3130198.01', '0.00', '313019.80', '313019.80', '0.00', '0.00', '727253.46', '0.00', 4, 88, 2, '2', '2398369', '140858.91', '31301.98', '0.00', '2020-09-02 03:08:13', '2020-04-25', 3, 17, '30510013213'),
(231, '255037', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 5, '2', '63925125', '136563.82', '30347.52', '0.00', '2020-09-02 03:08:13', '2020-04-25', 3, 17, '22310031304'),
(232, '255038', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '64271706', '136563.82', '30347.52', '0.00', '2020-09-02 03:08:13', '2020-04-25', 3, 17, '24710002402'),
(233, '255039', '8238655.60', '0.00', '823865.56', '823865.56', '0.00', '0.00', '2106537.01', '0.00', 4, 79, 1, '2', '54913543', '370739.50', '82386.56', '0.00', '2020-09-02 03:08:13', '2020-04-25', 7, 39, '00654831'),
(234, '255040', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 2, '2', '58069704', '136563.82', '30347.52', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0152268709100'),
(235, '255041', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 88, 5, '2', '53811216', '198512.56', '44113.90', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '01J2028537400'),
(236, '255042', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 94, 1, '2', '45033376', '80495.84', '17887.96', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0152317686200'),
(237, '255043', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 95, 4, '2', '59245433', '80495.84', '17887.96', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0152213480500'),
(238, '255044', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 97, 1, '2', '65485076', '137650.70', '30589.05', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0152294853000'),
(239, '255045', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 2, '2', '40085031', '198512.56', '44113.90', '0.00', '2020-09-02 03:08:13', '2020-04-25', 4, 19, '0100301355000'),
(240, '255047', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 3, '2', '60555688', '136563.82', '30347.52', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0152352041600'),
(241, '255049', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 105, 2, '2', '45041342', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 5, 14, '0765146120'),
(242, '255050', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 2, '2', '63226758', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 3, 17, '51110014190'),
(243, '255051', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 113, 5, '2', '60656298', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 5, 14, '0753013674'),
(244, '255052', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 126, 2, '2', '64672263', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 5, 21, '0675559454'),
(245, '255053', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 119, 9, '2', '62565761', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0112583358400'),
(246, '255054', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 121, 1, '2', '45043126', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0152218089400'),
(247, '255055', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 124, 8, '2', '65579771', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 3, 18, '32610002345'),
(248, '255056', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 124, 5, '2', '45003239', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 5, 14, '0752711205'),
(249, '255058', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 105, 5, '2', '65668480', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 5, 14, '0769306663'),
(250, '255059', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 8, '2', '63060434', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0152083918300'),
(251, '255060', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 7, '2', '62491342', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 3, 4, '20610000315'),
(252, '255061', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 7, '2', '64424103', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 5, 14, '0765413872'),
(253, '255062', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 2, '2', '65612124', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 5, 14, '24710002402'),
(254, '255063', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 114, 9, '2', '66415403', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0152290741600'),
(255, '255064', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 2, 80, 1, '2', '61851930', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0152222014500'),
(256, '255065', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 125, 2, '2', '58617817', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0152279732300'),
(257, '255066', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 110, 2, '2', '66619556 ', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 1, 34, '0152353551300'),
(258, '255067', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 109, 2, '2', '63626195', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 3, 17, '23710010594'),
(259, '255069', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 103, 6, '2', '63370107', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 3, 17, '70210027551'),
(260, '255070', '1311783.98', '0.00', '131178.40', '131178.40', '0.00', '0.00', '236281.67', '0.00', 4, 95, 1, '2', '64436438', '59030.28', '13117.84', '0.00', '2020-09-02 03:08:13', '2020-04-25', 3, 17, '20810001347'),
(261, '255071', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 127, 4, '2', '63637928', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 5, 14, '0764400281'),
(262, '255072', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 128, 4, '2', '39077799', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 5, 14, ''),
(263, '255003', '734341.96', '0.00', '0.00', '0.00', '0.00', '0.00', '102402.59', '0.00', 2, 101, 1, '3', '', '33045.39', '7343.42', '0.00', '2020-09-02 03:08:13', '2020-04-25', 11, 6, '1092873310'),
(264, '255068', '630000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '75600.00', '0.00', 4, 120, 6, '3', 'Retired', '28350.00', '6300.00', '0.00', '2020-09-02 03:08:13', '2020-04-25', 2, 2, '027163008371'),
(265, '255001', '4801328.97', '0.00', '480132.90', '480132.90', '0.00', '0.00', '1178458.82', '0.00', 2, 93, 1, '2', '54913241', '216059.80', '48013.29', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 8, '0041001836'),
(266, '255002', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 98, 1, '2', '54913047', '137650.70', '30589.05', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 8, '0041048166'),
(267, '255004', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 97, 1, '2', '54913055', '137650.70', '30589.05', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 30, '0121018241'),
(268, '255005', '1137796.44', '0.00', '113779.64', '113779.64', '0.00', '0.00', '189305.04', '0.00', 4, 102, 1, '2', '54913217', '51200.84', '11377.96', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 8, '0041031360'),
(269, '255006', '952422.51', '0.00', '95242.25', '95242.25', '0.00', '0.00', '139254.08', '0.00', 2, 100, 1, '2', '54913012', '42859.01', '9524.23', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 9, '0141016008'),
(270, '255007', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', '54913004', '42859.01', '9524.22', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 8, '0041038284'),
(271, '255008', '8288034.48', '0.00', '828803.45', '828803.45', '0.00', '0.00', '2119869.31', '0.00', 4, 81, 1, '2', '54913209', '372961.55', '82880.34', '0.00', '2022-09-14 10:02:49', '2022-09-14', 11, 6, '1317213316'),
(272, '255009', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 1, '2', '54913128', '198512.56', '44113.90', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 8, '0041043156'),
(273, '255010', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 2, 80, 1, '2', '54913071', '192889.06', '42864.24', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 8, '0041026367'),
(274, '255011', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 1, '2', '54913225', '198512.56', '44113.90', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 9, '0141091611'),
(275, '255012', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 5, '2', '45011553', '198512.56', '44113.90', '0.00', '2022-09-14 10:02:49', '2022-09-14', 3, 18, '70210029252'),
(276, '255013', '3130198.01', '0.00', '313019.80', '313019.80', '0.00', '0.00', '727253.46', '0.00', 4, 89, 1, '2', '54913063', '140858.91', '31301.98', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 9, '0041023538'),
(277, '255014', '6248835.86', '0.00', '624883.59', '624883.59', '0.00', '0.00', '1569285.68', '0.00', 4, 82, 1, '2', '54913160', '281197.61', '62488.36', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0152264454800'),
(278, '255015', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 2, '2', '54913098', '136563.82', '30347.52', '0.00', '2022-09-14 10:02:49', '2022-09-14', 3, 17, '52010002523'),
(279, '255016', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 85, 1, '2', '54913039', '137650.70', '30589.05', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 12, '0152218559900'),
(280, '255017', '6242400.01', '0.00', '624240.00', '624240.00', '0.00', '0.00', '1567548.00', '0.00', 1, 83, 1, '2', '62540521', '280908.00', '62424.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 13, '0112088479300'),
(281, '255018', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 95, 6, '2', '64528642', '80495.84', '17887.96', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0152216162400'),
(282, '255019', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 1, 90, 1, '2', '54913187', '192889.06', '42864.24', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 8, '0041017546'),
(283, '255020', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 91, 1, '2', '54913500', '136563.82', '30347.52', '0.00', '2022-09-14 10:02:49', '2022-09-14', 10, 38, '3001111356328'),
(284, '255021', '1137796.45', '0.00', '113779.65', '113779.65', '0.00', '0.00', '189305.04', '0.00', 2, 99, 1, '2', '50501879', '51200.84', '11377.96', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 9, '0141174703'),
(285, '255022', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 88, 1, '2', '64500675', '198512.56', '44113.90', '0.00', '2022-09-14 10:02:49', '2022-09-14', 4, 19, '0100303584200'),
(286, '255023', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', '61993573', '42859.01', '9524.22', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 8, '0041574224'),
(287, '255024', '539706.03', '0.00', '53970.60', '53970.60', '0.00', '0.00', '42247.09', '0.00', 2, 100, 1, '2', '61993581', '24286.77', '5397.06', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 8, '0141344137');
INSERT INTO `payroll_logs` (`id`, `empID`, `salary`, `allowances`, `pension_employee`, `pension_employer`, `medical_employee`, `medical_employer`, `taxdue`, `meals`, `department`, `position`, `branch`, `pension_fund`, `membership_no`, `sdl`, `wcf`, `less_takehome`, `due_date`, `payroll_date`, `bank`, `bank_branch`, `account_no`) VALUES
(288, '255025', '5001834.65', '0.00', '500183.47', '500183.47', '0.00', '0.00', '1232595.36', '0.00', 2, 75, 1, '2', ' 50415549', '225082.56', '50018.35', '0.00', '2022-09-14 10:02:49', '2022-09-14', 8, 20, '9120001042066'),
(289, '255026', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 4, '2', '54913381', '136563.82', '30347.52', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0152258731600'),
(290, '255028', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 87, 1, '2', '55487351', '198512.56', '44113.90', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 27, '0531022602'),
(291, '255029', '9727740.00', '0.00', '972774.00', '972774.00', '0.00', '0.00', '2508589.80', '0.00', 1, 78, 1, '2', '37085239', '437748.30', '97277.40', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '01J2456602600'),
(292, '255030', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '54915465', '136563.82', '30347.52', '0.00', '2022-09-14 10:02:49', '2022-09-14', 3, 17, '22910018423'),
(293, '255031', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '54915430', '136563.82', '30347.52', '0.00', '2022-09-14 10:02:49', '2022-09-14', 3, 17, '31810018271'),
(294, '255032', '3013177.00', '0.00', '301317.70', '301317.70', '0.00', '0.00', '695657.79', '0.00', 4, 88, 1, '2', '54915414', '135592.97', '30131.77', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0112077702900'),
(295, '255033', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', ' 63823780', '42859.01', '9524.22', '0.00', '2022-09-14 10:02:49', '2022-09-14', 3, 17, '22610017364'),
(296, '255034', '9987840.00', '0.00', '998784.00', '998784.00', '0.00', '0.00', '2578816.80', '0.00', 2, 80, 1, '2', '33937036', '449452.80', '99878.40', '0.00', '2022-09-14 10:02:49', '2022-09-14', 6, 7, '0011012310'),
(297, '255035', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 1, 90, 1, '2', '63827603', '192889.06', '42864.24', '0.00', '2022-09-14 10:02:49', '2022-09-14', 2, 37, '047163013910'),
(298, '255036', '3130198.01', '0.00', '313019.80', '313019.80', '0.00', '0.00', '727253.46', '0.00', 4, 88, 2, '2', '2398369', '140858.91', '31301.98', '0.00', '2022-09-14 10:02:49', '2022-09-14', 3, 17, '30510013213'),
(299, '255037', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 5, '2', '63925125', '136563.82', '30347.52', '0.00', '2022-09-14 10:02:49', '2022-09-14', 3, 17, '22310031304'),
(300, '255038', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '64271706', '136563.82', '30347.52', '0.00', '2022-09-14 10:02:49', '2022-09-14', 3, 17, '24710002402'),
(301, '255039', '8238655.60', '0.00', '823865.56', '823865.56', '0.00', '0.00', '2106537.01', '0.00', 4, 79, 1, '2', '54913543', '370739.50', '82386.56', '0.00', '2022-09-14 10:02:49', '2022-09-14', 7, 39, '00654831'),
(302, '255040', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 2, '2', '58069704', '136563.82', '30347.52', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0152268709100'),
(303, '255041', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 88, 5, '2', '53811216', '198512.56', '44113.90', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '01J2028537400'),
(304, '255042', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 94, 1, '2', '45033376', '80495.84', '17887.96', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0152317686200'),
(305, '255043', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 95, 4, '2', '59245433', '80495.84', '17887.96', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0152213480500'),
(306, '255044', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 97, 1, '2', '65485076', '137650.70', '30589.05', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0152294853000'),
(307, '255045', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 2, '2', '40085031', '198512.56', '44113.90', '0.00', '2022-09-14 10:02:49', '2022-09-14', 4, 19, '0100301355000'),
(308, '255047', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 3, '2', '60555688', '136563.82', '30347.52', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0152352041600'),
(309, '255049', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 105, 2, '2', '45041342', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 5, 14, '0765146120'),
(310, '255050', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 2, '2', '63226758', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 3, 17, '51110014190'),
(311, '255051', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 113, 5, '2', '60656298', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 5, 14, '0753013674'),
(312, '255052', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 126, 2, '2', '64672263', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 5, 21, '0675559454'),
(313, '255053', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 119, 9, '2', '62565761', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0112583358400'),
(314, '255054', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 121, 1, '2', '45043126', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0152218089400'),
(315, '255055', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 124, 8, '2', '65579771', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 3, 18, '32610002345'),
(316, '255056', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 124, 5, '2', '45003239', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 5, 14, '0752711205'),
(317, '255058', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 105, 5, '2', '65668480', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 5, 14, '0769306663'),
(318, '255059', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 8, '2', '63060434', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0152083918300'),
(319, '255060', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 7, '2', '62491342', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 3, 4, '20610000315'),
(320, '255061', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 7, '2', '64424103', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 5, 14, '0765413872'),
(321, '255062', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 2, '2', '65612124', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 5, 14, '24710002402'),
(322, '255063', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 114, 9, '2', '66415403', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0152290741600'),
(323, '255064', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 2, 80, 1, '2', '61851930', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0152222014500'),
(324, '255065', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 125, 2, '2', '58617817', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0152279732300'),
(325, '255066', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 110, 2, '2', '66619556 ', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 1, 34, '0152353551300'),
(326, '255067', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 109, 2, '2', '63626195', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 3, 17, '23710010594'),
(327, '255069', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 103, 6, '2', '63370107', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 3, 17, '70210027551'),
(328, '255070', '1311783.98', '0.00', '131178.40', '131178.40', '0.00', '0.00', '236281.67', '0.00', 4, 95, 1, '2', '64436438', '59030.28', '13117.84', '0.00', '2022-09-14 10:02:49', '2022-09-14', 3, 17, '20810001347'),
(329, '255071', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 127, 4, '2', '63637928', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 5, 14, '0764400281'),
(330, '255072', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 128, 4, '2', '39077799', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 5, 14, ''),
(331, '255003', '734341.96', '0.00', '0.00', '0.00', '0.00', '0.00', '102402.59', '0.00', 2, 101, 1, '3', '', '33045.39', '7343.42', '0.00', '2022-09-14 10:02:49', '2022-09-14', 11, 6, '1092873310'),
(332, '255068', '630000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '75600.00', '0.00', 4, 120, 6, '3', 'Retired', '28350.00', '6300.00', '0.00', '2022-09-14 10:02:49', '2022-09-14', 2, 2, '027163008371'),
(333, '255001', '4801328.97', '0.00', '480132.90', '480132.90', '0.00', '0.00', '1178458.82', '0.00', 2, 93, 1, '2', '54913241', '216059.80', '48013.29', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 8, '0041001836'),
(334, '255002', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 98, 1, '2', '54913047', '137650.70', '30589.05', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 8, '0041048166'),
(335, '255004', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 97, 1, '2', '54913055', '137650.70', '30589.05', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 30, '0121018241'),
(336, '255005', '1137796.44', '0.00', '113779.64', '113779.64', '0.00', '0.00', '189305.04', '0.00', 4, 102, 1, '2', '54913217', '51200.84', '11377.96', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 8, '0041031360'),
(337, '255006', '952422.51', '0.00', '95242.25', '95242.25', '0.00', '0.00', '139254.08', '0.00', 2, 100, 1, '2', '54913012', '42859.01', '9524.23', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 9, '0141016008'),
(338, '255007', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', '54913004', '42859.01', '9524.22', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 8, '0041038284'),
(339, '255008', '8288034.48', '0.00', '828803.45', '828803.45', '0.00', '0.00', '2119869.31', '0.00', 4, 81, 1, '2', '54913209', '372961.55', '82880.34', '0.00', '2022-09-14 11:09:42', '2022-08-31', 11, 6, '1317213316'),
(340, '255009', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 1, '2', '54913128', '198512.56', '44113.90', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 8, '0041043156'),
(341, '255010', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 2, 80, 1, '2', '54913071', '192889.06', '42864.24', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 8, '0041026367'),
(342, '255011', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 1, '2', '54913225', '198512.56', '44113.90', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 9, '0141091611'),
(343, '255012', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 5, '2', '45011553', '198512.56', '44113.90', '0.00', '2022-09-14 11:09:42', '2022-08-31', 3, 18, '70210029252'),
(344, '255013', '3130198.01', '0.00', '313019.80', '313019.80', '0.00', '0.00', '727253.46', '0.00', 4, 89, 1, '2', '54913063', '140858.91', '31301.98', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 9, '0041023538'),
(345, '255014', '6248835.86', '0.00', '624883.59', '624883.59', '0.00', '0.00', '1569285.68', '0.00', 4, 82, 1, '2', '54913160', '281197.61', '62488.36', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0152264454800'),
(346, '255015', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 2, '2', '54913098', '136563.82', '30347.52', '0.00', '2022-09-14 11:09:42', '2022-08-31', 3, 17, '52010002523'),
(347, '255016', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 85, 1, '2', '54913039', '137650.70', '30589.05', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 12, '0152218559900'),
(348, '255017', '6242400.01', '0.00', '624240.00', '624240.00', '0.00', '0.00', '1567548.00', '0.00', 1, 83, 1, '2', '62540521', '280908.00', '62424.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 13, '0112088479300'),
(349, '255018', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 95, 6, '2', '64528642', '80495.84', '17887.96', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0152216162400'),
(350, '255019', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 1, 90, 1, '2', '54913187', '192889.06', '42864.24', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 8, '0041017546'),
(351, '255020', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 91, 1, '2', '54913500', '136563.82', '30347.52', '0.00', '2022-09-14 11:09:42', '2022-08-31', 10, 38, '3001111356328'),
(352, '255021', '1137796.45', '0.00', '113779.65', '113779.65', '0.00', '0.00', '189305.04', '0.00', 2, 99, 1, '2', '50501879', '51200.84', '11377.96', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 9, '0141174703'),
(353, '255022', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 88, 1, '2', '64500675', '198512.56', '44113.90', '0.00', '2022-09-14 11:09:42', '2022-08-31', 4, 19, '0100303584200'),
(354, '255023', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', '61993573', '42859.01', '9524.22', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 8, '0041574224'),
(355, '255024', '539706.03', '0.00', '53970.60', '53970.60', '0.00', '0.00', '42247.09', '0.00', 2, 100, 1, '2', '61993581', '24286.77', '5397.06', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 8, '0141344137'),
(356, '255025', '5001834.65', '0.00', '500183.47', '500183.47', '0.00', '0.00', '1232595.36', '0.00', 2, 75, 1, '2', ' 50415549', '225082.56', '50018.35', '0.00', '2022-09-14 11:09:42', '2022-08-31', 8, 20, '9120001042066'),
(357, '255026', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 4, '2', '54913381', '136563.82', '30347.52', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0152258731600'),
(358, '255028', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 87, 1, '2', '55487351', '198512.56', '44113.90', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 27, '0531022602'),
(359, '255029', '9727740.00', '0.00', '972774.00', '972774.00', '0.00', '0.00', '2508589.80', '0.00', 1, 78, 1, '2', '37085239', '437748.30', '97277.40', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '01J2456602600'),
(360, '255030', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '54915465', '136563.82', '30347.52', '0.00', '2022-09-14 11:09:42', '2022-08-31', 3, 17, '22910018423'),
(361, '255031', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '54915430', '136563.82', '30347.52', '0.00', '2022-09-14 11:09:42', '2022-08-31', 3, 17, '31810018271'),
(362, '255032', '3013177.00', '0.00', '301317.70', '301317.70', '0.00', '0.00', '695657.79', '0.00', 4, 88, 1, '2', '54915414', '135592.97', '30131.77', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0112077702900'),
(363, '255033', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', ' 63823780', '42859.01', '9524.22', '0.00', '2022-09-14 11:09:42', '2022-08-31', 3, 17, '22610017364'),
(364, '255034', '9987840.00', '0.00', '998784.00', '998784.00', '0.00', '0.00', '2578816.80', '0.00', 2, 80, 1, '2', '33937036', '449452.80', '99878.40', '0.00', '2022-09-14 11:09:42', '2022-08-31', 6, 7, '0011012310'),
(365, '255035', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 1, 90, 1, '2', '63827603', '192889.06', '42864.24', '0.00', '2022-09-14 11:09:42', '2022-08-31', 2, 37, '047163013910'),
(366, '255036', '3130198.01', '0.00', '313019.80', '313019.80', '0.00', '0.00', '727253.46', '0.00', 4, 88, 2, '2', '2398369', '140858.91', '31301.98', '0.00', '2022-09-14 11:09:42', '2022-08-31', 3, 17, '30510013213'),
(367, '255037', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 5, '2', '63925125', '136563.82', '30347.52', '0.00', '2022-09-14 11:09:42', '2022-08-31', 3, 17, '22310031304'),
(368, '255038', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '64271706', '136563.82', '30347.52', '0.00', '2022-09-14 11:09:42', '2022-08-31', 3, 17, '24710002402'),
(369, '255039', '8238655.60', '0.00', '823865.56', '823865.56', '0.00', '0.00', '2106537.01', '0.00', 4, 79, 1, '2', '54913543', '370739.50', '82386.56', '0.00', '2022-09-14 11:09:42', '2022-08-31', 7, 39, '00654831'),
(370, '255040', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 2, '2', '58069704', '136563.82', '30347.52', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0152268709100'),
(371, '255041', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 88, 5, '2', '53811216', '198512.56', '44113.90', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '01J2028537400'),
(372, '255042', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 94, 1, '2', '45033376', '80495.84', '17887.96', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0152317686200'),
(373, '255043', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 95, 4, '2', '59245433', '80495.84', '17887.96', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0152213480500'),
(374, '255044', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 97, 1, '2', '65485076', '137650.70', '30589.05', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0152294853000'),
(375, '255045', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 2, '2', '40085031', '198512.56', '44113.90', '0.00', '2022-09-14 11:09:42', '2022-08-31', 4, 19, '0100301355000'),
(376, '255047', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 3, '2', '60555688', '136563.82', '30347.52', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0152352041600'),
(377, '255049', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 105, 2, '2', '45041342', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 5, 14, '0765146120'),
(378, '255050', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 2, '2', '63226758', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 3, 17, '51110014190'),
(379, '255051', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 113, 5, '2', '60656298', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 5, 14, '0753013674'),
(380, '255052', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 126, 2, '2', '64672263', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 5, 21, '0675559454'),
(381, '255053', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 119, 9, '2', '62565761', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0112583358400'),
(382, '255054', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 121, 1, '2', '45043126', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0152218089400'),
(383, '255055', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 124, 8, '2', '65579771', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 3, 18, '32610002345'),
(384, '255056', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 124, 5, '2', '45003239', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 5, 14, '0752711205'),
(385, '255058', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 105, 5, '2', '65668480', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 5, 14, '0769306663'),
(386, '255059', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 8, '2', '63060434', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0152083918300'),
(387, '255060', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 7, '2', '62491342', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 3, 4, '20610000315'),
(388, '255061', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 7, '2', '64424103', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 5, 14, '0765413872'),
(389, '255062', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 2, '2', '65612124', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 5, 14, '24710002402'),
(390, '255063', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 114, 9, '2', '66415403', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0152290741600'),
(391, '255064', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 2, 80, 1, '2', '61851930', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0152222014500'),
(392, '255065', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 125, 2, '2', '58617817', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0152279732300'),
(393, '255066', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 110, 2, '2', '66619556 ', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 1, 34, '0152353551300'),
(394, '255067', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 109, 2, '2', '63626195', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 3, 17, '23710010594'),
(395, '255069', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 103, 6, '2', '63370107', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 3, 17, '70210027551'),
(396, '255070', '1311783.98', '0.00', '131178.40', '131178.40', '0.00', '0.00', '236281.67', '0.00', 4, 95, 1, '2', '64436438', '59030.28', '13117.84', '0.00', '2022-09-14 11:09:42', '2022-08-31', 3, 17, '20810001347'),
(397, '255071', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 127, 4, '2', '63637928', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 5, 14, '0764400281'),
(398, '255072', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 128, 4, '2', '39077799', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 5, 14, ''),
(399, '255003', '734341.96', '0.00', '0.00', '0.00', '0.00', '0.00', '102402.59', '0.00', 2, 101, 1, '3', '', '33045.39', '7343.42', '0.00', '2022-09-14 11:09:42', '2022-08-31', 11, 6, '1092873310'),
(400, '255068', '630000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '75600.00', '0.00', 4, 120, 6, '3', 'Retired', '28350.00', '6300.00', '0.00', '2022-09-14 11:09:42', '2022-08-31', 2, 2, '027163008371'),
(401, '255001', '4801328.97', '0.00', '480132.90', '480132.90', '0.00', '0.00', '1178458.82', '0.00', 2, 93, 1, '2', '54913241', '216059.80', '48013.29', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 8, '0041001836'),
(402, '255002', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 98, 1, '2', '54913047', '137650.70', '30589.05', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 8, '0041048166'),
(403, '255004', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 97, 1, '2', '54913055', '137650.70', '30589.05', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 30, '0121018241'),
(404, '255005', '1137796.44', '0.00', '113779.64', '113779.64', '0.00', '0.00', '189305.04', '0.00', 4, 102, 1, '2', '54913217', '51200.84', '11377.96', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 8, '0041031360'),
(405, '255006', '952422.51', '0.00', '95242.25', '95242.25', '0.00', '0.00', '139254.08', '0.00', 2, 100, 1, '2', '54913012', '42859.01', '9524.23', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 9, '0141016008'),
(406, '255007', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', '54913004', '42859.01', '9524.22', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 8, '0041038284'),
(407, '255008', '8288034.48', '0.00', '828803.45', '828803.45', '0.00', '0.00', '2119869.31', '0.00', 4, 81, 1, '2', '54913209', '372961.55', '82880.34', '0.00', '2022-10-04 14:09:59', '2022-10-04', 11, 6, '1317213316'),
(408, '255009', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 1, '2', '54913128', '198512.56', '44113.90', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 8, '0041043156'),
(409, '255010', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 2, 80, 1, '2', '54913071', '192889.06', '42864.24', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 8, '0041026367'),
(410, '255011', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 1, '2', '54913225', '198512.56', '44113.90', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 9, '0141091611'),
(411, '255012', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 5, '2', '45011553', '198512.56', '44113.90', '0.00', '2022-10-04 14:09:59', '2022-10-04', 3, 18, '70210029252'),
(412, '255013', '3130198.01', '0.00', '313019.80', '313019.80', '0.00', '0.00', '727253.46', '0.00', 4, 89, 1, '2', '54913063', '140858.91', '31301.98', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 9, '0041023538'),
(413, '255014', '6248835.86', '0.00', '624883.59', '624883.59', '0.00', '0.00', '1569285.68', '0.00', 4, 82, 1, '2', '54913160', '281197.61', '62488.36', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0152264454800'),
(414, '255015', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 2, '2', '54913098', '136563.82', '30347.52', '0.00', '2022-10-04 14:09:59', '2022-10-04', 3, 17, '52010002523'),
(415, '255016', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 85, 1, '2', '54913039', '137650.70', '30589.05', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 12, '0152218559900'),
(416, '255017', '6242400.01', '0.00', '624240.00', '624240.00', '0.00', '0.00', '1567548.00', '0.00', 1, 83, 1, '2', '62540521', '280908.00', '62424.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 13, '0112088479300'),
(417, '255018', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 95, 6, '2', '64528642', '80495.84', '17887.96', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0152216162400'),
(418, '255019', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 1, 90, 1, '2', '54913187', '192889.06', '42864.24', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 8, '0041017546'),
(419, '255020', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 91, 1, '2', '54913500', '136563.82', '30347.52', '0.00', '2022-10-04 14:09:59', '2022-10-04', 10, 38, '3001111356328'),
(420, '255021', '1137796.45', '0.00', '113779.65', '113779.65', '0.00', '0.00', '189305.04', '0.00', 2, 99, 1, '2', '50501879', '51200.84', '11377.96', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 9, '0141174703'),
(421, '255022', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 88, 1, '2', '64500675', '198512.56', '44113.90', '0.00', '2022-10-04 14:09:59', '2022-10-04', 4, 19, '0100303584200'),
(422, '255023', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', '61993573', '42859.01', '9524.22', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 8, '0041574224'),
(423, '255024', '539706.03', '0.00', '53970.60', '53970.60', '0.00', '0.00', '42247.09', '0.00', 2, 100, 1, '2', '61993581', '24286.77', '5397.06', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 8, '0141344137'),
(424, '255025', '5001834.65', '0.00', '500183.47', '500183.47', '0.00', '0.00', '1232595.36', '0.00', 2, 75, 1, '2', ' 50415549', '225082.56', '50018.35', '0.00', '2022-10-04 14:09:59', '2022-10-04', 8, 20, '9120001042066'),
(425, '255026', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 4, '2', '54913381', '136563.82', '30347.52', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0152258731600'),
(426, '255028', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 87, 1, '2', '55487351', '198512.56', '44113.90', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 27, '0531022602'),
(427, '255029', '9727740.00', '0.00', '972774.00', '972774.00', '0.00', '0.00', '2508589.80', '0.00', 1, 78, 1, '2', '37085239', '437748.30', '97277.40', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '01J2456602600'),
(428, '255030', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '54915465', '136563.82', '30347.52', '0.00', '2022-10-04 14:09:59', '2022-10-04', 3, 17, '22910018423'),
(429, '255031', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '54915430', '136563.82', '30347.52', '0.00', '2022-10-04 14:09:59', '2022-10-04', 3, 17, '31810018271'),
(430, '255032', '3013177.00', '0.00', '301317.70', '301317.70', '0.00', '0.00', '695657.79', '0.00', 4, 88, 1, '2', '54915414', '135592.97', '30131.77', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0112077702900'),
(431, '255033', '952422.40', '0.00', '95242.24', '95242.24', '0.00', '0.00', '139254.05', '0.00', 2, 100, 1, '2', ' 63823780', '42859.01', '9524.22', '0.00', '2022-10-04 14:09:59', '2022-10-04', 3, 17, '22610017364'),
(432, '255034', '9987840.00', '0.00', '998784.00', '998784.00', '0.00', '0.00', '2578816.80', '0.00', 2, 80, 1, '2', '33937036', '449452.80', '99878.40', '0.00', '2022-10-04 14:09:59', '2022-10-04', 6, 7, '0011012310'),
(433, '255035', '4286423.54', '0.00', '428642.35', '428642.35', '0.00', '0.00', '1039434.36', '0.00', 1, 90, 1, '2', '63827603', '192889.06', '42864.24', '0.00', '2022-10-04 14:09:59', '2022-10-04', 2, 37, '047163013910'),
(434, '255036', '3130198.01', '0.00', '313019.80', '313019.80', '0.00', '0.00', '727253.46', '0.00', 4, 88, 2, '2', '2398369', '140858.91', '31301.98', '0.00', '2022-10-04 14:09:59', '2022-10-04', 3, 17, '30510013213'),
(435, '255037', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 5, '2', '63925125', '136563.82', '30347.52', '0.00', '2022-10-04 14:09:59', '2022-10-04', 3, 17, '22310031304'),
(436, '255038', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 89, 6, '2', '64271706', '136563.82', '30347.52', '0.00', '2022-10-04 14:09:59', '2022-10-04', 3, 17, '24710002402'),
(437, '255039', '8238655.60', '0.00', '823865.56', '823865.56', '0.00', '0.00', '2106537.01', '0.00', 4, 79, 1, '2', '54913543', '370739.50', '82386.56', '0.00', '2022-10-04 14:09:59', '2022-10-04', 7, 39, '00654831'),
(438, '255040', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 2, '2', '58069704', '136563.82', '30347.52', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0152268709100'),
(439, '255041', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 88, 5, '2', '53811216', '198512.56', '44113.90', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '01J2028537400'),
(440, '255042', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 94, 1, '2', '45033376', '80495.84', '17887.96', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0152317686200'),
(441, '255043', '1788796.34', '0.00', '178879.63', '178879.63', '0.00', '0.00', '365075.01', '0.00', 4, 95, 4, '2', '59245433', '80495.84', '17887.96', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0152213480500'),
(442, '255044', '3058904.52', '0.00', '305890.45', '305890.45', '0.00', '0.00', '708004.22', '0.00', 2, 97, 1, '2', '65485076', '137650.70', '30589.05', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0152294853000'),
(443, '255045', '4411390.12', '0.00', '441139.01', '441139.01', '0.00', '0.00', '1073175.33', '0.00', 4, 86, 2, '2', '40085031', '198512.56', '44113.90', '0.00', '2022-10-04 14:09:59', '2022-10-04', 4, 19, '0100301355000'),
(444, '255047', '3034751.60', '0.00', '303475.16', '303475.16', '0.00', '0.00', '701482.93', '0.00', 4, 88, 3, '2', '60555688', '136563.82', '30347.52', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0152352041600'),
(445, '255049', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 105, 2, '2', '45041342', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 5, 14, '0765146120'),
(446, '255050', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 2, '2', '63226758', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 3, 17, '51110014190'),
(447, '255051', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 113, 5, '2', '60656298', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 5, 14, '0753013674'),
(448, '255052', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 126, 2, '2', '64672263', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 5, 21, '0675559454'),
(449, '255053', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 119, 9, '2', '62565761', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0112583358400'),
(450, '255054', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 121, 1, '2', '45043126', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0152218089400'),
(451, '255055', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 124, 8, '2', '65579771', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 3, 18, '32610002345'),
(452, '255056', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 124, 5, '2', '45003239', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 5, 14, '0752711205'),
(453, '255058', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 105, 5, '2', '65668480', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 5, 14, '0769306663'),
(454, '255059', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 8, '2', '63060434', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0152083918300'),
(455, '255060', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 7, '2', '62491342', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 3, 4, '20610000315'),
(456, '255061', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 7, '2', '64424103', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 5, 14, '0765413872'),
(457, '255062', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 107, 2, '2', '65612124', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 5, 14, '24710002402'),
(458, '255063', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 114, 9, '2', '66415403', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0152290741600'),
(459, '255064', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 2, 80, 1, '2', '61851930', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0152222014500'),
(460, '255065', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 125, 2, '2', '58617817', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0152279732300'),
(461, '255066', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 110, 2, '2', '66619556 ', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 34, '0152353551300'),
(462, '255067', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 109, 2, '2', '63626195', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 3, 17, '23710010594'),
(463, '255069', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 103, 6, '2', '63370107', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 3, 17, '70210027551'),
(464, '255070', '1311783.98', '0.00', '131178.40', '131178.40', '0.00', '0.00', '236281.67', '0.00', 4, 95, 1, '2', '64436438', '59030.28', '13117.84', '0.00', '2022-10-04 14:09:59', '2022-10-04', 3, 17, '20810001347'),
(465, '255071', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 127, 4, '2', '63637928', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 5, 14, '0764400281'),
(466, '255072', '630000.00', '0.00', '63000.00', '63000.00', '0.00', '0.00', '59850.00', '0.00', 4, 128, 4, '2', '39077799', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 5, 14, ''),
(467, 'Auto111222', '2700000.00', '0.00', '270000.00', '270000.00', '0.00', '0.00', '611100.00', '0.00', 2, 84, 2, '2', 'Auto111222', '121500.00', '27000.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 2, 2, ''),
(468, '1111', '3000000.00', '0.00', '300000.00', '300000.00', '0.00', '0.00', '692100.00', '0.00', 8, 131, 1, '2', '1111', '135000.00', '30000.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 2, 37, '1232312324'),
(469, '2554', '3000000.00', '0.00', '300000.00', '300000.00', '0.00', '0.00', '692100.00', '0.00', 8, 131, 1, '2', '1111', '135000.00', '30000.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 2, 37, '1232312324'),
(470, '9090', '3000000.00', '0.00', '300000.00', '300000.00', '0.00', '0.00', '692100.00', '0.00', 8, 131, 1, '2', '9090', '135000.00', '30000.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 2, 16, '123443333'),
(471, '8080', '3000000.00', '0.00', '300000.00', '300000.00', '0.00', '0.00', '692100.00', '0.00', 8, 130, 1, '2', '8080', '135000.00', '30000.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 2, 16, '1212123323'),
(472, '7070', '3000000.00', '0.00', '300000.00', '300000.00', '0.00', '0.00', '692100.00', '0.00', 8, 130, 1, '2', '7070', '135000.00', '30000.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 2, 2, ''),
(473, '6060', '3000000.00', '0.00', '300000.00', '300000.00', '0.00', '0.00', '692100.00', '0.00', 2, 85, 1, '2', '6060', '135000.00', '30000.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 3, '6736768655'),
(474, '5050', '3000000.00', '106250.00', '310625.00', '310625.00', '0.00', '0.00', '720787.50', '0.00', 8, 130, 1, '2', '5050', '139781.25', '31062.50', '0.00', '2022-10-04 14:09:59', '2022-10-04', 2, 2, '34345334323'),
(475, '255003', '734341.96', '0.00', '0.00', '0.00', '0.00', '0.00', '102402.59', '0.00', 2, 101, 1, '3', '', '33045.39', '7343.42', '0.00', '2022-10-04 14:09:59', '2022-10-04', 11, 6, '1092873310'),
(476, '255068', '630000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '75600.00', '0.00', 4, 120, 6, '3', 'Retired', '28350.00', '6300.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 2, 2, '027163008371'),
(477, '87', '2700000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '692100.00', '0.00', 2, 93, 1, '3', '67789', '121500.00', '27000.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 3, 17, '888888888888888'),
(478, '3453', '2700000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '692100.00', '0.00', 2, 85, 1, '3', '4532', '121500.00', '27000.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 1, 1, '344444444444444'),
(479, 'Auto111333', '4900000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '1352100.00', '0.00', 2, 80, 2, '3', 'Auto111333', '220500.00', '49000.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 4, 19, '111111111111111'),
(480, '54321', '3000000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '782100.00', '0.00', 2, 84, 2, '3', '54321', '135000.00', '30000.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 2, 16, '100000000'),
(481, '4321', '3000000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '782100.00', '0.00', 8, 130, 1, '3', '4321', '135000.00', '30000.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 2, 16, '1111111111111'),
(482, '123456', '3000000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '782100.00', '0.00', 8, 130, 1, '3', '123456', '135000.00', '30000.00', '0.00', '2022-10-04 14:09:59', '2022-10-04', 2, 2, '111111111111111');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_months`
--

CREATE TABLE `payroll_months` (
  `id` int(11) NOT NULL,
  `payroll_date` date NOT NULL DEFAULT '2019-09-28',
  `state` int(1) NOT NULL DEFAULT 1,
  `wcf` double NOT NULL DEFAULT 0.01,
  `sdl` double NOT NULL DEFAULT 0.045,
  `init_author` varchar(10) NOT NULL,
  `recom_author` varchar(110) DEFAULT NULL,
  `appr_author` varchar(10) NOT NULL,
  `init_date` date NOT NULL,
  `recom_date` varchar(110) DEFAULT NULL,
  `appr_date` date NOT NULL,
  `arrears` int(1) NOT NULL DEFAULT 0 COMMENT '0-No, 1-Yes',
  `pay_checklist` int(1) NOT NULL DEFAULT 0 COMMENT '0-Not Ready, 1-Ready',
  `email_status` int(1) NOT NULL DEFAULT 0 COMMENT '0-Not sent, 1-Sent'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payroll_months`
--

INSERT INTO `payroll_months` (`id`, `payroll_date`, `state`, `wcf`, `sdl`, `init_author`, `recom_author`, `appr_author`, `init_date`, `recom_date`, `appr_date`, `arrears`, `pay_checklist`, `email_status`) VALUES
(1, '2019-01-29', 0, 0.01, 0.045, '255001', '255010', '255073', '2020-07-08', '2020-07-08', '2020-07-08', 0, 1, 1),
(2, '2019-02-19', 0, 0.01, 0.045, '255001', '255010', '255073', '2020-07-09', '2020-07-09', '2020-07-09', 1, 1, 1),
(5, '2020-04-25', 0, 0.01, 0.045, '255001', '255010', '255073', '2020-09-02', '2020-09-02', '2020-09-02', 0, 1, 1),
(7, '2022-09-14', 0, 0.01, 0.045, '255001', '255010', '255073', '2022-09-14', '2022-09-14', '2022-09-14', 0, 1, 1),
(8, '2022-08-31', 0, 0.01, 0.045, '255001', '255010', '255073', '2022-09-14', '2022-09-14', '2022-09-14', 0, 0, 1),
(10, '2022-10-04', 0, 0.01, 0.045, '255001', '255010', '255073', '2022-10-04', '2022-10-04', '2022-10-04', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pension_fund`
--

CREATE TABLE `pension_fund` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `amount_employee` double NOT NULL COMMENT 'Employee Amount in percent',
  `amount_employer` double NOT NULL COMMENT 'Employer Amount in percent',
  `deduction_from` int(1) NOT NULL COMMENT '1-from Basic Salary, 2-From Gross',
  `code` int(11) NOT NULL,
  `abbrv` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pension_fund`
--

INSERT INTO `pension_fund` (`id`, `name`, `amount_employee`, `amount_employer`, `deduction_from`, `code`, `abbrv`) VALUES
(2, 'National Social Security Fund', 0.1, 0.1, 2, 5036, 'NSSF'),
(3, 'Non Pensionable', 0, 0, 2, 0, 'NP');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `code` varchar(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `permission_type` int(1) NOT NULL DEFAULT 1 COMMENT '1-HR, 2-Performance, 3-Financial, 4-Line manager, 5-General',
  `state` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `code`, `name`, `permission_type`, `state`) VALUES
(1, '0', 'View Employee Summary', 5, 1),
(2, '1', 'View Payroll Summary', 5, 1),
(3, '2', 'View Department’s Projects-activities-grants structure Summary', 5, 1),
(4, '3', 'View Organisation’s Projects-activities-grants structure Summary', 5, 1),
(5, '4', 'View Employees', 5, 1),
(6, '5', 'Manage Employees', 1, 1),
(7, '6', 'Approve Employees', 1, 1),
(8, '7', 'View Projects (Projects, Grant, Activity and Allocations)', 5, 1),
(9, '8', 'Manage Projects (Projects, Grant, Activity and Allocations)', 3, 1),
(10, '9', 'View Leave Applications', 1, 1),
(11, 'a', 'Manage Leave', 1, 1),
(12, 'b', 'Approve Leave', 4, 1),
(13, 'c', 'Manage Attendance', 1, 1),
(14, 'd', 'Manage Leave Report', 1, 1),
(15, 'e', 'View Organization', 5, 1),
(16, 'f', 'Manage Organization', 1, 1),
(17, 'g', 'Recommend Payments(Allowances,overtime, imprest, arrears, incentives, Salary Advance and Payroll)', 3, 1),
(18, 'h', 'Manage Statutory Reports', 3, 1),
(19, 'i', 'Manage Payments (Allowances,overtime, imprest, arrears, incentives, Salary Advance and Payroll)(View', 1, 1),
(20, 'j', 'Generate Pay slips', 1, 1),
(21, 'k', 'Use Salary Calculator', 1, 1),
(22, 'l', 'Approve Payments (Allowances,overtime, imprest, arrears, incentives, Salary Advance and Payroll)', 6, 1),
(23, 'm', 'Manage Roles and Groups (View, Create, Delete, Modify, Assign to Employees)', 1, 1),
(24, 'n', 'Manage Audit Trail', 1, 1),
(25, 'o', 'Manage Banking Information (View, Create, Delete, Modify, Assign to Employees(but Not Approve))', 3, 1),
(26, 'p', 'Recommend Deductions(Payroll deduction, Statutory Deduction, Non-statutory Deduction, PAYE Brackets)', 3, 1),
(27, 'q', 'Approve Deductions(Payroll deduction, Statutory Deduction, Non-statutory Deduction, PAYE Brackets)', 6, 1),
(28, 'r', 'Manage Deductions', 1, 1),
(29, 's', 'View Department Allocation', 4, 1),
(30, 't', 'View Settings menus', 5, 1),
(31, 'u', 'View Projects', 5, 1),
(32, 'v', 'View Employee Transfers', 5, 1),
(33, 'w', 'Manage organization Menus', 5, 1);

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
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `dept_code` varchar(5) NOT NULL DEFAULT '001',
  `organization_level` int(11) NOT NULL,
  `purpose` varchar(300) NOT NULL DEFAULT 'N/A',
  `minimum_qualification` varchar(200) NOT NULL DEFAULT 'N/A',
  `driving_licence` int(1) NOT NULL DEFAULT 0,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `state` int(1) NOT NULL DEFAULT 1,
  `isLinked` int(1) NOT NULL DEFAULT 1,
  `position_code` varchar(10) NOT NULL DEFAULT '0',
  `parent_code` varchar(10) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `name`, `code`, `dept_id`, `dept_code`, `organization_level`, `purpose`, `minimum_qualification`, `driving_licence`, `created_by`, `created_on`, `state`, `isLinked`, `position_code`, `parent_code`, `level`) VALUES
(1, 'Country Director', 'DPT10002', 1, '001', 3, 'N/A', 'N/A', 0, '2550001', '2018-07-24 03:49:00', 0, 0, 'qadrpf', 'qadrpf', 1),
(2, 'Finance Director', 'DPT10002', 2, '001', 3, 'N/A', 'N/A', 0, '2550001', '2018-07-24 03:49:00', 0, 1, 'srpasq', 'qadrpf', 2),
(70, 'Head of Finance', 'TZA', 4, '001', 4, 'Manage Programmes', 'Digree', 1, '2550001', '2020-04-26 01:31:38', 0, 1, 'etnerd', 'qadrpf', 2),
(71, 'People and Operations Director', 'DPT10002', 2, '001', 2, 'Manage People, Processes and IT ', 'Masters in Operations and IT ', 0, '2550001', '2020-04-26 01:32:48', 0, 1, 'axvwsu', 'qadrpf', 2),
(72, 'Finance Director', 'DPT10002', 1, '001', 3, 'Manage Finances', 'Masters in Finance Management', 0, '2550001', '2020-04-26 01:35:26', 0, 1, 'wvacyg', 'qadrpf', 2),
(73, 'Country Director', 'DPT10002', 3, '001', 3, 'Manage country Ops', 'PhD', 1, '2550001', '2020-04-26 01:36:57', 0, 1, 'bxankc', 'qadrpf', 2),
(75, 'Operations Manager', '12', 2, '001', 3, 'Yes', 'Masters', 1, '2550001', '2020-05-01 00:21:57', 0, 1, 'ikerqs', 'axvwsu', 3),
(76, 'People Manager', '13', 2, '001', 3, 'Yes', 'Masters', 0, '2550001', '2020-05-01 00:22:34', 0, 1, 'biwule', 'axvwsu', 3),
(77, 'Country Directors', '', 3, '001', 4, '', '', 0, '2550001', '2020-05-16 05:13:50', 1, 1, 'jumhwh', '0', 1),
(78, 'Head of Finance', '', 1, '001', 4, '', '', 0, '2550001', '2020-05-16 05:39:49', 1, 1, 'uxsyao', 'jumhwh', 2),
(79, 'Head of Programmes', '', 4, '001', 4, '', '', 0, '2550001', '2020-05-16 05:41:00', 1, 1, 'ajhhel', 'uxsyao', 3),
(80, 'Head of People and Operations', '', 2, '001', 4, '', '', 0, '2550001', '2020-05-16 05:45:59', 1, 1, 'rzqoqg', 'jumhwh', 2),
(81, 'Resilient Livelihoods Programmes Manager', '', 4, '001', 4, '', '', 0, '2550001', '2020-05-16 05:47:08', 1, 1, 'psqdrp', 'jumhwh', 2),
(82, 'Youth Programmes Manager', '', 4, '001', 4, '', '', 0, '2550001', '2020-05-16 05:50:09', 1, 1, 'ukosrs', 'jumhwh', 2),
(83, 'Senior Accountant', '', 1, '001', 4, '', '', 0, '2550001', '2020-05-16 06:05:50', 1, 1, 'fzimsa', 'uxsyao', 3),
(84, 'Operation Manager', '', 2, '001', 3, '', '', 0, '2550001', '2020-05-16 06:07:07', 1, 1, 'sonkth', 'rzqoqg', 3),
(85, 'Operation Officer', '', 2, '001', 3, '', '', 0, '2550001', '2020-05-16 06:22:51', 1, 1, 'mmjxff', 'sonkth', 4),
(86, 'Project Manager - Resilient Livelihoods Programmes', '', 4, '001', 3, '', '', 0, '2550001', '2020-05-16 06:25:12', 1, 1, 'pszrab', 'psqdrp', 3),
(87, 'Project Manager - Youth Programmes', '', 4, '001', 3, '', '', 0, '2550001', '2020-05-16 06:26:06', 1, 1, 'txmwcf', 'ukosrs', 3),
(88, 'Project Officer - Resilient Livelihoods Programmes', '', 4, '001', 3, '', '', 0, '2550001', '2020-05-16 06:28:06', 1, 1, 'jkppiz', 'pszrab', 4),
(89, 'Project Officer - Youth Programmes ', '', 4, '001', 3, '', '', 0, '2550001', '2020-05-16 06:28:50', 1, 1, 'qpgzoq', 'txmwcf', 4),
(90, 'Grant Finance Officer', '', 1, '001', 3, '', '', 0, '2550001', '2020-05-16 06:29:17', 1, 1, 'bwoyhi', 'uxsyao', 3),
(91, 'Project Coordinator - Resilient Livelihoods Programmes', '', 4, '001', 3, '', '', 0, '2550001', '2020-05-16 06:30:18', 1, 1, 'gkmomu', 'pszrab', 4),
(92, 'Project Coordinator - Youth Programmes ', '', 4, '001', 3, '', '', 0, '2550001', '2020-05-16 06:31:04', 1, 1, 'gyistr', 'txmwcf', 4),
(93, 'Recruitment Specialist ', '', 2, '001', 3, '', '', 0, '2550001', '2020-05-16 06:31:39', 1, 1, 'pnvxlq', 'rzqoqg', 3),
(94, 'Project Assistant - Resilient Livelihoods Programmes ', '', 4, '001', 2, '', '', 0, '2550001', '2020-05-16 06:36:56', 1, 1, 'ijcaco', 'pszrab', 4),
(95, 'Project Assistant - Youth Programmes', '', 4, '001', 2, '', '', 0, '2550001', '2020-05-16 06:37:33', 1, 1, 'btqtiz', 'txmwcf', 4),
(96, 'Finance Assistant', '', 1, '001', 2, '', '', 0, '2550001', '2020-05-16 06:38:23', 1, 1, 'vwmory', 'fzimsa', 4),
(97, 'temporary Support Officer', '', 2, '001', 8, '', '', 0, '2550001', '2020-05-16 06:39:00', 1, 1, 'zfchvd', 'ajhhel', 3),
(98, 'Liason Officer', '', 2, '001', 2, '', '', 0, '2550001', '2020-05-16 06:39:44', 1, 1, 'uxxfpn', 'rzqoqg', 3),
(99, 'Driver', '', 2, '001', 1, '', '', 0, '2550001', '2020-05-16 06:40:26', 1, 1, 'grwyne', 'sonkth', 4),
(100, 'Security Guard ', '', 2, '001', 1, '', '', 1, '2550001', '2020-05-16 06:40:57', 1, 1, 'aundxj', 'mmjxff', 5),
(101, 'Cleaner', '', 2, '001', 1, '', '', 0, '2550001', '2020-05-16 06:42:46', 1, 1, 'gtfkvp', 'mmjxff', 5),
(102, 'Driver - Programmes', 'DRIVER', 4, '001', 1, '', 'Undefined', 1, 'TZ1114433', '2020-05-18 20:59:32', 1, 1, 'iahqwn', 'ajhhel', 3),
(103, 'Agriculture Adviser', '000', 4, '001', 3, '', '1', 0, 'TZ1114433', '2020-05-19 05:38:26', 1, 1, 'nxorlb', 'txmwcf', 4),
(104, 'Project Manager', '000', 2, '001', 3, '', '2', 0, 'TZ1114433', '2020-05-19 05:46:40', 1, 1, 'etneuc', 'ajhhel', 3),
(105, 'BDSO - Gender Equality', '000', 4, '001', 3, '', '1\r\n', 0, 'TZ1114433', '2020-05-19 05:49:22', 1, 1, 'ivyiyl', 'ajhhel', 3),
(106, 'Business and Entrepreneurship Adviser', '000', 2, '001', 3, '', '1', 0, 'TZ1114433', '2020-05-19 05:53:16', 0, 1, 'lgansf', 'gkmomu', 5),
(107, 'Business Development Services - NV', '000', 4, '001', 3, '', '1', 0, 'TZ1114433', '2020-05-19 05:55:43', 1, 1, 'ywchii', 'ajhhel', 3),
(108, 'Communication Specialist', '000', 2, '001', 3, '', '1', 0, 'TZ1114433', '2020-05-19 05:57:10', 0, 1, 'sgpywt', 'txmwcf', 4),
(109, 'Community Engagement Adviser', '000', 4, '001', 2, '', '1', 0, 'TZ1114433', '2020-05-19 05:58:35', 1, 1, 'ubuhfd', 'ukosrs', 3),
(110, 'Community Strategy Adviser', '000', 4, '001', 2, '', '1', 0, 'TZ1114433', '2020-05-19 05:59:50', 1, 1, 'nbclwp', 'txmwcf', 4),
(111, 'Entrepreneurship Adviser', '000', 4, '001', 3, '', '1', 0, 'TZ1114433', '2020-05-19 06:01:06', 1, 1, 'hyqppe', 'psqdrp', 3),
(112, 'Entrepreneurship Adviser', '000', 4, '001', 3, '', '1', 0, 'TZ1114433', '2020-05-19 06:01:08', 1, 1, 'pesvcc', 'psqdrp', 3),
(113, 'Field Officer', '000', 4, '001', 2, '', '1', 0, 'TZ1114433', '2020-05-19 06:02:27', 1, 1, 'vkpezc', 'pszrab', 4),
(114, 'National Resilient Adviser', '000', 4, '001', 2, '', '1', 0, 'TZ1114433', '2020-05-19 06:04:10', 1, 1, 'fymrci', 'ukosrs', 3),
(115, 'Private Sector Engagement Adviser', '000', 4, '001', 3, '', '1', 0, 'TZ1114433', '2020-05-19 06:05:34', 1, 1, 'eclsze', 'txmwcf', 4),
(116, 'Private Sector Engagement Adviser', '000', 4, '001', 3, '', '1', 0, 'TZ1114433', '2020-05-19 06:05:41', 1, 1, 'rpppgq', 'txmwcf', 4),
(117, 'Private Sector Engagement Adviser', '000', 4, '001', 3, '', '1', 0, 'TZ1114433', '2020-05-19 06:05:46', 1, 1, 'uuywer', 'txmwcf', 4),
(118, 'Private Sector Engagement Adviser', '000', 4, '001', 3, '', '1', 0, 'TZ1114433', '2020-05-19 06:05:48', 1, 1, 'jhimmt', 'txmwcf', 4),
(119, 'Quality Teaching Facilitator ', '000', 4, '001', 2, '', '1', 0, 'TZ1114433', '2020-05-19 06:07:08', 1, 1, 'nfcdgj', 'ukosrs', 3),
(120, 'School Management Adviser', '000', 4, '001', 2, '', '1', 0, 'TZ1114433', '2020-05-19 06:08:21', 1, 1, 'uvmvmv', 'txmwcf', 4),
(121, 'Sport and Life Skill Adviser', '000', 4, '001', 2, '', '1', 0, 'TZ1114433', '2020-05-19 06:09:28', 1, 1, 'lqowpr', 'txmwcf', 4),
(122, 'temporary Support Officer', '000', 2, '001', 8, '', '1', 0, 'TZ1114433', '2020-05-19 06:10:39', 1, 1, 'wssclw', 'rzqoqg', 3),
(123, 'temporary Support Officer', '000', 2, '001', 8, '', '1', 0, 'TZ1114433', '2020-05-19 06:10:44', 1, 1, 'zbubjs', 'rzqoqg', 3),
(124, 'Youth Council Representative', '000', 4, '001', 3, '', '1', 0, 'TZ1114433', '2020-05-19 06:12:06', 1, 1, 'mpjzxi', 'ukosrs', 3),
(125, 'Business & Entrepreneurship Adviser', '000', 4, '001', 3, '', '1', 0, 'TZ1114433', '2020-05-19 10:51:03', 1, 1, 'iahbhd', 'pszrab', 4),
(126, 'Communication Specialist', '000', 4, '001', 3, '', '1', 0, 'TZ1114433', '2020-05-20 01:41:13', 1, 1, 'ihymgv', 'txmwcf', 4),
(127, 'Policy and Governance Adviser ', '000', 4, '001', 8, '', 'Diploma', 0, 'TZ1113936', '2020-06-22 01:13:11', 1, 1, 'hibfpu', 'txmwcf', 4),
(128, 'Social Accountability & Youth Engagement Adviser', '000', 4, '001', 8, '', 'Diploma', 0, 'TZ1113936', '2020-06-22 01:19:15', 1, 1, 'wdtorr', 'txmwcf', 4),
(129, 'Transport Officer', '40', 2, '001', 2, 'transportation', 'masters', 0, '255028', '2022-10-02 04:01:20', 0, 1, 'xkbeze', 'jumhwh', 2),
(130, 'Software Developer', '', 8, '001', 3, 'coordinating people', 'masters', 0, '255001', '2022-10-04 06:15:27', 1, 1, 'bkfxmv', 'rzqoqg', 3),
(131, 'Head of Software Production', '', 8, '001', 3, 'management', 'php', 0, '255001', '2022-10-04 06:20:20', 1, 1, 'kcvfbk', 'rzqoqg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cost` varchar(100) DEFAULT NULL,
  `target` varchar(100) DEFAULT NULL,
  `description` varchar(200) NOT NULL,
  `state` varchar(45) NOT NULL DEFAULT '1',
  `project_segment` varchar(150) DEFAULT NULL,
  `managed_by` varchar(45) NOT NULL,
  `document` varchar(100) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `code`, `name`, `cost`, `target`, `description`, `state`, `project_segment`, `managed_by`, `document`, `start_date`, `end_date`) VALUES
(1, 'SP008', 'Livelihood in Tanzania', '', '', 'Livelihood', '1', 'Eduaction', '255010', NULL, NULL, NULL),
(2, 'SP032', 'Inclusive Education in Tanzania', NULL, NULL, 'Education', '0', NULL, '', NULL, NULL, NULL),
(3, 'SP040', 'ABVC in Tanzania', NULL, NULL, 'ABVC', '0', NULL, '', NULL, NULL, NULL),
(4, 'SP062', 'Social Accountability in Tanzania', NULL, NULL, 'Social Accountability', '0', NULL, '', NULL, NULL, NULL),
(5, 'JJ001', 'JJ001', NULL, NULL, 'JJ001 project', '0', NULL, '', NULL, NULL, NULL),
(6, '250', 'Test', '40000', '30000', 'project for testing', '0', 'Agriculture', '255028', NULL, NULL, NULL),
(8, '2022St', '2022 Strategies', '10000000', '10 Korosho Godowns', 'The bank has to buy 10 godowns of Korosho', '1', 'Agriculture', '255010', NULL, '2022-01-01 00:00:00', '2022-12-31 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `project_grant`
--

CREATE TABLE `project_grant` (
  `id` int(11) NOT NULL,
  `project_code` varchar(50) NOT NULL,
  `grant_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_segment`
--

CREATE TABLE `project_segment` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` varchar(45) NOT NULL,
  `created_by` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_segment`
--

INSERT INTO `project_segment` (`id`, `name`, `created_at`, `created_by`) VALUES
(3, 'Eduaction', '2020-07-08', '255001'),
(4, 'Health', '2020-07-08', '255001'),
(5, 'Agriculture', '2020-07-08', '255001');

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
-- Table structure for table `retire`
--

CREATE TABLE `retire` (
  `id` int(11) NOT NULL,
  `retire_age` int(11) NOT NULL DEFAULT 60,
  `notify_before` int(11) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retire`
--

INSERT INTO `retire` (`id`, `retire_age`, `notify_before`) VALUES
(1, 60, 5);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `permissions` varchar(500) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `created_by`, `created_on`, `permissions`) VALUES
(2, 'Line Manager', 'TZ1116298', '2018-05-29 03:00:14', '2ebs'),
(13, 'Admin', 'TZ1116298', '2018-05-29 03:00:14', '012347etuvw569acdfijkmnrlqbs8hop'),
(25, 'HR', 'TZ1116298', '2020-05-07 23:01:57', '01347tuw569acdfijkmnrh'),
(26, 'Finance', 'TZ1116298', '2020-05-07 23:02:16', '014etv8ghop'),
(27, 'Director', 'TZ1114433', '2020-06-03 22:43:36', '01347tuv9lq'),
(28, 'Observer', 'TZ1113936', '2020-06-29 05:53:15', '0127w');

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
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `description` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`id`, `title`, `start_time`, `end_time`, `description`) VALUES
(1, 'Morning Shift', '08:00:00', '14:00:00', ''),
(2, 'Noon Shift', '14:00:00', '20:00:00', ''),
(3, 'Night Shift', '20:00:00', '02:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `position_ref` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL DEFAULT 'N/A',
  `type` varchar(10) NOT NULL DEFAULT 'IND',
  `amount` bigint(20) NOT NULL,
  `mandatory` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` varchar(10) NOT NULL,
  `isActive` int(1) NOT NULL DEFAULT 1,
  `dated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `strategy`
--

CREATE TABLE `strategy` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` varchar(670) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `type` int(1) NOT NULL DEFAULT 1 COMMENT '1-strategy, 2-project',
  `funder` int(11) NOT NULL,
  `author` varchar(10) NOT NULL,
  `status` int(11) NOT NULL,
  `progress` int(11) NOT NULL,
  `dated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `strategy`
--

INSERT INTO `strategy` (`id`, `title`, `description`, `start`, `end`, `type`, `funder`, `author`, `status`, `progress`, `dated`) VALUES
(1, 'Test', 'Test', '2019-05-10', '2020-05-09', 1, 0, '2550001', 0, 0, '2019-02-21 22:28:55'),
(34, 'Malalie Elimination', 'Description', '2020-05-05', '2020-05-30', 2, 1, '2550001', 0, 0, '2020-05-05 03:11:42');

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
-- Table structure for table `talent`
--

CREATE TABLE `talent` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `score` double NOT NULL,
  `description` varchar(200) NOT NULL,
  `due_date` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `talent`
--

INSERT INTO `talent` (`id`, `empID`, `score`, `description`, `due_date`, `status`) VALUES
(1, '2550001', 100, 'N/A', '2019-08-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `title` varchar(200) NOT NULL DEFAULT 'N/A',
  `initial_quantity` decimal(15,2) NOT NULL DEFAULT 1.00,
  `submitted_quantity` decimal(15,2) NOT NULL DEFAULT 0.00,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `assigned_to` varchar(50) DEFAULT NULL,
  `assigned_by` varchar(11) DEFAULT NULL,
  `date_assigned` date DEFAULT NULL,
  `progress` int(3) NOT NULL DEFAULT 0,
  `outcome_ref` int(11) NOT NULL,
  `strategy_ref` int(11) DEFAULT NULL,
  `output_ref` int(11) NOT NULL,
  `status` int(2) DEFAULT 0 COMMENT '0-assigned, 1- Submitted, 2-approved, 3-Cancelled, 4-overdue, 5-disapproved, 6-committed',
  `quantity` double DEFAULT 1,
  `quantity_type` int(11) NOT NULL DEFAULT 2 COMMENT '1-finencial quantity, 2-numerical quantity',
  `quality` double DEFAULT 1 COMMENT 'behaviour',
  `excess_points` double NOT NULL DEFAULT 0,
  `qb_ratio` varchar(15) DEFAULT '70:30' COMMENT 'quantity_behaviour Ratio',
  `monetaryValue` int(11) DEFAULT 0,
  `remarks` varchar(500) DEFAULT NULL,
  `isAssigned` int(11) NOT NULL DEFAULT 0,
  `notification` int(11) NOT NULL DEFAULT 1 COMMENT '0-seen, 1-Employee, 2-line manager',
  `date_completed` date DEFAULT NULL,
  `attachment` varchar(100) NOT NULL DEFAULT '0',
  `submission_remarks` varchar(300) DEFAULT NULL,
  `date_marked` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `description`, `title`, `initial_quantity`, `submitted_quantity`, `start`, `end`, `assigned_to`, `assigned_by`, `date_assigned`, `progress`, `outcome_ref`, `strategy_ref`, `output_ref`, `status`, `quantity`, `quantity_type`, `quality`, `excess_points`, `qb_ratio`, `monetaryValue`, `remarks`, `isAssigned`, `notification`, `date_completed`, `attachment`, `submission_remarks`, `date_marked`) VALUES
(1, 'Description Task1', 'Task1', '3.00', '0.00', '2020-05-05', '2020-05-30', '2550004', '2550001', '2020-05-05', 0, 1, 34, 1, 0, 1, 2, 1, 0, '70:30', 200000, NULL, 1, 1, NULL, '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_employee`
--

CREATE TABLE `task_employee` (
  `id` int(11) NOT NULL,
  `employeeID` varchar(10) NOT NULL,
  `taskID` int(11) NOT NULL,
  `assignedOn` datetime NOT NULL,
  `assignedBy` varchar(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '1-Assigned, 0-Cancelled'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `task_ratings`
--

CREATE TABLE `task_ratings` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `lower_limit` double NOT NULL,
  `upper_limit` double NOT NULL,
  `contribution` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task_ratings`
--

INSERT INTO `task_ratings` (`id`, `title`, `description`, `lower_limit`, `upper_limit`, `contribution`) VALUES
(1, 'Outstanding', '', 85, 100.4, 1),
(2, 'Very Strong', '', 75, 85, 0.75),
(3, 'Strong', '', 65, 75, 0.5),
(4, 'Good', '', 50, 65, 0.25),
(5, 'Improvement Needed', '', 0, 50, 0);

-- --------------------------------------------------------

--
-- Table structure for table `task_resources`
--

CREATE TABLE `task_resources` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `cost` decimal(15,2) NOT NULL,
  `taskID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task_resources`
--

INSERT INTO `task_resources` (`id`, `name`, `cost`, `taskID`) VALUES
(4, 'gty', '500.00', 139),
(32, 'Trend', '340000.00', 142),
(11, 'Logistics and materials', '2000000.00', 159),
(31, 'ERD', '23000.00', 142),
(21, 'Another Resource', '125000.00', 132),
(20, 'Second Resource', '2500.00', 132),
(19, 'First Resource', '500.00', 132),
(33, 'one', '100.00', 183),
(34, 'two', '150.00', 183);

-- --------------------------------------------------------

--
-- Table structure for table `task_settings`
--

CREATE TABLE `task_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `behaviour` double DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `value` double(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task_settings`
--

INSERT INTO `task_settings` (`id`, `name`, `behaviour`, `quantity`, `value`) VALUES
(1, 'Marking Parameters', 30, 70, 0.00),
(2, 'Percent of time elapsed to alert', 0, 0, 80.00);

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
-- Table structure for table `temp_allowance_logs`
--

CREATE TABLE `temp_allowance_logs` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `allowanceID` int(11) DEFAULT NULL,
  `allowanceCode` int(11) DEFAULT NULL,
  `description` varchar(50) NOT NULL DEFAULT 'Unclassified',
  `policy` varchar(50) NOT NULL DEFAULT 'Fixed Amount',
  `amount` bigint(20) DEFAULT NULL,
  `payment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_arrears`
--

CREATE TABLE `temp_arrears` (
  `id` bigint(20) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `paid` decimal(15,2) NOT NULL DEFAULT 0.00,
  `amount_last_paid` decimal(15,2) NOT NULL DEFAULT 0.00,
  `last_paid_date` date NOT NULL,
  `payroll_date` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '0-Payment Completed, 1-Payment Not Completed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_deduction_logs`
--

CREATE TABLE `temp_deduction_logs` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `deductionID` int(11) DEFAULT NULL,
  `deductionCode` int(11) DEFAULT NULL,
  `description` varchar(50) NOT NULL DEFAULT 'Unclassified',
  `policy` varchar(50) NOT NULL DEFAULT 'Fixed Amount',
  `paid` bigint(20) DEFAULT NULL,
  `payment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_loan_logs`
--

CREATE TABLE `temp_loan_logs` (
  `id` int(11) NOT NULL,
  `loanID` int(11) NOT NULL,
  `loanTypeID` int(11) DEFAULT NULL,
  `loanCode` int(11) DEFAULT NULL,
  `policy` double NOT NULL DEFAULT 0,
  `paid` bigint(20) DEFAULT NULL,
  `remained` bigint(20) DEFAULT NULL,
  `payment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_payroll_logs`
--

CREATE TABLE `temp_payroll_logs` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `salary` double DEFAULT NULL,
  `allowances` double NOT NULL DEFAULT 0,
  `pension_employee` double DEFAULT NULL,
  `pension_employer` double DEFAULT NULL,
  `medical_employee` double NOT NULL DEFAULT 0,
  `medical_employer` double NOT NULL DEFAULT 0,
  `taxdue` double DEFAULT NULL,
  `meals` double NOT NULL DEFAULT 0,
  `department` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `branch` int(11) NOT NULL,
  `pension_fund` varchar(100) NOT NULL,
  `membership_no` varchar(20) NOT NULL DEFAULT 'PSSF/2019/000910',
  `sdl` double NOT NULL,
  `wcf` double NOT NULL,
  `due_date` datetime NOT NULL DEFAULT current_timestamp(),
  `payroll_date` date DEFAULT NULL,
  `bank` int(11) NOT NULL DEFAULT 1,
  `bank_branch` int(11) NOT NULL DEFAULT 1,
  `account_no` varchar(20) NOT NULL DEFAULT '0128J092341550',
  `less_takehome` decimal(20,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `training_application`
--

CREATE TABLE `training_application` (
  `id` int(11) NOT NULL,
  `skillsID` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '0-requested, 1-recommended, 2-approved by HR, 3-Confirmed By Finance, 4-Held by Line Manager, 5-Dissaproved, 6-Unconfirmed, 7-Cancelled Employee,',
  `recommended_by` varchar(10) NOT NULL,
  `date_recommended` date NOT NULL DEFAULT '2019-07-29',
  `approved_by` varchar(10) NOT NULL,
  `date_approved` date NOT NULL DEFAULT '2019-07-29',
  `confirmed_by` varchar(10) NOT NULL,
  `date_confirmed` date NOT NULL DEFAULT '2019-07-29',
  `application_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_budget`
--

CREATE TABLE `training_budget` (
  `id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `start` date NOT NULL DEFAULT '2019-07-27',
  `end` date NOT NULL DEFAULT '2019-07-27',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0-requested, 1-approved, 2-Denied',
  `recommended_by` varchar(10) NOT NULL,
  `date_recommended` date NOT NULL DEFAULT '2019-07-26',
  `approved_by` varchar(10) NOT NULL,
  `date_approved` date NOT NULL DEFAULT '2019-07-26'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `training_budget`
--

INSERT INTO `training_budget` (`id`, `description`, `amount`, `start`, `end`, `status`, `recommended_by`, `date_recommended`, `approved_by`, `date_approved`) VALUES
(15, 'Training Budget', '10000000.00', '2019-07-30', '2019-08-10', 1, '2550001', '2019-07-26', '2540018', '2020-05-08'),
(19, 'Mwaka kesho training ', '30000000.00', '2019-08-13', '2020-08-13', 1, '2550001', '2019-08-13', '2550001', '2019-08-13'),
(20, '2020 Training', '10000000.00', '2020-05-08', '2020-12-31', 0, '2550017', '2020-05-08', '', '2020-05-08');

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `parameter` varchar(100) NOT NULL,
  `parameterID` int(11) NOT NULL COMMENT '1-Salary, 2-Position, 3-Deptment, 4-Branch, 5-',
  `old` decimal(15,2) NOT NULL,
  `new` decimal(15,2) NOT NULL,
  `old_department` varchar(5) NOT NULL DEFAULT '0',
  `new_department` varchar(5) NOT NULL DEFAULT '0',
  `old_position` varchar(5) NOT NULL DEFAULT '0',
  `new_position` varchar(5) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '0-Requested, 1-Accepted, 2-Rejected',
  `recommended_by` varchar(10) NOT NULL,
  `approved_by` varchar(10) NOT NULL,
  `date_recommended` date NOT NULL,
  `date_approved` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transfer`
--

INSERT INTO `transfer` (`id`, `empID`, `parameter`, `parameterID`, `old`, `new`, `old_department`, `new_department`, `old_position`, `new_position`, `status`, `recommended_by`, `approved_by`, `date_recommended`, `date_approved`) VALUES
(1, '0970015', 'Salary', 1, '0.00', '2000000.00', '0', '0', '0', '0', 1, '2550001', '2550001', '2020-05-01', '2020-05-01'),
(3, '2550002', 'Salary', 1, '734342.00', '770000.00', '0', '0', '0', '0', 1, '2550017', '2550001', '2020-05-08', '2020-05-18'),
(4, '2550001', 'Department', 3, '1.00', '2.00', '0', '0', '1', '93', 1, '2550001', '2550001', '2020-05-18', '2020-05-18'),
(5, '2550001', 'Salary', 1, '611781.00', '4801328.97', '0', '0', '0', '0', 1, '2550001', '2550001', '2020-05-18', '2020-05-18'),
(7, 'TZ394', 'Position', 2, '93.00', '90.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-18', '2020-05-18'),
(8, 'UG213', 'Department', 3, '1.00', '4.00', '0', '0', '93', '79', 1, 'TZ1114433', 'TZ1114433', '2020-05-18', '2020-05-18'),
(9, 'UG213', 'Salary', 1, '0.00', '8238655.60', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-18', '2020-05-18'),
(10, 'TZ346', 'Department', 3, '1.00', '4.00', '0', '0', '93', '102', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(11, 'TZ346', 'Salary', 1, '0.00', '1137796.44', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(12, 'TZ350', 'Department', 3, '4.00', '4.00', '0', '0', '88', '81', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(13, 'TZ350', 'Salary', 1, '4411390.12', '8288034.48', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(15, 'TZ270', 'Position', 2, '88.00', '101.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(16, 'TZ270', 'Department', 3, '2.00', '2.00', '0', '0', '101', '101', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(17, 'TZ1118959', 'Department', 3, '4.00', '2.00', '0', '0', '88', '80', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(18, 'TZ1118959', 'Salary', 1, '3034751.60', '9987840.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(19, 'TZ392', 'Salary', 1, '930000.00', '4411390.12', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(20, 'TZ392', 'Department', 3, '4.00', '4.00', '0', '0', '88', '87', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(21, 'TZ394', 'Department', 3, '4.00', '1.00', '0', '0', '88', '90', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(22, 'TZ394', 'Salary', 1, '3130198.01', '4286423.54', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(23, 'TZ1111725', 'Department', 3, '4.00', '1.00', '0', '0', '88', '90', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(24, 'TZ1111725', 'Salary', 1, '930000.00', '4286423.54', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(25, 'TZ350', 'Department', 3, '4.00', '4.00', '0', '0', '81', '81', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(26, 'TZ270', 'Department', 3, '2.00', '2.00', '0', '0', '101', '101', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(27, 'TZ1118959', 'Department', 3, '2.00', '2.00', '0', '0', '80', '80', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(28, 'TZ392', 'Department', 3, '4.00', '4.00', '0', '0', '87', '87', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(29, 'TZ354', 'Department', 3, '4.00', '4.00', '0', '0', '88', '86', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(30, 'TZ390', 'Department', 3, '4.00', '4.00', '0', '0', '88', '86', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(31, 'TZ390', 'Salary', 1, '1137796.44', '4411390.12', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(32, 'TZ398', 'Department', 3, '2.00', '4.00', '0', '0', '88', '89', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(33, 'TZ398', 'Salary', 1, '1137796.45', '3130198.01', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(34, 'TZ346', 'Department', 3, '4.00', '4.00', '0', '0', '88', '102', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(35, 'TZ346', 'Salary', 1, '4411390.12', '1137796.44', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(36, 'TZ255', 'Department', 3, '1.00', '2.00', '0', '0', '88', '100', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(37, 'TZ255', 'Salary', 1, '4286423.54', '952422.51', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(38, 'TZ255', 'Salary', 1, '4286423.54', '952422.51', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(39, 'TZ255', 'Salary', 1, '4286423.54', '952422.51', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(40, 'TZ1112567', 'Department', 3, '4.00', '2.00', '0', '0', '88', '99', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(41, 'TZ1112567', 'Salary', 1, '4411390.12', '1137796.45', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(42, 'TZ1114237', 'Department', 3, '4.00', '2.00', '0', '0', '88', '100', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(43, 'TZ1114237', 'Salary', 1, '930000.00', '952422.41', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(44, 'TZ1114237', 'Salary', 1, '930000.00', '952422.40', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(45, 'TZ1113936', 'Department', 3, '1.00', '2.00', '0', '0', '88', '100', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(46, 'TZ1113936', 'Salary', 1, '9727740.00', '952422.40', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(47, 'TZ280', 'Department', 3, '4.00', '2.00', '0', '0', '88', '98', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(48, 'TZ280', 'Salary', 1, '8288034.48', '3058904.52', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(49, 'TZ280', 'Salary', 1, '8288034.48', '3058904.52', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(50, 'TZ1114433', 'Department', 3, '1.00', '2.00', '0', '0', '93', '93', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(51, 'TZ1114433', 'Salary', 1, '4801328.97', '4801328.97', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(52, 'TZ207', 'Department', 3, '1.00', '2.00', '0', '0', '88', '100', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(53, 'TZ207', 'Salary', 1, '4286423.54', '952422.40', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(54, 'TZ344', 'Department', 3, '2.00', '2.00', '0', '0', '88', '97', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(55, 'TZ344', 'Salary', 1, '9987840.00', '3058904.52', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(56, 'V1107641', 'Department', 3, '1.00', '4.00', '0', '0', '88', '121', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(57, 'V1107641', 'Salary', 1, '2073728.75', '930000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(58, 'TZ1118433', 'Department', 3, '4.00', '4.00', '0', '0', '88', '88', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(59, 'TZ1118433', 'Salary', 1, '1788796.34', '3013177.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(60, 'TZ1120832', 'Position', 2, '88.00', '88.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(61, 'TZ1120832', 'Salary', 1, '8238655.60', '4411390.12', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(62, 'V1120726', 'Department', 3, '4.00', '4.00', '0', '0', '88', '119', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(63, 'V1120726', 'Salary', 1, '930000.00', '930000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(64, 'V1122282', 'Department', 3, '4.00', '4.00', '0', '0', '88', '114', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(65, 'TZ1117437', 'Department', 3, '4.00', '1.00', '0', '0', '88', '78', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(66, 'TZ1117437', 'Salary', 1, '3034751.60', '99727740.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(67, 'TZ1117437', 'Salary', 1, '3034751.60', '99727740.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(68, 'TZ1118646', 'Department', 3, '4.00', '2.00', '0', '0', '88', '97', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(69, 'TZ1118646', 'Salary', 1, '930000.00', '3058904.52', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(70, 'V1116705', 'Department', 3, '4.00', '4.00', '0', '0', '88', '107', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(71, 'V1116705', 'Salary', 1, '3034751.60', '930000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(72, 'TZ1119719', 'Department', 3, '2.00', '4.00', '0', '0', '88', '95', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(73, 'TZ1119719', 'Salary', 1, '3058904.52', '1788796.34', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(74, 'V1123869', 'Department', 3, '4.00', '4.00', '0', '0', '88', '125', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(75, 'TZ1118697', 'Salary', 1, '930000.00', '1788796.34', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(76, 'V1119259', 'Salary', 1, '952422.40', '930000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(77, 'TZ1120662', 'Salary', 1, '930000.00', '1788796.34', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(78, 'TZ1123840', 'Salary', 1, '930000.00', '2731276.44', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(79, 'TZ1123911', 'Salary', 1, '930000.00', '3034751.60', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(80, 'TZ1110594', 'Salary', 1, '952422.40', '6248835.86', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(81, 'TZ1117437', 'Salary', 1, '99727740.00', '9727740.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(82, ' TZ1116298', 'Salary', 1, '930000.00', '3034751.60', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(83, 'V1123855', 'Salary', 1, '4411390.12', '930000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(84, 'TZ1118808', 'Salary', 1, '952422.40', '6242400.01', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(85, 'T1118301', 'Salary', 1, '3013177.00', '3034751.60', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(86, 'UG213', 'Salary', 1, '6242400.01', '8238655.60', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(87, 'V1122491', 'Salary', 1, '3130198.01', '930000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(88, 'V1121008', 'Salary', 1, '3034751.60', '930000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(89, 'V1120365', 'Salary', 1, '4286423.54', '930000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(90, 'V1118644', 'Salary', 1, '3034751.60', '930000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(91, 'V1121009', 'Salary', 1, '3034751.60', '930000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(92, 'V1123856', 'Salary', 1, '5001834.65', '930000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(93, 'TZ1119120', 'Salary', 1, '6248835.86', '4286423.54', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(94, 'TZ1119120', 'Salary', 1, '6248835.86', '4286423.54', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(95, 'V1122495', 'Salary', 1, '4411390.12', '930000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(96, 'TZ1117612', 'Salary', 1, '1788796.34', '2073728.75', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(97, 'TZ396', 'Salary', 1, '952422.51', '4411390.12', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(98, 'TZ1119257', 'Salary', 1, '3034751.60', '3130198.01', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(99, 'TZ1110431', 'Salary', 1, '952422.40', '3034751.60', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(100, 'TZ1117942', 'Salary', 1, '1788796.34', '3034751.60', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(101, 'TZ1118543', 'Salary', 1, '930000.00', '3034751.60', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(102, 'TZ1119238', 'Salary', 1, '930000.00', '3034751.60', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(103, 'TZ1119944', 'Salary', 1, '3058904.52', '3034751.60', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(104, 'V1123868', 'Salary', 1, '4411390.12', '930000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(105, 'TZ1119029', 'Salary', 1, '2731276.44', '952422.40', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(106, 'V1115825', 'Salary', 1, '3034751.60', '930000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(107, 'TZ1123833', 'Salary', 1, '930000.00', '4411390.12', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(108, 'T1114490', 'Salary', 1, '930000.00', '4411390.12', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(109, 'TZ1114436', 'Salary', 1, '3058904.52', '5001834.65', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-19', '2020-05-19'),
(110, 'TZ1118697', 'Department', 3, '4.00', '4.00', '0', '0', '88', '95', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(112, 'V1119259', 'Position', 2, '88.00', '80.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(114, 'TZ1120662', 'Department', 3, '4.00', '4.00', '0', '0', '88', '94', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(116, 'TZ1123840', 'Department', 3, '4.00', '4.00', '0', '0', '88', '88', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(118, 'TZ1123911', 'Department', 3, '4.00', '4.00', '0', '0', '88', '88', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(120, 'TZ1110594', 'Department', 3, '2.00', '4.00', '0', '0', '88', '82', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(121, 'V1121009', 'Department', 3, '4.00', '4.00', '0', '0', '88', '107', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(123, ' TZ1116298', 'Department', 3, '4.00', '4.00', '0', '0', '88', '88', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(125, 'V1123856', 'Department', 3, '2.00', '4.00', '0', '0', '88', '120', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(126, 'V1123855', 'Department', 3, '4.00', '4.00', '0', '0', '88', '110', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(127, 'TZ1119120', 'Department', 3, '4.00', '1.00', '0', '0', '88', '90', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(128, 'TZ1110882', 'Department', 3, '2.00', '2.00', '0', '0', '88', '85', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(130, 'V1123864', 'Department', 3, '4.00', '4.00', '0', '0', '88', '103', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(131, 'TZ1118808', 'Department', 3, '2.00', '1.00', '0', '0', '88', '83', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(132, 'V1122495', 'Department', 3, '4.00', '4.00', '0', '0', '88', '124', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(133, 'V1122495', 'Department', 3, '4.00', '4.00', '0', '0', '88', '124', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(134, 'T1118301', 'Department', 3, '4.00', '4.00', '0', '0', '88', '91', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(135, 'UG213', 'Department', 3, '1.00', '4.00', '0', '0', '88', '79', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(136, 'TZ1117612', 'Department', 3, '4.00', '1.00', '0', '0', '88', '96', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(137, 'TZ396', 'Department', 3, '2.00', '4.00', '0', '0', '88', '87', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(138, 'V1120850', 'Department', 3, '4.00', '4.00', '0', '0', '88', '105', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(139, 'TZ396', 'Department', 3, '4.00', '4.00', '0', '0', '87', '86', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(140, 'TZ1119257', 'Department', 3, '4.00', '4.00', '0', '0', '88', '88', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(141, 'V1122491', 'Department', 3, '4.00', '4.00', '0', '0', '88', '124', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(142, 'V1117694', 'Department', 3, '4.00', '4.00', '0', '0', '88', '107', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(143, 'V1121008', 'Department', 3, '4.00', '4.00', '0', '0', '88', '105', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(144, 'V1120922', 'Department', 3, '4.00', '4.00', '0', '0', '88', '111', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(145, 'TZ1110431', 'Department', 3, '2.00', '4.00', '0', '0', '88', '89', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(146, 'V1123660', 'Department', 3, '4.00', '4.00', '0', '0', '88', '115', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(147, 'TZ1117942', 'Department', 3, '4.00', '4.00', '0', '0', '88', '89', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(148, 'V1120365', 'Department', 3, '1.00', '4.00', '0', '0', '88', '113', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(149, 'V1118644', 'Department', 3, '4.00', '4.00', '0', '0', '88', '107', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(150, 'TZ1118543', 'Department', 3, '4.00', '4.00', '0', '0', '88', '89', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(151, 'V1120364', 'Department', 3, '4.00', '4.00', '0', '0', '88', '126', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(152, 'TZ1114436', 'Department', 3, '2.00', '2.00', '0', '0', '88', '75', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(153, 'TZ1123833', 'Department', 3, '4.00', '4.00', '0', '0', '88', '86', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(154, 'TZ1119944', 'Department', 3, '2.00', '4.00', '0', '0', '88', '89', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(155, 'V1123868', 'Department', 3, '4.00', '4.00', '0', '0', '88', '109', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(156, 'V1115825', 'Department', 3, '4.00', '4.00', '0', '0', '88', '107', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(157, 'TZ1119029', 'Department', 3, '4.00', '2.00', '0', '0', '88', '100', 1, 'TZ1114433', 'TZ1114433', '2020-05-20', '2020-05-20'),
(159, 'V11123974', 'Salary', 1, '2700000.00', '930000.00', '0', '0', '0', '0', 1, 'TZ1113936', 'TZ1113936', '2020-06-19', '2020-06-19'),
(160, 'V11123973', 'Salary', 1, '2700000.00', '930000.00', '0', '0', '0', '0', 1, 'TZ1113936', 'TZ1114433', '2020-06-19', '2020-06-19'),
(163, 'TZ1119258', 'Salary', 1, '1788796.34', '1311783.98', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-06-19', '2020-06-19'),
(164, 'TZ1113936', 'Salary', 1, '952422.40', '539706.03', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-06-19', '2020-06-19'),
(166, 'V11123973', 'Position', 2, '125.00', '128.00', '0', '0', '0', '0', 1, 'TZ1113936', 'TZ1113936', '2020-06-22', '2020-06-22'),
(167, 'V11123974', 'Position', 2, '125.00', '127.00', '0', '0', '0', '0', 1, 'TZ1113936', 'TZ1113936', '2020-06-22', '2020-06-22'),
(168, 'V1123856', 'Salary', 1, '630000.00', '930000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-06-22', '2020-06-22'),
(169, 'V1123856', 'Salary', 1, '930000.00', '630000.00', '0', '0', '0', '0', 1, 'TZ1114433', 'TZ1114433', '2020-06-22', '2020-06-22'),
(170, 'TZ394', 'Department', 3, '1.00', '2.00', '0', '0', '90', '80', 1, 'TZ1114433', 'TZ1114433', '2020-06-26', '2020-06-26'),
(171, 'ytrewdsa', 'New Employee', 5, '0.00', '5000000.00', '0', '1', '0', '78', 7, '255001', '', '2020-07-14', '0000-00-00'),
(172, 'Auto111222', 'New Employee', 5, '0.00', '2700000.00', '0', '2', '0', '84', 6, '255001', '255001', '2022-10-01', '2022-10-01'),
(173, '87', 'New Employee', 5, '0.00', '2700000.00', '0', '2', '0', '93', 5, '255028', '', '2022-10-02', '0000-00-00'),
(174, '3453', 'New Employee', 5, '0.00', '2700000.00', '0', '2', '0', '85', 5, '255001', '', '2022-10-02', '0000-00-00'),
(175, '1111', 'New Employee', 5, '0.00', '3000000.00', '0', '8', '0', '131', 5, '255001', '', '2022-10-04', '0000-00-00'),
(176, '2554', 'New Employee', 5, '0.00', '3000000.00', '0', '8', '0', '131', 5, '255001', '', '2022-10-04', '0000-00-00'),
(177, 'Auto111333', 'New Employee', 5, '0.00', '4900000.00', '0', '2', '0', '80', 5, '255001', '', '2022-10-04', '0000-00-00'),
(178, '54321', 'New Employee', 5, '0.00', '3000000.00', '0', '2', '0', '84', 5, '255001', '', '2022-10-04', '0000-00-00'),
(179, '4321', 'New Employee', 5, '0.00', '3000000.00', '0', '8', '0', '130', 5, '255001', '', '2022-10-04', '0000-00-00'),
(180, '123456', 'New Employee', 5, '0.00', '3000000.00', '0', '8', '0', '130', 5, '255001', '', '2022-10-04', '0000-00-00'),
(181, '9090', 'New Employee', 5, '0.00', '3000000.00', '0', '8', '0', '131', 5, '255001', '', '2022-10-04', '0000-00-00'),
(182, '8080', 'New Employee', 5, '0.00', '3000000.00', '0', '8', '0', '130', 5, '255001', '', '2022-10-04', '0000-00-00'),
(183, '7070', 'New Employee', 5, '0.00', '3000000.00', '0', '8', '0', '130', 6, '255001', '255001', '2022-10-04', '2022-10-04'),
(184, '6060', 'New Employee', 5, '0.00', '3000000.00', '0', '2', '0', '85', 5, '255001', '', '2022-10-04', '0000-00-00'),
(185, '5050', 'New Employee', 5, '0.00', '3000000.00', '0', '8', '0', '130', 6, '255001', '255001', '2022-10-04', '2022-10-04'),
(186, '112', 'New Employee', 5, '0.00', '1500000.00', '0', '1', '0', '96', 5, '255028', '', '2022-11-23', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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

INSERT INTO `users` (`id`, `name`, `emp_id`, `added_by`, `phone`, `address`, `department_id`, `designation_id`, `joining_date`, `active_status`, `disabled`, `disabled_date`, `email`, `email_verified_at`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'CITS Test Account', '55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin@gmail.com', '2022-12-01 07:32:54', '$2y$10$QueW5thXzMAZIWqG3U587ezxMamKhqDitZgrNqJsQzNZG8rnTGkjm', 'active', 'QmOm10fj9NRPwD2mTCPS15IGCtpl2dMutWrQnYYLezR2nAkhjovfY7ESURV1', '2022-12-01 07:32:54', '2022-12-01 07:32:54');

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
-- Table structure for table `user_passwords`
--

CREATE TABLE `user_passwords` (
  `id` int(11) NOT NULL,
  `empID` varchar(110) NOT NULL,
  `password` varchar(110) NOT NULL,
  `time` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_passwords`
--

INSERT INTO `user_passwords` (`id`, `empID`, `password`, `time`) VALUES
(32, '9090', '$2y$10$0pYqThbNg20qnriVLlgIoOYn8kAAQqNCM9AHQOEiua.YYcd1hIVyW', '2022-10-04'),
(33, '5050', '$2y$10$67Q0QbsKfrTDlu.aiF6iqOoyTNceoGIINoDqqZj5p6BjWg1eFWMbC', '2022-10-04');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_employee_activity`
-- (See below for the actual view)
--
CREATE TABLE `vw_employee_activity` (
`empID` varchar(10)
,`isActive` varchar(45)
,`project_code` varchar(50)
,`percent` varchar(45)
,`grant_code` varchar(50)
,`activity_code` varchar(50)
,`payroll_date` varchar(45)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_employee_activity1`
-- (See below for the actual view)
--
CREATE TABLE `vw_employee_activity1` (
`empID` varchar(10)
,`isActive` int(11)
,`project_code` varchar(50)
,`percent` double
,`grant_code` varchar(50)
,`activity_code` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_employee_auto_activity_allocation`
-- (See below for the actual view)
--
CREATE TABLE `vw_employee_auto_activity_allocation` (
`id` int(1)
,`empID` varchar(45)
,`activity_code` varchar(6)
,`grant_code` varchar(3)
,`percent` double
,`isActive` int(1)
,`payroll_date` varchar(45)
);

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

-- --------------------------------------------------------

--
-- Structure for view `vw_employee_activity`
--
DROP TABLE IF EXISTS `vw_employee_activity`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cits`@`localhost` SQL SECURITY DEFINER VIEW `vw_employee_activity`  AS   (select `employee`.`emp_id` AS `empID`,if(`eag`.`empID` is null,1,`eag`.`isActive`) AS `isActive`,if(`eag`.`empID` is null,(select `project`.`code` from `project` where `project`.`id` = 1),(select `activity`.`project_ref` from `activity` where `activity`.`code` = `eag`.`activity_code` limit 1)) AS `project_code`,if(`eag`.`empID` is null,100,`eag`.`percent`) AS `percent`,if(`eag`.`empID` is null,(select `grants`.`code` from `grants` where `grants`.`id` = 1),`eag`.`grant_code`) AS `grant_code`,if(`eag`.`empID` is null,(select `activity`.`code` from `activity` where `activity`.`id` = 1),`eag`.`activity_code`) AS `activity_code`,`eag`.`payroll_date` AS `payroll_date` from (`employee` left join (select `vw_employee_auto_activity_allocation`.`id` AS `id`,`vw_employee_auto_activity_allocation`.`empID` AS `empID`,`vw_employee_auto_activity_allocation`.`activity_code` AS `activity_code`,`vw_employee_auto_activity_allocation`.`grant_code` AS `grant_code`,`vw_employee_auto_activity_allocation`.`percent` AS `percent`,`vw_employee_auto_activity_allocation`.`isActive` AS `isActive`,`vw_employee_auto_activity_allocation`.`isActive` AS `payroll_date` from `vw_employee_auto_activity_allocation` union select `employee_activity_grant_logs`.`id` AS `id`,`employee_activity_grant_logs`.`empID` AS `empID`,`employee_activity_grant_logs`.`activity_code` AS `activity_code`,`employee_activity_grant_logs`.`grant_code` AS `grant_code`,`employee_activity_grant_logs`.`percent` AS `percent`,`employee_activity_grant_logs`.`isActive` AS `isActive`,`employee_activity_grant_logs`.`payroll_date` AS `payroll_date` from `employee_activity_grant_logs`) `eag` on(`employee`.`emp_id` = `eag`.`empID`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `vw_employee_activity1`
--
DROP TABLE IF EXISTS `vw_employee_activity1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cits`@`localhost` SQL SECURITY DEFINER VIEW `vw_employee_activity1`  AS   (select `employee`.`emp_id` AS `empID`,if(`eag`.`empID` is null,1,`eag`.`isActive`) AS `isActive`,if(`eag`.`empID` is null,(select `project`.`code` from `project` where `project`.`id` = 1),(select `activity`.`project_ref` from `activity` where `activity`.`code` = `eag`.`activity_code` limit 1)) AS `project_code`,if(`eag`.`empID` is null,100,`eag`.`percent`) AS `percent`,if(`eag`.`empID` is null,(select `grants`.`code` from `grants` where `grants`.`id` = 1),`eag`.`grant_code`) AS `grant_code`,if(`eag`.`empID` is null,(select `activity`.`code` from `activity` where `activity`.`id` = 1),`eag`.`activity_code`) AS `activity_code` from (`employee` left join (select `vw_employee_auto_activity_allocation`.`id` AS `id`,`vw_employee_auto_activity_allocation`.`empID` AS `empID`,`vw_employee_auto_activity_allocation`.`activity_code` AS `activity_code`,`vw_employee_auto_activity_allocation`.`grant_code` AS `grant_code`,`vw_employee_auto_activity_allocation`.`percent` AS `percent`,`vw_employee_auto_activity_allocation`.`isActive` AS `isActive` from `vw_employee_auto_activity_allocation` union select `employee_activity_grant`.`id` AS `id`,`employee_activity_grant`.`empID` AS `empID`,`employee_activity_grant`.`activity_code` AS `activity_code`,`employee_activity_grant`.`grant_code` AS `grant_code`,`employee_activity_grant`.`percent` AS `percent`,`employee_activity_grant`.`isActive` AS `isActive` from `employee_activity_grant`) `eag` on(`employee`.`emp_id` = `eag`.`empID`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `vw_employee_auto_activity_allocation`
--
DROP TABLE IF EXISTS `vw_employee_auto_activity_allocation`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cits`@`localhost` SQL SECURITY DEFINER VIEW `vw_employee_auto_activity_allocation`  AS   (select 0 AS `id`,`secondaryquery`.`empID` AS `empID`,'AC0018' AS `activity_code`,'VSO' AS `grant_code`,100 - `secondaryquery`.`sumPercent` AS `percent`,1 AS `isActive`,`secondaryquery`.`payroll_date` AS `payroll_date` from (select `employee_activity_grant_logs`.`empID` AS `empID`,`employee_activity_grant_logs`.`payroll_date` AS `payroll_date`,sum(`employee_activity_grant_logs`.`percent`) AS `sumPercent` from `employee_activity_grant_logs` where `employee_activity_grant_logs`.`isActive` = 1 group by `employee_activity_grant_logs`.`empID`,`employee_activity_grant_logs`.`payroll_date`) `secondaryquery` where `secondaryquery`.`sumPercent` < 100)  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountability`
--
ALTER TABLE `accountability`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_code`
--
ALTER TABLE `account_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activation_deactivation`
--
ALTER TABLE `activation_deactivation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_cost`
--
ALTER TABLE `activity_cost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_grant`
--
ALTER TABLE `activity_grant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_results`
--
ALTER TABLE `activity_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allowance_logs`
--
ALTER TABLE `allowance_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appreciation`
--
ALTER TABLE `appreciation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `arrears`
--
ALTER TABLE `arrears`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `arrears_logs`
--
ALTER TABLE `arrears_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `arrears_pendings`
--
ALTER TABLE `arrears_pendings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_employee`
--
ALTER TABLE `assignment_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_exception`
--
ALTER TABLE `assignment_exception`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_task`
--
ALTER TABLE `assignment_task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_task_comment`
--
ALTER TABLE `assignment_task_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_task_logs`
--
ALTER TABLE `assignment_task_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_purge_logs`
--
ALTER TABLE `audit_purge_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_trails`
--
ALTER TABLE `audit_trails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_branch`
--
ALTER TABLE `bank_branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `behaviour`
--
ALTER TABLE `behaviour`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bonus`
--
ALTER TABLE `bonus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bonus_logs`
--
ALTER TABLE `bonus_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bonus_tags`
--
ALTER TABLE `bonus_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taskID` (`taskID`);

--
-- Indexes for table `company_emails`
--
ALTER TABLE `company_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_info`
--
ALTER TABLE `company_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_property`
--
ALTER TABLE `company_property`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_fk` (`given_to`),
  ADD KEY `given_by` (`given_by`);

--
-- Indexes for table `confirmed_imprest`
--
ALTER TABLE `confirmed_imprest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `confirmed_trainee`
--
ALTER TABLE `confirmed_trainee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deduction`
--
ALTER TABLE `deduction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deduction_logs`
--
ALTER TABLE `deduction_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deduction_tags`
--
ALTER TABLE `deduction_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliverables`
--
ALTER TABLE `deliverables`
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
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_id` (`emp_id`),
  ADD KEY `positiont_fk` (`position`),
  ADD KEY `department_fk` (`department`);

--
-- Indexes for table `employee_activity_grant`
--
ALTER TABLE `employee_activity_grant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_activity_grant_logs`
--
ALTER TABLE `employee_activity_grant_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_group`
--
ALTER TABLE `employee_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_name` (`group_name`);

--
-- Indexes for table `employee_overtime`
--
ALTER TABLE `employee_overtime`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empID` (`empID`);

--
-- Indexes for table `emp_allowances`
--
ALTER TABLE `emp_allowances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package` (`allowance`);

--
-- Indexes for table `emp_deductions`
--
ALTER TABLE `emp_deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_role`
--
ALTER TABLE `emp_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `emp_skills`
--
ALTER TABLE `emp_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exception_type`
--
ALTER TABLE `exception_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `exit_list`
--
ALTER TABLE `exit_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_category`
--
ALTER TABLE `expense_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `funder`
--
ALTER TABLE `funder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grants`
--
ALTER TABLE `grants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grant_logs`
--
ALTER TABLE `grant_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grievances`
--
ALTER TABLE `grievances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `imprest`
--
ALTER TABLE `imprest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `imprest_requirement`
--
ALTER TABLE `imprest_requirement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_application`
--
ALTER TABLE `leave_application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_type`
--
ALTER TABLE `leave_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_index` (`empID`,`type`);

--
-- Indexes for table `loan_application`
--
ALTER TABLE `loan_application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_logs`
--
ALTER TABLE `loan_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_type`
--
ALTER TABLE `loan_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meals_deduction`
--
ALTER TABLE `meals_deduction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobile_service_provider`
--
ALTER TABLE `mobile_service_provider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `next_of_kin`
--
ALTER TABLE `next_of_kin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_fk` (`employee_fk`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_index` (`type`,`for`);

--
-- Indexes for table `once_off_deduction`
--
ALTER TABLE `once_off_deduction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_level`
--
ALTER TABLE `organization_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outcome`
--
ALTER TABLE `outcome`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `output`
--
ALTER TABLE `output`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overtimes`
--
ALTER TABLE `overtimes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overtime_category`
--
ALTER TABLE `overtime_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overtime_logs`
--
ALTER TABLE `overtime_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partial_payment`
--
ALTER TABLE `partial_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paused_task`
--
ALTER TABLE `paused_task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paye`
--
ALTER TABLE `paye`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_logs`
--
ALTER TABLE `payroll_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empID` (`empID`);

--
-- Indexes for table `payroll_months`
--
ALTER TABLE `payroll_months`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pension_fund`
--
ALTER TABLE `pension_fund`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id2` (`code`);

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
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_fk` (`dept_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_grant`
--
ALTER TABLE `project_grant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_segment`
--
ALTER TABLE `project_segment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regions_zone_id_foreign` (`zone_id`);

--
-- Indexes for table `retire`
--
ALTER TABLE `retire`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `strategy`
--
ALTER TABLE `strategy`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `talent`
--
ALTER TABLE `talent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_employee`
--
ALTER TABLE `task_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_ratings`
--
ALTER TABLE `task_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_resources`
--
ALTER TABLE `task_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_settings`
--
ALTER TABLE `task_settings`
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
-- Indexes for table `temp_allowance_logs`
--
ALTER TABLE `temp_allowance_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_arrears`
--
ALTER TABLE `temp_arrears`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_deduction_logs`
--
ALTER TABLE `temp_deduction_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_loan_logs`
--
ALTER TABLE `temp_loan_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_payroll_logs`
--
ALTER TABLE `temp_payroll_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empID` (`empID`);

--
-- Indexes for table `training_application`
--
ALTER TABLE `training_application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_budget`
--
ALTER TABLE `training_budget`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
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
-- Indexes for table `user_passwords`
--
ALTER TABLE `user_passwords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountability`
--
ALTER TABLE `accountability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_code`
--
ALTER TABLE `account_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `activation_deactivation`
--
ALTER TABLE `activation_deactivation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `activity_cost`
--
ALTER TABLE `activity_cost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity_grant`
--
ALTER TABLE `activity_grant`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `activity_results`
--
ALTER TABLE `activity_results`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `allowances`
--
ALTER TABLE `allowances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `allowance_logs`
--
ALTER TABLE `allowance_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appreciation`
--
ALTER TABLE `appreciation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `arrears`
--
ALTER TABLE `arrears`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `arrears_logs`
--
ALTER TABLE `arrears_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `arrears_pendings`
--
ALTER TABLE `arrears_pendings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assignment_employee`
--
ALTER TABLE `assignment_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `assignment_exception`
--
ALTER TABLE `assignment_exception`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `assignment_task`
--
ALTER TABLE `assignment_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `assignment_task_comment`
--
ALTER TABLE `assignment_task_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `assignment_task_logs`
--
ALTER TABLE `assignment_task_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=390;

--
-- AUTO_INCREMENT for table `audit_purge_logs`
--
ALTER TABLE `audit_purge_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `audit_trails`
--
ALTER TABLE `audit_trails`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `bank_branch`
--
ALTER TABLE `bank_branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `behaviour`
--
ALTER TABLE `behaviour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bonus`
--
ALTER TABLE `bonus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bonus_logs`
--
ALTER TABLE `bonus_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bonus_tags`
--
ALTER TABLE `bonus_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_emails`
--
ALTER TABLE `company_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `company_info`
--
ALTER TABLE `company_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_property`
--
ALTER TABLE `company_property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `confirmed_imprest`
--
ALTER TABLE `confirmed_imprest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `confirmed_trainee`
--
ALTER TABLE `confirmed_trainee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contract`
--
ALTER TABLE `contract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `deduction`
--
ALTER TABLE `deduction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `deduction_logs`
--
ALTER TABLE `deduction_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deduction_tags`
--
ALTER TABLE `deduction_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `deliverables`
--
ALTER TABLE `deliverables`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `employee_activity_grant`
--
ALTER TABLE `employee_activity_grant`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `employee_activity_grant_logs`
--
ALTER TABLE `employee_activity_grant_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2242;

--
-- AUTO_INCREMENT for table `employee_group`
--
ALTER TABLE `employee_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `employee_overtime`
--
ALTER TABLE `employee_overtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `emp_allowances`
--
ALTER TABLE `emp_allowances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `emp_deductions`
--
ALTER TABLE `emp_deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `emp_role`
--
ALTER TABLE `emp_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `emp_skills`
--
ALTER TABLE `emp_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exception_type`
--
ALTER TABLE `exception_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exit_list`
--
ALTER TABLE `exit_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `expense_category`
--
ALTER TABLE `expense_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `funder`
--
ALTER TABLE `funder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grants`
--
ALTER TABLE `grants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `grant_logs`
--
ALTER TABLE `grant_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grievances`
--
ALTER TABLE `grievances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `imprest`
--
ALTER TABLE `imprest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `imprest_requirement`
--
ALTER TABLE `imprest_requirement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `leave_application`
--
ALTER TABLE `leave_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `leave_type`
--
ALTER TABLE `leave_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `loan_application`
--
ALTER TABLE `loan_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `loan_logs`
--
ALTER TABLE `loan_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `loan_type`
--
ALTER TABLE `loan_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `meals_deduction`
--
ALTER TABLE `meals_deduction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mobile_service_provider`
--
ALTER TABLE `mobile_service_provider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `next_of_kin`
--
ALTER TABLE `next_of_kin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `once_off_deduction`
--
ALTER TABLE `once_off_deduction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organization_level`
--
ALTER TABLE `organization_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `outcome`
--
ALTER TABLE `outcome`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `output`
--
ALTER TABLE `output`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `overtimes`
--
ALTER TABLE `overtimes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `overtime_category`
--
ALTER TABLE `overtime_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `overtime_logs`
--
ALTER TABLE `overtime_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `partial_payment`
--
ALTER TABLE `partial_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `paused_task`
--
ALTER TABLE `paused_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paye`
--
ALTER TABLE `paye`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payroll_logs`
--
ALTER TABLE `payroll_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=483;

--
-- AUTO_INCREMENT for table `payroll_months`
--
ALTER TABLE `payroll_months`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pension_fund`
--
ALTER TABLE `pension_fund`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `project_grant`
--
ALTER TABLE `project_grant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_segment`
--
ALTER TABLE `project_segment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `retire`
--
ALTER TABLE `retire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `strategy`
--
ALTER TABLE `strategy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `talent`
--
ALTER TABLE `talent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task_employee`
--
ALTER TABLE `task_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_ratings`
--
ALTER TABLE `task_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `task_resources`
--
ALTER TABLE `task_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `task_settings`
--
ALTER TABLE `task_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `temp_allowance_logs`
--
ALTER TABLE `temp_allowance_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_arrears`
--
ALTER TABLE `temp_arrears`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_deduction_logs`
--
ALTER TABLE `temp_deduction_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_loan_logs`
--
ALTER TABLE `temp_loan_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_payroll_logs`
--
ALTER TABLE `temp_payroll_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_application`
--
ALTER TABLE `training_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_budget`
--
ALTER TABLE `training_budget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `transfer`
--
ALTER TABLE `transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `user_passwords`
--
ALTER TABLE `user_passwords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
