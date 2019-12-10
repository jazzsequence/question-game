<?php
/**
 * Main wrapper template
 * 
 * Renders the contents of the page and calls in additional templates.
 * 
 * @package Question-Game
 * @author Chris Reynolds <chris@jazzsequence.com>
 * @version 0.0
 */

namespace Game;

get_head();
?>

<div class="question-game main">
	<div class="nes-container nes-text is-primary">
		<p>This game uses cookies to store information. Please make sure your browser is able to save cookies and click the New Game button to start a new session.</p>
	</div>

	<div class="new-game">
		<button type="button" class="nes-btn is-primary new-game">New Game</button>
	</div>

	<!-- Stuff goes here. -->

</div>

<?php
get_footer();
