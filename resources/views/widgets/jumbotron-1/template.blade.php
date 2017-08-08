<div id="{{ $widget->name }}-{{ $widget->instance }}" class="jumbotron">
    <h1 contenteditable="true" spellcheck="false" data-keyup="saveWidgetTitle" data-setting="headline" data-instance="{{ $widget->instance }}">{{ $widget->settings->headline }}</h1>
    <p contenteditable="true" spellcheck="false">... and my background-color is: {{ $widget->settings->backgroundColor->code }}</p>
</div>
