<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

$this->title = 'บันทึกแผนการจัดชื้อยาสามัญ';
$this->params['breadcrumbs'][] = $this->title;
$layout = <<< HTML
<div class="pull-right"></div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
?>
<?php $this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#Purchasing1").addClass("active open");
    $("#pcplanbydrug").addClass("active");
    '); ?>
<ul class="nav nav-tabs " id="myTab5">
    <li class="active">
        <a data-toggle="tab" href="#home5">
            <?= Html::encode($this->title) ?>
        </a>
    </li>  
</ul>
<div class="tab-content">
    <div id="home5" class="tab-pane in active">
        <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
        <?php echo Yii::$app->finddata->alertsave() ?>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'bootstrap' => true,
            'responsiveWrap' => FALSE,
            'responsive' => true,
            'hover' => true,
            'pjax' => true,
            'striped' => false,
            'condensed' => true,
            'toggleData' => true,
            'layout' => $layout,
            'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
            'columns' => [
                [
                    'class' => 'kartik\grid\SerialColumn',
                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                    'width' => '36px',
                    'header' => '<font color="black">#</font>',
                    'headerOptions' => ['class' => 'kartik-sheet-style']
                ],
//                        [
//                            'class' => 'kartik\grid\ExpandRowColumn',
//                            'width' => '50px',
//                            'value' => function ($model, $key, $index, $column) {
//                                return GridView::ROW_COLLAPSED;
//                            },
//                            'detailRowCssClass' => GridView::TYPE_DEFAULT,
//                            'detailUrl' => 'km4/backend/web/index.php?r=Purchasing/tbpcplan/test',
//                            'headerOptions' => ['class' => 'kartik-sheet-style'],
//                            'expandOneOnly' => true
//                        ],
                [
                    'header' => '<font color="black">เลขที่แผนจัดชื้อ </font>',
                    'attribute' => 'PCPlanNum',
                    'hAlign' => 'center',
                    'options' => ['class' => 'text-right'],
                ],
                [
                    'header' => '<font color="black">วันที่</font>',
                    'attribute' => 'PCPlanDate',
                    'format' => ['date', 'php:d/m/Y'],
                    'hAlign' => 'center',
                ],
                [
                    'header' => '<font color="black">ฝ่าย</font>',
                    'attribute' => 'DepartmentID',
                    'value' => 'department.DepartmentDesc',
//                            'width' => '20px',
                    'hAlign' => 'center'],
                [
                    'header' => '<font color="black">แผนก</font>',
                    'attribute' => 'SectionID',
                    'value' => 'section.SectionDecs',
                    'hAlign' => 'center',
                ],
                [
                    'header' => '<font color="black">ประเภทแผนจัดชื้อ</font>',
                    'attribute' => 'PCPlanTypeID',
                    'value' => 'pcplantype.PCPlanType',
//                            'width' => '10px',
                    'hAlign' => 'center',
                ],
                [
                    'header' => '<font color="black">วันที่เริ่มแผน</font>',
                    'attribute' => 'PCPlanBeginDate',
                    'format' => ['date', 'php:d/m/Y'],
//                            'width' => '10px',
                    'hAlign' => 'center'
                ],
                [
                    'header' => '<font color="black">วันที่สิ้นสุดแผน</font>',
                    'attribute' => 'PCPlanEndDate',
                    'format' => ['date', 'php:d/m/Y'],
//                            'width' => '10px',
                    'hAlign' => 'center'
                ],
                [
                    'header' => '<font color="black">สถานะ</font>',
                    'attribute' => 'PCPlanStatusID',
                    'value' => 'pcplanstatus.PCPlanStatus',
                    'hAlign' => 'center'
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'header' => '<font color="black">Actions</font>',
                    'options' => ['style' => 'width:160px;'],
                    'width' => '200px',
                    'template' => '{view} {update} {delete} {print}',
                    'buttonOptions' => ['class' => 'btn btn-default'],
                    'buttons' => [
                        'print' => function ($url, $model, $key) {
                            $url = 'index.php?r=Report/report-purchasing/pcplangenerics&PCPlanNum=' . $key;
                            return Html::a('<span class="btn btn-info btn-xs"> print </span>', $url, [
                                        'title' => 'print',
                                        'data-pjax' => 0,
                                        'target' => '_blank'
                            ]);
                        },
                                'view' => function ($url, $model, $key) {
                            return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', $url, [
                                        'title' => 'Edit',
                            ]);
                        },
                                'update' => function ($url, $model, $key) {
                            return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', $url, [
                                        'title' => 'Edit',
                            ]);
                        },
                                'delete' => function ($url, $model, $key) {
                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                        'title' => 'Delete',
                                        'data-id' => $key,
                                        'class' => 'activity-delete-link',
                            ]);
                        },
                            ],
                        ],
                    ],
                ]);
                ?>
                <?php yii\widgets\Pjax::end() ?>
                <div style="text-align: right">
                    <a href="index.php?r=Purchasing/dashboard/index" class="btn btn-default">Close</a>  
                </div>

            </div>
        </div>
        <?php
        $script = <<< JS
function init_click_handlers() {
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
  swal({
    title: message_confirmdelete,
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) { 
                $.post(
                        'index.php?r=Purchasing/tbpcplan/delete',
                        {
                            id: fID
                        },
                function (data)
                {
                    $.pjax.reload({container: '#grid-user-pjax'});
                }
             );
            }
        }
      );
    });
}
init_click_handlers(); //first run
$('#grid-user-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
        $this->registerJs($script);
        ?>
