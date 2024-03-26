import fs from 'fs';
import path from 'path';
import { resolveConfig } from '../../../rollup.shared.js';

// Dynamically find theme directories
const themesDir = path.resolve(__dirname, 'assets/themes');
const themeDirectories = fs.readdirSync(themesDir).filter(dir =>
    fs.statSync(path.join(themesDir, dir)).isDirectory()
);

// Generate an entry for each theme
const themeEntries = themeDirectories.reduce((entries, dir) => {
    entries[dir] = `assets/themes/${dir}/index.ts`;
    return entries;
}, {});

const configs = [
    resolveConfig({ name: 'flasher' }),
];

Object.keys(themeEntries).map(themeName =>
    configs.push(resolveConfig({
        name: themeName,
        input: themeEntries[themeName],
        isTheme: true,
    }))
);

export default configs;
