<?php
/**
 * Current Question and Level
 *
 * @package Question-Game
 * @author Chris Reynolds <chris@jazzsequence.com>
 * @version 0.1.0
 */

namespace Game;

$level = get_level_name( get_current_level() );
$class = get_level_class( get_current_level() );
?>
<div class="level-question">
	<p>
		<span class="nes-text <?php echo $class; ?>"><?php echo get_level_name( get_current_level() ); ?></span>
	</p>
</div>
