const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .babelConfig({
        presets: ['@babel/preset-env'],
        plugins: ['@babel/plugin-transform-modules-commonjs']
    })
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
        // Optional: You can also add other PostCSS plugins if needed
    ])
    .sourceMaps();
