-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.7.14 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- 导出 api 的数据库结构
DROP DATABASE IF EXISTS `api`;
CREATE DATABASE IF NOT EXISTS `api` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `api`;

-- 导出  表 api.articles 结构
DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(256) NOT NULL COMMENT '标题',
  `alias` VARCHAR(256) DEFAULT NULL
  COMMENT '别名，子标题等',
  `article_cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类',
  `tags` varchar(256) DEFAULT NULL COMMENT '标签',
  `picture` varchar(256) DEFAULT NULL COMMENT '主图',
  `url` varchar(256) DEFAULT NULL COMMENT '外部URL',
  `detail` mediumtext COMMENT '详情',
  `click_num` int(11) NOT NULL DEFAULT '0' COMMENT '点击数',
  `status` tinyint(1) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章表';

-- 正在导出表  api.articles 的数据：2 rows
DELETE FROM `articles`;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` (`id`, `uuid`, `user_id`, `name`, `alias`, `article_cate_id`, `tags`, `picture`, `url`, `detail`, `click_num`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'f4312a9326c84f3caac95bbbd47051b0', 40, '文章1', '', 1, 'php laravel lnmp', '', '', '', 23, 2, 1503546272, 1503548194),
	(2, '4b74f655a3b541219bf56b724ff0b675', 40, '文章1', '', 1, 'php laravel lnmp', '', '', '', 0, 1, 1503548194, 1503548194);
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;

-- 导出  表 api.article_cates 结构
DROP TABLE IF EXISTS `article_cates`;
CREATE TABLE IF NOT EXISTS `article_cates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `color` varchar(50) DEFAULT NULL COMMENT '颜色，高级用法',
  `icon` varchar(50) DEFAULT NULL COMMENT 'ICON，高级用法',
  `poster` varchar(256) DEFAULT NULL COMMENT '海报图',
  `intro` varchar(256) DEFAULT NULL COMMENT '简介',
  `keywords` varchar(256) DEFAULT NULL COMMENT 'SEO关键词',
  `description` varchar(512) DEFAULT NULL COMMENT 'SEO描述',
  `status` tinyint(1) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章分类表';

-- 正在导出表  api.article_cates 的数据：3 rows
DELETE FROM `article_cates`;
/*!40000 ALTER TABLE `article_cates` DISABLE KEYS */;
INSERT INTO `article_cates` (`id`, `uuid`, `user_id`, `name`, `color`, `icon`, `poster`, `intro`, `keywords`, `description`, `status`, `created_at`, `updated_at`) VALUES
	(1, '8225676d5ac14225ad42bbcb0a3811c1', 40, 'a-c', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1503544936, 1503544936),
	(2, '68f4b97f8f134a5b9848210ace94b1b3', 40, 'nodejs', '#fff', 'https://nodejs.org/static/images/logo.svg', '海报图', 'Node.js® is a JavaScript runtime built on Chrome\'s V8 JavaScript engine.', 'node', 'Node.js® is a JavaScript runtime built on Chrome\'s V8 JavaScript engine. Node.js uses an event-driven, non-blocking I/O model that makes it lightweight and efficient. Node.js\' package ecosystem, npm, is the largest ecosystem of open source libraries in the world.', 1, 1503545115, 1503545335),
	(3, 'ccfa5b3e755f42f8a5eca8cc4167ea34', 40, 'node', '#fff', 'https://nodejs.org/static/images/logo.svg', '海报图', 'Node.js® is a JavaScript runtime built on Chrome\'s V8 JavaScript engine.', 'node', 'Node.js® is a JavaScript runtime built on Chrome\'s V8 JavaScript engine. Node.js uses an event-driven, non-blocking I/O model that makes it lightweight and efficient. Node.js\' package ecosystem, npm, is the largest ecosystem of open source libraries in the world.', 2, 1503548190, 1503548190);
/*!40000 ALTER TABLE `article_cates` ENABLE KEYS */;

-- 导出  表 api.article_tags 结构
DROP TABLE IF EXISTS `article_tags`;
CREATE TABLE IF NOT EXISTS `article_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `color` varchar(50) DEFAULT NULL COMMENT '颜色，高级用法',
  `icon` varchar(50) DEFAULT NULL COMMENT 'ICON，高级用法',
  `poster` varchar(256) DEFAULT NULL COMMENT '海报图',
  `intro` varchar(256) DEFAULT NULL COMMENT '简介',
  `keywords` varchar(256) DEFAULT NULL COMMENT 'SEO关键词',
  `description` varchar(512) DEFAULT NULL COMMENT 'SEO描述',
  `status` tinyint(1) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章分类表';

-- 正在导出表  api.article_tags 的数据：1 rows
DELETE FROM `article_tags`;
/*!40000 ALTER TABLE `article_tags` DISABLE KEYS */;
INSERT INTO `article_tags` (`id`, `uuid`, `user_id`, `name`, `color`, `icon`, `poster`, `intro`, `keywords`, `description`, `status`, `created_at`, `updated_at`) VALUES
	(2, '387c09bb3b3b469b9a100a8e83b03312', 40, 'php', '', '', '', '', '', '', 1, 1503546155, 1503546155);
/*!40000 ALTER TABLE `article_tags` ENABLE KEYS */;

-- 导出  表 api.configs 结构
DROP TABLE IF EXISTS `configs`;
CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `k` varchar(50) NOT NULL COMMENT 'key值',
  `desc` varchar(50) DEFAULT NULL COMMENT '描述',
  `v` text COMMENT 'value值',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='配置表';

-- 正在导出表  api.configs 的数据：0 rows
DELETE FROM `configs`;
/*!40000 ALTER TABLE `configs` DISABLE KEYS */;
/*!40000 ALTER TABLE `configs` ENABLE KEYS */;

-- 导出  表 api.custom_datas 结构
DROP TABLE IF EXISTS `custom_datas`;
CREATE TABLE IF NOT EXISTS `custom_datas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `custom_table__id` int(11) NOT NULL,
  `json` longtext NOT NULL COMMENT '内容(json格式)',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='自定义表的数据';

-- 正在导出表  api.custom_datas 的数据：0 rows
DELETE FROM `custom_datas`;
/*!40000 ALTER TABLE `custom_datas` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_datas` ENABLE KEYS */;

-- 导出  表 api.custom_fields 结构
DROP TABLE IF EXISTS `custom_fields`;
CREATE TABLE IF NOT EXISTS `custom_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `custom_table_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL COMMENT '字段名称',
  `type` varchar(32) NOT NULL COMMENT '字段类型',
  `placeholder` varchar(32) DEFAULT NULL COMMENT '字段解释',
  `required` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0非必填，1必填',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='自定义字段表';

-- 正在导出表  api.custom_fields 的数据：0 rows
DELETE FROM `custom_fields`;
/*!40000 ALTER TABLE `custom_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_fields` ENABLE KEYS */;

-- 导出  表 api.custom_tables 结构
DROP TABLE IF EXISTS `custom_tables`;
CREATE TABLE IF NOT EXISTS `custom_tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL COMMENT '表名',
  `comment` varchar(32) DEFAULT NULL COMMENT '表注释',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='自定义表';

-- 正在导出表  api.custom_tables 的数据：0 rows
DELETE FROM `custom_tables`;
/*!40000 ALTER TABLE `custom_tables` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_tables` ENABLE KEYS */;

-- 导出  表 api.files 结构
DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `dir` varchar(50) NOT NULL COMMENT '物理目录（根目录）',
  `folder` varchar(256) NOT NULL DEFAULT '/' COMMENT '虚拟文件夹全名（相对于根目录）',
  `name` varchar(256) DEFAULT NULL COMMENT '自定义的文件名',
  `ext` varchar(10) DEFAULT NULL COMMENT '后缀',
  `size` int(11) DEFAULT '0' COMMENT '文件大小(Byte)',
  `media` tinyint(1) DEFAULT '1' COMMENT '1在素材库，0从素材库移出',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文件表';

-- 正在导出表  api.files 的数据：0 rows
DELETE FROM `files`;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;

-- 导出  表 api.products 结构
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '编号',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
  `alias` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '别名',
  `picture` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '主图',
  `attrs` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性',
  `params` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '参数',
  `url` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '外部URL',
  `detail` text COLLATE utf8_unicode_ci COMMENT '详情',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0''不显示/下架'',1''显示/上架'',2''推荐''',
  `created_at` int(11) DEFAULT '0',
  `updated_at` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='商品表';

-- 正在导出表  api.products 的数据：1 rows
DELETE FROM `products`;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `uuid`, `user_id`, `code`, `name`, `alias`, `picture`, `attrs`, `params`, `url`, `detail`, `status`, `created_at`, `updated_at`) VALUES
	(2, '156ce8dbabfd4d0fa147d6853d80877c', 40, 'code', '名称', '别名', '主图，可以是单个图，或者多个图', '101:石膏;102:水晶系列', '101:白色,黑色;102:L,XL', '外部地址，如淘宝地址', '详情，建议markdown', 0, 1503547594, 1503547594);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- 导出  表 api.product_attrs 结构
DROP TABLE IF EXISTS `product_attrs`;
CREATE TABLE IF NOT EXISTS `product_attrs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='产品属性表';

-- 正在导出表  api.product_attrs 的数据：13 rows
DELETE FROM `product_attrs`;
/*!40000 ALTER TABLE `product_attrs` DISABLE KEYS */;
INSERT INTO `product_attrs` (`id`, `uuid`, `user_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(7, '102', 0, '系列', NULL, 0, 0),
	(8, '103', 0, '风格', NULL, 0, 0),
	(9, '104', 0, '面料', NULL, 0, 0),
	(10, '105', 0, '材质', NULL, 0, 0),
	(11, '106', 0, '产地', NULL, 0, 0),
	(12, '107', 0, '价格', NULL, 0, 0),
	(13, '108', 0, '适用季节', NULL, 0, 0),
	(14, '39b7afb3489440fba60906c61acb31b7', 0, '属性1', NULL, 1502781329, 1502781329),
	(15, '24404e075c5444ecbde06932a540c9f9', 0, '产品11', NULL, 1502787442, 1502787518),
	(16, '8f62da6cfc674b9ab004db6d30f675d4', 1, 'ww', NULL, 1503313192, 1503313192),
	(17, 'f2f4b3cd3dd44af1adac453b4a76f80a', 1, 'allen-test1', NULL, 1503381451, 1503381451),
	(18, '65c1ff10df144b6b96ed69fccce9c6b8', 40, '标签组', NULL, 1503546492, 1503546492),
	(20, 'cfa8c2b12877424eba7cd142bef4bb90', 40, '属性', NULL, 1503548195, 1503548195);
/*!40000 ALTER TABLE `product_attrs` ENABLE KEYS */;

-- 导出  表 api.product_params 结构
DROP TABLE IF EXISTS `product_params`;
CREATE TABLE IF NOT EXISTS `product_params` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '标签名',
  `description` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `values` text COLLATE utf8_unicode_ci COMMENT '默认值，如：黑色，白色，红色',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='产品标签表';

-- 正在导出表  api.product_params 的数据：7 rows
DELETE FROM `product_params`;
/*!40000 ALTER TABLE `product_params` DISABLE KEYS */;
INSERT INTO `product_params` (`id`, `uuid`, `user_id`, `name`, `description`, `values`, `created_at`, `updated_at`) VALUES
	(1, '201', 0, '颜色', NULL, '["黑","白"]', 0, 0),
	(2, '202', 0, '尺寸', NULL, '["L","XL"]', 0, 0),
	(8, 'be8b3a6fa7af4ba6b634826b73d5cc08', 1, '属性2', NULL, NULL, 1502951884, 1502951884),
	(9, 'b4084f4cb9e7440b8eb2268d956dfb23', 1, '标签', NULL, NULL, 1502951912, 1502951912),
	(11, 'cbe1d5721e62453a8f7836b02f854540', 1, '产品11111', NULL, '标签1，标签2，标签3', 1502952453, 1502952472),
	(13, '0367f3063fa5449088d8e309cbeb8361', 39, '产品1222', 'miaoshu-description', 'jsonString', 1503485227, 1503539770),
	(15, 'fa7ee930fd7344b9b81751871ddd8bdc', 40, '参数组', NULL, '参数1，参数2', 1503548196, 1503548196);
/*!40000 ALTER TABLE `product_params` ENABLE KEYS */;

-- 导出  表 api.users 结构
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加者',
  `uuid` char(32) NOT NULL,
  `group` varchar(50) NOT NULL COMMENT '团队名称',
  `name` varchar(50) NOT NULL COMMENT '用户名',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `pwd` varchar(256) NOT NULL COMMENT '密码',
  `domain` varchar(50) DEFAULT NULL COMMENT '域名',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号码',
  `deadline` int(11) NOT NULL DEFAULT '0' COMMENT '截止日期',
  `remark` text COMMENT '备注',
  `login_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `custom_table_max` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '表数量',
  `custom_field_max` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '字段数量',
  `user_num` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '用户数',
  `is_super` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1是超级管理员，0否',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员表';

-- 正在导出表  api.users 的数据：6 rows
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `user_id`, `uuid`, `group`, `name`, `email`, `pwd`, `domain`, `mobile`, `deadline`, `remark`, `login_count`, `custom_table_max`, `custom_field_max`, `user_num`, `is_super`, `status`, `created_at`, `updated_at`) VALUES
	(1, 0, '0c7ef6dad2c34f1495fe09750d5135a7', 'root', 'root', '704872038@qq.com', '6f5360a894e966cc6c255a41db135a8a', NULL, '18782988780', 0, '', 213, 0, 0, 10, 1, 1, 1450759038, 1501468787),
	(2, 0, 'd209a8665bed4360bc298e23c5ac2641', 'demo', 'demo', '222222222222@qq.com', 'f4d45733f8a2d7dd39a139966434c57c', NULL, NULL, 0, NULL, 0, 1, 10, 10, 1, 1, 1503293864, 1503293864),
	(38, 0, 'bfbb3bf8d72d432ba324a64ff94922fd', 'test', 'test', 'test@qq.com', '6f5360a894e966cc6c255a41db135a8a', NULL, NULL, 0, NULL, 0, 1, 10, 10, 1, 1, 1503294900, 1503294900),
	(39, 0, 'dca629a2ce1741b3b9b8d05e5a10e6f9', 'root', 'a', 'a@qq.com', '6f5360a894e966cc6c255a41db135a8a', NULL, NULL, 0, NULL, 0, 1, 10, 10, 1, 1, 1503300615, 1503300615),
	(40, 0, 'a2091e8c2a3541a7a56df6050495ce05', 'bb', 'bb', '2@qq.com', '6f5360a894e966cc6c255a41db135a8a', NULL, NULL, 0, NULL, 0, 1, 10, 1, 1, 1, 1503544125, 1503544125),
	(42, 40, '89f3ce5a6ee943fc9dd1b4ca74d9c9c8', 'bb', 'bbbb', 'b-2@qq.com', '6f5360a894e966cc6c255a41db135a8a', NULL, NULL, 0, NULL, 0, 1, 10, 1, 0, 1, 1503544904, 1503544904);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
