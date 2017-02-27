<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/GarySwift
 * @since      1.0.0
 *
 * @package    Wp_Swift_Google_Map
 * @subpackage Wp_Swift_Google_Map/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Swift_Google_Map
 * @subpackage Wp_Swift_Google_Map/public
 * @author     Gary <garyswiftmail@gmail.com>
 */
class Wp_Swift_Google_Map_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct(  ) {//$plugin_name, $version

		// $this->plugin_name = $plugin_name;
		// $this->version = $version;

		add_action( 'admin_menu', array($this, 'wp_swift_google_map_add_admin_menu') );
		add_action( 'admin_init', array($this, 'wp_swift_google_map_settings_init' ) );

	}



	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function mgms_enqueue_assets() {
	wp_enqueue_script( 
	  'google-maps', 
	  '//maps.googleapis.com/maps/api/js?key=AIzaSyAzXoaC9OV09c-sTdIWWR1hWzUcJppx_g8&callback=initMap', 
	  array(), 
	  '1.0', 
	  true 
	);
}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Swift_Google_Map_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Swift_Google_Map_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-swift-google-map-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Swift_Google_Map_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Swift_Google_Map_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-swift-google-map-public.js', array( 'jquery' ), $this->version, false );

	}







	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function  wp_swift_google_map_add_admin_menu(  ) { 

		add_submenu_page( 'tools.php', 'Wp Swift Google Map', 'Wp Swift Google Map', 'manage_options', 'wp_swift_google_map', array($this, 'wp_swift_google_map_options_page') );

	}


	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function  wp_swift_google_map_settings_init(  ) { 

		register_setting( 'wp_swift_google_map_plugin_page', 'wp_swift_google_map_settings' );

		add_settings_section(
			'wp_swift_google_map_plugin_page_section', 
			__( 'Your section description', 'wp-swift-google-map' ), 
			array($this, 'wp_swift_google_map_settings_section_callback'), 
			'wp_swift_google_map_plugin_page'
		);

		add_settings_field( 
			'wp_swift_google_map_text_field_0', 
			__( 'Settings field description', 'wp-swift-google-map' ), 
			array($this, 'wp_swift_google_map_text_field_0_render'), 
			'wp_swift_google_map_plugin_page', 
			'wp_swift_google_map_plugin_page_section' 
		);


	}


	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function  wp_swift_google_map_text_field_0_render(  ) { 

		$options = get_option( 'wp_swift_google_map_settings' );
		?>
		<input type='text' name='wp_swift_google_map_settings[wp_swift_google_map_text_field_0]' value='<?php echo $options['wp_swift_google_map_text_field_0']; ?>'>
		<?php

	}


	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function  wp_swift_google_map_settings_section_callback(  ) { 

		echo __( 'This section description', 'wp-swift-google-map' );

	}


	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function  wp_swift_google_map_options_page(  ) { 

		?>
		<form action='options.php' method='post'>

			<h2>Wp Swift Google Map</h2>

			<?php
			settings_fields( 'wp_swift_google_map_plugin_page' );
			do_settings_sections( 'wp_swift_google_map_plugin_page' );
			submit_button();
			?>

		</form>
		<?php

	}

}
