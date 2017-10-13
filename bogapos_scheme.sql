-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2017 at 09:53 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bogasoftware_bogapos`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `auth_login_attempts`
--

CREATE TABLE `auth_login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users`
--

CREATE TABLE `auth_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `store` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_users`
--

INSERT INTO `auth_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `fullname`, `phone`, `image`, `store`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1507877967, 1, 'Owner', '21', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_groups`
--

CREATE TABLE `auth_users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user` int(11) UNSIGNED NOT NULL,
  `group` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_users_groups`
--

INSERT INTO `auth_users_groups` (`id`, `user`, `group`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cash`
--

CREATE TABLE `cash` (
  `id` int(11) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `code` varchar(40) NOT NULL,
  `type` varchar(5) NOT NULL COMMENT 'begin, in, out',
  `sale` int(11) UNSIGNED DEFAULT NULL,
  `return` int(11) UNSIGNED DEFAULT NULL,
  `purchase` int(11) UNSIGNED DEFAULT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `note` varchar(255) DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `postcode` int(6) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `city`, `postcode`) VALUES
(1, 'Default Customer', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `code` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `quantity` int(7) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `price` double NOT NULL DEFAULT '0',
  `cost` double NOT NULL DEFAULT '0',
  `weight` float NOT NULL DEFAULT '0',
  `minimum` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `viewed` int(5) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(40) NOT NULL,
  `date` datetime NOT NULL,
  `supplier` int(10) UNSIGNED NOT NULL,
  `supplier_name` varchar(50) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `subtotal` double NOT NULL DEFAULT '0',
  `discount` double DEFAULT '0',
  `tax` float DEFAULT '0' COMMENT 'percentage',
  `shipping` double DEFAULT '0',
  `grand_total` double NOT NULL DEFAULT '0',
  `cash` double NOT NULL DEFAULT '0',
  `credit` double NOT NULL DEFAULT '0',
  `change` double NOT NULL DEFAULT '0',
  `status` varchar(20) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_product`
--

CREATE TABLE `purchase_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase` int(10) UNSIGNED NOT NULL,
  `product` int(10) UNSIGNED NOT NULL,
  `product_code` varchar(64) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `cost` double NOT NULL DEFAULT '0',
  `quantity` float NOT NULL DEFAULT '0',
  `discount` float NOT NULL DEFAULT '0' COMMENT 'percentage',
  `subtotal` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(40) NOT NULL,
  `date` datetime NOT NULL,
  `customer` int(10) UNSIGNED NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `subtotal` double NOT NULL DEFAULT '0',
  `discount` double DEFAULT '0',
  `tax` float DEFAULT '0' COMMENT 'percentage',
  `shipping` double DEFAULT '0',
  `grand_total` double NOT NULL DEFAULT '0',
  `cash` double NOT NULL DEFAULT '0',
  `credit` double NOT NULL DEFAULT '0',
  `change` double NOT NULL DEFAULT '0',
  `status` varchar(20) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `pos` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sale_product`
--

CREATE TABLE `sale_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale` int(10) UNSIGNED NOT NULL,
  `product` int(10) UNSIGNED NOT NULL,
  `product_code` varchar(64) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `cost` double NOT NULL DEFAULT '0',
  `net_price` double NOT NULL DEFAULT '0',
  `fix_price` double NOT NULL DEFAULT '0',
  `quantity` float NOT NULL DEFAULT '0',
  `discount` float NOT NULL DEFAULT '0' COMMENT 'percentage',
  `subtotal` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sale_shipping`
--

CREATE TABLE `sale_shipping` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `code` varchar(45) NOT NULL,
  `recipient` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(45) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`) VALUES
(1, 'timezone', 'Asia/Jakarta'),
(2, 'language', 'indonesian'),
(3, 'enable_tax', 'false'),
(4, 'default_customer', '1'),
(5, 'default_supplier', '1'),
(6, 'store_name', 'Bogapos'),
(7, 'store_address', 'Karawang'),
(8, 'store_phone', '0000'),
(9, 'store_logo', './files/images/logo.png'),
(10, 'duedate_payment', '10'),
(11, 'number_of_decimal', '2'),
(12, 'code_format_sales', 'SL/[IN]/[MONTH]/[YEAR]'),
(13, 'code_format_purchases', 'PC/[IN]/[MONTH]/[YEAR]'),
(14, 'code_format_pos', 'POS/[IN]/[MONTH]/[YEAR]'),
(15, 'code_format_cash_in', 'CI/[IN]/[MONTH]/[YEAR]'),
(16, 'code_format_cash_out', 'CO/[IN]/[MONTH]/[YEAR]'),
(17, 'separator_decimal', '.'),
(18, 'separator_thousand', ','),
(19, 'date_format', 'd/m/Y'),
(20, 'date_format_uk', 'DD/MM/YYYY');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `postcode` int(6) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `email`, `phone`, `address`, `city`, `postcode`) VALUES
(1, 'Default Suplier', 'suplier@admin.com', '081111111', 'Karawang', 'Karawang', 41351);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_login_attempts`
--
ALTER TABLE `auth_login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_users`
--
ALTER TABLE `auth_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warehouse` (`store`);

--
-- Indexes for table `auth_users_groups`
--
ALTER TABLE `auth_users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user`,`group`),
  ADD KEY `fk_users_groups_users1_idx` (`user`),
  ADD KEY `fk_users_groups_groups1_idx` (`group`);

--
-- Indexes for table `cash`
--
ALTER TABLE `cash`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale` (`sale`),
  ADD KEY `return` (`return`),
  ADD KEY `purchase` (`purchase`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `customer` (`supplier`);

--
-- Indexes for table `purchase_product`
--
ALTER TABLE `purchase_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale` (`purchase`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `customer` (`customer`);

--
-- Indexes for table `sale_product`
--
ALTER TABLE `sale_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale` (`sale`);

--
-- Indexes for table `sale_shipping`
--
ALTER TABLE `sale_shipping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale` (`sale`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`,`key`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `auth_login_attempts`
--
ALTER TABLE `auth_login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `auth_users`
--
ALTER TABLE `auth_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `auth_users_groups`
--
ALTER TABLE `auth_users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cash`
--
ALTER TABLE `cash`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchase_product`
--
ALTER TABLE `purchase_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sale_product`
--
ALTER TABLE `sale_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sale_shipping`
--
ALTER TABLE `sale_shipping`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
