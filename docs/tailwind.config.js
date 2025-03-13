/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        // Source files only
        './_site/**/*.{html,js}',
        './docs/**/*.{html,md}',
        './_includes/**/*.html',
        './_layouts/**/*.html',
        './assets/**/*.{js,pcss}',
        './static/css/*.css',
        './static/js/*.js',

        // Explicit exclusions
        // '!./_site/**', // Jekyll output directory
        '!./node_modules/**', // Already excluded, but keeping it explicit
        '!./dist/**', // Webpack output
    ],
}
