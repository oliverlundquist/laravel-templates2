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
            <img src="/images/mystore-header.png" style="width:100%" alt="Mystore Header" />
            <div id="app"></div>
        </div>
        <script>window.template_id = {{ Route::current()->parameters()['id'] ?? 0 }}</script>
        <script src="{{ mix('/js/app.js') }}"></script>
        <script>new Vue(routes.templates)</script>
    </body>
</html>
