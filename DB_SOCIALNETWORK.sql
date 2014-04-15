-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Apr 15, 2014 at 12:53 AM
-- Server version: 5.0.45
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `DB_SOCIALNETWORK`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `tb_info`
-- 

CREATE TABLE `tb_info` (
  `id` int(11) NOT NULL auto_increment,
  `imgUrl` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `followCount` bigint(20) NOT NULL,
  `fblikescount` bigint(20) NOT NULL default '0',
  `gpluscount` bigint(20) NOT NULL default '0',
  `youtubecount` bigint(20) NOT NULL default '0',
  `total` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=260 ;
