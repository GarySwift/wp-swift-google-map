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
	 * The Google API key
	 * It is necessary to register a Google API key in order to allow the Google API to load correctly. 
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $google_api_key=false;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		// add_action( 'admin_init', array($this, array($this, 'set_google_api_key')) );
		add_action('acf/init', array($this, 'wp_swift_acf_init'));
		# Create the menu link in the tools menu
		// add_action( 'admin_menu', array($this, 'wp_swift_google_map_add_admin_menu') );
		add_action( 'admin_menu', array($this, 'wp_swift_acf_options_sub_page_google_map') );
		add_action( 'admin_menu', array($this, 'wp_swift_acf_options_sub_page_google_api_key') );
		add_action( 'admin_menu', array($this, 'acf_add_local_field_group_google_api_key') );
		# Initialize the page settings
		// add_action( 'admin_init', array($this, 'wp_swift_google_map_settings_init' ) );
		# A shortcode for rendering the google maps.
        add_shortcode( 'wp-swift-google-map', array( $this, 'render_google_map' ) );


        // if ($this->google_api_key) {
			# Create the JavaScript variables used in the Google Maps API directly in the footer
			add_action('wp_footer', array($this, 'set_map_js_vars_in_footer'));
			if ( ! is_admin() ) {
				# enqueue the google maps API in the footer
				// add_action( 'admin_enqueue_scripts', array($this, 'enqueue_assets_googleapis_maps') );
				add_action( 'init', array($this, 'enqueue_assets_googleapis_maps') );//admin_enqueue_scripts
			}
			

		// 			$key = $this->google_api_key;
		// 			echo "<pre>";var_dump($key);echo "</pre>";
		// wp_enqueue_script( 
		//   'google-maps', 
		//   '//maps.googleapis.com/maps/api/js?v=3.exp&key='.$key, 
		//   array(), 
		//   '1.0', 
		//   true 
		// );
        // }

	}


public function wp_swift_acf_options_sub_page_google_map() {
	/*
	 * The submenu page
	 */
	acf_add_options_sub_page(array(
	    'title' => 'Google Map',
	    'slug' => 'wp-swift-acf-google-map',
	    'parent' => 'options-general.php'//$this->parent,
	));	
}
	
public function wp_swift_acf_options_sub_page_google_api_key() {
	/*
	 * The submenu page
	 */
	acf_add_options_sub_page(array(
	    'title' => 'Google API Key',
	    'slug' => 'google-api-key',
	    'parent' => 'options-general.php',//'tools.php'//$this->parent,
	));

}

public function acf_add_local_field_group_google_api_key() {
	/*
	 * The ACF fields
	 */
	if( function_exists('acf_add_local_field_group') ):

		acf_add_local_field_group(array (
			'key' => 'group_57f000b6caf59',
			'title' => 'Google API Key',
			'fields' => array (
				array (
					'key' => 'field_57f000c651529',
					'label' => 'Google API Key',
					'name' => 'google_api_key',
					'type' => 'text',
					'instructions' => 'Register a Google API key in order to allow the Google API to load correctly',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'google-api-key',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'seamless',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));

	endif;	
}
public function acf_add_local_field_group_google_map() {
	if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array (
		'key' => 'group_58b53ef2b3176',
		'title' => 'Google Map',
		'fields' => array (
			array (
				'key' => 'field_58b5464b3d00a',
				'label' => 'Map',
				'name' => 'map',
				'type' => 'google_map',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'center_lat' => '52.259320',
				'center_lng' => '-7.110070',
				'zoom' => 16,
				'height' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'wp-swift-acf-google-map',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'seamless',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	endif;
}

/*
 * It is necessary to register a Google API key in order to allow the Google API to load correctly. 
 *
 * Ref: https://www.advancedcustomfields.com/resources/google-map/
 *
 */
public function wp_swift_acf_init() {
	// function my_acf_init() {
		$google_api_key = get_field('google_api_key', 'option');
		if( $google_api_key ) {
			acf_update_setting('google_api_key', $google_api_key);
			$this->google_api_key = $google_api_key;
		}		
}
	function enqueue_assets_googleapis_maps() {
		// $key = $this->google_api_key;
		$key=  'AIzaSyCICoKUng12Yd9aMSkFOHWN6s0Ib17SozI';
		wp_enqueue_script( 
		  'google-maps', 
		  '//maps.googleapis.com/maps/api/js?v=3.exp&key='.$key, 
		  array(), 
		  '1.0', 
		  true 
		);
	}

    /**
     * A shortcode for rendering the google map.
     *
     * @param  array   $attributes  Shortcode attributes.
     * @param  string  $content     The text content for shortcode. Not used.
     *
     * @return string  The shortcode output
     */
    public function render_google_map( $attributes, $content = null ) {
        ob_start();
        if ($this->google_api_key):
     		$location = get_field('map', 'option');
			if( !empty($location) ):
			?>
				<p><?php echo $location['address']; ?></p>
				<div class="acf-map">
					<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
				</div>
			<?php endif; ?>
		<?php else: ?>
			<div class="callout">
				<h3>Sorry, there was a problem loading the map.</h3>
			</div>
			<?php
		endif;
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    /**
     * This will create the JavaScript variables used in the  Google Maps API
     *
     */
    public function set_map_js_vars_in_footer() {


        ob_start();
		$map_zoom_level=14;
		$decription='Directions coming soon.';
		if( get_field('directions', 'option') ) {
		    $directions = get_field('directions', 'option');
		    foreach ($directions as $key => $value) {
		    	$decription.= $value['content'];
		    }
		}
	    // contentString is used to make the Info windows in the google map 
		// More: https://developers.google.com/maps/documentation/javascript/examples/infowindow-simple
		$contentString = 
		'<div id="content" class="google-content-pane">'.
			'<div id="siteNotice"></div>'.
			'<h3 id="firstHeading" class="firstHeading">'.get_bloginfo('name').'</h3>'.
			'<h5 id="secondHeading" class="secondHeading">'.get_bloginfo('description').'</h5>'.
			//'<div id="bodyContent">'.$decription.'</div>'.
		'</div>';
		/*Go to https://snazzymaps.com/ [Snazzy Maps] for map styles*/
		$map_style = false;
		/*<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCICoKUng12Yd9aMSkFOHWN6s0Ib17SozI"></script>*/
		?>
		
		<script>
		    var map_zoom_level = <?php echo json_encode($map_zoom_level); //Don't forget the extra semicolon ?>;
		    map_zoom_level = parseInt(map_zoom_level);
		    var map_style = <?php echo json_encode($map_style); ?>;
		    map_style = JSON.parse(map_style);
		    var contentString = <?php echo json_encode($contentString); ?>;
		</script>
		<?php 

        $html = ob_get_contents();
        ob_end_clean();
     
        echo $html;


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