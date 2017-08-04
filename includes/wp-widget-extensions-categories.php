<?php
/**
 * Admin Widget Register
 *
 * @author  Kazuya Takami
 * @version 2.0.0
 * @since   1.0.0
 * @see     /wp-includes/widgets/class-wp-widget-categories.php
 */

unregister_widget( 'WP_Widget_Categories' );
register_widget( 'WP_Widget_Extensions_Categories' );

class WP_Widget_Extensions_Categories extends WP_Widget_Categories {

	/**
	 * Variable definition.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private $text_domain = 'wp-widget-extentions';
	private $instance    = array();

	/**
	 * Widget Form Display.
	 *
	 * @version 1.5.1
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
		echo '<p><strong>[ Plugin: WordPress Default Widget Extension ]</strong></p>';

		/**
		 * OrderBy Element
		 */
		$field_name = 'orderby';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = "name"; }
		$sort_array  = array(
			"name"  => __( "Name order",        $this->text_domain ),
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

		/**
		 * Exclude Category ids
		 */
		$field_name = 'exclude';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = ""; }
		$form->text(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ],
			__( 'Exclude:'                          , $this->text_domain ),
			__( 'e.g. 1,2,3'                        , $this->text_domain ),
			__( 'Category IDs, separated by commas.', $this->text_domain )
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
		$instance['exclude'] = sanitize_text_field( $new_instance['exclude'] );
		$instance['target']  = sanitize_text_field( $new_instance['target'] );

		return (array) $instance;
	}

	/**
	 * Widget Categories Args
	 *
	 * @version 1.3.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $args
	 * @return  array $args
	 */
	public function widget_categories_args ( $args ) {
		if ( isset( $this->instance['orderby'] ) ) {
			$args['orderby'] = $this->instance['orderby'];
		}
		if ( isset( $this->instance['order'] ) ) {
			$args['order'] = $this->instance['order'];
		}
		if ( isset( $this->instance['exclude'] ) ) {
			$args['exclude'] = $this->instance['exclude'];
		}

		return (array) $args;
	}

	/**
	 * Widget Display.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
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

		$d = ! empty( $instance['dropdown'] ) ? '1' : '0';
		if ( $d ) {
			add_filter( 'widget_categories_dropdown_args', array( $this, 'widget_categories_args' ) );
		} else {
			add_filter( 'widget_categories_args', array( $this, 'widget_categories_args' ) );
		}
		parent::widget( $args, $instance );
	}
}