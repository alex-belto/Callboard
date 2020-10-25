-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 25, 2020 at 05:40 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `callboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `advert`
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
-- Dumping data for table `advert`
--

INSERT INTO `advert` (`id`, `user_id`, `issue`, `position`, `text`, `contacts`) VALUES
(1, 1, '1', 3, 'Отдам в добрые руки: Кот, Барсик, белый, 2,5 года', '+325667848454'),
(2, 2, '2', 2, 'Найден кот, раён таврии, черный окрс, рыжие уши.', '+32234342414'),
(3, 5, '2', 8, 'Найден кот, черно-белый, бар \"Синий\"', '+3256745676747'),
(5, 12, '2', 4, 'Найден пёс, белый окрас, ухо черное, рынок\"Привоз\"', '+3234123428900'),
(7, 12, '1', 6, 'Отдам в добрые руки: Немецкая овчарка,  черного окраса, приблизительный возраст 3 года, кличка Bil.', '+3234123428900'),
(8, 11, '1', 7, 'Отдам в добрые руки: Кошка, порода - сибирский, трехцветный, 2года,кличка Матильда.', '+3234123473027'),
(10, 17, '1', 1, 'В хорошие руки, Кот, перс, 3 года', '+3234127654321'),
(17, 17, '2', 5, 'gfsdgdfgds', '+3234127654321');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(35) DEFAULT NULL,
  `phone_numb` varchar(20) DEFAULT NULL,
  `email` varchar(35) DEFAULT NULL,
  `login` varchar(32) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `block_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone_numb`, `email`, `login`, `password`, `block_time`) VALUES
(1, 'Иванов Иван 12345', '+3234123423421', 'tyazhkorob.aleks@mail.ru', 'ivanov', '827ccb0eea8a706c4c34a16891f84e7b', 1603488125),
(2, 'Александр Александрович rewq', '+32234342414', 'tyazhkorob.aleks@mail.ru', 'alex', 'ca092c71d6be4e9dd735fbceb0890093', 0),
(3, 'Михаил Иващук 54321', '+3234123473027', 'ivashchuk@mail.ru', 'michail', '01cfcd4f6b8770febfb40cb906715822', 0),
(4, 'Алексей Мирнов', '+3234123424521', 'mirnov@mail.ru', 'mirnov', 'fa54c5cbc883650562785570be4aa7c4', 0),
(5, 'guest', NULL, NULL, 'guest', '084e0343a0486ff05530df6c705c8bb4', 1603730487),
(10, 'Иванов Иван', '+3234123473027', 'ivashchuk@mail.ru', 'dsfasfas34', 'd2b555005448e1e218500318cc805e1c', 0),
(11, 'Паша', '+3234123473027', 'pasha73@mail.ru', 'pasha', '$2y$10$J5qdN7mlB75KNrFn4kuKN.56gNb5YDYQb2Z72YlifXoRxFsrvNmXu', 1603729545),
(12, 'Добрыдин', '+3234123428900', 'dobridin@mail.tu', 'dobridin', '$2y$10$ffwEs8EIP.cPAfjCFe6yRORYPD0VR7TGzCDUcEpMVpiQ7wbssXyqq', 1603728937),
(17, 'Мирнов Василий', '+3234127654321', 'vasiliy_mirnov@mail.ru', 'vasiliy321', '$2y$10$OGAEWVgCuc4oFxY33jHKxuNXNq/0sikgH4N2rrXziC7J5mhAn2Fqi', 1603728026);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advert`
--
ALTER TABLE `advert`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advert`
--
ALTER TABLE `advert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
