import { beforeEach, describe, expect, it, vi } from 'vitest'
import type { Envelope } from '@flasher/flasher/types'

// Use vi.hoisted to define mocks that will be available during vi.mock hoisting
const { mockShow, mockNotyInstance, MockNoty } = vi.hoisted(() => {
    const mockShow = vi.fn()
    const mockNotyInstance = {
        show: mockShow,
        layoutDom: { dataset: {} as DOMStringMap },
    }
    const MockNoty = Object.assign(
        vi.fn().mockImplementation(() => mockNotyInstance),
        { overrideDefaults: vi.fn() },
    )
    return { mockShow, mockNotyInstance, MockNoty }
})

vi.mock('noty', () => ({
    default: MockNoty,
}))

// Import after mocks
import NotyPlugin from '@flasher/flasher-noty/noty'

const createEnvelope = (overrides: Partial<Envelope> = {}): Envelope => ({
    type: 'success',
    message: 'Test message',
    title: 'Test title',
    options: {},
    metadata: { plugin: 'noty' },
    ...overrides,
})

describe('NotyPlugin', () => {
    let plugin: NotyPlugin

    beforeEach(() => {
        vi.clearAllMocks()
        // Restore mock implementations after clearing
        MockNoty.mockImplementation(() => mockNotyInstance)
        mockNotyInstance.layoutDom = { dataset: {} as DOMStringMap }
        plugin = new NotyPlugin()
    })

    describe('renderEnvelopes', () => {
        it('should do nothing with empty envelopes', () => {
            plugin.renderEnvelopes([])

            expect(MockNoty).not.toHaveBeenCalled()
        })

        it('should do nothing with null/undefined envelopes', () => {
            plugin.renderEnvelopes(null as unknown as Envelope[])
            plugin.renderEnvelopes(undefined as unknown as Envelope[])

            expect(MockNoty).not.toHaveBeenCalled()
        })

        it('should create Noty instance with envelope data', () => {
            plugin.renderEnvelopes([createEnvelope({
                type: 'success',
                message: 'Hello World',
            })])

            expect(MockNoty).toHaveBeenCalledWith(expect.objectContaining({
                text: 'Hello World',
                type: 'success',
            }))
        })

        it('should call show() on Noty instance', () => {
            plugin.renderEnvelopes([createEnvelope()])

            expect(mockShow).toHaveBeenCalled()
        })

        it('should include default timeout option', () => {
            plugin.renderEnvelopes([createEnvelope()])

            expect(MockNoty).toHaveBeenCalledWith(expect.objectContaining({
                timeout: 10000,
            }))
        })

        it('should merge envelope options', () => {
            plugin.renderEnvelopes([createEnvelope({
                options: { timeout: 5000, layout: 'topRight' },
            })])

            expect(MockNoty).toHaveBeenCalledWith(expect.objectContaining({
                timeout: 5000,
                layout: 'topRight',
            }))
        })

        it('should render multiple envelopes', () => {
            plugin.renderEnvelopes([
                createEnvelope({ message: 'First' }),
                createEnvelope({ message: 'Second' }),
            ])

            expect(MockNoty).toHaveBeenCalledTimes(2)
            expect(mockShow).toHaveBeenCalledTimes(2)
        })

        it('should set Turbo compatibility on layoutDom', () => {
            plugin.renderEnvelopes([createEnvelope()])

            expect(mockNotyInstance.layoutDom.dataset.turboTemporary).toBe('')
        })

        it('should handle missing layoutDom gracefully', () => {
            MockNoty.mockImplementationOnce(() => ({
                show: mockShow,
                layoutDom: null,
            }))

            // Should not throw
            expect(() => plugin.renderEnvelopes([createEnvelope()])).not.toThrow()
        })

        it('should handle errors gracefully', () => {
            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {})
            MockNoty.mockImplementationOnce(() => {
                throw new Error('Noty error')
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

            expect(MockNoty.overrideDefaults).not.toHaveBeenCalled()
        })

        it('should call Noty.overrideDefaults with merged options', () => {
            plugin.renderOptions({ timeout: 8000, layout: 'bottomLeft' })

            expect(MockNoty.overrideDefaults).toHaveBeenCalledWith(expect.objectContaining({
                timeout: 8000,
                layout: 'bottomLeft',
            }))
        })

        it('should preserve existing default options', () => {
            plugin.renderOptions({ layout: 'topLeft' })
            plugin.renderOptions({ theme: 'mint' })

            // Get the last call arguments
            const lastCall = MockNoty.overrideDefaults.mock.calls[MockNoty.overrideDefaults.mock.calls.length - 1][0]

            expect(lastCall).toMatchObject({
                timeout: 10000, // default
                layout: 'topLeft', // from first call
                theme: 'mint', // from second call
            })
        })

        it('should use options in subsequent renderEnvelopes', () => {
            plugin.renderOptions({ animation: { open: 'fadeIn', close: 'fadeOut' } })
            plugin.renderEnvelopes([createEnvelope()])

            expect(MockNoty).toHaveBeenCalledWith(expect.objectContaining({
                animation: { open: 'fadeIn', close: 'fadeOut' },
            }))
        })
    })

    describe('convenience methods (inherited from AbstractPlugin)', () => {
        it('success() should create success notification', () => {
            plugin.success('Success message')

            expect(MockNoty).toHaveBeenCalledWith(expect.objectContaining({
                type: 'success',
            }))
        })

        it('error() should create error notification', () => {
            plugin.error('Error message')

            expect(MockNoty).toHaveBeenCalledWith(expect.objectContaining({
                type: 'error',
            }))
        })

        it('info() should create info notification', () => {
            plugin.info('Info message')

            expect(MockNoty).toHaveBeenCalledWith(expect.objectContaining({
                type: 'info',
            }))
        })

        it('warning() should create warning notification', () => {
            plugin.warning('Warning message')

            expect(MockNoty).toHaveBeenCalledWith(expect.objectContaining({
                type: 'warning',
            }))
        })
    })

    describe('notification types', () => {
        it('should support all standard Noty types', () => {
            const types = ['alert', 'success', 'error', 'warning', 'info']

            types.forEach((type) => {
                MockNoty.mockClear()
                plugin.renderEnvelopes([createEnvelope({ type })])

                expect(MockNoty).toHaveBeenCalledWith(expect.objectContaining({
                    type,
                }))
            })
        })
    })
})
