<?php 
/*
Plugin Name: Linked Pages
Version: auto
Description: Link Additional Pages to albums.
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=635
Author: Mistic
Author URI: http://www.strangeplanet.fr
*/

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

global $prefixeTable;

// +-----------------------------------------------------------------------+
// | Define plugin constants                                               |
// +-----------------------------------------------------------------------+
defined('LINKEDPAGES_ID') or define('LINKEDPAGES_ID', basename(dirname(__FILE__)));
define('LINKEDPAGES_PATH' ,   PHPWG_PLUGINS_PATH . LINKEDPAGES_ID . '/');
define('LINKEDPAGES_TABLE',   $prefixeTable . 'linked_pages');
define('LINKEDPAGES_ADMIN',   get_root_url() . 'admin.php?page=plugin-' . LINKEDPAGES_ID);
define('LINKEDPAGES_VERSION', 'auto');


// init the plugin
add_event_handler('init', 'linked_pages_init');


/**
 * plugin initialization
 */
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
  
  if (
    LINKEDPAGES_VERSION == 'auto' or
    $pwg_loaded_plugins[LINKEDPAGES_ID]['version'] == 'auto' or
    version_compare($pwg_loaded_plugins[LINKEDPAGES_ID]['version'], LINKEDPAGES_VERSION, '<')
  )
  {
    include_once(LINKEDPAGES_PATH . 'include/install.inc.php');
    linked_pages_install();
    
    if ( $pwg_loaded_plugins[LINKEDPAGES_ID]['version'] != 'auto' and LINKEDPAGES_VERSION != 'auto')
    {
      $query = '
UPDATE '. PLUGINS_TABLE .'
SET version = "'. LINKEDPAGES_VERSION .'"
WHERE id = "'. LINKEDPAGES_ID .'"';
      pwg_query($query);
      
      $pwg_loaded_plugins[LINKEDPAGES_ID]['version'] = LINKEDPAGES_VERSION;
      
      if (defined('IN_ADMIN'))
      {
        $_SESSION['page_infos'][] = 'Linked Pages updated to version '. LINKEDPAGES_VERSION;
      }
    }
  }
}

?>