/**
 * Laravel Mix configuration file.
 *
 * Laravel Mix is a layer built on top of WordPress that simplifies much of the
 * complexity of building out a Webpack configuration file. Use this file to
 * configure how your assets are handled in the build process.
 *
 * @link https://laravel.com/docs/6.0/mix
 *
 * @author    Karl Adams <karladams@getmediawise.com>
 * @link      https://www.getmediawise.com/
 */

// Import required packages.
const mix = require('laravel-mix');
const pkg = require('./package.json');

// Set Directories.
const app = 'app';
const dist = 'assets';
const src = 'src';

/*
 * Sets the path to the generated assets. By default, this is the `/dist` folder
 * in the theme. If doing something custom, make sure to change this everywhere.
 */
mix.setPublicPath(dist);

/*
 * Set Laravel Mix options.
 *
 * @link https://laravel.com/docs/5.6/mix#postcss
 * @link https://laravel.com/docs/5.6/mix#url-processing
 */
mix.options({
    postCss: [require('postcss-preset-env')()],
    processCssUrls: false,
});

/*
 * Builds sources maps for assets.
 *
 * @link https://laravel.com/docs/5.6/mix#css-source-maps
 */
mix.sourceMaps();

/*
 * Versioning and cache busting. Append a unique hash for production assets. If
 * you only want versioned assets in production, do a conditional check for
 * `mix.inProduction()`.
 *
 * @link https://laravel.com/docs/5.6/mix#versioning-and-cache-busting
 */
mix.version();

/*
 * Combine JavaScript.
 */
mix.combine(
    [src + '/scripts/frontend/*'],
    dist + '/js/' + pkg.name + '.js'
).minify(
    dist + '/js/' + pkg.name + '.js',
);

/*
 * Compile SASS to CSS and Minify
 */
mix.sass(
    src + '/scss/public.scss',
    'css/' + pkg.name + '.css'
).minify(
    [
        dist + '/css/' + pkg.name + '.css'
    ]
);

/*
 * Add custom Webpack configuration.
 *
 * Laravel Mix doesn't currently minimize images while using its `.copy()`
 * function, so we're using the `CopyWebpackPlugin` for processing and copying
 * images into the distribution folder.
 *
 * @link https://laravel.com/docs/5.6/mix#custom-webpack-configuration
 * @link https://webpack.js.org/configuration/
 */
mix.webpackConfig({
    stats: 'minimal',
    devtool: mix.inProduction() ? false : 'source-map',
    performance: {hints: false}
});

if (process.env.sync) {
    mix.browserSync({
        proxy: 'localhost',
        files: [
            dist + '/**/*',
            app + '/**/*.php',
            'functions.php',
        ],
    });
}