import path from 'node:path'
import process from 'node:process'
import { fileURLToPath } from 'node:url'
import babel from '@rollup/plugin-babel'
import resolve from '@rollup/plugin-node-resolve'
import terser from '@rollup/plugin-terser'
import typescript from '@rollup/plugin-typescript'
import strip from '@rollup/plugin-strip'
import autoprefixer from 'autoprefixer'
import cssnano from 'cssnano'
import glob from 'glob'
import discardComments from 'postcss-discard-comments'
import { defineConfig } from 'rollup'
import cleanup from 'rollup-plugin-cleanup'
import clear from 'rollup-plugin-clear'
import copy from 'rollup-plugin-copy'
import filesize from 'rollup-plugin-filesize'
import postcss from 'rollup-plugin-postcss'
import progress from 'rollup-plugin-progress'

const isProduction = process.env.NODE_ENV === 'production'

const modules = [
    { name: 'flasher', path: 'src/Prime/Resources' },
    {
        name: 'noty',
        path: 'src/Noty/Prime/Resources',
        globals: { noty: 'Noty' },
        assets: ['noty/lib/noty.min.js', 'noty/lib/noty.css', 'noty/lib/themes/mint.css'],
    },
    { name: 'notyf', path: 'src/Notyf/Prime/Resources' },
    {
        name: 'sweetalert',
        path: 'src/SweetAlert/Prime/Resources',
        globals: { sweetalert2: 'Swal' },
        assets: ['sweetalert2/dist/sweetalert2.min.js', 'sweetalert2/dist/sweetalert2.min.css'],
    },
    {
        name: 'toastr',
        path: 'src/Toastr/Prime/Resources',
        globals: { toastr: 'toastr' },
        assets: ['jquery/dist/jquery.min.js', 'toastr/build/toastr.min.js', 'toastr/build/toastr.min.css'],
    },
]

const postcssPlugins = [
    cssnano(),
    discardComments({ removeAll: true }),
    autoprefixer({ overrideBrowserslist: ['> 0%'] }),
]

const externalFlasherId = fileURLToPath(new URL('src/Prime/Resources/assets/index.ts', import.meta.url))

function commonPlugins(path) {
    return [
        resolve(),
        typescript({ compilerOptions: { outDir: `${path}/dist` }, include: [`${path}/assets/**/*.ts`] }),
        babel({ babelHelpers: 'bundled' }),
    ]
}

function createConfig(module) {
    module = { ...module, globals: createGlobals(module) }

    return defineConfig({
        input: `${module.path}/assets/index.ts`,
        external: Object.keys(module.globals),
        plugins: createPlugins(module),
        output: createOutput(module),
    })
}

function createGlobals(module) {
    const globals = module.globals || {}

    if (module.name !== 'flasher') {
        globals['@flasher/flasher'] = 'flasher'
    }

    return globals
}

function createPlugins({ name, path, assets }) {
    const filename = name === 'flasher' ? 'flasher.min.css' : `flasher-${name}.min.css`

    const copyAssets = assets
        ? [copy({
                targets: assets.map((asset) => ({
                    src: asset.startsWith('node_modules') ? asset : `node_modules/${asset}`,
                    dest: `${path}/public`,
                })),
            })]
        : []

    return [
        progress(),
        ...(isProduction ? [clear({ targets: [`${path}/dist`, `${path}/public`] })] : []),
        postcss({
            extract: filename,
            plugins: isProduction ? postcssPlugins : [],
            use: { sass: { silenceDeprecations: ['legacy-js-api'] } },
        }),
        ...commonPlugins(path),
        ...(isProduction ? [strip()] : []),
        ...(isProduction ? [cleanup({ comments: 'none' })] : []),
        ...copyAssets,
    ]
}

function createOutput({ name, path, globals }) {
    const filename = name === 'flasher' ? 'flasher' : `flasher-${name}`
    const distPath = `${path}/dist`
    const publicPath = `${path}/public`

    const output = {
        name,
        globals,
        assetFileNames: '[name][extname]',
    }

    const plugins = [
        ...(isProduction ? [terser({ format: { comments: false } })] : []),
        copy({
            targets: [{ src: [`${distPath}/*.min.js`, `${distPath}/*.min.css`], dest: publicPath }],
            hook: 'writeBundle',
        }),
        ...(isProduction ? [filesize({ showBrotliSize: true })] : []),
    ]

    return [
        { format: 'umd', file: `${distPath}/${filename}.min.js`, plugins, ...output },
        { format: 'umd', file: `${distPath}/${filename}.js`, ...output },
        { format: 'es', file: `${distPath}/${filename}.esm.js`, ...output },
        // { format: 'cjs', file: `${distPath}/${filename}.cjs.js`, ...output },
        // { format: 'iife', file: `${distPath}/${filename}.iife.js`, ...output },
    ]
}

function createPrimePlugin() {
    const path = 'src/Prime/Resources'
    const filename = `${path}/dist/plugin`

    return defineConfig({
        input: `${path}/assets/plugin.ts`,
        plugins: [
            resolve(),
            typescript({
                compilerOptions: {
                    outDir: `${path}/dist`,
                },
                include: [`${path}/assets/**/**`],
            })],
        output: [
            { format: 'es', file: `${filename}.js` },
            // { format: 'cjs', file: `${filename}.cjs.js` },
        ],
    })
}

function createThemeConfig(file) {
    const primePath = 'src/Prime/Resources'
    const themeName = path.basename(path.dirname(file))

    const globals = {
        '@flasher/flasher': 'flasher',
        [externalFlasherId]: 'flasher',
    }

    return defineConfig({
        input: file,
        external: Object.keys(globals),
        plugins: [
            resolve(),
            postcss({
                extract: `${themeName}.min.css`,
                plugins: isProduction ? postcssPlugins : [],
                use: { sass: { silenceDeprecations: ['legacy-js-api'] } },
            }),
            typescript({
                compilerOptions: {
                    outDir: `${primePath}/dist/themes/${themeName}`,
                    declaration: false,
                },
                include: [
                    `${primePath}/assets/**/*.ts`,
                ],
            }),
            babel({ babelHelpers: 'bundled' }),
            ...(isProduction ? [cleanup({ comments: 'none' })] : []),
            ...(isProduction ? [strip()] : []),
            ...(isProduction ? [filesize({ showBrotliSize: true })] : []),
        ],
        output: [
            {
                format: 'umd',
                file: `${primePath}/dist/themes/${themeName}/${themeName}.min.js`,
                name: `theme.${themeName}`,
                globals,
                plugins: [
                    ...isProduction ? [terser({ format: { comments: false } })] : [],
                    copy({
                        targets: [
                            {
                                src: [
                                    `${primePath}/dist/themes/${themeName}/${themeName}.min.js`,
                                    `${primePath}/dist/themes/${themeName}/${themeName}.min.css`,
                                ],
                                dest: `${primePath}/public/themes/${themeName}`,
                            },
                        ],
                        hook: 'writeBundle',
                        verbose: false,
                    }),
                ],
            },
            {
                format: 'umd',
                file: `${primePath}/dist/themes/${themeName}/${themeName}.js`,
                name: `theme.${themeName}`,
                globals,
            },
            {
                format: 'es',
                file: `${primePath}/dist/themes/${themeName}/${themeName}.esm.js`,
                globals,
            },
        ],
    })
}

function createThemesConfigs() {
    const primePath = 'src/Prime/Resources'
    const themesDir = `${primePath}/assets/themes`

    const themeFiles = glob.sync(`${themesDir}/**/index.ts`).filter((file) => file !== `${themesDir}/index.ts`)

    return themeFiles.map(createThemeConfig)
}

export default [
    createPrimePlugin(),
    ...modules.map(createConfig),
    ...createThemesConfigs(),
]
