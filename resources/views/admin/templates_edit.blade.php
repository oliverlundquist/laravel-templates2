<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        <title>Templates Edit</title>
    </head>
    <body>
        <div class="content">
            <img src="/images/mystore-header.png" style="width:100%" alt="Mystore Header" />
            <div id="app"></div>
        </div>
        <script>window.template_id = {{ $templateId }}</script>
        <script src="{{ mix('/js/app.js') }}"></script>
         <script>new Vue(Object.assign(routes.templates_edit, { store: new Vuex.Store(routes.templates_edit.store) }))</script>
    </body>
</html>
