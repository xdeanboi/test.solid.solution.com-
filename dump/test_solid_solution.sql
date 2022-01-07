-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 07 2022 г., 15:03
-- Версия сервера: 5.7.29
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_solid_solution`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category_roots`
--

CREATE TABLE `category_roots` (
  `id_parent` int(10) NOT NULL,
  `id_child` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `roots`
--

CREATE TABLE `roots` (
  `id` int(10) NOT NULL,
  `name` char(4) NOT NULL DEFAULT 'root'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category_roots`
--
ALTER TABLE `category_roots`
  ADD PRIMARY KEY (`id_parent`,`id_child`),
  ADD KEY `id_child` (`id_child`);

--
-- Индексы таблицы `roots`
--
ALTER TABLE `roots`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `roots`
--
ALTER TABLE `roots`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `category_roots`
--
ALTER TABLE `category_roots`
  ADD CONSTRAINT `category_roots_ibfk_1` FOREIGN KEY (`id_parent`) REFERENCES `roots` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_roots_ibfk_2` FOREIGN KEY (`id_child`) REFERENCES `roots` (`id`) ON DELETE CASCADE,
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
