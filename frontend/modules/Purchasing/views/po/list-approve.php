<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$this->title = 'ใบสั่งซื้อผ่านการอนุมัติ';
$this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'สั่งซื้อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
        $('#tab_G').addClass("active");
        $("#formmail").bootstrapValidator();
    });
$(document).ready(function () {
    
    $('#summernote').summernote({
        height: 150, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: true,
         toolbar: [
                ['headline', ['style']],
                ['style', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
                ['textsize', ['fontsize']],
                ['alignment', ['ul', 'ol', 'paragraph', 'lineheight']],
                ['view', ['fullscreen', 'codeview', 'help']],
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
                            
var edit = function () {
    $('#summernote').summernote({
        height: 100, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: true,
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
        ],
        hint: {
            words: ['apple', 'orange', 'watermelon', 'lemon'],
            match: /\b(\w{1,})$/,
            search: function (keyword, callback) {
                callback($.grep(this.words, function (item) {
                    return item.indexOf(keyword) === 0;
                }));
            }
        }
    });
};

        
function init_click_handlers() {
    $('.activity-mail-link').click(function (e) {
        $('#modalsendmail').modal('show');
        $('#formmail').trigger("reset");
        $('#summernote').summernote('reset');
        var fID = $(this).closest('tr').data('key');
        $.ajax({
            url: 'index.php?r=Purchasing/po/getdetailpotomail',
            type: 'POST',
            data: {id: fID},
            //data: $('#SaveToGeneric').serialize(),
            dataType: 'json',
            success: function (data) {
                $('#POID').val(fID);
                $('#PONum').val(data.PONum);
                $('#VendorID').val(data.VendorID);
                $('#VendorName').val(data.VenderName);
                $('#PODate').val(data.PODate);
                $('#Subject').val(data.Subject);
                $('#Email').val(data.VenderEmail);
            }
        });
    });
}
init_click_handlers(); //first run
$('#list-approve').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <?php echo $this->render('_tab_menu'); ?>
            <div class="tab-content">
                <div id="tab" class="tab-pane in active ">
                    <div class="tb-po2-temp-index">
                        <?php Pjax::begin([ 'timeout' => 5000, 'id' => 'list-approve']) ?>
                        <?php echo $this->render('_search', ['model' => $searchModel, 'action' => 'list-approve']); ?>
                        <p></p>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'bootstrap' => true,
                            'responsiveWrap' => FALSE,
                            'responsive' => true,
                            'hover' => true,
                            //'pjax' => true,
                            'striped' => false,
                            'condensed' => true,
                            'toggleData' => false,
                            'layout' => $layout,
                            'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'width' => '36px',
                                    'header' => '#',
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;']
                                ],
                                [
                                    'header' => 'เลขที่ใบสั่งซื้อ',
                                    'attribute' => 'PONum',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => 'วันที่',
                                    'attribute' => 'PODate',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'format' => ['date', 'php:d/m/Y'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => 'ประเภทใบขอซื้อ',
                                    'attribute' => 'PRTypeID',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'value' => 'prtype.PRType',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => 'ประเภทการสั่งซื้อ',
                                    'attribute' => 'POTypeID',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'value' => 'potype.POType',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => 'กำหนดการส่งมอบ',
                                    'attribute' => 'PODueDate',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'format' => ['date', 'php:d/m/Y'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => 'สถานะใบสั่งซื้อ',
                                    'attribute' => 'POStatus',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'value' => 'postatus.POStatusDes',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'noWrap' => true,
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'template' => '{view} {print} {po} {mail}',
                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                    'buttons' => [
                                        'mail' => function ($url, $model) {
                                            return Html::a('<span class="btn btn-default btn-xs"><i class="fa fa-envelope-o"></i>Mail</span> ', '#', [
                                                        //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                        'title' => 'Send E-Mail',
                                                        'data-toggle' => 'modal',
                                                        'class' => 'activity-mail-link',
                                            ]);
                                        },
                                                'print' => function ($url, $model, $key) {
                                            $url = 'http://www.udcancer.org/km4/frontend/web/report/poreport.php?id='.$key.'&en=Anjkmaloodd4214';
                                            return Html::a('<span class="btn btn-info btn-xs btn-group"> Print </span>', $url, [
                                                        'title' => 'print',
                                                        'target' => '_blank',
                                                        'data-pjax' => 0
                                            ]);
                                        },
                                                'po' => function ($url, $model, $key) {
                                            $url = 'http://www.udcancer.org/km4/frontend/web/report/poreport2.php?id='.$key.'&en=Anjkmaloodd4214';
                                            return Html::a('<span class="btn btn-info btn-xs btn-group"> Print ยาบริจาค</span>', $url, [
                                                        'title' => 'print บริจาค',
                                                        'target' => '_blank',
                                                        'data-pjax' => 0
                                            ]);
                                        },
                                                //view button
                                                'view' => function ($url, $model) {
                                            return Html::a('<span class="btn btn-success btn-xs btn-group"> Select </span>', $url, [
                                                        'title' => 'Selete',
                                                        'data-pjax' => 0,
                                            ]);
                                        },
                                            ],
                                            'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'view') {
                                            return Url::to(['update-detail-approve', 'id' => $key, 'view' => 'approve']);
                                        }
                                    }
                                        ],
                                    ],
                                ]);
                                ?>
                                <?php Pjax::end() ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="horizontal-space"></div>
            </div>
        </div>
        <?php
        \yii\bootstrap\Modal::begin([
            'id' => 'modalsendmail',
            'header' => '<h4 class="modal-title">ส่งใบสั่งซื้อผ่าน E-mail</h4>',
            //'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
            'size' => 'modal-lg modal-primary',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => false,
        ]);
        ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <form id="formmail" class="form-horizontal" role="form" method="post" data-bv-message="This value is not valid"
                      data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                      data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                      data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">เลขที่ใบสั่งซื้อ</label>
                        <div class="col-sm-3">
                            <input class="form-control" name="PONum" id="PONum" style="background-color: white" readonly=""/> 
                        </div>
                        <label class="col-sm-2 control-label no-padding-right">เลขที่ผู้จำหน่าย</label>
                        <div class="col-sm-3">
                            <input class="form-control" name="VendorID" id="VendorID" style="background-color: white" readonly=""/> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">วันที่</label>
                        <div class="col-sm-3">
                            <input class="form-control" name="PODate" id="PODate" style="background-color: white" readonly=""/> 
                        </div>
                        <label class="col-sm-2 control-label no-padding-right">ชื่อผู้จำหน่าย</label>
                        <div class="col-sm-3">
                            <input class="form-control" name="VendorName" id="VendorName" style="background-color: white" readonly=""/> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right"></label>
                        <div class="col-sm-3">
                            <input class="form-control" type="hidden" id="POID"/>
                        </div>
                        <label class="col-sm-2 control-label no-padding-right">E-mail ผู้รับ</label>
                        <div class="col-sm-3">
                            <input required="" data-bv-emailaddress-message="The input is not a valid email address" class="form-control" name="Email" id="Email" style="background-color: #ffff99" type="email"/> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">ชื่อเรื่อง</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="Subject" id="Subject" style="background-color: #ffff99"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">ข้อความ</label>
                        <div class="col-sm-8">
                            <div id="summernote"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10" style="text-align: right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button id="clear3" class="btn btn-danger" onclick="Clearnote(this);" type="button">Clear</button>
                            <!--            <button id="edit" class="btn btn-info" onclick="edit()" type="button">Edit</button>-->
                            <a id="save" class="btn btn-primary ladda-button" onclick="send(this);" type="button" data-style="expand-left">Send</a>
                        </div>
                    </div>
                </form>   
            </div>
        </div>
        <?php \yii\bootstrap\Modal::end(); ?>
<script>
    function send() {
        var id = $("#POID").val();
        var mail = $("#Email").val();
        if (mail == '') {
            swal("กรุณากรอก E-mail!", "", "warning");
        } else {
            var l = $('.ladda-button').ladda();
            l.ladda('start');
            run_waitMe();
            $.get(
                    'http://www.udcancer.org/km4/frontend/web/report/mail_po_pdf.php?id=' + id + '&en=Anjkmaloodd4214',
                    {
                    },
                    function ()
                    {
                        Sendmail(l,id);

                    }
            );
        }
    }

    function Sendmail(l,id) {
        var makrup = $('#summernote').summernote('code');
        var subject = $("#Subject").val();
        var mail = $("#Email").val();
        var name = $("#VendorName").val();
        $.post(
                'index.php?r=Purchasing/po/sending',
                {
                    subject: subject, makrup: makrup, mail: mail, name: name,id:id
                },
        function ()
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
                            l.ladda('stop');
                            $('#formmail').trigger("reset");
                            $('#modalsendmail').modal('hide');
                        }
                    });
        }
        ).fail(function ()
        {
            console.log('server error');
            $('.modal-body').waitMe('hide');
            l.ladda('stop');
            swal("OOPS !", "เกิดข้อผิดพลาดในการส่ง :)", "error");
        })
    }

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

    function Clearnote() {
        $('#summernote').summernote('reset');
    }
</script>


<?php 
$this->registerJsFile(Yii::getAlias('@web') . '/vendor/js/validation/bootstrapValidator.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>