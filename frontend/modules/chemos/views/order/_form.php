<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\chemo\models\VwUserprofile;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$script1 = <<< JS
function init_click_handlers() {
    /* Delete */
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=chemos/rxorder/delete-details',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#cpoedetail-pjax'});
                        }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#cpoedetail-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});  
    
$('#form_rxorder').on('beforeSubmit', function (e)
    {
        var l = $('.ladda-button').ladda();
        l.ladda('start');
        var form = $(this);
        $.post(
                form.attr('action'), // serialize Yii2 form
                form.serialize()
                )

                .done(function (result) {
                    if (result != "")
                    {
                        swal({
                            title: "",
                            text: "Save Complete!",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: true,
                            closeOnCancel: true,
                        },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        l.ladda('stop');
                                        $('#tbcpoe-cpoe_num').val(result);
                                    }
                                });
                    }
                })
                .fail(function ()
                {
                    console.log('server error');
                })
        return false;
    });  
JS;
$this->registerJs($script1);
?>
<style>
    table.default thead tr th{
        background-color: #ddd;
        text-align: center;
    }
</style>
<div class="tb-cpoe-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_rxorder', 'action' => Url::to(['save-rxorder']),]); ?>

    <?= $form->field($model, 'cpoe_id', ['showLabels' => false])->hiddenInput() ?>
    <div class="form-group">
        <?= Html::activeLabel($model, 'cpoe_date', ['label' => 'ใบสั่งยาเลขที่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'cpoe_num', ['showLabels' => false])->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>

        <?= Html::activeLabel($model, 'cpoe_date', ['label' => 'วันที่', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?=
            $form->field($model, 'cpoe_date', ['showLabels' => false])->widget(DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'dd/MM/yyyy',
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'options' => [
                    'class' => 'form-control',
                //'style' => 'background-color: #ffff99',
                ],
            ])
            ?>  
        </div>

        <?= Html::activeLabel($model, 'cpoe_order_by', ['label' => 'แพทย์', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?=
            $form->field($model, 'cpoe_order_by', ['showLabels' => false])->widget(Select2::classname(), [
                'data' => ArrayHelper::map(VwUserprofile::find()->where(['User_jobid' => '3'])->all(), 'user_id', 'User_name'),
                'pluginOptions' => ['allowClear' => true],
                'options' => ['placeholder' => 'Select state...',]
            ]);
            ?>
        </div>
    </div>


    <div class="form-group">

    </div>

    <div class="form-group">
        <div class="col-lg-12 col-sm-6 col-xs-12">
            <?php Pjax::begin(['id' => 'cpoedetail-pjax']); ?>    
            <h5 class="success">
                <b><?= Html::encode('Medication :'); ?></b>
                <?=
                Html::a('<i class="glyphicon glyphicon-plus"></i>Drug', ['create-medication', 'cpoeid' => $model->cpoe_id, 'vn' => $model->pt_vn_number], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]) . ' ' .
                Html::a('<i class="glyphicon glyphicon-plus"></i>Chemo P.O.', ['create-chemopo', 'cpoeid' => $model->cpoe_id, 'vn' => $model->pt_vn_number], ['class' => 'btn btn-purple btn-sm', 'role' => 'modal-remote',]);
                ?>
            </h5>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'responsive' => true,
                'layout' => $layout,
                'showPageSummary' => true,
                'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                'tableOptions' => [
                    'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed',
                ],
                'columns' => [
                    [
                        'class' => '\kartik\grid\SerialColumn',
                        'width' => '25px',
                    ],
                    [
                        'header' => 'cpoe_itemtype_decs',
                        'attribute' => 'cpoe_itemtype_decs',
                        'contentOptions' => ['class' => 'text-left'],
                        'headerOptions' => ['style' => 'color:black;'],
                        'value' => function($model, $key, $index) {
                    return empty($model->cpoe_itemtype_decs) ? '-' : $model->cpoe_itemtype_decs;
                },
                        'group' => true, // enable grouping,
                        'groupedRow' => true, // move grouped column to a single grouped row
                        'groupOddCssClass' => 'kv-grouped-row', // configure odd group cell css class
                        'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                    ],
                    [
                        'header' => 'รหัสสินค้า',
                        'attribute' => 'ItemID',
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['style' => 'color:black;'],
                        'value' => function($model, $key, $index) {
                    return empty($model->ItemID) ? '-' : $model->ItemID;
                },
                    ],
                    [
                        'header' => 'รายการ',
                        'attribute' => 'ItemDetail',
                        'contentOptions' => ['class' => 'text-left'],
                        'headerOptions' => ['style' => 'color:black;'],
                        'value' => function($model, $key, $index) {
                    return empty($model->ItemDetail) ? '-' : $model->ItemDetail;
                },
                    ],
                    [
                        'header' => 'จำนวน',
                        'attribute' => 'ItemQty1',
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['style' => 'color:black;'],
                        'value' => function($model, $key, $index) {
                    return empty($model->ItemQty1) ? '-' : $model->ItemQty1;
                },
                    ],
                    [
                        'header' => 'ราคา/หน่วย',
                        'attribute' => 'ItemPrice',
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['style' => 'color:black;'],
                        'pageSummary' => 'รวม',
                        'value' => function($model, $key, $index) {
                    return empty($model->ItemPrice) ? '-' : $model->ItemPrice;
                },
                    ],
                    [
                        'header' => 'จำนวนเงิน',
                        'attribute' => 'Item_Amt',
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['style' => 'color:black;'],
                        'pageSummary' => true,
                        'format' => ['decimal', 2],
                        'value' => function($model, $key, $index) {
                    return empty($model->Item_Amt) ? '' : $model->Item_Amt;
                },
                    ],
                    [
                        'header' => 'เบิกได้',
                        'attribute' => 'Item_Cr_Amt_Sum',
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['style' => 'color:black;'],
                        'pageSummary' => true,
                        'format' => ['decimal', 2],
                        'value' => function($model, $key, $index) {
                    return empty($model->Item_Cr_Amt_Sum) ? '' : $model->Item_Cr_Amt_Sum;
                },
                    ],
                    [
                        'header' => 'เบิกไม่ได้',
                        'attribute' => 'Item_Pay_Amt',
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['style' => 'color:black;'],
                        'pageSummary' => true,
                        'format' => ['decimal', 2],
                        'value' => function($model, $key, $index) {
                    return empty($model->Item_Pay_Amt) ? '' : $model->Item_Pay_Amt;
                },
                    ],
                    [
                        'class' => '\kartik\grid\ActionColumn',
                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                        'template' => '{updatetreat} {delete}',
                        'noWrap' => true,
                        'header' => 'Actions',
                        'buttons' => [
                            'updatetreat' => function ($key, $model) {
                                if ($model['cpoe_Itemtype'] == 54) {
                                    $url = ['edit-chemopo', 'ids' => $model['cpoe_ids']];
                                    return Html::a('Edit', $url, [
                                                'title' => 'Edit',
                                                'class' => 'btn btn-info btn-xs',
                                                'role' => 'modal-remote',
                                    ]);
                                } else {
                                    $url = ['edit-medication', 'ids' => $model['cpoe_ids']];
                                    return Html::a('Edit', $url, [
                                                'title' => 'Edit',
                                                'class' => 'btn btn-info btn-xs',
                                                'role' => 'modal-remote',
                                    ]);
                                }
                            },
                                    'delete' => function ($url, $model) {
                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                            'title' => 'Delete',
                                            'data-toggle' => 'modal',
                                            'class' => 'activity-delete-link',
                                ]);
                            },
                                ],
                            ],
                        ],
                    ]);
                    ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($model, 'cpoe_comment', ['label' => 'หมายเหตุ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                <div class="col-sm-4">
                    <?= $form->field($model, 'cpoe_comment', ['showLabels' => false])->textarea(['rows' => 4]); ?>
                </div>
            </div>

            <div class="form-group" style="text-align: right">
                <div class="col-sm-12">
                    <?= Html::a('Close', ['/chemos'], ['class' => 'btn btn-default']); ?>
                    <?= Html::submitButton($model->isNewRecord ? 'Save Draft' : 'Save Draft', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', 'data-style' => 'expand-left']) ?>
                    <?= Html::button('Order Sign', [ 'class' => 'btn btn-info']); ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

</div>
