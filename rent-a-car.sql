-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2021 at 12:03 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rent-a-car`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `role_id`) VALUES
(1, 'Admin', 'admin.support@gmail.com', '0000000000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`) VALUES
(1, 'AC'),
(2, 'Aston Martin'),
(3, 'Austin-Healey'),
(7, 'Chevrolet'),
(4, 'Ford'),
(5, 'Jaguar'),
(6, 'Lotus'),
(8, 'Pontiac');

-- --------------------------------------------------------

--
-- Table structure for table `brands_cars`
--

CREATE TABLE `brands_cars` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands_cars`
--

INSERT INTO `brands_cars` (`id`, `car_id`, `brand_id`) VALUES
(3, 19, 2),
(4, 20, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `picture` varchar(200) NOT NULL,
  `info` text NOT NULL,
  `price` int(11) NOT NULL DEFAULT 250,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `name`, `model`, `picture`, `info`, `price`, `stock`) VALUES
(19, 'Aston Martin', 'DB4', 'aston-martin-db4.jpg', 'Cool automobile', 250, 0),
(20, 'Aston Martin', 'DB5', 'aston-martin-db5.jpg', 'Cool automobile', 250, 0),
(21, 'Ac', 'Cobra427', 'ac-cobra427.jpg', 'It\'s a true Shelby that, when equipped with a proper Ford 427, delivers the performance expected of genuine American supercar. It can go from 0-60 MPH under four seconds and run a 12 second quarter mile in the hands of an experienced driver.', 250, 3);

-- --------------------------------------------------------

--
-- Table structure for table `cars_users`
--

CREATE TABLE `cars_users` (
  `car_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars_users`
--

INSERT INTO `cars_users` (`car_id`, `user_id`, `car_value`) VALUES
(19, 43, 0),
(20, 43, 0),
(21, 43, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rent_locations`
--

CREATE TABLE `rent_locations` (
  `id` int(11) NOT NULL,
  `pickup_location` varchar(150) NOT NULL,
  `pickup_date` date NOT NULL,
  `pickup_time` time NOT NULL,
  `return_location` varchar(150) NOT NULL,
  `return_date` date NOT NULL,
  `return_time` time NOT NULL,
  `car_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rent_locations`
--

INSERT INTO `rent_locations` (`id`, `pickup_location`, `pickup_date`, `pickup_time`, `return_location`, `return_date`, `return_time`, `car_id`, `user_id`) VALUES
(50, 'ZAGREB-CENTAR', '2021-02-24', '10:00:00', 'ZAGREB-ZRAČNA LUKA', '2021-02-26', '13:00:00', 21, 43),
(51, 'ZAGREB-CENTAR', '2021-02-25', '10:00:00', 'OSIJEK-ZRAČNA LUKA', '2021-02-28', '12:00:00', 21, 48);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `join_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `username`, `phone_number`, `join_time`, `role_id`) VALUES
(43, 'Josip', 'Mareljic', 'josip.josip10@gmail.com', '$2y$10$kzbMghpOGUSDPlpWmXRGLetXfQzGvLJ1SpIijVrYap06uGXrlcw6O', 'Marelja', '456755465', '2021-02-25 20:54:49', 2),
(44, 'Alberto', 'Cazini', 'albert.cazini@gmail.com', '$2y$10$kXRCUo4tfKEiAUNfMh7xquh8Y34BUYFjrsRbVT6ThgE7a2RQflvQK', 'Al berto nije', '3456545', '2021-02-22 22:30:41', 2),
(45, 'Tommy', 'Lister Jr.', 'tommy.lister@gmail.com', '$2y$10$hqtvHvH73800OuwgC8rLTuDBSU1Dq9BNhkJUEyLAsqXbnBxL4YrR6', 'Deebo', '45676545', '2021-02-22 22:47:54', 2),
(46, 'Oliver', 'Twist', 'oliver.twist@gmail.com', '$2y$10$V8YSLQzNG/kUJsobz40W8.CnUGNmcfbBFWhCJZqHljIhWgXnH98Iy', 'Twistie', '4567685654', '2021-02-24 22:17:18', 2),
(48, 'Mars', 'Mercury', 'mars.mercury@gmail.com', '$2y$10$CBxKNjgVGgH6MLZyIOXKeu6o/nes5NyTL8vEnorWhwNvXAmZ2L9tK', 'Freddie', '3546765', '2021-02-25 21:14:29', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `brands_cars`
--
ALTER TABLE `brands_cars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `car_id` (`car_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `cars_users`
--
ALTER TABLE `cars_users`
  ADD UNIQUE KEY `car_id` (`car_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rent_locations`
--
ALTER TABLE `rent_locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `brands_cars`
--
ALTER TABLE `brands_cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `rent_locations`
--
ALTER TABLE `rent_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `cars_users`
--
ALTER TABLE `cars_users`
  ADD CONSTRAINT `cars_users_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cars_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rent_locations`
--
ALTER TABLE `rent_locations`
  ADD CONSTRAINT `rent_locations_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
  ADD CONSTRAINT `rent_locations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
