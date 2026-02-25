import { beforeEach, describe, expect, it, vi } from 'vitest'
import type { Envelope } from '@flasher/flasher/types'

// Use vi.hoisted to define mocks that will be available during vi.mock hoisting
const { mockOpen, mockNotyfInstance, MockNotyf } = vi.hoisted(() => {
    const mockOpen = vi.fn()
    const mockNotyfInstance = {
        open: mockOpen,
        view: {
            container: { dataset: {} as DOMStringMap },
            a11yContainer: { dataset: {} as DOMStringMap },
        },
    }
    const MockNotyf = vi.fn().mockImplementation(() => mockNotyfInstance)
    return { mockOpen, mockNotyfInstance, MockNotyf }
})

vi.mock('notyf', () => ({
    Notyf: MockNotyf,
}))

vi.mock('notyf/notyf.min.css', () => ({}))

// Import after mocks
import NotyfPlugin from '@flasher/flasher-notyf/notyf'

const createEnvelope = (overrides: Partial<Envelope> = {}): Envelope => ({
    type: 'success',
    message: 'Test message',
    title: 'Test title',
    options: {},
    metadata: { plugin: 'notyf' },
    ...overrides,
})

describe('NotyfPlugin', () => {
    let plugin: NotyfPlugin

    beforeEach(() => {
        vi.clearAllMocks()
        // Restore mock implementations after clearing
        MockNotyf.mockImplementation(() => mockNotyfInstance)
        mockNotyfInstance.view.container.dataset = {} as DOMStringMap
        mockNotyfInstance.view.a11yContainer.dataset = {} as DOMStringMap
        plugin = new NotyfPlugin()
    })

    describe('renderEnvelopes', () => {
        it('should initialize Notyf on first render', () => {
            plugin.renderEnvelopes([createEnvelope()])

            expect(MockNotyf).toHaveBeenCalled()
        })

        it('should call notyf.open with envelope data', () => {
            plugin.renderEnvelopes([createEnvelope({
                type: 'success',
                message: 'Hello',
                title: 'Title',
            })])

            expect(mockOpen).toHaveBeenCalledWith(expect.objectContaining({
                type: 'success',
                message: 'Hello',
                title: 'Title',
            }))
        })

        it('should merge envelope options', () => {
            plugin.renderEnvelopes([createEnvelope({
                options: { duration: 5000, dismissible: true },
            })])

            expect(mockOpen).toHaveBeenCalledWith(expect.objectContaining({
                duration: 5000,
                dismissible: true,
            }))
        })

        it('should render multiple envelopes', () => {
            plugin.renderEnvelopes([
                createEnvelope({ message: 'First' }),
                createEnvelope({ message: 'Second' }),
            ])

            expect(mockOpen).toHaveBeenCalledTimes(2)
        })

        it('should set Turbo compatibility on containers', () => {
            plugin.renderEnvelopes([createEnvelope()])

            expect(mockNotyfInstance.view.container.dataset.turboTemporary).toBe('')
            expect(mockNotyfInstance.view.a11yContainer.dataset.turboTemporary).toBe('')
        })

        it('should handle errors gracefully', () => {
            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {})
            mockOpen.mockImplementationOnce(() => {
                throw new Error('Notyf error')
            })

            plugin.renderEnvelopes([createEnvelope()])

            expect(consoleSpy).toHaveBeenCalledWith(
                expect.stringContaining('Error rendering notification'),
                expect.any(Error),
                expect.any(Object),
            )
        })
    })

    describe('renderOptions', () => {
        it('should do nothing with null/undefined options', () => {
            plugin.renderOptions(null as unknown as Record<string, unknown>)
            plugin.renderOptions(undefined as unknown as Record<string, unknown>)
            // Should not throw
        })

        it('should initialize Notyf with options', () => {
            plugin.renderOptions({ duration: 8000, position: { x: 'left', y: 'bottom' } })

            expect(MockNotyf).toHaveBeenCalledWith(expect.objectContaining({
                duration: 8000,
                position: { x: 'left', y: 'bottom' },
            }))
        })

        it('should use default duration if not provided', () => {
            plugin.renderOptions({ position: { x: 'center', y: 'top' } })

            expect(MockNotyf).toHaveBeenCalledWith(expect.objectContaining({
                duration: 10000,
            }))
        })

        it('should add info type configuration', () => {
            plugin.renderOptions({})

            const callArgs = MockNotyf.mock.calls[0][0]
            const infoType = callArgs.types.find((t: any) => t.type === 'info')

            expect(infoType).toBeDefined()
            expect(infoType.className).toBe('notyf__toast--info')
            expect(infoType.background).toBe('#5784E5')
        })

        it('should add warning type configuration', () => {
            plugin.renderOptions({})

            const callArgs = MockNotyf.mock.calls[0][0]
            const warningType = callArgs.types.find((t: any) => t.type === 'warning')

            expect(warningType).toBeDefined()
            expect(warningType.className).toBe('notyf__toast--warning')
            expect(warningType.background).toBe('#E3A008')
        })

        it('should not duplicate types if already provided', () => {
            plugin.renderOptions({
                types: [
                    { type: 'info', background: '#custom' },
                ],
            })

            const callArgs = MockNotyf.mock.calls[0][0]
            const infoTypes = callArgs.types.filter((t: any) => t.type === 'info')

            expect(infoTypes).toHaveLength(1)
            expect(infoTypes[0].background).toBe('#custom')
        })
    })

    describe('default initialization', () => {
        it('should initialize with default options when rendering without prior options', () => {
            plugin.renderEnvelopes([createEnvelope()])

            expect(MockNotyf).toHaveBeenCalledWith(expect.objectContaining({
                duration: 10000,
                position: { x: 'right', y: 'top' },
                dismissible: true,
            }))
        })
    })

    describe('convenience methods (inherited from AbstractPlugin)', () => {
        it('success() should create success notification', () => {
            plugin.success('Success message')

            expect(mockOpen).toHaveBeenCalledWith(expect.objectContaining({
                type: 'success',
            }))
        })

        it('error() should create error notification', () => {
            plugin.error('Error message')

            expect(mockOpen).toHaveBeenCalledWith(expect.objectContaining({
                type: 'error',
            }))
        })

        it('info() should create info notification', () => {
            plugin.info('Info message')

            expect(mockOpen).toHaveBeenCalledWith(expect.objectContaining({
                type: 'info',
            }))
        })

        it('warning() should create warning notification', () => {
            plugin.warning('Warning message')

            expect(mockOpen).toHaveBeenCalledWith(expect.objectContaining({
                type: 'warning',
            }))
        })
    })
})
