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
        $('#tab_H').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="profile-container">
            <?php echo $this->render('@frontend/modules/Purchasing/views/dashboard/_hd_pharmacy.php'); ?>
            <div class="profile-body">
                <div class="col-lg-12">
                    <div class="tabbable">
                        <?php  echo $this->render('@frontend/modules/Purchasing/views/dashboard/_tab_pharmacy.php'); ?>
                        <div class="tab-content tabs-flat">

                            <div id="overview" class="tab-pane active">
                                <div class="row profile-overview">
                                    <div class="col-xs-12 col-md-12">
                                        <?php Pjax::begin([ 'timeout' => 5000]) ?>
                                         <?php echo Yii::$app->finddata->alertsave() ?>
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
                                                    'header' => '<a>#</a>',
                                                    'class' => 'yii\grid\SerialColumn'],
                                                [
                                                    //'header' => '<font color="black">เลขที่ใบขอเบิกสินค้า</font>',
                                                    'attribute' => 'SRNum',
                                                    'hAlign' => 'center'
                                                ],
                                                [
                                                    //'header' => '<font color="black">วันที่</font>',
                                                    'attribute' => 'SRDate',
                                                    'hAlign' => 'center',
                                                    'format' => ['date', 'php:d/m/Y'],
                                                ],
                                                [
                                                     //'header' => '<font color="black">เบิกจากคลัง</font>',
                                                    'attribute' => 'SRIssue_stkID',
                                                    'hAlign' => 'center',
                                                    'value' => function ($model) {
                                                        if ($model->viewsr2['stk_issue'] == NULL) {
                                                            return '-';
                                                        } else {
                                                            return $model->viewsr2->stk_issue;
                                                        }
                                                    }
                                                ],
                                                [
                                                    //'header' => '<font color="black">รับเข้าคลัง</font>',
                                                    'attribute' => 'SRReceive_stkID',
                                                    'hAlign' => 'center',
                                                    'value' => function ($model) {
                                                        if ($model->viewsr2['stk_receive'] == NULL) {
                                                            return '-';
                                                        } else {
                                                            return $model->viewsr2->stk_receive;
                                                        }
                                                    }
                                                ],
                                                [
                                                    //'header' => '<font color="black">ประเภทการขอเบิก</font>',
                                                    'attribute' => 'SRTypeID',
                                                    'hAlign' => 'center',
                                                    'value' => function ($model) {
                                                        if ($model->viewsr2['SRType'] == NULL) {
                                                            return '-';
                                                        } else {
                                                            return $model->viewsr2->SRType;
                                                        }
                                                    }
                                                ],
                                                //   'SRIssue_stkID',
                                                // 'SRReceive_stkID',
                                                // 'DepartmentID',
                                                //'SectionID',
                                                //'SRTypeID',
                                                // 'SRExpectDate',
                                                [
                                                    //'header' => '<font color="black">สถานะใบขอเบิก</font>',
                                                    'attribute' => 'SRStatus',
                                                    'hAlign' => 'center',
                                                    'value' => function ($model) {
                                                        if ($model->viewsr2['SRStatusDesc'] == NULL) {
                                                            return '-';
                                                        } else {
                                                            return $model->viewsr2->SRStatusDesc;
                                                        }
                                                    }
                                                ],
                                                // 'SRStatus',
                                                // 'SRCreateBy',
                                                // 'SRCreateDate',
                                                // 'SRApproveBy',
                                                // 'SRApproveDate',
                                                // 'SRRejectApproveBy',
                                                // 'SRRejectApproveDate',
                                                // 'SRNote',
                                                [
                                                    'class' => 'kartik\grid\ActionColumn',
                                                    'header' => '<a>Actions</a>',
                                                    'options' => ['style' => 'width:160px;'],
                                                    'width' => '200px',
                                                    'template' => '<div class="btn-group btn-group-justified text-center" role="group">  {update}</div>',
                                                    'dropdown' => false,
                                                    'vAlign' => 'middle',
                                                    'urlCreator' => function($action, $model, $key, $index) {
                                                return Url::to(["updatepha", 'id' => $key]);
                                            },
                                                    'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'
                                                        , 'label' => '
                <span class="btn btn-success btn-xs">
                            Select
                           
                          </span>',
                                                    ]
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


