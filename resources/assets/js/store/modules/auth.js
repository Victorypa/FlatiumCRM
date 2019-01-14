import router from './../../routes'

const state = {
    isLoggedIn: !!localStorage.getItem('token')
}

const mutations = {
    loginUser (state) {
        state.isLoggedIn = true
    },

    logoutUser (state) {
        state.isLoggedIn = false
    }
}

const actions = {
    login ({ commit }, credentials) {
        axios.post('/api/auth/login',
        {
            email: credentials.email,
            password: credentials.password
        })
        .then(response => {
            localStorage.setItem('token', response.data.access_token)
            window.axios.defaults.headers.common.Authorization = `Bearer ${response.data.access_token}`
            commit('loginUser')
            router.push({ name: 'orders' })

            setTimeout(() => {
              commit('logoutUser')
            }, 60000 * 15)
            
        })
        .catch(err => {
            window.location.reload(true)
        })
    },

    logout({ commit }) {
        commit('logoutUser')
        localStorage.removeItem('token')
        router.push({ name: 'login' })
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions
}
