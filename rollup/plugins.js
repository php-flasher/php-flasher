/**
 * @description Plugin configurations for PHPFlasher build system
 * Centralizes all plugin configurations in one place
 */

import autoprefixer from 'autoprefixer'
import cssnano from 'cssnano'
import discardComments from 'postcss-discard-comments'
import babel from '@rollup/plugin-babel'
import resolve from '@rollup/plugin-node-resolve'
import strip from '@rollup/plugin-strip'
import terser from '@rollup/plugin-terser'
import typescript from '@rollup/plugin-typescript'
import cleanup from 'rollup-plugin-cleanup'
import clear from 'rollup-plugin-clear'
import copy from 'rollup-plugin-copy'
import filesize from 'rollup-plugin-filesize'
import postcss from 'rollup-plugin-postcss'
import progress from 'rollup-plugin-progress'

import { CONFIG } from './config.js'

/**
 * CSS processing plugins collection
 */
export const cssPlugins = [
    // Minify CSS with advanced optimizations
    cssnano({
        preset: ['default', {
            discardComments: {
                removeAll: true,
            },
        }],
    }),

    // Remove all comments
    discardComments({
        removeAll: true,
    }),

    // Add vendor prefixes for browser compatibility
    autoprefixer(),
]

/**
 * Create a progress indicator plugin
 * @param {string} name - Module name for display
 * @returns {Array} Configured plugins
 */
export function createProgressPlugin(name) {
    return [
        progress({
            clearLine: true,
            format: `Building ${name} [:bar] :percent`,
        }),
    ]
}

/**
 * Create directory cleaning plugins
 * @param {string} path - Path to clean
 * @returns {Array} Configured plugins
 */
export function createCleanPlugin(path) {
    return CONFIG.env.isProduction
        ? [clear({ targets: [`${path}/dist`, `${path}/public`] })]
        : []
}

/**
 * Create CSS processing plugins
 * @param {string} name - Module name
 * @returns {Array} Configured plugins
 */
export function createCssPlugin(name) {
    return [
        postcss({
            extract: CONFIG.filenames.css(name),
            plugins: CONFIG.env.isProduction ? cssPlugins : [],
            use: { sass: { silenceDeprecations: ['legacy-js-api'] } },
        }),
    ]
}

/**
 * Create core compilation plugins
 * @param {string} path - Module path
 * @returns {Array} Configured plugins
 */
export function createCompilationPlugins(path) {
    return [
        resolve(),
        typescript({
            compilerOptions: {
                outDir: `${path}/dist`,
            },
            include: [`${path}/assets/**/*.ts`],
        }),
        babel({ babelHelpers: 'bundled' }),
    ]
}

/**
 * Create code optimization plugins for production
 * @returns {Array} Configured plugins
 */
export function createOptimizationPlugins() {
    return CONFIG.env.isProduction
        ? [
                strip(),
                cleanup({ comments: 'none' }),
            ]
        : []
}

/**
 * Create asset copying plugins
 * @param {string} path - Destination path
 * @param {Array} assets - Assets to copy
 * @returns {Array} Configured plugins
 */
export function createAssetCopyPlugins(path, assets) {
    return assets
        ? [
                copy({
                    targets: assets.map((asset) => ({
                        src: asset.startsWith('node_modules') ? asset : `node_modules/${asset}`,
                        dest: `${path}/public`,
                    })),
                }),
            ]
        : []
}

/**
 * Create output bundle plugins
 * @param {string} distPath - Distribution path
 * @param {string} publicPath - Public path
 * @returns {Array} Configured plugins
 */
export function createOutputPlugins(distPath, publicPath) {
    return [
    // Minify with terser in production mode
        ...(CONFIG.env.isProduction ? [terser({ format: { comments: false } })] : []),

        // Copy minified files to public directory
        copy({
            targets: [{
                src: [`${distPath}/*.min.js`, `${distPath}/*.min.css`],
                dest: publicPath,
            }],
            hook: 'writeBundle',
        }),

        // Show bundle size information in production
        ...(CONFIG.env.isProduction ? [filesize({ showBrotliSize: true })] : []),
    ]
}

/**
 * Create metrics reporting plugins
 * @returns {Array} Configured plugins
 */
export function createMetricsPlugins() {
    return CONFIG.env.isProduction
        ? [
                filesize({
                    showMinifiedSize: true,
                    showGzippedSize: true,
                    showBrotliSize: true,
                }),
            ]
        : []
}

/**
 * Create a complete plugin set for module builds
 * @param {object} module - Module configuration
 * @returns {Array} All configured plugins
 */
export function createModulePlugins({ name, path, assets }) {
    return [
        ...createProgressPlugin(name),
        ...createCleanPlugin(path),
        ...createCssPlugin(name),
        ...createCompilationPlugins(path),
        ...createOptimizationPlugins(),
        ...createAssetCopyPlugins(path, assets),
        ...createMetricsPlugins(),
    ]
}

/**
 * Create special theme plugins
 * @param {string} primePath - Path to prime resources
 * @param {string} themeName - Theme name
 * @returns {Array} Theme-specific plugins
 */
export function createThemePlugins(primePath, themeName) {
    console.log(`Setting up plugins for theme: ${themeName}`)

    return [
        {
            name: 'external-debug',
            resolveId(source, importer) {
                console.log(`Import resolution: ${source} from ${importer || 'unknown'}`)
                return null // Let Rollup continue resolution
            },
        },
        resolve({
            // This is critical - it ensures that Rollup prioritizes
            // the external check before trying to resolve
            preferBuiltins: true,
        }),
        // Process theme CSS/SCSS
        postcss({
            extract: `${themeName}.min.css`,
            plugins: CONFIG.env.isProduction ? cssPlugins : [],
            use: { sass: { silenceDeprecations: ['legacy-js-api'] } },
            sourceMap: false,
        }),
        // TypeScript processing
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
        // Production optimizations
        ...createOptimizationPlugins(),
        ...createMetricsPlugins(),
        {
            name: 'theme-debugger',
            transform(code, id) {
                if (id.includes(`themes/${themeName}`)) {
                    console.log(`Building theme: ${themeName} (${id})`)
                }
                return null
            },
        },
    ]
}
