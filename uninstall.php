<?php
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
new WP_Widget_Extensions_Uninstall();

/**
 * Plugin Uninstall
 *
 * @author  Kazuya Takami
 * @version 1.1.0
 * @since   1.1.0
 */
class WP_Widget_Extensions_Uninstall {

	/**
	 * Constructor Define.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	public function __construct () {
		$this->delete_widget_meta( "widget_meta" );
	}

	/**
	 * Delete Widget Meta Option.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 * @param   string $option
	 */
	private function delete_widget_meta ( $option ) {
		$widget_array = get_option( $option );
		$update_array = array();

		foreach ( $widget_array as $key => $value ) {
			if ( is_array( $value ) ) {
				unset(
					$value["site_admin"],
					$value["site_login"],
					$value["entries_rss"],
					$value["comments_rss"],
					$value["wordpress_org"]
				);
			}
			$update_array[$key] = $value;
		}
		update_option( $option, $update_array );
	}
}