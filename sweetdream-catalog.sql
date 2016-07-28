CREATE TABLE `catalog` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` char(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `catalog`
--

INSERT INTO `catalog` (`id`, `parent_id`, `name`) VALUES
(1, 0, 'Полотенца'),
(2, 1, 'Полотенца махровые');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `catalog`
--
ALTER TABLE `catalog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);
