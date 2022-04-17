import { axiosRequest } from '@utils/axios-request'

export const state = {
    dataTable: {
        items: [],
        fields: [],
        totalRows: 0,
        currentPage: 1,
        perPage: 10,
        lastPage: 1,
        pageOptions: [10, 25, 50, 100],
        sortBy: 'created_date',
        sortDesc: true,
        filter: null,
        filterOn: [],
        isBusy: true,
    },
    reloadDataTable: false,
    pageIsLoading: true,
    paginationParams: {
        apiUrl: null,
        sortBy: null,
        sortDesc: null,
    },
};

export const getters = {
    dataTableGetter: (state) => {
        return state.dataTable;
    },
};

export const mutations = {
    PAGE_LOADING_OVERLAY: (state, pageIsLoading) => {
        state.pageIsLoading = pageIsLoading;
    },
    DATA_TABLE_IS_BUSY: (state, isBusy) => {
        state.dataTable.isBusy = isBusy;
    },
    DATA_TABLE_FIELDS: (state, fields) => {
        state.dataTable.fields = fields;
    },
    DATA_TABLE: (state, dataTable) => {
        state.dataTable.items       = dataTable.items;
        state.dataTable.totalRows   = dataTable.totalRows;
        state.dataTable.currentPage = dataTable.currentPage;
        state.dataTable.perPage     = dataTable.perPage;
        state.dataTable.lastPage    = dataTable.lastPage;
        state.dataTable.isBusy      = dataTable.isBusy;
    },
};

export const actions = {
    fetchDetail: ({ commit, dispatch, getters }, args  = {}) =>  {
        const config = {
            method: 'get',
            url: args.apiUrl,
            params: (typeof args.params == 'undefined') ? {} : args.params,
            deferCancel: (typeof args.deferCancel == 'undefined') ? false : args.deferCancel,
            headers: getSavedState('auth.jwt'),
        };

        commit('PAGE_LOADING_OVERLAY', (typeof args.pageLoadingOverlay != 'undefined') ? args.pageLoadingOverlay : true);

        return axiosRequest(config)
            .then((response) => {
                commit('PAGE_LOADING_OVERLAY', false);
                return response.data.response;
            })
            .catch((error) => {
                commit('PAGE_LOADING_OVERLAY', false);
                return {
                    variant: 'danger',
                    message: error.response.data.response.error
                };
            })
    },
    fetchList: ({ commit, dispatch, getters }, args  = {}) => {
        const config = {
            method: 'get',
            url: args.apiUrl,
            params: (typeof args.params == 'undefined') ? {} : args.params,
            deferCancel: (typeof args.deferCancel == 'undefined') ? false : args.deferCancel,
            headers: getSavedState('auth.jwt'),
        };

        commit('DATA_TABLE_IS_BUSY', true);

        return axiosRequest(config)
            .then((response) => {
                const res = response.data.response;
                commit('DATA_TABLE', {
                    items       : res.data,
                    totalRows   : res.total,
                    currentPage : res.current_page,
                    perPage     : res.per_page,
                    lastPage    : res.last_page,
                    isBusy      : false,
                })

                return response.data.response;
            })
            .catch((error) => {
                return {
                    variant: 'danger',
                    message: error.response.data.response.error
                };
            });
    },
}

function getSavedState(key) {
    return JSON.parse(window.localStorage.getItem(key))
}