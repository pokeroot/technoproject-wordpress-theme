const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin'); // Used in prod, but loader choice depends on env

module.exports = {
  entry: {
    // As per the document, though a theme might not have admin/public entries like this
    // if the React app is solely for the theme's main frontend.
    // Adjust if only one main entry point is needed for the decoupled frontend.
    main: './src/index.tsx',
    // admin: './src/admin/index.tsx', // Assuming these might be separate React apps or entries
    // public: './src/public/index.tsx' // For now, focusing on the main app.
  },
  resolve: {
    extensions: ['.tsx', '.ts', '.js', '.jsx'],
    alias: {
      '@': path.resolve(__dirname, 'src'),
      '@components': path.resolve(__dirname, 'src/components'),
      '@types': path.resolve(__dirname, 'src/types'),
      '@hooks': path.resolve(__dirname, 'src/hooks'),
      '@contexts': path.resolve(__dirname, 'src/contexts'), // Added based on created structure
      '@services': path.resolve(__dirname, 'src/services'),
      '@utils': path.resolve(__dirname, 'src/utils'),
      '@styles': path.resolve(__dirname, 'src/styles'),
      '@assets': path.resolve(__dirname, 'src/assets')
    }
  },
  module: {
    rules: [
      {
        test: /\.tsx?$/,
        exclude: /node_modules/,
        use: [
          {
            loader: 'ts-loader',
            options: {
              transpileOnly: true, // Speeds up compilation; type checking is done by IDE/tsc
              // experimentalWatchApi: true, // This option might be deprecated or unnecessary with webpack 5
            }
          }
        ]
      },
      {
        test: /\.scss$/,
        use: [
          // Loader for MiniCssExtractPlugin should only be used in production
          // In development, 'style-loader' is typically used for HMR.
          // This will be chosen in webpack.dev.js and webpack.prod.js.
          process.env.NODE_ENV === 'production'
            ? MiniCssExtractPlugin.loader
            : 'style-loader',
          {
            loader: 'css-loader',
            options: {
              modules: {
                localIdentName: '[name]__[local]--[hash:base64:5]',
                auto: (resourcePath) => !resourcePath.includes('global'), // Enable CSS modules only for non-global files
              },
              sourceMap: true
            }
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: true,
              sassOptions: {
                includePaths: [path.resolve(__dirname, 'src/styles')]
              }
            }
          }
        ]
      },
      {
        test: /\.(png|jpe?g|gif|svg|webp)$/i,
        type: 'asset', // Webpack 5 asset modules
        parser: {
          dataUrlCondition: {
            maxSize: 8 * 1024 // Inline assets smaller than 8kb
          }
        },
        generator: {
          filename: 'assets/images/[name].[hash:8][ext]' // Output path for images
        }
      },
      {
        test: /\.(woff|woff2|eot|ttf|otf)$/i,
        type: 'asset/resource', // Webpack 5 asset modules
        generator: {
          filename: 'assets/fonts/[name].[hash:8][ext]' // Output path for fonts
        }
      }
    ]
  },
  plugins: [
    // HtmlWebpackPlugin generates an HTML file from a template.
    // For a decoupled WP theme, this might be used to generate a base HTML
    // if React is not injected into a PHP template, or for a standalone dev server.
    new HtmlWebpackPlugin({
      template: './src/index.html', // Path to your source index.html
      chunks: ['main'], // Which bundles to include
      filename: 'index.html' // Output filename
    }),
    // Example for admin entry, if used:
    // new HtmlWebpackPlugin({
    //   template: './src/admin/index.html',
    //   chunks: ['admin'],
    //   filename: 'admin.html'
    // })
  ]
};
