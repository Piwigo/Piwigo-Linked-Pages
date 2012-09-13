<?php
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

include_once(PHPWG_PLUGINS_PATH . 'linked_pages/include/install.inc.php');


function plugin_install() 
{
  linked_pages_install();
  define('linked_pages_installed', true);
}


function plugin_activate()
{
  if (!defined('linked_pages_installed'))
  {
    linked_pages_install();
  }
}


function plugin_uninstall() 
{
  global $prefixeTable;
  
  pwg_query('DROP TABLE `'.$prefixeTable.'linked_pages`;');
}

?>