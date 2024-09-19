import process from 'node:process'
import { defineConfig } from 'rollup'
import clear from 'rollup-plugin-clear'
import resolve from '@rollup/plugin-node-resolve'
import cleanup from 'rollup-plugin-cleanup'
import typescript from '@rollup/plugin-typescript'
import babel from '@rollup/plugin-babel'
import terser from '@rollup/plugin-terser'
import filesize from 'rollup-plugin-filesize'
import copy from 'rollup-plugin-copy'
import postcss from 'rollup-plugin-postcss'
import cssnano from 'cssnano'
import autoprefixer from 'autoprefixer'
import discardComments from 'postcss-discard-comments'
import progress from 'rollup-plugin-progress'

const isProduction = process.env.NODE_ENV === 'production'

const modules = [
    { name: 'flasher', path: 'src/Prime/Resources' },
    { name: 'noty', path: 'src/Noty/Prime/Resources', globals: { noty: 'Noty' }, assets: ['noty/lib/noty.min.js', 'noty/lib/noty.css', 'noty/lib/themes/mint.css'] },
    { name: 'notyf', path: 'src/Notyf/Prime/Resources' },
    { name: 'sweetalert', path: 'src/SweetAlert/Prime/Resources', globals: { sweetalert2: 'Swal' }, assets: ['sweetalert2/dist/sweetalert2.min.js', 'sweetalert2/dist/sweetalert2.min.css'] },
    { name: 'toastr', path: 'src/Toastr/Prime/Resources', globals: { toastr: 'toastr' }, assets: ['jquery/dist/jquery.min.js', 'toastr/build/toastr.min.js', 'toastr/build/toastr.min.css'] },
]

const postcssPlugins = [
    cssnano(),
    discardComments({ removeAll: true }),
    autoprefixer({ overrideBrowserslist: ['> 0%'] }),
]

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
        ? [copy({ targets: assets.map((asset) => ({
                src: asset.startsWith('node_modules') ? asset : `node_modules/${asset}`,
                dest: `${path}/public` })) })]
        : []

    return [
        progress(),
        ...(isProduction ? [clear({ targets: [`${path}/dist`, `${path}/public`] })] : []),
        postcss({ extract: filename, plugins: isProduction ? postcssPlugins : [] }),
        ...commonPlugins(path),
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
        copy({ targets: [{ src: [`${distPath}/*.min.js`, `${distPath}/*.min.css`], dest: publicPath }], hook: 'writeBundle' }),
        ...(isProduction ? [terser({ format: { comments: false } })] : []),
        ...(isProduction ? [filesize()] : []),
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
        plugins: [resolve(), typescript({ compilerOptions: { outDir: `${path}/dist` }, include: [`${path}/assets/**/**`] })],
        output: [
            { format: 'es', file: `${filename}.js` },
            // { format: 'cjs', file: `${filename}.cjs.js` },
        ],
    })
}

export default [
    createPrimePlugin(),
    ...modules.map(createConfig),
]
