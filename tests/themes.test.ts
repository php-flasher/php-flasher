import { describe, expect, it, vi } from 'vitest'
import type { Envelope } from '@flasher/flasher/types'

// Mock SCSS imports
vi.mock('@flasher/flasher/themes/flasher/flasher.scss', () => ({}))

// Import theme after mocking
import { flasherTheme } from '@flasher/flasher/themes/flasher/flasher'

const createEnvelope = (overrides: Partial<Envelope> = {}): Envelope => ({
    type: 'success',
    message: 'Test message',
    title: 'Test title',
    options: {},
    metadata: { plugin: 'theme.flasher' },
    ...overrides,
})

describe('flasherTheme', () => {
    describe('render function', () => {
        it('should return valid HTML string', () => {
            const html = flasherTheme.render(createEnvelope())

            expect(html).toContain('fl-flasher')
            expect(html).toContain('fl-success')
        })

        it('should include message and title', () => {
            const html = flasherTheme.render(createEnvelope({
                title: 'My Title',
                message: 'My Message',
            }))

            expect(html).toContain('My Title')
            expect(html).toContain('My Message')
        })

        it('should apply type-specific class', () => {
            const types = ['success', 'error', 'warning', 'info']

            types.forEach((type) => {
                const html = flasherTheme.render(createEnvelope({ type }))
                expect(html).toContain(`fl-${type}`)
            })
        })

        it('should capitalize type for default title when title is empty', () => {
            const html = flasherTheme.render(createEnvelope({
                type: 'success',
                title: '',
            }))

            expect(html).toContain('Success')
        })

        it('should include close button', () => {
            const html = flasherTheme.render(createEnvelope())

            expect(html).toContain('fl-close')
            expect(html).toContain('&times;')
        })

        it('should include progress bar container', () => {
            const html = flasherTheme.render(createEnvelope())

            expect(html).toContain('fl-progress-bar')
        })

        it('should include icon container', () => {
            const html = flasherTheme.render(createEnvelope())

            expect(html).toContain('fl-icon')
        })
    })

    describe('accessibility', () => {
        it('should have role="alert" for error type', () => {
            const html = flasherTheme.render(createEnvelope({ type: 'error' }))

            expect(html).toContain('role="alert"')
        })

        it('should have role="alert" for warning type', () => {
            const html = flasherTheme.render(createEnvelope({ type: 'warning' }))

            expect(html).toContain('role="alert"')
        })

        it('should have role="status" for success type', () => {
            const html = flasherTheme.render(createEnvelope({ type: 'success' }))

            expect(html).toContain('role="status"')
        })

        it('should have role="status" for info type', () => {
            const html = flasherTheme.render(createEnvelope({ type: 'info' }))

            expect(html).toContain('role="status"')
        })

        it('should have aria-live="assertive" for error/warning', () => {
            const errorHtml = flasherTheme.render(createEnvelope({ type: 'error' }))
            const warningHtml = flasherTheme.render(createEnvelope({ type: 'warning' }))

            expect(errorHtml).toContain('aria-live="assertive"')
            expect(warningHtml).toContain('aria-live="assertive"')
        })

        it('should have aria-live="polite" for success/info', () => {
            const successHtml = flasherTheme.render(createEnvelope({ type: 'success' }))
            const infoHtml = flasherTheme.render(createEnvelope({ type: 'info' }))

            expect(successHtml).toContain('aria-live="polite"')
            expect(infoHtml).toContain('aria-live="polite"')
        })

        it('should have aria-atomic="true"', () => {
            const html = flasherTheme.render(createEnvelope())

            expect(html).toContain('aria-atomic="true"')
        })

        it('should have accessible close button label', () => {
            const html = flasherTheme.render(createEnvelope({ type: 'success' }))

            expect(html).toContain('aria-label="Close success message"')
        })
    })

    describe('HTML structure', () => {
        it('should have content wrapper', () => {
            const html = flasherTheme.render(createEnvelope())

            expect(html).toContain('fl-content')
        })

        it('should have title element with fl-title class', () => {
            const html = flasherTheme.render(createEnvelope())

            expect(html).toContain('fl-title')
            expect(html).toContain('<strong')
        })

        it('should have message element with fl-message class', () => {
            const html = flasherTheme.render(createEnvelope())

            expect(html).toContain('fl-message')
            expect(html).toContain('<span')
        })
    })
})

describe('Theme contract', () => {
    it('flasherTheme should have required render function', () => {
        expect(typeof flasherTheme.render).toBe('function')
    })

    it('render should return string', () => {
        const result = flasherTheme.render(createEnvelope())
        expect(typeof result).toBe('string')
    })

    it('should handle all standard notification types', () => {
        const types = ['success', 'error', 'warning', 'info']

        types.forEach((type) => {
            expect(() => flasherTheme.render(createEnvelope({ type }))).not.toThrow()
        })
    })

    it('should handle custom notification types', () => {
        expect(() => flasherTheme.render(createEnvelope({ type: 'custom' }))).not.toThrow()
    })

    it('should handle empty message', () => {
        expect(() => flasherTheme.render(createEnvelope({ message: '' }))).not.toThrow()
    })

    it('should handle empty title', () => {
        expect(() => flasherTheme.render(createEnvelope({ title: '' }))).not.toThrow()
    })

    it('should handle special characters in message', () => {
        const html = flasherTheme.render(createEnvelope({
            message: 'Test <script>alert("xss")</script>',
        }))

        // Theme doesn't escape - that's FlasherPlugin's responsibility
        expect(html).toContain('Test <script>alert("xss")</script>')
    })
})
