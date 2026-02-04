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
    .sourceMaps()      // добавить app.js.map файл
    .extract(['vue'])  // изоляция vue от изменений в JS
    .version()
    .sass('resources/sass/app.scss', 'public/css');

  // поддержка автоматической синхронизации в браузере
// mix.browserSync('sync.test');
  // создание микса js
// mix.scripts(['first.js', 'second.js'], 'all.js');
  // создание микса js с поддержкой синтаксиса ES2015 (babel)
// mix.babel(['first.js', 'second.js'], 'all.js');
  // поддержка логики и модулей React
// mix.react('app.jsx', 'public/js');


// преобразование файлов less, если они есть, в готовые css
// mix.less('path.less', 'public/css/less.css')
//    .less('path2.less', 'public/css/less2.css');

// создание одного css файла из двух своих css файлов
// mix.styles(['first.css', 'second.css'], 'public/css/all.css');
