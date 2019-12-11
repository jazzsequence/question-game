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
 * Get the levels set in the project.
 *
 * @return array An array of levels and their numeric value.
 */
function get_levels() : array {
	$data   = DATA_DIR . 'manifest.json';
	$levels = [];

	if ( file_exists( $data ) ) {
		$levels = (array) json_decode( file_get_contents( $data ) )->levels;
	}

	return $levels;
}

/**
 * Returns the data for a given level by level value if a value exists. Returns false if no level exists for that value.
 *
 * @param int $level The numeric level value.
 * @return mixed     False if no level exists for the value passed. Otherwise, returns the level data for the requested level.
 */
function get_level( int $level ) {
	$levels = get_levels();

	// Make sure the level passed is not greater than the max level in the data.
	if ( $level > get_max_level( $levels ) ) {
		return [ 'Game over' ];
	}

	// Get the level name from the levels array.
	$level_name = array_search( $level, $levels );

	return get_level_data( $level_name );
}

/**
 * Returns the data for the requested level by level name.
 *
 * @param string $level The level by level name. Must match an existing .json file.
 *
 * @return array        An array of level data.
 */
function get_level_data( string $level ) : array {
	$src  = DATA_DIR . "$level.json";
	$data = [];

	if ( file_exists( $src ) ) {
		$data = json_decode( file_get_contents( $src ) );
	}

	return $data;
}

/**
 * Returns the highest possible level value.
 * 
 * Since the values are always stored as integers, we should always get back an integer, but it's possible that a false might be returned if an empty array was passed.
 * 
 * @param array $levels The array of levels to check.
 * @return int          The max numeric level.
 */
function get_max_level( array $levels ) : int {
	return max( array_values( $levels ) );
}

/**
 * Get the maximum number of questions for a given level.
 *
 * @param int $level The level in int format.
 * @return int       The number of questions for that level.
 */
function get_max_questions_for_level( int $level ) : int {
	$data       = DATA_DIR . 'manifest.json';
	$level_name = array_search( $level, get_levels() );
	$questions  = 0;

	if ( $level_name && file_exists( $data ) ) {
		$questions_per_level = json_decode( file_get_contents( $data ) );
		$questions           = $questions_per_level[ $level_name ];
	}

	return $questions;
}

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

/**
 * Returns the URL path to the assets directory or, optionally, a specific file inside the assets directory.
 *
 * @param string $file   (Optional) A specific file inside the assets directory.
 * @param string $assets (Optional) Path override to the directory with the assets.
 *
 * @return string
 */
function assets_url( string $file = '', string $assets = '' ) : string {
	$domain = '';
	$assets = empty( $assets ) ? '/src/assets/' : $assets;

	if ( ! empty( $_SERVER['REQUEST_URI'] ) ) {
		$domain = str_replace( 'index.php', '', $_SERVER['REQUEST_URI'] );
	}
	// If the file param was empty or the file passed doesn't exist, return the path to the assets dir.
	if (
		(
			! $assets ||
			! file_exists( "$assets/$file" )
		) && ( 
			empty( $file ) || 
			! file_exists( ASSETS_PATH . "/$file" ) 
		) ) {
		return $domain . ASSETS_PATH;
	}

	return $domain . $assets . $file;
}

/**
 * Checks if a cookie is set and returns it if it exists. Otherwise returns false if no cookie exists.
 */
function get_cookie() {
	if ( ! isset( $_COOKIE['qst_game'] ) ) {
		return false;
	}

	return $_COOKIE['qst_game'];
}

/**
 * Deletes a game cookie.
 */
function delete_cookie() {
	setcookie( 'qst_game', 0, 1, '/' );
}

/**
 * Updates/sets a game cookie.
 *
 * @param int $level     The level to set the cookie to. If no cookie exists, it initializes at level 0.
 * @param int $questions The questions to set the cookie to. If the game hasn't started yet, initializes to 0 questions.
 */
function update_cookie( int $level = 0, int $questions = 0 ) {
	setcookie( 'qst_game', [
		'level'     => $level,
		'questions' => $questions
	], strtotime( '+1 day' ), '/' );
}

/**
 * Returns a random question.
 */
function get_question() {}

/**
 * Output the head section of the page.
 *
 * @param string $title (Optional) A page title to display in the browser window/tab.
 */
function get_head( string $title = '' ) {
	$title = ! empty( $title ) ? $title : 'Question Game';
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $title; ?></title>
		<link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<?php echo assets_url( 'nes.min.css', NES_CSS ); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo assets_url( 'css/style.css' ); ?>">
	</head>
	<body>
	<?php
}

/**
 * Output the footer section of the page.
 */
function get_footer() {
	?>
	<script src="<?php echo assets_url( 'js/main.js' ); ?>"></script>
	</body>
	</html>
	<?php
}
