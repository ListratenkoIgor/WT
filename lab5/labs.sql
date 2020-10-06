-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Авг 03 2020 г., 18:22
-- Версия сервера: 8.0.20
-- Версия PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `labs`
--

-- --------------------------------------------------------

--
-- Структура таблицы `business_trips`
--

CREATE TABLE `business_trips` (
  `id_trip` int UNSIGNED NOT NULL,
  `id_worker` int NOT NULL,
  `city` varchar(20) NOT NULL,
  `date_departure` date NOT NULL,
  `date_arrival` date NOT NULL,
  `daily_salary` double(10,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `business_trips`
--

INSERT INTO `business_trips` (`id_trip`, `id_worker`, `city`, `date_departure`, `date_arrival`, `daily_salary`) VALUES
(1, 1, 'Moskow', '2020-04-27', '2020-04-30', 100.00),
(2, 2, 'Saint-Petersburg', '2020-04-16', '2020-04-22', 150.00),
(3, 3, 'Dublin', '2020-04-20', '2020-04-25', 300.00);

-- --------------------------------------------------------

--
-- Структура таблицы `personal_data`
--

CREATE TABLE `personal_data` (
  `id_worker` int NOT NULL,
  `date_birth` date NOT NULL,
  `address` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `personal_data`
--

INSERT INTO `personal_data` (`id_worker`, `date_birth`, `address`, `phone_number`) VALUES
(1, '1990-03-05', 'Minsk, Surganova 48, 19', '80179995566'),
(2, '1976-03-05', 'Minsk, Kolasa, 4, 16', '80179995567'),
(3, '1980-03-15', 'Minsk, Pushkina, 13, 2', '80179995561');

-- --------------------------------------------------------

--
-- Структура таблицы `positions`
--

CREATE TABLE `positions` (
  `id_position` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` int UNSIGNED NOT NULL,
  `salary` double(10,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `positions`
--

INSERT INTO `positions` (`id_position`, `name`, `category`, `salary`) VALUES
(1, 'engineer4', 4, 1200.00),
(2, 'engineer5', 5, 2500.00),
(3, 'electrician3', 3, 550.00),
(4, 'electrician5', 5, 700.00);

-- --------------------------------------------------------

--
-- Структура таблицы `workers`
--

CREATE TABLE `workers` (
  `id_worker` int NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `patronymic` varchar(20) NOT NULL,
  `id_position` int NOT NULL,
  `date_appointment` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `workers`
--

INSERT INTO `workers` (`id_worker`, `last_name`, `first_name`, `patronymic`, `id_position`, `date_appointment`) VALUES
(1, 'Petrov', 'Petr', 'Petrovich', 4, '2020-04-01'),
(2, 'Ivanov', 'Ivan', 'Ivanovich', 3, '2020-04-03'),
(3, 'Grek', 'Anton', 'Ivanovich', 4, '2020-04-08'),
(4, 'New', 'Test', 'New', 1, '2020-04-16');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `personal_data`
--
ALTER TABLE `personal_data`
  ADD PRIMARY KEY (`id_worker`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- Индексы таблицы `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id_position`);

--
-- Индексы таблицы `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id_worker`),
  ADD KEY `id_position` (`id_position`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `positions`
--
ALTER TABLE `positions`
  MODIFY `id_position` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `workers`
--
ALTER TABLE `workers`
  MODIFY `id_worker` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `personal_data`
--
ALTER TABLE `personal_data`
  ADD CONSTRAINT `personal_data_ibfk_1` FOREIGN KEY (`id_worker`) REFERENCES `workers` (`id_worker`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `workers`
--
ALTER TABLE `workers`
  ADD CONSTRAINT `workers_ibfk_1` FOREIGN KEY (`id_position`) REFERENCES `positions` (`id_position`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
