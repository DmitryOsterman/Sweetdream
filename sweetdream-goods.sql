--
-- База данных: `sweetdream`
-- пароль: `df9(s1`

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--


CREATE TABLE IF NOT EXISTS `goods` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`parent_id` INT(11) NOT NULL,
	`name` CHAR(250) NOT NULL,
	`price` CHAR(30) NOT NULL,
	`amount` CHAR(30) NOT NULL,	
	`link` CHAR(30) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`,`parent_id`, `name`, `price`, `amount`, `link`) 
VALUES
	(1,0,'Для детей',0,0,'#'),
	(2,1,'Пеленки',0,0,'#'),
	(3,2,'Пеленка розовая, для девочек, размер 1000х1500','700руб','3 шт.','#'),
	(4,0,'Постельное белье',0,0,'#'),
	(null,4,'Бязь',0,0,'#'),
	(null,4,'Поплин',0,0,'#'),
	(null,4,'Шелка',0,0,'#');
	
	
	
