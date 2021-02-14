<?php
/*
Plugin Name: WordPress Default Widget Extension
Plugin URI: https://github.com/miiitaka/wp-widget-extensions
Description: Plug-ins that extend the standard of the widget function.
Version: 2.1.3
Author: Kazuya Takami
Author URI: https://www.terakoya.work/
License: GPLv2 or later
Text Domain: wp-widget-extentions
Domain Path: /languages
*/
new WP_Widget_Extensions();

/**
 * Basic Class
 *
 * @author  Kazuya Takami
 * @version 2.0.0
 * @since   1.0.0
 */
class WP_Widget_Extensions {

	/**
	 * Variable definition.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private $text_domain = 'wp-widget-extentions';

	/**
	 * Constructor Define.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	public function __construct () {
		register_activation_hook( __FILE__, array( $this, 'widget_data_init' ) );
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_action( 'widgets_init',   array( $this, 'widget_init' ) );

		if ( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}
	}

	/**
	 * Widget Data init.
	 *
	 * @version 2.0.0
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

		if ( !get_option( $this->text_domain ) ) {
			$widget_type = array(
				"widget_archives"        => 1,
				"widget_calendar"        => 1,
				"widget_categories"      => 1,
				"widget_meta"            => 1,
				"widget_nav_menu"        => 1,
				"widget_pages"           => 1,
				"widget_recent-comments" => 1,
				"widget_recent-posts"    => 1,
				"widget_rss"             => 1,
				"widget_search"          => 1,
				"widget_tag_cloud"       => 1,
				"widget_text"            => 1
			);
			update_option( $this->text_domain, $widget_type );
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
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	public function widget_init () {
		$args = get_option( $this->text_domain );

		if ( is_array( $args ) && count( $args ) > 0 ) {
			if ( isset( $args['widget_archives'] ) && $args['widget_archives'] ) {
				require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-archives.php' );
			}
			if ( isset( $args['widget_calendar'] ) && $args['widget_calendar'] ) {
				require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-calendar.php' );
			}
			if ( isset( $args['widget_categories'] ) && $args['widget_categories'] ) {
				require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-categories.php' );
			}
			if ( isset( $args['widget_meta'] ) && $args['widget_meta'] ) {
				require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-meta.php' );
			}
			if ( isset( $args['widget_nav_menu'] ) && $args['widget_nav_menu'] ) {
				require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-nav-menu.php' );
			}
			if ( isset( $args['widget_pages'] ) && $args['widget_pages'] ) {
				require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-pages.php' );
			}
			if ( isset( $args['widget_recent-comments'] ) && $args['widget_recent-comments'] ) {
				require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-recent-comments.php' );
			}
			if ( isset( $args['widget_recent-posts'] ) && $args['widget_recent-posts'] ) {
				require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-recent-posts.php' );
			}
			if ( isset( $args['widget_rss'] ) && $args['widget_rss'] ) {
				require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-rss.php' );
			}
			if ( isset( $args['widget_search'] ) && $args['widget_search'] ) {
				require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-search.php' );
			}
			if ( isset( $args['widget_tag_cloud'] ) && $args['widget_tag_cloud'] ) {
				require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-tag-cloud.php' );
			}
			if ( isset( $args['widget_text'] ) && $args['widget_text'] ) {
				require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-widget-extensions-text.php' );
			}
		}
	}

	/**
	 * Add Menu to the Admin Screen.
	 *
	 * @version 2.0.4
	 * @since   2.0.0
	 */
	public function admin_menu () {
		add_menu_page(
			esc_html__( 'Widget Extension', $this->text_domain ),
			esc_html__( 'Widget Extension', $this->text_domain ),
			'manage_options',
			plugin_basename( __FILE__ ),
			array( $this, 'list_page_render' )
		);
	}

	/**
	 * LIST Page Template Require.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	public function list_page_render () {
		require_once( plugin_dir_path( __FILE__ ) . 'includes/admin/wp-widget-extension-admin-list.php' );
		new WP_Widget_Extension_List( $this->text_domain );
	}
}