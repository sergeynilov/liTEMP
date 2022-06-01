const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

const path = require('path')

mix.webpackConfig({
    resolve: {
        alias: {
            ziggy: path.resolve('vendor/tightenco/ziggy/dist/vue'),
            '@Layouts': path.resolve(__dirname, 'resources/js/Layouts')
        },
    },
});

module.exports = {
    module: {
        rules: [
            {
                test: /\.svg$/,
                use: [
                    'vue-loader',
                    'vue-svg-loader',
                ],
            },
        ],
    },
};

mix
    /* CSS */
    .sass('resources/sass/main.scss', 'public/css/oneui.css')
    .sass('resources/sass/css.scss', 'public/css/main.css')
    .sass('resources/sass/frontend.scss', 'public/css/frontend.css')
    .sass('resources/sass/oneui/themes/amethyst.scss', 'public/css/themes/')
    .sass('resources/sass/oneui/themes/city.scss', 'public/css/themes/')
    .sass('resources/sass/oneui/themes/flat.scss', 'public/css/themes/')
    .sass('resources/sass/oneui/themes/modern.scss', 'public/css/themes/')
    .sass('resources/sass/oneui/themes/smooth.scss', 'public/css/themes/')

    /* JS */
    .js('resources/js/app.js', 'public/js/laravel.app.js')
    .js('resources/js/oneui/app.js', 'public/js/oneui.app.js')

    .js('resources/js/frontend_app.js', 'public/js').vue()

    /* Page JS */
    .js('resources/js/pages/tables_datatables.js', 'public/js/pages/tables_datatables.js')

    /* Tools */
    // .browserSync('localhost:8000')
    // .disableNotifications()

    /* Options */
    .options({
        processCssUrls: false
    });


mix.copy(
    "vendor/proengsoft/laravel-jsvalidation/resources/views",
    "resources/views/vendor/jsvalidation"
).copy(
    "vendor/proengsoft/laravel-jsvalidation/public",
    "public/vendor/jsvalidation"
);
