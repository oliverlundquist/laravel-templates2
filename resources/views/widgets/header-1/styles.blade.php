<style>
    #{{ $widget->name }}-{{ $widget->instance }} .wrapper {
        display: flex;
    }
    #{{ $widget->name }}-{{ $widget->instance }} .logo-wrapper {
        width: 128px;
        margin-right: 10px;
    }
    #{{ $widget->name }}-{{ $widget->instance }} .logo {
        width: 100%;
        height: auto;
        border-radius: 10px;
        border-color: #{{ $widget->settings->borderColor->code }};
        border-style: solid;
        border-width: 5px;
    }
    #{{ $widget->name }}-{{ $widget->instance }} .text-wrapper {
        flex: 1;
    }
</style>
