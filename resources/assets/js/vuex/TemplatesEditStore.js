import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const state = {
    template: {},
    widgets: [],
    galleryImages: []
}

const getters = {
    imageGalleryChunks: state => {
        return _.chunk(state.galleryImages, 4);
    }
}

const actions = {
    loadTemplate: ({ commit, dispatch }, payload) => {
        return axios.get('/api/templates/' + payload.id)
                .then((response) => { commit('loadTemplate', response.data); dispatch('loadWidgets'); })
                .catch((error) => { console.log(error); });
    },
    saveTemplatePage: ({ commit }) => {
        let template = _.clone(state.template)
        let widgets  = _.map(_.cloneDeep(state.widgets), widget => { return { widget: widget } })
        let data     = _.assign(template, { contents: widgets })

        return axios.put('/api/template-pages/' + data.id, data)
                .then((response) => { commit('saveTemplatePage', response.data); })
                .catch((error) => { console.log(error); });
    },
    loadWidgets: ({ commit }) => {
        state.template.contents.forEach((widget, index) => {
            axios.post('/api/widget', widget)
                .then((response) => { commit('loadWidgets', { widget: response.data, index: index }); })
                .catch((error) => { console.log(error); });
        });
    },
    loadWidget: ({ commit }, payload) => {
        axios.post('/api/widget', { widget: _.merge(state.widgets[payload.index], payload.widget) })
                .then((response) => { commit('loadWidget', { widget: response.data, index: payload.index }); })
                .catch((error) => { console.log(error); });
    },
    updateWidget: ({ commit }, payload) => {
        commit('updateWidget', { widget: _.merge(state.widgets[payload.index], payload.widget), index: payload.index })
    },
    addWidget: ({ commit, dispatch }, payload) => {
        axios.post('/api/widget', { widget: payload.widget })
                .then((response) => { commit('addWidget', { widget: response.data, index: payload.index }); })
                .catch((error) => { console.log(error); });
    },
    getGalleryImages: ({ commit }) => {
        axios.get('/api/images')
            .then((response) => { commit('getGalleryImages', response.data); })
            .catch((error) => { console.log(error); });
    }
}

const mutations = {
    loadTemplate (state, payload) {
        state.template = payload.pages[0];
    },
    saveTemplatePage (state, payload) {
        console.log('saved template!', payload);
    },
    loadWidgets (state, payload) {
        state.widgets.splice(payload.index, 0, payload.widget.widget);
    },
    loadWidget (state, payload) {
        state.widgets.splice(payload.index, 1, payload.widget.widget);
    },
    updateWidget (state, payload) {
        state.widgets.splice(payload.index, 1, payload.widget);
    },
    addWidget (state, payload) {
        state.widgets.splice(payload.index, 0, payload.widget.widget);
    },
    getGalleryImages (state, payload) {
        state.galleryImages = payload;
    },
}

export default {
    state,
    getters,
    actions,
    mutations
}
