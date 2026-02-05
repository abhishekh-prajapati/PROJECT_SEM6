-- Database Setup for LiveQRR (PHP Version)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+05:30";

--
-- Database: `qrify_db`
--
-- You might need to create the database first manually or uncomment the next line:
CREATE DATABASE IF NOT EXISTS `qrify_db`;
USE `qrify_db`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cart_data` longtext NOT NULL CHECK (json_valid(`cart_data`)),
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(5) NOT NULL,
  `category` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(255) DEFAULT '',
  `is_veg` tinyint(1) NOT NULL DEFAULT 1,
  `is_spicy` tinyint(1) NOT NULL DEFAULT 0,
  `rating` decimal(2,1) DEFAULT NULL,
  `bestseller` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `lang_cat` (`lang`, `category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`lang`, `category`, `name`, `price`, `img`, `is_veg`, `is_spicy`) VALUES
-- English (en) - Veg
('en', 'veg', 'Paneer Butter Masala', 210, 'panner_butter_masala.jpg', 1, 0),
('en', 'veg', 'Kadai Paneer', 210, 'kadai_paneer.jpg', 1, 0),
('en', 'veg', 'Shahi Paneer', 230, 'shahi_paneer.jpg', 1, 0),
('en', 'veg', 'Veg Kolhapuri', 200, 'veg_kolhapuri.jpg', 1, 1),
('en', 'veg', 'Mix Veg Curry', 180, 'Mix_Veg_Curry.jpg', 1, 0),
('en', 'veg', 'Dal Tadka', 160, 'dal_tadka.jpg', 1, 0),
('en', 'veg', 'Dal Fry', 150, 'dal_fry.jpg', 1, 0),
('en', 'veg', 'Veg Handi', 190, 'veg_handi.jpg', 1, 0),
('en', 'veg', 'Aloo Gobi', 140, 'aloo_gobi.jpg', 1, 0),
('en', 'veg', 'Jeera Aloo', 130, 'jeera_aloo.jpg', 1, 0),
('en', 'veg', 'Bhindi Masala', 150, 'bhindi_masala.jpg', 1, 0),
('en', 'veg', 'Chole Masala', 160, 'chole_masala.jpg', 1, 0),
('en', 'veg', 'Rajma Masala', 170, 'rajma.jpg', 1, 0),
('en', 'veg', 'Malai Kofta', 240, 'malai_kofta.jpg', 1, 0),
('en', 'veg', 'Veg Thali', 260, 'veg_thali.jpg', 1, 0),

-- English (en) - Non Veg
('en', 'nonveg', 'Chicken Butter Masala', 280, 'Chicken_Butter_Masala.jpg', 0, 0),
('en', 'nonveg', 'Chicken Tikka Masala', 270, 'Chicken_Tikka_Masala.webp', 0, 0),
('en', 'nonveg', 'Chicken Kolhapuri', 260, 'Chicken_Kolhapuri.jpg', 0, 1),
('en', 'nonveg', 'Chicken Handi', 290, 'Chicken_Handi.webp', 0, 0),
('en', 'nonveg', 'Chicken Curry', 240, 'Chicken_Curry.webp', 0, 0),
('en', 'nonveg', 'Chicken Biryani', 300, 'Chicken_Biryani.webp', 0, 0),
('en', 'nonveg', 'Mutton Biryani', 380, 'Mutton_Biryani.webp', 0, 0),
('en', 'nonveg', 'Mutton Curry', 360, 'Mutton_curry.webp', 0, 0),
('en', 'nonveg', 'Egg Curry', 190, 'Egg_Curry.webp', 0, 0),
('en', 'nonveg', 'Egg Masala', 180, 'Egg_Masala.webp', 0, 0),
('en', 'nonveg', 'Fish Curry', 320, 'Fish_Curry.jpg', 0, 0),
('en', 'nonveg', 'Fish Fry', 340, 'Fish_Fry.webp', 0, 0),
('en', 'nonveg', 'Chicken Lollipop', 260, 'Chicken_Lollipop.webp', 0, 0),
('en', 'nonveg', 'Tandoori Chicken', 350, 'Tandoori_Chicken.webp', 0, 0),
('en', 'nonveg', 'Chicken Thali', 330, 'Chicken_Thali.webp', 0, 0),

-- English (en) - Chinese (Assumed Veg unless specified, but name checks logic in app.js handled backend now?)
-- For simplicity, setting is_veg based on name keywords as per app.js logic manually here.
('en', 'chinese', 'Veg Hakka Noodles', 160, 'Veg-Hakka-Noodles.jpg', 1, 0),
('en', 'chinese', 'Veg Fried Rice', 150, 'Veg-Fried-Rice.webp', 1, 0),
('en', 'chinese', 'Veg Manchurian', 170, 'Veg-Manchurian.jpg', 1, 0),
('en', 'chinese', 'Paneer Chilli', 200, 'Panner-Chilli.webp', 1, 1),
('en', 'chinese', 'Veg Spring Roll', 140, 'Veg-Spring-Roll.webp', 1, 0),
('en', 'chinese', 'Chicken Fried Rice', 190, 'Chicken-Fried-Rice.jpg', 0, 0),
('en', 'chinese', 'Chicken Noodles', 200, 'Chicken-Noodles.jpg', 0, 0),
('en', 'chinese', 'Chicken Manchurian', 210, 'Chicken-Manchurian.jpg', 0, 0),
('en', 'chinese', 'Chicken Chilli', 230, 'Chicken-Chilli.jpg', 0, 1),
('en', 'chinese', 'Schezwan Noodles', 180, 'Schezwan-Noodles.webp', 1, 1),
('en', 'chinese', 'Schezwan Rice', 170, 'Schezwan-Rice.jpg', 1, 1),
('en', 'chinese', 'Triple Fried Rice', 220, 'Triple-Fried-Rice.jpg', 1, 0),
('en', 'chinese', 'Honey Chilli Potato', 160, 'Honey-Chilli-Potato.jpg', 1, 1),
('en', 'chinese', 'American Chopsuey', 210, 'American-Chopsuey.jpg', 1, 0),
('en', 'chinese', 'Chinese Bhel', 130, 'Chinese-Bhel.jpg', 1, 0),

-- English (en) - South
('en', 'south', 'Plain Dosa', 120, '', 1, 0),
('en', 'south', 'Masala Dosa', 150, '', 1, 0),
('en', 'south', 'Mysore Dosa', 170, '', 1, 1),
('en', 'south', 'Idli Sambar', 100, '', 1, 0),
('en', 'south', 'Medu Vada', 110, '', 1, 0),
('en', 'south', 'Uttapam', 140, '', 1, 0),
('en', 'south', 'Rava Dosa', 160, '', 1, 0),
('en', 'south', 'Set Dosa', 150, '', 1, 0),
('en', 'south', 'Sambar Rice', 140, '', 1, 0),
('en', 'south', 'Curd Rice', 120, '', 1, 0),
('en', 'south', 'Lemon Rice', 130, '', 1, 0),
('en', 'south', 'Rasam Rice', 120, '', 1, 0),
('en', 'south', 'South Indian Thali', 260, '', 1, 0),
('en', 'south', 'Pongal', 140, '', 1, 0),
('en', 'south', 'Filter Coffee', 60, '', 1, 0),

-- English (en) - Snacks
('en', 'snacks', 'Samosa', 30, '', 1, 0),
('en', 'snacks', 'Kachori', 35, '', 1, 0),
('en', 'snacks', 'Vada Pav', 25, '', 1, 1),
('en', 'snacks', 'Pav Bhaji', 150, '', 1, 1),
('en', 'snacks', 'Misal Pav', 140, '', 1, 1),
('en', 'snacks', 'Bhel Puri', 80, '', 1, 0),
('en', 'snacks', 'Sev Puri', 90, '', 1, 0),
('en', 'snacks', 'Dahi Puri', 100, '', 1, 0),
('en', 'snacks', 'Cheese Sandwich', 120, '', 1, 0),
('en', 'snacks', 'Grilled Sandwich', 130, '', 1, 0),
('en', 'snacks', 'French Fries', 110, '', 1, 0),
('en', 'snacks', 'Cheese Fries', 140, '', 1, 0),
('en', 'snacks', 'Veg Puff', 35, '', 1, 0),
('en', 'snacks', 'Tea', 20, '', 1, 0),
('en', 'snacks', 'Cold Coffee', 90, '', 1, 0),

-- Hindi (hi) - Veg
('hi', 'veg', 'पनीर बटर मसाला', 220, 'panner_butter_masala.jpg', 1, 0),
('hi', 'veg', 'कड़ाई पनीर', 210, 'kadai_paneer.jpg', 1, 0),
('hi', 'veg', 'शाही पनीर', 230, 'shahi_paneer.jpg', 1, 0),
('hi', 'veg', 'वेज कोल्हापुरी', 200, 'veg_kolhapuri.jpg', 1, 1),
('hi', 'veg', 'मिक्स वेज करी', 180, 'Mix_Veg_Curry.jpg', 1, 0),
('hi', 'veg', 'दाल तड़का', 160, 'dal_tadka.jpg', 1, 0),
('hi', 'veg', 'दाल फ्राय', 150, 'dal_fry.jpg', 1, 0),
('hi', 'veg', 'वेज हांडी', 190, 'veg_handi.jpg', 1, 0),
('hi', 'veg', 'आलू गोभी', 140, 'aloo_gobi.jpg', 1, 0),
('hi', 'veg', 'जीरा आलू', 130, 'jeera_aloo.jpg', 1, 0),
('hi', 'veg', 'भिंडी मसाला', 150, 'bhindi_masala.jpg', 1, 0),
('hi', 'veg', 'छोले मसाला', 160, 'chole_masala.jpg', 1, 0),
('hi', 'veg', 'राजमा मसाला', 170, 'rajma.jpg', 1, 0),
('hi', 'veg', 'मलाई कोफ्ता', 240, 'malai_kofta.jpg', 1, 0),
('hi', 'veg', 'वेज थाली', 260, 'veg_thali.jpg', 1, 0),

-- Hindi (hi) - Non Veg
('hi', 'nonveg', 'चिकन बटर मसाला', 280, 'Chicken_Butter_Masala.jpg', 0, 0),
('hi', 'nonveg', 'चिकन टिक्का मसाला', 270, 'Chicken_Tikka_Masala.webp', 0, 0),
('hi', 'nonveg', 'चिकन कोल्हापुरी', 260, 'Chicken_Kolhapuri.jpg', 0, 1),
('hi', 'nonveg', 'चिकन हांडी', 290, 'Chicken_Handi.webp', 0, 0),
('hi', 'nonveg', 'चिकन करी', 240, 'Chicken_Curry.webp', 0, 0),
('hi', 'nonveg', 'चिकन बिरयानी', 300, 'Chicken_Biryani.webp', 0, 0),
('hi', 'nonveg', 'मटन बिरयानी', 380, 'Mutton_Biryani.webp', 0, 0),
('hi', 'nonveg', 'मटन करी', 360, 'Mutton_curry.webp', 0, 0),
('hi', 'nonveg', 'अंडा करी', 190, 'Egg_Curry.webp', 0, 0),
('hi', 'nonveg', 'अंडा मसाला', 180, 'Egg_Masala.webp', 0, 0),
('hi', 'nonveg', 'फिश करी', 320, 'Fish_Curry.jpg', 0, 0),
('hi', 'nonveg', 'फिश फ्राय', 340, 'Fish_Fry.webp', 0, 0),
('hi', 'nonveg', 'चिकन लॉलीपॉप', 260, 'Chicken_Lollipop.webp', 0, 0),
('hi', 'nonveg', 'तंदूरी चिकन', 350, 'Tandoori_Chicken.webp', 0, 0),
('hi', 'nonveg', 'चिकन थाली', 330, 'Chicken_Thali.webp', 0, 0),

-- Hindi (hi) - Chinese
('hi', 'chinese', 'वेज हक्का नूडल्स', 160, 'Veg-Hakka-Noodles.jpg', 1, 0),
('hi', 'chinese', 'वेज फ्राइड राइस', 150, 'Veg-Fried-Rice.webp', 1, 0),
('hi', 'chinese', 'वेज मंचूरियन', 170, 'Veg-Manchurian.jpg', 1, 0),
('hi', 'chinese', 'पनीर चिली', 200, 'Panner-Chilli.webp', 1, 1),
('hi', 'chinese', 'वेज स्प्रिंग रोल', 140, 'Veg-Spring-Roll.webp', 1, 0),
('hi', 'chinese', 'चिकन फ्राइड राइस', 190, 'Chicken-Fried-Rice.jpg', 0, 0),
('hi', 'chinese', 'चिकन नूडल्स', 200, 'Chicken-Noodles.jpg', 0, 0),
('hi', 'chinese', 'चिकन मंचूरियन', 210, 'Chicken-Manchurian.jpg', 0, 0),
('hi', 'chinese', 'चिकन चिली', 230, 'Chicken-Chilli.jpg', 0, 1),
('hi', 'chinese', 'शेजवान नूडल्स', 180, 'Schezwan-Noodles.webp', 1, 1),
('hi', 'chinese', 'शेजवान राइस', 170, 'Schezwan-Rice.jpg', 1, 1),
('hi', 'chinese', 'ट्रिपल फ्राइड राइस', 220, 'Triple-Fried-Rice.jpg', 1, 0),
('hi', 'chinese', 'हनी चिली पोटैटो', 160, 'Honey-Chilli-Potato.jpg', 1, 1),
('hi', 'chinese', 'अमेरिकन चॉप्सुए', 210, 'American-Chopsuey.jpg', 1, 0),
('hi', 'chinese', 'चाइनीज भेल', 130, 'Chinese-Bhel.jpg', 1, 0),

-- Hindi (hi) - South
('hi', 'south', 'प्लेन डोसा', 120, '', 1, 0),
('hi', 'south', 'मसाला डोसा', 150, '', 1, 0),
('hi', 'south', 'मैसूर डोसा', 170, '', 1, 1),
('hi', 'south', 'इडली सांभर', 100, '', 1, 0),
('hi', 'south', 'मेदु वडा', 110, '', 1, 0),
('hi', 'south', 'उत्तपम', 140, '', 1, 0),
('hi', 'south', 'रवा डोसा', 160, '', 1, 0),
('hi', 'south', 'सेट डोसा', 150, '', 1, 0),
('hi', 'south', 'सांभर राइस', 140, '', 1, 0),
('hi', 'south', 'दही चावल', 120, '', 1, 0),
('hi', 'south', 'नींबू चावल', 130, '', 1, 0),
('hi', 'south', 'रसम चावल', 120, '', 1, 0),
('hi', 'south', 'साउथ इंडियन थाली', 260, '', 1, 0),
('hi', 'south', 'पोंगल', 140, '', 1, 0),
('hi', 'south', 'फिल्टर कॉफी', 60, '', 1, 0),

-- Hindi (hi) - Snacks
('hi', 'snacks', 'समोसा', 30, '', 1, 0),
('hi', 'snacks', 'कचौरी', 35, '', 1, 0),
('hi', 'snacks', 'वड़ा पाव', 25, '', 1, 1),
('hi', 'snacks', 'पाव भाजी', 150, '', 1, 1),
('hi', 'snacks', 'मिसल पाव', 140, '', 1, 1),
('hi', 'snacks', 'भेल पूरी', 80, '', 1, 0),
('hi', 'snacks', 'सेव पूरी', 90, '', 1, 0),
('hi', 'snacks', 'दही पूरी', 100, '', 1, 0),
('hi', 'snacks', 'चीज़ सैंडविच', 120, '', 1, 0),
('hi', 'snacks', 'ग्रिल्ड सैंडविच', 130, '', 1, 0),
('hi', 'snacks', 'फ्रेंच फ्राइज', 110, '', 1, 0),
('hi', 'snacks', 'चीज़ फ्राइज', 140, '', 1, 0),
('hi', 'snacks', 'वेज पफ', 35, '', 1, 0),
('hi', 'snacks', 'चाय', 20, '', 1, 0),
('hi', 'snacks', 'कोल्ड कॉफी', 90, '', 1, 0),

-- Marathi (mr) - Veg
('mr', 'veg', 'पनीर बटर मसाला', 220, 'panner_butter_masala.jpg', 1, 0),
('mr', 'veg', 'कढई पनीर', 210, 'kadai_paneer.jpg', 1, 0),
('mr', 'veg', 'शाही पनीर', 230, 'shahi_paneer.jpg', 1, 0),
('mr', 'veg', 'वेज कोल्हापुरी', 200, 'veg_kolhapuri.jpg', 1, 1),
('mr', 'veg', 'मिक्स वेज भाजी', 180, 'Mix_Veg_Curry.jpg', 1, 0),
('mr', 'veg', 'डाळ तडका', 160, 'dal_tadka.jpg', 1, 0),
('mr', 'veg', 'डाळ फ्राय', 150, 'dal_fry.jpg', 1, 0),
('mr', 'veg', 'वेज हांडी', 190, 'veg_handi.jpg', 1, 0),
('mr', 'veg', 'आलू गोबी', 140, 'aloo_gobi.jpg', 1, 0),
('mr', 'veg', 'जिरा आलू', 130, 'jeera_aloo.jpg', 1, 0),
('mr', 'veg', 'भेंडी मसाला', 150, 'bhindi_masala.jpg', 1, 0),
('mr', 'veg', 'छोले मसाला', 160, 'chole_masala.jpg', 1, 0),
('mr', 'veg', 'राजमा मसाला', 170, 'rajma.jpg', 1, 0),
('mr', 'veg', 'मलाई कोफ्ता', 240, 'malai_kofta.jpg', 1, 0),
('mr', 'veg', 'वेज थाळी', 260, 'veg_thali.jpg', 1, 0),

-- Marathi (mr) - Non Veg
('mr', 'nonveg', 'चिकन बटर मसाला', 280, 'Chicken_Butter_Masala.jpg', 0, 0),
('mr', 'nonveg', 'चिकन टिक्का मसाला', 270, 'Chicken_Tikka_Masala.webp', 0, 0),
('mr', 'nonveg', 'चिकन कोल्हापुरी', 260, 'Chicken_Kolhapuri.jpg', 0, 1),
('mr', 'nonveg', 'चिकन हांडी', 290, 'Chicken_Handi.webp', 0, 0),
('mr', 'nonveg', 'चिकन रस्सा', 240, 'Chicken_Curry.webp', 0, 0),
('mr', 'nonveg', 'चिकन बिर्याणी', 300, 'Chicken_Biryani.webp', 0, 0),
('mr', 'nonveg', 'मटण बिर्याणी', 380, 'Mutton_Biryani.webp', 0, 0),
('mr', 'nonveg', 'मटण रस्सा', 360, 'Mutton_curry.webp', 0, 0),
('mr', 'nonveg', 'अंडा करी', 190, 'Egg_Curry.webp', 0, 0),
('mr', 'nonveg', 'अंडा मसाला', 180, 'Egg_Masala.webp', 0, 0),
('mr', 'nonveg', 'फिश करी', 320, 'Fish_Curry.jpg', 0, 0),
('mr', 'nonveg', 'फिश फ्राय', 340, 'Fish_Fry.webp', 0, 0),
('mr', 'nonveg', 'चिकन लॉलीपॉप', 260, 'Chicken_Lollipop.webp', 0, 0),
('mr', 'nonveg', 'तंदूरी चिकन', 350, 'Tandoori_Chicken.webp', 0, 0),
('mr', 'nonveg', 'चिकन थाळी', 330, 'Chicken_Thali.webp', 0, 0),

-- Marathi (mr) - Chinese
('mr', 'chinese', 'वेज हक्का नूडल्स', 160, 'Veg-Hakka-Noodles.jpg', 1, 0),
('mr', 'chinese', 'वेज फ्राइड राईस', 150, 'Veg-Fried-Rice.webp', 1, 0),
('mr', 'chinese', 'वेज मंचुरियन', 170, 'Veg-Manchurian.jpg', 1, 0),
('mr', 'chinese', 'पनीर चिली', 200, 'Panner-Chilli.webp', 1, 1),
('mr', 'chinese', 'वेज स्प्रिंग रोल', 140, 'Veg-Spring-Roll.webp', 1, 0),
('mr', 'chinese', 'चिकन फ्राइड राईस', 190, 'Chicken-Fried-Rice.jpg', 0, 0),
('mr', 'chinese', 'चिकन नूडल्स', 200, 'Chicken-Noodles.jpg', 0, 0),
('mr', 'chinese', 'चिकन मंचुरियन', 210, 'Chicken-Manchurian.jpg', 0, 0),
('mr', 'chinese', 'चिकन चिली', 230, 'Chicken-Chilli.jpg', 0, 1),
('mr', 'chinese', 'शेजवान नूडल्स', 180, 'Schezwan-Noodles.webp', 1, 1),
('mr', 'chinese', 'शेजवान राईस', 170, 'Schezwan-Rice.jpg', 1, 1),
('mr', 'chinese', 'ट्रिपल फ्राइड राईस', 220, 'Triple-Fried-Rice.jpg', 1, 0),
('mr', 'chinese', 'हनी चिली पोटॅटो', 160, 'Honey-Chilli-Potato.jpg', 1, 1),
('mr', 'chinese', 'अमेरिकन चॉप्सुए', 210, 'American-Chopsuey.jpg', 1, 0),
('mr', 'chinese', 'चायनीज भेल', 130, 'Chinese-Bhel.jpg', 1, 0),

-- Marathi (mr) - South
('mr', 'south', 'साधा डोसा', 120, '', 1, 0),
('mr', 'south', 'मसाला डोसा', 150, '', 1, 0),
('mr', 'south', 'मैसूर डोसा', 170, '', 1, 1),
('mr', 'south', 'इडली सांबार', 100, '', 1, 0),
('mr', 'south', 'मेदू वडा', 110, '', 1, 0),
('mr', 'south', 'उत्तपम', 140, '', 1, 0),
('mr', 'south', 'रवा डोसा', 160, '', 1, 0),
('mr', 'south', 'सेट डोसा', 150, '', 1, 0),
('mr', 'south', 'सांबार राईस', 140, '', 1, 0),
('mr', 'south', 'दही भात', 120, '', 1, 0),
('mr', 'south', 'लिंबू भात', 130, '', 1, 0),
('mr', 'south', 'रसम भात', 120, '', 1, 0),
('mr', 'south', 'साउथ इंडियन थाळी', 260, '', 1, 0),
('mr', 'south', 'पोंगल', 140, '', 1, 0),
('mr', 'south', 'फिल्टर कॉफी', 60, '', 1, 0),

-- Marathi (mr) - Snacks
('mr', 'snacks', 'समोसा', 30, '', 1, 0),
('mr', 'snacks', 'कचोरी', 35, '', 1, 0),
('mr', 'snacks', 'वडापाव', 25, '', 1, 1),
('mr', 'snacks', 'पाव भाजी', 150, '', 1, 1),
('mr', 'snacks', 'मिसळ पाव', 140, '', 1, 1),
('mr', 'snacks', 'भेळपुरी', 80, '', 1, 0),
('mr', 'snacks', 'सेवपुरी', 90, '', 1, 0),
('mr', 'snacks', 'दहीपुरी', 100, '', 1, 0),
('mr', 'snacks', 'चीज सँडविच', 120, '', 1, 0),
('mr', 'snacks', 'ग्रिल्ड सँडविच', 130, '', 1, 0),
('mr', 'snacks', 'फ्रेंच फ्राइज', 110, '', 1, 0),
('mr', 'snacks', 'चीज फ्राइज', 140, '', 1, 0),
('mr', 'snacks', 'वेज पफ', 35, '', 1, 0),
('mr', 'snacks', 'चहा', 20, '', 1, 0),
('mr', 'snacks', 'कोल्ड कॉफी', 90, '', 1, 0);

COMMIT;
