<?php
/**
 * Admin Widget Register
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 * @see     /wp-includes/widgets/class-wp-widget-archives.php
 */

unregister_widget( 'WP_Widget_Archives' );
register_widget( 'WP_Widget_Extensions_Archives' );

class WP_Widget_Extensions_Archives extends WP_Widget_Archives {

	/**
	 * Variable definition.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private $text_domain = 'wp-widget-extensions';
	private $instance    = array();

	/**
	 * Widget Form Display.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $instance
	 * @return  string Parent::Default return is 'noform'
	 */
	public function form ( $instance ) {
		parent::form( $instance );
		
		echo '<hr>';
	}

	/**
	 * Widget Form Update.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $new_instance
	 * @param   array $old_instance
	 * @return  array $instance
	 */
	public function update ( $new_instance, $old_instance ) {
		$instance = parent::update( $new_instance, $old_instance );

		$instance['type']  = isset( $new_instance['type'] )  ? $new_instance['type']  : "";
		$instance['order'] = isset( $new_instance['order'] ) ? $new_instance['order'] : "";
		$instance['limit'] = isset( $new_instance['limit'] ) ? $new_instance['limit'] : "";

		return (array) $instance;
	}

	/**
	 * Widget Archives Args
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $archive_args
	 * @return  array $archive_args
	 */
	public function widget_archives_args ( $archive_args ) {
		$archive_args['type'] = 'monthly';
		//$archive_args['type'] = 'yearly';
		//$archive_args['type'] = 'daily';
		//$archive_args['type'] = 'weekly';
		$archive_args['order'] = 'DESC';
		//$archive_args['order'] = 'ASC';
		$archive_args['limit'] = 5;

		return (array) $archive_args;
	}

	/**
	 * Widget Display.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $args
	 * @param   array $instance
	 */
	public function widget ( $args, $instance ) {
		$this->instance = $instance;

		$d = ! empty( $instance['dropdown'] ) ? '1' : '0';
		if ( $d ) {
			add_filter( 'widget_archives_dropdown_args', array( $this, 'widget_archives_args' ) );
		} else {
			add_filter( 'widget_archives_args', array( $this, 'widget_archives_args' ) );
		}
		parent::widget( $args, $instance );
	}
}