/**
 * Question Game javascript
 *
 * Handles all the (very basic) javascript needed to display the game.
 */
const qstGameInit = () => {
	const alert = document.querySelector( '.cookie-alert' );
	const alertBtn = document.querySelector( 'a.cookie-confirm' );

	// Bail if the alert isn't rendered.
	if ( ! alert || ! alertBtn ) {
		return;
	}

	alertBtn.addEventListener( 'click', () => {
		alert.style.display = 'none';
	} );
};

qstGameInit();
