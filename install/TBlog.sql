-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016-07-21 20:15:14
-- 服务器版本: 5.5.44-0ubuntu0.14.04.1
-- PHP 版本: 5.5.9-1ubuntu4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `common`
--

-- --------------------------------------------------------

--
-- 表的结构 `blog_comment`
--

CREATE TABLE IF NOT EXISTS `blog_comment` (
  `CID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) NOT NULL DEFAULT '0',
  `upCID` int(11) NOT NULL DEFAULT '0',
  `UID` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL,
  `IP` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `url` tinytext NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`CID`),
  UNIQUE KEY `CID` (`CID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=20 ;

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

CREATE TABLE IF NOT EXISTS `blog_media` (
  `mediaID` int(11) NOT NULL AUTO_INCREMENT,
  `creatAt` int(11) NOT NULL,
  `creatBy` int(11) NOT NULL,
  `path` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`mediaID`),
  UNIQUE KEY `mediaID` (`mediaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `blog_meta`
--

CREATE TABLE IF NOT EXISTS `blog_meta` (
  `MID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext,
  `slug` tinytext,
  `type` tinytext NOT NULL,
  `description` tinytext,
  `count` int(10) unsigned DEFAULT '0',
  `order` int(10) unsigned DEFAULT '0',
  `parent` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`MID`),
  UNIQUE KEY `MID` (`MID`),
  KEY `slug` (`slug`(191))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=7 ;

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

CREATE TABLE IF NOT EXISTS `blog_nav` (
  `title` tinytext NOT NULL,
  `slug` tinytext NOT NULL,
  `url` tinytext NOT NULL,
  `order` int(10) unsigned zerofill NOT NULL,
  `other` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `blog_post`
--

CREATE TABLE IF NOT EXISTS `blog_post` (
  `PID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `UID` int(11) unsigned NOT NULL,
  `time` int(11) NOT NULL,
  `slug` tinytext NOT NULL,
  `type` tinytext NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `title` tinytext NOT NULL,
  `content` text NOT NULL,
  `isPost` enum('0','1') NOT NULL,
  PRIMARY KEY (`PID`),
  UNIQUE KEY `pid` (`PID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `blog_post`
--

INSERT INTO `blog_post` (`PID`, `UID`, `time`, `slug`, `type`, `order`, `title`, `content`, `isPost`) VALUES
(1, 1, 1467170440, 'about', 'page', 0, '关于', '<p>这是不点儿Blog的第一个页面。。。。<br></p>', '0'),
(2, 1, 1467170524, 'welcome', 'post', 0, '欢迎使用本博客程序', '<p>你看到这个文章的时候，你已经安装成功了。<br></p>', '0'),
(3, 1, 1468481293, '57873eeab6b17', 'post', 0, '文章实现无限分类', '<p style="">just like wp or typecho<br></p>', '0'),
(5, 1, 1468489550, '57875f33e75f0', 'post', 0, '无限分类完成', '<p style="">给自己鼓掌，今天就到这了<br></p>', '0'),
(6, 1, 1469068883, '579035deaa956', 'post', 0, '图片上传测试', '<p style=""><img src="/./Media/2016/07/5790364013816.png" alt="QQ截图20160721102904.png" height="178" width="439"><br></p>', '0');

-- --------------------------------------------------------

--
-- 表的结构 `blog_relationship`
--

CREATE TABLE IF NOT EXISTS `blog_relationship` (
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

CREATE TABLE IF NOT EXISTS `blog_setting` (
  `key` varchar(100) NOT NULL,
  `value` text,
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `blog_setting`
--

INSERT INTO `blog_setting` (`key`, `value`) VALUES
('blogDescription', 'just so so....'),
('blogKeyWorld', 'Tblog'),
('blogLogo', ''),
('blogTitle', 'Tblog'),
('plugins', 'a:1:{s:10:"helloWorld";a:1:{s:6:"status";s:4:"open";}}');

-- --------------------------------------------------------

--
-- 表的结构 `blog_user`
--

CREATE TABLE IF NOT EXISTS `blog_user` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `url` tinytext NOT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `aid` (`UID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `blog_user`
--

INSERT INTO `blog_user` (`UID`, `name`, `password`, `email`, `url`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'e@e.com', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
