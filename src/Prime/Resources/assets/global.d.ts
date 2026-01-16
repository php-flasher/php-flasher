import type Flasher from './flasher'

declare global {
    interface Window {
        flasher: Flasher
    }
}

export {}
