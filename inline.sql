-- Creating database

CREATE DATABASE IF NOT EXISTS `inline` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `inline`;

-- Creating tables

CREATE TABLE IF NOT EXISTS `comments` (
  `postId` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(127) NOT NULL,
  `email` varchar(63) NOT NULL,
  `body` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_FK` (`postId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `posts` (
  `userId` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(127) NOT NULL,
  `body` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Creating foreign keys

ALTER TABLE `comments`
  ADD CONSTRAINT `comments_FK` FOREIGN KEY (`postId`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
