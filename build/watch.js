const url = require('url');
const webpack = require('webpack');
const browserSync = require('browser-sync');
const webpackDevMiddleware = require('webpack-dev-middleware');
const webpackHotMiddleware = require('webpack-hot-middleware');

const config = require('./config');
const webpackConfig = require('./webpack.dev');
const bundler = webpack(webpackConfig);

browserSync({
  host: url.parse(config.proxyUrl).hostname,
  port: url.parse(config.proxyUrl).port,
  delay: 200,
  open: config.open,
  ui: false,
  ghostMode: false,

  proxy: {
    target: process.env.DEVURL || config.devUrl,
    middleware: [
      webpackDevMiddleware(bundler, {
        publicPath: webpackConfig.output.publicPath,
        stats: false,
        // for other settings see
        // https://webpack.js.org/guides/development/#using-webpack-dev-middleware
        // https://webpack.js.org/configuration/dev-server/
      }),

      webpackHotMiddleware(bundler),
    ],
  },
  files: config.bsWatchFiles,
});
