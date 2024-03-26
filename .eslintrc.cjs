module.exports = {
    root: true,
    env: {
        browser: true,
        es6: true,
        node: true,
    },
    extends: [
        'eslint:recommended',
        'plugin:@typescript-eslint/recommended',
        'plugin:prettier/recommended',
    ],
    parser: '@typescript-eslint/parser',
    parserOptions: {
        project: [
            './tsconfig.json',
            './src/**/*/tsconfig.json',
        ],
    },
    plugins: ['@typescript-eslint', 'import'],
    rules: {
        "quotes": ["error", "single"],
        "no-trailing-spaces": ["error"],
        "object-curly-spacing": ["error", "always"],
        "comma-dangle": ["error", "always-multiline"],
        "semi": ["error", "never"],
        "@typescript-eslint/ban-ts-comment": ["off"],
    },
    settings: {
        'import/resolver': {
            typescript: {},
        },
    },
};
