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
	public function __construct($plugin_name='', $version='') {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		# Register the Google API key to use with Advanced Custum Fields
		add_action('acf/init', array($this, 'wp_swift_acf_init'));

		# Create the menu links
		add_action( 'admin_menu', array($this, 'wp_swift_acf_options_sub_page_google_map') );
		add_action( 'admin_menu', array($this, 'wp_swift_acf_options_sub_page_google_api_key') );

		# Register ACF field groups that will appear on the options pages
		add_action( 'admin_menu', array($this, 'acf_add_local_field_group_google_api_key') );
		add_action( 'admin_menu', array($this, 'acf_add_local_field_group_google_map') );

		# Shortcodes for rendering the google maps.
        add_shortcode( 'wp-swift-google-map', array( $this, 'render_google_map' ) );
        add_shortcode( 'google-map', array( $this, 'render_google_map' ) );

		# enqueue the google maps API in the footer
		add_action( 'init', array($this, 'enqueue_assets_googleapis_maps') );

		# Create the JavaScript variables used in the Google Maps API directly in the footer
		add_action('wp_footer', array($this, 'set_map_js_vars_in_footer'));
	}

	/*
	 * This determines the location the menu links
	 * They are listed under Settings unless the other plugin 'wp_swift_admin_menu' is activated
	 */
	public function get_parent_slug() {
		if ( get_option( 'wp_swift_admin_menu' ) ) {
			return get_option( 'wp_swift_admin_menu' );
		}
		else {
			return 'options-general.php';
		}
	}

	/*
	 * The 'Google Map' submenu page
	 */
	public function wp_swift_acf_options_sub_page_google_map() {

		if(function_exists('acf_add_options_page')) { 

			acf_add_options_sub_page(array(
			    'title' => 'Google Map',
			    'slug' => 'wp-swift-acf-google-map',
			    'parent' => $this->get_parent_slug(),
			));	
		}
	}

	/*
	 * The 'Google API Key' submenu page
	 */		
	public function wp_swift_acf_options_sub_page_google_api_key() {

		if(function_exists('acf_add_options_page')) { 
		    $user = wp_get_current_user();
		    if (user_can( $user->ID, 'administrator' )) { // Editor and above
				acf_add_options_sub_page(array(
				    'title' => 'Google API Key',
				    'slug' => 'wp-swift-google-api-key',
				    'parent' => $this->get_parent_slug(),
				));
			}
		}

	}

	/*
	 * The ACF field group for 'Google API Key'
	 */
	public function acf_add_local_field_group_google_api_key() {

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
							'value' => 'wp-swift-google-api-key',
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
	 * The ACF field group for 'Google Map'
	 */	
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
		$google_api_key = get_field('google_api_key', 'option');
		if( $google_api_key ) {
			acf_update_setting('google_api_key', $google_api_key);
			$this->google_api_key = $google_api_key;
		}		
	}

	/*
	 * Retun the API key if it was set
	 */
	public function get_api_key() {
		if (get_field('google_api_key', 'option')) {
			return get_field('google_api_key', 'option');
		} else {
			return false;
		}
	}

	/*
	 * Enqueue the google maps API in the footer
	 */
	public function enqueue_assets_googleapis_maps() {
		if ( ! is_admin() ) {// Do not use the API in the WordPress backend as it will be called twice
			$key = $this->get_api_key();
			if ($key) {
				wp_enqueue_script( 
				  'google-maps', 
				  '//maps.googleapis.com/maps/api/js?v=3.exp&key='.$key, 
				  array(), 
				  '1.0', 
				  true 
				);
			}
		}
	}

    /**
     * A shortcode for rendering the google map.
     *
     * @param  array   $attributes  Shortcode attributes.
     * @param  string  $content     The text content for shortcode. Not used.
     *
     * @return string  The shortcode output
     */
    public function render_google_map( $attributes=null, $content = null ) {
        ob_start();
        if ($this->get_api_key()):
     		$location = get_field('map', 'option');
			if( !empty($location) ):
			?>
				<?php if (isset($attributes['address'])): ?>
					<p><?php echo $location['address']; ?></p>
				<?php endif ?>
				
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
     * This will create the JavaScript variables used in the Google Maps API
     *
     */
    public function set_map_js_vars_in_footer() {

		$map_zoom_level=14;/* Go to https://snazzymaps.com/ [Snazzy Maps] for map styles */
		$map_style = false;
	    // contentString is used to make the Info windows in the google map 
		// More: https://developers.google.com/maps/documentation/javascript/examples/infowindow-simple
		ob_start();
		?>
		<div id="content" class="google-content-pane">
			<div id="siteNotice"></div>
			<h5 id="firstHeading"><?php echo get_bloginfo('name') ?></h5>
			<h6 id="secondHeading"><?php echo get_bloginfo('description') ?></h6>
		</div>
		<?php
			$contentString = ob_get_contents();
			ob_end_clean();
			ob_start();
		?>
		<script>
		    var map_zoom_level = <?php echo json_encode($map_zoom_level); //Don't forget the extra semicolon ?>;
		    map_zoom_level = parseInt(map_zoom_level);
		    var map_style = <?php echo json_encode($map_style); ?>;
		    map_style = JSON.parse(map_style);
		    var contentString = <?php echo json_encode($contentString); ?>;
		</script>
		<?php 

        $javascript = ob_get_contents();
        ob_end_clean();
        echo $javascript;
    }

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-swift-google-map-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-swift-google-map-public.js', array( 'jquery' ), $this->version, false );

	}
}