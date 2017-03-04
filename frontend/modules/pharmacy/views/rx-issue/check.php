<?php

use yii\helpers\Html;
use frontend\assets\LaddaAsset;
use frontend\assets\DataTableAsset;

LaddaAsset::register($this);
DataTableAsset::register($this);

$this->title = 'ตรวจสอบรายการใบสั่งยา';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/rx-issue/check-list']];
$this->params['breadcrumbs'][] = ['label' => 'ใบสั่งยารอตรวจสอบ', 'url' => ['/pharmacy/rx-issue/check-list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            <?= $this->title; ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="horizontal-space"></div>
        </div>

        <div class="profile-container">

           <?= $this->render('_header', ['ptar' => $ptar, 'profile' => $profile,'model' => $modelCpoe]) ?>

            <div class="profile-body">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="tabbable">
                        <?php echo $this->render('_tab_pharma', ['modelCpoe' => $modelCpoe]) ?>
                        <div class="tab-content tabs-flat bg-white">

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="tb-cpoe-create">

                                        <?php /*
                                        $this->render('_form', [
                                            'model' => $modelCpoe,
                                        ])*/
                                        ?>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <?= Html::beginForm(['order/update'], 'post', ['enctype' => 'multipart/form-data', 'id' => 'from-scanbarcode']) ?>
                                    <div class="well">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-sm-4">
                                                    <?= Html::input('text', 'barcode_ids', '', ['type' => 'text', 'id' => 'barcode_ids', 'value' => '', 'class' => 'form-control', 'autofocus' => 'autofocus', 'placeholder' => 'Barcode']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?= Html::endForm() ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <?=
                                    $this->render('_grid_details', [
                                        'model' => $modelCpoe,
                                        'searchModel' => $searchModel,
                                        'dataProvider' => $dataProvider,
                                    ])
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right"><?= Html::encode('หมายเหตุ'); ?></label>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <textarea rows="3" class="form-control" name="TbCpoe[cpoe_comment]" id="cpoe_comment"><?php echo $modelCpoe['cpoe_comment']; ?></textarea>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: right;">
                                    <?= Html::a('Close', ['/pharmacy/rx-issue/check-list'], ['class' => 'btn btn-default']); ?>
                                    <?= Html::button('Adj Requestion', ['class' => 'btn btn-warning', 'disabled' => $modelCpoe['cpoe_status'] == '6' ? true : false, 'id' => 'adj-requestion']); ?>
                                    <?= Html::button('Order Check', ['class' => 'btn btn-success', 'id' => 'order-check']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->render('modal'); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/vendor/jquery-pos-master/jquery.pos.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php
$script1 = <<< JS
    function init_click_handlers() {
        /* Adj Request */
        $('.activity-adjrequrst').click(function (e) {
            var fID = $(this).closest('tr').data('key');
            $('#modal_request').modal('show');
            $('#form-adjrequest').trigger("reset");
            $('#ids_request').val(fID);
        });
    }
    init_click_handlers(); //first run
    $('#cpoedetail-pjax').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    });

    $('#btn-save-reques').click(function (e) {
        var frm = $('#form-adjrequest');
        var l = $(this).ladda();
        var note = $('#RequestNote').val();
        if (note == '' || note == null) {
            swal("กรุณากรอกข้อมูล!", "", "warning");
        } else {
            l.ladda('start');
            $.ajax({
                type: 'POST',
                url: 'save-adjust-note',
                data: frm.serialize(),
                success: function (data) {
                    swal({
                        title: "",
                        text: "Save Completed!",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    l.ladda('stop');
                                    $('#modal_request').modal('hide');
                                    $.pjax.reload({container: '#cpoedetail-pjax'});
                                }
                            });
                },
                error: function (xhr, status, error) {
                    swal({
                        title: error,
                        text: "",
                        type: "error",
                        confirmButtonText: "OK"
                    });
                    l.ladda('stop');
                },
            });
        }
    });
        
    $('#adj-requestion').click(function (e) {
        var cpoeid = $('#tbcpoe-cpoe_id').val();
        swal({
            title: "ยืนยัน?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#53a93f",
            closeOnConfirm: false,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
            showLoaderOnConfirm: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'adj-requestion',
                                {
                                    cpoeid: cpoeid
                                },
                                function (data)
                                {
                                    swal("Success!", "", "success");
                                    $('#adj-requestion').attr('disabled', 'disabled');
                                }
                        ).fail(function (xhr, status, error)
                        {
                            swal("Oops...", error, "error");
                            console.log(error);
                        });
                    }
                });
    });
        
    $('#order-check').click(function (e) {
        var cpoeid = $('#tbcpoe-cpoe_id').val();
        swal({
            title: "Order Check?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#53a93f",
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
            showLoaderOnConfirm: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'order-check',
                                {
                                    cpoeid: cpoeid
                                },
                                function (data)
                                {
                                    if (data == 'Success') {
                                        swal("Check Completed!", "", "success");
                                    } else {
                                        swal(data, "", "error");
                                    }

                                }
                        ).fail(function (xhr, status, error)
                        {
                            swal("Oops...", error, "error");
                            console.log(error);
                        });
                    }
                });
    });
    $(function () {
        $(document).pos();
        $(document).on('scan.pos.barcode', function (event) {
            var barcode = event.code;
            $('#barcode_ids').val(barcode);
            var rows = $('table.kv-grid-table tbody tr');
            var keys = new Array();
            rows.each(function (i, item) {
                var a = $(item);
                keys.push(a.data('key'));
            });
            AddClassRows(barcode, keys,rows);
        });
    });
JS;
$this->registerJs($script1);
?>
<script type="text/javascript">
    function EditAdjust(e) {
        $('#modal_request').modal('show');
        $('#form-adjrequest').trigger("reset");
        $('#RequestNote').val(e.getAttribute("note"));
        $('#ids_request').val(e.getAttribute("id"));
    }

    function AddClassRows(barcode, keys, rows) {
        if (inArray(keys, parseFloat(barcode)) === true) {
            rows.each(function (i, item) {
                var tr = $(item);
                if (tr.data('key') == barcode) {
                    if ($(this).hasClass('success')) {
                        swal("Oops!", "เช็คแล้ว!", "error");
                    } else {
                        PostCheck(barcode);
                        $(this).addClass('success');
                    }
                }
            });
        } else {
            swal("Oops!", "ไม่พบข้อมูล!", "error");
            $('#from-scanbarcode').trigger("reset");
            return false;
        }
    }

    function inArray(myArray, myValue) {
        var inArray = false;
        myArray.map(function (key) {
            if (key === myValue) {
                inArray = true;
            }
        });
        return inArray;
    }

    function PostCheck(ids) {
        $.post(
                'save-check',
                {
                    ids: ids
                },
                function (result)
                {
                    if (result == 'Success') {
                        Notify('Completed!', 'bottom-right', '2000', 'success', 'fa-check-square-o', true);
                    } else {
                        swal('Oops!', "Error", "error");
                    }

                }
        ).fail(function (xhr, status, error)
        {
            swal("Oops...", error, "error");
            console.log(error);
        });
    }
</script>