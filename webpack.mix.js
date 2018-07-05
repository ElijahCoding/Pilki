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

mix.js('resources/assets/js/users/app.js', 'public/js/users')
   .sass('resources/assets/sass/users/app.scss', 'public/css/users');

mix.js('resources/assets/js/crm/app.js', 'public/js/crm')
    .sass('resources/assets/sass/crm/app.scss', 'public/css/crm');
