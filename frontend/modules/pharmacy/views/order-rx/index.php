<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use frontend\assets\DataTableAsset;

DataTableAsset::register($this);

$this->title = 'รายชื่อผู้ป่วยนอก';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/order-rx/index']];
$this->params['breadcrumbs'][] = ['label' => 'สั่งจ่ายยาผู้ป่วยนอก', 'url' => ['/pharmacy/order-rx/index']];
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
            <?php echo $this->render('_tab_menu_index'); ?>

            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="tb-cpoe-index">

                        <?php Pjax::begin(); ?>
                        <table id="table" class="default responsive kv-grid-table table table-hover table-striped table-condensed kv-table-wrap" width="100%">
                            <thead>
                                <tr>
                                    <?= Html::tag('th', Html::encode('#'), ['style' => $style]) ?>

                                    <?= Html::tag('th', Html::encode('HNVN'), ['style' => $style]) ?>

                                    <?= Html::tag('th', Html::encode('ชื่อ-นามสกุลผู้ป่วย'), ['style' => $style]) ?>

                                    <?= Html::tag('th', Html::encode('สิทธิการรักษา'), ['style' => $style]) ?>

                                    <?= Html::tag('th', Html::encode('Action'), ['style' => $style]) ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($query as $v) : ?>
                                    <tr>
                                        <?= Html::tag('td', '', ['style' => 'text-align: center;']) ?>

                                        <?= Html::tag('td', empty($v['HNVN']) ? '-' : $v['HNVN'], ['style' => 'text-align: center;']) ?>

                                        <?= Html::tag('td', empty($v['pt_name']) ? '-' : $v['pt_name'], []) ?>

                                        <?= Html::tag('td', empty($v['pt_right']) ? '-' : $v['pt_right'], []) ?>

                                        <?php
                                        $Button = Html::a('<span class="btn btn-success btn-xs"> Rx Order </span>', Url::to(['/pharmacy/order-rx/create', 'data' => $v['pt_visit_number'], 'type' => '1011']), [
                                                    'title' => 'Rx Order',
                                                    'data-pjax' => 0,
                                                ])
                                                . ' ' .
                                                Html::a('<span class="btn btn-purple btn-xs">Chemo Rx Order </span>', Url::to(['/pharmacy/order-rx/create', 'data' => $v['pt_visit_number'], 'type' => '1012']), [
                                                    'title' => 'Chemo Rx Order',
                                                    'data-pjax' => 0,
                                        ]);
                                        ?>
                                        <?= Html::tag('td', $Button, ['style' => 'text-align: center;']) ?>
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

<?php
$script = <<< JS
   $(document).ready(function() {
    var t = $('#table').DataTable( {
        "dom": '<"pull-left"f><"pull-right"Tl>t<"pull-left"i>p',
        "pageLength": 10,
        "responsive": true,
        //"ordering": false,
        "language": {
            "lengthMenu": " _MENU_ ",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            "search": 'ค้นหา : _INPUT_ ',
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