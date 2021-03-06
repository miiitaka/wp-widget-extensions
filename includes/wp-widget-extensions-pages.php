<?php
/**
 * Admin Widget Register
 *
 * @author  Kazuya Takami
 * @version 2.0.0
 * @since   1.4.0
 * @see     /wp-includes/widgets/class-wp-widget-pages.php
 */

unregister_widget( 'WP_Widget_Pages' );
register_widget( 'WP_Widget_Extensions_Pages' );

class WP_Widget_Extensions_Pages extends WP_Widget_Pages {

	/**
	 * Variable definition.
	 *
	 * @version 1.4.0
	 * @since   1.4.0
	 */
	private $text_domain = 'wp-widget-extentions';
	private $instance    = array();

	/**
	 * Widget Form Display.
	 *
	 * @version 2.0.0
	 * @since   1.4.0
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
		 * Depth Element
		 */
		$field_name = 'depth';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = "0"; }
		$order_array  = array(
			"0" => __( "all pages",            $this->text_domain ),
			"1" => __( "top-level pages only", $this->text_domain )
		);
		$form->select(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ],
			__( 'Hierarchy of pages:', $this->text_domain ),
			$order_array
		);

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
	 * @since   1.4.0
	 * @access  public
	 * @param   array $new_instance
	 * @param   array $old_instance
	 * @return  array $instance
	 */
	public function update ( $new_instance, $old_instance ) {
		$instance = parent::update( $new_instance, $old_instance );

		$instance['depth']  = sanitize_text_field( $new_instance['depth'] );
		$instance['target'] = sanitize_text_field( $new_instance['target'] );

		return (array) $instance;
	}

	/**
	 * Widget Pages Args
	 *
	 * @version 1.4.0
	 * @since   1.4.0
	 * @access  public
	 * @param   array $args
	 * @return  array $args
	 */
	public function widget_pages_args ( $args ) {
		if ( isset( $this->instance['depth'] ) ) {
			$args['depth'] = (int) $this->instance['depth'];
		}

		return (array) $args;
	}

	/**
	 * Widget Display.
	 *
	 * @version 2.0.0
	 * @since   1.4.0
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

		$this->instance = $instance;

		add_filter( 'widget_pages_args', array( $this, 'widget_pages_args' ) );

		parent::widget( $args, $instance );
	}
}