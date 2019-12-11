/* globals require */
/**
 * Question Game javascript
 *
 * Handles all the (very basic) javascript needed to display the game.
 */
const qstGameInit = () => {
	const alert = document.querySelector( '.cookie-alert' );
	const alertBtn = document.querySelector( 'button.cookie-confirm' );
	const cookie = qstGameGetCookie();

	console.log( eval( `(${cookie})` ) );

	alertBtn.addEventListener( 'click', () => {
		alert.style.display = 'none';
	} );
}

const qstGameGetCookie = () => {
	const value = '; ' + document.cookie;
	const parts = value.split( '; qst_game=' );
	if ( parts.length == 2 ) {
		return parts.pop()
			.split( ';' )
			.shift();
	}
}

const qstGameUpdateCookie = ( cookie ) => {

}

qstGameInit();
