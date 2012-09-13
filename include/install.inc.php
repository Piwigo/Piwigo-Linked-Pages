<?php
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

function linked_pages_install() 
{
  global $prefixeTable;
  
	pwg_query('
CREATE TABLE IF NOT EXISTS `'.$prefixeTable.'linked_pages` (
  `page_id` smallint(5) unsigned NOT NULL,
  `category_id` smallint(5) unsigned NOT NULL,
  `pos` smallint(5) unsigned NOT NULL,
  UNIQUE KEY `UNIQUE`(`page_id`,`category_id`)
) DEFAULT CHARSET=utf8
;');
}

?>