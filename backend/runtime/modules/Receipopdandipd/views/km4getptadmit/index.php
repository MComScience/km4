<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Receipopdandipd\models\KM4GETPTIPDSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Km4 Getptipds';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
foreach (Yii::$app->session->getAllFlashes() as $message):
    ?>
    <?php
    echo \kartik\widgets\Growl::widget([
        'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
        'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
        'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
        'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
        'showSeparator' => true,
        'delay' => 1, //This delay is how long before the message shows
        'pluginOptions' => [
            'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
            'placement' => [
                'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
            ]
        ]
    ]);
    ?>
<?php endforeach; ?>
<div class="km4-getptipd-index">
    <div id="ajaxCrudDatatable">
        <?php
//        GridView::widget([
//            'id'=>'crud-datatable',
//            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
//            'pjax'=>true,
//            'columns' => require(__DIR__.'/_columns.php'),
//            'toolbar'=> [
//                ['content'=>
//                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
//                    ['role'=>'modal-remote','title'=> 'Create new Km4 Getptipds','class'=>'btn btn-default']).
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
//                'heading' => '<i class="glyphicon glyphicon-list"></i> Km4 Getptipds listing',
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
    <ul class="nav nav-tabs">
        <li class="active"><a  href="index.php?r=Opdandipd/km4getptadmit" aria-expanded="true">รายชื่อผู้ป่วยรอลงทะเบียน</a></li>
        <li class=""><a  href="index.php?r=Opdandipd/km4getptadmit/admitipdregister" aria-expanded="false">รายชื่อผุ้ป่วยในลงทะเบียนแล้ว</a></li>
        <li class=""><a  href="index.php?r=Opdandipd/km4getptadmit/waitregisterdoctor" aria-expanded="false">รายชื่อผู้ป่วยส่งพบแพทย์</a></li>
        <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">รายชื่อผู้ป่วยรอคำสั่งแพทย์</a></li>
        <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">รายชื่อผู้ป่วยจำหน่ายแล้ว</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr> 
                                <th style="text-align: center">ลำดับ</th>
                                <th style="text-align: center">HN</th>
                                <th style="text-align: center">ชื่อผู้รับบริการ</th>
                                <th style="text-align: center">แผนก</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $a = 1;
                            if (!empty($getadmit)) {
                                foreach ($getadmit as $r) {
                                    if ($r->d['pt_registry_date'] != date('Y-m-d') && $r->d['pt_registry_date'] == null) {
                                        ?>
                                        <tr>
                                            <td style="text-align: center"><?php echo $a; ?></td>
                                            <td style="text-align: center"><?php echo $r->PT_HOSPITAL_NUMBER ?></td>
                                            <td style="text-align: left"><?php echo $r->title['pt_titlename'].$r->PT_FNAME_TH.' '.$r->PT_LNAME_TH; ?></td>
                                            <td style="text-align: center"><?php echo $r->PT_SERVICE_SECTION_ID ?></td>
                                            <!--<td><a class="btn btn-success" href="index.php?r=Opdandipd/km4getptipd/save_service_arrive&hn=<?php //  echo $r->PT_HOSPITAL_NUMBER       ?>&&date=<?php //  echo $r->PT_REGISTRY_DATE       ?>">ลงทะเบียน</a></td>-->
                                            <td style="text-align: center"><a class="btn btn-success" href="javascript:conf(<?php echo $r->PT_HOSPITAL_NUMBER ?>,<?php echo str_replace('-', '', $r->PT_REGISTRY_DATE) ?>)">ลงทะเบียน</a></td>
                                        </tr>
                                        <?php
                                        $a++;
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function conf(hn, dat) {
      
        
        swal({
            title: "ยืนยันคำสั่งหรือไม่ ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false},
        function (isConfirm) {
            if (isConfirm) {
                // swal("ยืนยันคำสั่งแล้ว", "", "success");
                $("#step1Content").load("index.php?r=Opdandipd/km4getptopd/loadpage");
                $.get('index.php?r=Opdandipd/km4getptadmit/save_service', {hn: hn, dat: dat}, function (response) {
                    window.location.reload();
                });
            } else {
                swal("Cancelled", "", "error");
            }
        });
    }
</script>
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

