import axios from 'axios';

let call;

export const axiosRequest = (config = {}) => {
    let axiosReturn;
    let deferCancel = true;


    if (typeof config.headers == 'undefined') {
        config.headers = {}
    } else {
        config.headers = {
            'Authorization' : 'Bearer ' + config.headers
        }
    }

    if (typeof config.deferCancel == 'undefined' || config.deferCancel == false) {
        deferCancel = false;
        if (call) {
            call.cancel("Only one request allowed at a time.");
        }
        call = axios.CancelToken.source();

        config.cancelToken = call.token;
    }


    switch (config.method) {
        case 'get':
            if (deferCancel) {
                axiosReturn = axios.get(config.url, {
                    params: config.params,
                    headers: config.headers
                });
            } else {
                axiosReturn = axios.get(config.url, {
                    params: config.params,
                    cancelToken: config.cancelToken,
                    headers: config.headers
                });
            }
            break;
        case 'delete':
            if (deferCancel) {
                axiosReturn = axios[config.method](config.url, {data: config.params}, {
                    headers: config.headers
                });
            } else {
                axiosReturn = axios[config.method](config.url, {data: config.params}, {
                    cancelToken: config.cancelToken,
                    headers: config.headers
                });
            }
            break;
        default:
            if (deferCancel) {
                axiosReturn = axios[config.method](config.url, config.params, {
                    headers: config.headers
                });
            } else {
                axiosReturn = axios[config.method](config.url, config.params, {
                    cancelToken: config.cancelToken,
                    headers: config.headers
                });
            }
    }

    return axiosReturn;
};
