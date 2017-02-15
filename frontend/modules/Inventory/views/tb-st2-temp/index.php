<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\SweetAlertAsset;
use frontend\assets\DataTableAsset;

WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
SweetAlertAsset::register($this);
DataTableAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\models\SearchTbSt2Temp */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ร่างใบโอนสินค้า';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$("#tab_F").addClass("active");')
?>
<div class="tb-st2-temp-index">
    <div class="vwsr2listdraf-index">
        <?php echo $this->render('_tab_menu'); ?>
        <div class="well">
            <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
            <?php echo Yii::$app->finddata->alertsave() ?>
            <?php echo $this->render('_search', ['model' => $searchModel, 'type' => 'index']); ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'bootstrap' => true,
                'responsiveWrap' => FALSE,
                'responsive' => true,
                'hover' => true,
                'pjax' => true,
                'striped' => true,
                'condensed' => true,
                'toggleData' => false,
                'layout' => Yii::$app->componentdate->layoutgridview(),
                'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                'columns' => [
                        [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'header' => '<a>#</a>',
                        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black']

                    ],
                        [
                        //'header' => '<font color="black">เลขที่ใบโอน</font>',
                        'attribute' => 'STNum',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            if ($model->STNum == NULL) {
                                return $model->SRNum;
                            } else {
                                return $model->STNum;
                            }
                        }
                    ],
                        [
                        //'header' => '<font color="black">เลขที่ใบเบิก</font>',
                        'attribute' => 'SRNum',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            if ($model->SRNum == NULL) {
                                return '';
                            } else {
                                return $model->SRNum;
                            }
                        }
                    ],
                        [
                        //'header' => '<font color="black">วันที่</font>',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'STDate',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            if ($model->vwstlistdraf['STDate'] == NULL) {
                                return '-';
                            } else {
                                return $model->vwstlistdraf->STDate;
                            }
                        }
                    ],
                        [
                        //'header' => '<font color="black">ขอเบิกจาก</font>',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'STIssue_StkID',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            if ($model->vwstlistdraf['Stk_issue'] == NULL) {
                                return $model->stk->StkName; //'-';
                            } else {
                                return $model->vwstlistdraf->Stk_issue;
                            }
                        }
                    ],
                        [
                        //'header' => '<font color="black">รับเข้า</font>',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'STRecieve_StkID',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            if ($model->vwstlistdraf['Stk_receive'] == NULL) {
                                return $model->stkrecieve->StkName; //'-';
                            } else {
                                return $model->vwstlistdraf->Stk_receive;
                            }
                        }
                    ],
                    /*
                      [
                      'header' => '<font color="black">ประเภทการขอเบิก</font>',
                      'headerOptions' => ['style' => 'text-align:center'],
                      'attribute' => 'STTypeID',
                      'hAlign' => GridView::ALIGN_CENTER,
                      'value' => function ($model) {
                      if ($model->vwstlistdraf['STTypeDesc'] == NULL) {
                      return '-';
                      } else {
                      return $model->vwstlistdraf->STTypeDesc;
                      }
                      }
                      ],
                     * 
                     */
                        [
                        //'header' => '<font color="black">สถานะใบโอน</font>',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'STStatus',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            if ($model->vwstlistdraf['STStatusDesc'] == NULL) {
                                return '-';
                            } else {
                                return $model->vwstlistdraf->STStatusDesc;
                            }
                        }
                    ],
                        [
                        //'header' => '<font color="black">ผู้โอน</font>',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'STCreateBy',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            if ($model->vwstlistdraf['STCreateBy'] == NULL) {
                                return '-';
                            } else {
                                return $model->vwstlistdraf->STCreateBy;
                            }
                        }
                    ],
                        [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => '<a>Actions</a>',
                        'noWrap' => true,
                        'template' => '{update} {delete}',
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'buttons' => [
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
            <div class="form-group" style="text-align: right">
                <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Inventory/dashboard/index" class="btn btn-default">Close</a>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
                   
function init_click_handlers() {
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
     swal({
          title: 'ยืนยันการลบ?',
            text: "",
            type: "error",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) { 
     
                $.post(
                        '/km4/Inventory/tb-st2-temp/delete',
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
