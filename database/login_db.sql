-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.24-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for login_db
CREATE DATABASE IF NOT EXISTS `login_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `login_db`;

-- Dumping structure for table login_db.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  KEY `idx_categories_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table login_db.categories: ~4 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`) VALUES
	(1, 'Electronice'),
	(2, 'Masini'),
	(3, 'Articole sportive'),
	(4, 'Nutritie');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Dumping structure for table login_db.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `card_number` varchar(155) NOT NULL,
  `expiration_date` varchar(155) NOT NULL,
  `cvv` varchar(155) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table login_db.orders: ~3 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `name`, `email`, `card_number`, `expiration_date`, `cvv`) VALUES
	(1, 'hjgj', 'eduard.vintila123@gmail.com', '1234567891111111', '02/26', '690'),
	(2, 'hjgj', 'eduard.vintila123@gmail.com', '1234567891111111', '02/27', '243'),
	(3, 'hjgj', 'donedwardo123@gmail.com', '1234567891111111', '11/29', '257'),
	(4, 'ioan', 'ioan.andrei97@gmail.com', '4916182120057394', '12/25', '123'),
	(5, 'ioan', 'ioan@gmail.com', '1111111111111111', '12/25', '123'),
	(6, 'andi', 'a@gmai.com', '1111111111111111', '12/25', '123'),
	(7, 'andi', 'a@gmai.com', '1111111111111111', '12/25', '123'),
	(8, 'andi', 'a@gmai.com', '1111111111111111', '12/25', '123'),
	(9, 'andi', 'a@gmai.com', '1111111111111111', '12/25', '123'),
	(10, 'andi', 'a@gmai.com', '1111111111111111', '12/25', '123'),
	(11, 'andi', 'a@gmai.com', '1111111111111111', '12/25', '123'),
	(12, '$_SESSION[\'cart\']', 'qqq@gmail.com', '1111111111111111', '12/25', '123'),
	(13, '$_SESSION[\'cart\']', 'qqq@gmail.com', '1111111111111111', '12/25', '123'),
	(14, 'eqweqweqw', 'qewqeqw@gmail.com', '1111111111111111', '12/25', '123');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table login_db.order_products
CREATE TABLE IF NOT EXISTS `order_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table login_db.order_products: ~0 rows (approximately)
/*!40000 ALTER TABLE `order_products` DISABLE KEYS */;
INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`) VALUES
	(1, 1, 2, 3, 100),
	(2, 13, 2, 1, 100),
	(3, 13, 2, 1, 100),
	(4, 14, 2, 1, 100),
	(5, 14, 2, 1, 100);
/*!40000 ALTER TABLE `order_products` ENABLE KEYS */;

-- Dumping structure for table login_db.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` int(128) NOT NULL,
  `image_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `stock` varchar(128) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category` (`category_id`),
  CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table login_db.products: ~10 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `category_id`, `description`, `price`, `image_id`, `image_url`, `stock`, `user_id`) VALUES
	(1, 'Mercedes cls 63 amg', 2, 'O masina blanabomba', 60000, 0, 'images/cls63amg.jpg', '2', NULL),
	(2, 'Iphone 4 s', 1, 'Un telefon vechi dar bun', 100, 0, 'images/iphone 4s.jpg', '6', NULL),
	(3, 'Gantera reglabila', 3, 'Sa faci bratu mare', 500, 0, 'images/gantera reglabila.jpg', '1', NULL),
	(4, 'Valori nutritie', 4, 'Sa faci bratu mare', 200, 0, 'images/nutritie.jpg', '1', NULL),
	(5, 'hjgj', 1, 'adsada', 22, 0, '', '1', NULL),
	(6, '231312', 2, 'sdda', 111, 0, '', '11', NULL),
	(7, 'bmw m4', 2, 'Rupe tata', 50000, 0, 'images/bmw.jpg', '3', NULL),
	(8, 'Range Rover', 2, 'Mafia Car', 45000, 0, 'images/evoque.jpg', '1', NULL),
	(9, 'A 12', 1, 'Telefon bun', 200, 0, 'images/samsung.jpg', '15', NULL),
	(10, 'my product', 1, 'eqwewqeqweqw', 100, 0, '', '10', 10);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table login_db.reviews
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `nume` varchar(255) NOT NULL,
  `review` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product` (`product_id`),
  CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table login_db.reviews: ~0 rows (approximately)
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` (`id`, `product_id`, `nume`, `review`) VALUES
	(1, 1, '', 'Imi place ');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;

-- Dumping structure for table login_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table login_db.users: ~4 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `role`, `name`, `email`, `password_hash`) VALUES
	(7, 'customer', 'hjgj', 'eduard.vintila123@gmail.com', '$2y$10$ZKg7LfymTL9tEYaXBzYg8uyiyNgFFRlxvwaIiBuZwbJfRCHI9PYfG'),
	(8, 'seller', '231312', 'donedwardo123@gmail.com', '$2y$10$6tJA/jLJLu.JpAZsnLswMO9UHgq/ZsbII.Gaf0fAolXcaB9kLyAKi'),
	(9, 'seller', 'hjgj', 'robinlister67@yahoo.com', '$2y$10$hGj0ms1GhXpg4qq8CWSLGufBJM4k7s2.UWvQtPZl55mk1F7UcfMxK'),
	(10, 'seller', 'andrei', 'ioan.andrei97@gmail.com', '$2y$10$tynvblKhRaBQFTgxAxTTW./iELF3UfimC6FBUyoGzHehCZsKCu57W');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
