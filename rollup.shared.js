import cleanup from 'rollup-plugin-cleanup';
import clear from 'rollup-plugin-clear';
import commonjs from '@rollup/plugin-commonjs';
import copy from 'rollup-plugin-copy';
import cssnano from 'cssnano';
import resolve from '@rollup/plugin-node-resolve';
import styles from 'rollup-plugin-styles';
import terser from '@rollup/plugin-terser';
import typescript from '@rollup/plugin-typescript';
import { defineConfig } from 'rollup';

const isProduction = 'production' === process.env.NODE_ENV;

const basePlugins = [
    clear({ targets: ['dist/', 'public/'] }),
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
    cleanup({ comments: 'none', extensions: ['.ts'] }),
];

const outputOptions = (options = {}) => {
    return {
        exports: 'auto',
        sourcemap: false,
        sourcemapExcludeSources: false,
        assetFileNames: '[name][extname]',
        inlineDynamicImports: true,
        format: 'umd',
        ...options,
    };
};

export const resolveConfig = ({ name, input = 'assets/index.ts', external = [], globals = {}, isTheme = false }) => {
    const basePath = isTheme ? `dist/themes/${name}/` : 'dist/';
    const publicPath = isTheme ? `public/themes/${name}/` : 'public/';

    const fileName = isTheme
        ? `${name}.js`
        : 'flasher' === name
            ? 'flasher.js'
            : `flasher-${name}.js`;

    const minFileName = fileName.replace('.js', '.min.js');

    const tsPlugin = isTheme
        ? typescript({ tsconfig: './tsconfig.build.json', sourceMap: false, declaration: false })
        : typescript({ tsconfig: './tsconfig.build.json', sourceMap: false });

    const plugins = [
        ...basePlugins,
        tsPlugin,
        copy({
            targets: [
                { src: [`${basePath}*.min.js`, `${basePath}*.min.css`], dest: publicPath }
            ],
            hook: 'writeBundle',
        }),
    ];

    const minPlugins = [
        isProduction && terser({ format: { comments: false } }),
    ].filter(Boolean);

    if ('flasher' !== name) {
        globals = { ...globals, '@flasher/flasher': 'flasher' };
        external = [...external, '@flasher/flasher'];
    }

    return defineConfig({
        input,
        plugins,
        external,
        output: [
            outputOptions({ name, file: `${basePath}${fileName}`, globals }),
            outputOptions({ name, file: `${basePath}${minFileName}`, globals, plugins: minPlugins }),
        ],
    });
};
