<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://8-b.co
 * @since      1.0.0
 *
 * @package    Wp_Pivotal_Tracker
 * @subpackage Wp_Pivotal_Tracker/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Pivotal_Tracker
 * @subpackage Wp_Pivotal_Tracker/admin
 * @author     Bob Ware <jrbobware@gmail.com>
 */
class Wp_Pivotal_Tracker_Admin {

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
	 * Slug used for the plugin's settings
	 * 
	 * @since 1.0.0
	 * @access private
	 * @var string $option_name Slug for naming plugin settings records
	 */
	private $option_name;

	/**
	 * Pivotal Tracker API object
	 * 
	 * @since 1.0.0
	 * @access private
	 * @var object $api Object providing methods to interact with the Pivotal Tracker API
	 */
	private $api;

	/**
	 * Pivotal Tracker API token
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string API token for authentication with Pivotal Tracker
	 */
	private $api_token;

	/**
	 * Pivotal Tracker Project ID
	 *
	 * @since 1.0.0
	 * @access private
	 * @var int ID of PT project
	 */
	private $project_id;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// set the option slug to be $plugin_name with - replaced with _
		$this->option_name = str_replace( '-', '_', $plugin_name );

		// attempt to retrieve the api token from the DB
		$this->api_token = get_option( $this->option_name . '_api_token', false );



		// set admin notice if no api key
		if ( false === $this->api_token ) {
			// do thing
			// add admin notification function to admin_notices hook
		}

		// attempt to retrieve the project ID
		$this->project_id = get_option( $this->option_name . '_project_id', false );

		// set admin notice if no project id
		if ( false === $this->project_id ) {
			// do thing?
		}

		// create our API object
		$this->api = new Wp_Pivotal_Tracker_Api( $this->api_token );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Pivotal_Tracker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Pivotal_Tracker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-pivotal-tracker-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Pivotal_Tracker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Pivotal_Tracker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-pivotal-tracker-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register plugin settings
	 * Added to 'admin_init' action hook in main plugin class.
	 */
	public function register_settings() {

		// adds a section to the Settings menu
		add_settings_section(
			$this->option_name . '_general',
			__( 'Settings', $this->plugin_name ),
			array( $this, 'display_settings_page' ),
			$this->plugin_name
		);

		// add the API token field to the settings section
		add_settings_field(
			$this->option_name . '_api_token',	// id
			__( 'API Token', $this->plugin_name ),	// title
			array( $this, 'display_settings_api_token' ),	// callback
			$this->plugin_name,	
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_api_token' )
		);

		// add the Project ID field to the general settings section
		add_settings_field( 
			$this->option_name . '_project_id',
			__( 'Project ID', $this->plugin_name ),
			array( $this, 'display_settings_project_id' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_project_id' )
		);

		// register the api token setting
		register_setting(
			$this->plugin_name,
			$this->option_name . '_api_token',
			array( $this, 'sanitize_api_token' )
		);

		// register the project id setting
		register_setting(
			$this->plugin_name,
			$this->option_name . '_project_id',
			'intval'
		);

		// check for existing values and if empty issue Admin notifications!
		$api_token = get_option( $this->option_name, '_api_token' );
		$project_id = get_option( $this->option_name, '_project_id' );

		if ( empty( $api_token ) || empty( $project_id ) ) {
			// admin notification
			// set message
		}

	}

	/**
	 * Add admin menus
	 * Added to 'admin_menu' action hook in main plugin class file.
	 */
	public function add_menus() {

		// add top-level menu item
		add_menu_page(
			'WP Pivotal Tracker Stories', // page title
			'WP Pivotal Tracker', // menu title
			'manage_options',	// required user capability to access
			$this->plugin_name, // unique menu slug
			// using a class function requires passing an array containing the object and a string of the member function name
			array( 
				$this,
				'display_project_page'
				), // function to display page
			plugin_dir_url( __DIR__ ) . 'assets/Tracker_Icon-20x20.png', // icon
			11 // priority
		);

		// add a submenu page for adding a story
		add_submenu_page(
			$this->plugin_name, // parent menu URL slug
			__( 'WP Pivotal Tracker: Add Story', $this->plugin_name ), // page title
			__( 'Add Story', $this->plugin_name ), // menu title
			'manage_options', // required user capability to access
			$this->plugin_name . '-add-story', // URL slug for this menu item
			array( $this, 'display_add_story_page' ) // callback to render page
		);

		// add a settings submenu page
		add_submenu_page(
			$this->plugin_name, // parent menu URL slug
			__( 'WP Pivotal Tracker Settings', $this->plugin_name ), // page title
			__( 'Settings', $this->plugin_name ), // menu title
			'manage_options',
			$this->plugin_name . '-settings', // unique URL slug for this menu item
			array( $this, 'display_settings_page' ) // callback
		);

	}

	/**
	 * display options page
	 */
	public function display_project_page() {

		if ( !current_user_can('manage_options') ) { // DRY?
			return;
		}

		/**
		 * @TODO: error handling
		 */		

		$pt_response = $this->api->get_response();

		if ( !is_wp_error( $pt_response ) ) {
			$pt_response = $this->api->get_stories( $this->project_id );
		}

		if ( is_wp_error( $pt_response ) ) {
			$pt_errors = $pt_response->get_error_messages();
			$pt_data = 'Error!';
		}

		elseif ( !is_array( $pt_response ) || empty( $pt_response ) ) {
			$pt_data = 'No data retrieved.';
		}

		// if good, get body of response
		else {
			$pt_data = json_decode( $pt_response['body'], true );
			// $pt_data = $pt_response;
		}

		include 'partials/wp-pivotal-tracker-admin-display-project.php';

	}

	/**
	 * Display stories page
	 */
	public function display_stories_page() {
		// check permissions, again
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}

		$pt_data = 'You haven\'t added stories yet.';

		include_once 'partials/wp-pivotal-tracker-admin-display-stories.php';

	}

	/**
	 * Display add/edit story page
	 */
	public function display_add_story_page() {

		// check permissions, again
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}

		// this used for the 'action' hidden form value to hook into the 'admin_post_{action}' hook
		$pt_action = $this->option_name . '_add_story';

		$response = $this->api->get_response();

		if ( !is_null( $response ) ) {

		}

		include_once 'partials/wp-pivotal-tracker-admin-display-add-story.php';		

	}


	/**
	 * Display settings page text
	 */
	public function display_settings_page() {
		include_once 'partials/wp-pivotal-tracker-admin-display-settings.php';
	}


	/**
	 * Display API Token setting field.
	 */
	public function display_settings_api_token() {
		$this->_display_option_text_field( $this->option_name . '_api_token' );
	}

	/**
	 * Display Pivotal Tracker project ID field.
	 */
	public function display_settings_project_id() {
		$this->_display_option_text_field( $this->option_name . '_project_id' );
	}

	/**
	 * display text option field
	 */
	private function _display_option_text_field( $option_name, $options = array() ) {

		$value = get_option( $option_name );

		echo sprintf(
			'<input type="text" name="%s" id="%s" value="%s" class="regular-text">' . "\n",
			$option_name,
			$option_name,
			$value
		);
	}

	/**
	 * Process add/edit form submission.
	 * Added to admin_post_process_story_form
	 */
	public function wp_pivotal_tracker_add_story() {

		if ( empty( $_POST ) || !isset( $_POST['name'] ) || empty( $_POST['name'] ) ) {
			// EMPTY INPUT ERROR NOTICE
			add_action( 'admin_notices', array( $this, 'display_error_notice' ) );
			// REDIRECT TO ADD STORY
			wp_redirect( admin_url( 'admin.php?page=' . $this->plugin_name . '-add-story' ) );
			exit;
		}

		$data = $this->sanitize_story_form_data( $_POST );

		// do this thing
		$response = $this->api->add_story( $this->project_id, $data );

		// if no can, display errors
		if ( !is_array( $response ) || is_wp_error( $response ) ) {
			$pt_errors = $response->get_error_messages();
			$response = 'There were errors.';
			add_action( 'admin_notices', array( $this, 'display_error_notice' ) );
			// does this fall through to the same page?	
			$redirect = $this->plugin_name . '-add-story';
		}

		// if can, redirect to stories page!
		else {
			// set success admin notification
			add_action( 'admin_notices', array( $this, 'display_success_notice' ) );
			// redirect to stories page!				
			$redirect = $this->plugin_name;
		}

		// do_action( 'admin_notices' );
		wp_redirect( admin_url( 'admin.php?page=' . $redirect ) );
		exit();

	}

	/**
	 * Validate and sanitize the API key form data.
	 */
	public function sanitize_api_token( $api_token ) {

		// @TODO: validate length - 32 chars
		// @TODO: validate alphanumeric - pregmatch on [0-9a-z]{32}?

		return $api_token;
	}


	/**
	 * Validate, sanitize and process submitted story form data.
	 *
	 * @param $data form data (probably from POST)
	 *
	 * @return array clean data
	 */
	public function sanitize_story_form_data( $data ) {

		$_data = array();

		// name
		$_data['name'] = $this->sanitize_story_name( $data['name'] );

		// description
		$_data['description'] = $this->sanitize_story_description( $data['description'] );

		// labels
		/**
		 * Labels break teh thing.
		 * @TODO: fix labels!
		 */
		// $_data['labels'] = $this->sanitize_story_labels( $data['labels'] );

		return $_data;
	}

	/**
	 * VSP submitted form story name
	 *
	 * @param $name
	 *
	 * @return string clean story name
	 */
	public function sanitize_story_name( $name ) {

		$name = stripslashes($name);

		$name = substr($name, 0, 5000); // max length per PT dox

		return $name;
	}

	/**
	 * VSP submitted form story description
	 *
	 * @param $description
	 *
	 * @return string clean story description
	 */
	public function sanitize_story_description( $description ) {

		$description = stripslashes($description);

		$description = substr( $description, 0 , 20000 ); // max length 20000 per PT dox

		return $description;

	}

	/**
	 * VSP submitted form story labels
	 *
	 * @param $labels
	 *
	 * @return array clean story labels
	 */
	public function sanitize_story_labels( $labels ) {

		// we expect a comma separated list
		$labels = explode( ',', $labels );

		// but now we wanna trim and sanitize each label
		foreach( $labels as $k => $v ) {

			$v = trim( $v );
			
			$v = stripslashes($v);
			
			$labels[$k] = $v;

		}

		// add the plugin's name as a label
		$labels[] = $this->plugin_name;

		// $labels = implode( ',', $labels );

		return $labels;

	}


	/**
	 * Display admin notice. Dynamically hooked to 'admin_notices' as needed.
	 *
	 * I wish I could pass params
	 *
	 */
	public function display_notice() {

		$notice_type = 'notice-warning';

		$message = 'This is your admin notification speaking. Captain\'s Log on the poopdeck!';

		include 'partials/wp-pivotal-tracker-admin-display-notice.php';

	}

	public function display_error_notice() {

		$notice_type = 'notice-error';

		$message = "An unspecified error occurred.";

		include 'partials/wp-pivotal-tracker-admin-display-notice.php';

	}

	public function display_success_notice() {

		$notice_type = 'notice-success';

		$message = "An unspecified success occurred.";

		include 'partials/wp-pivotal-tracker-admin-display-notice.php';

	}

}
