let mix = require('laravel-mix')

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .webpackConfig({
       resolve: {
           extensions: ['.js', '.vue', '.json'],
           alias: {
             'vue$': 'vue/dist/vue.esm.js',
             '@': __dirname + '/resources/assets/js'
           }
       }
   })
