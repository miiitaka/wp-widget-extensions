<?php
/**
 * Admin Widget Register
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 * @see     /wp-includes/widgets/class-wp-widget-tag-cloud.php
 */

unregister_widget( 'WP_Widget_Tag_Cloud' );
register_widget( 'WP_Widget_Extensions_Tag_Cloud' );

class WP_Widget_Extensions_Tag_Cloud extends WP_Widget_Tag_Cloud {

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

		require_once( 'wp-widget-extensions-form-build.php' );
		$form = new WP_Widget_Extensions_Form_Build();

		echo '<hr>';

		/**
		 * OrderBy Element
		 */
		$field_name = 'orderby';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = "name"; }
		$sort_array  = array(
			"name"  => __( "Name order",  $this->text_domain ),
			"count" => __( "Posts Count order", $this->text_domain )
		);
		$form->select(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ],
			__( 'Sort by:', $this->text_domain ),
			$sort_array
		);

		/**
		 * Order Element
		 */
		$field_name = 'order';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = "ASC"; }
		$order_array  = array(
			"ASC"  => __( "Ascending order",  $this->text_domain ),
			"DESC" => __( "Descending order", $this->text_domain )
		);
		$form->select(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ],
			__( 'Order by:', $this->text_domain ),
			$order_array
		);
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

		$instance['orderby'] = sanitize_text_field( $new_instance['orderby'] );
		$instance['order']   = sanitize_text_field( $new_instance['order'] );

		return (array) $instance;
	}

	/**
	 * Widget Tag Cloud Args
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $args
	 * @return  array $args
	 */
	public function widget_tag_cloud_args ( $args ) {
		if ( isset( $this->instance['orderby'] ) ) {
			$args['orderby'] = $this->instance['orderby'];
		}
		if ( isset( $this->instance['order'] ) ) {
			$args['order'] = $this->instance['order'];
		}

		return (array) $args;
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

		add_filter( 'widget_tag_cloud_args', array( $this, 'widget_tag_cloud_args' ) );

		parent::widget( $args, $instance );
	}
}