-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 08 2015 г., 00:59
-- Версия сервера: 5.5.43-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `components`
--

CREATE TABLE IF NOT EXISTS `components` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `settings` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `components`
--

INSERT INTO `components` (`id`, `name`, `settings`) VALUES
(1, 'admin', '');

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `config` text NOT NULL,
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`config`, `id`) VALUES
('a:3:{s:3:"cms";a:6:{s:5:"langs";a:2:{s:2:"ru";a:3:{s:6:"locale";s:5:"ru_RU";s:4:"name";s:14:"Русский";s:6:"domain";s:22:"ru_language_1443378441";}s:2:"ua";a:3:{s:6:"locale";s:5:"uk_UA";s:4:"name";s:20:"Українська";s:6:"domain";s:22:"ua_language_1443378441";}}s:8:"def_lang";a:4:{s:2:"id";s:2:"ru";s:6:"locale";s:5:"ru_RU";s:4:"name";s:14:"Русский";s:6:"domain";s:8:"language";}s:8:"template";s:4:"lime";s:5:"debug";b:1;s:10:"log_errors";b:0;s:8:"base_url";s:9:"cms.local";}s:10:"components";a:2:{s:7:"default";s:5:"admin";s:9:"installed";a:3:{s:4:"page";a:3:{s:4:"name";s:5:"pages";s:10:"url_access";b:1;s:4:"path";s:23:"pages/controllers/pages";}s:6:"errors";a:3:{s:4:"name";s:6:"errors";s:4:"path";s:25:"errors/controllers/errors";s:10:"url_access";b:0;}s:5:"admin";a:3:{s:4:"name";s:5:"admin";s:4:"path";s:23:"admin/controllers/admin";s:10:"url_access";b:1;}}}s:5:"cache";a:2:{s:8:"lifetime";i:0;s:6:"driver";s:5:"files";}}', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `group_id`, `name`, `lastname`, `login`, `email`, `password`, `active`) VALUES
(1, 2, 'admin', 'admin', 'admin', 'admin@admin.com', '$1$t2cKzqz/$6gBjAvlqxAZWKJbmdLT420', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `user_groups`
--

INSERT INTO `user_groups` (`id`, `name`, `permissions`) VALUES
(1, 'Пользователь', ''),
(2, 'Администратор', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
