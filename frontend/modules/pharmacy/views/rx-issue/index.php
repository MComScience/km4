<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use frontend\assets\DataTableAsset;

DataTableAsset::register($this);

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/rx-issue/index']];
$this->params['breadcrumbs'][] = $this->title;
$style = 'border-top: 1px solid #ddd;';
?>
<style type="text/css">
    table.default th{
        text-align: center;
        white-space: nowrap;
        color: black;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode($this->title); ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="tb-cpoe-index">
                        <?php if ($action == 'check-list') : ?>
                            <?= Html::beginForm(['order/update'], 'post', ['enctype' => 'multipart/form-data', 'id' => 'from-scanbarcode']) ?>
                            <div class="well">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <?= Html::input('text', 'cpoe_prnum', '', ['type' => 'text', 'id' => 'cpoe_prnum', 'value' => '', 'class' => 'form-control', 'autofocus' => 'autofocus', 'placeholder' => 'ยิง Barcode หรือกรอก เลขที่ใบสั่งยา']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?= Html::endForm() ?>
                        <?php endif; ?>

                        <?php Pjax::begin(); ?>
                        <?php if ($action == 'verify-list') : ?>
                            <table id="table" class="default responsive kv-grid-table table table-hover table-striped table-condensed kv-table-wrap" width="100%">
                                <thead>
                                    <tr>
                                        <?= Html::tag('th', Html::encode('#'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('เลขที่ใบสั่งยา'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('HN:VN'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('ชื่อ-นามสกุลผู้ป่วย'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('อายุ'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('แผนก'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('สิทธิการรรักษา'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('สถานะคำสั่ง'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('Action'), ['style' => $style]) ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($model as $v) : ?>
                                        <tr>
                                            <?= Html::tag('td', '', ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['cpoe_num']) ? '-' : $v['cpoe_num'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['HNVN']) ? '-' : $v['HNVN'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['pt_name']) ? '-' : $v['pt_name'], []) ?>

                                            <?= Html::tag('td', empty($v['pt_age_registry_date']) ? '-' : $v['pt_age_registry_date'] . ' ปี', ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['SectionDecs']) ? '-' : $v['SectionDecs'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['pt_right']) ? '-' : $v['pt_right'], []) ?>

                                            <?= Html::tag('td', empty($v['cpoe_status_decs']) ? '-' : $v['cpoe_status_decs'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', Html::a('Issue', ['verify', 'id' => $v['cpoe_id']], ['class' => 'btn btn-xs btn-success', 'data-pjax' => 0]), ['style' => 'text-align: center;']) ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if ($action == 'check-list') : ?>
                            <table id="table" class="default responsive kv-grid-table table table-hover table-striped table-condensed kv-table-wrap" width="100%">
                                <thead>
                                    <tr>
                                        <?= Html::tag('th', Html::encode('#'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('เลขที่ใบสั่งยา'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('HN:VN'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('ชื่อ-นามสกุลผู้ป่วย'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('อายุ'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('สิทธิการรรักษา'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('แผนก'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('สถานะคำสั่ง'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('ตรวจสอบจัดยา'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('จ่ายยา'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('Action'), ['style' => $style]) ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($model as $v) : ?>
                                        <tr>
                                            <?= Html::tag('td', '', ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['cpoe_num']) ? '-' : $v['cpoe_num'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['HNVN']) ? '-' : $v['HNVN'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['pt_name']) ? '-' : $v['pt_name'], []) ?>

                                            <?= Html::tag('td', empty($v['pt_age_registry_date']) ? '-' : $v['pt_age_registry_date'] . ' ปี', ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['pt_right']) ? '-' : $v['pt_right'], []) ?>

                                            <?= Html::tag('td', empty($v['SectionDecs']) ? '-' : $v['SectionDecs'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['cpoe_status_decs']) ? '-' : $v['cpoe_status_decs'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['rxcheck_status']) ? '-' : $v['rxcheck_status'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['rxissue_ststus']) ? '-' : $v['rxissue_ststus'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', Html::a('Check', ['check', 'id' => $v['cpoe_id']], ['class' => 'btn btn-xs btn-success', 'data-pjax' => 0]), ['style' => 'text-align: center;']) ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if ($action == 'issue-list') : ?>
                            <table id="table" class="default responsive kv-grid-table table table-hover table-striped table-condensed kv-table-wrap" width="100%">
                                <thead>
                                    <tr>
                                        <?= Html::tag('th', Html::encode('#'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('เลขที่ใบสั่งยา'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('HN:VN'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('ชื่อ-นามสกุลผู้ป่วย'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('อายุ'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('สิทธิการรรักษา'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('แผนก'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('สถานะคำสั่ง'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('จ่ายยา'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('การเงิน'), ['style' => $style]) ?>

                                        <?= Html::tag('th', Html::encode('Action'), ['style' => $style]) ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($model as $v) : ?>
                                        <tr>
                                            <?= Html::tag('td', '', ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['cpoe_num']) ? '-' : $v['cpoe_num'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['HNVN']) ? '-' : $v['HNVN'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['pt_name']) ? '-' : $v['pt_name'], []) ?>

                                            <?= Html::tag('td', empty($v['pt_age_registry_date']) ? '-' : $v['pt_age_registry_date'] . ' ปี', ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['pt_right']) ? '-' : $v['pt_right'], []) ?>

                                            <?= Html::tag('td', empty($v['SectionDecs']) ? '-' : $v['SectionDecs'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['cpoe_status_decs']) ? '-' : $v['cpoe_status_decs'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['rxissue_ststus']) ? '-' : $v['rxcheck_status'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', empty($v['cpoe_rep_status']) ? '-' : $v['rxissue_ststus'], ['style' => 'text-align: center;']) ?>

                                            <?= Html::tag('td', Html::a('ISSUE', ['issue', 'id' => $v['cpoe_id']], ['class' => 'btn btn-xs btn-success', 'data-pjax' => 0]), ['style' => 'text-align: center;']) ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/vendor/jquery-pos-master/jquery.pos.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php
$script = <<< JS
    $(function () {
        $(document).pos();
        $(document).on('scan.pos.barcode', function (event) {
            var barcode = event.code;
            $('#cpoe_prnum').val(barcode);
            $.post(
                    'check-cpoe',
                    {
                        cpoeid: barcode
                    },
                    function (result)
                    {
                        if (result == false) {
                            swal("ไม่พบข้อมูล!", "", "error");
                        }else{
                            window.location.href = 'check&id=' + barcode;
                        }
                    }
            ).fail(function (xhr, status, error)
            {
                swal("Oops...", error, "error");
                console.log(error);
            });
        });
    }); 
   
   $(document).ready(function() {
    var t = $('#table').DataTable( {
        "dom": '<"pull-left"f><"pull-right"Tl>t<"pull-left"i>p',
        "pageLength": 10,
        "responsive": true,
        "ordering": false,
        "language": {
            "lengthMenu": " _MENU_ ",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            "search": '_INPUT_ ',
        },
        "aLengthMenu": [
            [5, 10, 15, 20, 100, -1],
            [5, 10, 15, 20, 100, "All"]
        ]
    });

    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
   } );
JS;
$this->registerJs($script);
?>