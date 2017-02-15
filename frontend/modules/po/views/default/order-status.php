<?php

use yii\helpers\Html;
use frontend\assets\DataTableAsset;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;
use frontend\assets\ModalFullScreenAsset;

ModalFullScreenAsset::register($this);
DataTableAsset::register($this);
CrudAsset::register($this);

$style = 'border-top: 1px solid #ddd;text-align:center;white-space: nowrap;background-color:white;';
;

$this->title = 'PURCHASING ORDER STATUS';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="tab-success active">
                    <a data-toggle="tab" href="#tab1">
                        <i class="fa fa-medkit"></i> <?= Html::encode('ยา') ?>
                    </a>
                </li>
                <li class="tab-success">
                    <a data-toggle="tab" href="#tab2">
                        <i class="fa fa-stethoscope" aria-hidden="true"></i> <?= Html::encode('เวชภัณฑ์') ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="tab1" class="tab-pane in active">
                    <table id="table1" width="100%" class="default table table-hover table-striped  kv-table-wrap table-condensed table-bordered">
                        <thead>
                            <tr>
                                <?= Html::tag('th', Html::encode('#'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('เลขที่'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('ประเภทจัดซื้อ'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('สถานะขอซื้อ'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('สั่งซื้อวันที่'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('สถานะสั่งซื้อ'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('ผู้จำหน่าย'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('ผู้นำเข้าผู้ผลิต'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('สถานะรับสินค้า'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('วันรับสินค้า'), ['style' => $style]) ?>
                                
                                <?= Html::tag('th', Html::encode('Actions'), ['style' => $style]) ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($query1 as $v) : ?>
                                <tr>
                                    <?= Html::tag('td', '', ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['PRNum']) ? '-' : $v['PRNum'], ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['POType']) ? '-' : $v['POType'], ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['PRStatus']) ? '-' : $v['PRStatus'], ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['PODate']) ? '-' : Yii::$app->formatter->asDate($v['PODate'], 'dd/MM/yyyy'), ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['POStatus']) ? '-' : $v['POStatus'], ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['Vender']) ? '-' : $v['Vender'], []) ?>

                                    <?= Html::tag('td', empty($v['Menu_Vendor']) ? '-' : $v['Menu_Vendor'], []) ?>

                                    <?= Html::tag('td', empty($v['GRStatus']) ? '-' : $v['GRStatus'], ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['GRDate']) ? '-' : Yii::$app->formatter->asDate($v['GRDate'], 'dd/MM/yyyy'), ['style' => 'text-align: center;']) ?>
                                    
                                    <?= Html::tag('td', Html::a('Detail',['view-details','PRID' => $v['PRID'],'PRNum' => $v['PRNum'],'POID' => empty($v['POID']) ? 'test' : $v['POID']] ,['class' => 'btn btn-xs btn-success','role' => 'modal-remote',]), ['style' => 'text-align: center;']) ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div id="tab2" class="tab-pane">
                    <table id="table2" width="100%" class="default table table-hover table-striped  kv-table-wrap table-condensed table-bordered">
                        <thead>
                            <tr>
                                <?= Html::tag('th', Html::encode('#'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('เลขที่'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('ประเภทจัดซื้อ'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('สถานะขอซื้อ'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('สั่งซื้อวันที่'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('สถานะสั่งซื้อ'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('ผู้จำหน่าย'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('ผู้นำเข้าผู้ผลิต'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('สถานะรับสินค้า'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('วันรับสินค้า'), ['style' => $style]) ?>
                                
                                <?= Html::tag('th', Html::encode('Actions'), ['style' => $style]) ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($query2 as $v) : ?>
                                <tr>
                                    <?= Html::tag('td', '', ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['PRNum']) ? '-' : $v['PRNum'], ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['POType']) ? '-' : $v['POType'], ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['PRStatus']) ? '-' : $v['PRStatus'], ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['PODate']) ? '-' : Yii::$app->formatter->asDate($v['PODate'], 'dd/MM/yyyy'), ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['POStatus']) ? '-' : $v['POStatus'], ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['Vender']) ? '-' : $v['Vender'], []) ?>

                                    <?= Html::tag('td', empty($v['Menu_Vendor']) ? '-' : $v['Menu_Vendor'], []) ?>

                                    <?= Html::tag('td', empty($v['GRStatus']) ? '-' : $v['GRStatus'], ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['GRDate']) ? '-' : Yii::$app->formatter->asDate($v['GRDate'], 'dd/MM/yyyy'), ['style' => 'text-align: center;']) ?>
                                    
                                    <?= Html::tag('td', Html::a('Detail',['view-details','PRID' => $v['PRID'],'PRNum' => $v['PRNum'],'POID' => empty($v['POID']) ? 'test' : $v['POID']] ,['class' => 'btn btn-xs btn-success','role' => 'modal-remote',]), ['style' => 'text-align: center;']) ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>

<?php
$this->registerJsFile(Yii::getAlias('@web') . '/js/po/order-status.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<?php 
Modal::begin([
        "id" => "ajaxCrudModal",
        'size' => 'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        "footer" => "", // always need it for jquery plugin
        'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
    ]);
    Modal::end();
?>