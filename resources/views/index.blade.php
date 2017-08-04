<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        <title>Toppage</title>
    </head>
    <body>
        <div class="content">
            @foreach ($contents as $content)
                @include('widgets.' . $content->widget . '-' . $content->version, [
                    'widget'   => $content->widget,
                    'version'  => $content->version,
                    'styles'   => $content->styles,
                    'instance' => $content->instance,
                    'content'  => $content->content,
                    'settings' => $content->settings
                ])
            @endforeach
        </div>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
