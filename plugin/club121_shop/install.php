<?php
/*******************************************************************
 * 121积分商城——鲁大学生网
 *
 * @Filename install.php $
 *
 * @Author ETY001 http://www.domyself.me $
 *
 * @Date 2012-02-19 02:31:44 $
 *******************************************************************/


if(!defined('IN_JISHIGOU'))
{
    exit('invalid request');
}
$table_prefix = TABLE_PREFIX;
$sql = <<<EOF
DROP TABLE IF EXISTS {$table_prefix}plugin_shop;
DROP TABLE IF EXISTS {$table_prefix}plugin_shop_log;

CREATE TABLE  `{$table_prefix}plugin_shop` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`title` TEXT CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL ,
`name` TEXT CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL ,
`pic` TEXT CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL ,
`credit` INT NOT NULL ,
`description` MEDIUMTEXT CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL ,
`auth` INT( 11 ) NOT NULL DEFAULT  '0' ,
`time` TIMESTAMP( 11 ) NOT NULL ,
`total` INT( 11 ) NOT NULL ,
`e4` INT NOT NULL
) ENGINE = MYISAM CHARACTER SET gbk COLLATE gbk_chinese_ci;

CREATE TABLE `{$table_prefix}plugin_shop_log` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`uid` INT NOT NULL ,
`product_id` INT NOT NULL ,
`auth` INT NOT NULL DEFAULT  '0',
`num` INT NOT NULL
) ENGINE = MYISAM CHARACTER SET gbk COLLATE gbk_chinese_ci;

EOF;
?>