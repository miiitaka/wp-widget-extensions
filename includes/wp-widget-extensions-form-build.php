<?php
/**
 * Admin Widget Form Build
 *
 * @author  Kazuya Takami
 * @version 2.0.0
 * @since   1.1.0
 */

class WP_Widget_Extensions_Form_Build {

	/**
	 * Variable definition.(Text Domain)
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	private $text_domain = 'wp-widget-extentions';

	/**
	 * Widget Form Checkbox.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 * @access  private
	 * @param   string  $id
	 * @param   string  $name
	 * @param   boolean $value
	 * @param   string  $text
	 */
	public function checkbox ( $id, $name, $value, $text ) {
		if ( $value ) {
			printf( '<input type="checkbox" id="%s" name="%s" class="checkbox" checked="checked">', $id, $name );
		} else {
			printf( '<input type="checkbox" id="%s" name="%s" class="checkbox">', $id, $name );
		}
		printf( '<label for="%s">%s</label>', $id, $text );
	}

	/**
	 * Widget Form Number.
	 *
	 * @version 1.3.2
	 * @since   1.1.0
	 * @access  private
	 * @param   string  $id
	 * @param   string  $name
	 * @param   boolean $value
	 * @param   string  $text
	 */
	public function number ( $id, $name, $value, $text ) {
		echo '<p>';
		printf( '<label for="%s">%s</label>', $id, $text );
		printf( '<input type="number" id="%s" name="%s" value="%s" class="small-text">', $id, $name, esc_attr( $value ) );
		echo '</p>';
	}

	/**
	 * Widget Form Text.
	 *
	 * @version 1.3.2
	 * @since   1.3.0
	 * @access  private
	 * @param   string  $id
	 * @param   string  $name
	 * @param   boolean $value
	 * @param   string  $text
	 * @param   string  $placeholder
	 * @param   string  $notes
	 */
	public function text ( $id, $name, $value, $text, $placeholder = "", $notes = "" ) {
		echo '<p>';
		printf( '<label for="%s">%s</label>', $id, $text );
		printf( '<input type="text" id="%s" name="%s" value="%s" class="widefat" placeholder="%s">', $id, $name, esc_attr( $value ), esc_attr( $placeholder ) );

		if ( !empty( $notes ) ) {
			printf( '<small>%s</small>', esc_attr( $notes ) );
		}
		echo '</p>';
	}

	/**
	 * Widget Form Text(Color Picker).
	 *
	 * @version 1.6.0
	 * @since   1.6.0
	 * @access  private
	 * @param   string  $id
	 * @param   string  $name
	 * @param   boolean $value
	 * @param   string  $text
	 * @param   string  $class
	 */
	public function text_color_picker ( $id, $name, $value, $text, $class ) {
		echo '<p style="margin: 5px 0;">';
		printf( '<label for="%s">%s</label>', $id, $text );
		echo '</p>';
		printf( '<input type="text" id="%s" name="%s" value="%s" class="widefat %s">', $id, $name, esc_attr( $value ), $class );
	}

	/**
	 * Widget Form Select.
	 *
	 * @version 1.3.2
	 * @since   1.1.0
	 * @access  private
	 * @param   string  $id
	 * @param   string  $name
	 * @param   boolean $value
	 * @param   string  $text
	 * @param   array   $option_array
	 */
	public function select ( $id, $name, $value, $text, array $option_array ) {
		echo '<p>';
		printf( '<label for="%s">%s</label><br>', $id, $text );
		printf( '<select id="%s" name="%s" class="widefat">', $id, $name );

		foreach ( $option_array as $key => $row ) {
			if ( $key == $value ) {
				printf( '<option value="%s" selected="selected">%s</option>', $key, esc_html( $row ) );
			} else {
				printf( '<option value="%s">%s</option>', $key, esc_html( $row ) );
			}
		}
		echo '</select></p>';
	}

	/**
	 * Widget Form Select.(target)
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 * @access  private
	 * @param   string  $id
	 * @param   string  $name
	 * @param   boolean $value
	 */
	public function select_target ( $id, $name, $value ) {
		$args = array(
			"all"    => __( "All Users",        $this->text_domain ),
			"login"  => __( "Logged-in users",  $this->text_domain ),
			"logout" => __( "Logged-out users", $this->text_domain )
		);
		$this->select(
			$id,
			$name,
			$value,
			__( 'Widget display target:', $this->text_domain ),
			$args
		);
	}

}