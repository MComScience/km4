<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\icons\Icon;
use common\themes\beyond\assets\DeleteButtonAsset;

DeleteButtonAsset::register($this);

$layout = <<< HTML
<div class="pull-right">{toolbar}</div>
{custom}
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;


$this->title = 'ร่างใบขอซื้อ';
$this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'ขอซื้อรายการบัญชี รพ.', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$headerOptions = ['style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'];
?>
<?php $this->registerCssFile(Yii::getAlias('@web') . '/css/bootstrap-dropdownhover.min.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]); ?>
<?= yii2mod\alert\Alert::widget() ?>
<?php /*
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">

            <?php echo $this->render('_tab_menu'); ?>

            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="tb-pr2-temp-index">
                        <?php Pjax::begin(); ?>    
                        <?php
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'hover' => true,
                            'pjax' => true,
                            'striped' => true,
                            'condensed' => true,
                            'bordered' => false,
                            //'responsive' => false,
                            //'showOnEmpty'=>false,
                            'emptyCell' => '-',
                            'export' => false,
                            'layout' => $layout,
                            'replaceTags' => [
                                '{custom}' => $this->render('@frontend/modules/pr/views/gpu/_search.php', ['model' => $searchModel, 'action' => Yii::$app->controller->action->id]),
                            ],
                            'toolbar' => [
                                '{toggleData}',
                            ],
                            'tableOptions' => ['class' => GridView::TYPE_DEFAULT, 'style' => 'width:100%'],
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style', 'style' => 'text-align:center;'],
                                    'width' => '36px',
                                    'header' => '#',
                                    'headerOptions' => $headerOptions
                                ],
                                [
                                    'header' => 'เลขที่ใบขอซื้อ',
                                    'headerOptions' => $headerOptions,
                                    'attribute' => 'PRNum',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return empty($model->PRNum) ? '-' : $model->PRNum;
                                    },
                                ],
                                [
                                    'header' => Icon::show('calendar', [], Icon::BSG) . 'วันที่',
                                    'headerOptions' => $headerOptions,
                                    'attribute' => 'PRDate',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'format' => ['date', 'php:d/m/Y'],
                                ],
                                [
                                    'header' => 'ประเภทใบขอซื้อ',
                                    'headerOptions' => $headerOptions,
                                    'attribute' => 'PRTypeID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        return empty($model->prtype->PRType) ? '-' : $model->prtype->PRType;
                                    }
                                ],
                                [
                                    'header' => 'ประเภทการสั่งซื้อ',
                                    'headerOptions' => $headerOptions,
                                    'attribute' => 'POTypeID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        return empty($model->potype->POType) ? '-' : $model->potype->POType;
                                    }
                                ],
                                [
                                    'header' => 'กำหนดเวลาการส่งมอบ',
                                    'headerOptions' => $headerOptions,
                                    'attribute' => 'PRExpectDate',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function($model) {
                                        return empty($model->PRExpectDate) ? '-' : 'ภายใน ' . $model->PRExpectDate . ' วัน';
                                    }
                                ],
                                [
                                    'class' => '\kartik\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'headerOptions' => $headerOptions,
                                    'contentOptions' => ['style' => 'text-align:center;'],
                                    'template' => '{view} {update} {delete}',
                                    'noWrap' => true,
                                    'buttons' => [
                                        //view button
                                        'view' => function ($url, $model) {
                                            if (!empty($model->PRNum)) {
                                                return Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), $url, [
                                                            'title' => Yii::t('app', 'Detail'),
                                                            'data-toggle' => 'tooltip',
                                                            'data-pjax' => 0,
                                                            'class' => 'btn btn-success btn-sm',
                                                ]);
                                            }
                                        },
                                        'update' => function ($url, $model) {
                                            if ($model->PRStatusID == 1 && !empty($model->PRNum)) {
                                                return Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), $url, [
                                                            'title' => Yii::t('app', 'Edit'),
                                                            'data-toggle' => 'tooltip',
                                                            'data-pjax' => 0,
                                                            'class' => 'btn btn-primary btn-sm',
                                                ]);
                                            }
                                        },
                                        'delete' => function ($key, $model) {
                                            if (!empty($model->PRNum)) {
                                                return Html::a(Icon::show('trash-o') . Yii::t('app', 'Delete'), Url::to(['delete', 'id' => $model['PRID']]), [
                                                            'title' => Yii::t('app', 'Delete'),
                                                            'class' => 'btn btn-danger btn-sm delete-button',
                                                            'data-confirm' => Yii::t('app', 'Are you sure delete item?'),
                                                            'data-method' => 'post',
                                                            'data-pjax' => '0',
                                                            'data-toggle' => 'tooltip',
                                                ]);
                                            } else {
                                                return '<span class="success">กำลังทำรายการ</span>';
                                            }
                                        },
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {

                                        if ($model->PRTypeID == 1) {//ยาสามัญ
                                            if ($action === 'view') {//View
                                                return Url::to(['/pr/gpu/view', 'id' => $key]);
                                            }
                                            if ($action === 'update') {
                                                return Url::to(['/pr/gpu/update', 'id' => $key]);
                                            }
                                        } elseif ($model->PRTypeID == 2) {//ยาการค้า
                                            if ($action === 'view') {//View
                                                return Url::to(['/pr/tpu/view', 'id' => $key]);
                                            }
                                            if ($action === 'update') {
                                                return Url::to(['/pr/tpu/update', 'id' => $key]);
                                            }
                                        } elseif ($model->PRTypeID == 3) {//เวชภัณฑ์
                                            if ($action === 'view') {//View
                                                return Url::to(['/pr/nd/view', 'id' => $key]);
                                            }
                                            if ($action === 'update') {
                                                return Url::to(['/pr/nd/update', 'id' => $key]);
                                            }
                                        } elseif ($model->PRTypeID == 4) {
                                            if ($action === 'view') {//View
                                                return Url::to(['/pr/tpu-cont/view', 'id' => $key]);
                                            }
                                            if ($action === 'update') {
                                                return Url::to(['/pr/tpu-cont/update', 'id' => $key]);
                                            }
                                        } elseif ($model->PRTypeID == 5) {//เวชภัณฑ์ จะซื้อจะขาย
                                            if ($action === 'view') {//View
                                                return Url::to(['/pr/nd-cont/view', 'id' => $key]);
                                            }
                                            if ($action === 'update') {
                                                return Url::to(['/pr/nd-cont/update', 'id' => $key]);
                                            }
                                        }
                                    }
                                ],
                            ],
                        ]);
                        ?>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>
    </div>
</div>
 * 
 */?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget radius-bordered">
            <div class="widget-header bordered-bottom bordered-success">
                <span class="widget-caption">
                    <?php echo $this->render('_tab_menu'); ?>
                </span>
                <div class="widget-buttons">
                    <a href="#" data-toggle="maximize">
                        <i class="fa fa-expand pink"></i>
                    </a>
                    <a href="#" data-toggle="collapse">
                        <i class="fa fa-minus blue"></i>
                    </a>
                </div><!--Widget Buttons-->
            </div><!--Widget Header-->
            <div class="widget-body">
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'hover' => true,
                    'pjax' => true,
                    'striped' => true,
                    'condensed' => true,
                    'bordered' => false,
                    //'responsive' => false,
                    //'showOnEmpty'=>false,
                    'emptyCell' => '-',
                    'export' => false,
                    'layout' => $layout,
                    'replaceTags' => [
                        '{custom}' => $this->render('@frontend/modules/pr/views/gpu/_search.php', ['model' => $searchModel, 'action' => Yii::$app->controller->action->id]),
                    ],
                    'toolbar' => [
                        '{toggleData}',
                    ],
                    'tableOptions' => ['class' => GridView::TYPE_DEFAULT, 'style' => 'width:100%'],
                    'columns' => [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'contentOptions' => ['class' => 'kartik-sheet-style', 'style' => 'text-align:center;'],
                            'width' => '36px',
                            'header' => '#',
                            'headerOptions' => $headerOptions
                        ],
                        [
                            'header' => 'เลขที่ใบขอซื้อ',
                            'headerOptions' => $headerOptions,
                            'attribute' => 'PRNum',
                            'contentOptions' => ['class' => 'text-center'],
                            'value' => function ($model) {
                                return empty($model->PRNum) ? '-' : $model->PRNum;
                            },
                        ],
                        [
                            'header' => Icon::show('calendar', [], Icon::BSG) . 'วันที่',
                            'headerOptions' => $headerOptions,
                            'attribute' => 'PRDate',
                            'contentOptions' => ['class' => 'text-center'],
                            'format' => ['date', 'php:d/m/Y'],
                        ],
                        [
                            'header' => 'ประเภทใบขอซื้อ',
                            'headerOptions' => $headerOptions,
                            'attribute' => 'PRTypeID',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return empty($model->prtype->PRType) ? '-' : $model->prtype->PRType;
                            }
                        ],
                        [
                            'header' => 'ประเภทการสั่งซื้อ',
                            'headerOptions' => $headerOptions,
                            'attribute' => 'POTypeID',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return empty($model->potype->POType) ? '-' : $model->potype->POType;
                            }
                        ],
                        [
                            'header' => 'กำหนดเวลาการส่งมอบ',
                            'headerOptions' => $headerOptions,
                            'attribute' => 'PRExpectDate',
                            'contentOptions' => ['class' => 'text-center'],
                            'value' => function($model) {
                                return empty($model->PRExpectDate) ? '-' : 'ภายใน ' . $model->PRExpectDate . ' วัน';
                            }
                        ],
                        [
                            'class' => '\kartik\grid\ActionColumn',
                            'header' => 'Actions',
                            'headerOptions' => $headerOptions,
                            'contentOptions' => ['style' => 'text-align:center;'],
                            'template' => '{view} {update} {delete}',
                            'noWrap' => true,
                            'buttons' => [
                                //view button
                                
                                'view' => function ($url, $model) {
                                    if (!empty($model->PRNum)) {
                                        return Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), $url, [
                                                    'title' => Yii::t('app', 'Detail'),
                                                    'data-toggle' => 'tooltip',
                                                    'data-pjax' => 0,
                                                    'class' => 'btn btn-success btn-sm',
                                        ]);
                                    }
                                },
                                'update' => function ($url, $model) {
                                    if ($model->PRStatusID == 1 && !empty($model->PRNum)) {
                                        return Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), $url, [
                                                    'title' => Yii::t('app', 'Edit'),
                                                    'data-toggle' => 'tooltip',
                                                    'data-pjax' => 0,
                                                    'class' => 'btn btn-primary btn-sm',
                                        ]);
                                    }
                                },
                                'delete' => function ($key, $model) {
                                    if (!empty($model->PRNum)) {
                                        return Html::a(Icon::show('trash-o') . Yii::t('app', 'Delete'), Url::to(['delete', 'id' => $model['PRID']]), [
                                                    'title' => Yii::t('app', 'Delete'),
                                                    'class' => 'btn btn-danger btn-sm delete-button',
                                                    'data-confirm' => Yii::t('app', 'Are you sure delete item?'),
                                                    'data-method' => 'post',
                                                    'data-pjax' => '0',
                                                    'data-toggle' => 'tooltip',
                                        ]);
                                    } else {
                                        return '<span class="success">กำลังทำรายการ</span>';
                                    }
                                },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {

                                if ($model->PRTypeID == 1) {//ยาสามัญ
                                    if ($action === 'view') {//View
                                        return Url::to(['/pr/gpu/view', 'id' => $key]);
                                    }
                                    if ($action === 'update') {
                                        return Url::to(['/pr/gpu/update', 'id' => $key]);
                                    }
                                } elseif ($model->PRTypeID == 2) {//ยาการค้า
                                    if ($action === 'view') {//View
                                        return Url::to(['/pr/tpu/view', 'id' => $key]);
                                    }
                                    if ($action === 'update') {
                                        return Url::to(['/pr/tpu/update', 'id' => $key]);
                                    }
                                } elseif ($model->PRTypeID == 3) {//เวชภัณฑ์
                                    if ($action === 'view') {//View
                                        return Url::to(['/pr/nd/view', 'id' => $key]);
                                    }
                                    if ($action === 'update') {
                                        return Url::to(['/pr/nd/update', 'id' => $key]);
                                    }
                                } elseif ($model->PRTypeID == 4) {
                                    if ($action === 'view') {//View
                                        return Url::to(['/pr/tpu-cont/view', 'id' => $key]);
                                    }
                                    if ($action === 'update') {
                                        return Url::to(['/pr/tpu-cont/update', 'id' => $key]);
                                    }
                                } elseif ($model->PRTypeID == 5) {//เวชภัณฑ์ จะซื้อจะขาย
                                    if ($action === 'view') {//View
                                        return Url::to(['/pr/nd-cont/view', 'id' => $key]);
                                    }
                                    if ($action === 'update') {
                                        return Url::to(['/pr/nd-cont/update', 'id' => $key]);
                                    }
                                }
                            }
                        ],
                    ],
                ]);
                ?>
            </div><!--Widget Body-->
        </div><!--Widget-->
    </div>
</div>
<?php echo $this->render('@frontend/modules/pr/views/gpu/script.php'); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/bootstrap-dropdownhover.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>