-- phpMyAdmin SQL Dump
-- version 3.3.7deb11
-- http://www.phpmyadmin.net
--
-- Host: lochnagar.abertay.ac.uk
-- Generation Time: Nov 28, 2016 at 03:13 PM
-- Server version: 5.1.73
-- PHP Version: 5.3.3-7+squeeze28

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sql1602312`
--

-- --------------------------------------------------------

--
-- Table structure for table `classifieds`
--

CREATE TABLE IF NOT EXISTS `classifieds` (
  `classifiedID` varchar(255) NOT NULL,
  `userID` varchar(255) NOT NULL,
  `info` varchar(255) NOT NULL,
  `imagePath` varchar(255) NOT NULL,
  `uploadDate` varchar(255) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classifieds`
--

INSERT INTO `classifieds` (`classifiedID`, `userID`, `info`, `imagePath`, `uploadDate`) VALUES
('1', '2', 'This is a test', 'upload/test.png', 'CURDATE()'),
('2', '3', 'This is a second test', 'upload/test.png', 'today');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customerID` int(255) NOT NULL,
  `email` varchar(20) NOT NULL,
  `registrationDate` date NOT NULL,
  `DOB` date NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `address` text NOT NULL,
  `postcode` text NOT NULL,
  `city` text NOT NULL,
  `country` text NOT NULL,
  PRIMARY KEY (`customerID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Customer Information';

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerID`, `email`, `registrationDate`, `DOB`, `firstName`, `lastName`, `address`, `postcode`, `city`, `country`) VALUES
(1001, 'test@test.com', '2016-09-13', '1992-10-21', 'testfirstA', 'testlastA', '1001 High Street', 'AB012345', 'Test', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `loginData`
--

CREATE TABLE IF NOT EXISTS `loginData` (
  `customerID` int(255) NOT NULL,
  `loginID` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userEmail` varchar(30) NOT NULL,
  PRIMARY KEY (`loginID`),
  KEY `customerID` (`customerID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loginData`
--

INSERT INTO `loginData` (`customerID`, `loginID`, `password`, `userEmail`) VALUES
(583, 'Test', '0aa7a29d6c3640b4a2b5914c006f05f2ec9ee01611e1b12d53fb54b4d7e154a2', 'seamussalt@gmail.com'),
(583, 'Seamus Salt', '0aa7a29d6c3640b4a2b5914c006f05f2ec9ee01611e1b12d53fb54b4d7e154a2', 'seamussalt@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `buyerID` int(255) NOT NULL,
  `sellerID` int(255) NOT NULL,
  `transactionID` int(255) NOT NULL,
  `totalCost` decimal(65,10) NOT NULL,
  `date` date NOT NULL,
  `descrip` text NOT NULL,
  PRIMARY KEY (`transactionID`),
  KEY `sellerID` (`sellerID`),
  KEY `buyerID` (`buyerID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

