<?php
/**
 * Admin Widget Register
 *
 * @author  Kazuya Takami
 * @version 2.0.0
 * @since   1.6.0
 * @see     /wp-includes/widgets/class-wp-widget-calendar.php
 */

unregister_widget( 'WP_Widget_Calendar' );
register_widget( 'WP_Widget_Extensions_Calendar' );

class WP_Widget_Extensions_Calendar extends WP_Widget_Calendar {

	/**
	 * Variable definition.
	 *
	 * @version 1.6.0
	 * @since   1.6.0
	 */
	private $text_domain = 'wp-widget-extentions';

	/**
	 * Widget Form Display.
	 *
	 * @version 2.0.0
	 * @since   1.6.0
	 * @access  public
	 * @param   array $instance
	 * @return  string Parent::Default return is 'noform'
	 */
	public function form ( $instance ) {
		parent::form( $instance );

		/* Form build  */
		require_once( 'wp-widget-extensions-form-build.php' );
		$form = new WP_Widget_Extensions_Form_Build();

		/* Color Picker Library Read */
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		if ( !isset( $instance[ 'sat-background-color' ] ) ) { $instance[ 'sat-background-color' ] = "#ffffff"; }
		if ( !isset( $instance[ 'sat-font-color' ] ) ) { $instance[ 'sat-font-color' ] = "#000000"; }
		if ( !isset( $instance[ 'sun-background-color' ] ) ) { $instance[ 'sun-background-color' ] = "#ffffff"; }
		if ( !isset( $instance[ 'sun-font-color' ] ) ) { $instance[ 'sun-font-color' ] = "#000000"; }

		$html  = '<script>';
		$html .= '(function($) {';
		$html .= '$(function() {';
		$html .= '$("#' . $this->get_field_id( 'sat-background-color' ) . '").wpColorPicker({"defaultColor": "' . $instance[ 'sat-background-color' ] . '"});';
		$html .= '$("#' . $this->get_field_id( 'sat-font-color' ) . '").wpColorPicker({"defaultColor": "' . $instance[ 'sat-font-color' ] . '"});';
		$html .= '$("#' . $this->get_field_id( 'sun-background-color' ) . '").wpColorPicker({"defaultColor": "' . $instance[ 'sun-background-color' ] . '"});';
		$html .= '$("#' . $this->get_field_id( 'sun-font-color' ) . '").wpColorPicker({"defaultColor": "' . $instance[ 'sun-font-color' ] . '"});';
		$html .= '});';
		$html .= '})(jQuery);';
		$html .= '</script>';

		echo $html;

		echo '<hr>';
		echo '<p><strong>[ Plugin: WordPress Default Widget Extension ]</strong></p>';

		/**
		 * Saturday Background Color
		 */
		$field_name = 'sat-background-color';
		$form->text_color_picker(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ],
			__( 'Saturday Background Color :' , $this->text_domain ),
			$field_name
		);

		/**
		 * Saturday Font Color
		 */
		$field_name = 'sat-font-color';
		$form->text_color_picker(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ],
			__( 'Saturday Font Color :' , $this->text_domain ),
			$field_name
		);

		/**
		 * Sunday Background Color
		 */
		$field_name = 'sun-background-color';
		$form->text_color_picker(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ],
			__( 'Sunday Background Color :' , $this->text_domain ),
			$field_name
		);

		/**
		 * Sunday Font Color
		 */
		$field_name = 'sun-font-color';
		$form->text_color_picker(
			$this->get_field_id( $field_name ),
			$this->get_field_name( $field_name ),
			$instance[ $field_name ],
			__( 'Sunday Font Color :' , $this->text_domain ),
			$field_name
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
	 * @since   1.6.0
	 * @access  public
	 * @param   array $new_instance
	 * @param   array $old_instance
	 * @return  array $instance
	 */
	public function update ( $new_instance, $old_instance ) {
		$instance = parent::update( $new_instance, $old_instance );

		$instance['sat-background-color'] = sanitize_text_field( $new_instance['sat-background-color'] );
		$instance['sat-font-color']       = sanitize_text_field( $new_instance['sat-font-color'] );
		$instance['sun-background-color'] = sanitize_text_field( $new_instance['sun-background-color'] );
		$instance['sun-font-color']       = sanitize_text_field( $new_instance['sun-font-color'] );
		$instance['target']               = sanitize_text_field( $new_instance['target'] );

		return (array) $instance;
	}

	/**
	 * Widget Display.
	 *
	 * @version 2.0.0
	 * @since   1.6.0
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

		wp_enqueue_script( 'jquery' );

		$this->set_color_style( $args['widget_id'], $instance );
		$saturday_week = $this->get_week_date(6);
		$sunday_week   = $this->get_week_date(0);

		$html  = '<script>';
		$html .= '(function($) {$(function() {';
		$html .= 'var satArray = ' . $saturday_week . ',';
		$html .= 'sunArray = ' . $sunday_week . ',';
		$html .= 'tdObj = $("#' . $args['widget_id'] . ' tbody td");';
		$html .= 'tdObj.each(function(){';
		$html .= 'if (satArray.indexOf(Number($(this).text())) >= 0) {';
		$html .= '$(this).addClass("wp-extension-calendar-sat");';
		$html .= '}';
		$html .= 'if (sunArray.indexOf(Number($(this).text())) >= 0) {';
		$html .= '$(this).addClass("wp-extension-calendar-sun");';
		$html .= '}';
		$html .= '})});})(jQuery);';
		$html .= '</script>';

		echo $html;
	}

	/**
	 * Color style set.
	 *
	 * @version 1.6.0
	 * @since   1.6.0
	 * @access  private
	 * @param   string $args
	 * @param   array  $instance
	 */
	private function set_color_style( $widget_id, $instance ) {
		$html = '<style>';

		/* Saturday color style. */
		$html .= '#' . $widget_id . ' .wp-extension-calendar-sat {';
		if ( isset( $instance['sat-background-color'] ) && $this->is_color_code( $instance['sat-background-color'] ) ) {
			$html .= 'background-color: ' . $instance['sat-background-color'] . ';';
		}
		if ( isset( $instance['sat-font-color'] ) && $this->is_color_code( $instance['sat-font-color'] ) ) {
			$html .= 'color: ' . $instance['sat-font-color'] . ';';
		}
		$html .= '}';

		/* Sunday color style. */
		$html .= '#' . $widget_id . ' .wp-extension-calendar-sun {';
		if ( isset( $instance['sun-background-color'] ) && $this->is_color_code( $instance['sun-background-color'] ) ) {
			$html .= 'background-color: ' . $instance['sun-background-color'] . ';';
		}
		if ( isset( $instance['sun-font-color'] ) && $this->is_color_code( $instance['sun-font-color'] ) ) {
			$html .= 'color: ' . $instance['sun-font-color'] . ';';
		}
		$html .= '}';

		$html .= '</style>';

		echo $html;
	}

	/**
	 * Color code regular expression check.
	 *
	 * @version 1.6.0
	 * @since   1.6.0
	 * @access  private
	 * @param   string $color
	 * @return  boolean
	 */
	private function is_color_code( $color ) {
		if ( preg_match( "/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/", $color ) ) {
			return __return_true();
		} else {
			return __return_false();
		}
	}

	/**
	 * Get the date array of the specified day of the week.
	 *
	 * @version 1.6.0
	 * @since   1.6.0
	 * @access  private
	 * @param   integer $weekday_number
	 * @return  object  $weekday
	 */
	private function get_week_date( $weekday_number ) {
		global $year, $monthnum;

		$time_stamp = current_time( 'timestamp' );
		$this_month = empty( $monthnum ) ? gmdate( 'm', $time_stamp ) : $monthnum;
		$this_year  = empty( $year )     ? gmdate( 'Y', $time_stamp ) : $year;

		/* Month Last Day */
		$days_in_month = (int) date( 't', mktime( 0, 0 , 0, $this_month, 1, $this_year ) );

		$weekday = array();
		for ( $day = 1; $day <= $days_in_month; $day++ ) {
			$w = (int) date( 'w', mktime( 0, 0 , 0, $this_month, $day, $this_year ) );
			if ( $weekday_number == $w ) {
				$weekday[] = $day;
			}
		}
		return json_encode( $weekday, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT );
	}
}