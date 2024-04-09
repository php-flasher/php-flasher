---
permalink: /
description: PHPFlasher - A powerful & easy-to-use package for adding flash messages to Laravel or Symfony projects. Provides feedback to users, improves engagement & enhances user experience. Intuitive design for beginners & experienced developers. A reliable, flexible solution.
data-controller: flasher
---

<div class="text-center mb-24">
    <img id="logo" src="{{ '/static/images/php-flasher-logo.svg'|absolute_url }}" class="h-20 my-8" alt="PHPFlasher">
    <p class="pt-4 mt-4 text-center">
        <a href="https://www.linkedin.com/in/younes--ennaji/">
            <img src="https://img.shields.io/badge/author-@yoeunes-blue.svg" alt="Author" />
        </a>
        <a href="https://github.com/php-flasher/php-flasher">
            <img src="https://img.shields.io/badge/source-php--flasher/php--flasher-blue.svg" alt="Source" />
        </a>
        <a href="https://github.com/php-flasher/php-flasher/releases">
            <img src="https://img.shields.io/github/tag/php-flasher/flasher.svg" alt="GitHub release" />
        </a>
        <a href="https://github.com/php-flasher/flasher/blob/master/LICENSE">
            <img src="https://img.shields.io/badge/license-MIT-brightgreen.svg" alt="License" />
        </a>
        <a href="https://packagist.org/packages/php-flasher/flasher">
            <img src="https://img.shields.io/packagist/dt/php-flasher/flasher.svg" alt="Packagist Downloads" />
        </a>
        <a href="https://github.com/php-flasher/php-flasher">
            <img src="https://img.shields.io/github/stars/php-flasher/php-flasher.svg" alt="GitHub stars" />
        </a>
        <a href="https://packagist.org/packages/php-flasher/flasher">
            <img src="https://img.shields.io/packagist/php-v/php-flasher/flasher.svg" alt="PHP Version" />
        </a>
    </p>
</div>

## <i class="fa-duotone fa-list-radio"></i> Introduction

{% PHPFlasher %} is a powerful and easy-to-use package that allows you to quickly and easily add flash messages to your Laravel or Symfony projects. 
Whether you need to alert users of a successful form submission, an error, or any other important information, flash messages are a simple and effective solution for providing feedback to your users. 

With {% PHPFlasher %}, you can easily record and store messages within the session, making it simple to retrieve and display them on the current or next page. 
This improves user engagement and enhances the overall user experience on your website or application. 

Whether you're a beginner or an experienced developer, {% PHPFlasher %}'s intuitive and straightforward design makes it easy to integrate into your projects. 
So, if you're looking for a reliable, flexible and easy to use flash messages solution, {% PHPFlasher %} is the perfect choice.

---

### <i class="fa-duotone fa-list-radio"></i> Flash notification types

Flash notifications serves as a feedback & confirmation mechanism after the user takes an action.

> <div class="mt-2"><span class="text-green-700"><i class="fa-solid fa-circle-check fa-xl"></i> success : </span> Whatever was attempted did, in fact, succeed.</div>
> <div class="mt-2"><span class="text-blue-600"><i class="fa-solid fa-circle-info fa-xl"></i> info : </span> Some event occurred that the user should be aware of.</div>
> <div class="mt-2"><span class="text-yellow-600"><i class="fa-solid fa-circle-exclamation fa-xl"></i> warning : </span> Something not good happened, but it isn't an error.</div>
> <div class="mt-2"><span class="text-red-600"><i class="fa-solid fa-circle-xmark fa-xl"></i> error : </span> Some sort of program error occurred.</div>

---

## <i class="fa-duotone fa-list-radio"></i> Why use {% PHPFlasher %} ?

{% PHPFlasher %} supports popular notification libraries : 
<span class="text-indigo-900">[__toastr.js__](/library/toastr/)</span>, 
<span class="text-indigo-900">[__sweetalert 2__](/library/sweetalert/)</span>, 
<span class="text-indigo-900">[__noty__](/library/noty/)</span> and
<span class="text-indigo-900">[__notyf__](/library/notyf/)</span>.

You have a wide range of options to choose from to suit your specific needs. Whether you want to display simple toast messages or more sophisticated alerts, 
{% PHPFlasher %} has you covered.

Overall, {% PHPFlasher %} is a versatile and easy-to-use library 
that can greatly enhance the user experience of your website or application.
Give it a try and see the difference it can make for yourself!

* Display multiple notifications at the same time
* Easily display notifications from <i class="fa-brands fa-js-square text-yellow-600 fa-xl"></i> JavaScript with a small footprint
* LTR <i class="fa-duotone fa-signs-post text-indigo-900 fa-xl"></i> and Dark-mode <i class="fa-duotone fa-circle-half-stroke text-indigo-900 fa-xl"></i> support
* Framework-agnostic with <a href="https://laravel.com/" class="text-indigo-900"><i class="fa-brands fa-laravel text-red-900 fa-xl"></i> <strong>Laravel</strong></a> and <a href="https://symfony.com/" class="text-indigo-900"><i class="fa-brands fa-symfony text-black fa-xl"></i> <strong>Symfony</strong></a> implementations
* <i class="fa-duotone fa-sidebar text-indigo-900 fa-xl"></i> PHPSTORM Autocomplete
* You can always create an adapter yourself <i class="fa-duotone fa-screwdriver-wrench fa-xl text-indigo-900"></i> if desired
* ...and more

---

## <i class="fa-duotone fa-list-radio"></i> Getting Started

* **[Installation](/installation/)**
* **[Toastr](/library/toastr/)**
* **[Noty](/library/noty/)**
* **[Notyf](/library/notyf/)**
* **[Sweet Alert](/library/sweetalert/)**

## <i class="fa-duotone fa-list-radio"></i> Sponsors

We are grateful for the support provided by our sponsors, who have made it possible for us to develop and improve the package. Special thanks to:

* [Nashwan Abdullah](https://github.com/codenashwan) via PayPal, check out his youtube channel [Rstacode](https://www.youtube.com/rstacode)
* [Salma Mourad](https://github.com/salmayno)
* [Arvid de Jong](https://github.com/darviscommerce)

## <i class="fa-duotone fa-list-radio"></i> Contributors

We are grateful for the contributions of our contributors, who have been instrumental in helping us to develop and improve the package. Thank you to:

* [Ash Allen](https://github.com/ash-jc-allen) for creating our logo, check out his :
  * **Battle Ready Laravel** book : [https://battle-ready-laravel.com](https://battle-ready-laravel.com)
  * blog : [https://ashallendesign.co.uk/blog](https://ashallendesign.co.uk/blog)
* [Tony Murray](https://github.com/murrant)
* [Stéphane P](https://github.com/n3wborn)
* [Lucas Maciel](https://github.com/LucasStorm)
* [Antoni Siek](https://github.com/ImJustToNy)
