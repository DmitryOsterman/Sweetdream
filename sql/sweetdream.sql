-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 13, 2016 at 02:34 PM
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
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `goods`
--

INSERT INTO `goods` (`id`, `parent_id`, `name`, `description`, `price`, `amount`, `link`, `img_link`) VALUES
(3, 2, 'Пеленка розовая', 'Пеленка розовая, для девочек, размер 1000х1500 mm', 700, '3', '#', '3-image.jpg'),
(9, 2, 'пеленки для курящих', '', 45.5, '4', '#', '9-image.jpg'),
(10, 6, 'поплин блин блин', '', 5555, '1', '#', 'c7b7902031512f5ac064e446596fdb8d.jpg'),
(14, 5, 'КПБ бязь бери не боязь', '', 2200, '4', '#', '14-image.jpg'),
(15, 5, 'БЕРИ а может и нет бязь', '', 220, '4', '#', ''),
(19, 2, 'КПБ ШУЯ', '', 777, '1', '#', '..\\img\\ScreenClip2.png'),
(25, 27, 'HART', '', 5, '6', '#', '25-image.jpg'),
(2, 2, 'Пеленка bluue, , размер 1000х1500 mm', '', 333, '3', '#', '0-image.jpg'),
(26, 2, 'шмаленки', '', 777, '7', '#', '26-image.jpg');

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
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `second_name`, `address`, `zip_code`, `phone`, `email`, `password`) VALUES
(30, '4-5', '', '', '', '', '4', 'a87ff679a2f3e71d9181a67b7542122c'),
(1, 'Артем', 'Иванов', 'West street 16 - 22', '58379', '+105441231', 'ai@dg.com', '4921c0e2d1f6005abe1f9ec2e2041909'),
(13, 'wer', 'werr', 'ww', '155900', '13', 'dsf', '3049a1f0f1c808cdaa4fbed0e01649b1'),
(29, 'Вася', '', '', '', '1', '1@1.com', 'c4ca4238a0b923820dcc509a6f75849b');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `catalog`
--
ALTER TABLE `catalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `upmenu`
--
ALTER TABLE `upmenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
