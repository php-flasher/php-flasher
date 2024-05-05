---
permalink: /javascript/
redirect_from: /docs/framework/javascript/
title: JavaScript
description: Easily add flash notification messages to your JavaScript application with PHPFlasher. Follow our step-by-step guide to install the library using npm or include it in your project using CDN links, and start engaging and informing your users with powerful flash messages.
---

<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong> assets can be installed from a cdn or using npm

## <i class="fa-duotone fa-list-radio"></i> Installation
Quick start guide for installing the <strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong> from cdn or npm.

---

### <i class="fa-duotone fa-list-radio"></i> cdn

To pull in the <strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong> via CDN, grab the latest version from [jsdelivr](https://www.jsdelivr.com/package/npm/@flasher/flasher)

<span>
    <a href="https://cdn.jsdelivr.net/npm/@flasher/flasher/dist/flasher.min.js" target="_blank">
        <img src="https://img.shields.io/badge/cdn-jsdelivr-blue.svg?style=flat-square" alt="cdn-jsdelivr" />
    </a>
    <a href="https://cdn.jsdelivr.net/npm/@flasher/flasher/dist/flasher.min.js">
        <img src="https://img.badgesize.io/php-flasher/flasher-js/main/packages/flasher/dist/flasher.min.js.svg?compression=brotli&label=flasher.min.js"/>
    </a>
</span>

```html
<script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
```

---

### <i class="fa-duotone fa-list-radio"></i> npm

To install <strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong> from npm use the following command:

```shell
npm i @flasher/flasher
```

## <i class="fa-duotone fa-list-radio"></i> Usage


```javascript
import flasher from "@flasher/flasher";

window.flasher = flasher; // only if you want to use it globally

flasher.error("Oops! Something went wrong!");
flasher.warning("Are you sure you want to proceed ?");
flasher.success("Data has been saved successfully!");
flasher.info("Welcome back");
```

or if you are using a cdn like this:
```html
<script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
<script>
    flasher.error("Oops! Something went wrong!");
    flasher.warning("Are you sure you want to proceed ?");
    flasher.success("Data has been saved successfully!");
    flasher.info("Welcome back");
</script>
```

---

### <i class="fa-duotone fa-list-radio"></i> Other adapters

First grad the cdn for any js library adapter supported by <strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong> or install it with npm
and then call the `create()` method on flasher object :

```html
<script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher-toastr@1.2.4/dist/flasher-toastr.min.js"></script>
<script>
    const factory = flasher.use('toastr');
    factory.error("Oops! Something went wrong!");
    factory.warning("Are you sure you want to proceed ?");
    factory.success("Data has been saved successfully!");
    factory.info("Welcome back");
    
    // or simply with
    flasher.toastr.error("Oops! Something went wrong!");
    flasher.toastr.warning("Are you sure you want to proceed ?");
    flasher.toastr.success("Data has been saved successfully!");
    flasher.toastr.info("Welcome back");
</script>
```
