<?php

use yii\helpers\Html;
use frontend\assets\LaddaAsset;
use frontend\assets\DataTableAsset;

LaddaAsset::register($this);
DataTableAsset::register($this);

$this->title = 'รายละเอียดใบสั่งยา';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/rx-issue/verify-list']];
$this->params['breadcrumbs'][] = ['label' => 'จัดยา', 'url' => ['/pharmacy/rx-issue/verify-list']];
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

            <?= $this->render('_header', ['header' => $header, 'ptar' => $ptar,]) ?>

            <div class="profile-body">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="tabbable">
                        <?php echo $this->render('_tab_pharma', ['modelCpoe' => $modelCpoe]) ?>
                        <div class="tab-content tabs-flat bg-white">

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="tb-cpoe-create">

                                        <?=
                                        $this->render('_form', [
                                            'model' => $modelCpoe,
                                        ])
                                        ?>

                                    </div>
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
                                    <?= Html::a('Close', ['/pharmacy/rx-issue/verify-list'], ['class' => 'btn btn-default']); ?>
                                    <?= Html::button('Adj Requestion', ['class' => 'btn btn-warning', 'disabled' => $modelCpoe['cpoe_status'] == '6' ? true : false, 'id' => 'adj-requestion']); ?>
                                    <?= Html::button('Order Verify', ['class' => 'btn btn-success', 'id' => 'order-verify']); ?>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?= Html::encode('Order Print') ?> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <?= Html::a('<i class="text-danger fa fa-file-pdf-o"></i> A4', ['export-download', 'id' => $modelCpoe['cpoe_id'], 'type' => 'A4'], ['data-pjax' => 0, 'target' => '_blank']); ?>
                                            </li>
                                            <li>
                                                <?= Html::a('<i class="text-muted fa fa-file-text-o"></i> Slip', ['export-download', 'id' => $modelCpoe['cpoe_id'], 'type' => 'Tabloid'], ['data-pjax' => 0, 'target' => '_blank']); ?>
                                            </li>
                                        </ul>
                                    </div>
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
<?php
$script1 = <<< JS
    function init_click_handlers() {
        /* OK */
        $('.activity-ok').click(function (e) {
            var fID = $(this).closest('tr').data('key');
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
                                    'ok-verify',
                                    {
                                        id: fID
                                    },
                                    function (data)
                                    {
                                        swal.close();
                                        $.pjax.reload({container: '#cpoedetail-pjax'});
                                    }
                            ).fail(function (xhr, status, error)
                            {
                                swal("Oops...", error, "error");
                                console.log(error);
                            });
                        }
                    });
        });

        /* Cencel */
        $('.activity-cancel').click(function (e) {
            var fID = $(this).closest('tr').data('key');
            swal({
                title: "Cancel?",
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
                                    'cencel-verify',
                                    {
                                        id: fID
                                    },
                                    function (data)
                                    {
                                        swal.close();
                                        $.pjax.reload({container: '#cpoedetail-pjax'});
                                    }
                            ).fail(function (xhr, status, error)
                            {
                                swal("Oops...", error, "error");
                                console.log(error);
                            });
                        }
                    });
        });

        /* OK All */
        $('.activity-ok-all').click(function (e) {
            var cpoeid = $('#tbcpoe-cpoe_id').val();
            var count = '$count';
            swal({
                title: "OK ALL?",
                text: 'ทั้งหมด ' + count + ' รายการ',
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
                                    'verify-ok-all',
                                    {
                                        cpoeid: cpoeid
                                    },
                                    function (data)
                                    {
                                        swal.close();
                                        $.pjax.reload({container: '#cpoedetail-pjax'});
                                    }
                            ).fail(function (xhr, status, error)
                            {
                                swal("Oops...", error, "error");
                                console.log(error);
                            });
                        }
                    });
        });

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
        
    $('#order-verify').click(function (e) {
        var cpoeid = $('#tbcpoe-cpoe_id').val();
        swal({
            title: "Verify?",
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
                                'order-verify',
                                {
                                    cpoeid: cpoeid
                                },
                                function (data)
                                {
                                    if (data == 'Success') {
                                        swal("Verify Completed!", "", "success");
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
JS;
$this->registerJs($script1);
?>
<div id="dataview"></div>
<script type="text/javascript">
    function EditAdjust(e) {
        $('#modal_request').modal('show');
        $('#form-adjrequest').trigger("reset");
        $('#RequestNote').val(e.getAttribute("note"));
        $('#ids_request').val(e.getAttribute("id"));
    }



    function Test() {
        var id = '1';
        $.ajax({
            url: 'view',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                $('#dataview').html(data);
                setTimeout(function () {
                    $('#tbrxdetails').DataTable(
                            {
                                "dom": '<"pull-left"f><"pull-right"Tl>t<"pull-left"i>p',
                                "pageLength": 10,
                                "responsive": true,
                                //"bSortable": false,
                                "ordering": false,
                                "language": {
                                    "lengthMenu": " _MENU_ ",
                                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                    "search": 'ค้นหา _INPUT_ ',
                                },
                                "aLengthMenu": [
                                    [5, 10, 15, 20, 100, -1],
                                    [5, 10, 15, 20, 100, "All"]
                                ]
                            }
                    );
                }, 10);

            },
            error: function (xhr, status, error) {
                swal({
                    title: "Error!",
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
                $('.page-content').waitMe('hide');
                //alert(xhr.responseText);
            },
        });
    }
</script>