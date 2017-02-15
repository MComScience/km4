<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AppAsset extends AssetBundle {

    public $cssOptions = ['position' => \yii\web\View::POS_HEAD,];
    public $jsOptions = ['position' => \yii\web\View::POS_END/* 'position' => View::POS_END */];
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css?v=1.0',
        /*'vendor/css/responsive.bootstrap.min.css?v=1.0',
        'vendor/css/loader.css?v=1.0',
        'vendor/waitMe/waitMe.min.css?v=1.0',
        'vendor/ladda/dist/ladda-themeless.min.css?v=1.0',
        'vendor/DataTables-1.10.12/media/css/dataTables.bootstrap.min.css?v=1.0',
        'vendor/summernote/dist/summernote.css?v=1.0',*/
    ];
    public $js = [
        //'js/bootstrap-hover-dropdown.js',
        /*'vendor/js.v1/jquery.form-validator.min.js?v=1.0',
        'vendor/js.v1/jquery.dataTables.js?v=1.0',
        'vendor/DataTables-1.10.12/media/js/jquery.dataTables.js',
        'vendor/DataTables-1.10.12/media/js/dataTables.bootstrap.min.js',
        'vendor/js/autoNumeric.js?v=1.0',
        'vendor/js.v1/isotope.pkgd.min.js?v=1.0',
        'vendor/js.v1/smoothscroll.js?v=1.0',
        'vendor/js.v1/price_format.min.js?v=1.0',
        'vendor/js/fuelux/wizard/wizard-custom.js?v=1.0',
        'vendor/js/toastr/toastr.js?v=1.0',
        'vendor/js/select2/select2.js?v=1.0',
        'vendor/js/validation/bootstrapValidator.js?v=1.0',
        'vendor/js/bootbox/bootbox.js?v=1.0',
        'vendor/js.v1/jquery.easy-overlay.js?v=1.0',
        'vendor/waitMe/waitMe.min.js?v=1.0',
        'vendor/ladda/dist/spin.min.js?v=1.0',
        'vendor/ladda/dist/ladda.min.js?v=1.0',
        'vendor/ladda/dist/ladda.jquery.min.js?v=1.0',
        'js/jquery.number.min.js?v=1.0',
        'js/setall.js?v=1.0',
        'js/setdatestk.js?v=1.0',
        'js/jquery.knob.min.js?v=1.0',
        "imageselect/js/jquery.Jcrop.min.js",
        "imageselect/js/imgSelect.js",
        "js/swfobject.js",
        "js/scriptcam.js",
        'js/waitmejs.js?v=1.0',
        'js/bootstrap-hover-dropdown.js?v=1.0',
        'vendor/summernote/dist/summernote.js?v=1.0',
        'vendor/summernote/dist/summernote-ext-print.js?v=1.0',
        'vendor/jquery-pos-master/jquery.pos.js',*/
        'vendor/idletimer/dist/idle-timer.1.1.0.min.js?v=1.0'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        //'fedemotta\datatables\DataTablesAsset',
    ];

}
