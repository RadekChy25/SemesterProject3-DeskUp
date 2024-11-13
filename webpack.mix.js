import mix from 'laravel-mix';
import tailwindcss from 'tailwindcss';

mix
  .postCss('resources/css/app.css', 'public/css', [
      tailwindcss,
  ])
  .js('resources/js/app.js', 'public/js')
  .version();
