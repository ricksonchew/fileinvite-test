export const state = {
    cached: [],
}

export const getters = {}

export const mutations = {
    CACHE_USER(state, newUser) {
        state.cached.push(newUser)
    },
}

export const actions = {
    fetchUser({ commit, state, rootState }, { username }) {
        const { currentUser } = rootState.auth
        if (currentUser && currentUser.username === username) {
            return Promise.resolve(currentUser)
        }

        const matchedUser = state.cached.find((user) => user.username === username)
        if (matchedUser) {
            return Promise.resolve(currentUser)
        }
    },
}
