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
                            <h4>{{ startCase(widget.widget) }}</h4>
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
                                    <button v-for="(widget, index) in availableWidgets" :key="index" class="btn btn-default widget-button" type="button">{{ startCase(widget) }}</button>
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
            </div>
        </div>
        <div class="editor-wrapper">
            <div :style="{ backgroundColor: '#' + colors.backgroundColor.code }" class="editor">
                <draggable class="droparea" v-model="widgets" :options="{ group: 'widgets' }" @change="addWidget">
                    <div v-for="widget in widgets" :key="widget.instance" v-html="widget.content"></div>
                </draggable>
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import { mapGetters, mapActions } from 'vuex'
    import BaseColors from '../utils/base-colors'

    export default {
        data() {
            return {
                colors: {
                    base: BaseColors,
                    backgroundColor: BaseColors[144]
                },
                availableWidgets: ['jumbotron'],
                sidebarTab: 'widgets'
            }
        },
        methods: {
            setBackgroundColor(index, color) {
                this.$store.dispatch('loadWidget', { index: index, widget: { styles: true, settings: { backgroundColor: _.clone(color) } } });
            },
            setColor(index, color) {
                this.$store.dispatch('loadWidget', { index: index, widget: { styles: true, settings: { color: _.clone(color) } } });
            },
            setBaseColor(color) {
                this.colors.backgroundColor = _.clone(color);
            },
            addWidget(event) {
                let settings = { backgroundColor: this.colors.base[0], color: this.colors.base[1] }
                let widgetName = event.added.element
                let index = event.added.newIndex
                this.$store.dispatch('loadWidget', { index: index, widget: { widget: widgetName, version: '1', styles: true, settings: settings } });
            },
            startCase(title) {
                return _.startCase(title)
            }
        },
        computed: {
            widgets: { get() { return this.$store.state.widgets }, set(value) {} }
        },
        created() {
            this.$store.dispatch('loadTemplate', { id: template_id });
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
        width: 1064px; // 1024 + 20 + 20 padding
        padding: 20px 20px 0 20px;
        margin: 0 auto;
        flex: 1;
        display: flex;
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
</style>
