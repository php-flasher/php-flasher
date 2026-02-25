import { beforeEach, describe, expect, it, vi } from 'vitest'
import type { Envelope } from '@flasher/flasher/types'

// Use vi.hoisted to define mocks that will be available during vi.mock hoisting
const { mockToastr, mockJQuery } = vi.hoisted(() => {
    const mockToastr = {
        success: vi.fn().mockReturnValue({ parent: vi.fn().mockReturnValue({ attr: vi.fn() }) }),
        error: vi.fn().mockReturnValue({ parent: vi.fn().mockReturnValue({ attr: vi.fn() }) }),
        info: vi.fn().mockReturnValue({ parent: vi.fn().mockReturnValue({ attr: vi.fn() }) }),
        warning: vi.fn().mockReturnValue({ parent: vi.fn().mockReturnValue({ attr: vi.fn() }) }),
        options: {} as Record<string, unknown>,
    }
    const mockJQuery = vi.fn()
    return { mockToastr, mockJQuery }
})

vi.mock('toastr', () => ({
    default: mockToastr,
}))

// Import after mocks are set up
import ToastrPlugin from '@flasher/flasher-toastr/toastr'

const createEnvelope = (overrides: Partial<Envelope> = {}): Envelope => ({
    type: 'success',
    message: 'Test message',
    title: 'Test title',
    options: {},
    metadata: { plugin: 'toastr' },
    ...overrides,
})

describe('ToastrPlugin', () => {
    let plugin: ToastrPlugin

    beforeEach(() => {
        plugin = new ToastrPlugin()
        vi.clearAllMocks()
        mockToastr.options = {}

        // Set up jQuery mock
        ;(window as any).jQuery = mockJQuery
        ;(window as any).$ = mockJQuery
    })

    describe('renderEnvelopes', () => {
        it('should do nothing with empty envelopes', () => {
            plugin.renderEnvelopes([])

            expect(mockToastr.success).not.toHaveBeenCalled()
        })

        it('should do nothing with null/undefined envelopes', () => {
            plugin.renderEnvelopes(null as unknown as Envelope[])
            plugin.renderEnvelopes(undefined as unknown as Envelope[])

            expect(mockToastr.success).not.toHaveBeenCalled()
        })

        it('should call toastr with correct type', () => {
            plugin.renderEnvelopes([createEnvelope({ type: 'success' })])
            expect(mockToastr.success).toHaveBeenCalled()

            plugin.renderEnvelopes([createEnvelope({ type: 'error' })])
            expect(mockToastr.error).toHaveBeenCalled()

            plugin.renderEnvelopes([createEnvelope({ type: 'info' })])
            expect(mockToastr.info).toHaveBeenCalled()

            plugin.renderEnvelopes([createEnvelope({ type: 'warning' })])
            expect(mockToastr.warning).toHaveBeenCalled()
        })

        it('should pass message, title, and options to toastr', () => {
            plugin.renderEnvelopes([createEnvelope({
                message: 'Hello World',
                title: 'Greeting',
                options: { timeOut: 5000 },
            })])

            expect(mockToastr.success).toHaveBeenCalledWith(
                'Hello World',
                'Greeting',
                { timeOut: 5000 },
            )
        })

        it('should render multiple envelopes', () => {
            plugin.renderEnvelopes([
                createEnvelope({ type: 'success', message: 'First' }),
                createEnvelope({ type: 'error', message: 'Second' }),
            ])

            expect(mockToastr.success).toHaveBeenCalledTimes(1)
            expect(mockToastr.error).toHaveBeenCalledTimes(1)
        })

        it('should set Turbo compatibility attribute', () => {
            const mockParent = { attr: vi.fn() }
            mockToastr.success.mockReturnValue({ parent: () => mockParent })

            plugin.renderEnvelopes([createEnvelope()])

            expect(mockParent.attr).toHaveBeenCalledWith('data-turbo-temporary', '')
        })

        it('should log error when jQuery is not available', () => {
            delete (window as any).jQuery
            delete (window as any).$

            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {})

            plugin.renderEnvelopes([createEnvelope()])

            expect(consoleSpy).toHaveBeenCalledWith(
                expect.stringContaining('jQuery is required'),
            )
            expect(mockToastr.success).not.toHaveBeenCalled()

            // Restore jQuery for other tests
            ;(window as any).jQuery = mockJQuery
            ;(window as any).$ = mockJQuery
        })

        it('should handle toastr errors gracefully', () => {
            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {})
            mockToastr.success.mockImplementationOnce(() => {
                throw new Error('Toastr error')
            })

            plugin.renderEnvelopes([createEnvelope()])

            expect(consoleSpy).toHaveBeenCalledWith(
                expect.stringContaining('Error rendering notification'),
                expect.any(Error),
                expect.any(Object),
            )
        })

        it('should handle missing parent method gracefully', () => {
            mockToastr.success.mockReturnValueOnce({})

            // Should not throw
            expect(() => plugin.renderEnvelopes([createEnvelope()])).not.toThrow()
        })

        it('should handle parent() returning null gracefully', () => {
            mockToastr.success.mockReturnValueOnce({ parent: () => null })

            // Should not throw
            expect(() => plugin.renderEnvelopes([createEnvelope()])).not.toThrow()
        })
    })

    describe('renderOptions', () => {
        it('should set toastr options with defaults', () => {
            plugin.renderOptions({ closeButton: true })

            expect(mockToastr.options).toMatchObject({
                timeOut: 10000,
                progressBar: true,
                closeButton: true,
            })
        })

        it('should override default timeOut', () => {
            plugin.renderOptions({ timeOut: 5000 })

            expect(mockToastr.options.timeOut).toBe(5000)
        })

        it('should override default progressBar', () => {
            plugin.renderOptions({ progressBar: false })

            expect(mockToastr.options.progressBar).toBe(false)
        })

        it('should log error when jQuery is not available', () => {
            delete (window as any).jQuery
            delete (window as any).$

            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {})

            plugin.renderOptions({ timeOut: 5000 })

            expect(consoleSpy).toHaveBeenCalledWith(
                expect.stringContaining('jQuery is required'),
            )

            // Restore jQuery
            ;(window as any).jQuery = mockJQuery
            ;(window as any).$ = mockJQuery
        })
    })

    describe('convenience methods (inherited from AbstractPlugin)', () => {
        it('success() should create success notification', () => {
            plugin.success('Success message')

            expect(mockToastr.success).toHaveBeenCalled()
        })

        it('error() should create error notification', () => {
            plugin.error('Error message')

            expect(mockToastr.error).toHaveBeenCalled()
        })

        it('info() should create info notification', () => {
            plugin.info('Info message')

            expect(mockToastr.info).toHaveBeenCalled()
        })

        it('warning() should create warning notification', () => {
            plugin.warning('Warning message')

            expect(mockToastr.warning).toHaveBeenCalled()
        })
    })
})
