<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
    </head>
    <body>
        <ul>
            <li><a href="/">/</a></li>
            <li><a href="/adapter/flasher">/adapter/flasher</a></li>
            <li><a href="/adapter/noty">/adapter/noty</a></li>
            <li><a href="/adapter/notyf">/adapter/notyf</a></li>
            <li><a href="/adapter/sweetalert">/adapter/sweetalert</a></li>
            <li><a href="/adapter/toastr">/adapter/toastr</a></li>
            <li><a href="/livewire/counter">/adapter/livewire/counter</a></li>
            <li><a href="/livewire/eventous">/adapter/livewire/eventous</a></li>
        </ul>
        {{ $slot }}
    </body>
</html>
