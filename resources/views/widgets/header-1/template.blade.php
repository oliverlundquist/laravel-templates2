<div id="{{ $widget->name }}-{{ $widget->instance }}" class="page-header">
    <div class="wrapper">
        <div class="logo-wrapper">
            <a href="#"><img data-click="openImageGallery" data-instance="{{ $widget->instance }}" class="logo" src="{{ $widget->settings->logo }}" /></a>
        </div>
        <div class="text-wrapper">
            <h1 contenteditable="true" spellcheck="false" data-keyup="saveWidgetTitle" data-setting="headline" data-instance="{{ $widget->instance }}" class="shopname">{{ $widget->settings->headline }}</h1>
            <p contenteditable="true" spellcheck="false" data-keyup="saveWidgetTitle" data-setting="kicker" data-instance="{{ $widget->instance }}">{{ $widget->settings->kicker }}</p>
        </div>
    </div>
</div>
