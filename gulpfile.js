const gulp = require('gulp'),
      sass = require('gulp-sass')(require('sass')),
      fs = require('fs'),
      path = require('path');

// Simple clean function using fs
function clean(done) {
  const filePath = path.join(__dirname, 'src/assets/css/styles.css');
  fs.unlink(filePath, (err) => {
    if (err) {
      // If the file does not exist, handle the error gracefully
      if (err.code === 'ENOENT') {
        console.log('File does not exist, skipping deletion.');
        done();
      } else {
        done(err);
      }
    } else {
      console.log('Successfully deleted file.');
      done();
    }
  });
}

gulp.task('nes.css', () => {
	return gulp.src('vendor/jazzsequence/nes.css/scss/nes.scss')
		.pipe(sass().on('error', sass.logError))
		.pipe(gulp.dest('src/assets/css/'));
});

gulp.task('styles', () => {
  return gulp.src('src/assets/sass/**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./src/assets/css/'));
});

gulp.task('clean', clean);

gulp.task('build', gulp.series(['clean', 'nes.css', 'styles']));

gulp.task('watch', () => {
  gulp.watch('src/assets/sass/**/*.scss', (done) => {
    gulp.series(['clean', 'styles'])(done);
  });
});
