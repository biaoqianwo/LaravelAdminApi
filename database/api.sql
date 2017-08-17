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
  `article_cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类',
  `article_tags` varchar(256) DEFAULT NULL COMMENT '标签',
  `name` varchar(256) NOT NULL COMMENT '标题',
  `alias` varchar(256) DEFAULT NULL COMMENT '别名，子标题等',
  `picture` varchar(256) DEFAULT NULL COMMENT '主图',
  `detail` mediumtext COMMENT '详情',
  `status` tinyint(1) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `url` varchar(256) DEFAULT NULL COMMENT '外部URL',
  `click_num` int(11) NOT NULL DEFAULT '0' COMMENT '点击数',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章表';

-- 正在导出表  api.articles 的数据：0 rows
DELETE FROM `articles`;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章分类表';

-- 正在导出表  api.article_cates 的数据：0 rows
DELETE FROM `article_cates`;
/*!40000 ALTER TABLE `article_cates` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_cates` ENABLE KEYS */;

-- 导出  表 api.article_tags 结构
DROP TABLE IF EXISTS `article_tags`;
CREATE TABLE IF NOT EXISTS `article_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `alias` varchar(50) DEFAULT NULL COMMENT '别名，如英文名',
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章分类表';

-- 正在导出表  api.article_tags 的数据：0 rows
DELETE FROM `article_tags`;
/*!40000 ALTER TABLE `article_tags` DISABLE KEYS */;
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
  `folder` varchar(256) NOT NULL DEFAULT '/' COMMENT '文件夹全名（相对于根目录）',
  `name` varchar(256) DEFAULT NULL COMMENT '文件名（含后缀名）',
  `size` int(11) DEFAULT '0' COMMENT '文件大小(Byte)',
  `used_num` tinyint(4) DEFAULT '1' COMMENT '被使用次数',
  `media` tinyint(1) DEFAULT '0' COMMENT '1在素材库，0从素材库移出',
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
  `attrs` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性',
  `tags` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '标签',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0''不显示/下架'',1''显示/上架'',2''推荐''',
  `picture` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '主图',
  `url` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '外部URL',
  `params` text COLLATE utf8_unicode_ci COMMENT '规格参数',
  `detail` text COLLATE utf8_unicode_ci COMMENT '详情',
  `created_at` int(11) DEFAULT '0',
  `updated_at` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='商品表';

-- 正在导出表  api.products 的数据：0 rows
DELETE FROM `products`;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- 导出  表 api.product_attrs 结构
DROP TABLE IF EXISTS `product_attrs`;
CREATE TABLE IF NOT EXISTS `product_attrs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='产品属性表';

-- 正在导出表  api.product_attrs 的数据：9 rows
DELETE FROM `product_attrs`;
/*!40000 ALTER TABLE `product_attrs` DISABLE KEYS */;
INSERT INTO `product_attrs` (`id`, `uuid`, `user_id`, `name`, `created_at`, `updated_at`) VALUES
	(7, '102', 0, '系列', 0, 0),
	(8, '103', 0, '风格', 0, 0),
	(9, '104', 0, '面料', 0, 0),
	(10, '105', 0, '材质', 0, 0),
	(11, '106', 0, '产地', 0, 0),
	(12, '107', 0, '价格', 0, 0),
	(13, '108', 0, '适用季节', 0, 0),
	(14, '39b7afb3489440fba60906c61acb31b7', 0, '属性1', 1502781329, 1502781329),
	(15, '24404e075c5444ecbde06932a540c9f9', 0, '产品11', 1502787442, 1502787518);
/*!40000 ALTER TABLE `product_attrs` ENABLE KEYS */;

-- 导出  表 api.product_tags 结构
DROP TABLE IF EXISTS `product_tags`;
CREATE TABLE IF NOT EXISTS `product_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '标签名',
  `values` text COLLATE utf8_unicode_ci COMMENT '默认值，如：黑色，白色，红色',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='产品标签表';

-- 正在导出表  api.product_tags 的数据：5 rows
DELETE FROM `product_tags`;
/*!40000 ALTER TABLE `product_tags` DISABLE KEYS */;
INSERT INTO `product_tags` (`id`, `uuid`, `user_id`, `name`, `values`, `created_at`, `updated_at`) VALUES
	(1, '201', 0, '颜色', '["黑","白"]', 0, 0),
	(2, '202', 0, '尺寸', '["L","XL"]', 0, 0),
	(8, 'be8b3a6fa7af4ba6b634826b73d5cc08', 1, '属性2', NULL, 1502951884, 1502951884),
	(9, 'b4084f4cb9e7440b8eb2268d956dfb23', 1, '标签', NULL, 1502951912, 1502951912),
	(11, 'cbe1d5721e62453a8f7836b02f854540', 1, '产品11111', '标签1，标签2，标签3', 1502952453, 1502952472);
/*!40000 ALTER TABLE `product_tags` ENABLE KEYS */;

-- 导出  表 api.users 结构
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `uuid` char(32) DEFAULT NULL,
  `group` varchar(50) DEFAULT NULL COMMENT '团队名称',
  `name` varchar(50) DEFAULT NULL COMMENT '用户名',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `pwd` varchar(256) NOT NULL COMMENT '密码',
  `domain` varchar(50) DEFAULT NULL COMMENT '域名',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号码',
  `deadline` date DEFAULT NULL COMMENT '截止日期',
  `remark` text COMMENT '备注',
  `login_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `custom_table_max` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '表数量',
  `custom_field_max` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '字段数量',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `is_super` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1是超级管理员，0否',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员表';

-- 正在导出表  api.users 的数据：1 rows
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `uuid`, `group`, `name`, `email`, `pwd`, `domain`, `mobile`, `deadline`, `remark`, `login_count`, `custom_table_max`, `custom_field_max`, `status`, `is_super`, `created_at`, `updated_at`) VALUES
	(1, '0c7ef6dad2c34f1495fe09750d5135a7', 'root', 'root', '704872038@qq.com', '6f5360a894e966cc6c255a41db135a8a', NULL, '18782988780', NULL, '', 213, 0, 0, 1, 1, 1450759038, 1501468787);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
