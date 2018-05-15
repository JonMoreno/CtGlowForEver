let laravel_mix = require('laravel-mix');
process.env.MIX_SENTRY_DSN_PUBLIC;
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

laravel_mix.js('resources/assets/js/app.js','public/js/app.js')
           .sass( 'resources/assets/sass/app.scss', 'public/css')
           .sass( 'resources/assets/sass/welcome.scss', 'public/css')
           .sass( 'resources/assets/sass/transitions.scss', 'public/css')
           .sass( 'resources/assets/sass/calendar.scss', 'public/css');
