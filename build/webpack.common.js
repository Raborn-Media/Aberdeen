'use strict'; // eslint-disable-line

const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin');
const CopyPlugin = require('copy-webpack-plugin');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const ESLintPlugin = require('eslint-webpack-plugin');

// config
const config = require('./config');

const assetsFilenames = `[name]${
  config.enabled.cacheBusting ? '.[contenthash]' : ''
}`;

let webpackConfig = {
  mode: config.env.production ? 'production' : 'development',
  context: config.paths.assets,
  entry: config.entry,
  devtool: false,
  output: {
    path: config.paths.dist,
    publicPath: '.' + config.publicPath,
    filename: `scripts/${assetsFilenames}.js`,
  },
  stats: {
    hash: false,
    version: false,
    timings: false,
    children: false,
    errors: true,
    errorDetails: true,
    warnings: false,
    chunks: false,
    modules: false,
    reasons: false,
    source: false,
    publicPath: false,
  },
  module: {
    rules: [
      {
        enforce: 'pre',
        test: /\.(js|s?[ca]ss)$/,
        include: config.paths.assets,
        loader: 'import-glob',
      },
      {
        test: /\.(sa|sc|c)ss$/,
        include: config.paths.assets,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
            options: {
              publicPath: '../',
            },
          },
          {
            loader: 'css-loader',
            options: { sourceMap: config.enabled.sourceMaps },
          },
          {
            loader: 'postcss-loader',
            options: {
              sourceMap: config.enabled.sourceMaps,
              postcssOptions: {
                parser: 'postcss-safe-parser',
                plugins: {
                  cssnano: {
                    preset: [
                      'default',
                      { discardComments: { removeAll: true } },
                    ],
                  },
                  autoprefixer: true,
                },
              },
            },
          },
          {
            loader: 'resolve-url-loader',
            options: { sourceMap: config.enabled.sourceMaps },
          },
          {
            loader: 'sass-loader',
            options: {
              sassOptions: {
                sourceMap: config.enabled.sourceMaps,
                sourceMapContents: false,
                outputStyle: 'compressed',
              },
            },
          },
        ],
      },
      {
        test: /\.(ttf|otf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
        include: config.paths.assets,
        type: 'asset/resource',
        generator: {
          filename: `[path]${assetsFilenames}[ext]`,
        },
      },
      {
        test: /\.(ttf|otf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
        include: /node_modules/,
        type: 'asset/resource',
        generator: {
          filename: (module) =>
            module.filename.replace('../node_modules', 'vendor'),
        },
      },
    ],
  },
  resolve: {
    modules: [config.paths.assets, 'node_modules'],
    enforceExtension: false,
  },
  externals: {
    jquery: 'jQuery',
  },
  optimization: {
    minimize: config.env.production,
  },
  plugins: [
    new CopyPlugin({
      patterns: [
        {
          from: config.copy,
          to: `[path]${assetsFilenames}[ext]`,
        },
      ],
    }),
    new StyleLintPlugin({
      failOnError: true,
      customSyntax: 'postcss-scss',
    }),
    new ESLintPlugin(),
    new MiniCssExtractPlugin({
      filename: `./styles/${assetsFilenames}.css`,
      ignoreOrder: true,
    }),
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      'window.jQuery': 'jquery',
    }),
    new FriendlyErrorsWebpackPlugin({
      clearConsole: true,
    }),
  ],
};

module.exports = webpackConfig;
