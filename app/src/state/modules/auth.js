import axios from 'axios'
import jwt_decode from 'jwt-decode'
import * as API_URL from '@constants/api'
import { axiosRequest } from '@utils/axios-request';

export const state = {
    currentUser: getSavedState('auth.currentUser'),
}

export const mutations = {
    SET_CURRENT_USER(state, newValue) {
        state.currentUser = newValue
        saveState('auth.currentUser', newValue)
    },
    SET_NEW_CSRF(state, newValue) {
        document.querySelector('meta[name="csrf-token"]').setAttribute('content', newValue);
        // setDefaultAuthHeaders(state)
    },
    SET_JWT_TOKEN(state, value) {
        saveState('auth.jwt', value);
    },
    DELETE_SESSION() {
        deleteState('auth.currentUser')
        deleteState('auth.jwt')
    },
}

export const getters = {
    loggedIn: (state) => {
        return !!state.currentUser
    },
}

export const actions = {
    init({ state, dispatch }) {
        dispatch('validate')
    },

    logIn({ commit, dispatch, getters }, { email, password } = {}) {
        if (getters.loggedIn) return dispatch('validate')

        return axios
            .post(API_URL.API_URL.login, { email, password })
            .then((response) => {
                commit('SET_CURRENT_USER', response.data.response.data.access_token);
                commit('SET_JWT_TOKEN', response.data.response.data.access_token);

                return {
                    variant: 'success',
                    message: 'Login successful',
                }
            })
            .catch(error => {
                commit('SET_CURRENT_USER', null);
                commit('SET_JWT_TOKEN', null);
                commit('DELETE_SESSION');

                return {
                    variant: 'danger',
                    message: error.response.data.response.error
                }
            });
    },
    logOut({ commit, dispatch, getters }) {
        const config = {
            method: 'post',
            url: API_URL.API_URL.logout,
            headers: getSavedState('auth.jwt'),
        };

        return axiosRequest(config)
            .then(response => {
                commit('SET_CURRENT_USER', null);
                commit('SET_JWT_TOKEN', null);
                commit('DELETE_SESSION');

                window.location.href = 'login'
            })
            .catch(error => {
                console.log(error, ' - error logout')
            })
    },
    register({ commit, dispatch, getters }, { firstName, lastName, email, password, password_confirmation } = {}) {
        if (getters.loggedIn) return dispatch('validate')

        const first_name = firstName
        const last_name  = lastName

        return axios
            .post(API_URL.API_URL.registration, { first_name, last_name, email, password, password_confirmation })
            .then((response) => {
                commit('SET_CURRENT_USER', response.data.response.data.access_token);
                commit('SET_JWT_TOKEN', response.data.response.data.access_token);

                window.location.href = 'login'
                // return response.data.response.data.access_token
            })
    },
    validate({ commit, dispatch, state }) {
        if (!state.currentUser) return Promise.resolve(null)

        return state.currentUser
    },
}

function getSavedState(key) {
    return JSON.parse(window.localStorage.getItem(key))
}

function saveState(key, state) {
    window.localStorage.setItem(key, JSON.stringify(state))
}

function deleteState(key) {
    window.localStorage.removeItem(key);
}

function isUserAuthenticated() {
    const jwtDecodedToken = jwt_decode(getSavedState('auth.jwt')),
          currentTime     = Math.floor(Date.now() / 1000);
    let $return           = true;

    if (jwtDecodedToken != null && jwtDecodedToken.exp < currentTime) {
        $return = false;
    }

    return $return;
}
