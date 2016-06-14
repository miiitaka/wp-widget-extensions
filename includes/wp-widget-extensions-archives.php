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

		require_once( 'wp-widget-extensions-form-build.php' );
		$form = new WP_Widget_Extensions_Form_Build();

		echo '<hr>';

		/**
		 * Type Element
		 */
		$field_name = 'type';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = "monthly"; }
		$type_array = array(
			"daily"   => __( "Daily",   $this->text_domain ),
			"weekly"  => __( "Weekly",  $this->text_domain ),
			"monthly" => __( "Monthly", $this->text_domain ),
			"yearly"  => __( "Yearly",  $this->text_domain )
		);
		$form->select(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ],
			__( 'Type:', $this->text_domain ),
			$type_array
		);

		/**
		 * Order Element
		 */
		$field_name = 'order';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = "DESC"; }
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

		/**
		 * Limit Element
		 */
		$field_name = 'limit';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = 0; }
		$form->number( $this->get_field_id( $field_name ), $this->get_field_name( $field_name ), $instance[ $field_name ], __( 'Number of archive to show:', $this->text_domain ) );
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

		$instance['type']  = sanitize_text_field( $new_instance['type'] );
		$instance['order'] = sanitize_text_field( $new_instance['order'] );
		$instance['limit'] = (int) $new_instance['limit'];

		return (array) $instance;
	}

	/**
	 * Widget Archives Args
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $args
	 * @return  array $args
	 */
	public function widget_archives_args ( $args ) {
		if ( isset( $this->instance['type'] ) ) {
			$args['type'] = $this->instance['type'];
		}
		if ( isset( $this->instance['order'] ) ) {
			$args['order'] = $this->instance['order'];
		}
		if ( isset( $this->instance['limit'] ) ) {
			if ( $this->instance['limit'] == 0 ) {
				$args['limit'] = "";
			} else {
				$args['limit'] = $this->instance['limit'];
			}
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

		$d = ! empty( $instance['dropdown'] ) ? '1' : '0';
		if ( $d ) {
			add_filter( 'widget_archives_dropdown_args', array( $this, 'widget_archives_args' ) );
		} else {
			add_filter( 'widget_archives_args', array( $this, 'widget_archives_args' ) );
		}
		parent::widget( $args, $instance );
	}
}