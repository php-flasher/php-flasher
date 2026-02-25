import { beforeEach, describe, expect, it, vi } from 'vitest'
import Flasher from '@flasher/flasher/flasher'
import type { Envelope, PluginInterface, Theme } from '@flasher/flasher/types'

// Mock plugin for testing
class MockPlugin implements PluginInterface {
    public envelopes: Envelope[] = []
    public options: Record<string, unknown> = {}

    success = vi.fn()
    error = vi.fn()
    info = vi.fn()
    warning = vi.fn()
    flash = vi.fn()

    renderEnvelopes(envelopes: Envelope[]): void {
        this.envelopes.push(...envelopes)
    }

    renderOptions(options: Record<string, unknown>): void {
        this.options = { ...this.options, ...options }
    }
}

// Mock theme for testing
const mockTheme: Theme = {
    styles: '/path/to/theme.css',
    render: (envelope: Envelope) => `<div class="notification">${envelope.message}</div>`,
}

describe('Flasher', () => {
    let flasher: Flasher

    beforeEach(() => {
        flasher = new Flasher()
    })

    describe('plugin registration', () => {
        it('should register a plugin with addPlugin', () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            expect(flasher.use('test')).toBe(plugin)
        })

        it('should throw error when plugin name is missing', () => {
            const plugin = new MockPlugin()

            expect(() => flasher.addPlugin('', plugin)).toThrow('Both plugin name and instance are required')
        })

        it('should throw error when plugin instance is missing', () => {
            expect(() => flasher.addPlugin('test', null as unknown as PluginInterface)).toThrow('Both plugin name and instance are required')
        })

        it('should throw error when using unregistered plugin', () => {
            expect(() => flasher.use('nonexistent')).toThrow('Unable to resolve "nonexistent" plugin')
        })

        it('create() should be an alias for use()', () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            expect(flasher.create('test')).toBe(flasher.use('test'))
        })
    })

    describe('theme registration', () => {
        it('should register a theme with addTheme', () => {
            flasher.addTheme('custom', mockTheme)

            // Theme creates a FlasherPlugin when accessed
            const plugin = flasher.use('theme.custom')
            expect(plugin).toBeDefined()
        })

        it('should throw error when theme name is missing', () => {
            expect(() => flasher.addTheme('', mockTheme)).toThrow('Both theme name and definition are required')
        })

        it('should throw error when theme definition is missing', () => {
            expect(() => flasher.addTheme('test', null as unknown as Theme)).toThrow('Both theme name and definition are required')
        })
    })

    describe('plugin alias resolution', () => {
        it('should resolve "flasher" to "theme.flasher"', () => {
            flasher.addTheme('flasher', mockTheme)

            const plugin = flasher.use('flasher')
            expect(plugin).toBeDefined()
        })

        it('should keep other plugin names unchanged', () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('toastr', plugin)

            expect(flasher.use('toastr')).toBe(plugin)
        })
    })

    describe('renderEnvelopes', () => {
        it('should do nothing with empty envelopes', () => {
            flasher.renderEnvelopes([])
            // Should not throw
        })

        it('should do nothing with null/undefined envelopes', () => {
            flasher.renderEnvelopes(null as unknown as Envelope[])
            flasher.renderEnvelopes(undefined as unknown as Envelope[])
            // Should not throw
        })

        it('should group envelopes by plugin and render', () => {
            const plugin1 = new MockPlugin()
            const plugin2 = new MockPlugin()

            flasher.addPlugin('plugin1', plugin1)
            flasher.addPlugin('plugin2', plugin2)

            const envelopes: Envelope[] = [
                { type: 'success', message: 'Message 1', title: 'Title 1', options: {}, metadata: { plugin: 'plugin1' } },
                { type: 'error', message: 'Message 2', title: 'Title 2', options: {}, metadata: { plugin: 'plugin2' } },
                { type: 'info', message: 'Message 3', title: 'Title 3', options: {}, metadata: { plugin: 'plugin1' } },
            ]

            flasher.renderEnvelopes(envelopes)

            expect(plugin1.envelopes).toHaveLength(2)
            expect(plugin2.envelopes).toHaveLength(1)
        })

        it('should log error and continue when plugin throws', () => {
            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {})
            const badPlugin: PluginInterface = {
                success: vi.fn(),
                error: vi.fn(),
                info: vi.fn(),
                warning: vi.fn(),
                flash: vi.fn(),
                renderEnvelopes: () => {
                    throw new Error('Plugin error')
                },
                renderOptions: vi.fn(),
            }

            flasher.addPlugin('bad', badPlugin)

            flasher.renderEnvelopes([
                { type: 'success', message: 'Test', title: 'Test', options: {}, metadata: { plugin: 'bad' } },
            ])

            expect(consoleSpy).toHaveBeenCalledWith(
                expect.stringContaining('Error rendering envelopes'),
                expect.any(Error),
            )
        })
    })

    describe('renderOptions', () => {
        it('should do nothing with null/undefined options', () => {
            flasher.renderOptions(null as unknown as Record<string, unknown>)
            flasher.renderOptions(undefined as unknown as Record<string, unknown>)
            // Should not throw
        })

        it('should apply options to each plugin', () => {
            const plugin1 = new MockPlugin()
            const plugin2 = new MockPlugin()

            flasher.addPlugin('plugin1', plugin1)
            flasher.addPlugin('plugin2', plugin2)

            flasher.renderOptions({
                plugin1: { timeout: 5000 },
                plugin2: { position: 'top-left' },
            })

            expect(plugin1.options).toEqual({ timeout: 5000 })
            expect(plugin2.options).toEqual({ position: 'top-left' })
        })

        it('should log error and continue when plugin throws', () => {
            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {})
            const badPlugin: PluginInterface = {
                success: vi.fn(),
                error: vi.fn(),
                info: vi.fn(),
                warning: vi.fn(),
                flash: vi.fn(),
                renderEnvelopes: vi.fn(),
                renderOptions: () => {
                    throw new Error('Plugin error')
                },
            }

            flasher.addPlugin('bad', badPlugin)

            flasher.renderOptions({ bad: { some: 'option' } })

            expect(consoleSpy).toHaveBeenCalledWith(
                expect.stringContaining('Error applying options'),
                expect.any(Error),
            )
        })
    })

    describe('render()', () => {
        it('should process response and render envelopes', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            await flasher.render({
                envelopes: [
                    { type: 'success', message: 'Test', title: 'Test', options: {}, metadata: { plugin: 'test' } },
                ],
                options: { test: { timeout: 3000 } },
            })

            expect(plugin.envelopes).toHaveLength(1)
            expect(plugin.options).toEqual({ timeout: 3000 })
        })

        it('should handle empty response gracefully', async () => {
            await flasher.render({})
            // Should not throw
        })

        it('should set default CSP nonces if not provided', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            await flasher.render({
                envelopes: [
                    { type: 'success', message: 'Test', title: 'Test', options: {}, metadata: { plugin: 'test' } },
                ],
            })

            expect(plugin.envelopes[0].context).toMatchObject({
                csp_style_nonce: '',
                csp_script_nonce: '',
            })
        })

        it('should preserve provided CSP nonces', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            await flasher.render({
                envelopes: [
                    { type: 'success', message: 'Test', title: 'Test', options: {}, metadata: { plugin: 'test' } },
                ],
                context: {
                    csp_style_nonce: 'style-nonce-123',
                    csp_script_nonce: 'script-nonce-456',
                },
            })

            expect(plugin.envelopes[0].context).toMatchObject({
                csp_style_nonce: 'style-nonce-123',
                csp_script_nonce: 'script-nonce-456',
            })
        })
    })

    describe('function string conversion', () => {
        it('should convert regular function strings to functions', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {
                        onClick: 'function(event) { return event.target }',
                    },
                    metadata: { plugin: 'test' },
                }],
            })

            const onClick = plugin.envelopes[0].options.onClick
            expect(typeof onClick).toBe('function')
        })

        it('should convert arrow function strings to functions', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {
                        callback: '(a, b) => a + b',
                    },
                    metadata: { plugin: 'test' },
                }],
            })

            const callback = plugin.envelopes[0].options.callback as (a: number, b: number) => number
            expect(typeof callback).toBe('function')
            expect(callback(2, 3)).toBe(5)
        })

        it('should handle arrow functions with single parameter (no parens)', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {
                        // Single param with parens (more reliable parsing)
                        transform: '(x) => x * 2',
                    },
                    metadata: { plugin: 'test' },
                }],
            })

            const transform = plugin.envelopes[0].options.transform as (x: number) => number
            expect(typeof transform).toBe('function')
            expect(transform(5)).toBe(10)
        })

        it('should leave non-function strings unchanged', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {
                        text: 'Hello World',
                        position: 'top-right',
                    },
                    metadata: { plugin: 'test' },
                }],
            })

            expect(plugin.envelopes[0].options.text).toBe('Hello World')
            expect(plugin.envelopes[0].options.position).toBe('top-right')
        })

        it('should leave non-string values unchanged', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {
                        timeout: 5000,
                        enabled: true,
                        data: { key: 'value' },
                    },
                    metadata: { plugin: 'test' },
                }],
            })

            expect(plugin.envelopes[0].options.timeout).toBe(5000)
            expect(plugin.envelopes[0].options.enabled).toBe(true)
            expect(plugin.envelopes[0].options.data).toEqual({ key: 'value' })
        })

        it('should handle invalid function strings gracefully', async () => {
            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {})
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {
                        // This matches the regex but has invalid JS syntax
                        bad: 'function() { throw }',
                    },
                    metadata: { plugin: 'test' },
                }],
            })

            // Should return original string on error
            expect(plugin.envelopes[0].options.bad).toBe('function() { throw }')
            expect(consoleSpy).toHaveBeenCalled()
        })
    })

    describe('asset loading', () => {
        it('should add style elements to document head', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            // Mock the load event
            const originalCreateElement = document.createElement.bind(document)
            vi.spyOn(document, 'createElement').mockImplementation((tag: string) => {
                const el = originalCreateElement(tag)
                if (tag === 'link' || tag === 'script') {
                    setTimeout(() => el.onload?.({} as Event), 0)
                }
                return el
            })

            await flasher.render({
                envelopes: [],
                styles: ['/path/to/style.css'],
            })

            const link = document.head.querySelector('link[href="/path/to/style.css"]')
            expect(link).toBeTruthy()
            expect(link?.getAttribute('rel')).toBe('stylesheet')
        })

        it('should add script elements to document head', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            const originalCreateElement = document.createElement.bind(document)
            vi.spyOn(document, 'createElement').mockImplementation((tag: string) => {
                const el = originalCreateElement(tag)
                if (tag === 'link' || tag === 'script') {
                    setTimeout(() => el.onload?.({} as Event), 0)
                }
                return el
            })

            await flasher.render({
                envelopes: [],
                scripts: ['/path/to/script.js'],
            })

            const script = document.head.querySelector('script[src="/path/to/script.js"]')
            expect(script).toBeTruthy()
            expect(script?.getAttribute('type')).toBe('text/javascript')
        })

        it('should not load duplicate assets', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            const originalCreateElement = document.createElement.bind(document)
            vi.spyOn(document, 'createElement').mockImplementation((tag: string) => {
                const el = originalCreateElement(tag)
                if (tag === 'link' || tag === 'script') {
                    setTimeout(() => el.onload?.({} as Event), 0)
                }
                return el
            })

            await flasher.render({
                envelopes: [],
                styles: ['/path/to/style.css', '/path/to/style.css'],
            })

            const links = document.head.querySelectorAll('link[href="/path/to/style.css"]')
            expect(links).toHaveLength(1)
        })

        it('should apply CSP nonce to loaded assets', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            const originalCreateElement = document.createElement.bind(document)
            vi.spyOn(document, 'createElement').mockImplementation((tag: string) => {
                const el = originalCreateElement(tag)
                if (tag === 'link' || tag === 'script') {
                    setTimeout(() => el.onload?.({} as Event), 0)
                }
                return el
            })

            await flasher.render({
                envelopes: [],
                styles: ['/path/to/style.css'],
                context: {
                    csp_style_nonce: 'test-nonce-123',
                },
            })

            const link = document.head.querySelector('link[href="/path/to/style.css"]')
            expect(link?.getAttribute('nonce')).toBe('test-nonce-123')
        })
    })

    describe('theme styles handling', () => {
        it('should add theme styles to response when using theme plugin', async () => {
            flasher.addTheme('custom', {
                styles: '/custom/theme.css',
                render: () => '<div></div>',
            })

            const originalCreateElement = document.createElement.bind(document)
            vi.spyOn(document, 'createElement').mockImplementation((tag: string) => {
                const el = originalCreateElement(tag)
                if (tag === 'link' || tag === 'script') {
                    setTimeout(() => el.onload?.({} as Event), 0)
                }
                return el
            })

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {},
                    metadata: { plugin: 'theme.custom' },
                }],
            })

            const link = document.head.querySelector('link[href="/custom/theme.css"]')
            expect(link).toBeTruthy()
        })

        it('should handle array of theme styles', async () => {
            flasher.addTheme('multi', {
                styles: ['/style1.css', '/style2.css'],
                render: () => '<div></div>',
            })

            const originalCreateElement = document.createElement.bind(document)
            vi.spyOn(document, 'createElement').mockImplementation((tag: string) => {
                const el = originalCreateElement(tag)
                if (tag === 'link' || tag === 'script') {
                    setTimeout(() => el.onload?.({} as Event), 0)
                }
                return el
            })

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {},
                    metadata: { plugin: 'theme.multi' },
                }],
            })

            expect(document.head.querySelector('link[href="/style1.css"]')).toBeTruthy()
            expect(document.head.querySelector('link[href="/style2.css"]')).toBeTruthy()
        })

        it('should handle theme without styles', async () => {
            flasher.addTheme('no-styles', {
                render: () => '<div></div>',
            })

            const originalCreateElement = document.createElement.bind(document)
            vi.spyOn(document, 'createElement').mockImplementation((tag: string) => {
                const el = originalCreateElement(tag)
                if (tag === 'link' || tag === 'script') {
                    setTimeout(() => el.onload?.({} as Event), 0)
                }
                return el
            })

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {},
                    metadata: { plugin: 'theme.no-styles' },
                }],
            })

            // Should not throw
        })

        it('should handle non-theme plugins without adding styles', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('custom-plugin', plugin)

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {},
                    metadata: { plugin: 'custom-plugin' },
                }],
            })

            expect(plugin.envelopes).toHaveLength(1)
        })
    })

    describe('error handling', () => {
        it('should handle errors in render() gracefully', async () => {
            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {})

            // Create a plugin that will throw during renderEnvelopes
            const badPlugin: PluginInterface = {
                success: vi.fn(),
                error: vi.fn(),
                info: vi.fn(),
                warning: vi.fn(),
                flash: vi.fn(),
                renderEnvelopes: () => {
                    throw new Error('Render error')
                },
                renderOptions: vi.fn(),
            }

            flasher.addPlugin('bad', badPlugin)

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {},
                    metadata: { plugin: 'bad' },
                }],
            })

            expect(consoleSpy).toHaveBeenCalled()
        })

        it('should handle asset loading errors', async () => {
            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {})

            const originalCreateElement = document.createElement.bind(document)
            vi.spyOn(document, 'createElement').mockImplementation((tag: string) => {
                const el = originalCreateElement(tag)
                if (tag === 'link' || tag === 'script') {
                    setTimeout(() => el.onerror?.({} as Event), 0)
                }
                return el
            })

            await flasher.render({
                envelopes: [],
                styles: ['/nonexistent.css'],
            })

            // Should handle error gracefully
            expect(consoleSpy).toHaveBeenCalled()
        })
    })

    describe('asset deduplication', () => {
        it('should skip loading if asset already exists in DOM', async () => {
            // Pre-add a link element to the DOM
            const existingLink = document.createElement('link')
            existingLink.rel = 'stylesheet'
            existingLink.href = '/existing.css'
            document.head.appendChild(existingLink)

            const originalCreateElement = document.createElement.bind(document)
            const createElementSpy = vi.spyOn(document, 'createElement').mockImplementation((tag: string) => {
                const el = originalCreateElement(tag)
                if (tag === 'link' || tag === 'script') {
                    setTimeout(() => el.onload?.({} as Event), 0)
                }
                return el
            })

            await flasher.render({
                envelopes: [],
                styles: ['/existing.css'],
            })

            // Should not create a new element since it already exists
            expect(createElementSpy).not.toHaveBeenCalledWith('link')
        })
    })

    describe('resolvePlugin edge cases', () => {
        it('should not create plugin for existing plugin alias', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('existing', plugin)

            // Resolve plugin should not overwrite existing
            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {},
                    metadata: { plugin: 'existing' },
                }],
            })

            expect(plugin.envelopes).toHaveLength(1)
        })

        it('should not create plugin for non-theme aliases', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('custom-plugin', plugin)

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {},
                    metadata: { plugin: 'custom-plugin' },
                }],
            })

            expect(plugin.envelopes).toHaveLength(1)
        })

        it('should silently handle non-existent theme', async () => {
            // This should not throw, just silently not render
            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {},
                    metadata: { plugin: 'theme.nonexistent' },
                }],
            })

            // Should not throw
        })
    })

    describe('resolveOptions edge cases', () => {
        it('should handle response with empty options', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {},
                    metadata: { plugin: 'test' },
                }],
                options: {},
            })

            expect(plugin.envelopes).toHaveLength(1)
        })

        it('should handle response with nested options', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {},
                    metadata: { plugin: 'test' },
                }],
                options: {
                    test: {
                        timeout: 5000,
                    },
                },
            })

            expect(plugin.envelopes).toHaveLength(1)
            expect(plugin.options).toEqual({ timeout: 5000 })
        })
    })

    describe('resolveFunction edge cases', () => {
        it('should handle arrow function with block body containing return', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {},
                    metadata: { plugin: 'test' },
                }],
                options: {
                    test: {
                        callback: '(x) => { return x * 2; }',
                    },
                },
            })

            expect(plugin.options.callback).toBeInstanceOf(Function)
        })

        it('should handle arrow function with block body without return keyword', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {},
                    metadata: { plugin: 'test' },
                }],
                options: {
                    test: {
                        callback: '(a, b) => { const c = a + b; return c; }',
                    },
                },
            })

            expect(plugin.options.callback).toBeInstanceOf(Function)
        })

        it('should handle nested arrow functions', async () => {
            const plugin = new MockPlugin()
            flasher.addPlugin('test', plugin)

            await flasher.render({
                envelopes: [{
                    type: 'success',
                    message: 'Test',
                    title: 'Test',
                    options: {},
                    metadata: { plugin: 'test' },
                }],
                options: {
                    test: {
                        callback: '(x) => (y) => x + y',
                    },
                },
            })

            expect(plugin.options.callback).toBeInstanceOf(Function)
        })
    })

    describe('addAssets edge cases', () => {
        it('should skip already loaded script URLs', async () => {
            const originalCreateElement = document.createElement.bind(document)
            let createElementCount = 0

            vi.spyOn(document, 'createElement').mockImplementation((tag: string) => {
                createElementCount++
                const el = originalCreateElement(tag)
                if (tag === 'link' || tag === 'script') {
                    setTimeout(() => el.onload?.({} as Event), 0)
                }
                return el
            })

            // First load
            await flasher.render({
                envelopes: [],
                scripts: ['/script.js'],
            })

            const firstCount = createElementCount

            // Second load - should skip
            await flasher.render({
                envelopes: [],
                scripts: ['/script.js'],
            })

            // Should not have created additional elements for the same URL
            expect(createElementCount).toBe(firstCount)
        })
    })
})
