<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        <title>Templates List</title>
    </head>
    <body>
        <div class="content">
            {{ $contents }}
            {{-- @foreach ($contents as $content) --}}
                {{-- @include('widgets.' . $content->template) --}}
            {{-- @endforeach --}}
        </div>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
