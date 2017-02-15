<?php

use kartik\grid\GridView;
use yii\bootstrap\Html;
use app\modules\Inventory\models\TbSt2Temp;
$this->title = 'ใบเบิกรอจัดสินค้า';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$("#tab_E").addClass("active");')
?>
<div class="tbsr2-index">
    <div class="vwsr2listdraf-index">
        <?php echo $this->render('_tab_menu'); ?>
        <div class="well">
            <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
            <?php echo $this->render('_search', ['model' => $searchModel, 'type' => 'spicking']); ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'bootstrap' => true,
                'responsiveWrap' => FALSE,
                'responsive' => FALSE,
                'hover' => true,
                'pjax' => true,
                'striped' => true,
                'condensed' => true,
                'toggleData' => false,
                'layout' => Yii::$app->componentdate->layoutgridview(),
                'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'header' => '<a>#</a>',
                        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black']
                    ],
                    [
                        //'header' => '<font color="black">เลขที่ใบขอเบิกสินค้า</font>',
                        'attribute' => 'SRNum',
                        'hAlign' => 'center'
                    ],
                    [
                        //'header' => '<font color="black">วันที่</font>',
                        'attribute' => 'SRDate',
                        'format' => ['date', 'php:d/m/Y'],
                        'hAlign' => 'center'
                    ],
                    [
                        //'header' => '<font color="black">เบิกจากคลัง</font>',
                        'attribute' => 'stk_issue',
                        'hAlign' => 'center',
//                        'value' => function ($model) {
//                            if ($model->viewsr2['stk_issue'] == NULL) {
//                                return '-';
//                            } else {
//                                return $model->viewsr2->stk_issue;
//                            }
//                        }
                    ],
                    [
                        //'header' => '<font color="black">รับเข้าคลัง</font>',
                        'attribute' => 'stk_receive',
                        'hAlign' => 'center',
//                        'value' => function ($model) {
//                            if ($model->viewsr2['stk_receive'] == NULL) {
//                                return '-';
//                            } else {
//                                return $model->viewsr2->stk_receive;
//                            }
//                        }
                    ],
                    [
                        //'header' => '<font color="black">ประเภทการขอเบิก</font>',
                        'attribute' => 'SRType',
                        'hAlign' => 'center',
//                        'value' => function ($model) {
//                            if ($model->viewsr2['SRType'] == NULL) {
//                                return '-';
//                            } else {
//                                return $model->viewsr2->SRType;
//                            }
//                        }
                    ],
                    [
                        //'header' => '<font color="black">สถานะใบขอเบิกสินค้า</font>',
                        'attribute' => 'SRStatusDesc',
                        'hAlign' => 'center',
//                        'value' => function ($model) {
//                            if ($model->viewsr2['SRStatusDesc'] == NULL) {
//                                return '-';
//                            } else {
//                                return $model->viewsr2->SRStatusDesc;
//                            }
//                        }
                    ],
                    [
                        //'header' => '<font color="black">อนุมัติโดย</font>',
                        'attribute' => 'SRCreateBy',
                        'hAlign' => 'center',
                        'value' => function ($model) {
                            if ($model->SRCreateBy == NULL) {
                                return '-';
                            } else {
                                return $model->SRCreateBy;
                            }
                        }
                    ],
//                    [
//                        'header' => '<font color="black">Actions</font>',
//                        'class' => 'kartik\grid\ActionColumn',
//                        'options' => ['style' => 'width:160px;'],
//                        'width' => '200px',
//                        'template' => '<div class="btn-group btn-group-justified text-center" role="group">  {view}{update} {print}</div>',
//                        'dropdown' => false,
//                        'vAlign' => 'middle',
//                        'urlCreator' => function($action, $model, $key, $index) {
//                    if ($action == 'view') {
//                        return Url::to([$action, 'id' => $key]);
//                        $action = 'createheader';
//                    } else if ($action == 'update') {
//                        $action = 'detail';
//                        return Url::to([$action, 'id' => $key]);
//                    } else if ($action == 'print') {
//                     
//                       return '<a href="index.php?r=Report/report-inventory/reportpikinglist&SRID=' . $key . '">print pigkinglist</a>';
//                    }
//                },
//                        'viewOptions' => [
//                            'class' => 'activity-view-link',
//                            'role' => 'modal-remote',
//                            'title' => 'View',
//                            'data-toggle' => 'tooltip',
////                        'data-target' => '#activity-modal',
//                            //'data-id' => $key,
//                            'data-pjax' => '0',
//                            'label' => '<span class="btn btn-success btn-xs">Select</span>',
//                        ],
//                        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'
//                            , 'label' => '
//                <span class="btn btn-info btn-xs">
//                            Detail
//                          </span>',
//                        ],
//                           'printOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'
//                            , 'label' => '
//                <span class="btn btn-info btn-xs">
//                            print
//                          </span>',
//                        ],
//                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => '<a>Actions</a>',
                        'noWrap' => true,
                        'template' => '{view} {update} {print} {check}',
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                $rs = TbSt2Temp::find()->where(['SRNum' => $model->SRNum])->one();
                                if ($rs == null) {
                                //$url = 'index.php?r=Inventory/tb-st2-temp/createheader&id=' . $key;
                                return Html::a('<span class="btn btn-success btn-xs"> Select </span> ', '#', [
                                            'title' => 'Select',
                                            'data-toggle' => 'modal',
                                            'class' => 'activity-view-link',
                                ]);
                                }
                            },
                            'update' => function ($url, $model, $key) {
                                $rs = TbSt2Temp::find()->where(['SRNum' => $model->SRNum])->one();
                                if ($rs == null) {
                                $url = '/km4/Inventory/tb-st2-temp/detail?id=' . $key;
                                return Html::a('<span class="btn btn-info btn-xs"> Detail </span>', $url, [
                                            'title' => 'Detail',
                                ]);
                                }
                            },
                            'print' => function ($url, $model, $key) {
                                $rs = TbSt2Temp::find()->where(['SRNum' => $model->SRNum])->one();
                                if ($rs == null) {
                                return '<div class="btn-group">
                                            <button class="btn btn-info btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                ใบจัดสินค้า
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    '.Html::a('<i class="text-danger fa fa-file-pdf-o"></i> A4', /*['/Report/report-inventory/reportpikinglist', 'SRID' => $model['SRID']]*/'javascript:void(0);', [/*'data-pjax' => 0, 'target' => '_blank'*/'onclick' => 'PrintA4('.$model['SRID'].')'])
                                                .'</li>
                                                <li>
                                                    '.Html::a('<i class="text-muted fa fa-file-text-o"></i> Slip', /*['/Report/report-inventory/slippikinglist', 'SRID' => $model['SRID']]*/'javascript:void(0);', [/*'data-pjax' => 0, 'target' => '_blank'*/'onclick' => 'PrintSlip('.$model['SRID'].')']).'
                                                </li>
                                            </ul>
                                        </div>';
                                    }
                            },

                            'check' => function ($url, $model, $key){
                                $rs = TbSt2Temp::find()->where(['SRNum' => $model->SRNum])->one();
                                if ($rs != null) {
                                return '<span style="color:#53a93f;">กำลังดำเนินการโอน</span><span class="glyphicon glyphicon-hourglass" style="color:#53a93f;"></span>';
                            }
                        }

                                ],
                            ],
                        ],
                    ]);
                    ?>
                    <?php yii\widgets\Pjax::end() ?>
                    <div class="form-group" style="text-align: right">
                        <a href="<?php echo Yii::$app->request->baseUrl; ?>/Inventory/dashboard-v2/cmd-listdrugnew" class="btn btn-default">Close</a>
                    </div>
                </div>
            </div>
            <?php
            $script = <<< JS
                   
function init_click_handlers() {
    $('.activity-view-link').click(function (e) {
    var fID = $(this).closest('tr').data('key');
    var SRNum = $(this).closest('tr').children('td:first').next().text();
         $.ajax({
            url: '/km4/Inventory/tb-st2-temp/check-sr-forst',
            data:{SRNum:SRNum},
            type: 'POST',
            success: function (data) {
                    if(data == 'true'){
                    location.replace("/km4/Inventory/tb-st2-temp/createheader?id="+fID);
                        }else{
                   swal("", "มีรายการที่ถูก ร่างใบโอน แล้ว", "warning");
               }
          }
      });             
    });
}
init_click_handlers(); //first run
$('#grid-user-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
            $this->registerJs($script);
            ?>
<script type="text/javascript">
        function PrintSlip(SRID) {
            //event.preventDefault();
            var myWindow = window.open("/km4/Report/report-inventory/slippikinglist?SRID=" + SRID, "", "top=100,left=200,width=" + (screen.width - '400') + ",height=550,right=auto");
            myWindow.window.print();
        }
        function PrintA4(SRID) {
            //event.preventDefault();
            var myWindow = window.open("/km4/Report/report-inventory/reportpikinglist?SRID=" + SRID, "", "top=100,left=50,width=" + (screen.width - '100') + ",height=550,right=auto");
            myWindow.window.print();
        }
</script>
