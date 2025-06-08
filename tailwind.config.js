const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/views/*.blade.php',
        './resources/views/layouts/*.blade.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            colors: {
                "foxecom-orange": "#FF6B35",
                "foxecom-dark": "#1A1A1A",
                "foxecom-gray": "#6B7280",
                "foxecom-light": "#F9FAFB",
                "bringlu-purple": "#5267DF",
                "bringlu-red": "#FA5959",
                "bringlu-blue": "#242A45",
                "bringlu-grey": "#9194A2",
                "bringlu-white": "#f7f7f7",
            },
            fontFamily: {
                Poppins: ["Poppins, sans-serif"],
            },
            boxShadow: {
                'foxecom': '0 4px 14px 0 rgba(255, 107, 53, 0.15)',
                'foxecom-lg': '0 10px 25px 0 rgba(255, 107, 53, 0.2)',
            }
        },
        container: {
            center: true,
            padding: "1rem",
            screens: {
                lg: "1124px",
                xl: "1124px",
                "2xl": "1124px",
            }
        },
    },
    variants: {
        extend: {},
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('flowbite/plugin')
    ],
};