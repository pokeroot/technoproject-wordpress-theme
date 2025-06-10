const { merge } = require('webpack-merge');
const common = require('./webpack.common.js');
const path = require('path');
const ReactRefreshWebpackPlugin = require('@pmmmwh/react-refresh-webpack-plugin');

module.exports = merge(common, {
  mode: 'development',
  devtool: 'eval-cheap-module-source-map', // Fast source maps for development
  output: {
    // For dev, output path is less critical as files are served from memory,
    // but publicPath is important for dev server routing.
    // WordPress integration will need careful publicPath handling for assets.
    // This publicPath assumes assets will be served from the root of the dev server.
    // For WP integration, it might be '/wp-content/themes/technoproject-theme/dist/'
    publicPath: '/',
    filename: 'js/[name].bundle.js',
    chunkFilename: 'js/[name].chunk.js',
  },
  devServer: {
    static: {
      directory: path.join(__dirname, 'dist'), // Serves from /dist (where HtmlWebpackPlugin might output)
    },
    compress: true,
    port: 3000, // Or any other preferred port
    hot: true, // Enable Hot Module Replacement
    historyApiFallback: true, // For single-page applications
    open: true, // Open the browser after server had been started
    proxy: {
      '/wp-json': { // Proxy requests that start with /wp-json
        target: 'https://technoproject.com.co', // Your production/staging WordPress site
        changeOrigin: true, // Important for virtual hosted sites
        secure: false, // Allow proxying to HTTPS sites, even if dev server is HTTP (though both should ideally be HTTPS)
        // You might need to configure pathRewrite if your WordPress is in a subdirectory on the target,
        // but for /wp-json directly under the domain, it's usually not needed.
        // pathRewrite: { '^/api': '' }, // Example: if you wanted to proxy /api to target's root

        // Optional: Add a log level to see proxy activity in the console
        logLevel: 'debug'
      }
    },
    client: {
      overlay: { // Show errors and warnings in the browser overlay
        errors: true,
        warnings: false, // Optionally disable warnings overlay
      },
    },
  },
  plugins: [
    new ReactRefreshWebpackPlugin(), // For React Fast Refresh (HMR for React components)
    // MiniCssExtractPlugin is not typically used in dev for HMR with styles;
    // style-loader (in webpack.common.js) handles this.
  ],
  // Tell Webpack to use the development environment variable
  // This is used in webpack.common.js to switch SCSS loader
  // Webpack 5 sets process.env.NODE_ENV based on the 'mode' automatically.
  // So explicitly setting it via DefinePlugin might not be necessary for this specific use case,
  // but can be useful for other flags.
  // new webpack.DefinePlugin({
  //   'process.env.NODE_ENV': JSON.stringify('development'),
  // }),
});
