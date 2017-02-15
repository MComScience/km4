<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'อนุมัติการปรับปรุงสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'ผู้บริหาร', 'url' => ['detail-verify']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
        $('#tab_I').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="profile-container">
            <?php echo $this->render('@frontend/modules/pr/views/default/dashboard_pharmacy.php', ['title' => 'ผู้บริหาร']); ?>
            <div class="profile-body">
                <div class="col-lg-12">
                    <div class="tabbable">
                        <?php echo $this->render('@frontend/modules/pr/views/default/_tab_admin.php'); ?>
                        <div class="tab-content tabs-flat">

                            <div id="overview" class="tab-pane active">
                                <div class="row profile-overview">
                                    <div class="col-xs-12 col-md-12">
                                        <?php Pjax::begin([ 'timeout' => 5000]) ?>
                                        <?php echo $this->render('search_detail', ['model' => $searchModel]); ?>
                                        <p></p>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'bootstrap' => true,
                                            'responsiveWrap' => FALSE,
                                            'responsive' => true,
                                            'hover' => true,
                                            'pjax' => true,
                                            'striped' => false,
                                            'condensed' => true,
                                            'toggleData' => true,
                                            'layout' => Yii::$app->componentdate->layoutgridview2(),
                                            'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                                            'columns' => [
                                                [
                                                    'class' => 'kartik\grid\SerialColumn',
                                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                    'width' => '36px',
                                                    'header' => '<font color="black">#</font>',
                                                    'headerOptions' => ['class' => 'kartik-sheet-style']
                                                ],
//                        [
//                            'class' => 'kartik\grid\ExpandRowColumn',
//                            'width' => '50px',
//                            'value' => function ($model, $key, $index, $column) {
//                                return GridView::ROW_COLLAPSED;
//                            },
//                            'detailRowCssClass' => GridView::TYPE_DEFAULT,
//                            'detailUrl' => 'km4/backend/web/index.php?r=Purchasing/tbpcplan/test',
//                            'headerOptions' => ['class' => 'kartik-sheet-style'],
//                            'expandOneOnly' => true
//                        ],
                                                [
                                                    'header' => '<font color="black">เลขที่แผนจัดชื้อ</font>',
                                                    'attribute' => 'PCPlanNum',
                                                    'hAlign' => 'center',
                                                    'options' => ['class' => 'text-right'],
                                                ],
                                                [
                                                    'header' => '<font color="black">วันที่</font>',
                                                    'attribute' => 'PCPlanDate',
                                                    'format' => ['date', 'php:d/m/Y'],
                                                    'hAlign' => 'center',
                                                ],
                                                [
                                                    'header' => '<font color="black">ฝ่าย</font>',
                                                    'attribute' => 'DepartmentID',
                                                    'value' => 'department.DepartmentDesc',
//                            'width' => '20px',
                                                    'hAlign' => 'center'],
                                                [
                                                    'header' => '<font color="black">แผนก</font>',
                                                    'attribute' => 'SectionID',
                                                    'value' => 'section.SectionDecs',
                                                    'hAlign' => 'center',
                                                ],
                                                [
                                                    'header' => '<font color="black">ประเภทแผนจัดชื้อ</font>',
                                                    'attribute' => 'PCPlanTypeID',
                                                    'value' => 'pcplantype.PCPlanType',
//                            'width' => '10px',
                                                    'hAlign' => 'center',
                                                ],
                                                [
                                                    'header' => '<font color="black">วันที่เริ่มแผน</font>',
                                                    'attribute' => 'PCPlanBeginDate',
                                                    'format' => ['date', 'php:d/m/Y'],
//                            'width' => '10px',
                                                    'hAlign' => 'center'
                                                ],
                                                [
                                                    'header' => '<font color="black">วันที่สิ้นสุดแผน</font>',
                                                    'attribute' => 'PCPlanEndDate',
                                                    'format' => ['date', 'php:d/m/Y'],
//                            'width' => '10px',
                                                    'hAlign' => 'center'
                                                ],
                                                [
                                                    'header' => '<font color="black">สถานะ</font>',
                                                    'attribute' => 'PCPlanStatusID',
                                                    'value' => 'pcplanstatus.PCPlanStatus',
                                                    'hAlign' => 'center'
                                                ],
                                                [
                                                    'class' => 'kartik\grid\ActionColumn',
                                                    'header' => '<font color="black">Actions</font>',
                                                    //  'header' => '<a>Actions</a>',
                                                    'options' => ['style' => 'width:160px;'],
                                                    'width' => '200px',
                                                    'template' => '{primacyaprove}',
                                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                                    'buttons' => [
                                                        'primacyaprove' => function ($url, $model, $key) {
                                                            if ($model->PCPlanTypeID == '1' || $model->PCPlanTypeID == '2') {
                                                                $url = 'index.php?r=Purchasing/tbpcplan/primacyaprove&id=' . $key.'&type='.Yii::$app->componentdate->aes128Encrypt($key,'manager');
                                                            } else if ($model->PCPlanTypeID == '3' || $model->PCPlanTypeID == '4') {
                                                                $url = 'index.php?r=Purchasing/tbplan/primacyaprove&id=' . $key.'&type='.Yii::$app->componentdate->aes128Encrypt($key,'manager');
                                                            } else
                                                            if ($model->PCPlanTypeID == '7' || $model->PCPlanTypeID == '8') {
                                                                $url = 'index.php?r=Purchasing/tbplandrug/primacyaprove&id=' . $key.'&type='.Yii::$app->componentdate->aes128Encrypt($key,'manager');
                                                            } else if ($model->PCPlanTypeID == '5') {
                                                                $url = 'index.php?r=Purchasing/tbplandrugsale/primacyaprove&id=' . $key.'&type='.Yii::$app->componentdate->aes128Encrypt($key,'manager');
                                                            } else if ($model->PCPlanTypeID == '6') {
                                                                $url = 'index.php?r=Purchasing/tbplansale/primacyaprove&id=' . $key.'&type='.Yii::$app->componentdate->aes128Encrypt($key,'manager');
                                                            }

                                                            return Html::a('<span class="btn btn-success btn-xs">Select</span>', $url, [
                                                                        'title' => 'Select',
                                                            ]);
                                                        },
                                                            ],
                                                        ],
                                                    ],
                                                ]);
                                                ?>
                                                <?php Pjax::end() ?>
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

        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
            echo \kartik\widgets\Growl::widget([
                'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
                'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                'showSeparator' => true,
                'delay' => 1, //This delay is how long before the message shows
                'pluginOptions' => [
                    'delay' => (!empty($message['duration'])) ? $message['duration'] : 2000, //This delay is how long the message shows for
                    'placement' => [
                        'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                        'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                    ]
                ]
            ]);
            ?>
        <?php endforeach; ?>

