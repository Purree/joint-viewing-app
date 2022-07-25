const path = require('path')
const webpack = require('webpack')

// File only for IDE hints
module.exports = {
    resolve: {
        extensions: ['.js', '.json', '.vue'],
        alias: {
            '@': path.join(__dirname, 'resources/js'),
            '@@': path.join(__dirname, 'resources/sass'),
        }
    }
}
