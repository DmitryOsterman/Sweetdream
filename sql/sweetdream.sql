-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 21, 2016 at 04:15 PM
-- Server version: 5.7.11-log
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sweetdream`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE IF NOT EXISTS `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` char(250) NOT NULL,
  `order_id` int(11) DEFAULT '0',
  `status` char(250) DEFAULT NULL,
  `comment` char(250) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created`, `order_id`, `status`, `comment`) VALUES
(19, 34, '2016-10-17 07:44:43', 0, NULL, 'victory!'),
(60, 0, '2016-10-21 05:07:23', 0, NULL, 'AutoCreated'),
(58, 0, '2016-10-21 05:06:58', 0, NULL, 'AutoCreated'),
(56, 0, '2016-10-21 04:43:06', 0, NULL, 'AutoCreated'),
(54, 0, '2016-10-21 03:59:56', 0, NULL, 'AutoCreated'),
(53, 0, '2016-10-21 03:37:53', 0, NULL, 'AutoCreated'),
(52, 0, '2016-10-21 03:35:05', 0, NULL, 'AutoCreated'),
(51, 0, '2016-10-21 03:31:55', 0, NULL, 'AutoCreated'),
(50, 0, '2016-10-21 03:30:31', 0, NULL, 'AutoCreated'),
(49, 0, '2016-10-21 03:28:54', 0, NULL, 'AutoCreated'),
(48, 0, '2016-10-21 03:24:17', 0, NULL, 'AutoCreated'),
(47, 0, '2016-10-21 03:20:23', 0, NULL, 'AutoCreated'),
(46, 0, '2016-10-21 02:32:12', 0, NULL, 'AutoCreated'),
(45, 0, '2016-10-21 02:16:00', 0, NULL, 'AutoCreated'),
(62, 0, '2016-10-21 05:11:45', 0, NULL, 'AutoCreated'),
(64, 0, '2016-10-21 05:23:03', 0, NULL, 'AutoCreated'),
(66, 0, '2016-10-21 05:25:34', 0, NULL, 'AutoCreated'),
(67, 29, '2016-10-21 05:25:44', 0, NULL, 'User Cart Created success'),
(68, 0, '2016-10-21 05:28:59', 0, NULL, 'AutoCreated'),
(69, 0, '2016-10-21 05:32:17', 0, NULL, 'AutoCreated'),
(70, 0, '2016-10-21 05:35:09', 0, NULL, 'AutoCreated'),
(71, 0, '2016-10-21 05:35:44', 0, NULL, 'AutoCreated'),
(72, 0, '2016-10-21 05:36:25', 0, NULL, 'AutoCreated'),
(73, 0, '2016-10-21 05:39:03', 0, NULL, 'AutoCreated'),
(74, 0, '2016-10-21 05:52:41', 0, NULL, 'AutoCreated'),
(75, 350, '2016-10-21 05:54:46', 0, NULL, 'User Cart Created success'),
(76, 0, '2016-10-21 05:54:53', 0, NULL, 'AutoCreated'),
(77, 35, '2016-10-21 07:27:59', 0, NULL, 'User Cart Created success'),
(78, 0, '2016-10-21 07:40:58', 0, NULL, 'AutoCreated'),
(79, 0, '2016-10-21 08:22:41', 0, NULL, 'AutoCreated'),
(80, 0, '2016-10-21 12:28:39', 0, NULL, 'AutoCreated'),
(81, 0, '2016-10-21 13:05:57', 0, NULL, 'AutoCreated'),
(82, 0, '2016-10-21 14:25:12', 0, NULL, 'AutoCreated'),
(83, 0, '2016-10-21 16:06:43', 0, NULL, 'AutoCreated');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=155 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `amount`) VALUES
(154, 67, 31, '1'),
(153, 79, 14, '1'),
(152, 77, 27, '2'),
(43, 19, 27, '3'),
(84, 19, 25, '5'),
(150, 77, 3, '1'),
(147, 75, 14, '2'),
(146, 75, 3, '1'),
(145, 75, 25, '1'),
(144, 67, 3, '2'),
(143, 67, 9, '1'),
(137, 62, 9, '1'),
(136, 60, 14, '1'),
(135, 58, 15, '1'),
(134, 56, 14, '1'),
(133, 54, 10, '1'),
(132, 53, 14, '1'),
(131, 52, 25, '1'),
(130, 51, 10, '1'),
(129, 49, 14, '1'),
(128, 48, 3, '1'),
(126, 47, 9, '1'),
(125, 47, 10, '1'),
(124, 46, 14, '1'),
(123, 45, 15, '1'),
(122, 45, 14, '1'),
(120, 44, 25, '1'),
(119, 43, 10, '1');

-- --------------------------------------------------------

--
-- Table structure for table `catalog`
--

CREATE TABLE IF NOT EXISTS `catalog` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` char(250) NOT NULL,
  `price` char(30) DEFAULT NULL,
  `amount` char(30) DEFAULT NULL,
  `link` char(250) DEFAULT NULL,
  `imgLink` char(250) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `catalog`
--

INSERT INTO `catalog` (`id`, `parent_id`, `name`, `price`, `amount`, `link`, `imgLink`) VALUES
(1, 0, 'Для детей', '0', '0', '#', ''),
(2, 1, 'Пеленки', '0', '0', '#', '#'),
(4, 0, 'Постельное белье', '0', '0', '#', ''),
(5, 4, 'Бязь', '0', '0', '#', ''),
(6, 12, 'Поплин', '0', '0', '#', ''),
(12, 0, 'Подушки', '', '', '#', ''),
(26, 0, 'Одеяла', NULL, NULL, NULL, NULL),
(27, 26, 'Синтепон', NULL, NULL, NULL, NULL),
(31, 1, 'Наборы', NULL, NULL, '#', NULL),
(32, 0, 'Матрасы', NULL, NULL, NULL, NULL),
(33, 0, 'Для мам и пап', NULL, NULL, NULL, NULL),
(34, 1, 'Костюмы', NULL, NULL, NULL, NULL),
(35, 32, 'Ортопедические', NULL, NULL, NULL, NULL),
(36, 33, 'Товары для взрослых', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `goods`
--

CREATE TABLE IF NOT EXISTS `goods` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` char(250) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `amount` char(30) NOT NULL,
  `link` char(250) NOT NULL DEFAULT '#',
  `img_link` char(250) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `goods`
--

INSERT INTO `goods` (`id`, `parent_id`, `name`, `description`, `price`, `amount`, `link`, `img_link`) VALUES
(3, 2, 'Пеленка розовая', 'Пеленка розовая, для девочек, размер 1000х1500 mm', 700, '7', '#', '3-image.jpg'),
(9, 2, 'Пеленка желтая', 'очень краствая, двухспальная', 45.5, '3', '#', '9-image.jpg'),
(10, 6, 'поплин', 'Шёлковая, полушёлковая или хлопчатобумажная ткань в мелкий поперечный рубчик.', 5555, '5', '#', '10-image.jpg'),
(14, 5, 'КПБ бязь бери не боязь', '', 2200, '3', '#', '14-image.jpg'),
(15, 5, 'БЕРИ а может и нет бязь', 'Хлопчатобумажная плотная ткань.', 220, '4', '#', '15-image.jpg'),
(19, 5, 'КПБ ШУЯ', 'Комплект двухспальный Евро размер', 777, '1', '#', '19-image.jpg'),
(2, 2, 'Пеленка bluue, , размер 1000х1500 mm', '', 333, '3', '#', '0-image.jpg'),
(26, 2, 'шмаленки', '', 777, '2', '#', '26-image.jpg'),
(30, 35, 'Матрас', 'Soft and warm, 160 x 160', 24000, '6', '#', '30-image.jpg'),
(28, 35, 'Матрас', 'орто 140 х 160', 12000, '4', '#', '28-image.jpg'),
(29, 36, 'Cat', 'Kitchen master', 999999999, '1', '#', '29-image.jpg'),
(31, 27, 'Одеяло', 'Наполнитель - полиэфирное волокно. Размер: 1,5 - спальное', 575, '12', '#', '31-image.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `status` char(250) NOT NULL,
  `comment` char(250) NOT NULL,
  `total` double DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `created`, `status`, `comment`, `total`) VALUES
(33, 30, '2016-10-15 08:50:43', 'ordering', 'no_more_comment', NULL),
(32, 32, '2016-10-15 08:45:32', 'ordering', 'no_more_comment', NULL),
(31, 30, '2016-12-13 16:21:10', 'ordering', 'no_more_comment', NULL),
(30, 1, '2016-10-13 07:50:19', 'ordering', 'no_more_comment', NULL),
(29, 33, '2016-10-13 07:34:10', 'ordering', 'no_more_comment', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` double DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `amount`, `price`) VALUES
(41, 24, 25, 2, 5),
(40, 24, 25, 1, 5),
(39, 24, 3, 1, 700),
(38, 23, 26, 1, 777),
(37, 22, 26, 1, 777),
(36, 21, 26, 1, 777),
(42, 25, 26, 1, 777),
(43, 26, 3, 1, 700),
(44, 26, 25, 1, 5),
(45, 26, 25, 2, 5),
(46, 26, 3, 1, 700),
(47, 27, 3, 1, 700),
(48, 27, 25, 1, 5),
(49, 27, 25, 2, 5),
(50, 27, 3, 1, 700),
(51, 28, 3, 1, 700),
(52, 28, 25, 1, 5),
(53, 28, 25, 2, 5),
(54, 28, 3, 1, 700),
(55, 29, 26, 1, 777),
(56, 30, 14, 1, 2200),
(57, 30, 3, 2, 700),
(58, 31, 10, 3, 5555),
(59, 32, 9, 1, 45.5),
(60, 32, 3, 1, 700),
(61, 33, 26, 1, 700);

-- --------------------------------------------------------

--
-- Table structure for table `upmenu`
--

CREATE TABLE IF NOT EXISTS `upmenu` (
  `id` int(11) NOT NULL,
  `name` char(30) NOT NULL,
  `link` char(30) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `upmenu`
--

INSERT INTO `upmenu` (`id`, `name`, `link`) VALUES
(1, 'О нас', 'about'),
(2, 'Доставка', 'delivery'),
(3, 'Оптовикам', 'dealers'),
(4, 'Статьи', 'articles'),
(5, 'Контакты', 'contacts');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `first_name` char(100) NOT NULL,
  `second_name` char(100) NOT NULL,
  `address` char(60) NOT NULL,
  `zip_code` char(10) NOT NULL,
  `phone` char(12) NOT NULL,
  `email` char(60) DEFAULT NULL,
  `password` char(250) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `second_name`, `address`, `zip_code`, `phone`, `email`, `password`) VALUES
(35, 'q', 'q', '', '', '', 'q@q.com', '7694f4a66316e53c8cdd9d9954bd611d'),
(34, 'ARTEM', '', '', '', '', 'a@a.com', '0cc175b9c0f1b6a831c399e269772661'),
(29, 'Вася', '', '', '', '1', '1@1.com', 'c4ca4238a0b923820dcc509a6f75849b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalog`
--
ALTER TABLE `catalog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upmenu`
--
ALTER TABLE `upmenu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=155;
--
-- AUTO_INCREMENT for table `catalog`
--
ALTER TABLE `catalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `upmenu`
--
ALTER TABLE `upmenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
