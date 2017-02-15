<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\AuthenticationandFinance\models\VwArListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'บันทึกรายละเอียดต้นสิทธิ์(ลูกหนี้)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vw-ar-list-index">

    <div class="vwsr2listdraf-index">
        <ul class="nav nav-tabs " id="myTab5">
            <li class="active">
                <a data-toggle="tab" href="#home5">
                    <?= Html::encode($this->title) ?> 
                </a>
            </li>  
        </ul>
        <div class="well">

            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php Pjax::begin(['id' => 'grid_pjax']); ?>         
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
                'layout' => Yii::$app->componentdate->layoutgridview2(),
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
                        'header' => '<font color="black">รหัส</font>',
                        'attribute' => 'ar_id',
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                    ],
                    [
                        'header' => '<font color="black">ชื่อหน่วยงาน</font>',
                        'attribute' => 'ar_name',
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                    ],
                    [
                        'header' => '<font color="black">กลุ่มสิทธิ์</font>',
                        'attribute' => 'medical_right_group',
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                    ],
                    [
                        'header' => '<font color="black">ประเภทสิทธิ์</font>',
                        'attribute' => 'medical_right_desc',
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => '<font color="black">Actions</font>',
                        'options' => ['style' => 'width:160px;'],
                        'width' => '200px',
                        'template' => ' {view} {update} {delete}',
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', '#', [
                                            'title' => 'Detail',
                                            'data-toggle' => 'modal',
                                            'data-id' => $key,
                                            'class' => 'activity-view-link',
                                ]);
                            },
                                    'update' => function ($url, $model, $key) {
                                return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', '#', [
                                            'title' => 'Edit',
                                            'data-toggle' => 'modal',
                                            'data-id' => $key,
                                            'class' => 'activity-update-link',
                                ]);
                            },
                                    'delete' => function ($url, $model, $key) {
                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
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
                    <?php Pjax::end(); ?>
                </div>
            </div>
            <?php
            Modal::begin([
                'id' => 'modal_register_ar',
                'header' => '<h4 class="modal-title">บันทึกรายละเอียดต้นสิทธิ์(ลูกหนี้)</h4>',
                'size' => 'modal-lg modal-primary',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                'closeButton' => FALSE,
                    //'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
            ]);
            ?>
            <div id="detail_ar"></div>
            <?php
            Modal::end();
            
            $s = <<< JS

$('#createar').click(function (e) {
    $.ajax({
                    url: 'index.php?r=AuthenticationandFinance/ar/create',
                    type: 'get',
                    success: function (data) { 
                      $('#detail_ar').html(data); 
                    }
            });
    $('#modal_register_ar').modal({show: 'true'}); 
});

function init_click_handlers() {
    $('.activity-view-link').click(function (e) {
       $("#form_main").trigger('reset');
        var fID = $(this).closest('tr').data('key'); 
         run_waitMe(2);
        $.get(
                'index.php?r=AuthenticationandFinance/ar/view',
                {
                    id: fID
                },
        function (data)
        {
            $('#detail_ar').html(data);
            $('#modal_register_ar').modal('show');
             waitMe_hide(2);
            
        }
        );
    });
    $('.activity-update-link').click(function (e) {
                    $('#detail_ar_edit').html('');
       $("#form_editright").trigger('reset');
        var fID = $(this).closest('tr').data('key');
                    run_waitMe(2);
        $.get(
                'index.php?r=AuthenticationandFinance/ar/update',
                {
                    id: fID
                },
        function (data)
        {
            $('#detail_ar').html(data);
            $('#modal_register_ar').modal('show');
            waitMe_hide(2);
        }
        );
    });
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
     swal({
             title: message_confirmdelete,
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
              run_waitMe(2);      
                $.get(
                        'index.php?r=AuthenticationandFinance/ar/delete',
                        {
                            id: fID
                        },
                function (data)
                {
                    waitMe_hide(2);
                    $.pjax.reload({container: '#grid_pjax'});
                }
                );
            }
        });
    });
}
init_click_handlers(); //first run
$('#grid_pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
            $this->registerJs($s);
            ?>
    <script>
        function editright(id) {
            run_waitMe(2);
            $.get(
                    'index.php?r=AuthenticationandFinance/ar/editright',
                    {
                        id: id
                    },
            function (data)
            {
                $('#detail_ar').html(data);
                $('#modal_register_ar').modal('show');
                waitMe_hide(2);
            }
            );
        }
    function run_waitMe(type) {
        if (type == '1') {
            var idnaclass = '.modal-content';
        } else if (type == '2') {
            var idnaclass = '.main-container';
        }
        $(idnaclass).waitMe({
            effect: 'ios',
            text: 'Please wait...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            source: 'img.svg',
            onClose: function () {
            }
        });
    }
    function waitMe_hide(type) {
        if (type == '1') {
            $('.modal-content').removeClass('waitMe_container');
            $('.waitMe').html('');
        } else if (type == '2') {
            $('.main-container').removeClass('waitMe_container');
        }
    }
    </script>

