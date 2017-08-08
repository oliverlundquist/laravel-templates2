<style>
    #{{ $widget->name }}-{{ $widget->instance }} {
        background-color: #{{ $widget->settings->backgroundColor->code }};
        color: #{{ $widget->settings->color->code }};
        padding: 60px;
        margin-bottom: 0;
        border-radius: 6px;
    }
</style>
