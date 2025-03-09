/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        // Source files only
        './docs/**/*.{html,md}',
        './_includes/**/*.html',
        './_layouts/**/*.html',
        './assets/**/*.{js,pcss}',

        // Explicit exclusions
        '!./_site/**', // Jekyll output directory
        '!./node_modules/**', // Already excluded, but keeping it explicit
        '!./dist/**', // Webpack output
    ],
}
