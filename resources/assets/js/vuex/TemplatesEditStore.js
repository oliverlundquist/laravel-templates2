import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const state = {
    template: {},
    widgets: []
}

const getters = {}

const actions = {
    loadTemplate: ({ commit, dispatch }, payload) => {
        return axios.get('/api/templates/' + payload.id)
                .then((response) => { commit('loadTemplate', response.data); dispatch('loadWidgets'); })
                .catch((error) => { console.log(error); });
    },
    loadWidgets: ({ commit }) => {
        state.template.contents.forEach((widget, index) => {
            axios.post('/api/widget', widget)
                .then((response) => { commit('loadWidgets', { widget: response.data, index: index }); })
                .catch((error) => { console.log(error); });
        });
    }
}

const mutations = {
    loadTemplate (state, payload) {
        state.template = payload.pages[0];
    },
    loadWidgets (state, payload) {
        state.widgets.splice(payload.index, 1, payload.widget);
    }
}

export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations
})
