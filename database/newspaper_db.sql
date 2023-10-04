-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2021 at 05:44 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newspaper_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `article_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `post_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `author` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `is_published` tinyint(1) NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `image_url` varchar(2083) NOT NULL,
  `views` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`article_id`, `title`, `post_datetime`, `author`, `body`, `is_published`, `category_id`, `user_id`, `image_url`, `views`) VALUES
(2, 'Best Website Ever!', '2020-12-23 18:13:23', 'Safal Sharma', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 3, 1, '', 9),
(4, 'Java Hello World Code', '2020-12-24 02:17:53', 'Safal Sharma', '\r\n<pre>\r\n<code>\r\npublic void main(String args[]){\r\n  System.out.println(\"Hello World!\");\r\n}\r\n</code>\r\n</pre>  \r\nCoding is easier than you think!', 1, 3, 1, '', 4),
(43, 'Classes Schedule', '2021-01-03 03:14:51', 'Safal Sharma', 'This is just a class routine...', 1, 1, 1, 'http://localhost/uploads/images/College schedule(4).png', 74),
(44, 'CES 2021 Is Over!', '2021-01-17 22:28:15', 'Safal Sharma', 'This article is about technology and so will find it in the technology category.\r\nHere are some texts to make it long:\r\n\r\nVivamus mattis consectetur consequat. Curabitur justo elit, finibus id risus ut, tincidunt dapibus augue. Vestibulum id congue ex. Nullam nec risus fringilla, convallis lorem id, varius libero. Maecenas a nunc id nisl tempor posuere ut eu nunc. Quisque sed commodo tellus. Nullam molestie nunc quis tempor sollicitudin. Curabitur id odio accumsan, pellentesque sem vitae, molestie ligula. Ut sit amet semper leo, sed congue tortor. Vivamus sodales nibh tristique consequat vestibulum. Nulla consectetur viverra ipsum, nec imperdiet quam tristique eu. Duis et tempus enim.\r\n\r\nIn in lorem sed nulla bibendum cursus eu sit amet erat. Aenean sit amet fermentum augue. Sed commodo eget dui eget vehicula. Vestibulum placerat, ipsum sed eleifend sagittis, eros eros imperdiet felis, scelerisque dignissim quam nisl nec neque. Vestibulum eget felis lacinia, posuere diam a, hendrerit nibh. Cras auctor rutrum tellus et consequat. Nulla condimentum auctor nunc, et sodales arcu convallis vel. Suspendisse tristique mauris quis sem fringilla cursus. Fusce auctor turpis mauris, nec lacinia felis aliquet sit amet. Nunc dui enim, malesuada a pulvinar a, tristique et lectus. Vivamus in pharetra justo. Sed a nisl a metus sodales pretium non at nisl. Vivamus quis diam non arcu pulvinar mollis. Sed sapien dolor, imperdiet sed ultrices sed, facilisis ac dolor. Aenean tincidunt, magna nec fringilla sollicitudin, lorem libero tempus ex, non euismod dolor dolor et quam.\r\n\r\nDonec sit amet cursus felis, mollis suscipit nisl. Fusce risus felis, eleifend eget leo nec, mollis viverra nulla. Sed dapibus dui sapien, a tincidunt massa commodo ultrices. Aliquam libero lacus, semper id erat sed, consequat mattis ex. Pellentesque lectus neque, luctus viverra metus non, mattis lobortis odio. Fusce erat est, tempor at nibh a, faucibus pharetra risus. Aenean convallis, lacus et interdum maximus, lorem neque varius justo, et vulputate augue erat a libero. Vestibulum ultricies vestibulum ullamcorper. Curabitur ut aliquam magna. Sed a ante malesuada, commodo lorem a, consequat sapien. Interdum et malesuada fames ac ante ipsum primis in faucibus. In tempus velit a arcu accumsan facilisis. Quisque tempor dictum ultricies.\r\n\r\nInteger dapibus, urna quis varius bibendum, ante lectus hendrerit lacus, a eleifend tellus lorem ac diam. In luctus mauris nec dolor tincidunt porttitor a a justo. Mauris varius volutpat dignissim. Duis arcu ipsum, maximus eu nisi sed, ultrices convallis erat. Donec a malesuada risus. Proin vulputate quis sem nec tincidunt. Nam pellentesque ex auctor nisi feugiat venenatis. Proin et fermentum lorem, sed laoreet tortor. Quisque consequat finibus egestas. Sed semper volutpat orci dignissim ornare. Nullam interdum purus mauris, eu dictum ex gravida sed. Integer volutpat eleifend diam, vel fermentum enim. Sed sit amet sollicitudin massa. Maecenas quis facilisis metus, a mollis lectus. Aenean nec eleifend enim.\r\n\r\nVivamus ultricies luctus ligula, nec dictum mi aliquam non. Nulla facilisi. In tempus finibus elementum. Vestibulum vitae luctus lorem, eget condimentum dolor. Pellentesque quis fermentum urna, vel fermentum orci. Donec a laoreet nibh. Ut tempor hendrerit ex eget maximus. Phasellus et quam at nisl convallis interdum in a massa.\r\n\r\nVestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus pretium bibendum lectus. Duis lacinia dolor neque, in tempus nibh cursus eu. Proin scelerisque finibus luctus. Nam rutrum lacus ac enim volutpat aliquet. Ut molestie eleifend orci sed dignissim. Etiam non viverra nulla, nec fermentum diam. Donec suscipit ullamcorper posuere. Morbi facilisis, eros vel consequat auctor, nulla urna porta urna, id varius arcu diam vitae massa.\r\n\r\nSuspendisse potenti. In vestibulum ipsum non porta tempus. Donec sed nulla a justo sollicitudin mattis at nec lectus. Nullam pulvinar vestibulum ullamcorper. Sed lectus diam, elementum ut tincidunt sit amet, tristique at velit. Curabitur commodo diam eget tincidunt finibus. Fusce euismod ante sed elit pharetra volutpat at in lacus. Cras hendrerit consequat pulvinar. Donec semper congue consequat. Aliquam eu diam sed libero congue feugiat et eu libero.\r\n\r\nOrci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean hendrerit cursus sapien eget pellentesque. Integer nibh lectus, aliquam quis rutrum sit amet, tincidunt a leo. Nulla sem odio, imperdiet nec mollis ac, dignissim et elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In quis nisl sit amet lorem ultrices blandit. Quisque feugiat ullamcorper lorem, ac finibus lacus. Morbi volutpat dui eu leo convallis, blandit ullamcorper augue scelerisque. In eleifend augue sed ligula pharetra, non fringilla diam varius. In rutrum, sem ac auctor ornare, risus ligula pharetra mi, eget hendrerit velit risus id quam.\r\n\r\nFusce eu efficitur sapien. Duis a varius est. Nunc ullamcorper suscipit velit nec iaculis. In hac habitasse platea dictumst. Fusce at diam ac massa porta pharetra eget nec felis. Nam ut magna dui. Aenean aliquam, lorem eu blandit auctor, nulla neque gravida risus, at laoreet massa lorem eget nibh. Nam sagittis ante sed finibus eleifend. Phasellus tincidunt ante neque, vel molestie urna vehicula quis. Nullam vestibulum nunc at volutpat molestie. Nunc rhoncus justo a tristique tempor. Fusce porta gravida dui, quis varius lacus facilisis eu. Aliquam id libero lobortis, pulvinar nulla in, porta nibh. Curabitur lorem massa, cursus id dictum id, pellentesque vitae est. Praesent aliquet aliquet quam, vel interdum nibh tincidunt at.\r\n\r\nAenean et orci elementum, sollicitudin urna sit amet, pretium nisl. Quisque bibendum dolor non felis facilisis dapibus. Aliquam maximus ipsum sed lectus auctor, eget faucibus augue convallis. Sed sollicitudin felis nec hendrerit posuere. Aliquam rutrum tincidunt enim in sollicitudin. Etiam et est nunc. Sed non est fermentum enim commodo sollicitudin. Etiam volutpat facilisis condimentum. In consectetur sem massa, ut lacinia arcu congue vehicula. Praesent tempus, elit id pellentesque condimentum, eros justo consequat magna, in condimentum eros sem nec nulla. Nam vulputate sodales semper. Aenean finibus elit quis neque accumsan, ut dignissim justo lobortis.', 1, 3, 1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(4, 'Business'),
(1, 'Local News'),
(13, 'Science'),
(2, 'Sport'),
(3, 'Technology');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) UNSIGNED NOT NULL,
  `comment_text` varchar(1024) NOT NULL,
  `post_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `article_id` int(11) UNSIGNED NOT NULL,
  `reply_to` int(11) UNSIGNED DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_text`, `post_datetime`, `is_approved`, `article_id`, `reply_to`, `user_id`) VALUES
(18, 'I love college!', '2021-01-14 02:27:21', 1, 43, NULL, 1),
(19, 'I hate morning classes', '2021-01-14 02:35:13', 1, 43, NULL, 24),
(21, 'Same here :(', '2021-01-14 02:39:40', 1, 43, 19, 24),
(22, 'What is the time for Web Development class?', '2021-01-17 17:59:02', 1, 43, NULL, 1),
(23, 'What is the time for Web Development class?', '2021-01-17 17:59:29', 0, 43, NULL, 24);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `username` varchar(65) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(65) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `name`, `email`, `is_admin`) VALUES
(1, 'safal', '$2y$10$ewCbXfBMsw5brbA92ew5suxuOk9oxg84DZ37YmGh.Ls8cBul01L16', 'Safal Sharma', 'safal.sharma.ss@gmail.com', 1),
(24, 'safalfrom2050', '$2y$10$pRY5KSVBifX.YLeLE4MfgekW8s8lHEQ4SMNBhfIUmlvs0Rk8l5nEG', 'Safal From 2050', 'safalfrom2050@gmail.com', 0),
(28, 'sasasa', '$2y$10$WVM8fWoQRtl5bvJgWT37Ju/INhj3kHQVhyZezcjISwlrhUaa2z5s.', 'Safal Sharma', 'safal.sharma19@my.northampton.ac.uk', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
