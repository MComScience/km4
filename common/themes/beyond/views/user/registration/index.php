<?php

use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use fedemotta\datatables\DataTables;
use frontend\assets\SweetAlertAsset;
use frontend\assets\WaitMeAsset;
SweetAlertAsset::register($this);
WaitMeAsset::register($this);

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$this->title = Yii::t('app', 'รายชื่อผู้ขาย Vendor List');
$this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'จัดการข้อมูลผู้ขาย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs"  id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        รายชื่อผู้ขาย Vendor List
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#import">
                        <h3 class="panel-title"><i class="glyphicon glyphicon-import"></i> การนำเข้าข้อมูลผู้ขาย</h3>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane in active">

                    <?php Pjax::begin(['timeout' => 5000, 'id' => 'Vendorliist']) ?>
                    <?php // $this->render('_search', ['model' => $searchModel]); ?>
                    <?=
                    DataTables::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' => [
                            'class' => 'kv-grid-table table table-hover table-striped kv-table-wrap',
                        ],
                        'options' => [
                            'retrieve' => true
                        ],
                        'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                        'clientOptions' => [
                            'bSortable' => false,
                            'bAutoWidth' => true,
                            'ordering' => false,
                            'pageLength' => 10,
                            //'bFilter' => false,
                            'language' => [
                                'info' => 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
                                'lengthMenu' => '_MENU_',
                                'sSearchPlaceholder' => 'ค้นหาข้อมูล...',
                                'search' => '_INPUT_ <a class="btn btn-success" href="/km4/user/registration/register" data-pjax="0"><i class="fa fa-user-plus"></i> บันทึกข้อมูลผู้ขาย</a>'
                            ],
                            "lengthMenu" => [[10, -1], [10, "All"]],
                            "responsive" => true,
                            "dom" => '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                        ],
                        'columns' => [
                                [
                                'class' => 'yii\grid\SerialColumn',
                                'contentOptions' => ['class' => 'text-center'],
                                'headerOptions' => ['style' => 'text-align:center;color:black;width: 25px'],
                            ],
                                [
                                'header' => 'เลขประจำตัวผู้เสียภาษี',
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                'attribute' => 'VenderTaxID',
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                                [
                                'header' => 'ชื่อผู้ขาย',
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                'attribute' => 'VenderName',
                            ],
                                [
                                'header' => 'อีเมลล์',
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                'attribute' => 'VenderEmail',
                                'format' => 'email',
                            ],
                                [
                                'header' => Yii::t('user', 'Confirmation'),
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    if ($model->user->isConfirmed) {
                                        return '<div class="text-center"><span class="text-success">' . Yii::t('user', 'Confirmed') . '</span></div>';
                                    } else {
                                        return Html::a(Yii::t('user', 'Confirm'), ['confirm-users', 'id' => $model->user_id], [
                                                    'class' => 'btn btn-xs btn-success btn-block',
                                                    'data-method' => 'post',
                                                    'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                                        ]);
                                    }
                                },
                                'format' => 'raw',
                                'visible' => Yii::$app->getModule('user')->enableConfirmation,
                            ],
                                [
                                'header' => 'ระดับผู้ขาย',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'VenderRating',
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return empty($model->VenderRating) ? '' : $model->VenderRating;
                                }
                            ],
                                [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Actions',
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{today_action} {block} {today_action1}',
                                'buttonOptions' => ['class' => 'btn btn-default'],
                                'buttons' => [
                                    'block' => function ($url, $model, $key) {
                                        if ($model->user->isBlocked && $model->user->profile->UserCatID == 2) {
                                            return Html::a('<span class="btn btn-xs btn-success"> UnBlock </span>', '#', [
                                                        'title' => 'Un Block',
                                                        'class' => 'activity-unblock-vendor',
                                                        'data-toggle' => 'modal',
                                                        'data-id' => $key,
                                                        'data-pjax' => '0',
                                            ]);

                                            /* return Html::a('UnBlock', ['blocksys', 'id' => $model->user_id], [
                                              'class' => 'btn btn-xs btn-success',
                                              'title' => 'Un Block',
                                              'data-method' => 'post',
                                              'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                                              ]); */
                                        } else {
                                            return Html::a('<span class="btn btn-xs btn-danger"> Block </span>', '#', [
                                                        'title' => 'Block',
                                                        'class' => 'activity-block-vendor',
                                                        'data-toggle' => 'modal',
                                                        'data-id' => $key,
                                                        'data-pjax' => '0',
                                            ]);
                                            /* return Html::a('Block', ['blocksys', 'id' => $model->user_id], [
                                              'class' => 'btn btn-xs btn-danger',
                                              'title' => 'Block',
                                              'data-method' => 'post',
                                              'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
                                              ]); */
                                        }
                                    },
                                    'today_action' => function ($url, $model) {
                                        return Html::a('Edit', $url, [
                                                    'title' => 'Edit',
                                                    'class' => 'btn btn-primary btn-xs',
                                                    'data-pjax' => '0',
                                        ]);
                                    },
                                    'today_action1' => function ($url, $model, $key) {
                                        return Html::a('<span class="btn btn-danger btn-xs btn-group"> Delete </span>', '#', [
                                                    'title' => Yii::t('app', 'Delete'),
                                                    'class' => 'activity-view-delete',
                                                    'data-toggle' => 'modal',
                                                    'data-id' => $key,
                                                    'data-pjax' => '0',
                                        ]);
                                    },
                                ],
                                'urlCreator' => function ($action, $model, $key, $index) {
                                    if ($action === 'today_action') {
                                        return Url::to(['/user/admin/update-profile/', 'id' => $model->user_id]);
                                    } else if ($action === 'today_action1') {
                                        return Url::to(['/user/admin/delete-vender/', 'id' => $model->user_id]);
                                    }
                                },
                            ],
                        ],
                    ]);
                    ?>
                    <?php Pjax::end() ?>
                    <br/>
                    <br/>
                </div>
                <div id="import" class="tab-pane">
                    <?= $this->render('_import', ['fkey' => $fkey, 'sum' => $sum,]); ?>
                    <p style="padding-top: 10px;">
                        <span class="label label-primary">Notice</span>
                        <code>Default Username = เลขประจำตัวผู้เสียภาษี,Default Password = เลขประจำตัวผู้เสียภาษี</code> ผู้ใช้สามารถแก้ไขรหัสผ่าน และอีเมล์เองได้ในภายหลัง
                        <button id="Download" type="button" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-download"></i> ดาวโหลดแบบฟอร์ม</button>
                    </p>
                </div>
                <div class="form-group" style="text-align: right">
                    <?= Html::a('Close',['/'],['class' => 'btn btn-default']) ?>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>

<?php
Modal::begin([
    'id' => 'sumalert',
    'header' => '<h4 class="modal-title">ผลการนำเข้า</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => false,
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
]);
?>
<?php if (!empty($sum)): ?>
    <div class="row" style="font-size: 18px;">
        <div class="col-md-6 col-md-offset-3">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>นำเข้าสำเร็จ</th>
                        <td style="text-align: right;"><code><?= number_format($sum['tsum']) ?></code></td>
                    </tr>
                    <tr>
                        <th>นำเข้าไม่ได้</th>
                        <td style="text-align: right;"><code><?= number_format($sum['fsum']) ?></code></td>
                    </tr>
                    <tr>
                        <th>ชื่อที่ซ้ำ</th>
                        <td style="text-align: right;"><code><?= number_format($sum['ksum']) ?></code></td>
                    </tr>
                    <tr>
                        <th>ทั้งหมด</th>
                        <td style="text-align: right;"><code><?= number_format($sum['all']) ?></code></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (!empty($fkey)): ?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                ชื่อที่ซ้ำมีดังนี้ <code><?= implode(', ', $fkey) ?></code>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php Modal::end(); ?>
<?php if (empty($sum)) { ?>
    <input id="sum" value="1" type="hidden"/>
<?php } else { ?>
    <input id="sum" value="0" type="hidden"/>
<?php } ?>

<?php
$script = <<< JS
function init_click_handlers() {
    $(".activity-view-delete").click(function (e) {
        var fID = $(this).closest("tr").data("key");
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirm!",
            closeOnConfirm: false,
            //closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                "/km4/user/admin/delete-vender",
                                {
                                    id: fID
                                },
                                function (data)
                                {
                                    $.pjax.reload({container: '#Vendorliist'});
                                    swal("Deleted!", "", "success");
                                }
                        );
                    }
                });
    });
    
    $(".activity-unblock-vendor").click(function (e) {
        var fID = $(this).closest("tr").data("key");
        swal({
            title: "Unblock this user?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Confirm!",
            //closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                "blocksys",
                                {
                                    id: fID
                                },
                                function (data)
                                {
                                    $.pjax.reload({container: '#Vendorliist'});
                                }
                        );
                    }
                });
    });
    
    $(".activity-block-vendor").click(function (e) {
        var fID = $(this).closest("tr").data("key");
        swal({
            title: "Block this user?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Confirm!",
            //closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                "blocksys",
                                {
                                    id: fID
                                },
                                function (data)
                                {
                                    $.pjax.reload({container: '#Vendorliist'});
                                }
                        );
                    }
                });
    });

}
init_click_handlers(); //first run
$("#Vendorliist").on("pjax:success", function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
$(document).ready(function () {
     var sum = $("#sum").val();
     if(sum == 0){
        $('#sumalert').modal('show');
        $('#sum').val('1');
     }
});
$('#Download').click(function (e) {
    window.open('/km4/uploads/vendor.xls','_blank');
});
$('#Import').click(function (e) {
    $('.page-content').waitMe({
        effect: 'progressBar',//roundBounce
        text: 'กำลังนำเข้าข้อมูล...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#53a93f',
        maxSize: '',
        source: 'img.svg',
        onClose: function () {
        }
    });
});
JS;
$this->registerJs($script, \yii\web\View::POS_END, 'index');
?>