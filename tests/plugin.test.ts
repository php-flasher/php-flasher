import { describe, expect, it, vi } from 'vitest'
import { AbstractPlugin } from '@flasher/flasher/plugin'
import type { Envelope, Options } from '@flasher/flasher/types'

// Concrete implementation for testing
class TestPlugin extends AbstractPlugin {
    public envelopes: Envelope[] = []
    public options: Options = {}

    renderEnvelopes(envelopes: Envelope[]): void {
        this.envelopes = envelopes
    }

    renderOptions(options: Options): void {
        this.options = options
    }
}

describe('AbstractPlugin', () => {
    describe('flash() argument normalization', () => {
        it('should handle basic call: flash(type, message)', () => {
            const plugin = new TestPlugin()
            plugin.flash('success', 'Hello World')

            expect(plugin.envelopes).toHaveLength(1)
            expect(plugin.envelopes[0]).toMatchObject({
                type: 'success',
                message: 'Hello World',
                title: 'Success',
                options: {},
            })
        })

        it('should handle call with title: flash(type, message, title)', () => {
            const plugin = new TestPlugin()
            plugin.flash('error', 'Something went wrong', 'Error Title')

            expect(plugin.envelopes[0]).toMatchObject({
                type: 'error',
                message: 'Something went wrong',
                title: 'Error Title',
            })
        })

        it('should handle call with options: flash(type, message, title, options)', () => {
            const plugin = new TestPlugin()
            plugin.flash('info', 'Info message', 'Info', { timeout: 5000 })

            expect(plugin.envelopes[0]).toMatchObject({
                type: 'info',
                message: 'Info message',
                title: 'Info',
                options: { timeout: 5000 },
            })
        })

        it('should handle object as first argument: flash({ type, message, title })', () => {
            const plugin = new TestPlugin()
            plugin.flash({
                type: 'warning',
                message: 'Warning message',
                title: 'Custom Title',
                customOption: true,
            })

            expect(plugin.envelopes[0]).toMatchObject({
                type: 'warning',
                message: 'Warning message',
                title: 'Custom Title',
                options: { customOption: true },
            })
        })

        it('should handle object as second argument: flash(type, { message, title })', () => {
            const plugin = new TestPlugin()
            plugin.flash('success', {
                message: 'Success message',
                title: 'Custom Title',
                extra: 'data',
            })

            expect(plugin.envelopes[0]).toMatchObject({
                type: 'success',
                message: 'Success message',
                title: 'Custom Title',
                options: { extra: 'data' },
            })
        })

        it('should handle object as third argument: flash(type, message, { title })', () => {
            const plugin = new TestPlugin()
            plugin.flash('info', 'Info message', { title: 'Object Title', key: 'value' })

            expect(plugin.envelopes[0]).toMatchObject({
                type: 'info',
                message: 'Info message',
                title: 'Object Title',
                options: { key: 'value' },
            })
        })

        it('should handle object as third argument without title: flash(type, message, { options })', () => {
            const plugin = new TestPlugin()
            plugin.flash('info', 'Info message', { timeout: 3000 })

            expect(plugin.envelopes[0]).toMatchObject({
                type: 'info',
                message: 'Info message',
                title: 'Info', // Auto-generated from type
                options: { timeout: 3000 },
            })
        })

        it('should merge options when third argument is object and fourth is also provided', () => {
            const plugin = new TestPlugin()
            plugin.flash('success', 'Message', { key1: 'value1' }, { key2: 'value2' })

            expect(plugin.envelopes[0].options).toMatchObject({
                key1: 'value1',
                key2: 'value2',
            })
        })

        it('should auto-generate title from type when not provided', () => {
            const plugin = new TestPlugin()

            plugin.flash('success', 'Message')
            expect(plugin.envelopes[0].title).toBe('Success')

            plugin.flash('error', 'Message')
            expect(plugin.envelopes[0].title).toBe('Error')

            plugin.flash('warning', 'Message')
            expect(plugin.envelopes[0].title).toBe('Warning')

            plugin.flash('info', 'Message')
            expect(plugin.envelopes[0].title).toBe('Info')
        })

        it('should handle null title by auto-generating', () => {
            const plugin = new TestPlugin()
            plugin.flash('success', 'Message', null as unknown as string)

            expect(plugin.envelopes[0].title).toBe('Success')
        })

        it('should handle undefined title by auto-generating', () => {
            const plugin = new TestPlugin()
            plugin.flash('success', 'Message', undefined)

            expect(plugin.envelopes[0].title).toBe('Success')
        })

        it('should throw error when type is missing', () => {
            const plugin = new TestPlugin()

            expect(() => plugin.flash({
                message: 'No type provided',
            })).toThrow('Type is required for notifications')
        })

        it('should throw error when message is missing', () => {
            const plugin = new TestPlugin()

            expect(() => plugin.flash({
                type: 'success',
            })).toThrow('Message is required for notifications')
        })

        it('should throw error when message is null', () => {
            const plugin = new TestPlugin()

            expect(() => plugin.flash('success', null as unknown as string)).toThrow('Message is required for notifications')
        })

        it('should include metadata with empty plugin string', () => {
            const plugin = new TestPlugin()
            plugin.flash('success', 'Message')

            expect(plugin.envelopes[0].metadata).toEqual({ plugin: '' })
        })
    })

    describe('convenience methods', () => {
        it('success() should call flash with type "success"', () => {
            const plugin = new TestPlugin()
            const flashSpy = vi.spyOn(plugin, 'flash')

            plugin.success('Success message', 'Title', { option: true })

            expect(flashSpy).toHaveBeenCalledWith('success', 'Success message', 'Title', { option: true })
        })

        it('error() should call flash with type "error"', () => {
            const plugin = new TestPlugin()
            const flashSpy = vi.spyOn(plugin, 'flash')

            plugin.error('Error message')

            expect(flashSpy).toHaveBeenCalledWith('error', 'Error message', undefined, undefined)
        })

        it('info() should call flash with type "info"', () => {
            const plugin = new TestPlugin()
            const flashSpy = vi.spyOn(plugin, 'flash')

            plugin.info('Info message', 'Info Title')

            expect(flashSpy).toHaveBeenCalledWith('info', 'Info message', 'Info Title', undefined)
        })

        it('warning() should call flash with type "warning"', () => {
            const plugin = new TestPlugin()
            const flashSpy = vi.spyOn(plugin, 'flash')

            plugin.warning({ message: 'Warning', title: 'Warn' })

            expect(flashSpy).toHaveBeenCalledWith('warning', { message: 'Warning', title: 'Warn' }, undefined, undefined)
        })
    })

    describe('renderEnvelopes and renderOptions calls', () => {
        it('should call renderOptions before renderEnvelopes', () => {
            const plugin = new TestPlugin()
            const callOrder: string[] = []

            vi.spyOn(plugin, 'renderOptions').mockImplementation(() => {
                callOrder.push('renderOptions')
            })
            vi.spyOn(plugin, 'renderEnvelopes').mockImplementation(() => {
                callOrder.push('renderEnvelopes')
            })

            plugin.flash('success', 'Message')

            expect(callOrder).toEqual(['renderOptions', 'renderEnvelopes'])
        })

        it('should pass empty object to renderOptions', () => {
            const plugin = new TestPlugin()
            const renderOptionsSpy = vi.spyOn(plugin, 'renderOptions')

            plugin.flash('success', 'Message')

            expect(renderOptionsSpy).toHaveBeenCalledWith({})
        })

        it('should pass envelope array to renderEnvelopes', () => {
            const plugin = new TestPlugin()
            const renderEnvelopesSpy = vi.spyOn(plugin, 'renderEnvelopes')

            plugin.flash('success', 'Message')

            expect(renderEnvelopesSpy).toHaveBeenCalledWith([
                expect.objectContaining({
                    type: 'success',
                    message: 'Message',
                }),
            ])
        })
    })
})
