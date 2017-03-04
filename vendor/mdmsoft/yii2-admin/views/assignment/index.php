<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = Yii::t('rbac-admin', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;

$columns = [
        [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'header' => '#',
        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;']
    ],
        [
        'header' => 'FullName',
        'attribute' => 'VenderName',
        'headerOptions' => ['style' => 'text-align:center;color:black;'],
        'value' => function ($model) {
            return $model->profile->User_fname . ' ' . $model->profile->User_lname;
        }
    ],
    $usernameField,
];
$columns2 = [
        [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'header' => '#',
        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;']
    ],
        [
        'header' => 'VendorName',
        'attribute' => 'VenderName',
        'headerOptions' => ['style' => 'text-align:center;color:black;'],
        'value' => function ($model) {
            return $model->profile->VenderName;
        }
    ],
    $usernameField,
];
if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
    $columns2 = array_merge($columns2, $extraColumns);
}
$columns[] = [
    'class' => 'kartik\grid\ActionColumn',
    'template' => '{view}',
    'hAlign' => GridView::ALIGN_CENTER,
    'noWrap' => TRUE,
    'buttons' => [
        'view' => function ($url, $model, $key) {
            return Html::a('<span class="btn btn-success btn-xs">กำหนดสิทธิ์</span>', $url, [
                        'title' => 'กำหนดสิทธิ์',
                        'data-pjax' => 0,
            ]);
        },
    ],
];
$columns2[] = [
    'class' => 'kartik\grid\ActionColumn',
    'template' => '{view}',
    'hAlign' => GridView::ALIGN_CENTER,
    'noWrap' => TRUE,
    'buttons' => [
        'view' => function ($url, $model, $key) {
            return Html::a('<span class="btn btn-success btn-xs">กำหนดสิทธิ์</span>', $url, [
                        'title' => 'กำหนดสิทธิ์',
                        'data-pjax' => 0,
            ]);
        },
    ],
];
?>
<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#user">
                        User
                    </a>
                </li>

                <li class="tab-red">
                    <a data-toggle="tab" href="#vendor">
                        Vendor
                    </a>
                </li>

            </ul>

            <div class="tab-content">
                <div id="user" class="tab-pane in active">
                    <?php Pjax::begin(); ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'export' => FALSE,
                        'pjax' => true,
                        'toggleData' => false,
                        'condensed' => true,
                        'headerRowOptions' => ['style' => 'background-color: #DFF0D8'],
                        'panel' => [
                            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> </h3>',
                            'type' => 'default',
                            'before' => FALSE,
                            'after' => FALSE,
                        //'footer' => false
                        ],
                        // 'pjaxSettings' => [
                        //     'neverTimeout' => true,
                        //     'enablePushState' => false,
                        //     'options' => ['id' => 'UsersGrid'],
                        // ],
                        'columns' => $columns,
                    ]);
                    ?>
                    <?php Pjax::end(); ?>
                </div>

                <div id="vendor" class="tab-pane">
                    <?php Pjax::begin(); ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider_vendor,
                        'filterModel' => $searchModel,
                        'export' => FALSE,
                        'pjax' => true,
                        'toggleData' => false,
                        'condensed' => true,
                        'headerRowOptions' => ['style' => 'background-color: #DFF0D8'],
                        'panel' => [
                            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> </h3>',
                            'type' => 'default',
                            'before' => FALSE,
                            'after' => FALSE,
                        //'footer' => false
                        ],
                        'columns' => $columns2,
                    ]);
                    ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>