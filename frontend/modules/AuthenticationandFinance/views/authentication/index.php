<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\AuthenticationandFinance\models\VwPtRegistedListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'บันทึกสิทธิผู้ป่วย';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="vw-pt-registed-list-index">

    <div class="vwsr2listdraf-index">
        <ul class="nav nav-tabs " id="myTab5">
            <li class="active">
                <a data-toggle="tab" href="#home5">
                    <?= Html::encode($this->title) ?> 
                </a>
            </li>  
        </ul>
        <div class="well">
           <?php yii\widgets\Pjax::begin(['id' => 'grid_pjax', 'timeout' => 5000]) ?>
           <?php echo $this->render('_search', ['model' => $searchModel, 'action' => 'index']); ?>
           
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
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detailRowCssClass' => GridView::TYPE_DEFAULT,
            'detailUrl' => 'index.php?r=AuthenticationandFinance/authentication/expen',
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
            ],
            [
            'header' => '<font color="black">VN</font>',
            'attribute' => 'pt_visit_number',
            'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
            ],
            [
            'header' => '<font color="black">HN</font>',
            'attribute' => 'pt_hospital_number',
            'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
            ],
            [
            'header' => '<font color="black">AN</font>',
            'attribute' => 'pt_admission_number',
            'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
            'value' => function ($model) {
                if ($model->pt_admission_number == "") {
                    return '-';
                } else {
                    return $model->pt_admission_number;
                }
            }
            ],
            [
            'header' => '<font color="black">ชื่อ-นามสกุลผู้ป่วย</font>',
            'attribute' => 'pt_name',
            'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
            ],
            [
            'header' => '<font color="black">สถานะผู้ป่วย</font>',
            'attribute' => 'pt_status',
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
                return Html::a('<span class="btn btn-info btn-xs"> Detail </span>', '#', [
                    'title' => 'Detail',
                    'data-toggle' => 'modal',
                    'data-id' => $key,
                    'class' => 'activity-view-link',
                    ]);
            },
            'update' => function ($url, $model, $key) {
                return Html::a('<span class="btn btn-success btn-xs"> Edit </span>', '#', [
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
</div>
<?php
Modal::begin([
    'id' => 'modal_view_right_patian',
    'header' => '<h4 class="modal-title">รายละเอียดสิทธิ</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
                //'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
    ]);
    ?>
    <div id="detail_view_patain"></div>
    <?php Modal::end(); ?>
    <?php
    $s = <<< JS

    function init_click_handlers() {
        $('.activity-view-link').click(function (e) {
            var fID = $(this).closest('tr').data('key'); 
            waitMe_Running_show(2);
            $.get(
            'index.php?r=AuthenticationandFinance/authentication/view',
            {
                id: fID
            },
            function (data)
            {
                $('#detail_view_patain').html(data);
                $('#modal_view_right_patian').modal('show'); 
                 waitMe_Running_hide(2);  

            }
            );
        });
        $('.activity-update-link').click(function (e) {
            var fID = $(this).closest('tr').data('key'); 
             waitMe_Running_show(2);
            $.get(
            'index.php?r=AuthenticationandFinance/authentication/update',
            {
                id: fID
            },
            function (data)
            {
               $('#detail_view_patain').html(data);
               $('#modal_view_right_patian').modal('show');  
                waitMe_Running_hide(2);   
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



