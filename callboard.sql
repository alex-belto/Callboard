-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Время создания: Ноя 03 2020 г., 09:58
-- Версия сервера: 5.7.26
-- Версия PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `callboard`
--

-- --------------------------------------------------------

--
-- Структура таблицы `advert`
--

CREATE TABLE `advert` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `issue` varchar(15) NOT NULL,
  `position` int(8) NOT NULL,
  `text` text NOT NULL,
  `contacts` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `advert`
--

INSERT INTO `advert` (`id`, `user_id`, `issue`, `position`, `text`, `contacts`) VALUES
(1, 1, '1', 1, 'Отдам в добрые руки: Кот, Барсик, белый, 2,5 года', '+325667848454'),
(2, 2, '2', 9, 'Найден кот, раён таврии, черный окрас, рыжие уши.', '+32234342414'),
(3, 5, '2', 3, 'Найден кот, черно-белый, бар \"Синий\"', '+3256745676747'),
(5, 12, '2', 6, 'Найден пёс, белый окрас, ухо черное, рынок\"Привоз\"', '+3234123428900'),
(8, 11, '1', 2, 'Отдам в добрые руки: Кошка, порода - сибирский, трехцветный, 2года,кличка Матильда.', '+3234123473027'),
(10, 17, '1', 5, 'В хорошие руки, Кот, перс, 3 года', '+3234127654321'),
(18, 12, '2', 7, 'Найден волнисты попугай, Правобережный парк, отдам при наличии фотографии или иных док-в!!!', '+3234123428900'),
(19, 12, '1', 10, 'Отдадим в добрые руки: Кот, 6 месяцев, черный, только с договором!', '+3234123428900');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `text`, `date`, `ad_id`, `user_id`) VALUES
(5, 'Заберу!', 1603991545, 8, 12),
(8, 'Скинь фотки', 1603991763, 8, 17),
(9, 'xcfgsdgds', 1603992441, 8, 17),
(10, 'Беру!', 1603993775, 19, 17),
(11, 'Документы? Прививки?', 1603994101, 19, 17),
(12, 'Когда можно посмотреть?', 1603999396, 5, 17),
(13, 'Мой, скорее всего, куда можно подъехать?', 1604065735, 18, 18),
(19, 'вфыа', 1604227341, 19, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(35) DEFAULT NULL,
  `phone_numb` varchar(20) DEFAULT NULL,
  `email` varchar(35) DEFAULT NULL,
  `login` varchar(32) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `block_time` int(11) DEFAULT NULL,
  `status` varchar(6) NOT NULL,
  `role` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `phone_numb`, `email`, `login`, `password`, `block_time`, `status`, `role`) VALUES
(1, 'Иванов Иван 12345', '+3234123423421', 'tyazhkorob.aleks@mail.ru', 'ivanov', '827ccb0eea8a706c4c34a16891f84e7b', 1603488125, 'active', 'user'),
(2, 'Александр Сергеевич', '+32234342414', 'tyazhkorob.aleks@mail.ru', 'alex', '$2y$10$J5qdN7mlB75KNrFn4kuKN.56gNb5YDYQb2Z72YlifXoRxFsrvNmXu', 1604163088, 'active', 'admin'),
(3, 'Михаил Иващук 54321', '+3234123473027', 'ivashchuk@mail.ru', 'michail', '01cfcd4f6b8770febfb40cb906715822', 0, 'active', 'user'),
(4, 'Алексей Мирнов', '+3234123424521', 'mirnov@mail.ru', 'mirnov', 'fa54c5cbc883650562785570be4aa7c4', 0, 'active', 'user'),
(5, 'guest', NULL, NULL, 'guest', '084e0343a0486ff05530df6c705c8bb4', 1603730487, 'active', 'guest'),
(10, 'Иванов Иван', '+3234123473027', 'ivashchuk@mail.ru', 'dsfasfas34', 'd2b555005448e1e218500318cc805e1c', 0, 'active', 'user'),
(11, 'Паша', '+3234123473027', 'pasha73@mail.ru', 'pasha', '$2y$10$J5qdN7mlB75KNrFn4kuKN.56gNb5YDYQb2Z72YlifXoRxFsrvNmXu', 0, 'active', 'user'),
(12, 'Добрыдин', '+3234123428900', 'dobridin@mail.tu', 'dobridin', '$2y$10$ffwEs8EIP.cPAfjCFe6yRORYPD0VR7TGzCDUcEpMVpiQ7wbssXyqq', 1604313730, 'active', 'moderator'),
(17, 'Мирнов Василий', '+3234127654321', 'vasiliy_mirnov@mail.ru', 'vasiliy321', '$2y$10$OGAEWVgCuc4oFxY33jHKxuNXNq/0sikgH4N2rrXziC7J5mhAn2Fqi', 0, 'active', 'user'),
(18, 'Иван Мойшев', '+3234123479933', 'moyshev@mail.ru', 'moysha', '$2y$10$Wkm3tDPyj890STnx9ttklu.HZNvjkqnENQim4ug/zIge.5hE8vNR6', 0, 'active', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `advert`
--
ALTER TABLE `advert`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `advert`
--
ALTER TABLE `advert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
