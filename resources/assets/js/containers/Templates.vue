<template>
    <div class="page-content">
        <div v-for="(chunk, index) in templateChunks" v-bind:key="index" class="template-row">
            <div v-for="template in chunk" v-bind:key="template.id" class="template-wrapper">
                <div class="template-frame">Template {{ template.id }}</div>
                <a :href="'/editor/' + template.id" class="btn btn-default">Edit</a>
                <button v-if="template.active === 1" class="btn disabled" disabled="disabled">Activate</button>
                <button v-else @click="activateTemplate(template.id)" class="btn btn-default">Activate</button>
                <a :href="'/?preview_template_id=' + template.id" class="btn btn-default">Preview</a>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {
        computed: mapGetters(['templateChunks']),
        methods: {
            activateTemplate(template_id) {
                this.$store.dispatch('activateTemplate', { template_id: template_id });
            }
        },
        created() {
            this.$store.dispatch('loadTemplates');
        }
    }
</script>

<style lang="scss" scoped>
    .page-content {
        padding: 0 14%;
    }

    .template-row {
        display: flex;
        align-items: flex-start;
    }

    .template-wrapper {
        padding:1%;
        width:24%;
    }

    .template-frame {
        height:200px;
        border:1px solid #636b6f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size:26px;
        margin-bottom: 10px;
    }

    .form-btn-wrapper {
        display: inline-block;
    }
</style>
