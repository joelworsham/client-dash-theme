'use strict';
module.exports = function (grunt) {

    // load all grunt tasks
    require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

    grunt.initConfig({

        // Define watch tasks
        watch: {
            options: {
                livereload: true
            },
            sass: {
                files: ['./assets/scss/**/*.scss', '!./assets/scss/backend/*.scss'],
                tasks: ['sass:dist', 'autoprefixer']
            },
            backend: {
                files: ['./assets/scss/backend/*.scss'],
                tasks: ['sass:backend']
            },
            js: {
                files: ['./assets/js/source/*.js'],
                tasks: ['uglify:dist']
            },
            jsbackend: {
                files: ['./assets/js/source/backend/*.js'],
                tasks: ['uglify:backend']
            },
            jsdeps: {
                files: ['./assets/js/source/deps/*.js'],
                tasks: ['uglify:deps']
            },
            livereload: {
                files: ['./**/*.html', './**/*.php', './assets/images/**/*.{png,jpg,jpeg,gif,webp,svg}']
            }
        },

        // SASS
        sass: {
            options: {
                sourcemap: 'none'
            },
            dist: {
                options: {
                    style: 'compressed'
                },
                files: {
                    './assets/css/client-dash-theme-frontend.min.css': './assets/scss/frontend.scss'
                }
            },
            backend: {
                options: {
                    style: 'compressed'
                },
                files: {
                    './assets/css/client-dash-theme-backend.min.css': './assets/scss/backend/backend.scss'
                }
            }
        },

        // Auto prefix our CSS with vendor prefixes
        autoprefixer: {
            dist: {
                expand: true,
                flatten: true,
                src: './assets/css/**/*.css',
                dest: './assets/css',
                options: {
                    browsers: ['last 2 version', 'ie 8', 'ie 9']
                }
            }
        },

        // Uglify and concatenate
        uglify: {
            dist: {
                files: {
                    './assets/js/client-dash-theme.min.js': [
                        './assets/js/source/*.js'
                    ]
                }
            },
            backend: {
                files: {
                    './assets/js/client-dash-theme-backend.min.js': [
                        './assets/js/source/backend/*.js'
                    ]
                }
            },
            deps: {
                files: {
                    './assets/js/client-dash-theme-deps.min.js': [
                        './assets/js/source/deps/*.js'
                    ]
                }
            }
        }

    });

    // Register our main task
    grunt.registerTask('Watch', ['watch']);

};