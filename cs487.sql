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
(1, 'Chicago', 'IL');

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
(1, 'Red');

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
(1, 1, 1);

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
(1, 1, 'ssmy', 'e996af04ad7ba8bdf4639860ece66bd32369532a', 1, 1),
(2, 2, 'ron', 'b937b287f61b7a223d4aac55072db1a5381d3bb3', 2, 1);

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
(1, 'Dan''s Cars', '3404 S Union Ave', 1, 1);

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
(1, 'Ford');

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
(1, 1, 'Focus');

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
(1, 112.17, 10, 'Tire');

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
(3, 'Ronald', 'Pyka', 'ronald.pyka@gmail.com', '3404 S Union Ave', 1, 1234567789);

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
(1, 'ACTIVE'),
(2, 'FOR SALE');

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
('3FAHP395X2R233648', 1, 1, 1, 2003, 2, 1);

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
(1, 60616);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
