// модуль Node laravel-mix
const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

// преобразование файлов less, если они есть, в готовые css
// mix.less('path.less', 'public/css/less.css')
//    .less('path2.less', 'public/css/less2.css');

// создание одного css файла из двух своих css файлов
// mix.styles(['first.css', 'second.css'], 'public/css/all.css');
