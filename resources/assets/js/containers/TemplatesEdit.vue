<template>
    <div>
        <div>Template: <pre>{{ $store.state.template }}</pre></div>
        <div v-for="widget in widgets" v-bind:key="widget.instance" v-html="widget.content"></div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {
        computed: {
            widgets() { return this.$store.state.widgets; }
        },
        created() {
            this.$store.dispatch('loadTemplate', { id: template_id });
        }
    }
</script>

<style lang="scss" scoped>
    //
</style>
