<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use frontend\assets\SweetAlertAsset;

SweetAlertAsset::register($this);

$this->title = 'บันทึกแผนการจัดชื้อยาสามัญ';
$this->params['breadcrumbs'][] = ['label' => 'แผนการจัดซื้อ', 'url' => ['/Purchasing/plan-gpu/index']];
$this->params['breadcrumbs'][] = $this->title;
$layout = <<< HTML
<div class="pull-right"></div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
?>
<?php $this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#Purchasing1").addClass("active open");
    $("#pcplanbydrug").addClass("active");
    '); ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <?= Html::a('บันทึกแผนการจัดชื้อยาสามัญ', ['/Purchasing/plan-gpu/index']) ?>
                </li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <?php echo Yii::$app->finddata->alertsave() ?>
                    <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000, 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]) ?>
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    <?php
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'bootstrap' => true,
                        'responsiveWrap' => FALSE,
                        'responsive' => FALSE,
                        'hover' => true,
                        'pjax' => true,
                        'striped' => false,
                        'condensed' => true,
                        'toggleData' => true,
                        'layout' => $layout,
                        'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                        'columns' => [
                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                'width' => '36px',
                                'header' => '<font color="black">#</font>',
                                'headerOptions' => ['class' => 'kartik-sheet-style']
                            ],
//                        [
//                            'class' => 'kartik\grid\ExpandRowColumn',
//                            'width' => '50px',
//                            'value' => function ($model, $key, $index, $column) {
//                                return GridView::ROW_COLLAPSED;
//                            },
//                            'detailRowCssClass' => GridView::TYPE_DEFAULT,
//                            'detailUrl' => 'km4/backend/web//km4/Purchasing/tbpcplan/test',
//                            'headerOptions' => ['class' => 'kartik-sheet-style'],
//                            'expandOneOnly' => true
//                        ],
                            [
                                'header' => '<font color="black">เลขที่แผนจัดชื้อ </font>',
                                'attribute' => 'PCPlanNum',
                                'hAlign' => 'center',
                                'options' => ['class' => 'text-right'],
                            ],
                            [
                                'header' => '<font color="black">วันที่</font>',
                                'attribute' => 'PCPlanDate',
                                'format' => ['date', 'php:d/m/Y'],
                                'hAlign' => 'center',
                            ],
                            [
                                'header' => '<font color="black">ฝ่าย</font>',
                                'attribute' => 'DepartmentID',
                                'value' => 'department.DepartmentDesc',
//                            'width' => '20px',
                                'hAlign' => 'center'],
                            [
                                'header' => '<font color="black">แผนก</font>',
                                'attribute' => 'SectionID',
                                'value' => 'section.SectionDecs',
                                'hAlign' => 'center',
                            ],
                            [
                                'header' => '<font color="black">ประเภทแผนจัดชื้อ</font>',
                                'attribute' => 'PCPlanTypeID',
                                'value' => 'pcplantype.PCPlanType',
//                            'width' => '10px',
                                'hAlign' => 'center',
                            ],
                            [
                                'header' => '<font color="black">วันที่เริ่มแผน</font>',
                                'attribute' => 'PCPlanBeginDate',
                                'format' => ['date', 'php:d/m/Y'],
//                            'width' => '10px',
                                'hAlign' => 'center'
                            ],
                            [
                                'header' => '<font color="black">วันที่สิ้นสุดแผน</font>',
                                'attribute' => 'PCPlanEndDate',
                                'format' => ['date', 'php:d/m/Y'],
//                            'width' => '10px',
                                'hAlign' => 'center'
                            ],
                            [
                                'header' => '<font color="black">สถานะ</font>',
                                'attribute' => 'PCPlanStatusID',
                                'value' => 'pcplanstatus.PCPlanStatus',
                                'hAlign' => 'center'
                            ],
                            [
                                'class' => 'kartik\grid\ActionColumn',
                                'header' => '<font color="black">Actions</font>',
                                'noWrap' => true,
                                'template' => '{view} {update} {delete} {print}',
                                'buttonOptions' => ['class' => 'btn btn-default'],
                                'buttons' => [
                                    'print' => function ($url, $model, $key) {
                                        return '<div class="btn-group">
                                            <button class="btn btn-info btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                Print
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    ' . Html::a('<i class="text-danger fa fa-file-pdf-o"></i> รายงานแผนการจัดซื้อ', /* ['/Report/report-inventory/reportpikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print1(this);', 'id' => $model['PCPlanNum']])
                                                . '</li>
                                                <li>
                                                    ' . Html::a('<i class="text-muted fa fa-file-text-o"></i> บันทึกข้อความ', /* ['/Report/report-inventory/slippikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print2(this);', 'id' => $model['PCPlanNum']]) . '
                                                </li>
                                            </ul>
                                        </div>';
                                    },
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', $url, [
                                                    'title' => 'Edit',
                                                    'data-pjax' => 0,
                                        ]);
                                    },
                                    'update' => function ($url, $model, $key) {
                                        if (($model['PCPlanStatusID'] == 5) && (Yii::$app->user->can('ApprovedPlan'))) {
                                            return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', $url, [
                                                        'title' => 'Edit',
                                                        'data-pjax' => 0,
                                            ]);
                                        } else if (($model['PCPlanStatusID'] == 5) && (!Yii::$app->user->can('ApprovedPlan'))) {
                                            return Html::button('Edit', [
                                                        'title' => 'Edit',
                                                        'class' => 'btn btn-info btn-xs',
                                                        'disabled' => true,
                                            ]);
                                        } else {
                                            return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', $url, [
                                                        'title' => 'Edit',
                                                        'data-pjax' => 0,
                                            ]);
                                        }
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        if (($model['PCPlanStatusID'] == 5) && (Yii::$app->user->can('ApprovedPlan'))) {
                                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                        'title' => 'Delete',
                                                        'data-id' => $key,
                                                        'class' => 'activity-delete-link',
                                            ]);
                                        } else if (($model['PCPlanStatusID'] == 5) && (!Yii::$app->user->can('ApprovedPlan'))) {
                                            return Html::button('Delete', [
                                                        'title' => 'Delete',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'disabled' => true,
                                            ]);
                                        } else {
                                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                        'title' => 'Delete',
                                                        'data-id' => $key,
                                                        'class' => 'activity-delete-link',
                                            ]);
                                        }
                                    },
                                ],
                            ],
                        ],
                    ]);
                    ?>
                    <?php yii\widgets\Pjax::end() ?>
                    <div style="text-align: right">
                        <?= Html::a('Close', '/km4/Purchasing/dashboard/index', ['class' => 'btn btn-default']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>

<?php
$script = <<< JS
function init_click_handlers() {
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
  swal({
    title: "ยืนยันการลบ",
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
                        '/km4/Purchasing/plan-generics/delete',
                        {
                            id: fID
                        },
                function (data)
                {
                    $.pjax.reload({container: '#grid-user-pjax'});
                }
             );
            }
        }
      );
    });
}
init_click_handlers(); //first run
$('#grid-user-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
$this->registerJs($script);
?>
<script type="text/javascript">
    function Print1(e) {
        var PCPlanNum = (e.getAttribute("id"));
        //event.preventDefault();
        var myWindow = window.open("/km4/Report/report-purchasing/plan-gpu?PCPlanNum=" + PCPlanNum, "", "top=100,left=200,width=" + (screen.width - '400') + ",height=550,right=auto");
        myWindow.window.print();
    }
    function Print2(e) {
        var PCPlanNum = (e.getAttribute("id"));
        //event.preventDefault();
        var myWindow = window.open("/km4/Report/report-purchasing/plan-gpureport?PCPlanNum=" + PCPlanNum, "", "top=100,left=50,width=" + (screen.width - '100') + ",height=550,right=auto");
        myWindow.window.print();
    }
</script>