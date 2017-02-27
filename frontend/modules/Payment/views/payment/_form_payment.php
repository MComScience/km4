<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\modules\Payment\models\VwPtArdetail */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="profile-container">
            <div class="profile-header row">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-center" style="margin-top: 15px;">
                    <img src="/km4/assets/img/avatars/admin.png" alt="" class="header-avatar" />
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 profile-info">
                    <?=
                    $this->render('payment_header_column1', [
                        'modelHD' => $modelHD,
                    ]);
                    ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 profile-stats">
                    <?= $this->render('payment_header_column2',[
                        'ar_name' => $ar_name,
                    ]); ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 profile-stats">
                    <?=
                    $this->render('payment_header_column3', [
                        'modelHD' => $modelHD,
                        'form' => $form,
                        'view'=>$view,
                    ]);
                    ?>
                </div>
            </div>
            <div class="profile-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?=
                    $this->render('payment_body', [
                        'searchModelBD' => $searchModelBD,
                        'dataProviderBD' => $dataProviderBD,
                        'view'=>$view,
                    ]);
                    ?>
                </div>
            </div>
            <div class="profile-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?= $this->render('payment_footer',[
                        'modelHD' => $modelHD,
                        'modelPaid'=>$modelPaid,
                        'form' => $form,
                        'searchModelFT' => $searchModelFT,
                        'dataProviderFT' => $dataProviderFT,
                        'view'=>$view,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
