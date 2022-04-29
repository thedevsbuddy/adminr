const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/coreui/coreui.scss', 'public/adminr/css')
    .sass('resources/sass/app.scss', 'public/css');
