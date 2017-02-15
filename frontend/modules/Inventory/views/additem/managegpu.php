<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'ข้อมูลยาสามัญ';
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['managegpu']];
$this->params['breadcrumbs'][] = ['label' => 'จัดการข้อมูลยา', 'url' => ['managegpu']];
$this->params['breadcrumbs'][] = $this->title;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
?>

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode('จัดการข้อมูลยาสามัญ') ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <div class="tb-manage-index">
                        <?php Pjax::begin(['id' => 'tb_manage_pjax']); ?>    
                        <?php echo $this->render('_search_managegpu', ['model' => $searchModel]); ?>
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
                            'layout' => $layout,
                            'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'width' => '36px',
                                    'header' => '#',
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;']
                                ],
                                [
                                    'header' => 'รหัสยาสามัญ',
                                    'attribute' => 'TMTID_GPU',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => 'รายละเอียดยา',
                                    'attribute' => 'FSN_GPU',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                ],
                                [
                                    'class' => 'kartik\grid\ActionColumn',
                                    ///'options' => ['style' => 'width:180px;'],
                                    'noWrap' => true,
                                    'header' => 'Actions',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'template' => '{edit}',
                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                    'buttons' => [

                                        /* Edit */
                                        'edit' => function ($url, $model) {
                                            return Html::a('<span class="btn btn-info btn-xs btn-group"> Edit </span>', $url, [
                                                        'title' => Yii::t('app', 'Edit'),
                                                        'data-pjax' => 0,
                                            ]);
                                        },
                                            ],
                                            'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'edit') {
                                            return Url::to(['create', 'gpu' => $key, 'itemid' => '','edit' => 'no']);
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