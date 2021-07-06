-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2021 at 09:30 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emart`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`vishal`@`localhost` PROCEDURE `addpr` (IN `fname` VARCHAR(100), IN `lname` VARCHAR(100), IN `gender` VARCHAR(100), IN `dob` VARCHAR(100), IN `email` VARCHAR(100), IN `phone` VARCHAR(100), OUT `oupid` INT(3))  NO SQL
BEGIN
INSERT INTO profile
(fname,lname,gender,dob,email,phone) VALUES(fname,lname,gender,dob,email,phone);
set oupid=LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addtocart` (IN `name` VARCHAR(200), IN `price` VARCHAR(200), IN `img` VARCHAR(200), IN `qun` VARCHAR(200), IN `total` VARCHAR(200), IN `ccode` INT(11), IN `uid` INT(11), OUT `ouid` INT(3))  NO SQL
BEGIN
INSERT INTO cart (prodcname,prodcprice,prodcimg,quantity,total,ccode,uid) VALUES(name,price,img,qun,total,ccode,uid);
set ouid=LAST_INSERT_ID();
END$$

CREATE DEFINER=`vishal`@`localhost` PROCEDURE `age1` (IN `ages` VARCHAR(50))  NO SQL
SELECT TIMESTAMPDIFF (YEAR, ages, CURDATE()) FROM age AS AGE$$

CREATE DEFINER=`vishal`@`localhost` PROCEDURE `counter` (INOUT `counter` INT(10), IN `inc` INT(10))  NO SQL
BEGIN
	SET counter = counter + inc;
END$$

CREATE DEFINER=`vishal`@`localhost` PROCEDURE `details` (IN `pid` INT(10))  NO SQL
SELECT * FROM `product` WHERE prodid=pid$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `orders` (IN `add1` VARCHAR(200), IN `add2` VARCHAR(200), IN `country` VARCHAR(200), IN `state` VARCHAR(200), IN `city` VARCHAR(200), IN `zip` VARCHAR(200), IN `phone` VARCHAR(200), IN `products` TEXT, IN `total` VARCHAR(200), IN `sstatus` INT(11), IN `uid` INT(11), IN `pmode` VARCHAR(100), IN `orderid` VARCHAR(100), OUT `orid` INT(3))  NO SQL
BEGIN
INSERT INTO `orders`(`address1`, `address2`, `country`, `state`, `city`, `zip`, `phone`, `products`, `total`, `status`,`uid`,`pmode`,`orderid`) VALUES (add1,add2,country,state,city,zip,phone,products,total,sstatus,uid,pmode,orderid);
set orid=LAST_INSERT_ID();
END$$

CREATE DEFINER=`vishal`@`localhost` PROCEDURE `pr` ()  NO SQL
BEGIN
SELECT fun1();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `profile` (IN `fname` VARCHAR(200), IN `lname` VARCHAR(200), IN `gender` VARCHAR(200), IN `dob` VARCHAR(200), IN `email` VARCHAR(200), IN `phone` VARCHAR(200), IN `uid` INT(11))  NO SQL
BEGIN
UPDATE `profile` 
SET    	`fname`=fname,`lname`=lname,`gender`=gender,`dob`=dob,`email`=email,`phone`=phone WHERE profid=uid;
END$$

CREATE DEFINER=`vishal`@`localhost` PROCEDURE `res` (IN `ages` DATE, OUT `outid` INT(3))  NO SQL
BEGIN
INSERT INTO age(ages) VALUES(ages);
SET outid=LAST_INSERT_ID();
END$$

CREATE DEFINER=`vishal`@`localhost` PROCEDURE `st` (IN `state` VARCHAR(50))  NO SQL
select cname FROM city where sid IN (SELECT sid from state WHERE sname=state)$$

CREATE DEFINER=`my`@`localhost` PROCEDURE `t1` (IN `sname` VARCHAR(100), IN `sdname` VARCHAR(100))  NO SQL
BEGIN
START TRANSACTION;
INSERT INTO state(sname) VALUES(sname);
DELETE FROM state WHERE sname=sdname;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `wishlist` (IN `name` VARCHAR(200), IN `price` VARCHAR(200), IN `img` VARCHAR(200), IN `uid` INT(11), IN `wcode` INT(11), OUT `ouwid` INT(3))  NO SQL
BEGIN
INSERT INTO wishlist 
(wname,wprice,wimg,uid,wcode) 
VALUES(name,price,img,uid,wcode);
set ouwid=LAST_INSERT_ID();
END$$

--
-- Functions
--
CREATE DEFINER=`vishal`@`localhost` FUNCTION `fun` (`id` INT(11)) RETURNS INT(10) NO SQL
BEGIN
DECLARE c int;
set c = 10;
SELECT COUNT(*) INTO c FROM product WHERE catid=id;
RETURN c;
END$$

CREATE DEFINER=`vishal`@`localhost` FUNCTION `fun1` () RETURNS INT(10) NO SQL
BEGIN
DECLARE c int;
set c=10;
SELECT COUNT(*) INTO c from product;
RETURN c;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartid` int(11) NOT NULL,
  `prodcname` varchar(250) NOT NULL,
  `prodcprice` varchar(250) NOT NULL,
  `prodcimg` varchar(250) NOT NULL,
  `quantity` varchar(250) NOT NULL,
  `total` varchar(250) NOT NULL,
  `ccode` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartid`, `prodcname`, `prodcprice`, `prodcimg`, `quantity`, `total`, `ccode`, `uid`) VALUES
(6, 'Standard Refresh Air DXR Exhaust Plastic Round Fan', '1120', '../views/uploads/crompton_flux_air_metal_exhaust_fan_1.png', '1', '1120', 5, 18),
(7, 'Taparia Claw Hammer, 340 Gms', '1228', '../views/uploads/tablefan2.jpg', '1', '1228', 1, 20),
(10, 'Wipro Garnet LED Slim Batten Light 14 W', '2300', '../views/uploads/Inkedwipro-granet-ledslimlight-5114_LI.jpg', '1', '2300', 7, 2),
(12, 'Crompton HS Decora Standard Ceiling Fan', '1795', '../views/uploads/crompton.png', '1', '1795', 3, 2),
(14, 'Syska Rocket LED Bulb B22Base 45W', '699', '../views/uploads/syska_led_pagn_bulb.png', '1', '699', 6, 27);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `catid` int(11) NOT NULL,
  `catname` varchar(50) NOT NULL,
  `catimg` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`catid`, `catname`, `catimg`) VALUES
(1, 'Fan', '../views/uploads/crompton.png'),
(2, 'Light', '../views/uploads/wipro-granet-ledbulb-9000.jpg'),
(3, 'Hand tools', '../views/uploads/IMG-20200224-WA0023.jpg'),
(4, 'Plugs & Sockets', '../views/uploads/sockets.jpg'),
(5, 'Cabels & Wires', '../views/uploads/IMG-20200224-WA0033.jpg'),
(6, 'Wiring Devices', '../views/uploads/switch_1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `msg` text NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `msg`, `uid`) VALUES
(1, 'vishal', 'vishalchunara24@gmail.com', 'my order is not deliver.', 24);

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `expired` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`id`, `uid`, `name`, `price`, `expired`) VALUES
(4, 24, 'IPL20', '125', 1),
(5, 24, 'DIWALI24', '120', 1),
(6, 26, 'IPL20', '150', 1),
(7, 25, 'WCC23', '99', 1);

-- --------------------------------------------------------

--
-- Table structure for table `disuser`
--

CREATE TABLE `disuser` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `pass`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `oid` int(11) NOT NULL,
  `address1` varchar(400) NOT NULL,
  `address2` varchar(400) NOT NULL,
  `country` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `zip` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `products` text NOT NULL,
  `total` varchar(400) NOT NULL,
  `status` int(3) NOT NULL DEFAULT '0',
  `uid` int(50) NOT NULL,
  `pmode` varchar(100) NOT NULL,
  `pstatus` varchar(100) NOT NULL DEFAULT 'failure',
  `orderid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`oid`, `address1`, `address2`, `country`, `state`, `city`, `zip`, `phone`, `products`, `total`, `status`, `uid`, `pmode`, `pstatus`, `orderid`) VALUES
(98, '', '', '', '', '', '', '', 'Syska Rocket LED Bulb B22Base 45W(1)', '549', 0, 26, 'online', 'success', 'ORDS22555440'),
(99, 'Block no B-60  Vijay Flats', 'Gujarat University Navarang Pura', 'Indian', 'Gujarat', 'Ahemdabad', '380021', '9974347590', 'Havells Ciera High Speed Cabin Fan(1)', '1616', 0, 27, 'offline', 'success', 'ORDS25623616'),
(101, '', '', '', '', '', '', '', 'Crompton HS Decora Standard Ceiling Fan(3)', '5385', 0, 26, 'online', 'success', 'ORDS26420648'),
(102, '', '', '', '', '', '', '', 'Syska Rocket LED Bulb B22Base 45W(1)', '699', 0, 26, 'online', 'success', 'ORDS99814582');

-- --------------------------------------------------------

--
-- Table structure for table `otp_expiry`
--

CREATE TABLE `otp_expiry` (
  `id` int(11) NOT NULL,
  `otp` int(50) NOT NULL,
  `is_expired` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `otp_expiry`
--

INSERT INTO `otp_expiry` (`id`, `otp`, `is_expired`, `created_at`) VALUES
(99, 552192, 1, '2021-05-31 18:42:27'),
(100, 805169, 0, '2021-05-31 18:45:37'),
(101, 511175, 1, '2021-06-01 09:51:51'),
(102, 432312, 1, '2021-06-01 09:53:55'),
(103, 920595, 1, '2021-06-01 09:56:33'),
(104, 411862, 1, '2021-06-01 09:58:07'),
(105, 736763, 1, '2021-06-01 10:00:25'),
(106, 277297, 0, '2021-06-01 10:02:11'),
(107, 705315, 1, '2021-06-06 12:14:28'),
(108, 703083, 0, '2021-06-06 12:47:08'),
(109, 696217, 1, '2021-06-06 12:47:47');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `prodid` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  `prodname` varchar(100) NOT NULL,
  `prodimg` varchar(100) NOT NULL,
  `proddesc` text NOT NULL,
  `prodprice` varchar(100) NOT NULL,
  `prodstatus` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prodid`, `catid`, `prodname`, `prodimg`, `proddesc`, `prodprice`, `prodstatus`) VALUES
(1, 1, 'Taparia Claw Hammer, 340 Gms', '../views/uploads/tablefan2.jpg', '                                                                                                                                                                                                Taparia Claw Hammer, 340 Gms With Handle (Ref No. : CH 340)                                                                                                                                                                                ', '1228', 1),
(3, 1, 'Crompton HS Decora Standard Ceiling Fan', '../views/uploads/crompton.png', '                        Crompton HS Decora Metallic Standard - Deco Ceiling Fan 1200 Mm (48\"), Ginger Gold, 3 Blade, High Air Delivery (Ref No. : HSDCPRM48GGD)\r\n                                            ', '1795', 1),
(4, 1, 'Havells Ciera High Speed Cabin Fan', '../views/uploads/IMG-20200223-WA0011.jpg', 'Havells Ciera High Speed Cabin Fan 300 Mm (12\"), Ivory (Ref No. : FHPCISTIVR12)                      ', '1616', 1),
(5, 1, 'Standard Refresh Air DXR Exhaust Plastic Round Fan', '../views/uploads/crompton_flux_air_metal_exhaust_fan_1.png', 'Standard Refresh Air - DXR Exhaust Plastic Round Ventilation Fan 150 Mm (6\"), White (Ref No. : FSVRFDWWHT06)\r\n                        \r\n                                            ', '1120', 1),
(6, 2, 'Syska Rocket LED Bulb B22Base 45W', '../views/uploads/syska_led_pagn_bulb.png', '                        Syska Rocket LED Bulb B22 Base 45 W, Warm White (Ref No. : SSK-RB-4501-3K-B22)                        \r\n                                            ', '699', 1),
(7, 2, 'Wipro Garnet LED Slim Batten Light 14 W', '../views/uploads/Inkedwipro-granet-ledslimlight-5114_LI.jpg', 'Wipro Garnet LED Slim Batten Light 14 W, Warm White (Ref No. : D511427)                        \r\n                      ', '2300', 1),
(8, 2, 'GM Modular G-02 LED Flood Light 30 W', '../views/uploads/Flood_Light.png', 'GM Modular G-02 LED Flood Light 30 W, Cool White (Ref No. : G02-30-6.5K-FL)                        \r\n                      ', '2900', 1),
(9, 2, 'M Modular Fiesta LED Mini COB Spot Light 3 W', '../views/uploads/123.jpg', 'M Modular Fiesta LED Mini COB Spot Light 3 W, Neutral White, Concealed Mounted, Square (Ref No. : GM 0210)                        \r\n                      ', '500', 1),
(10, 5, 'Polycab 1 Sq.Mm, Single Core Copper Flexible Cable', '../views/uploads/Inkedpolycab_1_core_cable_red_fr_LI.jpg', '                        Polycab 1 Sq.Mm, Single Core Copper Flexible Cable, Red, PVC FR (Flame Retardant) (Ref No. : POLY_1_CU_1C_MS_FR_R_90)                        \r\n                                            ', '600', 1),
(11, 3, 'Taparia Double Ended Spanner, 10 X 12 Mm', '../views/uploads/Inkedtaparia_double_ended_spanner_dep_LI.jpg', 'Taparia Double Ended Spanner, 10 X 12 Mm, Chrome Plated (Ref No. : DEP 10 X 12)                        \r\n                      ', '31', 1),
(12, 3, 'Taparia Wire Stripping Plier, 150 Mm', '../views/uploads/taparia_round_nose_mini_plier_1402.png', 'Taparia Wire Stripping Plier, 150 Mm (Ref No. : WS 06)                        \r\n                      ', '62', 1),
(13, 3, 'Taparia Flat Screw Driver 1.6 X 0.4 Mm Tip, 50mm', '../views/uploads/taparia_two_in_one_screw_driver.png', 'Taparia Flat Screw Driver 1.6 X 0.4 Mm Tip, 50mm Length (Ref No. : 932)                        \r\n                      ', '29', 1),
(14, 3, 'Taparia Ball Pein Hammer, 500 Gms', '../views/uploads/taparia_claw_hammer.png', 'Taparia Ball Pein Hammer, 500 Gms With Handle (Ref No. : WH 500 B/C)                        \r\n                      ', '200', 1),
(15, 4, 'Legrand Mylinc White SP Switch 6 A', '../views/uploads/Inkedlegrand_mylinc_sp_switch_6755_01_LI.jpg', 'Legrand Mylinc White SP Switch 6 A, 1 Module, 1 Way (Ref No. : 6755 01)                        \r\n                      ', '31', 1),
(16, 4, 'Anchor Rider White 3 Pin Universal Socket 10 A', '../views/uploads/Inkedgreat_white_fiana_socket_20234_LI.jpg', 'Anchor Rider White 3 Pin Universal Socket 10 A, 2 Module, With Safety Shutter (Ref No. : 47323)                        \r\n                      ', '45', 1),
(17, 4, 'GM Modular FourFive 2 Module Light', '../views/uploads/gm_light_fitting_2_module_aa_2_062.png', 'GM Modular FourFive 2 Module Graphite Magnesia Light Fitting, White- LED (Ref No. : AA 2 062_GRAPHITE)                        \r\n                      ', '888', 1),
(18, 4, 'Anchor Rider White Fan Regulator 100 W', '../views/uploads/anchor_roma_fan_regulator_white_22546.jpg', 'Anchor Rider White Fan Regulator 100 W, 2 Module, 5 Step (Ref No. : 47500)                        \r\n                      ', '176', 1),
(19, 6, '9 Electric Schuko Connector 16 A', '../views/uploads/Inked9_electric_schuko_connector_9e10843_LI.jpg', '9 Electric Schuko Connector 16 A (Ref No. : 9E 10843)                        \r\n                      ', '264', 1),
(20, 6, '9 Electric Industrial Socket 16-20 A', '../views/uploads/Inked9_electric_industrial_wall_mounted_socket_9e_101_LI.jpg', '                        9 Electric Industrial Socket 16-20 A, 2 Pole+E, Wall Mounted, IP 44, 230 V, 6H (Ref No. : 9E 101)                        \r\n                                            ', '355', 0),
(21, 5, 'Finolex 1 Sq.Mm, Single Core Copper Flexible Cable', '../views/uploads/finolexcable.jpg', ' Finolex 1 Sq.Mm, Single Core Copper Flexible Cable, Red, PVC FR (Flame Retardant) (Ref No. : POLY_1_CU_1C_MS_FR_R_90)                        \r\n                                                      ', '580', 1),
(22, 3, 'KROST New 46PCS 1/4\" Taparia Socket Set for Car, Motorbike, Bicycle Repair Tool Kit', '../views/uploads/1handcable.jpg', 'Tools Centre is the authorised distributor for this product so kindly check the seller before buying the product.\r\n1/4\" Taparia Socket Set.', '1982.00', 1),
(23, 3, 'AmazonBasics Tools 4-Piece Pliers Set', '../views/uploads/2handtool.jpg', 'Brand -	AmazonBasics,\r\nMaterial - 	Metal, \r\nItem Dimensions -   LxWxH	22.5 x 7 x 8.8 Centimeters,\r\nColour -	Black,\r\nHandle Material -	Plastic,\r\nItem Weight	- 2.38 Pounds .              ', '1459.00', 1),
(24, 5, 'OXCOR D Twin Flat 2 core Copper Wires and Cables 1mm 30 feet (10yd) ', '../views/uploads/wire1.jpg', 'Perfectly made for home appliances like ceiling fan, room heaters, Wall fans, Exaust fan, Pedestal fans, LED lights, Domestic Tube fittings.', '499.00', 1),
(25, 5, 'Ultra High Quality Super Flexible Silicone Wire by Indian Hobby Center (1meter Black)', '../views/uploads/wire2.jpg', '0.08mm Ultra thin Tin Coated Copper Strands results in High Strand Count in the wire which leads to High Current Carrying Capacity. A 12AWG Silicone Wires comes with 680 copper strands.               ', '149.00', 1),
(26, 5, 'TERABYTE 18 Meter LAN Cable CAT6/Cat 6 Ethernet Cable Network Cable Internet Cable RJ45', '../views/uploads/wire3.jpg', 'Compared to a wireless network, Ethernet cables provide a wired network for a more secure and reliable internet connection. Use Ethernet cables to easily connect computers and peripherals to your LAN.                        \r\n                      ', '2284.00', 1),
(27, 5, 'Robotbanao N7-9JUZ-2DKU Double Ended Crocodile Clips Cable Alligator Clips Wire Testing', '../views/uploads/wire4.jpg', 'Imported, good quality, Kit contain: 10X double ended crocodile clips, It suits most users in deforest environment                        \r\n                      ', '189.00', 1),
(28, 2, 'HAPPENWELL Solar Powered Wireless Waterproof 20 LED Bright Outdoor Security Might Spotlights with Mo', '../views/uploads/light1.jpg', 'Waterproof and Durable: This light is weatherproof and durable with solid hard plastic which can withstand years of usageâ—† Solar panel life span: 5 years , LED Life Span:50000 hours.Only takes 6-8 hours to fully charge                    \r\n                      ', '389.00', 1),
(29, 2, 'ESS EMM 12W Round Cool Day White Led Surface Mounted Ceiling Light -Pack of 1', '../views/uploads/light2.jpg', 'â˜…WIDE APPLICATION: 6000K Natural Day Light,great for Stairwell,Stores,Shop,Office,Home,Living Room,Bathroom,Laundry room,Utility room,Washroom.Perfect as closet ceiling light,kitchen ceiling light,stairwell ceiling light,garage ceiling light.                        \r\n                      ', '299.00', 1),
(30, 1, 'Havells Stealth Air 1250mm Ceiling Fan (Pearl White)', '../views/uploads/fan.jpg', 'Exotic rich looks with modern styling ; Air delivery: 280 mÂ³/min ; Rated Speed: 280 revolution per minute ; Blade finish: Dust and Mark Resistant Coating.                        \r\n                      ', '5672.00', 1),
(31, 1, 'Orient Electric Wendy 1200mm Ceiling Fan (Topaz Gold/Brown)', '../views/uploads/fan2.jpg', 'Full copper motor and ribbed aluminium blades for durability\r\nWarranty: 2 years warranty on product\r\nPower Wattage : 70 W                        \r\n                      ', '2278', 0),
(32, 4, 'Lonix 3 pin Plug Adapter, Multiple Socket Plug, 3 Pin Travel Universal Multi Plug', '../views/uploads/plug1.jpg', 'International sockets and indicator\r\nSuitable for different types of plugs used around the world in 150 countries\r\nVoltage: 240 volts\r\nFrequency: 60 hertz                        \r\n                      ', '75.00', 0),
(33, 4, 'INDURO 2 Pc Spark plug socket set', '../views/uploads/s1.jpg', 'Spark plug 16mm + 21 mm, with t handle, \r\nMade of high grade Crv steel,  \r\nWith ergonomic Grip on the handle, \r\nMade in Taiwan.                        \r\n                      ', '349.00', 1),
(34, 6, 'LIFEGUARD RCCB & MCB, RCBOs 63 AMP with Over Voltage Protection, FR Grade PBT Cabinate (Din Rail & S', '../views/uploads/w1.jpg', 'LIFEGUARD DPSV RCBOs 63Amp., Single Phase, 2-Pole (1:Phase, 1:Neutral)\r\nRated breaking capacity :10kA ( ISI MCB Designed by German Technology), 220V AC, 50 Hz, Rated Residual Operating Time : 0.03S, O/v Cut-Off: 285V +/-2% With Respect to Neutral                        \r\n                      ', '5450.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `profid` int(11) NOT NULL,
  `fname` varchar(250) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `gender` varchar(250) NOT NULL,
  `dob` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profid`, `fname`, `lname`, `gender`, `dob`, `email`, `phone`) VALUES
(24, 'vishal', 'chunara', 'male', '1999-02-24', 'vishalchunara24@gmail.com', '6353653848'),
(25, 'vk', 'chunara', 'male', '2021-04-08', 'vishal.c.addweb@gmail.com', '6353653848'),
(26, 'urmish', 'solanki', 'male', '2021-04-02', 'urmishmscit123@gmail.com', '9724830156'),
(27, '', '', '', '', 'urmishsolanki2225@gmail.com', ''),
(28, '', '', '', '', 'redeagleg06@gmail.com', ''),
(29, '', '', '', '', 'pkamleshbhai443@gmail.com', ''),
(30, '', '', '', '', 'aeksayar05081999@gmail.com', ''),
(31, '', '', '', '', 'urmishmscit123@outlook.com', ''),
(32, '', '', '', '', 'sahilsametriya2063@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `submit_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `prod_id`, `email`, `description`, `rating`, `submit_date`) VALUES
(1, 1, 'David Deacon', 'I use this website daily, the amount of content is brilliant.', 2, '2020-01-09 20:43:02'),
(2, 1, 'John Doe', 'Great website, great content, and great support!', 4, '2020-01-09 21:00:41'),
(6, 3, 'Robin', 'I use this website daily, the amount of content is brilliant.', 5, '2021-05-19 12:39:36'),
(7, 3, 'Jack', 'Amazing content inside your application but one problem in your site you cant tract product.', 4, '2021-05-19 12:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wid` int(11) NOT NULL,
  `wname` varchar(100) NOT NULL,
  `wprice` varchar(100) NOT NULL,
  `wimg` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL,
  `wcode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wid`, `wname`, `wprice`, `wimg`, `uid`, `wcode`) VALUES
(3, 'Standard Refresh Air DXR Exhaust Plastic Round Fan', '1120', '../views/uploads/crompton_flux_air_metal_exhaust_fan_1.png', 2, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `disuser`
--
ALTER TABLE `disuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`oid`);

--
-- Indexes for table `otp_expiry`
--
ALTER TABLE `otp_expiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prodid`),
  ADD KEY `catid` (`catid`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`profid`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `disuser`
--
ALTER TABLE `disuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `otp_expiry`
--
ALTER TABLE `otp_expiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prodid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `profid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
