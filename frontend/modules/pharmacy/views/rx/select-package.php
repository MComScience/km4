<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use app\modules\chemo\models\TbMedicalRigth;
use yii\helpers\ArrayHelper;
use app\modules\chemos\models\TbDrugsetType;

#register assets
CrudAsset::register($this);

$this->title = 'Standard Regimen';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/rx/index']];
$this->params['breadcrumbs'][] = ['label' => 'ห้องจ่ายยาผู้ป่วยนอก', 'url' => ['/pharmacy/rx/index']];
$this->params['breadcrumbs'][] = $this->title;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
?>
<style>
    table.kv-grid-table thead tr th{
        background-color: white;
        text-align: center;
    }
    div#ajaxCrudModal .modal-header {
        background-color: #f4b400;
    }
    div#edit-modal .modal-header {
        background-color: #f4b400;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="tab-warning active">
                    <a data-toggle="tab" href="#content1">
                        <?= Html::encode('Select Package'); ?>
                    </a>
            </ul>
            <div class="tab-content">
                <div id="content1" class="tab-pane in active">
                    <div class="tb-std-trp-chemo-index">
                        <?php Pjax::begin(['id' => 'stdtrp-chemo-index']); ?>

                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'responsive' => true,
                            'layout' => $layout,
                            'condensed' => true,
                            'striped' => false,
                            'bordered' => true,
                            'hover' => true,
                            'columns' => [
                                    [
                                    'class' => 'yii\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                    [
                                    'class' => 'kartik\grid\ExpandRowColumn',
                                    'value' => function ($model, $key, $index, $column) {
                                        return GridView::ROW_COLLAPSED;
                                    },
                                    'expandOneOnly' => true,
                                    'detailAnimationDuration' => 'slow', //fast
                                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                    'detailUrl' => Url::to(['standard-details']),
                                ],
                                    [
                                    'attribute' => 'std_trp_chemo_id',
                                    'header' => 'เลขที่',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'value' => function ($model) {
                                        return empty($model->std_trp_chemo_id) ? '-' : $model->std_trp_chemo_id;
                                    }
                                ],
                                    [
                                    'attribute' => 'std_trp_regimen_name',
                                    'header' => 'Regimen Name',
                                    'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                    'value' => function ($model) {
                                        return empty($model->std_trp_regimen_name) ? '-' : $model->std_trp_regimen_name;
                                    }
                                ],
                                    [
                                    'attribute' => 'std_trp_chemo_name',
                                    'header' => 'Chemo Name',
                                    'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                    'value' => function ($model) {
                                        return empty($model->chemo->std_trp_chemo_name) ? '-' : $model->chemo->std_trp_chemo_name;
                                    }
                                ],
                                    [
                                    'attribute' => 'dx_code',
                                    'header' => 'Dx',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'value' => function ($model) {
                                        return empty($model->dx_code) ? '-' : $model->dx_code;
                                    }
                                ],
                                    [
                                    'attribute' => 'ca_stage_code',
                                    'header' => 'Stage',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'value' => function ($model) {
                                        return empty($model->ca_stage_code) ? '-' : $model->ca_stage_code;
                                    }
                                ],
                                    [
                                    'attribute' => 'std_trp_regimen_paycode',
                                    'header' => 'std_trp_regimen_paycode',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return empty($model->std_trp_regimen_paycode) ? '-' : $model->std_trp_regimen_paycode;
                                    }
                                ],
                                    [
                                    'attribute' => 'cpoe_status_decs',
                                    'header' => 'cpoe_status_decs',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'value' => function ($model) {
                                        return empty($model->cpoe_status_decs) ? '-' : $model->cpoe_status_decs;
                                    }
                                ],
                            ],
                        ]);
                        ?>
                        <?php Pjax::end(); ?>

                        <p>
                            <?= Html::a('Close', ['order-chemo', 'id' => $data, 'type' => $type], ['class' => 'btn btn-default pull-right']) ?>
                        </p>
                        <br><br>
                    </div>
                </div>
            </div>
            <div class="horizontal-space"></div>
            <input type="hidden" id="cpoeid" value="<?= $data; ?>"/>
            <input type="hidden" id="drugset_type" value="<?= $type; ?>"/>
        </div>
    </div>

