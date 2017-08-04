<?php
/**
 * Admin Widget Register
 *
 * @author  Kazuya Takami
 * @version 2.0.0
 * @since   2.0.0
 * @see     /wp-includes/widgets/class-wp-nav-menu-widget.php
 */

unregister_widget( 'WP_Nav_Menu_Widget' );
register_widget( 'WP_Widget_Extensions_Nav_Menu' );

class WP_Widget_Extensions_Nav_Menu extends WP_Nav_Menu_Widget {

	/**
	 * Widget Form Display.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 * @access  public
	 * @param   array $instance
	 * @return  string Parent::Default return is 'noform'
	 */
	public function form ( $instance ) {
		parent::form( $instance );

		require_once( 'wp-widget-extensions-form-build.php' );
		$form = new WP_Widget_Extensions_Form_Build();

		echo '<hr>';
		echo '<p><strong>[ Plugin: WordPress Default Widget Extension ]</strong></p>';

		/**
		 * Target Element
		 */
		$field_name = 'target';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = "all"; }
		$form->select_target(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ]
		);
	}

	/**
	 * Widget Form Update.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 * @access  public
	 * @param   array $new_instance
	 * @param   array $old_instance
	 * @return  array $instance
	 */
	public function update ( $new_instance, $old_instance ) {
		$instance = parent::update( $new_instance, $old_instance );

		$instance['target'] = sanitize_text_field( $new_instance['target'] );

		return (array) $instance;
	}

	/**
	 * Widget Display.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 * @access  public
	 * @param   array $args
	 * @param   array $instance
	 */
	public function widget ( $args, $instance ) {
		if ( is_user_logged_in() && isset( $instance['target'] ) && $instance['target'] === 'logout' ) {
			return;
		}
		if ( !is_user_logged_in() && isset( $instance['target'] ) && $instance['target'] === 'login' ) {
			return;
		}

		parent::widget( $args, $instance );
	}
}