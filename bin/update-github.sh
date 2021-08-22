#!/usr/bin/env bash

set -e
set -x

function remote()
{
    git remote set-url "$1" "$2" || true
}

remote flasher git@github.com-yoeunes:php-flasher/flasher.git
remote laravel git@github.com-yoeunes:php-flasher/flasher-laravel.git
remote symfony git@github.com-yoeunes:php-flasher/flasher-symfony.git

remote toastr git@github.com-yoeunes:php-flasher/flasher-toastr.git
remote toastr-laravel git@github.com-yoeunes:php-flasher/flasher-toastr-laravel.git
remote toastr-symfony git@github.com-yoeunes:php-flasher/flasher-toastr-symfony.git

remote notyf git@github.com-yoeunes:php-flasher/flasher-notyf.git
remote notyf-laravel git@github.com-yoeunes:php-flasher/flasher-notyf-laravel.git
remote notyf-symfony git@github.com-yoeunes:php-flasher/flasher-notyf-symfony.git

remote sweet-alert git@github.com-yoeunes:php-flasher/flasher-sweet-alert.git
remote sweet-alert-laravel git@github.com-yoeunes:php-flasher/flasher-sweet-alert-laravel.git
remote sweet-alert-symfony git@github.com-yoeunes:php-flasher/flasher-sweet-alert-symfony.git

remote pnotify git@github.com-yoeunes:php-flasher/flasher-pnotify.git
remote pnotify-laravel git@github.com-yoeunes:php-flasher/flasher-pnotify-laravel.git
remote pnotify-symfony git@github.com-yoeunes:php-flasher/flasher-pnotify-symfony.git

remote noty git@github.com-yoeunes:php-flasher/flasher-noty.git
remote noty-laravel git@github.com-yoeunes:php-flasher/flasher-noty-laravel.git
remote noty-symfony git@github.com-yoeunes:php-flasher/flasher-noty-symfony.git

