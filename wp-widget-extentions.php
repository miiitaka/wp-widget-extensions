<?php
/*
Plugin Name: WordPress Default Widget Extension
Plugin URI: https://github.com/miiitaka/wp-widget-extensions
Description: Plug-in Posted Display Widget & ShortCode Add. You can also save and display your browsing history to Cookie.
Version: 1.0.0
Author: Kazuya Takami
Author URI: http://programp.com/
License: GPLv2 or later
Text Domain: wp-widget-extensions
Domain Path: /languages
*/
new WP_Widget_Extensions();

/**
 * Basic Class
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 */
class WP_Widget_Extensions {

	/**
	 * Constructor Define.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function __construct () {
		add_action( 'widgets_init',   array( $this, 'widget_init' ) );
	}

	/**
	 * Widget Register.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function widget_init () {
		require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-archives.php' );
		require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-categories.php' );
	}
}