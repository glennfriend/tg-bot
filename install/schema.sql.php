<?php exit; ?>

-- phpMyAdmin SQL Dump
-- version 4.4.6
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2016 年 01 月 04 日 07:37
-- 伺服器版本: 5.5.44-0ubuntu0.14.04.1
-- PHP 版本： 5.5.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫： `telegram_bot`
--

-- --------------------------------------------------------

--
-- 資料表結構 `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL,
  `message_id` int(10) unsigned NOT NULL,
  `update_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `chat_type` varchar(10) NOT NULL,
  `chat_id` int(10) NOT NULL,
  `chat_title` varchar(40) NOT NULL,
  `content` text NOT NULL,
  `create_message_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_execute` tinyint(3) unsigned NOT NULL,
  `properties` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `message_id` (`message_id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
