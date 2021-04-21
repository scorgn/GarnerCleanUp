const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const LiveReloadPlugin = require('webpack-livereload-plugin');
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
// webpack.mix.js
mix.js("resources/js/app.js", "public/js")
    .sass("resources/css/app.scss", "public/css")
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    }).copyDirectory('./node_modules/@fortawesome/fontawesome-free/webfonts', 'public/fonts/fontawesome-free')
    .webpackConfig({
        plugins: [new LiveReloadPlugin({
            // 'hostname': '127.0.0.1',
        })]
    });
