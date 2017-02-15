<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\widgets\Select2;

#register assets
CrudAsset::register($this);

$this->title = 'สั่งยา';
$this->params['breadcrumbs'][] = ['label' => 'จ่ายยาผู้ป่วยนอก', 'url' => ['/cpoe/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table.default thead tr th{
        background-color: #ddd;
    }
    div#ajaxCrudModal .modal-content {
        /* new custom width */
        width: 1222px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -140px;
    }
</style>

<!-- Begin Row -->
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="col-lg-12 col-sm-6 col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            บันทึกใบสั่งยาผู้ป่วยนอก
                        </a>
                    </li>
                </ul>
            </div>
            <div class="horizontal-space"></div>

        </div>
        <div class="profile-container">

            <?= $this->render('_profiles', ['header' => $header, 'ptar' => $ptar,]) ?>

            <div class="profile-body">
                <div class="col-lg-12 col-sm-6 col-xs-12">
                    <div class="tabbable">
                        <?= $this->render('_tab', []) ?>
                        <div class="tab-content tabs-flat bg-white">

                            <div id="overview" class="tab-pane active">
                                <div class="row profile-overview">

                                    <?php
                                    echo $this->render('_form', [
                                        'model' => $modelcpoe,
                                        'dataProvider' => $dataProvider,
                                    ])
                                    ?>


                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-10">
                                            <div class="tbcpoe-index">
                                                <div id="ajaxCrudDatatable">

                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-2">

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div id="timeline" class="tab-pane">
                                <div class="row profile-overview">
                                    <div class="col-md-8">แผนการให้ยาเคมีบำบัด</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- End Row -->
<!-- Begin Modal -->


<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    "footer" => "", // always need it for jquery plugin
    'options' => ['tabindex' => FALSE]
])
?>
<?php Modal::end(); ?>
<!-- End Modal -->

<!-- Begin Alert -->
<?php echo $this->render('_alert'); ?>
<!-- End Alert -->
<?php
$script = <<< JS
$(document).ready(function() {
  $(".select2").select2();
});
JS;
$this->registerJs($script, \yii\web\View::POS_END, 'create');
?>
<?php /*
  <div class="tbcpoe-index">

  <h1><?= Html::encode($this->title) ?></h1>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <p>
  <?= Html::a('Create Tbcpoe', ['create'], ['class' => 'btn btn-success']) ?>
  </p>
  <?php Pjax::begin(); ?>    <?= GridView::widget([
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
  'columns' => [
  ['class' => 'yii\grid\SerialColumn'],

  'cpoe_id',
  'cpoe_schedule_type',
  'cpoe_type',
  'cpoe_num',
  'pt_vn_number',
  // 'cpoe_date',
  // 'cpoe_order_by',
  // 'cpoe_order_section',
  // 'cpoe_comment',
  // 'cpoe_status',
  // 'cpoe_createby',

  ['class' => 'yii\grid\ActionColumn'],
  ],
  ]); ?>
  <?php Pjax::end(); ?></div>
 * 
 */
?>