const url = require('url');
const webpack = require('webpack');
const { merge } = require('webpack-merge');

// config
let webpackCommon = require('./webpack.common');
const config = require('./config');

const target = process.env.DEVURL || config.devUrl;

if (!('devUrl' in config) || config.devUrl.length === 0) {
  console.error(
    '\x1b[30m\x1b[41m %s \x1b[0m \x1b[31m%s\x1b[0m',
    'devUrl is not specified',
    'Specify the correct devUrl in config.json!'
  );
  throw new Error();
} else if (!('proxyUrl' in config) || config.proxyUrl.length === 0) {
  console.error(
    '\x1b[30m\x1b[41m %s \x1b[0m \x1b[31m%s\x1b[0m',
    'proxyUrl is not specified',
    'Specify the correct proxyUrl in config.json!'
  );
  throw new Error();
} else if (config.devUrl.substr(-1) === '/') {
  console.error(
    '\x1b[30m\x1b[41m %s \x1b[0m \x1b[31m%s\x1b[0m',
    'devUrl contains trailing slash',
    'Please, remove trailing slash from devUrl option!'
  );
  throw new Error();
}

if (url.parse(target).protocol !== url.parse(config.proxyUrl).protocol) {
  console.warn(
    '\x1b[35m\x1b[43m %s \x1b[0m \x1b[33m%s\x1b[0m',
    'Unmatched protocols',
    'proxyUrl should have the same protocol as the devURL.'
  );
  config.proxyUrl = config.proxyUrl.replace(
    url.parse(config.proxyUrl).protocol,
    url.parse(target).protocol
  );
  console.warn(
    '\x1b[32m%s\x1b[0m',
    'Protocol was automatically switched to "' +
      url.parse(target).protocol.replace(':', '') +
      '"'
  );
}

/**
 * We do this to enable injection over SSL.
 */
if (url.parse(target).protocol === 'https:') {
  process.env.NODE_TLS_REJECT_UNAUTHORIZED = 0;
}

if (url.parse(target).path !== '/') {
  config.proxyUrl += url.parse(target).path;
}

let webpackDev = {
  mode: 'development',
  output: {
    pathinfo: true,
    publicPath: config.proxyUrl + config.publicPath,
  },
  devtool: config.enabled.sourceMaps ? 'source-map' : false,
  stats: false,
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: [/(node_modules)(?![/|\\](bootstrap|foundation-sites))/],
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
          },
        },
      },
    ],
  },
  plugins: [
    // new webpack.optimize.OccurrenceOrderPlugin(),
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoEmitOnErrorsPlugin(),
  ],
};

webpackCommon = merge(webpackCommon, webpackDev);

webpackCommon.entry = require('./util/addHotMiddleware')(webpackCommon.entry);

module.exports = webpackCommon;
