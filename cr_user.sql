-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2017-01-22 18:02:58
-- 服务器版本： 5.7.13
-- PHP Version: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `chatroom`
--

-- --------------------------------------------------------

--
-- 表的结构 `cr_user`
--

CREATE TABLE `cr_user` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '自增id',
  `user_name` varchar(15) NOT NULL COMMENT '用户名',
  `password` varchar(60) NOT NULL COMMENT '密码',
  `remember_token` varchar(100) NOT NULL DEFAULT '' COMMENT '记住我session令牌',
  `email` varchar(40) NOT NULL DEFAULT '' COMMENT '邮箱',
  `gender` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 保密，1 男，2 女',
  `avatar` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '头像',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表' ROW_FORMAT=DYNAMIC;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cr_user`
--
ALTER TABLE `cr_user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cr_user`
--
ALTER TABLE `cr_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id';