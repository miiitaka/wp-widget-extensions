<?php
/**
 * Admin Widget Register
 *
 * @author  Kazuya Takami
 * @version 1.5.1
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
		 * Smallest Font Size Element
		 */
		$field_name = 'smallest';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = 8; }
		$form->number(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ],
			__( 'Smallest Font Size:', $this->text_domain )
		);

		/**
		 * Largest Font Size Element
		 */
		$field_name = 'largest';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = 22; }
		$form->number(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ],
			__( 'Largest Font Size:', $this->text_domain )
		);

		/**
		 * Font Unit Element
		 */
		$field_name = 'unit';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = "pt"; }
		$sort_array  = array(
			"em"   => "em",
			"ex"   => "ex",
			"%"    => "%",
			"px"   => "px",
			"cm"   => "cm",
			"mm"   => "mm",
			"in"   => "ic",
			"pt"   => "pt",
			"pc"   => "pc",
			"ch"   => "ch",
			"rem"  => "rem",
			"vh"   => "vh",
			"vw"   => "vw",
			"vmin" => "vmin",
			"vmax" => "vmax"
		);
		$form->select(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ],
			__( 'Font unit:', $this->text_domain ),
			$sort_array
		);

		/**
		 * Number of tags to show Element
		 */
		$field_name = 'number';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = 45; }
		$form->number(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ],
			__( 'Number of tags to show:', $this->text_domain )
		);

		/**
		 * Display Format Element
		 */
		$field_name = 'format';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = "flat"; }
		$sort_array  = array(
			"flat" => __( "Flat Display", $this->text_domain ),
			"list" => __( "List Display", $this->text_domain )
		);
		$form->select(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ],
			__( 'Display Format:', $this->text_domain ),
			$sort_array
		);

		/**
		 * Text Separator Element
		 */
		$field_name = 'separator';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = ""; }
		$form->text(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ],
			__( 'Text Separator(Display format is Flat only):' , $this->text_domain ),
			"",
			__( 'Allow only HTML tags for br, p, and span.' , $this->text_domain )
		);

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
			"DESC" => __( "Descending order", $this->text_domain ),
			"RAND" => __( "Random order",     $this->text_domain )
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
	 * @version 1.5.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $new_instance
	 * @param   array $old_instance
	 * @return  array $instance
	 */
	public function update ( $new_instance, $old_instance ) {
		$instance = parent::update( $new_instance, $old_instance );

		$instance['smallest']  = (int) $new_instance['smallest'];
		$instance['largest']   = (int) $new_instance['largest'];
		$instance['unit']      = sanitize_text_field( $new_instance['unit'] );
		$instance['number']    = (int) $new_instance['number'];
		$instance['format']    = sanitize_text_field( $new_instance['format'] );
		$instance['separator'] = strip_tags( $new_instance['separator'], '<br><p><span>' );
		$instance['orderby']   = sanitize_text_field( $new_instance['orderby'] );
		$instance['order']     = sanitize_text_field( $new_instance['order'] );

		return (array) $instance;
	}

	/**
	 * Widget Tag Cloud Args
	 *
	 * @version 1.5.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $args
	 * @return  array $args
	 */
	public function widget_tag_cloud_args ( $args ) {
		if ( isset( $this->instance['smallest'] ) ) {
			$args['smallest'] = $this->instance['smallest'];
		}
		if ( isset( $this->instance['largest'] ) ) {
			$args['largest'] = $this->instance['largest'];
		}
		if ( isset( $this->instance['unit'] ) ) {
			$args['unit'] = $this->instance['unit'];
		}
		if ( isset( $this->instance['number'] ) ) {
			$args['number'] = $this->instance['number'];
		}
		if ( isset( $this->instance['format'] ) ) {
			$args['format'] = $this->instance['format'];
		}
		if ( isset( $this->instance['separator'] ) ) {
			$args['separator'] = $this->instance['separator'];
		}
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