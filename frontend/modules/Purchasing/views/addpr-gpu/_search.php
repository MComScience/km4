<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-sm-4">
        <div class="tb-pr-search">

            <?php
            $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'action' => [$action],
                        'method' => 'get',
                        'options' => ['data-pjax' => true]
            ]);
            ?>
            <?php if($action == 'index') { ?>
            <div class="input-group">
                <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...','style' => 'background-color:white']) ?>
                <span class="input-group-btn">
                <?php /*
                    <a class="btn btn-primary shiny" href="javascript:void(0);">สร้างใบขอซื้อ</a>
                    <a class="btn btn-primary dropdown-toggle shiny" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown-menu dropdown-primary" >
                        <li>
                            <a href="index.php?r=Purchasing/addpr-gpu/createprid-temp">
                                <div class="panel-title"><i class="fa fa-edit"></i>
                                    ยาสามัญ
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="index.php?r=Purchasing/addpr-tpu/createprid-temp">
                                <div class="panel-title"><i class="fa fa-edit"></i> 
                                    ยาการค้า
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="index.php?r=Purchasing/addpr-nd/createprid-temp">
                                <div class="panel-title"><i class="fa fa-edit"></i>
                                    เวชภัณฑ์
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="index.php?r=Purchasing/addpr-tpu-cont/createprid-temp">
                                <div class="panel-title"><i class="fa fa-edit"></i>
                                    ยาการค้าจะซื้อจะขาย
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="index.php?r=Purchasing/addpr-nd-cont/createprid-temp">
                                <div class="panel-title"><i class="fa fa-edit"></i>
                                    เวชภัณฑ์จะซื้อจะขาย
                                </div>
                            </a>
                        </li>
                    </ul>
*/ ?>
                    <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="100" >
                        <?= Html::encode('สร้างใบขอซื้อ') ?> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu dropdown-success" >
                        <li>
                            <a href="<?= Url::to(['/Purchasing/addpr-gpu/createprid-temp']); ?>" data-pjax="0">
                                <div class="panel-title"><i class="fa fa-edit"></i>
                                    <?= Html::encode('ยาสามัญ'); ?>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['/Purchasing/addpr-tpu/createprid-temp']); ?>" data-pjax="0">
                                <div class="panel-title"><i class="fa fa-edit"></i> 
                                    <?= Html::encode('ยาการค้า'); ?>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['/Purchasing/addpr-nd/createprid-temp']); ?>" data-pjax="0">
                                <div class="panel-title"><i class="fa fa-edit"></i>
                                    <?= Html::encode('เวชภัณฑ์'); ?>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['/Purchasing/addpr-tpu-cont/createprid-temp']); ?>" data-pjax="0">
                                <div class="panel-title"><i class="fa fa-edit"></i>
                                    <?= Html::encode('ยาการค้าจะซื้อจะขาย'); ?>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['/Purchasing/addpr-nd-cont/createprid-temp']); ?>" data-pjax="0">
                                <div class="panel-title"><i class="fa fa-edit"></i>
                                    <?= Html::encode('เวชภัณฑ์จะซื้อจะขาย'); ?>
                                </div>
                            </a>
                        </li>
                    </ul>
                </span>
                <?php } ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
</div> 
</div>

