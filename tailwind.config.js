import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Source Sans 3"', ...defaultTheme.fontFamily.sans],
                display: ['Oswald', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                mc: {
                    yellow: '#fed700',
                    'yellow-dark': '#e6c200',
                    dark: '#333333',
                    darker: '#222222',
                    nav: '#2b2b2b',
                    muted: '#747474',
                    border: '#e5e5e5',
                    soft: '#f5f5f5',
                    price: '#e74c3c',
                },
            },
            maxWidth: {
                store: '1200px',
            },
            animation: {
                'fade-up': 'fadeUp 0.6s ease-out both',
                'fade-in': 'fadeIn 0.5s ease-out both',
                'slide-soft': 'slideSoft 0.7s ease-out both',
            },
            keyframes: {
                fadeUp: {
                    '0%': { opacity: '0', transform: 'translateY(16px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideSoft: {
                    '0%': { opacity: '0', transform: 'translateX(-12px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
