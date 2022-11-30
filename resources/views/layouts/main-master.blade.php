<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('layouts.shared.title-meta', ['title' => $title])
        @include('layouts.shared.head-css')
    </head>

    <body>

        @include('layouts.shared.left-sidebar')


        {{-- @include('layouts.shared/footer-script') --}}

    </body>
</html>
