/**
 * @file PHPFlasher Type Exports
 * @description Re-exports types and interfaces for TypeScript users
 * @author Younes ENNAJI
 */

/**
 * Re-export all types and interfaces.
 *
 * This allows TypeScript users to import specific types:
 *
 * @example
 * ```typescript
 * import { Options, Envelope } from '@flasher/flasher/exports';
 * ```
 */
export * from './types'

/**
 * Re-export the AbstractPlugin class.
 *
 * This is useful for creating custom plugins.
 *
 * @example
 * ```typescript
 * import { AbstractPlugin } from '@flasher/flasher/exports';
 *
 * class MyPlugin extends AbstractPlugin {
 *   // Implementation
 * }
 * ```
 */
export { AbstractPlugin } from './plugin'

/**
 * Re-export the FlasherPlugin class.
 *
 * This allows creating custom theme-based plugins.
 *
 * @example
 * ```typescript
 * import { FlasherPlugin } from '@flasher/flasher/exports';
 * import myTheme from './my-theme';
 *
 * const plugin = new FlasherPlugin(myTheme);
 * ```
 */
export { default as FlasherPlugin } from './flasher-plugin'

/**
 * Re-export the default flasher instance.
 *
 * This ensures consistency whether importing from the main package
 * or from the exports file.
 */
export { default } from './index'
