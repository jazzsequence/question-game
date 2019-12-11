/**
 * .config/webpack.config.prod.js
 * This file defines the production build configuration
 */
const { helpers, externals, presets } = require( '@humanmade/webpack-helpers' );
const { choosePort, cleanOnExit, filePath } = helpers;

// Clean up manifests on exit.
cleanOnExit( [
	filePath( 'build/asset-manifest.json' )
] );

module.exports = choosePort( 8080 ).then( port => [
	presets.development( {
		devServer: {
			port,
		},
		externals,
		entry: {
			main: filePath( 'assets/js/main.js' ),
		},
		output: {
			path: filePath( 'build' ),
			publicPath: `https://localhost:${ port }/`
		},
 	} ),
] );
