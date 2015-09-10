var elixir = require('laravel-elixir');

require('laravel-elixir-css-url-adjuster');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
var paths = {
 'jquery': './vendor/bower_components/jquery/',
 'bootstrap': './vendor/bower_components/bootstrap-sass-official/assets/',
 'fontawesome': './vendor/fortawesome/font-awesome/',
    'lineicons': './resources/assets/plugins/line-icons/',
 'sass': './resources/assets/sass/',
    'assets': './resources/assets/',
    'inspinaimg': 'resources/assets/img/inspina/'
}

elixir(function(mix) {
    /*mix.sass([paths.sass+'app.scss', paths.fontawesome + "scss/!*"], 'public/css/app.css', '/')*/
  mix.sass(['app.scss','plugins/toastr/toastr.scss'])
        .copy(paths.fontawesome + 'fonts/**', 'public/fonts')
        .copy(paths.lineicons + 'fonts/**', 'public/fonts')
        .copy(paths.assets + 'img/patterns/**', 'public/assets/img/patterns')
        .copy(paths.assets + 'img/icons/**', 'public/assets/img/icons')
        .copy(paths.assets + 'img/bg/**', 'public/assets/img/bg')
        .copy(paths.assets + 'img/breadcrumbs/**', 'public/assets/img/breadcrumbs')
        .copy(paths.assets + 'img/team/**', 'public/assets/img/team')
        .copy(paths.assets + 'img/sliders/**', 'public/assets/img/sliders')
        .copy(paths.assets + 'img/custom/**', 'public/assets/img')
        .copy(paths.assets + 'img/custom/**', 'public/assets/img')
        .copy(paths.assets + 'plugins/revolution-slider/**', 'public/assets/plugins/revolution-slider')
        .copy(paths.assets + 'img/transparent/bg-black.png', 'public/assets/img')
        .copy(paths.assets + 'js/revolution-slider.js', 'public/assets/js')
        .copy(paths.assets + 'js/jquery.parallax.js', 'public/assets/js')
      .copy(paths.assets + 'js/jfc.js', 'public/assets/js')
      .copy(paths.assets + 'js/entosis.js', 'public/assets/js')
        .copy(paths.assets + 'js/app.js', 'public/assets/js');

    mix.sass(['inspina/style.scss', 'plugins/toastr/toastr.scss'], 'public/css/inspina.css')
        .copy(paths.inspinaimg + 'patterns/**', 'public/css/patterns')
        .copy(paths.assets + 'js/plugins/dataTables/swf/**', 'public/js/plugins/dataTables/swf')
        .copy(paths.assets + 'css/plugins/images/**', 'public/images');

    mix.urlAdjuster('./resources/assets/css/footers/footer-v1.css', {
        replace: ['../../img', '../assets/img']
    }, './resources/assets/css/footers/urladjusted');

    mix.urlAdjuster('./resources/assets/plugins/line-icons/line-icons.css', {
        replace: ['fonts/', '../fonts/']
    }, './resources/assets/css/plugins/line-icons');

    mix.urlAdjuster('./resources/assets/css/theme-skins/dark.css', {
        replace: ['../../img', '../assets/img']
    }, './resources/assets/css/theme-skins/urladjusted');

    mix.urlAdjuster('./resources/assets/css/app.css', {
        replace: ['../img', '../assets/img']
    }, './resources/assets/css/urladjusted');

   mix.urlAdjuster('./resources/assets/css/style.css', {
        replace: ['../img', '../assets/img']
    }, './resources/assets/css/urladjusted');

    mix.urlAdjuster('./resources/assets/css/blocks.css', {
        replace: ['../img', '../assets/img']
    }, './resources/assets/css/urladjusted');

    mix.urlAdjuster('./resources/assets/css/plugins.css', {
        replace: ['../img', '../assets/img']
    }, './resources/assets/css/urladjusted');

    mix.styles(['fonts.css',
                'urladjusted/app.css',
                'urladjusted/style.css',
                'urladjusted/blocks.css',
                'urladjusted/plugins.css',
                'headers/header-default.css',
                'footers/urladjusted/footer-v1.css',
                'plugins/line-icons/line-icons.css',
                'plugins/animate.css',
                'theme-colors/aqua.css',
                'theme-skins/urladjusted/dark.css',
                'custom.css',
                'plugins/skyforms/sky-forms.css'
                ]);


    mix.scripts([   'jquery/jquery.min.js',
                    'jquery/jquery-migrate.min.js',
                    'bootstrap/bootstrap.min.js',
                    'back-to-top.js',
                    'smoothScroll.js',
                    'plugins/toastr/toastr.js']);

    //inspina styles
    mix.styles(['plugins/skyforms/sky-forms.css',
                'plugins/dataTables/dataTables.bootstrap.css',
                'plugins/dataTables/dataTables.responsive.css',
                'plugins/dataTables/dataTables.tableTools.min.css',
                'plugins/line-icons/line-icons.css',
                'plugins/select2/select2.css',
                'plugins/typeahead/typeahead.css',
                'plugins/iCheck/custom.css'],  'public/css/inspinacss.css')
            .copy( './resources/assets/css/plugins/iCheck/green.png', 'public/css')
            .copy( './resources/assets/css/plugins/iCheck/green@2x.png', 'public/css');

    //inspina scripts
    mix.scripts([   'inspina/metisMenu/jquery.metisMenu.js',
        'inspina/slimscroll/jquery.slimscroll.min.js',
        'inspina/inspinia.js',
        'inspina/pace/pace.min.js',
        'plugins/toastr/toastr.js',
        'plugins/dataTables/jquery.dataTables.js',
        'plugins/dataTables/dataTables.bootstrap.js',
        'plugins/dataTables/dataTables.responsive.js',
        'plugins/dataTables/dataTables.tableTools.min.js',
        'plugins/validate/jquery.validate.min.js',
        'plugins/select2/select2.js',
        'plugins/typeahead/typeahead.bundle.js',
        'plugins/chartjs/Chart.min.js',
        'plugins/flot/jquery.flot.js',
        'plugins/flot/jquery.flot.time.js',
        'plugins/flot/jquery.flot.resize.js',
        'plugins/flot/jquery.flot.tooltip.min.js',
        'plugins/iCheck/icheck.min.js',
        'plugins/unveil/jquery.unveil.js'
    ], 'public/js/inspina.js');

});
