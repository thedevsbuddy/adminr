let mix = require('laravel-mix');

mix.js('resources/js/adminr-engine.js', 'resources/assets/js')
    .vue()
    .sass('resources/sass/adminr-engine.scss', 'resources/assets/css');
    // .sass('resources/sass/coreui.scss', 'resources/assets/coreui/css');
