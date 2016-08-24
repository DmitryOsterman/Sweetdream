CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `first_name` char(100) NOT NULL,
  `second_name` char(100) NOT NULL,
  `address` char(60) NOT NULL,
  `city` char(20) NOT NULL,
  `zip_code` char(10) NOT NULL,
  `phone` char(12) NOT NULL,
  `email` char(60) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `second_name`, `address`, `city`, `zip_code`, `phone`, `email`) VALUES
(1, 'Артем', 'Иванов', 'West street 16 - 22', 'Tokio', '58379' , '+105441231', 'ai@dg.com'),
(2, 'Nice', 'Wiki', 'Sun street 16 - 22', 'LA', '341379' , '+1134873331', 'nw@dg.com'),
(3, 'GETBND', 'DATAFILES', 'Moonlight st. 43', 'LA', '341379' , '+1034433331', 'gd@dg.com');


