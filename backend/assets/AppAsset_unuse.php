<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'newcss/vendor/fontawesome/css/font-awesome.css',
        'newcss/vendor/metisMenu/dist/metisMenu.css',
        'newcss/vendor/animate.css/animate.css',
        'newcss/vendor/bootstrap/dist/css/bootstrap.css',
        'newcss/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css',
        'newcss/fonts/pe-icon-7-stroke/css/helper.css',
        'newcss/styles/style.css',
        'newcss/vendor/datatables/media/js/jquery.dataTables.min.js',
        'newcss/vendor/datatables.net-bs/js/dataTables.bootstrap.min.js',
//        'assets/css/font-awesome.min.css',
//        'assets/css/weather-icons.min.css',
//        'assets/css/demo.min.css',
//        'assets/css/typicons.min.css',
//        'assets/css/animate.min.css',
//        'assets/css/beyond.css',
//        'css/datatable.css'
    ];
    public $js = [
        'assets/js/skins.min.js',
        'newcss/vendor/jquery/dist/jquery.min.js',
        'newcss/vendor/jquery-ui/jquery-ui.min.js',
        'newcss/vendor/slimScroll/jquery.slimscroll.min.js',
        'newcss/vendor/bootstrap/dist/js/bootstrap.min.js',
        'newcss/vendor/jquery-flot/jquery.flot.js',
        'newcss/vendor/jquery-flot/jquery.flot.resize.js',
        'newcss/vendor/jquery-flot/jquery.flot.pie.js',
        'newcss/vendor/flot.curvedlines/curvedLines.js',
        'newcss/vendor/jquery.flot.spline/index.js',
        'newcss/vendor/metisMenu/dist/metisMenu.min.js',
        'newcss/vendor/iCheck/icheck.min.js',
        'newcss/vendor/peity/jquery.peity.min.js',
        'newcss/vendor/sparkline/index.js',
        'newcss/scripts/homer.js',
        'newcss/scripts/charts.js',
        
        'newcss/vendor/datatables/media/js/jquery.dataTables.min.js',
        'newcss/vendor/datatables.net-bs/js/dataTables.bootstrap.min.js',
        
         'newcss/vendor/pdfmake/build/pdfmake.min.js',
         'newcss/vendor/pdfmake/build/vfs_fonts.js',
         'newcss/vendor/datatables.net-buttons/js/buttons.html5.min.js',
         'newcss/vendor/datatables.net-buttons/js/buttons.print.min.js',
         'newcss/vendor/datatables.net-buttons/js/dataTables.buttons.min.js',
         'newcss/vendor/datatables.net-buttons-bs/js/buttons.bootstrap.min.js',
        
    
//        'assets/js/slimscroll/jquery.slimscroll.min.js',
//        'assets/js/beyond.js',
//        // 'js/jquery.dataTables.js',
//        //  'js/dataTables.bootstrap.js',
//        // 'js/dataTables.responsive.js',
//        'js/setall.js',
//        'js/jquery.form-validator.min.js',
//        'js/addnondrug.js',
//        'js/price_format.min.js',
//        'js/bootbox.min.js',
//        'js/datatable.js',
//        'js/toastr/toastr.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
