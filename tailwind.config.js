import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                vwtext:['VWText-Regular','sans-serif'],
                vwheadlight:['VWHeadWeb-Light1','sans-serif'],
                vwheadbold:['VWHead-Bold', 'sans-serif'],
            },
        },
    },

    plugins: [forms],
};
