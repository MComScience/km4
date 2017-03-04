<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\Payment\models\VwPtArdetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
if($view == 'create'){
  $this->title = "บันทึกการชำระเงิน";  
}else{
  $this->title = "ประวัติการชำระเงิน";  
}

$this->params['breadcrumbs'][] = ['label' => 'รายการใบแจ้งค่าใช้จ่าย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="tab-success active">
                    <a data-toggle="tab" href="#home">
                    <?php if ($view == 'create') { ?>
                        <?= Html::encode('บันทึกการชำระเงิน') ?>
                    <?php }else{?>
                        <?= Html::encode('ประวัติการชำระเงิน') ?>
                    <?php }?>    
                    </a>
                </li>
            </ul> 
            <div class="tab-content bg-white">
                <div id="_form_payment" class="tab-pane in active">
                    <?php
                    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_payment']);
                    ?>    
                    <?=
                    $this->render('_form_payment', [
                        'modelHD' => $modelHD,
                        'modelPaid'=>$modelPaid,
                        'ar_name' => $ar_name,
                        'searchModelBD' => $searchModelBD,
                        'dataProviderBD' => $dataProviderBD,
                        'searchModelFT' => $searchModelFT,
                        'dataProviderFT' => $dataProviderFT,
                        'view'=>$view,
                        'form' => $form,
                    ]);
                    ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
