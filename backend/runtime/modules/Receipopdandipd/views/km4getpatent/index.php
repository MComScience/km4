<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Receipopdandipd\models\KM4GETPATENTSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Km4 Getpatents';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
?>
<div class="km4-getpatent-index">
    <div id="ajaxCrudDatatable">
        <?php
//GridView::widget([
//            'id'=>'crud-datatable',
//            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
//            'pjax'=>true,
//            'columns' => require(__DIR__.'/_columns.php'),
//            'toolbar'=> [
//                ['content'=>
//                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
//                    ['role'=>'modal-remote','title'=> 'Create new Km4 Getpatents','class'=>'btn btn-default']).
//                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
//                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
//                    '{toggleData}'.
//                    '{export}'
//                ],
//            ],          
//            'striped' => true,
//            'condensed' => true,
//            'responsive' => true,          
//            'panel' => [
//                'type' => 'primary', 
//                'heading' => '<i class="glyphicon glyphicon-list"></i> Km4 Getpatents listing',
//                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
//                'after'=>BulkButtonWidget::widget([
//                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
//                                ["bulk-delete"] ,
//                                [
//                                    "class"=>"btn btn-danger btn-xs",
//                                    'role'=>'modal-remote-bulk',
//                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
//                                    'data-request-method'=>'post',
//                                    'data-confirm-title'=>'Are you sure?',
//                                    'data-confirm-message'=>'Are you sure want to delete this item'
//                                ]),
//                        ]).                        
//                        '<div class="clearfix"></div>',
//            ]
//        ])
        ?>
    </div>
</div>
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "", // always need it for jquery plugin
])
?>
<?php Modal::end(); ?>

<div class="hpanel">
    <div class="panel-heading">
        <div class="panel-tools">
            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
            <a class="closebox"><i class="fa fa-times"></i></a>
        </div>

    </div>
    <div class="panel-body">

        <div class="table-responsive">
            <table id="example2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr> 
                        <th>PT_MAININSCL_ID</th>
                        <th>PT_INSCLCARD_ID</th>
                        <th>PT_INSCLCARD_STARTDATE</th>
                        <th>PT_INSCLCARD_EXPDATE</th>
                        <th>PT_PURCHASEPROVINCE_ID</th>
                        <th>PT_SCL_UPDATE_DATE</th>
                        <th>PT_SCL_UPDATE_TIME</th>
                        <th>PT_HOSPITAL_NUMBER</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($getpatent as $r) {
                        ?>
                        <tr>
                            <td><?php echo $r->PT_MAININSCL_ID ?></td>
                            <td><?php echo $r->PT_INSCLCARD_ID ?></td>
                            <td><?php echo $r->PT_INSCLCARD_STARTDATE ?></td>
                            <td><?php echo $r->PT_INSCLCARD_EXPDATE ?></td>
                            <td><?php echo $r->PT_PURCHASEPROVINCE_ID ?></td>
                            <td><?php echo $r->PT_SCL_UPDATE_DATE ?></td>
                            <td><?php echo $r->PT_SCL_UPDATE_TIME ?></td>
                            <td><?php echo $r->PT_HOSPITAL_NUMBER ?></td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php
$s = <<< JS
 $(function () {

   $("#example2").dataTable({
       "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>'
           });
        });
JS;
$this->registerJs($s);
?>

