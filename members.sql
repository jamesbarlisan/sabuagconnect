-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2025 at 06:41 PM
-- Server version: 8.4.4
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `members`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL DEFAULT '0',
  `full_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `username`, `password`) VALUES
(3, 'Sherly S. Reyes', 'admin_reyes', '$2y$10$QX2xCvAtuv6EeT/h4rixSeOLFRaNAG22zwe.1znrU6goqXh8823Dm');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `created_at`) VALUES
(1, 'IT Days 2025', 'IT Days 2025 will be on March 25-28, 2025.', '2025-02-17 07:08:59'),
(5, 'Midterm Exam', 'The Midterm Examination Schedule will be on March 17-21, 2025.', '2025-03-09 18:10:51');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `task_id` int NOT NULL,
  `member_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image_path` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`task_id`, `member_id`, `title`, `content`, `date_submitted`, `image_path`) VALUES
(62, 33, 'Bridging Culture, Inspiring Unity', 'The university\'s \"Week of Welcome\" (Pegguna 2024) marked an exciting start to the school year, bringing students and parents together in a week-long series of events. The festivities began with Student and Parent Orientation, where university leaders welcomed newcomers, provided campus tours, and offered academic guidance. The excitement continued on Tuesday with the Grand Welcome, featuring booths from student organizations and a lively cheer to unite the community. Wednesday\'s Organizational Recruitment Fair encouraged students to explore clubs and organizations, helping them connect with like-minded peers.\r\n\r\nOn Thursday, the Research Colloquium highlighted academic excellence, showcasing research in environmental science and technology while offering students networking opportunities.\r\n\r\nThe week concluded with a Buwan ng Wika celebration, where Filipino culture was honored through performances and creative showcases, followed by the election of class officers, marking the beginning of student leadership for the year. By the end of the week, students had formed friendships, discovered new opportunities, and officially became part of the university community, setting the stage for a successful academic journey.', '2025-03-08 16:00:00', 'uploads/455753272_1005906481546065_1070630957914274257_n.jpg'),
(82, 38, 'Reviving the Allure of the Prohibition Era: Acquaintance Party Goes Mafia-Themed', 'Welcomed by a golden arch at the entrance, the red carpet fired up the party as the Mafia Dons and Dames owned their walk. Flashes of lights sparkled in the gymnasium as students snapped photos, while elegant table designs lined up beside the aisle. Ecstatic students from USTP Panaon filled the venue with fun talks, dazzling smiles, and an array of stunning Mafia-themed outfits. It was a night of groovy music and unforgettable good times.\r\n\r\nThe event kick-started with a hit of timeless classic songs and a luxurious ambiance set with hints of red and classic black and white. Dressed to impress, men channeled their inner Al Capone in sharp suits and black sunglasses, while women dazzled in elegant dresses and boots, and adorned with glittering accessories—capturing the allure of the Prohibition era.\r\n\r\nAs the Mafia-dressed hosts set the stage for entertainment, performers from the faculty, officers, and students energized the crowd with their lively performances. The most anticipated part of the event was the Panag-ila Ceremony, where all freshmen lined up in two circles around the bleachers and stage, while students from higher years walked between the lines, greeting them with waves of ‘Hi’ and ‘Hello.’ This annual tradition during the acquaintance party symbolizes unity and fosters a sense of belonging within the USTP community.\r\n\r\nThe highlight of the evening was the Mr. & Ms. Panag-ila 2024. Kayryll Tagbo, in her sleek black dress and perfectly sculpted hair, and Gregorlie Ybañez, in his bold suit and charming smile, both hailing from the TLE Department, took home the coveted titles, capping off the night in style. A game of the all-time favorite ‘Bring Me’ followed, right before students were serenaded with a lovely song during dinner.\r\n\r\nIn true Mafia fashion, a few top-picked faculty, officers, and students bagged awards for Best Dressed, Head Turner, Face of the Night, and of course, the Don’s Son & Daughter award.\r\n\r\nWhile the atmosphere was cool and fun, the participants’ striking looks set the place on fire. The theme was a hit, truly bringing everyone together and proving once again that the university’s student council knows how to host an unforgettable evening. Memories were made, new friendships were fostered, and the dance floor was packed with guests swaying and letting loose. And as the night drew to a close, everyone danced the night away.\r\n', '2025-04-06 12:26:15', NULL),
(83, 35, 'Campus Care Day', 'On August 30, 2024, with the AACCUP visit quickly approaching, USTP Panaon is busy making final preparations. A key event leading up to this important evaluation is the General Campus \"Do Day\"—not just a clean-up but a powerful demonstration of the university’s collective effort to present its best self. Faculty, staff, and students are working hand in hand to ensure that every corner of the campus reflects their pride in the institution.\r\n\r\nFrom cleaning classrooms to landscaping common areas, everyone is involved, embodying the deep-rooted spirit of unity at USTP Panaon. This event unites the entire institution in preparing the campus to\r\nmeet accreditation standards. Through their continuous efforts, the campus is not only ready for the upcoming visit but also reaffirms its dedication to continuous improvement and academic excellence.\r\n\r\nBy maintaining a pristine and organized environment, USTP Panaon sends a clear message: it is fully prepared for accreditation while striving to enhance the student experience and uphold high academic standards. Through their collective commitment, the USTP community not only readies itself for evaluation but also strengthens its culture of quality, growth, and excellence—principles that will guide the university into the future.\r\n', '2025-03-08 16:00:00', 'uploads/480877495_627208406725163_1955231538274969220_n.jpg'),
(84, 34, 'A Day of Reflection and Growth: Embracing Servant Leadership', 'On August 24, 2024, the USTP leadership team engaged in a meaningful day of reflection and growth, guided by Fr. Elmo’s inspiring message on servant leadership and team building. He emphasized the importance of leading with humility, prioritizing others, and fostering collaboration. His words reminded us that true leadership is about serving, empowering, and uplifting those around us.\r\n\r\nThis experience strengthened our sense of unity and renewed our commitment to lead with compassion and dedication. Inspired by his insights, we strive to become student leaders who create a positive\r\nimpact through selfless service and a shared vision for growth.', '2025-03-08 16:00:00', 'uploads/475906676_122149579028071257_2090184941488218032_n.jpg'),
(85, 38, 'Trailblazing Leaders’ Assembly empowers USTP Panaon student leaders', 'Over 50 student leaders from the eight University of Science and Technology of Southern Philippines (USTP) campuses took part in the Trailblazing Leaders’ Assembly held at USTP Claveria, Misamis Oriental, on October 23-25, 2024.\r\nThe event, themed “Ignite: Empowering Tomorrow’s Trailblazers,” provided an invaluable platform for student leaders to engage in discussions on leadership, ethics, and governance.\r\nRepresentatives from the Supreme Student Council (SSC), League of Information Technologists (LIT), Future Educators Guild (FEG), and Organization for Conservation, Ecology, and Academic Nobility (OCEAN) actively participated in the three-day event, focusing on key leadership concepts such as servant leadership, which emphasizes prioritizing the needs and growth of others.\r\nMoreover, the event also underscored the importance of ethical leadership, highlighting the values of character, competence, and compassion as essential to becoming impactful leaders.\r\nPractical sessions on event planning and management equipped participants with skills necessary for organizing successful initiatives, while the discussions on parliamentary procedures taught effective meeting management, including the symbolic use of the gavel and block.\r\nThe assembly culminated in the Election of New Officers for the Federation of Student Councils. Student council presidents from each campus convened to cast their votes in a secret ballot, marking an important milestone in their leadership journey. The assembly reaffirmed that leadership is not just about authority but about collaboration, integrity, and fostering a culture of empowerments.\r\n', '2025-03-08 16:00:00', 'uploads/464599443_1883678485474745_371855211043899518_n.jpg'),
(86, 38, 'USTP commemorates 39th EDSA People Power anniv', 'To commemorate the EDSA People Power Revolution, which restored democracy in the Philippines, the University of Science and Technology of Southern Philippines (USTP) - Panaon Campus organized a series of activities to honor its legacy and educate students on its historical significance.\r\nMarking its 39th anniversary in 2025, this year’s commemoration differed from previous years, as February 25 was declared a special working holiday, preventing a nationwide pause for reflection. \r\nNonetheless, USTP—among the many institutions that declared a suspension of classes—upheld the spirit of the revolution by suspending classes across all its campuses.\r\nThe department organizations—League of Information Technologists (LIT), Future Educators\' Guild (FEG), and Organization for Conservation, Ecology, and Academic Nobility (OCEAN)—led the commemoration with activities including a film viewing of EDSA documentaries, a panel discussion with students, and a candle-lighting ceremony, all aimed at deepening the understanding of the revolution’s relevance today.\r\nTwo faculty guest speakers, Mr. Jan James Arañas and Ms. Darfe Mae Dando, delivered insightful discussions on the significance of the People Power Revolution and its lasting impact on Philippine democracy.\r\nMoreover, Mr. Arañas, a member of the Arts and Sciences faculty, emphasized the importance of remembering the sacrifices of the people during the revolution and honoring them through actions.\r\nThe event concluded with a solemn candle-lighting ceremony, symbolizing the students\' commitment to upholding democracy and honoring the sacrifices of those who fought for freedom, with prayers offered by Supreme Student Council President Perjohn C. Magtagad.\r\nFollowing the event, students joined hands for a clean-up drive activity, focusing waste segregation and ground maintenance. The initiative aimed to reinforce the values of unity, responsibility, and collective action within the campus community.\r\nThe joint efforts of students, including the USTP gathering, highlighted shared commitment to remembering the People Power Revolution-not just as a historical event but as an ongoing responsibility to defend democracy and human rights.\r\n', '2025-03-08 16:00:00', 'uploads/481109502_625006166945387_3701197383128543517_n.jpg'),
(87, 38, 'NSTP empowers freshmen studes with comprehensive emergency preparedness seminar', 'To prepare and equip students with important life skills, the National Service Training Program unit of the University of Science and Technology of Southern Philippines – Panaon conducted a seminar on December 15, 2023, with the theme, \"Emergency Preparedness: Surviving Nature\'s Fury, Fire Prevention Protocols, and First Aid Essentials.\"\r\nThe event, conducted on the university premises, aimed to raise awareness about the importance of being prepared for emergencies. It aimed to teach students with the necessary knowledge and skills to respond efficiently during times of disaster.\r\nThe seminar was actively participated by first-year students, with the guest speakers from Municipal Disaster Risk Reduction and Management Office of Panaon and Bureau of Fire Protection, who are experts in the fields of disaster management, fire prevention, and first aid.\r\nMoreover, the seminar focused on understanding and surviving natural disasters. This was followed by discussions on fire prevention protocols, offering students a comprehensive understanding of fire safety measures. The event also included a discussion about first aid essentials, equipping students with the skills needed to provide immediate assistance during emergencies.\r\nMeanwhile, the seminar concluded with a coastal clean-up and certificate distribution ceremony, recognizing the active participation of students.\r\nThanks to the proactive initiatives of the NSTP in preparing this informative and empowering seminar, the USTP community is now more equipped to confront the challenges presented by natural disasters and emergencies.\r\n', '2025-03-08 16:00:00', 'uploads/411227346_873648254764023_6413737123443852736_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `article_id` int NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `user_name`, `comment`, `created_at`) VALUES
(2, 87, 'James', 'power!', '2025-03-12 23:48:15'),
(3, 82, 'elcid', 'Great experience', '2025-03-13 11:53:27');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `first_name`, `last_name`, `email`, `subject`, `message`, `created_at`) VALUES
(18, 'Sample', 'Barlisan', 'jamesfrancisbarlisan@gmail.com', 'Title', 'asasasasa', '2025-04-06 03:38:09'),
(19, 'Sample', 'Barlisan', 'jamesfrancisbarlisan@gmail.com', 'Title', 'asasasasa', '2025-04-06 03:38:09'),
(20, 'james', 'Ballard', 'cadiz@ustp.edu.ph', 'Concernasa', 'asas', '2025-04-06 03:40:09'),
(21, 'James', 'Mendoza', 'sample@email.com', 'Concernasa', 'asasasa', '2025-04-06 03:43:15');

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id`, `name`) VALUES
(2, 'IT Days 2025'),
(3, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `media_repository`
--

CREATE TABLE `media_repository` (
  `id` int NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` enum('photo','video') NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `folder_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `media_repository`
--

INSERT INTO `media_repository` (`id`, `file_name`, `file_type`, `file_path`, `uploaded_at`, `folder_id`) VALUES
(52, '485855863_1029748115727216_1213130899415959131_n.jpg', 'photo', 'uploads/1743933910_485855863_1029748115727216_1213130899415959131_n.jpg', '2025-04-06 10:05:10', 2),
(53, '6280753259782193805.jpg', 'photo', 'uploads/1743933910_6280753259782193805.jpg', '2025-04-06 10:05:10', 2),
(54, '6280753259782193806.jpg', 'photo', 'uploads/1743933910_6280753259782193806.jpg', '2025-04-06 10:05:10', 2),
(55, '6280753259782193807.jpg', 'photo', 'uploads/1743933910_6280753259782193807.jpg', '2025-04-06 10:05:10', 2),
(56, '6280753259782193795.jpg', 'photo', 'uploads/1743933910_6280753259782193795.jpg', '2025-04-06 10:05:10', 2),
(57, '6280753259782193796.jpg', 'photo', 'uploads/1743933910_6280753259782193796.jpg', '2025-04-06 10:05:10', 2),
(58, '6280753259782193797.jpg', 'photo', 'uploads/1743933910_6280753259782193797.jpg', '2025-04-06 10:05:10', 2),
(59, '6280753259782193798.jpg', 'photo', 'uploads/1743933910_6280753259782193798.jpg', '2025-04-06 10:05:10', 2),
(60, '6280753259782193799.jpg', 'photo', 'uploads/1743933910_6280753259782193799.jpg', '2025-04-06 10:05:10', 2),
(61, '6280753259782193800.jpg', 'photo', 'uploads/1743933910_6280753259782193800.jpg', '2025-04-06 10:05:10', 2),
(62, '485868143_665691372636842_5126374588682445916_n.jpg', 'photo', 'uploads/1743933910_485868143_665691372636842_5126374588682445916_n.jpg', '2025-04-06 10:05:10', 2),
(63, '485252655_1316074799628779_753653398120697034_n.jpg', 'photo', 'uploads/1743933910_485252655_1316074799628779_753653398120697034_n.jpg', '2025-04-06 10:05:10', 2),
(64, '486418639_1368668657778671_7066734490089603579_n.jpg', 'photo', 'uploads/1743933910_486418639_1368668657778671_7066734490089603579_n.jpg', '2025-04-06 10:05:10', 2),
(65, '484906864_1311485779940219_7141444805307432315_n.jpg', 'photo', 'uploads/1743933910_484906864_1311485779940219_7141444805307432315_n.jpg', '2025-04-06 10:05:10', 2),
(66, '482914177_2630997000436699_6234030849753269341_n.jpg', 'photo', 'uploads/1743933910_482914177_2630997000436699_6234030849753269341_n.jpg', '2025-04-06 10:05:10', 2),
(67, '485407841_1379036083545564_7164200849701769399_n.jpg', 'photo', 'uploads/1743933910_485407841_1379036083545564_7164200849701769399_n.jpg', '2025-04-06 10:05:10', 2),
(68, '483013929_1207281824066079_3515257905029274230_n.jpg', 'photo', 'uploads/1743933910_483013929_1207281824066079_3515257905029274230_n.jpg', '2025-04-06 10:05:10', 2),
(69, '480156927_994800552755996_7270021309671392644_n.jpg', 'photo', 'uploads/1743933910_480156927_994800552755996_7270021309671392644_n.jpg', '2025-04-06 10:05:10', 2),
(70, '487051640_995752545844071_5380578616603775057_n.jpg', 'photo', 'uploads/1743933910_487051640_995752545844071_5380578616603775057_n.jpg', '2025-04-06 10:05:10', 2),
(71, '485213919_2857722734417156_677528137864542830_n.jpg', 'photo', 'uploads/1743933910_485213919_2857722734417156_677528137864542830_n.jpg', '2025-04-06 10:05:10', 2),
(72, '6276312950792898918.jpg', 'photo', 'uploads/1743934188_6276312950792898918.jpg', '2025-04-06 10:09:48', 3);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int NOT NULL,
  `birthday` date NOT NULL,
  `program` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `year_section` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `position` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_number` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `birthday`, `program`, `year_section`, `position`, `profile_picture`, `username`, `password`, `first_name`, `last_name`, `contact_number`) VALUES
(11, '1990-10-11', 'BTLE Industrial Arts', '3A', 'Editor-in-Chief', 'uploads/Sherly Reyes.jpeg', 'admin_reyes', '', 'Sherly', 'Reyes', NULL),
(19, '2006-07-13', 'BS Marine Biology', '1F', 'Social Media Manager', NULL, 'sabuag_adlaon', '', 'Jelyn', 'Adlaon', NULL),
(30, '2006-11-07', 'BTLE Industrial Arts', '1A', 'Video Editor', NULL, 'sabuag_adorable', '', 'Jc', 'Adorable', NULL),
(33, '2006-08-01', 'BTLE Home Economics', '1A', 'Writer', NULL, 'sabuag_aguhar', '', 'Shane', 'Aguhar', NULL),
(25, '2004-09-21', 'BS Marine Biology', '2B', 'Photo Journalist', NULL, 'sabuag_aranas', '', 'Sanny', 'Aranas', NULL),
(14, '2004-06-30', 'BS Information Technology', '2C', 'Assistant Secretary', NULL, 'sabuag_arcenas', '', 'Junly', 'Arcenas', NULL),
(23, '2004-08-15', 'BS Marine Biology', '1G', 'Editorial Cartoonist', NULL, 'sabuag_bartolaba', '', 'Julius', 'Bartolaba', NULL),
(18, '2001-11-26', 'BS Information Technology', '3B', 'Social Media Manager', NULL, 'sabuag_bison', '', 'Renz', 'Bison', NULL),
(38, '2004-12-18', 'BS Marine Biology', '2F', 'Writer', 'uploads/470238754_122155546598331053_5634375586186767944_n.jpg', 'sabuag_caballero', '', 'Ashly', 'Caballero', '091574839283'),
(21, '2003-03-07', 'BS Information Technology', '4A', 'Layout Artist', NULL, 'sabuag_caliso', '', 'Ferland', 'Caliso', NULL),
(34, '2004-11-30', 'BTLE Industrial Arts', '1A', 'Writer', NULL, 'sabuag_cedamon', '', 'Nathalie', 'Cedamon', NULL),
(13, '2006-02-25', 'BTLE Industrial Arts', '1A', 'Publication Secretary', NULL, 'sabuag_curambao', '', 'Reina', 'Curambao', NULL),
(16, '2004-09-24', 'BS Marine Biology', '2D', 'Auditor', NULL, 'sabuag_dagatan', '', 'Mekyla', 'Dagatan', NULL),
(24, '2002-03-06', 'BS Information Technology', '3A', 'Editorial Cartoonist', NULL, 'sabuag_de-vera', '', 'Israel', 'Vera', NULL),
(35, '2002-08-04', 'BTLE Industrial Arts', '3A', 'Writer', NULL, 'sabuag_galindo', '', 'Mary', 'Galindo', NULL),
(15, '2003-04-06', 'BTLE Industrial Arts', '3A', 'Managing Editor', NULL, 'sabuag_garan', '', 'Gavino', 'Garan,', NULL),
(17, '2004-12-24', 'BS Marine Biology', '1E', 'Circulation Manager', NULL, 'sabuag_mendoza', '', 'John', 'Mendoza', NULL),
(29, '1998-12-22', 'BTLE Industrial Arts', '3A', 'Video Editor', NULL, 'sabuag_navarro', '', 'Alexander', 'Navarro,', NULL),
(28, '2004-05-16', 'BS Information Technology', '1B', 'Video Editor', NULL, 'sabuag_rivera', '', 'Josiah', 'Rivera', NULL),
(26, '2003-09-30', 'BS Information Technology', '3A', 'Photo Journalist', NULL, 'sabuag_rodriguez', '', 'Edghiel', 'Rodriguez', NULL),
(22, '1997-06-05', 'BTLE Industrial Arts', '3A', 'Editorial Cartoonist', NULL, 'sabuag_salvacion', '', 'Nilver', 'Salvacion', NULL),
(27, '2004-03-07', 'BS Marine Biology', '2A', 'Photo Journalist', NULL, 'sabuag_tano', '', 'Coky', 'Tano', NULL),
(32, '2004-11-26', 'BS Marine Biology', '2A', 'Graphic Artist', NULL, 'sabuag_taruc', '', 'Xyza', 'Taruc', NULL),
(31, '1999-08-28', 'BTLE Home Economics', '1A', 'Graphic Artist', NULL, 'sabuag_tenorio', '', 'Kenneth', 'Tenorio', NULL),
(20, '2004-04-08', 'BTLE Industrial Arts', '3A', 'Layout Artist', NULL, 'sabuag_toledo', '', 'April', 'Toledo', NULL),
(12, '2001-01-11', 'BS Information Technology', '4A', 'Associate Editor-in-Chief', NULL, 'sabuag_tumampos', '', 'Dexter', 'Tumampos', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Pending','Completed') COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `completed` tinyint(1) DEFAULT '0',
  `deadline` date NOT NULL,
  `task_id` int NOT NULL,
  `assigned_to` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_name`, `status`, `created_at`, `completed`, `deadline`, `task_id`, `assigned_to`) VALUES
('Write an article about Intrams', 'Pending', '2025-04-06 11:22:04', 0, '2025-04-20', 88, 38),
('asasa', 'Pending', '2025-04-06 14:05:51', 0, '2025-05-03', 89, 38);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'sabuag_tumampos', '$2y$10$sx7AZoCvRAWB2rBWL39NC.GjBiXevjIhqhyeOp9ZLwA7oxT/FHphW'),
(2, 'sabuag_caballero', '$2y$10$iSMDeWKxS7.jm.HbdupNXupilEy6bE0SF.MQ0ieHkAxfyT3JZK77q'),
(6, 'sabuag_galindo', '$2y$10$9n5w94ebxwHwfL.6JBHyKuDQydTbyFBxZdHJkNA4Lbv6LBgcF0xF6'),
(7, 'sabuag_cedamon', '$2y$10$WLe0Cvik2V0i7b3VJN8mbeVeYHshUGdWPaQn8hsC3OCnrn.cdWyJ2'),
(8, 'sabuag_aguhar', '$2y$10$gt1d1pMDMGHe4N2QllP8ZuFrIVCCNeBfi0wPI.JkkqMNUlwnJougO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `media_repository`
--
ALTER TABLE `media_repository`
  ADD PRIMARY KEY (`id`),
  ADD KEY `folder_id` (`folder_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `fk_tasks_members` (`assigned_to`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `task_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `media_repository`
--
ALTER TABLE `media_repository`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`task_id`) ON DELETE CASCADE;

--
-- Constraints for table `media_repository`
--
ALTER TABLE `media_repository`
  ADD CONSTRAINT `media_repository_ibfk_1` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_tasks_members` FOREIGN KEY (`assigned_to`) REFERENCES `members` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
