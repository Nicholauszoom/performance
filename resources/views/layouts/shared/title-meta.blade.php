<meta charset="utf-8" />

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>
    @if (isset($excelTitle))
    {{ $excelTitle }}
    @else
    {{ $title ?? '' }} | HC-HUB
    @endif
</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<meta content="A fully featured fléx performance system" name="description" />
<meta content="Flex" name="author" />

<link rel="shortcut icon" href="{{asset('assets/images/favicon_io/favicon.ico')}}">
