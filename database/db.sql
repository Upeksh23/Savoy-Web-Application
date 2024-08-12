booking_seatfeedbackmovie_castsmoviesfeedback-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.28-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.7.0.6850
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for savoy_cinema
CREATE DATABASE IF NOT EXISTS `savoy_cinema` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `savoy_cinema`;

-- Dumping structure for table savoy_cinema.booking
CREATE TABLE IF NOT EXISTS `booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moive_id` int(11) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `parking_slots` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_booking_movies` (`moive_id`),
  KEY `FK_booking_users` (`users_id`),
  CONSTRAINT `FK_booking_movies` FOREIGN KEY (`moive_id`) REFERENCES `movies` (`id`),
  CONSTRAINT `FK_booking_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table savoy_cinema.booking: ~3 rows (approximately)
INSERT INTO `booking` (`id`, `moive_id`, `date`, `time`, `parking_slots`, `users_id`, `booking_date`) VALUES
	(30, 38, '28', '08:30 PM', 0, 8, '2024-06-25'),
	(31, 43, '1', '04:00 PM', 0, 8, '2024-06-25'),
	(32, 43, '1', '04:00 PM', 1, 8, '2024-06-25');

-- Dumping structure for table savoy_cinema.booking_seat
CREATE TABLE IF NOT EXISTS `booking_seat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) DEFAULT NULL,
  `seat_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_booking_seat_booking` (`booking_id`),
  KEY `FK_booking_seat_seat` (`seat_id`),
  CONSTRAINT `FK_booking_seat_booking` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`id`),
  CONSTRAINT `FK_booking_seat_seat` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table savoy_cinema.booking_seat: ~3 rows (approximately)
INSERT INTO `booking_seat` (`id`, `booking_id`, `seat_id`) VALUES
	(47, 30, 18),
	(48, 31, 27),
	(49, 32, 32);

-- Dumping structure for table savoy_cinema.feedback
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `feedback` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table savoy_cinema.feedback: ~2 rows (approximately)
INSERT INTO `feedback` (`id`, `user_id`, `name`, `feedback`, `created_at`) VALUES
	(13, 8, 'Sanuka Thamendra', 'Using a phone number instead of a user name while logging in is a difficult task. That is, it takes some time to enter, and sometimes the phone number is not remembered.', '2024-06-23 13:58:37'),
	(14, 9, 'Avishka Senarath', 'Only one email address is allowed to be used at a time, and if we forget the password or phone number and create a new account, we must have a new email address.\r\n', '2024-06-23 14:11:15'),
	(15, 10, 'Megana', 'Accessing the system using the phone number will be quite a difficult process.', '2024-06-23 14:52:41');

-- Dumping structure for table savoy_cinema.movies
CREATE TABLE IF NOT EXISTS `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movieName` varchar(255) DEFAULT NULL,
  `movieImage` varchar(255) DEFAULT NULL,
  `movieDescription` text DEFAULT NULL,
  `movieLanguage` varchar(250) DEFAULT NULL,
  `showingDate` date DEFAULT NULL,
  `endingDate` date DEFAULT NULL,
  `showingTime1` varchar(50) DEFAULT NULL,
  `showingTime2` varchar(50) DEFAULT NULL,
  `showingTime3` varchar(50) DEFAULT NULL,
  `dimension` varchar(10) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `rating` varchar(10) DEFAULT NULL,
  `trailerLink` varchar(255) DEFAULT NULL,
  `releaseDate` date DEFAULT NULL,
  `status` enum('now_showing','upcoming') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table savoy_cinema.movies: ~8 rows (approximately)
INSERT INTO `movies` (`id`, `movieName`, `movieImage`, `movieDescription`, `movieLanguage`, `showingDate`, `endingDate`, `showingTime1`, `showingTime2`, `showingTime3`, `dimension`, `genre`, `rating`, `trailerLink`, `releaseDate`, `status`) VALUES
	(27, 'Deadpool & Wolverine', 'uploads/Deadpool 3.jpg', 'Wolverine is recovering from his injuries when he crosses paths with the loudmouth, Deadpool. They team up to defeat a common enemy.', 'English', '2024-07-26', '2024-07-31', '16:30:00', '21:00:00', '10:00:00', '3D', 'Action', 'PG', 'https://youtu.be/uJMCNJP2ipI', '2024-07-26', 'upcoming'),
	(31, 'Indian 2', 'uploads/Indian 2.jpg', 'Indian 2 is an upcoming Indian Tamil-language vigilante action film directed by S. Shankar, who wrote the screenplay with B. Jeyamohan, Kabilan Vairamuthu, and Lakshmi Saravana Kumar. The film is jointly produced by Lyca Productions and Red Giant Movies. The sequel to Indian (1996), Kamal Haasan reprises his role as Senapathy, an ageing freedom fighter turned vigilante who fights against corruption, with Siddharth, S. J. Suryah, Rakul Preet Singh, Bobby Simha, Vivek, Priya Bhavani Shankar, Gulshan Grover, Samuthirakani and Nedumudi Venu in the ensemble cast.', 'Tamil', '2024-07-12', '2024-07-25', '10:00:00', '16:00:00', '00:00:00', '2D', 'Action', 'G - Genera', 'https://youtu.be/kqGj31bQQQ0', '2024-07-12', 'upcoming'),
	(35, 'Khufiya', 'uploads/Khufiya.jpg', 'Krishna Mehra is an operative at Indian spy agency known as R&AW. She is assigned to track down the mole selling India\\\'s defense secrets, while all along grappling with her dual identity as a spy and a lover.', 'Hindi', '2024-10-15', '2024-12-22', '10:30 AM', '04:00 PM', '09:30 PM', '2D', 'Thriller', 'G - Genera', 'https://youtu.be/ByojhBwG_-E?si=R_IBF3wiLqF-68yF', '2024-10-13', 'upcoming'),
	(37, 'Twisters', 'uploads/Twisters.jpg', 'An update to the 1996 film \\\'Twister\\\', which centered on a pair of storm chasers who risk their lives in an attempt to test an experimental weather alert system.\\r\\n', 'English', '2024-06-19', '2024-01-11', '10:30 AM', '02:00 PM', '10:00 AM', '2D', 'Adventure', 'G - Genera', 'https://youtu.be/wdok0rZdmx4?si=DDl7geReIpn3gT_Q', '2024-07-17', 'upcoming'),
	(38, 'The Garfield Movie', 'uploads/1.jpg', 'After Garfield\\\'s unexpected reunion with his long-lost father, ragged alley cat Vic, he and his canine friend Odie are forced from their perfectly pampered lives to join Vic on a risky heist.', 'English', '2024-06-24', '2024-06-30', '10:30 AM', '02:00 PM', '08:30 PM', '2D', 'Fantasy', 'G - Genera', 'https://youtu.be/IeFWNtMo1Fs?si=ncbosk-Bn0UTTi2c', '2024-06-05', 'now_showing'),
	(41, 'IF', 'uploads/IF.jpg', 'A young girl who goes through a difficult experience begins to see everyone\\\'s imaginary friends who have been left behind as their real-life friends have grown up.', 'English', '2024-06-25', '2024-07-01', '11:30 AM', '04:00 PM', '10:30 PM', '2D', 'Conedy', 'G - Genera', 'https://youtu.be/mb2187ZQtBE?si=x5l-FXHRYh0sa2Du', '2024-05-02', 'now_showing'),
	(42, 'Dark Matter', 'uploads/dark.jpg', 'A man is abducted into an alternate version of his life. Amid the mind-bending landscape of lives he could\\\'ve lived, he embarks on a harrowing journey to get back to his true family and save them from a most terrifying foe: himself.', 'English', '2024-06-25', '2024-07-01', '10:30 AM', '02:00 PM', '06:00 PM', '2D', 'Thriller', 'G - Genera', 'https://youtu.be/j6ucGt_Xp14?si=pEcnCcs9yxC75cdg', '2024-05-30', 'now_showing'),
	(43, 'Article 370', 'uploads/ar.jpg', 'Ahead of a major constitutional decision, special agent Zooni Haksar is tasked with a secret mission to quell violence in a conflict-ridden region.', 'Hindi', '2024-06-25', '2024-07-01', '08:00 AM', '11:30 AM', '04:00 PM', '2D', 'Thriller', 'G - Genera', 'https://youtu.be/6Pf6RUmq7S0?si=ELOp1y_ARH7A7JHw', '2024-05-29', 'now_showing');

-- Dumping structure for table savoy_cinema.movie_casts
CREATE TABLE IF NOT EXISTS `movie_casts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movieId` int(11) DEFAULT NULL,
  `castName` varchar(255) DEFAULT NULL,
  `castImage` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `movieId` (`movieId`),
  CONSTRAINT `movie_casts_ibfk_1` FOREIGN KEY (`movieId`) REFERENCES `movies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table savoy_cinema.movie_casts: ~32 rows (approximately)
INSERT INTO `movie_casts` (`id`, `movieId`, `castName`, `castImage`) VALUES
	(69, 27, 'Ryan Renolds', 'uploads/ryan renolds.jpeg'),
	(70, 27, 'Hugh Jackman', 'uploads/Hugh Jackman.jpeg'),
	(71, 27, 'Morena Baccarin', 'uploads/Morena Baccarin.jpg'),
	(72, 27, 'Shawn Levy', 'uploads/Shawn Levy.jpg'),
	(77, 31, 'Kamal Hassan', 'uploads/Kamal_haasan.jpg'),
	(78, 31, 'Priya Bhavani Shankar', 'uploads/Priya_Bhavani_Shankar_PYTV.png'),
	(79, 31, 'Siddharth', 'uploads/2640-siddharth.jpg'),
	(80, 31, 'Shankar', 'uploads/Shankar_at_the_2.0_Trailer_Launch.jpg'),
	(93, 35, 'Wamiqa Gabbi', 'uploads/Wamiqa.jpg'),
	(94, 35, 'Tabu', 'uploads/Tabu.jpg'),
	(95, 35, 'Ali Fazal', 'uploads/Alil.jpg'),
	(96, 35, 'Azmeri Haque Badhon', 'uploads/images.jpg'),
	(101, 37, 'Glen Powell', 'uploads/Glen.jpg'),
	(102, 37, 'Kiernan Shipka', 'uploads/Shipka.jpg'),
	(103, 37, 'Anthony Ramos', 'uploads/Cw.jpg'),
	(104, 37, 'Daisy Edgar-Jones', 'uploads/download.jpg'),
	(105, 38, 'Chris Pratt', 'uploads/Chris.jpg'),
	(106, 38, 'Hannah Waddingham', 'uploads/images (1).jpg'),
	(107, 38, 'Nicholas Hoult', 'uploads/Hoult.jpg'),
	(108, 38, 'Brett Goldstein', 'uploads/Brett.jpg'),
	(117, 41, 'Ryan Reynolds', 'uploads/Raynjpg.jpg'),
	(118, 41, 'Steve Carell', 'uploads/images (4).jpg'),
	(119, 41, 'Cailey Fleming', 'uploads/images (2).jpg'),
	(120, 41, 'Emily Blunt', 'uploads/images (3).jpg'),
	(121, 42, 'Joel Edgerton', 'uploads/download.jpg'),
	(122, 42, 'Jennifer Connelly', 'uploads/images (5).jpg'),
	(123, 42, 'Alice Braga', 'uploads/Ali.jpg'),
	(124, 42, 'Jimmi Simpson', 'uploads/images (6).jpg'),
	(125, 43, 'Yami Gautam', 'uploads/images.jpg'),
	(126, 43, 'Kiran Karmarkar', 'uploads/images (7).jpg'),
	(127, 43, 'Iravati Harshe', 'uploads/m_.jpg'),
	(128, 43, 'Priyamani', 'uploads/images (8).jpg');

-- Dumping structure for table savoy_cinema.now_showing
CREATE TABLE IF NOT EXISTS `now_showing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movieName` varchar(255) DEFAULT NULL,
  `movieImage` varchar(255) DEFAULT NULL,
  `movieDescription` text DEFAULT NULL,
  `showingDate` date DEFAULT NULL,
  `endingDate` date DEFAULT NULL,
  `showingTime1` varchar(50) DEFAULT NULL,
  `showingTime2` varchar(50) DEFAULT NULL,
  `showingTime3` varchar(50) DEFAULT NULL,
  `dimension` varchar(10) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `rating` varchar(10) DEFAULT NULL,
  `trailerLink` varchar(255) DEFAULT NULL,
  `releaseDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table savoy_cinema.now_showing: ~4 rows (approximately)
INSERT INTO `now_showing` (`id`, `movieName`, `movieImage`, `movieDescription`, `showingDate`, `endingDate`, `showingTime1`, `showingTime2`, `showingTime3`, `dimension`, `genre`, `rating`, `trailerLink`, `releaseDate`) VALUES
	(31, 'The Garfield Movie', 'uploads/1.jpg', 'After Garfield\\\'s unexpected reunion with his long-lost father, ragged alley cat Vic, he and his canine friend Odie are forced from their perfectly pampered lives to join Vic on a risky heist.', '2024-06-24', '2024-06-30', '10:30 AM', '02:00 PM', '08:30 PM', '2D', 'Fantasy', 'G - Genera', 'https://youtu.be/IeFWNtMo1Fs?si=ncbosk-Bn0UTTi2c', '2024-06-05'),
	(34, 'IF', 'uploads/IF.jpg', 'A young girl who goes through a difficult experience begins to see everyone\\\'s imaginary friends who have been left behind as their real-life friends have grown up.', '2024-06-25', '2024-07-01', '11:30 AM', '04:00 PM', '10:30 PM', '2D', 'Conedy', 'G - Genera', 'https://youtu.be/mb2187ZQtBE?si=x5l-FXHRYh0sa2Du', '2024-05-02'),
	(35, 'Dark Matter', 'uploads/dark.jpg', 'A man is abducted into an alternate version of his life. Amid the mind-bending landscape of lives he could\\\'ve lived, he embarks on a harrowing journey to get back to his true family and save them from a most terrifying foe: himself.', '2024-06-25', '2024-07-01', '10:30 AM', '02:00 PM', '06:00 PM', '2D', 'Thriller', 'G - Genera', 'https://youtu.be/j6ucGt_Xp14?si=pEcnCcs9yxC75cdg', '2024-05-30'),
	(36, 'Article 370', 'uploads/ar.jpg', 'Ahead of a major constitutional decision, special agent Zooni Haksar is tasked with a secret mission to quell violence in a conflict-ridden region.', '2024-06-25', '2024-07-01', '08:00 AM', '11:30 AM', '04:00 PM', '2D', 'Thriller', 'G - Genera', 'https://youtu.be/6Pf6RUmq7S0?si=ELOp1y_ARH7A7JHw', '2024-05-29');

-- Dumping structure for table savoy_cinema.promotions
CREATE TABLE IF NOT EXISTS `promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `discount` varchar(50) NOT NULL,
  `duration` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table savoy_cinema.promotions: ~1 rows (approximately)
INSERT INTO `promotions` (`id`, `title`, `description`, `discount`, `duration`, `image`, `start_date`, `end_date`, `created_at`) VALUES
	(2, 'Credit Card Offer', 'Another great opportunity for you to increase your cinema experience. Commercial bank credit card holders', '50%', 4, 'uploads/Master Credit Gold-01.png', '2024-06-25', '2024-07-02', '2024-06-24 23:49:17');

-- Dumping structure for table savoy_cinema.seat
CREATE TABLE IF NOT EXISTS `seat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `seat_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_seat_seat_type` (`seat_type_id`),
  CONSTRAINT `FK_seat_seat_type` FOREIGN KEY (`seat_type_id`) REFERENCES `seat_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table savoy_cinema.seat: ~40 rows (approximately)
INSERT INTO `seat` (`id`, `name`, `seat_type_id`) VALUES
	(1, 'A1', 1),
	(2, 'A2', 1),
	(3, 'A3', 1),
	(4, 'A4', 1),
	(5, 'A5', 1),
	(6, 'A6', 2),
	(7, 'A7', 2),
	(8, 'A8', 2),
	(9, 'A9', 2),
	(10, 'A10', 2),
	(11, 'A11', 2),
	(12, 'A12', 2),
	(13, 'A13', 2),
	(14, 'A14', 2),
	(15, 'A15', 2),
	(16, 'A16', 3),
	(17, 'A17', 3),
	(18, 'A18', 3),
	(19, 'A19', 3),
	(20, 'A20', 3),
	(21, 'B1', 1),
	(22, 'B2', 1),
	(23, 'B3', 1),
	(24, 'B4', 1),
	(25, 'B5', 1),
	(26, 'B6', 2),
	(27, 'B7', 2),
	(28, 'B8', 2),
	(29, 'B9', 2),
	(30, 'B10', 2),
	(31, 'B11', 2),
	(32, 'B12', 2),
	(33, 'B13', 2),
	(34, 'B14', 2),
	(35, 'B15', 2),
	(36, 'B16', 3),
	(37, 'B17', 3),
	(38, 'B18', 3),
	(39, 'B19', 3),
	(40, 'B20', 3);

-- Dumping structure for table savoy_cinema.seat_type
CREATE TABLE IF NOT EXISTS `seat_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table savoy_cinema.seat_type: ~3 rows (approximately)
INSERT INTO `seat_type` (`id`, `name`) VALUES
	(1, 'Left Seats'),
	(2, 'Middle Seats'),
	(3, 'Right Seats');

-- Dumping structure for table savoy_cinema.staff
CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table savoy_cinema.staff: ~2 rows (approximately)
INSERT INTO `staff` (`id`, `name`, `phone_number`, `password`, `created_at`) VALUES
	(5, 'Staff Member 2', '0721234560', '$2y$10$gi3lDrzyxOP415p/p8SQIeSZ6MjgAlqEV8PJTjn0nkaJPe7T3e5iG', '2024-06-24 22:18:36');

-- Dumping structure for table savoy_cinema.upcoming_movies
CREATE TABLE IF NOT EXISTS `upcoming_movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movieName` varchar(255) DEFAULT NULL,
  `movieImage` varchar(255) DEFAULT NULL,
  `movieDescription` text DEFAULT NULL,
  `showingDate` date DEFAULT NULL,
  `endingDate` date DEFAULT NULL,
  `showingTime1` varchar(50) DEFAULT NULL,
  `showingTime2` varchar(50) DEFAULT NULL,
  `showingTime3` varchar(50) DEFAULT NULL,
  `dimension` varchar(10) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `rating` varchar(10) DEFAULT NULL,
  `trailerLink` varchar(255) DEFAULT NULL,
  `releaseDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table savoy_cinema.upcoming_movies: ~4 rows (approximately)
INSERT INTO `upcoming_movies` (`id`, `movieName`, `movieImage`, `movieDescription`, `showingDate`, `endingDate`, `showingTime1`, `showingTime2`, `showingTime3`, `dimension`, `genre`, `rating`, `trailerLink`, `releaseDate`) VALUES
	(19, 'Deadpool & Wolverine', 'uploads/Deadpool 3.jpg', 'Wolverine is recovering from his injuries when he crosses paths with the loudmouth, Deadpool. They team up to defeat a common enemy.', '2024-07-26', '2024-07-31', '16:30:00', '21:00:00', '10:00:00', '3D', 'Action', 'PG', 'https://youtu.be/uJMCNJP2ipI', '2024-07-26'),
	(20, 'Indian 2', 'uploads/Indian 2.jpg', 'Indian 2 is an upcoming Indian Tamil-language vigilante action film directed by S. Shankar, who wrote the screenplay with B. Jeyamohan, Kabilan Vairamuthu, and Lakshmi Saravana Kumar. The film is jointly produced by Lyca Productions and Red Giant Movies. The sequel to Indian (1996), Kamal Haasan reprises his role as Senapathy, an ageing freedom fighter turned vigilante who fights against corruption, with Siddharth, S. J. Suryah, Rakul Preet Singh, Bobby Simha, Vivek, Priya Bhavani Shankar, Gulshan Grover, Samuthirakani and Nedumudi Venu in the ensemble cast.', '2024-07-12', '2024-07-25', '10:00:00', '16:00:00', '00:00:00', '2D', 'Action', 'G - Genera', 'https://youtu.be/kqGj31bQQQ0', '2024-07-12'),
	(21, 'Khufiya', 'uploads/Khufiya.jpg', 'Krishna Mehra is an operative at Indian spy agency known as R&AW. She is assigned to track down the mole selling India\\\'s defense secrets, while all along grappling with her dual identity as a spy and a lover.', '2024-10-15', '2024-12-22', '10:30 AM', '04:00 PM', '09:30 PM', '2D', 'Thriller', 'G - Genera', 'https://youtu.be/ByojhBwG_-E?si=R_IBF3wiLqF-68yF', '2024-10-13'),
	(22, 'Twisters', 'uploads/Twisters.jpg', 'An update to the 1996 film \\\'Twister\\\', which centered on a pair of storm chasers who risk their lives in an attempt to test an experimental weather alert system.\\r\\n', '2024-06-19', '2024-01-11', '10:30 AM', '02:00 PM', '10:00 AM', '2D', 'Adventure', 'G - Genera', 'https://youtu.be/wdok0rZdmx4?si=DDl7geReIpn3gT_Q', '2024-07-17');

-- Dumping structure for table savoy_cinema.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table savoy_cinema.users: ~7 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `password`, `created_at`) VALUES
	(5, 'ihara', 'ihara@gmail.com', '0763947527', '$2y$10$NrPmPrAfQOHbyM1.vsfmyuebO5AVNiRPt0xDJpGSGqYvax9/89p7W', '2024-06-18 05:53:30'),
	(6, 'mega', 'me@gmail.com', '0769173390', '$2y$10$AIhnL/b5udAe0u0NG45j/OxRRoriZkVetsm9HguVca/oZkr.n6rsu', '2024-06-21 02:44:59'),
	(7, 'ama', 'ama@gmail.com', '0762238223', '$2y$10$AwBa7mGnac9tn2A6rCzwhevfd6AuDNbjOup7cyR4Fky5DGtvIXmY6', '2024-06-22 08:17:59'),
	(8, 'Sanuka Thamendra', 'sanu@gmail.com', '0772282280', '$2y$10$8JS5HQCfWpRW7p7DwfEwEeOhJ2YUqiuiXnJUon5oIM7inMDPopuhu', '2024-06-23 13:57:32'),
	(9, 'Avishka Senarath', 'Avishka@gmail.com', '0782255891', '$2y$10$GCOnTbHWGxpknx547X5E8./1F.0G3.ioZTNWbraLJKRDDlJs29y9y', '2024-06-23 14:10:42'),
	(10, 'Megana', 'megana@gmail.com', '0721234456', '$2y$10$eo7ctodFcNIzuPsUI/Ub2e2R6KzP6S.aKRP6yhaB4fJRYIZKoq79i', '2024-06-23 14:49:24'),
	(12, 'Samadhi Yashodhara', 'sama@gmail.com', '0769173390', '$2y$10$LAtAzCTyuWDqacotunukVOdUzZATBjdpK1AKcE4xyCCf6Jw6b9t.2', '2024-06-24 22:33:24');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
