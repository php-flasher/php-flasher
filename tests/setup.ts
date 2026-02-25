import { afterEach, vi } from 'vitest'

// Clean up DOM after each test
afterEach(() => {
    document.body.innerHTML = ''
    document.head.innerHTML = ''
    vi.clearAllMocks()
    vi.restoreAllMocks()
    vi.useRealTimers()
})

// Mock CSS imports
vi.mock('*.scss', () => ({}))
vi.mock('*.css', () => ({}))
