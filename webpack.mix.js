const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// frontend -------------------------
mix.js([
    'resources/assets/js/app.js',
    'resources/assets/plugins/daterangepicker/daterangepicker.js',
    'node_modules/owl.carousel/dist/owl.carousel.min.js',
], 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
mix.copyDirectory('resources/assets/img', 'public/images');
mix.copyDirectory('resources/assets/fonts', 'public/fonts');
mix.styles([
    'resources/assets/styles/style.css',
    'resources/assets/plugins/daterangepicker/daterangepicker.css',
    'resources/assets/admin/plugins/datatables/dataTables.bootstrap.css',
    'node_modules/owl.carousel/dist/assets/owl.carousel.min.css',
], 'public/css/all.css');


// admin -----------------------------
//fonts
mix.copyDirectory([
    'node_modules/font-awesome/fonts',
    'node_modules/ionicons/dist/fonts',
], 'public/admin/fonts');

//app js, style
mix.js([
    'resources/assets/admin/js/app.js',
], 'public/admin/js')
   .sass('resources/assets/admin/sass/app.scss', 'public/admin/css');
mix.styles([
    'resources/assets/admin/styles/AdminLTE.min.css',
    'resources/assets/admin/styles/_all-skins.min.css',
], 'public/admin/css/all.css');

//plugins
mix.styles([
    'node_modules/jqueryui/jquery-ui.css',
    'node_modules/icheck/skins/flat/blue.css',
    'node_modules/morris.js/morris.css',
    'node_modules/jvectormap/jquery-jvectormap.css',
    'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css',
    'node_modules/daterangepicker/daterangepicker.css',
    'node_modules/bootstrap3-wysihtml5-npm/dist/bootstrap3-wysihtml5.min.css',
    'resources/assets/admin/plugins/datatables/dataTables.bootstrap.css',
], 'public/admin/plugins/vendor.css');

mix.js([
    'resources/assets/admin/plugins/jquery-jvectormap-world-mill-en.js',
    'resources/assets/admin/plugins/sparkline/jquery.sparkline.min.js',
    'resources/assets/admin/plugins/fastclick/fastclick.min.js',
    'resources/assets/admin/plugins/slimScroll/jquery.slimscroll.min.js',
], 'public/admin/plugins/vendor.js');

mix.copyDirectory([
    'resources/assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
], 'public/admin/plugins/');

mix.copyDirectory([
    'resources/assets/admin/plugins/datatables/jquery.dataTables.min.js',
], 'public/admin/plugins/');

mix.copyDirectory([
    'resources/assets/admin/plugins/datatables/dataTables.bootstrap.min.js',
], 'public/admin/plugins/');

mix.copyDirectory([
    'resources/assets/admin/plugins/jquery.formatCurrency-1.4.0.min.js',
], 'public/admin/plugins/');

mix.copyDirectory([
    'resources/assets/admin/img',
], 'public/admin/img');

mix.copyDirectory([
    'resources/assets/admin/plugins/datatables/images',
], 'public/admin/plugins/images');

//LTE
mix.js([
    'resources/assets/admin/LTE/app.js',
    'resources/assets/admin/LTE/dashboard.js',
    'resources/assets/admin/LTE/demo.js',
], 'public/admin/js/LTE.js');
