#-- phpMyAdmin SQL Dump
#-- version 2.11.8.1
#-- http://www.phpmyadmin.net
#--
#-- Host: localhost
#-- Generation Time: Aug 26, 2008 at 11:29 PM
#-- Server version: 5.0.22
#-- PHP Version: 5.1.6

#SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
#
#--
#-- Database: `xoops230`
#--

#-- --------------------------------------------------------

#--
#-- Table structure for table `amminigall_categories`
#--

CREATE TABLE `amminigall_categories` (
  `cat_id` smallint(10) NOT NULL auto_increment,
  `cat_name` varchar(100) default NULL,
  `cat_description` text,
  `cat_sortorder` tinyint(5) NOT NULL default '0',
  `cat_showme` tinyint(5) NOT NULL default '1',
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 ;

#--
#-- Dumping data for table `amminigall_categories`
#--

INSERT INTO `amminigall_categories` (`cat_id`, `cat_name`, `cat_description`, `cat_sortorder`, `cat_showme`) VALUES 
(1, 'Example', 'This is an example', 0, 1);

#-- --------------------------------------------------------

#--
#-- Table structure for table `amminigall_images`
#--

CREATE TABLE `amminigall_images` (
  `img_id` smallint(10) NOT NULL auto_increment,
  `img_catid` smallint(10) NOT NULL default '0',
  `img_title` varchar(100) default NULL,
  `img_filename_photo` varchar(50) default NULL,
  `img_filename_thumb` varchar(50) default NULL,
  `img_path_filesys` varchar(100) default NULL,
  `img_path_url` varchar(100) default NULL,
  `img_description` text,
  `img_thumb_width` varchar(10) NOT NULL default '0',
  `img_thumb_height` varchar(10) NOT NULL default '0',
  `img_photo_width` varchar(10) NOT NULL default '0',
  `img_photo_height` varchar(10) NOT NULL default '0',
  `img_filesize_bytes` varchar(10) NOT NULL default '0',
  `img_date_added` datetime NOT NULL default '0000-00-00 00:00:00',
  `img_addedby` smallint(10) NOT NULL default '0',
  `img_showme` tinyint(1) NOT NULL default '1',
  `img_views` int(10) NOT NULL default '0',
  `img_weight` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`img_id`)
) ENGINE=MyISAM ;

