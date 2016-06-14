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
		$this->delete_widget_archives( "widget_archives" );
		$this->delete_widget_categories( "widget_categories" );
		$this->delete_widget_meta( "widget_meta" );
		$this->delete_widget_tag_cloud( "widget_tag_cloud" );
	}

	/**
	 * Delete Widget Archives Option.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 * @param   string $option
	 */
	private function delete_widget_archives ( $option ) {
		if ( get_option( $option ) ) {
			$widget_array = get_option( $option );
			$update_array = array();

			foreach ( $widget_array as $key => $value ) {
				if ( is_array( $value ) ) {
					unset(
						$value["type"],
						$value["order"],
						$value["limit"]
					);
				}
				$update_array[$key] = $value;
			}
			update_option( $option, $update_array );
		}
	}

	/**
	 * Delete Widget Categories Option.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 * @param   string $option
	 */
	private function delete_widget_categories ( $option ) {
		if ( get_option( $option ) ) {
			$widget_array = get_option( $option );
			$update_array = array();

			foreach ( $widget_array as $key => $value ) {
				if ( is_array( $value ) ) {
					unset(
						$value["order"],
						$value["orderby"]
					);
				}
				$update_array[$key] = $value;
			}
			update_option( $option, $update_array );
		}
	}

	/**
	 * Delete Widget Meta Option.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 * @param   string $option
	 */
	private function delete_widget_meta ( $option ) {
		if ( get_option( $option ) ) {
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

	/**
	 * Delete Widget Tag Cloud Option.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 * @param   string $option
	 */
	private function delete_widget_tag_cloud ( $option ) {
		if ( get_option( $option ) ) {
			$widget_array = get_option( $option );
			$update_array = array();

			foreach ( $widget_array as $key => $value ) {
				if ( is_array( $value ) ) {
					unset(
						$value["order"],
						$value["orderby"]
					);
				}
				$update_array[$key] = $value;
			}
			update_option( $option, $update_array );
		}
	}
}