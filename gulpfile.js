const gulp = require( 'gulp' ),
	sass = require( 'gulp-sass' ),
	del = require( 'del' );

gulp.task( 'styles', () => {
	return gulp.src( 'src/assets/sass/**/*.scss' )
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe( gulp.dest( './src/assets/css/' ) );
} );

gulp.task( 'clean', () => {
	return del( [
		'src/assets/css/style.css',
	] );
} );

gulp.task( 'default', gulp.series( [ 'clean', 'styles' ] ) );