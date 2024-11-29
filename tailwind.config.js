import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        'blue-1000': 'rgb(35, 4, 53)', // Custom blue color
      },
      borderRadius: {
        // Adding custom border radius for circle
        'rounded-circle': '50%', // This will create a circle if used on a square element
      },
    },
  },
  plugins: [
    plugin(function({ addUtilities }) {
        const newUtilities = {
            '.text-justify': {
                textAlign: 'justify',
            },
            '.text-center': {
                textAlign: 'center',
            },
            '.text-left': {
                textAlign: 'left',
            },
            '.text-right': {
                textAlign: 'right',
            },
        };

        addUtilities(newUtilities, ['responsive', 'hover']);
    }),
    addIconSelectors({
        // Ensure you have the correct configuration here
        varName: 'iconify', // Example configuration
    }),
],
};
