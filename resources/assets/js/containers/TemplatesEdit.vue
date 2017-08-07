<template>
    <div class="wrapper">
        <div class="sidebar">
            <ul class="nav nav-tabs">
                <li role="presentation" :class="{ active: sidebarTab === 'widgets' }"><a @click.prevent="sidebarTab = 'widgets'" href="#">Widgets</a></li>
                <li role="presentation" :class="{ active: sidebarTab === 'settings' }"><a @click.prevent="sidebarTab = 'settings'" href="#">Settings</a></li>
            </ul>
            <div class="sidebar-inner">
                <div v-if="sidebarTab === 'widgets'">
                    <ul class="list-group">
                        <li v-for="(widget, widgetIndex) in widgets" :key="widget.instance" class="list-group-item">
                            <h4>{{ startCase(widget.name) }}</h4>
                            <div v-if="has(widget.settings, 'backgroundColor')">
                                <div>Background Color</div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span :style="{ backgroundColor: '#' + widget.settings.backgroundColor.code }" class="color-patch-with-label"></span>{{ widget.settings.backgroundColor.name }} <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li v-for="(color, index) in colors.base" :key="index">
                                            <a @click="setBackgroundColor(widgetIndex, color)" style="cursor:pointer"><span :style="{ backgroundColor: '#' + color.code }" class="color-patch-with-label"></span>{{color.name}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div v-if="has(widget.settings, 'color')">
                                <div style="margin-top:5px">Text Color</div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span :style="{ backgroundColor: '#' + widget.settings.color.code }" class="color-patch-with-label"></span>{{ widget.settings.color.name }} <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li v-for="(color, index) in colors.base" :key="index">
                                            <a @click="setColor(widgetIndex, color)" style="cursor:pointer"><span :style="{ backgroundColor: '#' + color.code }" class="color-patch-with-label"></span>{{color.name}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <h4>Add Widget</h4>
                            <div>Drag and drop any widget below to the content area to the right to add it to your template.</div>
                        </li>
                        <li class="list-group-item">
                            <div>
                                <draggable v-model="availableWidgets" :options="{ group: { name: 'widgets', pull: 'clone', put: false } }">
                                    <button v-for="(widget, index) in availableWidgets" :key="index" class="btn btn-default widget-button" type="button"><span class="glyphicon glyphicon-move" aria-hidden="true"></span> {{ startCase(widget.name) }}</button>
                                </draggable>
                            </div>
                        </li>
                    </ul>
                </div>
                <div v-if="sidebarTab === 'settings'">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <h4>Base Color</h4>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span :style="{ backgroundColor: '#' + colors.backgroundColor.code }" class="color-patch-with-label"></span>{{ colors.backgroundColor.name }} <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li v-for="(color, index) in colors.base" :key="index">
                                        <a @click="setBaseColor(color)" style="cursor:pointer"><span :style="{ backgroundColor: '#' + color.code }" class="color-patch-with-label"></span>{{color.name}}</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <div>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <h4>Preview & Save</h4>
                        </li>
                        <li class="list-group-item">
                            <a @click="showModal = true" href="#" class="btn btn-default fullwidth-button">Preview</a>
                            <button @click="save()" type="button" class="btn btn-default fullwidth-button">Save</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="editor-wrapper">
            <div @click="widgetClickEvent" @keyup="widgetKeyupEvent" :style="{ backgroundColor: '#' + colors.backgroundColor.code }" class="editor">
                <draggable class="droparea" v-model="widgets" :options="{ group: 'widgets', handle: '.area' }" @change="addWidget">
                    <div v-for="widget in widgets" :key="widget.instance" v-html="widget.content + widget.styles"></div>
                </draggable>
            </div>
        </div>
        <div v-if="showModal" @click.self="showModal = false" class="preview-modal">
            <div class="preview-modal-inner">
                <div class="preview-modal-menu">
                    <div class="btn" @click="previewFrame = { width: 1024, height: 768 }"><span class="glyphicon glyphicon-phone"></span>Desktop</div>
                    <div class="btn" @click="previewFrame = { width: 768, height: 1024 }"><span class="glyphicon glyphicon-phone"></span>iPad</div>
                    <div class="btn" @click="previewFrame = { width: 375, height: 667 }"><span class="glyphicon glyphicon-phone"></span>iPhone</div>
                    <div class="btn" @click="previewFrame = { width: 380, height: 667 }"><span class="glyphicon glyphicon-qrcode"></span>QR</div>
                </div>
                <div class="preview-modal-content">
                    <div v-if="previewFrame.width === 380">
                        <h3>Scan this QR code</h3>
                        <h4>to preview the template on your smartphone or tablet</h4>
                        <div v-html="getQRCode()"></div>
                    </div>
                    <iframe v-else class="iframe" :style="{ width: previewFrame.width + 'px', height: previewFrame.height + 'px' }" :src="'/?preview_template_id=' + template_id"></iframe>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import { mapGetters, mapActions } from 'vuex'
    import BaseColors from '../utils/base-colors'
    import * as Widgets from '../widgets'

    export default {
        data() {
            return {
                colors: {
                    base: BaseColors,
                    backgroundColor: BaseColors[144]
                },
                availableWidgets: _.map(Widgets, value => value),
                sidebarTab: 'widgets',
                showModal: false,
                previewFrame: { width: 1024, height: 768 }
            }
        },
        methods: {
            setBackgroundColor(index, color) {
                this.$store.dispatch('loadWidget', { index: index, widget: { settings: { backgroundColor: _.clone(color) } } });
            },
            setColor(index, color) {
                this.$store.dispatch('loadWidget', { index: index, widget: { settings: { color: _.clone(color) } } });
            },
            setBaseColor(color) {
                this.colors.backgroundColor = _.clone(color);
            },
            addWidget(event) {
                let settings = { backgroundColor: this.colors.base[0], color: this.colors.base[1] }
                let widgetName = event.added.element
                let index = event.added.newIndex
                this.$store.dispatch('addWidget', { index: index, widget: { widget: widgetName, version: '1', styles: true, settings: settings } });
            },
            save() {
                this.$store.dispatch('saveTemplatePage')
            },
            widgetClickEvent(event) {
                if (typeof event.target.dataset.click === 'undefined' || typeof event.target.dataset.instance === 'undefined') {
                    return; // undefined
                }
                this[event.target.dataset.click](event.target, event.target.dataset.instance);
            },
            widgetKeyupEvent(event) {
                if (typeof event.target.dataset.keyup === 'undefined' || typeof event.target.dataset.instance === 'undefined') {
                    return; // undefined
                }
                this[event.target.dataset.keyup](event.target, event.target.dataset.instance);
            },
            saveWidgetTitle(element, instance) {
                let index = _.findIndex(this.$store.state.widgets, ['instance', instance])
                let headline = element.innerHTML
                this.$store.dispatch('updateWidget', { index: index, widget: { settings: { headline: headline } } })
            },
            getQRCode() {
                var typeNumber = 8;
                var errorCorrectionLevel = 'L';
                var qr = qrcode(typeNumber, errorCorrectionLevel);
                qr.addData('http://10.0.0.160/?preview_template_id=' + this.template_id);
                qr.make();
                return qr.createImgTag();
            },
            startCase(title) {
                return _.startCase(title)
            },
            has(object, key) {
                return _.has(object, key);
            }
        },
        computed: {
            widgets: { get() { return this.$store.state.widgets }, set(value) {} },
            template_id() { return window.template_id }
        },
        created() {
            this.$store.dispatch('loadTemplate', { id: this.template_id });
        },
        components: {
            draggable
        }
    }
</script>

<style lang="scss" scoped>
    .wrapper {
        display: flex;
        height: 100%;
    }
    .sidebar {
        width: 200px;
        padding-top: 5px;
        display: flex;
        flex-direction: column;
    }
    .sidebar-inner {
        flex: 1;
        padding-top: 20px;
        background-color: #eee;
    }
    .color-patch-with-label {
        padding: 0 8px;
        margin: 0 5px 0 0;
    }
    .editor-wrapper {
        flex: 1;
        padding-top: 20px;
        display: flex;
        flex-direction: column;
    }
    .editor {
        width: 1044px;
        padding: 10px;
        flex: 1;
        display: flex;
        margin: 0 auto;
    }
    .droparea {
        flex: 1;
    }
    .widget-button {
        cursor: move;
        width: 100%;
        display: inline-block;
        margin-bottom: 5px;
        margin-top: 5px;
    }
    .fullwidth-button {
        width: 100%;
        margin-bottom: 5px;
        margin-top: 5px;
    }
    .preview-modal {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        padding: 20px;
        background-color: rgba(0,0,0,0.3);
        text-align: center;
    }
    .preview-modal-inner {
        display:inline-block;
    }
    .preview-modal-menu {
        width:355px;
        display:inline-block;
        background-color:#fff;
        padding:5px 5px 5px 14px;
        text-align:left;
    }
    .preview-modal-content {
        padding: 20px;
        background-color: #fff;
        text-align: center;
    }
    iframe {
        border: none;
        display: block;
    }
</style>
