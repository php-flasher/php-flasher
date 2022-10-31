<p align="center">
    <picture>
      <source media="(prefers-color-scheme: dark)" srcset="https://raw.githubusercontent.com/php-flasher/art/main/php-flasher-logo-dark.svg">
      <img  width="600" src="https://raw.githubusercontent.com/php-flasher/art/main/php-flasher-logo.svg" alt="PHPFlasher Logo">
    </picture>
</p>

<p align="center">Flexible flash notifications system for Symfony</p>

## Official Documentation

Documentation for PHPFlasher can be found on the [PHPFlasher website](https://php-flasher.io).

## Introduction

PHPFlasher offers a solid integration with the Symfony framework, with supports from Symfony 2.0 to 6.

## Install

You can install the PHPFlasher Symfony bundle using composer.
This is the base package for all Symfony adapters (toastr, sweetalert, notyf ..etc).

```shell
composer require php-flasher/flasher-symfony
```

If you are using  Symfony version 4+ the bundle will be registered automatically in `config/bundles.php`, otherwise enable the bundle in the kernel:

```php
public function registerBundles()
{
    $bundles = [
        // ...
        new Flasher\Symfony\FlasherSymfonyBundle(),
        // ...
    ];
}
```

## Usage

The usage of this bundle is very simple and straightforward. it only required **one** step to use it and does not
require anything to be included in your views: 

Use `FlasherInterface` service inside your controller to set a toast notification for `info`, `success`, `warning` or `error`

```php
<?php

namespace App\Controller;

use Flasher\Prime\FlasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController
{
    public function save(FlasherInterface $flasher): Response
    {
        // ...

        $flasher->addSuccess('Book saved successfully');

        return $this->render('book/index.html.twig');
    }
}
```

Basic api methods: 

- `flash()->addSuccess('Data has been saved successfully!')`
- `flash()->addError('Oops! An error has occurred.')`
- `flash()->addWarning('Are you sure you want to delete this item?')`
- `flash()->addInfo('Welcome to the site!')`


By default `PHPFlasher` show its default notification style.
To use another adapter, use the `create()` method or its Factory service :

```php
class PostController
{
   public function create(FlasherInterface $flasher): Response
   {
      $flasher
         ->error('An error has occurred, please try again later.')
         ->priority(3)
         ->flash();
   }

   public function edit(FlasherInterface $flasher): Response
   {
      $toastr = $flasher->create('toastr'); // You need to require php-flasher/flasher-toastr-symfony
      $toastr->addSuccess('This notification will be rendered using the toastr adapter');
   }

   public function update(ToastrFactory $toastr): Response
   {
      $toastr
         ->title('Oops...')
         ->warning('Something went wrong!')
         ->timeOut(3000)
         ->progressBar()
         ->flash();
   }
}
```
## Contact

PHPFlasher is being actively developed by <a href="https://github.com/yoeunes">yoeunes</a>. You can reach out with questions, bug reports, or feature requests 
on any of the following:

- [Github Issues](https://github.com/php-flasher/flasher/issues) 
- [Github](https://github.com/yoeunes)
- [Twitter](https://twitter.com/yoeunes)
- [Linkedin](https://www.linkedin.com/in/younes-khoubza/)
- [Email me directly](mailto:younes.khoubza@gmail.com)

## License

PHPFlasher is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

<p align="center"> <b>Made with ❤️ by <a href="https://www.linkedin.com/in/younes-khoubza/">Younes KHOUBZA</a> </b> </p>
