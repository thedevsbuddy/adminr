const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js").css(
    "resources/css/app.css",
    "public/css"
);

/// Adminr System Related Assets
mix.js("system/resources/js/system.js", "public/adminr/js")
    .vue()
    .sass("system/resources/sass/system.scss", "public/adminr/css");
