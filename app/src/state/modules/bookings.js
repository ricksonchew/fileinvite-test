import { axiosRequest } from '@utils/axios-request'
import * as API_URL from '@constants/api'

export const state = {
    form: {
        booking_date_from : null,
        booking_date_to : null,
    },
    pageIsLoading: false,
}

export const getters = {
    formGetter: (state) => {
        return state.form;
    },
}

export const mutations = {
    SET_FORM: (state, form) => {
        Object.keys(form).map((key) => {
            state.form[key] = form[key]
        });
    },
    SET_PAGE_IS_LOADING: (state, value) => {
        state.pageIsLoading = value;
    },
}

export const actions = {
    onSubmitEdit: ({ commit, dispatch, getters }, args  = {}) => {
        const config = {
            method: 'put',
            url: API_URL.API_URL.bookings.default,
            params: {...getters.formGetter, ...args.params}
        };

        commit('SET_PAGE_IS_LOADING', true);

        return axiosRequest(config)
            .then((response) => {
                commit('SET_PAGE_IS_LOADING', false);

                return {
                    variant: 'success',
                    message: response.data.response.data
                };
            })
            .catch((error) => {
                commit('SET_PAGE_IS_LOADING', false);

                return {
                    variant: 'danger',
                    message: error.response.data.response.error
                };
            })
    },
}