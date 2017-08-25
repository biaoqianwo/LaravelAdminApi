ALTER TABLE `product_attrs`
	CHANGE COLUMN `description` `intro` VARCHAR(256) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci' AFTER `name`;
ALTER TABLE `product_params`
	CHANGE COLUMN `description` `intro` VARCHAR(256) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci' AFTER `name`;