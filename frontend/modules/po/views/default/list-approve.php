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

$this->title = 'ใบขอซื้อรอการทวนสอบ';
$this->params['breadcrumbs'][] = ['label' => 'ผู้บริหาร', 'url' => ['list-approve']];
$this->params['breadcrumbs'][] = $this->title;

$headerOptions = ['style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'];
?>
<?= \yii2mod\alert\Alert::widget(); ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="profile-container">
            <?php echo $this->render('@frontend/modules/pr/views/default/dashboard_pharmacy.php', ['title' => 'ผู้บริหาร']); ?>
            <div class="profile-body">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="tabbable">
                        <?php echo $this->render('@frontend/modules/pr/views/default/_tab_admin.php'); ?>
                        <div class="tab-content tabs-flat">

                            <div id="overview" class="tab-pane active">
                                <div class="row profile-overview">
                                    <div class="col-xs-12 col-md-12">
                                        <?php Pjax::begin() ?>
                                        <?php
                                        echo GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'hover' => true,
                                            'pjax' => true,
                                            'striped' => true,
                                            'condensed' => true,
                                            'bordered' => false,
                                            'layout' => "{items}",
                                            'responsive' => false,
                                            'showOnEmpty' => false,
                                            'export' => false,
                                            'replaceTags' => [
                                                '{custom}' => $this->render('_search', ['model' => $searchModel, 'action' => Yii::$app->controller->action->id]),
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
                                                    'header' => 'เลขที่ใบสั่งซื้อ',
                                                    'headerOptions' => $headerOptions,
                                                    'attribute' => 'PONum',
                                                    'contentOptions' => ['class' => 'text-center'],
                                                    'value' => function ($model) {
                                                        return empty($model->PONum) ? '-' : $model->PONum;
                                                    },
                                                ],
                                                    [
                                                    'header' => Icon::show('calendar', [], Icon::BSG) . 'วันที่',
                                                    'headerOptions' => $headerOptions,
                                                    'attribute' => 'PODate',
                                                    'contentOptions' => ['style' => 'text-align:center'],
                                                    'format' => ['date', 'php:d/m/Y'],
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
                                                    'attribute' => 'PODueDate',
                                                    'contentOptions' => ['class' => 'text-center'],
                                                    'format' => ['date', 'php:d/m/Y'],
                                                    'value' => function($model) {
                                                        return empty($model->PODueDate) ? '' : $model->PODueDate;
                                                    }
                                                ],
                                                    [
                                                    'header' => 'สถานะใบสั่งซื้อ',
                                                    'headerOptions' => $headerOptions,
                                                    'attribute' => 'POStatus',
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                        return empty($model->statusDes->POStatusDes) ? '-' : $model->statusDes->POStatusDes;
                                                    }
                                                ],
                                                    [
                                                    'class' => 'kartik\grid\ActionColumn',
                                                    'header' => 'Actions',
                                                    'noWrap' => true,
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'headerOptions' => $headerOptions,
                                                    'template' => '{select}',
                                                    'buttons' => [
                                                        'select' => function ($url, $model) {
                                                            return Html::a(Yii::t('app', 'Select'), $url, [
                                                                        'title' => Yii::t('app', 'Select'),
                                                                        'data-toggle' => 'tooltip',
                                                                        'data-pjax' => 0,
                                                                        'class' => 'btn btn-primary btn-xs',
                                                            ]);
                                                        },
                                                    ],
                                                    'urlCreator' => function ($action, $model, $key, $index) {
                                                        //Update
                                                        if ($action === 'select') {
                                                            return Url::to(['approve-po', 'data' => $key]);
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
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/po/datatables.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>