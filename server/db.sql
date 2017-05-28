-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logtype` int(1) NOT NULL,
  `date` varchar(64) NOT NULL,
  `data` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `logs` (`id`, `logtype`, `date`, `data`) VALUES
(1,	0,	'24.05 12:16',	'1'),
(2,	0,	'24.05 12:21',	'0'),
(3,	1,	'24.05 12:16',	'25.3'),
(4,	1,	'24.05 12:21',	'26.7'),
(6,	2,	'24.05 12:16',	'15.4'),
(7,	2,	'24.05 12:21',	'14.2'),
(9,	3,	'24.05 12:16',	'60'),
(10,	3,	'24.05 12:21',	'78'),
(12,	4,	'24.05 12:16',	'40'),
(13,	4,	'24.05 12:21',	'37'),
(15,	5,	'24.05 12:16',	'5000'),
(16,	5,	'24.05 12:21',	'4396');

-- 2017-05-24 06:45:27