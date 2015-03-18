SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `platinum`
--

-- --------------------------------------------------------

--
-- Структура таблицы `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(24) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `leader` int(3) NOT NULL DEFAULT '0',
  `member` int(10) NOT NULL DEFAULT '0',
  `rank` int(3) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `date` varchar(15) NOT NULL DEFAULT '06/03/2014',
  `sex` int(1) NOT NULL,
  `skin` int(3) NOT NULL,
  `money` int(11) NOT NULL,
  `health` float NOT NULL DEFAULT '100',
  `lastlog` varchar(15) NOT NULL,
  `satiety` float NOT NULL DEFAULT '100',
  `level` int(11) NOT NULL DEFAULT '1',
  `exp` int(11) NOT NULL,
  `played` int(11) NOT NULL,
  `house` int(11) NOT NULL,
  `setup` varchar(30) NOT NULL DEFAULT '0|0',
  `biz` varchar(20) NOT NULL DEFAULT '0|0',
  `mobile` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `Cents` int(11) NOT NULL,
  `lang` int(11) NOT NULL,
  `Age` int(11) NOT NULL,
  `Scolor` int(11) NOT NULL,
  `admin` int(11) NOT NULL,
  `clock` int(11) NOT NULL,
  `map` int(11) NOT NULL,
  `gps` int(11) NOT NULL,
  `online` int(5) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `pass`, `mail`, `leader`, `member`, `rank`, `ip`, `date`, `sex`, `skin`, `money`, `health`, `lastlog`, `satiety`, `level`, `exp`, `played`, `house`, `setup`, `biz`, `mobile`, `number`, `Cents`, `lang`, `Age`, `Scolor`, `admin`, `clock`, `map`, `gps`, `online`) VALUES
(1, 'User_Test', '123456', 'user@mail.ru', 0, 0, 0, '127.0.0.1', '20/3/2014', 1, 8, 99862, 75, '30/3/2014', 23, 4, 0, 3221, 1, '1|0', '1|4', 3, 8129259, 0, 0, 0, 0, 1, 0, 0, 0, -1);

-- --------------------------------------------------------

--
-- Структура таблицы `platinum_email`
--

CREATE TABLE IF NOT EXISTS `platinum_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(24) NOT NULL,
  `oldEmail` varchar(64) NOT NULL,
  `newEmail` varchar(64) NOT NULL,
  `key` varchar(32) NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `platinum_login`
--

CREATE TABLE IF NOT EXISTS `platinum_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `key` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `platinum_menu`
--

CREATE TABLE IF NOT EXISTS `platinum_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `href` varchar(64) NOT NULL,
  `visible` int(1) NOT NULL,
  `type` int(1) NOT NULL,
  `priority` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `platinum_menu`
--

INSERT INTO `platinum_menu` (`id`, `title`, `href`, `visible`, `type`, `priority`) VALUES
(1, 'Главная', '/', 0, 0, 1),
(2, 'Панель администратора', '/admin/main/', 3, 0, 2),
(3, 'Личный кабинет', '/user/account/', 2, 1, 1),
(4, 'Личные сообщения', '/message/', 2, 1, 2),
(5, 'Выход из аккаунта', '/user/logout/', 2, 1, 5),
(6, 'Авторизация', '/user/login/', 1, 1, 3),
(7, 'Восстановление пароля', '/user/recovery/', 1, 1, 6),
(8, 'Регистрация', '/user/register/', 1, 1, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `platinum_message`
--

CREATE TABLE IF NOT EXISTS `platinum_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to` varchar(24) NOT NULL,
  `from` varchar(24) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(32) NOT NULL,
  `text` text NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `deleteTO` int(1) NOT NULL DEFAULT '0',
  `deleteFROM` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `platinum_news`
--

CREATE TABLE IF NOT EXISTS `platinum_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(24) NOT NULL,
  `title` varchar(128) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `platinum_recovery`
--

CREATE TABLE IF NOT EXISTS `platinum_recovery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(24) NOT NULL,
  `email` varchar(64) NOT NULL,
  `key` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `platinum_users`
--

CREATE TABLE IF NOT EXISTS `platinum_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(24) NOT NULL,
  `settings` varchar(128) NOT NULL,
  `userbar` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `platinum_users`
--

INSERT INTO `platinum_users` (`id`, `Name`, `settings`, `userbar`) VALUES
(1, 'User_Test', '%7B%22message%22%3Atrue%2C%22profile%22%3Atrue%2C%22userbar%22%3Atrue%7D', '%7B%22image%22%3A%22ubar.png%22%2C%22data%22%3A%5B%7B%22pos_top%22%3A%22-5%22%2C%22pos_left%22%3A%22129.625%22%2C%22name%22%3A%22Level%22%2C%22fontSize%22%3A%2226%22%2C%22color%22%3A%22rgb%28214%2C+0%2C+0%29%22%7D%2C%7B%22pos_top%22%3A%22153%22%2C%22pos_left%22%3A%2238.625%22%2C%22name%22%3A%22Money%22%2C%22fontSize%22%3A%2229%22%2C%22color%22%3A%22rgb%28255%2C+255%2C+255%29%22%7D%2C%7B%22pos_top%22%3A%22109%22%2C%22pos_left%22%3A%220.625%22%2C%22name%22%3A%22Online%22%2C%22fontSize%22%3A%2220%22%2C%22color%22%3A%22rgb%2849%2C+172%2C+21%29%22%7D%2C%7B%22pos_top%22%3A%2285%22%2C%22pos_left%22%3A%220.625%22%2C%22name%22%3A%22Member%22%2C%22fontSize%22%3A%2216%22%2C%22color%22%3A%22rgb%2867%2C+67%2C+67%29%22%7D%2C%7B%22pos_top%22%3A%22126%22%2C%22pos_left%22%3A%22255.375%22%2C%22name%22%3A%22Skin%22%2C%22fontSize%22%3A%2226%22%2C%22color%22%3A%22rgb%28214%2C+0%2C+0%29%22%7D%5D%7D');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
