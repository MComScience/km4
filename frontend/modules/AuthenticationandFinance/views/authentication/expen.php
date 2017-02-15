<?php
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\bootstrap\Html;
?>
<div class="row">
    <div class="col-md-2">
        <div class="col-lg-2 col-md-4 col-sm-12 text-center">
            <img src="<?php echo  $service->pt_picture_path != null ? $service->pt_picture_path:'assets/img/avatars/admin.png' ?>" alt="" class="header-avatar" width="100" height="100"/>
        </div>
    </div>
    <div class="col-md-10">
       <?php yii\widgets\Pjax::begin(['id' => 'grid_pjax_rightdetail', 'timeout' => 5000]) ?>
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
        'header' => '',
        'attribute' => 'pt_ar_id',
        'headerOptions' => ['style' => 'display:none'],
        'contentOptions' => ['style' => 'display:none'],
        ],
        [
        'header' => '<font color="black">ลำดับสิทธิ</font>',
        'attribute' => 'pt_ar_seq',
        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
        'value'=>function($model, $key, $index, $column){
            if(!empty($model->pt_ar_seq)){
                return  $model->pt_ar_seq;
            }else{
                return  '-';
            }
        }
        ],
        [
        'header' => '<font color="black">สิทธิการรักษา</font>',
        'attribute' => 'medical_right_group',
        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
        'value'=>function($model, $key, $index, $column){
            if(!empty($model->medical_right_group)){
                return  $model->medical_right_group;
            }else{
                return  '-';
            }
        }
        ],
        [
        'header' => '<font color="black">ชื่อหน่วยงาน(ลูกหนี้)</font>',
        'attribute' => 'ar_name',
        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
        'value'=>function($model, $key, $index, $column){
            if(!empty($model->ar_name)){
                return  $model->ar_name;
            }else{
                return  '-';
            }
        }
        ],
        [
        'header' => '<font color="black">ใช้สิทธิ</font>',
        'attribute' => 'pt_ar_usage',
        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
        'value'=>function($model, $key, $index, $column){
            if(!empty($model->pt_ar_usage)){
                return  $model->pt_ar_usage;
            }else{
                return  '-';
            }
        }
        ],
        [
        'header' => '<font color="black">เลขที่ใบส่งตัว</font>',
        'attribute' => 'refer_hsender_doc_id',
        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
        'value'=>function($model, $key, $index, $column){
            if(!empty($model->refer_hsender_doc_id)){
                return  $model->refer_hsender_doc_id;
            }else{
                return  '-';
            }
        }
        ], 
        [
        'header' => '<font color="black">วันเริ่มใบส่งตัว</font>',
        'attribute' => 'refer_hsender_doc_start',
        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
        'value'=>function($model){
            if($model->refer_hsender_doc_start != null){
              return  Yii::$app->formatter->asDate($model->refer_hsender_doc_start,'php:d/m/Y');

          }else{
            return  '-';
        }
    }
    ], 
    [
    'header' => '<font color="black">วันสิ้นสุดใบส่งตัว</font>',
    'attribute' => 'refer_hsender_doc_expdate',
    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
    'value'=>function($model){
        if($model->refer_hsender_doc_expdate != null){
          return  Yii::$app->formatter->asDate($model->refer_hsender_doc_expdate,'php:d/m/Y');

      }else{
        return  '-';
    }

}

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
<?php yii\widgets\Pjax::end() ?>        
</div>
</div>
<?php
$s = <<< JS

function init_click_handlers() {
    $('.activity-view-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        var id = $(this).closest('tr').children('td:eq(1)').text();
        $.get(
        'index.php?r=AuthenticationandFinance/authentication/edit-right-patian',
        {
            vn: fID,id:id
        },
        function (data)
        {
           $('#detail_edit_right_patian').html(data);
           $('#modal_edit_right_patian').modal('show');  
       }
       );
   });
   $('.activity-update-link').click(function (e) {
       var fID = $(this).closest('tr').data('key'); 
       var id = $(this).closest('tr').children('td:eq(1)').text();
       $.get(
       'index.php?r=AuthenticationandFinance/authentication/edit-right-patian',
       {
        vn: fID,id:id
    },
    function (data)
    {
     $('#detail_view_patain').html(data);
     $('#modal_view_right_patian').modal('show');   
 }
 );
});
$('.activity-delete-link').click(function (e) {
    var fID = $(this).closest('tr').data('key');
    var hn = $(this).closest('tr').children('td:eq(3)').text();
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
        $.get(
        'index.php?r=AuthenticationandFinance/authentication/delete-patian-all',
        {
            id: fID,
            hn:hn
        },
        function (data)
        {
            $.pjax.reload({container: '#grid_pjax_rightdetail'});
        }
        );
    }
});
});
}
init_click_handlers(); //first run
$('#grid_pjax_rightdetail').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
$this->registerJs($s);
?>

<?php
Modal::begin([
    'id' => 'modal_edit_right_patian',
    'header' => '<h4 class="modal-title">ปรับปรุงเงื่อนไขการใช้งานสิทธิ์</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE
    ]);
    ?>
    <div id="detail_edit_right_patian">
    </div>
    <?php Modal::end(); ?>
