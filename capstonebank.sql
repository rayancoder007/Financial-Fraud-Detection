-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2021 at 03:49 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Database: capstonebank
--

-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS capstonebank;
USE capstonebank;

-- --------------------------------------------------------

--
-- Table structure for table accountdetails
--

CREATE TABLE IF NOT EXISTS accountdetails (
  sno INT(11) NOT NULL AUTO_INCREMENT,
  accID INT(11) NOT NULL,
  name VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  balance DOUBLE NOT NULL,
  passwords VARBINARY(255) NOT NULL,
  PRIMARY KEY (sno)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Triggers `encrypt_password_before_insert`
--
DROP TRIGGER IF EXISTS encrypt_password_before_insert;
DELIMITER $$
CREATE TRIGGER encrypt_password_before_insert BEFORE INSERT ON accountdetails
FOR EACH ROW
BEGIN
    DECLARE new_encryption_key VARCHAR(6); -- Set the maximum length to 6 characters
    SET new_encryption_key = SUBSTRING(MD5(RAND()) FROM 1 FOR 6); -- Generate a new encryption key (6 characters)
    
    SET NEW.passwords = HEX(AES_ENCRYPT(NEW.passwords, new_encryption_key)); -- Encrypt password using the new key
END$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table data for table accountdetails
--

INSERT INTO accountdetails (accID, name, email, balance, passwords) VALUES
(1234, 'Rayan', 'rayan@gmail.com', 3137, ''),
(4211, 'Priyanshu', 'Priyanshu@gmail.com', 5655, ''),
(6789, 'Mahesh', 'Mahesh@gmail.com', 880, ''),
(1122, 'shipra', 'ship@gmail.com', 5000, ''),
(5467, 'aman', 'aman@gmail.com', 2000, ''),
(9999, 'sumit', 'sumit@gmail.com', 6000, ''),
(7878, 'kartik', 'kartik@gmail.com', 8890, ''),
(4321, 'shreesh', 'shreesh@gmail.com', 1210, ''),
(1444, 'sheetal', 'st@gmail.com', 8900, ''),
(7777, 'divya', 'divya@gmail.com', 4703, ''),
(2430, 'krishan', 'krish@gmail.com', 4340, '');

-- --------------------------------------------------------

--
-- Table structure for table history
--

CREATE TABLE IF NOT EXISTS history (
  sno INT(11) NOT NULL AUTO_INCREMENT,
  payer TEXT NOT NULL,
  payerAcc INT(11) NOT NULL,
  payee TEXT NOT NULL,
  payeeAcc INT(11) NOT NULL,
  amount DOUBLE NOT NULL,
  time TEXT NOT NULL,
  PRIMARY KEY (sno)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table data for table history
--

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

COMMIT;
