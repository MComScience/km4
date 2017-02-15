<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'อนุมัติการปรับปรุงสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'หัวหน้าเภสัชกรรม', 'url' => ['detail-verify']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
        $('#tab_G').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="profile-container">
            <?php echo $this->render('@frontend/modules/pr/views/default/dashboard_pharmacy.php',['title' => 'หัวหน้าเภสัชกรรม']); ?>
            <div class="profile-body">
                <div class="col-lg-12">
                    <div class="tabbable">
                        <?php echo $this->render('@frontend/modules/pr/views/default/_tab_pharmacy.php'); ?>
                        <div class="tab-content tabs-flat">

                            <div id="overview" class="tab-pane active">
                                <div class="row profile-overview">
                                    <div class="col-xs-12 col-md-12">
                                        <?php Pjax::begin(['id' => 'phama', 'timeout' => 5000]) ?>
                                        <?php echo Yii::$app->finddata->alertsave() ?>
                                        <?php echo $this->render('search_detail', ['model' => $searchModel, 'action' => 'wait-approve-prarmacy']); ?>
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
                                                [
                                                    'header' => '<font color="black">เอกสารเลขที่</font>',
                                                    'attribute' => 'SANum',
                                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                ],
                                                [
                                                    'header' => '<font color="black">วันที่</font>',
                                                    'attribute' => 'SADate',
                                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                ],
                                                [
                                                    'header' => '<font color="black">คลังสินค้า</font>',
                                                    'attribute' => 'StkName',
                                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                ],
                                                [
                                                    'header' => '<font color="black">ประเภทการปรับปรุงยอด</font>',
                                                    'attribute' => 'SAType',
                                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                ],
                                                [
                                                    'header' => '<font color="black">สถานะปรับปรุงยอด</font>',
                                                    'attribute' => 'SAStatusDesc',
                                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                ],
                                                [
                                                    'class' => 'kartik\grid\ActionColumn',
                                                    'header' => '<font color="black">Actions</font>',
                                                    //  'header' => '<a>Actions</a>',
                                                    'options' => ['style' => 'width:160px;'],
                                                    'width' => '200px',
                                                    'template' => '{update}',
                                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                                    'buttons' => [
                                                        'view' => function ($url, $model, $key) {
                                                            return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', $url . '&appvo=2', [
                                                                        'title' => 'Edit',
                                                            ]);
                                                        },
                                                        'update' => function ($url, $model, $key) {
                                                            return Html::a('<span class="btn btn-success btn-xs">Select</span>', $url . '&appvo=2', [
                                                                        'title' => 'Edit',
                                                            ]);
                                                        },
                                                        'delete' => function ($url, $model, $key) {
                                                            return Html::a('<span class="btn btn-danger btn-xs">Delete</span> ', '#', [
                                                                        'title' => 'Delete',
                                                                        'data-toggle' => 'modal',
                                                                        'data-id' => $key,
                                                                        'class' => 'activity-delete-link',
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

