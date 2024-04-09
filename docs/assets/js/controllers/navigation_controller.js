import { Controller } from '@hotwired/stimulus'

import './navigation.pcss'

export default class extends Controller {
    connect() {
        const menuBtn = document.getElementById('menu-toggle')
        const navigation = document.getElementById('main-navigation')
        const article = document.getElementById('main-article')

        function toggleClassName(el, className) {
            if (el.classList.contains(className)) {
                el.classList.remove(className)
            } else {
                el.classList.add(className)
            }
        }

        menuBtn.addEventListener('click', (e) => {
            e.preventDefault()
            toggleClassName(menuBtn, 'menu-closed')
            toggleClassName(navigation, 'hidden')
            toggleClassName(article, 'hidden')
        })
    }
}
