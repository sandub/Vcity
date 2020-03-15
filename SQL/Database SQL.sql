-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

CREATE TABLE `casino_prizes` (
  `id` int(11) NOT NULL,
  `prizetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` int(11) NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `casino_prizes` (`id`, `prizetype`, `value`, `color`) VALUES
(1, 'Money', 1500, '#18d23e'),
(2, 'Gold', 15, 'orange'),
(3, 'Respect', 300, '#dd30cf'),
(4, 'Energy', 100, '#21cece'),
(5, 'Health', 100, 'red'),
(6, 'Money', 5000, '#18d23e'),
(7, 'Gold', 5, 'orange');

-- --------------------------------------------------------

CREATE TABLE `characters` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'assets/img/characters/female/',
  `category_id` int(11) NOT NULL DEFAULT '2',
  `power` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `agility` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `endurance` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `intelligence` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `characters` (`id`, `name`, `image`, `category_id`, `power`, `agility`, `endurance`, `intelligence`) VALUES
(1, 'Businessman', 'images/characters/male/businessman.png', 1, 'No', 'No', 'Yes', 'Yes'),
(2, 'Doctor', 'images/characters/male/doctor.png', 1, 'No', 'No', 'Yes', 'Yes'),
(3, 'Builder', 'images/characters/male/builder.png', 1, 'Yes', 'No', 'Yes', 'No'),
(4, 'Policeman', 'images/characters/male/policeman.png', 1, 'Yes', 'No', 'Yes', 'No'),
(5, 'Singer', 'images/characters/male/singer.png', 1, 'No', 'Yes', 'Yes', 'No'),
(6, 'Courier', 'images/characters/male/courier.png', 1, 'Yes', 'No', 'Yes', 'No'),
(7, 'Programmer', 'images/characters/male/programmer.png', 1, 'No', 'No', 'Yes', 'Yes'),
(8, 'Superhero', 'images/characters/male/superhero.png', 1, 'Yes', 'Yes', 'Yes', 'No'),
(9, 'Businesswoman', 'images/characters/female/businesswoman.png', 2, 'No', 'No', 'Yes', 'Yes'),
(10, 'Doctor', 'images/characters/female/doctor.png', 2, 'No', 'No', 'Yes', 'Yes'),
(11, 'Chef', 'images/characters/female/chef.png', 2, 'No', 'Yes', 'Yes', 'No'),
(12, 'Model', 'images/characters/female/model.png', 2, 'No', 'Yes', 'Yes', 'No'),
(13, 'Programmer', 'images/characters/female/programmer.png', 2, 'No', 'No', 'Yes', 'Yes'),
(14, 'Secretary', 'images/characters/female/secretary.png', 2, 'No', 'Yes', 'No', 'Yes'),
(15, 'Teacher', 'images/characters/female/teacher.png', 2, 'No', 'No', 'Yes', 'Yes');

-- --------------------------------------------------------

CREATE TABLE `character_categories` (
  `id` int(11) NOT NULL,
  `fa_icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `character_categories` (`id`, `fa_icon`, `category`) VALUES
(1, 'fa-male', 'Male Characters'),
(2, 'fa-female', 'Female Characters');

-- --------------------------------------------------------

CREATE TABLE `fights` (
  `id` int(11) NOT NULL,
  `playera_id` int(11) NOT NULL,
  `playerb_id` int(11) NOT NULL,
  `winner_id` int(11) NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `garages` (
  `id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images/backgrounds/garages/.jpg',
  `money` int(11) NOT NULL,
  `gold` int(11) NOT NULL,
  `min_level` int(11) NOT NULL DEFAULT '1',
  `respect` int(11) NOT NULL,
  `vip` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `max_vehicles` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `garages` (`id`, `image`, `money`, `gold`, `min_level`, `respect`, `vip`, `max_vehicles`) VALUES
(1, 'images/backgrounds/garages/1.jpg', 5000, 0, 1, 1000, 'No', 1),
(2, 'images/backgrounds/garages/2.jpg', 12500, 1, 3, 3000, 'No', 2),
(3, 'images/backgrounds/garages/3.jpg', 20000, 4, 6, 8500, 'No', 3),
(4, 'images/backgrounds/garages/4.jpg', 36000, 12, 9, 14200, 'No', 4),
(5, 'images/backgrounds/garages/5.jpg', 50000, 20, 14, 16000, 'Yes', 6);

-- --------------------------------------------------------

CREATE TABLE `global_chat` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `gym` (
  `id` int(11) NOT NULL,
  `workout_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `power` int(11) NOT NULL,
  `agility` int(11) NOT NULL,
  `endurance` int(11) NOT NULL,
  `energy_cost` int(11) NOT NULL,
  `health_restore` int(11) NOT NULL,
  `fee` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `gym` (`id`, `workout_type`, `power`, `agility`, `endurance`, `energy_cost`, `health_restore`, `fee`, `time`, `format`) VALUES
(1, 'Stretching', 0, 5, 2, 10, 15, 150, 15, 'Minutes'),
(2, 'Short Workout', 2, 0, 1, 20, 30, 300, 30, 'Minutes'),
(3, 'Normal Workout', 4, 0, 2, 30, 45, 500, 1, 'Hours'),
(4, 'Full Workout', 6, 3, 4, 70, 80, 650, 2, 'Hours');

-- --------------------------------------------------------

CREATE TABLE `hangars` (
  `id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images/backgrounds/hangars/.jpg',
  `money` int(11) NOT NULL,
  `gold` int(11) NOT NULL DEFAULT '15',
  `min_level` int(11) NOT NULL DEFAULT '5',
  `respect` int(11) NOT NULL DEFAULT '5000',
  `vip` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `max_vehicles` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `hangars` (`id`, `image`, `money`, `gold`, `min_level`, `respect`, `vip`, `max_vehicles`) VALUES
(1, 'images/backgrounds/hangars/1.jpg', 40000, 15, 7, 5000, 'No', 1),
(2, 'images/backgrounds/hangars/2.jpg', 85000, 34, 15, 15000, 'Yes', 3);

-- --------------------------------------------------------

CREATE TABLE `homes` (
  `id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images/backgrounds/homes/.jpg',
  `money` int(11) NOT NULL,
  `gold` int(11) NOT NULL DEFAULT '0',
  `min_level` int(11) NOT NULL DEFAULT '1',
  `respect` int(11) NOT NULL DEFAULT '300',
  `vip` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `max_pets` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `homes` (`id`, `image`, `money`, `gold`, `min_level`, `respect`, `vip`, `max_pets`) VALUES
(1, 'images/backgrounds/homes/1.jpg', 500, 0, 1, 300, 'No', 0),
(2, 'images/backgrounds/homes/2.jpg', 1500, 0, 1, 300, 'No', 1),
(3, 'images/backgrounds/homes/3.jpg', 3000, 0, 2, 300, 'No', 1),
(4, 'images/backgrounds/homes/4.jpg', 5200, 2, 4, 300, 'No', 1),
(5, 'images/backgrounds/homes/5.jpg', 10800, 4, 6, 300, 'No', 1),
(6, 'images/backgrounds/homes/6.jpg', 24300, 5, 8, 300, 'No', 2),
(7, 'images/backgrounds/homes/7.jpg', 30000, 10, 10, 300, 'No', 2),
(8, 'images/backgrounds/homes/8.jpg', 45000, 15, 14, 300, 'No', 2),
(9, 'images/backgrounds/homes/9.jpg', 58000, 20, 16, 300, 'Yes', 2),
(10, 'images/backgrounds/homes/10.jpg', 64200, 45, 18, 300, 'No', 3),
(11, 'images/backgrounds/homes/11.jpg', 76300, 50, 19, 300, 'Yes', 3),
(12, 'images/backgrounds/homes/12.jpg', 88000, 70, 19, 300, 'No', 3),
(13, 'images/backgrounds/homes/13.jpg', 150000, 100, 20, 300, 'Yes', 3);

-- --------------------------------------------------------

CREATE TABLE `hospital` (
  `id` int(11) NOT NULL,
  `fa_icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `treatment_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cost` int(11) NOT NULL,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `health_restore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `hospital` (`id`, `fa_icon`, `treatment_type`, `cost`, `format`, `time`, `health_restore`) VALUES
(1, 'fa-medkit', 'Therapy', 250, 'Minutes', 30, 50),
(2, 'fa-heartbeat', 'Full Treatment', 500, 'Hours', 1, 100);

-- --------------------------------------------------------

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT '3',
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images/shoes/hats/-shoes.png',
  `bonustype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'endurance',
  `bonusvalue` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `gold` int(11) NOT NULL DEFAULT '0',
  `respect` int(11) NOT NULL,
  `min_level` int(11) NOT NULL DEFAULT '1',
  `vip` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `items` (`id`, `item`, `category_id`, `image`, `bonustype`, `bonusvalue`, `money`, `gold`, `respect`, `min_level`, `vip`) VALUES
(1, 'Baseball Bat', 9, 'images/items/weapons/baseball-bat.png', 'power', 1, 150, 0, 100, 1, 'No'),
(2, 'Brass Knuckles', 9, 'images/items/weapons/brass-knuckles.png', 'power', 2, 200, 0, 250, 2, 'No'),
(3, 'Shovel', 9, 'images/items/weapons/shovel.png', 'power', 2, 250, 0, 250, 2, 'No'),
(4, 'Nightstick', 9, 'images/items/weapons/nightstick.png', 'power', 2, 300, 0, 250, 2, 'No'),
(5, 'Butcher Knife', 9, 'images/items/weapons/butcher-knife.png', 'power', 3, 800, 1, 250, 3, 'No'),
(6, 'Knife', 9, 'images/items/weapons/knife.png', 'power', 3, 1000, 0, 500, 4, 'No'),
(7, 'Knife', 9, 'images/items/weapons/lknife.png', 'power', 3, 1800, 0, 1000, 5, 'No'),
(8, 'Katana', 9, 'images/items/weapons/katana.png', 'power', 3, 2500, 2, 2000, 6, 'No'),
(9, 'Cocktail Molotov', 9, 'images/items/weapons/cocktail-molotov.png', 'power', 4, 3000, 1, 3000, 7, 'No'),
(10, 'Chainsaw', 9, 'images/items/weapons/chainsaw.png', 'power', 4, 3500, 1, 4500, 8, 'No'),
(11, 'Flamethrower', 9, 'images/items/weapons/flamethrower.png', 'power', 5, 4000, 1, 6000, 9, 'Yes'),
(12, 'Grenade', 9, 'images/items/weapons/grenade.png', 'power', 5, 4500, 5, 8500, 10, 'No'),
(13, 'Pistol', 9, 'images/items/weapons/pistol.png', 'power', 6, 5200, 6, 8940, 12, 'No'),
(14, 'Pistol #2', 9, 'images/items/weapons/pistol2.png', 'power', 7, 6400, 7, 9000, 14, 'No'),
(15, 'Pistol #3', 9, 'images/items/weapons/pistol3.png', 'power', 8, 8000, 8, 10000, 16, 'No'),
(16, 'Shotgun', 9, 'images/items/weapons/shotgun.png', 'power', 9, 9100, 9, 11000, 18, 'No'),
(17, 'SMG', 9, 'images/items/weapons/smg.png', 'power', 10, 10500, 10, 12000, 20, 'No'),
(18, 'AK-47', 9, 'images/items/weapons/rifle.png', 'power', 15, 11000, 12, 13500, 22, 'No'),
(19, 'M4A1 Carbine', 9, 'images/items/weapons/rifle2.png', 'power', 18, 12500, 15, 13800, 24, 'No'),
(20, 'Sniper', 9, 'images/items/weapons/sniper.png', 'power', 25, 14900, 18, 14000, 26, 'Yes'),
(21, 'Minigun', 9, 'images/items/weapons/minigun.png', 'power', 30, 20000, 20, 14150, 28, 'Yes'),
(22, 'Rocket Launcher', 9, 'images/items/weapons/rocket-launcher.png', 'power', 45, 28450, 30, 15000, 29, 'No'),
(23, 'Cross Necklace', 5, 'images/items/amulets/cross-necklace.png', 'endurance', 2, 500, 0, 250, 3, 'No'),
(24, 'Heart Necklace', 5, 'images/items/amulets/heart-necklace.png', 'endurance', 5, 1000, 1, 500, 7, 'No'),
(25, 'Heart Necklace #2', 5, 'images/items/amulets/heart-necklace2.png', 'endurance', 10, 2500, 5, 3500, 10, 'No'),
(26, 'Medal Necklace', 5, 'images/items/amulets/medal-necklace.png', 'endurance', 15, 5000, 10, 5600, 12, 'No'),
(27, 'Necklace', 5, 'images/items/amulets/necklace.png', 'endurance', 20, 8500, 20, 8300, 15, 'Yes'),
(28, 'Paper Bag', 4, 'images/items/bags/paper-bag.png', 'agility', 5, 500, 0, 900, 2, 'No'),
(29, 'Bag', 4, 'images/items/bags/bag.png', 'agility', 10, 1000, 5, 3400, 5, 'No'),
(30, 'Bag #2', 4, 'images/items/bags/bag2.png', 'agility', 15, 3500, 8, 5000, 9, 'No'),
(31, 'Briefcase', 4, 'images/items/bags/briefcase.png', 'agility', 20, 5000, 10, 7010, 13, 'Yes'),
(32, 'Backpack', 4, 'images/items/bags/backpack.png', 'agility', 30, 6500, 20, 9467, 18, 'No'),
(33, 'Underwear', 1, 'images/items/clothes/underwear.png', 'agility', 2, 150, 0, 500, 1, 'No'),
(34, 'Underwear', 1, 'images/items/clothes/underwear2.png', 'agility', 2, 150, 0, 500, 1, 'No'),
(35, 'T-Shirt', 1, 'images/items/clothes/shirt.gif', 'agility', 6, 420, 1, 1000, 3, 'No'),
(36, 'Tracksuit', 1, 'images/items/clothes/tracksuit.png', 'agility', 6, 420, 1, 1000, 3, 'No'),
(37, 'Blouse', 1, 'images/items/clothes/blouse.png', 'agility', 8, 840, 2, 2000, 5, 'No'),
(38, 'Skirt', 1, 'images/items/clothes/skirt.png', 'agility', 8, 840, 2, 5000, 5, 'No'),
(39, 'Shirt', 1, 'images/items/clothes/shirt.png', 'agility', 10, 1600, 5, 8000, 8, 'No'),
(40, 'Dress', 1, 'images/items/clothes/dress.png', 'agility', 10, 1600, 5, 10000, 10, 'No'),
(41, 'Glasses', 1, 'images/items/clothes/glasses.png', 'agility', 5, 3800, 10, 12000, 11, 'No'),
(42, 'Pants', 1, 'images/items/clothes/pants.png', 'agility', 10, 3800, 10, 14000, 14, 'No'),
(43, 'Black Glasses', 1, 'images/items/clothes/black-glasses.png', 'agility', 8, 5840, 15, 16000, 16, 'Yes'),
(44, 'Jacket', 1, 'images/items/clothes/jacket.png', 'agility', 15, 6410, 20, 18000, 20, 'No'),
(45, 'Jeans', 1, 'images/items/clothes/jeans.png', 'agility', 12, 8910, 25, 20000, 21, 'No'),
(46, 'Coat', 1, 'images/items/clothes/coat.png', 'agility', 15, 10674, 30, 22000, 23, 'No'),
(47, 'Vest', 1, 'images/items/clothes/vest.png', 'endurance', 15, 12455, 35, 24000, 24, 'No'),
(48, 'Suit', 1, 'images/items/clothes/suit.png', 'agility', 20, 13500, 40, 25500, 26, 'Yes'),
(49, 'Headphones', 6, 'images/items/devices/headphones.png', 'intelligence', 5, 1500, 1, 2700, 5, 'No'),
(50, 'TV', 6, 'images/items/devices/tv.png', 'intelligence', 10, 3000, 3, 3890, 7, 'No'),
(51, 'Smartphone', 6, 'images/items/devices/smartphone.png', 'intelligence', 15, 5500, 5, 5000, 9, 'No'),
(52, 'Computer', 6, 'images/items/devices/computer.png', 'intelligence', 25, 7200, 10, 7055, 11, 'No'),
(53, 'Laptop', 6, 'images/items/devices/laptop.png', 'intelligence', 30, 9850, 15, 9420, 13, 'Yes'),
(54, 'Tablet', 6, 'images/items/devices/tablet.png', 'intelligence', 20, 10720, 20, 12000, 15, 'No'),
(55, 'Tea', 8, 'images/items/drinks/tea.png', 'energy', 5, 250, 0, 500, 1, 'No'),
(56, 'Frappe', 8, 'images/items/drinks/frappe.png', 'energy', 10, 500, 0, 1000, 1, 'No'),
(57, 'Beer', 8, 'images/items/drinks/beer.png', 'energy', 15, 1000, 0, 1500, 2, 'No'),
(58, 'Milk', 8, 'images/items/drinks/milk.png', 'energy', 20, 1500, 0, 2000, 2, 'No'),
(59, 'Soft Drink', 8, 'images/items/drinks/soft-drink.png', 'energy', 25, 2000, 1, 2200, 3, 'No'),
(60, 'Alcohol', 8, 'images/items/drinks/alcohol.png', 'energy', 30, 3500, 2, 2400, 5, 'No'),
(61, 'Wine', 8, 'images/items/drinks/wine.png', 'energy', 40, 4200, 3, 2600, 7, 'Yes'),
(62, 'Helmet', 10, 'images/items/equipment/helmet.png', 'endurance', 5, 1700, 0, 1500, 3, 'No'),
(63, 'Helmet #2', 10, 'images/items/equipment/helmet2.png', 'endurance', 10, 2500, 1, 3000, 6, 'No'),
(64, 'King Helmet', 10, 'images/items/equipment/king-helmet.png', 'endurance', 15, 3410, 5, 4500, 9, 'No'),
(65, 'War Helmet', 10, 'images/items/equipment/war-helmet.png', 'endurance', 20, 5300, 10, 6005, 14, 'Yes'),
(66, 'Bulletproof Vest', 10, 'images/items/equipment/bulletproof-vest.png', 'endurance', 25, 6700, 16, 7510, 18, 'No'),
(67, 'Shield', 10, 'images/items/equipment/shield.png', 'endurance', 30, 9200, 29, 9410, 24, 'Yes'),
(68, 'Apple', 7, 'images/items/food/apple.png', 'energy', 5, 250, 0, 500, 1, 'No'),
(69, 'Soup', 7, 'images/items/food/soup.png', 'energy', 7, 420, 0, 750, 2, 'No'),
(70, 'Bread', 7, 'images/items/food/bread.png', 'energy', 10, 640, 0, 1000, 3, 'No'),
(71, 'Fast Food', 7, 'images/items/food/fast-food.png', 'energy', 13, 800, 0, 1250, 4, 'No'),
(72, 'Orange', 7, 'images/items/food/orange.png', 'energy', 15, 1200, 1, 1500, 5, 'No'),
(73, 'Eggs', 7, 'images/items/food/eggs.png', 'health', 17, 2500, 1, 1750, 6, 'No'),
(74, 'Bacon', 7, 'images/items/food/bacon.png', 'energy', 20, 3000, 2, 2000, 7, 'No'),
(75, 'Cake', 7, 'images/items/food/cake.png', 'energy', 25, 3750, 2, 2250, 8, 'Yes'),
(76, 'Fish', 7, 'images/items/food/fish.png', 'health', 30, 5000, 4, 3100, 9, 'Yes'),
(77, 'Baseball Cap', 2, 'images/items/hats/baseball-cap.png', 'agility', 5, 2400, 0, 900, 3, 'No'),
(78, 'Cultures Hat', 2, 'images/items/hats/cultures-hat.png', 'agility', 10, 3500, 1, 1400, 5, 'No'),
(79, 'Hawaiian Hat', 2, 'images/items/hats/hawaiian-hat.png', 'agility', 15, 4210, 3, 2400, 9, 'No'),
(80, 'Fedora', 2, 'images/items/hats/fedora-hat.png', 'agility', 20, 6740, 5, 3940, 12, 'No'),
(81, 'Christmas Hat', 2, 'images/items/hats/christmas-hat.png', 'agility', 25, 8300, 10, 4660, 15, 'Yes'),
(82, 'Pilot Hat', 2, 'images/items/hats/pilot-hat.png', 'agility', 30, 9420, 15, 5800, 21, 'No'),
(83, 'Rubber Shoes', 3, 'images/items/shoes/rubber-shoes.png', 'endurance', 5, 670, 0, 350, 2, 'No'),
(84, 'Shoes', 3, 'images/items/shoes/shoes.png', 'endurance', 10, 1200, 1, 500, 3, 'No'),
(85, 'Flamenco Shoes', 3, 'images/items/shoes/flamenco-shoes.png', 'endurance', 15, 2300, 2, 1700, 5, 'Yes'),
(86, 'Sport Shoes', 3, 'images/items/shoes/sport-shoes.png', 'endurance', 20, 4000, 4, 2640, 7, 'No'),
(87, 'Lady Shoes', 3, 'images/items/shoes/lady-shoes.png', 'endurance', 25, 5900, 6, 3040, 10, 'No'),
(88, 'Winter Shoes', 3, 'images/items/shoes/winter-shoes.png', 'endurance', 30, 7250, 10, 4700, 15, 'Yes');

-- --------------------------------------------------------

CREATE TABLE `item_categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fa_icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `item_categories` (`id`, `category`, `fa_icon`) VALUES
(1, 'Clothes', 'fa-male'),
(2, 'Hats', 'fa-graduation-cap'),
(3, 'Shoes', 'fa-tags'),
(4, 'Bags', 'fa-briefcase'),
(5, 'Amulets', 'fa-bolt'),
(6, 'Devices', 'fa-desktop'),
(7, 'Food', 'fa-utensils'),
(8, 'Drinks', 'fa-coffee'),
(9, 'Weapons', 'fa-gavel'),
(10, 'Equipment', 'fa-shield-alt');

-- --------------------------------------------------------

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `job_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `energy_cost` int(11) NOT NULL,
  `health_loss` int(11) NOT NULL,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` int(11) NOT NULL,
  `gold` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `jobs` (`id`, `job_type`, `energy_cost`, `health_loss`, `format`, `time`, `money`, `gold`) VALUES
(1, 'Part-Time Job', 40, 20, 'Hours', '4', 1600, 0),
(2, 'Full-Time Job', 60, 40, 'Hours', '8', 3200, 1),
(3, 'Temporary / Seasonal Work', 100, 60, 'Hours', '24', 8100, 4),
(4, 'Project', 80, 50, 'Hours', '16', 5300, 2);

-- --------------------------------------------------------

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `langcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default_language` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `languages` (`id`, `language`, `langcode`, `default_language`) VALUES
(1, 'English', 'en', 'Yes'),
(2, 'Български', 'bg', 'No');

-- --------------------------------------------------------

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `min_respect` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `levels` (`id`, `level`, `min_respect`) VALUES
(1, 1, 0),
(2, 2, 500),
(3, 3, 1000),
(4, 4, 1500),
(5, 5, 3000),
(6, 6, 5000),
(7, 7, 7500),
(8, 8, 9780),
(9, 9, 13500),
(10, 10, 18200),
(11, 11, 23400),
(12, 12, 27000),
(13, 13, 32000),
(14, 14, 36000),
(15, 15, 39900),
(16, 16, 42000),
(17, 17, 45720),
(18, 18, 48400),
(19, 19, 50100),
(20, 20, 57000),
(21, 21, 60000),
(22, 22, 75000),
(23, 23, 80000),
(24, 24, 90000),
(25, 25, 100000),
(26, 26, 125000),
(27, 27, 136000),
(28, 28, 140000),
(29, 29, 145000),
(30, 30, 150000);

-- --------------------------------------------------------

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `fromid` int(11) NOT NULL,
  `toid` int(11) NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `viewed` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `paid_services` (
  `id` int(11) NOT NULL,
  `service` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images/icons/',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'EUR'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `paid_services` (`id`, `service`, `image`, `type`, `amount`, `cost`, `currency`) VALUES
(1, 'Cash Pack [Mini]', 'images/icons/cash1.png', 'getmoney', 25000, 2, 'EUR'),
(2, 'Cash Pack [Small]', 'images/icons/cash2.png', 'getmoney', 50000, 4, 'EUR'),
(3, 'Cash Pack [Big]', 'images/icons/cash3.png', 'getmoney', 125000, 9, 'EUR'),
(4, 'Cash Pack [Large]', 'images/icons/cash4.png', 'getmoney', 580000, 15, 'EUR'),
(5, 'Gold Pack [Mini]', 'images/icons/gold1.png', 'getgold', 60, 2, 'EUR'),
(6, 'Gold Pack [Small]', 'images/icons/gold2.png', 'getgold', 185, 4, 'EUR'),
(7, 'Gold Pack [Big]', 'images/icons/gold3.png', 'getgold', 525, 9, 'EUR'),
(8, 'Gold Pack [Large]', 'images/icons/gold4.png', 'getgold', 2500, 15, 'USD'),
(9, 'Energy Pack', 'images/icons/energy.png', 'energyrefill', 100, 2, 'EUR'),
(10, 'VIP Status', 'images/icons/vip.png', 'vip', 1, 8, 'EUR');

-- --------------------------------------------------------

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `txn_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `pets` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images/pets/',
  `money` int(11) NOT NULL,
  `gold` int(11) NOT NULL DEFAULT '0',
  `respect` int(11) NOT NULL,
  `min_level` int(11) NOT NULL DEFAULT '1',
  `bonustype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bonusvalue` int(11) NOT NULL DEFAULT '10',
  `vip` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `pets` (`id`, `name`, `image`, `money`, `gold`, `respect`, `min_level`, `bonustype`, `bonusvalue`, `vip`) VALUES
(1, 'Cat', 'images/pets/cat.png', 500, 0, 500, 1, 'agility', 5, 'No'),
(2, 'Dog', 'images/pets/dog.png', 3000, 1, 3800, 2, 'power', 5, 'No'),
(3, 'Bolt', 'images/pets/robot1.png', 6800, 2, 7120, 6, 'endurance', 10, 'No'),
(4, 'Robotron', 'images/pets/robot2.png', 15100, 8, 10100, 10, 'intelligence', 10, 'No'),
(5, 'Maxx', 'images/pets/robot3.png', 45000, 30, 12860, 15, 'endurance', 15, 'No'),
(6, 'Norbit', 'images/pets/robot4.png', 81000, 45, 15000, 19, 'power', 15, 'Yes');

-- --------------------------------------------------------

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images/icons/default-avatar.jpg',
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Player',
  `level` int(11) NOT NULL DEFAULT '1',
  `money` int(11) NOT NULL DEFAULT '1500',
  `gold` int(11) NOT NULL DEFAULT '20',
  `respect` int(11) NOT NULL DEFAULT '0',
  `health` int(11) NOT NULL DEFAULT '100',
  `energy` int(11) NOT NULL DEFAULT '100',
  `power` int(11) NOT NULL DEFAULT '0',
  `agility` int(11) NOT NULL DEFAULT '0',
  `endurance` int(11) NOT NULL DEFAULT '0',
  `intelligence` int(11) NOT NULL DEFAULT '0',
  `character_id` int(11) NOT NULL DEFAULT '0',
  `home_id` int(11) NOT NULL DEFAULT '1',
  `garage_id` int(11) NOT NULL DEFAULT '0',
  `hangar_id` int(11) NOT NULL DEFAULT '0',
  `quay_id` int(11) NOT NULL DEFAULT '0',
  `bank` int(11) NOT NULL DEFAULT '0',
  `spins` int(11) NOT NULL DEFAULT '2',
  `theme` int(11) NOT NULL DEFAULT '1',
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timeonline` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `players` (`id`, `username`, `password`, `email`, `avatar`, `role`, `level`, `money`, `gold`, `respect`, `health`, `energy`, `power`, `agility`, `endurance`, `intelligence`, `character_id`, `home_id`, `garage_id`, `hangar_id`, `quay_id`, `bank`, `spins`, `theme`, `language`, `timeonline`) VALUES
(1, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin@mail.com', 'images/icons/default-avatar.jpg', 'Admin', 5, 407790, 1911, 4800, 100, 90, 70, 20, 12, 38, 8, 6, 1, 1, 0, 0, 0, 1, 'en', '1518112714'),
(2, 'demo', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'demo@mail.com', 'images/icons/default-avatar.jpg', 'Player', 4, 2425, 4, 1625, 100, 100, 10, 0, 10, 0, 6, 1, 0, 0, 0, 0, 2, 1, 'en', '1517591500');

-- --------------------------------------------------------

CREATE TABLE `player_actions` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `finishtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `player_comments` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `player_items` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `player_pets` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `player_properties` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `profittime` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `player_vehicles` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  `acceleration` int(11) NOT NULL,
  `stability` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `property` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images/properties/',
  `money` int(11) NOT NULL,
  `gold` int(11) NOT NULL,
  `min_level` int(11) NOT NULL DEFAULT '1',
  `respect` int(11) NOT NULL,
  `income` int(11) NOT NULL,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `vip` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `properties` (`id`, `property`, `image`, `money`, `gold`, `min_level`, `respect`, `income`, `format`, `time`, `vip`) VALUES
(1, 'Shop', 'images/properties/Shop.png', 3000, 0, 1, 1000, 500, 'Minutes', 15, 'No'),
(2, 'Cafe', 'images/properties/Cafe.png', 6000, 0, 2, 2000, 950, 'Minutes', 30, 'No'),
(3, 'Old House', 'images/properties/Old-House.png', 14000, 0, 4, 3500, 1600, 'Hours', 1, 'No'),
(4, 'Small House', 'images/properties/Small-House.png', 25000, 1, 6, 5000, 5000, 'Hours', 3, 'No'),
(5, 'Factory', 'images/properties/Factory.png', 32000, 2, 10, 8000, 9100, 'Hours', 5, 'No'),
(6, 'Big House', 'images/properties/Big-House.png', 48000, 4, 14, 9900, 14000, 'Hours', 8, 'No'),
(7, 'Mansion', 'images/properties/Mansion.png', 60000, 8, 15, 12000, 20000, 'Hours', 10, 'Yes'),
(8, 'School', 'images/properties/School.png', 75000, 12, 16, 14000, 25000, 'Hours', 12, 'No'),
(9, 'Hospital', 'images/properties/Hospital.png', 90500, 20, 17, 16000, 30000, 'Hours', 16, 'No'),
(10, 'Hotel', 'images/properties/Hotel.png', 150000, 37, 17, 18000, 45000, 'Hours', 24, 'Yes'),
(11, 'Company', 'images/properties/Company.png', 264000, 50, 19, 20000, 62000, 'Hours', 24, 'Yes');

-- --------------------------------------------------------

CREATE TABLE `quays` (
  `id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images/backgrounds/quays/.jpg',
  `money` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gold` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `min_level` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `respect` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `max_vehicles` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `quays` (`id`, `image`, `money`, `gold`, `min_level`, `respect`, `vip`, `max_vehicles`) VALUES
(1, 'images/backgrounds/quays/1.jpg', '120000', '25', '12', '9500', 'Yes', '1');

-- --------------------------------------------------------

CREATE TABLE `races` (
  `id` int(11) NOT NULL,
  `playera_id` int(11) NOT NULL,
  `playerb_id` int(11) NOT NULL,
  `winner_id` int(11) NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `school` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fa_icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Minutes',
  `time` int(11) NOT NULL DEFAULT '45',
  `fee` int(11) NOT NULL,
  `energy_cost` int(11) NOT NULL,
  `intelligence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `school` (`id`, `subject`, `fa_icon`, `format`, `time`, `fee`, `energy_cost`, `intelligence`) VALUES
(1, 'Maths', 'fa-calculator', 'Minutes', 45, 350, 15, 3),
(2, 'Music', 'fa-music', 'Minutes', 45, 350, 15, 3),
(3, 'Art', 'fa-paint-brush', 'Minutes', 45, 350, 15, 3),
(4, 'History', 'fa-history', 'Minutes', 45, 350, 15, 3),
(5, 'Science', 'fa-flask', 'Minutes', 45, 350, 15, 3),
(6, 'Information Technology', 'fa-desktop', 'Hours', 1, 500, 20, 5),
(7, 'Geography', 'fa-globe', 'Minutes', 45, 350, 15, 3);

-- --------------------------------------------------------

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'vCity',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'vCity - Online Browser Game',
  `keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'online, browser, game, virtual, city, online game, browser game, players, vehicles, upgrades, items, characters',
  `startmoney` int(11) NOT NULL DEFAULT '1500',
  `startgold` int(11) NOT NULL DEFAULT '20',
  `paypal_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `about` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `settings` (`id`, `title`, `description`, `keywords`, `startmoney`, `startgold`, `paypal_email`, `about`) VALUES
(1, 'vCity - Online Browser Game', 'Play your dream life and improve your virtual character', 'online, browser, game, virtual, city, online game, browser game, players, vehicles, upgrades, items, characters', 1500, 20, 'herschelgomez@xyzzyu.com', 'vCity is an online browser game in which you can have your own virutal life. You can buy vehicles, items, properties and you can do many activities.&lt;br /&gt;&lt;br /&gt;\r\n \r\nMain features: \r\n&lt;ul&gt;\r\n   &lt;li&gt;Upgrade character&lt;/li&gt;\r\n   &lt;li&gt;Buy items&lt;/li&gt;\r\n   &lt;li&gt;Buy vehicles&lt;/li&gt;\r\n   &lt;li&gt;Upgrade vehicles&lt;/li&gt;\r\n   &lt;li&gt;Buy Properties and earn income&lt;/li&gt;\r\n   &lt;li&gt;Fight against other players&lt;/li&gt;\r\n   &lt;li&gt;Race against other players&lt;/li&gt;\r\n   &lt;li&gt;Train character in gym&lt;/li&gt;\r\n   &lt;li&gt;Go to school&lt;/li&gt;\r\n   &lt;li&gt;Go to work&lt;/li&gt;\r\n   &lt;li&gt;Advance with levels&lt;/li&gt;\r\n&lt;/ul&gt;');

-- --------------------------------------------------------

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Theme ',
  `csspath` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'assets/css/skins/theme.min.css',
  `default_theme` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `themes` (`id`, `name`, `csspath`, `default_theme`) VALUES
(1, 'Theme', 'assets/css/skins/theme.min.css', 'Yes'),
(2, 'Theme 2', 'assets/css/skins/theme2.min.css', 'No'),
(3, 'Theme 3', 'assets/css/skins/theme3.min.css', 'No'),
(4, 'Theme 4', 'assets/css/skins/theme4.min.css', 'No'),
(5, 'Theme 5', 'assets/css/skins/theme5.min.css', 'No'),
(6, 'Theme 6', 'assets/css/skins/theme6.min.css', 'No'),
(7, 'Theme 7', 'assets/css/skins/theme7.min.css', 'No'),
(8, 'Theme 8', 'assets/css/skins/theme8.min.css', 'No'),
(9, 'Theme 9', 'assets/css/skins/theme9.min.css', 'No'),
(10, 'Theme 10', 'assets/css/skins/theme10.min.css', 'No'),
(11, 'Theme 11', 'assets/css/skins/theme11.min.css', 'No'),
(12, 'Theme 12', 'assets/css/skins/theme12.min.css', 'No'),
(13, 'Theme 13', 'assets/css/skins/theme13.min.css', 'No'),
(14, 'Theme 14', 'assets/css/skins/theme14.min.css', 'No'),
(15, 'Theme 15', 'assets/css/skins/theme15.min.css', 'No'),
(16, 'Theme 16', 'assets/css/skins/theme16.min.css', 'No'),
(17, 'Theme 17', 'assets/css/skins/theme17.min.css', 'No'),
(18, 'Theme 18', 'assets/css/skins/theme18.min.css', 'No');

-- --------------------------------------------------------

CREATE TABLE `tips` (
  `id` int(11) NOT NULL,
  `tip` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `tips` (`id`, `tip`) VALUES
(1, 'Invest money in properties and you will regain your money with profit'),
(2, 'Go to work to earn extra money'),
(3, 'If your health is low go to the Hospital'),
(4, 'Fight agains other players to improve your respect and to raise levels'),
(5, 'Do many activities to earn respect and raise levels faster');

-- --------------------------------------------------------

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images/vehicles/',
  `category_id` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  `acceleration` int(11) NOT NULL,
  `stability` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `gold` int(11) NOT NULL,
  `min_level` int(11) NOT NULL DEFAULT '1',
  `respect` int(11) NOT NULL,
  `vip` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `active` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `vehicles` (`id`, `image`, `category_id`, `speed`, `acceleration`, `stability`, `money`, `gold`, `min_level`, `respect`, `vip`, `active`) VALUES
(1, 'images/vehicles/suvs/2.png', 2, 140, 110, 135, 17500, 0, 6, 7000, 'No', 'Yes'),
(2, 'images/vehicles/suvs/3.png', 2, 150, 120, 145, 22500, 1, 9, 7500, 'No', 'Yes'),
(3, 'images/vehicles/suvs/4.png', 2, 160, 130, 155, 27500, 2, 12, 8000, 'No', 'Yes'),
(4, 'images/vehicles/suvs/5.png', 2, 170, 140, 165, 32500, 3, 15, 8500, 'No', 'Yes'),
(5, 'images/vehicles/suvs/6.png', 2, 180, 150, 175, 37500, 4, 18, 9000, 'No', 'Yes'),
(6, 'images/vehicles/suvs/7.png', 2, 190, 160, 185, 42500, 8, 21, 9500, 'No', 'Yes'),
(7, 'images/vehicles/suvs/8.png', 2, 200, 170, 195, 47500, 10, 24, 10000, 'No', 'Yes'),
(8, 'images/vehicles/suvs/9.png', 2, 210, 180, 205, 52500, 15, 25, 10500, 'Yes', 'Yes'),
(9, 'images/vehicles/suvs/10.png', 2, 220, 190, 215, 57500, 20, 25, 11000, 'No', 'Yes'),
(11, 'images/vehicles/cars/2.png', 2, 80, 50, 45, 5000, 0, 6, 4000, 'No', 'Yes'),
(12, 'images/vehicles/cars/3.png', 2, 90, 60, 55, 10000, 0, 7, 4500, 'No', 'Yes'),
(13, 'images/vehicles/cars/4.png', 2, 100, 70, 65, 15000, 0, 8, 5000, 'No', 'Yes'),
(14, 'images/vehicles/cars/5.png', 2, 110, 80, 75, 20000, 0, 9, 5500, 'No', 'Yes'),
(15, 'images/vehicles/cars/6.png', 2, 120, 90, 85, 25000, 0, 10, 6000, 'No', 'Yes'),
(16, 'images/vehicles/cars/7.png', 2, 130, 100, 95, 30000, 0, 11, 6500, 'No', 'Yes'),
(17, 'images/vehicles/cars/8.png', 2, 140, 110, 105, 35000, 0, 12, 7000, 'No', 'Yes'),
(18, 'images/vehicles/cars/9.png', 2, 150, 120, 115, 40000, 0, 13, 7500, 'No', 'Yes'),
(19, 'images/vehicles/cars/10.png', 2, 160, 130, 125, 45000, 0, 14, 8000, 'No', 'Yes'),
(20, 'images/vehicles/cars/11.png', 2, 170, 140, 135, 50000, 0, 15, 8500, 'No', 'Yes'),
(21, 'images/vehicles/cars/12.png', 2, 180, 150, 145, 55000, 0, 16, 9000, 'No', 'Yes'),
(22, 'images/vehicles/cars/13.png', 2, 190, 160, 155, 60000, 1, 17, 9500, 'No', 'Yes'),
(23, 'images/vehicles/cars/14.png', 2, 200, 170, 165, 65000, 2, 18, 10000, 'No', 'Yes'),
(24, 'images/vehicles/cars/15.png', 2, 210, 180, 175, 70000, 3, 19, 10500, 'No', 'Yes'),
(25, 'images/vehicles/cars/16.png', 2, 220, 190, 185, 75000, 4, 20, 11000, 'No', 'Yes'),
(26, 'images/vehicles/cars/17.png', 2, 230, 200, 195, 80000, 5, 21, 11500, 'No', 'Yes'),
(27, 'images/vehicles/cars/18.png', 2, 240, 210, 205, 85000, 6, 22, 12000, 'No', 'Yes'),
(28, 'images/vehicles/cars/19.png', 2, 250, 220, 215, 90000, 8, 23, 12500, 'No', 'Yes'),
(29, 'images/vehicles/cars/20.png', 2, 260, 230, 225, 95000, 10, 24, 13000, 'No', 'Yes'),
(30, 'images/vehicles/cars/21.png', 2, 270, 240, 235, 100000, 15, 25, 13500, 'No', 'Yes'),
(31, 'images/vehicles/cars/22.png', 2, 280, 250, 245, 105000, 20, 25, 14000, 'No', 'Yes'),
(32, 'images/vehicles/cars/23.png', 2, 290, 260, 255, 110000, 45, 25, 14500, 'No', 'Yes'),
(33, 'images/vehicles/cars/24.png', 2, 300, 270, 265, 115000, 50, 25, 15000, 'Yes', 'Yes'),
(34, 'images/vehicles/bicycles/1.png', 1, 10, 5, 5, 500, 0, 1, 500, 'No', 'Yes'),
(35, 'images/vehicles/bicycles/2.png', 1, 15, 10, 12, 1000, 0, 2, 1000, 'No', 'Yes'),
(36, 'images/vehicles/bicycles/3.png', 1, 20, 15, 18, 2500, 0, 2, 1500, 'No', 'Yes'),
(37, 'images/vehicles/bicycles/4.png', 1, 30, 20, 24, 5000, 2, 3, 3000, 'No', 'Yes'),
(38, 'images/vehicles/motorbikes/1.png', 1, 80, 95, 60, 5000, 0, 1, 1150, 'No', 'Yes'),
(39, 'images/vehicles/motorbikes/2.png', 1, 90, 105, 70, 10000, 1, 3, 1650, 'No', 'Yes'),
(40, 'images/vehicles/motorbikes/3.png', 1, 100, 115, 80, 15000, 4, 5, 2150, 'No', 'Yes'),
(41, 'images/vehicles/motorbikes/4.png', 1, 110, 125, 90, 20000, 8, 7, 2650, 'No', 'Yes'),
(42, 'images/vehicles/motorbikes/5.png', 1, 120, 135, 100, 25000, 12, 9, 3150, 'No', 'Yes'),
(43, 'images/vehicles/motorbikes/6.png', 1, 130, 145, 110, 30000, 16, 11, 3650, 'No', 'Yes'),
(44, 'images/vehicles/motorbikes/7.png', 1, 140, 155, 120, 35000, 18, 13, 4150, 'No', 'Yes'),
(45, 'images/vehicles/motorbikes/8.png', 1, 150, 165, 130, 40000, 20, 15, 4650, 'Yes', 'Yes'),
(46, 'images/vehicles/trucks/1.png', 3, 100, 75, 60, 40000, 5, 8, 3500, 'No', 'Yes'),
(47, 'images/vehicles/trucks/2.png', 3, 140, 125, 100, 85000, 15, 12, 5700, 'Yes', 'Yes'),
(48, 'images/vehicles/helicopters/1.png', 4, 250, 175, 190, 67500, 8, 10, 6500, 'No', 'Yes'),
(49, 'images/vehicles/helicopters/2.png', 4, 300, 200, 230, 98100, 16, 14, 7800, 'No', 'Yes'),
(50, 'images/vehicles/helicopters/3.png', 4, 350, 220, 265, 125000, 25, 18, 9250, 'Yes', 'Yes'),
(51, 'images/vehicles/planes/1.png', 4, 320, 190, 240, 110000, 15, 15, 8000, 'No', 'Yes'),
(52, 'images/vehicles/planes/2.png', 4, 400, 310, 350, 195000, 45, 20, 15000, 'Yes', 'Yes'),
(53, 'images/vehicles/boats/1.png', 5, 120, 85, 70, 35000, 5, 5, 5000, 'No', 'Yes'),
(54, 'images/vehicles/boats/2.png', 5, 150, 110, 85, 48000, 10, 10, 7000, 'No', 'Yes'),
(55, 'images/vehicles/boats/3.png', 5, 180, 125, 100, 61000, 15, 15, 9000, 'No', 'Yes'),
(56, 'images/vehicles/boats/4.png', 5, 220, 140, 115, 89500, 20, 20, 11000, 'Yes', 'Yes'),
(57, 'images/vehicles/other/1.png', 6, 90, 45, 65, 40000, 10, 14, 5500, 'No', 'Yes'),
(58, 'images/vehicles/other/2.png', 6, 180, 150, 135, 120000, 15, 18, 7800, 'Yes', 'Yes'),
(59, 'images/vehicles/other/3.png', 6, 60, 20, 250, 185000, 30, 22, 9900, 'Yes', 'Yes');

-- --------------------------------------------------------

CREATE TABLE `vehicle_categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fa_icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `vehicle_categories` (`id`, `category`, `fa_icon`) VALUES
(1, 'Bicycles & Motorbikes', 'fa-motorcycle'),
(2, 'Cars & SUVs', 'fa-car'),
(3, 'Trucks', 'fa-truck'),
(4, 'Helicopters & Planes', 'fa-plane'),
(5, 'Boats & Ships', 'fa-ship'),
(6, 'Other', 'fa-ambulance');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `casino_prizes`
--
ALTER TABLE `casino_prizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `character_categories`
--
ALTER TABLE `character_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fights`
--
ALTER TABLE `fights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `garages`
--
ALTER TABLE `garages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `global_chat`
--
ALTER TABLE `global_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym`
--
ALTER TABLE `gym`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hangars`
--
ALTER TABLE `hangars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homes`
--
ALTER TABLE `homes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paid_services`
--
ALTER TABLE `paid_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player_actions`
--
ALTER TABLE `player_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player_comments`
--
ALTER TABLE `player_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player_items`
--
ALTER TABLE `player_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player_pets`
--
ALTER TABLE `player_pets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player_properties`
--
ALTER TABLE `player_properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player_vehicles`
--
ALTER TABLE `player_vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quays`
--
ALTER TABLE `quays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `races`
--
ALTER TABLE `races`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tips`
--
ALTER TABLE `tips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_categories`
--
ALTER TABLE `vehicle_categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `casino_prizes`
--
ALTER TABLE `casino_prizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `character_categories`
--
ALTER TABLE `character_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fights`
--
ALTER TABLE `fights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `garages`
--
ALTER TABLE `garages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `global_chat`
--
ALTER TABLE `global_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gym`
--
ALTER TABLE `gym`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `hangars`
--
ALTER TABLE `hangars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `homes`
--
ALTER TABLE `homes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `paid_services`
--
ALTER TABLE `paid_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `player_actions`
--
ALTER TABLE `player_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `player_comments`
--
ALTER TABLE `player_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `player_items`
--
ALTER TABLE `player_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `player_pets`
--
ALTER TABLE `player_pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `player_properties`
--
ALTER TABLE `player_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `player_vehicles`
--
ALTER TABLE `player_vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `quays`
--
ALTER TABLE `quays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `races`
--
ALTER TABLE `races`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;
--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `tips`
--
ALTER TABLE `tips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `vehicle_categories`
--
ALTER TABLE `vehicle_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
