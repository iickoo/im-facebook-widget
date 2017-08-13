<?php
/**
 * @package IM_Facebook_Widget
 * @version 1.1.0
 */
/*
Plugin Name: IM Facebook Widget
Plugin URI: http://imwebdeveloper.com/
Description: Widget for Facebook Page like box
Version: 1.1.0
Author: Igor Mojto
Author URI: http://imwebdeveloper.com/
License: GPLv2 or later
Domain Path: /languages/
Text Domain: imfacebookwidget
*/

if ( !function_exists( 'add_action' ) ) {
	die( 'The END!' );
}

define( 'IMFBW_PLUGIN_NAME', 'imfacebookwidget');
define( 'IMFBW_PLUGIN_VERSION', '1.1.0');
define( 'IMFBW_PLUGIN_DIR', trailingslashit( plugin_basename( dirname( __FILE__ ) ) ) );
define( 'IMFBW_PLUGIN_DIR_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'IMFBW_PLUGIN_DIR_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );


//notices
//potreba reaktivacia pluginu, pre nacitanie Facebook available language pri aktivacii pluginu.
function update_1_0_0_to_high() {
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php _e( 'Please deactivate and activate plugin IM Facebook Widget (for loading Facebook available language)!', IMFBW_PLUGIN_NAME ); ?></p>
    </div>
    <?php
}

//show notice if don't set variable for Facebook available language
if( get_transient( 'imfbw_availableLanguage' ) === false ){

	add_action( 'admin_notices', 'update_1_0_0_to_high' );
}


//activate plugin
register_activation_hook( __FILE__, 'imfbw_plugin_activation' );
function imfbw_plugin_activation(){

	//update plugin version
	$version = get_option( 'imfbw-version' );

	if( $version === false ) {

      add_option( 'imfbw-version', IMFBW_PLUGIN_VERSION );
  } else {

      update_option( 'imfbw-version', IMFBW_PLUGIN_VERSION );
  }


	//loading Facebook available language
	$xmlAvailablelanguageURL = 'https://www.facebook.com/translations/FacebookLocales.xml';
	$getRemoteFile = wp_remote_get( $xmlAvailablelanguageURL );

	if($getRemoteFile['response']['code'] == 200){
		$data = array(
			'status'  => true,
			'body'    => $getRemoteFile['body']
		);
	} else {
		$data = array(
			'status'  => false
		);
	}

	set_transient( 'imfbw_availableLanguage', $data, 0 );

}

//deactivate plugin
register_deactivation_hook( __FILE__, 'imfbw_plugin_deactivation' );
function imfbw_plugin_deactivation(){

	delete_transient( 'imfbw_availableLanguage' );
}


//load languages
add_action( 'plugins_loaded', 'imfbw_load_textdomain' );
function imfbw_load_textdomain(){
    load_plugin_textdomain( IMFBW_PLUGIN_NAME, null, IMFBW_PLUGIN_DIR . 'languages' );
}


//register styles and scripts
add_action( 'wp_enqueue_scripts', 'imfbw_styles_and_scripts' );
function imfbw_styles_and_scripts() {
	wp_register_script( 'imfbw_plb', IMFBW_PLUGIN_DIR_URL . 'scripts/imfbw_plb.js', array(), '1.1.0', true );
}


//pagelike box widget class
require_once( IMFBW_PLUGIN_DIR_PATH . 'includes/widgets/pagelikebox.php' );

//Register Widgets Class
add_action( 'widgets_init', 'imfbw_register_widget_class' );
function imfbw_register_widget_class() {
  register_widget( 'IMFBW_Widget_Facebook_Pagelikebox' );
}
