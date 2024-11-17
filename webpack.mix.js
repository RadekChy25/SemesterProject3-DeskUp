const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .babelConfig({
        presets: ['@babel/preset-env'], // Ensure Babel processes JS files
        plugins: ['@babel/plugin-transform-modules-commonjs'] // Transpile ES Modules to CommonJS
    })
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
    ])
    .sourceMaps();

