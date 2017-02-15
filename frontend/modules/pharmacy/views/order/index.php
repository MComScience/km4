<?php

use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\grid\GridView;

$layout = <<< HTML
<div class="pull-right">{toolbar}</div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

#register assets
CrudAsset::register($this);

$this->title = 'Rx Order';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/pt/index']];
$this->params['breadcrumbs'][] = ['label' => 'สั่งจ่ายยาผู้ป่วยนอก', 'url' => ['/pharmacy/pt/index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
    $('li.order').addClass("active");
});
    $('#btn-savedraft-cpoe').click(function (e) {
        var order_by = $('#tbcpoe-cpoe_order_by :selected').val();
        if (order_by == '') {
            //swal("Message Alert", "กรุณากรอกข้อมูลด้านบนให้ครบ", "warning");
            swal({
                title: "Message Alert",
                text: "กรุณาเลือกแพทย์",
                type: "warning",
                showCancelButton: false,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.pjax({container: '#cpoedetail-pjax'});
                        }
                    });
        } else {
            SaveDraftCpoe();
        }
    });
    
    function SaveDraftCpoe() {
        var frm = $('#form_rxorder');
        var l = $('.ladda-button').ladda();
        l.ladda('start');
        $.ajax({
            type: 'POST',
            url: 'index.php?r=pharmacy/rxorder/savedraft-cpoe',
            data: frm.serialize(),
            success: function (data) {
                $('#tbcpoe-cpoe_num').val(data);
                swal({
                    title: "",
                    text: "SaveDraft Complete!",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                l.ladda('stop');
                            }
                        });
            }
        });
    }
JS;
$this->registerJs($script);
?>

<style>
    table.kv-grid-table thead tr th{
        background-color: white;
    }
    div#ajaxCrudModal .modal-content {
        /* new custom width */
        width: 1222px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -140px;
    }
</style>

<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="col-lg-12 col-sm-6 col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            <?= Html::encode('บันทึกใบสั่งยาผู้ป่วยนอก'); ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="horizontal-space"></div>

        </div>
        <div class="profile-container">

            <?= $this->render('_header', ['header' => $header, 'ptar' => $ptar,]) ?>

            <div class="profile-body">
                <div class="col-lg-12 col-sm-6 col-xs-12">
                    <div class="tabbable">
                        <?= $this->render('_tab', ['header' => $header]) ?>
                        <div class="tab-content tabs-flat bg-white">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-12">
                                    <?php echo $this->render('_form', ['model' => $model, 'dataProvider' => $dataProvider]); ?>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-sm-6 col-xs-12">
                                    <?php Pjax::begin(['id' => 'cpoedetail-pjax']); ?>    
                                    <?php /*
                                      <h5 class="success">
                                      <b><?= Html::encode('Medication :'); ?></b>
                                      <?=
                                      Html::a('<i class="glyphicon glyphicon-plus"></i>Drug', ['create-medication', 'cpoeid' => $model->cpoe_id, 'vn' => $model->pt_vn_number], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]) . ' ' .
                                      Html::a('<i class="glyphicon glyphicon-plus"></i>Chemo P.O.', ['create-chemopo', 'cpoeid' => $model->cpoe_id, 'vn' => $model->pt_vn_number], ['class' => 'btn btn-purple btn-sm', 'role' => 'modal-remote',]);
                                      ?>
                                      </h5>
                                     * 
                                     */ ?>
                                    <?=
                                    GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'responsive' => true,
                                        'layout' => $layout,
                                        'showPageSummary' => true,
                                        'striped' => false,
                                        'condensed' => true,
                                        'hover' => true,
                                        'bordered' => true,
                                        'headerRowOptions' => [
                                            'class' => GridView::TYPE_DEFAULT
                                        ],
                                        'toggleData' => false,
                                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                        'panel' => [
                                            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i> Details</h3>',
                                            'type' => GridView::TYPE_DEFAULT,
                                            'before' =>
                                            Html::a('<i class="glyphicon glyphicon-plus"></i>Drug', ['create-medication', 'cpoeid' => $model->cpoe_id, 'vn' => $model->pt_vn_number], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]) . ' ' .
                                            Html::a('<i class="glyphicon glyphicon-plus"></i>Chemo P.O.', ['create-chemopo', 'cpoeid' => $model->cpoe_id, 'vn' => $model->pt_vn_number], ['class' => 'btn btn-purple btn-sm', 'role' => 'modal-remote',]),
                                            'after' => false,
                                        ],
                                        'export' => [
                                            'fontAwesome' => true,
                                            'label' => '<b>สรุปรายการยา</b>',
                                            'class' => 'btn btn-default',
                                            'icon' => 'print',
                                            'showConfirmAlert' => FALSE,
                                            'header' => '',
                                            'stream' => false,
                                            'target' => '_blank',
                                        ],
                                        'exportConfig' => [
                                            // GridView::EXCEL => ['label' => 'EXCEL', 'filename' => empty($model['cpoe_num']) ? 'Report' : $model['cpoe_num'],],
                                            GridView::PDF => [
                                                'label' => Yii::t('app', 'PDF'),
                                                'iconOptions' => ['class' => 'text-danger'],
                                                'filename' => 'สรุปรายการยา',
                                                'options' => ['title' => Yii::t('app', 'Portable Document Format')],
                                                'mime' => 'application/pdf',
                                                'showHeader' => true,
                                                'showPageSummary' => true,
                                                'showFooter' => true,
                                                'showCaption' => true,
                                                'config' => [
                                                    'mode' => 'UTF-8',
                                                    'format' => 'A4-L',
                                                    'destination' => 'D',
                                                    'marginTop' => 35,
                                                    'marginBottom' => 20,
                                                    'marginHeader' => 10,
                                                    'methods' => [
                                                        'SetHeader' => $this->render('_header_report', [
                                                            'model' => $model,
                                                        ]),
                                                        'SetFooter' => ['|Page {PAGENO}|'],
                                                    ],
                                                    'options' => [
                                                        'title' => 'Report',
                                                        'defaultheaderline' => 0,
                                                        'defaultfooterline' => 0,
                                                    ],
                                                ]
                                            ],
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
                                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                                'value' => function($model, $key, $index) {
                                            return empty($model->ItemID) ? '-' : $model->ItemID;
                                        },
                                            ],
                                            [
                                                'header' => 'รายการ',
                                                'attribute' => 'ItemDetail',
                                                'contentOptions' => ['class' => 'text-left'],
                                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                                'value' => function($model, $key, $index) {
                                            return empty($model->ItemDetail) ? '-' : $model->ItemDetail;
                                        },
                                            ],
                                            [
                                                'header' => 'จำนวน',
                                                'attribute' => 'ItemQty1',
                                                'contentOptions' => ['class' => 'text-center'],
                                                'noWrap' => true,
                                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                                'value' => function($model, $key, $index) {
                                            return empty($model->ItemQty1) ? '-' : $model->ItemQty1;
                                        },
                                            ],
                                            [
                                                'header' => 'ราคา/หน่วย',
                                                'attribute' => 'ItemPrice',
                                                'contentOptions' => ['class' => 'text-right'],
                                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                                'pageSummary' => 'รวม',
                                                'noWrap' => true,
                                                'pageSummaryOptions' => ['style' => 'text-align:right'],
                                                'value' => function($model, $key, $index) {
                                            return empty($model->ItemPrice) ? '-' : $model->ItemPrice;
                                        },
                                            ],
                                            [
                                                'header' => 'จำนวนเงิน',
                                                'attribute' => 'Item_Amt',
                                                'contentOptions' => ['class' => 'text-right'],
                                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                                'pageSummary' => true,
                                                'format' => ['decimal', 2],
                                                'noWrap' => true,
                                                'pageSummaryOptions' => ['style' => 'text-align:right'],
                                                'value' => function($model, $key, $index) {
                                            return empty($model->Item_Amt) ? '' : $model->Item_Amt;
                                        },
                                            ],
                                            [
                                                'header' => 'เบิกได้',
                                                'attribute' => 'Item_Cr_Amt_Sum',
                                                'contentOptions' => ['class' => 'text-right'],
                                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                                'pageSummary' => true,
                                                'noWrap' => true,
                                                'format' => ['decimal', 2],
                                                'pageSummaryOptions' => ['style' => 'text-align:right'],
                                                'value' => function($model, $key, $index) {
                                            return empty($model->Item_Cr_Amt_Sum) ? '' : $model->Item_Cr_Amt_Sum;
                                        },
                                            ],
                                            [
                                                'header' => 'เบิกไม่ได้',
                                                'attribute' => 'Item_Pay_Amt_Sum',
                                                'contentOptions' => ['class' => 'text-right'],
                                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                                'pageSummary' => true,
                                                'noWrap' => true,
                                                'format' => ['decimal', 2],
                                                'pageSummaryOptions' => ['style' => 'text-align:right'],
                                                'value' => function($model, $key, $index) {
                                            return empty($model->Item_Pay_Amt_Sum) ? '' : $model->Item_Pay_Amt_Sum;
                                        },
                                            ],
                                            [
                                                'class' => '\kartik\grid\ActionColumn',
                                                'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                                'template' => '{updatetreat} {delete}',
                                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
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
                                    <br/>
                                    <div class="row" >
                                        <div class="col-lg-12 col-sm-6 col-xs-12" style="text-align: right">
                                            <?= Html::a('Close', ['/pharmacy/pt/index'], ['class' => 'btn btn-default']); ?>
                                            <?= Html::button('SaveDraft', [ 'class' => 'btn btn-success ladda-button', 'id' => 'btn-savedraft-cpoe', 'data-style' => 'expand-left']); ?>
                                            <?= Html::button('Save', [ 'class' => 'btn btn-success']); ?>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        Modal::begin([
            "id" => "ajaxCrudModal",
            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            "footer" => "", // always need it for jquery plugin
            'options' => ['tabindex' => FALSE]
        ])
        ?>
        <?php Modal::end(); ?>

