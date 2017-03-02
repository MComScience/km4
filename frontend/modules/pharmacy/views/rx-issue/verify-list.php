<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
//use frontend\assets\DataTableAsset;

//DataTableAsset::register($this);

$this->title = 'ใบสั่งยารอจัดยา';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/rx-issue/verify-list']];
$this->params['breadcrumbs'][] = $this->title;
$style = 'border-top: 1px solid #ddd;';
?>
<style>
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

            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <div class="tb-cpoe-index">
                        <?php Pjax::begin(); ?>    
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

                                        <?= Html::tag('td', Html::a('Verify', ['verify','id' => $v['cpoe_id']], ['class' => 'btn btn-xs btn-success','data-pjax' => 0]), ['style' => 'text-align: center;']) ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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
