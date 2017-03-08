-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-02-25 11:29:28
-- 服务器版本： 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.13-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tblog`
--

-- --------------------------------------------------------

--
-- 表的结构 `blog_comment`
--

CREATE TABLE `blog_comment` (
  `CID` int(11) NOT NULL,
  `PID` int(11) NOT NULL DEFAULT '0',
  `upCID` int(11) NOT NULL DEFAULT '0',
  `UID` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL,
  `IP` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `url` tinytext NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `blog_comment`
--

INSERT INTO `blog_comment` (`CID`, `PID`, `upCID`, `UID`, `time`, `IP`, `name`, `email`, `url`, `content`) VALUES
(7, 2, 0, 0, 1467170638, '61.131.96.156', 'hello', 'i@tristana.cn', '', '?第一条评论，么么哒。'),
(8, 6, 0, 0, 1469069064, '27.155.41.204', '管理员', 'i@tristana.cn', '', '即时编辑，即时上传');

-- --------------------------------------------------------

--
-- 表的结构 `blog_media`
--

CREATE TABLE `blog_media` (
  `mediaID` int(11) NOT NULL,
  `creatAt` int(11) NOT NULL,
  `creatBy` int(11) NOT NULL,
  `path` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `blog_meta`
--

CREATE TABLE `blog_meta` (
  `MID` int(10) UNSIGNED NOT NULL,
  `name` tinytext,
  `slug` tinytext,
  `type` tinytext NOT NULL,
  `description` tinytext,
  `count` int(10) UNSIGNED DEFAULT '0',
  `order` int(10) UNSIGNED DEFAULT '0',
  `parent` int(10) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `blog_meta`
--

INSERT INTO `blog_meta` (`MID`, `name`, `slug`, `type`, `description`, `count`, `order`, `parent`) VALUES
(1, '默认分类', 'default', 'category', '', 0, 0, 0),
(5, '程序员日志', 'coder', 'category', '', 0, 0, 0),
(6, 'php', 'php', 'category', '', 0, 0, 5);

-- --------------------------------------------------------

--
-- 表的结构 `blog_nav`
--

CREATE TABLE `blog_nav` (
  `title` tinytext NOT NULL,
  `slug` tinytext NOT NULL,
  `url` tinytext NOT NULL,
  `order` int(10) UNSIGNED ZEROFILL NOT NULL,
  `other` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `blog_post`
--

CREATE TABLE `blog_post` (
  `PID` int(11) UNSIGNED NOT NULL,
  `UID` int(11) UNSIGNED NOT NULL,
  `time` int(11) NOT NULL,
  `slug` tinytext NOT NULL,
  `type` tinytext NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `title` tinytext NOT NULL,
  `content` text NOT NULL,
  `isPost` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `blog_post`
--

INSERT INTO `blog_post` (`PID`, `UID`, `time`, `slug`, `type`, `order`, `title`, `content`, `isPost`) VALUES
(1, 1, 1467170440, 'about', 'page', 0, '关于', '<p>这是不点儿Blog的第一个页面。。。。<br></p>', '0'),
(2, 1, 1467170524, 'welcome', 'post', 0, '欢迎使用本博客程序', '<p>你看到这个文章的时候，你已经安装成功了。<br></p>', '0'),
(3, 1, 1468481293, '57873eeab6b17', 'post', 0, '文章实现无限分类', '<p style=\"\">just like wp or typecho<br></p>', '0'),
(5, 1, 1468489550, '57875f33e75f0', 'post', 0, '无限分类完成', '<p style=\"\">给自己鼓掌，今天就到这了<br></p>', '0'),
(6, 1, 1469068883, '579035deaa956', 'post', 0, '图片上传测试', '<p style=\"\"><img src=\"/./Media/2016/07/5790364013816.png\" alt=\"QQ截图20160721102904.png\" height=\"178\" width=\"439\"><br></p>', '0');

-- --------------------------------------------------------

--
-- 表的结构 `blog_relationship`
--

CREATE TABLE `blog_relationship` (
  `post_id` int(11) NOT NULL,
  `meta_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `blog_relationship`
--

INSERT INTO `blog_relationship` (`post_id`, `meta_id`) VALUES
(4, 5),
(4, 6),
(3, 5),
(3, 6),
(2, 1),
(5, 5);

-- --------------------------------------------------------

--
-- 表的结构 `blog_setting`
--

CREATE TABLE `blog_setting` (
  `key` varchar(100) NOT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `blog_setting`
--

INSERT INTO `blog_setting` (`key`, `value`) VALUES
('blogDescription', 'just so so....'),
('blogKeyWorld', 'Tblog'),
('blogLogo', ''),
('blogTitle', 'Tblog'),
('plugins', 'a:1:{s:10:\"helloWorld\";a:1:{s:6:\"status\";s:4:\"open\";}}');

-- --------------------------------------------------------

--
-- 表的结构 `blog_user`
--

CREATE TABLE `blog_user` (
  `UID` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `url` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `blog_user`
--

INSERT INTO `blog_user` (`UID`, `name`, `password`, `email`, `url`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'e@e.com', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_comment`
--
ALTER TABLE `blog_comment`
  ADD PRIMARY KEY (`CID`),
  ADD UNIQUE KEY `CID` (`CID`);

--
-- Indexes for table `blog_media`
--
ALTER TABLE `blog_media`
  ADD PRIMARY KEY (`mediaID`),
  ADD UNIQUE KEY `mediaID` (`mediaID`);

--
-- Indexes for table `blog_meta`
--
ALTER TABLE `blog_meta`
  ADD PRIMARY KEY (`MID`),
  ADD UNIQUE KEY `MID` (`MID`),
  ADD KEY `slug` (`slug`(63));

--
-- Indexes for table `blog_post`
--
ALTER TABLE `blog_post`
  ADD PRIMARY KEY (`PID`),
  ADD UNIQUE KEY `pid` (`PID`);

--
-- Indexes for table `blog_setting`
--
ALTER TABLE `blog_setting`
  ADD UNIQUE KEY `key` (`key`);

--
-- Indexes for table `blog_user`
--
ALTER TABLE `blog_user`
  ADD PRIMARY KEY (`UID`),
  ADD UNIQUE KEY `aid` (`UID`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `blog_comment`
--
ALTER TABLE `blog_comment`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- 使用表AUTO_INCREMENT `blog_media`
--
ALTER TABLE `blog_media`
  MODIFY `mediaID` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `blog_meta`
--
ALTER TABLE `blog_meta`
  MODIFY `MID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `blog_post`
--
ALTER TABLE `blog_post`
  MODIFY `PID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `blog_user`
--
ALTER TABLE `blog_user`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
