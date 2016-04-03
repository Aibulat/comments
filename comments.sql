-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 02 2016 г., 21:42
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `aibulat`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `author` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `parent_id`, `author`, `value`, `created_at`) VALUES
(1, 0, 'Иван', 'Lorem ipsum dolor sit amet.', '2016-04-01 19:41:13'),
(2, 1, 'Алексей', 'Blanditiis praesentium voluptatum deleniti atque.', '2016-04-01 19:41:38'),
(3, 4, 'Евгений', 'Autem vel illum, qui blanditiis praesentium voluptatum deleniti atque corrupti.', '2016-04-01 19:42:04'),
(4, 0, 'Айбулат', ' Dolor repellendus cum soluta nobis.', '2016-04-01 19:42:18'),
(5, 2, 'Анастасия', 'Corporis suscipit laboriosam, nisi ut enim.', '2016-04-01 20:34:23'),
(6, 5, 'Елена', 'Debitis aut perferendis doloribus asperiores repellat. sint, obcaecati cupiditate non numquam eius.Itaque earum rerum facilis.', '2016-04-01 20:34:56'),
(7, 6, 'Мария', 'Similique sunt in ea commodi.', '2016-04-01 20:35:12'),
(8, 4, 'Александр', 'Dolor repellendus numquam eius modi.', '2016-04-02 18:28:27'),
(9, 5, 'Сергей', 'Quam nihil molestiae consequatur, vel illum, qui ratione voluptatem accusantium doloremque.', '2016-04-02 18:30:17');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
