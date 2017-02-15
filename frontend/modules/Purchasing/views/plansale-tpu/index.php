<?php

use yii\helpers\Html;
use kartik\grid\GridView;

//use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TbPcplanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'บันทึกสัญญาจะชื้อจะขายยา';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->registerJs('
    
    $("#Purchasing").addClass("active open");
    $("#tbplandrugsale").addClass("active open");
    $("#drugsale").addClass("active");
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
        <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
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
                    'hAlign' => 'center',
                    'attribute' => 'SectionID',
                    'value' => 'section.SectionDecs'
                ],
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
                ],
                [
                    'header' => '<font color="black">วันที่สิ้นสุดแผน</font>',
                    'hAlign' => 'center',
                    'attribute' => 'PCPlanEndDate',
                    'format' => ['date', 'php:d/m/Y'],
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
                            return Html::a('<span class="btn btn-info btn-xs"> print </span>', yii\helpers\Url::to(['/Report/report-purchasing/plan-gpu', 'PCPlanNum' => $key]), [
                                        'title' => 'print',
                                        'data-pjax' => 0,
                                        'target' => '_blank'
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
                            if (($model['PCPlanStatusID'] == 5) && (Yii::$app->user->can('ApprovedPlan'))) {
                                return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', $url, [
                                            'title' => 'Edit',
                                                //'class' => 'btn btn-primary btn-xs',
                                ]);
                            } else if (($model['PCPlanStatusID'] == 5) && (!Yii::$app->user->can('ApprovedPlan'))) {
                                return Html::button('Edit', [
                                            'title' => 'Edit',
                                            'class' => 'btn btn-info btn-xs',
                                            'disabled' => true,
                                ]);
                            } else {
                                return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', $url, [
                                            'title' => 'Edit',
                                                //'class' => 'btn btn-primary btn-xs',
                                ]);
                            }
                        },
                        'delete' => function ($url, $model, $key) {
                            if (($model['PCPlanStatusID'] == 5) && (Yii::$app->user->can('ApprovedPlan'))) {
                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                            //  'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'title' => 'Delete',
                                            'data-toggle' => 'modal',
                                            //'data-method' => "post",
                                            //'role' => 'modal-remote',
                                            'data-id' => $key,
                                            'class' => 'activity-delete-link',
                                ]);
                            } else if (($model['PCPlanStatusID'] == 5) && (!Yii::$app->user->can('ApprovedPlan'))) {
                                return Html::button('Delete', [
                                            'title' => 'Delete',
                                            'class' => 'btn btn-danger btn-xs',
                                            'disabled' => true,
                                ]);
                            } else {
                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                            //  'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'title' => 'Delete',
                                            'data-toggle' => 'modal',
                                            //'data-method' => "post",
                                            //'role' => 'modal-remote',
                                            'data-id' => $key,
                                            'class' => 'activity-delete-link',
                                ]);
                            }
                        },
                    ],
                ],
            ],
        ]);
        ?>
        <?php yii\widgets\Pjax::end() ?>
        <div style="text-align: right">
            <a href="/km4/Purchasing/dashboard/index" class="btn btn-default">Close</a>  
        </div>
    </div>
</div>
<?php
$script = <<< JS
function init_click_handlers() {
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
     
       swal({
            title: "ยืนยันการลบ!",
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
                        'delete',
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
