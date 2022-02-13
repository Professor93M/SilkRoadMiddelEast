const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
        minWidth: {
            '0': '0',
            '15': '15%',
            '20': '20%',
            '25': '25%',
            '30': '30%',
            '40': '40%',
            '50': '50%',
            '60': '60%',
            '70': '70%',
        },
        maxWidth: {
            '18': '18%',
            '20': '20%',
            '25': '25%',
            '30': '30%',
            '40': '40%',
            '50': '50%',
            '60': '60%',
            '70': '70%',
            '80': '80%',
        },
        minHeight: {
            '90': '90%',
            '80': '80%',
            '70': '70%',
            '60': '60%',
            '50': '50%',
            '40': '40%',
            '30': '30%',
            '20': '20%',
        },
        extend: {
            gridTemplateColumns: {
              // Simple 16 column grid
             '3-4': 'repeat(3, minmax(0, 400px))',
             '3-5': 'repeat(3, minmax(0, 500px))',
            }
        },
        height: {
            96: '96%',
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
    ],
};
