import { beforeEach, describe, expect, it, vi } from 'vitest'
import type { Envelope } from '@flasher/flasher/types'

// Use vi.hoisted to define mocks that will be available during vi.mock hoisting
const { mockFire, mockMixin, mockIsVisible, mockGetPopup, mockClose } = vi.hoisted(() => {
    const mockFire = vi.fn().mockResolvedValue({ isConfirmed: true })
    const mockMixin = vi.fn().mockReturnValue({ fire: mockFire })
    const mockIsVisible = vi.fn().mockReturnValue(false)
    const mockGetPopup = vi.fn().mockReturnValue({ style: { setProperty: vi.fn() } })
    const mockClose = vi.fn()
    return { mockFire, mockMixin, mockIsVisible, mockGetPopup, mockClose }
})

vi.mock('sweetalert2', () => ({
    default: {
        mixin: mockMixin,
        isVisible: mockIsVisible,
        getPopup: mockGetPopup,
        close: mockClose,
    },
}))

// Import after mocks
import SweetAlertPlugin from '@flasher/flasher-sweetalert/sweetalert'

const createEnvelope = (overrides: Partial<Envelope> = {}): Envelope => ({
    type: 'success',
    message: 'Test message',
    title: 'Test title',
    options: {},
    metadata: { plugin: 'sweetalert' },
    ...overrides,
})

describe('SweetAlertPlugin', () => {
    let plugin: SweetAlertPlugin

    beforeEach(() => {
        vi.clearAllMocks()
        // Restore mock implementations after clearing
        mockFire.mockResolvedValue({ isConfirmed: true })
        mockMixin.mockReturnValue({ fire: mockFire })
        mockIsVisible.mockReturnValue(false)
        mockGetPopup.mockReturnValue({ style: { setProperty: vi.fn() } })
        plugin = new SweetAlertPlugin()
    })

    describe('renderEnvelopes', () => {
        it('should initialize SweetAlert on first render', async () => {
            await plugin.renderEnvelopes([createEnvelope()])

            expect(mockMixin).toHaveBeenCalled()
        })

        it('should call fire with envelope options', async () => {
            await plugin.renderEnvelopes([createEnvelope({
                type: 'success',
                message: 'Hello World',
            })])

            expect(mockFire).toHaveBeenCalledWith(expect.objectContaining({
                icon: 'success',
                text: 'Hello World',
            }))
        })

        it('should use envelope.type as icon by default', async () => {
            await plugin.renderEnvelopes([createEnvelope({ type: 'error' })])

            expect(mockFire).toHaveBeenCalledWith(expect.objectContaining({
                icon: 'error',
            }))
        })

        it('should use envelope.message as text by default', async () => {
            await plugin.renderEnvelopes([createEnvelope({ message: 'Custom message' })])

            expect(mockFire).toHaveBeenCalledWith(expect.objectContaining({
                text: 'Custom message',
            }))
        })

        it('should allow overriding icon via options', async () => {
            await plugin.renderEnvelopes([createEnvelope({
                type: 'success',
                options: { icon: 'warning' },
            })])

            expect(mockFire).toHaveBeenCalledWith(expect.objectContaining({
                icon: 'warning',
            }))
        })

        it('should allow overriding text via options', async () => {
            await plugin.renderEnvelopes([createEnvelope({
                message: 'Original',
                options: { text: 'Override' },
            })])

            expect(mockFire).toHaveBeenCalledWith(expect.objectContaining({
                text: 'Override',
            }))
        })

        it('should render envelopes sequentially', async () => {
            const callOrder: string[] = []

            mockFire
                .mockImplementationOnce(async () => {
                    callOrder.push('first')
                    return { isConfirmed: true }
                })
                .mockImplementationOnce(async () => {
                    callOrder.push('second')
                    return { isConfirmed: true }
                })

            await plugin.renderEnvelopes([
                createEnvelope({ message: 'First' }),
                createEnvelope({ message: 'Second' }),
            ])

            expect(callOrder).toEqual(['first', 'second'])
        })

        it('should dispatch promise event after fire', async () => {
            const eventHandler = vi.fn()
            window.addEventListener('flasher:sweetalert:promise', eventHandler)

            await plugin.renderEnvelopes([createEnvelope()])

            expect(eventHandler).toHaveBeenCalledWith(expect.objectContaining({
                detail: expect.objectContaining({
                    promise: { isConfirmed: true },
                    envelope: expect.any(Object),
                }),
            }))

            window.removeEventListener('flasher:sweetalert:promise', eventHandler)
        })

        it('should handle errors gracefully', async () => {
            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {})
            mockFire.mockRejectedValueOnce(new Error('Swal error'))

            await plugin.renderEnvelopes([createEnvelope()])

            expect(consoleSpy).toHaveBeenCalledWith(
                expect.stringContaining('Error rendering envelope'),
                expect.any(Error),
                expect.any(Object),
            )
        })
    })

    describe('renderOptions', () => {
        it('should create mixin with options', () => {
            plugin.renderOptions({ timer: 5000, showConfirmButton: false })

            expect(mockMixin).toHaveBeenCalledWith(expect.objectContaining({
                timer: 5000,
                showConfirmButton: false,
            }))
        })

        it('should use default timer if not provided', () => {
            plugin.renderOptions({})

            expect(mockMixin).toHaveBeenCalledWith(expect.objectContaining({
                timer: 10000,
            }))
        })

        it('should use default timerProgressBar if not provided', () => {
            plugin.renderOptions({})

            expect(mockMixin).toHaveBeenCalledWith(expect.objectContaining({
                timerProgressBar: true,
            }))
        })

        it('should setup Turbo compatibility', () => {
            const addEventListenerSpy = vi.spyOn(document, 'addEventListener')

            plugin.renderOptions({})

            expect(addEventListenerSpy).toHaveBeenCalledWith(
                'turbo:before-cache',
                expect.any(Function),
            )
        })

        it('should handle errors gracefully', () => {
            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {})
            mockMixin.mockImplementationOnce(() => {
                throw new Error('Mixin error')
            })

            plugin.renderOptions({ timer: 5000 })

            expect(consoleSpy).toHaveBeenCalledWith(
                expect.stringContaining('Error applying options'),
                expect.any(Error),
            )
        })
    })

    describe('Turbo compatibility', () => {
        it('should close visible Swal on turbo:before-cache', () => {
            mockIsVisible.mockReturnValueOnce(true)

            plugin.renderOptions({})

            // Simulate turbo:before-cache event
            document.dispatchEvent(new Event('turbo:before-cache'))

            expect(mockClose).toHaveBeenCalled()
        })

        it('should set animation duration to 0ms before closing', () => {
            mockIsVisible.mockReturnValueOnce(true)
            const mockSetProperty = vi.fn()
            mockGetPopup.mockReturnValueOnce({ style: { setProperty: mockSetProperty } })

            plugin.renderOptions({})

            document.dispatchEvent(new Event('turbo:before-cache'))

            expect(mockSetProperty).toHaveBeenCalledWith('animation-duration', '0ms')
        })

        it('should not close if Swal is not visible', () => {
            mockIsVisible.mockReturnValueOnce(false)

            plugin.renderOptions({})

            document.dispatchEvent(new Event('turbo:before-cache'))

            expect(mockClose).not.toHaveBeenCalled()
        })
    })

    describe('default initialization', () => {
        it('should initialize with default options when rendering without prior options', async () => {
            await plugin.renderEnvelopes([createEnvelope()])

            expect(mockMixin).toHaveBeenCalledWith(expect.objectContaining({
                timer: 10000,
                timerProgressBar: true,
            }))
        })
    })

    describe('convenience methods (inherited from AbstractPlugin)', () => {
        it('success() should create success notification', async () => {
            await plugin.success('Success message')

            expect(mockFire).toHaveBeenCalledWith(expect.objectContaining({
                icon: 'success',
            }))
        })

        it('error() should create error notification', async () => {
            await plugin.error('Error message')

            expect(mockFire).toHaveBeenCalledWith(expect.objectContaining({
                icon: 'error',
            }))
        })
    })
})
