/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        container: {
            center: true,
        },
        extend: {
            flexCenter: {
                display: 'flex',
                justifyContent: 'center',
                alignItems: 'center',
            },
        }
    },
    plugins: [
        require("@tailwindcss/forms")({
            strategy: 'base', // only generate global styles
        }),
    ],
}

