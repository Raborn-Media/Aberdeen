'use strict'; // eslint-disable-line

const path = require('path');
const { merge } = require('webpack-merge');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MinifyPlugin = require('babel-minify-webpack-plugin');
const CircularDependencyPlugin = require('circular-dependency-plugin');

// config
let webpackCommon = require('./webpack.common');
const config = require('./config');

let webpackProd = {
  devtool: config.enabled.sourceMaps ? 'source-map' : false,
  module: {
    rules: [
      {
        test: /\.js$/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
          },
        },
      },
    ],
  },
  optimization: {
    minimize: config.env.production,
    concatenateModules: config.env.production,
    sideEffects: config.env.production,
    runtimeChunk: 'single',
    moduleIds: 'deterministic',
    splitChunks: {
      chunks: 'async',
      name: config.env.production ? false : 'main',

      cacheGroups: {
        vendor: {
          test: /[\\/]node_modules[\\/]/,
          priority: -10,
          reuseExistingChunk: true,
          name: 'vendor',
          chunks: 'all',
        },
      },
    },
  },
  plugins: [
    new CleanWebpackPlugin({
      verbose: false,
    }),
    new MinifyPlugin(),
    new CircularDependencyPlugin({
      exclude: /node_modules/,
      failOnError: false,
    }),
  ],
};

if (config.enabled.optimize) {
  const ImageMinimizerPlugin = require('image-minimizer-webpack-plugin');

  webpackProd = merge(webpackProd, {
    optimization: {
      minimizer: [
        new ImageMinimizerPlugin({
          minimizer: {
            implementation: ImageMinimizerPlugin.squooshMinify,
            options: {
              encodeOptions: {
                mozjpeg: {
                  // That setting might be close to lossless, but it’s not guaranteed
                  // https://github.com/GoogleChromeLabs/squoosh/issues/85
                  quality: 100,
                },
                webp: {
                  lossless: 1,
                },
                avif: {
                  // https://github.com/GoogleChromeLabs/squoosh/blob/dev/codecs/avif/enc/README.md
                  cqLevel: 0,
                },
              },
            },
          },
        }),
      ],
    },
  });
}

webpackCommon = merge(webpackCommon, webpackProd);

if (config.enabled.cacheBusting) {
  const WebpackAssetsManifest = require('webpack-assets-manifest');

  webpackCommon.plugins.push(
    new WebpackAssetsManifest({
      output: 'assets.json',
      space: 2,
      writeToDisk: false,
      assets: config.manifest,
      customize: (entry) => {
        const { key, value } = entry;
        const sourcePath = path.basename(path.dirname(key));
        const targetPath = path.basename(path.dirname(value));
        if (sourcePath === targetPath) {
          return entry;
        }

        return {
          key: `${targetPath}/${key}`,
          value,
        };
      },
    })
  );
}

module.exports = webpackCommon;
