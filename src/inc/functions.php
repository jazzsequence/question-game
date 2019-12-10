<?php
/**
 * Question Game Functions
 *
 * Helper functions used in the game files.
 *
 * @package Question-Game
 * @author Chris Reynolds <chris@jazzsequence.com>
 * @version 0.1.0
 */

namespace Game;

/**
 * Gets all the data from json files in the /data/ directory.
 *
 * @return array An array of all the data from the various json files.
 */
function get_data() : array {
	$data = [];

	foreach ( glob( DATA_DIR . '*.json' ) as $datasrc ) {
		$dataset = json_decode( file_get_contents( $datasrc ), true );
		$data    = array_merge( $data, $dataset );
	}

	return $data;
}

/**
 * Get a template file to load on the page.
 *
 * @param string $template_name (Required) The slug of the template file.
 */
function get_template( string $template_name ) {
	$template_path = TEMPLATES_DIR . "$template_name.php";

	if ( file_exists( $template_path ) ) {
		require_once $template_path;
	}
}
