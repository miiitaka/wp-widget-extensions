<?php
/**
 * Plugin Uninstall
 *
 * @author  Kazuya Takami
 * @version 2.0.0
 * @since   1.1.0
 */

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
new WP_Widget_Extensions_Uninstall();

class WP_Widget_Extensions_Uninstall {

	/**
	 * Variable definition.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	private $text_domain = 'wp-widget-extentions';

	/**
	 * Constructor Define.
	 *
	 * @version 2.0.0
	 * @since   1.1.0
	 */
	public function __construct () {
		delete_option( $this->text_domain );
		$this->delete_widget_archives( "widget_archives" );
		$this->delete_widget_calendar( "widget_calendar" );
		$this->delete_widget_categories( "widget_categories" );
		$this->delete_widget_meta( "widget_meta" );
		$this->delete_widget_nav_menu( "widget_nav_menu" );
		$this->delete_widget_pages( "widget_pages" );
		$this->delete_widget_recent_comments( "widget_recent-comments" );
		$this->delete_widget_recent_posts( "widget_recent-posts" );
		$this->delete_widget_rss( "widget_rss" );
		$this->delete_widget_search( "widget_search" );
		$this->delete_widget_text( "widget_text" );
		$this->delete_widget_tag_cloud( "widget_tag_cloud" );
	}

	/**
	 * Delete Widget Archives Option.
	 *
	 * @version 2.0.0
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
						$value["limit"],
						$value["target"]
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
	 * @version 2.0.0
	 * @since   1.6.0
	 * @param   string $option
	 */
	private function delete_widget_calendar ( $option ) {
		if ( get_option( $option ) ) {
			$widget_array = get_option( $option );
			$update_array = array();

			foreach ( $widget_array as $key => $value ) {
				if ( is_array( $value ) ) {
					unset(
						$value["sat-background-color"],
						$value["sat-font-color"],
						$value["sun-background-color"],
						$value["sun-font-color"],
						$value["target"]
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
	 * @version 2.0.0
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
						$value["exclude"],
						$value["target"]
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
	 * @version 2.0.0
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
						$value["wordpress_org"],
						$value["target"]
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
	 * Delete Widget Nav Menu Option.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 * @param   string $option
	 */
	private function delete_widget_nav_menu ( $option ) {
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
						$value["target"]
					);
				}
				$update_array[$key] = $value;
			}
			update_option( $option, $update_array );
		}
	}

	/**
	 * Delete Widget Pages Option.
	 *
	 * @version 2.0.0
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
						$value["depth"],
						$value["target"]
					);
				}
				$update_array[$key] = $value;
			}
			update_option( $option, $update_array );
		}
	}

	/**
	 * Delete Widget Recent Comments Option.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 * @param   string $option
	 */
	private function delete_widget_recent_comments ( $option ) {
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
						$value["target"]
					);
				}
				$update_array[$key] = $value;
			}
			update_option( $option, $update_array );
		}
	}

	/**
	 * Delete Widget Recent Posts Option.
	 *
	 * @version 1.7.0
	 * @since   1.7.0
	 * @param   string $option
	 */
	private function delete_widget_recent_posts ( $option ) {
		if ( get_option( $option ) ) {
			$widget_array = get_option( $option );
			$update_array = array();
			// custom post
			$args = array(
				'public'   => true,
				'_builtin' => false
			);
			$post_types = get_post_types( $args, 'objects' );

			foreach ( $widget_array as $key => $value ) {
				if ( is_array( $value ) ) {
					foreach ( $post_types as $post_type ) {
						unset( $value[$post_type->name] );
					}
					unset( $value['post'] );
				}
				$update_array[$key] = $value;
			}
			update_option( $option, $update_array );
		}
	}

	/**
	 * Delete Widget RSS Option.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 * @param   string $option
	 */
	private function delete_widget_rss ( $option ) {
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
						$value["target"]
					);
				}
				$update_array[$key] = $value;
			}
			update_option( $option, $update_array );
		}
	}

	/**
	 * Delete Widget Search Option.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 * @param   string $option
	 */
	private function delete_widget_search ( $option ) {
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
						$value["target"]
					);
				}
				$update_array[$key] = $value;
			}
			update_option( $option, $update_array );
		}
	}

	/**
	 * Delete Widget Text Option.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 * @param   string $option
	 */
	private function delete_widget_text ( $option ) {
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
						$value["target"]
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
						$value['smallest'],
						$value['largest'],
						$value['unit'],
						$value['number'],
						$value['format'],
						$value['separator'],
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