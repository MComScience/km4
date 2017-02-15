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
        'newcss/vendor/fontawesome/css/font-awesome.css',
        'newcss/vendor/metisMenu/dist/metisMenu.css',
        'newcss/vendor/animate.css/animate.css',
        'newcss/vendor/bootstrap/dist/css/bootstrap.css',
        'newcss/vendor/datatables.net-bs/css/dataTables.bootstrap.min.css',
        'newcss/vendor/sweetalert/lib/sweet-alert.css',
        'newcss/vendor/toastr/build/toastr.min.css',
        'newcss/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css',
        'newcss/fonts/pe-icon-7-stroke/css/helper.css',
        'newcss/styles/style.css',
        'newcss/styles/static_custom.css'
    ];
    public $js = [
//        "newcss/vendor/jquery/dist/jquery.min.js",
        "newcss/vendor/jquery-ui/jquery-ui.min.js",
"newcss/vendor/peity/jquery.peity.min.js",
        "newcss/vendor/slimScroll/jquery.slimscroll.min.js",
        "newcss/vendor/bootstrap/dist/js/bootstrap.min.js",
        "newcss/vendor/metisMenu/dist/metisMenu.min.js",
        "newcss/vendor/iCheck/icheck.min.js",
        "newcss/vendor/sparkline/index.js",
        "newcss/vendor/datatables/media/js/jquery.dataTables.min.js",
        "newcss/vendor/datatables.net-bs/js/dataTables.bootstrap.min.js",
        "newcss/vendor/pdfmake/build/pdfmake.min.js",
        "newcss/vendor/pdfmake/build/vfs_fonts.js",
        "newcss/vendor/datatables.net-buttons/js/buttons.html5.min.js",
        "newcss/vendor/datatables.net-buttons/js/buttons.print.min.js",
        "newcss/vendor/datatables.net-buttons/js/dataTables.buttons.min.js",
        "newcss/vendor/datatables.net-buttons-bs/js/buttons.bootstrap.min.js",
        "newcss/scripts/homer.js",
        "newcss/vendor/sweetalert/lib/sweet-alert.min.js",
        "newcss/vendor/toastr/build/toastr.min.js",
'js/price_format.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
