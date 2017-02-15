<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use frontend\assets\SweetAlertAsset;

SweetAlertAsset::register($this);

$this->title = 'ปรับปรุงยอดสินค้าคงคลัง';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('$("#tab_B").addClass("active");');

?>
<div class="vw-sa-list-index">
    <div class="vwsr2listdraf-index">
        <?php echo $this->render('_tab_menu'); ?>
        <div class="well">
            <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
            <?php echo $this->render('_search', ['model' => $searchModel,'action'=>'wait-approve']); ?>   
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
                 'layout' => Yii::$app->componentdate->layoutgridview(),
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
                        'options' => ['style' => 'width:160px;'],
                        'width' => '200px',
                        'template' => ' {view} {delete}',
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', $url . '&appvo=2', [
                                            'title' => 'Edit',
                                ]);
                            },
                                    'update' => function ($url, $model, $key) {
                                return Html::a('<span class="btn btn-info btn-xs">Edit</span>', $url . '&appvo=2', [
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
                    <?php yii\widgets\Pjax::end() ?>
                    <div class="form-group" style="text-align: right">
                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/Inventory/dashboard-v2/cmd-listdrugnew" class="btn btn-default">Close</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $script = <<< JS
function init_click_handlers() {
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
     
     swal({
             title: "ยืนยันการลบ",
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) { 
                $.post(
                        'delete',
                        {
                            id: fID
                        },
                function (data)
                {
                    $.pjax.reload({container: '#grid-user-pjax'});
                }
                );
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
