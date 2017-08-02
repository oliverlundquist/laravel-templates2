<div id="jumbotron-{{ $instance }}" class="jumbotron">
    <h1>I'm a jumbotron!</h1>
    <p>... and my background-color is: {{ $settings->color }}</p>
</div>
@if ($styles === true)
<style>
    #{{ $widget }}-{{ $instance }} { background-color: {{ $settings->color }}; };
</style>
@endif
