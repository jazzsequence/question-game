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
define( 'ASSETS_PATH', dirname( __FILE__ ) . '/assets/' );
define( 'NES_CSS', 'node_modules/nes.css/css/' );

/**
 * Run initialization stuff.
 */
function init() {
	// check if database table exists, if not, create database table.
}
