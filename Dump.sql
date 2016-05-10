-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.29 - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных yii2advanced
CREATE DATABASE IF NOT EXISTS `yii2advanced` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `yii2advanced`;


-- Дамп структуры для таблица yii2advanced.adress
CREATE TABLE IF NOT EXISTS `adress` (
  `AdressId` int(11) NOT NULL DEFAULT '0',
  `Street` text,
  `Litera` text,
  `Number` int(11) DEFAULT NULL,
  PRIMARY KEY (`AdressId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2advanced.adress: ~4 rows (приблизительно)
DELETE FROM `adress`;
/*!40000 ALTER TABLE `adress` DISABLE KEYS */;
INSERT INTO `adress` (`AdressId`, `Street`, `Litera`, `Number`) VALUES
	(1, 'ул. Куйбышева', '', NULL),
	(2, 'ул. Ленинская', '', 142),
	(3, ' ул. Алексея Толстого', '', 19),
	(4, 'ул. Фрунзе', '', 2);
/*!40000 ALTER TABLE `adress` ENABLE KEYS */;


-- Дамп структуры для таблица yii2advanced.contact
CREATE TABLE IF NOT EXISTS `contact` (
  `ContactId` int(11) NOT NULL,
  `phone` text,
  `site` text,
  `WorkTime` text,
  PRIMARY KEY (`ContactId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2advanced.contact: ~2 rows (приблизительно)
DELETE FROM `contact`;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` (`ContactId`, `phone`, `site`, `WorkTime`) VALUES
	(1, '+7 (846) 333-64-23', 'http://www.alabin.ru/', ''),
	(2, '+7 (846) 244-08-94', 'http://galchonok.my1.ru/', '');
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;


-- Дамп структуры для таблица yii2advanced.sight
CREATE TABLE IF NOT EXISTS `sight` (
  `SightId` int(11) NOT NULL DEFAULT '0',
  `Sightname` varchar(150) NOT NULL,
  `descriptions` varchar(250) DEFAULT NULL,
  `SightTypeId` int(11) DEFAULT NULL,
  `AdressId` int(11) DEFAULT NULL,
  `ContactId` int(11) DEFAULT NULL,
  `SightX` double NOT NULL,
  `SightY` double NOT NULL,
  PRIMARY KEY (`SightId`),
  KEY `SightTypeId` (`SightTypeId`),
  KEY `AdressId` (`AdressId`),
  KEY `ContactId` (`ContactId`),
  CONSTRAINT `sight_ibfk_1` FOREIGN KEY (`SightTypeId`) REFERENCES `sighttype` (`SightTypeId`),
  CONSTRAINT `sight_ibfk_2` FOREIGN KEY (`AdressId`) REFERENCES `adress` (`AdressId`),
  CONSTRAINT `sight_ibfk_3` FOREIGN KEY (`ContactId`) REFERENCES `contact` (`ContactId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2advanced.sight: ~4 rows (приблизительно)
DELETE FROM `sight`;
/*!40000 ALTER TABLE `sight` DISABLE KEYS */;
INSERT INTO `sight` (`SightId`, `Sightname`, `descriptions`, `SightTypeId`, `AdressId`, `ContactId`, `SightX`, `SightY`) VALUES
	(1, 'Памятник Валериану Куйбышеву', 'Бронзовая скульптура Валериана Владимировича Куйбышева высотой в 7 метров на возвышении из гранита высотой в 5 метров', 1, 1, NULL, 50.1021014, 53.195469),
	(2, 'Памятник Ленину', 'Скульптура Ленина на площади Революции, установленная 7 ноября 1927. На её же постаменте до революции стоял памятник Александру II', 1, 1, NULL, 50.0876, 53.1856),
	(3, 'Музей Алабина', 'Самарский областной историко-краевед музейчик — один из старейших музеев Поволжья, расположенный в Самаре', 2, 2, 1, 50.1091, 53.1927),
	(4, 'Гостиница "Галчонок"', '', 3, 4, 2, 50.0854, 53.179);
/*!40000 ALTER TABLE `sight` ENABLE KEYS */;


-- Дамп структуры для таблица yii2advanced.sighttype
CREATE TABLE IF NOT EXISTS `sighttype` (
  `SightTypeId` int(11) NOT NULL DEFAULT '0',
  `TypeName` varchar(450) DEFAULT NULL,
  PRIMARY KEY (`SightTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2advanced.sighttype: ~3 rows (приблизительно)
DELETE FROM `sighttype`;
/*!40000 ALTER TABLE `sighttype` DISABLE KEYS */;
INSERT INTO `sighttype` (`SightTypeId`, `TypeName`) VALUES
	(1, 'Памятник'),
	(2, 'Музей'),
	(3, 'Гостиница');
/*!40000 ALTER TABLE `sighttype` ENABLE KEYS */;


-- Дамп структуры для таблица yii2advanced.users
CREATE TABLE IF NOT EXISTS `users` (
  `UserId` int(11) NOT NULL DEFAULT '0',
  `username` varchar(450) DEFAULT NULL,
  `password1` text,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2advanced.users: ~1 rows (приблизительно)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`UserId`, `username`, `password1`) VALUES
	(1, 'admin', 'admin');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
