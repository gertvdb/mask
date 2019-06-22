const path = require('path');
const globEntry = require('webpack-glob-entry');

module.exports = {
    entry: globEntry("./js/*.js"),
    output: {
        filename: '[name].es6.js',
        path: path.resolve(__dirname, 'js')
    },
    mode: 'development',
    module: {
        rules: [
            {
                test: /\.m?js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            }
        ]
    },
    externals: {
        jquery: 'jQuery'
    }
};
