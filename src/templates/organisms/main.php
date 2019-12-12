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
	<?php if ( show_cookie_alert() ) : ?>
		<?php get_template( 'molecules/cookie-alert' ); ?>
	<?php endif; ?>

	<div class="nes-container with-title is-dark">
		<h2 class="title"><?php render_name(); ?></h2>

		<?php get_template( 'molecules/question' ); ?>
	</div>

	<?php get_template( 'molecules/new-game' ); ?>
</div>

<?php
get_footer();
