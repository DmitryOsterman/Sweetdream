-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 17, 2016 at 05:19 AM
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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created`, `order_id`, `status`, `comment`) VALUES
(18, 29, '2016-10-16 07:57:08', 0, NULL, 'victory!');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `amount`) VALUES
(19, 17, 15, '1'),
(18, 17, 15, '1'),
(17, 17, 15, '1'),
(16, 17, 14, '1'),
(15, 17, 25, '1'),
(14, 17, 14, '1'),
(20, 17, 25, '1'),
(21, 17, 25, '1'),
(22, 18, 25, '2'),
(32, 18, 9, '2'),
(31, 18, 3, '8'),
(36, 18, 10, '2'),
(37, 18, 19, '1'),
(38, 18, 26, '1'),
(39, 18, 2, '2'),
(40, 18, 14, '1'),
(41, 18, 15, '1'),
(42, 18, 27, '2');

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
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

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
(26, 0, 'Командировочные', NULL, NULL, '#', NULL),
(27, 26, 'Проезд', NULL, NULL, '#', NULL),
(31, 1, 'Наборы', NULL, NULL, '#', NULL),
(32, 0, 'Матрасы', NULL, NULL, NULL, NULL),
(33, 0, 'Для мам и пап', NULL, NULL, NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `goods`
--

INSERT INTO `goods` (`id`, `parent_id`, `name`, `description`, `price`, `amount`, `link`, `img_link`) VALUES
(3, 2, 'Пеленка розовая', 'Пеленка розовая, для девочек, размер 1000х1500 mm', 700, '7', '#', '3-image.jpg'),
(9, 2, 'пеленки для курящих', '', 45.5, '3', '#', '9-image.jpg'),
(10, 6, 'поплин блин блин', '', 5555, '5', '#', 'c7b7902031512f5ac064e446596fdb8d.jpg'),
(14, 5, 'КПБ бязь бери не боязь', '', 2200, '3', '#', '14-image.jpg'),
(15, 5, 'БЕРИ а может и нет бязь', '', 220, '4', '#', ''),
(19, 2, 'КПБ ШУЯ', 'It''s Bantly Nevada 3500', 777, '1', '#', '..\\img\\ScreenClip2.png'),
(25, 27, 'HART', '', 5, '10', '#', '25-image.jpg'),
(2, 2, 'Пеленка bluue, , размер 1000х1500 mm', '', 333, '3', '#', '0-image.jpg'),
(26, 2, 'шмаленки', '', 777, '2', '#', '26-image.jpg'),
(27, 32, 'Матрас', 'Soft and warm', 11, '22', '#', '27-image.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `second_name`, `address`, `zip_code`, `phone`, `email`, `password`) VALUES
(30, '4-5', 'Push', '', '', '', '4', '83878c91171338902e0fe0fb97a8c47a'),
(32, 'Elena', '', '', '', '', '2@1.com', 'c4ca4238a0b923820dcc509a6f75849b'),
(1, 'Артем', 'Иванов', 'West street 16 - 22', '58379', '+105441231', 'ai@dg.com', '4921c0e2d1f6005abe1f9ec2e2041909'),
(13, 'wer', 'werr', 'ww', '155900', '13', 'dsf', '3049a1f0f1c808cdaa4fbed0e01649b1'),
(33, 'ARTEM', '', '', '', '', '3@3.com', 'eccbc87e4b5ce2fe28308fd9f2a7baf3'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `catalog`
--
ALTER TABLE `catalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
