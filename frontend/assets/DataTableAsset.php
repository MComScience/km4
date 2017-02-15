<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class DataTableAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/datatables.net-bs/css/dataTables.bootstrap.min.css',
        'vendor/DataTables-1.10.12/Responsive/css/responsive.bootstrap.min.css',
        'vendor/DataTables-1.10.12/Responsive/css/responsive.jqueryui.min.css',
        'vendor/DataTables-1.10.12/media/css/buttons.dataTables.min.css'
    ];
    public $js = [
        'vendor/DataTables-1.10.12/media/js/jquery.dataTables.min.js',
        'vendor/datatables.net-bs/js/dataTables.bootstrap.min.js',
        'vendor/DataTables-1.10.12/Responsive/js/dataTables.responsive.min.js',
        'vendor/DataTables-1.10.12/Responsive/js/responsive.jqueryui.min.js',
        //'vendor/DataTables-1.10.12/media/js/date-uk.js',
        //'vendor/DataTables-1.10.12/media/js/monthYear.js',
        //'vendor/DataTables-1.10.12/media/js/dataTables.buttons.min.js',
        //'vendor/DataTables-1.10.12/media/js/buttons.html5.min.js',
        //'vendor/DataTables-1.10.12/media/js/pdfmake.min.js',
        //'vendor/DataTables-1.10.12/media/js/vfs_fonts.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];

}
