const appConfig = require('./src/app.config')

module.exports = {
    configureWebpack: {
        name: appConfig.title,
        // Set up all the aliases we use in our app.
        resolve: {
            alias: require('./aliases.config').webpack,
        },
        performance: {
            hints:
                process.env.NODE_ENV === 'production' &&
                !process.env.VUE_APP_TEST &&
                'warning',
        },
    },
    css: {
        // Enable CSS source maps.
        sourceMap: true,
    },
    // Configure Webpack's dev server.
    devServer: {
        ...{ proxy: { '/api': { target: process.env.VUE_APP_API_BASE_URL } } },
        disableHostCheck: true
    },
}
