<?php 
/*
Plugin Name: Linked Pages
Version: auto
Description: Link Additional Pages to albums.
Plugin URI: auto
Author: Mistic
Author URI: http://www.strangeplanet.fr
*/

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

if (mobile_theme())
{
  return;
}

global $prefixeTable;

define('LINKEDPAGES_ID',    basename(dirname(__FILE__)));
define('LINKEDPAGES_PATH' , PHPWG_PLUGINS_PATH . LINKEDPAGES_ID . '/');
define('LINKEDPAGES_TABLE', $prefixeTable . 'linked_pages');
define('LINKEDPAGES_ADMIN', get_root_url() . 'admin.php?page=plugin-' . LINKEDPAGES_ID);


add_event_handler('init', 'linked_pages_init');


function linked_pages_init()
{
  global $conf, $pwg_loaded_plugins;
  
  if (!isset($pwg_loaded_plugins['AdditionalPages']))
  {
    return;
  }
  
  // add event handlers
  if (defined('IN_ADMIN'))
  {
    add_event_handler('tabsheet_before_select', 'linked_pages_tabsheet_before_select', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);
  }
  else
  {
    add_event_handler('loc_end_index', 'linked_pages_loc_end_index', EVENT_HANDLER_PRIORITY_NEUTRAL+20);
  }

  include_once(LINKEDPAGES_PATH . 'include/functions.inc.php');
}
