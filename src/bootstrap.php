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

define( 'ROOT_DIR', dirname( __DIR__ ) . '/' );
define( 'SRC_DIR', __DIR__ . '/' );
define( 'INC_DIR', SRC_DIR . '/inc/' );

require_once INC_DIR . 'functions.php';
