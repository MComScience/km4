<?php
date_default_timezone_set('Asia/Bangkok');
?>

<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
$this->title = 'บันทึกแผนการสั่งซื้อสินค้าเวชภัณฑ์มิใช่ยา';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#Purchasing1").addClass("active open");
    $("#addnondrugms").addClass("active");
    ');
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
        <?php
        echo
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
                    'attribute' => 'PCPlanNum',
                    'hAlign' => 'center',
                    'options' => ['class' => 'text-right'],
                ],
                [
                    'header' => '<font color="black">วันที่</font>',
                    'attribute' => 'PCPlanDate',
                    'hAlign' => 'center',
                    'format' => ['date', 'php:d/m/Y'],
                ],
                [
                    'header' => '<font color="black">ฝ่าย</font>',
                    'attribute' => 'DepartmentID',
                    'hAlign' => 'center',
                    'value' => 'department.DepartmentDesc'],
                [
                    'header' => '<font color="black">แผนก</font>',
                    'attribute' => 'SectionID',
                    'hAlign' => 'center',
                    'value' => 'section.SectionDecs'],
                [
                    'header' => '<font color="black">ประเภทแผนจัดชื้อ</font>',
                    'attribute' => 'PCPlanTypeID',
                    'hAlign' => 'center',
                    'value' => 'pcplantype.PCPlanType'],
                [
                    'header' => '<font color="black">วันที่เริ่มแผน</font>',
                    'attribute' => 'PCPlanBeginDate',
                    'hAlign' => 'center',
                    'format' => ['date', 'php:d/m/Y'],
                ],
                [
                    'header' => '<font color="black">วันที่สิ้นสุดแผน</font>',
                    'attribute' => 'PCPlanEndDate',
                    'hAlign' => 'center',
                    'format' => ['date', 'php:d/m/Y'],
                ],
                [
                    'header' => '<font color="black">สถานะ</font>',
                    'attribute' => 'PCPlanStatusID',
                    'hAlign' => 'center',
                    'value' => 'pcplanstatus.PCPlanStatus'
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
                            $url = 'index.php?r=Report/report-purchasing/pcplannondrug&PCPlanNum=' . $key;
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
                        'index.php?r=Purchasing/tbplan/delete',
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

