<?php
/**
 * Question template
 * 
 * Template wrapper for questions.
 * 
 * @package Question-Game
 * @author Chris Reynolds <chris@jazzsequence.com>
 * @version 0.1.0
 */

namespace Game;

$question = get_question();
?>
<div class="question">
	<p>
		<?php echo $question; ?>
	</p>
</div>
