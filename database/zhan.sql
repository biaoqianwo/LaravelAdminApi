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


-- 导出 zhan 的数据库结构
DROP DATABASE IF EXISTS `zhan`;
CREATE DATABASE IF NOT EXISTS `zhan` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `zhan`;

-- 导出  表 zhan.agents 结构
DROP TABLE IF EXISTS `agents`;
CREATE TABLE IF NOT EXISTS `agents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(256) NOT NULL COMMENT '名称',
  `person` varchar(256) DEFAULT NULL COMMENT '联系人',
  `address` varchar(256) DEFAULT NULL COMMENT '地址',
  `tel` varchar(256) DEFAULT NULL COMMENT '电话',
  `picture` varchar(256) DEFAULT NULL COMMENT '主图',
  `detail` text COMMENT '详情',
  `status` tinyint(4) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='代理商表';

-- 正在导出表  zhan.agents 的数据：0 rows
DELETE FROM `agents`;
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
/*!40000 ALTER TABLE `agents` ENABLE KEYS */;

-- 导出  表 zhan.articles 结构
DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `article_cate_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(256) NOT NULL COMMENT '标题',
  `alias` varchar(256) NOT NULL COMMENT '别名，子标题等',
  `picture` varchar(256) DEFAULT NULL COMMENT '主图',
  `detail` mediumtext COMMENT '详情',
  `status` tinyint(1) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `url` varchar(256) DEFAULT NULL COMMENT '外部URL',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章表';

-- 正在导出表  zhan.articles 的数据：0 rows
DELETE FROM `articles`;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;

-- 导出  表 zhan.article_cates 结构
DROP TABLE IF EXISTS `article_cates`;
CREATE TABLE IF NOT EXISTS `article_cates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `color` varchar(50) DEFAULT NULL COMMENT '颜色，高级用法',
  `icon` varchar(50) DEFAULT NULL COMMENT 'ICON，高级用法',
  `poster` varchar(256) DEFAULT NULL COMMENT '海报图',
  `intro` varchar(256) DEFAULT NULL,
  `keywords` varchar(256) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章分类表';

-- 正在导出表  zhan.article_cates 的数据：0 rows
DELETE FROM `article_cates`;
/*!40000 ALTER TABLE `article_cates` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_cates` ENABLE KEYS */;

-- 导出  表 zhan.article_tags 结构
DROP TABLE IF EXISTS `article_tags`;
CREATE TABLE IF NOT EXISTS `article_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `alias` varchar(50) NOT NULL COMMENT '别名，如英文名',
  `color` varchar(50) DEFAULT NULL COMMENT '颜色，高级用法',
  `icon` varchar(50) DEFAULT NULL COMMENT 'ICON，高级用法',
  `poster` varchar(256) DEFAULT NULL COMMENT '海报图',
  `intro` varchar(256) DEFAULT NULL,
  `keywords` varchar(256) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章分类表';

-- 正在导出表  zhan.article_tags 的数据：0 rows
DELETE FROM `article_tags`;
/*!40000 ALTER TABLE `article_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_tags` ENABLE KEYS */;

-- 导出  表 zhan.carousels 结构
DROP TABLE IF EXISTS `carousels`;
CREATE TABLE IF NOT EXISTS `carousels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `picture` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '主标题',
  `subtitle` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '副标题',
  `url` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '详情地址',
  `linkType` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkContent` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) DEFAULT '0',
  `updated_at` int(11) DEFAULT '0',
  `deleted_at` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='轮播表';

-- 正在导出表  zhan.carousels 的数据：0 rows
DELETE FROM `carousels`;
/*!40000 ALTER TABLE `carousels` DISABLE KEYS */;
/*!40000 ALTER TABLE `carousels` ENABLE KEYS */;

-- 导出  表 zhan.cases 结构
DROP TABLE IF EXISTS `cases`;
CREATE TABLE IF NOT EXISTS `cases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `category` varchar(50) NOT NULL DEFAULT '0' COMMENT '组名',
  `name` varchar(256) NOT NULL COMMENT '标题',
  `picture` varchar(256) DEFAULT NULL COMMENT '主图',
  `detail` text COMMENT '详情',
  `status` tinyint(4) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='案例表';

-- 正在导出表  zhan.cases 的数据：0 rows
DELETE FROM `cases`;
/*!40000 ALTER TABLE `cases` DISABLE KEYS */;
/*!40000 ALTER TABLE `cases` ENABLE KEYS */;

-- 导出  表 zhan.configs 结构
DROP TABLE IF EXISTS `configs`;
CREATE TABLE IF NOT EXISTS `configs` (
  `uid` int(11) NOT NULL,
  `k` varchar(50) NOT NULL,
  `desc` varchar(50) DEFAULT NULL,
  `v` longtext,
  `img` varchar(256) DEFAULT NULL,
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站配置表';

-- 正在导出表  zhan.configs 的数据：0 rows
DELETE FROM `configs`;
/*!40000 ALTER TABLE `configs` DISABLE KEYS */;
/*!40000 ALTER TABLE `configs` ENABLE KEYS */;

-- 导出  表 zhan.documents 结构
DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `category` int(11) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `document_cate_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(256) NOT NULL COMMENT '标题',
  `picture` varchar(256) DEFAULT NULL COMMENT '主图',
  `detail` text COMMENT '详情',
  `status` tinyint(4) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `url` varchar(256) DEFAULT NULL,
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章表';

-- 正在导出表  zhan.documents 的数据：0 rows
DELETE FROM `documents`;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;

-- 导出  表 zhan.document_cates 结构
DROP TABLE IF EXISTS `document_cates`;
CREATE TABLE IF NOT EXISTS `document_cates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `alias` varchar(50) NOT NULL COMMENT '别名',
  `color` varchar(50) DEFAULT NULL COMMENT '颜色',
  `poster` varchar(256) DEFAULT NULL COMMENT '海报图',
  `intro` varchar(256) DEFAULT NULL,
  `keywords` varchar(256) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章分类表';

-- 正在导出表  zhan.document_cates 的数据：0 rows
DELETE FROM `document_cates`;
/*!40000 ALTER TABLE `document_cates` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_cates` ENABLE KEYS */;

-- 导出  表 zhan.downloads 结构
DROP TABLE IF EXISTS `downloads`;
CREATE TABLE IF NOT EXISTS `downloads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `category` varchar(256) DEFAULT NULL,
  `name` varchar(256) NOT NULL COMMENT '标题',
  `url` varchar(256) NOT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='下载表';

-- 正在导出表  zhan.downloads 的数据：0 rows
DELETE FROM `downloads`;
/*!40000 ALTER TABLE `downloads` DISABLE KEYS */;
/*!40000 ALTER TABLE `downloads` ENABLE KEYS */;

-- 导出  表 zhan.fields 结构
DROP TABLE IF EXISTS `fields`;
CREATE TABLE IF NOT EXISTS `fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `tbl_id` int(11) NOT NULL COMMENT '日期',
  `name` varchar(32) NOT NULL,
  `type` varchar(32) NOT NULL,
  `placeholder` varchar(32) DEFAULT NULL,
  `required` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0非必填，1必填',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid_tbl_id_name_deleted_at` (`uid`,`tbl_id`,`name`,`deleted_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='表';

-- 正在导出表  zhan.fields 的数据：0 rows
DELETE FROM `fields`;
/*!40000 ALTER TABLE `fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `fields` ENABLE KEYS */;

-- 导出  表 zhan.files 结构
DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `uuid` char(32) NOT NULL,
  `folder` varchar(256) NOT NULL DEFAULT '/',
  `name` varchar(256) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `used_num` tinyint(4) DEFAULT '1',
  `media_num` tinyint(4) DEFAULT '0',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文件表';

-- 正在导出表  zhan.files 的数据：0 rows
DELETE FROM `files`;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;

-- 导出  表 zhan.histories 结构
DROP TABLE IF EXISTS `histories`;
CREATE TABLE IF NOT EXISTS `histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `date` varchar(256) NOT NULL COMMENT '日期',
  `intro` text COMMENT '详情',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid_code` (`uid`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='发展历程表';

-- 正在导出表  zhan.histories 的数据：0 rows
DELETE FROM `histories`;
/*!40000 ALTER TABLE `histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `histories` ENABLE KEYS */;

-- 导出  表 zhan.honors 结构
DROP TABLE IF EXISTS `honors`;
CREATE TABLE IF NOT EXISTS `honors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(256) NOT NULL COMMENT '标题',
  `picture` varchar(256) NOT NULL COMMENT '主图',
  `status` tinyint(4) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='荣誉资质表';

-- 正在导出表  zhan.honors 的数据：0 rows
DELETE FROM `honors`;
/*!40000 ALTER TABLE `honors` DISABLE KEYS */;
/*!40000 ALTER TABLE `honors` ENABLE KEYS */;

-- 导出  表 zhan.jobs 结构
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(256) NOT NULL COMMENT '职位',
  `address` varchar(256) NOT NULL COMMENT '工作地点',
  `detail` text COMMENT '详情',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid_code` (`uid`,`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='人才招聘表';

-- 正在导出表  zhan.jobs 的数据：0 rows
DELETE FROM `jobs`;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;

-- 导出  表 zhan.pages 结构
DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `code` varchar(256) NOT NULL COMMENT '标识',
  `name` varchar(256) NOT NULL COMMENT '标题',
  `poster` varchar(256) DEFAULT NULL COMMENT '海报',
  `detail` text COMMENT '详情',
  `status` tinyint(4) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid_code` (`uid`,`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='单页表';

-- 正在导出表  zhan.pages 的数据：0 rows
DELETE FROM `pages`;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;

-- 导出  表 zhan.partners 结构
DROP TABLE IF EXISTS `partners`;
CREATE TABLE IF NOT EXISTS `partners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(256) NOT NULL COMMENT '标题',
  `picture` varchar(256) DEFAULT NULL COMMENT '主图',
  `detail` text COMMENT '详情',
  `status` tinyint(4) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='合作伙伴表';

-- 正在导出表  zhan.partners 的数据：0 rows
DELETE FROM `partners`;
/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
/*!40000 ALTER TABLE `partners` ENABLE KEYS */;

-- 导出  表 zhan.products 结构
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `uuid` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category` int(11) NOT NULL DEFAULT '0',
  `serie` int(11) NOT NULL DEFAULT '0',
  `code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '型号',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
  `attrs` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性',
  `tags` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '标签',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '''不显示/下架'', ''显示/上架'', ''推荐''',
  `alias` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '别名',
  `picture` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '主图',
  `url` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `params` text COLLATE utf8_unicode_ci COMMENT '规格参数',
  `detail` text COLLATE utf8_unicode_ci COMMENT '详情',
  `created_at` int(11) DEFAULT '0',
  `updated_at` int(11) DEFAULT '0',
  `deleted_at` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='商品表';

-- 正在导出表  zhan.products 的数据：4 rows
DELETE FROM `products`;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `user_id`, `uuid`, `category`, `serie`, `code`, `name`, `attrs`, `tags`, `status`, `alias`, `picture`, `url`, `params`, `detail`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 29, NULL, 0, 0, NULL, 'demo', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
	(9, 1, 'cefc530754e24aa99bb31a14f25afb42', 0, 0, 'ddd3', '产品1', '101:石膏;102:水晶系列', '101:白色,黑色;102:L,XL', 0, NULL, NULL, NULL, NULL, NULL, 1502860822, 1502860822, 0),
	(5, 29, 'fa6c71be1f9c472ca7b06ec4f377e941', 0, 0, 'ccc', '产品1', '101:分类:石膏;102:系列:水晶系列', '101:颜色:白色,黑色;102:尺寸:L,XL', 1, NULL, NULL, NULL, NULL, NULL, 1502775300, 1502775300, 0),
	(8, 29, '88a38bab021d4aac89b70682f62df7b6', 0, 0, 'ddd3', '产品1', '101:石膏;102:水晶系列', '101:白色,黑色;102:L,XL', 1, NULL, NULL, NULL, NULL, NULL, 1502775368, 1502775368, 0);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- 导出  表 zhan.product_attrs 结构
DROP TABLE IF EXISTS `product_attrs`;
CREATE TABLE IF NOT EXISTS `product_attrs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `uuid` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='产品属性表';

-- 正在导出表  zhan.product_attrs 的数据：9 rows
DELETE FROM `product_attrs`;
/*!40000 ALTER TABLE `product_attrs` DISABLE KEYS */;
INSERT INTO `product_attrs` (`id`, `user_id`, `uuid`, `name`, `created_at`, `updated_at`) VALUES
	(7, 0, '102', '系列', 0, 0),
	(8, 0, '103', '风格', 0, 0),
	(9, 0, '104', '面料', 0, 0),
	(10, 0, '105', '材质', 0, 0),
	(11, 0, '106', '产地', 0, 0),
	(12, 0, '107', '价格', 0, 0),
	(13, 0, '108', '适用季节', 0, 0),
	(14, 0, '39b7afb3489440fba60906c61acb31b7', '属性1', 1502781329, 1502781329),
	(15, 0, '24404e075c5444ecbde06932a540c9f9', '产品11', 1502787442, 1502787518);
/*!40000 ALTER TABLE `product_attrs` ENABLE KEYS */;

-- 导出  表 zhan.product_cates 结构
DROP TABLE IF EXISTS `product_cates`;
CREATE TABLE IF NOT EXISTS `product_cates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL COMMENT '颜色',
  `picture` varchar(256) DEFAULT NULL COMMENT '主图',
  `intro` text,
  `keywords` varchar(256) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='产品分类表';

-- 正在导出表  zhan.product_cates 的数据：0 rows
DELETE FROM `product_cates`;
/*!40000 ALTER TABLE `product_cates` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_cates` ENABLE KEYS */;

-- 导出  表 zhan.product_series 结构
DROP TABLE IF EXISTS `product_series`;
CREATE TABLE IF NOT EXISTS `product_series` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL COMMENT '颜色',
  `picture` varchar(256) DEFAULT NULL COMMENT '主图',
  `intro` text,
  `keywords` varchar(256) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='产品系列表';

-- 正在导出表  zhan.product_series 的数据：0 rows
DELETE FROM `product_series`;
/*!40000 ALTER TABLE `product_series` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_series` ENABLE KEYS */;

-- 导出  表 zhan.product_tags 结构
DROP TABLE IF EXISTS `product_tags`;
CREATE TABLE IF NOT EXISTS `product_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `uuid` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `values` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='产品标签表';

-- 正在导出表  zhan.product_tags 的数据：5 rows
DELETE FROM `product_tags`;
/*!40000 ALTER TABLE `product_tags` DISABLE KEYS */;
INSERT INTO `product_tags` (`id`, `user_id`, `uuid`, `name`, `values`, `created_at`, `updated_at`) VALUES
	(1, 0, '201', '颜色', '["黑","白"]', 0, 0),
	(2, 0, '202', '尺寸', '["L","XL"]', 0, 0),
	(8, 1, 'be8b3a6fa7af4ba6b634826b73d5cc08', '属性2', NULL, 1502951884, 1502951884),
	(9, 1, 'b4084f4cb9e7440b8eb2268d956dfb23', '标签', NULL, 1502951912, 1502951912),
	(11, 1, 'cbe1d5721e62453a8f7836b02f854540', '产品11111', '标签1，标签2，标签3', 1502952453, 1502952472);
/*!40000 ALTER TABLE `product_tags` ENABLE KEYS */;

-- 导出  表 zhan.stores 结构
DROP TABLE IF EXISTS `stores`;
CREATE TABLE IF NOT EXISTS `stores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(256) NOT NULL COMMENT '名称',
  `address` varchar(256) DEFAULT NULL COMMENT '地址',
  `phone` varchar(256) DEFAULT NULL COMMENT '电话',
  `point` varchar(256) DEFAULT NULL COMMENT '经纬度',
  `picture` varchar(256) DEFAULT NULL COMMENT '主图',
  `detail` text COMMENT '详情',
  `status` tinyint(4) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='门店表';

-- 正在导出表  zhan.stores 的数据：0 rows
DELETE FROM `stores`;
/*!40000 ALTER TABLE `stores` DISABLE KEYS */;
/*!40000 ALTER TABLE `stores` ENABLE KEYS */;

-- 导出  表 zhan.tables 结构
DROP TABLE IF EXISTS `tables`;
CREATE TABLE IF NOT EXISTS `tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL COMMENT '表名',
  `comment` varchar(32) DEFAULT NULL COMMENT '注释',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid_name` (`uid`,`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='表';

-- 正在导出表  zhan.tables 的数据：2 rows
DELETE FROM `tables`;
/*!40000 ALTER TABLE `tables` DISABLE KEYS */;
INSERT INTO `tables` (`id`, `uid`, `name`, `comment`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 24, 'demos', '演示', 1502259346, 1502265642, 1502265642),
	(2, 24, 'test1', '测试', 1502262447, 1502262447, 0);
/*!40000 ALTER TABLE `tables` ENABLE KEYS */;

-- 导出  表 zhan.tdatas 结构
DROP TABLE IF EXISTS `tdatas`;
CREATE TABLE IF NOT EXISTS `tdatas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `tbl_id` int(11) NOT NULL COMMENT '表ID',
  `json` longtext NOT NULL COMMENT 'json内容',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='表';

-- 正在导出表  zhan.tdatas 的数据：2 rows
DELETE FROM `tdatas`;
/*!40000 ALTER TABLE `tdatas` DISABLE KEYS */;
INSERT INTO `tdatas` (`id`, `uid`, `tbl_id`, `json`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 24, 3, '{"title":"\\u8fd9\\u662f\\u4e00\\u4e2a\\u6d4b\\u8bd5","img":"http:\\/\\/bcc.biaoqianwo.com\\/Public\\/Uploads\\/24\\/Table\\/201708091242264248.jpg","publish_time":"2017-08-09 14:20:01","like_num":"1","content":"&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 10px;&quot;&gt;\\u8fd9\\u662f\\u6d4b\\u8bd5\\u5185\\u5bb9&lt;\\/p&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 10px;&quot;&gt;&lt;img src=&quot;http:\\/\\/bcc.biaoqianwo.com\\/Public\\/Uploads\\/24\\/FroalaEditor\\/201708091154086774.jpg&quot; style=&quot;display: block; vertical-align: top; margin: 5px auto; box-sizing: border-box; border: 0px; cursor: pointer; position: relative; max-width: 100%;&quot; fr-original-style=&quot;display: block; vertical-align: top; margin: 5px auto;&quot; fr-original-class=&quot;fr-draggable&quot;&gt;&lt;\\/p&gt;"}', 1502259634, 1502259634, 0),
	(2, 24, 2, '{"dass":"fd","22":"fdsf","33":"gdsg","444":"gsdgd","555":"gdgd"}', 1502264823, 1502264823, 0);
/*!40000 ALTER TABLE `tdatas` ENABLE KEYS */;

-- 导出  表 zhan.users 结构
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `uuid` char(32) DEFAULT NULL,
  `group` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT '用户名',
  `domain` varchar(50) DEFAULT NULL COMMENT '域名',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号码',
  `pwd` varchar(256) NOT NULL COMMENT '密码',
  `deadline` date DEFAULT NULL COMMENT '截止日期',
  `remark` text COMMENT '备注',
  `login_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `tbl_limit` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '表数量',
  `field_limit` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '字段数量',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `is_super` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1是超级管理员，0否',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员表';

-- 正在导出表  zhan.users 的数据：1 rows
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `uuid`, `group`, `name`, `domain`, `email`, `mobile`, `pwd`, `deadline`, `remark`, `login_count`, `tbl_limit`, `field_limit`, `status`, `is_super`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, '0c7ef6dad2c34f1495fe09750d5135a7', 'root', 'root', NULL, '704872038@qq.com', '18782988780', '6f5360a894e966cc6c255a41db135a8a', NULL, '', 213, 0, 0, 1, 1, 1450759038, 1501468787, 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- 导出  表 zhan.videos 结构
DROP TABLE IF EXISTS `videos`;
CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `category` varchar(256) DEFAULT NULL,
  `name` varchar(256) NOT NULL COMMENT '标题',
  `picture` varchar(256) DEFAULT NULL COMMENT '主图',
  `detail` text COMMENT '详情',
  `status` tinyint(4) DEFAULT '1' COMMENT '''不显示'', ''显示'', ''推荐''',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='视频表';

-- 正在导出表  zhan.videos 的数据：0 rows
DELETE FROM `videos`;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
