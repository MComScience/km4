<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\models\TbItemndmedsupplySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการหมวดเวชภัณฑ์ย่อย';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-itemndmedsupply-index">

    <div class="vwsr2listdraf-index">
        <ul class="nav nav-tabs " id="myTab5">
            <li class="active">
                <a data-toggle="tab" href="#home5">
                    <?= Html::encode($this->title) ?> 
                </a>
            </li>  
        </ul>
        <div class="well">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
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
              'filterModel' => $searchModel,
              'columns' => [
           [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions' => ['class' => 'kartik-sheet-style'],
                'width' => '36px',
                'header' => '<font color="black">#</font>',
                'headerOptions' => ['class' => 'kartik-sheet-style']
                ],
                     [
                                        'header' => '<font color="black">รหัสหมวดเวชภัณฑ์ย่อย</font>',
                                        'attribute' => 'ItemNDMedSupplyCatID',
                                        'hAlign' => GridView::ALIGN_LEFT,
                                         'filter' => false,
                                        'value' => function ($model) {
                                    if ($model->ItemNDMedSupplyCatID == NULL) {
                                        return '-';
                                    } else {
                                        return $model->ItemNDMedSupplyCatID;
                                    }
                                }
                                    ],
                                      [
                                        'header' => '<font color="black">ชื่อหมวดเวชภัณฑ์ย่อย</font>',
                                        'attribute' => 'ItemNDMedSupply',
                                        'hAlign' => GridView::ALIGN_LEFT,
                                         'filter' => false,
                                        'value' => function ($model) {
                                    if ($model->ItemNDMedSupply == NULL) {
                                        return '-';
                                    } else {
                                        return $model->ItemNDMedSupply;
                                    }
                                }
                                    ],
                                         [
                                        'header' => '<font color="black">ชื่อหมวดเวชภัณฑ์หลัก</font>',
                                        'attribute' => 'ItemNDMedSupplyCatID_sub',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                         'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\app\modules\Inventory\models\TbItemndmedsupplycatidSub::find()->all(), 'ItemNDMedSupplyCatID_sub_id', 'ItemNDMedSupplyCatID_sub_desc'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'เลือกหมวดหลัก'],
                                        'value' => function ($model) {
                                    if ($model->ItemNDMedSupplyCatID_sub == NULL) {
                                        return '-';
                                    } else {
                                        return $model->supilesub->ItemNDMedSupplyCatID_sub_desc;
                                    }
                                }
                                    ],
            //  'ItemNDMedSupplyCatID',
           //   'ItemNDMedSupply',
           //   'supilesub.ItemNDMedSupplyCatID_sub_desc',
              [
              'class' => 'kartik\grid\ActionColumn',
              'header' => '<font color="black">Actions</font>',
             // 'options' => ['style' => 'width:150px;'],
              'width' => '20%',
              'template' => ' {view} {update} {delete}',
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
                    'index.php?r=Inventory/itemndmedsupply/delete',
                    {
                        id: fID
                    },
                    function (data)
                    {
                        $.pjax.reload({container: '#grid-user-pjax'});
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
