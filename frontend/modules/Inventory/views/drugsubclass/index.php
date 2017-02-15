<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\models\TbDrugsubclassSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการหมวดยาย่อย';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-drugsubclass-index">
    
    <div class="vwsr2listdraf-index">
    <ul class="nav nav-tabs " id="myTab5">
    <li class="active">
        <a data-toggle="tab" href="#home5">
            <?= Html::encode($this->title) ?> 
        </a>
    </li>  
</ul>
    <div class="well">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
     <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
    <?= GridView::widget([
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
              'filterModel' => $searchModel,
        'columns' => [
              [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions' => ['class' => 'kartik-sheet-style'],
                'width' => '36px',
                'header' => '<font color="black">#</font>',
                'headerOptions' => ['class' => 'kartik-sheet-style']
                ],
 [
                                        'header' => '<font color="black">รหัสหมวดยาย่อย</font>',
                                        'attribute' => 'DrugSubClassID',
                                        'hAlign' => GridView::ALIGN_LEFT,
                                         'filter' => false,
                                        'value' => function ($model) {
                                    if ($model->DrugSubClassID == NULL) {
                                        return '-';
                                    } else {
                                        return $model->DrugSubClassID;
                                    }
                                }
                                    ],
                                     [
                                        'header' => '<font color="black">ชื่อหมวดยาย่อย</font>',
                                        'attribute' => 'DrugSubClass',
                                        'hAlign' => GridView::ALIGN_LEFT,
                                         'filter' => false,
                                        'value' => function ($model) {
                                    if ($model->DrugSubClass == NULL) {
                                        return '-';
                                    } else {
                                        return $model->DrugSubClass;
                                    }
                                }
                                    ],
                                     [
                                        'header' => '<font color="black">ชื่อหมวดยาหลัก</font>',
                                        'attribute' => 'DrugClassID',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                         'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\app\modules\Inventory\models\TbDrugclass::find()->all(), 'DrugClassID', 'DrugClass'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'เลือกหมวดหลัก'],
                                        'value' => function ($model) {
                                    if ($model->DrugClassID == NULL) {
                                        return '-';
                                    } else {
                                        return $model->supilesub->DrugClass;
                                    }
                                }
                                    ],
          //  'DrugSubClassID',
          //  'DrugClassID',
          //  'DrugSubClass',
           // 'DrugSubClassDesc',

            [
              'class' => 'kartik\grid\ActionColumn',
              'header' => '<font color="black">Actions</font>',
             // 'options' => ['style' => 'width:150px;'],
              'width' => '20%',
              'template' => ' {view} {update} {delete}',
              'buttonOptions' => ['class' => 'btn btn-default'],
              'buttons' => [
              'view' => function ($url, $model, $key) {
                return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', $url, [
                    'title' => 'Detail',
                    ]);
            },
            'update' => function ($url, $model, $key) {
                return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', $url, [
                    'title' => 'Edit',
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
            ]); ?>
             <?php yii\widgets\Pjax::end() ?>
        </div>
    </div>
    <?php
    $script = <<< JS
    function init_click_handlers() {
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
                    $.post(
                    'index.php?r=Inventory/drugsubclass/delete',
                    {
                        id: fID
                    },
                    function (data)
                    {
                        $.pjax.reload({container: '#grid-user-pjax'});
                    }
                    );
                }
            });
        });
    }
    init_click_handlers(); //first run
    $('#grid-user-pjax').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    });
JS;
    $this->registerJs($script);
    ?>
