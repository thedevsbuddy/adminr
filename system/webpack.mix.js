const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/adminr/js")
    .vue()
    .sass("resources/sass/app.scss", "public/adminr/css");
