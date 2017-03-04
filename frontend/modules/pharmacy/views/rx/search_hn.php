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
    <label class="col-sm-1 control-label no-padding-right"><h4>HN</h4></label>
    <div class="col-sm-4">
        <?= Html::input('text', 'HN', '', ['class' => 'form-control input-lg', 'placeholder' => 'กรอกรหัส HN', 'autofocus' => true, 'required' => true,]) ?>
    </div>
    <div class="col-sm-2">
        <?= Html::input('text', 'VN', '', ['class' => 'form-control input-lg', 'id' => 'VN', 'type' => 'hidden',]) ?>
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
                บันทึกใบสั่งยา <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-success">
                <li>
                    <?= Html::a('Rx Order', 'javascript:void(0);', ['onclick' => 'CreateRxOrder(1011,1);']) ?>
                </li>
                <li>
                    <?= Html::a('Chemo Order', 'javascript:void(0);', ['onclick' => 'CreateRxOrder(1012,1);']) ?>
                </li>
                <li>
                    <?= Html::a('Pre-Rx Order', 'javascript:void(0);', []) ?>
                </li>
                <li>
                    <?= Html::a('Pre-Chemo Order', 'javascript:void(0);', []) ?>
                </li>
                <li>
                    <?= Html::a('รับรองชื่อยานอกบัญชี รพ.', 'javascript:void(0);', []) ?>
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
                    $('#VN').val(result.vn);
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
    function CreateRxOrder(type, schd) {
        var VN = $('#VN').val() || null;
        if (VN === null) {
            swal({
                title: "กรุณาเลือกผู้ป่วย!",
                text: "",
                type: "error",
                confirmButtonText: "OK"
            });
        } else {
            window.location.href = 'create-order-chemo?data=' + VN + '&type=' + type + '&schd=' + schd;
        }
    }
</script>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/bootstrap-dropdownhover.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>