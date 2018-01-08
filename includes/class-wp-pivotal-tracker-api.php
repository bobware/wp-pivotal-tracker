<?php

/**
 * Minimal implementation of the Pivotal Tracker v5 API using WordPress HTTP requests.
 *
 * @link       http://8-b.co
 * @since      1.0.0
 *
 * @package    Wp_Pivotal_Tracker
 * @subpackage Wp_Pivotal_Tracker/includes
 */

/**
 * Minimal implementation of the Pivotal Tracker v5 API using WordPress HTTP requests.
 *
 * @since      1.0.0
 * @package    Wp_Pivotal_Tracker
 * @subpackage Wp_Pivotal_Tracker/includes
 * @author     Bob Ware <jrbobware@gmail.com>
 */

class Wp_Pivotal_Tracker_Api {
	
	/**
	 * API token used to authenticate
	 */
	private $api_token = null;

	private $base_endpoint = 'https://www.pivotaltracker.com/services/v5';

	private $project_endpoint = '/project';

	private $basic_request_args = array(
		'method' => '',
		'headers' => array(
			'X-TrackerToken' => ''
		)
	);

	private $request_args = array(
		'GET' => null,
		'POST' => null,
		'PUT' => null,
		'DELETE' => null
	);

	/**
	 * Store last response
	 */
	private $response = null;

	/**
	 * Constructor
	 *
	 * @param string $api_token
	 *
	 */
	public function __construct( $api_token ) {

		// set the api token
		$this->api_token = $api_token;

		// set up the request arguments for GET requests
		$this->_init_request_arguments();

	}

	private function _init_request_arguments() {		

		foreach( $this->request_args as $method => $args ) {

			$this->request_args[ $method ] = array(
				'method' => $method,
				'headers' => array(
					'X-TrackerToken' => $this->api_token
				)
			);
			
		}

	}

	/**
	 * Generic get function to encapsulate the common repetitive bits
	 *
	 * @param string $url URL of the API endpoint to get
	 *
	 * @return array of data or some errors
	 */
	public function get( $url ) {

		$this->response = wp_remote_get( $this->base_endpoint . $url, $this->request_args['GET'] );

		return $this->response;

	}
	
	/**
	 * Get project data
	 *
	 * @param int $project_id
	 *
	 * @return array list of project data
	 */
	public function get_project( $project_id ) {
		return $this->get( '/projects/' . $project_id );
	}


	/**
	 * Get all stories from a given project
	 *
	 * @param int $project_id
	 *
	 * @return array of stories
	 */
	public function get_stories( $project_id ) {
		return $this->get( '/projects/' . $project_id . '/stories' );
	}

	/**
	 * Get a single story
	 *
	 * @param int $project_id
	 * @param int $story_id
	 *
	 * @return array of story data
	 */
	public function get_story( $project_id, $story_id ) {
		return $this->get( '/projects/' . $project_id . '/stories/' . $story_id );		
	}

	/**
	 * Add a story to the given project
	 *
	 * @param int $project_id
	 * @param array $data
	 *
	 * @return mixed new story id OR errors
	 */
	public function add_story( $project_id, $data ) {
		return $this->post( '/projects/' . $project_id . '/stories', $data );
	}

	/**
	 * Edit story
	 *
	 * @param int $project_id
	 * @param int $story_id
	 * @param array $data
	 *
	 * @return mixed story id OR errors
	 */
	public function edit_story( $project_id, $story_id, $data ) {
		return $this->post( '/projects/' . $project_id . '/stories/' . $story_id, $data );
	}

	/**
	 * Posts data to Pivotal Tracker API
	 *
	 * @param string $url
	 * @param array $data
	 *
	 * @return mixed story id OR errors
	 */
	public function post( $url, $data ) {

		$url = $this->base_endpoint . $url;

		$args = $this->request_args['POST'];

		$args['body'] = $data;

		$this->response = wp_remote_post( $url, $args );

		pr( array(
			'url' => $url,
			'args' => $args,
			'response' => $this->response
		));

		return $this->response;

	}

	/**
	 * Get last response
	 */
	public function get_response() {
		return $this->response;
	}


}
