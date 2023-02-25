const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js").css(
    "resources/css/app.css",
    "public/css"
);

/// Adminr System Related Assets
mix.js("adminr/Core/resources/js/adminr-core.js", "public/adminr/js")
    .vue()
    .sass("adminr/Core/resources/sass/adminr-core.scss", "public/adminr/css");
