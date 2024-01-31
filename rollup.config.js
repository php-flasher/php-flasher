import cleanup from 'rollup-plugin-cleanup';
import clear from 'rollup-plugin-clear';
import commonjs from '@rollup/plugin-commonjs';
import copy from 'rollup-plugin-copy';
import cssnano from 'cssnano';
import filesize from 'rollup-plugin-filesize';
import resolve from '@rollup/plugin-node-resolve';
import styles from 'rollup-plugin-styles';
import terser from '@rollup/plugin-terser';
import typescript from '@rollup/plugin-typescript';
import { defineConfig } from 'rollup';

const isProduction = 'production' === process.env.NODE_ENV;

const debug = (message) => {
    const colors = {
        reset: '\x1b[0m',
        bright: '\x1b[1m',
        dim: '\x1b[2m',
        underscore: '\x1b[4m',
        blink: '\x1b[5m',
        reverse: '\x1b[7m',
        hidden: '\x1b[8m',

        black: '\x1b[30m',
        red: '\x1b[31m',
        green: '\x1b[32m',
        yellow: '\x1b[33m',
        blue: '\x1b[34m',
        magenta: '\x1b[35m',
        cyan: '\x1b[36m',
        white: '\x1b[37m',

        bgBlack: '\x1b[40m',
        bgRed: '\x1b[41m',
        bgGreen: '\x1b[42m',
        bgYellow: '\x1b[43m',
        bgBlue: '\x1b[44m',
        bgMagenta: '\x1b[45m',
        bgCyan: '\x1b[46m',
        bgWhite: '\x1b[47m',
    };

    console.log(
        `${colors.cyan}> DEBUG:${colors.reset} ${colors.bright}${colors.yellow}${message}${colors.reset}`,
    );
};

const resolveConfig = (config) => {
    const { name } = config;

    if ('flasher' !== name) {
        config.globals = { ...config.globals, '@flasher/flasher': 'flasher' };
        config.external = [...(config.external || []), '@flasher/flasher'];
    }

    if ('toastr' === name) {
        config.globals = { ...config.globals, jquery: 'jQuery' };
        config.external = [...(config.external || []), 'jquery'];
    }

    config.input = 'js/index.ts';
    config.file = `public/flasher-${name}.js`;

    if ('flasher' === name) {
        config.file = `public/flasher.js`;
    }

    return config;
};

const outputOptions = (options = {}) => ({
    exports: 'auto',
    sourcemap: true,
    sourcemapExcludeSources: false,
    assetFileNames: '[name][extname]',
    inlineDynamicImports: true,
    ...options,
});

const modules = {
    '@flasher/flasher': { name: 'flasher' },
    '@flasher/flasher-noty': { name: 'noty' },
    '@flasher/flasher-notyf': { name: 'notyf' },
    '@flasher/flasher-sweetalert': { name: 'sweetalert' },
    '@flasher/flasher-toastr': { name: 'toastr' },
};

const packageName = process.env.LERNA_PACKAGE_NAME;
debug(`Building package: ${packageName}.`);

const packageConfig = modules[packageName];

const plugins = [
    clear({
        targets: [
            'public',
            '../../Symfony/Resources/public/',
            '../../Laravel/Resources/public/',
        ],
    }),
    styles({
        mode: 'extract',
        plugins: {
            cssnano,
            'postcss-discard-comments': { removeAll: true },
            autoprefixer: { overrideBrowserslist: ['> 0%'] },
        },
    }),
    resolve(),
    commonjs(),
    typescript({
        tsconfig: 'tsconfig.build.json',
        sourceMap: isProduction,
    }),
    cleanup({
        comments: 'none',
        extensions: ['.ts'],
    }),
    copy({
        targets: [
            {
                src: 'public/*.js', dest: [
                    '../../Symfony/Resources/public/',
                    '../../Laravel/Resources/public/',
                ],
            },
        ],
        hook: 'writeBundle',
    }),
];

const config = resolveConfig(packageConfig);

export default defineConfig({
    input: config.input,
    plugins,
    external: config.external || [],
    output: [
        outputOptions({
            file: config.file,
            format: 'umd',
            name: config.name,
            globals: config.globals || {},
        }),
        outputOptions({
            file: config.file.replace('.js', '.min.js'),
            format: 'umd',
            name: config.name,
            globals: config.globals || {},
            plugins: [
                isProduction && terser({ format: { comments: false } }),
                filesize(),
            ].filter(Boolean),
        }),
    ],
});
