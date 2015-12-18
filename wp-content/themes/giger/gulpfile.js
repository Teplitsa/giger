//paths for source and bundled parts of app
var basePaths = {
    src: 'src/',
    dest: 'assets/',
    bower: 'bower_components/'
};

//require plugins
var gulp = require('gulp');

var es          = require('event-stream'),
    gutil       = require('gulp-util'),
    mainBower   = require('main-bower-files'),
    bourbon     = require('node-bourbon'),
    path        = require('relative-path'),
    runSequence = require('run-sequence'),
    del         = require('del'),
    async       = require('async');

require('events').EventEmitter.prototype._maxListeners = 100; //increase limit for listener number for async tool

//plugins - load gulp-* plugins without direct calls
var plugins = require("gulp-load-plugins")({
    pattern: ['gulp-*', 'gulp.*'],
    replaceString: /\bgulp[\-.]/
});

//env - call gulp --prod to go into production mode
var sassStyle = 'expanded'; // SASS syntax
var sourceMap = true; //wheter to build source maps
var isProduction = false; //mode flag

if(gutil.env.prod === true) {
    isProduction = true;
    sassStyle = 'compressed';
    sourceMap = false;
}

//log
var changeEvent = function(evt) {
    gutil.log('File', gutil.colors.cyan(evt.path.replace(new RegExp('/.*(?=/' + basePaths.src + ')/'), '')), 'was', gutil.colors.magenta(evt.type));
};

//js
//js
gulp.task('build-js', function() {
    var vendorFiles = mainBower({ //files from bower_components
            paths: {
                bowerDirectory: basePaths.bower,
                bowerJson: 'bower.json'
            }
        }),
        appFiles = [basePaths.src+'js/*']; //our own JS files

    return gulp.src(vendorFiles.concat(appFiles)) //join them
        .pipe(plugins.filter('*.js'))//select only .js ones
        .pipe(plugins.concat('bundle.js'))//combine them into bundle.js
        .pipe(isProduction ? plugins.uglify() : gutil.noop()) //minification
        .pipe(plugins.size()) //print size for log
        .on('error', console.log) //log
        .pipe(gulp.dest(basePaths.dest+'js')) //write results into file
});

//sass
gulp.task('build-css', function(done) {

    //paths for mdl and bourbon
    var paths = require('node-bourbon').includePaths,
        mdl = path('./bower_components/material-design-lite/src'),
        vendorFiles = gulp.src('bower_components/animate.css/animate.css'),
        keys = ['default', 'pink', 'black', 'orange', 'purple'], //prefixes for color schemes
        cssTasks = new Array();
        
        paths.push(mdl);
    
    for(var i = 0; i < keys.length; i++ ){ //build array of tasks
        
        cssTasks.push(function(){ //run SASS compilation for each -main.scss file separately
            var srcFile  = keys[i]+'-main.scss',
                destFile = keys[i]+'-bundle.css';
            
            return function (callback){
                var appFiles = gulp.src(basePaths.src+'sass/'+ srcFile) //our main file with @import-s
                        .pipe(!isProduction ? plugins.sourcemaps.init() : gutil.noop())  //process the original sources for sourcemap
                        .pipe(plugins.sass({
                                outputStyle: sassStyle, //SASS syntas
                                includePaths: paths //add bourbon + mdl
                            }).on('error', plugins.sass.logError))//sass own error log
                        .pipe(plugins.autoprefixer({ //autoprefixer
                                browsers: ['last 4 versions'],
                                cascade: false
                            }))
                        .pipe(!isProduction ? plugins.sourcemaps.write() : gutil.noop()) //add the map to modified source
                        .on('error', console.log);
                        
                es.concat(appFiles, vendorFiles) //combine vendor CSS files and our files after-SASS
                    .pipe(plugins.concat(destFile)) //combine into file
                    .pipe(isProduction ? plugins.cssmin() : gutil.noop()) //minification on production
                    .pipe(plugins.size()) //display size
                    .pipe(gulp.dest(basePaths.dest+'css')) //write file
                    .on('error', console.log)
                    .on("end", callback);
            }
        }());
    }

    async.parallel(cssTasks, done);
});

gulp.task('build-admin-css', function() {
    
    var paths = require('node-bourbon').includePaths,
        appFiles = gulp.src(basePaths.src+'sass/admin.scss')
        .pipe(!isProduction ? plugins.sourcemaps.init() : gutil.noop())  //process the original sources for sourcemap
        .pipe(plugins.sass({
                outputStyle: sassStyle, //SASS syntas
                includePaths: paths //add bourbon + mdl
            }).on('error', plugins.sass.logError))//sass own error log
        .pipe(plugins.autoprefixer({ //autoprefixer
                browsers: ['last 4 versions'],
                cascade: false
            }))
        .pipe(!isProduction ? plugins.sourcemaps.write() : gutil.noop()) //add the map to modified source
        .on('error', console.log); //log
        
    return appFiles
        .pipe(plugins.concat('admin.css')) //combine into file
        .pipe(isProduction ? plugins.cssmin() : gutil.noop()) //minification on production
        .pipe(plugins.size()) //display size
        .pipe(gulp.dest(basePaths.dest+'css')) //write file
        .on('error', console.log); //log
});

//revision
gulp.task('revision-clean', function(){
    // clean folder https://github.com/gulpjs/gulp/blob/master/docs/recipes/delete-files-folder.md
    return del([basePaths.dest+'rev/**/*']);
});

gulp.task('revision', function(){    
    
    return gulp.src([basePaths.dest+'css/*.css', basePaths.dest+'js/*bundle.js'])
        .pipe(plugins.rev())
        .pipe(gulp.dest( basePaths.dest+'rev' ))
        .pipe(plugins.rev.manifest())        
        .pipe(gulp.dest(basePaths.dest+'rev')) // write manifest to build dir        
        .on('error', console.log); //log   
});


//builds
gulp.task('full-build', function(callback) {
    runSequence('build-css',
        'build-admin-css',
        'build-js',
        'revision-clean',
        'revision',
        callback);
});

gulp.task('full-build-css', function(callback) {
    runSequence('build-css',
        'build-admin-css',
        'revision-clean',
        'revision',
        callback);
});

gulp.task('full-build-js', function(callback) {
    runSequence('build-js',
        'revision-clean',
        'revision',
        callback);
});


//svg - combine and clear svg assets
gulp.task('svg-opt', function() {
    
    var icons = gulp.src([basePaths.src+'svg/icon-*.svg', basePaths.src+'svg/plain-*.svg'])
        .pipe(plugins.cheerio({ 
            run: function ($) { //remove fill from icons
                $('[fill]').removeAttr('fill');
                $('[fill-rule]').removeAttr('fill-rule');
            },
            parserOptions: { xmlMode: true }
        })),
        pics = gulp.src([basePaths.src+'svg/pic-*.svg']);
    
    return es.concat(icons, pics)         
        .pipe(plugins.svgmin({
            plugins: [{
                removeComments: true
            }]
        })) //minification
        .pipe(plugins.svgstore({ inlineSvg: true })) //combine for inline usage
        .pipe(gulp.dest(basePaths.dest+'svg'));    
});

//watchers
gulp.task('watch', function(){
    gulp.watch([basePaths.src+'sass/*.scss', basePaths.src+'sass/**/*.scss'], ['full-build-css']).on('change', function(evt) {
        changeEvent(evt);
    });
    gulp.watch(basePaths.src+'js/*.js', ['full-build-js']).on('change', function(evt) {
        changeEvent(evt);
    });
});


//default
gulp.task('default', ['full-build', 'watch']);