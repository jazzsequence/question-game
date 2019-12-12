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
 * Return the name of the game, if defined.
 *
 * @return string The name of the game as defined in the manifest, or just Game.
 */
function get_name() : string {
	$data = DATA_DIR . 'manifest.json';
	$name = 'Game';

	if ( file_exists( $data ) ) {
		$name = empty( json_decode( file_get_contents( $data ) )->name ) ? $name : json_decode( file_get_contents( $data ) )->name;
	}

	return $name;
}

/**
 * Outputs the name of the game.
 */
function render_name() {
	echo get_name();
}

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
 * Gets the level name from the levels array.
 *
 * @param  int $level The numeric level value.
 * @return mixed False if no level exists for the value passed. Otherwise, returns the level data for the requested level.
 */
function get_level_name( int $level ) {
	$levels = get_levels();

	return array_search( $level, $levels );
}

/**
 * Returns the data for a given level by level value if a value exists. Returns false if no level exists for that value.
 *
 * @param int $level The numeric level value.
 * @return mixed     False if no level exists for the value passed. Otherwise, returns the level data for the requested level.
 */
function get_level( int $level ) {
	// Make sure the level passed is not greater than the max level in the data.
	if ( $level > get_max_level() ) {
		delete_cookie();
		return [ 'Game over' ];
	}

	// Get the level name from the levels array.
	$level_name = get_level_name( $level );

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
 * @return int          The max numeric level.
 */
function get_max_level() : int {
	$levels = get_levels();
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
		$questions_per_level = json_decode( file_get_contents( $data ) )->questions;
		$questions           = $questions_per_level->$level_name;
	}

	return $questions;
}

/**
 * Check if we're at or exceeding the max level.
 *
 * @return bool True if we're at the max level. False if we aren't.
 */
function is_max_level() : bool {
	$max_level     = get_max_level();
	$current_level = get_current_level();

	if ( $current_level > $max_level ) {
		return true;
	}

	return false;
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
 * Checks for a query string and returns it, parsed as an array, if it exists.
 *
 * @return false|array False if no query string exists. Otherwise parses the query string into an array.
 */
function get_query_string() {
	if ( ! isset( $_SERVER['QUERY_STRING'] ) ) {
		return false;
	}

	parse_str( $_SERVER['QUERY_STRING'], $args );

	return $args;
}

/**
 * Strip query args from a URL.
 *
 * @param string $url A valid URL.
 * @return string     The URL with query variables removed.
 */
function strip_query_args( string $url ) : string {
	$query_string = $_SERVER['QUERY_STRING'];
	return str_replace( "?$query_string", '', $url );
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
		$domain = str_replace( '/index.php', '', $_SERVER['REQUEST_URI'] );

		// If there's a query string in the URL, strip it out.
		if ( ! empty( get_query_string() ) ) {
			$domain = strip_query_args( $domain );
		}
	}

	// Check to make sure the file exists.
	if ( empty( $file ) || ! file_exists( ROOT_DIR . "/$assets/$file" ) ) {
		return '';
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
	setcookie( 'qst_game', serialize( [
		'level'     => $level,
		'questions' => $questions,
	] ), strtotime( '+1 day' ), '/' );
}

/**
 * Returns the current level as an integer based on the cookie.
 * Updates the level from a 0 state if a new game has started.
 *
 * @return mixed The current level as an int. False if the game hasn't started
 */
function get_current_level() {
	$cookie   = unserialize( get_cookie() );
	$level    = isset( $cookie['level'] ) ? $cookie['level'] : false;

	// If the cookie is set to level 0, we're starting a new game. Set the level to 1.
	if ( 0 === $level ) {
		$level++;
		update_cookie( $level );
	}

	return $level ?: false;
}

/**
 * Returns the current question based on the cookie.
 *
 * @return mixed The current question that has been displayed. False if the game hasn't started & the cookie hasn't been set.
 */
function get_current_question() {
	$cookie = unserialize( get_cookie() );
	return isset( $cookie['questions'] ) ? $cookie['questions'] : false;
}

/**
 * Returns a random question.
 */
function get_question() {
	$level          = get_current_level();
	$question_count = get_current_question();

	// Increment the question counter.
	$question_count++;

	if ( $question_count > get_max_questions_for_level( $level ) ) {
		$level = level_up( $level );
	} else {
		// Don't update the cookie if we're just acknowledging cookies.
		if ( empty( get_query_string() ) || ( get_query_string() && ! key_exists( 'cookie_accept', get_query_string() ) ) ) {
			update_cookie( $level, $question_count );
		}
	}

	$questions = get_level( $level );

	if ( ! empty( $questions ) ) {
		// Randomize the questions array.
		shuffle( $questions );

		return $questions[0];
	}

	return 'Start new game.';
}

/**
 * Process a level up.
 *
 * @param int $old_level The original level that we want to increase.
 * @return int           The new level.
 */
function level_up( int $old_level ) : int {
	delete_cookie();

	// Update the cookie with the next level as long as we haven't hit the max.
	if ( ! is_max_level() ) {
		$level    = $old_level + 1;
		$question = 0;

		update_cookie( $level, $question );
	} else {
		$level = 0;
	}

	return $level;
}

/**
 * Handle processing of URL query strings.
 */
function process_query_strings() {
	$query_string = get_query_string();

	// If the next level button was clicked, immediately do a level-up.
	if ( key_exists( 'next', $query_string ) && $query_string['next'] === 'level' ) {
		$current_level = get_current_level();
		level_up( $current_level );
	}

	// If the cookie alert was accepted, store a new cookie so it goes away.
	if ( key_exists( 'cookie_accept', $query_string ) ) {
		process_cookie_notif();
	}

	// If the new game button was clicked, start over.
	if ( key_exists( 'new_game', $query_string ) ) {
		delete_cookie();
	}
}

/**
 * Sets a cookie to hide the alert.
 */
function process_cookie_notif() {
	setcookie( 'qst_cookie_ok', 1, strtotime( '+1 year' ), '/' );
	header( 'Refresh:0' );
}

/**
 * Determine if the alert should be displayed based on whether a cookie exists.
 *
 * @return bool True if we should show the alert. False otherwise.
 */
function show_cookie_alert() {
	// No cookie has been set for the alert, so show the notice.
	if ( ! isset( $_COOKIE['qst_cookie_ok'] ) ) {
		return true;
	}

	// We've already seen the alert and don't need to see it again.
	return false;
}

/**
 * Output the head section of the page.
 */
function get_head() {
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php render_name() ?></title>
		<link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<?php echo assets_url( 'nes.min.css', NES_CSS ); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo assets_url( 'css/styles.css' ) . '?ver=' . time(); ?>">
	</head>
	<body class="nes-container is-dark">
	<?php
}

/**
 * Output the footer section of the page.
 */
function get_footer() {
	?>
	<script src="<?php echo assets_url( 'serialize-javascript/index.js', '/node_modules/' ); ?>"></script>
	<script src="<?php echo assets_url( 'js/main.js' ); ?>"></script>
	</body>
	</html>
	<?php
}

/**
 * Render any kind of button.
 *
 * Note: This is not a button by the strictest sense, but, rather, a link styled to look like a button.
 *
 * @param string $text    (Required) The text inside the button.
 * @param string $link    (Required) The URL to link to.
 * @param array  $classes (Optional) An array of classes for the button. By default, all buttons will have the nes-btn class.
 */
function render_button( string $text, string $link, array $classes = [] ) {
	$classlist = implode( ' ', array_merge( $classes, [ 'nes-btn' ] ) );
	$link_tag  = "<a class=\"$classlist\" href=\"$link\">$text</a>";

	echo $link_tag;
}

/**
 * Output the accept cookie button.
 */
function render_cookie_button() {
	render_button( 'Okay', '?cookie_accept=true', [ 'cookie-confirm' ] );
}

/**
 * Output the new game button.
 */
function render_new_game_button() {
	render_button( 'New Game', '?new_game=true', [ 'is-primary', 'new-game' ] );
}

/**
 * Output a next question button.
 */
function render_next_question_button() {
	$classes = [ 'is-success' ];
	$url     = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http' ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	if ( is_max_level() ) {
		$classes[] = 'is-disabled';
	}

	render_button( 'Next', strip_query_args( $url ), [ 'is-success' ] );
}

/**
 * Output a next level button.
 */
function render_next_level_button() {
	$classes = [ 'is-warning' ];

	// Set the button to appear disabled if we've reached the max level.
	if ( is_max_level() ) {
		$classes[] = 'is-disabled';
	}
	render_button( 'Next Level', '?next=level', $classes );
}

/**
 * Return a text color class based on a level.
 *
 * @param int $level The current level.
 * @return string    The class to represent that level.
 */
function get_level_class( int $level ) : string {
	switch ( $level ) {
		case 1:
			return 'is-success';
		case 2:
			return 'is-warning';
		case 3:
		case 4:
			return 'is-error';
		default:
			return 'is-primary';
	}
}
