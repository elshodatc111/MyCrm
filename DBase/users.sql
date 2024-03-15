-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 15 2024 г., 13:23
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `laravel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filial` varchar(11) NOT NULL,
  `name` varchar(70) NOT NULL,
  `address` varchar(70) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `tkun` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `filial`, `name`, `address`, `phone`, `tkun`, `type`, `status`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'NULL', 'Elshod Musurmonov', 'Qarshi shaxar', '998908830450', '02.01.1997', 'SuperAdmin', 'status', 'elshodatc1116', '$2y$12$sfcL3rWOc6iO43EROp580uR.0.ZqpiRgHFz4HaZSVZ3coPu.X3Zau', '2024-03-15 13:49:40', '2024-03-15 13:49:40'),
(2, '1', 'Dilshod Xolmurodov', 'Qarshi shaxar', '90 883 0450', '1997-02-02', 'Techer', 'true', 'Qarshi shaxar', '$2y$12$WYAsRECs9oYRvq2S4LtnZO10XdrX3UjJB/CFJGyO9KUhBbVIk.1NW', '2024-03-15 13:52:57', '2024-03-15 13:52:57'),
(3, '1', 'Elshod Musurmonov', 'G\'uzor Tumani', '90 883 0450', '1997-02-01', 'user', 'true', '1710504513', '$2y$12$PcylwR9BNzjqmSNfvdXJAupP.laZ6ZGQaV.nkWuIhiTgskTV4cQYW', '2024-03-15 14:08:32', '2024-03-15 14:08:32'),
(4, '1', 'Dilshod Xolmurodov', 'Dexqonobod Tumani', '94 520 4004', '1994-09-15', 'user', 'true', '1710504632', '$2y$12$OfWhjqgjXLswMiXNbReF/.ZWHER3yg9AgWg.MacawvzG/F/3cpsBu', '2024-03-15 14:10:31', '2024-03-15 14:10:31'),
(5, '1', 'Dilshod Xolmurodov2', 'Kasbi Tumani', '94 520 4009', '1994-09-15', 'user', 'true', '1710504677', '$2y$12$8xG4I7JAS3HicmBfZKrfIeO/i6YeRFQ8yyJrOqKGpCBbjmJ0r0WJi', '2024-03-15 14:11:16', '2024-03-15 14:11:16'),
(6, '1', 'Dilshod Xolmurodov 3', 'Ko\'kdala Tumani', '90 883 0451', '1999-01-01', 'user', 'true', '1710504802', '$2y$12$zOo7jyFjLrTEen4I2jDMfeiYgE7PB8hL9avWolNLLAOUK4MIgZPS6', '2024-03-15 14:13:21', '2024-03-15 14:13:21'),
(7, '2', 'Alimov Salim', 'Qarshi shaxar', '90 883 0450', '1999-01-01', 'Operator', 'true', '12345678', '$2y$12$ombJJ.tbW3KrIiGurXhsx.rdMQKSWMMhJt4GusqrkLP61vo.eF5Ie', '2024-03-15 14:14:26', '2024-03-15 14:14:26'),
(8, '2', 'Salimov Techer', 'Test Address', '90 883 0450', '1999-01-01', 'Techer', 'true', 'Techer01', '$2y$12$jvTS3kv6ON7H1tZxj21z.eZ5R9PPopCfVUc9I3xHWbdqiQBqmVd1O', '2024-03-15 14:16:33', '2024-03-15 14:16:33'),
(9, '2', 'Elshod Musurmonov', 'Koson Tumani', '90 883 0450', '1999-01-01', 'user', 'true', '1710505103', '$2y$12$5q8tPNKywV5IClmB8mZINuFs3OKG9RGLJNwxnu.V669/XI1VnnkJS', '2024-03-15 14:18:22', '2024-03-15 14:18:22'),
(10, '2', 'Maxmudov Maxmud', 'G\'uzor Tumani', '94 520 4004', '1999-01-01', 'user', 'true', '1710505131', '$2y$12$.0AKxHdHJE4QdkEcXmFS3uYQWWGw1PMis06GiNu5H/dreQW/WsdcO', '2024-03-15 14:18:50', '2024-03-15 14:18:50');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
