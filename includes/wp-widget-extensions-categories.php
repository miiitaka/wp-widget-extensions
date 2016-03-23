<?php
/**
 * Admin Widget Register
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 * @see     /wp-includes/widgets/class-wp-widget-categories.php
 */
class WP_Widget_Extensions_Categories extends WP_Widget_Categories {

	/**
	 * Constructor Define.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 */
	public function __construct () {
		$widget_options = array( 'description' => 'Categories Widget Extension' );
		parent::__construct( false, 'Categories Extension', $widget_options );
	}

	/**
	 * Widget Form Display.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 * @access  public
	 * @param   array $instance
	 * @return  string Parent::Default return is 'noform'
	 */
	public function form ( $instance ) {

	}

	/**
	 * Widget Form Update.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 * @access  public
	 * @param   array $new_instance
	 * @param   array $old_instance
	 * @return  array Parent::Settings to save or bool false to cancel saving.
	 */
	public function update ( $new_instance, $old_instance ) {
		return (array) $new_instance;
	}

	/**
	 * Widget Display.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 * @access  public
	 * @param   array $args
	 * @param   array $instance
	 */
	public function widget ( $args, $instance ) {

	}
}