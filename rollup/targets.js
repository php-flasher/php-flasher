/**
 * @description Specialized build targets
 * Contains configurations for specific build targets
 */

import path from 'node:path'
import { glob } from 'glob'
import { defineConfig } from 'rollup'
import resolve from '@rollup/plugin-node-resolve'
import typescript from '@rollup/plugin-typescript'
import copy from 'rollup-plugin-copy'
import terser from '@rollup/plugin-terser'

import { CONFIG } from './config.js'
import {
    createThemePlugins,
} from './plugins.js'

/**
 * Build configuration for the Prime plugin module
 * @returns {object} Rollup configuration
 */
export function buildPrimePlugin() {
    const primePath = CONFIG.paths.prime
    const filename = `${primePath}/dist/plugin`

    return defineConfig({
        input: `${primePath}/assets/plugin.ts`,
        plugins: [
            resolve(),
            typescript({
                compilerOptions: {
                    outDir: `${primePath}/dist`,
                },
                include: [`${primePath}/assets/**/**`],
            }),
        ],
        output: [
            {
                format: CONFIG.formats.ESM,
                file: `${filename}.js`,
                banner: CONFIG.build.banner,
            },
        ],
    })
}

/**
 * Build configurations for all available themes
 * @returns {Array<object>} Theme build configurations
 */
export function buildThemesConfigurations() {
    // Find all theme entry points but exclude the main themes index
    const themeFiles = glob.sync(`${CONFIG.paths.themes}/**/index.ts`)
        .filter((file) => file !== `${CONFIG.paths.themes}/index.ts`)

    // Create a configuration for each theme
    return themeFiles.map(buildThemeConfig)
}

/**
 * Build configuration for a specific theme
 * @param {string} themePath - Path to theme entry file
 * @returns {object} Rollup configuration for theme
 */
function buildThemeConfig(themePath) {
    const primePath = CONFIG.paths.prime
    const themeName = path.basename(path.dirname(themePath))

    console.log(`Configuring build for theme: ${themeName} (${themePath})`)

    // Define external dependencies and their global names
    const globals = {
        '@flasher/flasher': 'flasher',
        [CONFIG.flasherId]: 'flasher',
    }

    return defineConfig({
        input: themePath,

        // Simplified external check that only looks for specific imports
        external: Object.keys(globals),

        plugins: [
            // Add a plugin to rewrite imports to use the package name
            {
                name: 'rewrite-imports',
                resolveId(source, importer) {
                    // Handle relative imports that should be external
                    if (source === '../../index' || source === '../../../index') {
                        console.log(`Rewriting ${source} to @flasher/flasher`)
                        return { id: '@flasher/flasher', external: true }
                    }

                    // Handle absolute path to flasher index
                    if (source === CONFIG.flasherId
                        || (importer && source.includes(path.join(primePath, 'assets/index')))) {
                        console.log(`Rewriting ${source} to @flasher/flasher`)
                        return { id: '@flasher/flasher', external: true }
                    }

                    return null
                },
            },
            ...createThemePlugins(primePath, themeName),
        ],

        output: [
            // Minified UMD bundle
            {
                format: CONFIG.formats.UMD,
                file: `${primePath}/dist/themes/${themeName}/${themeName}.min.js`,
                name: `theme.${themeName}`,
                globals,
                banner: CONFIG.build.banner,

                // Fix: Remove the paths option which is causing the issue
                // Or explicitly force absolute (non-relative) paths:
                paths: (id) => {
                    if (id === '@flasher/flasher' || id.includes('@flasher/flasher')) {
                        // Ensure we return the exact package name with no modifications
                        return '@flasher/flasher'
                    }
                    // For all other IDs, return as-is
                    return id
                },

                plugins: [
                    ...CONFIG.env.isProduction ? [terser({ format: { comments: false } })] : [],
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
            // Use the same fix for non-minified and ESM bundles
            {
                format: CONFIG.formats.UMD,
                file: `${primePath}/dist/themes/${themeName}/${themeName}.js`,
                name: `theme.${themeName}`,
                globals,
                banner: CONFIG.build.banner,
                paths: (id) => id === '@flasher/flasher' ? '@flasher/flasher' : id,
            },
            {
                format: CONFIG.formats.ESM,
                file: `${primePath}/dist/themes/${themeName}/${themeName}.esm.js`,
                globals,
                banner: CONFIG.build.banner,
                paths: (id) => id === '@flasher/flasher' ? '@flasher/flasher' : id,
            },
        ],
    })
}
