<?php
use kartik\grid\GridView;
use yii\helpers\Html;
echo $this->render('/config/Asset_Js.php');
$header_style = ['style' => 'text-align:center;background-color: #ddd;color:#000000;'];
?>
<div class="tabbable">
    <div class="tab-content tabs-flat">
        <div id="body_payment" class="tab-pane active">
            <?php \yii\widgets\Pjax::begin([ 'id' => 'pjax_footer', 'timeout' => 5000]) ?>
            <div class="row profile-overview">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php if ($view == 'create') { ?>
                    <div class="form-group" >
                        <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">วิธีการชำระเงิน</label>
                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <a class="btn btn-success btn-md" id="Cash"><i class="glyphicon glyphicon-plus">เงินสด</i></a>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <a class="btn btn-success btn-md" id="Creditcard"><i class="glyphicon glyphicon-plus">บัตรเครดิต</i></a>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12" style="margin-left: 22px">
                            <a class="btn btn-success btn-md" id="Banktrans"><i class="glyphicon glyphicon-plus">โอนเงิน</i></a>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"  style="margin-left: 5px">
                            <a class="btn btn-success btn-md" id="Cheque"><i class="glyphicon glyphicon-plus">เช็คธนาคาร</i></a>
                        </div>
                    </div>
                    <?php }?>
                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                    <?php if ($view == 'create') { ?>
                        <div class="form-group">
                            <?=
                            kartik\grid\GridView::widget([
                                'dataProvider' => $dataProviderFT,
                                'bootstrap' => true,
                                'responsiveWrap' => FALSE,
                                'responsive' => true,
                                'showPageSummary' => true,
                                'hover' => true,
                                'pjax' => true,
                                'striped' => true,
                                'condensed' => true,
                                'toggleData' => false,
                                'pageSummaryRowOptions' => ['class' => 'default', 'id' => 'setting_summary_row'],
                                'layout' => Yii::$app->componentdate->layoutgridview(),
                                'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                'columns' => [
                                    [
                                        'class' => 'kartik\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                                        'width' => '36px',
                                        'header' => 'ลำดับ',
                                        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:#000000;'],
                                    ],
                                    [
                                        'headerOptions' => $header_style,
                                        'header' => 'รายละเอียดการชำระ',
                                        'pageSummary' => '<div  style="text-align: right;margin-right: 15px;">รวม</div>',
                                        'hAlign' => kartik\grid\GridView::ALIGN_LEFT,
                                        'value' => function ($model) {
                                            if ($model->piad_type == NULL) {
                                                return '-';
                                            } else {
                                                return $model->piad_type;
                                            }
                                        }
                                    ],
                                    [
                                        'headerOptions' => $header_style,
                                        'header' => 'เป็นเงิน',
                                        'format' => ['decimal', 2],
                                        'pageSummary' => true,
                                        'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                        'value' => function ($model) {
                                            if ($model->paid_amt == NULL) {
                                                return '0';
                                            } else {
                                                return $model->paid_amt;
                                            }
                                        }
                                    ],
//                                    [
//                                        'headerOptions' => $header_style,
//                                        'header' => 'Type',
//                                        //'format' => ['decimal', 2],
//                                        //'pageSummary' => true,
//                                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
//                                        'value' => function ($model) {
//                                    if ($model->piad_typeid == NULL) {
//                                        return '0';
//                                    } else {
//                                        return $model->piad_typeid;
//                                    }
//                                }
//                                    ],
                                    [
                                        'class' => 'kartik\grid\ActionColumn',
                                        'header' => 'Actions',
                                        'noWrap' => true,
                                        'pageSummary' => '<div style="margin-right: 60px;">บาท</div>',
                                        'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                        'headerOptions' => $header_style,
                                        'template' => '{update} {delete}',
                                        'buttonOptions' => ['class' => 'btn btn-default'],
                                        'buttons' => [
                                            'update' => function ($url, $model, $key) {
                                                return Html::a('<span class="btn btn-info btn-xs">Edit</span>', false, [
                                                            'class' => 'activity-editdetail-link',
                                                            'title' => 'app', 'Edit',
                                                            'data-id' => $key,
                                                ]);
                                            },
                                                    'delete' => function ($url, $model, $key) {
                                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ',false, [
                                                            'title' => 'Delete',
                                                            'class' => 'activity-deletedetail-link',
                                                            'data-id' => $key,
                                                ]);
                                            },
                                                ],
                                            ],
                                        ],
                                    ]);
                                    ?>
                                </div>
                        <?php }?>
                        <?php if ($view == 'history') { ?>
                            <div class="form-group">
                            <?=
                            kartik\grid\GridView::widget([
                                'dataProvider' => $dataProviderFT,
                                'bootstrap' => true,
                                'responsiveWrap' => FALSE,
                                'responsive' => true,
                                'showPageSummary' => true,
                                'hover' => true,
                                'pjax' => true,
                                'striped' => true,
                                'condensed' => true,
                                'toggleData' => false,
                                'pageSummaryRowOptions' => ['class' => 'default', 'id' => 'setting_summary_row'],
                                'layout' => Yii::$app->componentdate->layoutgridview(),
                                'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                'columns' => [
                                    [
                                        'class' => 'kartik\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                                        'width' => '36px',
                                        'header' => 'ลำดับ',
                                        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:#000000;'],
                                    ],
                                    [
                                        'headerOptions' => $header_style,
                                        'header' => 'รายละเอียดการชำระ',
                                        'pageSummary' => '<div  style="text-align: right;margin-right: 15px;">รวม</div>',
                                        'hAlign' => kartik\grid\GridView::ALIGN_LEFT,
                                        'value' => function ($model) {
                                            if ($model->piad_type == NULL) {
                                                return '-';
                                            } else {
                                                return $model->piad_type;
                                            }
                                        }
                                    ],
                                    [
                                        'headerOptions' => $header_style,
                                        'header' => 'เป็นเงิน',
                                        'format' => ['decimal', 2],
                                        'pageSummary' => true,
                                        'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                        'value' => function ($model) {
                                            if ($model->paid_amt == NULL) {
                                                return '0';
                                            } else {
                                                return $model->paid_amt;
                                            }
                                        }
                                    ],
                                
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <?php }?>
                                <br><br>
                                <?php if ($view == 'create') { ?> 
                                <div class="form-group">
                                    <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-left" style="color:#53a93f;text-align:left">หมายเหตุ:</label>
                                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12" style="text-align:left;">
                                        <?=
                                        $form->field($modelHD, 'rep_comment', ['showLabels' => false])->textarea([
                                            'rows' => 3,
                                            'style' => 'background-color:#FFFF99',
                                        ])
                                        ?>
                                    </div>
                                </div>
                                <?php }?>
                                <?php if ($view == 'history') { ?> 
                                <div class="form-group">
                                    <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-left" style="color:#53a93f;text-align:left">หมายเหตุ:</label>
                                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12" style="text-align:left;">
                                        <?=
                                        $form->field($modelHD, 'rep_comment', ['showLabels' => false])->textarea([
                                            'rows' => 3,
                                            'style' => 'background-color:white',
                                            'readonly'=>true,
                                        ])
                                        ?>
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">รวมเป็นเงิน</label>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <?=
                                        $form->field($modelPaid, 'rep_Amt_total', ['showLabels' => false])->textInput([
                                            'maxlength' => true,
                                            'readonly' => true,
                                            'style' => 'background-color:white;text-align: right;font-size: 30px;',
                                            'value' => $modelPaid['rep_Amt_total'] == null ? '0.00' : number_format($modelPaid['rep_Amt_total'], 2),
                                        ])
                                        ?>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                        <label class="control-label no-padding-left">บาท</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ส่วนลด</label>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <?=
                                        $form->field($modelPaid, 'rep_Amt_discount', ['showLabels' => false])->textInput([
                                            'maxlength' => true,
                                            'readonly' => true,
                                            'style' => 'background-color:white;text-align: right;font-size: 30px;',
                                            'value' => $modelPaid['rep_Amt_discount'] == null ? '0.00' :number_format($modelPaid['rep_Amt_discount'], 2),
                                        ])
                                        ?>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                        <label class="control-label no-padding-left">บาท</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">รวมยอดที่ต้องชำระ</label>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <?=
                                        $form->field($modelPaid, 'rep_Amt_net', ['showLabels' => false])->textInput([
                                            'maxlength' => true,
                                            'readonly' => true,
                                            'style' => 'background-color: #5db2ff;text-align: right;font-size: 30px;color: #Fff;',
                                            'value' => $modelPaid['rep_Amt_net'] == null ? '0.00' : number_format($modelPaid['rep_Amt_net'],2),
                                        ])
                                        ?>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                        <label class="control-label no-padding-left">บาท</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ชำระแล้ว</label>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <?=
                                        $form->field($modelPaid, 'rep_item_sum_paid', ['showLabels' => false])->textInput([
                                            'maxlength' => true,
                                            'readonly' => true,
                                            'style' => 'background-color:white;text-align: right;font-size: 30px;',
                                            'value' => $modelPaid['rep_item_sum_paid'] == null ? '0.00' : number_format($modelPaid['rep_item_sum_paid'], 2),
                                        ])
                                        ?>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                        <label class="control-label no-padding-left">บาท</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ค้างชำระ</label>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <?=
                                        $form->field($modelPaid, 'rep_Amt_left', ['showLabels' => false])->textInput([
                                            'maxlength' => true,
                                            'readonly' => true,
                                            'style' => 'background-color:white;text-align: right;font-size: 30px;',
                                            'value' => $modelPaid['rep_Amt_left'] === null ? number_format($modelPaid['rep_Amt_net'], 2) : number_format($modelPaid['rep_Amt_left'], 2),
                                        ])
                                        ?>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                        <label class="control-label no-padding-left">บาท</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <?=
                                    $form->field($modelPaid, 'rep_id', ['showLabels' => false])->hiddenInput([
                                        'readonly' => true,
                                        'style' => 'background-color:white',
                                    ])
                                    ?>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top:30px;text-align: right">
                                <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                                <?php if ($view == 'create') { ?>  
                                <?= Html::button('Clear', ['class' => 'btn btn-danger', 'id' => 'Clear']) ?>
                                <button class="btn btn-success" type="submit">Draft</button>
                                <a class="btn btn-info" id="Save" onclick="Save();">Save</a>
                                <?php } ?>
                                <?php if ($view == 'history') { ?> 
                                 <?= Html::a('พิมพ์ใบเสร็จ',['/Payment/payment/newbill1','id'=>$modelHD->rep_id],['class'=>'btn btn-info','target'=>"_blank",'data-pjax'=>0]) ?>
                                <?php } ?>
                            </div>    
                        </div>
                    </div>
                    <?php \yii\widgets\Pjax::end() ?>
                </div>
            </div>
        </div>
        <?php
        \yii\bootstrap\Modal::begin([
            'id' => 'payment_Cash',
            'header' => '<h4 class="modal-title">ชำระเงินสด</h4>',
            'size' => 'modal-md modal-primary',
        ]);
        ?>
        <div id="data_Cash"></div>
        <?php \yii\bootstrap\Modal::end(); ?>
        <?php
        \yii\bootstrap\Modal::begin([
            'id' => 'payment_Creditcard',
            'header' => '<h4 class="modal-title">ชำระบัตรเครดิต</h4>',
            'size' => 'modal-md modal-primary',
        ]);
        ?>
        <div id="data_Creditcard"></div>
        <?php \yii\bootstrap\Modal::end(); ?>
        <?php
        \yii\bootstrap\Modal::begin([
            'id' => 'payment_Banktrans',
            'header' => '<h4 class="modal-title">ชำระโดยเข้าบัญชีธนาคาร</h4>',
            'size' => 'modal-md modal-primary',
        ]);
        ?>
        <div id="data_Banktrans"> </div>
        <?php \yii\bootstrap\Modal::end(); ?>
        <?php
        \yii\bootstrap\Modal::begin([
            'id' => 'payment_Cheque',
            'header' => '<h4 class="modal-title">ชำระโดยเช็คธนาคาร</h4>',
            'size' => 'modal-md modal-primary',
        ]);
        ?>
        <div id="data_Cheque"></div>
        <?php \yii\bootstrap\Modal::end(); ?>
        <?php
        $script = <<< JS
$(document).ready(function(){
   ready_pjax();
});
function ready_pjax() {
    //$('#setting_summary_row').css('background-color','#ddd');            
    $('#setting_summary_row').css('font-weight','bolder');            
    var checkbtn = $('#vwitempaid-rep_amt_left').val();
    if(checkbtn === '0.00' || checkbtn === '0' || checkbtn === ''){
        $('#Cash').addClass("disabled", "disabled");
        $('#Creditcard').addClass("disabled", "disabled");
        $('#Banktrans').addClass("disabled", "disabled");
        $('#Cheque').addClass("disabled", "disabled");    
    }       
}                
function LocationHash() {
    $("html, body").animate({ scrollTop: $('#pjax_footer').offset().top -50}, 1000);
} 
function LocationFast() {
    $("html, body").animate({ scrollTop: $('#pjax_footer').offset().top -50}, 10);
}     
function init_click_handlers() {
    ready_pjax();
  //   $('#Print').click(function (e) { 
  //   	window.open("http://www.udcancer.org/km4/Payment/payment/newbill1?id="+$('#vwitempaid-rep_id').val(),'_blank');      
 	// });
 	$('#Clear').click(function (e) { 
    	alert('Wait_Sql_Query');     
     //window.open("www.waitreport.com"+$('#vwitempaid-rep_id').val(),'_blank');     
 	});     
    $('.activity-deletedetail-link').click(function (e) {
        var payment_id = $(this).attr("data-id");
        console.log(payment_id);
        wait();
        LocationFast();
        swal({   
                title: "ยืนยันคำสั่ง?",   
                text: "",   
                type: "error",   
                showCancelButton: true,   
                confirmButtonColor: "#53a93f",   
                confirmButtonText: "Confirm",   
                closeOnConfirm: false
        },function(){        
        $.get(
                'delete-payment',
                {
                    payment_id
                },
                function (data)
                {   
                    $('#_form_payment').waitMe('hide');
                    swal("Success","", "success");
                    $.pjax.reload({container:'#pjax_footer'});
                    //LocationHash();
                }
        );
        });
        $('#_form_payment').waitMe('hide');       
    });
    $('.activity-editdetail-link').click(function (e) {
    var payment_id = $(this).attr("data-id");
    var key = $(this).attr("data-id");            
    console.log(payment_id);
    wait();
    var rep_id = $('#vwitempaid-rep_id').val();
    var check_edit = 'edit';
    LocationFast();            
    $.get(
            'edit-payment',
    {
    payment_id
    },
            function (data)
            {       console.log(data);
            if (data === '1'){
            $.get(
                    'cash',
            {
            rep_id, check_edit, key
            },
                    function (data)
                    {
                    $('#_form_payment').waitMe('hide');
                    $('#payment_Cash').find('.modal-body').html(data);
                    $('#data_Cash').html(data);
                    $('#payment_Cash').modal('show');
                    }
            );
            } else if (data === '2'){
            $.get(
                    'creditcard',
            {
            rep_id, check_edit, key
            },
                    function (data)
                    {
                    $('#_form_payment').waitMe('hide');
                    $('#payment_Creditcard').find('.modal-body').html(data);
                    $('#data_Creditcard').html(data);
                    $('#payment_Creditcard').modal('show');
                    }
            );
            } else if (data === '3'){
            $.get(
                    'banktrans',
            {
            rep_id, check_edit, key
            },
                    function (data)
                    {
                    $('#_form_payment').waitMe('hide');
                    $('#payment_Banktrans').find('.modal-body').html(data);
                    $('#data_Banktrans').html(data);
                    $('#payment_Banktrans').modal('show');
                    }
            );
            } else if (data === '4'){
            $.get(
                    'cheque',
            {
            rep_id, check_edit, key
            },
                    function (data)
                    {
                    $('#_form_payment').waitMe('hide');
                    $('#payment_Cheque').find('.modal-body').html(data);
                    $('#data_Cheque').html(data);
                    $('#payment_Cheque').modal('show');
                    }
            );
            } else{
            console.log('error!!');
            }

            }
    );
    });
    $('#Cash').click(function (e) {
        console.log('Cash');
        wait();
        var check_edit = 'create';
//        var cash = $('#vwitempaid-rep_piad_cash').val();
//        console.log(cash);
//        if(cash != '0.00'){
//            var check_edit = 'edit';
//        }else{
//            var check_edit = 'create';
//        }
        var rep_id = $('#vwitempaid-rep_id').val();
        console.log(rep_id);
        var key = '';        
        wait();
        $.get(
                'cash',
                {
                    rep_id,check_edit,key
                },
                function (data)
                {   
                    $('#_form_payment').waitMe('hide');
                    $('#payment_Cash').find('.modal-body').html(data);
                    $('#data_Cash').html(data);
                    $('#payment_Cash').modal('show');
                }
        );
    });
    $('#Creditcard').click(function (e) {
        console.log('Creditcard');
        wait();
        var check_edit = 'create';       
//        var creditcard = $('#vwitempaid-rep_piad_creditcard').val();
//        if(creditcard != '0.00'){
//            var check_edit = 'edit';
//        }else{
//            var check_edit = 'create';
//        }
        var rep_id = $('#vwitempaid-rep_id').val();
        console.log(rep_id);
        var key = '';
        $.get(
                'creditcard',
                {
                    rep_id,check_edit,key
                },
                function (data)
                {
                    $('#_form_payment').waitMe('hide');
                    $('#payment_Creditcard').find('.modal-body').html(data);
                    $('#data_Creditcard').html(data);
                    $('#payment_Creditcard').modal('show');
                }
        );
    });
$('#Banktrans').click(function (e) {
        console.log('Banktrans');
        wait();
                var check_edit = 'create';
//        var banktransfer = $('#vwitempaid-rep_piad_banktransfer').val();
//        if(banktransfer != '0.00'){
//            var check_edit = 'edit';
//        }else{
//            var check_edit = 'create';
//        }
        var rep_id = $('#vwitempaid-rep_id').val();
        console.log(rep_id);
        var key = '';        
        $.get(
                'banktrans',
                {
                   rep_id,check_edit,key
                },
                function (data)
                {
                    $('#_form_payment').waitMe('hide');
                    $('#payment_Banktrans').find('.modal-body').html(data);
                    $('#data_Banktrans').html(data);
                    $('#payment_Banktrans').modal('show');
                }
        );
});
$('#Cheque').click(function (e) {
        console.log('Cheque');        
        wait();
        var check_edit = 'create';         
//        var cheque = $('#vwitempaid-rep_piad_cheque').val();
//        if(cheque != '0.00'){
//            var check_edit = 'edit';
//        }else{
//            var check_edit = 'create';
//        }
        var rep_id = $('#vwitempaid-rep_id').val();
        console.log(rep_id);
        var key = '';
        $.get(
                'cheque',
                {
                    rep_id,check_edit,key
                },
                function (data)
                {
                    $('#_form_payment').waitMe('hide');
                    $('#payment_Cheque').find('.modal-body').html(data);
                    $('#data_Cheque').html(data);
                    $('#payment_Cheque').modal('show');
                }
        );
});
}
    init_click_handlers(); //first run
    $('#pjax_footer').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    });
    function wait(){
            var current_effect = 'ios';
            run_waitMe(current_effect);
            function run_waitMe(effect) {
                $('#_form_payment').waitMe({
                    effect: 'ios',
                    text: 'กำลังโหลดข้อมูล...',
                    bg: 'rgba(255,255,255,0.7)',
                    color: '#000',
                    sizeW: '',
                    sizeH: '',
                    source: '',
                    onClose: function () {}
                });
            }
    } 
    $('#form_payment').on('beforeSubmit', function(e){ 
            var \$form = $(this);
            wait();
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result){
            if(result){
                $('#_form_payment').waitMe('hide');
                $('#vwfirepheader-rep_num').val(result);
                console.log(result);
                swal("บันทึกข้อมูล","","success");
                $("#Save").removeAttr('disabled');
            }else{
                console.log('else');
            }
            })
            .fail(function(){
            console.log('Function Error!!');
            })
            return false;
       
    });  
    function Save(){
        swal("","Save","Success");         
    };  
JS;
        $this->registerJs($script);
        ?>
<script>
    function wait(){
            var current_effect = 'ios';
            run_waitMe(current_effect);
            function run_waitMe(effect) {
                $('#_form_payment').waitMe({
                    effect: 'ios',
                    text: 'กำลังโหลดข้อมูล...',
                    bg: 'rgba(255,255,255,0.7)',
                    color: '#000',
                    sizeW: '',
                    sizeH: '',
                    source: '',
                    onClose: function () {}
                });
            }
    } 
    function Save(){
        var rep_id = $('#vwitempaid-rep_id').val();
        var repdate = $("#vwfirepheader-repdate").val();
        var rep_comment = $('#vwfirepheader-rep_comment').val();
        var rep_amt_left = $('#vwitempaid-rep_amt_left').val();
        if(rep_amt_left != '0.00'){
            var showText = "คงเหลือยอดค้างชำละ "+rep_amt_left+" บาท";
        }else{
            var showText = "ต้องการที่จะบันทึกข้อมูลใช่หรือไม่";
        }
        swal({   
            title: "ยืนยันคำสั่ง?",   
            text: showText,   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#53a93f",   
            confirmButtonText: "Confirm",   
            closeOnConfirm: false
        },function(){
        wait();
        $.post(
            'save',
            {
              rep_id,repdate,rep_comment
            },
                function (data)
                {   
                    after_save();
                    $('#_form_payment').waitMe('hide');
                }
        );
        });
        $('#_form_payment').waitMe('hide');      
    };
    function after_save(){
                 swal({   
                    title: "ต้องการสั่งพิมพ์ใช่หรือไม่?",   
                    text: '',   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#53a93f",   
                    confirmButtonText: "Confirm",   
                    closeOnConfirm: false,   
                    closeOnCancel: false
                   },function(isConfirm){   
                    if (isConfirm) {
                        $.post(
                            'page-index',
                            { },
                        function (data)
                            { }
                        );     
                        window.open("http://www.udcancer.org/km4/Payment/payment/newbill1?id="+$('#vwitempaid-rep_id').val(),'_blank'); 
                    } else {     
                        $.post(
                            'page-index',
                            { },
                        function (data)
                            { }
                        ); 
                    } 
                });
        };  
</script>
