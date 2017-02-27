<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/GarySwift
 * @since      1.0.0
 *
 * @package    Wp_Swift_Google_Map
 * @subpackage Wp_Swift_Google_Map/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Swift_Google_Map
 * @subpackage Wp_Swift_Google_Map/includes
 * @author     Gary <garyswiftmail@gmail.com>
 */
class Wp_Swift_Google_Map_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-swift-google-map',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
