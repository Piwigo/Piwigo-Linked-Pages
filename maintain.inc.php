<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

class linked_pages_maintain extends PluginMaintain
{
  private $installed = false;

  function install($plugin_version, &$errors=array())
  {
    global $prefixeTable;

    pwg_query('
CREATE TABLE IF NOT EXISTS `'.$prefixeTable.'linked_pages` (
  `page_id` smallint(5) unsigned NOT NULL,
  `category_id` smallint(5) unsigned NOT NULL,
  `pos` smallint(5) unsigned NOT NULL,
  UNIQUE KEY `UNIQUE`(`page_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
;');

    $this->installed = true;
  }

  function activate($plugin_version, &$errors=array())
  {
    if (!$this->installed)
    {
      $this->install($plugin_version, $errors);
    }
  }

  function deactivate()
  {
  }

  function uninstall()
  {
    global $prefixeTable;
    
    pwg_query('DROP TABLE `'.$prefixeTable.'linked_pages`;');
  }
}
