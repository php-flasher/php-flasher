import { defineConfig } from 'vitest/config'
import { resolve } from 'path'

export default defineConfig({
    test: {
        globals: true,
        environment: 'jsdom',
        include: ['tests/**/*.test.ts'],
        coverage: {
            provider: 'v8',
            reporter: ['text', 'json', 'html'],
            reportsDirectory: 'coverage/vitest',
            include: ['src/*/Resources/assets/**/*.ts'],
            exclude: [
                '**/index.ts',
                '**/*.d.ts',
                '**/themes/**',
            ],
        },
        setupFiles: ['./tests/setup.ts'],
    },
    resolve: {
        alias: {
            '@flasher/flasher/dist/plugin': resolve(__dirname, 'src/Prime/Resources/assets/plugin'),
            '@flasher/flasher/dist/types': resolve(__dirname, 'src/Prime/Resources/assets/types'),
            '@flasher/flasher': resolve(__dirname, 'src/Prime/Resources/assets'),
            '@flasher/flasher-noty': resolve(__dirname, 'src/Noty/Prime/Resources/assets'),
            '@flasher/flasher-notyf': resolve(__dirname, 'src/Notyf/Prime/Resources/assets'),
            '@flasher/flasher-sweetalert': resolve(__dirname, 'src/SweetAlert/Prime/Resources/assets'),
            '@flasher/flasher-toastr': resolve(__dirname, 'src/Toastr/Prime/Resources/assets'),
        },
    },
})
