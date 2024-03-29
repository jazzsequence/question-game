<?php
/**
 * Question Game Bootstrap
 *
 * Sets up the infrastructure for the game files.
 *
 * @package Question-Game
 * @author Chris Reynolds <chris@jazzsequence.com>
 * @version 0.1.0
 */

namespace Game;

define( 'ROOT_DIR', dirname( __DIR__ ) );
define( 'SRC_DIR', ROOT_DIR . '/src/' );
define( 'INC_DIR', SRC_DIR . 'inc/' );
define( 'DATA_DIR', SRC_DIR . 'data/' );
define( 'TEMPLATES_DIR', SRC_DIR . 'templates/' );
define( 'ASSETS_PATH', __DIR__ . '/assets/' );
define( 'NES_CSS', '/assets/css/' );

/**
 * Run initialization stuff.
 */
function init() {
	if ( ! get_cookie() ) {
		update_cookie();
	}

	get_template( 'organisms/main' );
	process_query_strings();
}
