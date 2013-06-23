-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 22, 2013 at 03:05 PM
-- Server version: 5.5.31
-- PHP Version: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cs487`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `cityid` int(11) NOT NULL AUTO_INCREMENT,
  `city` text NOT NULL,
  `state` text NOT NULL,
  PRIMARY KEY (`cityid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`cityid`, `city`, `state`) VALUES
(1, 'Chicago', 'IL'),
(2, 'San Diego', 'CA'),
(3, 'London', 'England'),
(4, 'New York', 'NY'),
(5, 'Austin', 'TX'),
(6, 'Blackburn', 'Scottland');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE IF NOT EXISTS `colors` (
  `colorid` int(11) NOT NULL AUTO_INCREMENT,
  `color` text NOT NULL,
  PRIMARY KEY (`colorid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`colorid`, `color`) VALUES
(1, 'Red'),
(2, 'Green'),
(3, 'Blue'),
(4, 'Yellow'),
(5, 'Black'),
(6, 'Silver'),
(7, 'Rust');
-- --------------------------------------------------------

--
-- Table structure for table `contacttypes`
--

CREATE TABLE IF NOT EXISTS `contacttypes` (
  `contactid` int(11) NOT NULL AUTO_INCREMENT,
  `contact` text NOT NULL,
  PRIMARY KEY (`contactid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `contacttypes`
--

INSERT INTO `contacttypes` (`contactid`, `contact`) VALUES
(1, 'Walk-In'),
(2, 'Phone');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customerid` int(11) NOT NULL AUTO_INCREMENT,
  `personid` int(11) NOT NULL,
  `contacttype` int(11) NOT NULL,
  PRIMARY KEY (`customerid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerid`, `personid`, `contacttype`) VALUES
(1, 1, 1),
(2, 5, 1),
(3, 6, 2),
(4, 7, 1),
(5, 8, 2);


-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `employeeid` int(11) NOT NULL AUTO_INCREMENT,
  `personid` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `rankid` int(11) NOT NULL,
  `statusid` int(11) NOT NULL,
  PRIMARY KEY (`employeeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employeeid`, `personid`, `username`, `password`, `rankid`, `statusid`) VALUES
(1, 1, 'danemp', '2591e5f46f28d303f9dc027d475a5c60d8dea17a', 2, 1),
(2, 1, 'danman', '2591e5f46f28d303f9dc027d475a5c60d8dea17a', 1, 1),
(3, 2, 'ronemp', 'b937b287f61b7a223d4aac55072db1a5381d3bb3', 2, 1);
(4, 2, 'ronman', 'b937b287f61b7a223d4aac55072db1a5381d3bb3', 1, 1);
(5, 3, 'tonyemp', '1001e8702733cced254345e193c88aaa47a4f5de', 2, 1);
(6, 3, 'tonyman', '1001e8702733cced254345e193c88aaa47a4f5de', 1, 1);
(7, 4, 'joshemp', 'c028c213ed5efcf30c3f4fc7361dbde0c893c5b7', 2, 1);
(8, 4, 'joshman', 'c028c213ed5efcf30c3f4fc7361dbde0c893c5b7', 1, 1);
-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `locationid` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `cityid` int(11) NOT NULL,
  `zipid` int(11) NOT NULL,
  PRIMARY KEY (`locationid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`locationid`, `name`, `address`, `cityid`, `zipid`) VALUES
(1, 'Dans Bad Business Practices', '3404 S Union Ave', 1, 1),
(2, 'Good Morning San Diego Autos', '1023 N Main St', 2, 2),
(3, 'Big Ben\'s Cars and Parts', '12 Clocktower Pl', 3, 3),
(4, 'Im walkin here car repair', '430 broklin St', 4, 4),
(5, 'Ride em Pickups', '53123 Cowtipper Rd', 5, 5),
(6, 'Bar Brawls Moving Buggies', 'East 1st St', 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `makes`
--

CREATE TABLE IF NOT EXISTS `makes` (
  `makeid` int(11) NOT NULL AUTO_INCREMENT,
  `make` text NOT NULL,
  PRIMARY KEY (`makeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `makes`
--

INSERT INTO `makes` (`makeid`, `make`) VALUES
(1, 'Ford'),
(2, 'Toyota'),
(3, 'Dodge'),
(4, 'Chysler'),
(5, 'Audi'),
(6, 'Jaguar'),
(7, 'Jeep');
-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE IF NOT EXISTS `models` (
  `modelid` int(11) NOT NULL AUTO_INCREMENT,
  `makeid` int(11) NOT NULL,
  `model` text NOT NULL,
  PRIMARY KEY (`modelid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`modelid`, `makeid`, `model`) VALUES
(1, 1, 'Focus'),
(2, 2, 'Rav4'),
(3, 1, 'Pinto'),
(4, 3, 'Ram 1500'),
(5, 4, 'Sebring'),
(6, 5, 'A3'),
(7, 7, 'Liberty'),
(8, 1, 'Thunderbird'),
(9, 6, 'F-Type'),
(10, 1, 'Mustang');
-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE IF NOT EXISTS `parts` (
  `partid` int(11) NOT NULL AUTO_INCREMENT,
  `cost` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`partid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (`partid`, `cost`, `quantity`, `name`) VALUES
(1, 112.17, 10, 'Tire'),
(2, 19.99, 50, 'Wax'),
(3, 7.99, 100, 'Air Freshener'),
(4, 29.99, 25, 'Wipers'),
(5, 45.00, 10, 'Battery'),
(6, 25.99, 20, 'Oil Filter'),
(7, 300.00, 5, 'Radiator'),
(8, 20.00, 20, 'Oil in a Can'),
(9, 2.99, 1000, 'Bolts');

-- --------------------------------------------------------

--
-- Table structure for table `partsales`
--

CREATE TABLE IF NOT EXISTS `partsales` (
  `saleid` int(11) NOT NULL AUTO_INCREMENT,
  `customerid` int(11) NOT NULL,
  `employeeid` int(11) NOT NULL,
  `partid` int(11) NOT NULL,
  `datesold` date NOT NULL,
  `saleprice` float NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`saleid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE IF NOT EXISTS `people` (
  `personid` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `email` text NOT NULL,
  `address` text NOT NULL,
  `cityid` int(11) NOT NULL,
  `phone` bigint(11) NOT NULL,
  PRIMARY KEY (`personid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`personid`, `firstname`, `lastname`, `email`, `address`, `cityid`, `phone`) VALUES
(1, 'Daniel', 'LaGesse', 'dlagesse1992@gmail.com', '3404 S Union Ave', 1, 8159169783),
(2, 'Ronald', 'Pyka', 'ronald.pyka@gmail.com', '3404 S Union Ave', 1, 1234567789),
(3, 'Antono','Hudson', 'rradioack@gmail.com', '3300 S Ferderal Street', 1, 8328633562),
(4, 'Josh', 'Moser', 'joshuamoser@gmail.com', '1234 S. Prarie Ave', 1, 9876543210),
(5, 'Ron', 'Burgundy', 'gwamm@thethunder.com', 'First Best Street', 2, 6194685683),
(6, 'James', 'May', 'ohbollocks@godsavethequeen.eu', 'Capt Slow Ln', 3, 3922182854),
(7, 'Techno', 'Love', 'wubwub@dropthebass.com', 'Loosey Goosey Lane', 4, 2938182882),
(8, 'Susan', 'Boyle', 'idreamadream@daysgoneby.uk', 'Good Lungs Ave', 6, 9293828182);

-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

CREATE TABLE IF NOT EXISTS `ranks` (
  `rankid` int(11) NOT NULL AUTO_INCREMENT,
  `rank` text NOT NULL,
  PRIMARY KEY (`rankid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ranks`
--

INSERT INTO `ranks` (`rankid`, `rank`) VALUES
(1, 'MANAGER'),
(2, 'SALESMAN');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
  `statusid` int(11) NOT NULL AUTO_INCREMENT,
  `status` text NOT NULL,
  PRIMARY KEY (`statusid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`statusid`, `status`) VALUES
(1, 'FOR SALE'),
(2, 'SOLD'),
(3, 'IN SHOP');

-- --------------------------------------------------------

--
-- Table structure for table `employeestatuses`
--

CREATE TABLE IF NOT EXISTS `employeestatuses` (
  `statusid` int(11) NOT NULL AUTO_INCREMENT,
  `status` text NOT NULL,
  PRIMARY KEY (`statusid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `employeestatuses`
--

INSERT INTO `employeestatuses` (`statusid`, `status`) VALUES
(1, 'ACTIVE'),
(2, 'FIRED'),
(3, 'RETIRED');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE IF NOT EXISTS `vehicles` (
  `vin` text NOT NULL,
  `vehicleid` int(11) NOT NULL AUTO_INCREMENT,
  `colorid` int(11) NOT NULL,
  `modelid` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `statusid` int(11) NOT NULL,
  `locationid` int(11) NOT NULL,
  PRIMARY KEY (`vehicleid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vin`, `vehicleid`, `colorid`, `modelid`, `year`, `statusid`, `locationid`) VALUES
('3FAHP395X2R233648', 1, 1, 1, 2003, 2, 1),
('7KDK0294NV0201P6J', 2, 2, 2, 2007, 1, 3),
('FD30FMWEKWI3MV932', 3, 7, 3, 1993, 3, 1),
('KDK3FM303O0GNRM31', 4, 4, 4, 2013, 1, 4),
('EJ032OFI02I3FN228', 5, 6, 5, 2004, 2, 1),
('AJNEOWCVNOV29WL23', 6, 5, 6, 1999, 1, 6),
('SGH339FN30FNV73BD', 7, 2, 7, 2013, 2, 2),
('AJE92FEGLG0G93UY2', 8, 3, 8, 1960, 3, 2),
('JRJ3393NFO303UFN3', 9, 1, 9, 2001, 1, 1),
('IEI202NFO23N20H48',10,4, 10, 1974, 1, 5);
-- --------------------------------------------------------

--
-- Table structure for table `vehiclesales`
--

CREATE TABLE IF NOT EXISTS `vehiclesales` (
  `saleid` int(11) NOT NULL AUTO_INCREMENT,
  `customerid` int(11) NOT NULL,
  `employeeid` int(11) NOT NULL,
  `vehicleid` int(11) NOT NULL,
  `datesold` date NOT NULL,
  `saleprice` int(11) NOT NULL,
  PRIMARY KEY (`saleid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `zips`
--

CREATE TABLE IF NOT EXISTS `zips` (
  `zipid` int(11) NOT NULL AUTO_INCREMENT,
  `zip` int(11) NOT NULL,
  PRIMARY KEY (`zipid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `zips`
--

INSERT INTO `zips` (`zipid`, `zip`) VALUES
(1, 60616),
(2, 92130),
(3, 12121),
(4, 10004),
(5, 78729),
(6, 28943);
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
