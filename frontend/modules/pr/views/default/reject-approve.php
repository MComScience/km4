<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\icons\Icon;
use frontend\assets\DataTableAsset;

DataTableAsset::register($this);

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

$this->title = 'ใบขอซื้อไม่ผ่านการอนุมัติ';
$this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'ขอซื้อรายการบัญชี รพ.', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$headerOptions = ['style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'];
?>
<?= \yii2mod\alert\Alert::widget() ?>

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
                <?php Pjax::begin(); ?>    
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'hover' => true,
                    'pjax' => true,
                    'striped' => true,
                    'condensed' => true,
                    'bordered' => false,
                    'export' => false,
                    'layout' => "{items}",
                    'responsive' => false,
                    'showOnEmpty' => false,
                    'emptyCell' => '-',
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
                            'headerOptions' => $headerOptions,
                        ],
                        [
                            'header' => 'เลขที่ใบขอซื้อ',
                            'headerOptions' => $headerOptions,
                            'attribute' => 'PRNum',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return empty($model->PRNum) ? '-' : $model->PRNum;
                            },
                        ],
                        [
                            'header' => Icon::show('calendar', [], Icon::BSG) . 'วันที่',
                            'headerOptions' => $headerOptions,
                            'attribute' => 'PRDate',
                            'hAlign' => GridView::ALIGN_CENTER,
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
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function($model) {
                                return empty($model->PRExpectDate) ? '-' : 'ภายใน ' . $model->PRExpectDate . ' วัน';
                            }
                        ],
                        [
                            'class' => '\kartik\grid\ActionColumn',
                            'header' => 'Actions',
                            'headerOptions' => $headerOptions,
                            'contentOptions' => ['style' => 'text-align:center;'],
                            'template' => '{detail}',
                            'noWrap' => true,
                            'buttons' => [
                                'detail' => function ($url, $model) {
                                    return Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), $url, [
                                                'title' => Yii::t('app', 'Detail'),
                                                'data-toggle' => 'tooltip',
                                                'data-pjax' => 0,
                                                'class' => 'btn btn-success btn-sm',
                                    ]);
                                },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($model->PRTypeID == 1) {//ยาสามัญ
                                    if ($action === 'detail') {
                                        return Url::to(['/pr/gpu/approve-pr', 'data' => $key]);
                                    }
                                } elseif ($model->PRTypeID == 2) {//ยาการค้า
                                    if ($action === 'detail') {
                                        return Url::to(['/pr/tpu/approve-pr', 'data' => $key]);
                                    }
                                } elseif ($model->PRTypeID == 3) {//เวชภัณฑ์
                                    if ($action === 'detail') {
                                        return Url::to(['/pr/nd/approve-pr', 'data' => $key]);
                                    }
                                } elseif ($model->PRTypeID == 4) {
                                    if ($action === 'detail') {
                                        return Url::to(['/pr/tpu-cont/approve-pr', 'data' => $key]);
                                    }
                                } elseif ($model->PRTypeID == 5) {
                                    if ($action === 'detail') {
                                        return Url::to(['/pr/nd-cont/approve-pr', 'data' => $key]);
                                    }
                                }
                            }
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
            </div><!--Widget Body-->
        </div><!--Widget-->
    </div>
</div>
<?php echo $this->render('@frontend/modules/pr/views/gpu/script.php'); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/datatables.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>