let mix = require('laravel-mix');

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

mix.sass('resources/assets/sass/all.scss', 'public/css')
mix.js([
    'resources/assets/js/bootstrap.js',
    'resources/assets/js/bundle.js',
    'resources/assets/js/peer.js',
    'resources/assets/js/app.js',
], 'public/js/app.js');
