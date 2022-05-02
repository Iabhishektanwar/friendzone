-- Create database in phpmyadmin
CREATE DATABASE IF NOT EXISTS `friendzone` /*!40100 DEFAULT CHARACTER SET utf8mb4 */

-- Create users table in friendzone db
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(19) NOT NULL AUTO_INCREMENT,
  `userid` bigint(19) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `url_address` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_image` varchar(1000) NOT NULL DEFAULT '',
  `cover_image` varchar(1000) NOT NULL DEFAULT '',
  `likes` int(11) NOT NULL DEFAULT 0,
  `bio` varchar(1024) NOT NULL DEFAULT '',
  `work` varchar(500) NOT NULL DEFAULT '',
  `education` varchar(500) NOT NULL DEFAULT '',
  `hometown` varchar(500) NOT NULL DEFAULT '',
  `contact` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `first_name` (`first_name`),
  KEY `last_name` (`last_name`),
  KEY `email` (`email`),
  KEY `username` (`username`),
  KEY `url_address` (`url_address`),
  KEY `date` (`date`),
  KEY `likes` (`likes`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4

-- Create posts table in friendzone db
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(19) NOT NULL AUTO_INCREMENT,
  `postid` bigint(12) NOT NULL,
  `userid` bigint(19) NOT NULL,
  `post` text NOT NULL,
  `image` varchar(500) NOT NULL,
  `comments` int(11) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `has_image` tinyint(1) NOT NULL,
  `is_profile_image` tinyint(1) NOT NULL,
  `is_cover_image` tinyint(1) NOT NULL,
  `parent` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `postid` (`postid`),
  KEY `userid` (`userid`),
  KEY `comments` (`comments`),
  KEY `likes` (`likes`),
  KEY `date` (`date`),
  KEY `has_image` (`has_image`),
  KEY `is_profile_image` (`is_profile_image`),
  KEY `is_cover_image` (`is_cover_image`),
  KEY `parent` (`parent`),
  FULLTEXT KEY `post` (`post`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4

-- Create likes table in friendzone db
CREATE TABLE IF NOT EXISTS `likes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  `contentid` bigint(20) NOT NULL,
  `likes` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `contentid` (`contentid`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4