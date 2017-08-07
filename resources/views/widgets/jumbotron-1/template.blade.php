<div id="{{ $widget->name }}-{{ $widget->instance }}" class="jumbotron">
    <h1 contenteditable="true" spellcheck="false" data-keyup="saveWidgetTitle" data-instance="{{ $widget->instance }}">I'm a jumbotron!</h1>
    <p contenteditable="true" spellcheck="false">... and my background-color is: {{ $widget->settings->backgroundColor->code }}</p>
</div>
