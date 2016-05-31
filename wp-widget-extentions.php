<?php
/*
Plugin Name: WordPress Default Widget Extension
Plugin URI: https://github.com/miiitaka/wp-widget-extensions
Description: Plug-ins that extend the standard of the widget function.
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
	 * Variable definition.
	 *
	 * @since 1.0.0
	 */
	private $text_domain = 'wp-widget-extensions';

	/**
	 * Constructor Define.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function __construct () {
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_action( 'widgets_init',   array( $this, 'widget_init' ) );
	}

	/**
	 * i18n.
	 *
	 * @since   1.0.0
	 */
	public function plugins_loaded () {
		load_plugin_textdomain( $this->text_domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
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
		require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-tag-cloud.php' );
	}
}