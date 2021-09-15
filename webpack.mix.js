const  mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */


mix.styles([
    'resources/assets/css/main.css',
    'resources/assets/css/bootstrap.min.css',
    'resources/assets/css/bootstrap-select.css ',
],'public/test/css/all.css');

mix.scripts([
    'resource/assets/js/jquery-3.5.1.js',
    'resource/assets/js/bootstrap.bundle.min.js',
    'resource/assets/js/bootstrap-select.min.js',
    'resource/assets/js/bootstrap.js'
    ],
    'public/test/js/all.js');










