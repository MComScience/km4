<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Receipopdandipd\models\KM4GETPATENT */
?>
<div class="km4-getpatent-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'PT_MAININSCL_ID',
            'PT_INSCLCARD_ID',
            'PT_INSCLCARD_STARTDATE',
            'PT_INSCLCARD_EXPDATE',
            'PT_PURCHASEPROVINCE_ID',
            'PT_SCL_UPDATE_DATE',
            'PT_SCL_UPDATE_TIME',
            'PT_HOSPITAL_NUMBER',
        ],
    ]) ?>

</div>
