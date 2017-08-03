<div id="jumbotron-{{ $instance }}" class="jumbotron">
    <h1>I'm a jumbotron!</h1>
    <p>... and my background-color is: {{ $settings->backgroundColor['code'] }}</p>
</div>
@if ($styles === true)
<style>
    #{{ $widget }}-{{ $instance }} {
        background-color: #{{ $settings->backgroundColor['code'] }};
        color: #{{ $settings->color['code'] }};
        margin-bottom: 0;
    };
</style>
@endif
