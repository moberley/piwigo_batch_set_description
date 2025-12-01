<?php
/*
Plugin Name: Batch Set Description
Version: 1.0
Description: Set description in the batch manager global mode.
Plugin URI: https://piwigo.org/
Author: moberley
Author URI: https://github.com/moberley/
Has Settings: false
 */

if (!defined('PHPWG_ROOT_PATH')) { die('Hacking attempt!'); }

add_event_handler('init', 'batch_set_description_plugin_init');
function batch_set_description_plugin_init()
{
  load_language('plugin.lang', dirname(__FILE__).'/');
}

/*
 * Add description editor to the batch manager global mode.
 */
add_event_handler('loc_end_element_set_global', 'batch_set_description_global');
add_event_handler('element_set_global_action', 'batch_set_description_global_save', 50, 2); // save action handler

function batch_set_description_global()
{
  global $template;

  $template->set_filename('BATCH_SET_DESCRIPTION_GLOBAL', dirname(__FILE__).'/batch_plugin_global.tpl');
  
  // append to the choose action dropdown
  $template->append('element_set_global_plugins_actions', array(
    'ID' => 'description',
    'NAME' => l10n('Set description'),
    'CONTENT' => $template->parse('BATCH_SET_DESCRIPTION_GLOBAL', true)
  ));
}

/*
 * Process the save changes action.
 */
function batch_set_description_global_save($action, $collection)
{
  error_log(print_r($action, true));

  if ($action == 'description') // check for correct action ID
  {
    if (isset($_POST['remove_description']))
    {
      $_POST['description'] = null;
    }

    $datas = array();
    foreach ($collection as $image_id)
    {
      $datas[] = array(
        'id' => $image_id,
        'comment' => $_POST['description']
        );
    }

    mass_updates(
      IMAGES_TABLE,
      array('primary' => array('id'), 'update' => array('comment')),
      $datas
      );

    pwg_activity('photo', $collection, 'edit', array('action'=>'description'));
  }
}

?>
