<?php

class MPS_Options {

	/**
	 * Returns an array of option names for a given type.
	 *
	 * @return array
	 */
	public static function get_option_names() {
		return [
			'activated',
			'active_modules',
		];
	}

	/**
	 * Checks if the option name valid.
	 *
	 * @param string $name The name of the option
	 *
	 * @return bool        If the option name is valid.
	 */
	public static function is_valid( $name ) {
		if ( in_array( $name, self::get_option_names() ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Updates the single given option.
	 *
	 * @param string $name  Option name.
	 * @param mixed  $value Option value.
	 * @param string $autoload
	 *
	 * @return bool If the option successfully updated.
	 */
	public static function update_option( $name, $value, $autoload = null ) {
		if ( self::is_valid( $name ) ) {
			return update_option( "mps_$name", $value, $autoload );
		}

		trigger_error( sprintf( 'Invalid option name: %s', $name ), E_USER_WARNING );

		return false;
	}

	/**
	 * Returns the requested option.
	 *
	 * @param string $name Option name.
	 *
	 * @return mixed
	 */
	public static function get_option( $name ) {
		if ( self::is_valid( $name ) ) {
			return get_option( "mps_$name" );
		}

		trigger_error( sprintf( 'Invalid option name: %s', $name ), E_USER_WARNING );

		return false;
	}

	/**
	 * Returns the requested option, and ensures it's toggleable from settings.
	 *
	 * @param string $name    Option name
	 * @param mixed  $default (optional)
	 *
	 * @return mixed
	 */
	public static function get_option_and_ensure_autoload( $name, $default ) {
		$value = get_option( $name );

		if ( $value == false && $default !== false ) {
			update_option( $name, $default );
			$value = $default;
		}

		return $value;
	}

	/**
	 * Delete all known options
	 *
	 * @return void
	 */
	static function delete_all_known_options() {
		foreach ( (array) self::get_option_names() as $option_name ) {
			delete_option( $option_name );
		}
	}

	/**
	 * Prints out a setting's section and settings added to a particular settings page
	 *
	 * @global       $wp_settings_sections Storage array of all settings sections added to admin pages.
	 * @global       $wp_settings_fields   Storage array of settings fields and info about their pages/sections.
	 *
	 * @param string $page                 The slug name of the page whose settings sections you want to output.
	 * @param string $section              Slug title of the settings section whose fields you want to show.
	 */
	static function do_settings_section( $page, $section ) {
		global $wp_settings_sections, $wp_settings_fields;

		if ( ! isset( $wp_settings_fields[ $page ][ $section ] ) ) {
			return;
		}

		$section = (array) $wp_settings_sections[$page][ $section ];

		if ( $section['title'] ) {
			echo "<h2>{$section['title']}</h2>\n";
		}

		if ( $section['callback'] ) {
			call_user_func( $section['callback'], $section );
		}

		echo '<table class="form-table">';
		do_settings_fields( $page, $section['id'] );
		echo '</table>';
	}

}