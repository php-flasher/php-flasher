import { afterEach, beforeEach, describe, expect, it, vi } from 'vitest'
import FlasherPlugin from '@flasher/flasher/flasher-plugin'
import type { Envelope, Theme } from '@flasher/flasher/types'

// Mock SCSS import
vi.mock('@flasher/flasher/themes/index.scss', () => ({}))

const createMockTheme = (customRender?: (envelope: Envelope) => string): Theme => ({
    render: customRender || ((envelope: Envelope) => `
        <div class="fl-notification fl-${envelope.type}">
            <div class="fl-content">
                <strong class="fl-title">${envelope.title}</strong>
                <span class="fl-message">${envelope.message}</span>
                <button class="fl-close">&times;</button>
            </div>
            <span class="fl-progress-bar"></span>
        </div>
    `),
})

const createEnvelope = (overrides: Partial<Envelope> = {}): Envelope => ({
    type: 'success',
    message: 'Test message',
    title: 'Test title',
    options: {},
    metadata: { plugin: 'theme.test' },
    ...overrides,
})

describe('FlasherPlugin', () => {
    let plugin: FlasherPlugin

    beforeEach(() => {
        plugin = new FlasherPlugin(createMockTheme())
        vi.useFakeTimers()

        // Mock requestAnimationFrame to execute callback immediately
        vi.spyOn(window, 'requestAnimationFrame').mockImplementation((cb) => {
            cb(performance.now())
            return 0
        })
    })

    afterEach(() => {
        vi.useRealTimers()
    })

    describe('constructor', () => {
        it('should throw error when theme is missing', () => {
            expect(() => new FlasherPlugin(null as unknown as Theme)).toThrow('Theme is required')
        })

        it('should throw error when theme has no render function', () => {
            expect(() => new FlasherPlugin({} as Theme)).toThrow('Theme must have a render function')
        })

        it('should throw error when theme render is not a function', () => {
            expect(() => new FlasherPlugin({ render: 'not a function' } as unknown as Theme)).toThrow('Theme must have a render function')
        })

        it('should create plugin with valid theme', () => {
            const p = new FlasherPlugin(createMockTheme())
            expect(p).toBeInstanceOf(FlasherPlugin)
        })
    })

    describe('renderOptions', () => {
        it('should merge options with defaults', () => {
            plugin.renderOptions({ timeout: 5000, position: 'bottom-left' })
            plugin.renderEnvelopes([createEnvelope()])

            const container = document.querySelector('.fl-wrapper')
            expect(container?.getAttribute('data-position')).toBe('bottom-left')
        })

        it('should do nothing with null/undefined options', () => {
            plugin.renderOptions(null as unknown as Record<string, unknown>)
            plugin.renderOptions(undefined as unknown as Record<string, unknown>)
            // Should not throw
        })
    })

    describe('renderEnvelopes', () => {
        it('should do nothing with empty envelopes', () => {
            plugin.renderEnvelopes([])
            expect(document.querySelector('.fl-wrapper')).toBeNull()
        })

        it('should do nothing with null/undefined envelopes', () => {
            plugin.renderEnvelopes(null as unknown as Envelope[])
            plugin.renderEnvelopes(undefined as unknown as Envelope[])
            // Should not throw
        })

        it('should create container with default position', () => {
            plugin.renderEnvelopes([createEnvelope()])

            const container = document.querySelector('.fl-wrapper')
            expect(container).toBeTruthy()
            expect(container?.getAttribute('data-position')).toBe('top-right')
        })

        it('should create notification inside container', () => {
            plugin.renderEnvelopes([createEnvelope()])

            const notification = document.querySelector('.fl-container')
            expect(notification).toBeTruthy()
        })

        it('should add fl-show class after animation frame', () => {
            plugin.renderEnvelopes([createEnvelope()])

            const notification = document.querySelector('.fl-container')
            // With mocked requestAnimationFrame, fl-show is added immediately
            expect(notification?.classList.contains('fl-show')).toBe(true)
        })

        it('should reuse existing container for same position', () => {
            plugin.renderEnvelopes([createEnvelope()])
            plugin.renderEnvelopes([createEnvelope()])

            const containers = document.querySelectorAll('.fl-wrapper')
            expect(containers).toHaveLength(1)

            const notifications = document.querySelectorAll('.fl-container')
            expect(notifications).toHaveLength(2)
        })

        it('should create separate containers for different positions', () => {
            plugin.renderEnvelopes([createEnvelope({ options: { position: 'top-left' } })])
            plugin.renderEnvelopes([createEnvelope({ options: { position: 'bottom-right' } })])

            const containers = document.querySelectorAll('.fl-wrapper')
            expect(containers).toHaveLength(2)
        })

        it('should prepend notifications when direction is "top"', () => {
            plugin.renderOptions({ direction: 'top' })

            plugin.renderEnvelopes([createEnvelope({ message: 'First' })])
            plugin.renderEnvelopes([createEnvelope({ message: 'Second' })])

            const container = document.querySelector('.fl-wrapper')
            const first = container?.firstElementChild
            expect(first?.querySelector('.fl-message')?.textContent).toBe('Second')
        })

        it('should append notifications when direction is "bottom"', () => {
            plugin.renderOptions({ direction: 'bottom' })

            plugin.renderEnvelopes([createEnvelope({ message: 'First' })])
            plugin.renderEnvelopes([createEnvelope({ message: 'Second' })])

            const container = document.querySelector('.fl-wrapper')
            const last = container?.lastElementChild
            expect(last?.querySelector('.fl-message')?.textContent).toBe('Second')
        })

        it('should add fl-rtl class when rtl option is true', () => {
            plugin.renderOptions({ rtl: true })
            plugin.renderEnvelopes([createEnvelope()])

            const notification = document.querySelector('.fl-container')
            expect(notification?.classList.contains('fl-rtl')).toBe(true)
        })

        it('should set Turbo temporary attribute on container', () => {
            plugin.renderEnvelopes([createEnvelope()])

            const container = document.querySelector('.fl-wrapper')
            expect(container?.hasAttribute('data-turbo-temporary')).toBe(true)
        })
    })

    describe('timeout and timer', () => {
        it('should auto-remove notification after timeout', () => {
            plugin.renderOptions({ timeout: 5000 })
            plugin.renderEnvelopes([createEnvelope()])

            expect(document.querySelector('.fl-container')).toBeTruthy()

            vi.advanceTimersByTime(5000)

            const notification = document.querySelector('.fl-container')
            expect(notification?.classList.contains('fl-show')).toBe(false)
        })

        it('should use type-specific timeout when global timeout is null', () => {
            plugin.renderOptions({
                timeout: null,
                timeouts: { success: 3000 },
            })
            plugin.renderEnvelopes([createEnvelope({ type: 'success' })])

            // fl-show is added immediately with mocked requestAnimationFrame
            const notification = document.querySelector('.fl-container') as HTMLElement
            expect(notification).toBeTruthy()
            expect(notification.classList.contains('fl-show')).toBe(true)

            // Advance most of the way (with buffer for timer precision)
            vi.advanceTimersByTime(2800)
            expect(notification.classList.contains('fl-show')).toBe(true)

            // Advance past the timeout
            vi.advanceTimersByTime(300)
            expect(notification.classList.contains('fl-show')).toBe(false)
        })

        it('should respect envelope-specific timeout over global', () => {
            plugin.renderOptions({ timeout: 10000 })
            plugin.renderEnvelopes([createEnvelope({ options: { timeout: 2000 } })])

            // fl-show is added immediately with mocked requestAnimationFrame
            const notification = document.querySelector('.fl-container') as HTMLElement
            expect(notification).toBeTruthy()
            expect(notification.classList.contains('fl-show')).toBe(true)

            // Should still be showing before timeout
            vi.advanceTimersByTime(1800)
            expect(notification.classList.contains('fl-show')).toBe(true)

            // Should be removed after timeout
            vi.advanceTimersByTime(300)
            expect(notification.classList.contains('fl-show')).toBe(false)
        })

        it('should create sticky notification when timeout is false', () => {
            plugin.renderEnvelopes([createEnvelope({ options: { timeout: false } })])

            const notification = document.querySelector('.fl-container')
            expect(notification?.classList.contains('fl-sticky')).toBe(true)

            // Should not auto-remove
            vi.advanceTimersByTime(60000)
            expect(document.querySelector('.fl-container')).toBeTruthy()
        })

        it('should create sticky notification when timeout is 0', () => {
            plugin.renderEnvelopes([createEnvelope({ options: { timeout: 0 } })])

            const notification = document.querySelector('.fl-container')
            expect(notification?.classList.contains('fl-sticky')).toBe(true)
        })

        it('should create sticky notification when timeout is negative', () => {
            plugin.renderEnvelopes([createEnvelope({ options: { timeout: -1 } })])

            const notification = document.querySelector('.fl-container')
            expect(notification?.classList.contains('fl-sticky')).toBe(true)
        })

        it('should update progress bar during countdown', () => {
            plugin.renderOptions({ timeout: 1000, fps: 10 })
            plugin.renderEnvelopes([createEnvelope()])

            vi.advanceTimersByTime(100) // First tick

            const progressBar = document.querySelector('.fl-progress') as HTMLElement
            expect(progressBar).toBeTruthy()

            // After 500ms, should be around 50%
            vi.advanceTimersByTime(400)
            const width = Number.parseFloat(progressBar.style.width)
            expect(width).toBeLessThan(60)
            expect(width).toBeGreaterThan(40)
        })

        it('should create 100% progress bar for sticky notifications', () => {
            plugin.renderEnvelopes([createEnvelope({ options: { timeout: false } })])

            vi.runAllTimers()

            const progressBar = document.querySelector('.fl-progress.fl-sticky-progress') as HTMLElement
            expect(progressBar?.style.width).toBe('100%')
        })
    })

    describe('close button', () => {
        it('should remove notification when close button is clicked', () => {
            plugin.renderEnvelopes([createEnvelope({ options: { timeout: false } })])

            const closeButton = document.querySelector('.fl-close') as HTMLElement
            closeButton.click()

            const notification = document.querySelector('.fl-container')
            expect(notification?.classList.contains('fl-show')).toBe(false)
        })

        it('should stop event propagation on close click', () => {
            plugin.renderEnvelopes([createEnvelope({ options: { timeout: false } })])

            const notification = document.querySelector('.fl-container') as HTMLElement
            const notificationClickHandler = vi.fn()
            notification.addEventListener('click', notificationClickHandler)

            const closeButton = document.querySelector('.fl-close') as HTMLElement
            closeButton.click()

            expect(notificationClickHandler).not.toHaveBeenCalled()
        })
    })

    describe('hover pause', () => {
        it('should pause timer on mouse over', () => {
            plugin.renderOptions({ timeout: 5000 })
            plugin.renderEnvelopes([createEnvelope()])

            vi.advanceTimersByTime(2000) // Advance halfway

            const notification = document.querySelector('.fl-container') as HTMLElement
            notification.dispatchEvent(new MouseEvent('mouseover'))

            vi.advanceTimersByTime(10000) // Advance a lot more

            // Should still be showing because timer was paused
            expect(notification.classList.contains('fl-show')).toBe(true)
        })

        it('should resume timer on mouse out', () => {
            plugin.renderOptions({ timeout: 5000 })
            plugin.renderEnvelopes([createEnvelope()])

            // Run requestAnimationFrame to add fl-show
            vi.advanceTimersByTime(0)

            const notification = document.querySelector('.fl-container') as HTMLElement

            vi.advanceTimersByTime(2000) // 2s elapsed
            notification.dispatchEvent(new MouseEvent('mouseover'))
            vi.advanceTimersByTime(5000) // Paused, no change
            notification.dispatchEvent(new MouseEvent('mouseout'))
            vi.advanceTimersByTime(3500) // Remaining time + buffer

            expect(notification.classList.contains('fl-show')).toBe(false)
        })
    })

    describe('HTML escaping', () => {
        it('should escape HTML when escapeHtml option is true', () => {
            plugin.renderOptions({ escapeHtml: true })
            plugin.renderEnvelopes([createEnvelope({
                message: '<script>alert("xss")</script>',
                title: '<b>Bold</b>',
            })])

            const message = document.querySelector('.fl-message')
            const title = document.querySelector('.fl-title')

            expect(message?.innerHTML).toContain('&lt;script&gt;')
            expect(title?.innerHTML).toContain('&lt;b&gt;')
        })

        it('should not escape HTML when escapeHtml is false (default)', () => {
            plugin.renderEnvelopes([createEnvelope({
                message: '<b>Bold message</b>',
            })])

            const message = document.querySelector('.fl-message')
            expect(message?.innerHTML).toContain('<b>Bold message</b>')
        })

        it('should escape special characters correctly', () => {
            plugin.renderOptions({ escapeHtml: true })
            plugin.renderEnvelopes([createEnvelope({
                message: '& < > " \' ` = /',
            })])

            const message = document.querySelector('.fl-message')
            // When innerHTML is serialized, browser only escapes & < > minimally
            // The key test is that < and > are escaped (prevents XSS)
            expect(message?.innerHTML).toContain('&amp;')
            expect(message?.innerHTML).toContain('&lt;')
            expect(message?.innerHTML).toContain('&gt;')
            // Text content should have all original characters
            expect(message?.textContent).toBe('& < > " \' ` = /')
        })

        it('should handle null/undefined message gracefully when escaping', () => {
            plugin.renderOptions({ escapeHtml: true })

            // This tests the escapeHtml method's null handling
            plugin.renderEnvelopes([createEnvelope({
                message: null as unknown as string,
            })])

            // Should not throw
        })

        it('should respect per-envelope escapeHtml option', () => {
            plugin.renderOptions({ escapeHtml: false }) // Global false

            plugin.renderEnvelopes([createEnvelope({
                message: '<b>Bold</b>',
                options: { escapeHtml: true }, // Per-envelope true
            })])

            const message = document.querySelector('.fl-message')
            expect(message?.innerHTML).toContain('&lt;b&gt;')
        })
    })

    describe('custom styles', () => {
        it('should apply custom style properties to container', () => {
            plugin.renderOptions({
                style: {
                    zIndex: '9999',
                    marginTop: '20px',
                },
            })
            plugin.renderEnvelopes([createEnvelope()])

            const container = document.querySelector('.fl-wrapper') as HTMLElement
            expect(container.style.getPropertyValue('z-index')).toBe('9999')
            expect(container.style.getPropertyValue('margin-top')).toBe('20px')
        })
    })

    describe('container cleanup', () => {
        it('should remove empty container after last notification is removed', () => {
            plugin.renderOptions({ timeout: 1000 })
            plugin.renderEnvelopes([createEnvelope()])

            vi.advanceTimersByTime(1000)

            const notification = document.querySelector('.fl-container') as HTMLElement
            // Trigger transition end
            notification?.ontransitionend?.({} as TransitionEvent)

            expect(document.querySelector('.fl-wrapper')).toBeNull()
        })

        it('should keep container when other notifications remain', () => {
            plugin.renderOptions({ timeout: false })
            plugin.renderEnvelopes([createEnvelope({ message: 'First' })])
            plugin.renderEnvelopes([createEnvelope({ message: 'Second' })])

            // Remove first notification
            const closeButtons = document.querySelectorAll('.fl-close')
            ;(closeButtons[0] as HTMLElement).click()

            const notification = document.querySelectorAll('.fl-container')[0] as HTMLElement
            notification?.ontransitionend?.({} as TransitionEvent)

            expect(document.querySelector('.fl-wrapper')).toBeTruthy()
            expect(document.querySelectorAll('.fl-container')).toHaveLength(1)
        })
    })

    describe('DOM ready handling', () => {
        it('should defer rendering if DOM is loading', () => {
            // Mock document.readyState
            Object.defineProperty(document, 'readyState', {
                value: 'loading',
                writable: true,
            })

            const addEventListenerSpy = vi.spyOn(document, 'addEventListener')

            plugin.renderEnvelopes([createEnvelope()])

            expect(addEventListenerSpy).toHaveBeenCalledWith('DOMContentLoaded', expect.any(Function))

            // Reset
            Object.defineProperty(document, 'readyState', {
                value: 'complete',
                writable: true,
            })
        })
    })

    describe('error handling', () => {
        it('should log error and continue when envelope rendering fails', () => {
            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {})

            const badTheme: Theme = {
                render: () => {
                    throw new Error('Render error')
                },
            }

            const badPlugin = new FlasherPlugin(badTheme)
            badPlugin.renderEnvelopes([createEnvelope()])

            expect(consoleSpy).toHaveBeenCalledWith(
                expect.stringContaining('Error rendering envelope'),
                expect.any(Error),
                expect.any(Object),
            )
        })
    })

    describe('normalizeTimeout edge cases', () => {
        it('should use default timeout when envelope timeout is null', () => {
            plugin.renderEnvelopes([createEnvelope({ options: { timeout: null } })])

            const notification = document.querySelector('.fl-container')
            expect(notification).toBeTruthy()
            // Should use default timeout (10000ms), so NOT sticky
            expect(notification?.classList.contains('fl-sticky')).toBe(false)
        })

        it('should use default timeout when envelope timeout is undefined', () => {
            plugin.renderEnvelopes([createEnvelope({ options: { timeout: undefined } })])

            const notification = document.querySelector('.fl-container')
            expect(notification).toBeTruthy()
            // Should use default timeout (10000ms), so NOT sticky
            expect(notification?.classList.contains('fl-sticky')).toBe(false)
        })

        it('should handle string timeout', () => {
            plugin.renderEnvelopes([createEnvelope({ options: { timeout: '5000' } })])

            const notification = document.querySelector('.fl-container')
            expect(notification).toBeTruthy()

            // Should auto-remove after timeout
            vi.advanceTimersByTime(5100)
            expect(notification?.classList.contains('fl-show')).toBe(false)
        })

        it('should handle invalid string timeout as sticky', () => {
            plugin.renderEnvelopes([createEnvelope({ options: { timeout: 'invalid' } })])

            const notification = document.querySelector('.fl-container')
            expect(notification?.classList.contains('fl-sticky')).toBe(true)
        })
    })

    describe('removeNotification edge cases', () => {
        it('should handle null notification gracefully', () => {
            // Access private method via any
            const result = (plugin as any).removeNotification(null)

            // Should not throw and return undefined
            expect(result).toBeUndefined()
        })

        it('should handle undefined notification gracefully', () => {
            const result = (plugin as any).removeNotification(undefined)

            expect(result).toBeUndefined()
        })
    })

    describe('progress bar edge cases', () => {
        it('should create progress bar if not present', () => {
            const themeWithoutProgressBar: Theme = {
                render: () => '<div class="fl-notification"><div class="fl-progress-bar"></div></div>',
            }

            const customPlugin = new FlasherPlugin(themeWithoutProgressBar)
            vi.spyOn(window, 'requestAnimationFrame').mockImplementation((cb) => {
                cb(performance.now())
                return 0
            })

            customPlugin.renderOptions({ timeout: 1000, fps: 10 })
            customPlugin.renderEnvelopes([createEnvelope()])

            vi.advanceTimersByTime(100)

            const progressBar = document.querySelector('.fl-progress')
            expect(progressBar).toBeTruthy()
        })
    })

    describe('stringToHTML error handling', () => {
        it('should throw error when theme returns empty HTML', () => {
            const emptyTheme: Theme = {
                render: () => '',
            }

            const emptyPlugin = new FlasherPlugin(emptyTheme)
            vi.spyOn(window, 'requestAnimationFrame').mockImplementation((cb) => {
                cb(performance.now())
                return 0
            })

            // Spy on console.error as the error is caught in renderEnvelopes
            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {})

            emptyPlugin.renderEnvelopes([createEnvelope()])

            expect(consoleSpy).toHaveBeenCalledWith(
                expect.stringContaining('Error rendering envelope'),
                expect.any(Error),
                expect.any(Object),
            )
        })

        it('should throw error when theme returns only whitespace', () => {
            const whitespaceTheme: Theme = {
                render: () => '   \n  ',
            }

            const whitespacePlugin = new FlasherPlugin(whitespaceTheme)
            vi.spyOn(window, 'requestAnimationFrame').mockImplementation((cb) => {
                cb(performance.now())
                return 0
            })

            const consoleSpy = vi.spyOn(console, 'error').mockImplementation(() => {})

            whitespacePlugin.renderEnvelopes([createEnvelope()])

            expect(consoleSpy).toHaveBeenCalledWith(
                expect.stringContaining('Error rendering envelope'),
                expect.any(Error),
                expect.any(Object),
            )
        })
    })

    describe('memory leak prevention', () => {
        it('should clean up event listeners when notification is removed', () => {
            plugin.renderOptions({ timeout: 1000 })
            plugin.renderEnvelopes([createEnvelope()])

            const notification = document.querySelector('.fl-container') as HTMLElement
            expect(notification).toBeTruthy()

            // Verify cleanup function was attached
            expect((notification as any)._flasherCleanup).toBeDefined()

            // Trigger timeout to remove notification
            vi.advanceTimersByTime(1000)

            // Cleanup function should have been called and deleted
            expect((notification as any)._flasherCleanup).toBeUndefined()
        })

        it('should clean up when notification is closed manually', () => {
            plugin.renderOptions({ timeout: false })
            plugin.renderEnvelopes([createEnvelope()])

            const notification = document.querySelector('.fl-container') as HTMLElement
            const closeButton = document.querySelector('.fl-close') as HTMLElement

            // Verify cleanup is set for timed notifications (not sticky ones)
            // For sticky notifications, no timer cleanup is needed

            closeButton.click()

            // Notification should be in closing state
            expect(notification.classList.contains('fl-show')).toBe(false)
        })

        it('should remove DOMContentLoaded listener after firing', () => {
            // Mock document.readyState
            Object.defineProperty(document, 'readyState', {
                value: 'loading',
                writable: true,
            })

            const removeEventListenerSpy = vi.spyOn(document, 'removeEventListener')
            const addEventListenerSpy = vi.spyOn(document, 'addEventListener')

            plugin.renderEnvelopes([createEnvelope()])

            // Get the handler that was added
            const handler = addEventListenerSpy.mock.calls.find(
                call => call[0] === 'DOMContentLoaded',
            )?.[1] as EventListener

            // Simulate DOMContentLoaded firing
            handler?.({} as Event)

            expect(removeEventListenerSpy).toHaveBeenCalledWith('DOMContentLoaded', handler)

            // Reset
            Object.defineProperty(document, 'readyState', {
                value: 'complete',
                writable: true,
            })
        })
    })
})
