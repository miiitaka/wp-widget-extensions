<?php
/*
Plugin Name: WordPress Default Widget Extension
Plugin URI: https://github.com/miiitaka/wp-widget-extensions
Description: Plug-ins that extend the standard of the widget function.
Version: 1.5.1
Author: Kazuya Takami
Author URI: http://www.terakoya.work/
License: GPLv2 or later
Text Domain: wp-widget-extentions
Domain Path: /languages
*/
new WP_Widget_Extensions();

/**
 * Basic Class
 *
 * @author  Kazuya Takami
 * @version 1.5.0
 * @since   1.0.0
 */
class WP_Widget_Extensions {

	/**
	 * Variable definition.
	 *
	 * @since 1.0.0
	 */
	private $text_domain = 'wp-widget-extentions';

	/**
	 * Constructor Define.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function __construct () {
		register_activation_hook( __FILE__, array( $this, 'widget_data_init' ) );
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_action( 'widgets_init',   array( $this, 'widget_init' ) );
	}

	/**
	 * Widget Data init.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	public function widget_data_init(){
		$field_name = "widget_meta";
		if ( get_option( $field_name ) ) {
			$widget_array = get_option( $field_name );
			$update_array = array();

			foreach ( $widget_array as $key => $value ) {
				if ( is_array( $value ) ) {
					$value["site_admin"]    = 1;
					$value["site_login"]    = 1;
					$value["entries_rss"]   = 1;
					$value["comments_rss"]  = 1;
					$value["wordpress_org"] = 1;
				}
				$update_array[$key] = $value;
			}
			update_option( $field_name, $update_array );
		}
	}

	/**
	 * i18n.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function plugins_loaded () {
		load_plugin_textdomain( $this->text_domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Widget Register.
	 *
	 * @version 1.4.0
	 * @since   1.0.0
	 */
	public function widget_init () {
		require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-archives.php' );
		require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-categories.php' );
		require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-meta.php' );
		require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-pages.php' );
		require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-tag-cloud.php' );
	}
}