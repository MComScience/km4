<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use frontend\assets\ModalFullScreenAsset;
use app\modules\pharmacy\models\TbCpoeItemtype;

ModalFullScreenAsset::register($this);
$QueryType = TbCpoeItemtype::find()->where(['cpoe_itemtype_id' => [10, 20]])->all();
?>
<?php
Modal::begin([
    'id' => 'solution-modal',
    'header' => '<h4 class="modal-title solution-title">' . 'IV Solution' . ' <span class="pull-right"> ' . $TitleModal . ' </span> ' . '</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
        //'closeButton' => false,
]);
?>
<div id="from-iv"></div>
<?php Modal::end(); ?>


<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    "footer" => "", // always need it for jquery plugin
    'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
])
?>
<?php Modal::end(); ?>

<?php
Modal::begin([
    'id' => 'modal-default-table',
    'header' => '<h4 class="modal-title default-title">' . '<text id="titlemodal"></text>' . ' <span class="pull-right"> ' . $TitleModal . ' </span> ' . '</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
//    'footer' => '<div class="btn-save-back" style="display:none">' . Html::button('<i class="glyphicon glyphicon-chevron-left"></i> ' . 'Prev', ['class' => 'btn btn-default', 'id' => 'btn-backsteb2',]) .
//    Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => "modal"]) .
//    Html::button('Save', ['type' => 'button', 'class' => 'btn btn-success ladda-button', 'id' => 'btn-savecpoe-details', 'data-style' => 'expand-left',]) . '</div>' . ' ' .
//    '<div class="btn-close">' . Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => "modal"]) . '</div>',
]);
?>
<div class="row">
    <div class="col-md-7 col-md-offset-0">
        <div id="simplewizard" class="wizard" data-target="#simplewizard-steps">
            <ul class="steps">
                <li id="simplewizardstep1" data-target="#simplewizardstep1" class="active"><span class="step">1</span><text id="numbersteb1"></text><span class="chevron"></span></li>
                <li id="simplewizardstep2" style="display: none;" data-target="#simplewizardstep2"><span class="step"><div id="numbersteb2"></div></span>ระบุข้อกำหนดการใช้ยา<span class="chevron"></span></li>
                <li id="simplewizardstep3" style="display: none;" data-target="#simplewizardstep3"><span class="step"><div id="numbersteb3"></div></span><text id="textstep3">วิธีการใช้ยา</text><span class="chevron"></span></li>
            </ul>
        </div>
        <p></p>
    </div>

    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <!-- Begin Widget Body -->
            <div class="widget-body">
                <div class="widget-main">
                    <div class="tabbable">
                        <div class="tab-content tabs-flat bg-white">
                            <!-- Begin Content -->
                            <div id="content1" class="tab-pane in active">
                                <div class="row">
                                    <div class="col-md-3 homemed" style="display: none;">
                                        <div class="radio text-center" style="background-color: #fbfbfb">
                                            <?php foreach ($QueryType as $record): ?>
                                                <label>
                                                    <input name="cpoetype" type="radio"  value="<?= $record->cpoe_itemtype_id; ?>" id="cpoetype<?= $record->cpoe_itemtype_id; ?>">
                                                    <span class="text"><?= $record->cpoe_itemtype_decs; ?></span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div id="data-default"></div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <p><?= Html::button('Close', ['type' => 'button', 'class' => 'btn btn-default pull-right', 'data-dismiss' => 'modal']); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div id="content2" class="tab-pane">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div id="from-ised"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="content3" class="tab-pane">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div id="from-input"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden"  id="ItemQtyAvalible" name="min">
<input type="hidden"  id="Item_Cr_Amt" name="max">
<input type="hidden"  id="Itemtype">
<input type="hidden"  id="seq" name="seq">
<?php Modal::end(); ?>


