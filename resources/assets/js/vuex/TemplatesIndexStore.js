const state = {
    templates: []
}

const getters = {
    templateChunks: state => {
        return _.chunk(state.templates, 4);
    }
}

const actions = {
    loadTemplates: ({ commit }) => {
        return axios.get('/api/templates')
                .then((response) => { commit('loadTemplates', response.data); })
                .catch((error) => { console.log(error); });
    },
    activateTemplate: ({ commit, dispatch }, payload) => {
        return axios.put('/api/templates/' + payload.template_id)
                .then((response) => { commit('activateTemplate', response.data); dispatch('loadTemplates') })
                .catch((error) => { console.log(error); });
    }
}

const mutations = {
    loadTemplates (state, payload) {
        state.templates = payload;
    },
    activateTemplate (state, payload) {
        //
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
