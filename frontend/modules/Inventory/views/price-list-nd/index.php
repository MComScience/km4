<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\SweetAlertAsset;
use frontend\assets\DataTableAsset;
use frontend\assets\SummerNoteAsset;
WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
SweetAlertAsset::register($this);
DataTableAsset::register($this);
SummerNoteAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\models\VwQuPricelistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pricelists';
$this->params['breadcrumbs'][] = $this->title;
$script = <<< JS
$(document).ready(function () {
        $('#tab_A').addClass("active");

        //Config Summernote
    $('.summernote').summernote({
        height: 150, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: true,
         /* toolbar: [
                ['headline', ['style']],
                ['style', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
                ['textsize', ['fontsize']],
                ['alignment', ['ul', 'ol', 'paragraph', 'lineheight']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']],
            ['misc', ['print']]
        ], */
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear','style']],
            ['font', ['strikethrough', 'superscript', 'subscript',]],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']],
            ['misc', ['print']],
            ['height', ['height']]
        ],
        hint: {
            words: ['apple', 'orange', 'watermelon', 'lemon'],
            match: /\b(\w{1,})$/,
            search: function (keyword, callback) {
                callback($.grep(this.words, function (item) {
                    return item.indexOf(keyword) === 0;
                }));
            }
        },
    });
});
JS;
$this->registerJs($script);
?>  
<div class="tabbable">
    <?php echo $this->render('_tab_menu'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            <div class="vw-qu-pricelist-index">
                <?php Pjax::begin([ 'timeout' => 5000,'id' => 'price_list_nd']) ?>
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
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
                    'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                    'columns' => [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'contentOptions' => ['class' => 'kartik-sheet-style'],
                            'width' => '36px',
                            'header' => 'ลำดับ',
                            'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:#000000;']
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'options' => ['style' => 'width:80px;'],
                            'header' => 'ผู้ขาย',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->VenderName == null) {
                                    return '-';
                                } else {
                                    return $model->VenderName;
                                }
                            }
                        ],   
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'รหัสสินค้า',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->TMTID_TPU == null) {
                                    return '-';
                                } else {
                                    return $model->TMTID_TPU;
                                }
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'รายละเอียดสินค้า',
                            //'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                        if ($model->ItemName == null) {
                            return '-';
                        } else {
                            return $model->ItemName;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'จำนวน',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                        if ($model->QUQty == null) {
                            return '-';
                        } else {
                            return $model->QUQty;
                        }
                    }
                        ],
                        [
                           'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'หน่วย',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                        if ($model->QUUnit == null) {
                            return '-';
                        } else {
                            return $model->QUUnit;
                        }
                    }
                        ],
                        [
                           'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ราคา/หน่วย',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                if ($model->QUUnitCost2 == null) {
                                    return '-';
                                } else {
                                    return $model->QUUnitCost2;
                                }
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'เป็นเงิน',
                            'format'=>['decimal',4],
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                if ($model->QUQty == null) {
                                    return '-';
                                } else {
                                    $unit = $model->QUQty;
                                    $cost = $model->QUUnitCost2;
                                    $sum = $unit*$cost;
                                    return $sum;
                                }
                            }
                        ],        
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'QUMOQ',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                if ($model->QUMQO == null) {
                                    return '-';
                                } else {
                                    return $model->QUMQO;
                                }
                            }
                        ],        
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ส่งสินค้า(วัน)',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                if ($model->QULeadtime == null) {
                                    return '-';
                                } else {
                                    return $model->QULeadtime;
                                }
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ยืนราคาถึงวันที่',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->QUValidDate == null) {
                                    return '-';
                                } else {
                                    return $model->QUValidDate;
                                }
                            }
                        ],
                        // [
                        //     'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                        //     'header' => 'สถานะ',
                        //     //'format' => ['date', 'php:d/m/Y'],
                        //     'hAlign' => GridView::ALIGN_CENTER,
                        //     'value' => function ($model) {
                        //         if ($model->Itemstatus == null) {
                        //             return '-';
                        //         } else {
                        //             return $model->Itemstatus;
                        //         }
                        //     }
                        // ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ผู้จัดจำหน่าย',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->DistributorName == null) {
                                    return '-';
                                } else {
                                    return $model->DistributorName;
                                }
                            }
                        ],
                        // [
                        //     'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                        //     'header' => 'Price_change',
                        //     //'format' => ['date', 'php:d/m/Y'],
                        //     'hAlign' => GridView::ALIGN_CENTER,
                        //     'value' => function ($model) {
                        //         if ($model->Price_change == null) {
                        //             return '-';
                        //         } else {
                        //             return $model->Price_change;
                        //         }
                        //     }
                        // ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => 'Actions',
                            'noWrap' => true,
                            'hAlign' => GridView::ALIGN_CENTER,
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'template' => '{view} {active} {mail} {print}',
                            'buttons' => [
                                'mail' => function ($url, $model) {
                                            return Html::a('<i class="fa fa-envelope-o"></i>Mail', 'javascript:void(0);', [
                                                        'class' => 'btn btn-default btn-xs',
                                                        'onclick' => 'ShowformMailPricelist(this);',
                                                        'id' => $model->VenderName,
                                                        'data-id' => $model->VenderName .'  '.'(<a href="mailto:'.$model->VenderEmail.'" >'. $model->VenderEmail.'</a>)',
                                                        'data-toggle' => $model->VenderEmail,
                                                        'data-toggle1' => $model->ItemName,
                                            ]);
                                        },
                                'view' => function ($url, $model, $key) {
                                    return Html::a('<span class="btn btn-success btn-xs">Detail</span>', '#', [
                                                'class' => 'activity-detail-link',
                                                'title' => 'ดูรายละเอียด',
                                                'data-toggle' => 'modal',
                                                'data-id' => $key,
                                                'data-pjax' => '0',
                                    ]);
                                },
                                    'active' => function ($url, $model, $key) {
                                    if($model->QUItemNumStatusID == 2){
                                        return Html::a('<span class="btn btn-warning btn-xs">Discontinus</span>', '#', [
                                                'class' => 'activity-active-link',
                                                'title' => 'Discontinus',
                                                'data-toggle' => 'modal',
                                                'data-id' => $key,
                                                'data-pjax' => '0',
                                    ]);
                                    }else{
                                        return Html::a('<span class="btn btn-default btn-xs">UnDiscontinus</span>', '#', [
                                                'class' => 'activity-not-active-link',
                                                'title' => 'UnDiscontinus',
                                                'data-toggle' => 'modal',
                                                'data-id' => $key,
                                                'data-pjax' => '0',
                                    ]);
                                    }
                                    
                                },
                                    'print'=> function ($url, $model, $key) {
                                        return Html::a('<span class="btn btn-info btn-xs">Print</span>', '#', [
                                                'title' => 'Discontinus',
                                                'data-toggle' => 'modal',
                                                'onclick' => "print($key);",
                                                'data-pjax' => '0',
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
        <div class="form-group" style="text-align: right">
                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Purchasing/dashboard/index" class="btn btn-default">Close</a>
        </div>
    </div>   
</div>
<?php
        \yii\bootstrap\Modal::begin([
            'id' => 'getdatatpumodal',
            'header' => '<h4 class="modal-title">เลือกยาการค้า</h4>',
            'size' => 'modal-lg modal-primary',
        ]);
        ?>
        <div id="datatpu"></div>
        <?php \yii\bootstrap\Modal::end(); ?>
        <?php
        \yii\bootstrap\Modal::begin([
            'id' => 'inputtpu',
            'header' => '<h4 class="modal-title">เลือกยาการค้า</h4>',
            'size' => 'modal-xs modal-primary',
        ]);
        ?>
        <div id="datatpu"></div>
        <?php \yii\bootstrap\Modal::end(); ?>
        <?php
        \yii\bootstrap\Modal::begin([
            'id' => 'tpu-modal',
            'header' => '<h4 class="modal-title">รายละเอียดสินค้า</h4>',
            'size' => 'modal-lg modal-primary',
        ]);
        ?>
        <div id="data"></div>
        <?php \yii\bootstrap\Modal::end();
?>

<!-- Mail -->
        <?php
        \yii\bootstrap\Modal::begin([
            'id' => 'pricelistmail',
            'header' => '<h4 class="modal-title"><i class="fa fa-envelope-o"></i> ส่ง E-mail ถึงผู้จำหน่ายสินค้า</h4>',
            //'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
            'size' => 'modal-lg modal-primary',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                // 'closeButton' => false,
        ]);
        ?>
        <?php echo $this->render('_form_mail'); ?>
        <?php \yii\bootstrap\Modal::end(); ?>

<?php
$script = <<< JS
//-------------------------------------------START Edit and Delete form----------------------------    
function init_click_handlers() {
    $('.activity-detail-link').click(function (e) {
       var current_effect = 'ios'; 
                run_waitMe(current_effect);
                function run_waitMe(effect){
                    $('#price_list_nd').waitMe({
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
        var fID = $(this).closest('tr').data('key');
        $.ajax({
                url: 'edit',
                        type: 'POST',
                        data: {ids_qu:fID},
                        success: function (data) {
                        $('#price_list_nd').waitMe('hide'); 
                        if (data == 'itemalready') {
                            Notify('รายการนี้ถูกบันทึกแล้ว!', 'top-right', '2000', 'danger', 'fa-exclamation-circle', true);
                        }else if(data == 'itememty') {
                            Notify('รหัสยาการค้าไม่ถูกต้อง!', 'top-right', '2000', 'warning', 'fa-exclamation-triangle', true);
                        } else {
                        $('#formpricelisttpu').trigger("reset");
                        $('#tpu-modal').find('.modal-body').html(data);
                        $('#data').html(data);
                        $('.modal-title').html('รายละเอียดสินค้า');
                        $('#tpu-modal').modal('show');
                        }
                        }
        });
    });
    $('.activity-active-link').click(function (e) {
                var current_effect = 'ios'; 
                run_waitMe(current_effect);
                function run_waitMe(effect){
                    $('#price_list_nd').waitMe({
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
        var fID = $(this).closest('tr').data('key');
        swal({   
            title: "Are you sure?",   
            //text: "You will not be able to recover this imaginary file!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#53a93f",   
            confirmButtonText: "OK",   
            closeOnConfirm: false
        },function(){
                $.ajax({
                url: 'active',
                        type: 'POST',
                        data: {ids_qu:fID},
                        success: function (data) {
                        $('#price_list_nd').waitMe('hide'); 
                            if (data == 'updatesuccess') {
                                swal("Success","", "success"); 
                                $.pjax.reload({container: '#price_list_nd'}); 
                            }
                        }
                });
            });
            $('#price_list_nd').waitMe('hide');
    });
    $('.activity-not-active-link').click(function (e) {
                var current_effect = 'ios'; 
                run_waitMe(current_effect);
                function run_waitMe(effect){
                    $('#price_list_nd').waitMe({
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
        var fID = $(this).closest('tr').data('key');
        swal({   
            title: "Are you sure?",   
            //text: "You will not be able to recover this imaginary file!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#53a93f",   
            confirmButtonText: "OK",   
            closeOnConfirm: false
        },function(){
            $.ajax({
                    url: 'not-active',
                            type: 'POST',
                            data: {ids_qu:fID},
                            success: function (data) {
                            $('#price_list_nd').waitMe('hide'); 
                                if (data == 'updatesuccess') {
                                    swal("Success","", "success"); 
                                    $.pjax.reload({container: '#price_list_nd'}); 
                                }
                            }
            });
        });
        $('#price_list_nd').waitMe('hide');
    });
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        bootbox.confirm('Are you sure?', function (result) {
            if (result) {
                //Delete
                $.post(
                        'delete-detail',
                        {
                            id: fID
                        },
                function (data)
                {
                   $.pjax.reload({container: '#price_list_nd'});
                }
                );
            }
        });
    });    
    }
    
    init_click_handlers(); //first run
    $('#price_list_nd').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    });    
//--------------------------------------END Edit and Delete form------------------------------------- 
JS;
        $this->registerJs($script);
       ?>
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

<script type="text/javascript">
    function run_waitMe(effect) {
        $('.modal-body').waitMe({
            effect: 'progressBar',
            text: 'Sending...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#53a93f',
            onClose: function () {
            }
        });
    }

    function ShowformMailPricelist(e) {
        $('#pricelistmail').modal('show');
        $('#form_vendormail').trigger("reset");
        $('.summernote').summernote('reset');
        var name = (e.getAttribute("id"));
        var setto = (e.getAttribute("data-id"));
        var email = (e.getAttribute("data-toggle"));
        var itemname = (e.getAttribute("data-toggle1"));
        $('#name_email').html(setto);
        $('#VendorEmail').val(email);
        $('#VendorName').val(name);
        $('#Subject').val('ขอยืนยันการเสนอราคา '+ ' ' + itemname);
    }

    function SendmailtoVendor() {
        var makrup = $('.summernote').summernote('code');
        var subject = $("#Subject").val();
        var mail = $("#VendorEmail").val();
        var name = $("#VendorName").val();
        var ccmail = $("#CCMail").val();
        run_waitMe();
        $.post(
                'index.php?r=Inventory/price-list/sendmail-to-vendor',
                {
                    subject: subject, makrup: makrup, mail: mail, name: name, ccmail: ccmail
                },
                function (data)
                {
                    $('.modal-body').waitMe('hide');
                    swal({
                        title: "",
                        text: "ส่งสำเร็จ!",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    $('#form_vendormail').trigger("reset");
                                    $('#pricelistmail').modal('hide');
                                }
                            });
                }
        ).fail(function ()
        {
            console.log('server error');
            $('.modal-body').waitMe('hide');
            swal("OOPS !", "เกิดข้อผิดพลาดในการส่ง :)", "error");
        });
    }
    function print($key){
        alert($key);
    }
</script>