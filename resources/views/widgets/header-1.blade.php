<div id="{{ $widget }}-{{ $instance }}" class="page-header">
    <div class="wrapper">
        <div class="logo-wrapper">
            <img @click="clickOnImage" class="logo" src="/images/default-logo.png" />
        </div>
        <div class="text-wrapper">
            <h1 contenteditable="true" spellcheck="false" class="shopname">Chips Inc. Webshop</h1>
            <p contenteditable="true" spellcheck="false">Welcome all chips lovers to our shop!</p>
        </div>
    </div>
</div>
@if ($styles === true)
<style>
    #{{ $widget }}-{{ $instance }} .wrapper {
        display: flex;
    }
    #{{ $widget }}-{{ $instance }} .logo-wrapper {
        width: 128px;
        margin-right: 10px;
    }
    #{{ $widget }}-{{ $instance }} .logo {
        width: 100%;
        height: auto;
    }
    #{{ $widget }}-{{ $instance }} .text-wrapper {
        flex: 1;
    }
</style>
@endif
