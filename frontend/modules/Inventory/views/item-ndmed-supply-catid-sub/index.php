<?php

use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\models\TbItemndmedsupplycatidSubSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการหมวดเวชภัณฑ์หลัก';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-itemndmedsupplycatid-sub-index">

    <div class="vwsr2listdraf-index">
        <ul class="nav nav-tabs " id="myTab5">
            <li class="active">
                <a data-toggle="tab" href="#home5">
                    <?= Html::encode($this->title) ?> 
                </a>
            </li>  
        </ul>
        <div class="well">
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
            <?= GridView::widget([
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
      //  'filterModel' => $searchModel,
                'columns' => [
                [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions' => ['class' => 'kartik-sheet-style'],
                'width' => '5%',
                'header' => '<font color="black">#</font>',
                'headerOptions' => ['class' => 'kartik-sheet-style']
                ],
                [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'width' => '5%',
                'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black'],
                                                        'detailAnimationDuration' => 'slow', //fast'expandOneOnly' => true,
                                                        'expandOneOnly' => true,
                                                        'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                                        'detailUrl' => \yii\helpers\Url::to(['ext-pen']), //'index.php?r=Inventory/tb-st2-temp/ext-pen',
                                                        ],
                                                        [
                                                        'attribute' => 'ItemNDMedSupplyCatID_sub_desc',
                                                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                        'width' => '50%',
                                                        'header' => '<font color="black">ชื่อหมวดเวชภัณฑ์หลัก</font>',
                                                        'headerOptions' => ['style' => 'text-align:center'],
                                                        ],
        //  'ItemNDMedSupplyCatID_sub_id',


                                                        [
                                                        'class' => 'kartik\grid\ActionColumn',
                                                        'header' => '<font color="black">Actions</font>',
                                                        //'options' => ['style' => 'width:30px;'],
                                                        'width' => '10%',
                                                        'template' => ' {update} {delete}',
                                                        'buttonOptions' => ['class' => 'btn btn-default'],
                                                        'buttons' => [
                                                        'view' => function ($url, $model, $key) {
                                                            return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', $url, [
                                                                'title' => 'Detail',
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
                                                                'data-toggle' => 'modal',
                                                                'data-id' => $key,
                                                                'class' => 'activity-delete-link',
                                                                ]);
                                                        },
                                                        ],
                                                        ],
                                                        ],
                                                        ]); ?>
                                                        <?php yii\widgets\Pjax::end() ?>
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
                                                            'index.php?r=Inventory/item-ndmed-supply-catid-sub/delete',
                                                            {
                                                                id: fID
                                                            },
                                                            function (data)
                                                            {
                                                                $.pjax.reload({container: '#grid-user-pjax'});
                                                                location.reload();
                                                            }
                                                            );
                                                        }
                                                    });
                                                });
                                            }
                                            init_click_handlers(); //first run
                                            $('#grid-user-pjax').on('pjax:success', function () {
                                                init_click_handlers(); //reactivate links in grid after pjax update
                                            });
JS;
                                            $this->registerJs($script);
                                            ?>


