const mix = require('laravel-mix');
const path = require('path');

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

mix.react('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .options({ processCssUrls: false });

mix.webpackConfig({
  resolve: {
    alias: {
      '@components': path.resolve(__dirname, 'resources/js/components/'),
      '@fonts': path.resolve(__dirname, 'public/fonts/'),
      '@theme': path.resolve(__dirname, 'resources/js/theme/')
    }
  }
});
