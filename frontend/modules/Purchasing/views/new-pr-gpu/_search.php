<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TbprSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-5">
        <div class="tb-pr-search">
            <?php
            $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'action' => ['index'],
                        'method' => 'get',
                        'options' => ['data-pjax' => true]
            ]);
            ?>
            <div class="input-group">
                <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>
                    <div class="btn-group">
                        <a class="btn btn-primary" href="javascript:void(0);">บันทึกใบขอซื้อนอกแผน</a>
                        <a class="btn btn-primary dropdown-toggle shiny" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu dropdown-primary" >
                            <li>
                                <a href="index.php?r=Purchasing/new-pr-gpu/create-pridtemp">
                                    <div class="panel-title"><i class="fa fa-edit"></i>
                                        ยาสามัญ
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?r=Purchasing/new-pr-tpu/create-pridtemp">
                                    <div class="panel-title"><i class="fa fa-edit"></i> 
                                        ยาการค้า
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?r=Purchasing/new-pr-nd/create-pridtemp">
                                    <div class="panel-title"><i class="fa fa-edit"></i>
                                        เวชภัณฑ์
                                    </div>
                                </a>
                            </li>
                         </ul>
                    </div>
                </span>
             </div>
                
                <?php ActiveForm::end(); ?>
        </div>
    </div> 
</div>

