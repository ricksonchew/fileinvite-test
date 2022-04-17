const API_BASE_URL = process.env.VUE_APP_API_BASE_URL

export const API_URL = {
    login: API_BASE_URL + 'login',
    registration: API_BASE_URL + 'registration',
    logout: API_BASE_URL + 'logout',
    bookings: {
        default: API_BASE_URL + 'bookings',
    }
}