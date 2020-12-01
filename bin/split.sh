#!/usr/bin/env bash

set -e
set -x

CURRENT_BRANCH="main"

function split()
{
    SHA1=$(./bin/splitsh-lite --prefix="$1")
    git push "$2" "$SHA1:refs/heads/$CURRENT_BRANCH" -f
}

function remote()
{
    git remote add "$1" "$2" || true
}

git pull origin $CURRENT_BRANCH

remote flasher git@github.com:php-flasher/flasher.git
remote laravel git@github.com:php-flasher/flasher-laravel.git
remote symfony git@github.com:php-flasher/flasher-symfony.git

remote toastr git@github.com:php-flasher/flasher-toastr.git
remote toastr-laravel git@github.com:php-flasher/flasher-toastr-laravel.git
remote toastr-symfony git@github.com:php-flasher/flasher-toastr-symfony.git

remote notyf git@github.com:php-flasher/flasher-notyf.git
remote notyf-laravel git@github.com:php-flasher/flasher-notyf-laravel.git
remote notyf-symfony git@github.com:php-flasher/flasher-notyf-symfony.git

remote sweet-alert git@github.com:php-flasher/flasher-sweet-alert.git
remote sweet-alert-laravel git@github.com:php-flasher/flasher-sweet-alert-laravel.git
remote sweet-alert-symfony git@github.com:php-flasher/flasher-sweet-alert-symfony.git

remote pnotify git@github.com:php-flasher/flasher-pnotify.git
remote pnotify-laravel git@github.com:php-flasher/flasher-pnotify-laravel.git
remote pnotify-symfony git@github.com:php-flasher/flasher-pnotify-symfony.git

split 'src/Prime' flasher
split 'src/Laravel' laravel
split 'src/Symfony' symfony

split 'src/Toastr/Prime' toastr
split 'src/Toastr/Laravel' toastr-laravel
split 'src/Toastr/Symfony' toastr-symfony

split 'src/Notyf/Prime' notyf
split 'src/Notyf/Laravel' notyf-laravel
split 'src/Notyf/Symfony' notyf-symfony

split 'src/SweetAlert/Prime' sweet-alert
split 'src/SweetAlert/Laravel' sweet-alert-laravel
split 'src/SweetAlert/Symfony' sweet-alert-symfony

split 'src/Pnotify/Prime' pnotify
split 'src/Pnotify/Laravel' pnotify-laravel
split 'src/Pnotify/Symfony' pnotify-symfony
