<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $this->registerCssFile(Yii::getAlias('@web') . '/css/bootstrap-dropdownhover.min.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]); ?>
<style>
    table#details thead th{
        text-align: center;
    }
</style>
<?php
$form = ActiveForm::begin([
            'id' => 'searchhn-form',
            'options' => ['class' => 'form-horizontal'],
        ])
?>
<div class="form-group">
    <label class="col-sm-1 control-label no-padding-right">ค้นหา</label>
    <div class="col-sm-4">
        <?= Html::input('text', 'HN', '', ['class' => 'form-control input-lg', 'placeholder' => 'กรอกรหัส HN', 'autofocus' => true]) ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title"></h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-1 text-center">
                <br/>
                <img src="http://192.168.1.53/km4/profiles/default/admin.png" class="img-circle" alt="Avatar" width="50" height="50">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-11">
                <div id="content-search">
                    <table id="details" class="table table-hover table-bordered table-striped table-condensed kv-table-wrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>สิทธิการรักษา</th>
                                <th>เลขที่ใบส่งตัว</th>
                                <th>วันเริ่มใบส่งตัว</th>
                                <th>วันสิ้นสุดใบส่งตัว</th>
                                <th>ใช้สิทธิ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    -
                                </td>
                                <td class="text-left"> 
                                    -
                                </td>
                                <td class="text-center">
                                    -
                                </td>
                                <td class="text-center">
                                    -
                                </td>
                                <td class="text-center">
                                    -
                                </td>
                                <td class="text-center">
                                    -
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group" style="text-align: right;">
    <div class="col-md-12" >
        <?= Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => "modal"]); ?>
        <div class="btn-group dropdown">
            <a class="btn btn-success dropdown-toggle"  data-toggle="dropdown" data-hover="dropdown" data-delay="100">
                Action <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-success">
                <li>
                    <a href="javascript:void(0);">Rx Order</a>
                </li>
                <li>
                    <a href="javascript:void(0);">Chemo Order</a>
                </li>
                <li>
                    <a href="javascript:void(0);">Pre-Rx Order</a>
                </li>
                <li>
                    <a href="javascript:void(0);">Pre-Chemo Order</a>
                </li>
                <li>
                    <a href="javascript:void(0);">รับรองชื่อยานอกบัญชี รพ.</a>
                </li>
            </ul>
        </div>

    </div>
</div>
<?php ActiveForm::end() ?>
<script type="text/javascript">
    $('#searchhn-form').on('beforeSubmit', function (e) {
        e.preventDefault();
        var dataArray = $(this).serializeArray(),
                dataObj = {};
        $(dataArray).each(function (i, field) {
            dataObj[field.name] = field.value;
        });
        console.log(dataObj['HN']);
        LoadingClass();
        $.ajax({
            type: 'GET',
            url: 'query-ardetail',
            data: {HN: dataObj['HN']},
            dataType: "JSON",
            success: function (result) {
                if (result === 'No data') {
                    swal({
                        title: "ไม่พบข้อมูล",
                        text: "",
                        type: "error",
                        confirmButtonText: "OK"
                    });
                } else {
                    $('.panel-title').html(result.name);
                    $('#content-search').html(result.table);
                }
                $('.modal-body').waitMe('hide');
            },
            error: function (xhr, status, error) {
                swal({
                    title: error,
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
                $('.modal-body').waitMe('hide');
            },
        });
        return false;
    });
    function LoadingClass() {
        $('.modal-body').waitMe({
            effect: 'roundBounce', //roundBounce,ios,progressBar
            text: 'Please wait...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000', //default #000
            maxSize: '',
            source: 'img.svg',
            fontSize: '20px',
            onClose: function () {
            }
        });
    }
</script>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/bootstrap-dropdownhover.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>