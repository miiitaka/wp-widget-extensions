<?php
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
new WP_Widget_Extensions_Uninstall();

/**
 * Plugin Uninstall
 *
 * @author  Kazuya Takami
 * @version 1.4.0
 * @since   1.1.0
 */
class WP_Widget_Extensions_Uninstall {

	/**
	 * Constructor Define.
	 *
	 * @version 1.4.0
	 * @since   1.1.0
	 */
	public function __construct () {
		$this->delete_widget_archives( "widget_archives" );
		$this->delete_widget_categories( "widget_categories" );
		$this->delete_widget_meta( "widget_meta" );
		$this->delete_widget_pages( "widget_pages" );
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
	 * @version 1.3.0
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
						$value["orderby"],
						$value["exclude"]
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
	 * @version 1.2.0
	 * @since   1.1.0
	 * @param   string $option
	 */
	private function delete_widget_meta ( $option ) {
		if ( get_option( $option ) ) {
			$widget_array = get_option( $option );
			$update_array = array();

			/* Custom Posts */
			$post_args = array(
				'public'   => true,
				'_builtin' => false
			);
			$post_types = get_post_types( $post_args, 'objects' );

			foreach ( $widget_array as $key => $value ) {
				if ( is_array( $value ) ) {
					unset(
						$value["site_admin"],
						$value["site_login"],
						$value["entries_rss"],
						$value["comments_rss"],
						$value["wordpress_org"]
					);
					foreach ( $post_types as $post_type ) {
						unset( $value[ $post_type->name ] );
					}
				}
				$update_array[$key] = $value;
			}
			update_option( $option, $update_array );
		}
	}

	/**
	 * Delete Widget Pages Option.
	 *
	 * @version 1.4.0
	 * @since   1.4.0
	 * @param   string $option
	 */
	private function delete_widget_pages ( $option ) {
		if ( get_option( $option ) ) {
			$widget_array = get_option( $option );
			$update_array = array();

			foreach ( $widget_array as $key => $value ) {
				if ( is_array( $value ) ) {
					unset(
						$value["depth"]
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