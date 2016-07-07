--
-- База данных: `sweetdream`
-- пароль: `df9(s1`

-- --------------------------------------------------------

--
-- Структура таблицы `upmenu`
--


CREATE TABLE IF NOT EXISTS `upmenu` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` CHAR(30) NOT NULL,
	`link` CHAR(30) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `upmenu`
--

INSERT INTO `upmenu` (`id`, `name`, `link`) 
VALUES
	(1, 'О нас', '#'),
	(2, 'Доставка', '#'),
	(3, 'Оптовикам', '#'),
	(4, 'Статьи', '#'),
	(5, 'Контакты', '#');
