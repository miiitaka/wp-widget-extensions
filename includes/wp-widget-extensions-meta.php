<?php
/**
 * Admin Widget Register ( Meta Widget )
 *
 * @author  Kazuya Takami
 * @version 1.1.0
 * @since   1.1.0
 * @see     /wp-includes/widgets/class-wp-widget-meta.php
 * @see     wp-widget-extensions-form-build.php
 */

unregister_widget( 'WP_Widget_Meta' );
register_widget( 'WP_Widget_Extensions_Meta' );

class WP_Widget_Extensions_Meta extends WP_Widget_Meta {

	/**
	 * Variable definition.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	private $text_domain = 'wp-widget-extensions';
	private $instance    = array();

	/**
	 * Widget Form Display.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 * @access  public
	 * @param   array $instance
	 * @return  string Parent::Default return is 'noform'
	 */
	public function form ( $instance ) {
		parent::form( $instance );

		require_once( 'wp-widget-extensions-form-build.php' );
		$form = new WP_Widget_Extensions_Form_Build();

		echo '<hr>';
		echo '<p>';

		/**
		 * Site Admin
		 */
		$field_name = 'site_admin';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = ''; }
		$form->checkbox( $this->get_field_id( $field_name ), $this->get_field_name( $field_name ), $instance[ $field_name ], __( 'Site Admin' ) );
		echo '<br />';

		/**
		 * Site Login
		 */
		$field_name = 'site_login';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = ''; }
		$form->checkbox( $this->get_field_id( $field_name ), $this->get_field_name( $field_name ), $instance[ $field_name ], __('Log in') . ' / ' . __('Log out') );
		echo '<br />';

		/**
		 * Entries RSS
		 */
		$field_name = 'entries_rss';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = ''; }
		$form->checkbox( $this->get_field_id( $field_name ), $this->get_field_name( $field_name ), $instance[ $field_name ], __( 'Entries <abbr title="Really Simple Syndication">RSS</abbr>' ) );
		echo '<br />';

		/**
		 * Comments RSS
		 */
		$field_name = 'comments_rss';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = ''; }
		$form->checkbox( $this->get_field_id( $field_name ), $this->get_field_name( $field_name ), $instance[ $field_name ], __( 'Comments <abbr title="Really Simple Syndication">RSS</abbr>' ) );
		echo '<br />';

		/**
		 * WordPress.org
		 */
		$field_name = 'wordpress_org';
		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = ''; }
		$form->checkbox( $this->get_field_id( $field_name ), $this->get_field_name( $field_name ), $instance[ $field_name ], _x( 'WordPress.org', 'meta widget link text' ) );

		echo '</p>';
	}

	/**
	 * Widget Form Update.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 * @access  public
	 * @param   array $new_instance
	 * @param   array $old_instance
	 * @return  array $instance
	 */
	public function update ( $new_instance, $old_instance ) {
		$instance = parent::update( $new_instance, $old_instance );
		return (array) $instance;
	}

	/**
	 * Widget Display.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 * @access  public
	 * @param   array $args
	 * @param   array $instance
	 */
	public function widget ( $args, $instance ) {
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', empty($instance['title']) ? __( 'Meta' ) : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$html  = '';
		$html .= '<ul>';

		wp_register();

		$html .= '<li>' . wp_loginout( '', false ) . '</li>';

		$html .= '<li><a href="' . esc_url( get_bloginfo( 'rss2_url' ) ) . '">'. __( 'Entries <abbr title="Really Simple Syndication">RSS</abbr>' ) . '</a></li>';

		$html .= '<li><a href="' . esc_url( get_bloginfo( 'comments_rss2_url' ) ) . '">'. __( 'Comments <abbr title="Really Simple Syndication">RSS</abbr>' ) . '</a></li>';

		echo $html;

		echo apply_filters( 'widget_meta_poweredby', sprintf( '<li><a href="%s" title="%s">%s</a></li>',
			esc_url( __( 'https://wordpress.org/' ) ),
			esc_attr__( 'Powered by WordPress, state-of-the-art semantic personal publishing platform.' ),
			_x( 'WordPress.org', 'meta widget link text' )
		) );

		wp_meta();

		echo '</ul>';

		echo $args['after_widget'];
	}
}