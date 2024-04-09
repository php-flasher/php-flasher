import antfu from '@antfu/eslint-config'

export default antfu(
    {
        stylistic: {
            indent: 4,
        },

        typescript: true,
        ignores: [
            '.github',
            'dist',
            'node_modules',
        ],
    },
    {
        rules: {
            'style/brace-style': ['error', '1tbs'],
            'style/arrow-parens': ['error', 'always'],
            'curly': ['error', 'all'],
            'antfu/consistent-list-newline': 'off',
            '@typescript-eslint/ban-ts-comment': 'off',
            'ts/consistent-type-definitions': 'off',
        },
    },
    {
        files: ['package.json'],
        rules: {
            'style/eol-last': 'off',
        },
    },
)
