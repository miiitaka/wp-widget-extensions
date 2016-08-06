<?php
/**
 * Admin Widget Form Build
 *
 * @author  Kazuya Takami
 * @version 1.3.0
 * @since   1.1.0
 */

class WP_Widget_Extensions_Form_Build {

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
	 * @version 1.1.0
	 * @since   1.1.0
	 * @access  private
	 * @param   string  $id
	 * @param   string  $name
	 * @param   boolean $value
	 * @param   string  $text
	 */
	public function number ( $id, $name, $value, $text ) {
		printf( '<p><label for="%s">%s</label>', $id, $text );
		printf( '<input type="number" id="%s" name="%s" value="%s" class="small-text">', $id, $name, esc_attr( $value ) );
		echo '</p>';
	}

	/**
	 * Widget Form Text.
	 *
	 * @version 1.3.0
	 * @since   1.3.0
	 * @access  private
	 * @param   string  $id
	 * @param   string  $name
	 * @param   boolean $value
	 * @param   string  $text
	 * @param   string  $placeholder
	 */
	public function text ( $id, $name, $value, $text, $placeholder ) {
		printf( '<p><label for="%s">%s</label>', $id, $text );
		printf( '<input type="text" id="%s" name="%s" value="%s" class="widefat" placeholder="%s">', $id, $name, esc_attr( $value ), esc_attr( $placeholder ) );
		echo '</p>';
	}

	/**
	 * Widget Form Select.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 * @access  private
	 * @param   string  $id
	 * @param   string  $name
	 * @param   boolean $value
	 * @param   string  $text
	 * @param   array   $option_array
	 */
	public function select ( $id, $name, $value, $text, array $option_array ) {
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

}