-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2023 at 09:55 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
                              `id` int(11) NOT NULL,
                              `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
                                            (1, 'Electronice'),
                                            (2, 'Masini'),
                                            (3, 'Articole sportive'),
                                            (4, 'Nutritie');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
                            `id` int(11) NOT NULL,
                            `name` varchar(255) NOT NULL,
                            `category_id` int(11) NOT NULL,
                            `description` varchar(255) NOT NULL,
                            `price` int(128) NOT NULL,
                            `image_id` int(11) NOT NULL,
                            `image_url` varchar(255) NOT NULL,
                            `stock` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `description`, `price`, `image_id`, `image_url`, `stock`) VALUES
                                                                                                                   (1, 'Mercedes cls 63 amg', 2, 'O masina blanabomba', 60000, 0, 'images/cls63amg.jpg', '2'),
                                                                                                                   (2, 'Iphone 4 s', 1, 'Un telefon vechi dar bun', 100, 0, 'images/iphone 4s.jpg', '6'),
                                                                                                                   (3, 'Gantera reglabila', 3, 'Sa faci bratu mare', 500, 0, 'images/gantera reglabila.jpg', '1'),
                                                                                                                   (4, 'Valori nutritie', 4, 'Sa faci bratu mare', 200, 0, 'images/nutritie.jpg', '1'),
                                                                                                                   (5, 'hjgj', 1, 'adsada', 22, 0, '', '1'),
                                                                                                                   (6, '231312', 2, 'sdda', 111, 0, '', '11');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
                           `id` int(11) NOT NULL,
                           `product_id` int(11) NOT NULL,
                           `nume` varchar(255) NOT NULL,
                           `review` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `nume`, `review`) VALUES
    (1, 1, '', 'Imi place ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
                         `id` int(11) NOT NULL,
                         `role` varchar(255) NOT NULL,
                         `name` varchar(128) NOT NULL,
                         `email` varchar(255) NOT NULL,
                         `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `password_hash`) VALUES
                                                                         (7, 'customer', 'hjgj', 'eduard.vintila123@gmail.com', '$2y$10$ZKg7LfymTL9tEYaXBzYg8uyiyNgFFRlxvwaIiBuZwbJfRCHI9PYfG'),
                                                                         (8, 'seller', '231312', 'donedwardo123@gmail.com', '$2y$10$6tJA/jLJLu.JpAZsnLswMO9UHgq/ZsbII.Gaf0fAolXcaB9kLyAKi'),
                                                                         (9, 'seller', 'hjgj', 'robinlister67@yahoo.com', '$2y$10$hGj0ms1GhXpg4qq8CWSLGufBJM4k7s2.UWvQtPZl55mk1F7UcfMxK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
    ADD KEY `idx_categories_id` (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
    ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
    ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
    ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
