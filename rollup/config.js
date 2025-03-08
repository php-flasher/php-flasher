/**
 * @description Central configuration for PHPFlasher build system
 */

import process from 'node:process'
import { fileURLToPath } from 'node:url'

/**
 * Build environment settings
 */
const ENV = {
    isProduction: process.env.NODE_ENV === 'production',
    isDevelopment: process.env.NODE_ENV !== 'production',
}

/**
 * Path configuration
 */
const PATHS = {
    src: 'src',
    get prime() {
        return `${this.src}/Prime/Resources`
    },
    get themes() {
        return `${this.prime}/assets/themes`
    },
    get nodeModules() {
        return 'node_modules'
    },
}

/**
 * Output format constants
 */
const FORMATS = {
    UMD: 'umd',
    ESM: 'es',
    CJS: 'cjs',
    IIFE: 'iife',
}

/**
 * Module definitions for PHPFlasher
 */
const MODULES = [
    // Core flasher module
    {
        name: 'flasher',
        path: PATHS.prime,
    },

    // Noty notification plugin
    {
        name: 'noty',
        path: `${PATHS.src}/Noty/Prime/Resources`,
        globals: { noty: 'Noty' },
        assets: [
            'noty/lib/noty.min.js',
            'noty/lib/noty.css',
            'noty/lib/themes/mint.css',
        ],
    },

    // Notyf notification plugin
    {
        name: 'notyf',
        path: `${PATHS.src}/Notyf/Prime/Resources`,
    },

    // SweetAlert notification plugin
    {
        name: 'sweetalert',
        path: `${PATHS.src}/SweetAlert/Prime/Resources`,
        globals: { sweetalert2: 'Swal' },
        assets: [
            'sweetalert2/dist/sweetalert2.min.js',
            'sweetalert2/dist/sweetalert2.min.css',
        ],
    },

    // Toastr notification plugin
    {
        name: 'toastr',
        path: `${PATHS.src}/Toastr/Prime/Resources`,
        globals: { toastr: 'toastr' },
        assets: [
            'jquery/dist/jquery.min.js',
            'toastr/build/toastr.min.js',
            'toastr/build/toastr.min.css',
        ],
    },
]

/**
 * Build options
 */
const BUILD_OPTIONS = {
    banner: '/**\n * @package PHPFlasher\n * @author Younes ENNAJI\n * @license MIT\n */',
    sourceMaps: true,
}

/**
 * Filename generators
 */
const FILENAME_GENERATORS = {
    /**
     * Generate module filename based on name
     * @param {string} name - Module name
     * @param {string} suffix - Optional suffix
     * @returns {string} Formatted filename
     */
    module(name, suffix = '') {
        return name === 'flasher' ? `flasher${suffix}` : `flasher-${name}${suffix}`
    },

    /**
     * Generate CSS filename based on module name
     * @param {string} name - Module name
     * @returns {string} CSS filename
     */
    css(name) {
        return this.module(name, '.min.css')
    },
}

// Calculate external flasher ID (needed for themes)
const FLASHER_ID = fileURLToPath(new URL(`${PATHS.prime}/assets/index.ts`, import.meta.url))

/**
 * Exported configuration object
 */
export const CONFIG = {
    env: ENV,
    paths: PATHS,
    formats: FORMATS,
    modules: MODULES,
    build: BUILD_OPTIONS,
    filenames: FILENAME_GENERATORS,
    flasherId: FLASHER_ID,
}
