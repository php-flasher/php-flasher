/**
 * @file TypeScript Global Declarations
 * @description Type definitions for global objects
 * @author Younes ENNAJI
 */
import type Flasher from './flasher'

/**
 * Extend the Window interface to include the global flasher instance.
 *
 * This allows TypeScript to recognize window.flasher as a valid property
 * with proper type information.
 */
declare global {
    interface Window {
        /**
         * Global PHPFlasher instance.
         *
         * Available as window.flasher in browser environments.
         */
        flasher: Flasher
    }
}

export {}
