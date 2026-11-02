const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

module.exports = Encore
    .setOutputPath('public')
    .setPublicPath('/bundles/codefogelementsfilter')
    .setManifestKeyPrefix('')
    .addEntry('frontend', './assets/frontend.js')
    .copyFiles({
        from: 'node_modules/isotope-layout/dist',
        pattern: /\.min\.js$/,
        to: '[path][name].[ext]',
    })
    .disableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .getWebpackConfig()
;
