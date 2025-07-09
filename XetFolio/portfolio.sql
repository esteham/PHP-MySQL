-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2025 at 08:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `pic` varchar(100) NOT NULL,
  `type` enum('Admin','Author','Editor','Guest') NOT NULL DEFAULT 'Guest'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `pass`, `status`, `created_at`, `pic`, `type`) VALUES
(1, 'admin', 'eshasan1287005@gmail.com', '$2y$10$oB67wBQwVIdt77a.vPGu9uTY3w6AISyEsl/I3/K25pMbIQLaOlH5G', 'active', '2025-05-13 01:13:34', '', 'Guest');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_cat_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `blog_title`, `blog_cat_id`, `created_date`, `created_by_admin`) VALUES
(34, 'tgdfgf', 1, '2025-06-30 13:25:24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `blog_description`
--

CREATE TABLE `blog_description` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `short_description` mediumtext DEFAULT NULL,
  `full_description` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_description`
--

INSERT INTO `blog_description` (`id`, `blog_id`, `short_description`, `full_description`) VALUES
(29, 34, 'saf sdfafd', '<p>jdsfsafklj<br>&nbsp;</p><figure class=\"image-x\"><img style=\"aspect-ratio:450/300;\" src=\"http://127.0.0.1/jQuery/Portfolio/images/uploads/blog_img_68623baf56c1e.jpg\" width=\"450\" height=\"300\"></figure>');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `cat_name`, `created_at`) VALUES
(1, 'Domain', '2025-05-13 05:11:05'),
(2, 'Test 1 category', '2025-05-13 11:54:55'),
(3, 'News', '2025-05-17 03:17:21');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `commenter_name` varchar(100) NOT NULL,
  `commenter_email` varchar(150) NOT NULL,
  `comment_text` mediumtext NOT NULL,
  `allowed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `blog_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(7, 'test may work', 'muhammadhafizurrahmanSpiDer@gmail.com', 'no way', '1<br />\r\nServices<br />\r\n1<br />\r\nDomains<br />\r\n0<br />\r\nTickets<br />\r\n2<br />\r\nInvoices<br />\r\n  Your Active Products/Services<br />\r\nActive<br />\r\nTarzan nvme Packages yearly - Nvme 2 gb Package finland<br />\r\nEsteham H. Zihad Ansari.xyz<br />\r\n <br />\r\nView More...<br />\r\n  Overdue Invoices<br />\r\nYou have 2 overdue invoice(s) with a total balance due of ৳1647.00BDT. Pay them now to avoid any interruptions in service.<br />\r\n<br />\r\n  Register a New Domain<br />\r\n  Recent News<br />\r\n20 জিবি হোস্টিং এবং .COM ডোমেইন 1399 টাকা অফার টি সীমিত সময়ের জন্য।<br />\r\nWednesday, January 1st, 2025<br />\r\n.com ডোমেইন রেজিস্ট্রেশন মাত্র 1049 টাকা।<br />\r\nMonday, December 2nd, 2024', '2025-06-25 13:21:03'),
(8, 'MD. Esteham H. Zihad Ansari আরো', 'eshasan1287005@gmail.com', 'Test subjectএটাও', 'This is a tesr detective এটা একটা টেস্ট ছিল', '2025-06-25 21:56:17'),
(9, 'Search Engine Index', 'submissions@searchindex.site', 'Add Esteham H. Zihad Ansari.xyz to Google Search Index!', 'Hello,<br />\r\n<br />\r\nfor your website do be displayed in searches your domain needs to be indexed in the Google Search Index.<br />\r\n<br />\r\nTo add your domain to Google Search Index now, please visit <br />\r\n<br />\r\nhttps://SearchRegister.info/', '2025-06-25 22:06:23'),
(10, 'Hello', 'eshasan1287005@gmail.com', 'Test subject', '🤢🤮🤢', '2025-06-26 22:38:16'),
(11, 'Mike Vincent Frangois', 'info@speed-seo.net', 'Find Esteham H. Zihad Ansari.xyz SEO Issues totally free', 'Hi, <br />\r\nWorried about hidden SEO issues on your website? Let us help — completely free. <br />\r\nRun a 100% free SEO check and discover the exact problems holding your site back from ranking higher on Google. <br />\r\n <br />\r\nRun Your Free SEO Check Now <br />\r\nhttps://www.speed-seo.net/check-site-seo-score/ <br />\r\n <br />\r\nOr chat with us and our agent will run the report for you: https://www.speed-seo.net/whatsapp-with-us/ <br />\r\n <br />\r\nBest regards, <br />\r\n <br />\r\n <br />\r\nMike Vincent Frangois<br />\r\n <br />\r\nSpeed SEO Digital <br />\r\nEmail: info@speed-seo.net <br />\r\nPhone/WhatsApp: +1 (833) 454-8622', '2025-06-28 20:04:29'),
(12, 'Joanna Riggs', 'joannariggs83@gmail.com', 'Video Promotion for your website', 'Hi,<br />\r\n<br />\r\nI just visited Esteham H. Zihad Ansari.xyz and wondered if you&#039;d ever thought about having an engaging video to explain what you do?<br />\r\n<br />\r\nA couple of samples to check out for a Service and a Product:<br />\r\n<br />\r\nhttps://www.youtube.com/watch?v=uMI9l_FHwA8<br />\r\n<br />\r\nhttps://www.youtube.com/watch?v=67neUK1vylc<br />\r\n<br />\r\nOur prices start from just $195 (USD).<br />\r\n<br />\r\nLet me know if you&#039;re interested in seeing more samples of our previous work or have any questions.<br />\r\n<br />\r\nRegards,<br />\r\nJoanna', '2025-06-30 08:52:21');

-- --------------------------------------------------------

--
-- Table structure for table `modify`
--

CREATE TABLE `modify` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total_modify` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `port_url` varchar(255) NOT NULL,
  `port_name` varchar(255) NOT NULL,
  `port_desc` varchar(255) NOT NULL,
  `port_cat` varchar(255) NOT NULL,
  `port_uploaded_name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portfolio`
--

INSERT INTO `portfolio` (`id`, `port_url`, `port_name`, `port_desc`, `port_cat`, `port_uploaded_name`, `created_at`) VALUES
(25, 'https://aviation.xetroot.com', 'Aviation system', '', 'HTML,JavaScript,CSS,Bootstrap 5,PHP,Mysql', 'port_6863884e325360.39743401.gif', '2025-07-01 13:03:42'),
(26, 'https://eshop.xetroot.com/', 'Xetshop', '', 'HTML,CSS,Bootstrap 5,JavaScript,PHP,MySQL', 'port_6864cf4e4cab7.gif', '2025-07-02 12:15:38');

-- --------------------------------------------------------

--
-- Table structure for table `subscribe`
--

CREATE TABLE `subscribe` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thumbnail`
--

CREATE TABLE `thumbnail` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `thumb_name` varchar(255) NOT NULL,
  `thumb_uploaded_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thumbnail`
--

INSERT INTO `thumbnail` (`id`, `blog_id`, `thumb_name`, `thumb_uploaded_name`, `created_at`) VALUES
(27, 34, 'jullvern-1751082570-b7f6235_xlarge.jpg', 'thumb_68623be4cc62b.jpg', '2025-06-30 07:25:24');

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `total_view` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `blog_id`, `total_view`) VALUES
(26, 34, 841);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `name` (`username`) USING BTREE;

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_description`
--
ALTER TABLE `blog_description`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cat_name` (`cat_name`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_comment_blog` (`blog_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modify`
--
ALTER TABLE `modify`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_modify_blog` (`blog_id`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribe`
--
ALTER TABLE `subscribe`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `thumbnail`
--
ALTER TABLE `thumbnail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_views_blog` (`blog_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `blog_description`
--
ALTER TABLE `blog_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `modify`
--
ALTER TABLE `modify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `subscribe`
--
ALTER TABLE `subscribe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thumbnail`
--
ALTER TABLE `thumbnail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_description`
--
ALTER TABLE `blog_description`
  ADD CONSTRAINT `blog_description_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `modify`
--
ALTER TABLE `modify`
  ADD CONSTRAINT `modify_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `thumbnail`
--
ALTER TABLE `thumbnail`
  ADD CONSTRAINT `thumbnail_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `views`
--
ALTER TABLE `views`
  ADD CONSTRAINT `views_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
