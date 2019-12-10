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
