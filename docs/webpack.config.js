const process = require('node:process')
const Encore = require('@symfony/webpack-encore')

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev')
}

Encore
    .setOutputPath('dist/')
    .setPublicPath('/dist')

    // Clean up the output directory before building
    .cleanupOutputBeforeBuild()

    .disableSingleRuntimeChunk()

    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    // Enable notifications on build completion/errors
    .enableBuildNotifications()

    // enables the Symfony UX Stimulus bridge (used in assets/js/stimulus.js)
    .enableStimulusBridge('./assets/controllers.json')

    // Enable scss and postcss support for styling
    .enablePostCssLoader()

    .configureManifestPlugin((options) => {
        options.fileName = '../_data/manifest.json'
    })

    .addEntry('main', './assets/js/main.js')

module.exports = Encore.getWebpackConfig()
