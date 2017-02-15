<?php

use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = 'สถานะสินค้าคงคลัง';
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//$countdetail = app\modules\Inventory\models\TbPrSelectedDetail::find()->count();

$script = <<< JS
$(document).ready(function () {
        $('#tab_A').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <?php echo $this->render('_tab_menu'); ?>
            <div class="tab-content">
                <div id="tab" class="tab-pane in active">
                    <div class="stock-index">
                        <?php Pjax::begin([ 'timeout' => 5000, 'id' => 'detailgpu']) ?>
                        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $searchModel,
                            'responsive' => true,
                            'hover' => true,
                            'pjax' => true,
                            'striped' => true,
                            'condensed' => true,
                            'pjaxSettings' => [
                                'neverTimeout' => true,
                                'loadingCssClass' => true,
                            ],
                            //'headerRowOptions' => ['style' => 'align:center'],
                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
//                'rowOptions' => function($model) {
//            if ($model->ItemCatID == '1') {
//                return ['class' => 'success'];
//            } 
//        },
                            //'panel'=>['type'=>'primary', 'heading'=>'Grid Grouping Example'],
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'width' => '36px',
                                    'header' => '#',
                                    'headerOptions' => ['class' => 'kartik-sheet-style']
                                ],
                                [
                                    'class' => 'kartik\grid\ExpandRowColumn',
                                    'value' => function ($model, $key, $index, $column) {
                                        return GridView::ROW_COLLAPSED;
                                    },
                                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                                    'expandOneOnly' => true,
                                    'expandIcon' => '<span class="glyphicon glyphicon-expand">',
                                    'detailAnimationDuration' => 'slow', //fast
                                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                    'detailUrl' => \yii\helpers\Url::to(['gpu-plan-detail']),
//                        'detail' => function ($model, $key, $column) {
//                    //$searchModel = new app\modules\Inventory\models\GpuplanDetailAvalibleSearch();
//                    $searchModel = new app\modules\Inventory\models\TbPcplangpudetailSearch();
//                    $searchModel->TMTID_GPU = $model->TMTID_GPU;
//                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//                    //GPU
//                    return Yii::$app->controller->renderPartial('_gpuplandetail', [
//                                'searchModel' => $searchModel,
//                                'dataProvider' => $dataProvider,
//                                'model' => $model
//                    ]);
//                },
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;'],
                                    'attribute' => 'ItemID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'ItemCat',
                                    'header' => '<a>ประเภทสินค้า</a>',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => 'dataonviewbalance.ItemCat',
                                ],
//                    [
//                        'attribute' => 'ItemCat',
//                        'vAlign' => 'middle',
//                        'width' => '180px',
//                        'hAlign' => GridView::ALIGN_CENTER,
//                        'filterType' => GridView::FILTER_SELECT2,
//                        'filter' => ArrayHelper::map(app\models\TbItemcatid::find()->orderBy('ItemCat')->asArray()->all(), 'ItemCat', 'ItemCat'),
//                        'filterWidgetOptions' => [
//                            'pluginOptions' => ['allowClear' => true],
//                        ],
//                        'filterInputOptions' => ['placeholder' => 'ประเภทสินค้า'],
//                        'format' => 'raw'
//                    ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'ItemName',
                                    'header' => '<a>ชื่อสินค้า</a>',
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'ItemReorderLevel',
                                    'header' => '<a>จุดสั่งซื้อ</a>',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'Stkbalance',
                                    'header' => '<a>คงคลัง</a>',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => 'dataonviewbalance.Stkbalance',
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'DispUnit',
                                    'header' => '<a>หน่วย</a>',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => 'dataonviewbalance.DispUnit',
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'ItemOnPR',
                                    'header' => '<a>กำลังขอซื้อ</a>',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => 'dataonviewbalance.ItemOnPR',
                                ],
                                [
                                    'attribute' => 'ItemOnPO',
                                    'header' => '<a>กำลังสั่งซื้อ</a>',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => 'dataonviewbalance.ItemOnPO',
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'PODueDate',
                                    'header' => '<a>กำหนดรับสินค้า</a>',
                                    //'format' => ['date', 'php:d/m/Y'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => 'dataonviewbalance.PODueDate',
                                ],
//                    [ // แสดงข้อมูลออกเป็น icon
//                        'label' => '',
//                        'attribute' => 'icon',
//                        'format' => 'html',
//                        'hAlign' => GridView::ALIGN_CENTER,
//                        'value' => function($model, $key, $index, $column) {
//                            if ($model['ItemCatID'] == 1) {
//                                return "<i class='fa fa-medkit'></i>";
//                            } else {
//                                return "<i class='fa fa-stethoscope'></i>";
//                            }
//                        }
//                    ],
                                [
                                    'attribute' => 'Check',
                                    'header' => 'มี/ไม่มี<br>ในแผน',
                                    'format' => 'html',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function($model, $key, $index, $column) {
                                        $checkgpu = \app\modules\Inventory\models\VwGpuplanDetailAvalible::findAll(['TMTID_GPU' => $model['TMTID_GPU']]);
                                        $checktpu = \app\modules\Inventory\models\VwTpuplanDetailAvalible::findAll(['TMTID_TPU' => $model->TMTID_TPU, 'ItemID' => $model->ItemID]);
                                        $checknd = \app\modules\Inventory\models\VwNdplanDetailAvalible::findAll(['ItemID' => $model->ItemID]);
                                        if ($checkgpu != NULL or $checktpu != NULL or $checknd != NULL) {
                                            return '<span class="glyphicon glyphicon-ok text-success"></span>';
                                        } else {
                                            return '<span class="glyphicon glyphicon-remove text-danger"></span>';
                                        }
                                    }
                                        ],
                                    ],
                                ]);
                                ?>
                                <?php Pjax::end() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>
    </div>
</div>

