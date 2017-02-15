<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$layout = <<< HTML
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

$script = <<< JS
$(document).ready(function () {
        $('#tab_B').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <?php echo $this->render('_tab_menu'); ?>
            <div class="tab-content">
                <div id="tab" class="tab-pane in active ">
                    <div class="tb-po2-temp-index">
                        <?php Pjax::begin([ 'timeout' => 5000]) ?>
                       <?php echo $this->render('_search', ['model' => $searchModel,'action' => 'detail-draft']); ?>
                        <p></p>
                        <?php // Html::a(Yii::t('app', 'Create Tb Po2 Temp'), ['create'], ['class' => 'btn btn-success']) ?>
                        
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $searchModel,
                            'bootstrap' => true,
                            'responsiveWrap' => FALSE,
                            'responsive' => true,
                            'hover' => true,
                            'pjax' => true,
                            'striped' => false,
                            'condensed' => true,
                            'toggleData' => false,
                            'layout' => $layout,
                            'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'width' => '36px',
                                    'header' => '#',
                                    'headerOptions' => ['class' => 'kartik-sheet-style','style' => 'color:black;']
                                ],
                                [
                                    'header' => 'เลขที่ใบสั่งซื้อ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'PONum',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->PONum == null) {
                                    return '-';
                                } else {
                                    return $model->PONum;
                                }
                            }
                                ],
                                [
                                    'header' => 'วันที่',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'PODate',
                                    'format' => ['date', 'php:d/m/Y'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => 'ประเภทการสั่งซื้อ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'POTypeID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->POTypeID == null) {
                                    return '-';
                                } else {
                                    return $model->potype->POType;
                                }
                            }
                                ],
                                [
                                    'header' => 'กำหนดการส่งมอบ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'PODueDate',
                                    //'format' => ['date', 'php:d-m-Y'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->PODueDate == null) {
                                    return '-';
                                } else {
                                    return Yii::$app->componentdate->convertMysqlToThaiDate2($model->PODueDate);
                                }
                            }
                                ],
                                [
                                    'header' => 'สถานะใบสั่งซื้อ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'POStatus',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->POStatus == null) {
                                    return '-';
                                } else {
                                    return $model->postatus->POStatusDes;
                                }
                            }
                                ],
                                [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'template' => '{update}',
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            return Html::a('<span class="btn btn-primary btn-xs"> Select </span>', $url, [
                                                        'title' => 'Select',
                                                        'data-pjax' => 0,
                                            ]);
                                        },
                                            ],
                                            'urlCreator' => function ($action, $model, $key, $index) {
                                        //Update
                                        //if ($model->PRTypeID == 1 || $model->PRTypeID == 5 || $model->PRTypeID == 8) {//ยาสามัญ
                                        if ($action === 'update') {
                                            return Url::to(['create', 'prid' => '', 'prnum' => $model['PRNum']]);
                                        }
                                        // }
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

