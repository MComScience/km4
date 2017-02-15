<?php
date_default_timezone_set('Asia/Bangkok');
?>

<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#tbplandrugsale").addClass("active open");
    $("#sale").addClass("active");
    ');
$this->title = 'บันทึกสัญญาจะชื้อจะขายเวชภัณฑ์';
$this->params['breadcrumbs'][] = $this->title;
?>
<ul class="nav nav-tabs " id="myTab5">
    <li class="active">
        <a data-toggle="tab" href="#home5">
            <?= Html::encode($this->title) ?>
        </a>
    </li>  
</ul>
<div class="tab-content">
    <div id="home5" class="tab-pane in active">
        <?php Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
        <?php echo Yii::$app->finddata->alertsave() ?>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'bootstrap' => true,
            'responsiveWrap' => FALSE,
            'responsive' => true,
            'hover' => true,
            'pjax' => true,
            'striped' => false,
            'condensed' => true,
            'toggleData' => true,
            'layout' => Yii::$app->componentdate->layoutgridview(),
            'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
            'columns' => [
                [
                    'header' => '<font color="black">#</font>',
                    'class' => 'yii\grid\SerialColumn'],
                [
                    'header' => '<font color="black">เลขที่แผนจัดชื้อ</font>',
                    'hAlign' => 'center',
                    'attribute' => 'PCPlanNum',
                ],
                //  'PCPlanDate',
                [
                    'header' => '<font color="black">วันที่</font>',
                    'hAlign' => 'center',
                    'attribute' => 'PCPlanDate',
                    'format' => ['date', 'php:d/m/Y'],
                    'value' => $searchModel->PCPlanDate
                ],
                [
                    'header' => '<font color="black">ฝ่าย</font>',
                    'hAlign' => 'center',
                    'attribute' => 'DepartmentID',
                    'value' => 'department.DepartmentDesc'],
                [
                    'header' => '<font color="black">แผนก</font>',
                    'hAlign' => 'center',
                    'attribute' => 'SectionID',
                    'value' => 'section.SectionDecs'],
                [
                    'header' => '<font color="black">ประเภทแผนจัดชื้อ</font>',
                    'hAlign' => 'center',
                    'attribute' => 'PCPlanTypeID',
                    'value' => 'pcplantype.PCPlanType'],
                [
                    'header' => '<font color="black">วันที่เริ่มแผน</font>',
                    'hAlign' => 'center',
                    'attribute' => 'PCPlanBeginDate',
                    'format' => ['date', 'php:d/m/Y'],
                    'value' => $searchModel->PCPlanBeginDate
                ],
                [
                    'header' => '<font color="black">วันที่สิ้นสุดแผน</font>',
                    'hAlign' => 'center',
                    'attribute' => 'PCPlanEndDate',
                    'format' => ['date', 'php:d/m/Y'],
                    'value' => $searchModel->PCPlanEndDate
                ],
                [
                    'header' => '<font color="black">สถานะ</font>',
                    'hAlign' => 'center',
                    'attribute' => 'PCPlanStatusID',
                    'value' => 'pcplanstatus.PCPlanStatus'],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'header' => '<font color="black">Actions</font>',
                    'options' => ['style' => 'width:160px;'],
                    'width' => '200px',
                    'template' => '{view} {update} {delete} {print}',
                    'buttonOptions' => ['class' => 'btn btn-default'],
                    'buttons' => [
                          'print' => function ($url, $model, $key) {
                           $url = 'index.php?r=Report/report-purchasing/plan-gpu&PCPlanNum=' . $key;
                            return Html::a('<span class="btn btn-info btn-xs"> print </span>', $url, [
                                        'title' => 'print',
                                        'data-pjax' => 0,
                                        'target'=>'_blank'
                                            //'class' => 'btn btn-primary btn-xs',
                            ]);
                        },
                        'view' => function ($url, $model, $key) {
                            return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', $url, [
                                        'title' => 'Edit',
                                            //'class' => 'btn btn-primary btn-xs',
                            ]);
                        },
                                'update' => function ($url, $model, $key) {
                            
                                return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', $url, [
                                            'title' => 'Edit',
                                                //'class' => 'btn btn-primary btn-xs',
                                ]);
                            
                        },
                                'delete' => function ($url, $model, $key) {
                          
                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                            //  'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'title' => 'Delete',
                                            'data-toggle' => 'modal',
                                            //'data-method' => "post",
                                            //'role' => 'modal-remote',
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
                        'index.php?r=Purchasing/tbplansale/delete',
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