var webpack = require('webpack');
const path = require('path');

module.exports = {
    entry: './src/index.js',
    mode: 'production',
    output: {
        filename: 'bundle.js',
        path: path.resolve(__dirname, 'dist')
    },
    plugins: [
        new webpack.ProvidePlugin({
            '$': 'jquery',
            'jQuery': 'jquery',
            'Popper': ['popper.js', 'default']
        })
    ],
    module: {
        rules: [{
            test: require.resolve('jquery'),
            use: [{
                loader: 'expose-loader',
                options: 'jQuery'
            },{
                loader: 'expose-loader',
                options: '$'
            }]},
		{ test: /\.handlebars$/, loader: "handlebars-loader" }
               ]
    },
    // Workaround to make Handlebars work
    node: {
	fs: 'empty'
    }
};
