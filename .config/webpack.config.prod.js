/**
 * .config/webpack.config.prod.js
 * This file defines the production build configuration
 */
const { helpers, externals, presets } = require( '@humanmade/webpack-helpers' );
const { filePath } = helpers;

module.exports = presets.production( {
	externals,
	entry: {
		main: filePath( 'src/assets/js/main.js' ),
	},
	output: {
		path: filePath( 'build' ),
	},
 } );
 