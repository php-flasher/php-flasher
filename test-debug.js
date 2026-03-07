const { createFilter } = require('@rollup/pluginutils');
const path = require('path');

// Simulating exact typescript plugin behavior
const include = ['**/*.ts'];
const exclude = ['demo/**', 'tests/**'];

// The typescript plugin uses rootDir or cwd
const resolve = process.cwd();

console.log('Creating filter with:');
console.log('  include:', include);
console.log('  exclude:', exclude);
console.log('  resolve:', resolve);

const filter = createFilter(include, exclude, { resolve });

const testFile = '/Users/yoeunes/projects/flasher/php-flasher/src/Prime/Resources/assets/plugin.ts';
console.log('\nTesting file:', testFile);
console.log('Filter result:', filter(testFile));
