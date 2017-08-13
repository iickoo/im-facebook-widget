<?php
/**
 * Plugin Name: IM Facebook Widget
 * Plugin URI: http://imwebdeveloper.com/
 * Description: Widget for Facebook Page like box
 * Version: 1.2.0
 * Author: Igor Mojto
 * Author URI: http://imwebdeveloper.com/
 * License: GPLv2 or later
 * Domain Path: /languages/
 * Text Domain: imfacebookwidget
 *
 * @package IM_Facebook_Widget
 * @version 1.2.0
 */

if (!function_exists('add_action')){
	die('The END!');
}

define('IMFBW_PLUGIN_NAME', 'imfacebookwidget');
define('IMFBW_PLUGIN_VERSION', '1.2.0');
define('IMFBW_PLUGIN_DIR', trailingslashit( plugin_basename( dirname(__FILE__) ) ));
define('IMFBW_PLUGIN_DIR_PATH', trailingslashit( plugin_dir_path(__FILE__) ));
define('IMFBW_PLUGIN_DIR_URL', trailingslashit( plugin_dir_url(__FILE__) ));

/**
 * Upozornenie pre potrebu reaktivacie pluginu koli nacitaniu dostupnych jazykov
 */
function update_1_0_0_to_high() {
  ?>
  <div class="notice notice-warning is-dismissible">
    <p><?php _e('Please deactivate and activate plugin IM Facebook Widget (for loading Facebook available language)!', IMFBW_PLUGIN_NAME); ?></p>
  </div>
  <?php
}

/**
 * Show notice if don't set variable for Facebook available language
 */
if (get_transient('imfbw_availableLanguage') === false) {
	add_action('admin_notices', 'update_1_0_0_to_high');
}

/**
 * Activate plugin
 */
function imfbw_plugin_activation() {

	$version = get_option('imfbw-version');

	if ($version === false) {
      add_option('imfbw-version', IMFBW_PLUGIN_VERSION);
  } else {
      update_option('imfbw-version', IMFBW_PLUGIN_VERSION);
  }

	// Loading Facebook available language
	$xmlAvailablelanguageURL = 'https://www.facebook.com/translations/FacebookLocales.xml';
	$getRemoteFile = wp_remote_get($xmlAvailablelanguageURL);

	if ($getRemoteFile['response']['code'] == 200){
		$data = array(
			'status' => true,
			'body' => $getRemoteFile['body']
		);
	} else {
		$data = array(
			'status' => false
		);
	}

	set_transient('imfbw_availableLanguage', $data, 0);

}
register_activation_hook(__FILE__, 'imfbw_plugin_activation');

/**
 * Deactivate plugin
 */
function imfbw_plugin_deactivation() {
	delete_transient('imfbw_availableLanguage');
}
register_deactivation_hook(__FILE__, 'imfbw_plugin_deactivation');

/**
 * Load languages
 */
function imfbw_load_textdomain(){
  load_plugin_textdomain(IMFBW_PLUGIN_NAME, null, IMFBW_PLUGIN_DIR . 'languages');
}
add_action('plugins_loaded', 'imfbw_load_textdomain');

/**
 * Register styles and scripts
 */
function imfbw_styles_and_scripts() {
	wp_register_script('imfbw', IMFBW_PLUGIN_DIR_URL . 'scripts/imfbw.js', array(), IMFBW_PLUGIN_VERSION, true);
}
add_action('wp_enqueue_scripts', 'imfbw_styles_and_scripts');

// Pagelike box widget class
require_once(IMFBW_PLUGIN_DIR_PATH . 'includes/widgets/pagelikebox.php');

/**
 * Register Widgets Class
 */
function imfbw_register_widget_class() {
  register_widget('IMFBW_Widget_Facebook_Pagelikebox');
}
add_action('widgets_init', 'imfbw_register_widget_class');
