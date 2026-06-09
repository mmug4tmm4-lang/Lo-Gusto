-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 01 يونيو 2026 الساعة 17:12
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- بنية الجدول `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(1, 'وجبات سريعة '),
(2, 'مشروبات باردة '),
(3, 'حلويات'),
(4, 'مشروبات ساخنة'),
(5, 'سلطات'),
(6, 'مقبلات'),
(7, 'شوربات');

-- --------------------------------------------------------

--
-- بنية الجدول `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `menu_items`
--

INSERT INTO `menu_items` (`id`, `item_name`, `price`, `image_path`, `category_id`, `image`) VALUES
(1, 'شاورما عربي دبل', 22.00, '', 1, '1780323982_shawarma.jpg.webp'),
(2, 'برجر لحم بالجبنة', 20.50, '', 1, '1780324057_burger.jpg.jpg'),
(3, 'عصير كوكتيل طبيعي', 10.00, '', 2, '1780324094_cocktail.jpg.jpg'),
(4, 'كيكة بالشوكلاتة الساخنة', 15.00, '', 3, '1780324144_chocolate_cake.jpg.jpg'),
(5, 'بيتزا إيطالي سوبر بريم ', 25.00, '', 1, '1780324071_pizza.jpg.jpg'),
(6, 'موهيتو بلو بيري', 12.00, '', 2, '1780324108_mohito.jpg.jpg'),
(7, 'لقيمات مقرمشة بالعسل', 10.00, '', 3, '1780324160_luqaimat.jpg.jpg'),
(8, 'تشيز كيك بالفراولة ', 25.00, '', 3, '1780324183_strawberry_cheesecake.jpg.webp'),
(10, 'شاي بالنعناع الأخضر', 5.00, '', 4, '1780324232_tea.jpg.jpg'),
(11, 'قهوة تركية مضبوطة', 7.00, '', 4, '1780324245_coffee.jpg.jpg'),
(12, 'سلطة خضار مشكلة ', 10.00, '', 5, '1780324298_green_salad.jpg.jpg'),
(13, 'شوربة عدس دافئة ', 10.00, '', 7, '1780324434_lentil_soup.jpg.jpg'),
(14, 'بطاطا مقلية عائلية ', 10.00, '', 6, '1780324364_fries.jpg.jpg'),
(15, 'شوربة فطر بالكريمة', 15.00, '', 7, '1780324450_mushroom_soup.jpg.jpg'),
(16, 'زنجر دجاج مقرمش', 18.00, '', 1, '1780324084_zinger.jpg.jpg'),
(17, 'آيس سبانش لاتيه', 14.00, '', 2, '1780324118_iced_lathe.jpg.jpg'),
(18, 'كولا مثلجة', 5.00, '', 2, '1780324130_cola.jpg.webp'),
(19, 'كابتشينو برغوة كثيفة', 12.00, '', 4, '1780324261_cappuccino.jpg.jpg'),
(20, 'سحلب بالمكسرات والقرفة', 10.00, '', 4, '1780324276_sahlab.jpg.jpg'),
(21, 'وافل بنوتيلا وفواكه', 18.00, '', 3, '1780324198_waffle.jpg.jpg'),
(22, 'سلطة سيزر بالدجاج', 10.00, '', 5, '1780324314_caesar_salad.jpg.jpg'),
(23, 'سلطة يونانية بالجبنة', 12.00, '', 5, '1780324330_greek_salad.jpg.jpg'),
(24, 'تبولة لبناني فريش', 10.00, '', 5, '1780324348_tabbouleh.jpg.jpg'),
(25, 'أصابع موزاريلا مقرمشة', 14.00, '', 6, '1780324379_mozzarella_sticks.jpg.webp'),
(26, 'حلقات بصل مقلية', 8.00, '', 6, '1780324393_onion_rings.jpg.jpg'),
(27, 'سمبوسك بالجبنة واللحمة ', 12.00, '', 6, '1780324407_sambousek.jpg.jpg'),
(28, 'شوربة دجاج بالخضار', 12.00, '', 7, '1780324466_chicken_soup.jpg.jpg'),
(29, 'شوربة لسان عصفور', 8.00, '', 7, '1780324514_orzo_soup.jpg.jpg');

-- --------------------------------------------------------

--
-- بنية الجدول `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `menu_item_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','cashier') NOT NULL DEFAULT 'cashier'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '123456', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_item_id` (`menu_item_id`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- قيود الجداول `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- قيود الجداول `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
