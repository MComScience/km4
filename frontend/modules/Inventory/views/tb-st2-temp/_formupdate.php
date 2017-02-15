<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use app\modules\Inventory\models\Tbstk;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\TbStstatus;
use app\modules\Inventory\models\TbSttype;
use yii\jui\DatePicker;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbSt2Temp */
/* @var $form yii\widgets\ActiveForm */
?>

<ul class="nav nav-tabs " id="myTab5">
    <li class="active">
        <a data-toggle="tab" href="#home5">
            <?= Html::encode($this->title); ?>
        </a>
    </li>  
</ul>

<div class="tab-content">
    <div id="home5" class="tab-pane in active">
        <!--<div class="tb-st2-temp-form">-->
        <div class="well">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'id' => 'form_st_main']); ?>
            <div class="row">
                <input type="hidden" value="<?php echo!empty($STID) ? $STID : '' ?>" name="stid" id="stid"/>
                <input type="hidden" value="<?php echo!empty($SRID) ? $SRID : '' ?>" name="srid" id="srid"/>
                <div class="col-sm-6">
                    <?= $form->field($model, 'STNum')->textInput(['maxlength' => true]) ?>
                    <?php
                    echo $form->field($model, 'STRecieve_StkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbstk::find()->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                    <?php $form->field($model, 'STTypeID')->textInput() ?>

                    <?php
                    echo $form->field($model, 'STTypeID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbSttype::find()->all(), 'STTypeID', 'STTypeDesc'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php $form->field($model, 'STDate')->textInput() ?>
                    <?php
                    echo
                    $form->field($model, 'STDate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Select issue date ...',
                        ],
                    ])
                    ?>
                    <?php $form->field($model, 'STIssue_StkID')->textInput() ?>
                    <?php
                    echo $form->field($model, 'STIssue_StkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbstk::find()->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                    <?php $form->field($model, 'STStatus')->textInput() ?>
                    <?php
                    echo $form->field($model, 'STStatus')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbStstatus::find()->all(), 'STStatusID', 'STStatusDesc'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                </div>


                <div style="margin: 20px">
                    <br>
                    <?php
                if (!empty($searchModel)) {
                        $ids = '';
                        ?>
                        <div class="form-group">
                            <?php \yii\widgets\Pjax::begin(['id' => 'sr2_detail_']) ?>
                            <?=
                            kartik\grid\GridView::widget([
                                'dataProvider' => $dataProvider,
                                'bootstrap' => true,
                                'showPageSummary' => true,
                                'responsiveWrap' => FALSE,
                                'responsive' => true,
                                'hover' => true,
                                'pjax' => true,
                                'striped' => false,
                                'condensed' => true,
                                'toggleData' => false,
                                'filterPosition' => \kartik\grid\GridView::FILTER_POS_BODY,
                                'tableOptions' => ['class' => \kartik\grid\GridView::TYPE_DEFAULT],
                                'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                                'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                'columns' => [

                                    [
                                        'class' => 'kartik\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                                        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd']
                                    ],
                                    [
                                        'class' => 'kartik\grid\ExpandRowColumn',
                                        'value' => function ($model, $key, $index, $column) {
                                            return GridView::ROW_COLLAPSED;
                                        },
                                        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'text-align:center;background-color: #ddd'],
                                        'detailAnimationDuration' => 'slow', //fast'expandOneOnly' => true,
                                        'expandOneOnly' => true,
                                        'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                        'detailUrl' => \yii\helpers\Url::to(['ext-pen']), //'index.php?r=Inventory/tb-st2-temp/ext-pen',
                                    ],
                                    [
                                        'header' => 'รหัสสินค้า',
                                        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                        'attribute' => 'ItemID',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                    if ($model->ItemID == NULL) {
                                        return '-';
                                    } else {
                                        return $model->ItemID;
                                    }
                                }
                                    ],
                                    [
                                        'header' => 'รายละเอียดสินค้า',
                                        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                        'attribute' => 'ItemName',
                                        'hAlign' => GridView::ALIGN_LEFT,
                                        'value' => function ($model) {
                                    if ($model->ItemName == NULL) {
                                        return '-';
                                    } else {
                                        return $model->ItemName;
                                    }
                                }
                                    ],
                                    [
                                        'header' => 'ขอเบิก',
                                        'width' => '150px',
                                        'headerOptions' => ['style' => 'text-align:right;background-color: #ddd'],
                                        'attribute' => 'SRQty',
                                        'format' => ['decimal', 2],
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                    if ($model->SRQty == NULL) {
                                        return '0.00';
                                    } else {
                                        return $model->SRQty;
                                    }
                                }
                                    ],
                                    [
                                        'header' => '',
                                        'attribute' => 'SRUnit',
                                        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                    if ($model->SRUnit == NULL) {
                                        return '-';
                                    } else {
                                        return $model->SRUnit;
                                    }
                                }
                                    ],
                                    [
                                        'header' => 'ยอดโอน',
                                        'width' => '150px',
                                        'attribute' => 'STQty',
                                        'format' => ['decimal', 2],
                                        'headerOptions' => ['style' => 'text-align:right;background-color: #ddd'],
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                    if ($model->STQty == NULL) {
                                        return '0.00';
                                    } else {
                                        return $model->STQty;
                                    }
                                }
                                    ],
                                    [
                                        'header' => '',
                                        'attribute' => 'SRUnit',
                                        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                    if ($model->SRUnit == NULL) {
                                        return '-';
                                    } else {
                                        return $model->SRUnit;
                                    }
                                }
                                    ],
                                    [
                                        'class' => 'kartik\grid\ActionColumn',
                                        'header' => 'Actions',
                                        'noWrap' => true,
                                        'options' => ['style' => 'width:100px;'],
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                        'template' => ' {view} {update} {deletegpu}',
                                        'buttonOptions' => ['class' => 'btn btn-default'],
                                        'buttons' => [
                                            'view' => function ($url, $model, $key) {

                                                if ($model->ids_st == null) {

                                                    $model = 'selectlot';
                                                    return Html::a('<span class="btn btn-success btn-xs">Select</span>', '#', [
                                                                'class' => 'activity-view-link',
                                                                'title' => 'Select',
                                                                'data-toggle' => 'modal',
                                                                //  'data-target' => '#lotselect_',
                                                                'data-id' => $key,
                                                                'data-pjax' => '0',
                                                    ]);
                                                }
                                            },
                                                    'update' => function ($url, $model, $key) {
                                                if ($model->ids_st != null) {
                                                    return Html::a('<span class="btn btn-info btn-xs">Edit</span>', '#', [
                                                                'class' => 'activity-update-link',
                                                                'title' => 'แก้ไขข้อมูล',
                                                                'data-toggle' => 'modal',
                                                                'data-target' => '#gpu-modal',
                                                                'data-id' => $key,
                                                                'data-pjax' => '0',
                                                    ]);
                                                }
                                            }
                                                    ,
                                                    'deletegpu' => function ($url, $model, $key) {
                                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                            //  'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                            'title' => 'Delete',
                                                            'data-toggle' => 'modal',
                                                            //'data-method' => "post",
                                                            //'role' => 'modal-remote',
                                                            'data-id' => $key,
                                                            'class' => 'activity-delete-link',
                                                ]);
                                            },
                                                ],
                                            ],
                                            [
                                                'class' => '\kartik\grid\DataColumn',
                                                'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                                'width' => '10px',
                                                'hidden' => true,
//                                                'value' => function ($model, $key, $index, $widget) {
//                                                    return '-';
//                                                },
                                                'group' => true, // enable grouping
                                                'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                                                    return [
                                                        'mergeColumns' => [
                                                            [1, 3],
                                                            [8, 9]
                                                        ], // columns to merge in summary
                                                        'content' => [// content to show in each summary cell
                                                            1 => '',
                                                            4 => 'จำนวน',
                                                            5 => 'หน่วย',
                                                            6 => 'จำนวน',
                                                            7 => 'หน่วย',
                                                        ],
                                                        'contentOptions' => [// content html attributes for each summary cell
                                                            0 => ['style' => 'background-color: #ddd'],
                                                            1 => ['style' => 'background-color: #ddd'],
                                                            4 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                            5 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                            6 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                            7 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                            8 => ['style' => 'background-color: #ddd']
                                                        ],
                                                        // html attributes for group summary row
                                                        'options' => ['class' => 'default', 'style' => 'font-weight:bold;']
                                                    ];
                                                }
                                                    ],
                                                ],
                                            ]);
                                            ?>
                                            <?php \yii\widgets\Pjax::end() ?>
                                        </div>
                                    <?php } ?>
                        </div> 
                        <div class="col-sm-6">
                            <?= $form->field($model, 'STNote')->textarea(['maxlength' => true, 'row' => 8]) ?>
                        </div>
                        <div style="text-align: right;margin-right: 10px">
                            <a class="btn btn-default"  href="index.php?r=Inventory/tb-st2-temp">Close</a>
                            <!--<a class="btn btn-danger" id="_clear" href="javascript:void(0)">Clear</a>-->
                            <?php // Html::submitButton($model->isNewRecord ? 'Create' : 'Save Draft', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
                            <!--<a class="btn btn-primary" id="_stock_issu" href="javascript:void(0)">Stock Issu</a>-->
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $s = <<< JS
    $('#_clear').click(function (e) {
          $.ajax({
            url: 'index.php?r=Inventory/tb-st2-temp/_clear',
            type: 'POST',
            data:$("#form_st_main").serialize(),
            success: function (data) {
               window.location.replace("index.php?r=Inventory/tb-st2-temp");
            }
      });
    });    
        
    $('#_clear').click(function (e) {
          $.ajax({
            url: 'index.php?r=Inventory/tb-st2-temp/_clear',
            type: 'POST',
            data:$("#form_st_main").serialize(),
            success: function (data) {
               window.location.replace("index.php?r=Inventory/tb-st2-temp");
            }
      });
    }); 
                
   $('#_stock_issu').click(function (e) {
    bootbox.confirm("Are you sure?", function (result) {
    if (result) {
          $.ajax({
            url: 'index.php?r=Inventory/tb-st2-temp/cmd-st2-stk-issu',
            type: 'POST',
            data:$("#form_st_main").serialize(),
            success: function (data) {
               window.location.replace("index.php?r=Inventory/tb-st2-temp");
            }
                
      });
    }
                });
    }); 
function init_click_handlers() {
      $('.activity-view-link').click(function (e) {
        var fID = $(this).closest('tr').children('td:eq(2)').text();
        var stkid = $('#tbst2temp-stissue_stkid').val();
               var  srid = $('#srid').val();
        $.get(
                'index.php?r=Inventory/tb-st2-temp/select-lot',
                {
                    id: fID,
                stkid:stkid,
                    srid:srid
                },
        function (data)
        {
          $('#formdetail').html(data);
        }
        );
    });
            
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
               $.ajax({
           // url: 'index.php?r=Inventory/tbsr2/update-detailgpu',
                    url: 'index.php?r=Inventory/tbsr2/detailedit',
            data:{id:fID},
            type: 'GET',
          // dataType: 'json',
            success: function (data) {
                    $('#header_tpund').html('แก้ไขข้อมูล');
                    $('#datatpudetal').html(data);
                    $('#tpu_sr2_detail_list').modal('show');
        }
      });                   
    });
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
       bootbox.confirm('Are you sure?', function (result) {
            if (result) {
                $.post(
                        'index.php?r=Inventory/tbsr2/delete-detail',
                        {
                            id: fID
                        },
                function (data)
                {
                    $.pjax.reload({container: '#sr2_detail_'});
                }
                );
            }
        });
    });
}
init_click_handlers(); //first run
$('#sr2_detail_').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
                        
JS;
        $this->registerJs($s);
        ?>

        <?php
        $script = <<< JS
$(document).ready(function () {
         //On Save
    $('#form_st_main').on('beforeSubmit', function(e)
    {
    var \$form = $(this);
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result)
            {
            //$(\$form).trigger("reset");
                $('#tbst2temp-stnum').val(result);
                  Notify('Saved Successfully!', 'top-right', '2000', 'success', 'fa-check', false);
            } else
            {
            $("#message").html(result);
            }
            })
            .fail(function()
            {
            console.log("server error");
            });
            return false;
    });
    
});
JS;
        $this->registerJs($script);
        ?>

        <?php
        Modal::begin([
            'id' => 'lotselect_',
            'header' => '<h4 class="modal-title">เลือก Lot Number</h4>',
            'size' => 'modal-dialog modal-lg'
        ]);
        ?>
        <div id="formdetail"/>
        <?php
        Modal::end();

        Modal::begin([
            'id' => 'determinethenumber',
            'header' => '<h4 class="modal-title">กำหนดจำนวน</h4>',
            'size' => 'modal-dialog modal-lg'
        ]);
        ?>

        <div id="determinethenumber_detail"/>
        <?php Modal::end(); ?>



