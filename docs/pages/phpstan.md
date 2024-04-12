---
permalink: /phpstan/
title: PHPStan
description: Seamlessly integrate PHPFlasher with PHPStan to validate dynamic methods and enhance code analysis in your projects. This open-source initiative is designed to help maintain clean and reliable code with minimal configuration.
---

## <i class="fa-duotone fa-list-radio"></i> PHPFlasher extension for PHPStan

{% PHPFlasher %} extends PHPStan by providing a straightforward solution to validate dynamic methods. This integration aids in keeping your code analysis precise and free of errors that may occur due to the dynamic nature of {% PHPFlasher %}.

---

## <i class="fa-duotone fa-list-radio"></i> Configuration

Add the {% PHPFlasher %} extension to your PHPStan setup by updating your project's `phpstan.neon` file:

```neon
includes:
    - vendor/php-flasher/flasher/extension.neon
```

By including this configuration, PHPStan will recognize and validate all dynamic methods introduced by {% PHPFlasher %}, ensuring a clean and accurate code analysis process.
