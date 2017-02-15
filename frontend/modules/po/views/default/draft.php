<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\icons\Icon;
use frontend\assets\DataTableAsset;
use common\themes\beyond\assets\DeleteButtonAsset;

DeleteButtonAsset::register($this);
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

$this->title = 'ร่างใบสั่งซื้อ';
$this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'สั่งซื้อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$headerOptions = ['style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'];
?>

<?= yii2mod\alert\Alert::widget() ?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">

            <?php echo $this->render('_tab_menu', ['model' => $searchModel]); ?>

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
                                    'template' => '{update} {delete}',
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            return Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), $url, [
                                                        'title' => Yii::t('app', 'Edit'),
                                                        'data-toggle' => 'tooltip',
                                                        'data-pjax' => 0,
                                                        'class' => 'btn btn-primary btn-xs',
                                            ]);
                                        },
                                        'delete' => function ($url, $model) {
                                            return Html::a(Icon::show('trash-o') . Yii::t('app', 'Delete'), $url, [
                                                        'title' => Yii::t('app', 'Delete'),
                                                        'class' => 'btn btn-danger btn-xs delete-button',
                                                        'data-confirm' => Yii::t('app', 'Are you sure delete item?'),
                                                        'data-method' => 'post',
                                                        'data-pjax' => '0',
                                                        'data-toggle' => 'tooltip',
                                            ]);
                                        },
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        //Update
                                        if ($action === 'update') {
                                            return Url::to(['update', 'data' => $key]);
                                        }
                                        if ($action === 'delete') {
                                            return Url::to(['delete', 'id' => $key]);
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
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/po/datatables.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>