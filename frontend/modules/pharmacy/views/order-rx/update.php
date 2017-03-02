<?php

use johnitvn\ajaxcrud\CrudAsset;
use yii\helpers\Html;
use frontend\assets\DataTableAsset;
use frontend\assets\NotifyAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\AutoNumericAsset;

CrudAsset::register($this);
DataTableAsset::register($this);
NotifyAsset::register($this);
LaddaAsset::register($this);
AutoNumericAsset::register($this);

$this->title = 'ใบสั่งยา';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/order-rx/order-status']];
$this->params['breadcrumbs'][] = ['label' => 'Chemo Order : ผู้ป่วยนอก', 'url' => ['/pharmacy/order-rx/update', 'id' => $modelCpoe->cpoe_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->registerCssFile(Yii::getAlias('@web') . '/css/bootstrap-dropdownhover.min.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]); ?>
<style type="text/css">
    div#solution-modal .modal-body{
        overflow-y: auto;
        height: 600px;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            <?php echo $modelCpoe->cpoetype->cpoe_type_decs == null ? 'ใบสั่งยาผู้ป่วยนอก' : $modelCpoe->cpoetype->cpoe_type_decs; ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="horizontal-space"></div>
        </div>

        <div class="profile-container">

            <?= $this->render('_profile', ['ptar' => $ptar, 'profile' => $profile,'model' => $modelCpoe]) ?>

            <div class="profile-body">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="tabbable">
                        <?php echo $this->render('_tab_pharma', ['profile' => $profile,'model' => $modelCpoe]) ?>
                        <div class="tab-content tabs-flat bg-white">

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="tb-cpoe-create">

                                        <?php /*
                                        $this->render('_form', [
                                            'model' => $modelCpoe,
                                        ])*/
                                        ?>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div id="content-tabledetails">
                                        <?=
                                        $this->render('_grid_details', [
                                            'model' => $modelCpoe,
                                            'searchModel' => $searchModel,
                                            'dataProvider' => $dataProvider,
                                        ])
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right"><?= Html::encode('หมายเหตุ'); ?></label>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <textarea rows="3" class="form-control" name="TbCpoe[cpoe_comment]" id="cpoe_comment"><?php echo $modelCpoe['cpoe_comment']; ?></textarea>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: right;">
                                    <?= Html::a('Close', ['/pharmacy/order-rx/order-status'], ['class' => 'btn btn-default']); ?>
                                    <?= Html::button('SaveDraft', ['class' => 'btn btn-success ladda-button', 'id' => 'btn-savedraft-cpoe', 'data-style' => 'expand-left', 'disabled' => $modelCpoe['cpoe_status'] == 2 ? true : false,'onclick' => 'SaveDraftCpoe(this);']); ?>
                                    <?= Html::button('Save', ['class' => 'btn btn-success ladda-button', 'id' => 'btn-save-cpoe', 'data-style' => 'expand-left', 'disabled' => empty($modelCpoe['cpoe_status']) || $modelCpoe['cpoe_status'] == 1 ? true : false,'onclick' => 'SaveCpoe(this);']); ?>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?= Html::encode('ใบสรุปราคายา') ?> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <?= Html::a('<i class="text-danger fa fa-file-pdf-o"></i> A4', ['export-download', 'id' => $modelCpoe['cpoe_id'], 'type' => 'A4'], ['data-pjax' => 0, 'target' => '_blank']); ?>
                                            </li>
                                            <li>
                                                <?= Html::a('<i class="text-muted fa fa-file-text-o"></i> Slip', ['export-download', 'id' => $modelCpoe['cpoe_id'], 'type' => 'Tabloid'], ['data-pjax' => 0, 'target' => '_blank']); ?>
                                            </li>
                                        </ul>
                                    </div>
                                    <?= Html::button('พิมพ์ฉลากยา', ['class' => 'btn btn-default', 'id' => 'btn-print', 'disabled' => $modelCpoe['cpoe_status'] != 2 ? true : false]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->render('style'); ?>
<?php echo $this->render('modal', ['TitleModal' => $TitleModal]); ?>
<?php echo $this->render('script'); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/bootstrap-dropdownhover.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
