const { merge } = require('webpack-merge');
const common = require('./webpack.common.js');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
// const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer'); // Optional: for analyzing bundle sizes

module.exports = merge(common, {
  mode: 'production',
  devtool: 'source-map', // Recommended for production for debugging, but can be omitted or changed
  output: {
    path: path.resolve(__dirname, 'assets/dist'), // Output to theme's assets/dist directory
    // WordPress needs to know this path to enqueue correctly.
    // It should match where your WP theme expects to find these assets.
    publicPath: '/wp-content/themes/technoproject-theme/assets/dist/',
    filename: 'js/[name].[contenthash:8].js', // Cache busting with contenthash
    chunkFilename: 'js/[name].[contenthash:8].chunk.js',
    clean: true, // Clean the output directory before emit
  },
  optimization: {
    minimize: true,
    minimizer: [
      new TerserPlugin({
        terserOptions: {
          compress: {
            drop_console: true, // Remove console.log statements
            drop_debugger: true,
            // pure_funcs: ['console.log', 'console.info'], // Alternative way to drop console
          },
          mangle: {
            safari10: true, // Workaround for Safari 10/11 bugs
          },
          format: {
            comments: false, // Remove comments
          },
        },
        extractComments: false, // Do not extract comments to a separate file
      }),
      new CssMinimizerPlugin({
        minimizerOptions: {
          preset: [
            'default',
            {
              discardComments: { removeAll: true },
            },
          ],
        },
      }),
    ],
    splitChunks: {
      chunks: 'all', // Apply to all chunks
      cacheGroups: {
        // Vendor chunk for node_modules
        vendor: {
          test: /[\\/]node_modules[\\/]/,
          name: 'vendors', // Name of the vendor chunk
          chunks: 'all',
          priority: 10, // Higher priority
          reuseExistingChunk: true,
        },
        // Common chunk for shared modules (if any, beyond vendors)
        // common: {
        //   name: 'common',
        //   minChunks: 2, // Module must be shared in at least 2 chunks
        //   chunks: 'all',
        //   priority: 5,
        //   reuseExistingChunk: true,
        // },
        // Specific chunk for React library for better caching, as per document
        react: {
          test: /[\\/]node_modules[\\/](react|react-dom|react-router-dom)[\\/]/,
          name: 'react',
          chunks: 'all',
          priority: 20, // Highest priority for react libs
        },
      },
    },
    runtimeChunk: { // Extract runtime boilerplate into a separate chunk
      name: 'runtime',
    },
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'css/[name].[contenthash:8].css',
      chunkFilename: 'css/[name].[contenthash:8].chunk.css',
    }),
    // Optional: uncomment to analyze bundle sizes after build
    // process.env.ANALYZE && new BundleAnalyzerPlugin({
    //   analyzerMode: 'static', // Generates a report file
    //   openAnalyzer: false,
    //   reportFilename: '../../bundle-report.html' // Relative to output.path
    // })
  ].filter(Boolean), // Filter out conditional plugins if they are null/false
  performance: {
    hints: 'warning', // Show a warning if asset size exceeds limits
    maxAssetSize: 250 * 1024, // 250kb
    maxEntrypointSize: 300 * 1024, // 300kb
  },
});
