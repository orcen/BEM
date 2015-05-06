module.exports = function(grunt) {

    // 1. All configuration goes here
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        watch: {
            options: {
                spawn: false,
                debounceDelay: 250,
            },
            sass: {
              files: [
                'css/**/*.scss'
              ],
              tasks: ['sass']
            },
            js: {
                files: [
                    'js/**/*.js'
                ],
                tasks: ['jshit','concat']
            },
            configFiles: {
                files: [ 'Gruntfile.js', 'config/*.js' ],
                options: {
                    reload: true
                }
            }

        },
        sass: {                              // Task
            dist: {                            // Target
                files: {                         // Dictionary of files
                    'dist/css/style.css': 'css/style.scss',       // 'destination': 'source'
                }
            }
        },
        cssmin: {
            concat : {

            },
            minimize : {
                files: {
                    'dist/css/style.min.css' : 'dist/css/style.css'
                }
            }
        },
        imagemin: {
            dynamic: {
                files: [{
                    expand: true,                  // Enable dynamic expansion
                    cwd: 'dist/',                   // Src matches are relative to this path
                    src: ['**/*.{png,jpg,gif}'],   // Actual patterns to match
                    dest: 'dist/'                  // Destination path prefix
                }]
            }
        },
        concat: {
            js: {
                src: [
                    'js/jquery.js',
                    //'dev/js/jquery.supersized/js/supersized.core.3.2.1.min.js',
                    'js/jquery.fancybox/jquery.fancybox.pack.js',
                    //'dev/js/skrollr.js',
                    'js/customScroll/jquery.mousewheel-3.0.6.js',
                    //'dev/js/customScroll/jquery.mCustomScrollbar.js',
                    //'dev/js/jquery.bxslider/jquery.bxslider.min.js',

                    'js/default.dev.js',
                    '!js/modernizr.js'
                ],
                dest: 'dist/js/default.js',
            },
            jscss: {
                src: [
                    'js/jquery.fancybox/jquery.fancybox.css'
                ],
                dest: 'js/jquery.css'
            }
        },
        jshint: {
          files: ['js/default.dev.js'],
          options: {
            globals: {
              jQuery: true,
              console: true,
              module: true
              }
              }
        },
        uglify: {
          build: {
            src: 'dist/js/default.js',
            dest: 'dist/js/default.ugl.js'
          }
        }
    });
    /*
    grunt.event.on('watch', function(action, filepath, target) {
      grunt.log.writeln(target + ': ' + filepath + ' has ' + action);
    }); */

    // 3. Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jshint');

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-imagemin');


    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['sass','jshint', 'concat', 'watch']);
    grunt.registerTask('dist', ['sass', 'cssmin', 'uglify', 'imagemin']);
    grunt.registerTask('exit', 'Just exits.', function() { process.exit(0); });

};
