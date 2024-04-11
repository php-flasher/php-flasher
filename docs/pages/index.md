---
permalink: /
description: PHPFlasher is a robust, open-source tool for seamlessly adding flash messages to Laravel or Symfony projects, aimed at improving user interaction and feedback with minimal developer effort.
data-controller: flasher
---

<div class="text-center mb-24">
    <img id="logo" src="{{ '/static/images/php-flasher-logo.svg'|absolute_url }}" class="h-20 my-8" alt="PHPFlasher">
    <p class="pt-4 mt-4 text-center">
        <a href="https://www.linkedin.com/in/younes--ennaji/">
            <img src="https://img.shields.io/badge/author-@yoeunes-blue.svg" alt="Author Badge" />
        </a>
        <a href="https://github.com/php-flasher/php-flasher">
            <img src="https://img.shields.io/badge/source-php--flasher/php--flasher-blue.svg" alt="Source Code Badge" />
        </a>
        <a href="https://github.com/php-flasher/php-flasher/releases">
            <img src="https://img.shields.io/github/tag/php-flasher/flasher.svg" alt="GitHub Release Badge" />
        </a>
        <a href="https://github.com/php-flasher/flasher/blob/master/LICENSE">
            <img src="https://img.shields.io/badge/license-MIT-brightgreen.svg" alt="License Badge" />
        </a>
        <a href="https://packagist.org/packages/php-flasher/flasher">
            <img src="https://img.shields.io/packagist/dt/php-flasher/flasher.svg" alt="Packagist Downloads Badge" />
        </a>
        <a href="https://github.com/php-flasher/php-flasher">
            <img src="https://img.shields.io/github/stars/php-flasher/php-flasher.svg" alt="GitHub Stars Badge" />
        </a>
        <a href="https://packagist.org/packages/php-flasher/flasher">
            <img src="https://img.shields.io/packagist/php-v/php-flasher/flasher.svg" alt="Supported PHP Version Badge" />
        </a>
    </p>
</div>

## <i class="fa-duotone fa-list-radio"></i> Introduction

{% PHPFlasher %} is a powerful, community-driven, open-source project designed to enhance your web applications by providing an intuitive way to display flash messages. These messages serve as immediate feedback for user actions, significantly improving user experience by confirming actions like form submissions, warnings, or errors.

Flash messages are crucial for interactive applications, and {% PHPFlasher %} makes implementing them in {% Laravel %} or {% Symfony %} projects straightforward. With support for session-based message storage, {% PHPFlasher %} ensures that messages can be easily set and then retrieved for display on subsequent pages, without complex setup.

---

### <i class="fa-duotone fa-list-radio"></i> Flash Notification Types

{% PHPFlasher %} can handle a variety of notification types to suit different feedback scenarios:

> <div class="mt-2"><span class="text-green-700"><i class="fa-solid fa-circle-check fa-xl"></i> success : </span> Indicates successful completion of an action.</div>
> <div class="mt-2"><span class="text-blue-600"><i class="fa-solid fa-circle-info fa-xl"></i> info : </span> Provides informational messages to users.</div>
> <div class="mt-2"><span class="text-yellow-600"><i class="fa-solid fa-circle-exclamation fa-xl"></i> warning : </span> Alerts users to potential issues that are not errors.</div>
> <div class="mt-2"><span class="text-red-600"><i class="fa-solid fa-circle-xmark fa-xl"></i> error : </span> Notifies users of errors or problems encountered.</div>

---

## <i class="fa-duotone fa-list-radio"></i> Why {% PHPFlasher %} ?

- **Broad Library Support**: PHPFlasher integrates with several popular notification libraries, including [toastr.js](/library/toastr/), [SweetAlert 2](/library/sweetalert/), [Noty](/library/noty/), and [Notyf](/library/notyf/).
- **Ease of Use**: Designed with all levels of developers in mind, from beginners to experienced professionals.
- **Flexibility**: Offers extensive customization options for notification styling and behaviors.
- **Framework Compatibility**: Seamlessly integrates with {% Laravel %} and {% Symfony %}, with options for custom adapter creation.
- **Developer Friendly**: Features PHPStorm autocomplete for easier coding and integration.

---

## <i class="fa-duotone fa-list-radio"></i> Getting Started

Dive into PHPFlasher with our straightforward guides and documentation to seamlessly integrate flash messaging into your projects:

- [**Symfony Guide**](/Symfony/)
- [**Laravel Guide**](/Laravel/)
- [**Toastr Library**](/library/toastr/)
- [**Noty Library**](/library/noty/)
- [**Notyf Library**](/library/notyf/)
- [**Sweet Alert Library**](/library/sweetalert/)

## <i class="fa-duotone fa-list-radio"></i> Community and Contributions

{% PHPFlasher %} thrives on community contributions. Your feedback, code contributions, and feature suggestions are invaluable to us. Explore our [GitHub repository](https://github.com/php-flasher/php-flasher) to see how you can become part of the PHPFlasher community. Let's build something great together!
