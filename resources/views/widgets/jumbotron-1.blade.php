<div id="{{ $widget }}-{{ $instance }}" class="jumbotron">
    <h1 contenteditable="true" spellcheck="false">I'm a jumbotron!</h1>
    <p contenteditable="true" spellcheck="false">... and my background-color is: {{ $settings->backgroundColor['code'] }}</p>
</div>
@if ($styles === true)
<style>
    #{{ $widget }}-{{ $instance }} {
        background-color: #{{ $settings->backgroundColor['code'] }};
        color: #{{ $settings->color['code'] }};
        padding: 60px;
        margin-bottom: 0;
        border-radius: 6px;
    }
</style>
@endif
