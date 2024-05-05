import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
    connect() {
        this.container = document.querySelector('#anchor-navigation')
        if (!this.container) {
            return
        }

        this.createAnchorNavigation()
        this.highlightCurrentAnchor()
        this.stickyHeight()
        this.setupEventListeners()
    }

    createAnchorNavigation() {
        const ul = this.container.querySelector('ul')
        const anchors = document.querySelectorAll('#main-article h3, #main-article h2, #main-article a.anchor')

        if (anchors.length === 0) {
            this.container.remove()
            return
        }

        this.container.classList.add('lg:block')

        anchors.forEach((anchor) => {
            const li = this.createNavItem(anchor)
            ul.appendChild(li)
        })
    }

    createNavItem(anchor) {
        const li = document.createElement('li')
        li.className = 'px-6 rounded w-full'
        if (anchor.tagName === 'A') {
            li.className = 'px-12 rounded w-full'
        }

        const link = document.createElement('a')
        link.href = anchor.tagName === 'A' ? anchor.hash : `#${anchor.getAttribute('id')}`
        link.innerHTML = anchor.tagName === 'A' ? anchor.textContent : `<i class="fa-duotone fa-angle-right"></i>${anchor.textContent}`
        link.className = 'leading-loose text-md inline-block w-full text-indigo-500'

        li.appendChild(link)
        return li
    }

    highlightCurrentAnchor(hash = window.location.hash) {
        if (hash.length === 0) {
            return
        }

        const links = document.querySelectorAll('a.anchor, #anchor-navigation ul li a')

        links.forEach((link) => {
            const parent = link.parentElement
            if (hash === link.hash) {
                link.classList.remove('text-gray-900')
                link.classList.add('text-white')
                parent.classList.add('bg-indigo-500')
            } else {
                link.classList.add('text-gray-900')
                link.classList.remove('text-white')
                parent.classList.remove('bg-indigo-500')
            }
        })
    }

    stickyHeight() {
        const article = document.querySelector('#main-article')
        const stickies = document.querySelectorAll('.sticky')

        stickies.forEach((sticky) => {
            if (sticky.offsetHeight > window.innerHeight && article.clientHeight > sticky.offsetHeight) {
                const div = document.createElement('div')
                div.className = 'h-screen overflow-y-auto'
                div.innerHTML = sticky.innerHTML

                sticky.innerHTML = div.outerHTML
            }
        })
    }

    setupEventListeners() {
        const links = this.container.querySelectorAll('a')
        links.forEach((link) => {
            link.addEventListener('click', (event) => {
                event.preventDefault()
                window.location.hash = link.hash
                this.highlightCurrentAnchor(link.hash)
            })
        })
    }
}
