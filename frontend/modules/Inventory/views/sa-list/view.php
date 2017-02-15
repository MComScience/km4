<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use kartik\widgets\Select2;
use app\modules\Inventory\models\TbStk;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\TbSatype;
use app\modules\Inventory\models\TbSastatus;
use kartik\grid\GridView;

$this->title = 'บันทึกปรับปรุงยอดสินค้าคงคลัง';
$this->params['breadcrumbs'][] = ['label' => 'บันทึกปรับปรุงยอดสินค้าคงคลัง', 'url' => ['index']];
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
        <div class="well">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'id' => 'form_sa_main']); ?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'SAID')->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'SANum')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ?>
                     <div class="form-group field-inputEmail3 required ">
                        <label class="control-label col-sm-3" for="inputEmail3">ประเภทเอกสาร</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="status_" style="text-align:left" name="Tb" value="<?php
                            if ($model->SATypeID == 1) {
                                echo 'ปรับปรุงยอดสินค้าคงคลัง';
                            } else if ($model->SAStatus == 2) {
                                echo 'Active';
                            } 
                            ?>" readonly="" maxlength="50">
                            <div class="help-block help-block-error "></div>
                        </div>
                    </div>
                     <input type="hidden" value="<?php echo $model->SATypeID; ?>" name="TbPcplan[SATypeID]" />
                    <?php
                    $form->field($model, 'SATypeID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbSatype::find()->all(), 'SATypeID', 'SAType'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                             'disabled' => 'disabled'
                        ],
                    ]);
                    ?>
                     <div class="form-group field-inputEmail3 required ">
                        <label class="control-label col-sm-3" for="inputEmail3">สถานะ</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="status_" style="text-align:left" name="TbPcplan[PCPlanStatusID]" value="<?php
                            if ($model->SAStatus == 1) {
                                echo 'Draft';
                            } else if($model->SAStatus == 2){
                                echo 'Active';
                            }else if($model->SAStatus == 3){
                                echo 'Reject From Approve';
                            }else if($model->SAStatus == 4){
                                echo 'Approve';
                            }
                            else if($model->SAStatus == 5){
                                echo 'Hold SA';
                            } else if($model->SAStatus == 6){
                                echo 'Draft Approve';
                            }
                            ?>" readonly="" maxlength="50">
                            <div class="help-block help-block-error "></div>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $model->SAStatus; ?>" name="TbPcplan[PCPlanStatusID]" />
                    <?php
                     $form->field($model, 'SAStatus')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbSastatus::find()->all(), 'SAStatusID', 'SAStatusDesc'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                             'disabled' => 'disabled'
                        ],
                    ]);
                    ?>

                </div>
                <div class="col-sm-6">
                    <?php
                    echo
                    $form->field($model, 'SADate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Select issue date ...',
                             'disabled' => 'disabled'
                        ],
                    ])
                    ?>
                    <?php
                    echo $form->field($model, 'SA_stkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbStk::find()->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                             'disabled' => 'disabled'
                        ],
                    ]);
                    ?>

                </div> 
            </div>
            <h5 class="row-title before-success">รายละเอียดปรับปรุงยอด</h5>
            <br>
            <?php
//            echo '<a class="btn btn-success" id="addtpu" href="javascript:void(0)"><i class="glyphicon glyphicon-plus"> รายการยา</i></a> <a class="btn btn-success" id="addnd" href="javascript:void(0)"><i class="glyphicon glyphicon-plus"> รายการเวชภัณฑ์</i></a>';
            ?>
            <div style="margin: 20px">
                <!-- new   -->
                <?php if (!empty($searchModel)) { ?>
                    <div class="form-group">

                        <?php \yii\widgets\Pjax::begin(['id' => 'sr2_detail_']) ?>
                        <?php
                        //echo $this->render('_searchdetailgpu', ['model' => $searchModel,]);
                        ?>
                        <?=
                        kartik\grid\GridView::widget([
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
                            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                            'columns' => [
                               [
                                    'header' => '<font color="black">#</font>',
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => '']
                                ],
                                [
                                    'class' => 'kartik\grid\ExpandRowColumn',
                                    'value' => function ($model, $key, $index, $column) {
                                        return GridView::ROW_COLLAPSED;
                                    },
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'text-align:center;background-color: #ddd'],
                                    'detailAnimationDuration' => 'slow',
                                    'expandOneOnly' => true,
                                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                    'detailUrl' => \yii\helpers\Url::to(['ext-pen_1']),
                                ],
                                [
                                    'header' => '<font color="black">รหัสสินค้า</font>',
                                    'headerOptions' => ['style' => ''],
                                    'attribute' => 'ItemID',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->ItemID != null) {
                                    return $model->ItemID;
                                } else {
                                    return '-';
                                }
                            }
                                ],
                                [
                                    'header' => '<font color="black">รายละเอียดยา</font>',
                                    'headerOptions' => ['style' => 'text-align:center;'],
                                    'attribute' => 'ItemName',
                                    'value' => function ($model) {
                                if ($model->ItemName == NULL) {
                                    return '-';
                                } else {
                                    return $model->ItemName;
                                }
                            }
                                ],
                                [
                                    'header' => '<font color="black">หน่วย</font>',
                                    'attribute' => 'DispUnit',
                                    'headerOptions' => ['style' => ''],
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->DispUnit == NULL) {
                                    return '-';
                                } else {
                                    return $model->DispUnit;
                                }
                            },
                                ],
                                [
                                    'header' => '<font color="black">ยอดในคลัง</font>',
                                    'headerOptions' => ['style' => ''],
                                    'attribute' => 'OnhandLotItemQty',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => '<font color="black">นับได้</font>',
                                    'headerOptions' => ['style' => ''],
                                    'attribute' => 'ActualLotItemQty',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => '<font color="black">ส่วนต่าง</font>',
                                    'headerOptions' => ['style' => ''],
                                    'attribute' => 'AdjLotItemQty',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => '<font color="black">ยอดหลังจากการปรับปรุง</font>',
                                    'headerOptions' => ['style' => ''],
                                    'attribute' => 'BalanceAdjLotItemQty',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                ],
                            ],
                        ]);
                        ?>
                        <?php \yii\widgets\Pjax::end() ?>
                    </div>
                <?php } ?>

                <!-- new   -->

            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?php $form->field($model, 'SANote')->textarea(['maxlength' => true, 'rows' => 5]) ?>     
                </div>
                <div style="text-align: right;margin-right: 10px">
                    <?php if($appvo == '1'){  ?>
                    <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                    <?php }else if($appvo == '2'){ ?>
                    <?= Html::a('Close', ['wait-approve'], ['class' => 'btn btn-default']) ?>
                     <?php }else if($appvo == '3'){ ?>
                    <?= Html::a('Close', ['history'], ['class' => 'btn btn-default']) ?>
                    <?php } ?>
                </div>  
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$script = <<<JS
    $('#_Clear').click(function (e) {
        var fID = $('#tbsa2-said').val(); 
             $.get(
                    'sa2-clear',
                {
                     id: fID
                },
                function (data)
                {
                   location.replace("index")
                   Notify('Clear Successfully!', 'top-right', '2000', 'success', 'fa-check', false);
                }
    );
    });
         $('#_sendtoapprove').click(function (e) {
        var fID = $('#tbsa2-said').val(); 
             $.get(
                    'sa2-send-to-approve',
                {
                     id: fID
                },
                function (data)
                {
                   location.replace("index")
                   Notify('Send To Successfully!', 'top-right', '2000', 'success', 'fa-check', false);
                }
    );
    });
          //On Save  
  $(document).ready(function () {
    $('#form_sa_main').on('beforeSubmit', function(e)
    {
    var \$form = $(this);
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result)
            {
                $('#tbsa2-sanum').val(result);
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
