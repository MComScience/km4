<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
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

$this->title = 'ใบขอซื้อรอการอนุมัติ';
$this->params['breadcrumbs'][] = ['label' => 'ผู้บริหาร', 'url' => ['list-approve']];
$this->params['breadcrumbs'][] = $this->title;

$headerOptions = ['style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'];
?>
<?= \yii2mod\alert\Alert::widget(); ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="profile-container">
            <?php echo $this->render('dashboard_pharmacy', ['title' => 'ผู้บริหาร']); ?>
            <div class="profile-body">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="tabbable">
                        <?php echo $this->render('_tab_admin', ['action' => Yii::$app->controller->action->id]); ?>
                        <div class="tab-content tabs-flat">

                            <div id="overview" class="tab-pane active">
                                <div class="row profile-overview">
                                    <div class="col-xs-12 col-md-12">
                                        <?php Pjax::begin() ?>
                                        <?=
                                        GridView::widget([
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
                                            'tableOptions' => ['class' => GridView::TYPE_DEFAULT, 'style' => 'width:100%'],
                                            'replaceTags' => [
                                                '{custom}' => $this->render('@frontend/modules/pr/views/gpu/_search.php', ['model' => $searchModel, 'action' => Yii::$app->controller->action->id]),
                                            ],
                                            'toolbar' => [
                                                /* ['content' =>
                                                  Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['list-approve'], ['class' => 'btn btn-default','data-pjax' => 0])
                                                  ], */
                                                '{toggleData}',
                                            ],
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
                                                    'class' => 'kartik\grid\ActionColumn',
                                                    'header' => 'Actions',
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'headerOptions' => $headerOptions,
                                                    'template' => '{select}',
                                                    'buttons' => [
                                                        //view button
                                                        'select' => function ($url, $model) {
                                                            return Html::a(Icon::show('hand-up', [], Icon::BSG) . Yii::t('app', 'Select'), $url, [
                                                                        'title' => Yii::t('app', 'Select'),
                                                                        'data-pjax' => 0,
                                                                        'data-toggle' => 'tooltip',
                                                                        'class' => 'btn btn-success btn-sm',
                                                            ]);
                                                        },
                                                    ],
                                                    'urlCreator' => function ($action, $model, $key, $index) {
                                                        if ($model->PRTypeID == 1) {//ยาสามัญ
                                                            if ($action === 'select') {
                                                                return Url::to(['/pr/gpu/approve-pr', 'data' => $key]);
                                                            }
                                                        } elseif ($model->PRTypeID == 2) {//ยาการค้า
                                                            if ($action === 'select') {
                                                                return Url::to(['/pr/tpu/approve-pr', 'data' => $key]);
                                                            }
                                                        } elseif ($model->PRTypeID == 3) {//เวชภัณฑ์
                                                            if ($action === 'select') {
                                                                return Url::to(['/pr/nd/approve-pr', 'data' => $key]);
                                                            }
                                                        } elseif ($model->PRTypeID == 4) {
                                                            if ($action === 'select') {
                                                                return Url::to(['/pr/tpu-cont/approve-pr', 'data' => $key]);
                                                            }
                                                        } elseif ($model->PRTypeID == 5) {
                                                            if ($action === 'select') {
                                                                return Url::to(['/pr/nd-cont/approve-pr', 'data' => $key]);
                                                            }
                                                        }
                                                    }
                                                ],
                                            ],
                                        ]);
                                        ?>
                                        <?php Pjax::end() ?>
                                    </div>
                                    <div class="col-xs-12 col-md-12" style="text-align: right;">
                                        <?= Html::a('Close', ['/'], ['class' => 'btn btn-default']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->render('@frontend/modules/pr/views/gpu/script.php'); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/datatables.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>