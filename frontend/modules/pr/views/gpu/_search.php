<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\icons\Icon;
?>
<div class="row">
    <div class="col-xs-12 col-sm-6 <?= $action == 'index' ? 'col-md-5' : 'col-md-4'?>">
        <div class="tb-pr-search">
            <?php
            $form = ActiveForm::begin([
                        'action' => [$action],
                        'method' => 'post',
                        'options' => ['data-pjax' => true],
            ]);
            ?>
            <?php if ($action != 'index') : ?>
                <div class="input-group">
                    <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...', 'style' => 'background-color: white']) ?>
                    <span class="input-group-btn">
                        <?= Html::submitButton(Icon::show('search', [], Icon::BSG).Yii::t('app', 'Search'), ['class' => 'btn btn-success']); ?>
                    </span>
                </div>
            <?php endif; ?>

            <?php if ($action == 'index') : ?>
                <div class="input-group">
                    <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...', 'style' => 'background-color: white']) ?>

                    <span class="input-group-btn dropdown">
                        <?= Html::submitButton(Icon::show('search', [], Icon::BSG).Yii::t('app', 'Search'), ['class' => 'btn btn-success']); ?>
                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="100" >
                            <?= Html::encode('สร้างใบขอซื้อ') ?> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-success">
                            <li>
                                <a href="<?= Url::to(['/pr/gpu/create']); ?>" data-pjax="0">
                                    <div class="panel-title">
                                        <?= Icon::show('edit', [], Icon::BSG).Html::encode('ยาสามัญ'); ?>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::to(['/pr/tpu/create']); ?>" data-pjax="0">
                                    <div class="panel-title">
                                        <?= Icon::show('edit', [], Icon::BSG).Html::encode('ยาการค้า'); ?>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::to(['/pr/nd/create']); ?>" data-pjax="0">
                                    <div class="panel-title">
                                        <?= Icon::show('edit', [], Icon::BSG).Html::encode('เวชภัณฑ์'); ?>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::to(['/pr/tpu-cont/create']); ?>" data-pjax="0">
                                    <div class="panel-title">
                                        <?= Icon::show('edit', [], Icon::BSG).Html::encode('ยาการค้าจะซื้อจะขาย'); ?>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::to(['/pr/nd-cont/create']); ?>" data-pjax="0">
                                    <div class="panel-title">
                                        <?= Icon::show('edit', [], Icon::BSG).Html::encode('เวชภัณฑ์จะซื้อจะขาย'); ?>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </span>
                </div>
            <?php endif; ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div> 
</div>

