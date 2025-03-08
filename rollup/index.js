/**
 * @description Core build system for PHPFlasher
 * Contains consolidated build functions
 */

import { defineConfig } from 'rollup'

import {
    createModulePlugins,
    createOutputPlugins,
} from './plugins.js'
import {
    buildPrimePlugin,
    buildThemesConfigurations,
} from './targets.js'
import { CONFIG } from './config.js'

/**
 * Create all build configurations for PHPFlasher
 * @returns {Array<object>} Combined rollup configurations
 */
export function createBuildConfigurations() {
    return [
        buildPrimePlugin(),
        ...CONFIG.modules.map(buildModuleConfig),
        ...buildThemesConfigurations(),
    ]
}

/**
 * Build a complete Rollup configuration for a module
 * @param {object} moduleConfig - Module configuration object
 * @returns {object} Rollup configuration object
 */
function buildModuleConfig(moduleConfig) {
    // Normalize the module configuration
    const module = {
        ...moduleConfig,
        globals: buildGlobalsDictionary(moduleConfig),
    }

    return defineConfig({
        input: `${module.path}/assets/index.ts`,
        external: Object.keys(module.globals),
        plugins: createModulePlugins(module),
        output: buildOutputConfigs(module),
    })
}

/**
 * Build globals dictionary for module
 * @param {object} module - Module configuration
 * @returns {object} Globals mapping for Rollup
 */
function buildGlobalsDictionary(module) {
    const globals = module.globals || {}

    // Add flasher as external dependency for all non-core modules
    if (module.name !== 'flasher') {
        globals['@flasher/flasher'] = 'flasher'
    }

    return globals
}

/**
 * Build output configurations for a module
 * @param {object} module - Module configuration with name, path, globals
 * @returns {Array} Array of output configurations
 */
function buildOutputConfigs({ name, path, globals }) {
    // Generate appropriate filename based on module name
    const filename = CONFIG.filenames.module(name)
    const distPath = `${path}/dist`
    const publicPath = `${path}/public`

    // Base output configuration shared across formats
    const baseOutput = {
        name,
        globals,
        assetFileNames: '[name][extname]',
        banner: CONFIG.build.banner,
    }

    // Output plugins
    const outputPlugins = createOutputPlugins(distPath, publicPath)

    // Return array of output formats
    return [
        // Minified UMD bundle
        {
            format: CONFIG.formats.UMD,
            file: `${distPath}/${filename}.min.js`,
            plugins: outputPlugins,
            ...baseOutput,
        },

        // Non-minified UMD bundle
        {
            format: CONFIG.formats.UMD,
            file: `${distPath}/${filename}.js`,
            ...baseOutput,
        },

        // ESM bundle for modern bundlers
        {
            format: CONFIG.formats.ESM,
            file: `${distPath}/${filename}.esm.js`,
            ...baseOutput,
        },
    ]
}
